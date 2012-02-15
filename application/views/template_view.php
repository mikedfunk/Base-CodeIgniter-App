<!DOCTYPE html>
<html lang="en" class="">
  <head>
    <meta charset="utf-8">
    <title>[title]</title>
    <meta name="description" content="[description]">
    <meta name="author" content="[author]">
    
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<?php
// assets
lessc::ccompile($this->carabiner->style_dir.'twitter_bootstrap/less/bootstrap.less', $this->carabiner->style_dir.'cache/bootstrap.css');
$this->carabiner->css('cache/bootstrap.css');

lessc::ccompile($this->carabiner->style_dir.'styles/styles.less', $this->carabiner->style_dir.'cache/styles.css');
$this->carabiner->css('cache/styles.css');

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
	
    <!-- fav and touch icons -->
<?php /*
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
  <footer>
<div class="footer">
<hr />
<div class="container">
<p>&copy;<?=date('Y')?> [copyright holder]. All Rights Reserved.</p>
</div><!--container-->
</div><!--footer-->
</footer>
  </body>
</html>
<?php
/* End of file template_view.php */
/* Location: ./base_codeigniter_app/application/views/template_view.php */