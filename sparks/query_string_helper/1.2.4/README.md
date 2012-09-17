Query String Helper
==================

A CodeIgniter helper to manipulate and return the current/new query string.

Usage
-----------------

1. Load the spark: ```$this->load->spark('query_string_helper/x.x.x');```
2. Use functions in views or controllers such as ```query_string()```

query\_string($add, $remove, $include\_current)
-----------------

* ```query_string()``` with no params just returns the current query string with the ? in front. If no query string exists it will return a blank string.
* ```$add``` _(optional)_ allows you to add an array of items to the query string.
* ```$remove``` _(optional)_ you can either send a string of a key you want to remove or send an array of keys you want to remove.
* ```$include_current``` _(optional)_ lets you ditch the current query string if you want and just make a new one.

uri\_query\_string( same params as above )
------------------

This includes the current uri with the query string on the end. It allows you to manipulate the query string in the same ways as above.


current\_url\_query\_string( same params as above )
------------------

This includes the ```current_url``` (from the url helper) with the query string on the end. It allows you to manipulate the query string in the same ways as above.

Now you can just replace all your ```$this->uri->uri_string()``` with ```uri_query_string()``` and ```current_url()``` with ```base_query_string()``` or and you're good to go!

Change Log
---------------------

**1.2.4**

* Merged bugfix for ```current_url_query_string()``` thanks to [edmundask](https://github.com/edmundask).

**1.2.3**

* Merged bugfix which prevented removing keys. Thanks to [burakerdem](https://github.com/burakerdem).

**1.2.2**

* Added ```current_url_query_string()``` function.

**1.2.1**

* Explained the helper better in the readme.

**1.2.0**

* Changed to spark format

**1.1.1**

* fixed bug with get() returning false

**1.1.0**

* added ```uri_query_string()``` function

**1.0.0**

* Initial release
