<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * allows for setting form error prefix and suffix in config, allows getting
 * form errors in an array
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file MY_Form_validation.php
 */

/**
 * MY_Form_validation class.
 * 
 * @extends CI_Form_validation
 */
class MY_Form_validation extends CI_Form_validation 
{
	// --------------------------------------------------------------------------
	
	/**
	 * codeigniter
	 * 
	 * @var object
	 * @access private
	 */
	private $_ci;
	
	// --------------------------------------------------------------------------
	
    /**
     * __construct function.
     *
     * Just defines the parent and sets error prefixes globally
     * 
     * @access public
     * @return void
     */
    function __construct()
    {
        parent::__construct();
        $this->_ci =& get_instance();
        if (file_exists(APPPATH . 'config/form_validation.php'))
        {
	        $this->_ci->config->load('form_validation');
	    }
        $this->_error_prefix = (config_item('form_error_prefix') ? config_item('form_error_prefix') : '');
        $this->_error_suffix = (config_item('form_error_suffix') ? config_item('form_error_suffix') : '');
    }
    
    // --------------------------------------------------------------------------
    
    /**
     * getErrorsArray
     *
     * Returns an array of the errors rather than just a string.
     *
     * @link http://stackoverflow.com/questions/468139/codeigniter-form-validation-get-the-result-as-array-instead-of-string 
     * @access public
     * @return array
     */
    public function get_errors_array()
    {
        return $this->_error_array;
    }
}
/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */