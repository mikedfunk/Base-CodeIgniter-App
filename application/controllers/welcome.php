<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * the default welcome controller moved into the yield->layout pattern
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file welcome.php
 */

/**
 * Welcome class.
 *
 * @extends MY_Controller
 */
class Welcome extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->spark('assets/1.5.1');
		// $this->load->library('firephp');
		// $this->firephp->log('FirePHP Installed!');
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */