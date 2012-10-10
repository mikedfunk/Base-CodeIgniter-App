<?php

/**
 * extends ciunit/phpunit for functional testing of the api
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file api_TestCase.php
 */

namespace API\Tests;

// class api_TestCase extends \PHPUnit_Framework_TestCase
class api_TestCase extends \CIUnit_TestCase
{
	/**
	 * The API URL, the access token and shared secret
	 */
// 	protected $api_base_url = 'http://bookymark.dev/';
// 	protected $api_access_token = '4395dd07a3cfe84d9655bb2542907f3acd0024fe';
// 	protected $api_shared_secret = '3c697e1314808f56bd44bc5ccb4765607b433715';

	protected $api_base_url;
	protected $api_access_token;
	protected $api_shared_secret;
	
	// --------------------------------------------------------------------------
	
	public function __construct()
	{
		parent::setUp();
		$config = array();
		require(APPPATH . 'config/testing/bookymark_api.php');
		foreach ($config as $key => $value)
		{
			$this->$key = $value;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Make a cURL request, with params, to the API.
	 * 
	 * @access public
	 * @param string $method such as GET
	 * @param string $path such as api/v2/bookmarks
	 * @param array $params (default: array()) the get/put/post params
	 * @return array
	 */
	protected function request($method, $path, $params = array())
	{
		$path = 'api/v1/' . $path;
		
		// set curl handler and options
		$curl = curl_init($this->api_base_url . $path);
		
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		// set required headers
		$headers = array();
		$headers[] = 'User-Agent: Bookymark Application';
		$headers[] = 'Accept: application/json; version=v1';
		$headers[] = 'X-Access-Token: ' . $this->api_access_token;

		$timestamp = time();
		$headers[] = 'X-Request-Timestamp: ' . $timestamp;

		// build signature and set header
		$hash = $path . http_build_query($params);
		$hash .= $timestamp . $this->api_shared_secret;
		$signature = sha1($hash);
		$headers[] = 'X-Request-Signature: ' . $signature;

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		// execute and return
		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		
		$return = array(
			'info' => $info,
			'body' => json_decode($result)
		);
		
		return $return;
	}
}