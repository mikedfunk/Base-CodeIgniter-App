<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * restricted page
 * 
 * An example restricted page
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		restricted_page.php
 * @version		1.3.4
 * @date		03/20/2012
 */

// --------------------------------------------------------------------------

/**
 * restricted_page class.
 * 
 * @extends CI_Controller
 */
class restricted_page extends CI_Controller
{
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->load->spark('ci_authentication/1.3.4');
		
		// redirects you to the configured login page if not logged in.
		$this->ci_authentication->restrict_access();
		
		echo 'this text will only show up after you log in.';
	}
	
	// --------------------------------------------------------------------------
}

/* End of file restricted_page.php */
/* Location: ./ci_authentication/examples/controllers/restricted_page.php */