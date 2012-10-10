<?php

/**
 * function api tests
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file api_bookmark_Test.php
 */

namespace API\Tests;

require_once(TESTSPATH . 'support/api_TestCase.php');

/**
 * api_bookmark_Test class.
 * 
 * @extends api_TestCase
 */
class api_bookmark_Test extends api_TestCase
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
	 * set controller just to get active record.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_ci =& set_controller('bookmarks');
		
		// set production database
		$new_db = $this->_ci->load->database('development', TRUE);
		$this->_ci->db = $new_db;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * after each function.
	 * 
	 * @access public
	 * @return void
	 */
	public function tearDown()
	{
		parent::tearDown();
		
		// disable throttling
		$data['throttled_at'] = date('Y-m-d H:i:s', strtotime('-5 days'));
		$this->_ci->db->where('api_access_token', $this->api_access_token)
			->update('api_clients', $data);
	}
	
	// --------------------------------------------------------------------------

	/**
	 * POST /bookmarks
	 */
	public function test_post_delete_bookmarks()
	{
		$this->_add_bookmark();
		$this->_delete_last_bookmark();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * GET /bookmarks
	 */
	public function test_get_bookmarks()
	{
		$test_item = array(
			'url' => 'http://new_bookmark.com',
			'description' => 'New bookmark'
		);
		
		$this->_add_bookmark();
		$request = $this->request('GET', 'bookmarks');
		
		// deep convert to array
		$request = json_decode(json_encode($request), true);

		$this->assertEquals(200, $request['info']['http_code']);
		$this->assertInternalType('array', $request['body']);
		
		// check for existence of test item
		$in_body = false;
		foreach($request['body'] as $item)
		{
			if (in_array($test_item['url'], $item) && in_array($test_item['description'], $item))
			{
				$in_body = true;
			}
		}
		$this->assertTrue($in_body);
		$this->_delete_last_bookmark();
	}
	
	// --------------------------------------------------------------------------

	/**
	 * GET /bookmarks/[id]
	 */
	public function test_get_bookmark_one()
	{	
		$this->_add_bookmark();
		$id = $this->_get_last_id();
		$request = $this->request('GET', 'bookmarks/id/'.$id);

		// deep convert to array
		$request = json_decode(json_encode($request), true);
		
		$this->assertEquals(200, $request['info']['http_code']);
		$this->assertEquals('http://new_bookmark.com', $request['body'][0]['url']);
		$this->assertEquals('New bookmark', $request['body'][0]['description']);

		$request = $this->request('GET', 'bookmarks/testtest123');
		$this->assertEquals(404, $request['info']['http_code']);
		$this->_delete_last_bookmark();
	}
	
	// --------------------------------------------------------------------------

	/**
	 * PUT /bookmarks/[id]
	 */
	public function test_put_bookmarks()
	{
		$this->_add_bookmark();
		$id = $this->_get_last_id();
		$request = $this->request('PUT', 'bookmarks/' . $id, array(
			'id' => $id,
			'url' => 'http://another.com',
			'description' => 'Another New bookmark'
		));
		
		// deep convert to array
		$request = json_decode(json_encode($request), true);

		$this->assertEquals(200, $request['info']['http_code']);
		$this->assertEquals(true, $request['body']['success']);
		$this->_delete_last_bookmark();
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * returns the id of the last bookmark added.
	 * 
	 * @access private
	 * @return void
	 */
	private function _get_last_id()
	{
		// get last bookmark added
		$q = $this->_ci->db->select('id')
			->limit(1)
			->order_by('id', 'desc')
			->get('bookmarks');
		return $q->row()->id;
	}
	
	// --------------------------------------------------------------------------
	
	private function _add_bookmark()
	{
		$request = $this->request('POST', 'bookmarks', array(
			'url' => 'http://new_bookmark.com',
			'description' => 'New bookmark'
		));
		
		$this->assertEquals(201, $request['info']['http_code']);
		return $request;
	}
	
	// --------------------------------------------------------------------------
	
	private function _delete_last_bookmark()
	{
		$id = $this->_get_last_id();
		
		$request = $this->request('DELETE', 'bookmarks/'.$id);
		$request = json_decode(json_encode($request), true);
		
		$this->assertEquals(200, $request['info']['http_code']);
		$this->assertEquals(true, $request['body']['success']);
		return $request;
	}
	
	// --------------------------------------------------------------------------
}
/* End of file api_bookmark_Test.php */
/* Location: ./tests/controllers/api_bookmark_Test.php */