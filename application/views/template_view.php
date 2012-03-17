<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * template_view
 * 
 * Description
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		template_view.php
 * @version		1.1.0
 * @date		03/11/2012
 */

// --------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="en" class="">
  <head>
    <meta charset="utf-8">
    <title><?=(isset($title)?$title:'')?></title>
    <meta name="description" content="<?=(isset($title)?$title:'')?>">
    <meta name="author" content="<?=(isset($author)?$author:'')?>">
    
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php
// assets
$this->carabiner->css('twitter_bootstrap/docs/assets/css/bootstrap.css');

// remote jquery
// $this->carabiner->js('http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
// local jquery
$this->carabiner->js('scripts/jquery-1.7.min.js');
$this->carabiner->js('scripts/actions.js');
$this->carabiner->js('scripts/scripts.js');
$this->carabiner->display();
?>

    <!-- HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<!--[if IE]><![endif]-->
	
<?php /* it would be a good idea to add these...
	<!-- fav and touch icons -->
    <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?=base_url()?>assets/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>assets/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>assets/images/apple-touch-icon-114x114.png">
*/ ?>

  </head>
  <body>
<?php /*
  <div class="navbar navbar-fixed-top">
<div class="navbar-inner">
    <div class="fill">
      <div class="container">
        <a class="brand" href="#/admin/home">Welcome</a>
        </div><!--container-->
        </div><!--fill-->
        </div><!--navbar-inner-->
</div><!--navbar-->
*/ ?>
  <?=$content?>
<?php /*
  <footer>
<div class="footer">
<hr />
<div class="container">
<p>&copy;<?=date('Y')?> [copyright holder]. All Rights Reserved.</p>
</div><!--container-->
</div><!--footer-->
</footer>
*/ ?>
  </body>
</html>
<?php
/* End of file template_view.php */
/* Location: ./base_codeigniter_app/application/views/template_view.php */