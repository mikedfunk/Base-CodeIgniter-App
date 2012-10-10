<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(TESTSPATH . 'support/mock_get_user.php');

/**
 * tests all bookmark controller methods
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file bookmark_Test.php
 */

/**
 * bookmark_Test class.
 *
 * @extends CIUnit_TestCase
 */
class bookmark_Test extends CIUnit_TestCase
{
	// --------------------------------------------------------------------------

	/**
	 * codeigniter
	 *
	 * @var object
	 * @access private
	 */
	private $_ci;

	// --------------------------------------------------------------------------

	/**
	 * setup.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_ci =& set_controller('bookmarks');
		$this->_ci->router->class = 'bookmarks';
		require_once(TESTSPATH . 'support/bookmark_support.php');
	}

	// --------------------------------------------------------------------------

	/**
	 * test index function.
	 *
	 * @group controllers
	 * @access public
	 * @return void
	 */
	public function test_index()
	{
		// make sure there are no exceptions
		try
		{
			$this->_ci->_remap('index');
			$out = output();
			$this->assertNotEquals('', $out);
		}
		catch (Exception $e)
		{
			$this->assertEquals('', $e->getMessage());
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * test create_new function.
	 *
	 * @group controllers
	 * @access public
	 * @return void
	 */

	public function test_create_new()
	{
		// make sure there are no exceptions
		try
		{
			$this->_ci->before_filters = array();
			$this->_ci->_remap('create_new');
			// $this->_ci->create_new();
			$out = output();
			$this->assertNotEquals('', $out);
		}
		catch (Exception $e)
		{
			$this->assertEquals('', $e->getMessage());
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * test create_new function.
	 *
	 * @group controllers
	 * @access public
	 * @return void
	 */

	public function edit()
	{
		// make sure there are no exceptions
		try
		{
			$this->_ci->before_filters = array();
			$this->_ci->_remap('edit/1');
			// $this->_ci->create_new();
			$out = output();
			$this->assertNotEquals('', $out);
		}
		catch (Exception $e)
		{
			$this->assertEquals('', $e->getMessage());
		}
	}

	// --------------------------------------------------------------------------

	/**
	 * test create_new function.
	 *
	 * @group controllers
	 * @access public
	 * @return void
	 */

	public function delete()
	{
		// make sure there are no exceptions
		try
		{
			$this->_ci->before_filters = array();
			$this->_ci->_remap('delete/1');
			// $this->_ci->create_new();
			$out = output();
			$this->assertNotEquals('', $out);
			$this->assetEquals((object)array('success' => true), $out);
		}
		catch (Exception $e)
		{
			$this->assertEquals('', $e->getMessage());
		}
	}

	// --------------------------------------------------------------------------
}
/* End of file bookmark_Test.php */
/* Location: ./tests/controllers/bookmark_Test.php */