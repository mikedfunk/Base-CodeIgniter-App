<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * display bookmarks
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file bookmarks.php
 */

require_once(APPPATH . 'presenters/bookmark_presenter.php');
require_once(APPPATH . 'presenters/auth_presenter.php');

class bookmarks extends MY_Controller
{
	public $before_filters = array('_authenticate_user');

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
		$this->load->spark('ci_alerts/1.1.7');
		$this->load->spark('ci_authentication/1.3.4');
		$this->load->spark('assets/1.5.1');
		$this->load->helper('partial');
		$this->data['auth'] = new Auth_presenter(false);
	}

	// --------------------------------------------------------------------------

	/**
	 * show bookmarks for the logged in user.
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->data['bookmark'] = new Bookmark_presenter($this->bookmark->get_many_by('user_id', auth_id()));
	}

	// --------------------------------------------------------------------------

	/**
	 * _authenticate_user function.
	 *
	 * @access protected
	 * @return void
	 */
	protected function _authenticate_user()
	{
		// restrict user
		$q = $this->ci_authentication_model->get_user_by_username(auth_username());
		if ($q->num_rows() == 0 && auth_username() != '')
		{
			throw new Exception('No users found with the email address ' . auth_username() . '.');
		}
		else if ($q->num_rows() > 1 && auth_username() != '')
		{
			throw new Exception('There is more than one user with the email address ' . auth_username() . '.');
		}
		$this->data['user'] = $q->row();
		$condition = (isset($this->data['user']) ? $this->data['user']->can_list_bookmarks : FALSE);
		$this->ci_authentication->restrict_access($condition);
	}

	// --------------------------------------------------------------------------

	/**
	 * the form and action to create a bookmark.
	 *
	 * @access public
	 * @return void
	 */
	public function create_new()
	{
		$this->view = 'bookmarks/edit';
		$this->load->helper('form');
		if ($this->input->post())
		{
			if ($this->bookmark->insert($this->input->post()))
			{
				$this->ci_alerts->set('success', 'Bookmark added.');
				redirect('bookmarks');
			}
		}
		$this->data['bookmark'] = new Bookmark_presenter(false);
	}

	// --------------------------------------------------------------------------

	/**
	 * the form and action to edit a bookmark.
	 *
	 * @access public
	 * @param mixed $id
	 * @return void
	 */
	public function edit($id)
	{
		$this->load->helper('form');
		if ($this->input->post())
		{
			if ($this->bookmark->update($this->input->post('id'), $this->input->post()))
			{
				$this->ci_alerts->set('success', 'Bookmark edited.');
				redirect('bookmarks');
			}
		}

		$result = $this->bookmark->get($id);
		if (count((array)$result) == 0)
		{
			throw new Exception('Bookmark not found.');
		}
		$this->data['bookmark'] = new Bookmark_presenter($result);
	}

	// --------------------------------------------------------------------------

	/**
	 * delete action. On success, sets alert and redirects.
	 *
	 * @access public
	 * @param mixed $id
	 * @return void
	 */
	public function delete($id)
	{
		$this->ci_alerts->set('success', 'Bookmark deleted.');
		if (!$this->bookmark->delete($id))
		{
			throw new Exception('There was en error deleting your bookmark.');
		}
		redirect('bookmarks');
	}

	// --------------------------------------------------------------------------

	/**
	 * checks for a valid url via form_validation.
	 *
	 * @access public
	 * @param string $url
	 * @return bool
	 */
	public function _url_check($url)
	{
		if (preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $url))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('_url_check', 'Please enter a valid URL.');
			return false;
		}
	}

	// --------------------------------------------------------------------------
}
/* End of file bookmarks.php */
/* Location: ./application/controllers/bookmarks.php */