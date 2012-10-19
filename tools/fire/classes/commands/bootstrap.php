<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

require_once BASE_PATH . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'github_helpers.php';

/**
 * Bootstrap Command
 */
class FIRE_Bootstrap extends BaseCommand
{
    /**
     * El Constructor!
     *
     * @access public
     * @param array $args Parsed command line arguments
     * @author Aziz Light
     */
    public function __construct(array $args)
    {
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
        $codeigniter_sample_project_path = BASE_PATH . DIRECTORY_SEPARATOR . 'codeigniter';
        if (is_dir($codeigniter_sample_project_path))
        {
            ApplicationHelpers::delete_dir($codeigniter_sample_project_path);
        }

        fwrite(STDOUT, 'Bootstrapping Fire...' . PHP_EOL);
        if (GithubHelpers::git_clone($this->get_github_repo_link(), $codeigniter_sample_project_path) === FALSE)
        {
            throw new RuntimeException("Unable to clone the sample CodeIgniter project from Github");
        }
        else
        {
            if (php_uname("s") === "Windows NT")
            {
                $message = "\tFire Bootstrapped" . PHP_EOL;
            }
            else
            {
                $message = "\t" . ApplicationHelpers::colorize('Fire', 'green') . '  Bootstrapped' . PHP_EOL;
            }

            fwrite(STDOUT, $message);
        }
    }

    /**
     * Get the github repo from the new_project config file
     * and turn it into a link
     *
     * @access private
     * @return string The Github repo link
     * @author Aziz Light
     */
    private function get_github_repo_link()
    {
        $config = parse_ini_file(BASE_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'new_project.ini');
        return 'git://github.com/' . $config['github_repo'] . '.git';
    }
}
