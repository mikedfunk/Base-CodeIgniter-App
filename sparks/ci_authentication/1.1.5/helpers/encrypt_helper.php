<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * encrypt_helper
 * 
 * Unique encryption method with salt. Feel free to change this for security.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		
 * @version		1.1.5
 * @date		10/14/2011
 * 
 * Copyright (c) 2011
 */
 
// --------------------------------------------------------------------------
// !Utility functions
// --------------------------------------------------------------------------

/**
 * Encrypt_this
 *
 * Obfuscates the password with a session-specific salt and a
 * few other things.
 *
 * @param string  $password
 * @param int $salt (default: '')
 * @return string
 */
function encrypt_this($password, $salt = '')
{
	$CI =& get_instance();
	
	if ($salt == '') {
		$CI->load->helper('string');
		$salt = random_string('alnum', 64);
	}
	
	// Prefix the password with the salt
	// $hash = $salt . $password;
	$hash = $salt . $password . $CI->config->item('encryption_key');
	// Hash the salted password a bunch of times
	for ( $i = 0; $i < 53; $i ++ ) {
		$hash = hash('sha256', $hash);
	}
	
	// Prefix the hash with the salt so we can find it back later
	$hash = $salt . $hash;
	
	// set the session variable for the salt
	return $hash;
	// return $password;
}

// --------------------------------------------------------------------------

/* End of file encrypt_helper.php */
/* Location: ./booktrack/application/helpers/encrypt_helper.php */