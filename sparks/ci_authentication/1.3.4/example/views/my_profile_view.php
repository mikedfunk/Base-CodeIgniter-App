<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * my_profile_view
 * 
 * Edit form for auth/my_profile.
 * 
 * @license		Copyright Xulon Press, Inc. All Rights Reserved.
 * @author		Xulon Press
 * @link		http://xulonpress.com
 * @email		info@xulonpress.com
 * 
 * @file		my_profile_view.php
 * @version		1.0
 * @date		03/12/2012
 * 
 * Copyright (c) 2012
 */

// --------------------------------------------------------------------------
?>
<?php if (isset($item_query) && $item_query->num_rows() != 1): ?>
<div class="alert alert-error">Error loading form.</div>
<?php else: ?>
<?php 
if (isset($item_query)):
	$item = $item_query->row();
endif;
?>

<div class="page-header">
<h1>My Profile <small>Items with a * are required</small></h1>
</div><!--page-header-->
<?=$this->ci_alerts->display()?>
<?php /* if (validation_errors() != ''): ?>
<div class="alert alert-error fade in"><a class="close" href="#" data-dismiss="alert">&times;</a>
Please correct the highlighted errors below.
</div><!--alert-->
<?php endif; */ ?>
<?php
$hidden = array('id' => $item->id);
?>
<?=form_open('', array('class' => 'form-horizontal'), $hidden)?>

<div class="control-group form_item <?=(form_error('first_name') != '' ? 'error' : '')?>">
            <?=form_label('First Name: *', 'first_name_field', array('class' => 'control-label'))?>
            <div class="controls">
<?php
// form value
if (set_value('first_name') != '') {$value = set_value('first_name');}
else {$value = (isset($item) ? $item->first_name : '');}
?>
              <?=form_input(array('name' => 'first_name', 'id' => 'first_name_field', 'class' => 'span3', 'value' => $value))?>
              <?=form_error('first_name')?>
            </div><!--controls-->
          </div><!--control-group-->
          


<div class="control-group form_item <?=(form_error('last_name') != '' ? 'error' : '')?>">
            <?=form_label('Last Name: *', 'last_name_field', array('class' => 'control-label'))?>
            <div class="controls">
<?php
// form value
if (set_value('last_name') != '') {$value = set_value('last_name');}
else {$value = (isset($item) ? $item->last_name : '');}
?>
              <?=form_input(array('name' => 'last_name', 'id' => 'last_name_field', 'class' => 'span3', 'value' => $value))?>
              <?=form_error('last_name')?>
            </div><!--controls-->
          </div><!--control-group-->
          
          
          
<div class="control-group form_item <?=(form_error('email_address') != '' ? 'error' : '')?>">
            <?=form_label('Email Address: *', 'email_address_field', array('class' => 'control-label'))?>
            <div class="controls">
<?php
// form value
if (set_value('email_address') != '') {$value = set_value('email_address');}
else {$value = (isset($item) ? $item->email_address : '');}
?>
              <?=form_input(array('name' => 'email_address', 'id' => 'email_address_field', 'class' => 'span3', 'value' => $value))?>
              <?=form_error('email_address')?>
            </div><!--controls-->
          </div><!--control-group-->
          
          
          
<div class="control-group form_item <?=(form_error('old_password') != '' ? 'error' : '')?>">
            <?=form_label('Old Password: *', 'old_password_field', array('class' => 'control-label'))?>
            <div class="controls">
<?php
// form value
if (set_value('old_password') != '') {$value = set_value('old_password');}
else {$value = '';}
?>
              <?=form_password(array('name' => 'old_password', 'id' => 'old_password_field', 'class' => 'span3', 'value' => $value))?>
              <?=form_error('old_password')?>
            </div><!--controls-->
          </div><!--control-group-->
          
          
          
<div class="control-group form_item <?=(form_error('password') != '' ? 'error' : '')?>">
            <?=form_label('New Password: *', 'password_field', array('class' => 'control-label'))?>
            <div class="controls">
<?php
// form value
if (set_value('password') != '') {$value = set_value('password');}
else {$value = '';}
?>
              <?=form_password(array('name' => 'password', 'id' => 'password_field', 'class' => 'span3', 'value' => $value))?>
              <?=form_error('password')?>
            </div><!--controls-->
          </div><!--control-group-->
          
          
          
<div class="control-group form_item <?=(form_error('confirm_password') != '' ? 'error' : '')?>">
            <?=form_label('Confirm New Password: *', 'confirm_password_field', array('class' => 'control-label'))?>
            <div class="controls">
<?php
// form value
if (set_value('confirm_password') != '') {$value = set_value('confirm_password');}
else {$value = '';}
?>
              <?=form_password(array('name' => 'confirm_password', 'id' => 'confirm_password_field', 'class' => 'span3', 'value' => $value))?>
              <?=form_error('confirm_password')?>
            </div><!--controls-->
          </div><!--control-group-->



<fieldset class="form-actions">
<button type="submit" class="btn btn-large btn-success"><i class="icon-ok icon-white"></i> Save Changes</button>
<a href="<?=base_url()?>contest/cancel?redirect=<?=urlencode('contest/list_items/' . $this->input->get('from'))?>" class="btn btn-large btn-danger"><i class="icon-remove icon-white"></i> Cancel</a>
</fieldset><!--form-actions-->
</form>
<?php
endif;
/* End of file my_profile_view.php */
/* Location: ./writing_contest/application/views/auth/my_profile_view.php */