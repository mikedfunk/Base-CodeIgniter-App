<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

require_once BASE_PATH . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'github_helpers.php';

/**
 * The new_project command
 */
class FIRE_NewProject extends BaseCommand
{
    /**
     * The name of the new project
     *
     * @access private
     * @var string
     */
    private $name;

    /**
     * The location where the new project will reside
     *
     * @access private
     * @var string
     */
    private $location;

    /**
     * The Github repo to clone from
     *
     * @access private
     * @var string
     */
    private $repo;

    /**
     * Wether or not to force the command to clone
     * from Github every single time
     *
     * @access private
     * @var boolean
     */
    private $force_clone;

    /**
     * Tag or branch to checkout before the git repo is deleted
     *
     * @access private
     * @var string
     * @author Aziz Light
     */
    private $tag_or_branch;

    /**
     * El Constructor!
     *
     * @access public
     * @param array $args Parsed command line arguments
     * @author Aziz Light
     **/
    public function __construct(array $args)
    {
        $this->name = $args['name'];
        // FIXME: This will not work if the user passes an absolute path
        $this->location = getcwd() . DIRECTORY_SEPARATOR . $args['name'];
        $this->force_clone = !empty($args['force_clone']);
        $this->tag_or_branch = (array_key_exists('tag_or_branch', $args)) ? $args['tag_or_branch'] : "";

        // If fire is not bootstrapped, then we need to get CodeIgniter from the Inter-Webs
        if (!$this->is_fire_bootstrapped() || $this->force_clone == TRUE)
        {
            $this->repo = 'git://github.com/' . $args['github_repo'] . '.git';

            // Check that git is installed
            exec('which git > /dev/null 2>&1 && echo "FOUND" || echo "NOT_FOUND"', $output);
            if ($output[0] === "NOT_FOUND")
            {
                throw new RuntimeException("Git is required to create a new CodeIgniter project");
            }
        }
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
        if ($this->is_fire_bootstrapped() && $this->force_clone === FALSE)
        {
            if ($this->copy_codeigniter_sample_project($this->location, BASE_PATH . DIRECTORY_SEPARATOR . 'codeigniter'))
            {
                if (php_uname("s") !== "Windows NT")
                {
                    $message = "\t" . ApplicationHelpers::colorize('CodeIgniter project created', 'green') . ' ' . $this->name . PHP_EOL;
                }
                else
                {
                    $message = "\tCodeIgniter project created " . $this->name . PHP_EOL;
                }
                fwrite(STDOUT, $message);
            }
            else
            {
                throw new RuntimeException("Unable to create a new CodeIgniter Project");
            }
        }
        else
        {
            fwrite(STDOUT, 'Cloning CodeIgniter...' . PHP_EOL);

            // First let's download CodeIgniter
            if (GithubHelpers::git_clone($this->repo, $this->location, $this->tag_or_branch) === FALSE)
            {
                throw new RuntimeException("Unable to clone CodeIgniter from Github");
            }
            else
            {
                if (php_uname("s") !== "Windows NT")
                {
                    $message = "\t" . ApplicationHelpers::colorize('CodeIgniter project created', 'green') . ' ' . $this->name . PHP_EOL;
                }
                else
                {
                    $message = "\tCodeIgniter project created " . $this->name . PHP_EOL;
                }
                fwrite(STDOUT, $message);
            }
        }
    }

    /**
     * Copy the CodeIgniter folder to create a new project.
     * It's a pain in the ass to transfer permissions when copying a file/folder
     * in php so here is what will happen:
     *     - All the files will have a permission of 644.
     *     - All the folders will have a permission of 755.
     *
     * I did not create this method, It's Sina Salek who left it as comment
     * on php.net {@link http://www.php.net/manual/en/function.copy.php#91256}
     * and then info ]t[ intalo [.] de modified
     * it {@link http://www.php.net/manual/en/function.copy.php#93953}
     *
     * @access private
     * @param string $dest : The destination folder.
     * @param string $source : The source file/folder.
     * @param string $folderPermission : The permission that will be given to all folders.
     * @param string $filePermission  : The permission that will be given to all files.
     * @return bool Whether or not the copying succeeded.
     * @author Sina Salek
     */
    private function copy_codeigniter_sample_project($dest = '', $source = self::codeigniter_path, $folderPermission = 0755, $filePermission = 0644)
    {
        $result = FALSE;

        if (is_file($source))
        {
            if (is_dir($dest))
            {
                if ($dest[strlen($dest) - 1] != '/')
                {
                    $__dest = $dest . '/';
                }

                $__dest .= basename($source);
            }
            else
            {
                $__dest = $dest;
            }

            $result = copy($source, $__dest);
            chmod($__dest, $filePermission);
        }
        elseif (is_dir($source))
        {
            if (!is_dir($dest))
            {
                mkdir($dest, $folderPermission);
                chmod($dest, $folderPermission);
            }

            if ($source[strlen($source) - 1] != '/')
            {
                $source = $source . '/';
            }

            if ($dest[strlen($dest) - 1] != '/')
            {
                $dest = $dest . '/';
            }

            $result = TRUE;
            $dirHandle = opendir($source);
            while ($file = readdir($dirHandle))
            {
                if ($file != '.' && $file != '..')
                {
                    $result = $this->copy_codeigniter_sample_project($dest . $file, $source . $file, $folderPermission, $filePermission);
                }
            }
            closedir($dirHandle);
        }
        else
        {
            $result = FALSE;
        }

        return $result;
    }

    /**
     * Check if Fire is bootstrapped or not
     *
     * @access private
     * return bool Wether or not Fire is bootstrapped
     * @author Aziz Light
     */
    private function is_fire_bootstrapped()
    {
        return is_dir(BASE_PATH . DIRECTORY_SEPARATOR . 'codeigniter');
    }
}
