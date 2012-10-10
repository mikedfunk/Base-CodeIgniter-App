<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * the login form.
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file login.php
 */

// --------------------------------------------------------------------------
$this->data['title'] = 'Login';
?>
<section>
  <div class="container">
    <?=form_open('', array('id' => 'login_form', 'class' => 'form-horizontal'))?>
      <div class="page-header"><h1>Please Login</h1></div><!--page-header-->
      <?=$this->ci_alerts->display()?>
      <?=$auth->email_address_field()?>
      <?=$auth->password_field()?>
      <?=$auth->remember_me_field()?>
      <fieldset class="form-actions">
        <button type="submit" class="btn btn-primary">Login</button>
      </fieldset><!--form-actions-->
    </form>
  </div><!--container-->
</section>
<?php
/* End of file login.php */
/* Location: ./application/views/login.php */