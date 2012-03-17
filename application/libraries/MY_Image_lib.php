<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * My Image Lib
 * 
 * Extend to get errors array
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		MY_Image_lib.php
 * @version		1.1.1
 * @date		03/11/2012
 * 
 * Copyright (c) 2011
 */

// --------------------------------------------------------------------------

/**
 * MY_Image_lib class.
 * 
 * @extends CI_Image_lib
 */
class MY_Image_lib extends CI_Image_lib {

	// --------------------------------------------------------------------------
	
	/**
	 * get errors array
	 *
	 * just returns the errors array as an array
	 *
	 * @access public
	 */
	public function get_errors_array()
	{
		return $this->error_msg;
	}
}
/* End of file MY_Image_lib.php */
/* Location: ./booktrack/application/libraries/MY_Image_lib.php */