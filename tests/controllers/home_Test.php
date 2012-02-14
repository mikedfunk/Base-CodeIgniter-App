<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * home_Test
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		home_Test.php
 * @version		1.0
 * @date		02/14/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * home_Test class.
 * 
 * @extends CIUnit_TestCase
 */
class home_Test extends CIUnit_TestCase
{
	// --------------------------------------------------------------------------
	
	/**
	 * _ci
	 *
	 * the codeigniter super object
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_ci;
	
	// --------------------------------------------------------------------------
	
	/**
	 * setUp function.
	 * 
	 * @access public
	 * @return void
	 */
	public function setUp()
	{
		parent::setUp();
		
		// Set the tested controller
		$this->_ci = set_controller('home');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function test_login()
	{
		// test
		$this->_ci->login();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertNotEquals('', $out);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file home_Test.php */
/* Location: ./bookymark/tests/controllers/home_Test.php */