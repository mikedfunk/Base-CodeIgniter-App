<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

/**
* Help class
*/
class Help
{
    /**
     * The directory where all the help files are.
     */
    const HELP_DIR = "help";

    // Prevent from instantiating the class.
    public function __construct()
    {
        throw new RuntimeException('The Help class can not be instantiated');
    }

    public static function main()
    {
        // FIXME: Get the contents of the file properly!
        return file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . self::HELP_DIR . '/main.txt');
    }
}
