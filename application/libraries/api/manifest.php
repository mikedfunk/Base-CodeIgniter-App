<?php
namespace
{
	class Manifest { }
}

namespace API\Manifest
{
	class Endpoint { }
	class HTTP_Verb { }
	
	class Parameter
	{
		public $type;
		public $description;

		public function __construct($type, $description)
		{
			$this->type = $type;
			$this->description = $description;
		}
	}
}