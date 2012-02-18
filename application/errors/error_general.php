<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * error_404
 * 
 * since I can't load a controller here, I'll just let this act like a controller.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		error_404.php
 * @version		1.0
 * @date		02/18/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

// load resources
$_ci =& get_instance();
$data = array(
	'title' => $heading,
	'message' => $message
);
$_ci->load->add_package_path(FCPATH_U . APPPATH_U . 'third_party/carabiner');
$_ci->load->library('carabiner');

// load views
$data['content'] = $_ci->load->view('error_view', $data, TRUE);
$_ci->load->view('template_view', $data);

// --------------------------------------------------------------------------

/* End of file error_404.php */
/* Location: ./base_codeigniter_app/application/errors/error_404.php */