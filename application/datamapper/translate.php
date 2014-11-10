<?php

/**
 * Translate Extension for DataMapper classes.
 *
 * Translate DataMapper model fields containing language strings
 *
 * @license 	MIT License
 * @package		DMZ-Included-Extensions
 * @category	DMZ
 * @author  	WanWizard
 * @version 	1.0
 */

// --------------------------------------------------------------------------

/**
 * DMZ_Translate Class
 *
 * @package		DMZ-Included-Extensions
 */
class DMZ_Translate {

	/**
	 * do language translations of the field list.
	 *
	 * @param	DataMapper $object The DataMapper Object to convert
	 * @param	array $fields Array of fields to include.  If empty, includes all database columns.
	 * @return	object, the Datamapper object
	 */
	function translate( $object, $fields = array() )
	{
		// make sure $fields is an array
		$fields = (array) $fields;

		// assume all database columns if $fields is not provided.
		if(empty($fields))
		{
			$fields = $object->fields;
		}

		// loop through the fields
		foreach($fields as $f)
		{
			// first, deal with the loaded fields
			if ( isset($object->{$f}) )
			{
				$line = lang($object->{$f});
				if ( $line )
				{
					$object->{$f};
				}
			}

			// then, loop through the all array
			foreach($object->all as $key => $all_object)
			{
				if ( isset($all_object->{$f}) )
				{
					$line = lang($all_object->{$f});
					if ( $line )
					{
						$object->all[$key]->{$f} = $line;
					}
				}
			}
		}

		// return the Datamapper object
		return $object;
	}

}

/* End of file translate.php */
/* Location: ./application/datamapper/translate.php */
