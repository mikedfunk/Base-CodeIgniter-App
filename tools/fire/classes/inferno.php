<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

/**
* Inferno, the master class.
*/
class Inferno
{
    /**
     * List of valid options without the -- at hte beginning
     *
     * @access private
     * @var array
     */
    private static $valid_options = array('parent', 'parent-migration');

    /**
     * List of valid arguments
     *
     * @access private
     * @var array
     */
    private static $valid_tasks = array('generate', 'new_project', 'bootstrap', 'migrate', 'web_fire');

    /**
     * List of valid command aliases and their corresponding command
     *
     * @access private
     * @var array
     */
    private static $valid_aliases = array('g'   => 'generate',
                                          'new' => 'new_project',
                                          'web' => 'web_fire');

    /**
     * List of commands that take no subject
     *
     * @access private
     * @var array
     */
    private static $commands_with_no_subjects = array('new_project', 'bootstrap');

    /**
     * List of commands that take no name
     *
     * @access private
     * @var array
     */
    private static $commands_with_no_name = array('bootstrap', 'migrate', 'web_fire');

    /**
     * List of valid column types supported by fire
     *
     * @access private
     * @var array
     */
    private static $valid_column_types = array('string', 'varchar', 'text', 'int', 'integer', 'decimal',
                                                'date', 'datetime', 'char', 'bool', 'boolean');

    /**
     * List of valid subjects
     *
     * @access private
     * @var array
     */
    private static $valid_subjects = array(
        'generate' => array('controller', 'model', 'scaffold', 'migration', 'views'),
        'migrate' => array('install', 'rollback'),
        'web_fire' => array('install'),
    );

    // Prevent from instantiating the class.
    public function __construct()
    {
        throw new RuntimeException("The Fire class can not be instantiated");
    }

    // TODO: add documentation
    public static function init(array $args)
    {
        if (!is_array($args))
        {
            throw new InvalidArgumentException('Argument 1 passed to Inferno::init() must be an array');
        }

        // First parse the options and remove them
        // from the $args array
        $options = self::parse_options($args);

        // Parse the arguments
        $args = self::parse($args);

        if ($args['command'] == 'new_project')
        {
            if (is_dir(getcwd() . DIRECTORY_SEPARATOR . $args['name']))
            {
                throw new InvalidArgumentException('A folder with the same name already exists');
            }

            $location = __DIR__ . DIRECTORY_SEPARATOR . $args['name'];
        }
        else if ($args['command'] != 'bootstrap')
        {
            $location = FolderScanner::check_location();
        }
        else
        {
            // FIXME: Find a better solution
            // Set the location so that we don't get errors
            $location = "";
        }

        if ($args['command'] != 'bootstrap' && !$location)
        {
            $error_message  = "No CodeIgniter project detected at your location.\n"
                            . "You must either be in the root or the application folder"
                            . " of a CodeIgniter project!";

            throw new RuntimeException($error_message);
        }

        // FIXME: Make this more generic
        // Get the config
        $config = parse_ini_file(BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . "{$args["command"]}.ini");

        // Add the location to the configuration array.
        $config["location"] = $location;

        // Merge the config and args arrays
        $args = array_merge($config, $args);

        // Merge the options and args arrays
        $args = array_merge($args, $options);

        // Example: new Generate()
        // Example: new NewCommand()
        $command_class = ApplicationHelpers::camelize($args['command']);

        // Remove the command from the array.
        unset($args["command"]);

        $klass = 'FIRE_' . $command_class;
        // Finally, call and run the command.
        $process = new $klass($args);
        return $process->run();
    }

    /**
     * Get help
     *
     * @param string $spec Name of the specific help text you want to get
     * @return string The help text
     * @author Aziz Light
     */
    public static function help($spec = "")
    {
        if ($spec == "")
        {
            $spec == "main";
        }

        return call_user_func("Help::" . $spec);
    }

