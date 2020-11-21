<?php

/**
* 构造相关方法
*/
defined('IN_IA') or exit('Access Denied');
class WechatUtil {
	
	public static function createMobileUrl($do, $modulename, $query = array(), $noredirect = false){
 	    global $_W;
		$query['do'] = $do;
		$query['m'] = strtolower($modulename);
		return self::murl('entry', $query, $noredirect);
	}
	public static function murl($segment, $params = array(), $noredirect = true) {
		global $_W;
		list($controller, $action, $do) = explode('/', $segment);
		$str = '';
		$url .= "app/index.php?i={$_W['uniacid']}{$str}&";
		if (!empty($controller)) {
			$url .= "c={$controller}&";
		}
		if (!empty($action)) {
			$url .= "a={$action}&";
		}
		if (!empty($do)) {
			$url .= "do={$do}&";
		}
		if (!empty($params)) {
			$queryString = http_build_query($params, '', '&');
			$url .= $queryString;
			if ($noredirect === false) {
				$url .= '&wxref=mp.weixin.qq.com#wechat_redirect';
			}
		}
		$domain = self::getDomain();
		return str_replace('addons/pz_guanhuai/', '', $domain . $url);
	}
	public static function tomedia($src, $local_path = false){
		global $_W;
		if (empty($src)) {
			return '';
		}
		if (strexists($src, "c=utility&a=wxcode&do=image&attach=")) {
			return $src;
		}
		if (strexists($src, 'addons/')) {
			return $_W['siteroot'] . substr($src, strpos($src, 'addons/'));
		}
		if (strexists($src, $_W['siteroot']) && !strexists($src, '/addons/')) {
			$urls = parse_url($src);
			$src = $t = substr($urls['path'], strpos($urls['path'], 'images'));
		}
		$t = strtolower($src);
		if (strexists($t, 'https://mmbiz.qlogo.cn') || strexists($t, 'http://mmbiz.qpic.cn')) {
			$url = url('utility/wxcode/image', array('attach' => $src));
			return $_W['siteroot'] . 'web' . ltrim($url, '.');
		}
		if ((substr($t, 0, 7) == 'http://') || (substr($t, 0, 8) == 'https://') || (substr($t, 0, 2) == '//')) {
			return $src;
		}
		if ($local_path || empty($_W['setting']['remote']['type']) || file_exists(IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/' . $src)) {
			$src = $_W['siteroot'] . $_W['config']['upload']['attachdir'] . '/' . $src;
		} else {
			$src = $_W['attachurl_remote'] . $src;
		}
		return $src;
	}
	/**
	  by 黄河 
	  QQ：541535641
	**/
	public function getOtherSettings($name){
	    global $_W;
	    $sql = 'SELECT `settings` FROM ' . tablename('uni_account_modules') . ' WHERE `uniacid` = :uniacid AND `module` = :module';
	    $settings = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':module' => $name));
	    $settings = iunserializer($settings);
	    return $settings;
	}
	public function saveOtherSettings($name,$settings){
		global $_W;

		$pars = array('module' => $name, 'uniacid' => $_W['uniacid']);
		$row = array();
		$row['settings'] = iserializer($settings);
		return pdo_update('uni_account_modules', $row, $pars) !== false;
	}
	private static function getDomain(){
		global $_W;
	    $settings = pdo_fetchcolumn("select bind_domain from " .tablename('uni_settings'). " where uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
	    $settings = iunserializer($settings);
	    WeUtility::logging("domain", $settings);
	    if(empty($settings['domain'])){
	    	return $_W['siteroot'];
	    }else{
	    	return $settings['domain']."/";
	    }
	}
	/***********************************************/
	/**
	 * youzan method
	 */
	public function youzan_access_token()
	{
		global $_W;
		$youzan = pdo_fetch("select * from " .tablename('n1ce_mission_token'). " where uniacid = :uniacid",array(':uniacid' => $_W['uniacid']));
		if ($youzan['endtime'] <= TIMESTAMP) {
			$oauth = $this->refreshToken($youzan['refresh_token']);
			$data = array('access_token' => $oauth['access_token'], 'refresh_token' => $oauth['refresh_token'], 'expires_in' => $youzan['expires_in'], 'scope' => $youzan['scope'], 'token_type' => $youzan['token_type'], 'endtime' => TIMESTAMP + $youzan['expires_in'], 'createtime' => TIMESTAMP);
			pdo_update('n1ce_mission_token', $data, array('id' => $youzan['id']));
			return $oauth['access_token'];
		} else {
			return $youzan['access_token'];
		}
	}
	public function refreshToken($refresh_token)
	{
		global $_W;
		load()->func('communication');
		$youzan = $this->getYouzan();
		$refurl = "https://open.youzan.com/oauth/token?grant_type=refresh_token&refresh_token=" . $refresh_token . "&client_id=" . $youzan['client_id'] . "&client_secret=" . $youzan['client_secret'];
		$result = ihttp_get($refurl);
		$auth = @json_decode($result['content'], true);
		return $auth;
	}
	private function getYouzan(){
		global $_W;
		$result = pdo_fetch("select * from " .tablename('n1ce_youzan_shopouth'));
		return $result;
	}

}