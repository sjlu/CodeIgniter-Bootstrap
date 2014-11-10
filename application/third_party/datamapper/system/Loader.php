<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Data Mapper ORM bootstrap
 *
 * Dynamic CI Loader class extension
 *
 * @license 	MIT License
 * @package		DataMapper ORM
 * @category	DataMapper ORM
 * @author  	Harro "WanWizard" Verton
 * @link		http://datamapper.wanwizard.eu/
 * @version 	2.0.0
 */

$dmclass = <<<CODE
class DM_Loader extends $name
{
	// --------------------------------------------------------------------

	/**
	 * Database Loader
	 *
	 * @param	string	the DB credentials
	 * @param	bool	whether to return the DB object
	 * @param	bool	whether to enable active record (this allows us to override the config setting)
	 * @return	object
	 */
	public function database(\$params = '', \$return = FALSE, \$active_record = NULL)
	{
		// Grab the super object
		\$CI =& get_instance();

		// Do we even need to load the database class?
		if (class_exists('CI_DB') AND \$return == FALSE AND \$active_record == NULL AND isset(\$CI->db) AND is_object(\$CI->db))
		{
			return FALSE;
		}

		require_once(APPPATH.'third_party/datamapper/system/DB.php');

		if (\$return === TRUE)
		{
			return DB(\$params, \$active_record);
		}

		// Initialize the db variable.  Needed to prevent
		// reference errors with some configurations
		\$CI->db = '';

		// Load the DB class
		\$CI->db =& DB(\$params, \$active_record);
	}
}
CODE;

// dynamically add our class extension
eval($dmclass);
unset($dmclass);

// and update the name of the class to instantiate
$name = 'DM_Loader';

/* End of file Loader.php */
/* Location: ./application/third_party/datamapper/system/Loader.php */
