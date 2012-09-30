<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ci_authentication_helper
 * 
 * shortcuts for username and password from the session
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		ci_authentication_helper.php
 * @version		1.3.4
 * @date		03/20/2012
 */

// --------------------------------------------------------------------------

/**
 * auth_id function.
 *
 * Returns id from session with configurable id field value.
 * 
 * @access public
 * @return void
 */
function auth_id()
{
	$_ci =& get_instance();
	$_ci->load->library('session');
	// $_ci->config->load('ci_authentication');
	
	return $_ci->session->userdata(config_item('user_id_field'));
}

// --------------------------------------------------------------------------

/**
 * auth_username function.
 *
 * Returns username from session with configurable username field value.
 * 
 * @access public
 * @return void
 */
function auth_username()
{
	$_ci =& get_instance();
	$_ci->load->library('session');
	// $_ci->config->load('ci_authentication');
	
	return $_ci->session->userdata(config_item('username_field'));
}

// --------------------------------------------------------------------------

/**
 * auth_password function.
 *
 * Returns password from session with configurable password field value.
 * 
 * @access public
 * @return void
 */
function auth_password()
{
	$_ci =& get_instance();
	$_ci->load->library('session');
	// $_ci->config->load('ci_authentication');
	
	return $_ci->session->userdata(config_item('password_field'));
}

// --------------------------------------------------------------------------

/**
 * is_logged_in function.
 *
 * Shortcut to $this->ci_authentication->is_logged_in(). Useful in views.
 * 
 * @access public
 * @return void
 */
function is_logged_in()
{
	$_ci =& get_instance();
	// $_ci->load->library('ci_authentication');
	return $_ci->ci_authentication->is_logged_in();
}

// --------------------------------------------------------------------------

/* End of file ci_authentication_helper.php */
/* Location: ./ci_authentication/helpers/ci_authentication_helper.php */