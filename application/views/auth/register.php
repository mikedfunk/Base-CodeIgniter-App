<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * the register form.
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file register.php
 */

// --------------------------------------------------------------------------
$this->data['title'] = 'Register';
?>
<section>
  <div class="container">
    <?=form_open('auth/register', array('id' => 'register_form', 'class' => 'form-horizontal'))?>
      <div class="page-header"><h1>Register</h1></div><!--page-header-->
      <?=$this->ci_alerts->display()?>
      <?=$auth->email_address_field()?>
      <?=$auth->password_field()?>
      <?=$auth->confirm_password_field()?>
      <?=$auth->remember_me_field()?>
      <fieldset class="form-actions">
        <button type="submit" class="btn btn-primary">Register</button>
      </fieldset><!--form-actions-->
    </form>
  </div><!--container-->
</section>
<?php
/* End of file register.php */
/* Location: ./application/views/register.php */