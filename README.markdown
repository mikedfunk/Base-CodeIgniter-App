Base Codeigniter App
=============================

Note: this contains a variety of submodules. after cloning, be sure to ```git submodule update --init --recursive``` and you should be good to go.

Includes the following submodules:

* [CodeIgniter](http://codeigniter.com) - application folder is outside so that we can just pull vanilla codeigniter updates.
* [Twitter Bootstrap](http://bootstrap.io) - in assets/twitter_bootstrap. This is my fork of bootstrap to allow for minification of js without breaking. I keep it updated from the main repo though. (I submitted a pull request on this but they wouldn't change it due to "strong opinions about semicolons").
* [Kenji's CIUnit](https://bitbucket.org/kenjis/my-ciunit) - a fork of CIUnit (PHPUnit support for CodeIgniter applications) that works in CodeIgniter 2. This is on bitbucket in mercurial so I couldn't add it as a submodule unfortunately. The way it is set up it spreads all over the application folder anyway so it's not just a drop-in tool. For sample tests clone his repo. The version included is from January 28, 2012.
* [QUnit](https://github.com/jquery/qunit) - for JS unit testing.
* [JQuery Mockjax](https://github.com/appendto/jquery-mockjax) - excellent tool for mocking ajax requests for JS unit testing.
* [Carabiner](https://github.com/mikedfunk/carabiner) - drop-in to third_party version of Carabiner - an asset management library. (with added [LessPHP](https://github.com/leafo/lessphp) support)
* [CI Authentication](https://github.com/mikedfunk/CI-Authentication) - An authentication package for CodeIgniter.

Additional tweaks:
------------------------------

* Welcome page is re-done with:
 * twitter bootstrap
 * less css
 * minified and combined JS and CSS through Carabiner
 * simple template setup
* global form_validation delimiters for twitter bootstrap set in ```libraries/MY_Form_validation.php```
* htaccess from [html5boilerplate](http://html5boilerplate.com) with codeigniter snippet at the top to remove index.php.

Permissions:
------------------------------

* ```assets/cache``` needs to be writable
* ```application/db_cache``` needs to be writable for database query caching to work
* ```application/cache``` needs to be writable for page caching to work
