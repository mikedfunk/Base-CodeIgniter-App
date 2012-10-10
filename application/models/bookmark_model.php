<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * makes calls to the api. based on his phpunit tests.
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file bookmark_model.php
 */

class bookmark_model extends MY_Model
{
	// --------------------------------------------------------------------------
	
	/**
	 * validation in the model with MY_Model
	 * 
	 * @var array
	 * @access public
	 */
	public $validate = array(
		array(
			'field' => 'url',
			'label' => 'URL',
			'rules' => 'required|callback__url_check'
		),
		array(
			'field' => 'description',
			'label' => 'Description',
			'rules' => 'required'
		)
	);
	
	// --------------------------------------------------------------------------
	
	// observers
	public $before_create = array('created_at', 'updated_at');
	public $before_update = array('created_at', 'updated_at');
	public $after_create = array('create_cleanup');
	public $after_update = array('update_cleanup');
	
	// --------------------------------------------------------------------------
	
	/**
	 * load config.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->config->load('bookymark_api');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * delete db caches after create.
	 * 
	 * @access public
	 * @return void
	 */
	public function create_cleanup()
	{
		$this->db->cache_delete('bookmarks');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * delete db caches after update.
	 * 
	 * @access public
	 * @return void
	 */
	public function update_cleanup()
	{
		$this->db->cache_delete('bookmarks');
		$this->db->cache_delete('bookmarks', 'edit');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * use the API for get_all.
	 * 
	 * @access public
	 * @return object the result().
	 */
	public function get_all()
	{
		// trigger events, get all results via API, return results
		$this->trigger('before_get');
		
		// if soft delete is set, don't return "deleted" rows
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $where[] = $this->soft_delete_key;
            $where[] = false;
        }
		
		$return = $this->request('GET', 'bookmarks');
		foreach ($return as &$row)
        {
            $row = $this->trigger('after_get', $row);
        }
        return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * use the API for get.
	 * 
	 * @access public
	 * @param int $primary_value the bookmark id.
	 * @return object a row() _not_ result().
	 */
	public function get($primary_value)
	{
		$this->trigger('before_get');
		$where = array($this->primary_key, $primary_value);
		
		// if soft delete is set, don't return "deleted" rows
        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $where[] = $this->soft_delete_key;
            $where[] = false;
        }

        // request via api
        $end = implode('/', $where);
        $row = $this->request('GET', 'bookmarks/'.$end);
        
        // either return the row or an empty object
        $row = (array)$row;
        if (isset($row[0])) {
        	$row = (object)$row[0];
        }
        else
        {
	        $row = (object)$row;
        }
        $row = $this->trigger('after_get', $row);

        return $row;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * use the API for get_many_by.
	 * 
	 * @access public
	 * @return object
	 */
	public function get_many_by()
	{
		$this->trigger('before_get');
		$where = func_get_args();
		
		// if soft delete is set, return without "deleted" rows
		if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE)
        {
            $where[] = $this->soft_delete_key;
            $where[] = false;
        }
		
		// request via API, trigger after_get, return
		$end = implode('/', $where);
		$return = $this->request('GET', 'bookmarks/'.$end);
		foreach ($return as &$row)
        {
            $row = $this->trigger('after_get', $row);
        }
        return $return;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Use the API to insert data.
	 * 
	 * @access public
	 * @param array $data
	 * @param bool $skip_validation (default: FALSE)
	 * @return mixed either the insert_id or false.
	 */
	public function insert($data, $skip_validation = FALSE)
	{
		// whether to run validation
		$valid = TRUE;

        if ($skip_validation === FALSE)
        {
            $valid = $this->_run_validation($data);
        }

        if ($valid)
        {
        	// trigger before and after, request via API, return insert_id
            $data = $this->trigger('before_create', $data);

            $return = $this->request('POST', 'bookmarks', $data);
            $insert_id = $return->id;

            $this->trigger('after_create', $insert_id);
            
            return $insert_id;
        } 
        else
        {
            return FALSE;
        }
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * use the api to delete a bookmark, return success or fail.
	 * 
	 * @access public
	 * @param int $id
	 * @return bool
	 */
	public function delete($id)
    {
        $this->trigger('before_delete', $id);

        $this->db->where($this->primary_key, $id);

        if ($this->soft_delete)
        {
        	// if soft delete, update instead of delete
        	$data = array($this->soft_delete_key, true);
			$result = $this->request('PUT', 'bookmarks/'.$id, $data);
        }
        else
        {
        	// else delete via api
        	$result = $this->request('DELETE', 'bookmarks/'.$id);
        	$result = $result->success;
        }

        $this->trigger('after_delete', $result);

        return $result;
    }
    
    // --------------------------------------------------------------------------
    
    /**
     * Updated a record based on the primary value.
     */
    public function update($primary_value, $data, $skip_validation = FALSE)
    {
    	// whether to run validation, trigger events
    	$valid = TRUE;

        $data = $this->trigger('before_update', $data);

        if ($skip_validation === FALSE)
        {
            $valid = $this->_run_validation($data);
        }

        if ($valid)
        {
        	// edit via API, return success bool
            $result = $this->request('PUT', 'bookmarks/'.$primary_value, $data);
            $result = $result->success;
            $this->trigger('after_update', array($data, $result));

            return $result;
        }
        else
        {
            return FALSE;
        }
    }
	
	// --------------------------------------------------------------------------
	
	/**
	 * Make a cURL request, with params, to the API.
	 * 
	 * @access public
	 * @param string $method such as GET
	 * @param string $path such as api/v2/bookmarks
	 * @param array $params (default: array()) the get/put/post params
	 * @return array
	 */
	public function request($method, $path, $params = array())
	{	
		// set curl handler and options
		$path = 'api/v1/' . $path;
		$curl = curl_init(config_item('api_base_url') . $path);
		
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		// set required headers
		$headers = array();
		$headers[] = 'User-Agent: Bookymark Application';
		$headers[] = 'Accept: application/json; version=v1';
		$headers[] = 'X-Access-Token: ' . config_item('api_access_token');

		$timestamp = time();
		$headers[] = 'X-Request-Timestamp: ' . $timestamp;

		// build signature and set header
		$hash = $path . http_build_query($params);
		$hash .= $timestamp . config_item('api_shared_secret');
		$signature = sha1($hash);
		$headers[] = 'X-Request-Signature: ' . $signature;

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		// execute and return
		$result = curl_exec($curl);
		
		return (object)json_decode($result);
	}
	
	// --------------------------------------------------------------------------
}
/* End of file bookmark_model.php */
/* Location: ./application/models/bookmark_model.php */