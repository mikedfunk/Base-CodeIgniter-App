<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * stores the database groups in one place for each environment
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file database_groups.php
 */

$db['development']['hostname'] = 'localhost';
$db['development']['username'] = 'root';
$db['development']['password'] = '';
$db['development']['database'] = 'bookymark';
$db['development']['dbdriver'] = 'pdo';
$db['development']['dbprefix'] = '';
$db['development']['pconnect'] = TRUE;
$db['development']['db_debug'] = TRUE;
$db['development']['cache_on'] = false;
$db['development']['cachedir'] = APPPATH.'db_cache';
$db['development']['char_set'] = 'utf8';
$db['development']['dbcollat'] = 'utf8_general_ci';
$db['development']['swap_pre'] = '';
$db['development']['autoinit'] = TRUE;
$db['development']['stricton'] = FALSE;

$db['testing']['hostname'] = 'localhost';
$db['testing']['username'] = 'root';
$db['testing']['password'] = '';
$db['testing']['database'] = 'bookymark_test';
$db['testing']['dbdriver'] = 'mysqli';
$db['testing']['dbprefix'] = '';
$db['testing']['pconnect'] = TRUE;
$db['testing']['db_debug'] = TRUE;
$db['testing']['cache_on'] = false;
$db['testing']['cachedir'] = APPPATH.'db_cache';
$db['testing']['char_set'] = 'utf8';
$db['testing']['dbcollat'] = 'utf8_general_ci';
$db['testing']['swap_pre'] = '';
$db['testing']['autoinit'] = TRUE;
$db['testing']['stricton'] = FALSE;

$db['production']['hostname'] = 'tunnel.pagodabox.com:3306';
$db['production']['username'] = 'carmina';
$db['production']['password'] = 'eTGWOfAE';
$db['production']['database'] = 'mikedfunk_db';
$db['production']['dbdriver'] = 'pdo';
$db['production']['dbprefix'] = '';
$db['production']['pconnect'] = TRUE;
$db['production']['db_debug'] = false;
$db['production']['cache_on'] = false;
$db['production']['cachedir'] = APPPATH.'db_cache';
$db['production']['char_set'] = 'utf8';
$db['production']['dbcollat'] = 'utf8_general_ci';
$db['production']['swap_pre'] = '';
$db['production']['autoinit'] = TRUE;
$db['production']['stricton'] = FALSE;

$db['staging']['hostname'] = 'localhost';
$db['staging']['username'] = '';
$db['staging']['password'] = '';
$db['staging']['database'] = '';
$db['staging']['dbdriver'] = 'mysql';
$db['staging']['dbprefix'] = '';
$db['staging']['pconnect'] = TRUE;
$db['staging']['db_debug'] = TRUE;
$db['staging']['cache_on'] = false;
$db['staging']['cachedir'] = APPPATH.'db_cache';
$db['staging']['char_set'] = 'utf8';
$db['staging']['dbcollat'] = 'utf8_general_ci';
$db['staging']['swap_pre'] = '';
$db['staging']['autoinit'] = TRUE;
$db['staging']['stricton'] = FALSE;

/* End of file database_groups.php */
/* Location: ./application/config/database_groups.php */