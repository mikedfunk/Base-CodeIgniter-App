<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

require_once BASE_PATH . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'migration_helpers.php';

/**
* Generate task
*/
class FIRE_Generate extends BaseCommand
{
    /**
     * Arguments passed to the constructor.
     *
     * @var    array
     * @access private
     */
    private $args;

    /**
     * Extra information to be generated seperately.
     * This includes controller actions and model methods.
     *
     * @var    string
     * @access private
     */
    private $extra;

    /**
     * The constructor.
     *
     * @access public
     * @param  array $args : Parsed command line arguments.
     * @author Aziz Light
     */
    public function __construct(array $args)
    {
        $this->extra = $this->generate_extra($args);

        $this->args = $args;
    }

    /**
     * Braaaaains
     *
     * @access public
     * @return void
     * @author Aziz Light
     */
    public function run()
    {
        $subject = $this->args['subject'];
        $this->$subject();
        return;
    }

    /**
     * The method that generates the controller
     *
     * @access private
     * @return void
     * @author Aziz Light
     */
    private function controller()
    {
        $location = $this->args["location"] . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;
        $relative_location = $this->args['application_folder'] . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;

        if (!empty($this->args['subdirectories']))
        {
            $location .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
            $relative_location .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
        }

        if (!is_dir($location))
        {
            mkdir($location, 0755, TRUE);
        }

        $relative_location .= $this->args['filename'];
        $filename = $location . $this->args['filename'];

        $args = array(
            "class_name"         => ApplicationHelpers::camelize($this->args['name']),
            "filename"           => $this->args['filename'],
            "application_folder" => $this->args['application_folder'],
            "parent_class"       => (isset($this->args['parent'])) ? $this->args['parent'] : $this->args['parent_controller'],
            "extra"              => $this->extra,
            'relative_location'  => $relative_location,
            'helper_name'        => strtolower($this->args['name']) . '_helper',
        );

        $template    = new TemplateScanner("controller", $args);
        $controller  = $template->parse();

        $message = "\t";
        if (file_exists($filename))
        {
            $message .= 'Controller already exists : ';
            if (php_uname("s") !== "Windows NT")
            {
                $message  = ApplicationHelpers::colorize($message, 'light_blue');
            }
            $message .= $relative_location;
        }
        elseif (file_put_contents($filename, $controller))
        {
            $message .= 'Created controller: ';
            if (php_uname("s") !== "Windows NT")
            {
                $message  = ApplicationHelpers::colorize($message, 'green');
            }
            $message .= $relative_location;
        }
        else
        {
            $message .= 'Unable to create controller: ';
            if (php_uname("s") !== "Windows NT")
            {
                $message  = ApplicationHelpers::colorize($message, 'red');
            }
            $message .= $relative_location;
        }

        // The controller has been generated, output the confirmation message
        fwrite(STDOUT, $message . PHP_EOL);

        // Create the helper files.
        $this->helpers();

        $this->assets();

        // Create the view files.
        $this->views();

        return;
    }

