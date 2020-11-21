<?php

/**
 * Class MonUtil
 * 工具类
 */
class MonUtil
{

	public static $DEBUG = true;

	public static $IMG_TITLE_BG = 1;
	public static $IMG_SHAKE_BG = 2;
	public static $IMG_INDEX_BG = 3;
	public static $IMG_SHARE_BG = 4;


	/**
	 * author: codeMonkey QQ:631872807
	 * @param $url
	 * @return string
	 */
	public static function str_murl($url)
	{
		global $_W;

		return $_W['siteroot'] . 'app' . str_replace('./', '/', $url);

	}


	/**
	 * author: codeMonkey QQ:631872807
	 * 检查手机
	 */
	public static function  checkmobile()
	{

		if (!MonUtil::$DEBUG) {
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			if (strpos($user_agent, 'MicroMessenger') === false) {
				echo "本页面仅支持微信访问!非微信浏览器禁止浏览!";
				exit();
			}
		}


	}

	/**
	 * author:codeMonkey QQ 631872807
	 * 获取哟规划信息
	 * @return array|mixed|stdClass
	 */
	public static function  getClientCookieUserInfo($cookieKey)
	{
		global $_GPC;
		$session = json_decode(base64_decode($_GPC[$cookieKey]), true);
		return $session;

	}


	/**
	 * author: codeMonkey QQ:631872807
	 * @param $openid
	 * @param $accessToken
	 * @return unknown
	 * cookie保存用户信息
	 */
	public static function setClientCookieUserInfo($userInfo = array(), $cookieKey)
	{

		if (!empty($userInfo) && !empty($userInfo['openid'])) {
			$cookie = array();
			foreach ($userInfo as $key => $value)
				$cookie[$key] = $value;
			$session = base64_encode(json_encode($cookie));

			isetcookie($cookieKey, $session, 1 * 3600 * 1);

		} else {

			message("获取用户信息错误");
		}


	}


	public static function getpicurl($url)
	{
		global $_W;
		return $_W ['attachurl'] . $url;

	}


	public static function  emtpyMsg($obj, $msg)
	{
		if (empty($obj)) {
			message($msg);
		}
	}

	public static function defaultImg($img_type,$shake='')
	{
		switch ($img_type) {
			//首页
			case MonUtil::$IMG_TITLE_BG:
				if (!empty($shake)&&!empty($shake['title_bg'])) {
					return MonUtil::getpicurl($shake['title_bg']);
				}
				$img_name = "title.png";
				break;
			case MonUtil::$IMG_SHAKE_BG:
				if (!empty($shake)&&!empty($shake['shake_bg'])) {
					return MonUtil::getpicurl($shake['shake_bg']);
				}
				$img_name = "top_bg.jpg";
				break;
			case MonUtil::$IMG_INDEX_BG:
				if (!empty($shake)&&!empty($shake['index_bg'])) {
					return MonUtil::getpicurl($shake['index_bg']);
				}
				$img_name = "index.jpg";
				break;
			case MonUtil::$IMG_SHARE_BG:
				if (!empty($shake)&&!empty($shake['share_bg'])) {
					return MonUtil::getpicurl($shake['share_bg']);
				}
				$img_name = "guide.png";
				break;
		}
		return "../addons/mon_qmshake/images/" . $img_name;

	}


}