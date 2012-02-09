<!DOCTYPE html>
<html lang="en" class="">
  <head>
    <meta charset="utf-8">
    <title>Bookymark! Save your bookmarks</title>
    <meta name="description" content="Xulon Press' internal book publishing system.">
    <meta name="author" content="Xulon Press">
    
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php
// assets
lessc::ccompile($style_dir.'twitter_bootstrap/less/bootstrap.less', $style_dir.'cache/bootstrap.css');
$this->carabiner->css('cache/bootstrap.css');

lessc::ccompile($style_dir.'styles/styles.less', $style_dir.'cache/styles.css');
$this->carabiner->css('cache/styles.css');

$this->carabiner->js('http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
$this->carabiner->js('scripts/actions.js');
$this->carabiner->js('scripts/scripts.js');
$this->carabiner->display();
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
  <?=$header?>
  <?=$content?>
  <footer>
<div class="footer">
<hr />
<div class="container">
<p>&copy;2012 Mike Funk. All Rights Reserved.</p>
</div><!--container-->
</div><!--footer-->
</footer>
  </body>
</html>