    /**
     * The method that creates the assets folders
     * if they don't already exist and generates the
     * assets (again, if they don't already exist)
     *
     * @access private
     * @return boolean
     * @author Aziz Light
     */
    private function assets()
    {
        $relative_location = 'assets/';
        $assets_directory = realpath($this->args['location'] . DIRECTORY_SEPARATOR . '..') . DIRECTORY_SEPARATOR . $relative_location;
        if (!is_dir($assets_directory))
        {
            if (mkdir($assets_directory, 0755))
            {
                $message = "\tCreated folder: ";
                if (php_uname("s") !== "Windows NT")
                {
                    $message = ApplicationHelpers::colorize($message, 'green') . $relative_location;
                }
                else
                {
                    $message .= $relative_location;
                }
            }
        }
        $assets_directories = array(
            'css' => 'css' . DIRECTORY_SEPARATOR,
            'img' => 'img' . DIRECTORY_SEPARATOR,
            'js'  => 'js'  . DIRECTORY_SEPARATOR
        );
        foreach ($assets_directories as $asset_type => $asset_directory)
        {
            $ad = $assets_directory . $asset_directory;
            if (!is_dir($ad) && mkdir($ad, 0755))
            {
                $message = "\tCreated folder: ";
                if (php_uname("s") !== "Windows NT")
                {
                    $message = ApplicationHelpers::colorize($message, 'green') . $relative_location . $asset_directory;
                }
                else
                {
                    $message .= $relative_location . $asset_directory;
                }
            }

            if (!empty($this->args['subdirectories']))
            {
                $ad .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
                if (!is_dir($assets_directory . $asset_directory . $this->args['subdirectories']) && mkdir($assets_directory . $asset_directory . $this->args['subdirectories'], 0755, TRUE))
                {
                    $message = "\tCreated folder: ";
                    if (php_uname("s") !== "Windows NT")
                    {
                        $message = ApplicationHelpers::colorize($message, 'green') . $relative_location . $asset_directory . $this->args['subdirectories'];
                    }
                    else
                    {
                        $message .= $relative_location . $asset_directory . $this->args['subdirectories'];
                    }
                }
            }

            if (isset($message))
            {
                fwrite(STDOUT, $message . "\n");
                unset($message);
            }

            if ($asset_type === 'img')
            {
                continue;
            }
            else
            {
                $ad .= $this->args['name'] . '.' . $asset_type;
                if (!is_file($ad) && touch($ad))
                {
                    $message = "\tCreated asset: ";
                    if (php_uname("s") !== "Windows NT")
                    {
                        $message = ApplicationHelpers::colorize($message, 'green') . $relative_location . $asset_directory;
                        if (!empty($this->args['subdirectories']))
                        {
                            $message .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
                        }
                        $message .= $this->args['name'] . '.' . $asset_type;
                    }
                    else
                    {
                        $message .= $relative_location . $asset_directory;
                        if (!empty($this->args['subdirectories']))
                        {
                            $message .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
                        }
                        $message .= $this->args['name'] . '.' . $asset_type;
                    }
                    
                    fwrite(STDOUT, $message . "\n");
                    unset($message);
                }
                else
                {
                    $message = "\tAsset already exists: " . $relative_location . $asset_directory;
                    if (!empty($this->args['subdirectories']))
                    {
                        $message .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
                    }
                    $message .= $this->args['name'] . '.' . $asset_type;
                    
                    fwrite(STDOUT, $message . "\n");
                    unset($message);
                }
            }

            unset($ad);
        }
        
        return true;
    }

