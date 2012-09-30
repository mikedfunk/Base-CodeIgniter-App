<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * the "welcome to bookymark" view
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file index.php
 */

// --------------------------------------------------------------------------

// page title
$this->data['title'] = 'Home | Bookymark';
?>
<section>
<div class="container">
<div class="page-header">
<h1>Welcome to Bookymark!</h1>
</div><!--page-header-->

<div class="row">
<div class="span8">

<div id="home_carousel" class="carousel slide">
  <!-- Carousel items -->
  <div class="carousel-inner">
    
    <div class="active item">
    	<img src="<?=base_url()?>assets/img/bookymark_carousel_1.png" alt="">
                <div class="carousel-caption">
                  <h4>Check out the source!</h4>
                  <p>Bookymark is intended to show CodeIgniter best practices and good documentation.</p>
                </div><!--carousel-caption-->
    </div><!--item-->
    
    <div class="item">
    	<img src="<?=base_url()?>assets/img/bookymark_carousel_2.png" alt="">
                <div class="carousel-caption">
                  <h4>Simple bookmarking tool</h4>
                  <p>List, edit, add, or delete bookmarks.</p>
                </div><!--carousel-caption-->
    </div><!--item-->
    
  </div><!--carousel-inner-->
  
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#home_carousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#home_carousel" data-slide="next">&rsaquo;</a>
</div><!--carousel-->

</div><!--span-->
<div class="span4" style="text-align: center;">
<h2>What's this about?</h2>
<p>Bookymark is a simple bookmarking tool that lets you add, edit, delete, and list bookmarks. It's nothing compared to Delicious.com but the intention is not to compete. It's just to show a code sample of some CodeIgniter best practices.</p>
<h2>Want to take it for a spin?</h2>
<p><a class="btn btn-large btn-primary" href="<?=base_url()?>auth/register">Register</a> <a class="btn btn-large" href="<?=base_url()?>auth/login">Login</a></p>
<hr />
<p>Prefer SSL?<br /> <a class="btn btn-mini" href="https://bookymark.pagodabox.com/auth/register"><i class="icon-lock"></i> Register</a> <a class="btn btn-mini" href="https://bookymark.pagodabox.com/auth/login"><i class="icon-lock"></i> Login</a></p>
</div><!--span-->

</div><!--row-->

</div><!--container-->
</section>
<?php
/* End of file home_view.php */
/* Location: ./bookymark/application/views/home_view.php */