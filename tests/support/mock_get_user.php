<?php

/**
 * mocks the get_user object so it returns dummy 
 * values from it's methods
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file mock_get_user.php
 */

/**
 * return num_rows() and row().
 */
class mock_get_user
{
	// --------------------------------------------------------------------------
	
	/**
	 * singleton instance
	 * 
	 * @var object
	 * @access private
	 * @static
	 */
	private static $instance;
	
	// --------------------------------------------------------------------------
	
	/**
	 * private constructor function
	 * to prevent external instantiation
	 * 
	 * @access private
	 * @return void
	 */
	private function __construct() { }
	
	// --------------------------------------------------------------------------

	/**
	 * singleton tool to either create a new object or return the instance
	 * 
	 * @access public
	 * @static
	 * @return void
	 */
	public static function getInstance()
	{
		if(!self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * returns dummy row.
	 * 
	 * @access public
	 * @return object
	 */
	public function row()
	{
		$out = array('can_list_bookmarks' => true);
		return (object)$out;
	}
	
	// --------------------------------------------------------------------------

	/**
	 * returns dummy number of rows.
	 * 
	 * @access public
	 * @return int
	 */
	public function num_rows()
	{
		return 1;
	}
	
	// --------------------------------------------------------------------------
}
/* End of file mock_get_user.php */
/* Location: ./tests/support/mock_get_user.php */