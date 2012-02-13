<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks_model
 * 
 * Description
 * 
 * @license		Copyright Mike Funk. All Rights Reserved.
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		bookmarks_model.php
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * bookmarks_model class.
 * 
 * @extends CI_Model
 */
class bookmarks_model extends CI_Model
{
	// --------------------------------------------------------------------------
	
	/**
	 * bookmarks_table function.
	 * 
	 * @access public
	 * @param array $opts an array of options
	 * @return void
	 */
	public function bookmarks_table($pass = array())
	{
		// if there's no get_post
		if ($pass == false) {$pass = array();}
		
		// merge options
		$opts = array(
			'limit' => '',
			'page' => '',
			'sort_by' => '',
			'sort_dir' => 'asc',
			'filter' => '',
			'ids_only' => false
		);
		$opts = array_merge($opts, $pass);
		
		// select
		if ($opts['ids_only'])
		{
			$this->db->select('id');
		}
		else
		{
			$this->db->select('url, description');
		}
		
		// sort
		if ($opts['sort_by'] != '' && $opts['sort_by'] != false)
		{
			$this->db->order_by($opts['sort_by'], $opts['sort_dir']);
		} 
		else 
		{
			$this->db->order_by('id', 'desc');
		}
		
		// limit and offset
		if ($opts['page'] != '' || $opts['limit'] != '')
		{
			$this->db->limit($opts['limit'], $opts['page']);
		}
		
		return $this->db->get('bookmarks');
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmarks_model.php */
/* Location: ./bookymark/application/models/bookmarks_model.php */