    /**
     * Parse the args list retrieved from the command line
     *
     * @param array $args Argument list
     * @return array Parsed argument list
     * @access private
     * @author Aziz Light
     */
    private static function parse($args)
    {
        $parsed_args = array();

        // remove the script name from the commands list.
        array_shift($args);

        if (!empty($args) && in_array($args[0], self::$valid_tasks))
        {
            $parsed_args['command'] = $args[0];
            array_shift($args);
        }
        else if (!empty($args))
        {
            $args[0] = self::check_and_get_command_alias($args[0]);
            if (empty($args[0]))
            {
                throw new InvalidArgumentException("Invalid task", INVALID_TASK_EXCEPTION);
            }
            else
            {
                # FIXME: Try to remove the duplication here.
                # NOTE: This is a good case for a goto: :-{)
                $parsed_args['command'] = $args[0];
                array_shift($args);
            }
        }
        else
        {
            throw new InvalidArgumentException("Invalid task", INVALID_TASK_EXCEPTION);
        }

        if (!empty($args) && array_key_exists($parsed_args['command'], self::$valid_subjects) && in_array($args[0], self::$valid_subjects[$parsed_args['command']]))
        {
            $parsed_args['subject'] = $args[0];
            array_shift($args);
        }
        else if(self::has_subjects($parsed_args['command']))
        {
            if ($parsed_args['command'] !== 'migrate' && (empty($args) || !in_array($args[0], self::$valid_subjects[$parsed_args['command']])))
            {
                throw new InvalidArgumentException("Invalid subject", INVALID_SUBJECT_EXCEPTION);
            }
        }

        // The bootstrap command is the only one that is called without any additional args
        if (self::has_a_name($parsed_args['command']))
        {
            if (empty($args))
            {
                throw new InvalidArgumentException("Missing name", MISSING_NAME_EXCEPTION);
            }

            $unparsed_name = array_shift($args);

            // NOTE: I have to use this $tmp variable in order to avoid getting a "Stict Standards" notice by php
            $tmp = explode(DIRECTORY_SEPARATOR, $unparsed_name);
            $parsed_args['name'] = array_pop($tmp);
            $parsed_args['subdirectories'] = join(DIRECTORY_SEPARATOR, $tmp);

            if (Inflector::is_plural($parsed_args['name']) && $parsed_args['command'] === 'generate' && in_array($parsed_args['subject'], array('model', 'scaffold' ), TRUE))
            {
                $message = 'Fire thinks that your model name is plural.' . PHP_EOL;
                $message .= 'If that\'s the case then you\'re probably doing it wrong...' . PHP_EOL;
                $message .= 'Read the section on generating models or scaffolds in' . PHP_EOL;
                $message .= 'the README for more info on the subject.' . PHP_EOL . PHP_EOL;
                fwrite(STDOUT, $message);
            }

            if ($parsed_args['command'] != 'new_project')
            {
                $parsed_args['filename'] = ApplicationHelpers::underscorify($parsed_args['name']) . ".php";
            }
        }

        if (!empty($args))
        {
            if ($parsed_args['command'] === 'generate')
            {
                if (in_array($parsed_args['subject'], array('model', 'migration', 'scaffold')))
                {
                    $parsed_args['extra'] = self::parse_table_columns($args);
                }
                else
                {
                    $parsed_args['extra'] = $args;
                }
            }
            else
            {
                throw new InvalidArgumentException('Too many arguments');
            }
        }

        return $parsed_args;
    }

    /**
     * Check if the given alias is valid.
     * If it is, return the corresponding command,
     * otherwise return an empty string.
     *
     * @param string $alias An alias
     * @return string The corresponding command
     * @access private
     * @author Aziz Light
     */
    private static function check_and_get_command_alias($alias)
    {
        return (array_key_exists($alias, self::$valid_aliases)) ? self::$valid_aliases[$alias] : "";
    }

    /**
     * Checks if a commands has subjects
     *
     * @param string $command The command
     * @return bool Wheter or not the command has subjects
     * @access private
     * @author Aziz Light
     */
    private static function has_subjects($command)
    {
        return !in_array($command, self::$commands_with_no_subjects);
    }

    /**
     * Check if a command needs to take a name or not
     *
     * @access private
     * @param string $command The command
     * @return bool Wether or not the command has a name
     * @author Aziz Light
     */
    private static function has_a_name($command)
    {
        return !in_array($command, self::$commands_with_no_name);
    }

    /**
     * Parse the table columns and set their attributes
     *
     * @access private
     * @param array $columns The list of table columns
     * @return array The table columns with their attributes
     * @author Aziz Light
     **/
    private static function parse_table_columns(array $columns)
    {
        $parsed_columns = array();

        foreach ($columns as $column)
        {
            $c = explode(':', $column);

            if (sizeof($c) != 2)
            {
                throw new RuntimeException('You did not specify the type of the ' . $c[0] . ' column');
            }
            else if (!in_array($c[1], self::$valid_column_types))
            {
                throw new InvalidArgumentException('You geve an invalid type to the ' . $c[0] . ' column');
            }

            $parsed_columns[$c[0]] = self::generate_column_attributes($c[1]);
        }

        return $parsed_columns;
    }

    /**
     * Generate the default attributes for a specified column type
     *
     * @access private
     * @param string $type The type of the column
     * @return array The default attributes for the specified column type
     * @author Aziz Light
     **/
    private static function generate_column_attributes($type)
    {
        $attributes = array();

        switch ($type)
        {
            case 'string':
            case 'varchar':
                $attributes['type'] = 'VARCHAR';
                $attributes['constraint'] = 255;
                $attributes['null'] = FALSE;
                break;
            case 'text':
                $attributes['type'] = 'TEXT';
                break;
            case 'int':
            case 'integer':
                $attributes['type'] = 'INT';
                $attributes['unsigned'] = TRUE;
                $attributes['null'] = FALSE;
                break;
            case 'decimal':
                $attributes['type'] = 'DECIMAL';
                $attributes['unsigned'] = TRUE;
                $attributes['null'] = FALSE;
                break;
            case 'date':
                $attributes['type'] = 'DATE';
                break;
            case 'datetime':
                $attributes['type'] = 'DATETIME';
                break;
            case 'char':
                $attributes['type'] = 'CHAR';
                break;
            case 'bool':
            case 'boolean':
                $attributes['type'] = 'TINYINT';
                $attributes['unsigned'] = TRUE;
                $attributes['null'] = FALSE;
                break;
        }

        return $attributes;
    }

    /**
     * Parse the options in the $args array
     * and get their value. Also remove the options
     * and their value from the $args array
     *
     * @access private
     * @params array $args The array of args
     * @return array The options and their value
     * @author Aziz Light
     **/
    private static function parse_options(array &$args)
    {
        $options = array();

        foreach ($args as $index => $arg)
        {
            if (in_array(substr($arg, 2), self::$valid_options))
            {
                if (isset($args[$index + 1]))
                {
                    $options[str_replace('-', '_', substr($arg, 2))] = $args[$index + 1];
                    array_splice($args, $index, 2);
                }
                else
                {
                    throw new InvalidArgumentException('You passed the ' . $arg . ' option but did\'t give it a value');
                }
            }
        }

        return $options;
    }
}
