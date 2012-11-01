<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PHP error template
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file error_php.php
 */

 // --------------------------------------------------------------------------
?>
<div class="alert alert-block alert-error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <h4>An Error Was Encountered</h4>
  <p><strong>Message:</strong> <?=$message?></p>
  <p><strong>Line Number:</strong> <?=$line?></p>
  <p><strong>File Path:</strong> <?=$filepath?></p>
  <p><strong>Severity:</strong> <?=$severity?></p>
</div>
<?php
/* End of file error_php.php */
/* Location: ./application/errors/error_php.php */