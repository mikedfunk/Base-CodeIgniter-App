<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * My Image Lib
 * 
 * Extend to get errors array
 * 
 * @license		Commercial
 * @author		Mike Funk
 * @link		http://xulonpress.com
 * @email		webmaster@xulonpress.com
 * 
 * @file		MY_Image_lib.php
 * @version		1.0
 * @date		04/02/2011
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