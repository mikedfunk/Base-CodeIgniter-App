Base Codeigniter App
=============================

Note: this contains a variety of submodules. after cloning, be sure to *git submodule update --init* and you should be good to go.

Includes the following submodules:
* CodeIgniter - application folder is outside so that we can just pull vanilla codeigniter updates.
* Twitter Bootstrap - in assets/twitter_bootstrap. This is my fork of bootstrap to allow for minification of js without breaking. I keep it updated from the main repo though. (I submitted a pull request on this but they wouldn't change it due to "strong opinions about semicolons").
* Kenji's CIUnit - a fork of CIUnit (PHPUnit support for CodeIgniter applications) that works in CodeIgniter 2. This is on bitbucket in mercurial so I couldn't add it as a submodule unfortunately. The way it is set up it spreads all over the application folder anyway so it's not just a drop-in tool. For sample tests clone his repo. The version included is from January 28, 2012.
* QUnit - for JS unit testing.
* JQuery Mockjax - excellent tool for mocking ajax requests for JS unit testing.
* LessPHP - php LessCSS interpreter.
* Carabiner - drop-in to third_party version of Carabiner - an asset management library.