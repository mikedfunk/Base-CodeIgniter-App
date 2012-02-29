<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * slash_helper
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		slash_helper.php
 * @version		1.0
 * @date		02/28/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * slash function.
 * 
 * @param string $string
 * @return string
 */
function slash($string)
{
	if (strpos(FCPATH, '/') === FALSE)
	{
		$string = str_replace('/', '\\', $string);
	}
	return $string;
}
/* End of file slash_helper.php */
/* Location: ./Volumes/Macintosh HD/Library/WebServer/Documents/base_codeigniter_app/application/helpers/slash_helper.php */