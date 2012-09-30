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

class bookmarks extends MY_Controller
{
	
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
		$this->load->spark('assets/1.5.1');
		$this->load->helper('partial');
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
		$this->data['bookmark'] = new Bookmark_presenter($this->bookmark->get_all());
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
		$this->data['bookmark'] = new Bookmark_presenter($this->bookmark->get($id));
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * the form and action to create a bookmark.
	 * 
	 * @access public
	 * @return void
	 */
	public function create()
	{
		$this->view = 'bookmarks/edit';
		$this->load->helper('form');
		if ($this->input->post())
		{
			if ($this->bookmark->insert($this->input->post()))
			{
				$this->ci_alerts->set('success', 'Bookmark created.');
				redirect('bookmarks');
			}
		}
		$this->data['bookmark'] = new Bookmark_presenter(false);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmarks.php */
/* Location: ./application/controllers/bookmarks.php */