<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * welcome
 * 
 * The default welcome page redone with carabiner and twitter bootstrap.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		welcome.php
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * welcome class.
 * 
 * @extends Front_Controller
 */
class welcome extends Front_Controller
{
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 *
	 * the welcome page.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{	
		// load view with data
		$this->_data['title'] = 'Welcome to CodeIgniter!';
		$this->_data['description'] = 'CodeIgniter welcome page';
		$this->_data['content'] = $this->load->view('welcome_message', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file welcome.php */
/* Location: ./base_codeigniter_app/application/controllers/welcome.php */