<?php

/**
 * Nested Sets Extension for DataMapper classes.
 *
 * Nested Sets DataMapper model
 *
 * @license 	MIT License
 * @package		DMZ-Included-Extensions
 * @category	DMZ
 * @author  	WanWizard
 * @info		Based on nstrees by Rolf Brugger, edutech
 * 				http://www.edutech.ch/contribution/nstrees
 * @version 	1.0
 */

// --------------------------------------------------------------------------

/**
 * DMZ_Nestedsets Class
 *
 * @package		DMZ-Included-Extensions
 */
class DMZ_Nestedsets {

	/**
	 * name of the tree node left index field
	 *
	 * @var    string
	 * @access private
	 */
	private $_leftindex = 'left_id';

	/**
	 * name of the tree node right index field
	 *
	 * @var    string
	 * @access private
	 */
	private $_rightindex = 'right_id';

	/**
	 * name of the tree root id field. Used when the tree contains multiple roots
	 *
	 * @var    string
	 * @access private
	 */
	private $_rootfield = 'root_id';

	/**
	 * value of the root field we need to filter on
	 *
	 * @var    string
	 * @access private
	 */
	private $_rootindex = NULL;

	/**
	 * name of the tree node symlink index field
	 *
	 * @var    string
	 * @access private
	 */
	private $_symlinkindex = 'symlink_id';

	/**
	 * name of the tree node name field, used to build a path string
	 *
	 * @var    string
	 * @access private
	 */
	private $_nodename = NULL;

	/**
	 * indicates with pointers need to be used
	 *
	 * @var    string
	 * @access private
	 */
	private $use_symlink_pointers = TRUE;

	// -----------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 * @param	mixed	optional, array of load-time options or NULL
	 * @param	object	the DataMapper object
	 * @return	void
	 * @access	public
	 */
	function __construct( $options = array(), $object = NULL )
	{
		// do we have the datamapper object
		if ( ! is_null($object) )
		{
			// update the config
			$this->tree_config($object, $options);
		}
	}

	// -----------------------------------------------------------------

