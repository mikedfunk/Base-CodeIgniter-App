<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * My Upload
 * 
 * Add get errors array
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		MY_Upload.php
 * @version		1.1.1
 * @date		03/11/2012
 * 
 * Copyright (c) 2011
 */

// --------------------------------------------------------------------------

/**
 * MY_Upload class.
 * 
 * @extends CI_Upload
 */
class MY_Upload extends CI_Upload {
	
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
/* End of file MY_Upload.php */
/* Location: ./booktrack/application/libraries/MY_Upload.php */