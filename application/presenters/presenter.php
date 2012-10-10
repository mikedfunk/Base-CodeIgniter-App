<?php

/**
 * Jamie Rumbelow's presenters, based on RoR.
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file presenter.php
 */
 
/**
 * Presenter class.
 */
class Presenter
{
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param object $object
	 * @return void
	 */
	public function __construct($object)
	{
		$name = strtolower(str_replace("_presenter", "", get_class($this)));
		$this->$name = $object;
	}

	// --------------------------------------------------------------------------
	
	/**
	 * __get function.
	 * 
	 * @access public
	 * @param mixed $attr
	 * @return mixed
	 */
	public function __get($attr)
	{
		if (isset(get_instance()->$attr))
		{
			return get_instance()->$attr;
		}
	}
	
	// --------------------------------------------------------------------------
}
/* End of file presenter.php */
/* Location: ./application/presenters/presenter.php */