[![Build Status](https://secure.travis-ci.org/mikedfunk/Base-CodeIgniter-App.png)](http://travis-ci.org/mikedfunk/Base-CodeIgniter-App)

# Base CodeIgniter App

A starting point CodeIgniter App filled with useful goodies.

## Setup

1. Clone or download
2. Set the following directories to writable:
   1. application/cache
   2. application/logs
   2. application/db_cache
   3. public/assets/cache

That's it! No submodules because they are a pain.

## Usage

* [MY_Controller](https://github.com/jamierumbelow/codeigniter-base-controller) does a ton of cool stuff:
   * autoload views by saving them as ```controller_name/method_name.php``` or define a custom view as ```$this->view = 'my_view'``` or skip the view with ```$this->view = false;```
   * views are loaded into *layouts* (templates) stored in ```views/layouts```. The default layout is ```application.php```. You can change it inside a controller method with ```$layout = 'layout_name'```. or skip the layout with ```$layout = false;```
   * autoload models by saving them as ```controller_name_model.php```. It gets loaded as ```$this->controller_name```.
   * *filters* are functions run before and after controller output. Set them via ```public $before_filters = array('method_1', 'method_2');```. They take the same params that your controller method does. The point is that you can run them for all but certain methods, only certain methods, or a mix between. Great for authentication!
   * auto migrate to latest version. To enable, uncomment ```$this->_migrate();``` in ```application/core/MY_Controller.php```
* [MY_Model](https://github.com/jamierumbelow/codeigniter-base-model) lets you greatly reduce necessary model methods, allow validation in the model, enable observers. Check out the source for details, there's too much to explain here.
* [Presenters](https://github.com/efendibooks/codeigniter-handbook-vol-1/blob/master/application/presenters/presenter.php) to clean up views dramatically
* [REST_Controller](https://github.com/efendibooks/codeigniter-handbook-vol-2/blob/master/application/core/MY_Controller.php) to authenticate, format, and present errors properly
* [Pigeon](https://github.com/jamierumbelow/pigeon) and [API_Router](https://github.com/efendibooks/codeigniter-handbook-vol-2/blob/master/application/controllers/api_router.php) for RESTful routing
* Updated [MY_Migration](https://github.com/mikedfunk/MY_Migration). You can set the migration table in ```application/config/migration.php```
* [MY_Form_validation](https://github.com/mikedfunk/MY_Form_validation) for a prefix and suffix for each form error. Set it in ```application/config/form_validation.php```
* All public stuff such as index.php and assets goes in ```/public/```
* Add a [Composer](http://getcomposer.org) package by editing ```/composer.json```, then run ```php composer.phar install``` on the command line from the root directory.

## But wait, there's more!

* Jamie Rumbelow's [REST_Controller](https://github.com/efendibooks/codeigniter-handbook-vol-2/blob/master/application/core/MY_Controller.php) to output in various formats, throttle, authenticate, return API manifest, add debug info, etc. Extend it, set $this->data, and you're done! You can also set ```$this->status_code``` to a 3-digit number and ```$this->respond();``` to just send a status back
* caching fragments available via the fragment library, repeating partial views via the partial helper
* Using MY_Log to fix chmod issues
* Includes [Sparks](http://getsparks.org) with the following sparks:
   * [assets](http://getsparks.org/packages/assets/versions/HEAD/show) - for easy combining, minifying, and caching of js/css and parsing LESS and CoffeeScript. I added a line to make this work with unit tests as well.
   * [curl](http://getsparks.org/packages/curl/versions/HEAD/show) - makes curl codeignitery
   * [events](http://getsparks.org/packages/events/versions/HEAD/show) - event-driven development
   * [query string helper](http://getsparks.org/packages/query_string_helper/versions/HEAD/show) - makes working with query-string heavy apps much easier
   * [REST client](http://getsparks.org/packages/restclient/versions/HEAD/show) - to interact with RESTful APIs
* Includes [Kenji's CIUnit](https://bitbucket.org/kenjis/my-ciunit) for unit testing of models, controllers, helpers, libraries. Unit test examples are in ```tests/folder_name```. There is a working controller test in ```tests/controllers/welcome_Test.php```
* [Twitter Bootstrap](twitter.github.com/bootstrap/) for easy, responsive, beautiful, customizable, cross-browser UI goodness.
* [Twitter Bootstrap Pagination Config](https://gist.github.com/3504432)
* API exception handler and manifest library to return formatted API help (both in ```application/libraries/api```)
* .htaccess from [HTML5 Boilerplate](http://html5boilerplate.com) with CodeIgniter stuff to remove index.php
* main config and database config are separated into folders for four typical development environments. I usually add environment setting logic based on the HTTP_HOST in index.php.
* [FirePHP](http://firephp.org) library for console debugging
* [Bower](https://github.com/twitter/bower) for composer-like installation of CSS/JS/HTML/IMG assets. Twitter Bootstrap and JQuery installed to ```assets/components```.


## Change Log

**2.0.2**
* Installed twitter bootstrap and jquery via bower. Update these on CLI from the ```assets``` dir via ```bower update bootstrap```, ```bower update jquery```, etc.
* Fixed bug in assets spark with unit tests
* Refined selenium example test
* Added [MY_Exceptions.php](https://github.com/mikedfunk/CodeIgniter-Email-PHP-Errors) and related config file to allow emailing of PHP errors. Disabled by default.

**2.0.1**

* Added FirePHP library
* Added example for Selenium functional test thanks to [Phil Palmieri](https://github.com/philpalmieri)'s examples. To run this test, modify the url accordingly and uncomment the ```functional``` directory line in ```tests/phpunit.xml```.
* Added examples for model, helper, and library tests
* Updated Twitter Bootstrap to 2.2.0
* Show profiler by default if in development environment and it's not an ajax request
* Added autoload sparks line
* Better gitignore

**2.0.0**

* Added most things above. No need to repeat the entire README again :) .

**1.1.2**

* Updated submodules

**1.1.1**

* Updated Twitter Bootstrap to 2.0.2
* Removed copyright statements from docblocks
* Updated all relevant docblocks to @version 1.1.2

**1.1.0**

* Support for travis-ci
* Updated db config
