<?php

/**
 * Data Mapper ORM Class
 *
 * Transforms database tables into objects.
 *
 * @license 	MIT License
 * @package		DataMapper ORM
 * @category	DataMapper ORM
 * @author  	Harro Verton
 * @author  	Phil DeJarnett (up to v1.7.1)
 * @author  	Simon Stenhouse (up to v1.6.0)
 * @link		http://datamapper.wanwizard.eu/
 * @version 	1.8.2
 */

/**
 * Key for storing pre-converted classnames
 */
define('DMZ_CLASSNAMES_KEY', '_dmz_classnames');

/**
 * DMZ version
 */
define('DMZ_VERSION', '1.8.2');

/**
 * Data Mapper Class
 *
 * Transforms database tables into objects.
 *
 * @package		DataMapper ORM
 *
 * Properties (for code completion)
 * @property CI_DB_driver $db The CodeIgniter Database Library
 * @property CI_Loader $load The CodeIgnter Loader Library
 * @property CI_Language $lang The CodeIgniter Language Library
 * @property CI_Config $config The CodeIgniter Config Library
 * @property CI_Form_validation $form_validation The CodeIgniter Form Validation Library
 *
 *
 * Define some of the magic methods:
 *
 * Get By:
 * @method DataMapper get_by_id() get_by_id(int $value) Looks up an item by its ID.
 * @method DataMapper get_by_FIELD() get_by_FIELD(mixed $value) Looks up an item by a specific FIELD. Ex: get_by_name($user_name);
 * @method DataMapper get_by_related() get_by_related(mixed $related, string $field = NULL, string $value = NULL) Get results based on a related item.
 * @method DataMapper get_by_related_RELATEDFIELD() get_by_related_RELATEDFIELD(string $field = NULL, string $value = NULL) Get results based on a RELATEDFIELD. Ex: get_by_related_user('id', $userid);
 *
 * Save and Delete
 * @method DataMapper save_RELATEDFIELD() save_RELATEDFIELD(mixed $object) Saves relationship(s) using the specified RELATEDFIELD. Ex: save_user($user);
 * @method DataMapper delete_RELATEDFIELD() delete_RELATEDFIELD(mixed $object) Deletes relationship(s) using the specified RELATEDFIELD. Ex: delete_user($user);
 *
 * Related:
 * @method DataMapper where_related() where_related(mixed $related, string $field = NULL, string $value = NULL) Limits results based on a related field.
 * @method DataMapper where_between_related() where_related(mixed $related, string $field = NULL, string $value1 = NULL, string $value2 = NULL) Limits results based on a related field, via BETWEEN.
 * @method DataMapper or_where_related() or_where_related(mixed $related, string $field = NULL, string $value = NULL) Limits results based on a related field, via OR.
 * @method DataMapper where_in_related() where_in_related(mixed $related, string $field, array $values) Limits results by comparing a related field to a range of values.
 * @method DataMapper or_where_in_related() or_where_in_related(mixed $related, string $field, array $values) Limits results by comparing a related field to a range of values.
 * @method DataMapper where_not_in_related() where_not_in_related(mixed $related, string $field, array $values) Limits results by comparing a related field to a range of values.
 * @method DataMapper or_where_not_in_related() or_where_not_in_related(mixed $related, string $field, array $values) Limits results by comparing a related field to a range of values.
 * @method DataMapper like_related() like_related(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a related field to a value.
 * @method DataMapper or_like_related() like_related(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a related field to a value.
 * @method DataMapper not_like_related() like_related(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a related field to a value.
 * @method DataMapper or_not_like_related() like_related(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a related field to a value.
 * @method DataMapper ilike_related() like_related(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a related field to a value (case insensitive).
 * @method DataMapper or_ilike_related() like_related(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a related field to a value (case insensitive).
 * @method DataMapper not_ilike_related() like_related(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a related field to a value (case insensitive).
 * @method DataMapper or_not_ilike_related() like_related(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a related field to a value (case insensitive).
 * @method DataMapper group_by_related() group_by_related(mixed $related, string $field) Groups the query by a related field.
 * @method DataMapper having_related() having_related(mixed $related, string $field, string $value) Groups the querying using a HAVING clause.
 * @method DataMapper or_having_related() having_related(mixed $related, string $field, string $value) Groups the querying using a HAVING clause, via OR.
 * @method DataMapper order_by_related() order_by_related(mixed $related, string $field, string $direction) Orders the query based on a related field.
 *
 *
 * Join Fields:
 * @method DataMapper where_join_field() where_join_field(mixed $related, string $field = NULL, string $value = NULL) Limits results based on a join field.
 * @method DataMapper where_between_join_field() where_related(mixed $related, string $field = NULL, string $value1 = NULL, string $value2 = NULL) Limits results based on a join field, via BETWEEN.
 * @method DataMapper or_where_join_field() or_where_join_field(mixed $related, string $field = NULL, string $value = NULL) Limits results based on a join field, via OR.
 * @method DataMapper where_in_join_field() where_in_join_field(mixed $related, string $field, array $values) Limits results by comparing a join field to a range of values.
 * @method DataMapper or_where_in_join_field() or_where_in_join_field(mixed $related, string $field, array $values) Limits results by comparing a join field to a range of values.
 * @method DataMapper where_not_in_join_field() where_not_in_join_field(mixed $related, string $field, array $values) Limits results by comparing a join field to a range of values.
 * @method DataMapper or_where_not_in_join_field() or_where_not_in_join_field(mixed $related, string $field, array $values) Limits results by comparing a join field to a range of values.
 * @method DataMapper like_join_field() like_join_field(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a join field to a value.
 * @method DataMapper or_like_join_field() like_join_field(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a join field to a value.
 * @method DataMapper not_like_join_field() like_join_field(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a join field to a value.
 * @method DataMapper or_not_like_join_field() like_join_field(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a join field to a value.
 * @method DataMapper ilike_join_field() like_join_field(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a join field to a value (case insensitive).
 * @method DataMapper or_ilike_join_field() like_join_field(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a join field to a value (case insensitive).
 * @method DataMapper not_ilike_join_field() like_join_field(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a join field to a value (case insensitive).
 * @method DataMapper or_not_ilike_join_field() like_join_field(mixed $related, string $field, string $value, string $match = 'both') Limits results by matching a join field to a value (case insensitive).
 * @method DataMapper group_by_join_field() group_by_join_field(mixed $related, string $field) Groups the query by a join field.
 * @method DataMapper having_join_field() having_join_field(mixed $related, string $field, string $value) Groups the querying using a HAVING clause.
 * @method DataMapper or_having_join_field() having_join_field(mixed $related, string $field, string $value) Groups the querying using a HAVING clause, via OR.
 * @method DataMapper order_by_join_field() order_by_join_field(mixed $related, string $field, string $direction) Orders the query based on a join field.
 *
 * SQL Functions:
 * @method DataMapper select_func() select_func(string $function_name, mixed $args,..., string $alias) Selects the result of a SQL function. Alias is required.
 * @method DataMapper where_func() where_func(string $function_name, mixed $args,..., string $value) Limits results based on a SQL function.
 * @method DataMapper or_where_func() or_where_func(string $function_name, mixed $args,..., string $value) Limits results based on a SQL function, via OR.
 * @method DataMapper where_in_func() where_in_func(string $function_name, mixed $args,..., array $values) Limits results by comparing a SQL function to a range of values.
 * @method DataMapper or_where_in_func() or_where_in_func(string $function_name, mixed $args,..., array $values) Limits results by comparing a SQL function to a range of values.
 * @method DataMapper where_not_in_func() where_not_in_func(string $function_name, string $field, array $values) Limits results by comparing a SQL function to a range of values.
 * @method DataMapper or_where_not_in_func() or_where_not_in_func(string $function_name, mixed $args,..., array $values) Limits results by comparing a SQL function to a range of values.
 * @method DataMapper like_func() like_func(string $function_name, mixed $args,..., string $value) Limits results by matching a SQL function to a value.
 * @method DataMapper or_like_func() like_func(string $function_name, mixed $args,..., string $value) Limits results by matching a SQL function to a value.
 * @method DataMapper not_like_func() like_func(string $function_name, mixed $args,..., string $value) Limits results by matching a SQL function to a value.
 * @method DataMapper or_not_like_func() like_func(string $function_name, mixed $args,..., string $value) Limits results by matching a SQL function to a value.
 * @method DataMapper ilike_func() like_func(string $function_name, mixed $args,..., string $value) Limits results by matching a SQL function to a value (case insensitive).
 * @method DataMapper or_ilike_func() like_func(string $function_name, mixed $args,..., string $value) Limits results by matching a SQL function to a value (case insensitive).
 * @method DataMapper not_ilike_func() like_func(string $function_name, mixed $args,..., string $value) Limits results by matching a SQL function to a value (case insensitive).
 * @method DataMapper or_not_ilike_func() like_func(string $function_name, mixed $args,..., string $value) Limits results by matching a SQL function to a value (case insensitive).
 * @method DataMapper group_by_func() group_by_func(string $function_name, mixed $args,...) Groups the query by a SQL function.
 * @method DataMapper having_func() having_func(string $function_name, mixed $args,..., string $value) Groups the querying using a HAVING clause.
 * @method DataMapper or_having_func() having_func(string $function_name, mixed $args,..., string $value) Groups the querying using a HAVING clause, via OR.
 * @method DataMapper order_by_func() order_by_func(string $function_name, mixed $args,..., string $direction) Orders the query based on a SQL function.
 *
 * Field -> SQL functions:
 * @method DataMapper where_field_field_func() where_field_func($field, string $function_name, mixed $args,...) Limits results based on a SQL function.
 * @method DataMapper where_between_field_field_func() where_between_field_func($field, string $function_name, mixed $args,...) Limits results based on a SQL function, via BETWEEN.
 * @method DataMapper or_where_field_field_func() or_where_field_func($field, string $function_name, mixed $args,...) Limits results based on a SQL function, via OR.
 * @method DataMapper where_in_field_field_func() where_in_field_func($field, string $function_name, mixed $args,...) Limits results by comparing a SQL function to a range of values.
 * @method DataMapper or_where_in_field_field_func() or_where_in_field_func($field, string $function_name, mixed $args,...) Limits results by comparing a SQL function to a range of values.
 * @method DataMapper where_not_in_field_field_func() where_not_in_field_func($field, string $function_name, string $field) Limits results by comparing a SQL function to a range of values.
 * @method DataMapper or_where_not_in_field_field_func() or_where_not_in_field_func($field, string $function_name, mixed $args,...) Limits results by comparing a SQL function to a range of values.
 * @method DataMapper like_field_field_func() like_field_func($field, string $function_name, mixed $args,...) Limits results by matching a SQL function to a value.
 * @method DataMapper or_like_field_field_func() like_field_func($field, string $function_name, mixed $args,...) Limits results by matching a SQL function to a value.
 * @method DataMapper not_like_field_field_func() like_field_func($field, string $function_name, mixed $args,...) Limits results by matching a SQL function to a value.
 * @method DataMapper or_not_like_field_field_func() like_field_func($field, string $function_name, mixed $args,...) Limits results by matching a SQL function to a value.
 * @method DataMapper ilike_field_field_func() like_field_func($field, string $function_name, mixed $args,...) Limits results by matching a SQL function to a value (case insensitive).
 * @method DataMapper or_ilike_field_field_func() like_field_func($field, string $function_name, mixed $args,...) Limits results by matching a SQL function to a value (case insensitive).
 * @method DataMapper not_ilike_field_field_func() like_field_func($field, string $function_name, mixed $args,...) Limits results by matching a SQL function to a value (case insensitive).
 * @method DataMapper or_not_ilike_field_field_func() like_field_func($field, string $function_name, mixed $args,...) Limits results by matching a SQL function to a value (case insensitive).
 * @method DataMapper group_by_field_field_func() group_by_field_func($field, string $function_name, mixed $args,...) Groups the query by a SQL function.
 * @method DataMapper having_field_field_func() having_field_func($field, string $function_name, mixed $args,...) Groups the querying using a HAVING clause.
 * @method DataMapper or_having_field_field_func() having_field_func($field, string $function_name, mixed $args,...) Groups the querying using a HAVING clause, via OR.
 * @method DataMapper order_by_field_field_func() order_by_field_func($field, string $function_name, mixed $args,...) Orders the query based on a SQL function.
 *
 * Subqueries:
 * @method DataMapper select_subquery() select_subquery(DataMapper $subquery, string $alias) Selects the result of a function. Alias is required.
 * @method DataMapper where_subquery() where_subquery(mixed $subquery_or_field, mixed $value_or_subquery) Limits results based on a subquery.
 * @method DataMapper or_where_subquery() or_where_subquery(mixed $subquery_or_field, mixed $value_or_subquery) Limits results based on a subquery, via OR.
 * @method DataMapper where_in_subquery() where_in_subquery(mixed $subquery_or_field, mixed $values_or_subquery) Limits results by comparing a subquery to a range of values.
 * @method DataMapper or_where_in_subquery() or_where_in_subquery(mixed $subquery_or_field, mixed $values_or_subquery) Limits results by comparing a subquery to a range of values.
 * @method DataMapper where_not_in_subquery() where_not_in_subquery(mixed $subquery_or_field, string $field, mixed $values_or_subquery) Limits results by comparing a subquery to a range of values.
 * @method DataMapper or_where_not_in_subquery() or_where_not_in_subquery(mixed $subquery_or_field, mixed $values_or_subquery) Limits results by comparing a subquery to a range of values.
 * @method DataMapper like_subquery() like_subquery(DataMapper $subquery, string $value, string $match = 'both') Limits results by matching a subquery to a value.
 * @method DataMapper or_like_subquery() like_subquery(DataMapper $subquery, string $value, string $match = 'both') Limits results by matching a subquery to a value.
 * @method DataMapper not_like_subquery() like_subquery(DataMapper $subquery, string $value, string $match = 'both') Limits results by matching a subquery to a value.
 * @method DataMapper or_not_like_subquery() like_subquery(DataMapper $subquery, string $value, string $match = 'both') Limits results by matching a subquery to a value.
 * @method DataMapper ilike_subquery() like_subquery(DataMapper $subquery, string $value, string $match = 'both') Limits results by matching a subquery to a value (case insensitive).
 * @method DataMapper or_ilike_subquery() like_subquery(DataMapper $subquery, string $value, string $match = 'both') Limits results by matching a subquery to a value (case insensitive).
 * @method DataMapper not_ilike_subquery() like_subquery(DataMapper $subquery, string $value, string $match = 'both') Limits results by matching a subquery to a value (case insensitive).
 * @method DataMapper or_not_ilike_subquery() like_subquery(DataMapper $subquery, string $value, string $match = 'both') Limits results by matching a subquery to a value (case insensitive).
 * @method DataMapper having_subquery() having_subquery(string $field, DataMapper $subquery) Groups the querying using a HAVING clause.
 * @method DataMapper or_having_subquery() having_subquery(string $field, DataMapper $subquery) Groups the querying using a HAVING clause, via OR.
 * @method DataMapper order_by_subquery() order_by_subquery(DataMapper $subquery, string $direction) Orders the query based on a subquery.
 *
 * Related Subqueries:
 * @method DataMapper where_related_subquery() where_related_subquery(mixed $related_model, string $related_field, DataMapper $subquery) Limits results based on a subquery.
 * @method DataMapper or_where_related_subquery() or_where_related_subquery(mixed $related_model, string $related_field, DataMapper $subquery) Limits results based on a subquery, via OR.
 * @method DataMapper where_in_related_subquery() where_in_related_subquery(mixed $related_model, string $related_field, DataMapper $subquery) Limits results by comparing a subquery to a range of values.
 * @method DataMapper or_where_in_related_subquery() or_where_in_related_subquery(mixed $related_model, string $related_field, DataMapper $subquery) Limits results by comparing a subquery to a range of values.
 * @method DataMapper where_not_in_related_subquery() where_not_in_related_subquery(mixed $related_model, string $related_field, DataMapper $subquery) Limits results by comparing a subquery to a range of values.
 * @method DataMapper or_where_not_in_related_subquery() or_where_not_in_related_subquery(mixed $related_model, string $related_field, DataMapper $subquery) Limits results by comparing a subquery to a range of values.
 * @method DataMapper having_related_subquery() having_related_subquery(mixed $related_model, string $related_field, DataMapper $subquery) Groups the querying using a HAVING clause.
 * @method DataMapper or_having_related_subquery() having_related_subquery(mixed $related_model, string $related_field, DataMapper $subquery) Groups the querying using a HAVING clause, via OR.
 *
 * Array Extension:
 * @method array to_array() to_array($fields = '') NEEDS ARRAY EXTENSION.  Converts this object into an associative array.  @link DMZ_Array::to_array
 * @method array all_to_array() all_to_array($fields = '') NEEDS ARRAY EXTENSION.  Converts the all array into an associative array.  @link DMZ_Array::all_to_array
 * @method array|bool from_array() from_array($data, $fields = '', $save = FALSE) NEEDS ARRAY EXTENSION.  Converts $this->all into an associative array.  @link DMZ_Array::all_to_array
 *
 * CSV Extension
 * @method bool csv_export() csv_export($filename, $fields = '', $include_header = TRUE) NEEDS CSV EXTENSION.  Exports this object as a CSV file.
 * @method array csv_import() csv_import($filename, $fields = '', $header_row = TRUE, $callback = NULL) NEEDS CSV EXTENSION.  Imports a CSV file into this object.
 *
 * JSON Extension:
 * @method string to_json() to_json($fields = '', $pretty_print = FALSE) NEEDS JSON EXTENSION.  Converts this object into a JSON string.
 * @method string all_to_json() all_to_json($fields = '', $pretty_print = FALSE) NEEDS JSON EXTENSION.  Converts the all array into a JSON string.
 * @method bool from_json() from_json($json, $fields = '') NEEDS JSON EXTENSION.  Imports the values from a JSON string into this object.
 * @method void set_json_content_type() set_json_content_type() NEEDS JSON EXTENSION.  Sets the content type header to Content-Type: application/json.
 *
 * SimpleCache Extension:
 * @method DataMapper get_cached() get_cached($limit = '', $offset = '') NEEDS SIMPLECACHE EXTENSION.  Enables cacheable queries.
 * @method DataMapper clear_cache() get_cached($segment,...) NEEDS SIMPLECACHE EXTENSION.  Clears a cache for the specfied segment.
 *
 * Translate Extension:
 *
 * Nestedsets Extension:
 *
 */
class DataMapper implements IteratorAggregate {

	/**
	 * Stores the shared configuration
	 * @var array
	 */
	static $config = array();
	/**
	 * Stores settings that are common across a specific Model
	 * @var array
	 */
	static $common = array(DMZ_CLASSNAMES_KEY => array());
	/**
	 * Stores global extensions
	 * @var array
	 */
	static $global_extensions = array();
	/**
	 * Used to override unset default properties.
	 * @var array
	 */
	static $_dmz_config_defaults = array(
		'prefix' => '',
		'join_prefix' => '',
		'error_prefix' => '<span class="error">',
		'error_suffix' => '</span>',
		'created_field' => 'created',
		'updated_field' => 'updated',
		'local_time' => FALSE,
		'unix_timestamp' => FALSE,
		'timestamp_format' => 'Y-m-d H:i:s',
		'lang_file_format' => 'model_${model}',
		'field_label_lang_format' => '${model}_${field}',
		'auto_transaction' => FALSE,
		'auto_populate_has_many' => FALSE,
		'auto_populate_has_one' => TRUE,
		'all_array_uses_ids' => FALSE,
		'db_params' => '',
		'extensions' => array(),
		'extensions_path' => 'datamapper',
	);

	/**
	 * Contains any errors that occur during validation, saving, or other
	 * database access.
	 * @var DM_Error_Object
	 */
	public $error;
	/**
	 * Used to keep track of the original values from the database, to
	 * prevent unecessarily changing fields.
	 * @var object
	 */
	public $stored;
	/**
	 * The name of the table for this model (may be automatically generated
	 * from the classname).
	 * @var string
	 */
	public $table = '';
	/**
	 * The singular name for this model (may be automatically generated from
	 * the classname).
	 * @var string
	 */
	public $model = '';
	/**
	 * The primary key used for this models table
	 * the classname).
	 * @var string
	 */
	public $primary_key = 'id';
	/**
	 * The result of validate is stored here.
	 * @var bool
	 */
	public $valid = FALSE;
	/**
	 * delete relations on delete of an object. Defaults to TRUE.
	 * set to FALSE if you RDBMS takes care of this using constraints
	 * @var bool
	 */
	public $cascade_delete = TRUE;
	/**
	 * Contains the database fields for this object.
	 * ** Automatically configured **
	 * @var array
	 */
	public $fields = array();
	/**
	 * Contains the result of the last query.
	 * @var array
	 */
	public $all = array();
	/**
	 * Semi-private field used to track the parent model/id if there is one.
	 * @var array
	 */
	public $parent = array();
	/**
	 * Contains the validation rules, label, and get_rules for each field.
	 * @var array
	 */
	public $validation = array();
	/**
	 * Contains any related objects of which this model is related one or more times.
	 * @var array
	 */
	public $has_many = array();
	/**
	 * Contains any related objects of which this model is singularly related.
	 * @var array
	 */
	public $has_one = array();
	/**
	 * Used to enable or disable the production cache.
	 * This should really only be set in the global configuration.
	 * @var bool
	 */
	public $production_cache = FALSE;
	/**
	 * If a query returns more than the number of rows specified here,
	 * then it will be automatically freed after a get.
	 * @var int
	 */
	public $free_result_threshold = 100;
	/**
	 * This can be specified as an array of fields to sort by if no other
	 * sorting or selection has occurred.
	 * @var mixed
	 */
	public $default_order_by = NULL;

