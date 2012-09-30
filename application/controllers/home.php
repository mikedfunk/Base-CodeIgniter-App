<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * the intro page
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file home.php
 */


// --------------------------------------------------------------------------

/**
 * home class.
 * 
 * @extends MY_Controller
 */
class home extends MY_Controller
{
	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		
		// load resources
		$this->load->spark('assets/1.5.1');
		$this->load->helper('partial');
		$this->load->helper('url');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 *
	 * the home page.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
	}
	
	// --------------------------------------------------------------------------
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */