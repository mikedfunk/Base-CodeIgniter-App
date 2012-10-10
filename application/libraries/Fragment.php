<?php

class Fragment
{
	protected $key = '';
	protected $fragment = '';

	protected $fresh = FALSE;
	
	protected $expire = 3600;

	public function __construct()
	{
		$this->ci =& get_instance();
	}

	public function start_cache($expire = 3600)
	{
		$backtrace = debug_backtrace();
		$this->key = sha1($this->ci->uri->uri_string . $backtrace[0]['line']);

		$this->expire = $expire;

		if ($fragment = $this->ci->cache->memcached->get('fragments.' . $this->key))
		{
			$this->fragment = $fragment;

			return FALSE;
		}
		else
		{
			$this->fresh = TRUE;
			ob_start();

			return TRUE;
		}
	}

	public function end_cache()
	{
		if ($this->fresh)
		{
			$output = ob_get_contents();
			ob_end_clean();

			$this->ci->memcached->save($this->key, $output, $this->expire);
		}
		else
		{
	        ob_end_clean();
			$output = $this->fragment;
		}

		$this->fresh = FALSE;
		$this->key = '';
		$this->fragment = '';

		echo $output;
	}

	public function cache($fragment, $expire = 3600)
	{
		if ($this->start_cache($expire))
		{
        	$fragment();
    	}

		$this->end_cache();
	}
}