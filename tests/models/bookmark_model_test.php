<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * tests all methods in models/bookmark_model.php
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file bookmark_model_Test.php
 */

// --------------------------------------------------------------------------

/**
 * support classes, vars, etc.
 */
require_once(TESTSPATH . 'support/bookmark_model_support.php');

// --------------------------------------------------------------------------

/**
 * bookmark_model_Test class.
 *
 * @extends CIUnit_TestCase
 */
class bookmark_model_Test extends CIUnit_TestCase
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
	 * set up codeigniter
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_ci =& get_instance();

		// stub db class
		$this->_ci->bookmark_model = new test_bookmark_model();
	}

	// --------------------------------------------------------------------------

	/**
	 * test get_all.
	 *
	 * @access public
	 * @return void
	 */
	public function test_get_all()
	{
		// set data and compare
		global $get_data;
		$this->assertEquals($get_data, $this->_ci->bookmark_model->get_all());
	}

	// --------------------------------------------------------------------------

	/**
	 * test get_many_by.
	 *
	 * @access public
	 * @return void
	 */
	public function test_get_many_by()
	{
		// set data and compare
		global $get_data;
		$this->assertEquals($get_data, $this->_ci->bookmark_model->get_many_by());
	}

	// --------------------------------------------------------------------------

	/**
	 * test get.
	 *
	 * @access public
	 * @return void
	 */
	public function test_get()
	{
		// set data and compare
		global $get_data;
		$this->assertEquals($get_data, $this->_ci->bookmark_model->get('test'));
	}

	// --------------------------------------------------------------------------

	/**
	 * test_insert function.
	 *
	 * @access public
	 * @return void
	 */
	public function test_insert()
	{
		// set data and compare
		global $insert_return, $get_data;
		$content = (array)$get_data;
		$this->assertEquals($insert_return->id, $this->_ci->bookmark_model->insert($content));
	}

	// --------------------------------------------------------------------------

	/**
	 * test_delete function.
	 *
	 * @access public
	 * @return void
	 */
	public function test_delete()
	{
		// set data and compare
		$this->assertEquals(true, $this->_ci->bookmark_model->delete(1));
	}

	// --------------------------------------------------------------------------

	/**
	 * test_update function.
	 *
	 * @access public
	 * @return void
	 */
	public function test_update()
	{
		global $get_data;
		$content = (array)$get_data;
		$this->assertEquals(true, $this->_ci->bookmark_model->update($content['id'], $content));
	}

	// --------------------------------------------------------------------------
}
/* End of file bookmark_model_Test.php */
/* Location: ./bookymark/tests/models/bookmark_model_Test.php */