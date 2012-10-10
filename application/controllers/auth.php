<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * authentication controller methods
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file auth.php
 */

require_once(APPPATH . 'presenters/auth_presenter.php');

class auth extends MY_Controller
{
	public $data;

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
		$this->load->spark('ci_authentication/1.3.4');
		$this->load->spark('assets/1.5.1');
		$this->load->helper('url');
		$this->load->helper('partial');
		$this->data['auth'] = new Auth_presenter($this->input->post());
		$this->load->model('bookmark_model', 'bookmark');
	}

	// --------------------------------------------------------------------------

	/**
	 * login function.
	 *
	 * shows login form, handles validation.
	 *
	 * @access public
	 * @return void
	 */
	public function login()
	{
		// load resources
		$this->load->helper('cookie');
		$this->load->library('form_validation');
		$this->data['auth'] = new Auth_presenter($this->input->post());
		$this->ci_authentication->remember_me();

		// form validation
		$validate = array(
			array(
				'field' => 'email_address',
				'label' => 'Email Address',
				'rules' => 'trim|required|valid_email|callback__email_address_check'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|callback__password_check'
			)
		);
		$this->form_validation->set_rules($validate);

		// check for valid form, reshow form if invalid, else login and redirect
		if ($this->form_validation->run())
		{
			$this->ci_authentication->do_login();
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * login_new_password function.
	 *
	 * shows login_new_password form, handles validation.
	 *
	 * @access public
	 * @return void
	 */
	public function login_new_password()
	{
		// load resources
		$this->load->helper('cookie');
		$this->load->library('form_validation');
		$this->data['auth'] = new Auth_presenter($this->input->post());
		$this->ci_authentication->remember_me();

		// form validation
		$validate = array(
			array(
				'field' => 'email_address',
				'label' => 'Email Address',
				'rules' => 'trim|required|valid_email|callback__email_address_check'
			),
			array(
				'field' => 'temp_password',
				'label' => 'Temporary Password',
				'rules' => 'required|callback__password_check'
			),
			array(
				'field' => 'password',
				'label' => 'New Password',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'confirm_password',
				'label' => 'Confirm Password',
				'rules' => 'trim|required|matches[password]'
			)
		);
		$this->form_validation->set_rules($validate);

		// check for valid form, reshow form if invalid, else login and redirect
		if ($this->form_validation->run())
		{
			// redirect to configured home page
			$this->ci_authentication->do_login();
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * _email_address_check function.
	 *
	 * checks for an email in the db and checks to make sure registration link
	 * has been clicked.
	 *
	 * @access public
	 * @param string $email_address
	 * @return bool
	 */
	public function _email_address_check($email_address)
	{
		if (!$this->ci_authentication_model->username_check($email_address))
		{
			$this->form_validation->set_message('_email_address_check', 'Email address not found. <a href="' . base_url() . 'auth/register">Want to Register?</a>');
			return false;
		}
		else
		{
			// if there's a confirm string, fail
			$q = $this->ci_authentication_model->get_user_by_username($email_address);
			$r = $q->row();
			// if (!$this->ci_authentication_model->confirm_string_check($email_address))
			if ($r->confirm_string != '')
			{
				$this->form_validation->set_message('_email_address_check', 'Please click the registration link sent to your email. <a href="'.base_url().'auth/resend_register_email/'.$r->confirm_string.'">Or resend it</a>.');
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * _password_check function.
	 *
	 * checks to ensure password matches username in db.
	 *
	 * @access public
	 * @param string $password
	 * @return bool
	 */
	public function _password_check($password)
	{
		$chk = $this->ci_authentication_model->password_check($this->input->post('email_address'), $password);
		if (!$chk)
		{
			$this->form_validation->set_message('_password_check', 'Incorrect password. <a href="'.base_url().'auth/request_reset_password/?email_address='.$this->input->post('email_address').'">Forgot your password?</a>');
			return false;
		}
		else
		{
			return true;
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * register function.
	 *
	 * displays register form, handles validation, runs ci_authentication library
	 * method on success.
	 *
	 * @access public
	 * @return void
	 */
	public function register()
	{
		$this->load->library('form_validation');
		$this->data['auth'] = new Auth_presenter($this->input->post());

		// form validation
		$validate = array(
			array(
				'field' => 'email_address',
				'label' => 'Email Address',
				'rules' => 'trim|required|valid_email|is_unique[users.email_address]'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required'
			),
			array(
				'field' => 'confirm_password',
				'label' => 'Confirm Password',
				'rules' => 'trim|required|matches[password]'
			)
		);
		$this->form_validation->set_rules($validate);

		if ($this->form_validation->run())
		{
			// redirect to configured home page
			$this->ci_authentication->do_register();
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * resend_register_email function.
	 *
	 * resends register email based on confirm_string, redirects to configured page.
	 *
	 * @access public
	 * @param string $confirm_string
	 * @return void
	 */
	public function resend_register_email($confirm_string)
	{
		$this->ci_authentication->resend_register_email($confirm_string);
	}

	// --------------------------------------------------------------------------

	/**
	 * confirm_register function.
	 *
	 * verifies confirm link, clears confirm_string column for that user, sets
	 *  flashdata for success notice, redirects to login page.
	 *
	 * @access public
	 * @param string $confirm_string
	 * @return void
	 */
	public function confirm_register($confirm_string)
	{
		$this->ci_authentication->do_confirm_register($confirm_string);
	}

	// --------------------------------------------------------------------------

	/**
	 * request_reset_password function.
	 *
	 * send email confirmation to user, redirects to configured page.
	 *
	 * @access public
	 * @return void
	 */
	public function request_reset_password()
	{
		$email_address = $this->input->get('email_address');
		$this->ci_authentication->do_request_reset_password($email_address);
	}

	// --------------------------------------------------------------------------

	/**
	 * confirm_reset_password function.
	 *
	 * validates whether encryption of passed email and encrypted string match,
	 * emails temp password and redirects to configured page (login new password)
	 *
	 * @access public
	 * @return void
	 */
	public function confirm_reset_password()
	{
		$this->ci_authentication->do_confirm_reset_password();
	}

	// --------------------------------------------------------------------------

	/**
	 * logout function.
	 *
	 * destroys the session, unsets userdata, sets flashdata, redirects to
	 * configured page (login page).
	 *
	 * @access public
	 * @return void
	 */
	public function logout()
	{
		$this->ci_authentication->do_logout();
	}

	// --------------------------------------------------------------------------

	/**
	 * alert function.
	 *
	 * @access public
	 * @return void
	 */
	public function alert()
	{
	}

	// --------------------------------------------------------------------------
}
/* End of file auth.php */
/* Location: ./bookymark/application/controllers/auth.php */