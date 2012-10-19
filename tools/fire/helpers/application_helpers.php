<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

/**
 * Application Helpers
 */
class ApplicationHelpers
{
    private function __construct() {}

    /**
     * Takes a CamelCased string and returns an underscore separated version.
     *
     * This is from FuelPHP, it is under the MIT License.
     *
     * @param   string  the CamelCased word
     * @param   bool    whether to strtolower the result
     * @return  string  an underscore separated version of $camel_cased_word
     *
     * @author     Dan Horrigan
     * @copyright  2011 Dan Horrigan
     * @license    MIT License
     */
    public static function underscorify($camel_cased_word, $lower = true)
    {
        if ($camel_cased_word === strtoupper($camel_cased_word) or $camel_cased_word === strtolower($camel_cased_word))
        {
            return $camel_cased_word;
        }
        $result = preg_replace('/([A-Z]+)([A-Z])/', '\1_\2', preg_replace('/([a-z\d])([A-Z])/', '\1_\2', strval($camel_cased_word)));
        return $lower ? strtolower($result) : $result;
    }

    /**
     * Takes a string that has words seperated by underscores and turns it into
     * a CamelCased string.
     *
     * @param   string  the underscored word
     * @return  string  the CamelCased version of $underscoredWord
     *
     * @license    MIT License
     * @copyright  2010 - 2012 Fuel Development Team
     */
    public static function camelize($underscoredWord)
    {
        return preg_replace('/(^|_)(.)/e', "strtoupper('\\2')", strval($underscoredWord));
    }

    /**
     * Add some bash colors to a string.
     *
     * @param string $string      The string that will be colorized.
     * @param string $color       Foreground color.
     * @param string $background  Background color.
     * @static
     * @access public
     * @return string The colorized string
     *
     * @copyright  2011 Arkadius Stefanski (MIT License)
     * @author     Arkadius Stefanski <arkste[at]gmail[dot]com>
     * @author     modified by Aziz Light
     * @license    MIT License
     */
    public static function colorize($string, $color = null, $background = null)
    {

        $colored_string = "";

        $_fg_color = array();
        $_bg_color = array();

        $_fg_color['black'        ] = '0;30';
        $_fg_color['dark_gray'    ] = '1;30';
        $_fg_color['blue'         ] = '0;34';
        $_fg_color['light_blue'   ] = '1;34';
        $_fg_color['green'        ] = '0;32';
        $_fg_color['light_green'  ] = '1;32';
        $_fg_color['cyan'         ] = '0;36';
        $_fg_color['light_cyan'   ] = '1;36';
        $_fg_color['red'          ] = '0;31';
        $_fg_color['light_red'    ] = '1;31';
        $_fg_color['purple'       ] = '0;35';
        $_fg_color['light_purple' ] = '1;35';
        $_fg_color['brown'        ] = '0;33';
        $_fg_color['yellow'       ] = '1;33';
        $_fg_color['light_gray'   ] = '0;37';
        $_fg_color['white'        ] = '1;37';

        $_bg_color['black'        ] = '40';
        $_bg_color['red'          ] = '41';
        $_bg_color['green'        ] = '42';
        $_bg_color['yellow'       ] = '43';
        $_bg_color['blue'         ] = '44';
        $_bg_color['magenta'      ] = '45';
        $_bg_color['cyan'         ] = '46';
        $_bg_color['light_gray'   ] = '47';

        if (isset($_fg_color[$color]))
        {
            $colored_string .= "\033[" . $_fg_color[$color] . "m";
        }

        if (isset($_bg_color[$background]))
        {
            $colored_string .= "\033[" . $_bg_color[$background] . "m";
        }

        $colored_string .= $string . "\033[0m";

        return $colored_string;
    }

    /**
     * Delete a directory and its contents
     *
     * @access private
     * @param string $dir The directory to delete
     * @return void
     * @author alcuadrado on StackOverflow
     * @link http://stackoverflow.com/questions/3349753/php-delete-directory-with-files-in-it#answer-3349792
     */
    public static function delete_dir($dir)
    {
        $it = new RecursiveDirectoryIterator($dir);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);

        // empty the directory
        foreach($files as $file)
        {
            if ($file->isDir())
            {
                rmdir($file->getRealPath());
            }
            else
            {
                // The chmod call here is to avoid Permission Denied errors in Windows
                chmod($file->getRealPath(), 0777);
                unlink($file->getRealPath());
            }
        }

        // delete the .git directory
        rmdir($dir);

        return;
    }
}

