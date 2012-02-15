<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * test_view
 * 
 * Goes inside the template
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		test_view.php
 * @version		1.0
 * @date		02/08/2012
 * 
 * Copyright (c) 2012
 */
?>

<div class="container">
<div class="page-header">
<h1>Welcome to CodeIgniter!</h1>
</div><!--page-header-->
<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

		<p>If you would like to edit this page you'll find it located at:</p>
		<p><code>application/views/welcome_message.php</code></p>

		<p>The corresponding controller for this page is found at:</p>
		<p><code>application/controllers/welcome.php</code></p>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
		
		<hr />
		<p>Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT == 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
</p>
</div><!--container-->

<?php
/* End of file test_view.php */
/* Location: ./base_codeigniter_app/application/views/test_view.php */