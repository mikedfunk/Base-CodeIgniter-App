<?php if (!defined('BASE_PATH')) exit('No direct script access allowed');

/**
 * Template Scanner
 **/
class TemplateScanner
{
    /**
     * The name of the template to scan.
     *
     * @var string
     * @access private
     */
    private $template_name;

    /**
     * The name of the class being generated.
     *
     * @var string
     * @access private
     */
    private $class_name;

    /**
     * The folder where the views will be saved
     *
     * @access private
     * @var string
     */
    private $view_folder;

    /**
     * The name of the table to migrate.
     * Used with migrations only.
     *
     * @access private
     * @var string
     */
    private $table_name;

    /**
     * The name of the class that will extend the generated class.
     * Example: CI_Controller
     *
     * @var string
     * @access private
     */
    private $parent_class;

    /**
     * The extra stuff that will be generated like actions and methods.
     *
     * @var string
     * @access private
     */
    private $extra;

    /**
     * The name of the php file that will be generated.
     *
     * @var string
     * @access private
     */
    private $filename;

    /**
     * The application folder. By default: "application".
     *
     * @var string
     * @access private
     */
    private $application_folder;

    /**
     * Relative location to the templated file
     *
     * @access private
     * @var string
     */
    private $relative_location;

    /**
     * Name of the helper associated with the controller
     *
     * @access private
     * @var string
     */
    private $helper_name;

    /**
     * The constructor.
     *
     * @param string $template_name The template name without the extension.
     * @param array  $args All the extra info needed to genereate the files.
     * @access public
     * @return void
     * @author Aziz Light
     */
    public function __construct($template_name = "", array $args = array())
    {
        $this->template_name = $template_name;
        $this->set_attributes($args);
    }

    public function parse()
    {
        $template = $this->get_template();
        if ($template)
        {
            $patterns = array(
              "/{{class_name}}/",
              "/{{parent_class}}/",
              "/{{view_folder}}/",
              "/{{extra}}/",
              "/{{filename}}/",
              "/{{table_name}}/",
              "/{{application_folder}}/",
              "/{{relative_location}}/",
              "/{{helper_name}}/"
            );

            $replacements = array(
              $this->class_name,
              $this->parent_class,
              $this->view_folder,
              $this->extra,
              $this->filename,
              $this->table_name,
              $this->application_folder,
              $this->relative_location,
              $this->helper_name
            );
            return preg_replace($patterns, $replacements, $template);
        }
    }

    /**
     * Get the contents of the template
     *
     * @access private
     * @return bool|string
     * @author Aziz Light
     */
    private function get_template()
    {
        $path = BASE_PATH . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $this->template_name . '.php';
        if (file_exists($path))
        {
            return file_get_contents($path);
        }
        else
        {
            return false;
        }
    }

    /**
     * Set the template attributes as properties.
     *
     * @param array $args : Array of attributes passed to the constructor.
     * @access private
     * @return void
     * @author Aziz Light
     */
    private function set_attributes(array $args)
    {
        if ($this->template_name == 'migration_column')
        {
            $this->set_migration_column_attributes($args);
        }
        else
        {
            $valid_attributes = array(
                "class_name"         => 'My' . ucfirst($this->template_name),
                "parent_class"       => 'CI_' . ucfirst($this->template_name),
                "extra"              => "",
                "filename"           => 'my_' . $this->template_name . '.php',
                "table_name"         => "my_table",
                "application_folder" => "application",
                'view_folder'        => strtolower($this->template_name),
                'relative_location'  => 'application' . DIRECTORY_SEPARATOR . 'my_' . $this->template_name . '.php',
                'helper_name'        => 'my_helper',
            );

            foreach ($valid_attributes as $valid_attribute => $default_value)
            {
                if (array_key_exists($valid_attribute, $args))
                {
                    $this->$valid_attribute = $args[$valid_attribute];
                }
                else
                {
                    $this->$valid_attribute = $default_value;
                }
            }
        }

        return;
    }

    /**
     * Set the attributes of the migration
     *
     * @access private
     * @param array $args Migration column attibutes
     * @return void
     * @author Aziz Light
     **/
    private function set_migration_column_attributes(array $args)
    {
        $extra = "\t\t\t'" . $args['column_name'] . '\' => array(' . PHP_EOL;
        unset($args['column_name']);

        foreach ($args as $attr => $value)
        {
            $extra .= "\t\t\t\t'" . substr($attr, 7) . "' => ";

            if (is_int($value) || is_real($value))
            {
                $extra .= $value;
            }
            else if (is_bool($value))
            {
                $extra .= ($value) ? 'TRUE' : 'FALSE';
            }
            else
            {
                $extra .= "'" . $value . "'";
            }

            $extra .= ',' . PHP_EOL;
        }

        $extra .= "\t\t\t)," . PHP_EOL;

        $this->extra = $extra;

        return;
    }

}
