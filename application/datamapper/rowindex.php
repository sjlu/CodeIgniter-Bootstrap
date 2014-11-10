<?php

/**
 * Row Index Extension for DataMapper classes.
 *
 * Determine the row index for a given ID based on a query.
 *
 * @license 	MIT License
 * @package		DMZ-Included-Extensions
 * @category	DMZ
 * @author  	Phil DeJarnett
 * @link    	http://www.overzealous.com/dmz/pages/extensions/worindex.html
 * @version 	1.0
 */

// --------------------------------------------------------------------------

/**
 * DMZ_RowIndex Class
 *
 * @package		DMZ-Included-Extensions
 */
class DMZ_RowIndex {

	private $first_only = FALSE;

	/**
	 * Given an already-built query and an object's ID, determine what row
	 * that object has in the query.
	 *
	 * @param	DataMapper $object THe DataMapper object.
	 * @param	DataMapper|int $id The ID or object to look for.
	 * @param	array $leave_select A list of items to leave in the selection array, overriding the automatic removal.
	 * @param	<type> $distinct_on If TRUE, use DISTINCT ON (not all DBs support this)
	 * @return	bool|int Returns the index of the item, or FALSE if none are found.
	 */
	public function row_index($object, $id, $leave_select = array(), $distinct_on = FALSE) {
		$this->first_only = TRUE;
		$result = $this->get_rowindices($object, $id, $leave_select, $distinct_on);
		$this->first_only = FALSE;
		if(empty($result)) {
			return FALSE;
		} else {
			reset($result);
			return key($result);
		}
	}

	/**
	 * Given an already-built query and an object's ID, determine what row
	 * that object has in the query.
	 *
	 * @param	DataMapper $object THe DataMapper object.
	 * @param	DataMapper|array|int $id The ID or object to look for.
	 * @param	array $leave_select A list of items to leave in the selection array, overriding the automatic removal.
	 * @param	bool $distinct_on If TRUE, use DISTINCT ON (not all DBs support this)
	 * @return	array Returns an array of row indices.
	 */
	public function row_indices($object, $ids, $leave_select = array(), $distinct_on = FALSE) {
		$row_indices = array();
		if(!is_array($ids)) {
			$ids = array($ids);
		}
		$new_ids = array();
		foreach($ids as $id) {
			if(is_object($id)) {
				$new_ids[] = $id->id;
			} else {
				$new_ids[] = intval($id);
			}
		}
		if(!is_array($leave_select)) {
			$leave_select = array();
		}
		// duplicate to ensure the query isn't wiped out
		$object = $object->get_clone(TRUE);
		// remove the unecessary columns
		$sort_columns = $this->_orderlist($object->db->ar_orderby);
		$ar_select = array();
		if(empty($sort_columns) && empty($leave_select)) {
			// no sort columns, so just wipe it out.
			$object->db->ar_select = NULL;
		} else {
			// loop through the ar_select, and remove columns that
			// are not specified by sorting
			$select = $this->_splitselect(implode(', ', $object->db->ar_select));
			// find all aliases (they are all we care about)
			foreach($select as $alias => $sel) {
				if(in_array($alias, $sort_columns) || in_array($alias, $leave_select)) {
					$ar_select[] = $sel;
				}
			}
			$object->db->ar_select = NULL;
		}

		if($distinct_on) {
			// to ensure unique items we must DISTINCT ON the same list as the ORDER BY list.
			$distinct = 'DISTINCT ON (' . preg_replace("/\s+(asc|desc)/i", "", implode(",", $object->db->ar_orderby)) . ') ';

			// add in the DISTINCT ON and the $table.id column.  The FALSE prevents the items from being escaped
			$object->select($distinct . $object->table.'.id', FALSE);
		} else {
			$object->select('id');
		}
		// this ensures that the DISTINCT ON is first, since it must be
		$object->db->ar_select = array_merge($object->db->ar_select, $ar_select);

		// run the query
		$query = $object->get_raw();
		foreach($query->result() as $index => $row) {
			$id = intval($row->id);
			if(in_array($id, $new_ids)) {
				$row_indices[$index] = $id;
				if($this->first_only) {
					break;
				}
			}
		}

		// in case the user wants to know
		$object->rowindex_total_rows = $query->num_rows();

		// return results
		return $row_indices;
	}

	/**
	 * Processes the order_by array, and converts it into a list
	 * of non-fully-qualified columns. These might be aliases.
	 *
	 * @param	array $order_by  Original order_by array
	 * @return	array Modified array.
	 */
	private function _orderlist($order_by) {
		$list = array();
		$impt_parts_regex = '/([\w]+)([^\(]|$)/';
		foreach($order_by as $order_by_string) {
			$parts = explode(',', $order_by_string);
			foreach($parts as $part) {
				// remove optional order marker
				$part = preg_replace('/\s+(ASC|DESC)$/i', '', $part);
				// remove all functions (might not work well on recursive)
				$replacements = 1;
				while($replacements > 0) {
					$part = preg_replace('/[a-z][\w]*\((.*)\)/i', '$1', $part, -1, $replacements);
				}
				// now remove all fully-qualified elements (those with tables)
				$part = preg_replace('/("[a-z][\w]*"|[a-z][\w]*)\.("[a-z][\w]*"|[a-z][\w]*)/i', '', $part);
				// finally, match all whole words left behind
				preg_match_all('/([a-z][\w]*)/i', $part, $result, PREG_SET_ORDER);
				foreach($result as $column) {
					$list[] = $column[0];
				}
			}
		}
		return $list;
	}

	/**
	 * Splits the select query up into parts.
	 *
	 * @param	string $select Original select string
	 * @return	array Individual select components.
	 */
	private function _splitselect($select) {
		// splits a select into parameters, then stores them as
		// $select[<alias>] = $select_part
		$list = array();
		$last_pos = 0;
		$pos = -1;
		while($pos < strlen($select)) {
			$pos++;
			if($pos == strlen($select) || $select[$pos] == ',') {
				// we found an item, process it
				$sel = substr($select, $last_pos, $pos-$last_pos);
				if(preg_match('/\sAS\s+"?([a-z]\w*)"?\s*$/i', $sel, $matches) != 0) {
					$list[$matches[1]] = trim($sel);
				}
				$last_pos = $pos+1;
			} else if($select[$pos] == '(') {
				// skip past parenthesized sections
				$pos = $this->_splitselect_parens($select, $pos);
			}
		}
		return $list;
	}

	/**
	 * Recursively processes parentheses in the select string.
	 *
	 * @param	string $select Select string.
	 * @param	int $pos current location in the string.
	 * @return	int final position after all recursing is complete.
	 */
	private function _splitselect_parens($select, $pos) {
		while($pos < strlen($select)) {
			$pos++;
			if($select[$pos] == '(') {
				// skip past recursive parenthesized sections
				$pos = $this->_splitselect_parens($select, $pos);
			} else if($select[$pos] == ')') {
				break;
			}
		}
		return $pos;
	}
	
}

/* End of file rowindex.php */
/* Location: ./application/datamapper/rowindex.php */
