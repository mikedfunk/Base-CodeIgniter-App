<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * alert_view
 * 
 * The inner alert view called from the errors/error_404.php template and 
 * methods from the alert controller.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		alert_view.php
 * @version		1.3.4
 * @date		03/20/2012
 */
 
 // --------------------------------------------------------------------------
?>
<section>
<div class="container">
<?php
if (isset($title)):
?>
<div class="page-header">
<h1><?=$title?></h1>
</div><!--page-header-->
<?php
elseif ($this->session->flashdata('alert_page_title') != ''):
?>
<div class="page-header">
<h1><?=$this->session->flashdata('alert_page_title')?></h1>
</div><!--page-header-->
<?php
endif;
if (isset($message)):
?>
<p><?=$message?></p>
<?php
else:
	echo $this->ci_alerts->display();
endif;
?>
</div><!--container-->
</section>
<?php
/* End of file alert_view.php */
/* Location: ./ci_authentication/example/views/alert_view.php */