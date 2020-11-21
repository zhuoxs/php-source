<?php
/**
* 	配置账号信息
*/
define('APPID', C('pingche_xcx.appid'));
define('MCHID', C('wx_pay.mchid'));
define('WXKEY', C('wx_pay.secrect_key'));
define('APPSECRET', C('pingche_xcx.secret'));
define('SSLCERT_PATH', C('wx_pay.sslcert_path'));
define('SSLKEY_PATH', C('wx_pay.sslkey_path'));
class WxPayConfig
{
	const APPID = APPID;
	const MCHID = MCHID;
	const KEY = WXKEY;
	const APPSECRET =APPSECRET ;
	const SSLCERT_PATH = SSLCERT_PATH;
	const SSLKEY_PATH = SSLKEY_PATH;
	const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
	const CURL_PROXY_PORT = 0;//8080;
	const REPORT_LEVENL = 1;
}
