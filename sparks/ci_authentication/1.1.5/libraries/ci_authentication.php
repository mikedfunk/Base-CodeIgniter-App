<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ci_authentication
 * 
 * Tools for authentication in CodeIgniter.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		ci_authentication.php
 * @version		1.1.5
 * @date		02/17/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * ci_authentication class.
 */
class ci_authentication
{
	// --------------------------------------------------------------------------
	
	/**
	 * _ci
	 *
	 * The codeigniter superobject
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_ci;
	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 *
	 * load common resources
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->_ci =& get_instance();
		log_message('debug', 'CI Authentication: library initialized.');
		
		$this->_ci->load->spark('ci_alerts/1.1.2');
		log_message('debug', 'CI Authentication: CI Alerts spark initialized.');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * restrict_access function.
	 *
	 * if not logged in, redirects to configured url. also optionally restricts
	 * by condition set in session.
	 * 
	 * @access public
	 * @param bool $condition a condition obtained in a user query, usually
	 * joined in from the roles table. Such as "can_edit_bookmarks".
	 * @return void
	 */
	public function restrict_access($condition = '')
	{
		// load resources
		$this->_ci->load->model('ci_authentication_model', 'auth_model');
		$this->_ci->load->library(array('session', 'ci_alerts'));
		$this->_ci->load->helper('url');
			
		// check for password match, else redirect
		$chk = $this->_ci->auth_model->password_check(
			$this->_ci->session->userdata(config_item('username_field')), 
			$this->_ci->session->userdata(config_item('password_field')),
			true
		);
		
		if (!$chk)
		{
			$this->_ci->ci_alerts->set('error', config_item('logged_out_message'));
			redirect(config_item('logged_out_url'));
		}
		
		// if condition, only checking for condition set in session
		if ($condition != '')
		{
			if(!$this->_ci->session->userdata($condition))
			{
				$this->_ci->ci_alerts->set('error', config_item('access_denied_message'));
				$this->_ci->session->set_flashdata('alert_page_title', 'Access Denied');
				redirect(config_item('access_denied_url'));
			}
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * remember_me function.
	 *
	 * sets cookies if remember me is checked, otherwise deletes cookies.
	 * 
	 * @access public
	 * @return void
	 */
	public function remember_me()
	{
		// set output buffering so we don't get header already sent errors in testing
		if (ENVIRONMENT == 'testing') { ob_start(); }
		
		// set remember_me to 0 if not checked and there is post data
		if (!$this->_ci->input->post(config_item('remember_me_field')) && $this->_ci->input->post() !== false)
		{	
			$_POST[config_item('remember_me_field')] = 0;
		}
		
		// set remember_me checkbox cookie
		$this->_ci->input->set_cookie(
			config_item('remember_me_field'), 
			$this->_ci->input->post(config_item('remember_me_field')), 
			(config_item('remember_me_timeout'))
		);
		
		// if remember_me is true, remember, remember the 5th of November
		if ($this->_ci->input->post(config_item('remember_me_field')))
		{
			// set username cookie
			$this->_ci->input->set_cookie(
				config_item('username_field'), 
				$this->_ci->input->post(config_item('username_field')), 
				(config_item('remember_me_timeout'))
			);
			
			// set password cookie
			$this->_ci->input->set_cookie(
				config_item('password_field'), 
				$this->_ci->input->post(config_item('password_field')), 
				(config_item('remember_me_timeout'))
			);
		}
		// otherwise remember_me is false. fuggedaboutit. delete cookie.
		else
		{
			$this->_ci->input->set_cookie(config_item('username_field'), '', time() -1);
			$this->_ci->input->set_cookie(config_item('password_field'), '', time() -1);
		}
		if (ENVIRONMENT == 'testing') { ob_end_clean(); }
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * do_login function.
	 *
	 * hashes and salts password, logs in user to session, redirects to 
	 * configured url
	 * 
	 * @access public
	 * @return bool
	 */
	public function do_login()
	{
		$this->_ci->load->model('ci_authentication_model', 'auth_model');
		$this->_ci->load->helper(array('encrypt_helper', 'string', 'url'));
		$this->_ci->load->library('ci_alerts');
		
		// unset temporary password and confirm password fields
		unset($_POST['confirm_password']);
		unset($_POST['temp_password']);
		
		// set session vars, redirect to admin home
		$q = $this->_ci->auth_model->get_user_by_username($this->_ci->input->post(config_item('username_field')));
		$user = $q->row_array();
		
		$q = $this->_ci->auth_model->get_user_by_username($this->_ci->input->post(config_item('username_field')), FALSE);
		$user_only = $q->row_array();
		
		// set a new salt, re-encrypt the password
		$salt = random_string('alnum', config_item('salt_length'));
		$user[config_item('password_field')] = $user_only[config_item('password_field')] = encrypt_this($this->_ci->input->post(config_item('password_field')), $salt);
		
		// edit the user and set new userdata
		$check = $this->_ci->auth_model->edit_user($user_only);
		$this->_ci->session->set_userdata($user);
		
		// log errors
		if (!$check) {log_message('error', 'Authentication: error editing user during login.');}
		
		$this->_ci->ci_alerts->set('success', config_item('logged_in_message'));
		redirect($this->_ci->session->userdata(config_item('home_page_field')));
	}

	// --------------------------------------------------------------------------

	/**
	 * do_logout
	 *
	 * destroys session, redirects to configured url.
	 *
	 * Destroys the session
	 *
	 * @access public
	 * @return bool
	 */
	public function do_logout()
	{
		$this->_ci->load->library('ci_alerts');
		$this->_ci->load->helper('url');
		
		$this->_ci->session->sess_destroy();
		unset($this->_ci->session->userdata);
		$this->_ci->ci_alerts->set('success', config_item('logged_out_message'));
		redirect(config_item('logout_success_url'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * do_register function.
	 *
	 * adds user to db with updated/added values, emails the user, redirects.
	 * 
	 * @access public
	 * @return void
	 */
	public function do_register()
	{
		// load resources
		$this->_ci->load->model('ci_authentication_model', 'auth_model');
		$this->_ci->load->helper(array('encrypt_helper', 'string'));
		
		// get user, unset confirm password, set salt
		$user = $this->_ci->input->post();
		unset($user['confirm_password']);
		$salt = random_string('alnum', config_item('salt_length'));
		
		// set role_id, encrypt the password, set a new confirm_string
		$user[config_item('role_id_field')] = config_item('user_role_id');
		$user[config_item('password_field')] = encrypt_this($this->_ci->input->post(config_item('password_field')), $salt);
		$user[config_item('confirm_string_field')] = $confirm_string = random_string('alnum', 20);
		
		// add the user, send email, redirect.
		$check = $this->_ci->auth_model->add_user($user);
		$this->_send_register_email($user);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * resend_register_email function.
	 *
	 * resends registration email based on confirm string
	 * 
	 * @access public
	 * @param mixed $confirm_string
	 * @return void
	 */
	public function resend_register_email($confirm_string)
	{
		// load resources
		$this->_ci->load->model('ci_authentication_model', 'auth_model');
		
		// get user and send email
		$q = $this->_ci->auth_model->get_user_by_confirm_string($confirm_string);
		if ($q->num_rows() > 0)
		{
			$user = $q->row_array();
			$this->_send_register_email($user);
		}
		else
		{
			log_message('error', 'Authentication: resend register email: confirm string found.');
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * _send_register_email function.
	 *
	 * sends registration email to user, redirects.
	 * 
	 * @access private
	 * @param mixed $user_array
	 * @return void
	 */
	private function _send_register_email($user_array)
	{
		$this->_ci->load->helper('url');
		$this->_ci->load->library(array('email', 'session', 'ci_alerts'));
		
		// from, to, url, content
		$this->_ci->email->from(config_item('register_email_from'), config_item('register_email_from_name'));
		$this->_ci->email->to($user_array[config_item('username_field')]);
		
		$confirm_string = $user_array[config_item('confirm_string_field')];
		$data['confirm_register_url'] = base_url() . config_item('confirm_register_url') . '/' . $confirm_string;
		$data['content'] = $msg = $this->_ci->load->view(config_item('email_register_view'), $data, TRUE);
		
		// wrap email in template if it exists
		if (config_item('email_template_view') != '')
		{
			$msg = $this->_ci->load->view(config_item('email_template_view'), $data, TRUE);
		}
		
		// subject, msg, send
		$this->_ci->email->subject(config_item('register_email_subject'));
		$this->_ci->email->message($msg);
		$this->_ci->email->send();
		
		// redirect to register_success view
		$this->_ci->ci_alerts->set('success', config_item('register_success_message'));
		$this->_ci->session->set_flashdata('alert_page_title', config_item('register_success_title'));
		redirect(config_item('register_success_url'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * do_confirm_register function.
	 *
	 * if confirm string matches, clears string from user and redirects to
	 * configured url. Else redirects to configured fail url.
	 * 
	 * @access public
	 * @param mixed $confirm_string
	 * @return void
	 */
	public function do_confirm_register($confirm_string)
	{
		// check for user with confirm_string
		$this->_ci->load->model('ci_authentication_model', 'auth_model');
		$this->_ci->load->helper('url');
		$this->_ci->load->library(array('session', 'ci_alerts'));
		$q = $this->_ci->auth_model->get_user_by_confirm_string($confirm_string);
		
		// on match
		if ($q->num_rows > 0)
		{	
			// remove confirm string from user
			$r = $q->row();
			$user = array(
				'id' => $r->id,
				config_item('confirm_string_field') => ''
			);
			$this->_ci->auth_model->edit_user($user);
			
			// redirect to confirm success page
			$this->_ci->ci_alerts->set('success', config_item('confirm_register_success_message'));
			redirect(config_item('confirm_register_success_url'));
		}
		// on no match
		else
		{
			log_message('error', 'Authentication: confirm register fail.');
			
			// redirect to confirm fail page
			$this->_ci->ci_alerts->set('error', config_item('confirm_register_fail_message'));
			redirect(config_item('confirm_register_fail_url'));
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * do_request_reset_password function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return void
	 */
	public function do_request_reset_password($username)
	{
		// load resources
		$this->_ci->load->helper(array('encrypt_helper', 'url'));
		$this->_ci->load->library(array('email', 'session', 'ci_alerts'));
		
		// email reset password link

		// from, to, url, content
		$this->_ci->email->from(config_item('request_reset_email_from'), config_item('request_reset_email_from_name'));
		$this->_ci->email->to($username);
		
		// set confirm reset url, content
		$data['confirm_reset_url'] = base_url() . config_item('confirm_reset_url') . '?' . config_item('username_field') . '=' . $username . '&string=' . encrypt_this($username, $username[0]);
		$data['content'] = $msg = $this->_ci->load->view(config_item('email_request_reset_view'), $data, TRUE);
		
		// wrap email in template if it exists
		if (config_item('email_template_view') != '')
		{
			$msg = $this->_ci->load->view(config_item('email_template_view'), $data, TRUE);
		}
		
		// subject, msg, send
		$this->_ci->email->subject(config_item('request_reset_email_subject'));
		$this->_ci->email->message($msg);
		$this->_ci->email->send();
		
		// redirect
		$this->_ci->ci_alerts->set('success', config_item('request_reset_success_message'));
		$this->_ci->session->set_flashdata('alert_page_title', config_item('request_reset_success_title'));
		redirect(config_item('request_reset_success_url'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * do_confirm_reset_password function.
	 * 
	 * @access public
	 * @return void
	 */
	public function do_confirm_reset_password()
	{
		// load resources
		$this->_ci->load->helper(array('encrypt_helper', 'string', 'url'));
		$this->_ci->load->library(array('email', 'session', 'ci_alerts'));
		$this->_ci->load->model('ci_authentication_model', 'auth_model');
		
		// get username and encrypted_username
		$username = $this->_ci->input->get(config_item('username_field'));
		$encrypted_username = $this->_ci->input->get('string');
		
		// check if username matches
		if (encrypt_this($username, $username[0]) == $encrypted_username)
		{
			// get user for id
			$q = $this->_ci->auth_model->get_user_by_username($username);
			
			if ($q->num_rows() > 0)
			{
				// set new password, update user
				$user = $q->row();
				$salt = random_string('alnum', config_item('salt_length'));
				$data['new_password'] = $new_password = random_string('alnum', 8);
				$update = array(
					'id' => $user->id,
					'password' => encrypt_this($new_password, $salt)
				);
				$this->_ci->auth_model->edit_user($update);
				
				// email new password
		
				// from, to, url, content
				$this->_ci->email->from(config_item('confirm_reset_email_from'), config_item('confirm_reset_email_from_name'));
				$username_field = config_item('username_field');
				$this->_ci->email->to($user->$username_field);
				
				// set confirm reset url, content
				$data['content'] = $msg = $this->_ci->load->view(config_item('email_confirm_reset_view'), $data, TRUE);
				
				// wrap email in template if it exists
				if (config_item('email_template_view') != '')
				{
					$msg = $this->_ci->load->view(config_item('email_template_view'), $data, TRUE);
				}
				
				// subject, msg, send
				$this->_ci->email->subject(config_item('confirm_reset_email_subject'));
				$this->_ci->email->message($msg);
				$this->_ci->email->send();
				
				// redirect
				$this->_ci->ci_alerts->set('success', config_item('confirm_reset_success_message'));
				redirect(config_item('confirm_reset_success_url'));
			}
			else
			{
				log_message('error', 'Authentication: confirm reset password link with user not found in database.');
			}
		}
		else
		{
			log_message('error', 'Authentication: confirm reset password link with non-matching username and encrypted username.');
		}
	}
	
	// --------------------------------------------------------------------------
}

/* End of file ci_authentication.php */
/* Location: ./ci_authentication/libraries/ci_authentication.php */