<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * data access methods for bookmarks
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file bookmark_model.php
 */

class bookmark_model extends MY_Model
{
	// --------------------------------------------------------------------------
	
	/**
	 * validation in the model with MY_Model
	 * 
	 * @var array
	 * @access public
	 */
	public $validate = array(
		array(
			'field' => 'url',
			'label' => 'URL',
			'rules' => 'required'
		),
		array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => 'required'
		)
	);
	
	// --------------------------------------------------------------------------	
}
/* End of file bookmark_model.php */
/* Location: ./application/models/bookmark_model.php */