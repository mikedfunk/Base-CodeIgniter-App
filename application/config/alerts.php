<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * alerts_config
 * 
 * The HTML for alerts
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		alerts_config.php
 * @version		1.0
 * @date		02/22/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

$config['before_all'] = '';
$config['before_each'] = '';
$config['before_error'] = '<div class="alert alert-error fade in"><a class="close" href="#">&times;</a>';
$config['before_success'] = '<div class="alert alert-success fade in"><a class="close" href="#">&times;</a>';
$config['before_warning'] = '<div class="alert alert-warning fade in"><a class="close" href="#">&times;</a>';
$config['before_info'] = 
$config['before_no_type'] = '<div class="alert alert-info fade in"><a class="close" href="#">&times;</a>';

$config['after_all'] = '';
$config['after_each'] = '</div><!--alert-->';
$config['after_error'] = '';
$config['after_success'] = '';
$config['after_warning'] = '';
$config['after_info'] = '';
$config['after_no_type'] = '';

/* End of file alerts_config.php */
/* Location: ./ci_authentication/config/alerts_config.php */