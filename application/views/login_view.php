<section>
<div class="container">
<?php /*<div class="row">
<div class="span16"> */ ?>
<?=form_open('home/login_validation', array('id' => 'login_form', 'class' => 'form-horizontal'))?>
        <div class="page-header">
          <h1>Please Login</h1>
          </div><!--page-header-->
<div class="alert_wrap"></div>
<div class="control-group form_item">
            <?=form_label('Email Address:', 'email_address_field', array('class' => 'control-label'))?>
            <div class="controls">
              <?=form_input(array('name' => 'email_address', 'id' => 'email_address_field', 'class' => 'span3', 'value' => get_cookie('email_address')))?>
            </div><!--controls-->
          </div><!--control-group-->
          
<div class="control-group form_item">
            <?=form_label('Password', 'password_field', array('class' => 'control-label'))?>
            <div class="controls">
              <?=form_password(array('name' => 'password', 'id' => 'password_field', 'class' => 'span3', 'value' => get_cookie('password')))?>
            </div><!--controls-->
</div><!--control-group-->

          <fieldset class="form-actions">
          <button type="submit" class="btn btn-primary login">Login</button>
          </fieldset><!--form-actions-->
</form>
<?php /* </div><!--span-->
</div><!--row--> */ ?>
</div><!--container-->
</section>