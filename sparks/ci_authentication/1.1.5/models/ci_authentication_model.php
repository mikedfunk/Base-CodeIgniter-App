<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ci_authentication_model
 * 
 * All queries for ci_authentication package.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		ci_authentication_model.php
 * @version		1.1.5
 * @date		02/17/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * ci_authentication_model class.
 * 
 * @extends CI_Model
 */
class ci_authentication_model extends CI_Model
{	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 *
	 * load common resources.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->config->load('ci_authentication');
		log_message('debug', 'CI Authentication: model loaded.');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * password_check function.
	 *
	 * checks whether the password for a given user matches the passed password
	 * after being encrypted.
	 * 
	 * @access public
	 * @param string $username
	 * @param string $password
	 * @param bool $encrypted (default: false)
	 * @return bool
	 */
	public function password_check($username, $password, $encrypted = false)
	{	
		// check for blanks
		if ($username == '' || $password == '') { return false; }
		
		// check for existing email
		$q = $this->get_user_by_username($username);
		
		if ($q->num_rows() == 0)
		{
			return false;
		}
		// if it exists, *then* check for matching password
		else
		{
			// set up values
			$r = $q->row();
			$salt = substr($r->password, 0, config_item('salt_length'));
			$this->load->helper('encrypt_helper');
			
			if (!$encrypted) { $password = encrypt_this($password, $salt); }
			
			// check password and return match
			$this->db->where(config_item('username_field'), $username);
			$this->db->where(config_item('password_field'), $password);
			$q = $this->db->get(config_item('users_table'));
			if ($q->num_rows() == 0)
			{
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
	 * username_check function.
	 *
	 * checks whether a user by this username exists.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return bool
	 */
	public function username_check($username)
	{
		$q = $this->get_user_by_username($username);
		if ($q->num_rows() == 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * confirm_string_check function.
	 *
	 * checks to make sure this username does not have a confirm string
	 * 
	 * @access public
	 * @param mixed $username
	 * @return bool
	 */
	public function confirm_string_check($username)
	{
		$this->db->where(config_item('username_field'), $username);
		$this->db->where(config_item('confirm_string_field'), '');
		$q = $this->db->get(config_item('users_table'));
		if ($q->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * get_user_by_username function.
	 *
	 * returns the query for a user based on a passed username.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $join (default: true) whether to join in the role.
	 * @return object
	 */
	public function get_user_by_username($username, $join = true)
	{
		$ut = config_item('users_table');
		$rt = config_item('roles_table');
		
		// join in roles
		if ($join)
		{
			$this->db->select(
				$rt . '.*,' .
				$ut . '.id,' .
				$ut . '.' . config_item('username_field') . ',' .
				$ut . '.' . config_item('password_field') . ',' .
				$ut . '.' . config_item('confirm_string_field') . ','
			);
			$this->db->join($rt, $rt . '.id = ' . $ut . '.' . config_item('role_id_field'), 'left');
		}
		
		$this->db->where(config_item('username_field'), $username);
		return $this->db->get($ut);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * get_user_by_confirm_string function.
	 *
	 * returns the query for a user with the passed confirm string
	 * 
	 * @access public
	 * @param mixed $confirm_string
	 * @return void
	 */
	public function get_user_by_confirm_string($confirm_string)
	{
		$this->db->where(config_item('confirm_string_field'), $confirm_string);
		return $this->db->get(config_item('users_table'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * edit_user function.
	 *
	 * edits a user passed via an array.
	 * 
	 * @access public
	 * @param array $post
	 * @return bool
	 */
	public function edit_user($post)
	{
		$this->db->where('id', $post['id']);
		return $this->db->update(config_item('users_table'), $post);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * add_user function.
	 *
	 * adds a user passed via an array.
	 * 
	 * @access public
	 * @param array $post
	 * @return bool
	 */
	public function add_user($post)
	{
		return $this->db->insert(config_item('users_table'), $post);
	}
	
	// --------------------------------------------------------------------------
}

/* End of file ci_authentication_model.php */
/* Location: ./ci_authentication/models/ci_authentication_model.php */