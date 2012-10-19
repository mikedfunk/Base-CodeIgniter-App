<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

/**
 * Github Helpers
 */
class GithubHelpers
{
    private function __construct() {}

    /**
     * Clone the Codeigniter repository
     *
     * @access public
     * @param string $repo The git repository url
     * @param string $location The location where the git repo will be cloned
     * @param string $tag_or_branch A tag or branch in the git repo to be checked out
     * @return boolean TRUE/FALSE depending on wheter the repo was cloned or not
     * @author Aziz Light
     */
    public static function git_clone($repo, $location, $tag_or_branch = "")
    {
        if (php_uname('s') === "Windows NT")
        {
            $command = 'git clone ' . $repo . ' "' . $location . '" > NUL && echo CLONED || echo ERROR';
        }
        else
        {
            $command = 'git clone ' . $repo . ' ' . $location . ' > /dev/null 2>&1 && echo "CLONED" || echo "ERROR"';
        }

        exec($command, $output);
        if ($output[0] === "CLONED")
        {
            if (!empty($tag_or_branch))
            {
                unset($command);

                if (php_uname('s') === "Windows NT")
                {
                    $command = 'git checkout ' . $tag_or_branch . ' > NUL && echo CHECKEDOUT || echo ERROR';
                }
                else
                {
                    $command = 'git checkout ' . $tag_or_branch . ' > /dev/null 2>&1 && echo "CHECKEDOUT" || echo "ERROR"';
                }

                exec($command, $output);
                if ($output[0] === "ERROR")
                {
                    ApplicationHelpers::delete_dir($location);
                    return FALSE;
                }
            }

            // delete the .git directory
            ApplicationHelpers::delete_dir($location . DIRECTORY_SEPARATOR . '.git');
            return TRUE;
        }
        else if ($output[0] == "ERROR")
        {
            return FALSE;
        }
    }
}
