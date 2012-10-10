<?php

class API_Router extends CI_Controller
{
	public function index()
	{
        $args = func_get_args();
        $version = $args[0];
        $i = ($version) ? 1 : 0;
        
        $controller = $args[$i + 1];
        $action = $args[$i + 2];

        $this->router->directory = 'api/' . $version . '/';
        $this->router->class = $controller;
        $this->router->method = $action;

        $parameters = array_slice($this->uri->rsegments, $i + 5);
        
        if ($parameters && strpos($parameters[count($parameters) - 1], '.'))
        {
        	$arr = explode('.', $parameters[count($parameters) - 1], 2);
        	$parameters[count($parameters) - 1] = $arr[0];
        }

        if (!$version && strpos($_SERVER['HTTP_ACCEPT'], 'version=') !== FALSE)
        {
        	$arr = explode(';', $_SERVER['HTTP_ACCEPT']);
        	$arr = explode('=', trim($arr[1]));
        	$version = $arr[1];
        }
        
        $controller_path = APPPATH . 'controllers/api/' . $version . '/' . $controller . '.php';
        
		if (file_exists($controller_path))
		{
			require_once $controller_path;
			$controller = new $controller();
		}
		else
		{
			header('HTTP/1.1 406 Not Acceptable');
			header('Status: 406 Not Acceptable');

			exit;
		}

        define('API_VERSION', $version);
        
        if (method_exists($controller, '_remap'))
        {
            $controller->_remap($action, $parameters);
        }
        else
        {
            if (method_exists($controller, $action))
            {
                call_user_func_array(array($controller, $action), $parameters);
            }
            else
            {
                show_404();
            }
        }
	}
}