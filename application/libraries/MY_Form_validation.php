<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY Form Validation
 * 
 * returns an error array for form errors.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		MY_Form_validation.php
 * @version		1.1.1
 * @date		03/11/2012
 * 
 * Copyright (c) 2011
 */

// --------------------------------------------------------------------------

/**
 * MY_Form_validation class.
 * 
 * @extends CI_Form_validation
 */
class MY_Form_validation extends CI_Form_validation {
	
	// --------------------------------------------------------------------------
	
    /**
     * __construct function.
     *
     * Just defines the parent and sets the prefix/suffix.
     * 
     * @access public
     * @return void
     */
    function __construct()
    {
        parent::__construct();
        $this->_error_prefix = '<span class="help-inline error">';
        $this->_error_suffix    = '</span>';
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
/* Location: ./base_codeigniter_app/application/libraries/MY_Form_validation.php */