<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * register_view
 * 
 * The register form.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		register_view.php
 * @version		1.3.4
 * @date		03/20/2012
 */

// --------------------------------------------------------------------------
?>
<section>
<div class="container">
<?php /*<div class="row">
<div class="span16"> */ ?>
<?=form_open('auth/register', array('id' => 'register_form', 'class' => 'form-horizontal'))?>
        <div class="page-header">
          <h1>Register</h1>
          </div><!--page-header-->
<div class="alert_wrap">

<?php
// logout success notification
if (validation_errors() != ''):
?>
<div class="alert alert-error fade in" data-dismiss="alert"><a class="close" href="#">&times;</a>Please correct the highlighted errors.</div><!--alert-->
<?php endif; ?>

</div><!--alert-wrap-->
<div class="control-group form_item <?=(form_error('email_address') != '' ? 'error' : '')?>">
            <?=form_label('Email Address:', 'email_address_field', array('class' => 'control-label'))?>
            <div class="controls">
<?php
// form value
if (set_value('email_address') != '') {$value = set_value('email_address');}
else {$value = '';}
?>
              <?=form_input(array('name' => 'email_address', 'id' => 'email_address_field', 'class' => 'span3', 'value' => $value))?>
              <?=form_error('email_address')?>
            </div><!--controls-->
          </div><!--control-group-->
          
<div class="control-group form_item <?=(form_error('password') != '' ? 'error' : '')?>">
            <?=form_label('Password', 'password_field', array('class' => 'control-label'))?>
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
            <?=form_label('Confirm Password', 'confirm_password_field', array('class' => 'control-label'))?>
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
          <button type="submit" class="btn btn-primary">Register</button>
          </fieldset><!--form-actions-->
</form>
<?php /* </div><!--span-->
</div><!--row--> */ ?>
</div><!--container-->
</section>
<?php
/* End of file register_view.php */
/* Location: ./ci_authentication/example/views/register_view.php */