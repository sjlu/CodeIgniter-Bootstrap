<?php

/**
 * SimpleCache Extension for DataMapper classes.
 *
 * Allows the usage of CodeIgniter query caching on DataMapper queries.
 *
 * @license 	MIT License
 * @package		DMZ-Included-Extensions
 * @category	DMZ
 * @author  	Phil DeJarnett
 * @link    	http://www.overzealous.com/dmz/pages/extensions/simplecache.html
 * @version 	1.0
 */

// --------------------------------------------------------------------------

/**
 * DMZ_SimpleCache Class
 *
 * @package		DMZ-Included-Extensions
 */
class DMZ_SimpleCache {
	
	/**
	 * Allows CodeIgniter's caching method to cache large result sets.
	 * Call it exactly as get();
	 * 
	 * @param	DataMapper $object The DataMapper Object.
	 * @return	DataMapper The DataMapper object for chaining.
	 */
    function get_cached($object)
	{
        if( ! empty($object->_should_delete_cache) )
		{
            $object->db->cache_delete();
            $object->_should_delete_cache = FALSE;
        }
		
		$object->db->cache_on();
		// get the arguments, but pop the object.
		$args = func_get_args();
		array_shift($args);
		call_user_func_array(array($object, 'get'), $args);
        $object->db->cache_off();
        return $object;
    }

    /**
     * Clears the cached query the next time get_cached is called.
     * 
     * @param	DataMapper $object The DataMapper Object.
     * @return	DataMapper The DataMapper $object for chaining.
     */
    function clear_cache($object)
	{
		$args = func_get_args();
		array_shift($args);
		if( ! empty($args)) {
			call_user_func_array(array($object->db, 'cache_delete'), $args);
		} else {
	        $object->_should_delete_cache = TRUE;
		}
        return $object;
    }
	
}

/* End of file simplecache.php */
/* Location: ./application/datamapper/simplecache.php */
