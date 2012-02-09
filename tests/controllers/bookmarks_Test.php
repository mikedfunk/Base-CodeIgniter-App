<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks_Test
 * 
 * tests the bookmarks class
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		bookmarks_Test.php
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * bookmarks_Test class.
 * 
 * @extends CIUnit_TestCase
 */
class bookmarks_Test extends CIUnit_TestCase
{
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
		$this->CI = set_controller('bookmarks');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * test_list_bookmarks function.
	 * 
	 * @access public
	 * @return void
	 */
	public function test_list_bookmarks()
	{
		$this->CI->list_bookmarks();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertNotEquals('', $out);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * tearDown function.
	 * 
	 * @access public
	 * @return void
	 */
	public function tearDown()
	{
		parent::tearDown();
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmarks_Test.php */
/* Location: ./bookymark/tests/controllers/bookmarks_Test.php */