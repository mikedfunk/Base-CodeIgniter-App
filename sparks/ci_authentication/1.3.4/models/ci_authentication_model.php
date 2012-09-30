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
 * @version		1.3.4
 * @date		03/28/2012
 */

// --------------------------------------------------------------------------

/**
 * ci_authentication_model class.
 * 
 * @extends MY_Model
 */
class ci_authentication_model extends MY_Model
{	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 *
	 * Load common resources.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		// $this->config->load('ci_authentication');
		log_message('debug', 'CI Authentication: model loaded.');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * password_check function.
	 *
	 * Checks whether the password for a given user matches the passed password
	 * after being encrypted.
	 * 
	 * @access public
	 * @param string $username
	 * @param string $password
	 * @param bool $encrypted (default: FALSE)
	 * @return bool
	 */
	public function password_check($username, $password, $encrypted = FALSE)
	{	
		// check for blanks
		if ($username == '' || $password == '') { return FALSE; }
		
		// check for existing email
		$q = $this->get_user_by_username($username);
		
		if ($q->num_rows() == 0)
		{
			return FALSE;
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
				return FALSE;
			}
			else
			{
				return TRUE;
			}
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * username_check function.
	 *
	 * Checks whether a user by this username exists.
	 * 
	 * @access public
	 * @param string $username
	 * @param string $not_username (default: '')
	 * @return bool
	 */
	public function username_check($username, $not_username = '')
	{
		// exclude not_username if set
		if ($not_username != '')
		{
			$this->db->where(config_item('username_field') . ' !=', $not_username);
		}
		$q = $this->get_user_by_username($username);
		if ($q->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * confirm_string_check function.
	 *
	 * Checks to make sure this username does not have a confirm string.
	 * 
	 * @access public
	 * @param string $username
	 * @return bool
	 */
	public function confirm_string_check($username)
	{
		$this->db->where(config_item('username_field'), $username);
		$this->db->where(config_item('confirm_string_field'), '');
		$q = $this->db->get(config_item('users_table'));
		if ($q->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * get_role function.
	 *
	 * Returns the query object for a role by id.
	 * 
	 * @access public
	 * @param int $id
	 * @return object
	 */
	public function get_role($id)
	{
		$this->db->where('id', $id);
		return $this->db->get(config_item('roles_table'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * get_user_by_username function.
	 *
	 * Returns the query object for a user based on a passed username.
	 * 
	 * @access public
	 * @param string $username
	 * @return object
	 */
	public function get_user_by_username($username)
	{
		// if roles table is set, join it in
		if (config_item('roles_table') != '')
		{
			$rt = config_item('roles_table');
			$ut = config_item('users_table');
			$this->db->select($rt . '.*, ' . $ut . '.*');
			$this->db->join($rt, $rt . '.id = ' . $ut . '.' . config_item('role_id_field'));
		}
		$this->db->where(config_item('username_field'), $username);
		return $this->db->get(config_item('users_table'));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * get_user_by_confirm_string function.
	 *
	 * Returns the query object for a user with the passed confirm string.
	 * 
	 * @access public
	 * @param string $confirm_string
	 * @return object
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
	 * Edits a user passed via an array.
	 * 
	 * @access public
	 * @param array $post
	 * @return bool
	 */
	public function edit_user($post)
	{
		$this->db->where(config_item('user_id_field'), $post[config_item('user_id_field')]);
		return $this->db->update(config_item('users_table'), $post);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * edit_user_by_username function.
	 *
	 * Edits a user passed via an array.
	 * 
	 * @access public
	 * @param array $post
	 * @return bool
	 */
	public function edit_user_by_username($post)
	{
		$this->db->where(config_item('username_field'), $post[config_item('username_field')]);
		return $this->db->update(config_item('users_table'), $post);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * add_user function.
	 *
	 * Adds a user passed via an array.
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