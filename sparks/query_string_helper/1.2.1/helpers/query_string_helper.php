<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * query_string_helper
 * 
 * Functions to help with assembling a XSS filtered query string, allowing
 * to remove and add key/value pairs.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		query_string_helper.php
 * @version		1.2.1
 * @date		04/01/2012
 */

// --------------------------------------------------------------------------

/**
 * query_string function.
 *
 * Returns query string with added or removed key/value pairs.
 * 
 * @param mixed $add (default: '') can be string or array
 * @param mixed $remove (default: '') can be string or array
 * @param bool $include_current (default: TRUE)
 * @return string
 */
function query_string($add = '', $remove = '', $include_current = TRUE)
{
	$_ci =& get_instance();
	
	// set initial query string
	$query_string = array();
	if ($include_current && $_ci->input->get() !== FALSE)
	{
		$query_string = $_ci->input->get();
	}
	
	// add to query string
	if ($add != '')
	{
		// convert to array
		if (is_string($add))
		{
			$add = array($add);
		}
		$query_string = array_merge($query_string, $add);
	}
	
	// remove from query string
	if ($remove != '')
	{
		// convert to array
		if (is_string($remove))
		{
			$remove = array($remove);
		}
		
		// remove from query_string
		foreach ($remove as $rm)
		{
			$key = array_search($rm, $query_string);
			if ($key !== FALSE)
			{
				unset($query_string[$key]);
			}
		}
	}
	
	// return result
	$return = '';
	if (count($query_string) > 0)
	{
		$return = '?' . http_build_query($query_string);
	}
	return $return;
}

// --------------------------------------------------------------------------

/**
 * uri_query_string function.
 *
 * returns uri_string with query_string on the end.
 * 
 * @param mixed $add (default: '')
 * @param mixed $remove (default: '')
 * @param bool $include_current (default: TRUE) Whether to include the 
 * current page's query string or start fresh.
 * @return string
 */
function uri_query_string($add = '', $remove = '', $include_current = TRUE)
{
	$_ci =& get_instance();
	return $_ci->uri->uri_string() . query_string($add, $remove, $include_current);
}

// --------------------------------------------------------------------------

/* End of file query_string_helper.php */
/* Location: ./query_string_helper/helpers/query_string_helper.php */