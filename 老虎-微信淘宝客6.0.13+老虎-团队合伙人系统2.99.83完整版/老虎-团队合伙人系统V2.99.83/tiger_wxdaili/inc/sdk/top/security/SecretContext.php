<?php
	class SecretContext
	{
		var $secret;
		var $secretVersion;
		var $invalidTime;
		var $maxInvalidTime;

		function __construct()
	 	{

	 	}
	}

	class SecretData
	{
		var $originalValue;
		var $originalBase64Value;
		var $secretVersion;
		var $search;

		function __construct()
	 	{

	 	}
	}
?>