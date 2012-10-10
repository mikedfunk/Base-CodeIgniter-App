<?php

/*
 * This is NOT Phil Sturgeon's REST_Controller, it's Jamie Rumbelow's from the
 * CodeIgniter Handbook vol. 2.
 *
 * @link https://github.com/efendibooks/codeigniter-handbook-vol-2/blob/master/application/core/MY_Controller.php
 */

require_once(APPPATH.'libraries/api/exceptions.php');

class REST_Controller extends CI_Controller
{
	public $params = array();
	public $formats = array(
		'json' => 'application/json',
		'php' => 'application/php'
	);

	public $status_code = 200;
	public $response_format = FALSE;
	public $data = array();

	protected $client = FALSE;

	const LIMIT = 9999;
	const LIMIT_TIME = 3600;

	public function __construct()
	{
		parent::__construct();

		get_instance()->load->helper('url');
		$this->_detect_method();
		$this->_detect_response_type();
	}

	public function _remap($method, $params = array())
	{
		try
		{
			$this->authenticate();
			$this->throttle();
			$this->options();

			call_user_func_array(array($this, $method), $params);

			$formatted_data = $this->format($this->data);
			$this->respond($formatted_data);
		}
		catch (API\Exceptions\Exception $e)
		{
			$formatted_data = $this->format(array(
				'error' => TRUE,
				'type' => join('', array_slice(explode('\\', get_class($e)), -1)),
				'message' => $e->getMessage()
			));

			$this->status_code = $e->getCode();
			$this->respond($formatted_data);
		}
	}

	protected function respond($data = '')
	{
		$this->output->set_status_header($this->status_code);
		echo $data;

		exit;
	}

	protected function _detect_method()
	{
		$method = strtoupper($_SERVER['REQUEST_METHOD']);

		if ($method == 'GET')
		{
			$this->params = $_GET;
		}
		elseif ($method == 'POST')
		{
			$this->params = $_POST;
		}
		else
		{
			parse_str(file_get_contents('php://input'), $this->params);
		}
	}

	protected function _detect_response_type()
	{
		$content_type = FALSE;

		if (strpos($this->uri->uri_string, '.') > 0)
		{
			$content_type_arr = explode('.', $this->uri->uri_string);
			$content_type = $content_type_arr[count($content_type_arr) - 1];
		}
		else
		{
			$header_type = explode(';', $_SERVER['HTTP_ACCEPT']);
			$header_type = $header_type[0];

			if ($key = array_search($header_type, $this->formats))
			{
				$content_type = $key;
			}
		}

		if (!in_array($content_type, array_keys($this->formats)))
		{
			$this->status_code = 406;
			$this->respond();
		}
		else
		{
			header('Content-Type: ' . $this->formats[$content_type]);
			$this->response_format = $content_type;
		}
	}

	protected function authenticate()
	{
		$this->load->model('api_client_model', 'api_client');

		$token = @$_SERVER['HTTP_X_ACCESS_TOKEN'];
		$signature = @$_SERVER['HTTP_X_REQUEST_SIGNATURE'];
		$timestamp = @$_SERVER['HTTP_X_REQUEST_TIMESTAMP'];

		$this->client = $this->api_client->get_by('access_token', $token);

		if (!$this->client)
		{
			throw new API\Exceptions\Authentication();
		}
		else
		{
			$hash = $this->_calculate_signature($this->uri->uri_string, $timestamp);

			if ($signature !== $hash)
			{
				throw new API\Exceptions\Authentication_Signature();
			}
		}
	}

	protected function throttle()
	{
		$throttle_count = FALSE;
		$throttled_at = $this->client->throttled_at;

		if (strtotime($this->client->throttled_at) < time() - self::LIMIT_TIME)
		{
			$throttle_count = 1;
			$this->client->throttle_count = 1;
			$throttled_at = date('Y-m-d H:i:s');
		}

		if ($this->client->throttle_count > self::LIMIT)
		{
			$date = strtotime($this->client->throttled_at) + self::LIMIT_TIME;
			$date = date('Y-m-d H:i:s', $date);

			throw new API\Exceptions\Throttled($date);
		}
		else
		{
			$throttle_count = $this->client->throttle_count + 1;
		}

		if ($throttle_count !== FALSE)
		{
			$this->api_client->update_by('access_token', $this->client->access_token, array(
				'throttle_count' => $throttle_count,
				'throttled_at' => $throttled_at
			));
		}
	}

	protected function options()
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) == 'OPTIONS')
		{
			$manifest = include(APPPATH . 'config/api_manifest.php');

			foreach ($manifest as $route => $endpoint)
			{
				if (preg_match("#" . $route . "#", $this->uri->uri_string))
				{
					$formatted_data = $this->format($endpoint);

					$this->status_code = 200;
					$this->respond($formatted_data);
				}
			}
		}
	}

	protected function format($data)
	{
		// if (ENVIRONMENT == 'development')
		// {
		// 	$data = $this->add_debugging_info($data);
		// }

		$method = '_format_' . $this->response_format;
		return call_user_func_array(array($this, $method), array( $data ));
	}

	protected function _format_json($object) { return json_encode($object); }
	protected function _format_php($object) { return serialize($object); }

	protected function add_debugging_info($data)
	{
		$debugging_info = array(
			'request' => array(
				'ip_address'   => $this->input->ip_address(),
				'uri_string'   => $this->uri->uri_string,
				'controller'   => $this->router->class,
				'method' 	   => $this->router->method,
				'access_token' => @$_SERVER['HTTP_X_ACCESS_TOKEN'],
				'user_agent'   => $_SERVER['HTTP_USER_AGENT']
			),
			'server' => array(
				'elapsed_time' => $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end'),
				'memory_usage' => round(memory_get_usage()/1024/1024, 2).'MB',
				'total_queries' => $this->db->total_queries()
			)
		);

		$debugging_info['curl_guess'] = $this->_guess_curl_command();

		return array(
			'_debug' => $debugging_info,
			'result' => $data
		);
	}

	protected function _guess_curl_command()
	{
		$cmd = 'curl -X ' . strtoupper($_SERVER['REQUEST_METHOD']);
		$cmd .= ' -H \'Accept: ' . $this->formats[$this->response_format] . '; version=' . API_VERSION . '\'';

		$path = preg_replace('/^(v[0-9]+\/)?([a-zA-Z0-9\/_\-]+)(\.[a-zA-Z0-9]+)?$/', '$2', $this->uri->uri_string);

		$url = site_url($path);
		$url .= http_build_query($_GET);

		$timestamp = time();
		$signature = $this->_calculate_signature($path, $timestamp);

		$cmd .= ' -H \'X-Access-Token: ' . $this->client->access_token . '\'';
		$cmd .= ' -H \'X-Request-Timestamp: ' . $timestamp . '\'';
		$cmd .= ' -H \'X-Request-Signature: ' . $signature . '\'';

		if ($input = file_get_contents('php://input'))
		{
			$cmd .= ' -d \'' . urlencode($input) . '\'';
		}

		$cmd .= ' ' . $url;

		return $cmd;
	}

	protected function _calculate_signature($path, $timestamp)
	{
		// $hash = $path . http_build_query($_GET) . http_build_query($this->params);
		$hash = $path . http_build_query($this->params);
		$hash .= $timestamp . $this->client->shared_secret;

		return sha1($hash);
	}
}