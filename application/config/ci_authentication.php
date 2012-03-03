<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * authentication config
 * 
 * All configurable values for the authentication package
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		authentication.php
 * @version		1.0
 * @date		02/17/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------
/**
 * users_table
 *
 * the table to pull users from
 */
$config['users_table'] = 'users';

// --------------------------------------------------------------------------
/**
 * roles_table
 *
 * the table to pull roles from
 */
$config['roles_table'] = 'roles';

// --------------------------------------------------------------------------
/**
 * username_field
 *
 * the field in the db and session used for username
 */
$config['username_field'] = 'email_address';

// --------------------------------------------------------------------------
/**
 * password_field
 *
 * the field in the db and session used for password
 */
$config['password_field'] = 'password';

// --------------------------------------------------------------------------
/**
 * remember_me_field
 *
 * the field checked in post and used as a cookie name
 */
$config['remember_me_field'] = 'remember_me';

// --------------------------------------------------------------------------
/**
 * home_page_field
 *
 * the field in the db and session used for home_page (in the roles table)
 */
$config['home_page_field'] = 'home_page';

// --------------------------------------------------------------------------
/**
 * confirm_string_field
 *
 * the field in the db assigned to a user that has not yet confirmed 
 * their registration via email
 */
$config['confirm_string_field'] = 'confirm_string';

// --------------------------------------------------------------------------
/**
 * role_id_field
 *
 * the field used to join role_id (in the users table)
 */
$config['role_id_field'] = 'role_id';

// --------------------------------------------------------------------------
/**
 * user_role_id (int)
 *
 * the role id for users to be assigned
 */
$config['user_role_id'] = 1;

// --------------------------------------------------------------------------
/**
 * remember_me_timeout (int)
 *
 * the time, in seconds, that the remember_me cookie lasts
 */
$config['remember_me_timeout'] = 60 * 60 * 24 * 365;

// --------------------------------------------------------------------------
/**
 * salt_length (int)
 *
 * the length of the salt string to be added to / parsed from the password
 */
$config['salt_length'] = 64;

// --------------------------------------------------------------------------
/**
 * email from addresses
 *
 * the reply-to email address for registration emails and others
 */
$config['register_email_from'] =
$config['request_reset_email_from'] =
$config['confirm_reset_email_from'] =
 'admin@bookymark.com';

// --------------------------------------------------------------------------
/**
 * email from names (optional)
 *
 * the reply-to email address name for registration emails and others
 */
$config['register_email_from_name'] = 
$config['request_reset_email_from_name'] =
$config['confirm_reset_email_from_name'] =
'Bookymark';

// --------------------------------------------------------------------------
/**
 * register_email_subject
 *
 * the reply-to email address for registration emails
 */
$config['register_email_subject'] = 'Registration';

// --------------------------------------------------------------------------
/**
 * request_reset_email_subject
 *
 * the reply-to email address for request reset password email
 */
$config['request_reset_email_subject'] = 'Bookymark.com: Request for password reset';

// --------------------------------------------------------------------------
/**
 * confirm_reset_email_subject
 *
 * the reply-to email address for confirm reset password email
 */
$config['confirm_reset_email_subject'] = 'Bookymark.com: New password';

// --------------------------------------------------------------------------
/**
 * email_register_view
 *
 * the inner view used for sending registration emails
 */
$config['email_register_view'] = 'email/email_register_view';

// --------------------------------------------------------------------------
/**
 * email_request_reset_view
 *
 * the inner view used for sending registration emails
 */
$config['email_request_reset_view'] = 'email/email_request_reset_view';

// --------------------------------------------------------------------------
/**
 * email_confirm_reset_view
 *
 * the inner view used for sending registration emails
 */
$config['email_confirm_reset_view'] = 'email/email_confirm_reset_view';

// --------------------------------------------------------------------------
/**
 * email_template_view
 *
 * the outer view used for sending registration emails
 */
$config['email_template_view'] = 'email/email_template_view';

// --------------------------------------------------------------------------
/**
 * logged_out_url
 *
 * where to redirect when login_check fails
 */
$config['logged_out_url'] = 'home/login';

// --------------------------------------------------------------------------
/**
 * logout_success_url
 *
 * where to redirect on logout
 */
