<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * error
 * 
 * shows a 404 error with all ci object stuff available.
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		error.php
 * @version		1.0
 * @date		02/18/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * error class.
 * 
 * @extends CI_Controller
 */
class error extends CI_Controller
{
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 *
	 * show a 404 error
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->load->library('uri');
		show_404($this->uri->uri_string());
	}
	
	// --------------------------------------------------------------------------
}
/* End of file error.php */
/* Location: ./bookymark/application/controllers/error.php */