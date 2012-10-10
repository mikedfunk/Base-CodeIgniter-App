<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * cleans up the auth views.
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file auth_presenter.php
 */

require_once(APPPATH . 'presenters/presenter.php');

class Auth_presenter extends Presenter
{
	// --------------------------------------------------------------------------
	
	/**
	 * display the email address form field for logging in.
	 * 
	 * @access public
	 * @return string
	 */
	public function email_address_field()
	{	
		$return = '';
		
		// form value
		if (set_value('email_address') != '') 
		{
			$value = set_value('email_address');
		}
		else 
		{
			$value = (function_exists('get_cookie') ? get_cookie('email_address') : '');
		}
		
		$return .= '<div class="control-group form_item ' . (form_error('email_address') != '' ? 'error' : '') . '">'
		. form_label('Email Address: *', 'email_address_field', array('class' => 'control-label'))
		. '<div class="controls">'
		. form_input(array('name' => 'email_address', 'id' => 'email_address_field', 'class' => 'span3', 'value' => $value))
		. form_error('email_address')
		. '</div><!--controls-->
		</div><!--control-group-->';
		return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * display the email address form field for logging in.
	 * 
	 * @access public
	 * @return string
	 */
	public function password_field()
	{	
		$return = '';
		
		// form value
		if (set_value('password') != '') 
		{
			$value = set_value('password');
		}
		else 
		{
			$value = (function_exists('get_cookie') ? get_cookie('password') : '');
		}
		
		$return .= '<div class="control-group form_item ' . (form_error('password') != '' ? 'error' : '') . '">'
		. form_label('Password: *', 'password_field', array('class' => 'control-label'))
		. '<div class="controls">'
		. form_password(array('name' => 'password', 'id' => 'password_field', 'class' => 'span3', 'value' => $value))
		. form_error('password')
		. '</div><!--controls-->
		</div><!--control-group-->';
		return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * display the email address form field for logging in.
	 * 
	 * @access public
	 * @return string
	 */
	public function new_password_field()
	{	
		$return = '';
		
		// form value
		if (set_value('password') != '') {$value = set_value('password');}
		else {$value = get_cookie('password');}
		
		$return .= '<div class="control-group form_item ' . (form_error('password') != '' ? 'error' : '') . '">'
		. form_label('New Password: *', 'password_field', array('class' => 'control-label'))
		. '<div class="controls">'
		. form_password(array('name' => 'password', 'id' => 'password_field', 'class' => 'span3', 'value' => $value))
		. form_error('password')
		. '</div><!--controls-->
		</div><!--control-group-->';
		return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * display the email address form field for logging in.
	 * 
	 * @access public
	 * @return string
	 */
	public function temp_password_field()
	{	
		$return = '';
		
		// form value
		if (set_value('temp_password') != '') {$value = set_value('temp_password');}
		else {$value = get_cookie('temp_password');}
		
		$return .= '<div class="control-group form_item ' . (form_error('temp_password') != '' ? 'error' : '') . '">'
		. form_label('Temporary Password: *', 'temp_password_field', array('class' => 'control-label'))
		. '<div class="controls">'
		. form_password(array('name' => 'temp_password', 'id' => 'temp_password_field', 'class' => 'span3', 'value' => $value))
		. form_error('temp_password')
		. '</div><!--controls-->
		</div><!--control-group-->';
		return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * display the email address form field for logging in.
	 * 
	 * @access public
	 * @return string
	 */
	public function confirm_password_field()
	{	
		$return = '';
		
		// form value
		$value = set_value('confirm_password');
		
		$return .= '<div class="control-group form_item ' . (form_error('confirm_password') != '' ? 'error' : '') . '">'
		. form_label('Confirm Password: *', 'confirm_password_field', array('class' => 'control-label'))
		. '<div class="controls">'
		. form_password(array('name' => 'confirm_password', 'id' => 'confirm_password_field', 'class' => 'span3', 'value' => $value))
		. form_error('confirm_password')
		. '</div><!--controls-->
		</div><!--control-group-->';
		return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * the remember me checkbox.
	 * 
	 * @access public
	 * @return string
	 */
	public function remember_me_field()
	{
		// checked or not
		if ($this->input->post('remember_me') !== false) 
		{
			$checked = $this->input->post('remember_me');
		}
		else 
		{
			$checked = (function_exists('get_cookie') ? get_cookie('remember_me') : false);
		}
		
		$checkbox = form_checkbox(array('name' => 'remember_me', 'id' => 'remember_me_field', 'value' => '1', 'checked' => (boolean)$checked));

		$return = '<div class="control-group form_item">'
		. '<div class="controls">'
		. form_label($checkbox . ' <span>Remember Me</span>', 'remember_me_field', array('class' => 'checkbox'))
		. '</div><!--controls-->
		</div><!--control-group-->';
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * login info if logged in otherwise nothing.
	 * 
	 * @access public
	 * @return string
	 */
	public function logged_in_box()
	{
		$return = '';

		// logged in text
		if (is_callable('auth_username'))
		{
			if (auth_username() !== FALSE)
			{
				$return .= '<p class="navbar-text pull-right"><i class="icon-user"></i> Logged in as <strong>'.auth_username().'</strong>. <i class="icon-share"></i> <a href="'.base_url().'auth/logout">Logout</a></p>';
			}
		}
		return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * open the register form with params and hidden fields.
	 * 
	 * @access public
	 * @return string
	 */
	public function register_form_open()
	{
		$hidden = array('role_id' => 2);
		$params = array('id' => 'register_form', 'class' => 'form-horizontal');
		return form_open('', $params, $hidden);
	}
	
	// --------------------------------------------------------------------------
}

/* End of file auth_presenter.php */
/* Location: ./application/presenters/auth_presenter.php */