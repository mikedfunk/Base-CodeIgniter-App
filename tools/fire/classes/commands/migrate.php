<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

require_once BASE_PATH . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'migration_helpers.php';

/**
 * Migrate command
 */
class FIRE_Migrate extends BaseCommand
{
    /**
     * The migrate command.
     *
     * @access access
     * @var string
     */
    private $command;

    /**
     * Location of the application folder
     *
     * @access private
     * @var string
     */
    private $location;

    /**
     * Name of the migration controller
     * that will be generated
     *
     * @access private
     * @var string
     */
    private $controller_name;

    /**
     * Name of the CodeIgniter system folder
     *
     * @access private
     * @var string
     */
    private $system_folder;

    /**
     * CodeIgniter files to patch
     *
     * @access private
     * @var array
     */
    private $files_to_patch = array('Utf8', 'Output');

    /**
     * Whether or not the migration controller can be
     * run from a web browser or just from the CLI
     *
     * @access private
     * @var bool
     */
    private $run_from_web;

    /**
     * El Constructor!
     *
     * @access access
     * @param array $args Pased command line arguments
     * @return void
     * @author Aziz Light
     */
    public function __construct(array $args)
    {
        if (isset($args['subject']))
        {
            $this->command = $args['subject'];
        }

        $this->location = $args['location'];
        $this->controller_name = $args['controller_name'];
        $this->system_folder = $args['system_folder'];
        $this->run_from_web = (bool) $args['run_from_web'];
    }

    /**
     * The brains of the command
     *
     * @access private
     * @return void
     * @author Aziz Light
     **/
    public function run()
    {
        $this->patch_codeigniter();

        if (isset($this->command))
        {
            $command = $this->command;
            $this->$command();
        }
        else
        {
            $this->current();
        }

        $this->unpatch_codeigniter();

        return;
    }

    /**
     * Initialize CodeIgniter to be able to run migrations
     *
     * @access private
     * @return void
     * @author Aziz Light
     **/
    private function install()
    {
        if ($this->enable_migrations() && $this->create_migration_controller())
        {
            fwrite(STDOUT, 'Done!' . PHP_EOL);
        }
    }

    private function rollback()
    {
        $migration_number = MigrationHelpers::get_migration_number_from_config_file($this->location);
        if ($migration_number > 0)
        {
            $migration_number--;
            if (MigrationHelpers::add_migration_number_to_config_file($this->location, $migration_number))
            {
                $this->current(TRUE);
                fwrite(STDOUT, 'Last migration rolled back!' . PHP_EOL);
            }
            else
            {
                fwrite(STDOUT, 'Database could not be rolled back...' . PHP_EOL);
            }
        }
        else
        {
            fwrite(STDOUT, 'Nothing to rollback!' . PHP_EOL);
        }

        return;
    }

