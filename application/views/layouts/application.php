<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * main application layout
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file application.php
 */
 
 // --------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="en" class="">
  <head>
    <meta charset="utf-8">
    <title><?=(isset($title)?$title:'Bookymark! Save your bookmarks.')?></title>
    <meta name="description" content="<?=(isset($description)?$description:'')?>">
    <meta name="author" content="<?=(isset($author)?:'')?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php 
Assets::css(array(
	'assets/css/styles.less',
	'assets/bootstrap/css/bootstrap.min.css'
	
)); 
Assets::cdn(array('jquery'));
Assets::js(array(
	'assets/js/scripts.js',
	'assets/bootstrap/js/bootstrap.js'
));
?>
    <!-- HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<!--[if IE]><![endif]-->
	
    <!-- fav and touch icons -->
<?php /*
    <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?=base_url()?>assets/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=base_url()?>assets/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=base_url()?>assets/images/apple-touch-icon-114x114.png">
*/ ?>
  </head>
  <body>

<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
    <div class="fill">
      <div class="container">
        <a class="brand" href="<?=base_url()?>">Bookymark <?php /*<sup>&reg;</sup> */ ?></a>
        <?php /*=partial('partials/account_partial', $this->data)*/?>
        </div><!--container-->
        </div><!--fill-->
        </div><!--navbar-inner-->
</div><!--navbar-->

<section>
<div class="container">
  <?=$yield?>
</div><!--container-->
</section>
  <footer>
<div class="footer">
<hr />
<div class="container">
<p><a href="http://www.apache.org/licenses/LICENSE-2.0">Apache License 2.0</p>
</div><!--container-->
</div><!--footer-->
</footer>
<a href="https://github.com/mikedfunk/bookymark"><img style="position: absolute; z-index: 9999; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>
  </body>
</html>
<?php
/* End of file template_view.php */
/* Location: ./bookymark/application/views/template_view.php */