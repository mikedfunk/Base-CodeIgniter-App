<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * the api endpoint for bookmarks
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file bookmarks.php
 */

require_once(APPPATH.'core/REST_Controller.php');

class bookmarks extends REST_Controller
{
	// --------------------------------------------------------------------------

	/**
	 * load resources.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/v1/bookmark_model', 'bookmark');
	}

	// --------------------------------------------------------------------------

	/**
	 * just show all bookmarks
	 *
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$this->data = $this->bookmark->get_all();
	}

	// --------------------------------------------------------------------------

	/**
	 * filter all results.
	 *
	 * @access public
	 * @return void
	 */
	public function show()
	{
		$where = func_get_args();
		if (count($where) % 2 == 1)
		{	
			$this->status_code = 404;
			$this->respond();
		}
		$this->data = $data = $this->bookmark->get_many_by($where);
	}

	// --------------------------------------------------------------------------

	/**
	 * add a bookmark, echo the new id.
	 *
	 * @access public
	 * @return void
	 */
	public function create()
	{	
		$this->status_code = 201;
		$this->data['id'] = $this->bookmark->insert($this->input->post());
	}

	// --------------------------------------------------------------------------

	/**
	 * delete a bookmark, return formatted success or fail.
	 *
	 * @access public
	 * @param int $id
	 * @return void
	 */
	public function delete($id)
	{
		// $this->status_code = 204;
		$this->data['success'] = $this->bookmark->delete($id);
	}

	// --------------------------------------------------------------------------

	/**
	 * update a bookmark, return formatted success or fail.
	 *
	 * @access public
	 * @param int $id
	 * @return string
	 */
	public function update($id)
	{
		if (!($tracker = $this->bookmark->get($id)))
		{
			$this->status_code = 404;
			$this->respond();
		}
		else
		{
			$this->data['success'] = $this->bookmark->update($id, $this->params);
		}
	}

	// --------------------------------------------------------------------------
}
/* End of file bookmarks.php */
/* Location: ./application/controllers/api/bookmarks.php */