	/**
	 * runtime configuration of this nestedsets tree
	 *
	 * @param	object	the DataMapper object
	 * @param	mixed	optional, array of options or NULL
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function tree_config($object, $options = array() )
	{
		// make sure the load-time options parameter is an array
		if ( ! is_array($options) )
		{
			$options = array();
		}

		// make sure the model options parameter is an array
		if ( ! isset($object->nestedsets) OR ! is_array($object->nestedsets) )
		{
			$object->nestedsets = array();
		}

		// loop through all options
		foreach( array( $object->nestedsets, $options ) as $optarray )
		{
			foreach( $optarray as $key => $value )
			{
				switch ( $key )
				{
					case 'name':
						$this->_nodename = (string) $value;
						break;
					case 'symlink':
						$this->_symlinkindex = (string) $value;
						break;
					case 'left':
						$this->_leftindex = (string) $value;
						break;
					case 'right':
						$this->_rightindex = (string) $value;
						break;
					case 'root':
						$this->_rootfield = (string) $value;
						break;
					case 'value':
						$this->_rootindex = (int) $value;
						break;
					case 'follow':
						$this->use_symlink_pointers = (bool) $value;
						break;
					default:
						break;
				}
			}
		}
	}

	// -----------------------------------------------------------------

	/**
	 * select a specific root if the table contains multiple trees
	 *
	 * @param	object	the DataMapper object
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function select_root($object, $tree = NULL)
	{
		// set the filter value
		$this->_rootindex = $tree;

		// return the object
		return $object;
	}

	// -----------------------------------------------------------------
	// Tree constructors
	// -----------------------------------------------------------------

	/**
	 * create a new tree root
	 *
	 * @param	object	the DataMapper object
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function new_root($object)
	{
		// set the pointers for the root object
		$object->id = NULL;
		$object->{$this->_leftindex} = 1;
		$object->{$this->_rightindex} = 2;

		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->{$this->_rootfield} = $this->_rootindex;
		}

		// create the new tree root, and return the updated object
		return $this->_insertNew($object);
	}

	// -----------------------------------------------------------------

	/**
	 * creates a new first child of 'node'
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the parent node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function new_first_child($object, $node = NULL)
	{
		// a node passed?
		if ( is_null($node) )
		{
			// no, use the object itself
			$node = $object->get_clone();
		}

		// we need a valid node for this to work
		if ( ! $node->exists() )
		{
			return $node;
		}

		// set the pointers for the root object
		$object->id = NULL;
		$object->{$this->_leftindex} = $node->{$this->_leftindex} + 1;
		$object->{$this->_rightindex} = $node->{$this->_leftindex} + 2;

		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->{$this->_rootfield} = $this->_rootindex;
		}

		// shift nodes to make room for the new child
		$this->_shiftRLValues($node, $object->{$this->_leftindex}, 2);

		// create the new tree node, and return the updated object
		return $this->_insertNew($object);
	}

	// -----------------------------------------------------------------

	/**
	 * creates a new last child of 'node'
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the parent node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function new_last_child($object, $node = NULL)
	{
		// a node passed?
		if ( is_null($node) )
		{
			// no, use the object itself
			$node = $object->get_clone();
		}

		// we need a valid node for this to work
		if ( ! $node->exists() )
		{
			return $node;
		}

		// set the pointers for the root object
		$object->id = NULL;
		$object->{$this->_leftindex} = $node->{$this->_rightindex};
		$object->{$this->_rightindex} = $node->{$this->_rightindex} + 1;

		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->{$this->_rootfield} = $this->_rootindex;
		}

		// shift nodes to make room for the new child
		$this->_shiftRLValues($node, $object->{$this->_leftindex}, 2);

		// create the new tree node, and return the updated object
		return $this->_insertNew($object);
	}

	// -----------------------------------------------------------------

	/**
	 * creates a new sibling before 'node'
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the sibling node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function new_previous_sibling($object, $node = NULL)
	{
		// a node passed?
		if ( is_null($node) )
		{
			// no, use the object itself
			$node = $object->get_clone();
		}

		// we need a valid node for this to work
		if ( ! $node->exists() )
		{
			return $node;
		}

		// set the pointers for the root object
		$object->id = NULL;
		$object->{$this->_leftindex} = $node->{$this->_leftindex};
		$object->{$this->_rightindex} = $node->{$this->_leftindex} + 1;

		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->{$this->_rootfield} = $this->_rootindex;
		}

		// shift nodes to make room for the new sibling
		$this->_shiftRLValues($node, $object->{$this->_leftindex}, 2);

		// create the new tree node, and return the updated object
		return $this->_insertNew($object);
	}

	// -----------------------------------------------------------------

	/**
	 * creates a new sibling after 'node'
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the sibling node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function new_next_sibling($object, $node = NULL)
	{
		// a node passed?
		if ( is_null($node) )
		{
			// no, use the object itself
			$node = $object->get_clone();
		}

		// we need a valid node for this to work
		if ( ! $node->exists() )
		{
			return $node;
		}

		// set the pointers for the root object
		$object->id = NULL;
		$object->{$this->_leftindex} = $node->{$this->_rightindex} + 1;
		$object->{$this->_rightindex} = $node->{$this->_rightindex} + 2;

		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->{$this->_rootfield} = $this->_rootindex;
		}

		// shift nodes to make room for the new sibling
		$this->_shiftRLValues($node, $object->{$this->_leftindex}, 2);

		// create the new tree node, and return the updated object
		return $this->_insertNew($object);
	}

	// -----------------------------------------------------------------
	// Tree queries
	// -----------------------------------------------------------------


	/**
	 * returns the root of the (selected) tree
	 *
	 * @param	object	the DataMapper object
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function get_root($object)
	{
		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->db->where($this->_rootfield, $this->_rootindex);
		}

		// get the tree's root node
		return $object->where($this->_leftindex, 1)->get();
	}

	// -----------------------------------------------------------------

	/**
	 * returns the parent of the child 'node'
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the child node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function get_parent($object, $node = NULL)
	{
		// a node passed?
		if ( is_null($node) )
		{
			// no, use the object itself
			$node =& $object;
		}

		// we need a valid node for this to work
		if ( ! $node->exists() )
		{
			return $node;
		}

		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->db->where($this->_rootfield, $this->_rootindex);
		}

		// get the node's parent node
		$object->where($this->_leftindex . ' <', $node->{$this->_leftindex});
		$object->where($this->_rightindex . ' >', $node->{$this->_rightindex});
		return $object->order_by($this->_rightindex, 'asc')->limit(1)->get();
	}

	// -----------------------------------------------------------------

	/**
	 * returns the node with the requested left index pointer
	 *
	 * @param	object	the DataMapper object
	 * @param	integer	a node's left index value
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function get_node_where_left($object, $left_id)
	{
		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->db->where($this->_rootfield, $this->_rootindex);
		}

		// get the node's parent node
		$object->where($this->_leftindex, $left_id);
		return $object->get();
	}

	// -----------------------------------------------------------------

	/**
	 * returns the node with the requested right index pointer
	 *
	 * @param	object	the DataMapper object
	 * @param	integer	a node's right index value
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function get_node_where_right($object, $right_id)
	{
		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->db->where($this->_rootfield, $this->_rootindex);
		}

		// get the node's parent node
		$object->where($this->_rightindex, $right_id);
		return $object->get();
	}

	// -----------------------------------------------------------------

	/**
	 * returns the first child of the given node
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the parent node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function get_first_child($object, $node = NULL)
	{
		// a node passed?
		if ( is_null($node) )
		{
			// no, use the object itself
			$node =& $object;
		}

		// we need a valid node for this to work
		if ( ! $node->exists() )
		{
			return $node;
		}

		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->db->where($this->_rootfield, $this->_rootindex);
		}

		// get the node's first child node
		$object->where($this->_leftindex, $node->{$this->_leftindex}+1);
		return $object->get();
	}

	// -----------------------------------------------------------------

	/**
	 * returns the last child of the given node
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the parent node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function get_last_child($object, $node = NULL)
	{
		// a node passed?
		if ( is_null($node) )
		{
			// no, use the object itself
			$node =& $object;
		}

		// we need a valid node for this to work
		if ( ! $node->exists() )
		{
			return $node;
		}

		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->db->where($this->_rootfield, $this->_rootindex);
		}

		// get the node's last child node
		$object->where($this->_rightindex, $node->{$this->_rightindex}-1);
		return $object->get();
	}

	// -----------------------------------------------------------------

	/**
	 * returns the previous sibling of the given node
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the sibling node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function get_previous_sibling($object, $node = NULL)
	{
		// a node passed?
		if ( is_null($node) )
		{
			// no, use the object itself
			$node =& $object;
		}

		// we need a valid node for this to work
		if ( ! $node->exists() )
		{
			return $node;
		}

		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->db->where($this->_rootfield, $this->_rootindex);
		}

		// get the node's previous sibling node
		$object->where($this->_rightindex, $node->{$this->_leftindex}-1);
		return $object->get();
	}

	// -----------------------------------------------------------------

	/**
	 * returns the next sibling of the given node
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the sibling node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function get_next_sibling($object, $node = NULL)
	{
		// a node passed?
		if ( is_null($node) )
		{
			// no, use the object itself
			$node =& $object;
		}

		// we need a valid node for this to work
		if ( ! $node->exists() )
		{
			return $node;
		}

		// add a root index if needed
		if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
		{
			$object->db->where($this->_rootfield, $this->_rootindex);
		}

		// get the node's next sibling node
		$object->where($this->_leftindex, $node->{$this->_rightindex}+1);
		return $object->get();
	}

	// -----------------------------------------------------------------
	// Boolean tree functions
	// -----------------------------------------------------------------

	/**
	 * check if the object is a valid tree node
	 *
	 * @param	object	the DataMapper object
	 * @return	boolean
	 * @access	public
	 */
	function is_valid_node($object)
	{
		if ( ! $object->exists() )
		{
			return FALSE;
		}
		elseif ( ! isset($object->{$this->_leftindex}) OR ! is_numeric($object->{$this->_leftindex}) OR $object->{$this->_leftindex} <=0 )
		{
			return FALSE;
		}
		elseif ( ! isset($object->{$this->_rightindex}) OR ! is_numeric($object->{$this->_rightindex}) OR $object->{$this->_rightindex} <=0  )
		{
			return FALSE;
		}
		elseif ( $object->{$this->_leftindex} >= $object->{$this->_rightindex} )
		{
			return FALSE;
		}
		elseif ( ! empty($this->_rootfield) && ! in_array($this->_rootfield, $object->fields) )
		{
			return FALSE;
		}
		elseif ( ! empty($this->_rootfield) && ( ! is_numeric($object->{$this->_rootfield}) OR $object->{$this->_rootfield} <=0  ) )
		{
			return FALSE;
		}

		// all looks well...
		return TRUE;
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object is a tree root
	 *
	 * @param	object	the DataMapper object
	 * @return	boolean
	 * @access	public
	 */
	function is_root($object)
	{
		return ( $object->exists() && $this->is_valid_node($object) && $object->{$this->_leftindex} == 1 );
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object is a tree leaf (node with no children)
	 *
	 * @param	object	the DataMapper object
	 * @return	boolean
	 * @access	public
	 */
	function is_leaf($object)
	{
		return ( $object->exists() && $this->is_valid_node($object) && $object->{$this->_rightindex} - $object->{$this->_leftindex} == 1 );
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object is a child node
	 *
	 * @param	object	the DataMapper object
	 * @return	boolean
	 * @access	public
	 */
	function is_child($object)
	{
		return ( $object->exists() && $this->is_valid_node($object) && $object->{$this->_leftindex} > 1 );
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object is a child of node
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the parent node
	 * @return	boolean
	 * @access	public
	 */
	function is_child_of($object, $node = NULL)
	{
		// validate the objects
		if ( ! $this->is_valid_node($object) OR ! $this->is_valid_node($node) )		{
			return FALSE;
		}

		return ( $object->{$this->_leftindex} > $node->{$this->_leftindex} && $object->{$this->_rightindex} < $node->{$this->_rightindex} );
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object is the parent of node
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the parent node
	 * @return	boolean
	 * @access	public
	 */
	function is_parent_of($object, $node = NULL)
	{
		// validate the objects
		if ( ! $this->is_valid_node($object) OR ! $this->is_valid_node($node) )
		{
			return FALSE;
		}

		// fetch the parent of our child node
		$parent = $node->get_clone()->get_parent();

		return ( $parent->id === $object->id );
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object has a parent
	 *
	 * Note: this is an alias for is_child()
	 *
	 * @param	object	the DataMapper object
	 * @return	boolean
	 * @access	public
	 */
	function has_parent($object)
	{
		return $this->is_child($object);
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object has children
	 *
	 * Note: this is an alias for ! is_leaf()
	 *
	 * @param	object	the DataMapper object
	 * @return	boolean
	 * @access	public
	 */
	function has_children($object)
	{
		return $this->is_leaf($object) ? FALSE : TRUE;
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object has a previous silbling
	 *
	 * @param	object	the DataMapper object
	 * @return	boolean
	 * @access	public
	 */
	function has_previous_sibling($object)
	{
		// fetch the result using a clone
		$node = $object->get_clone();
		return $this->is_valid_node($node->get_previous_sibling($object));
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object has a next silbling
	 *
	 * @param	object	the DataMapper object
	 * @return	boolean
	 * @access	public
	 */
	function has_next_sibling($object)
	{
		// fetch the result using a clone
		$node = $object->get_clone();
		return $this->is_valid_node($node->get_next_sibling($object));
	}

	// -----------------------------------------------------------------
	// Integer tree functions
	// -----------------------------------------------------------------

	/**
	 * return the count of the objects children
	 *
	 * @param	object	the DataMapper object
	 * @return	integer
	 * @access	public
	 */
	function count_children($object)
	{
		return ( $object->exists() ? (($object->{$this->_rightindex} - $object->{$this->_leftindex} - 1) / 2) : FALSE );
	}

	// -----------------------------------------------------------------

	/**
	 * return the node level, where the root = 0
	 *
	 * @param	object	the DataMapper object
	 * @return	mixed	integer, of FALSE in case no valid object was passed
	 * @access	public
	 */
	function level($object)
	{
		if ( $object->exists() )
		{
			// add a root index if needed
			if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
			{
				$object->db->where($this->_rootfield, $this->_rootindex);
			}

			$object->where($this->_leftindex.' <', $object->{$this->_leftindex});
			$object->where($this->_rightindex.' >', $object->{$this->_rightindex});
			return $object->count();
		}
		else
		{
			return FALSE;
		}
	}

	// -----------------------------------------------------------------
	// Tree reorganisation
	// -----------------------------------------------------------------

	/**
	 * move the object as next sibling of 'node'
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the sibling node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function make_next_sibling_of($object, $node)
	{
		if ( ! $this->is_root($node) )
		{
			return $this->_moveSubtree($object, $node, $node->{$this->_rightindex}+1);
		}
		else
		{
			return FALSE;
		}
	}

	// -----------------------------------------------------------------

	/**
	 * move the object as previous sibling of 'node'
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the sibling node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function make_previous_sibling_of($object, $node)
	{
		if ( ! $this->is_root($node) )
		{
			return $this->_moveSubtree($object, $node, $node->{$this->_leftindex});
		}
		else
		{
			return FALSE;
		}
	}

	// -----------------------------------------------------------------

	/**
	 * move the object as first child of 'node'
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the sibling node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function make_first_child_of($object, $node)
	{
		return $this->_moveSubtree($object, $node, $node->{$this->_leftindex}+1);
	}

	// -----------------------------------------------------------------

	/**
	 * move the object as last child of 'node'
	 *
	 * @param	object	the DataMapper object
	 * @param	object	the sibling node
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function make_last_child_of($object, $node)
	{
		return $this->_moveSubtree($object, $node, $node->{$this->_rightindex});
	}

	// -----------------------------------------------------------------
	// Tree destructors
	// -----------------------------------------------------------------

	/**
	 * deletes the entire tree structure including all records
	 *
	 * @param	object	the DataMapper object
	 * @param	mixed	optional, id of the tree to delete
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function remove_tree($object, $tree_id = NULL)
	{
		// if we have multiple roots
		if ( in_array($this->_rootfield, $object->fields) )
		{
			// was a tree id passed?
			if ( ! is_null($tree_id) )
			{
				// only delete the selected one
				$object->db->where($this->_rootfield, $tree_id)->delete($object->table);
			}
			elseif ( ! is_null($this->_rootindex) )
			{
				// only delete the selected one
				$object->db->where($this->_rootfield, $this->_rootindex)->delete($object->table);
			}
			else
			{
				// delete them all
				$object->db->truncate($object->table);
			}
		}
		else
		{
			// delete them all
			$object->db->truncate($object->table);
		}

		// return the cleared object
		return $object->clear();
	}

	// -----------------------------------------------------------------

	/**
	 * deletes the current object, and all childeren
	 *
	 * @param	object	the DataMapper object
	 * @return	object	the updated DataMapper object
	 * @access	public
	 */
	function remove_node($object)
	{
		// we need a valid node to do this
		if ( $object->exists() )
		{
			// if we have multiple roots
			if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
			{
				// only delete the selected one
				$object->db->where($this->_rootfield, $this->_rootindex);
			}

			// clone the object, we need to it shift later
			$clone = $object->get_clone();

			// select the node and all children
			$object->db->where($this->_leftindex . ' >=', $object->{$this->_leftindex});
			$object->db->where($this->_rightindex . ' <=', $object->{$this->_rightindex});

			// delete them all
			$object->db->delete($object->table);

			// re-index the tree
			$this->_shiftRLValues($clone, $object->{$this->_rightindex} + 1, $clone->{$this->_leftindex} - $object->{$this->_rightindex} -1);
		}

		// return the cleared object
		return $object->clear();
	}

	// -----------------------------------------------------------------
	// dump methods
	// -----------------------------------------------------------------

	/**
	 * returns the tree in a key-value format suitable for html dropdowns
	 *
	 * @param	object	the DataMapper object
	 * @param	string	optional, name of the column to use
	 * @param	boolean	if true, the object itself (root of the dump) will not be included
	 * @return	array
	 * @access	public
	 */
	public function dump_dropdown($object, $field = FALSE, $skip_root = TRUE)
	{
		// check if a specific field has been requested
		if ( empty($field) OR ! isset($this->fields[$field]) )
		{
			// no field given, check if a generic name is defined
			if ( ! empty($this->_nodename) )
			{
				// yes, so use it
				$field = $this->_nodename;
			}
			else
			{
				// can't continue without a name
				return FALSE;
			}
		}

		// fetch the tree as an array
		$tree = $this->dump_tree($object, NULL, 'array', $skip_root);

		// storage for the result
		$result = array();

		if ( $tree )
		{
			// loop trough the tree
			foreach ( $tree as $key => $value )
			{
				$result[$value['__id']] = str_repeat('&nbsp;', ($value['__level']) * 3) . ($value['__level'] ? '&raquo; ' : '') . $value[$field];
			}
		}

		// return the result
		return $result;
	}

	// -----------------------------------------------------------------

	/**
	 * dumps the entire tree in HTML or TAB formatted output
	 *
	 * @param	object	the DataMapper object
	 * @param	array	list of columns to include in the dump
	 * @param	string	type of output requested, possible values 'html', 'tab', 'csv', 'array' ('array' = default)
	 * @param	boolean	if true, the object itself (root of the dump) will not be included
	 * @return	mixed
	 * @access	public
	 */
	public function dump_tree($object, $attributes = NULL, $type = 'array', $skip_root = TRUE)
	{
		if ( $this->is_valid_node($object) )
		{
			// do we need a sub-selection of attributes?
			if ( is_array($attributes) )
			{
				// make sure required fields are present
				$fields = array_merge($attributes, array('id', $this->_leftindex, $this->_rightindex));
				if ( ! empty($this->_nodename) && ! isset($fields[$this->_nodename] ) )
				{
					$fields[] = $this->_nodename;
				}
				// add a select
				$object->db->select($fields);
			}

			// create the where clause for this query
			if ( $skip_root === TRUE )
			{
				// select only all children
				$object->db->where($this->_leftindex . ' >', $object->{$this->_leftindex});
				$object->db->where($this->_rightindex . ' <', $object->{$this->_rightindex});
				$level = -1;
			}
			else
			{
				// select the node and all children
				$object->db->where($this->_leftindex . ' >=', $object->{$this->_leftindex});
				$object->db->where($this->_rightindex . ' <=', $object->{$this->_rightindex});
				$level = -2;
			}

			// if we have multiple roots
			if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
			{
				// only delete the selected one
				$object->db->where($this->_rootfield, $this->_rootindex);
			}

			// fetch the result
			$result = $object->db->order_by($this->_leftindex)->get($object->table)->result_array();

			// store the last left pointer
			$last_left = $object->{$this->_leftindex};

			// create the path
			if ( ! empty($this->_nodename) )
			{
				$path = array( $object->{$this->_nodename} );
			}
			else
			{
				$path = array();
			}

			// add level and path to the result
			foreach ( $result as $key => $value )
			{
				// for now, just store the ID
				$result[$key]['__id'] = $value['id'];

				// calculate the nest level of this node
				$level += $last_left - $value[$this->_leftindex] + 2;
				$last_left = $value[$this->_leftindex];
				$result[$key]['__level'] = $level;

				// create the relative path to this node
				$result[$key]['__path'] = '';
				if ( ! empty($this->_nodename) )
				{
					$path[$level] = $value[$this->_nodename];
					for ( $i = 0; $i <= $level; $i++ )
					{
						$result[$key]['__path'] .= '/' . $path[$i];
					}
				}
			}

			// convert the result to output
			if ( in_array($type, array('tab', 'csv', 'html')) )
			{
				// storage for the result
				$convert = '';

				// loop through the elements
				foreach ( $result as $key => $value )
				{
					// prefix based on requested type
					switch ($type)
					{
						case 'tab';
							$convert .= str_repeat("\t", $value['__level'] * 4 );
							break;
						case 'csv';
							break;
						case 'html';
							$convert .= str_repeat("&nbsp;", $value['__level'] * 4 );
							break;
					}

					// print the attributes requested
					if ( ! is_null($attributes) )
					{
						$att = reset($attributes);
						while($att){
							if ( is_numeric($value[$att]) )
							{
								$convert .= $value[$att];
							}
							else
							{
								$convert .= '"'.$value[$att].'"';
							}
							$att = next($attributes);
							if ($att)
							{
								$convert .= ($type == 'csv' ? "," : " ");
							}
						}
					}

					// postfix based on requested type
					switch ($type)
					{
						case 'tab';
							$convert .= "\n";
							break;
						case 'csv';
							$convert .= "\n";
							break;
						case 'html';
							$convert .= "<br />";
							break;
					}
				}
				return $convert;
			}
			else
			{
				return $result;
			}
		}

		return FALSE;
	}

	// -----------------------------------------------------------------
	// internal methods
	// -----------------------------------------------------------------

	/**
	 * makes room for a new node (or nodes) by shifting the left and right
	 * id's of nodes with larger values than our object by $delta
	 *
	 * note that $delta can also be negative!
	 *
	 * @param	object	the DataMapper object
	 * @param	integer	left value of the start node
	 * @param	integer	number of positions to shift
	 * @return	object	the updated DataMapper object
	 * @access	private
	 */
	private function _shiftRLValues($object, $first, $delta)
	{
		// we need a valid object
		if ( $object->exists() )
		{
			// if we have multiple roots
			if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
			{
				// select the correct one
				$object->where($this->_rootfield, $this->_rootindex);
			}

			// set the delta
			$delta = $delta >= 0 ? (' + '.$delta) : (' - '.(abs($delta)));

			// select the range
			$object->where($this->_leftindex.' >=', $first);
			$object->update(array($this->_leftindex => $this->_leftindex.$delta), FALSE);

			// if we have multiple roots
			if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
			{
				// select the correct one
				$object->where($this->_rootfield, $this->_rootindex);
			}

			// select the range
			$object->where($this->_rightindex.' >=', $first);

			$object->update(array($this->_rightindex => $this->_rightindex.$delta), FALSE);
		}

		// return the object
		return $object;
	}

	// -----------------------------------------------------------------

	/**
	 * shifts a range of nodes up or down the left and right index by $delta
	 *
	 * note that $delta can also be negative!
	 *
	 * @param	object	the DataMapper object
	 * @param	integer	left value of the start node
	 * @param	integer	right value of the end node
	 * @param	integer	number of positions to shift
	 * @return	object	the updated DataMapper object
	 * @access	private
	 */
	private function _shiftRLRange($object, $first, $last, $delta)
	{
		// we need a valid object
		if ( $object->exists() )
		{
			// if we have multiple roots
			if ( in_array($this->_rootfield, $object->fields) && ! is_null($this->_rootindex) )
			{
				// select the correct one
				$object->where($this->_rootfield, $this->_rootindex);
			}

			// select the range
			$object->where($this->_leftindex.' >=', $first);
			$object->where($this->_rightindex.' <=', $last);

			// set the delta
			$delta = $delta >= 0 ? (' + '.$delta) : (' - '.(abs($delta)));

			$object->update(array($this->_leftindex => $this->_leftindex.$delta, $this->_rightindex => $this->_rightindex.$delta), FALSE);
		}

		// return the object
		return $object;
	}

	// -----------------------------------------------------------------

	/**
	 * inserts a new record into the tree
	 *
	 * @param	object	the DataMapper object
	 * @return	object	the updated DataMapper object
	 * @access	private
	 */
	private function _insertNew($object)
	{
		// for now, just save the object
		$object->save();

		// return the object
		return $object;
	}

	// -----------------------------------------------------------------

	/**
	 * move a section of the tree to another location within the tree
	 *
	 * @param	object	the DataMapper object we're going to move
	 * @param	integer	the destination node's left id value
	 * @return	object	the updated DataMapper object
	 * @access	private
	 */
	private function _moveSubtree($object, $node, $destination_id)
	{
		// if we have multiple roots
		if ( in_array($this->_rootfield, $object->fields) )
		{
			// make sure both nodes are part of the same tree
			if ( $object->{$this->_rootfield} != $node->{$this->_rootfield} )
			{
				return FALSE;
			}
		}

		// determine the size of the tree to move
		$treesize = $object->{$this->_rightindex} - $object->{$this->_leftindex} + 1;

		// get the objects left- and right pointers
		$left_id = $object->{$this->_leftindex};
		$right_id = $object->{$this->_rightindex};

		// shift to make some space
		$this->_shiftRLValues($node, $destination_id, $treesize);

		// correct pointers if there were shifted to
		if ($object->{$this->_leftindex} >= $destination_id)
		{
			$left_id += $treesize;
			$right_id += $treesize;
		}

		// enough room now, start the move
		$this->_shiftRLRange($node, $left_id, $right_id, $destination_id - $left_id);

		// and correct index values after the source
		$this->_shiftRLValues($object, $right_id + 1, -$treesize);

		// return the object
		return $object->get_by_id($object->id);
	}

}

/* End of file nestedsets.php */
/* Location: ./application/datamapper/nestedsets.php */
