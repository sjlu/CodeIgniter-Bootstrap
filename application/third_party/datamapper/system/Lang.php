<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Data Mapper ORM bootstrap
 *
 * Dynamic CI Lang class extension
 *
 * @license 	MIT License
 * @package		DataMapper ORM
 * @category	DataMapper ORM
 * @author  	Harro "WanWizard" Verton
 * @link		http://datamapper.wanwizard.eu/
 * @version 	2.0.0
 */

$dmclass = <<<CODE
class DM_Lang extends $name
{
	/**
	 * Fetch a single line of text from the language array
	 *
	 * @access	public
	 * @param	string	\$line	the language line
	 * @return	string
	 */
	function dm_line(\$line = '')
	{
		return (\$line == '' OR ! isset(\$this->language[\$line])) ? FALSE : \$this->language[\$line];
	}
}
CODE;

// dynamically add our class extension
eval($dmclass);
unset($dmclass);

// and update the name of the class to instantiate
$name = 'DM_Lang';

/* End of file Lang.php */
/* Location: ./application/third_party/datamapper/system/Lang.php */
