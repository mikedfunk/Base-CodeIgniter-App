<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

/**
 * A folder scanner.
 *
 * @package Fire
 * @subpackage FolderScanner
 * @author Aziz Light
 * @link http://bitbucket.org/azizlight/fire
 * @link http://github.com/AzizLight/fire
 * @copyright Copyright (c) 2010, Aziz Light
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class FolderScanner
{
    /**
     * Get the current location. Returns the path of the current location
     * and the breadcrumbs trail to that location.
     *
     * @access public
     * @static
     * @return object
     * @author Aziz Light
     */
    public static function get_location()
    {
        $location = new stdClass();
        $location->path = getcwd();
        $location->dirs = explode(DIRECTORY_SEPARATOR, $location->path);
        $location->dirs[0] = DIRECTORY_SEPARATOR;

        return $location;
    } // End of get_location

    // ------------------------------------------------------------------------

    /**
     * List the files and folders that are in a given directory (by default the current location)
     *
     * @access public
     * @static
     * @param string $dir : The directory to scan.
     * @return array : The list of files and folders in an array.
     * @author Aziz Light
     */
    public static function ls($dir = '')
    {
        if (empty($dir))
            $dir = getcwd();

        $handle = opendir($dir);
        $folders = array();
        while (false !== ($f = readdir($handle)))
        {
            if ($f != '.' && $f != '..')
                $folders[] = $f;
        }
        closedir($handle);

        return $folders;
    } // End of ls

    // ------------------------------------------------------------------------

    /**
     * Check that the user is either in the root of a CodeIgniter project or in
     * the application folder of a CodeIgniter project and returns the path to the
     * application folder.
     *
     * @access public
     * @static
     * @return bool|string : Returns the path to the application folder or false if it wasn't found.
     * @author Aziz Light
     */
    public static function check_location($application_folder = 'application', $system_folder = 'system')
    {
        $location = self::get_location();

        if (!in_array($application_folder, $location->dirs))
        {
            $folders = self::ls();
            if (!in_array($application_folder, $folders))
            {
                if (!in_array($system_folder, $folders))
                    return false;

                $folders = self::ls($system_folder);
                if (!in_array($application_folder, $folders))
                    return false;

                return $location->path . DIRECTORY_SEPARATOR . $system_folder . DIRECTORY_SEPARATOR . $application_folder;
            }

            return $location->path . DIRECTORY_SEPARATOR . $application_folder;
        }

        return $location->path;
    } // End of check_location

    /**
     * Get the path to the system folder.
     * This is specifically relevent if fire
     * was called from the application folder.
     *
     * @access public
     * @return string The system path
     * @throws RuntimeException If the system folder is not found
     * @author Aziz Light
     **/
    public static function system_path($system_folder = 'system')
    {
        $system_path = '';
        $location = self::get_location();
        $folders = self::ls();

        if (in_array($system_folder, $folders))
        {
            $system_path .= $location->path . DIRECTORY_SEPARATOR . $system_folder . DIRECTORY_SEPARATOR;
        }
        else
        {
            $folders = self::ls('..');
            if (in_array($system_folder, $folders))
            {
                $system_path = realpath($location->path . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $system_folder) . DIRECTORY_SEPARATOR;
            }
            else
            {
                throw new RuntimeException('Unable to find the system folder...');
            }
        }

        return $system_path;
    }
} // End of FolderScanner

/* End of file folder_scanner.php */
