<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */class Agent
{
		const DEVICE_MOBILE  = 1;
	const DEVICE_DESKTOP = 2;
	const DEVICE_UNKNOWN = -1;
	
		const BROWSER_TYPE_IPHONE  = 1;
	const BROWSER_TYPE_IPAD    = 2;
	const BROWSER_TYPE_IPOD	   = 3;
	const BROWSER_TYPE_ANDROID = 4;
	const BROWSER_TYPE_UNKNOWN = -1;
	
		const OS_TYPE_IOS	  = 1;
	const OS_TYPE_ANDROID = 2;
	const OS_TYPE_UNKNOWN = -1;
	
		const RETINA_TYPE_YES = 1;
	const RETINA_TYPE_NOT = 0;
	
		const IOS6_YES = 1;
	const IOS6_NOT = 0;
	
		const MICRO_MESSAGE_YES = 1;
	const MICRO_MESSAGE_NOT = 0;
	
		const APP_INSTALLED_YES = 1;
	const APP_INSTALLED_NOT = 0;
	
		public static function getDeviceInfo()
	{
		return array(
			'deviceType'  => self::deviceType(),
			'browserType' => self::browserType(),
			'isRetina' 	  => self::isRetina(),
			'osType' 	  => self::osType(),
			'isIos6' 	  => self::isIos6(),
		);
	}
	
		public static function browserType($agent = '')
	{
		$agent = self::getAgent($agent);
	
		if (stripos($agent, 'iphone') !== false) {
			return self::BROWSER_TYPE_IPHONE;
		}
		
		if (stripos($agent, 'ipad') !== false) {
			return self::BROWSER_TYPE_IPAD;
		}
		
		if (stripos($agent, 'ipod') !== false) {
			return self::BROWSER_TYPE_IPOD;
		}
		
		if (stripos($agent, 'android') !== false) {
			return self::BROWSER_TYPE_ANDROID;
		}

		return self::BROWSER_TYPE_UNKNOWN;
	}
	
		public static function osType($agent = '')
	{
		$agent = self::getAgent($agent);
		$browserType = self::browserType($agent);

		switch ($browserType) {
			case self::BROWSER_TYPE_IPHONE:
			case self::BROWSER_TYPE_IPAD:
			case self::BROWSER_TYPE_IPOD:
				 $osType = self::OS_TYPE_IOS;
				 break;
			case self::BROWSER_TYPE_ANDROID:
				 $osType = self::OS_TYPE_ANDROID;
				 break;
			default:
				 $osType = self::OS_TYPE_UNKNOWN;
		}
		
		return $osType;
	}
	
		public static function deviceType()
	{
		if (self::isMobile()) {
			return self::DEVICE_MOBILE;
		} else {
			return self::DEVICE_DESKTOP;
		}
	}
	
		public static function isRetina($agent = '')
	{
		$agent = self::getAgent($agent);
		$osType = self::osType($agent);
		
		if (($osType == self::OS_TYPE_IOS) && (self::isIos6($agent) != 1)) {
			return self::RETINA_TYPE_YES;
		} else {
			return self::RETINA_TYPE_NOT;
		}
	}
	
		public static function isIos6($agent = '')
	{
		$agent = self::getAgent($agent);
		
		if (stripos($agent, 'iPhone OS 6')) {
			return self::IOS6_YES;
		} else {
			return self::IOS6_NOT;
		}
	}
		public static function isMicroMessage($agent = '')
	{
		$agent = self::getAgent($agent);
		
		if (stripos($agent, 'MicroMessenger') !== false) {
			return self::MICRO_MESSAGE_YES;
		} else {
			return self::MICRO_MESSAGE_NOT;
		}
	}
	
		public static function isAppInstalled()
	{
		if (isset($_GET['isappinstalled']) && ($_GET['isappinstalled'] == 1)) {
			return self::APP_INSTALLED_YES;
		} else {
			return self::APP_INSTALLED_NOT;
		}
	}
	
		public static function isMobile()
	{
				if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
			return true;
		}
				if (isset($_SERVER['HTTP_VIA']) && stristr($_SERVER['HTTP_VIA'], "wap")) {
				return true;
		}
				if (isset ($_SERVER['HTTP_USER_AGENT'])) {
			$clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp',
				'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 
				'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 
				'nexusone', 'cldc', 'midp', 'wap', 'mobile');
						if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
				return true;
			}
		}
				if (isset($_SERVER['HTTP_ACCEPT'])) {
						if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
				return true;
			}
		}
		return false;
	}
	
	public static function getAgent($agent = '')
	{
		$agent = empty($agent) ? $_SERVER['HTTP_USER_AGENT'] : $agent;
		return $agent;
	}
}