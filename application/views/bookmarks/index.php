<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * shows a list of paginated bookmarks
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file index.php
 */

// --------------------------------------------------------------------------

$this->data['title'] = 'My Bookymarks';
?>
<section>
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="<?=base_url()?>">Home</a> <span class="divider">&rarr;</span></li>
      <li class="active">Bookmarks</li>
    </ul>
    <div class="page-header">
        <h1>My Bookymarks <small>Hover over a row for more options</small></h1>
    </div><!--page-header-->
    <?=$this->ci_alerts->display()?>
    <div class="well">
      <a class="btn btn-success" href="<?=base_url()?>bookmarks/new"><i class="icon-plus icon-white"></i> New</a>
    </div><!--well-->
    <?=$bookmark->table()?>
  </div><!--container-->
</section>
<?php
/* End of file index.php */
/* Location: ./application/views/bookmarks/index.php */