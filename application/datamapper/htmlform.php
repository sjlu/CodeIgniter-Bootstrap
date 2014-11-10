<?php


/**
 * HTMLForm Extension for DataMapper classes.
 *
 * A powerful extension that allows one to quickly
 * generate standardized forms off a DMZ object.
 *
 * @license 	MIT License
 * @package		DMZ-Included-Extensions
 * @category	DMZ
 * @author  	Phil DeJarnett
 * @link    	http://www.overzealous.com/dmz/pages/extensions/htmlform.html
 * @version 	1.0
 */

// --------------------------------------------------------------------------

/**
 * DMZ_HTMLForm Class
 *
 * @package		DMZ-Included-Extensions
 */
class DMZ_HTMLForm {

	// this is the default template (view) to use for the overall form
	var $form_template = 'dmz_htmlform/form';
	// this is the default template (view) to use for the individual rows
	var $row_template = 'dmz_htmlform/row';
	// this is the default template (view) to use for the individual rows
	var $section_template = 'dmz_htmlform/section';

	var $auto_rule_classes = array(
		'integer' => 'integer',
		'numeric' => 'numeric',
		'is_natural' => 'natural',
		'is_natural_no_zero' => 'positive_int',
		'valid_email' => 'email',
		'valid_ip' => 'ip',
		'valid_base64' => 'base64',
		'valid_date' => 'date',
		'alpha_dash_dot' => 'alpha_dash_dot',
		'alpha_slash_dot' => 'alpha_slash_dot',
		'alpha' => 'alpha',
		'alpha_numeric' => 'alpha_numeric',
		'alpha_dash' => 'alpha_dash',
		'required' => 'required'
	);

	function __construct($options = array(), $object = NULL) {

		if (is_array($options) )
		{
			foreach($options as $k => $v)
			{
				$this->{$k} = $v;
			}
		}

		$this->CI =& get_instance();
		$this->load = $this->CI->load;
	}

	// --------------------------------------------------------------------------

	/**
	 * Render a single field.  Can be used to chain together multiple fields in a column.
	 *
	 * @param object $object The DataMapper Object to use.
	 * @param string $field The field to render.
	 * @param string $type  The type of field to render.
	 * @param array  $options  Various options to modify the output.
	 * @return Rendered String.
	 */
	function render_field($object, $field, $type = NULL, $options = NULL)
	{
		$value = '';

		if(array_key_exists($field, $object->has_one) || array_key_exists($field, $object->has_many))
		{
			// Create a relationship field
			$one = array_key_exists($field, $object->has_one);

			// attempt to look up the current value(s)
			if( ! isset($options['value']))
			{
				if($this->CI->input->post($field))
				{
					$value = $this->CI->input->post($field);
				}
				else
				{
					// load the related object(s)
					$sel = $object->{$field}->select('id')->get();
					if($one)
					{
						// only a single value is allowed
						$value = $sel->id;
					}
					else
					{
						// save what might be multiple values
						$value = array();
						foreach($sel as $s)
						{
							$value[] = $s->id;
						}
					}
				}

			}
			else
			{
				// value was already set in the options
				$value = $options['value'];
				unset($options['value']);
			}

			// Attempt to get a list of possible values
			if( ! isset($options['list']) || is_object($options['list']))
			{
				if( ! isset($options['list']))
				{
					// look up all of the related values
					$c = get_class($object->{$field});
					$total_items = new $c;
					// See if the custom method is defined
					if(method_exists($total_items, 'get_htmlform_list'))
					{
						// Get customized list
						$total_items->get_htmlform_list($object, $field);
					}
					else
					{
						// Get all items
						$total_items->get_iterated();
					}
				}
				else
				{
					// process a passed-in DataMapper object
					$total_items = $options['list'];
				}
				$list = array();
				foreach($total_items as $item)
				{
					// use the __toString value of the item for the label
					$list[$item->id] = (string)$item;
				}
				$options['list'] = $list;
			}

			// By if there can be multiple items, use a dropdown for large lists,
			// and a set of checkboxes for a small one.
			if($one || count($options['list']) > 6)
			{
				$default_type = 'dropdown';
				if( ! $one && ! isset($options['size']))
				{
					// limit to no more than 8 items high.
					$options['size'] = min(count($options['list']), 8);
				}
			}
			else
			{
				$default_type = 'checkbox';
			}
		}
		else
		{
			// attempt to look up the current value(s)
			if( ! isset($options['value']))
			{
				if($this->CI->input->post($field))
				{
					$value = $this->CI->input->post($field);
					// clear default if set
					unset($options['default_value']);
				}
				else
				{
					if(isset($options['default_value']))
					{
						$value = $options['default_value'];
						unset($options['default_value']);
					}
					else
					{
						// the field IS the value.
						$value = $object->{$field};
					}
				}

			}
			else
			{
				// value was already set in the options
				$value = $options['value'];
				unset($options['value']);
			}
			// default to text
			$default_type = ($field == 'id') ? 'hidden' : 'text';

			// determine default attributes
			$a = array();
			// such as the size of the field.
			$max = $this->_get_validation_rule($object, $field, 'max_length');
			if($max === FALSE)
			{
				$max = $this->_get_validation_rule($object, $field, 'exact_length');
			}
			if($max !== FALSE)
			{
				$a['maxlength'] = $max;
				$a['size'] = min($max, 30);
			}
			$list = $this->_get_validation_info($object, $field, 'values', FALSE);
			if($list !== FALSE)
			{
				$a['list'] = $list;
			}
			$options = $options + $a;
			$extra_class = array();

			// Add any of the known rules as classes (for JS processing)
			foreach($this->auto_rule_classes as $rule => $c)
			{
				if($this->_get_validation_rule($object, $field, $rule) !== FALSE)
				{
					$extra_class[] = $c;
				}
			}

			// add or set the class on the field.
			if( ! empty($extra_class))
			{
				$extra_class = implode(' ', $extra_class);
				if(isset($options['class']))
				{
					$options['class'] .= ' ' . $extra_class;
				}
				else
				{
					$options['class'] = $extra_class;
				}
			}
		}

		// determine the renderer type
		$type = $this->_get_type($object, $field, $type);
		if(empty($type))
		{
			$type = $default_type;
		}

		// attempt to find the renderer function
		if(method_exists($this, '_input_' . $type))
		{
			return $this->{'_input_' . $type}($object, $field, $value, $options);
		}
		else if(function_exists('input_' . $type))
		{
			return call_user_func('input_' . $type, $object, $field, $value, $options);
		}
		else
		{
			log_message('error', 'FormMaker: Unable to find a renderer for '.$type);
			return '<span style="color: Maroon; background-color: White; font-weight: bold">FormMaker: UNABLE TO FIND A RENDERER FOR '.$type.'</span>';
		}

	}

