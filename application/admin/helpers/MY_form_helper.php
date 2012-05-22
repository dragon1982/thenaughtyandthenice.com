<?php
// --------------------------------------------------------------------

/**
 * Drop-down Menu
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_dropdown'))
{
	function form_dropdown($name = '', $options = array(), $selected = array(), $extra = '')
	{
		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = array($_POST[$name]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

		# Insert the following code
		//-------------------------
		// Check post if post is not empty
		if (! empty($_POST))
		{
			// Post data exists. Default is select has no options selected.
			$selected = array();
			// Strip the [] from the name if multiple
			$post_name = preg_replace('/\[\]/','',$name);
			// Check for value(s) for this select item by name in $_POST array
			if (isset($_POST[$post_name]))
			{
				// Check if multiple values
				if (is_array($_POST[$post_name]))
				{
					// Extract each posted item
					foreach ($_POST[$post_name] as $posted)
					{
						// Override default values with posted values
						$selected[] = $posted;
					}
				}
				else
				{    // Single select value
					$selected = array($_POST[$post_name]);
				}
			}
		}
				
		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val) && ! empty($val))
			{
				$form .= '<optgroup label="'.$key.'">'."\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= '</optgroup>'."\n";
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	}
}
