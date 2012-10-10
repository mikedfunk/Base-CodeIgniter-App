<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * support stubs for bookmark_model
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file bookmark_model_support.php
 */

// --------------------------------------------------------------------------

// require stuff to extend
require_once(BASEPATH . 'core/Model.php');
require_once(APPPATH . 'core/MY_Model.php');
require_once(APPPATH . 'models/bookmark_model.php');

// set mock data
$get_data = (object)array(
	'url' => 'http://yahoo.com',
	'description' => 'yaaay',
	'user_id' => '1',
	'id' => 37
);

$insert_return = (object)array('id' => 37);
$delete_return = $update_return = (object)array('success' => true);

// --------------------------------------------------------------------------

/**
 * extends bookmark model to return dummy data.
 * 
 * @extends bookmark_model
 */
class test_bookmark_model extends bookmark_model
{
	public function request($method, $path, $params = array())
	{
		global $get_data, $insert_return, $delete_return, $update_return;
		switch ($method)
		{
			case 'GET':
				return $get_data;
			break;
			case 'PUT':
				return $update_return;
			break;
			case 'POST':
				return $insert_return;
			break;
			case 'DELETE':
				return $delete_return;
			break;
		}
	}
}

// --------------------------------------------------------------------------

/* End of file bookmark_model_support.php */
/* Location: ./tests/support/bookmark_model_support.php */