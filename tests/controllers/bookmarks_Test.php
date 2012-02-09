<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks_Test
 * 
 * tests the bookmarks class
 * 
 * @license		Copyright Mike Funk. All Rights Reserved.
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
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
		$this->_ci = set_controller('bookmarks');
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
		// test
		$this->_ci->list_bookmarks();
		$out = output();
		
		// Check if the content is OK
		$this->assertSame(0, preg_match('/(error|notice)(?:")/i', $out));
		$this->assertNotEquals('', $out);
		
		// add a record and try again
		// add bookmark
		$data = array(
			'url' => 'http://test.com',
			'description' => 'test description'
		);
		$this->assertTrue($this->_ci->db->insert('bookmarks', $data));
		$bookmark_id = $this->_ci->db->insert_id();
		
		// test
		$this->_ci->list_bookmarks();
		$out = output();
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->_ci->db->delete('bookmarks');
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