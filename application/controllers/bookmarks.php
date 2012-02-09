<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		bookmarks.php
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * bookmarks class.
 * 
 * @extends CI_Controller
 */
class bookmarks extends CI_Controller
{
	// --------------------------------------------------------------------------
	
	/**
	 * _data
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_data;
	
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
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * list_bookmarks function.
	 * 
	 * @access public
	 * @return void
	 */
	public function list_bookmarks()
	{
		// load resources
		require_once(FCPATH.APPPATH.'libraries/less_css/lessc.inc.php');
		$this->load->library('carabiner');
		$this->config->load('carabiner', TRUE);
		
		// for testing to work
		$fcpath = str_replace('application/third_party/CIUnit/', '', FCPATH);
		$this->_data['style_dir'] = $fcpath . $this->config->item('style_dir', 'carabiner');
		$this->_data['script_dir'] = $fcpath . $this->config->item('script_dir', 'carabiner');
		
		// load view
		$this->_data['content'] = $this->load->view('list_bookmarks_view', '', TRUE);
		$this->load->view('template_view', $this->_data);
	}
	// --------------------------------------------------------------------------
}
/* End of file bookmarks.php */
/* Location: ./bookymark/application/controllers/bookmarks.php */