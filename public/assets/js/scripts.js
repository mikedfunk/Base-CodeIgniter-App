/**
 * all custom javascript
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file scripts.js
 */

// --------------------------------------------------------------------------

/**
 * @link http://www.arlocarreon.com/blog/javascript/how-to-debug-javascript/
 */
var console = console || {
     log:function(){},
     warn:function(){},
     error:function(){}
};

// --------------------------------------------------------------------------

/**
 * document ready
 */
$(function()
{
	$('.carousel').carousel();
});

// --------------------------------------------------------------------------

/* End of file scripts.js */
/* Location: ./public/assets/js/scripts.js */