<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * {{class_name}}
 */
class {{class_name}} extends {{parent_class}}
{

    /**
     * The Contructor!
     */
    public function __construct()
    {
      parent::__construct();
      $this->load->helper('{{helper_name}}');
    }
{{extra}}
} // End of the {{class_name}}

/* End of file {{filename}} */
/* Location {{relative_location}} */
