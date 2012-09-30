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
$this->data['title'] = 'List Bookymarks';
?>
<section>
  <div class="container">
    <div class="page-header">
        <h1>My Bookymarks <small>Hover over a row for more options</small></h1>
    </div><!--page-header-->
    <?=$this->ci_alerts->display()?>
    <div class="well">
      <a class="btn btn-success" href="<?=base_url()?>bookmarks/create"><i class="icon-plus icon-white"></i> New</a>
    </div><!--well-->
    <?=$bookmark->table()?>
  </div><!--container-->
</section>
<?php
/* End of file index.php */
/* Location: ./application/views/bookmarks/index.php */