	// --------------------------------------------------------------------------

	/**
	 * Render a row with a single field.  If $field does not exist on
	 * $object->validation, then $field is output as-is.
	 *
	 * @param object $object The DataMapper Object to use.
	 * @param string $field The field to render (or content)
	 * @param string $type  The type of field to render.
	 * @param array  $options  Various options to modify the output.
	 * @param string $row_template  The template to use, or NULL to use the default.
	 * @return Rendered String.
	 */
	function render_row($object, $field, $type = NULL, $options = array(), $row_template = NULL)
	{
		// try to determine type automatically
		$type = $this->_get_type($object, $field, $type);

		if( ! isset($object->validation[$field]) && (empty($type) || $type == 'section' || $type == 'none'))
		{
			// this could be a multiple-field row, or just some text.
			// if $type is 'section, it will be rendered using the section template.
			$error = '';
			$label = '';
			$content = $field;
			$id = NULL;
		}
		else
		{
			// use validation information to render the field.
			$content = $this->render_field($object, $field, $type, $options);
			if(empty($row_template))
			{
				if($type == 'hidden' || $field == 'id')
				{
					$row_template = 'none';
				}
				else
				{
					$row_template = $this->row_template;
				}
			}
			// determine if there is an existing error
			$error = isset($object->error->{$field}) ? $object->error->{$field} : '';
			// determine if there is a pre-defined label
			$label = $this->_get_validation_info($object, $field, 'label', $field);
			// the field IS the id
			$id = $field;
		}

		$required = $this->_get_validation_rule($object, $field, 'required');

		// Append these items.  Values in $options have priority
		$view_data = $options + array(
			'object' => $object,
			'content' => $content,
			'field' => $field,
			'label' => $label,
			'error' => $error,
			'id' => $id,
			'required' => $required
		);

		if(is_null($row_template))
		{
			if(empty($type))
			{
				$row_template = 'none';
			}
			else if($type == 'section')
			{
				$row_template = $this->section_template;
			}
			else
			{
				$row_template = $this->row_template;
			}
		}

		if($row_template == 'none')
		{
			return $content;
		}
		else
		{
			return $this->load->view($row_template, $view_data, TRUE);
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * Renders an entire form.
	 *
	 * @param object $object The DataMapper Object to use.
	 * @param string $fields An associative array that defines the form.
	 * @param string $template  The template to use.
	 * @param string $row_template  The template to use for rows.
	 * @param array  $template_options  The template to use for rows.
	 * @return Rendered String.
	 */
	function render_form($object, $fields, $url = '', $options = array(), $template = NULL, $row_template = NULL)
	{
		if(empty($url))
		{
			// set url to current url
			$url =$this->CI->uri->uri_string();
		}

		if(is_null($template))
		{
			$template = $this->form_template;
		}

		$rows = '';
		foreach($fields as $field => $field_options)
		{
			$rows .= $this->_render_row_from_form($object, $field, $field_options, $row_template);
		}

		$view_data = $options + array(
			'object' => $object,
			'fields' => $fields,
			'url' => $url,
			'rows' => $rows
		);

		return $this->load->view($template, $view_data, TRUE);
	}

	// --------------------------------------------------------------------------
	// Private Methods
	// --------------------------------------------------------------------------

	// Converts information from render_form into a row of objects.
	function _render_row_from_form($object, $field, $options, $row_template, $row = TRUE)
	{
		if(is_int($field))
		{
			// simple form, or HTML-content
			$field = $options;
			$options = NULL;
		}
		if(is_null($options))
		{
			// always have an array for options
			$options = array();
		}

		$type = '';
		if( ! is_array($options))
		{
			// if options is a single string, assume it is the type.
			$type = $options;
			$options = array();
		}

		if(isset($options['type']))
		{
			// type was set in options
			$type = $options['type'];
			unset($options['type']);
		}

		// see if a different row_template was in the options
		$rt = $row_template;
		if(isset($options['template']))
		{
			$rt = $options['template'];
			unset($options['template']);
		}

		// Multiple fields, render them all as one.
		if(is_array($field))
		{
			if(isset($field['row_options']))
			{
				$options = $field['row_options'];
				unset($field['row_options']);
			}
			$ret = '';
			$sep = ' ';
			if(isset($field['input_separator']))
			{
				$sep = $field['input_separator'];
				unset($field['input_separator']);
			}
			foreach($field as $f => $fo)
			{
				// add each field to a list
				if( ! empty($ret))
				{
					$ret .= $sep;
				}
				$ret .= $this->_render_row_from_form($object, $f, $fo, $row_template, FALSE);
			}

			// renders into a row or field below.
			$field = $ret;
		}
		if($row)
		{
			// if row is set, render the whole row.
			return $this->render_row($object, $field, $type, $options, $rt);
		}
		else
		{
			// render just the field.
			return $this->render_field($object, $field, $type, $options);
		}
	}

	// --------------------------------------------------------------------------

	// Attempts to look up the field's type
	function _get_type($object, $field, $type)
	{
		if(empty($type))
		{
			$type = $this->_get_validation_info($object, $field, 'type', NULL);
		}
		return $type;
	}

	// --------------------------------------------------------------------------

	// Returns a field from the validation array
	function _get_validation_info($object, $field, $val, $default = '')
	{
		if(isset($object->validation[$field][$val]))
		{
			return $object->validation[$field][$val];
		}
		return $default;
	}

	// --------------------------------------------------------------------------

	// Returns the value (or TRUE) of the validation rule, or FALSE if it does not exist.
	function _get_validation_rule($object, $field, $rule)
	{
		$r = $this->_get_validation_info($object, $field, 'rules', FALSE);
		if($r !== FALSE)
		{
			if(isset($r[$rule]))
			{
				return $r[$rule];
			}
			else if(in_array($rule, $r, TRUE))
			{
				return TRUE;
			}
		}
		return FALSE;
	}

	// --------------------------------------------------------------------------
	// Input Types
	// --------------------------------------------------------------------------

	// Render a hidden input
	function _input_hidden($object, $id, $value, $options)
	{
		return $this->_render_simple_input('hidden', $id, $value, $options);
	}

	// render a single-line text input
	function _input_text($object, $id, $value, $options)
	{
		return $this->_render_simple_input('text', $id, $value, $options);
	}

	// render a password input
	function _input_password($object, $id, $value, $options)
	{
		if(isset($options['send_value']))
		{
			unset($options['send_value']);
		}
		else
		{
			$value = '';
		}
		return $this->_render_simple_input('password', $id, $value, $options);
	}

	// render a multiline text input
	function _input_textarea($object, $id, $value, $options)
	{
		if(isset($options['value']))
		{
			$value = $options['value'];
			unset($options['value']);
		}
		$a = $options + array(
			'name' => $id,
			'id' => $id
		);
		return $this->_render_node('textarea', $a, htmlspecialchars($value));
	}

	// render a dropdown
	function _input_dropdown($object, $id, $value, $options)
	{
		$list = $options['list'];
		unset($options['list']);
		$selected = $value;
		if(isset($options['value']))
		{
			$selected = $options['value'];
			unset($options['value']);
		}
		if( ! is_array($selected))
		{
			$selected = array($selected);
		}
		else
		{
			// force multiple
			$options['multiple'] = 'multiple';
		}
		$l = $this->_options($list, $selected);

		$name = $id;
		if(isset($options['multiple']))
		{
			$name .= '[]';
		}
		$a = $options + array(
			'name' => $name,
			'id' => $id
		);
		return $this->_render_node('select', $a, $l);
	}

	// used to render an options list.
	function _options($list, $sel)
	{
		$l = '';
		foreach($list as $opt => $label)
		{
			if(is_array($label))
			{
				$l .= '<optgroup label="' . htmlspecialchars($key) . '">';
				$l .= $this->_options($label, $sel);
				$l .= '</optgroup>';
			}
			else
			{
				$a = array('value' => $opt);
				if(in_array($opt, $sel))
				{
					$a['selected'] = 'selected';
				}
				$l .= $this->_render_node('option', $a, htmlspecialchars($label));
			}
		}
		return $l;
	}

	// render a checkbox or series of checkboxes
	function _input_checkbox($object, $id, $value, $options)
	{
		return $this->_checkbox('checkbox', $id, $value, $options);
	}

	// render a series of radio buttons
	function _input_radio($object, $id, $value, $options)
	{
		return $this->_checkbox('radio', $id, $value, $options);
	}

	// renders one or more checkboxes or radio buttons
	function _checkbox($type, $id, $value, $options, $sub_id = '', $label = '')
	{
		if(isset($options['value']))
		{
			$value = $options['value'];
			unset($options['value']);
		}
		// if there is a list in options, render our multiple checkboxes.
		if(isset($options['list']))
		{
			$list = $options['list'];
			unset($options['list']);
			$ret = '';
			if( ! is_array($value))
			{
				if(is_null($value) || $value === FALSE || $value === '')
				{
					$value = array();
				}
				else
				{
					$value = array($value);
				}
			}
			$sep = '<br/>';
			if(isset($options['input_separator']))
			{
				$sep = $options['input_separator'];
				unset($options['input_separator']);
			}
			foreach($list as $k => $v)
			{
				if( ! empty($ret))
				{
					// put each node on one line.
					$ret .= $sep;
				}
				$ret .= $this->_checkbox($type, $id, $value, $options, $k, $v);
			}
			return $ret;
		}
		else
		{
			// just render the single checkbox.
			$node_id = $id;
			if( ! empty($sub_id))
			{
				// there are multiple nodes with this id, append the sub_id
				$node_id .= '_' . $sub_id;
				$field_value = $sub_id;
			}
			else
			{
				// sub_id is the same as the node's id
				$sub_id = $id;
				$field_value = '1';
			}
			$name = $id;
			if(is_array($value))
			{
				// allow for multiple results
				$name .= '[]';
			}
			// node attributes
			$a = $options + array(
				'type' => $type,
				'id' => $node_id,
				'name' => $name,
				'value' => $field_value
			);
			// if checked wasn't overridden
			if( ! isset($a['checked']))
			{
				// determine if this is a multiple checkbox or not.
				$checked = $value;
				if(is_array($checked))
				{
					$checked = in_array($sub_id, $value);
				}
				if($checked)
				{
					$a['checked'] = 'checked';
				}
			}
			$ret = $this->_render_node('input', $a);
			if( ! empty($label))
			{
				$ret .= ' ' . $this->_render_node('label', array('for' => $node_id), $label);
			}
			return $ret;
		}
	}

	// render a file upload input
    function _input_file($object, $id, $value, $options)
    {
        $a = $options + array(
			'type' => 'file',
			'name' => $id,
			'id' => $id
		);
		return $this->_render_node('input', $a);
    }

	// Utility method to render a normal <input>
	function _render_simple_input($type, $id, $value, $options)
	{
		$a = $options + array(
			'type' => $type,
			'name' => $id,
			'id' => $id,
			'value' => $value
		);
		return $this->_render_node('input', $a);
	}

	// Utility method to render a node.
	function _render_node($type, $attributes, $content = FALSE)
	{
		// generate node
		$res = '<' . $type;
		foreach($attributes as $att => $v)
		{
			// the special attribute '_' is rendered directly.
			if($att == '_')
			{
				$res .= ' ' . $v;
			}
			else
			{
				if($att != 'label')
				{
					$res .= ' ' . $att . '="' . htmlspecialchars((string)$v) . '"';
				}
			}
		}
		// allow for content-containing nodes
		if($content !== FALSE)
		{
			$res .= '>' . $content . '</' . $type .'>';
		}
		else
		{
			$res .= ' />';
		}
		return $res;
	}

}

/* End of file htmlform.php */
/* Location: ./application/datamapper/htmlform.php */