    /**
     * Migrate the database up to the current migration
     * This method starts by replication the index.php file
     * of CodeIgniter.
     *
     * @access private
     * @return void
     * @author Aziz Light
     **/
    private function current($rollback = FALSE)
    {
        if ($rollback === FALSE)
        {
            $migration_number = MigrationHelpers::get_latest_migration_number($this->location);
            MigrationHelpers::add_migration_number_to_config_file($this->location, $migration_number);
        }
        else
        {
            define('MIGRATION_ROLLBACK', 'TRUE');
        }

        foreach ($_SERVER['argv'] as $index => $value)
        {
            if ($index === 0)
            {
                continue;
            }
            else
            {
                array_pop($_SERVER['argv']);
            }
        }
        $_SERVER['argv'][] = "migrate";

        // ---------------------------------------------------------------------

        $system_path = $this->system_folder;
        $generate_config = parse_ini_file(BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'generate.ini');
        $application_folder = $generate_config['application_folder'];
        $view_folder = '';
        unset($this->system_folder, $generate_config);

        if (($_temp = realpath($system_path)) !== FALSE)
        {
            $system_path = $_temp.'/';
        }
        else
        {
            $system_path = rtrim($system_path, '/').'/';
        }

        if ( ! is_dir($system_path))
        {
            header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
            exit('Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME));
        }

        define('SELF', pathinfo(getcwd() . '/index.php', PATHINFO_BASENAME));
        define('BASEPATH', str_replace('\\', '/', $system_path));
        define('FCPATH', getcwd());
        define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));
        if (is_dir($application_folder))
        {
            if (($_temp = realpath($application_folder)) !== FALSE)
            {
                $application_folder = $_temp;
            }

            define('APPPATH', $application_folder.'/');
        }
        else
        {
            if ( ! is_dir(BASEPATH.$application_folder.'/'))
            {
                header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
                exit('Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF);
            }

            define('APPPATH', BASEPATH.$application_folder.'/');
        }

        if ( ! is_dir($view_folder))
        {
            if ( ! empty($view_folder) && is_dir(APPPATH.$view_folder.'/'))
            {
                $view_folder = APPPATH.$view_folder;
            }
            elseif ( ! is_dir(APPPATH.'views/'))
            {
                header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
                exit('Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF);
            }
            else
            {
                $view_folder = APPPATH.'views';
            }
        }

        if (($_temp = realpath($view_folder)) !== FALSE)
        {
            $view_folder = realpath($view_folder).'/';
        }
        else
        {
            $view_folder = rtrim($view_folder, '/').'/';
        }

        define('VIEWPATH', $view_folder);

        require_once BASEPATH.'core/CodeIgniter.php';
    }

    /**
     * Patch CodeIgniter so that fire
     * can run the migrations from the
     * command line
     *
     * @access private
     * @return bool Whether or not CodeIgniter was patched
     * @author Aziz Light
     **/
    private function patch_codeigniter()
    {
        $result = FALSE;

        foreach ($this->files_to_patch as $file)
        {
            $file_location = FolderScanner::system_path() . 'core' . DIRECTORY_SEPARATOR . $file . '.php';
            $result = $this->patch_codeigniter_file($file_location);
        }

        return $result;
    }

    /**
     * Patch a CodeIgniter file
     *
     * @access private
     * @return bool Whether or not the file was patched
     * @author Aziz Light
     **/
    private function patch_codeigniter_file($file_location)
    {
        $this->backup_file($file_location);
        $tmp = explode(DIRECTORY_SEPARATOR, $file_location);
        $file_name = end($tmp);
        $file = file_get_contents($file_location);

        preg_match('/[\t ]*\/\/ Aziz Light is the boss!/', $file, $matches);
        if (empty($matches))
        {
            if ($file_name === 'Utf8.php')
            {
                $pattern = '/(?P<whitespace>[\t ]*)global \$CFG;/';
                preg_match($pattern, $file, $matches);

                $conditional  = $matches[0] . PHP_EOL;
                $conditional .= PHP_EOL . $matches['whitespace'] . '// Aziz Light is the boss!' . PHP_EOL;
                $conditional .= $matches['whitespace'] . 'if ($CFG === NULL)' . PHP_EOL;
                $conditional .= $matches['whitespace'] . '{' . PHP_EOL;
                $conditional .= $matches['whitespace'] . '    ' . '$CFG =& load_class(\'Config\', \'core\');' . PHP_EOL;
                $conditional .= $matches['whitespace'] . '}' . PHP_EOL;
            }
            else if ($file_name === 'Output.php')
            {
                $pattern = '/(?P<whitespace>[\t ]*)global \$BM, \$CFG;/';
                preg_match($pattern, $file, $matches);

                $conditional  = $matches[0] . PHP_EOL;
                $conditional .= PHP_EOL . $matches['whitespace'] . '// Aziz Light is the boss!' . PHP_EOL;
                $conditional .= $matches['whitespace'] . 'if ($CFG === NULL)' . PHP_EOL;
                $conditional .= $matches['whitespace'] . '{' . PHP_EOL;
                $conditional .= $matches['whitespace'] . '    ' . '$CFG =& load_class(\'Config\', \'core\');' . PHP_EOL;
                $conditional .= $matches['whitespace'] . '}' . PHP_EOL;
                $conditional .= PHP_EOL . $matches['whitespace'] . 'if ($BM === NULL)' . PHP_EOL;
                $conditional .= $matches['whitespace'] . '{' . PHP_EOL;
                $conditional .= $matches['whitespace'] . '    ' . '$BM =& load_class(\'Benchmark\', \'core\');' . PHP_EOL;
                $conditional .= $matches['whitespace'] . '}' . PHP_EOL;
            }

            $file = preg_replace($pattern, $conditional, $file);
            return file_put_contents($file_location, $file);
        }
        else
        {
            return TRUE;
        }
    }

    /**
     * Backup a file in the temp directory
     *
     * @access private
     * @param string $file_location The location of the file to backup
     * @return void
     * @author Aziz Light
     */
    private function backup_file($file_location)
    {
        $tmp = explode(DIRECTORY_SEPARATOR, $file_location);
        $file_name = end($tmp);

        if (!is_dir(BASE_PATH . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR))
        {
            mkdir(BASE_PATH . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR, 0755);
        }

        copy($file_location, BASE_PATH . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR . $file_name);
        return;
    }

    /**
     * Revert the CodeIgniter Patch
     *
     * @access private
     * @return bool Whether or not CodeIgniter was unpatched
     * @author Aziz Light
     **/
    private function unpatch_codeigniter()
    {
        $result = FALSE;

        foreach ($this->files_to_patch as $file)
        {
            $file_location = FolderScanner::system_path() . 'core' . DIRECTORY_SEPARATOR . $file . '.php';
            $result = $this->unpatch_codeigniter_file($file_location);
        }

        return $result;
    }

    /**
     * Unpatch a codeigniter file
     *
     * @access private
     * @param string $file_location The absolute path to the file to patch
     * @return bool Whether the codeigniter file was unpatched or not.
     * @author Aziz Light
     */
    private function unpatch_codeigniter_file($file_location)
    {
        $tmp = explode(DIRECTORY_SEPARATOR, $file_location);
        $file_name = end($tmp);
        $file = file_get_contents($file_location);

        preg_match('/[\t ]*\/\/ Aziz Light is the boss!/', $file, $matches);
        if (!empty($matches))
        {
            if ($file_name === 'Utf8.php')
            {
                $pattern  = '/\s*\/\/ Aziz Light is the boss!' . PHP_EOL;
                $pattern .= '[\t ]*if \(\$CFG === NULL\)' . PHP_EOL;
                $pattern .= '[\t ]*\{' . PHP_EOL;
                $pattern .= '[\t ]*\$CFG =& load_class\(\'Config\', \'core\'\);' . PHP_EOL;
                $pattern .= '[\t ]*\}' . PHP_EOL . '/';
            }
            else if ($file_name === 'Output.php')
            {
                $pattern  = '/\s*\/\/ Aziz Light is the boss!' . PHP_EOL;
                $pattern .= '[\t ]*if \(\$CFG === NULL\)' . PHP_EOL;
                $pattern .= '[\t ]*\{' . PHP_EOL;
                $pattern .= '[\t ]*\$CFG =& load_class\(\'Config\', \'core\'\);' . PHP_EOL;
                $pattern .= '[\t ]*\}' . PHP_EOL . PHP_EOL;
                $pattern .= '[\t ]*if \(\$BM === NULL\)' . PHP_EOL;
                $pattern .= '[\t ]*\{' . PHP_EOL;
                $pattern .= '[\t ]*\$BM =& load_class\(\'Benchmark\', \'core\'\);' . PHP_EOL;
                $pattern .= '[\t ]*\}' . PHP_EOL . '/';
            }

            $file = preg_replace($pattern, '', $file);

            return file_put_contents($file_location, $file);
        }
        else
        {
            return TRUE;
        }
    }

    /**
     * Enable the migrations in the
     * migration.php config file
     *
     * @access private
     * @return bool
     * @author Aziz Light
     **/
    private function enable_migrations()
    {
        $config_file = $this->location . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'migration.php';
        if (is_file($config_file))
        {
            $config_file_contents = file_get_contents($config_file);
            $config_file_contents = preg_replace('/\$config\[\'migration_enabled\'\] = FALSE;/', '$config[\'migration_enabled\'] = TRUE;', $config_file_contents, -1, $count);

            if (file_put_contents($config_file, $config_file_contents))
            {
                return TRUE;
            }
            else
            {
                // TODO: Find a clean way to return an error message saying that the migration succeeded but that the migration count could not be incremented in the config file
                return FALSE;
            }

        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Create the Migrate controller that
     * will be used to migrate the database
     *
     * @access private
     * @return void
     * @author Aziz Light
     **/
    private function create_migration_controller()
    {
        $controller = $this->location . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $this->controller_name . '.php';
        if (is_file($controller))
        {
            throw new RuntimeException('The ' . $this->controller_name . ' controller aleardy exists!');
        }
        else
        {
            $template_name = "migration_controller";
            $args = array(
                'class_name' => ApplicationHelpers::camelize($this->controller_name),
            );

            if ($this->run_from_web === FALSE)
            {
                $args['extra'] = '        $this->input->is_cli_request() or exit("Execute via command line: php index.php migrate");';
            }
            else
            {
                $args['extra'] = PHP_EOL;
            }

            $template = new TemplateScanner($template_name, $args);
            $controller_contents = $template->parse();

            if (!file_put_contents($controller, $controller_contents))
            {
                throw new RuntimeException('Could not create migration controller...' . PHP_EOL);
            }

            return TRUE;
        }
    }
}
