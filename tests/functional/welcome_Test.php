<?php

/**
 * Selenium tests
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file welcome_Test.php
 */

// get the PHPUnit Selenium extension
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

/**
 * sample test to load the welcome index.
 *
 * @extends PHPUnit_Extensions_SeleniumTestCase
 */
class WebTest extends PHPUnit_Extensions_SeleniumTestCase
{
    /**
     * setUp is required in selenium tests.
     *
     * @access protected
     * @return void
     */
    protected function setUp()
    {
        $this->setBrowser('*firefox');
        $this->setBrowserUrl('http://localhost/base_codeigniter_app/public');
    }

    /**
     * Make sure the text contains the word CodeIgniter.
     *
     * @access public
     * @return void
     */
    public function testHasCodeIgniter()
    {
        $this->open('http://localhost/base_codeigniter_app/public');
        $this->assertElementContainsText('body', 'CodeIgniter');
    }
}
/* End of file welcome_Test.php */
/* Location: ./tests/functional/welcome_Test.php */