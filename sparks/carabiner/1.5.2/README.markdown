Carabiner
=====================

**All credit to [Tony Dewan](http://codeigniter.com/forums/member/83507/) for original library.**

This is Carabiner implemented as a spark on (getsparks.org)[http://getsparks.org]. Once sparks is installed, load the spark with ```$this->load->spark('carabiner/1.5.2');```.

[Usage Documentation](http://codeigniter.com/wiki/Carabiner/)

---------------------

This also adds Less CSS PHP compiling to the mix. Just pass .less files via ```$this->carabiner->css('file.less')``` and away we go! It puts the compiled css file into the configured cache folder before minifying and combining. *NOTE: If you have any linked images, keep in mind that the path will be relative to the cache folder!*

*This repo contains the leafo.net LessPHP compiler as a submodule. If you're cloning this directly rather than loading as a spark, be sure to ```git submodule update --init``` after cloning.*