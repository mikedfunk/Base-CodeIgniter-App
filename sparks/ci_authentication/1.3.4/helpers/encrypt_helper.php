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
 * @file		encrypt_helper.php
 * @version		1.3.4
 * @date		03/20/2012
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
	$_ci =& get_instance();
	// $_ci->config->load('ci_authentication');
	
	// set the salt if not set
	if ($salt == '') {
		$_ci->load->helper('string');
		$salt = random_string('alnum', config_item('salt_length'));
	}
	
	// Prefix the password with the salt, add configured stuff
	$hash = $salt . $password;
	if (config_item('login_with_encryption_key'))
	{
		$hash .= $_ci->config->item('encryption_key');
	}
	
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