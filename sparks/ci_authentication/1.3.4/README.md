CI Authentication
============================

An authentication system for CodeIgniter.

Setup
----------------------------

1. Install sparks on [GetSparks.org](http://getsparks.org)
2. [Install this spark](http://getsparks.org/packages/ci\_authentication/versions/HEAD/show)
2. Edit **config/ci\_authentication.php** with the proper stuff like redirect urls, etc.
3. Import **setup.sql** in PHPMyAdmin or something
4. Load the spark: ```$this->load->spark('ci_authentication/x.x.x');```

***NOTE: Be sure you also have [CI Alerts](https://github.com/mikedfunk/CI-Alerts) version 1.1.7 as a spark and load it. CI Alerts are required for CI Authentication. This spark requires CI Alerts as a dependency, but double-check that you have it.***

restrict\_access()
----------------------------

At the top of a CI controller method or in ```__construct()``` do this:

    $this->ci_authentication->restrict_access();

It will redirect to the config\_item for logged\_out\_url.

You can also add a parameter to restrict access to pages based on permissions for that role. For instance ```$this->ci_authentication->restrict_access($result->can_edit_pages)```. You pass in a variable that evaluates to true or false. If it's false it will redirect to the config item access\_denied\_url.

----------------------------

Login
============================

is\_logged\_in()
----------------------------

Returns whether a user is logged in:

    $this->ci_authentication->is_logged_in();
    
It will check the encrypted password in the session for the username in the session vs. the values in the database and return true if there is a match.

do\_login()
----------------------------

When form validation passes, just do this:

    $this->ci_authentication->do_login();
    
It will hash and salt the password, log in the user (add username, user id, and encrypted password to the session), and redirect to the configured ```login_success_url```. Or the user's ```login_success_url_field``` in the users or roles table.

remember\_me()
----------------------------

At the top of a CI controller method that does form validation insert this:

    $this->ci_authentication->remember_me();
    
If the "remember me" checkbox is checked, it will save the username, password, and checked status of the remember me checkbox to cookies. You can use ```get_cookie('email_address')``` or whatever to load the form values into your login form by default.

do\_logout()
----------------------------

For the logout controller method, do this:

    $this->ci_authentication->do_logout();
    
It will destroy the session and redirect to the configured logged out url.

----------------------------

Register
============================

do\_register()
----------------------------

When registration passed form validation, do this:

    $this->ci_authentication->do_register();
    
It will:

1. unset ```$_POST['confirm_password']```
2. set a new salt and encrypt the password
3. set the role id
4. set a new confirm string
5. add the user
6. email the user with a confirm register link (email view, template, from, subject, etc. are all configurable in **config/ci\_authentication.php**)
7. In case you need it, sets the title for the error page based on config value
8. redirect to the configured register success url

do\_confirm\_register()
----------------------------

You need to set a controller method for when a user clicks the confirmation link. In this method, just put this:

    $this->ci_authentication->do_confirm_register();

It will check if a confirmation string exists for the passed string. If so, it will remove that string and redirect to the ```confirm_register_success_url```. Otherwise it will redirect to the ```confirm_register_fail_url```.

do\_resend\_register()
----------------------------

If you want to allow resending of the registration email, you need to add a controller method and link to it somewhere. That method needs to accept the ```confirm_string``` as a parameter or POST variable or something. In that method, just do this:

    $this->ci_authentication->do_resend_register($confirm_string);

It will check if a confirmation string exists for the passed string. If so, it will resend the confirmation email and redirect to ```register_success_url```.

----------------------------

Forgot Password
============================

do\_request\_reset\_password()
----------------------------

You need to set a controller method for when a user requests to reset their password. In this method, just put this:

    $this->ci_authentication->do_request_reset_password($email_address);

You will need to pass the ```$email_address``` variable. You could get this from a reset form or a link. This method will email a password link with an encrypted string based on the email address. The user must click this link to confirm they want to reset their password. This prevents passwords being reset without the user's consent. In case you need it the title for the alert page is set in flashdata based on the config value. Then the user is redirected to the ```request_reset_password_url```.

do\_confirm\_reset\_password()
----------------------------

You need to set a controller method for when a user clicks the reset password confirmation link. In this method, just put this:

    $this->ci_authentication->do_request_reset_password();

This method will retrieve the username and encrypted string via $\_GET variables. It will make sure the encrypted username matches the encrypted string, make sure a user exists with that username, set a new random password, email it to the user, update the user in the database with the new password (salted and encrypted), and redirect to the configured page.

----------------------------

Helper
============================

auth\_id()
----------------------------

Returns the user id from session with configurable id field value from ```config/ci_authentication.php```.

auth\_username()
----------------------------

Returns the username from session with configurable username field value from ```config/ci_authentication.php```.

auth\_password()
----------------------------

Returns the password from session with configurable password field value from ```config/ci_authentication.php```.

is\_logged\_in()
----------------------------

Shortcut to ```$this->ci_authentication->is_logged_in()```. Useful in views.

----------------------------

Change Log
============================

**1.3.4**

* Changed ```restrict_access($param)``` to just take a true/false param and not check the session. This helps prevent session overload and is more flexible.

**1.3.3**

* Thanks to [brianjoley](https://github.com/brianjolney) - Fixed bug where user id was hardcoded but should have used field name from config file.
* Updated [ci_alerts](http://getsparks.org/packages/ci_alerts/versions/HEAD/show) dependency to 1.1.7 which fixes a bug.

**1.3.2**

* Changed login to only set session data of user id, encrypted pw, and username. (very important so as not to overload the session cookie with role data!)
* Simplified redirection to role-specific url.
* Updated role_id_field check in ```do_register()``` to only check for the things it needs.

**1.3.1**

* Added my_profile to example in views and auth controller
* Uncommented dependency on ci_alerts

**1.3.1**

* Feature release, no bugfixes.
* Added ability to skip the confirmation email on registration and log the user right in. This can be toggled in ```config/ci_authentication.php``` with the property ```do_register_email```.
* Added a model method to ```edit_user_by_username()``` when you don't have the user ID.
* Added param ```$not_username``` to ```username_check()``` in the model, allowing you to check for duplicates excluding the current username.

**1.2.2**

* Fixed bug in register() with hardcoded username and password fields.
* Fixed bug where ```role_id``` was being set in ```do_register()``` when the ```roles_table``` config item was empty.
* Fixed bug where email config was not automatically set to HTML.
* Fixed bug with resetting password: Temp passwords were not matching.
* Added email views to **example/views** folder.
* Removed unnecessary salt creation in library.
* Made error logging more consistent (CI Authentication instead of Authentication).

**1.2.1**

* Fixed bug in ```is_logged_in()```
* Removed repetition in ```restrict_access()```, called ```is_logged_in()``` for login check
* Fixed display bugs, formatting issues in README
* Fixed bug in ```do_logout()```
* Autoload ```config/ci_authentication.php```
* Changed ```do_logout()``` to unset the username rather than the password

**1.2.0**

* Updated Alerts spark to 1.1.6 to resolve a bug and add a feature.
* Added library method ```is_logged_in()``` to return whether a user is logged in.
* Added config item ```user_id_field``` for the user id field name in the db.
* Added helper function ```auth_id()``` to return the ID of the currently signed in user.
* Added helper function ```is_logged_in()``` as a shortcut to the library method to check if a user is logged in. Useful in views.
* Added config item ```user_status_field``` for the user status field name in the db.
* Added library method ```set_user_status()``` to change a user's status. For instance active, inactive, or blocked.
* Updated **setup.sql** to account for user status. Removed roles.
* Added config item ```login_with_encryption_key```. If true, password string is mixed with the configured encryption key. Leave this true for security!
* Updated encrypt\_helper to limit by encryption key if config values are true.
* Updated encrypt\_helper to get the salt length from the config.
* In the library method ```do_login()```, removed setting a new salt there as it's already done in encrypt\_helper if you leave off the second param.

**1.1.10**

* Added config item for ```login_required_message```. This is set when a user is not logged in but hits a page that requires login.
* Fixed some bugs in the example **example/controllers/auth.php** controller
* Removed code to unset $this->session->userdata on logout

**1.1.9** 

* Made the roles table optional (leave blank in config if you don't join in a roles table to users)
* Changed ```home_page_field``` to the more appropriate ```login_success_url_field``` in **config/ci_authentication.php**.
* Added config item for a default ```login_success_url```. Use this if you don't set the ```login_success_url_field``` in the users or roles table.
* Removed duplicate config item: ```logged_out_message```
* Added an example folder with an authentication controller, views, and a restricted page.

----------------------------

Thanks to
============================

* [Ali Fatahi](http://disqus.com/guest/5e01ff5649c16170722126f43745ae73/) for some excellent suggestions on improving the library.