<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CodeIgniter Inflector Helpers
 *
 * Customised singular and plural helpers.
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team, stensi
 * @link		http://codeigniter.com/user_guide/helpers/inflector_helper.html
 */

// --------------------------------------------------------------------

/**
* Singular
*
* Takes a plural word and makes it singular (improved by stensi)
*
* @access	public
* @param	string
* @return	str
*/
if ( ! function_exists('singular'))
{
	function singular($str)
	{
		$str = strtolower(trim($str));
		$end5 = substr($str, -5);
		$end4 = substr($str, -4);
		$end3 = substr($str, -3);
		$end2 = substr($str, -2);
		$end1 = substr($str, -1);

		if ($end5 == 'eives')
		{
			$str = substr($str, 0, -3).'f';
		}
		elseif ($end4 == 'eaux')
		{
			$str = substr($str, 0, -1);
		}
		elseif ($end4 == 'ives')
		{
			$str = substr($str, 0, -3).'fe';
		}
		elseif ($end3 == 'ves')
		{
			$str = substr($str, 0, -3).'f';
		}
		elseif ($end3 == 'ies')
		{
			$str = substr($str, 0, -3).'y';
		}
		elseif ($end3 == 'men')
		{
			$str = substr($str, 0, -2).'an';
		}
		elseif ($end3 == 'xes' && strlen($str) > 4 OR in_array($end3, array('ses', 'hes', 'oes')))
		{
			$str = substr($str, 0, -2);
		}
		elseif (in_array($end2, array('da', 'ia', 'la')))
		{
			$str = substr($str, 0, -1).'um';
		}
		elseif (in_array($end2, array('bi', 'ei', 'gi', 'li', 'mi', 'pi')))
		{
			$str = substr($str, 0, -1).'us';
		}
		else
		{
			if ($end1 == 's' && $end2 != 'us' && $end2 != 'ss')
			{
				$str = substr($str, 0, -1);
			}
		}
	
		return $str;
	}
}

// --------------------------------------------------------------------

/**
* Plural
*
* Takes a singular word and makes it plural (improved by stensi)
*
* @access	public
* @param	string
* @param	bool
* @return	str
*/
if ( ! function_exists('plural'))
{	
	function plural($str, $force = FALSE)
	{
		$str = strtolower(trim($str));
		$end3 = substr($str, -3);
		$end2 = substr($str, -2);
		$end1 = substr($str, -1);

		if ($end3 == 'eau')
		{
			$str .= 'x';
		}
		elseif ($end3 == 'man')
		{
			$str = substr($str, 0, -2).'en';
		}
		elseif (in_array($end3, array('dum', 'ium', 'lum')))
		{
			$str = substr($str, 0, -2).'a';
		}
		elseif (strlen($str) > 4 && in_array($end3, array('bus', 'eus', 'gus', 'lus', 'mus', 'pus')))
		{
			$str = substr($str, 0, -2).'i';
		}
		elseif ($end3 == 'ife')
		{
			$str = substr($str, 0, -2).'ves';
		}
		elseif ($end1 == 'f')
		{
			$str = substr($str, 0, -1).'ves';
		}
		elseif ($end1 == 'y')
		{
			if(preg_match('#[aeiou]y#i', $end2))
			{
				// ays, oys, etc.
				$str = $str . 's';
			}
			else
			{
				$str = substr($str, 0, -1).'ies';
			}
		}
		elseif ($end1 == 'o')
		{
			if(preg_match('#[aeiou]o#i', $end2))
			{
				// oos, etc.
				$str = $str . 's';
			}
			else
			{
				$str .= 'es';
			}
		}
		elseif ($end1 == 'x' || in_array($end2, array('ss', 'ch', 'sh')) )
		{
			$str .= 'es';
		}
		elseif ($end1 == 's')
		{
			if ($force == TRUE)
			{
				$str .= 'es';
			}
		}
		else
		{
			$str .= 's';
		}

		return $str;
	}
}

// --------------------------------------------------------------------

/**
 * Camelize
 *
 * Takes multiple words separated by spaces or underscores and camelizes them
 *
 * @access	public
 * @param	string
 * @return	str
 */	
if ( ! function_exists('camelize'))
{	
	function camelize($str)
	{		
		$str = 'x'.strtolower(trim($str));
		$str = ucwords(preg_replace('/[\s_]+/', ' ', $str));
		return substr(str_replace(' ', '', $str), 1);
	}
}

// --------------------------------------------------------------------

/**
 * Underscore
 *
 * Takes multiple words separated by spaces and underscores them
 *
 * @access	public
 * @param	string
 * @return	str
 */	
if ( ! function_exists('underscore'))
{
	function underscore($str)
	{
		return preg_replace('/[\s]+/', '_', strtolower(trim($str)));
	}
}

// --------------------------------------------------------------------

/**
 * Humanize
 *
 * Takes multiple words separated by underscores and changes them to spaces
 *
 * @access	public
 * @param	string
 * @return	str
 */
if ( ! function_exists('humanize'))
{	
	function humanize($str)
	{
		return ucwords(preg_replace('/[_]+/', ' ', strtolower(trim($str))));
	}
}

/* End of file inflector_helper.php */
/* Location: ./application/helpers/inflector_helper.php */