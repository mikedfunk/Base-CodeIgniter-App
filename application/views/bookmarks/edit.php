<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * edit bookmark view
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file edit.php
 */
// --------------------------------------------------------------------------
$this->data['title'] = 'Edit Bookymark';
?>
<section>
  <div class="container">
    <div class="page-header">
      <h1><?=$bookmark->title()?> <small>Items with a * are required</small></h1>
    </div><!--page-header-->
    <?=$this->ci_alerts->display()?>
    <?php $hidden = (isset($bookmark) ? array('id' => $bookmark->id) : ''); ?>
    <?=form_open('', array('class' => 'form-horizontal'), $hidden)?>
      <?=$bookmark->url_field()?>
      <?=$bookmark->description_field()?>
      <div class="form-actions">
        <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Save</button>
        <a href="/bookmarks/cancel" class="btn btn-danger"><i class="icon-remove icon-white"></i> Cancel</a>
      </div><!--form-actions-->
    </form>
  </div><!--container-->
</section>
<?php
/* End of file edit.php */
/* Location: ./application/views/bookmarks/edit.php */