	// tracks whether or not the object has already been validated
	protected $_validated = FALSE;
	// tracks whether validation needs to be forced before save
	protected $_force_validation = FALSE;
	// Tracks the columns that need to be instantiated after a GET
	protected $_instantiations = NULL;
	// Tracks get_rules, matches, and intval rules, to spped up _to_object
	protected $_field_tracking = NULL;
	// used to track related queries in deep relationships.
	protected $_query_related = array();
	// If true before a related get(), any extra fields on the join table will be added.
	protected $_include_join_fields = FALSE;
	// If true before a save, this will force the next save to be new.
	protected $_force_save_as_new = FALSE;
	// If true, the next where statement will not be prefixed with an AND or OR.
	protected $_where_group_started = FALSE;
	// Tracks total number of groups created
	protected $_group_count = 0;

	// storage for additional model paths for the autoloader
	protected static $model_paths = array();

	/**
	 * Constructors (both PHP4 and PHP5 style, to stay compatible)
	 *
	 * Initialize DataMapper.
	 * @param	int $id if provided, load in the object specified by that ID.
	 */
	public function __construct($id = NULL)
	{
		return $this->DataMapper($id);
	}

	public function DataMapper($id = NULL)
	{
		$this->_dmz_assign_libraries();

		$this_class = strtolower(get_class($this));
		$is_dmz = $this_class == 'datamapper';

		if($is_dmz)
		{
			$this->_load_languages();

			$this->_load_helpers();
		}

		// this is to ensure that singular is only called once per model
		if(isset(DataMapper::$common[DMZ_CLASSNAMES_KEY][$this_class])) {
			$common_key = DataMapper::$common[DMZ_CLASSNAMES_KEY][$this_class];
		} else {
			DataMapper::$common[DMZ_CLASSNAMES_KEY][$this_class] = $common_key = singular($this_class);
		}

		// Determine model name
		if (empty($this->model))
		{
			$this->model = $common_key;
		}

		// If model is 'datamapper' then this is the initial autoload by CodeIgniter
		if ($is_dmz)
		{
			// Load config settings
			$this->config->load('datamapper', TRUE, TRUE);

			// Get and store config settings
			DataMapper::$config = $this->config->item('datamapper');

			// now double check that all required config values were set
			foreach(DataMapper::$_dmz_config_defaults as $config_key => $config_value)
			{
				if( ! array_key_exists($config_key, DataMapper::$config))
				{
					DataMapper::$config[$config_key] = $config_value;
				}
			}

			DataMapper::_load_extensions(DataMapper::$global_extensions, DataMapper::$config['extensions']);
			unset(DataMapper::$config['extensions']);

			return;
		}

		// Load stored config settings by reference
		foreach (DataMapper::$config as $config_key => &$config_value)
		{
			// Only if they're not already set
			if ( ! property_exists($this, $config_key))
			{
				$this->{$config_key} = $config_value;
			}
		}

		// Load model settings if not in common storage
		if ( ! isset(DataMapper::$common[$common_key]))
		{
			// load language file, if requested and it exists
			if(!empty($this->lang_file_format))
			{
				$lang_file = str_replace(array('${model}', '${table}'), array($this->model, $this->table), $this->lang_file_format);
				$deft_lang = $this->config->item('language');
				$idiom = ($deft_lang == '') ? 'english' : $deft_lang;
				if(file_exists(APPPATH.'language/'.$idiom.'/'.$lang_file.'_lang'.EXT))
				{
					$this->lang->load($lang_file, $idiom);
				}
			}

			$loaded_from_cache = FALSE;

			// Load in the production cache for this model, if it exists
			if( ! empty(DataMapper::$config['production_cache']))
			{
				// check if it's a fully qualified path first
				if (!is_dir($cache_folder = DataMapper::$config['production_cache']))
				{
					// if not, it's relative to the application path
					$cache_folder = APPPATH . DataMapper::$config['production_cache'];
				}
				if(file_exists($cache_folder) && is_dir($cache_folder) && is_writeable($cache_folder))
				{
					$cache_file = $cache_folder . '/' . $common_key . EXT;
					if(file_exists($cache_file))
					{
						include($cache_file);
						if(isset($cache))
						{
							DataMapper::$common[$common_key] =& $cache;
							unset($cache);

							// allow subclasses to add initializations
							if(method_exists($this, 'post_model_init'))
							{
								$this->post_model_init(TRUE);
							}

							// Load extensions (they are not cacheable)
							$this->_initiate_local_extensions($common_key);

							$loaded_from_cache = TRUE;
						}
					}
				}
			}

			if(! $loaded_from_cache)
			{

				// Determine table name
				if (empty($this->table))
				{
					$this->table = strtolower(plural(get_class($this)));
				}

				// Add prefix to table
				$this->table = $this->prefix . $this->table;

				$this->_field_tracking = array(
					'get_rules' => array(),
					'matches' => array(),
					'intval' => array('id')
				);

				// Convert validation into associative array by field name
				$associative_validation = array();

				foreach ($this->validation as $name => $validation)
				{
					if(is_string($name)) {
						$validation['field'] = $name;
					} else {
						$name = $validation['field'];
					}

					// clean up possibly missing fields
					if( ! isset($validation['rules']))
					{
						$validation['rules'] = array();
					}

					// Populate associative validation array
					$associative_validation[$name] = $validation;

					if (!empty($validation['get_rules']))
					{
						$this->_field_tracking['get_rules'][] = $name;
					}

					// Check if there is a "matches" validation rule
					if (isset($validation['rules']['matches']))
					{
						$this->_field_tracking['matches'][$name] = $validation['rules']['matches'];
					}
				}

				// set up id column, if not set
				if(!isset($associative_validation['id']))
				{
					// label is set below, to prevent caching language-based labels
					$associative_validation['id'] = array(
						'field' => 'id',
						'rules' => array('integer')
					);
				}

				$this->validation = $associative_validation;

				// Force all other has_one ITFKs to integers on get
				foreach($this->has_one as $related => $rel_props)
				{
					$field = $related . '_id';
					if(	in_array($field, $this->fields) &&
						( ! isset($this->validation[$field]) || // does not have a validation key or...
							! isset($this->validation[$field]['get_rules'])) &&  // a get_rules key...
						( ! isset($this->validation[$related]) || // nor does the related have a validation key or...
							! isset($this->validation[$related]['get_rules'])) ) // a get_rules key
					{
						// assume an int
						$this->_field_tracking['intval'][] = $field;
					}
				}

				// Get and store the table's field names and meta data
				$fields = $this->db->field_data($this->table);

				// Store only the field names and ensure validation list includes all fields
				foreach ($fields as $field)
				{
					// Populate fields array
					$this->fields[] = $field->name;

					// Add validation if current field has none
					if ( ! isset($this->validation[$field->name]))
					{
						// label is set below, to prevent caching language-based labels
						$this->validation[$field->name] = array('field' => $field->name, 'rules' => array());
					}
				}

				// convert simple has_one and has_many arrays into more advanced ones
				foreach(array('has_one', 'has_many') as $arr)
				{
					foreach ($this->{$arr} as $related_field => $rel_props)
					{
						// process the relationship
						$this->_relationship($arr, $rel_props, $related_field);
					}
				}

				// allow subclasses to add initializations
				if(method_exists($this, 'post_model_init'))
				{
					$this->post_model_init(FALSE);
				}

				// Store common model settings
				foreach (array('table', 'fields', 'validation',
							'has_one', 'has_many', '_field_tracking') as $item)
				{
					DataMapper::$common[$common_key][$item] = $this->{$item};
				}

				// store the item to the production cache
				$this->production_cache();

				// Load extensions last, so they aren't cached.
				$this->_initiate_local_extensions($common_key);
			}

			// Finally, localize the labels here (because they shouldn't be cached
			// This also sets any missing labels.
			$validation =& DataMapper::$common[$common_key]['validation'];
			foreach($validation as $field => &$val)
			{
				// Localize label if necessary
				$val['label'] = $this->localize_label($field,
						isset($val['label']) ?
							$val['label'] :
							FALSE);
			}
			unset($validation);
		}

		// Load stored common model settings by reference
		foreach(DataMapper::$common[$common_key] as $key => &$value)
		{
			$this->{$key} = $value;
		}

		// Clear object properties to set at default values
		$this->clear();

		if( ! empty($id) && is_numeric($id))
		{
			$this->get_by_id(intval($id));
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Reloads in the configuration data for a model.  This is mainly
	 * used to handle language changes.  Only this instance and new instances
	 * will see the changes.
	 */
	public function reinitialize_model()
	{
		// this is to ensure that singular is only called once per model
		if(isset(DataMapper::$common[DMZ_CLASSNAMES_KEY][$this_class])) {
			$common_key = DataMapper::$common[DMZ_CLASSNAMES_KEY][$this_class];
		} else {
			DataMapper::$common[DMZ_CLASSNAMES_KEY][$this_class] = $common_key = singular($this_class);
		}
		unset(DataMapper::$common[$common_key]);
		$model = get_class($this);
		new $model(); // re-initialze

		// Load stored common model settings by reference
		foreach(DataMapper::$common[$common_key] as $key => &$value)
		{
			$this->{$key} =& $value;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Autoload
	 *
	 * Autoloads object classes that are used with DataMapper.
	 * This method will look in any model directories available to CI.
	 *
	 * Note:
	 * It is important that they are autoloaded as loading them manually with
	 * CodeIgniter's loader class will cause DataMapper's __get and __set functions
	 * to not function.
	 *
	 * @param	string $class Name of class to load.
	 */
	public static function autoload($class)
	{
		static $CI = NULL;

		// get the CI instance
		is_null($CI) AND $CI =& get_instance();

		// Don't attempt to autoload CI_ , EE_, or custom prefixed classes
		if (in_array(substr($class, 0, 3), array('CI_', 'EE_')) OR strpos($class, $CI->config->item('subclass_prefix')) === 0)
		{
			return;
		}

		// Prepare class
		$class = strtolower($class);

		// Prepare path
		$paths = array();
		if (method_exists($CI->load, 'get_package_paths'))
		{
			// use CI 2.0 loader's model paths
			$paths = $CI->load->get_package_paths(false);
		}

		foreach (array_merge(array(APPPATH),$paths, self::$model_paths) as $path)
		{
			// Prepare file
			$file = $path . 'models/' . $class . EXT;

			// Check if file exists, require_once if it does
			if (file_exists($file))
			{
				require_once($file);
				break;
			}
		}

		// if class not loaded, do a recursive search of model paths for the class
		if (! class_exists($class))
		{
			foreach($paths as $path)
			{
				$found = DataMapper::recursive_require_once($class, $path . 'models');
				if($found)
				{
					break;
				}
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Add Model Path
	 *
	 * Manually add paths for the model autoloader
	 *
	 * @param	mixed $paths path or array of paths to search
	 */
	public static function add_model_path($paths)
	{
		// make sure paths is an array
		is_array($paths) OR $paths = array($paths);

		foreach($paths as $path)
		{
			$path = rtrim($path, '/') . '/';
			if ( is_dir($path.'models') && ! in_array($path, self::$model_paths))
			{
				self::$model_paths[] = $path;
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Recursive Require Once
	 *
	 * Recursively searches the path for the class, require_once if found.
	 *
	 * @param	string $class Name of class to look for
	 * @param	string $path Current path to search
	 */
	protected static function recursive_require_once($class, $path)
	{
		$found = FALSE;
		if(is_dir($path))
		{
			$handle = opendir($path);
			if ($handle)
			{
				while (FALSE !== ($dir = readdir($handle)))
				{
					// If dir does not contain a dot
					if (strpos($dir, '.') === FALSE)
					{
						// Prepare recursive path
						$recursive_path = $path . '/' . $dir;

						// Prepare file
						$file = $recursive_path . '/' . $class . EXT;

						// Check if file exists, require_once if it does
						if (file_exists($file))
						{
							require_once($file);
							$found = TRUE;

							break;
						}
						else if (is_dir($recursive_path))
						{
							// Do a recursive search of the path for the class
							DataMapper::recursive_require_once($class, $recursive_path);
						}
					}
				}

				closedir($handle);
			}
		}
		return $found;
	}

	// --------------------------------------------------------------------

	/**
	 * Loads in any extensions used by this class or globally.
	 *
	 * @param	array $extensions List of extensions to add to.
	 * @param	array $name List of new extensions to load.
	 */
	protected static function _load_extensions(&$extensions, $names)
	{
		static $CI = NULL;

		// get the CI instance
		is_null($CI) AND $CI =& get_instance();

		$class_prefixes = array(
			0 => 'DMZ_',
			1 => 'DataMapper_',
			2 => $CI->config->item('subclass_prefix'),
			3 => 'CI_'
		);
		foreach($names as $name => $options)
		{
			if( ! is_string($name))
			{
				$name = $options;
				$options = NULL;
			}
			// only load an extension if it wasn't already loaded in this context
			if(isset($extensions[$name]))
			{
				return;
			}

			if( ! isset($extensions['_methods']))
			{
				$extensions['_methods'] = array();
			}

			// determine the file name and class name
			$file = DataMapper::$config['extensions_path'] . '/' . $name . EXT;

			if ( ! file_exists($file))
			{
				if(strpos($name, '/') === FALSE)
				{
					$file = APPPATH . DataMapper::$config['extensions_path'] . '/' . $name . EXT;
					$ext = $name;
				}
				else
				{
					$file = APPPATH . $name . EXT;
					$ext = array_pop(explode('/', $name));
				}

				if(!file_exists($file))
				{
					show_error('DataMapper Error: loading extension ' . $name . ': File not found.');
				}
			}
			else
			{
				$ext = $name;
			}

			// load class
			include_once($file);

			// Allow for DMZ_Extension, DataMapper_Extension, etc.
			foreach($class_prefixes as $index => $prefix)
			{
				if(class_exists($prefix.$ext))
				{
					if($index == 2) // "MY_"
					{
						// Load in the library this class is based on
						$CI->load->library($ext);
					}
					$ext = $prefix.$ext;
					break;
				}
			}
			if(!class_exists($ext))
			{
				show_error("DataMapper Error: Unable to find a class for extension $name.");
			}
			// create class
			if(is_null($options))
			{
				$o = new $ext(NULL, isset($this) ? $this : NULL);
			}
			else
			{
				$o = new $ext($options, isset($this) ? $this : NULL);
			}
			$extensions[$name] = $o;

			// figure out which methods can be called on this class.
			$methods = get_class_methods($ext);
			foreach($methods as $m)
			{
				// do not load private methods or methods already loaded.
				if($m[0] !== '_' &&
						is_callable(array($o, $m)) &&
						! isset($extensions['_methods'][$m])
						) {
					// store this method.
					$extensions['_methods'][$m] = $name;
				}
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Loads the extensions that are local to this model.
	 * @param	string $common_key Shared key to save extenions to.
	 */
	private function _initiate_local_extensions($common_key)
	{
		if(!empty($this->extensions))
		{
			$extensions = $this->extensions;
			$this->extensions = array();
			DataMapper::_load_extensions($this->extensions, $extensions);
		}
		else
		{
			// ensure an empty array
			$this->extensions = array('_methods' => array());
		}
		// bind to the shared key, for dynamic loading
		DataMapper::$common[$common_key]['extensions'] =& $this->extensions;
	}

	// --------------------------------------------------------------------

	/**
	 * Dynamically load an extension when needed.
	 * @param	object $name Name of the extension (or array of extensions).
	 * @param	array $options Options for the extension
	 * @param	boolean $local If TRUE, only loads the extension into this object
	 */
	public function load_extension($name, $options = NULL, $local = FALSE)
	{
		if( ! is_array($name))
		{
			if( ! is_null($options))
			{
				$name = array($name => $options);
			}
			else
			{
				$name = array($name);
			}
		}
		// called individually to ensure that the array is modified directly
		// (and not copied instead)
		if($local)
		{
			DataMapper::_load_extensions($this->extensions, $name);
		}
		else
		{
			DataMapper::_load_extensions(DataMapper::$global_extensions, $name);
		}

	}

	// --------------------------------------------------------------------


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *																   *
	 * Magic methods													 *
	 *																   *
	 * The following are methods to override the default PHP behaviour.  *
	 *																   *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	// --------------------------------------------------------------------

	/**
	 * Magic Get
	 *
	 * Returns the value of the named property.
	 * If named property is a related item, instantiate it first.
	 *
	 * This method also instantiates the DB object and the form_validation
	 * objects as necessary
	 *
	 * @ignore
	 * @param	string $name Name of property to look for
	 * @return	mixed
	 */
	public function __get($name)
	{
		static $CI = NULL;

		// get the CI instance
		is_null($CI) AND $CI =& get_instance();

		// We dynamically get DB when needed, and create a copy.
		// This allows multiple queries to be generated at the same time.
		if($name == 'db')
		{
			if($this->db_params === FALSE)
			{
				if ( ! isset($CI->db) || ! is_object($CI->db) || ! isset($CI->db->dbdriver) )
				{
					show_error('DataMapper Error: CodeIgniter database library not loaded.');
				}
				$this->db =& $CI->db;
			}
			else
			{
				if($this->db_params == '' || $this->db_params === TRUE)
				{
					if ( ! isset($CI->db) || ! is_object($CI->db) || ! isset($CI->db->dbdriver) )
					{
						show_error('DataMapper Error: CodeIgniter database library not loaded.');
					}
					// ensure the shared DB is disconnected, even if the app exits uncleanly
					if(!isset($CI->db->_has_shutdown_hook))
					{
						register_shutdown_function(array($CI->db, 'close'));
						$CI->db->_has_shutdown_hook = TRUE;
					}
					// clone, so we don't create additional connections to the DB
					$this->db = clone($CI->db);
					$this->db->dm_call_method('_reset_select');
				}
				else
				{
					// connecting to a different database, so we *must* create additional copies.
					// It is up to the developer to close the connection!
					$this->db = $CI->load->database($this->db_params, TRUE, TRUE);
				}
				// these items are shared (for debugging)
				if(is_object($CI->db) && isset($CI->db->dbdriver))
				{
					$this->db->queries =& $CI->db->queries;
					$this->db->query_times =& $CI->db->query_times;
				}
			}
			// ensure the created DB is disconnected, even if the app exits uncleanly
			if(!isset($this->db->_has_shutdown_hook))
			{
				register_shutdown_function(array($this->db, 'close'));
				$this->db->_has_shutdown_hook = TRUE;
			}
			return $this->db;
		}

		// Special case to get form_validation when first accessed
		if($name == 'form_validation')
		{
			if ( ! isset($this->form_validation) )
			{
				if( ! isset($CI->form_validation))
				{
					$CI->load->library('form_validation');
					$this->lang->load('form_validation');
				}
				$this->form_validation =& $CI->form_validation;
			}
			return $this->form_validation;
		}

		$has_many = isset($this->has_many[$name]);
		$has_one = isset($this->has_one[$name]);

		// If named property is a "has many" or "has one" related item
		if ($has_many || $has_one)
		{
			$related_properties = $has_many ? $this->has_many[$name] : $this->has_one[$name];
			// Instantiate it before accessing
			$class = $related_properties['class'];
			$this->{$name} = new $class();

			// Store parent data
			$this->{$name}->parent = array('model' => $related_properties['other_field'], 'id' => $this->id);

			// Check if Auto Populate for "has many" or "has one" is on
			// (but only if this object exists in the DB, and we aren't instantiating)
			if ($this->exists() &&
					($has_many && ($this->auto_populate_has_many || $this->has_many[$name]['auto_populate'])) || ($has_one && ($this->auto_populate_has_one || $this->has_one[$name]['auto_populate'])))
			{
				$this->{$name}->get();
			}

			return $this->{$name};
		}

		$name_single = singular($name);
		if($name_single !== $name) {
			// possibly return single form of name
			$test = $this->{$name_single};
			if(is_object($test)) {
				return $test;
			}
		}

		return NULL;
	}

	// --------------------------------------------------------------------

	/**
	 * Used several places to temporarily override the auto_populate setting
	 * @ignore
	 * @param string $related Related Name
	 * @return DataMapper|NULL
	 */
	private function &_get_without_auto_populating($related)
	{
		$b_many = $this->auto_populate_has_many;
		$b_one = $this->auto_populate_has_one;
		$this->auto_populate_has_many = FALSE;
		$this->auto_populate_has_one = FALSE;
		$ret =& $this->{$related};
		$this->auto_populate_has_many = $b_many;
		$this->auto_populate_has_one = $b_one;
		return $ret;
	}

	// --------------------------------------------------------------------

	/**
	 * Magic Call
	 *
	 * Calls special methods, or extension methods.
	 *
	 * @ignore
	 * @param	string $method Method name
	 * @param	array $arguments Arguments to method
	 * @return	mixed
	 */
	public function __call($method, $arguments)
	{
		// List of watched method names
		// NOTE: order matters: make sure more specific items are listed before
		// less specific items
		static $watched_methods = array(
			'save_', 'delete_',
			'get_by_related_', 'get_by_related', 'get_by_',
			'_related_subquery', '_subquery',
			'_related_', '_related',
			'_join_field',
			'_field_func', '_func'
		);

		$ext = NULL;

		// attempt to call an extension first
		if($this->_extension_method_exists($method, 'local'))
		{
			$name = $this->extensions['_methods'][$method];
			$ext = $this->extensions[$name];
		}
		elseif($this->_extension_method_exists($method, 'global'))
		{
			$name = DataMapper::$global_extensions['_methods'][$method];
			$ext = DataMapper::$global_extensions[$name];
		}
		else
		{
			foreach ($watched_methods as $watched_method)
			{
				// See if called method is a watched method
				if (strpos($method, $watched_method) !== FALSE)
				{
					$pieces = explode($watched_method, $method);
					if ( ! empty($pieces[0]) && ! empty($pieces[1]))
					{
						// Watched method is in the middle
						return $this->{'_' . trim($watched_method, '_')}($pieces[0], array_merge(array($pieces[1]), $arguments));
					}
					else
					{
						// Watched method is a prefix or suffix
						return $this->{'_' . trim($watched_method, '_')}(str_replace($watched_method, '', $method), $arguments);
					}
				}
			}
		}

		if( ! is_null($ext))
		{
			array_unshift($arguments, $this);
			return call_user_func_array(array($ext, $method), $arguments);
		}

		// show an error, for debugging's sake.
		throw new Exception("Unable to call the method \"$method\" on the class " . get_class($this));
	}

	// --------------------------------------------------------------------

	/**
	 * Returns TRUE or FALSE if the method exists in the extensions.
	 *
	 * @param	object $method Method to look for.
	 * @param	object $which One of 'both', 'local', or 'global'
	 * @return	bool TRUE if the method can be called.
	 */
	private function _extension_method_exists($method, $which = 'both') {
		$found = FALSE;
		if($which != 'global') {
			$found =  ! empty($this->extensions) && isset($this->extensions['_methods'][$method]);
		}
		if( ! $found && $which != 'local' ) {
			$found =  ! empty(DataMapper::$global_extensions) && isset(DataMapper::$global_extensions['_methods'][$method]);
		}
		return $found;
	}

	// --------------------------------------------------------------------

	/**
	 * Magic Clone
	 *
	 * Allows for a less shallow clone than the default PHP clone.
	 *
	 * @ignore
	 */
	public function __clone()
	{
		foreach ($this as $key => $value)
		{
			if (is_object($value) && $key != 'db')
			{
				$this->{$key} = clone($value);
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * To String
	 *
	 * Converts the current object into a string.
	 * Should be overridden by extended objects.
	 *
	 * @return	string
	 */
	public function __toString()
	{
		return ucfirst($this->model);
	}

	// --------------------------------------------------------------------

	/**
	 * Allows the all array to be iterated over without
	 * having to specify it.
	 *
	 * @return	Iterator An iterator for the all array
	 */
	public function getIterator() {
		if(isset($this->_dm_dataset_iterator)) {
			return $this->_dm_dataset_iterator;
		} else {
			return new ArrayIterator($this->all);
		}
	}

	// --------------------------------------------------------------------


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *																   *
	 * Main methods													  *
	 *																   *
	 * The following are methods that form the main					  *
	 * functionality of DataMapper.									  *
	 *																   *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


	// --------------------------------------------------------------------

	/**
	 * Get
	 *
	 * Get objects from the database.
	 *
	 * @param	integer|NULL $limit Limit the number of results.
	 * @param	integer|NULL $offset Offset the results when limiting.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function get($limit = NULL, $offset = NULL)
	{

		// Check if this is a related object and if so, perform a related get
		if (! $this->_handle_related())
		{
			// invalid get request, return this for chaining.
			return $this;
		} // Else fall through to a normal get

		$query = FALSE;

		// Check if object has been validated (skipped for related items)
		if ($this->_validated && empty($this->parent))
		{
			// Reset validated
			$this->_validated = FALSE;

			// Use this objects properties
			$data = $this->_to_array(TRUE);

			if ( ! empty($data))
			{
				// Clear this object to make way for new data
				$this->clear();

				// Set up default order by (if available)
				$this->_handle_default_order_by();

				// Get by objects properties
				$query = $this->db->get_where($this->table, $data, $limit, $offset);
			} // FIXME: notify user if nothing was set?
		}
		else
		{
			// Clear this object to make way for new data
			$this->clear();

			// Set up default order by (if available)
			$this->_handle_default_order_by();

			// Get by built up query
			$query = $this->db->get($this->table, $limit, $offset);
		}

		// Convert the query result into DataMapper objects
		if($query)
		{
			$this->_process_query($query);
		}

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the SQL string of the current query (SELECTs ONLY).
	 * NOTE: This also _clears_ the current query info.
	 *
	 * This can be used to generate subqueries.
	 *
	 * @param	integer|NULL $limit Limit the number of results.
	 * @param	integer|NULL $offset Offset the results when limiting.
	 * @return	string SQL as a string.
	 */
	public function get_sql($limit = NULL, $offset = NULL, $handle_related = FALSE)
	{
		if($handle_related) {
			$this->_handle_related();
		}

		$this->db->dm_call_method('_track_aliases', $this->table);
		$this->db->from($this->table);

		$this->_handle_default_order_by();

		if ( ! is_null($limit))
		{
			$this->limit($limit, $offset);
		}

		$sql = $this->db->dm_call_method('_compile_select');
		$this->_clear_after_query();
		return $sql;
	}

	// --------------------------------------------------------------------

	/**
	 * Runs the query, but returns the raw CodeIgniter results
	 * NOTE: This also _clears_ the current query info.
	 *
	 * @param	integer|NULL $limit Limit the number of results.
	 * @param	integer|NULL $offset Offset the results when limiting.
	 * @return	CI_DB_result Result Object
	 */
	public function get_raw($limit = NULL, $offset = NULL, $handle_related = TRUE)
	{
		if($handle_related) {
			$this->_handle_related();
		}

		$this->_handle_default_order_by();

		$query = $this->db->get($this->table, $limit, $offset);
		$this->_clear_after_query();
		return $query;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns a streamable result set for large queries.
	 * Usage:
	 * $rs = $object->get_iterated();
	 * $size = $rs->count;
	 * foreach($rs as $o) {
	 *	 // handle $o
	 * }
	 * $rs can be looped through more than once.
	 *
	 * @param	integer|NULL $limit Limit the number of results.
	 * @param	integer|NULL $offset Offset the results when limiting.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function get_iterated($limit = NULL, $offset = NULL)
	{
		// clone $this, so we keep track of instantiations, etc.
		// because these are cleared after the call to get_raw
		$object = $this->get_clone();
		// need to clear query from the clone
		$object->db->dm_call_method('_reset_select');
		// Clear the query related list from the clone
		$object->_query_related = array();

		// Build iterator
		$this->_dm_dataset_iterator = new DM_DatasetIterator($object, $this->get_raw($limit, $offset, TRUE));
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Convenience method that runs a query based on pages.
	 * This object will have two new values, $query_total_pages and
	 * $query_total_rows, which can be used to determine how many pages and
	 * how many rows are available in total, respectively.
	 *
	 * @param	int $page Page (1-based) to start on, or row (0-based) to start on
	 * @param	int $page_size Number of rows in a page
	 * @param	bool $page_num_by_rows When TRUE, $page is the starting row, not the starting page
	 * @param	bool $iterated Internal Use Only
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function get_paged($page = 1, $page_size = 50, $page_num_by_rows = FALSE, $info_object = 'paged', $iterated = FALSE)
	{
		// first, duplicate this query, so we have a copy for the query
		$count_query = $this->get_clone(TRUE);

		if($page_num_by_rows)
		{
			$page = 1 + floor(intval($page) / $page_size);
		}

		// never less than 1
		$page = max(1, intval($page));
		$offset = $page_size * ($page - 1);

		// for performance, we clear out the select AND the order by statements,
		// since they aren't necessary and might slow down the query.
		$count_query->db->ar_select = NULL;
		$count_query->db->ar_orderby = NULL;
		$total = $count_query->db->ar_distinct ? $count_query->count_distinct() : $count_query->count();

		// common vars
		$last_row = $page_size * floor($total / $page_size);
		$total_pages = ceil($total / $page_size);

		if($offset >= $last_row)
		{
			// too far!
			$offset = $last_row;
			$page = $total_pages;
		}

		// now query this object
		if($iterated)
		{
			$this->get_iterated($page_size, $offset);
		}
		else
		{
			$this->get($page_size, $offset);
		}

		$this->{$info_object} = new stdClass();

		$this->{$info_object}->page_size = $page_size;
		$this->{$info_object}->items_on_page = $this->result_count();
		$this->{$info_object}->current_page = $page;
		$this->{$info_object}->current_row = $offset;
		$this->{$info_object}->total_rows = $total;
		$this->{$info_object}->last_row = $last_row;
		$this->{$info_object}->total_pages = $total_pages;
		$this->{$info_object}->has_previous = $offset > 0;
		$this->{$info_object}->previous_page = max(1, $page-1);
		$this->{$info_object}->previous_row = max(0, $offset-$page_size);
		$this->{$info_object}->has_next = $page < $total_pages;
		$this->{$info_object}->next_page = min($total_pages, $page+1);
		$this->{$info_object}->next_row = min($last_row, $offset+$page_size);

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Runs get_paged, but as an Iterable.
	 *
	 * @see get_paged
	 * @param	int $page Page (1-based) to start on, or row (0-based) to start on
	 * @param	int $page_size Number of rows in a page
	 * @param	bool $page_num_by_rows When TRUE, $page is the starting row, not the starting page
	 * @param	bool $iterated Internal Use Only
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function get_paged_iterated($page = 1, $page_size = 50, $page_num_by_rows = FALSE, $info_object = 'paged')
	{
		return $this->get_paged($page, $page_size, $page_num_by_rows, $info_object, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Forces this object to be INSERTed, even if it has an ID.
	 *
	 * @param	mixed $object  See save.
	 * @param	string $related_field See save.
	 * @return	bool Result of the save.
	 */
	public function save_as_new($object = '', $related_field = '')
	{
		$this->_force_save_as_new = TRUE;
		return $this->save($object, $related_field);
	}

	// --------------------------------------------------------------------

	/**
	 * Save
	 *
	 * Saves the current record, if it validates.
	 * If object is supplied, saves relations between this object and the supplied object(s).
	 *
	 * @param	mixed $object Optional object to save or array of objects to save.
	 * @param	string $related_field Optional string to save the object as a specific relationship.
	 * @return	bool Success or Failure of the validation and save.
	 */
	public function save($object = '', $related_field = '')
	{
		// Temporarily store the success/failure
		$result = array();

		// Validate this objects properties
		$this->validate($object, $related_field);

		// If validation passed
		if ($this->valid)
		{

			// Begin auto transaction
			$this->_auto_trans_begin();

			$trans_complete_label = array();

			// Get current timestamp
			$timestamp = $this->_get_generated_timestamp();

			// Check if object has a 'created' field, and it is not already set
			if (in_array($this->created_field, $this->fields) && empty($this->{$this->created_field}))
			{
				$this->{$this->created_field} = $timestamp;
			}

			// SmartSave: if there are objects being saved, and they are stored
			// as in-table foreign keys, we can save them at this step.
			if( ! empty($object))
			{
				if( ! is_array($object))
				{
					$object = array($object);
				}
				$this->_save_itfk($object, $related_field);
			}

			// Convert this object to array
			$data = $this->_to_array();

			if ( ! empty($data))
			{
				if ( ! $this->_force_save_as_new && ! empty($data['id']))
				{
					// Prepare data to send only changed fields
					foreach ($data as $field => $value)
					{
						// Unset field from data if it hasn't been changed
						if ($this->{$field} === $this->stored->{$field})
						{
							unset($data[$field]);
						}
					}

					// if there are changes, check if we need to update the update timestamp
					if (count($data) && in_array($this->updated_field, $this->fields) && ! isset($data[$this->updated_field]))
					{
						// update it now
						$data[$this->updated_field] = $this->{$this->updated_field} = $timestamp;
					}

					// Only go ahead with save if there is still data
					if ( ! empty($data))
					{
						// Update existing record
						$this->db->where('id', $this->id);
						$this->db->update($this->table, $data);

						$trans_complete_label[] = 'update';
					}

					// Reset validated
					$this->_validated = FALSE;

					$result[] = TRUE;
				}
				else
				{
					// Prepare data to send only populated fields
					foreach ($data as $field => $value)
					{
						// Unset field from data
						if ( ! isset($value))
						{
							unset($data[$field]);
						}
					}

					// Create new record
					$this->db->insert($this->table, $data);

					if( ! $this->_force_save_as_new)
					{
						// Assign new ID
						$this->id = $this->db->insert_id();
					}

					$trans_complete_label[] = 'insert';

					// Reset validated
					$this->_validated = FALSE;

					$result[] = TRUE;
				}
			}

			$this->_refresh_stored_values();

			// Check if a relationship is being saved
			if ( ! empty($object))
			{
				// save recursively
				$this->_save_related_recursive($object, $related_field);

				$trans_complete_label[] = 'relationships';
			}

			if(!empty($trans_complete_label))
			{
				$trans_complete_label = 'save (' . implode(', ', $trans_complete_label) . ')';
			}
			else
			{
				$trans_complete_label = '-nothing done-';
			}

			$this->_auto_trans_complete($trans_complete_label);

		}

		$this->_force_save_as_new = FALSE;

		// If no failure was recorded, return TRUE
		return ( ! empty($result) && ! in_array(FALSE, $result));
	}

	// --------------------------------------------------------------------

	/**
	 * Recursively saves arrays of objects if they are In-Table Foreign Keys.
	 * @ignore
	 * @param	object $objects Objects to save.  This array may be modified.
	 * @param	object $related_field Related Field name (empty is OK)
	 */
	protected function _save_itfk( &$objects, $related_field)
	{
		foreach($objects as $index => $o)
		{
			if(is_int($index))
			{
				$rf = $related_field;
			}
			else
			{
				$rf = $index;
			}
			if(is_array($o))
			{
				$this->_save_itfk($o, $rf);
				if(empty($o))
				{
					unset($objects[$index]);
				}
			}
			else
			{
				if(empty($rf)) {
					$rf = $o->model;
				}
				$related_properties = $this->_get_related_properties($rf);
				$other_column = $related_properties['join_other_as'] . '_id';
				if(isset($this->has_one[$rf]) && in_array($other_column, $this->fields))
				{
					// unset, so that it doesn't get re-saved later.
					unset($objects[$index]);

					if($this->{$other_column} != $o->id)
					{
						// ITFK: store on the table
						$this->{$other_column} = $o->id;

						// Remove reverse relationships for one-to-ones
						$this->_remove_other_one_to_one($rf, $o);
					}
				}
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Recursively saves arrays of objects.
	 *
	 * @ignore
	 * @param	object $object Array of objects to save, or single object
	 * @param	object $related_field Default related field name (empty is OK)
	 * @return	bool TRUE or FALSE if an error occurred.
	 */
	protected function _save_related_recursive($object, $related_field)
	{
		if(is_array($object))
		{
			$success = TRUE;
			foreach($object as $rk => $o)
			{
				if(is_int($rk))
				{
					$rk = $related_field;
				}
				$rec_success = $this->_save_related_recursive($o, $rk);
				$success = $success && $rec_success;
			}
			return $success;
		}
		else
		{
			return $this->_save_relation($object, $related_field);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * _Save
	 *
	 * Used by __call to process related saves.
	 *
	 * @ignore
	 * @param	mixed $related_field
	 * @param	array $arguments
	 * @return	bool
	 */
	private function _save($related_field, $arguments)
	{
		return $this->save($arguments[0], $related_field);
	}

	// --------------------------------------------------------------------

	/**
	 * Update
	 *
	 * Allows updating of more than one row at once.
	 *
	 * @param	object $field A field to update, or an array of fields => values
	 * @param	object $value The new value
	 * @param	object $escape_values  If false, don't escape the values
	 * @return	bool TRUE or FALSE on success or failure
	 */
	public function update($field, $value = NULL, $escape_values = TRUE)
	{
		if( ! is_array($field))
		{
			$field = array($field => $value);
		}
		else if($value === FALSE)
		{
				$escape_values = FALSE;
		}
		if(empty($field))
		{
			show_error("Nothing was provided to update.");
		}

		// Check if object has an 'updated' field
		if (in_array($this->updated_field, $this->fields))
		{
			$timestamp = $this->_get_generated_timestamp();
			if( ! $escape_values)
			{
				$timestamp = $this->db->escape($timestamp);
			}
			// Update updated datetime
			$field[$this->updated_field] = $timestamp;
		}

		foreach($field as $k => $v)
		{
			if( ! $escape_values)
			{
				// attempt to add the table name
				$v = $this->add_table_name($v);
			}
			$this->db->set($k, $v, $escape_values);
		}
		return $this->db->update($this->table);
	}

	// --------------------------------------------------------------------

	/**
	 * Update All
	 *
	 * Updates all items that are in the all array.
	 *
	 * @param	object $field A field to update, or an array of fields => values
	 * @param	object $value The new value
	 * @param	object $escape_values  If false, don't escape the values
	 * @return	bool TRUE or FALSE on success or failure
	 */
	public function update_all($field, $value = NULL, $escape_values = TRUE)
	{
		$ids = array();
		foreach($this->all as $object)
		{
			$ids[] = $object->id;
		}
		if(empty($ids))
		{
			return FALSE;
		}

		$this->where_in('id', $ids);
		return $this->update($field, $value, $escape_values);
	}

	// --------------------------------------------------------------------

	/**
	 * Gets a timestamp to use when saving.
	 * @return mixed
	 */
	private function _get_generated_timestamp()
	{
		// Get current timestamp
		$timestamp = ($this->local_time) ? date($this->timestamp_format) : gmdate($this->timestamp_format);

		// Check if unix timestamp
		return ($this->unix_timestamp) ? strtotime($timestamp) : $timestamp;
	}

	// --------------------------------------------------------------------

	/**
	 * Delete
	 *
	 * Deletes the current record.
	 * If object is supplied, deletes relations between this object and the supplied object(s).
	 *
	 * @param	mixed $object If specified, delete the relationship to the object or array of objects.
	 * @param	string $related_field Can be used to specify which relationship to delete.
	 * @return	bool Success or Failure of the delete.
	 */
	public function delete($object = '', $related_field = '')
	{
		if (empty($object) && ! is_array($object))
		{
			if ( ! empty($this->id))
			{
				// Begin auto transaction
				$this->_auto_trans_begin();

				// Delete all "has many" and "has one" relations for this object first
				foreach (array('has_many', 'has_one') as $type)
				{
					foreach ($this->{$type} as $model => $properties)
					{
						// do we want cascading delete's?
						if ($properties['cascade_delete'])
						{
							// Prepare model
							$class = $properties['class'];
							$object = new $class();

							$this_model = $properties['join_self_as'];
							$other_model = $properties['join_other_as'];

							// Determine relationship table name
							$relationship_table = $this->_get_relationship_table($object, $model);

							// We have to just set NULL for in-table foreign keys that
							// are pointing at this object
							if($relationship_table == $object->table  && // ITFK
									 // NOT ITFKs that point at the other object
									 ! ($object->table == $this->table && // self-referencing has_one join
										in_array($other_model . '_id', $this->fields)) // where the ITFK is for the other object
									)
							{
								$data = array($this_model . '_id' => NULL);

								// Update table to remove relationships
								$this->db->where($this_model . '_id', $this->id);
								$this->db->update($object->table, $data);
							}
							else if ($relationship_table != $this->table)
							{

								$data = array($this_model . '_id' => $this->id);

								// Delete relation
								$this->db->delete($relationship_table, $data);
							}
							// Else, no reason to delete the relationships on this table
						}
					}
				}

				// Delete the object itself
				$this->db->where('id', $this->id);
				$this->db->delete($this->table);

				// Complete auto transaction
				$this->_auto_trans_complete('delete');

				// Clear this object
				$this->clear();

				return TRUE;
			}
		}
		else if (is_array($object))
		{
			// Begin auto transaction
			$this->_auto_trans_begin();

			// Temporarily store the success/failure
			$result = array();

			foreach ($object as $rel_field => $obj)
			{
				if (is_int($rel_field))
				{
					$rel_field = $related_field;
				}
				if (is_array($obj))
				{
					foreach ($obj as $r_f => $o)
					{
						if (is_int($r_f))
						{
							$r_f = $rel_field;
						}
						$result[] = $this->_delete_relation($o, $r_f);
					}
				}
				else
				{
					$result[] = $this->_delete_relation($obj, $rel_field);
				}
			}

			// Complete auto transaction
			$this->_auto_trans_complete('delete (relationship)');

			// If no failure was recorded, return TRUE
			if ( ! in_array(FALSE, $result))
			{
				return TRUE;
			}
		}
		else
		{
			// Begin auto transaction
			$this->_auto_trans_begin();

			// Temporarily store the success/failure
			$result = $this->_delete_relation($object, $related_field);

			// Complete auto transaction
			$this->_auto_trans_complete('delete (relationship)');

			return $result;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * _Delete
	 *
	 * Used by __call to process related deletes.
	 *
	 * @ignore
	 * @param	string $related_field
	 * @param	array $arguments
	 * @return	bool
	 */
	private function _delete($related_field, $arguments)
	{
		return $this->delete($arguments[0], $related_field);
	}

	// --------------------------------------------------------------------

	/**
	 * Delete All
	 *
	 * Deletes all records in this objects all list.
	 *
	 * @return	bool Success or Failure of the delete
	 */
	public function delete_all()
	{
		$success = TRUE;
		foreach($this as $item)
		{
			if ( ! empty($item->id))
			{
				$success_temp = $item->delete();
				$success = $success && $success_temp;
			}
		}
		$this->clear();
		return $success;
	}

	// --------------------------------------------------------------------

	/**
	 * Truncate
	 *
	 * Deletes all records in this objects table.
	 *
	 * @return	bool Success or Failure of the truncate
	 */
	public function truncate()
	{
		// Begin auto transaction
		$this->_auto_trans_begin();

		// Delete all "has many" and "has one" relations for this object first
		foreach (array('has_many', 'has_one') as $type)
		{
			foreach ($this->{$type} as $model => $properties)
			{
				// do we want cascading delete's?
				if ($properties['cascade_delete'])
				{
					// Prepare model
					$class = $properties['class'];
					$object = new $class();

					$this_model = $properties['join_self_as'];
					$other_model = $properties['join_other_as'];

					// Determine relationship table name
					$relationship_table = $this->_get_relationship_table($object, $model);

					// We have to just set NULL for in-table foreign keys that
					// are pointing at this object
					if($relationship_table == $object->table  && // ITFK
							 // NOT ITFKs that point at the other object
							 ! ($object->table == $this->table && // self-referencing has_one join
								in_array($other_model . '_id', $this->fields)) // where the ITFK is for the other object
							)
					{
						$data = array($this_model . '_id' => NULL);

						// Update table to remove all ITFK relations
						$this->db->update($object->table, $data);
					}
					else if ($relationship_table != $this->table)
					{
						// Delete all relationship records
						$this->db->truncate($relationship_table);
					}
					// Else, no reason to delete the relationships on this table
				}
			}
		}

		// Delete all records
		$this->db->truncate($this->table);

		// Complete auto transaction
		$this->_auto_trans_complete('truncate');

		// Clear this object
		$this->clear();

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Refresh All
	 *
	 * Removes any empty objects in this objects all list.
	 * Only needs to be used if you are looping through the all list
	 * a second time and you have deleted a record the first time through.
	 *
	 * @return	bool FALSE if the $all array was already empty.
	 */
	public function refresh_all()
	{
		if ( ! empty($this->all))
		{
			$all = array();

			foreach ($this->all as $item)
			{
				if ( ! empty($item->id))
				{
					$all[] = $item;
				}
			}

			$this->all = $all;

			return TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Validate
	 *
	 * Validates the value of each property against the assigned validation rules.
	 *
	 * @param	mixed $object Objects included with the validation [from save()].
	 * @param	string $related_field See save.
	 * @return	DataMapper Returns $this for method chanining.
	 */
	public function validate($object = '', $related_field = '')
	{
		// Return if validation has already been run
		if ($this->_validated)
		{
			// For method chaining
			return $this;
		}

		// Set validated as having been run
		$this->_validated = TRUE;

		// Clear errors
		$this->error = new DM_Error_Object();

		// Loop through each property to be validated
		foreach ($this->validation as $field => $validation)
		{
			if(empty($validation['rules']))
			{
				continue;
			}

			// Get validation settings
			$rules = $validation['rules'];

			// Will validate differently if this is for a related item
			$related = (isset($this->has_many[$field]) || isset($this->has_one[$field]));

			// Check if property has changed since validate last ran
			if ($related || $this->_force_validation || ! isset($this->stored->{$field}) || $this->{$field} !== $this->stored->{$field})
			{
				// Only validate if field is related or required or has a value
				if ( ! $related && ! in_array('required', $rules) && ! in_array('always_validate', $rules))
				{
					if ( ! isset($this->{$field}) || $this->{$field} === '')
					{
						continue;
					}
				}

				$label = ( ! empty($validation['label'])) ? $validation['label'] : $field;

				// Loop through each rule to validate this property against
				foreach ($rules as $rule => $param)
				{
					// Check for parameter
					if (is_numeric($rule))
					{
						$rule = $param;
						$param = '';
					}

					// Clear result
					$result = '';
					// Clear message
					$line = FALSE;

					// Check rule exists
					if ($related)
					{
						// Prepare rule to use different language file lines
						$rule = 'related_' . $rule;

						$arg = $object;
						if( ! empty($related_field)) {
							$arg = array($related_field => $object);
						}

						if (method_exists($this, '_' . $rule))
						{
							// Run related rule from DataMapper or the class extending DataMapper
							$line = $result = $this->{'_' . $rule}($arg, $field, $param);
						}
						else if($this->_extension_method_exists('rule_' . $rule))
						{
							$line = $result = $this->{'rule_' . $rule}($arg, $field, $param);
						}
					}
					else if (method_exists($this, '_' . $rule))
					{
						// Run rule from DataMapper or the class extending DataMapper
						$line = $result = $this->{'_' . $rule}($field, $param);
					}
					else if($this->_extension_method_exists('rule_' . $rule))
					{
						// Run an extension-based rule.
						$line = $result = $this->{'rule_' . $rule}($field, $param);
					}
					else if (method_exists($this->form_validation, $rule))
					{
						// Run rule from CI Form Validation
						$result = $this->form_validation->{$rule}($this->{$field}, $param);
					}
					else if (function_exists($rule))
					{
						// Run rule from PHP
						$this->{$field} = $rule($this->{$field});
					}

					// Add an error message if the rule returned FALSE
					if (is_string($line) || $result === FALSE)
					{
						if(!is_string($line))
						{
							if (FALSE === ($line = $this->lang->line($rule)))
							{
								// Get corresponding error from language file
								$line = 'Unable to access an error message corresponding to your rule name: '.$rule.'.';
							}
						}

						// Check if param is an array
						if (is_array($param))
						{
							// Convert into a string so it can be used in the error message
							$param = implode(', ', $param);

							// Replace last ", " with " or "
							if (FALSE !== ($pos = strrpos($param, ', ')))
							{
								$param = substr_replace($param, ' or ', $pos, 2);
							}
						}

						// Check if param is a validation field
						if (isset($this->validation[$param]))
						{
							// Change it to the label value
							$param = $this->validation[$param]['label'];
						}

						// Add error message
						$this->error_message($field, sprintf($line, $label, $param));

						// Escape to prevent further error checks
						break;
					}
				}
			}
		}

		// Set whether validation passed
		$this->valid = empty($this->error->all);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Skips validation for the next call to save.
	 * Note that this also prevents the validation routine from running until the next get.
	 *
	 * @param	object $skip If FALSE, re-enables validation.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function skip_validation($skip = TRUE)
	{
		$this->_validated = $skip;
		$this->valid = $skip;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Force revalidation for the next call to save.
	 * This allows you to run validation rules on fields that haven't been modified
	 *
	 * @param	object $force If TRUE, forces validation on all fields.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function force_validation($force = TRUE)
	{
		$this->_force_validation = $force;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Clear
	 *
	 * Clears the current object.
	 */
	public function clear()
	{
		// Clear the all list
		$this->all = array();

		// Clear errors
		$this->error = new DM_Error_Object();

		// Clear this objects properties and set blank error messages in case they are accessed
		foreach ($this->fields as $field)
		{
			$this->{$field} = NULL;
		}

		// Clear this objects "has many" related objects
		foreach ($this->has_many as $related => $properties)
		{
			unset($this->{$related});
		}

		// Clear this objects "has one" related objects
		foreach ($this->has_one as $related => $properties)
		{
			unset($this->{$related});
		}

		// Clear the query related list
		$this->_query_related = array();

		// Clear and refresh stored values
		$this->stored = new stdClass();

		// Clear the saved iterator
		unset($this->_dm_dataset_iterator);

		$this->_refresh_stored_values();
	}

	// --------------------------------------------------------------------

	/**
	 * Clears the db object after processing a query, or returning the
	 * SQL for a query.
	 *
	 * @ignore
	 */
	protected function _clear_after_query()
	{
		// clear the query as if it was run
		$this->db->dm_call_method('_reset_select');

		// in case some include_related instantiations were set up, clear them
		$this->_instantiations = NULL;

		// Clear the query related list (Thanks to TheJim)
		$this->_query_related = array();

		// Clear the saved iterator
		unset($this->_dm_dataset_iterator);
	}

	// --------------------------------------------------------------------

	/**
	 * Count
	 *
	 * Returns the total count of the object records from the database.
	 * If on a related object, returns the total count of related objects records.
	 *
	 * @param	array $exclude_ids A list of ids to exlcude from the count
	 * @return	int Number of rows in query.
	 */
	public function count($exclude_ids = NULL, $column = NULL, $related_id = NULL)
	{
		// Check if related object
		if ( ! empty($this->parent))
		{
			// Prepare model
			$related_field = $this->parent['model'];
			$related_properties = $this->_get_related_properties($related_field);
			$class = $related_properties['class'];
			$other_model = $related_properties['join_other_as'];
			$this_model = $related_properties['join_self_as'];
			$object = new $class();

			// Determine relationship table name
			$relationship_table = $this->_get_relationship_table($object, $related_field);

			// To ensure result integrity, group all previous queries
			if( ! empty($this->db->ar_where))
			{
				// if the relationship table is different from our table, include our table in the count query
				if ($relationship_table != $this->table)
				{
					$this->db->join($this->table, $this->table . '.id = ' . $relationship_table . '.' . $this_model.'_id', 'LEFT OUTER');
				}

				array_unshift($this->db->ar_where, '( ');
				$this->db->ar_where[] = ' )';
			}

			// We have to query special for in-table foreign keys that
			// are pointing at this object
			if($relationship_table == $object->table  && // ITFK
					 // NOT ITFKs that point at the other object
					 ! ($object->table == $this->table && // self-referencing has_one join
					 	in_array($other_model . '_id', $this->fields)) // where the ITFK is for the other object
					)
			{
				// ITFK on the other object's table
				$this->db->where('id', $this->parent['id'])->where($this_model . '_id IS NOT NULL');
			}
			else
			{
				// All other cases
				$this->db->where($relationship_table . '.' . $other_model . '_id', $this->parent['id']);
			}
			if(!empty($exclude_ids))
			{
				$this->db->where_not_in($relationship_table . '.' . $this_model . '_id', $exclude_ids);
			}
			if($column == 'id')
			{
				$column = $relationship_table . '.' . $this_model . '_id';
			}
			if(!empty($related_id))
			{
				$this->db->where($this_model . '_id', $related_id);
			}
			$this->db->from($relationship_table);
		}
		else
		{
			$this->db->from($this->table);
			if(!empty($exclude_ids))
			{
				$this->db->where_not_in('id', $exclude_ids);
			}
			if(!empty($related_id))
			{
				$this->db->where('id', $related_id);
			}
			$column = $this->add_table_name($column);
		}

		// Manually overridden to allow for COUNT(DISTINCT COLUMN)
		$select = $this->db->_count_string;
		if(!empty($column))
		{
			// COUNT DISTINCT
			$select = 'SELECT COUNT(DISTINCT ' . $this->db->dm_call_method('_protect_identifiers', $column) . ') AS ';
		}
		$sql = $this->db->dm_call_method('_compile_select', $select . $this->db->dm_call_method('_protect_identifiers', 'numrows'));

		$query = $this->db->query($sql);
		$this->db->dm_call_method('_reset_select');

		if ($query->num_rows() == 0)
		{
			return 0;
		}

		$row = $query->row();
		return intval($row->numrows);
	}

	// --------------------------------------------------------------------

	/**
	 * Count Distinct
	 *
	 * Returns the total count of distinct object records from the database.
	 * If on a related object, returns the total count of related objects records.
	 *
	 * @param	array $exclude_ids A list of ids to exlcude from the count
	 * @param	string $column If provided, use this column for the DISTINCT instead of 'id'
	 * @return	int Number of rows in query.
	 */
	public function count_distinct($exclude_ids = NULL, $column = 'id')
	{
		return $this->count($exclude_ids, $column);
	}

	// --------------------------------------------------------------------

	/**
	 * Convenience method to return the number of items from
	 * the last call to get.
	 *
	 * @return	int
	 */
	public function result_count() {
		if(isset($this->_dm_dataset_iterator)) {
			return $this->_dm_dataset_iterator->result_count();
		} else {
			return count($this->all);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Exists
	 *
	 * Returns TRUE if the current object has a database record.
	 *
	 * @return	bool
	 */
	public function exists()
	{
		// returns TRUE if the id of this object is set and not empty, OR
		// there are items in the ALL array.
		return isset($this->id) ? !empty($this->id) : ($this->result_count() > 0);
	}

	// --------------------------------------------------------------------

	/**
	 * Query
	 *
	 * Runs the specified query and populates the current object with the results.
	 *
	 * Warning: Use at your own risk.  This will only be as reliable as your query.
	 *
	 * @param	string $sql The query to process
	 * @param	array|bool $binds Array of values to bind (see CodeIgniter)
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function query($sql, $binds = FALSE)
	{
		// Get by objects properties
		$query = $this->db->query($sql, $binds);

		$this->_process_query($query);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Check Last Query
	 * Renders the last DB query performed.
	 *
	 * @param	array $delims Delimiters for the SQL string.
	 * @param	bool $return_as_string If TRUE, don't output automatically.
	 * @return	string Last db query formatted as a string.
	 */
	public function check_last_query($delims = array('<pre>', '</pre>'), $return_as_string = FALSE) {
		$q = wordwrap($this->db->last_query(), 100, "\n\t");
		if(!empty($delims)) {
			$q = implode($q, $delims);
		}
		if($return_as_string === FALSE) {
			echo $q;
		}
		return $q;
	}

	// --------------------------------------------------------------------

	/**
	 * Error Message
	 *
	 * Adds an error message to this objects error object.
	 *
	 * @param string $field Field to set the error on.
	 * @param string $error Error message.
	 */
	public function error_message($field, $error)
	{
		if ( ! empty($field) && ! empty($error))
		{
			// Set field specific error
			$this->error->{$field} = $this->error_prefix . $error . $this->error_suffix;

			// Add field error to errors all list
			$this->error->all[$field] = $this->error->{$field};

			// Append field error to error message string
			$this->error->string .= $this->error->{$field};
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get Clone
	 *
	 * Returns a clone of the current object.
	 *
	 * @return	DataMapper Cloned copy of this object.
	 */
	public function get_clone($force_db = FALSE)
	{
		$temp = clone($this);

		// This must be left in place, even with the __clone method,
		// or else the DB will not be copied over correctly.
		if($force_db ||
				(($this->db_params !== FALSE) && isset($this->db)) )
		{
			// create a copy of $this->db
			$temp->db = clone($this->db);
		}
		return $temp;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Copy
	 *
	 * Returns an unsaved copy of the current object.
	 *
	 * @return	DataMapper Cloned copy of this object with an empty ID for saving as new.
	 */
	public function get_copy($force_db = FALSE)
	{
		$copy = $this->get_clone($force_db);

		$copy->id = NULL;

		return $copy;
	}

	// --------------------------------------------------------------------

	/**
	 * Get By
	 *
	 * Gets objects by specified field name and value.
	 *
	 * @ignore
	 * @param	string $field Field to look at.
	 * @param	array $value Arguments to this method.
	 * @return	DataMapper Returns self for method chaining.
	 */
	private function _get_by($field, $value = array())
	{
		if (isset($value[0]))
		{
			$this->where($field, $value[0]);
		}

		return $this->get();
	}

	// --------------------------------------------------------------------

	/**
	 * Get By Related
	 *
	 * Gets objects by specified related object and optionally by field name and value.
	 *
	 * @ignore
	 * @param	mixed $model Related Model or Object
	 * @param	array $arguments Arguments to the where method
	 * @return	DataMapper Returns self for method chaining.
	 */
	private function _get_by_related($model, $arguments = array())
	{
		if ( ! empty($model))
		{
			// Add model to start of arguments
			$arguments = array_merge(array($model), $arguments);
		}

		$this->_related('where', $arguments);

		return $this->get();
	}

	// --------------------------------------------------------------------

	/**
	 * Handles the adding the related part of a query if $parent is set
	 *
	 * @ignore
	 * @return bool Success or failure
	 */
	protected function _handle_related()
	{
		if ( ! empty($this->parent))
		{
			$has_many = array_key_exists($this->parent['model'], $this->has_many);
			$has_one = array_key_exists($this->parent['model'], $this->has_one);

			// If this is a "has many" or "has one" related item
			if ($has_many || $has_one)
			{
				if( ! $this->_get_relation($this->parent['model'], $this->parent['id']))
				{
					return FALSE;
				}
			}
			else
			{
				// provide feedback on errors
				$this_model = get_class($this);
				show_error("DataMapper Error: '".$this->parent['model']."' is not a valid parent relationship for $this_model.  Are your relationships configured correctly?");
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *																   *
	 * Active Record methods											 *
	 *																   *
	 * The following are methods used to provide Active Record		   *
	 * functionality for data retrieval.								 *
	 *																   *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


	// --------------------------------------------------------------------

	/**
	 * Add Table Name
	 *
	 * Adds the table name to a field if necessary
	 *
	 * @param	string $field Field to add the table name to.
	 * @return	string Possibly modified field name.
	 */
	public function add_table_name($field)
	{
		// only add table if the field doesn't contain a dot (.) or open parentheses
		if (preg_match('/[\.\(]/', $field) == 0)
		{
			// split string into parts, add field
			$field_parts = explode(',', $field);
			$field = '';
			foreach ($field_parts as $part)
			{
				if ( ! empty($field))
				{
					$field .= ', ';
				}
				$part = ltrim($part);
				// handle comparison operators on where
				$subparts = explode(' ', $part, 2);
				if ($subparts[0] == '*' || in_array($subparts[0], $this->fields))
				{
					$field .= $this->table  . '.' . $part;
				}
				else
				{
					$field .= $part;
				}
			}
		}
		return $field;
	}

	// --------------------------------------------------------------------

	/**
	 * Creates a SQL-function with the given (optional) arguments.
	 *
	 * Each argument can be one of several forms:
	 * 1) An un escaped string value, which will be automatically escaped: "hello"
	 * 2) An escaped value or non-string, which is copied directly: "'hello'" 123, etc
	 * 3) An operator, *, or a non-escaped string is copied directly: "[non-escaped]" ">", etc
	 * 4) A field on this model: "@property"  (Also, "@<whatever>" will be copied directly
	 * 5) A field on a related or deeply related model: "@model/property" "@model/other_model/property"
	 * 6) An array, which is processed recursively as a forumla.
	 *
	 * @param	string $function_name Function name.
	 * @param	mixed $args,... (Optional) Any commands that need to be passed to the function.
	 * @return	string The new SQL function string.
	 */
	public function func($function_name)
	{
		$ret = $function_name . '(';
		$args = func_get_args();
		// pop the function name
		array_shift($args);
		$comma = '';
		foreach($args as $arg)
		{
			$ret .= $comma . $this->_process_function_arg($arg);
			if(empty($comma))
			{
				$comma = ', ';
			}
		}
		$ret .= ')';
		return $ret;
	}

	// private method to convert function arguments into SQL
	private function _process_function_arg($arg, $is_formula = FALSE)
	{
		$ret = '';
		if(is_array($arg)) {
			// formula
			foreach($arg as $func => $formula_arg) {
				if(!empty($ret)) {
					$ret .= ' ';
				}
				if(is_numeric($func)) {
					// process non-functions
					$ret .= $this->_process_function_arg($formula_arg, TRUE);
				} else {
					// recursively process functions within functions
					$func_args = array_merge(array($func), (array)$formula_arg);
					$ret .= call_user_func_array(array($this, 'func'), $func_args);
				}
			}
			return $ret;
		}

		$operators = array(
			'AND', 'OR', 'NOT', // binary logic
			'<', '>', '<=', '>=', '=', '<>', '!=', // comparators
			'+', '-', '*', '/', '%', '^', // basic maths
			'|/', '||/', '!', '!!', '@', '&', '|', '#', '~', // advanced maths
			'<<', '>>'); // binary operators

		if(is_string($arg))
		{
			if( ($is_formula && in_array($arg, $operators)) ||
				 $arg == '*' ||
				 ($arg[0] == "'" && $arg[strlen($arg)-1] == "'") ||
				 ($arg[0] == "[" && $arg[strlen($arg)-1] == "]") )
			{
				// simply add already-escaped strings, the special * value, or operators in formulas
				if($arg[0] == "[" && $arg[strlen($arg)-1] == "]") {
					// Arguments surrounded by square brackets are added directly, minus the brackets
					$arg = substr($arg, 1, -1);
				}
				$ret .= $arg;
			}
			else if($arg[0] == '@')
			{
				// model or sub-model property
				$arg = substr($arg, 1);
				if(strpos($arg, '/') !== FALSE)
				{
					// related property
					if(strpos($arg, 'parent/') === 0)
					{
						// special parent property for subqueries
						$ret .= str_replace('parent/', '${parent}.', $arg);
					}
					else
					{
						$rel_elements = explode('/', $arg);
						$property = array_pop($rel_elements);
						$table = $this->_add_related_table(implode('/', $rel_elements));
						$ret .= $this->db->protect_identifiers($table . '.' . $property);
					}
				}
				else
				{
					$ret .= $this->db->protect_identifiers($this->add_table_name($arg));
				}
			}
			else
			{
				$ret .= $this->db->escape($arg);
			}
		}
		else
		{
			$ret .= $arg;
		}
		return $ret;
	}

	// --------------------------------------------------------------------

	/**
	 * Used by the magic method for select_func, {where}_func, etc
	 *
	 * @ignore
	 * @param	object $query Name of query function
	 * @param	array $args Arguments for func()
	 * @return	DataMapper Returns self for method chaining.
	 */
	private function _func($query, $args)
	{
		if(count($args) < 2)
		{
			throw new Exception("Invalid number of arguments to {$query}_func: must be at least 2 arguments.");
		}
		if($query == 'select')
		{
			$alias = array_pop($args);
			$value = call_user_func_array(array($this, 'func'), $args);
			$value .= " AS $alias";

			// we can't use the normal select method, because CI likes to breaky
			$this->_add_to_select_directly($value);

			return $this;
		}
		else
		{
			$param = array_pop($args);
			$value = call_user_func_array(array($this, 'func'), $args);
			return $this->{$query}($value, $param);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Used by the magic method for {where}_field_func, etc.
	 *
	 * @ignore
	 * @param	string $query Name of query function
	 * @param	array $args Arguments for func()
	 * @return	DataMapper Returns self for method chaining.
	 */
	private function _field_func($query, $args)
	{
		if(count($args) < 2)
		{
			throw new Exception("Invalid number of arguments to {$query}_field_func: must be at least 2 arguments.");
		}
		$field = array_shift($args);
		$func = call_user_func_array(array($this, 'func'), $args);
		return $this->_process_special_query_clause($query, $field, $func);
	}

	// --------------------------------------------------------------------

	/**
	 * Used by the magic method for select_subquery {where}_subquery, etc
	 *
	 * @ignore
	 * @param	string $query Name of query function
	 * @param	array $args Arguments for subquery
	 * @return	DataMapper Returns self for method chaining.
	 */
	private function _subquery($query, $args)
	{
		if(count($args) < 1)
		{
			throw new Exception("Invalid arguments on {$query}_subquery: must be at least one argument.");
		}
		if($query == 'select')
		{
			if(count($args) < 2)
			{
				throw new Exception('Invalid number of arguments to select_subquery: must be exactly 2 arguments.');
			}
			$sql = $this->_parse_subquery_object($args[0]);
			$alias = $args[1];
			// we can't use the normal select method, because CI likes to breaky
			$this->_add_to_select_directly("$sql AS $alias");
			return $this;
		}
		else
		{
			$object = $field = $value = NULL;
			if(is_object($args[0]) ||
					(is_string($args[0]) && !isset($args[1])) )
			{
				$field = $this->_parse_subquery_object($args[0]);
				if(isset($args[1])) {
					$value = $this->db->protect_identifiers($this->add_table_name($args[1]));
				}
			}
			else
			{
				$field = $this->add_table_name($args[0]);
				$value = $args[1];
				if(is_object($value))
				{
					$value = $this->_parse_subquery_object($value);
				}
			}
			$extra = NULL;
			if(isset($args[2])) {
				$extra = $args[2];
			}
			return $this->_process_special_query_clause($query, $field, $value, $extra);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Parses and protects a subquery.
	 * Automatically replaces the special ${parent} argument with a reference to
	 * this table.
	 *
	 * Also replaces all table references that would overlap with this object.
	 *
	 * @ignore
	 * @param	object $sql SQL string to process
	 * @return	string Processed SQL string.
	 */
	protected function _parse_subquery_object($sql)
	{
		if(is_object($sql))
		{
			$sql = '(' . $sql->get_sql() . ')';
		}

		// Table Name pattern should be
		$tablename = $this->db->dm_call_method('_escape_identifiers', $this->table);
		$table_pattern = '(?:' . preg_quote($this->table) . '|' . preg_quote($tablename) . '|\(' . preg_quote($tablename) . '\))';

		$fieldname = $this->db->dm_call_method('_escape_identifiers', '__field__');
		$field_pattern = '([-\w]+|' . str_replace('__field__', '[-\w]+', preg_quote($fieldname)) . ')';

		// replace all table.field references
		// pattern ends up being [^_](table|`table`).(field|`field`)
		// the NOT _ at the beginning is to prevent replacing of advanced relationship table references.
		$pattern = '/([^_])' . $table_pattern . '\.' . $field_pattern . '/i';
		// replacement ends up being `table_subquery`.`$1`
		$replacement = '$1' . $this->db->dm_call_method('_escape_identifiers', $this->table . '_subquery') . '.$2';
		$sql = preg_replace($pattern, $replacement, $sql);

		// now replace all "table table" aliases
		// important: the space at the end is required
		$pattern = "/$table_pattern $table_pattern /i";
		$replacement = $tablename . ' ' . $this->db->dm_call_method('_escape_identifiers', $this->table . '_subquery') . ' ';
		$sql = preg_replace($pattern, $replacement, $sql);

		// now replace "FROM table" for self relationships
		$pattern = "/FROM $table_pattern([,\\s])/i";
		$replacement = "FROM $tablename " . $this->db->dm_call_method('_escape_identifiers', $this->table . '_subquery') . '$1';
		$sql = preg_replace($pattern, $replacement, $sql);
		$sql = str_replace("\n", "\n\t", $sql);

		return str_replace('${parent}', $this->table, $sql);
	}

	// --------------------------------------------------------------------

	/**
	 * Manually adds an item to the SELECT column, to prevent it from
	 * being broken by AR->select
	 *
	 * @ignore
	 * @param	string $value New SELECT value
	 */
	protected function _add_to_select_directly($value)
	{
		// copied from system/database/DB_activerecord.php
		$this->db->ar_select[] = $value;

		if ($this->db->ar_caching === TRUE)
		{
			$this->db->ar_cache_select[] = $value;
			$this->db->ar_cache_exists[] = 'select';
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Handles specialized where clauses, like subqueries and functions
	 *
	 * @ignore
	 * @param	string $query Query function
	 * @param	string $field Field for Query function
	 * @param	mixed $value Value for Query function
	 * @param	mixed $extra If included, overrides the default assumption of FALSE for the third parameter to $query
	 * @return	DataMapper Returns self for method chaining.
	 */
	private function _process_special_query_clause($query, $field, $value, $extra = NULL) {
		if(strpos($query, 'where_in') !== FALSE) {
			$query = str_replace('_in', '', $query);
			$field .= ' IN ';
		} else if(strpos($query, 'where_not_in') !== FALSE) {
			$query = str_replace('_not_in', '', $query);
			$field .= ' NOT IN ';
		}
		if(is_null($extra)) {
			$extra = FALSE;
		}
		return $this->{$query}($field, $value, $extra);
	}

	// --------------------------------------------------------------------

	/**
	 * Select
	 *
	 * Sets the SELECT portion of the query.
	 *
	 * @param	mixed $select Field(s) to select, array or comma separated string
	 * @param	bool $escape If FALSE, don't escape this field (Probably won't work)
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function select($select = '*', $escape = NULL)
	{
		if ($escape !== FALSE) {
			if (!is_array($select)) {
				$select = $this->add_table_name($select);
			} else {
				$updated = array();
				foreach ($select as $sel) {
					$updated = $this->add_table_name($sel);
				}
				$select = $updated;
			}
		}
		$this->db->select($select, $escape);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Select Max
	 *
	 * Sets the SELECT MAX(field) portion of a query.
	 *
	 * @param	string $select Field to look at.
	 * @param	string $alias Alias of the MAX value.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function select_max($select = '', $alias = '')
	{
		// Check if this is a related object
		if ( ! empty($this->parent))
		{
			$alias = ($alias != '') ? $alias : $select;
		}
		$this->db->select_max($this->add_table_name($select), $alias);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Select Min
	 *
	 * Sets the SELECT MIN(field) portion of a query.
	 *
	 * @param	string $select Field to look at.
	 * @param	string $alias Alias of the MIN value.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function select_min($select = '', $alias = '')
	{
		// Check if this is a related object
		if ( ! empty($this->parent))
		{
			$alias = ($alias != '') ? $alias : $select;
		}
		$this->db->select_min($this->add_table_name($select), $alias);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Select Avg
	 *
	 * Sets the SELECT AVG(field) portion of a query.
	 *
	 * @param	string $select Field to look at.
	 * @param	string $alias Alias of the AVG value.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function select_avg($select = '', $alias = '')
	{
		// Check if this is a related object
		if ( ! empty($this->parent))
		{
			$alias = ($alias != '') ? $alias : $select;
		}
		$this->db->select_avg($this->add_table_name($select), $alias);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Select Sum
	 *
	 * Sets the SELECT SUM(field) portion of a query.
	 *
	 * @param	string $select Field to look at.
	 * @param	string $alias Alias of the SUM value.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function select_sum($select = '', $alias = '')
	{
		// Check if this is a related object
		if ( ! empty($this->parent))
		{
			$alias = ($alias != '') ? $alias : $select;
		}
		$this->db->select_sum($this->add_table_name($select), $alias);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Distinct
	 *
	 * Sets the flag to add DISTINCT to the query.
	 *
	 * @param	bool $value Set to FALSE to turn back off DISTINCT
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function distinct($value = TRUE)
	{
		$this->db->distinct($value);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Where
	 *
	 * Get items matching the where clause.
	 *
	 * @param	mixed $where See where()
	 * @param	integer|NULL $limit Limit the number of results.
	 * @param	integer|NULL $offset Offset the results when limiting.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function get_where($where = array(), $limit = NULL, $offset = NULL)
	{
		$this->where($where);

		return $this->get($limit, $offset);
	}

	// --------------------------------------------------------------------

	/**
	 * Starts a query group.
	 *
	 * @param	string $not (Internal use only)
	 * @param	string $type (Internal use only)
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function group_start($not = '', $type = 'AND ')
	{
		// Increment group count number to make them unique
		$this->_group_count++;

		// in case groups are being nested
		$type = $this->_get_prepend_type($type);

		$this->_where_group_started = TRUE;

		$prefix = (count($this->db->ar_where) == 0 AND count($this->db->ar_cache_where) == 0) ? '' : $type;

		$value =  $prefix . $not . str_repeat(' ', $this->_group_count) . ' (';
		$this->db->ar_where[] = $value;
		if($this->db->ar_caching) $this->db->ar_cache_where[] = $value;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Starts a query group, but ORs the group
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_group_start()
	{
		return $this->group_start('', 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Starts a query group, but NOTs the group
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function not_group_start()
	{
		return $this->group_start('NOT ', 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Starts a query group, but OR NOTs the group
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_not_group_start()
	{
		return $this->group_start('NOT ', 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Ends a query group.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function group_end()
	{
		$value = str_repeat(' ', $this->_group_count) . ')';
		$this->db->ar_where[] = $value;
		if($this->db->ar_caching) $this->db->ar_cache_where[] = $value;

		$this->_where_group_started = FALSE;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * protected function to convert the AND or OR prefix to '' when starting
	 * a group.
	 *
	 * @ignore
	 * @param	object $type Current type value
	 * @return	New type value
	 */
	protected function _get_prepend_type($type)
	{
		if($this->_where_group_started)
		{
			$type = '';
			$this->_where_group_started = FALSE;
		}
		return $type;
	}

	// --------------------------------------------------------------------

	/**
	 * Where
	 *
	 * Sets the WHERE portion of the query.
	 * Separates multiple calls with AND.
	 *
	 * Called by get_where()
	 *
	 * @param	mixed $key A field or array of fields to check.
	 * @param	mixed $value For a single field, the value to compare to.
	 * @param	bool $escape If FALSE, the field is not escaped.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function where($key, $value = NULL, $escape = TRUE)
	{
		return $this->_where($key, $value, 'AND ', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * Or Where
	 *
	 * Sets the WHERE portion of the query.
	 * Separates multiple calls with OR.
	 *
	 * @param	mixed $key A field or array of fields to check.
	 * @param	mixed $value For a single field, the value to compare to.
	 * @param	bool $escape If FALSE, the field is not escaped.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_where($key, $value = NULL, $escape = TRUE)
	{
		return $this->_where($key, $value, 'OR ', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * Where
	 *
	 * Called by where() or or_where().
	 *
	 * @ignore
	 * @param	mixed $key A field or array of fields to check.
	 * @param	mixed $value For a single field, the value to compare to.
	 * @param	string $type Type of addition (AND or OR)
	 * @param	bool $escape If FALSE, the field is not escaped.
	 * @return	DataMapper Returns self for method chaining.
	 */
	protected function _where($key, $value = NULL, $type = 'AND ', $escape = NULL)
	{
		if ( ! is_array($key))
		{
			$key = array($key => $value);
		}
		foreach ($key as $k => $v)
		{
			$new_k = $this->add_table_name($k);
			$this->db->dm_call_method('_where', $new_k, $v, $this->_get_prepend_type($type), $escape);
		}

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Where Between
	 *
	 * Sets the WHERE field BETWEEN 'value1' AND 'value2' SQL query joined with
	 * AND if appropriate.
	 *
	 * @param	string $key A field to check.
	 * @param	mixed $value value to start with
	 * @param	mixed $value value to end with
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function where_between($key = NULL, $value1 = NULL, $value2 = NULL)
	{
	 	return $this->_where_between($key, $value1, $value2);
	}

	// --------------------------------------------------------------------

	/**
	 * Where Between
	 *
	 * Sets the WHERE field BETWEEN 'value1' AND 'value2' SQL query joined with
	 * AND if appropriate.
	 *
	 * @param	string $key A field to check.
	 * @param	mixed $value value to start with
	 * @param	mixed $value value to end with
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function where_not_between($key = NULL, $value1 = NULL, $value2 = NULL)
	{
	 	return $this->_where_between($key, $value1, $value2, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Where Between
	 *
	 * Sets the WHERE field BETWEEN 'value1' AND 'value2' SQL query joined with
	 * AND if appropriate.
	 *
	 * @param	string $key A field to check.
	 * @param	mixed $value value to start with
	 * @param	mixed $value value to end with
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_where_between($key = NULL, $value1 = NULL, $value2 = NULL)
	{
	 	return $this->_where_between($key, $value1, $value2, FALSE, 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Where Between
	 *
	 * Sets the WHERE field BETWEEN 'value1' AND 'value2' SQL query joined with
	 * AND if appropriate.
	 *
	 * @param	string $key A field to check.
	 * @param	mixed $value value to start with
	 * @param	mixed $value value to end with
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_where_not_between($key = NULL, $value1 = NULL, $value2 = NULL)
	{
	 	return $this->_where_between($key, $value1, $value2, TRUE, 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Where In
	 *
	 * Sets the WHERE field IN ('item', 'item') SQL query joined with
	 * AND if appropriate.
	 *
	 * @param	string $key A field to check.
	 * @param	array $values An array of values to compare against
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function where_in($key = NULL, $values = NULL)
	{
	 	return $this->_where_in($key, $values);
	}

	// --------------------------------------------------------------------

	/**
	 * Or Where In
	 *
	 * Sets the WHERE field IN ('item', 'item') SQL query joined with
	 * OR if appropriate.
	 *
	 * @param	string $key A field to check.
	 * @param	array $values An array of values to compare against
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_where_in($key = NULL, $values = NULL)
	{
	 	return $this->_where_in($key, $values, FALSE, 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Where Not In
	 *
	 * Sets the WHERE field NOT IN ('item', 'item') SQL query joined with
	 * AND if appropriate.
	 *
	 * @param	string $key A field to check.
	 * @param	array $values An array of values to compare against
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function where_not_in($key = NULL, $values = NULL)
	{
		return $this->_where_in($key, $values, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Or Where Not In
	 *
	 * Sets the WHERE field NOT IN ('item', 'item') SQL query joined wuth
	 * OR if appropriate.
	 *
	 * @param	string $key A field to check.
	 * @param	array $values An array of values to compare against
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_where_not_in($key = NULL, $values = NULL)
	{
		return $this->_where_in($key, $values, TRUE, 'OR ');
	}

	// --------------------------------------------------------------------

	/**
	 * Where In
	 *
	 * Called by where_in(), or_where_in(), where_not_in(), or or_where_not_in().
	 *
	 * @ignore
	 * @param	string $key A field to check.
	 * @param	array $values An array of values to compare against
	 * @param	bool $not If TRUE, use NOT IN instead of IN.
	 * @param	string $type The type of connection (AND or OR)
	 * @return	DataMapper Returns self for method chaining.
	 */
	protected function _where_in($key = NULL, $values = NULL, $not = FALSE, $type = 'AND ')
	{
		$type = $this->_get_prepend_type($type);

		if ($values instanceOf DataMapper)
		{
			$arr = array();
			foreach ($values as $value)
			{
				$arr[] = $value->id;
			}
			$values = $arr;
		}
	 	$this->db->dm_call_method('_where_in', $this->add_table_name($key), $values, $not, $type);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Where Between
	 *
	 * Called by where_between(), or_where_between(), where_not_between(), or or_where_not_between().
	 *
	 * @ignore
	 * @param	string $key A field to check.
	 * @param	mixed $value value to start with
	 * @param	mixed $value value to end with
	 * @param	bool $not If TRUE, use NOT IN instead of IN.
	 * @param	string $type The type of connection (AND or OR)
	 * @return	DataMapper Returns self for method chaining.
	 */
	protected function _where_between($key = NULL, $value1 = NULL, $value2 = NULL, $not = FALSE, $type = 'AND ')
	{
		$type = $this->_get_prepend_type($type);

	 	$this->db->dm_call_method('_where', "`$key` ".($not?"NOT ":"")."BETWEEN ".$value1." AND ".$value2, NULL, $type, NULL);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Like
	 *
	 * Sets the %LIKE% portion of the query.
	 * Separates multiple calls with AND.
	 *
	 * @param	mixed $field A field or array of fields to check.
	 * @param	mixed $match For a single field, the value to compare to.
	 * @param	string $side One of 'both', 'before', or 'after'
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function like($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'AND ', $side);
	}

	// --------------------------------------------------------------------

	/**
	 * Not Like
	 *
	 * Sets the NOT LIKE portion of the query.
	 * Separates multiple calls with AND.
	 *
	 * @param	mixed $field A field or array of fields to check.
	 * @param	mixed $match For a single field, the value to compare to.
	 * @param	string $side One of 'both', 'before', or 'after'
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function not_like($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'AND ', $side, 'NOT');
	}

	// --------------------------------------------------------------------

	/**
	 * Or Like
	 *
	 * Sets the %LIKE% portion of the query.
	 * Separates multiple calls with OR.
	 *
	 * @param	mixed $field A field or array of fields to check.
	 * @param	mixed $match For a single field, the value to compare to.
	 * @param	string $side One of 'both', 'before', or 'after'
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_like($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'OR ', $side);
	}

	// --------------------------------------------------------------------

	/**
	 * Or Not Like
	 *
	 * Sets the NOT LIKE portion of the query.
	 * Separates multiple calls with OR.
	 *
	 * @param	mixed $field A field or array of fields to check.
	 * @param	mixed $match For a single field, the value to compare to.
	 * @param	string $side One of 'both', 'before', or 'after'
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_not_like($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'OR ', $side, 'NOT');
	}

	// --------------------------------------------------------------------

	/**
	 * ILike
	 *
	 * Sets the case-insensitive %LIKE% portion of the query.
	 *
	 * @param	mixed $field A field or array of fields to check.
	 * @param	mixed $match For a single field, the value to compare to.
	 * @param	string $side One of 'both', 'before', or 'after'
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function ilike($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'AND ', $side, '', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Not ILike
	 *
	 * Sets the case-insensitive NOT LIKE portion of the query.
	 * Separates multiple calls with AND.
	 *
	 * @param	mixed $field A field or array of fields to check.
	 * @param	mixed $match For a single field, the value to compare to.
	 * @param	string $side One of 'both', 'before', or 'after'
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function not_ilike($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'AND ', $side, 'NOT', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Or Like
	 *
	 * Sets the case-insensitive %LIKE% portion of the query.
	 * Separates multiple calls with OR.
	 *
	 * @param	mixed $field A field or array of fields to check.
	 * @param	mixed $match For a single field, the value to compare to.
	 * @param	string $side One of 'both', 'before', or 'after'
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_ilike($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'OR ', $side, '', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * Or Not Like
	 *
	 * Sets the case-insensitive NOT LIKE portion of the query.
	 * Separates multiple calls with OR.
	 *
	 * @param	mixed $field A field or array of fields to check.
	 * @param	mixed $match For a single field, the value to compare to.
	 * @param	string $side One of 'both', 'before', or 'after'
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_not_ilike($field, $match = '', $side = 'both')
	{
		return $this->_like($field, $match, 'OR ', $side, 'NOT', TRUE);
	}

	// --------------------------------------------------------------------

	/**
	 * _Like
	 *
	 * Private function to do actual work.
	 * NOTE: this does NOT use the built-in ActiveRecord LIKE function.
	 *
	 * @ignore
	 * @param	mixed $field A field or array of fields to check.
	 * @param	mixed $match For a single field, the value to compare to.
	 * @param	string $type The type of connection (AND or OR)
	 * @param	string $side One of 'both', 'before', or 'after'
	 * @param	string $not 'NOT' or ''
	 * @param	bool $no_case If TRUE, configure to ignore case.
	 * @return	DataMapper Returns self for method chaining.
	 */
	protected function _like($field, $match = '', $type = 'AND ', $side = 'both', $not = '', $no_case = FALSE)
	{
		if ( ! is_array($field))
		{
			$field = array($field => $match);
		}

		foreach ($field as $k => $v)
		{
			$new_k = $this->add_table_name($k);
			if ($new_k != $k)
			{
				$field[$new_k] = $v;
				unset($field[$k]);
			}
		}

		// Taken from CodeIgniter's Active Record because (for some reason)
		// it is stored separately that normal where statements.

		foreach ($field as $k => $v)
		{
			if($no_case)
			{
				$k = 'UPPER(' . $this->db->protect_identifiers($k) .')';
				$v = strtoupper($v);
			}
			$f = "$k $not LIKE ";

			if ($side == 'before')
			{
				$m = "%{$v}";
			}
			elseif ($side == 'after')
			{
				$m = "{$v}%";
			}
			else
			{
				$m = "%{$v}%";
			}

			$this->_where($f, $m, $type, TRUE);
		}

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Group By
	 *
	 * Sets the GROUP BY portion of the query.
	 *
	 * @param	string $by Field to group by
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function group_by($by)
	{
		$this->db->group_by($this->add_table_name($by));

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Having
	 *
	 * Sets the HAVING portion of the query.
	 * Separates multiple calls with AND.
	 *
	 * @param	string $key Field to compare.
	 * @param	string $value value to compare to.
	 * @param	bool $escape If FALSE, don't escape the value.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function having($key, $value = '', $escape = TRUE)
	{
		return $this->_having($key, $value, 'AND ', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * Or Having
	 *
	 * Sets the OR HAVING portion of the query.
	 * Separates multiple calls with OR.
	 *
	 * @param	string $key Field to compare.
	 * @param	string $value value to compare to.
	 * @param	bool $escape If FALSE, don't escape the value.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function or_having($key, $value = '', $escape = TRUE)
	{
		return $this->_having($key, $value, 'OR ', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * Having
	 *
	 * Sets the HAVING portion of the query.
	 * Separates multiple calls with AND.
	 *
	 * @ignore
	 * @param	string $key Field to compare.
	 * @param	string $value value to compare to.
	 * @param	string $type Type of connection (AND or OR)
	 * @param	bool $escape If FALSE, don't escape the value.
	 * @return	DataMapper Returns self for method chaining.
	 */
	protected function _having($key, $value = '', $type = 'AND ', $escape = TRUE)
	{
		$this->db->dm_call_method('_having', $this->add_table_name($key), $value, $type, $escape);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Order By
	 *
	 * Sets the ORDER BY portion of the query.
	 *
	 * @param	string $orderby Field to order by
	 * @param	string $direction One of 'ASC' or 'DESC'  Defaults to 'ASC'
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function order_by($orderby, $direction = '')
	{
		$this->db->order_by($this->add_table_name($orderby), $direction);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Adds in the defaut order_by items, if there are any, and
	 * order_by hasn't been overridden.
	 * @ignore
	 */
	protected function _handle_default_order_by()
	{
		if(empty($this->default_order_by))
		{
			return;
		}
		$sel = $this->table . '.' . '*';
		$sel_protect = $this->db->protect_identifiers($sel);
		// only add the items if there isn't an existing order_by,
		// AND the select statement is empty or includes * or table.* or `table`.*
		if(empty($this->db->ar_orderby) &&
			(
				empty($this->db->ar_select) ||
				in_array('*', $this->db->ar_select) ||
				in_array($sel_protect, $this->db->ar_select) ||
			 	in_array($sel, $this->db->ar_select)

			))
		{
			foreach($this->default_order_by as $k => $v) {
				if(is_int($k)) {
					$k = $v;
					$v = '';
				}
				$k = $this->add_table_name($k);
				$this->order_by($k, $v);
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Limit
	 *
	 * Sets the LIMIT portion of the query.
	 *
	 * @param	integer $limit Limit the number of results.
	 * @param	integer|NULL $offset Offset the results when limiting.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function limit($value, $offset = '')
	{
		$this->db->limit($value, $offset);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Offset
	 *
	 * Sets the OFFSET portion of the query.
	 *
	 * @param	integer $offset Offset the results when limiting.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function offset($offset)
	{
		$this->db->offset($offset);

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Start Cache
	 *
	 * Starts AR caching.
	 */
	public function start_cache()
	{
		$this->db->start_cache();
	}

	// --------------------------------------------------------------------

	/**
	 * Stop Cache
	 *
	 * Stops AR caching.
	 */
	public function stop_cache()
	{
		$this->db->stop_cache();
	}

	// --------------------------------------------------------------------

	/**
	 * Flush Cache
	 *
	 * Empties the AR cache.
	 */
	public function flush_cache()
	{
		$this->db->flush_cache();
	}

	// --------------------------------------------------------------------


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *																   *
	 * Transaction methods											   *
	 *																   *
	 * The following are methods used for transaction handling.		  *
	 *																   *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


	// --------------------------------------------------------------------

	/**
	 * Trans Off
	 *
	 * This permits transactions to be disabled at run-time.
	 *
	 */
	public function trans_off()
	{
		$this->db->trans_enabled = FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Trans Strict
	 *
	 * When strict mode is enabled, if you are running multiple groups of
	 * transactions, if one group fails all groups will be rolled back.
	 * If strict mode is disabled, each group is treated autonomously, meaning
	 * a failure of one group will not affect any others.
	 *
	 * @param	bool $mode Set to false to disable strict mode.
	 */
	public function trans_strict($mode = TRUE)
	{
		$this->db->trans_strict($mode);
	}

	// --------------------------------------------------------------------

	/**
	 * Trans Start
	 *
	 * Start a transaction.
	 *
	 * @param	bool $test_mode Set to TRUE to only run a test (and not commit)
	 */
	public function trans_start($test_mode = FALSE)
	{
		$this->db->trans_start($test_mode);
	}

	// --------------------------------------------------------------------

	/**
	 * Trans Complete
	 *
	 * Complete a transaction.
	 *
	 * @return	bool Success or Failure
	 */
	public function trans_complete()
	{
		return $this->db->trans_complete();
	}

	// --------------------------------------------------------------------

	/**
	 * Trans Begin
	 *
	 * Begin a transaction.
	 *
	 * @param	bool $test_mode Set to TRUE to only run a test (and not commit)
	 * @return	bool Success or Failure
	 */
	public function trans_begin($test_mode = FALSE)
	{
		return $this->db->trans_begin($test_mode);
	}

	// --------------------------------------------------------------------

	/**
	 * Trans Status
	 *
	 * Lets you retrieve the transaction flag to determine if it has failed.
	 *
	 * @return	bool Returns FALSE if the transaction has failed.
	 */
	public function trans_status()
	{
		return $this->db->trans_status();
	}

	// --------------------------------------------------------------------

	/**
	 * Trans Commit
	 *
	 * Commit a transaction.
	 *
	 * @return	bool Success or Failure
	 */
	public function trans_commit()
	{
		return $this->db->trans_commit();
	}

	// --------------------------------------------------------------------

	/**
	 * Trans Rollback
	 *
	 * Rollback a transaction.
	 *
	 * @return	bool Success or Failure
	 */
	public function trans_rollback()
	{
		return $this->db->trans_rollback();
	}

	// --------------------------------------------------------------------

	/**
	 * Auto Trans Begin
	 *
	 * Begin an auto transaction if enabled.
	 *
	 */
	protected function _auto_trans_begin()
	{
		// Begin auto transaction
		if ($this->auto_transaction)
		{
			$this->trans_begin();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Auto Trans Complete
	 *
	 * Complete an auto transaction if enabled.
	 *
	 * @param	string $label Name for this transaction.
	 */
	protected function _auto_trans_complete($label = 'complete')
	{
		// Complete auto transaction
		if ($this->auto_transaction)
		{
			// Check if successful
			if (!$this->trans_complete())
			{
				$rule = 'transaction';

				// Get corresponding error from language file
				if (FALSE === ($line = $this->lang->line($rule)))
				{
					$line = 'Unable to access the ' . $rule .' error message.';
				}

				// Add transaction error message
				$this->error_message($rule, sprintf($line, $label));

				// Set validation as failed
				$this->valid = FALSE;
			}
		}
	}

	// --------------------------------------------------------------------


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *																   *
	 * Related methods												   *
	 *																   *
	 * The following are methods used for managing related records.	  *
	 *																   *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	// --------------------------------------------------------------------

	/**
	 * get_related_properties
	 *
	 * Located the relationship properties for a given field or model
	 * Can also optionally attempt to convert the $related_field to
	 * singular, and look up on that.  It will modify the $related_field if
	 * the conversion to singular returns a result.
	 *
	 * $related_field can also be a deep relationship, such as
	 * 'post/editor/group', in which case the $related_field will be processed
	 * recursively, and the return value will be $user->has_NN['group'];
	 *
	 * @ignore
	 * @param	mixed $related_field Name of related field or related object.
	 * @param	bool $try_singular If TRUE, automatically tries to look for a singular name if not found.
	 * @return	array Associative array of related properties.
	 */
	public function _get_related_properties(&$related_field, $try_singular = FALSE)
	{
		// Handle deep relationships
		if(strpos($related_field, '/') !== FALSE)
		{
			$rfs = explode('/', $related_field);
			$last = $this;
			$prop = NULL;
			foreach($rfs as &$rf)
			{
				$prop = $last->_get_related_properties($rf, $try_singular);
				if(is_null($prop))
				{
					break;
				}
				$last =& $last->_get_without_auto_populating($rf);
			}
			if( ! is_null($prop))
			{
				// update in case any items were converted to singular.
				$related_field = implode('/', $rfs);
			}
			return $prop;
		}
		else
		{
			if (isset($this->has_many[$related_field]))
			{
				return $this->has_many[$related_field];
			}
			else if (isset($this->has_one[$related_field]))
			{
				return $this->has_one[$related_field];
			}
			else
			{
				if($try_singular)
				{
					$rf = singular($related_field);
					$ret = $this->_get_related_properties($rf);
					if( is_null($ret))
					{
						show_error("Unable to relate {$this->model} with $related_field.");
					}
					else
					{
						$related_field = $rf;
						return $ret;
					}
				}
				else
				{
					// not related
					return NULL;
				}
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Add Related Table
	 *
	 * Adds the table of a related item, and joins it to this class.
	 * Returns the name of that table for further queries.
	 *
	 * If $related_field is deep, then this adds all necessary relationships
	 * to the query.
	 *
	 * @ignore
	 * @param	mixed $object The object (or related field) to look up.
	 * @param	string $related_field  Related field name for object
	 * @param	string $id_only  Private, do not use.
	 * @param	object $db  Private, do not use.
	 * @param	array $query_related  Private, do not use.
	 * @param	string $name_prepend  Private, do not use.
	 * @param	string $this_table  Private, do not use.
	 * @return	string Name of the related table, or table.field if ID_Only
	 */
	public function _add_related_table($object, $related_field = '', $id_only = FALSE, $db = NULL, &$query_related = NULL, $name_prepend = '', $this_table = NULL)
	{
		if ( is_string($object))
		{
			// only a model was passed in, not an object
			$related_field = $object;
			$object = NULL;
		}
		else if (empty($related_field))
		{
			// model was not passed, so get the Object's native model
			$related_field = $object->model;
		}

		$related_field = strtolower($related_field);

		// Handle deep relationships
		if(strpos($related_field, '/') !== FALSE)
		{
			$rfs = explode('/', $related_field);
			$last = $this;
			$prepend = '';
			$object_as = NULL;
			foreach($rfs as $index => $rf)
			{
				// if this is the last item added, we can use the $id_only
				// shortcut to prevent unnecessarily adding the last table.
				$temp_id_only = $id_only;
				if($temp_id_only) {
					if($index < count($rfs)-1) {
						$temp_id_only = FALSE;
					}
				}
				$object_as = $last->_add_related_table($rf, '', $temp_id_only, $this->db, $this->_query_related, $prepend, $object_as);
				$prepend .= $rf . '_';
				$last =& $last->_get_without_auto_populating($rf);
			}
			return $object_as;
		}

		$related_properties = $this->_get_related_properties($related_field);
		$class = $related_properties['class'];
		$this_model = $related_properties['join_self_as'];
		$other_model = $related_properties['join_other_as'];

		if (empty($object))
		{
			// no object was passed in, so create one
			$object = new $class();
		}

		if(is_null($query_related))
		{
			$query_related =& $this->_query_related;
		}

		if(is_null($this_table))
		{
			$this_table = $this->table;
		}

		// Determine relationship table name
		$relationship_table = $this->_get_relationship_table($object, $related_field);

		// only add $related_field to the table name if the 'class' and 'related_field' aren't equal
		// and the related object is in a different table
		if ( ($class == $related_field) && ($this->table != $object->table) )
		{
			$object_as = $name_prepend . $object->table;
			$relationship_as = $name_prepend . $relationship_table;
		}
		else
		{
			$object_as = $name_prepend . $related_field . '_' . $object->table;
			$relationship_as = str_replace('.', '_', $name_prepend . $related_field . '_' . $relationship_table);
		}

		$other_column = $other_model . '_id';
		$this_column = $this_model . '_id' ;


		if(is_null($db)) {
			$db = $this->db;
		}

		// Force the selection of the current object's columns
		if (empty($db->ar_select))
		{
			$db->select($this->table . '.*');
		}

		// the extra in_array column check is for has_one self references
		if ($relationship_table == $this->table && in_array($other_column, $this->fields))
		{
			// has_one relationship without a join table
			if($id_only)
			{
				// nothing to join, just return the correct data
				$object_as = $this_table . '.' . $other_column;
			}
			else if ( ! in_array($object_as, $query_related))
			{
				$db->join($object->table . ' ' .$object_as, $object_as . '.id = ' . $this_table . '.' . $other_column, 'LEFT OUTER');
				$query_related[] = $object_as;
			}
		}
		// the extra in_array column check is for has_one self references
		else if ($relationship_table == $object->table && in_array($this_column, $object->fields))
		{
			// has_one relationship without a join table
			if ( ! in_array($object_as, $query_related))
			{
				$db->join($object->table . ' ' .$object_as, $this_table . '.id = ' . $object_as . '.' . $this_column, 'LEFT OUTER');
				$query_related[] = $object_as;
			}
			if($id_only)
			{
				// include the column name
				$object_as .= '.id';
			}
		}
		else
		{
			// has_one or has_many with a normal join table

			// Add join if not already included
			if ( ! in_array($relationship_as, $query_related))
			{
				$db->join($relationship_table . ' ' . $relationship_as, $this_table . '.id = ' . $relationship_as . '.' . $this_column, 'LEFT OUTER');

				if($this->_include_join_fields) {
					$fields = $db->field_data($relationship_table);
					foreach($fields as $key => $f)
					{
						if($f->name == $this_column || $f->name == $other_column)
						{
							unset($fields[$key]);
						}
					}
					// add all other fields
					$selection = '';
					foreach ($fields as $field)
					{
						$new_field = 'join_'.$field->name;
						if (!empty($selection))
						{
							$selection .= ', ';
						}
						$selection .= $relationship_as.'.'.$field->name.' AS '.$new_field;
					}
					$db->select($selection);

					// now reset the flag
					$this->_include_join_fields = FALSE;
				}

				$query_related[] = $relationship_as;
			}

			if($id_only)
			{
				// no need to add the whole table
				$object_as = $relationship_as . '.' . $other_column;
			}
			else if ( ! in_array($object_as, $query_related))
			{
				// Add join if not already included
				$db->join($object->table . ' ' . $object_as, $object_as . '.id = ' . $relationship_as . '.' . $other_column, 'LEFT OUTER');

				$query_related[] = $object_as;
			}
		}

		return $object_as;
	}

	// --------------------------------------------------------------------

	/**
	 * Related
	 *
	 * Sets the specified related query.
	 *
	 * @ignore
	 * @param	string $query Query String
	 * @param	array $arguments Arguments to process
	 * @param	mixed $extra Used to prevent escaping in special circumstances.
	 * @return	DataMapper Returns self for method chaining.
	 */
	private function _related($query, $arguments = array(), $extra = NULL)
	{
		if ( ! empty($query) && ! empty($arguments))
		{
			$object = $field = $value = NULL;

			$next_arg = 1;

			// Prepare model
			if (is_object($arguments[0]))
			{
				$object = $arguments[0];
				$related_field = $object->model;

				// Prepare field and value
				$field = (isset($arguments[1])) ? $arguments[1] : 'id';
				$value = (isset($arguments[2])) ? $arguments[2] : $object->id;
				$next_arg = 3;
			}
			else
			{
				$related_field = $arguments[0];
				// the TRUE allows conversion to singular
				$related_properties = $this->_get_related_properties($related_field, TRUE);
				$class = $related_properties['class'];
				// enables where_related_{model}($object)
				if(isset($arguments[1]) && is_object($arguments[1]))
				{
					$object = $arguments[1];
					// Prepare field and value
					$field = (isset($arguments[2])) ? $arguments[2] : 'id';
					$value = (isset($arguments[3])) ? $arguments[3] : $object->id;
					$next_arg = 4;
				}
				else
				{
					$object = new $class();
					// Prepare field and value
					$field = (isset($arguments[1])) ? $arguments[1] : 'id';
					$value = (isset($arguments[2])) ? $arguments[2] : NULL;
					$next_arg = 3;
				}
			}

			if(preg_replace('/[!=<> ]/ ', '', $field) == 'id')
			{
				// special case to prevent joining unecessary tables
				$field = $this->_add_related_table($object, $related_field, TRUE);
			}
			else
			{
				// Determine relationship table name, and join the tables
				$object_table = $this->_add_related_table($object, $related_field);
				$field = $object_table . '.' . $field;
			}

			if(is_string($value) && strpos($value, '${parent}') !== FALSE) {
				$extra = FALSE;
			}

			// allow special arguments to be passed into query methods
			if(is_null($extra)) {
				if(isset($arguments[$next_arg])) {
					$extra = $arguments[$next_arg];
				}
			}

			// Add query clause
			if(is_null($extra))
			{
				// convert where to where_in if the value is an array or a DM object
				if ($query == 'where')
				{
					if ( is_array($value) )
					{
						switch(count($value))
						{
							case 0:
								$value = NULL;
								break;
							case 1:
								$value = reset($value);
								break;
							default:
								$query = 'where_in';
								break;
						}
					}
					elseif ( $value instanceOf DataMapper )
					{
						switch($value->result_count())
						{
							case 0:
								$value = NULL;
								break;
							case 1:
								$value = $value->id;
								break;
							default:
								$query = 'where_in';
								break;
						}
					}
				}

				$this->{$query}($field, $value);
			}
			else
			{
				$this->{$query}($field, $value, $extra);
			}
		}

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Magic method to process a subquery for a related object.
	 * The format for this should be
	 *   $object->{where}_related_subquery($related_item, $related_field, $subquery)
	 * related_field is optional
	 *
	 * @ignore
	 * @param	string $query Query Method
	 * @param	object $args Arguments for the query
	 * @return	DataMapper Returns self for method chaining.
	 */
	private function _related_subquery($query, $args)
	{
		$rel_object = $args[0];
		$field = $value = NULL;
		if(isset($args[2])) {
			$field = $args[1];
			$value = $args[2];
		} else {
			$field = 'id';
			$value = $args[1];
		}
		if(is_object($value))
		{
			// see 25_activerecord.php
			$value = $this->_parse_subquery_object($value);
		}
		if(strpos($query, 'where_in') !== FALSE) {
			$query = str_replace('_in', '', $query);
			$field .= ' IN ';
		}
		return $this->_related($query, array($rel_object, $field, $value), FALSE);
	}

	// --------------------------------------------------------------------

	/**
	 * Is Related To
	 * If this object is related to the provided object, returns TRUE.
	 * Otherwise returns FALSE.
	 * Optionally can be provided a related field and ID.
	 *
	 * @param	mixed $related_field The related object or field name
	 * @param	int $id ID to compare to if $related_field is a string
	 * @return	bool TRUE or FALSE if this object is related to $related_field
	 */
	public function is_related_to($related_field, $id = NULL)
	{
		if(is_object($related_field))
		{
			$id = $related_field->id;
			$related_field = $related_field->model;
		}
		return ($this->{$related_field}->count(NULL, NULL, $id) > 0);
	}

	// --------------------------------------------------------------------

	/**
	 * Include Related
	 *
	 * Joins specified values of a has_one object into the current query
	 * If $fields is NULL or '*', then all columns are joined (may require instantiation of the other object)
	 * If $fields is a single string, then just that column is joined.
	 * Otherwise, $fields should be an array of column names.
	 *
	 * $append_name can be used to override the default name to append, or set it to FALSE to prevent appending.
	 *
	 * @param	mixed $related_field The related object or field name
	 * @param	array $fields The fields to join (NULL or '*' means all fields, or use a single field or array of fields)
	 * @param	bool $append_name The name to use for joining (with '_'), or FALSE to disable.
	 * @param	bool $instantiate If TRUE, the results are instantiated into objects
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function include_related($related_field, $fields = NULL, $append_name = TRUE, $instantiate = FALSE)
	{
		if (is_object($related_field))
		{
			$object = $related_field;
			$related_field = $object->model;
			$related_properties = $this->_get_related_properties($related_field);
		}
		else
		{
			// the TRUE allows conversion to singular
			$related_properties = $this->_get_related_properties($related_field, TRUE);
			$class = $related_properties['class'];
			$object = new $class();
		}

		if(is_null($fields) || $fields == '*')
		{
			$fields = $object->fields;
		}
		else if ( ! is_array($fields))
		{
			$fields = array((string)$fields);
		}

		$rfs = explode('/', $related_field);
		$last = $this;
		foreach($rfs as $rf)
		{
			// prevent populating the related items.
			$last =& $last->_get_without_auto_populating($rf);
		}

		$table = $this->_add_related_table($object, $related_field);

		$append = '';
		if($append_name !== FALSE)
		{
			if($append_name === TRUE)
			{
				$append = str_replace('/', '_', $related_field);
			}
			else
			{
				$append = $append_name;
			}
			$append .= '_';
		}

		// now add fields
		$selection = '';
		$property_map = array();
		foreach ($fields as $field)
		{
			$new_field = $append . $field;
			// prevent collisions
			if(in_array($new_field, $this->fields)) {
				if($instantiate && $field == 'id' && $new_field != 'id') {
					$property_map[$new_field] = $field;
				}
				continue;
			}
			if (!empty($selection))
			{
				$selection .= ', ';
			}
			$selection .= $table.'.'.$field.' AS '.$new_field;
			if($instantiate) {
				$property_map[$new_field] = $field;
			}
		}
		if(empty($selection))
		{
			log_message('debug', "DataMapper Warning (include_related): No fields were selected for {$this->model} on $related_field.");
		}
		else
		{
			if($instantiate)
			{
				if(is_null($this->_instantiations))
				{
					$this->_instantiations = array();
				}
				$this->_instantiations[$related_field] = $property_map;
			}
			$this->db->select($selection);
		}

		// For method chaining
		return $this;
	}

	/**
	 * Legacy version of include_related
	 * DEPRECATED: Will be removed by 2.0
	 * @deprecated Please use include_related
	 */
	public function join_related($related_field, $fields = NULL, $append_name = TRUE)
	{
		return $this->include_related($related_field, $fields, $append_name);
	}

	// --------------------------------------------------------------------

	/**
	 * Includes the number of related items using a subquery.
	 *
	 * Default alias is {$related_field}_count
	 *
	 * @param	mixed $related_field Field to count
	 * @param	string $alias  Alternative alias.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function include_related_count($related_field, $alias = NULL)
	{
		if (is_object($related_field))
		{
			$object = $related_field;
			$related_field = $object->model;
			$related_properties = $this->_get_related_properties($related_field);
		}
		else
		{
			// the TRUE allows conversion to singular
			$related_properties = $this->_get_related_properties($related_field, TRUE);
			$class = $related_properties['class'];
			$object = new $class();
		}

		if(is_null($alias))
		{
			$alias = $related_field . '_count';
		}

		// Force the selection of the current object's columns
		if (empty($this->db->ar_select))
		{
			$this->db->select($this->table . '.*');
		}

		// now generate a subquery for counting the related objects
		$object->select_func('COUNT', '*', 'count');
		$this_rel = $related_properties['other_field'];
		$tablename = $object->_add_related_table($this, $this_rel);
		$object->where($tablename . '.id  = ', $this->db->dm_call_method('_escape_identifiers', '${parent}.id'), FALSE);
		$this->select_subquery($object, $alias);
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Relation
	 *
	 * Finds all related records of this objects current record.
	 *
	 * @ignore
	 * @param	mixed $related_field Related field or object
	 * @param	int $id ID of related field or object
	 * @return	bool Sucess or Failure
	 */
	private function _get_relation($related_field, $id)
	{
		// No related items
		if (empty($related_field) || empty($id))
		{
			// Reset query
			$this->db->dm_call_method('_reset_select');

			return FALSE;
		}

		// To ensure result integrity, group all previous queries
		if( ! empty($this->db->ar_where))
		{
			array_unshift($this->db->ar_where, '( ');
			$this->db->ar_where[] = ' )';
		}

		// query all items related to the given model
		$this->where_related($related_field, 'id', $id);

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Save Relation
	 *
	 * Saves the relation between this and the other object.
	 *
	 * @ignore
	 * @param	DataMapper DataMapper Object to related to this object
	 * @param	string Specific related field if necessary.
	 * @return	bool Success or Failure
	 */
	protected function _save_relation($object, $related_field = '')
	{
		if (empty($related_field))
		{
			$related_field = $object->model;
		}

		// the TRUE allows conversion to singular
		$related_properties = $this->_get_related_properties($related_field, TRUE);

		if ( ! empty($related_properties) && $this->exists() && $object->exists())
		{
			$this_model = $related_properties['join_self_as'];
			$other_model = $related_properties['join_other_as'];
			$other_field = $related_properties['other_field'];

			// Determine relationship table name
			$relationship_table = $this->_get_relationship_table($object, $related_field);

			if($relationship_table == $this->table &&
			 		// catch for self relationships.
					in_array($other_model . '_id', $this->fields))
			{
				$this->{$other_model . '_id'} = $object->id;
				$ret =  $this->save();
				// remove any one-to-one relationships with the other object
				$this->_remove_other_one_to_one($related_field, $object);
				return $ret;
			}
			else if($relationship_table == $object->table)
			{
				$object->{$this_model . '_id'} = $this->id;
				$ret = $object->save();
				// remove any one-to-one relationships with this object
				$object->_remove_other_one_to_one($other_field, $this);
				return $ret;
			}
			else
			{
				$data = array($this_model . '_id' => $this->id, $other_model . '_id' => $object->id);

				// Check if relation already exists
				$query = $this->db->get_where($relationship_table, $data, NULL, NULL);

				if ($query->num_rows() == 0)
				{
					// If this object has a "has many" relationship with the other object
					if (isset($this->has_many[$related_field]))
					{
						// If the other object has a "has one" relationship with this object
						if (isset($object->has_one[$other_field]))
						{
							// And it has an existing relation
							$query = $this->db->get_where($relationship_table, array($other_model . '_id' => $object->id), 1, 0);

							if ($query->num_rows() > 0)
							{
								// Find and update the other objects existing relation to relate with this object
								$this->db->where($other_model . '_id', $object->id);
								$this->db->update($relationship_table, $data);
							}
							else
							{
								// Add the relation since one doesn't exist
								$this->db->insert($relationship_table, $data);
							}

							return TRUE;
						}
						else if (isset($object->has_many[$other_field]))
						{
							// We can add the relation since this specific relation doesn't exist, and a "has many" to "has many" relationship exists between the objects
							$this->db->insert($relationship_table, $data);

							// Self relationships can be defined as reciprocal -- save the reverse relationship at the same time
							if ($related_properties['reciprocal'])
							{
								$data = array($this_model . '_id' => $object->id, $other_model . '_id' => $this->id);
								$this->db->insert($relationship_table, $data);
							}

							return TRUE;
						}
					}
					// If this object has a "has one" relationship with the other object
					else if (isset($this->has_one[$related_field]))
					{
						// And it has an existing relation
						$query = $this->db->get_where($relationship_table, array($this_model . '_id' => $this->id), 1, 0);

						if ($query->num_rows() > 0)
						{
							// Find and update the other objects existing relation to relate with this object
							$this->db->where($this_model . '_id', $this->id);
							$this->db->update($relationship_table, $data);
						}
						else
						{
							// Add the relation since one doesn't exist
							$this->db->insert($relationship_table, $data);
						}

						return TRUE;
					}
				}
				else
				{
					// Relationship already exists
					return TRUE;
				}
			}
		}
		else
		{
			if( ! $object->exists())
			{
				$msg = 'dm_save_rel_noobj';
			}
			else if( ! $this->exists())
			{
				$msg = 'dm_save_rel_nothis';
			}
			else
			{
				$msg = 'dm_save_rel_failed';
			}
			$msg = $this->lang->line($msg);
			$this->error_message($related_field, sprintf($msg, $related_field));
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Remove Other One-to-One
	 * Removes other relationships on a one-to-one ITFK relationship
	 *
	 * @ignore
	 * @param string $rf Related field to look at.
	 * @param DataMapper $object Object to look at.
	 */
	private function _remove_other_one_to_one($rf, $object)
	{
		if( ! $object->exists())
		{
			return;
		}
		$related_properties = $this->_get_related_properties($rf, TRUE);
		if( ! array_key_exists($related_properties['other_field'], $object->has_one))
		{
			return;
		}
		// This should be a one-to-one relationship with an ITFK if we got this far.
		$other_column = $related_properties['join_other_as'] . '_id';
		$c = get_class($this);
		$update = new $c();

		$update->where($other_column, $object->id);
		if($this->exists())
		{
			$update->where('id <>', $this->id);
		}
		$update->update($other_column, NULL);
	}

	// --------------------------------------------------------------------

	/**
	 * Delete Relation
	 *
	 * Deletes the relation between this and the other object.
	 *
	 * @ignore
	 * @param	DataMapper $object Object to remove the relationship to.
	 * @param	string $related_field Optional specific related field
	 * @return	bool Success or Failure
	 */
	protected function _delete_relation($object, $related_field = '')
	{
		if (empty($related_field))
		{
			$related_field = $object->model;
		}

		// the TRUE allows conversion to singular
		$related_properties = $this->_get_related_properties($related_field, TRUE);

		if ( ! empty($related_properties) && ! empty($this->id) && ! empty($object->id))
		{
			$this_model = $related_properties['join_self_as'];
			$other_model = $related_properties['join_other_as'];

			// Determine relationship table name
			$relationship_table = $this->_get_relationship_table($object, $related_field);

			if ($relationship_table == $this->table &&
			 		// catch for self relationships.
					in_array($other_model . '_id', $this->fields))
			{
				$this->{$other_model . '_id'} = NULL;
				$this->save();
			}
			else if ($relationship_table == $object->table)
			{
				$object->{$this_model . '_id'} = NULL;
				$object->save();
			}
			else
			{
				$data = array($this_model . '_id' => $this->id, $other_model . '_id' => $object->id);

				// Delete relation
				$this->db->delete($relationship_table, $data);

				// Delete reverse direction if a reciprocal self relationship
				if ($related_properties['reciprocal'])
				{
					$data = array($this_model . '_id' => $object->id, $other_model . '_id' => $this->id);
					$this->db->delete($relationship_table, $data);
				}
			}

			// Clear related object so it is refreshed on next access
			unset($this->{$related_field});

			return TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Relationship Table
	 *
	 * Determines the relationship table between this object and $object.
	 *
	 * @ignore
	 * @param	DataMapper $object Object that we are interested in.
	 * @param	string $related_field Optional specific related field.
	 * @return	string The name of the table this relationship is stored on.
	 */
	public function _get_relationship_table($object, $related_field = '')
	{
		$prefix = $object->prefix;
		$table = $object->table;

		if (empty($related_field))
		{
			$related_field = $object->model;
		}

		$related_properties = $this->_get_related_properties($related_field);
		$this_model = $related_properties['join_self_as'];
		$other_model = $related_properties['join_other_as'];
		$other_field = $related_properties['other_field'];

		if (isset($this->has_one[$related_field]))
		{
			// see if the relationship is in this table
			if (in_array($other_model . '_id', $this->fields))
			{
				return $this->table;
			}
		}

		if (isset($object->has_one[$other_field]))
		{
			// see if the relationship is in this table
			if (in_array($this_model . '_id', $object->fields))
			{
				return $object->table;
			}
		}

		// was a join table defined for this relation?
		if ( ! empty($related_properties['join_table']) )
		{
			$relationship_table = $related_properties['join_table'];
		}
		else
		{
			$relationship_table = '';

			// Check if self referencing
			if ($this->table == $table)
			{
				// use the model names from related_properties
				$p_this_model = plural($this_model);
				$p_other_model = plural($other_model);
				$relationship_table = ($p_this_model < $p_other_model) ? $p_this_model . '_' . $p_other_model : $p_other_model . '_' . $p_this_model;
			}
			else
			{
				$relationship_table = ($this->table < $table) ? $this->table . '_' . $table : $table . '_' . $this->table;
			}

			// Remove all occurances of the prefix from the relationship table
			$relationship_table = str_replace($prefix, '', str_replace($this->prefix, '', $relationship_table));

			// So we can prefix the beginning, using the join prefix instead, if it is set
			$relationship_table = (empty($this->join_prefix)) ? $this->prefix . $relationship_table : $this->join_prefix . $relationship_table;
		}

		return $relationship_table;
	}

	// --------------------------------------------------------------------

	/**
	 * Count Related
	 *
	 * Returns the number of related items in the database and in the related object.
	 * Used by the _related_(required|min|max) validation rules.
	 *
	 * @ignore
	 * @param	string $related_field The related field.
	 * @param	mixed $object Object or array to include in the count.
	 * @return	int Number of related items.
	 */
	protected function _count_related($related_field, $object = '')
	{
		$count = 0;

		// lookup relationship info
		// the TRUE allows conversion to singular
		$rel_properties = $this->_get_related_properties($related_field, TRUE);
		$class = $rel_properties['class'];

		$ids = array();

		if ( ! empty($object))
		{
			$count = $this->_count_related_objects($related_field, $object, '', $ids);
			$ids = array_unique($ids);
		}

		if ( ! empty($related_field) && ! empty($this->id))
		{
			$one = isset($this->has_one[$related_field]);

			// don't bother looking up relationships if this is a $has_one and we already have one.
			if( (!$one) || empty($ids))
			{
				// Prepare model
				$object = new $class();

				// Store parent data
				$object->parent = array('model' => $rel_properties['other_field'], 'id' => $this->id);

				// pass in IDs to exclude from the count

				$count += $object->count($ids);
			}
		}

		return $count;
	}

	// --------------------------------------------------------------------

	/**
	 * Private recursive function to count the number of objects
	 * in a passed in array (or a single object)
	 *
	 * @ignore
	 * @param	string $compare related field (model) to compare to
	 * @param	mixed $object Object or array to count
	 * @param	string $related_field related field of $object
	 * @param	array $ids list of IDs we've already found.
	 * @return	int Number of items found.
	 */
	private function _count_related_objects($compare, $object, $related_field, &$ids)
	{
		$count = 0;
		if (is_array($object))
		{
			// loop through array to check for objects
			foreach ($object as $rel_field => $obj)
			{
				if ( ! is_string($rel_field))
				{
					// if this object doesn't have a related field, use the parent related field
					$rel_field = $related_field;
				}
				$count += $this->_count_related_objects($compare, $obj, $rel_field, $ids);
			}
		}
		else
		{
			// if this object doesn't have a related field, use the model
			if (empty($related_field))
			{
				$related_field = $object->model;
			}
			// if this object is the same relationship type, it counts
			if ($related_field == $compare && $object->exists())
			{
				$ids[] = $object->id;
				$count++;
			}
		}
		return $count;
	}

	// --------------------------------------------------------------------

	/**
	 * Include Join Fields
	 *
	 * If TRUE, the any extra fields on the join table will be included
	 *
	 * @param	bool $include If FALSE, turns back off the directive.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function include_join_fields($include = TRUE)
	{
		$this->_include_join_fields = $include;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Join Field
	 *
	 * Sets the value on a join table based on the related field
	 * If $related_field is an array, then the array should be
	 * in the form $related_field => $object or array($object)
	 *
	 * @param	mixed $related_field An object or array.
	 * @param	mixed $field Field or array of fields to set.
	 * @param	mixed $value Value for a single field to set.
	 * @param	mixed $object Private for recursion, do not use.
	 * @return	DataMapper Returns self for method chaining.
	 */
	public function set_join_field($related_field, $field, $value = NULL, $object = NULL)
	{
		$related_ids = array();

		if (is_array($related_field))
		{
			// recursively call this on the array passed in.
			foreach ($related_field as $key => $object)
			{
				$this->set_join_field($key, $field, $value, $object);
			}
			return;
		}
		else if (is_object($related_field))
		{
			$object = $related_field;
			$related_field = $object->model;
			$related_ids[] = $object->id;
			$related_properties = $this->_get_related_properties($related_field);
		}
		else
		{
			// the TRUE allows conversion to singular
			$related_properties = $this->_get_related_properties($related_field, TRUE);
			if (is_null($object))
			{
				$class = $related_properties['class'];
				$object = new $class();
			}
		}

		// Determine relationship table name
		$relationship_table = $this->_get_relationship_table($object, $related_field);

		if (empty($object))
		{
			// no object was passed in, so create one
			$class = $related_properties['class'];
			$object = new $class();
		}

		$this_model = $related_properties['join_self_as'];
		$other_model = $related_properties['join_other_as'];

		if (! is_array($field))
		{
			$field = array( $field => $value );
		}

		if ( ! is_array($object))
		{
			$object = array($object);
		}

		if (empty($object))
		{
			$this->db->where($this_model . '_id', $this->id);
			$this->db->update($relationship_table, $field);
		}
		else
		{
			foreach ($object as $obj)
			{
				$this->db->where($this_model . '_id', $this->id);
				$this->db->where($other_model . '_id', $obj->id);
				$this->db->update($relationship_table, $field);
			}
		}

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Join Field
	 *
	 * Adds a query of a join table's extra field
	 * Accessed via __call
	 *
	 * @ignore
	 * @param	string $query Query method.
	 * @param	array $arguments Arguments for query.
	 * @return	DataMapper Returns self for method chaining.
	 */
	private function _join_field($query, $arguments)
	{
		if ( ! empty($query) && count($arguments) >= 3)
		{
			$object = $field = $value = NULL;

			// Prepare model
			if (is_object($arguments[0]))
			{
				$object = $arguments[0];
				$related_field = $object->model;
			}
			else
			{
				$related_field = $arguments[0];
				// the TRUE allows conversion to singular
				$related_properties = $this->_get_related_properties($related_field, TRUE);
				$class = $related_properties['class'];
				$object = new $class();
			}


			// Prepare field and value
			$field = $arguments[1];
			$value = $arguments[2];

			// Determine relationship table name, and join the tables
			$rel_table = $this->_get_relationship_table($object, $related_field);

			// Add query clause
			$extra = NULL;
			if(count($arguments) > 3) {
				$extra = $arguments[3];
			}
			if(is_null($extra)) {
				$this->{$query}($rel_table . '.' . $field, $value);
			} else {
				$this->{$query}($rel_table . '.' . $field, $value, $extra);
			}
		}

		// For method chaining
		return $this;
	}

	// --------------------------------------------------------------------


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *																   *
	 * Related Validation methods										*
	 *																   *
	 * The following are methods used to validate the					*
	 * relationships of this object.									 *
	 *																   *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


	// --------------------------------------------------------------------

	/**
	 * Related Required (pre-process)
	 *
	 * Checks if the related object has the required related item
	 * or if the required relation already exists.
	 *
	 * @ignore
	 */
	protected function _related_required($object, $model)
	{
		return ($this->_count_related($model, $object) == 0) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Related Min Size (pre-process)
	 *
	 * Checks if the value of a property is at most the minimum size.
	 *
	 * @ignore
	 */
	protected function _related_min_size($object, $model, $size = 0)
	{
		return ($this->_count_related($model, $object) < $size) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Related Max Size (pre-process)
	 *
	 * Checks if the value of a property is at most the maximum size.
	 *
	 * @ignore
	 */
	protected function _related_max_size($object, $model, $size = 0)
	{
		return ($this->_count_related($model, $object) > $size) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *																   *
	 * Validation methods												*
	 *																   *
	 * The following are methods used to validate the					*
	 * values of this objects properties.								*
	 *																   *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */


	// --------------------------------------------------------------------

	/**
	 * Always Validate
	 *
	 * Does nothing, but forces a validation even if empty (for non-required fields)
	 *
	 * @ignore
	 */
	protected function _always_validate()
	{
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha Dash Dot (pre-process)
	 *
	 * Alpha-numeric with underscores, dashes and full stops.
	 *
	 * @ignore
	 */
	protected function _alpha_dash_dot($field)
	{
		return ( ! preg_match('/^([\.-a-z0-9_-])+$/i', $this->{$field})) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Alpha Slash Dot (pre-process)
	 *
	 * Alpha-numeric with underscores, dashes, forward slashes and full stops.
	 *
	 * @ignore
	 */
	protected function _alpha_slash_dot($field)
	{
		return ( ! preg_match('/^([\.\/-a-z0-9_-])+$/i', $this->{$field})) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Matches (pre-process)
	 *
	 * Match one field to another.
	 * This replaces the version in CI_Form_validation.
	 *
	 * @ignore
	 */
	protected function _matches($field, $other_field)
	{
		return ($this->{$field} !== $this->{$other_field}) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Min Date (pre-process)
	 *
	 * Checks if the value of a property is at least the minimum date.
	 *
	 * @ignore
	 */
	protected function _min_date($field, $date)
	{
		return (strtotime($this->{$field}) < strtotime($date)) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Max Date (pre-process)
	 *
	 * Checks if the value of a property is at most the maximum date.
	 *
	 * @ignore
	 */
	protected function _max_date($field, $date)
	{
		return (strtotime($this->{$field}) > strtotime($date)) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Min Size (pre-process)
	 *
	 * Checks if the value of a property is at least the minimum size.
	 *
	 * @ignore
	 */
	protected function _min_size($field, $size)
	{
		return ($this->{$field} < $size) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Max Size (pre-process)
	 *
	 * Checks if the value of a property is at most the maximum size.
	 *
	 * @ignore
	 */
	protected function _max_size($field, $size)
	{
		return ($this->{$field} > $size) ? FALSE : TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Unique (pre-process)
	 *
	 * Checks if the value of a property is unique.
 	 * If the property belongs to this object, we can ignore it.
 	 *
	 * @ignore
	 */
	protected function _unique($field)
	{
		if ( ! empty($this->{$field}))
		{
			$query = $this->db->get_where($this->table, array($field => $this->{$field}), 1, 0);

			if ($query->num_rows() > 0)
			{
				$row = $query->row();

				// If unique value does not belong to this object
				if ($this->id != $row->id)
				{
					// Then it is not unique
					return FALSE;
				}
			}
		}

		// No matches found so is unique
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Unique Pair (pre-process)
	 *
	 * Checks if the value of a property, paired with another, is unique.
 	 * If the properties belongs to this object, we can ignore it.
	 *
	 * @ignore
	 */
	protected function _unique_pair($field, $other_field = '')
	{
		if ( ! empty($this->{$field}) && ! empty($this->{$other_field}))
		{
			$query = $this->db->get_where($this->table, array($field => $this->{$field}, $other_field => $this->{$other_field}), 1, 0);

			if ($query->num_rows() > 0)
			{
				$row = $query->row();

				// If unique pair value does not belong to this object
				if ($this->id != $row->id)
				{
					// Then it is not a unique pair
					return FALSE;
				}
			}
		}

		// No matches found so is unique
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Date (pre-process)
	 *
	 * Checks whether the field value is a valid DateTime.
	 *
	 * @ignore
	 */
	protected function _valid_date($field)
	{
		// Ignore if empty
		if (empty($this->{$field}))
		{
			return TRUE;
		}

		$date = date_parse($this->{$field});

		return checkdate($date['month'], $date['day'],$date['year']);
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Date Group (pre-process)
	 *
	 * Checks whether the field value, grouped with other field values, is a valid DateTime.
	 *
	 * @ignore
	 */
	protected function _valid_date_group($field, $fields = array())
	{
		// Ignore if empty
		if (empty($this->{$field}))
		{
			return TRUE;
		}

		$date = date_parse($this->{$fields['year']} . '-' . $this->{$fields['month']} . '-' . $this->{$fields['day']});

		return checkdate($date['month'], $date['day'],$date['year']);
	}

	// --------------------------------------------------------------------

	/**
	 * Valid Match (pre-process)
	 *
	 * Checks whether the field value matches one of the specified array values.
	 *
	 * @ignore
	 */
	protected function _valid_match($field, $param = array())
	{
		return in_array($this->{$field}, $param);
	}

	// --------------------------------------------------------------------

	/**
	 * Boolean (pre-process)
	 *
	 * Forces a field to be either TRUE or FALSE.
	 * Uses PHP's built-in boolean conversion.
	 *
	 * @ignore
	 */
	protected function _boolean($field)
	{
		$this->{$field} = (boolean)$this->{$field};
	}

	// --------------------------------------------------------------------

	/**
	 * Encode PHP Tags (prep)
	 *
	 * Convert PHP tags to entities.
	 * This replaces the version in CI_Form_validation.
	 *
	 * @ignore
	 */
	protected function _encode_php_tags($field)
	{
		$this->{$field} = encode_php_tags($this->{$field});
	}

	// --------------------------------------------------------------------

	/**
	 * Prep for Form (prep)
	 *
	 * Converts special characters to allow HTML to be safely shown in a form.
	 * This replaces the version in CI_Form_validation.
	 *
	 * @ignore
	 */
	protected function _prep_for_form($field)
	{
		$this->{$field} = $this->form_validation->prep_for_form($this->{$field});
	}

	// --------------------------------------------------------------------

	/**
	 * Prep URL (prep)
	 *
	 * Adds "http://" to URLs if missing.
	 * This replaces the version in CI_Form_validation.
	 *
	 * @ignore
	 */
	protected function _prep_url($field)
	{
		$this->{$field} = $this->form_validation->prep_url($this->{$field});
	}

	// --------------------------------------------------------------------

	/**
	 * Strip Image Tags (prep)
	 *
	 * Strips the HTML from image tags leaving the raw URL.
	 * This replaces the version in CI_Form_validation.
	 *
	 * @ignore
	 */
	protected function _strip_image_tags($field)
	{
		$this->{$field} = strip_image_tags($this->{$field});
	}

	// --------------------------------------------------------------------

	/**
	 * XSS Clean (prep)
	 *
	 * Runs the data through the XSS filtering function, described in the Input Class page.
	 * This replaces the version in CI_Form_validation.
	 *
	 * @ignore
	 */
	protected function _xss_clean($field, $is_image = FALSE)
	{
		$this->{$field} = xss_clean($this->{$field}, $is_image);
	}


	// --------------------------------------------------------------------

	/**
	 * Trim
	 * Custom trim rule that ignores NULL values
	 *
	 * @ignore
	 */
	protected function _trim($field) {
		if( ! empty($this->{$field})) {
			$this->{$field} = trim($this->{$field});
		}
	}

	// --------------------------------------------------------------------


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 *																   *
	 * Common methods													*
	 *																   *
	 * The following are common methods used by other methods.		   *
	 *																   *
	 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	// --------------------------------------------------------------------

	/**
	 * A specialized language lookup function that will automatically
	 * insert the model, table, and (optional) field into a key, and return the
	 * language result for the replaced key.
	 *
	 * @param string $key Basic key to use
	 * @param string $field Optional field value
	 * @return string|bool
	 */
	public function localize_by_model($key, $field = NULL)
	{
		$s = array('${model}', '${table}');
		$r = array($this->model, $this->table);
		if(!is_null($field))
		{
			$s[] = '${field}';
			$r[] = $field;
		}
		$key = str_replace($s, $r, $key);
		return $this->lang->line($key);
	}

	// --------------------------------------------------------------------

	/**
	 * Variant that handles looking up a field labels
	 * @param string $field Name of field
	 * @param string|bool $label If not FALSE overrides default label.
	 * @return string|bool
	 */
	public function localize_label($field, $label = FALSE)
	{
		if($label === FALSE)
		{
			$label = $field;
			if(!empty($this->field_label_lang_format))
			{
				$label = $this->localize_by_model($this->field_label_lang_format, $field);
				if($label === FALSE)
				{
					$label = $field;
				}
			}
		}
		else if(strpos($label, 'lang:') === 0)
		{
			$label = $this->localize_by_model(substr($label, 5), $field);
		}
		return $label;
	}

	// --------------------------------------------------------------------

	/**
	 * Allows you to define has_one relations at runtime
	 * @param 	string	name of the model to make a relation with
	 * @param 	array	optional, array with advanced relationship definitions
	 * @return 	bool
	 */
	public function has_one( $parm1 = NULL, $parm2 = NULL )
	{
		if ( is_null($parm1) && is_null($parm2) )
		{
			return FALSE;
		}
		elseif ( is_array($parm2) )
		{
			return $this->_relationship('has_one', $parm2, $parm1);
		}
		else
		{
			return $this->_relationship('has_one', $parm1, 0);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Allows you to define has_many relations at runtime
	 * @param 	string	name of the model to make a relation with
	 * @param 	array	optional, array with advanced relationship definitions
	 * @return 	bool
	 */
	public function has_many( $parm1 = NULL, $parm2 = NULL )
	{
		if ( is_null($parm1) && is_null($parm2) )
		{
			return FALSE;
		}
		elseif ( is_array($parm2) )
		{
			return $this->_relationship('has_many', $parm2, $parm1);
		}
		else
		{
			return $this->_relationship('has_many', $parm1, 0);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Creates or updates the production schema cache file for this model
	 * @param 	void
	 * @return 	void
	 */
	public function production_cache()
	{
		// if requested, store the item to the production cache
		if( ! empty(DataMapper::$config['production_cache']))
		{
			// check if it's a fully qualified path first
			if (!is_dir($cache_folder = DataMapper::$config['production_cache']))
			{
				// if not, it's relative to the application path
				$cache_folder = APPPATH . DataMapper::$config['production_cache'];
			}
			if(file_exists($cache_folder) && is_dir($cache_folder) && is_writeable($cache_folder))
			{
				$common_key = DataMapper::$common[DMZ_CLASSNAMES_KEY][strtolower(get_class($this))];
				$cache_file = $cache_folder . '/' . $common_key . EXT;
				$cache = "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); \n";

				$cache .= '$cache = ' . var_export(DataMapper::$common[$common_key], TRUE) . ';';

				if ( ! $fp = @fopen($cache_file, 'w'))
				{
					show_error('Error creating production cache file: ' . $cache_file);
				}

				flock($fp, LOCK_EX);
				fwrite($fp, $cache);
				flock($fp, LOCK_UN);
				fclose($fp);

				@chmod($cache_file, FILE_WRITE_MODE);
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Define a new relationship for the current model
	 */
	protected function _relationship($type = '', $definition = array(), $name = 0)
	{
		// check the parameters
		if (empty($type) OR ! in_array($type, array('has_one','has_many')))
		{
			return FALSE;
		}

		// allow for simple (old-style) associations
		if (is_int($name))
		{
			// delete the old style entry, we're going to convert it
			if (isset($this->{$type}[$name]))
			{
				unset($this->{$type}[$name]);
			}
			$name = $definition;
		}

		// get the current relationships
		$new = (array) $this->{$type};

		// convert value into array if necessary
		if ( ! is_array($definition))
		{
			$definition = array('class' => $definition);
		}
		else if ( ! isset($definition['class']))
		{
			// if already an array, ensure that the class attribute is set
			$definition['class'] = $name;
		}
		if( ! isset($definition['other_field']))
		{
			// add this model as the model to use in queries if not set
			$definition['other_field'] = $this->model;
		}
		if( ! isset($definition['join_self_as']))
		{
			// add this model as the model to use in queries if not set
			$definition['join_self_as'] = $definition['other_field'];
		}
		if( ! isset($definition['join_other_as']))
		{
			// add the key as the model to use in queries if not set
			$definition['join_other_as'] = $name;
		}
		if( ! isset($definition['join_table']))
		{
			// by default, automagically determine the join table name
			$definition['join_table'] = '';
		}
		if( isset($definition['model_path']))
		{
			$definition['model_path'] = rtrim($definition['model_path'], '/') . '/';
			if ( is_dir($definition['model_path'].'models') && ! in_array($definition['model_path'], self::$model_paths))
			{
				self::$model_paths[] = $definition['model_path'];
			}
		}
		if(isset($definition['reciprocal']))
		{
			// only allow a reciprocal relationship to be defined if this is a has_many self relationship
			$definition['reciprocal'] = ($definition['reciprocal'] && $type == 'has_many' && $definition['class'] == strtolower(get_class($this)));
		}
		else
		{
			$definition['reciprocal'] = FALSE;
		}
		if(!isset($definition['auto_populate']) OR ! is_bool($definition['auto_populate']))
		{
			$definition['auto_populate'] = NULL;
		}
		if(!isset($definition['cascade_delete']) OR ! is_bool($definition['cascade_delete']))
		{
			$definition['cascade_delete'] = $this->cascade_delete;
		}

		$new[$name] = $definition;

		// load in labels for each not-already-set field
		if(!isset($this->validation[$name]))
		{
			$label = $this->localize_label($name);
			if(!empty($label))
			{
				// label is re-set below, to prevent caching language-based labels
				$this->validation[$name] = array('field' => $name, 'rules' => array());
			}
		}

		// replace the old array
		$this->{$type} = $new;
	}

	// --------------------------------------------------------------------

	/**
	 * To Array
	 *
	 * Converts this objects current record into an array for database queries.
	 * If validate is TRUE (getting by objects properties) empty objects are ignored.
	 *
	 * @ignore
	 * @param	bool $validate
	 * @return	array
	 */
	protected function _to_array($validate = FALSE)
	{
		$data = array();

		foreach ($this->fields as $field)
		{
			if ($validate && ! isset($this->{$field}))
			{
				continue;
			}

			$data[$field] = $this->{$field};
		}

		return $data;
	}

	// --------------------------------------------------------------------

	/**
	 * Process Query
	 *
	 * Converts a query result into an array of objects.
	 * Also updates this object
	 *
	 * @ignore
	 * @param	CI_DB_result $query
	 */
	protected function _process_query($query)
	{
		if ($query->num_rows() > 0)
		{
			// Populate all with records as objects
			$this->all = array();

			$this->_to_object($this, $query->row());

			// don't bother recreating the first item.
			$index = ($this->all_array_uses_ids && isset($this->id)) ? $this->id : 0;
			$this->all[$index] = $this->get_clone();

			if($query->num_rows() > 1)
			{
				$model = get_class($this);

				$first = TRUE;

				foreach ($query->result() as $row)
				{
					if($first)
					{
						$first = FALSE;
						continue;
					}

					$item = new $model();

					$this->_to_object($item, $row);

					if($this->all_array_uses_ids && isset($item->id))
					{
						$this->all[$item->id] = $item;
					}
					else
					{
						$this->all[] = $item;
					}
				}
			}

			// remove instantiations
			$this->_instantiations = NULL;

			// free large queries
			if($query->num_rows() > $this->free_result_threshold)
			{
				$query->free_result();
			}
		}
		else
		{
			// Refresh stored values is called by _to_object normally
			$this->_refresh_stored_values();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * To Object
	 * Copies the values from a query result row to an object.
	 * Also initializes that object by running get rules, and
	 *   refreshing stored values on the object.
	 *
	 * Finally, if any "instantiations" are requested, those related objects
	 *   are created off of query results
	 *
	 * This is only public so that the iterator can access it.
	 *
	 * @ignore
	 * @param	DataMapper $item Item to configure
	 * @param	object $row Query results
	 */
	public function _to_object($item, $row)
	{
		// Populate this object with values from first record
		foreach ($row as $key => $value)
		{
			$item->{$key} = $value;
		}

		foreach ($this->fields as $field)
		{
			if (! isset($row->{$field}))
			{
				$item->{$field} = NULL;
			}
		}

		// Force IDs to integers
		foreach($this->_field_tracking['intval'] as $field)
		{
			if(isset($item->{$field}))
			{
				$item->{$field} = intval($item->{$field});
			}
		}

		if (!empty($this->_field_tracking['get_rules']))
		{
			$item->_run_get_rules();
		}

		$item->_refresh_stored_values();

		if($this->_instantiations) {
			foreach($this->_instantiations as $related_field => $field_map) {
				// convert fields to a 'row' object
				$row = new stdClass();
				foreach($field_map as $item_field => $c_field) {
					$row->{$c_field} = $item->{$item_field};
				}

				// get the related item
				$c =& $item->_get_without_auto_populating($related_field);
				// set the values
				$c->_to_object($c, $row);

				// also set up the ->all array
				$c->all = array();
				$c->all[0] = $c->get_clone();
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Run Get Rules
	 *
	 * Processes values loaded from the database
	 *
	 * @ignore
	 */
	protected function _run_get_rules()
	{
		// Loop through each property to be validated
		foreach ($this->_field_tracking['get_rules'] as $field)
		{
			// Get validation settings
			$rules = $this->validation[$field]['get_rules'];

			// only process non-empty keys that are not specifically
			// set to be null
			if( ! isset($this->{$field}) && ! in_array('allow_null', $rules))
			{
				if(isset($this->has_one[$field]))
				{
					// automatically process $item_id values
					$field = $field . '_id';
					if( ! isset($this->{$field}) && ! in_array('allow_null', $rules))
					{
						continue;
					}
				} else {
					continue;
				}
			}

			// Loop through each rule to validate this property against
			foreach ($rules as $rule => $param)
			{
				// Check for parameter
				if (is_numeric($rule))
				{
					$rule = $param;
					$param = '';
				}
				if($rule == 'allow_null')
				{
					continue;
				}

				if (method_exists($this, '_' . $rule))
				{
					// Run rule from DataMapper or the class extending DataMapper
					$result = $this->{'_' . $rule}($field, $param);
				}
				else if($this->_extension_method_exists('rule_' . $rule))
				{
					// Run an extension-based rule.
					$result = $this->{'rule_' . $rule}($field, $param);
				}
				else if (method_exists($this->form_validation, $rule))
				{
					// Run rule from CI Form Validation
					$result = $this->form_validation->{$rule}($this->{$field}, $param);
				}
				else if (function_exists($rule))
				{
					// Run rule from PHP
					$this->{$field} = $rule($this->{$field});
				}
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Refresh Stored Values
	 *
	 * Refreshes the stored values with the current values.
	 *
	 * @ignore
	 */
	protected function _refresh_stored_values()
	{
		// Update stored values
		foreach ($this->fields as $field)
		{
			$this->stored->{$field} = $this->{$field};
		}

		// If there is a "matches" validation rule, match the field value with the other field value
		foreach ($this->_field_tracking['matches'] as $field_name => $match_name)
		{
			$this->{$field_name} = $this->stored->{$field_name} = $this->{$match_name};
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Assign Libraries
	 *
	 * Originally used by CodeIgniter, now just logs a warning.
	 *
	 * @ignore
	 */
	public function _assign_libraries()
	{
		log_message('debug', "Warning: A DMZ model ({$this->model}) was either loaded via autoload, or manually.  DMZ automatically loads models, so this is unnecessary.");
	}

	// --------------------------------------------------------------------

	/**
	 * Assign Libraries
	 *
	 * Assigns required CodeIgniter libraries to DataMapper.
	 *
	 * @ignore
	 */
	protected function _dmz_assign_libraries()
	{
		static $CI;
		if ($CI || $CI =& get_instance())
		{
			// make sure these exists to not trip __get()
			$this->load = NULL;
			$this->config = NULL;
			$this->lang = NULL;

			// access to the loader
			$this->load =& $CI->load;

			// to the config
			$this->config =& $CI->config;

			// and the language class
			$this->lang =& $CI->lang;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Load Languages
	 *
	 * Loads required language files.
	 *
	 * @ignore
	 */
	protected function _load_languages()
	{

		// Load the DataMapper language file
		$this->lang->load('datamapper');
	}

	// --------------------------------------------------------------------

	/**
	 * Load Helpers
	 *
	 * Loads required CodeIgniter helpers.
	 *
	 * @ignore
	 */
	protected function _load_helpers()
	{
		// Load inflector helper for singular and plural functions
		$this->load->helper('inflector');

		// Load security helper for prepping functions
		$this->load->helper('security');
	}
}

/**
 * Simple class to prevent errors with unset fields.
 * @package DMZ
 *
 * @param string $FIELD Get the error message for a given field or custom error
 * @param string $RELATED Get the error message for a given relationship
 * @param string $transaction Get the transaction error.
 */
class DM_Error_Object {
	/**
	 * Array of all error messages.
	 * @var array
	 */
	public $all = array();

	/**
	 * String containing entire error message.
	 * @var string
	 */
	public $string = '';

	/**
	 * All unset fields are returned as empty strings by default.
	 * @ignore
	 * @param string $field
	 * @return string Empty string
	 */
	public function __get($field) {
		return '';
	}
}



/**
 * Iterator for get_iterated
 *
 * @package DMZ
 */
class DM_DatasetIterator implements Iterator, Countable
{
	/**
	 * The parent DataMapper object that contains important info.
	 * @var DataMapper
	 */
	protected $parent;
	/**
	 * The temporary DM object used in the loops.
	 * @var DataMapper
	 */
	protected $object;
	/**
	 * Results array
	 * @var array
	 */
	protected $result;
	/**
	 * Number of results
	 * @var int
	 */
	protected $count;
	/**
	 * Current position
	 * @var int
	 */
	protected $pos;

	/**
	 * @param DataMapper $object Should be cloned ahead of time
	 * @param DB_result $query result from a CI DB query
	 */
	function __construct($object, $query)
	{
		// store the object as a main object
		$this->parent = $object;

		// clone the parent object, so it can be manipulated safely.
		$this->object = $object->get_clone();

		// Now get the information on the current query object
		$this->result = $query->result();
		$this->count = count($this->result);
		$this->pos = 0;
	}

	/**
	 * Gets the item at the current index $pos
	 * @return DataMapper
	 */
	function current()
	{
		return $this->get($this->pos);
	}

	function key()
	{
		return $this->pos;
	}

	/**
	 * Gets the item at index $index
	 * @param int $index
	 * @return DataMapper
	 */
	function get($index) {
		// clear to ensure that the item is not duplicating data
		$this->object->clear();
		// set the current values on the object
		$this->parent->_to_object($this->object, $this->result[$index]);
		return $this->object;
	}

	function next()
	{
		$this->pos++;
	}

	function rewind()
	{
		$this->pos = 0;
	}

	function valid()
	{
		return ($this->pos < $this->count);
	}

	/**
	 * Returns the number of results
	 * @return int
	 */
	function count()
	{
		return $this->count;
	}

	// Alias for count();
	function result_count() {
		return $this->count;
	}
}


// --------------------------------------------------------------------------

/**
 * Autoload
 *
 * Autoloads object classes that are used with DataMapper.
 * Must be at end due to implements IteratorAggregate...
 */
spl_autoload_register('DataMapper::autoload');

/* End of file datamapper.php */
/* Location: ./application/models/datamapper.php */
