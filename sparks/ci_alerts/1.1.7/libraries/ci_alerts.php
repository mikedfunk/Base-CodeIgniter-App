<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ci_alerts
 * 
 * Tools to alert and set/get flashdata from ci_alerts.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		ci_alerts.php
 * @version		1.1.7
 * @date		03/28/2012
 */

// --------------------------------------------------------------------------

/**
 * ci_alerts class.
 */
class ci_alerts
{
	// --------------------------------------------------------------------------
	
	/**
	 * _ci
	 *
	 * holds the codeigniter superobject.
	 * 
	 * @var mixed
	 * @access private
	 */
	private $_ci;
	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
		$this->_ci =& get_instance();
		$this->_ci->load->library('session');
		log_message('debug', 'CI Alerts: Library loaded.');
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * set function.
	 *
	 * adds an item to the specified flasydata array.
	 * 
	 * @access public
	 * @param string $type
	 * @param string $msg
	 * @return bool
	 */
	public function set($type, $msg)
	{
		// retrive the flashdata, add to the array, set it again
		$arr = $this->_ci->session->userdata($this->_ci->session->flashdata_key.':new:'.$type);
		if ($arr == FALSE || $arr == '') { $arr = array(); }
		
		// remove duplicates if configured to do so
		if (config_item('remove_duplicates')) { $arr = array_unique($arr); }
		
		$arr[] = $msg;
		$this->_ci->session->set_flashdata($type, $arr);
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * get function.
	 *
	 * gets all items or just items by the specified type as an array.
	 * 
	 * @access public
	 * @param string $type (default: '')
	 * @return array
	 */
	public function get($type = '')
	{
		// if it's all alerts
		if ($type == '')
		{
			$arr = array(
				'error' => $this->_ci->session->flashdata('error'),
				'success' => $this->_ci->session->flashdata('success'),
				'warning' => $this->_ci->session->flashdata('warning'),
				'info' => $this->_ci->session->flashdata('info')
			);
			return $arr;
		}
		// else it's a specific type
		else
		{
			return $this->_ci->session->flashdata($type);
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * display function.
	 *
	 * returns html wrapped items, either all or limited to a specific type.
	 * 
	 * @access public
	 * @param string $type (default: '')
	 * @return string
	 */
	public function display($type = '')
	{	
		$out = '';
		
		// if no type is passed, add all message data to output
		if ($type == '')
		{
			$arr = $this->get();
			
			if ($arr == FALSE) { $arr = array(); }
			
			foreach ($arr as $type => $items)
			{
				if (is_array($items))
				{
					$out .= config_item('before_all');
					foreach ($items as $item)
					{
						$out .= $this->_wrap($item, $type);
					}
					$out .= config_item('after_all');
				}
			}
		}
		// else just this type
		else
		{	
			$arr = $this->get($type);
			
			if ($arr == FALSE) { $arr = array(); }
			
			if (is_array($arr))
			{
				$out .= config_item('before_all');
				foreach ($arr as $item)
				{	
					$out .= $this->_wrap($item, $type);
				}
				$out .= config_item('after_all');
			}
		}
		return $out;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * _wrap function.
	 *
	 * wraps an item in it's configured html and returns the value.
	 * 
	 * @access private
	 * @param string $msg
	 * @param string $type
	 * @return string
	 */
	private function _wrap($msg, $type)
	{	
		$out = '';
		$out .= config_item('before_each');
		if ($type != '') 
		{
			$out .= config_item('before_'.$type); 
		}
		else
		{
			$out .= config_item('before_no_type'.$type);
		}
		$out .= $msg;
		$out .= config_item('after_each');
		if ($type != '') 
		{
			$out .= config_item('after_'.$type); 
		}
		else
		{
			$out .= config_item('after_no_type'.$type);
		}
		return $out;
	}
	
	// --------------------------------------------------------------------------
}
/* End of file ci_alerts.php */
/* Location: ./ci_authentication/libraries/ci_alerts.php */
