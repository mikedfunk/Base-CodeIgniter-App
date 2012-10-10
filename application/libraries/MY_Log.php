<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * fixes chmod issues
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file MY_Log.php
 */

class MY_Log extends CI_Log
{
	// --------------------------------------------------------------------

	/**
	 * Write Log File
	 *
	 * Generally this function will be called using the global log_message() function
	 *
	 * @param	string	the error level
	 * @param	string	the error message
	 * @param	bool	whether the error is a native PHP error
	 * @return	bool
	 */
	public function write_log($level = 'error', $msg, $php_error = FALSE)
	{
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}

		$level = strtoupper($level);

		if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
		{
			return FALSE;
		}

		$filepath = $this->_log_path.'log-'.date('Y-m-d').'.php';
		$message  = '';

		if ( ! file_exists($filepath))
		{
			$message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
		}

		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
		{
			return FALSE;
		}

		$message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' '.date($this->_date_fmt). ' --> '.$msg."\n";

		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);

		// @chmod($filepath, FILE_WRITE_MODE);
		/**
		 * @link http://codeigniter.com/forums/viewthread/214796/
		 */
		if (octdec(substr(sprintf('%o', fileperms($filepath)), -4)) != FILE_WRITE_MODE)
		{
			@chmod($filepath, FILE_WRITE_MODE);
		}
		return TRUE;
	}
}
/* End of file MY_Log.php */
/* Location: ./applicaiton/libraries/MY_Log.php */