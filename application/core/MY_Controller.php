<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY_Controller
 */

// --------------------------------------------------------------------------

/**
 * MY_Controller class.
 * 
 * @extends MX_Controller
 */
class MY_Controller extends MX_Controller
{
	/**
	 * View data
	 * 
	 * @access protected
	 */
	protected $_data;

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		//load resources
		$this->load->library('carabiner');
	}
	
	// --------------------------------------------------------------------------
}
/* End of file MY_Controller.php */