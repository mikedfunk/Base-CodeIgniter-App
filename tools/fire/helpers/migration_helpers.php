<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

class MigrationHelpers
{
    private function __construct() {}

    /**
     * Get the number of the migration from the migration.php config file
     *
     * @access public
     * @param string $application_folder The path to the application folder
     * @return int The migration number
     * @author Aziz Light
     **/
    public static function get_migration_number_from_config_file($application_folder)
    {
        $config_file = $application_folder . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'migration.php';
        if (is_file($config_file))
        {
            $config_file_contents = file_get_contents($config_file);
            preg_match('/\$config\[\'migration_version\'\] = (?P<migration_number>\d+);/', $config_file_contents, $matches);
            return intval($matches['migration_number']);
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Get the latest migration number by looking at the migration files
     *
     * @access public
     * @param string $application_folder The path to the application folder
     * @return int The migration number
     * @author Aziz Light
     **/
    public static function get_latest_migration_number($application_folder)
    {
        $migrations = glob($application_folder . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . '*.php');
        $tmp = end($migrations);
        $tmp = explode(DIRECTORY_SEPARATOR, $tmp);
        $migration = end($tmp);
        $migration_number = intval($migration);

        return $migration_number;
    }

    /**
     * Get the number of the migration by looking at the existing migrations
     * and incrementing the number of the last migration
     * Used to set the name of a new migration file
     *
     * @access public
     * @return string The number of the migration number in the format 001
     * @author Aziz Light
     **/
    public static function get_migration_number($application_folder)
    {
        $migration_number = self::get_latest_migration_number($application_folder);
        $migration_number++;

        if ($migration_number < 10)
        {
            $migration_number = '00' . $migration_number;
        }
        else if ($migration_number < 100)
        {
            $migration_number = '0' . $migration_number;
        }
        else
        {
            $migration_number = strval($migration_number);
        }

        return $migration_number;
    }

    /**
     * This method is used in the process of verifying if a migration
     * already exists.
     *
     * @access public
     * @param string $migration_number A migration number in the form 001
     * @return string Decremented migration number
     * @author Aziz Light
     **/
    public static function decrement_migration_number($migration_number)
    {
        $migration_number = intval($migration_number);
        $migration_number--;

        if ($migration_number < 10)
        {
            $migration_number = '00' . $migration_number;
        }
        else if ($migration_number < 100)
        {
            $migration_number = '0' . $migration_number;
        }
        else
        {
            $migration_number = strval($migration_number);
        }

        return $migration_number;
    }

    /**
     * This method adds the migration number to the config file
     *
     * @access public
     * @param string $migration_number The number of the migration in the form 001
     * @return bool Wether or not the migration number was added to the config file
     * @author Aziz Light
     **/
    public static function add_migration_number_to_config_file($application_folder, $migration_number)
    {
        $config_file = $application_folder . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'migration.php';
        if (is_file($config_file))
        {
            $config_file_contents = file_get_contents($config_file);
            $config_file_contents = preg_replace('/\$config\[\'migration_version\'\] = \d+;/', '$config[\'migration_version\'] = ' . intval($migration_number) . ';', $config_file_contents);

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
}
