<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * support stuff for bookmark test
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file bookmark_support.php
 */

// bookmark content
$get_content = (object)array(
	'url' => 'http://whatever.com',
	'description' => 'whatever',
	'id' => 37,
	'user_id' => 99
);

$delete_return = (object)array('success' => true);

// --------------------------------------------------------------------------

// mock auth model
$this->_ci->ci_authentication_model = $this->getMock('ci_authentication_model', array(
	'get_user_by_username'
));

$this->_ci->ci_authentication_model->expects($this->any())
	->method('get_user_by_username')
	->will($this->returnValue(mock_get_user::getInstance()));

// --------------------------------------------------------------------------

// mock assets lib
$this->_ci->assets = $this->getMock('Assets', array(
	'css',
	'cdn',
	'js'
));

// --------------------------------------------------------------------------

// mock bookmark model
$this->_ci->bookmark = $this->getMock('Bookmark_model', array(
	'get_many_by',
	'delete'
));

$this->_ci->ci_authentication_model->expects($this->any())
	->method('get_many_by')
	->will($this->returnValue($get_content));

$this->_ci->ci_authentication_model->expects($this->any())
	->method('delete')
	->will($this->returnValue($delete_return));

/* End of file bookmark_support.php */
/* Location: ./tests/support/bookmark_support.php */