    /**
     * The method that generates helpers
     *
     * @access private
     * @return void
     * @author Aziz Light
     **/
    private function helpers()
    {
        $relative_location = $this->args['application_folder'] . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR;
        $helper_directory = $this->args['location'] . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR;
        if (!empty($this->args['subdirectories']))
        {
            $relative_location .= $this->args['subdirectories'];
            $helper_directory .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
        }
        $relative_helper_location = $relative_location . DIRECTORY_SEPARATOR . strtolower($this->args['name']) . '_helper.php';
        $helper_file = $helper_directory . strtolower($this->args['name']) . '_helper.php';

        if (!is_dir($helper_directory))
        {
            $message = "\t";
            if (mkdir($helper_directory, 0755, TRUE))
            {
                $message .= 'Created folder: ';
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'green') . $relative_location;
                }
                else
                {
                    $message .= $relative_location;
                }
                fwrite(STDOUT, $message . PHP_EOL);
                unset($message);
            }
            else
            {
                $message .= 'Unable to create folder: ';
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'red') . $relative_location;
                }
                else
                {
                    $message .= $relative_location;
                }
                fwrite(STDOUT, $message . PHP_EOL);
                return false;
            }
        }

        if (file_exists($helper_file))
        {
            $message = "\tHelper already exists: ";
            if (php_uname("s") !== "Windows NT")
            {
                $message = ApplicationHelpers::colorize($message, 'light_blue') . $relative_helper_location;
            }
            else
            {
                $message .= $relative_helper_location;
            }
            fwrite(STDOUT, $message . PHP_EOL);
            unset($message);
            return true;
        }
        else
        {
            $content  = "<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');" . PHP_EOL;
            $content .= PHP_EOL . PHP_EOL . PHP_EOL;
            $content .= '/* End of file ' . strtolower($this->args['name']) . '_helper.php */' . PHP_EOL;
            $content .= '/* Location: ./' . $relative_location . ' */';

            $message = "\t";
            if (file_put_contents($helper_file, $content))
            {
                $message .= 'Created helper: ';
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'green') . $relative_helper_location;
                }
                else
                {
                    $message  .= $relative_helper_location;
                }
            }
            else
            {
                $message .= 'Unable to create helper: ';
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'red') . $relative_helper_location;
                }
                else
                {
                    $message  .= $relative_helper_location;
                }
            }

            fwrite(STDOUT, $message . PHP_EOL);
            unset($message);
        }

        return true;
    }

    /**
     * The method that generates the models
     *
     * @access private
     * @return void
     * @author Aziz Light
     */
    private function model()
    {
        $location = $this->args["location"] . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR;
        $relative_location = $this->args['application_folder'] . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR;
        $class_name = '';

        if (!empty($this->args['subdirectories']))
        {
            $location .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
            $relative_location .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;

            $tmp = explode(DIRECTORY_SEPARATOR, $this->args['subdirectories']);
            $tmp = join('_', $tmp);
            $class_name .= ApplicationHelpers::camelize($tmp);
        }

        if (!is_dir($location))
        {
            mkdir($location, 0755, TRUE);
        }

        $relative_location .= $this->args['filename'];
        $filename = $location . $this->args['filename'];
        $class_name .= ucfirst(strtolower($this->args['name']));

        $args = array(
            "class_name"         => ucfirst(strtolower($this->args['name'])),
            "filename"           => $this->args['filename'],
            "application_folder" => $this->args['application_folder'],
            "parent_class"       => (isset($this->args['parent'])) ? $this->args['parent'] : $this->args['parent_model'],
            "extra"              => $this->extra,
            'relative_location'  => $relative_location,
        );

        $template = new TemplateScanner("model", $args);
        $model    = $template->parse();

        $message = "\t";
        if (file_exists($filename))
        {
            $message .= 'Model already exists : ';
            if (php_uname("s") !== "Windows NT")
            {
                $message  = ApplicationHelpers::colorize($message, 'light_blue');
            }
            $message .= $relative_location;
        }
        elseif (file_put_contents($filename, $model))
        {
            $message .= 'Created model: ';
            if (php_uname("s") !== "Windows NT")
            {
                $message  = ApplicationHelpers::colorize($message, 'green');
            }
            $message .= $relative_location;
        }
        else
        {
            $message .= 'Unable to create model: ';
            if (php_uname("s") !== "Windows NT")
            {
                $message  = ApplicationHelpers::colorize($message, 'red');
            }
            $message .= $relative_location;
        }

        fwrite(STDOUT, $message . PHP_EOL);

        // Create the migration for the new model
        $this->migration();

        return;
    }

    /**
     * Creates the view files and the views folder if necessary.
     *
     * @access private
     * @return bool
     */
    private function views()
    {
        $controller = $this->args['name'];
        $views = (array_key_exists('extra', $this->args)) ? $this->args['extra'] : array();

        if (empty($views))
        {
            if ($this->args['subject'] === 'views')
            {
                $controller_location = $this->args['location'] . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;
                if (!empty($this->args['subdirectories']))
                {
                    $controller_location .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
                }
                $controller_location .= $this->args['filename'];

                if (is_file($controller_location))
                {
                    $views = $this->get_controller_actions($controller_location);
                }
                else
                {
                    return true;
                }
            }
            else
            {
                return true;
            }
        }

        // Check that the views folder exists and create it if it doesn't
        $location = $this->args['location'] . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
        $views_folder = $this->args['application_folder'] . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;

        if (!empty($this->args['subdirectories']))
        {
            $location .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
            $views_folder .= $this->args['subdirectories'] . DIRECTORY_SEPARATOR;
        }

        $location .= strtolower($controller);
        $views_folder .= strtolower($controller);

        if (!file_exists($location) || !is_dir($location))
        {
            $message = "\t";
            if (mkdir($location, 0755, TRUE))
            {
                $message .= 'Created folder: ';
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'green') . $views_folder;
                }
                else
                {
                    $message .= $views_folder;
                }
                fwrite(STDOUT, $message . PHP_EOL);
                unset($message);
            }
            else
            {
                $message .= 'Unable to create folder: ';
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'red') . $views_folder;
                }
                else
                {
                    $message .= $views_folder;
                }
                fwrite(STDOUT, $message . PHP_EOL);
                return false;
            }
        }

        // Create the views
        foreach ($views as $view)
        {
            // First check that the views doesn't already exist
            if (file_exists($location . DIRECTORY_SEPARATOR . $view . '.php'))
            {
                $message = "\tView already exists: ";
                if (php_uname("s") !== "Windows NT")
                {
                    $message = ApplicationHelpers::colorize($message, 'light_blue') . $views_folder . '/' . $view . '.php';
                }
                else
                {
                    $message .= $views_folder . DIRECTORY_SEPARATOR . $view . '.php';
                }
                fwrite(STDOUT, $message . PHP_EOL);
                unset($message);
                continue;
            }

            $content  = '<h1>' . $controller . '#' . $view . '</h1>';
            $content .= PHP_EOL . '<p>Find me in ' . $views_folder . DIRECTORY_SEPARATOR . $view . '.php</p>';

            $message = "\t";
            if (file_put_contents($location . DIRECTORY_SEPARATOR . $view . '.php', $content))
            {
                $message .= 'Created view: ';
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'green') . $views_folder . DIRECTORY_SEPARATOR . $view . '.php';
                }
                else
                {
                    $message  .= $views_folder . DIRECTORY_SEPARATOR . $view . '.php';
                }
            }
            else
            {
                $message .= 'Unable to create view ';
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'red') . $views_folder . DIRECTORY_SEPARATOR . $view . '.php';
                }
                else
                {
                    $message  .= $views_folder . DIRECTORY_SEPARATOR . $view . '.php';
                }
            }

            fwrite(STDOUT, $message . PHP_EOL);
            unset($message);
        }

        return true;
    }

    /**
     * Create a controller with its views and
     * a model with its migration
     *
     * @access private
     * @return void
     * @author Aziz Light
     */
    private function scaffold()
    {
        if (isset($this->args['extra']))
        {
            $extra = $this->args['extra'];
            unset($this->args['extra']);
        }
        else
        {
            $extra = array();
        }

        $this->args['name'] = Inflector::pluralize($this->args['name']);
        $this->args['filename'] = $this->args['name'] . '.php';
        $this->args['extra'] = array('index', 'create', 'view', 'edit', 'delete');
        $this->extra = $this->generate_controller_actions($this->args['name'], $this->args['extra']);
        $this->controller();

        $this->args['name'] = Inflector::singularize($this->args['name']);
        $this->args['filename'] = $this->args['name'] . '.php';
        $this->args['extra'] = $extra;
        $this->extra = $this->generate_migration_statement($this->args['name'], $this->args['extra']);
        $this->model();
    }

    /**
     * Create a migration file
     *
     * @access private
     * @return void
     * @author Aziz Light
     **/
    private function migration()
    {
        $location = $this->args['location'] . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR;
        if (!is_dir($location))
        {
            mkdir($location);
        }

        $backtrace = debug_backtrace();
        $calling_function = $backtrace[1]['function'];

        if ($calling_function === "model")
        {
            $class_name = 'Migration_Add_';
            $filename = 'add_';
            $table_name = '';

            if (!empty($this->args['subdirectories']))
            {
                $dirs = explode(DIRECTORY_SEPARATOR, $this->args['subdirectories']);
                $dirs = join('_', $dirs);
                $class_name .= strtolower($dirs) . '_';
                $filename .= strtolower($dirs) . '_';
                $table_name .= strtolower($dirs) . '_';
            }
            $args = array(
                'class_name'         => $class_name . Inflector::pluralize($this->args['name']),
                'table_name'         => $table_name . Inflector::pluralize(strtolower($this->args['name'])),
                'filename'           => $filename . Inflector::pluralize(ApplicationHelpers::underscorify($this->args['name'])) . '.php',
                'application_folder' => $this->args['application_folder'],
                'parent_class'       => $this->args['parent_migration'],
                'extra'              => $this->extra
            );

            $template_name = 'migration';
        }
        else
        {
            $args = array(
                'class_name'         => 'Migration_' . $this->args['name'],
                'table_name'         => $this->get_table_name_out_of_migration_name(),
                'filename'           => $this->args['filename'],
                'application_folder' => $this->args['application_folder'],
                'parent_class'       => $this->args['parent_migration'],
                'extra'              => $this->extra
            );

            $template_name = 'empty_migration';
        }

        $template  = new TemplateScanner($template_name, $args);
        $migration = $template->parse();

        $migration_number = MigrationHelpers::get_migration_number($this->args['location']);
        $filename = $location . $migration_number . '_' . $args['filename'];
        $potential_duplicate_migration_filename = MigrationHelpers::decrement_migration_number($migration_number) . '_' . $args['filename'];
        $potential_duplicate_migration = $location . $potential_duplicate_migration_filename;

        $message = "\t";
        if (file_exists($potential_duplicate_migration))
        {
            $message .= 'Migration already exists : ';
            if (php_uname("s") !== "Windows NT")
            {
                $message  = ApplicationHelpers::colorize($message, 'light_blue');
            }
            $message .= $this->args['application_folder'] . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . $potential_duplicate_migration_filename;
        }
        else if (file_put_contents($filename, $migration) && MigrationHelpers::add_migration_number_to_config_file($this->args['location'], $migration_number))
        {
            $message .= 'Created Migration: ';
            if (php_uname("s") !== "Windows NT")
            {
                $message  = ApplicationHelpers::colorize($message, 'green');
            }
            $message .= $this->args['application_folder'] . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . $migration_number . '_' . $args['filename'];
        }
        else
        {
            $message .= 'Unable to create migration: ';
            if (php_uname("s") !== "Windows NT")
            {
                $message  = ApplicationHelpers::colorize($message, 'red');
            }
            $message .= $this->args['application_folder'] . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . $migration_number . '_' . $this->args['filename'];
        }

        fwrite(STDOUT, $message . PHP_EOL);

        return;
    }

    /**
     * Generate the extra content that goes
     * in the main template depending on the
     * subject (controller, model or migration)
     *
     * @access private
     * @param array $args The parsed command line arguments
     * return string The extra code to inject into the main template
     * @author Aziz Light
     */
    private function generate_extra(array $args)
    {
        if (!array_key_exists('extra', $args) || !is_array($args['extra']) || empty($args['extra']) || $args['subject'] === 'views')
        {
            $extra = '';
        }
        else
        {
            switch ($args['subject'])
            {
                case 'controller':
                    $extra = $this->generate_controller_actions($args['name'], $args['subdirectories'], $args['extra']);
                    break;
                case 'scaffold':
                case 'model':
                    $extra = $this->generate_migration_statement($args['name'], $args['extra']);
                    break;
                case 'migration':
                    $extra = $this->generate_migration_statement($args['name'], $args['extra']);
                    break;
            }
        }

        return $extra;
    }

    /**
     * Parse a controller and returns a list of public actions
     *
     * @access private
     * @param string $controller_location The path to the controller to parse
     * @return array The public controller actions or an empty array
     * @author Aziz Light
     */
    private function get_controller_actions($controller_location)
    {
        $controller = file_get_contents($controller_location);
        $regex = '/^\s*(?:public )?function (?P<action>[a-zA-Z]+(?:_?[a-zA-Z0-9]+)*)/m';
        preg_match_all($regex, $controller, $matches);
        if (!empty($matches['action']))
        {
            return $matches['action'];
        }
        else
        {
            return array();
        }
    }

    /**
     * Generate the actions that will go in the controller.
     *
     * @access private
     * @param string $class_name : The name of the controller
     * @param  array $args : The list of actions to generate
     * @return string : The generated actions
     * @author Aziz Light
     */
    private function generate_controller_actions($class_name, $subdirectories, array $actions)
    {
        $extra = "";

        foreach ($actions as $action)
        {
            $args = array(
                "class_name" => $class_name,
                "extra" => $action
            );

            $args['view_folder'] = "";

            if (!empty($subdirectories))
            {
                $args['view_folder'] = $subdirectories . DIRECTORY_SEPARATOR;
            }

            $args['view_folder'] .= strtolower($args['class_name']);

            $template = new TemplateScanner("actions", $args);
            $extra   .= $template->parse();
            unset($args, $template);
        }
        return $extra;
    }

    /**
     * Generate the body the the migration that will be generated
     *
     * @access private
     * @param string $class_name The name of the model
     * @param array $columns The list of columns with their attributes
     * @return string The migration's body
     * @author Aziz Light
     **/
    private function generate_migration_statement($class_name, array $columns)
    {
        $extra = '';

        foreach ($columns as $column => $attrs)
        {
            $args = array();
            $args['column_name'] = $column;

            foreach ($attrs as $attr => $value)
            {
                $args['column_' . $attr] = $value;
            }

            $template = new TemplateScanner('migration_column', $args);
            $extra .= $template->parse();
        }

        return trim($extra, PHP_EOL) . PHP_EOL;
    }

    /**
     * Try to extract the table name out of the migration name
     *
     * @access private
     * @return string The guessed table name
     * @author Aziz Light
     **/
    private function get_table_name_out_of_migration_name()
    {
        $patterns = array(
            '/create_(?P<table_name>\w+)$/',
            '/add_\w+_to_(?P<table_name>\w+)$/',
            '/add_(?P<table_name>\w+)$/'
        );

        $table_name = "";
        foreach ($patterns as $pattern)
        {
            if (preg_match($pattern, $this->args['name'], $matches) === 1)
            {
                $table_name = $matches['table_name'];
                break;
            }
        }

        return $table_name;
    }
}
