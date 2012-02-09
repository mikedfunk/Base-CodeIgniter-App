<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * bookmarks_model_test
 * 
 * Description
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		bookmarks_model_test.php
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------

/**
 * bookmarks_model_test class.
 * 
 * @extends CIUnit_TestCase
 */
class bookmarks_model_test extends CIUnit_TestCase
{
	// --------------------------------------------------------------------------
	
	/**
	 * _ci
	 *
	 * Codeigniter superobject.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_ci;
	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 *
	 * extra variables are required for testing, even if blank.
	 * 
	 * @access public
	 * @param mixed $name (default: NULL)
	 * @param array $data (default: array())
	 * @param string $dataName (default: '')
	 * @return void
	 */
	public function __construct($name = NULL, array $data = array(), $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
	}
	
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
		
		$this->_ci =& get_instance();
		$this->_ci->load->database();
		$this->_ci->load->model('bookmarks_model');
		$this->_ci->db->cache_off();
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
	
	/**
	 * test_bookmarks_table function.
	 * 
	 * @access public
	 * @return void
	 */
	public function test_bookmarks_table()
	{
		// add bookmark
		$data = array(
			'url' => 'http://test.com',
			'description' => 'test description'
		);
		$this->assertTrue($this->_ci->db->insert('bookmarks', $data));
		$bookmark_id = $this->_ci->db->insert_id();
		
		// test
		$q = $this->_ci->bookmarks_model->bookmarks_table();
		$this->assertGreaterThan(0, $q->num_rows());
		
		// delete bookmark
		$this->_ci->db->where('id', $bookmark_id);
		$this->_ci->db->delete('bookmarks');
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmarks_model_test.php */
/* Location: ./bookymark/tests/models/bookmarks_model_test.php */