<?php

/**
 * api manifest. shows in requested format when OPTIONS is requested.
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file api_manifest.php
 */

namespace API\Manifest;

$manifest = array();

// /**
//  * GET /bookmarks/(.*)
//  */
// $manifest['bookmarks/(.*)/(.*)'] = new Endpoint();
// $manifest['bookmarks/(.*)/(.*)']->GET = new HTTP_Verb();
// $manifest['bookmarks/(.*)/(.*)']->GET->description = "Retrieve a specific bookmark";
// $manifest['bookmarks/(.*)/(.*)']->GET->parameters = array( new Parameter('string', 'The bookmark identifier') );
// $manifest['bookmarks/(.*)/(.*)']->GET->example = (object)array( 'id' => "123", 'url' => "http://google.com" );
// 
// /**
//  * GET /bookmarks
//  */
// $manifest['bookmarks$'] = new Endpoint();
// $manifest['bookmarks$']->GET = new HTTP_Verb();
// $manifest['bookmarks$']->GET->description = "Retrieve all bookmarks";
// $manifest['bookmarks$']->GET->example = array(
// 	(object)array( 'id' => "123", 'name' => "http://google.com" ),
// 	(object)array( 'id' => "125", 'name' => "http://yahoo.com" ),
// );
// 
// /**
//  * POST /bookmarks
//  */
// $manifest['bookmarks$']->POST = new HTTP_Verb();
// $manifest['bookmarks$']->POST->description = "Create a new bookmark";
// $manifest['bookmarks$']->POST->parameters = array(
// 	'url' => new Parameter('string', 'The bookmark url'),
// 	'description' => new Parameter('string', 'A description of the bookmark')
// );
// $manifest['bookmarks$']->POST->example = array(
// 	'url' => "http://mikefunk.com",
// 	'description' => "Web Developer"
// );
// 
// /**
//  * PUT /bookmarks
//  */
// $manifest['bookmarks/([0-9]+)'] = new Endpoint();
// $manifest['bookmarks/([0-9]+)']->PUT = new HTTP_Verb();
// $manifest['bookmarks/([0-9]+)']->PUT->description = "Update a bookmark";
// $manifest['bookmarks/([0-9]+)']->PUT->parameters = array(
// 	'id' => new Parameter('int', 'The primary key'),
// 	'url' => new Parameter('string', 'The bookmark url'),
// 	'description' => new Parameter('string', 'A description of the bookmark')
// );
// $manifest['bookmarks/([0-9]+)']->PUT->example = array(
// 	'id' => "123",
// 	'url' => "http://mikefunk.com",
// 	'description' => "Web Programmer"
// );
// 
// /**
//  * DELETE /bookmarks
//  */
// $manifest['bookmarks/([0-9]+)']->DELETE = new HTTP_Verb();
// $manifest['bookmarks/([0-9]+)']->DELETE->description = "Delete a bookmark";
// $manifest['bookmarks/([0-9]+)']->DELETE->parameters = array();
// $manifest['bookmarks/([0-9]+)']->DELETE->example = array();

return $manifest;

/* End of file api_manifest.php */
/* Location: ./application/config/api_manifest.php */