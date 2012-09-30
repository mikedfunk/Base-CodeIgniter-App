<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * autoload
 * 
 * Autoloads CI Authentication assets
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		autoload.php
 * @version		1.3.4
 * @date		03/20/2012
 */

// --------------------------------------------------------------------------

$autoload['libraries'] = array('ci_authentication');
$autoload['model'] = array('ci_authentication_model');
$autoload['helper'] = array('ci_authentication_helper');
$autoload['config'] = array('ci_authentication');

// --------------------------------------------------------------------------

/* End of file autoload.php */
/* Location: ./ci_authentication/config/autoload.php */