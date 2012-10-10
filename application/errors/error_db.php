<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * database error template
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file error_db.php
 */

 // --------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="en" class="">
  <head>
    <meta charset="utf-8">
    <title>Database Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<!--<link type="text/css" href="assets/css/styles.less" />-->
<link type="text/css" rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css" />
<style type="text/css">
section {
	margin-top: 60px;
}
</style>

<script type="text/javascript" src="/assets/js/scripts.js"></script>
<script type="text/javascript" src="/assets/bootstrap/js/bootstrap.js"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<!--[if IE]><![endif]-->

    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="/assets/img/favicon.ico">
  </head>
  <body>

<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
    <div class="fill">
      <div class="container">
        <a class="brand" href="">Bookymark</a>
        </div><!--container-->
        </div><!--fill-->
        </div><!--navbar-inner-->
</div><!--navbar-->

<section>
<div class="container">
  <h1><?=$heading?></h1>
  <p><?=$message?></p>
</div><!--container-->
</section>
  <footer>
<div class="footer">
<hr />
<div class="container">
<p>By <a href="http://mikefunk.com">Mike Funk</a> <a class="pull-right" href="http://www.apache.org/licenses/LICENSE-2.0">Apache License 2.0</p>
</div><!--container-->
</div><!--footer-->
</footer>
<a href="https://github.com/mikedfunk/bookymark"><img style="position: fixed; z-index: 9999; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>
  </body>
</html>
<?php
/* End of file error_db.php */
/* Location: ./application/errors/error_db.php */