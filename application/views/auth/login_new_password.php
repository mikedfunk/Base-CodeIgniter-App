<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * the login form after resetting the password.
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file login_new_password.php
 */

// --------------------------------------------------------------------------
$this->data['title'] = 'Login';
?>
<section>
  <div class="container">
    <?=form_open('', array('id' => 'login_form', 'class' => 'form-horizontal'))?>
      <div class="page-header"><h1>Please Login</h1></div><!--page-header-->
      <?php if (!$this->input->post()):?>
      <div class="alert alert-success fade in" data-dismiss="alert"><a class="close" href="#">&times;</a>Password reset. Your new password has been emailed to you. Please retrieve it and login.</div><!--alert-->
      <?php endif; ?>
      <?=$this->ci_alerts->display()?>
      <?=$auth->email_address_field()?>
      <?=$auth->temp_password_field()?>
      <?=$auth->new_password_field()?>
      <?=$auth->confirm_password_field()?>
      <?=$auth->remember_me_field()?>
      <fieldset class="form-actions">
        <button type="submit" class="btn btn-primary">Login</button>
      </fieldset><!--form-actions-->
    </form>
  </div><!--container-->
</section>
<?php
/* End of file login_new_password.php */
/* Location: ./application/views/login_new_password.php */