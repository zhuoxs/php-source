<?php

defined('IN_IA') or exit('Access Denied');


load()->classs('xzapp.account');

class XzappPlatform extends XzappAccount {

	public $appid;
	public $appsecret;
	public $encodingaeskey;
	public $token;
	public $refreshtoken;
	public $account;

	function __construct(array $account = array())
	{
		$setting['token'] = 'we7';
		$setting['encodingaeskey'] = 'g4LUbkbCbYmdXBeilamDMsU905IXfqjT5avgMETyV0e';
		$setting['appid'] = 'TrarDDV5IcTTxOffEXx58Gt5LsqlGyVi';
		$setting['appsecret'] = 'jCfdywGiBpaGxp2ivS5uHXIsEOLrzhZY';
		$setting['authstate'] = 1;
		$setting['url'] = 'https://ccceshi.w7.cc/xiongzhang_api.php';

		$_W['setting']['xzapp'] = $setting;

		$this->menuFrame = 'account';
		$this->type = ACCOUNT_TYPE_XZAPP_NORMAL;
		$this->typeName = '熊掌号';
		$this->typeSign = XZAPP_TYPE_SIGN;

		$this->appid = $setting['appid'];
		$this->appsecret = $setting['appsecret'];
		$this->token = $setting['token'];
		$this->encodingaeskey = $setting['encodingaeskey'];
	}



}
