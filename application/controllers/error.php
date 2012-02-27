<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * error
 * 
 * shows a 404 error with all ci object stuff available.
 * 
 */

// --------------------------------------------------------------------------

/**
 * error class.
 * 
 * @extends Front_Controller
 */
class error extends Front_Controller
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