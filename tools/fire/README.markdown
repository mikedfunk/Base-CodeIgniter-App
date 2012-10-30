# fire : CodeIgniter code generator
This little script lets you generate controllers and models very easily in your codeigniter-based app.

**NOTE**: Right now, fire is not compatible with Windows; I am working
on that and will release an OS-agnostic version as soon as possible.

## Installation
The first thing to do is to make sure that php is in you `$PATH`. On OS
X, assuming that you are using MAMP, here are the steps:

Open one of the following files in your favourite text editor: `.bash_profile`,
`.bashrc` or `.zshrc` depending on the shell you are using and add the following
line at the bottom of the file:

    PATH=Applications/MAMP/bin/php/php5.4.4/bin:$PATH

Depending on the version of MAMP you are using the path to the bin
directory may change.

On Windows 7, from the Desktop, right-click on `Computer`, then click on
`Advanced system settings` in the sidebar and click on `Environment
Variables...` at the bottm of the window that appeared. In the `System
variables` section, scroll down to find the `Path` variable,
double-click on that and append the path to the directory where the
`php` executable lives. Note that paths are separated by a `;`. If
you're using XAMPP then your `Path` variable should look similar to this
now:

    ...;C:\xampp\php

Next, download fire and put it somewhere safe. Now, you need to add an alias to fire.
In OS X, add this line to your `.bash_profile`, `.bashrc` or `.zshrc`:

    alias fire="php path/to/fire/fire"

Note that `path/to/fire/fire` is the path to the fire executable that
comes with fire, not the fire directory itself.

On Windows, you can either follow the same steps if you can a Unix
environment installed (eg: Cygwin) or you can follow the steps in this
link to do something similar: http://superuser.com/a/49194/10801

## Basic usage
Fire works out of the box, all you have to do is open a terminal window
and get going. Here are some examples:

### Create a new CodeIgniter project

    fire new myproject

This command will clone the latest stable version from Github (from this
repository) in the current folder and remove the git repository so that
you can have a fresh start. **NOTE**: absolute paths are not supported
yet.

If you don't want to clone CodeIgniter everytime you create a new
project run the following command:

    fire bootstrap

This will clone the CodeIgniter project in the same folder as `fire`.
The next time you run the `fire new` command, it will copy the local
version of CodeIgniter instead of cloning it.

Finally, you can specify which Github repository to clone from. To do
this, open the `config/new_project.ini` file in the `fire` folder and
replace `"EllisLab/CodeIgniter"` by any other repository. **NOTE**: You
need to use the same form, ie: `username/repo` or `organisation/repo`.

#### Create a controller

    fire generate controller posts index show new edit delete

This command will create a posts controller in the controllers folder
and will add the index, show, new, edit and delete actions to it. It
will also create a `posts_helper` helper, a views folder for the
controller and views for each action.

If you don't specify a name for the controller you want to create, ***fire*** will ask you to enter one!

    fire g controller

This will also create a controller. Notice that the `g` alias is
available to the lazy people out there too!

You can also create nested controllers, that is, controllers inside
subfolders:

    fire g controller admin/users index

This will create the admin folder in the controllers, helpers and the views
folders if they don't exits.

Finally, you can specify the `--parent` option along with the name of a
class to change the parent controller.

#### Create views

If you generated a blank controller with fire and added actions to it later on,
or if you created a controller manually and can't be bothered to create
a view for each action manually, fire lets you generate views for those actions!
All you have to do is to call the views generator with the name of the
controller in question:

    fire g views users

This will generate a view for each **public** action in the users
controller. **NOTE:** Actions that start with an underscore (`_`) are not
considered public.

You can limit the views generation by giving a list of views to
generate. **NOTE:** By doing this, you can force the generation of views
for non-public actions:

    fire g views users index show

This code snippet will only generate views for the listed actions,
namely: index and show.

#### Create a model

    fire g model post title:string body:text created_at:datetime updated_at:datetime

This command will create a post model in the models folder. It will also
create a migration which add a title field as `VARCHAR`, a body field as
`TEXT`, etc.

Same principle for the model, no need to a name:

    fire g model

This will also create a model, however the user will be asked to enter a
name. NOTE: When creating a model, the `migration_version` configuration
will be incremented by one in `application/config/migration.php`.

You can also create nested models, that is, models inside subfolders:

    fire g model admin/user name:string

Finally, you can specify the `--parent` option along with the name of a
class to change the parent model. You can also specify the
`--parent-migration` option to chage the parent of the migration class.

Here is list of valid field types that fire accepts:

- `string`: translates to `VARCHAR(255) NOT NULL`
- `varchar`: translates to `VARCHAR(255) NOT NULL`
- `text`: translates to `TEXT`
- `int`: translates to `INT(10) UNSIGNED NOT NULL`
- `integer`: translates to `INT(10) UNSIGNED NOT NULL`
- `decimal`: translates to `DECIMAL(10, 0) UNSIGNED NOT NULL`
- `date`: translates to `DATE`
- `datetime`: translates to `DATETIME`
- `char`: translates to `CHAR`
- `bool`: translates to `TINYINT(3) UNSIGNED NOT NULL`
- `boolean`: translates to `TINYINT(3) UNSIGNED NOT NULL`

### Create a migration

    fire g migration add_author_to_posts author:string

This command will generate a blank migration with the name
`add_author_to_posts.php`, prepended by the migration number of course!

In a future release the migration's content will be generated according
to the name of the migration.

Finally, you can specify the `--parent-migration` option along with the name of a
class to change the parent migration.

### Migrate the database

Fire lets you migrate and rollback the database, but first, you need to
setup your database config in `application/config/database.php` and you
need to run the following command:

     fire migrate install

You can now migrate and rollback the database from the command line
without any efforts:

    fire migrate
    fire migrate rollback

## Integration with WebFire

Fire can install its web-based stand-alone version, [WebFire](https://github.com/AzizLight/WebFire). One command
is available to do just that:

    fire web install

## Changelog

**NOTE**: For all the new changes, check the git commits please.

### 08/10/2010
* Bug fix: double equal instead of just one (author: [Erik Jansson](http://github.com/Meldanya))

### 03/20/2010
* New query syntax to add actions, methods and view files.
* View files!
* Models and view files can now be generated automatically.
* Project generation now works perfectly!
* Fixed lots of bugs.
* A lot of things that you won't notice when using the script but that made the code cleaner and easier to maintain.

### 03/13/2010
* New feature: Create new CodeIgniter projects (Work in progress - Additional features coming soon).
* Updated: Removed all the references to the source of the errors/warning in the message outputs that use user sees.

### 03/02/2010
* New feature: Create multiple controllers/models at a time.
* New feature: Add public/private actions/methods to new controllers/models.
* Updated: Better notification system.
* Soon: Create new CodeIgniter projects.

### Contributors

* [Erik Jansson](http://github.com/Meldanya)