$config['logout_success_url'] = 'home/login';

// --------------------------------------------------------------------------
/**
 * register_success_url
 *
 * where to redirect on register success
 */
$config['register_success_url'] = 'alert';

// --------------------------------------------------------------------------
/**
 * confirm_register_url
 *
 * the url of the controller method that checks the confirmation email link.
 * without the trailing slash.
 */
$config['confirm_register_url'] = 'home/confirm_register';

// --------------------------------------------------------------------------
/**
 * confirm_register_success_url
 *
 * where to redirect on confirm success
 */
$config['confirm_register_success_url'] = 'home/login';

// --------------------------------------------------------------------------
/**
 * confirm_register_fail_url
 *
 * where to redirect on confirm fail
 */
$config['confirm_register_fail_url'] = 'home/login';

// --------------------------------------------------------------------------
/**
 * confirm reset password url
 *
 * the url for the reset password link. Without the trailing slash.
 */
$config['confirm_reset_url'] = 'home/confirm_reset_password';

// --------------------------------------------------------------------------
/**
 * request_reset_success_url
 *
 * where to redirect on request reset password
 */
$config['request_reset_success_url'] = 'alert';

// --------------------------------------------------------------------------
/**
 * confirm_reset_success_url
 *
 * where to redirect on confirm reset password
 */
$config['confirm_reset_success_url'] = 'home/login_new_password';

// --------------------------------------------------------------------------
/**
 * access_denied_url
 *
 * where to redirect when a user reaches a page they do not have access to
 */
$config['access_denied_url'] = 'alert';

// --------------------------------------------------------------------------
/**
 * logged_out_message
 *
 * the notification to save to flashdata when logged out
 */
$config['logged_out_message'] = 'You have been logged out. Please login to continue.';

// --------------------------------------------------------------------------
/**
 * access_denied_message
 *
 * the notification to save to flashdata when access is denied
 */
$config['access_denied_message'] = 'You do not have access to view this page.';

// --------------------------------------------------------------------------
/**
 * logged_in_message
 *
 * the notification to save to flashdata when user logs in
 */
$config['logged_in_message'] = 'You have been logged in.';

// --------------------------------------------------------------------------
/**
 * logged_out_message
 *
 * the notification to save to flashdata when user logs out
 */
$config['logged_out_message'] = 'You have been logged out.';

// --------------------------------------------------------------------------
/**
 * register_success_message
 *
 * the notification to save to flashdata when user succeeds in verifying
 *  registration request
 */
$config['register_success_message'] = 'A confirmation has been sent to your email address. Please click the link there to continue.';

// --------------------------------------------------------------------------
/**
 * register_success_title
 *
 * saves to flashdata alert_page_title
 */
$config['register_success_title'] = 
$config['request_reset_success_title'] = 'Almost Done!';

// --------------------------------------------------------------------------
/**
 * confirm_register_success_message
 *
 * the notification to save to flashdata when user succeeds in verifying
 *  registration request
 */
$config['confirm_register_success_message'] = 'Registration confirmed. Please login.';

// --------------------------------------------------------------------------
/**
 * confirm_register_fail_message
 *
 * the notification to save to flashdata when user fails in verifying
 * registration request
 */
$config['confirm_register_fail_message'] = 'Registration confirmation failed. Please try logging in. If that does not work, please try registering again.';

// --------------------------------------------------------------------------
/**
 * request_reset_success_message
 *
 * the notification to save to flashdata when user succeeds in requesting a
 * new password
 */
$config['request_reset_success_message'] = 'A confirmation has been sent to your email address. Please click the link there to reset your password.';

// --------------------------------------------------------------------------
/**
 * request_reset_success_title
 *
 * saves to flashdata alert_page_title
 */
$config['request_reset_success_title'] = 'Almost Done!';

// --------------------------------------------------------------------------
/**
 * confirm_reset_success_message
 *
 * the notification to save to flashdata when user succeeds in confirming a
 * new password
 */
$config['confirm_reset_success_message'] = 'Password reset. Your new password has been emailed to you. Please retrieve it and login.';

// --------------------------------------------------------------------------

/* End of file ci_authentication.php */
/* Location: ./base_codeigniter_app/application/config/ci_authentication.php */