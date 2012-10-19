<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

/**
 * The web command: used to install WebFire
 */
class FIRE_WebFire extends BaseCommand
{
    /**
     * Location of the application folder
     *
     * @ccess private
     * @var string
     **/
    private $location;

    /**
     * The subject
     *
     * @access private
     * @var string
     **/
    private $subject;

    /**
     * List of WebFire directories to create
     *
     * @access private
     * @var array
     **/
    private $directories = array(
        'controllers/fire',
        'helpers/fire',
        'models/fire',
        'views/fire/generate',
        'views/fire/templates'
    );

    /**
     * List of WebFire's files, excluding the assets
     *
     * @access private
     * @var array
     **/
    private $files = array(
        'controllers/fire/generate.php',
        'helpers/fire/generate_helper.php',
        'models/fire/generate_model.php',
        'models/fire/template_scanner.php',
        'views/fire/layout.php',
        'views/fire/generate/controller_form.php',
        'views/fire/generate/controller_success.php',
        'views/fire/generate/index.php',
        'views/fire/generate/migration_form.php',
        'views/fire/generate/migration_success.php',
        'views/fire/generate/model_form.php',
        'views/fire/generate/model_success.php',
        'views/fire/templates/action.tpl',
        'views/fire/templates/controller.tpl',
        'views/fire/templates/empty_migration.tpl',
        'views/fire/templates/migration.tpl',
        'views/fire/templates/migration_column.tpl',
        'views/fire/templates/model.tpl',
    );

    /**
     * List of WebFire's assets
     *
     * @access private
     * @var array
     **/
    private $assets = array(
        'assets/css/fire.css',
        'assets/img/webfire.png',
        'assets/js/fire.js',
    );

    /**
     * El Constructor!
     *
     * @access public
     * @param array $params The parsed command line arguments
     * @return void
     * @author Aziz Light
     **/
    public function __construct(array $params)
    {
        $this->location = $params['location'];
        $this->subject = $params['subject'];
    }

    /**
     * The brains of the command
     *
     * @access public
     * @return void
     * @author Aziz Light
     **/
    public function run()
    {
        $subject = $this->subject;
        $this->$subject();
        return;
    }

    /**
     * Installs WebFire
     *
     * @access private
     * @return void
     * @author Aziz Light
     **/
    private function install()
    {
        if ($this->is_webfire_installed())
        {
            throw new RuntimeException('WebFire seems to be installed already!');
        }

        if (!$this->create_directories())
        {
            throw new RuntimeException('Unable to create WebFire directories');
        }

        $application_folder = explode(DIRECTORY_SEPARATOR, $this->location);
        $application_folder = array_pop($application_folder);

        foreach ($this->files as $file)
        {
            $source = BASE_PATH . DIRECTORY_SEPARATOR . 'WebFire' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . $file;
            $destination = $this->location . DIRECTORY_SEPARATOR . $file;
            $relative_location = $application_folder . DIRECTORY_SEPARATOR . $file;
            $subject = '';
            $message = '';
            if (preg_match('/templates/', $file) === 1)
            {
                $subject = 'template';
            }
            else
            {
                $subject = explode('/', $file);
                $subject = array_shift($subject);
                $subject = rtrim($subject, 's');
            }

            if (copy($source, $destination))
            {

                $message = "\tCreated {$subject}: ";
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'green');
                }
                $message .= $relative_location;
            }
            else
            {
                $message = "\tFailed to create {$subject}: ";
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'red');
                }
                $message .= $relative_location;
            }

            fwrite(STDOUT, $message . PHP_EOL);

            unset($source, $destination, $relative_location, $subject);
        }

        foreach ($this->assets as $asset)
        {
            $source = BASE_PATH . DIRECTORY_SEPARATOR . 'WebFire' . DIRECTORY_SEPARATOR . $asset;
            $location = explode(DIRECTORY_SEPARATOR, $this->location);
            array_pop($location);
            $location = join(DIRECTORY_SEPARATOR, $location);
            $destination = $location . DIRECTORY_SEPARATOR . $asset;
            $subject = '';
            $message = '';
            if (copy($source, $destination))
            {
                $message = "\tCreated asset: ";
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'green');
                }
                $message .= $asset;
            }
            else
            {
                $message = "\tFailed to create asset: ";
                if (php_uname("s") !== "Windows NT")
                {
                    $message  = ApplicationHelpers::colorize($message, 'red');
                }
                $message .= $asset;
            }

            fwrite(STDOUT, $message . PHP_EOL);

            unset($source, $location, $destination, $subject, $message);
        }
    }

    /**
     * Checks if WebFire is installed
     *
     * @access private
     * @return bool Whether or not WebFire is installed
     * @author Aziz Light
     **/
    private function is_webfire_installed()
    {
        $result = TRUE;
        foreach ($this->files as $file)
        {
            $result = $result && is_file($this->location . DIRECTORY_SEPARATOR . $file);
        }

        foreach ($this->assets as $asset)
        {
            // NOTE: fire assumes that the index.php file is on the same level as the application folder
            $result = $result && is_file(realpath($this->location . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $asset));
        }

        return $result;
    }

    /**
     * Creates Webfire directories if they don't exist
     *
     * @access private
     * @return bool Whether or not the WebFire directories were created
     * @author Aziz Light
     **/
    private function create_directories()
    {
        $result = TRUE;
        foreach ($this->directories as $dir)
        {
            if (!is_dir($this->location . DIRECTORY_SEPARATOR . $dir))
            {
                $result = $result && mkdir($this->location . DIRECTORY_SEPARATOR . $dir, 0755, TRUE);
            }
        }

        $assets_directories = array(
            'assets/css',
            'assets/img',
            'assets/js',
        );

        foreach ($assets_directories as $dir)
        {
            if (!is_dir(realpath($this->location . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $dir)))
            {
                $result = $result && mkdir($this->location . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $dir, 0755, TRUE);
            }
        }

        return $result;
    }
}
