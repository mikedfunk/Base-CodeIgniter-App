<?php

class Presenter
{
	public function __construct($object)
	{
		$name = strtolower(str_replace("_presenter", "", get_class($this)));
		$this->$name = $object;
	}

	public function __get($attr)
	{
		if (isset(get_instance()->$attr))
		{
			return get_instance()->$attr;
		}
	}
}