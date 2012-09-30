<?php
namespace
{
	class Exceptions { }
}

namespace API\Exceptions
{
	class Exception extends \Exception { }

	class Resource_Not_Found extends Exception
	{
		public function __construct($resource)
		{
			parent::__construct("The $resource you tried to retrieve can't be found", 404);
		}
	}

	class Authentication extends Exception
	{
		public function __construct()
		{
			parent::__construct("Your access token is either missing or incorrect. Please check the X-Access-Token header and try again.", 401);
		}
	}

	class Authentication_Signature extends Exception
	{
		public function __construct()
		{
			parent::__construct("There was a problem with the request signature you supplied.", 400);
		}
	}

	class Throttled extends Exception
	{
		public function __construct($date)
		{
			parent::__construct("The rate limits for this access_token have been exceeded. Please try again at " . $date, 400);
		}
	}
}