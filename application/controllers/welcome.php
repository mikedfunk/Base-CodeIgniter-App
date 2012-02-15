<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * welcome
 * 
 * Description
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		welcome.php
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * welcome class.
 * 
 * @extends CI_Controller
 */
class welcome extends CI_Controller
{
	// --------------------------------------------------------------------------
	
	/**
	 * _data
	 *
	 * holds all data for views
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
		
		// for testing to work
		$fcpath = str_replace('application/third_party/CIUnit/', '', FCPATH);
		$apppath = str_replace($fcpath, '', APPPATH);
		
		// load resources
		require_once($fcpath.$apppath.'libraries/less_css/lessc.inc.php');
		$this->load->add_package_path($fcpath.$apppath.'third_party/carabiner');
		$this->load->library('carabiner');
// 		$this->config->load('carabiner', TRUE);
// 		
// 		// set style and script dirs
// 		$this->_data['style_dir'] = $fcpath . $this->config->item('style_dir', 'carabiner');
// 		$this->_data['script_dir'] = $fcpath . $this->config->item('script_dir', 'carabiner');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * index function.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{	
		// load view
		$this->_data['content'] = $this->load->view('test_view', $this->_data, TRUE);
		$this->load->view('template_view', $this->_data);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file welcome.php */
/* Location: ./base_codeigniter_app/application/controllers/welcome.php */