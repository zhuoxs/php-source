<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

if (!function_exists('app')) {
	function app($name = '')
	{
		$names = explode('.', $name);

		if (isset($names[1])) {
			$model = EWEI_SHOPV2_PLUGIN . 'app/core/mobile/' . strtolower($names[0]) . '/' . strtolower($names[1]) . '.php';
			$actname = $names[1];
		}
		else {
			$model = EWEI_SHOPV2_PLUGIN . 'app/core/mobile/' . strtolower($names[0]) . '.php';
			$actname = $names[0];
		}

		if (!is_file($model)) {
			exit(' Controller ' . $names[0] . ' Not Found!');
		}

		require_once IA_ROOT . '/addons/ewei_shopv2/core/inc/page_mobile.php';
		require_once IA_ROOT . '/addons/ewei_shopv2/core/inc/page_mobile_plugin.php';
		require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
		require_once $model;
		$class_name = ucfirst($actname) . '_EweiShopV2Page';
		$_modules[$actname] = new $class_name();
		return $_modules[$actname];
	}
}

if (!function_exists('m')) {
	function m($name = '')
	{
		static $_modules = array();

		if (isset($_modules[$name])) {
			return $_modules[$name];
		}

		$model = EWEI_SHOPV2_CORE . 'model/' . strtolower($name) . '.php';

		if (!is_file($model)) {
			exit(' Model ' . $name . ' Not Found!');
		}

		require_once $model;
		$class_name = ucfirst($name) . '_EweiShopV2Model';
		$_modules[$name] = new $class_name();
		return $_modules[$name];
	}
}

if (!function_exists('d')) {
	function d($name = '')
	{
		static $_modules = array();

		if (isset($_modules[$name])) {
			return $_modules[$name];
		}

		$model = EWEI_SHOPV2_CORE . 'data/' . strtolower($name) . '.php';

		if (!is_file($model)) {
			exit(' Data Model ' . $name . ' Not Found!');
		}

		require_once EWEI_SHOPV2_INC . 'data_model.php';
		require_once $model;
		$class_name = ucfirst($name) . '_EweiShopV2DataModel';
		$_modules[$name] = new $class_name();
		return $_modules[$name];
	}
}

if (!function_exists('plugin_run')) {
	function plugin_run($name = '')
	{
		$names = explode('::', $name);
		$plugin = p($names[0]);

		if (!$plugin) {
			return false;
		}

		if (!method_exists($plugin, $names[1])) {
			return false;
		}

		$func_args = func_get_args();
		$args = array_splice($func_args, 1);
		return call_user_func_array(array($plugin, $names[1]), $args);
	}
}

if (!function_exists('socket')) {
	function socket($name)
	{
		static $_plugins = array();

		if (isset($_plugins[$name])) {
			return $_plugins[$name];
		}

		$socket = EWEI_SHOPV2_PLUGIN . strtolower($name) . '/core/socket.php';

		if (!is_file($socket)) {
			return false;
		}

		require_once EWEI_SHOPV2_CORE . 'inc/plugin_model.php';
		require_once $socket;
		$class_name = ucfirst($name) . 'Socket';

		if (!class_exists($class_name)) {
			return false;
		}

		$_plugins[$name] = new $class_name($name);

		if (com_run('perm::check_plugin', $name)) {
			if (!function_exists('redis') || is_error(redis())) {
				return false;
			}

			return $_plugins[$name];
		}

		return false;
	}
}

if (!function_exists('p')) {
	function p($name = '')
	{
		static $_plugins = array();

		if (isset($_plugins[$name])) {
			return $_plugins[$name];
		}

		$model = EWEI_SHOPV2_PLUGIN . strtolower($name) . '/core/model.php';

		if (!is_file($model)) {
			return false;
		}

		$return_instance = false;
		if ($name == 'grant' || $name == 'qpay') {
			$return_instance = true;
		}
		else {
			if (com_perm_check_plugin($name)) {
				$open = strpos($name, 'open_');
				if ($name == 'seckill' || $open) {
					if (!function_exists('redis') || is_error(redis())) {
						return false;
					}
				}

				$return_instance = true;
			}
		}

		if ($return_instance) {
			require_once EWEI_SHOPV2_CORE . 'inc/plugin_model.php';
			require_once $model;
			$class_name = ucfirst($name) . 'Model';
			$_plugins[$name] = new $class_name($name);
			return $_plugins[$name];
		}

		$_plugins[$name] = false;
		return false;
	}
}

if (!function_exists('com')) {
	function com($name = '')
	{
		static $_coms = array();

		if (isset($_coms[$name])) {
			return $_coms[$name];
		}

		if ($name == 'qiniu') {
			$data = m('cache')->getArray('qiniu', 'global');

			if (empty($data['upload'])) {
				$_coms[$name] = false;
				return $_coms[$name];
			}
		}

		$model = EWEI_SHOPV2_CORE . 'com/' . strtolower($name) . '.php';

		if (!is_file($model)) {
			return false;
		}

		require_once EWEI_SHOPV2_CORE . 'inc/com_model.php';
		require_once $model;
		$class_name = ucfirst($name) . '_EweiShopV2ComModel';
		$_coms[$name] = new $class_name($name);

		if (com_perm_check_com($name)) {
			return $_coms[$name];
		}

		$_coms[$name] = false;
		return $_coms[$name];
	}
}

if (!function_exists('com_perm_getPermset')) {
	function com_perm_getPermset()
	{
		$path = IA_ROOT . '/addons/ewei_shopv2/data/global';
		$permset = intval(m('cache')->getString('permset', 'global'));
		if (empty($permset) && is_file($path . '/perm.cache')) {
			$permset = authcode(file_get_contents($path . '/perm.cache'), 'DECODE', 'global');
		}

		return $permset;
	}
}

if (!function_exists('com_perm_isopen')) {
	function com_perm_isopen($pluginname = '', $iscom = false)
	{
		if (empty($pluginname)) {
			return false;
		}

		$plugins = m('plugin')->getAll($iscom);
		$plugins_name = array();

		foreach ($plugins as $val) {
			$plugins_name[] = $val['identity'];
		}

		if (in_array($pluginname, $plugins_name)) {
			foreach ($plugins as $plugin) {
				if ($plugin['identity'] == strtolower($pluginname)) {
					if (empty($plugin['status'])) {
						return false;
					}
				}
			}
		}
		else {
			return false;
		}

		return true;
	}
}

if (!function_exists('com_perm_check_plugin')) {
	function com_perm_check_plugin($pluginname = '')
	{
		global $_W;
		global $_GPC;
		$permset = com_perm_getPermset();

		if (empty($permset)) {
			return true;
		}

		$founders = explode(',', $_W['config']['setting']['founder']);
		$owner = account_owner($_W['uniacid']);
		if ($_W['role'] == 'founder' || empty($_W['role'])) {
			if (in_array($owner['uid'], $founders)) {
				return true;
			}
		}

		if ($pluginname == 'grant' && $_W['role'] == 'founder') {
			return true;
		}

		if (in_array($owner['uid'], $founders)) {
			static $userids = array();

			if (!isset($userids['uniacid_' . $_W['uniacid']])) {
				$userids = pdo_fetchall('select * from ' . tablename('uni_account_users') . '  where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']), 'uid');
				$userids['uniacid_' . $_W['uniacid']] = array_keys($userids);
			}

			if (in_array($_W['uid'], $userids['uniacid_' . $_W['uniacid']]) && $_W['role'] == 'manager') {
				return true;
			}
		}

		$isopen = com_perm_isopen($pluginname);

		if (!$isopen) {
			return false;
		}

		$allow = true;
		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		$ac_perm = pdo_fetch('select  plugins from ' . tablename('ewei_shop_perm_plugin') . ' where acid=:acid limit 1', array(':acid' => $acid));

		if (!empty($ac_perm)) {
			$allow_plugins = explode(',', $ac_perm['plugins']);

			if (!in_array($pluginname, $allow_plugins)) {
				$filename = '../addons/ewei_shopv2/core/model/grant.php';

				if (file_exists($filename)) {
					$check = m('grant')->checkplugin($pluginname);

					if (!$check) {
						$allow = false;
					}
				}
				else if (p('grant')) {
					$check = p('grant')->checkplugin($pluginname);

					if (!$check) {
						$allow = false;
					}
				}
				else {
					$allow = false;
				}
			}
		}
		else {
			load()->model('account');
			load()->model('user');
			$allow = true;
			$filename = '../addons/ewei_shopv2/core/model/grant.php';

			if (in_array($owner['uid'], $founders)) {
				if (file_exists($filename)) {
					$allow = m('grant')->checkplugin($pluginname);
				}
				else if (p('grant')) {
					$allow = p('grant')->checkplugin($pluginname);
				}
				else {
					$allow = false;
				}
			}
			else if (file_exists($filename)) {
				$allow = m('grant')->checkplugin($pluginname);
			}
			else if (p('grant')) {
				$allow = p('grant')->checkplugin($pluginname);
			}
			else {
				$allow = false;
			}
		}

		if (!$allow) {
			return false;
		}

		return true;
	}
}

if (!function_exists('com_perm_check_com')) {
	function com_perm_check_com($comname)
	{
		global $_W;
		global $_GPC;
		$permset = com_perm_getPermset();

		if (empty($permset)) {
			return true;
		}

		$founders = explode(',', $_W['config']['setting']['founder']);
		$owner = account_owner($_W['uniacid']);

		if ($_W['role'] == 'founder') {
			if (in_array($owner['uid'], $founders)) {
				return true;
			}
		}

		if (empty($_W['role'])) {
			return true;
		}

		if (in_array($owner['uid'], $founders)) {
			static $userids = array();

			if (!isset($userids['uniacid_' . $_W['uniacid']])) {
				$userids = pdo_fetchall('select * from ' . tablename('uni_account_users') . '  where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']), 'uid');
				$userids['uniacid_' . $_W['uniacid']] = array_keys($userids);
			}

			if (in_array($_W['uid'], $userids['uniacid_' . $_W['uniacid']]) && $_W['role'] == 'manager') {
				return true;
			}
		}

		$isopen = com_perm_isopen($comname, true);

		if (!$isopen) {
			return false;
		}

		$allow = true;
		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		$ac_perm = pdo_fetch('select  coms from ' . tablename('ewei_shop_perm_plugin') . ' where acid=:acid limit 1', array(':acid' => $acid));

		if (!empty($ac_perm)) {
			$allow_coms = explode(',', $ac_perm['coms']);

			if (!in_array($comname, $allow_coms)) {
				$allow_plugins = explode(',', $ac_perm['coms']);

				if (!in_array($comname, $allow_plugins)) {
					$filename = '../addons/ewei_shopv2/core/model/grant.php';

					if (file_exists($filename)) {
						$allow = m('grant')->checkplugin($comname);
					}
					else if (p('grant')) {
						$allow = p('grant')->checkplugin($comname);
					}
					else {
						$allow = false;
					}
				}
			}
		}
		else {
			load()->model('account');

			if (in_array($owner['uid'], $founders)) {
				$allow = true;
				$filename = '../addons/ewei_shopv2/core/model/grant.php';

				if (file_exists($filename)) {
					$allow = m('grant')->checkplugin($comname);
				}
				else {
					if (p('grant')) {
						$allow = p('grant')->checkplugin($comname);
					}
				}
			}
			else {
				$filename = '../addons/ewei_shopv2/core/model/grant.php';

				if (file_exists($filename)) {
					$allow = m('grant')->checkplugin($comname);
				}
				else if (p('grant')) {
					$allow = p('grant')->checkplugin($comname);
				}
				else {
					$allow = false;
				}
			}
		}

		if (!$allow) {
			return false;
		}

		return true;
	}
}

if (!function_exists('check_operator_perm')) {
	function check_operator_perm($pluginname = '')
	{
		global $_W;
		global $_GPC;
		$uid = empty($_W['uid']) ? $_W['user']['uid'] : $_W['uid'];

		if (empty($uid)) {
			return false;
		}

		if (empty($_W['role']) || $_W['role'] != 'operator') {
			return true;
		}

		$user_perms = array();
		$role_perms = array();
		$item = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_perm_user') . ' WHERE uid =:uid and deleted=0 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':uid' => $uid));

		if (!empty($item)) {
			$role = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_perm_role') . ' WHERE id =:id and deleted=0 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $item['roleid']));

			if (!empty($role)) {
				$role_perms = explode(',', $role['perms2']);
			}

			$user_perms = explode(',', $item['perms2']);
		}

		if (in_array($pluginname, $role_perms) || in_array($pluginname, $user_perms)) {
			return true;
		}

		return false;
	}
}

if (!function_exists('com_run')) {
	function com_run($name = '')
	{
		$names = explode('::', $name);
		$com = com($names[0]);

		if (!$com) {
			return false;
		}

		if (!method_exists($com, $names[1])) {
			return false;
		}

		$func_args = func_get_args();
		$args = array_splice($func_args, 1);
		return call_user_func_array(array($com, $names[1]), $args);
	}
}

if (!function_exists('byte_format')) {
	function byte_format($input, $dec = 0)
	{
		$prefix_arr = array(' B', 'K', 'M', 'G', 'T');
		$value = round($input, $dec);
		$i = 0;

		while (1024 < $value) {
			$value /= 1024;
			++$i;
		}

		$return_str = round($value, $dec) . $prefix_arr[$i];
		return $return_str;
	}
}

if (!function_exists('is_array2')) {
	function is_array2($array)
	{
		if (is_array($array)) {
			foreach ($array as $k => $v) {
				return is_array($v);
			}

			return false;
		}

		return false;
	}
}

if (!function_exists('set_medias')) {
	function set_medias($list = array(), $fields = NULL)
	{
		if (empty($list)) {
			return array();
		}

		if (empty($fields)) {
			foreach ($list as &$row) {
				$row = tomedia($row);
			}

			return $list;
		}

		if (!is_array($fields)) {
			$fields = explode(',', $fields);
		}

		if (is_array2($list)) {
			foreach ($list as $key => &$value) {
				foreach ($fields as $field) {
					if (isset($list[$field])) {
						$list[$field] = tomedia($list[$field]);
					}

					if (is_array($value) && isset($value[$field])) {
						$value[$field] = tomedia($value[$field]);
					}
				}
			}

			return $list;
		}

		foreach ($fields as $field) {
			if (isset($list[$field])) {
				$list[$field] = tomedia($list[$field]);
			}
		}

		return $list;
	}
}

if (!function_exists('get_last_day')) {
	function get_last_day($year, $month)
	{
		return date('t', strtotime($year . '-' . $month . ' -1'));
	}
}

if (!function_exists('show_message')) {
	function show_message($msg = '', $url = '', $type = '')
	{
		$site = new Page();
		$site->message($msg, $url, $type);
		exit();
	}
}

if (!function_exists('show_json')) {
	function show_json($status = 1, $return = NULL)
	{
		$ret = array('status' => $status, 'result' => $status == 1 ? array('url' => referer()) : array());

		if (!is_array($return)) {
			if ($return) {
				$ret['result']['message'] = $return;
			}

			exit(json_encode($ret));
		}
		else {
			$ret['result'] = $return;
		}

		if (isset($return['url'])) {
			$ret['result']['url'] = $return['url'];
		}
		else {
			if ($status == 1) {
				$ret['result']['url'] = referer();
			}
		}

		exit(json_encode($ret));
	}
}

if (!function_exists('is_weixin')) {
	function is_weixin()
	{
		global $_W;

		if (EWEI_SHOPV2_DEBUG) {
			return true;
		}

		if (empty($_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'Windows Phone') === false) {
			return false;
		}

		return true;
	}
}

if (!function_exists('is_h5app')) {
	function is_h5app()
	{
		if (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'CK 2.0')) {
			return true;
		}

		return false;
	}
}

if (!function_exists('is_ios')) {
	function is_ios()
	{
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
			return true;
		}

		return false;
	}
}

if (!function_exists('is_mobile')) {
	function is_mobile()
	{
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/(android|bb\\d+|meego).+mobile|avantgo|bada\\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\\-(n|u)|c55\\/|capi|ccwa|cdm\\-|cell|chtm|cldc|cmd\\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\\-s|devi|dica|dmob|do(c|p)o|ds(12|\\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\\-|_)|g1 u|g560|gene|gf\\-5|g\\-mo|go(\\.w|od)|gr(ad|un)|haie|hcit|hd\\-(m|p|t)|hei\\-|hi(pt|ta)|hp( i|ip)|hs\\-c|ht(c(\\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\\-(20|go|ma)|i230|iac( |\\-|\\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\\/)|klon|kpt |kwc\\-|kyo(c|k)|le(no|xi)|lg( g|\\/(k|l|u)|50|54|\\-[a-w])|libw|lynx|m1\\-w|m3ga|m50\\/|ma(te|ui|xo)|mc(01|21|ca)|m\\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\\-2|po(ck|rt|se)|prox|psio|pt\\-g|qa\\-a|qc(07|12|21|32|60|\\-[2-7]|i\\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\\-|oo|p\\-)|sdk\\/|se(c(\\-|0|1)|47|mc|nd|ri)|sgh\\-|shar|sie(\\-|m)|sk\\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\\-|v\\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\\-|tdg\\-|tel(i|m)|tim\\-|t\\-mo|to(pl|sh)|ts(70|m\\-|m3|m5)|tx\\-9|up(\\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\\-|your|zeto|zte\\-/i', substr($useragent, 0, 4))) {
			return true;
		}

		return false;
	}
}

if (!function_exists('b64_encode')) {
	function b64_encode($obj)
	{
		if (is_array($obj)) {
			return urlencode(base64_encode(json_encode($obj)));
		}

		return urlencode(base64_encode($obj));
	}
}

if (!function_exists('b64_decode')) {
	function b64_decode($str, $is_array = true)
	{
		$str = base64_decode(urldecode($str));

		if ($is_array) {
			return json_decode($str, true);
		}

		return $str;
	}
}

if (!function_exists('create_image')) {
	function create_image($img)
	{
		$ext = strtolower(substr($img, strrpos($img, '.')));

		if ($ext == '.png') {
			$thumb = imagecreatefrompng($img);
		}
		else if ($ext == '.gif') {
			$thumb = imagecreatefromgif($img);
		}
		else {
			$thumb = imagecreatefromjpeg($img);
		}

		return $thumb;
	}
}

if (!function_exists('get_authcode')) {
	function get_authcode()
	{
		$auth = get_auth();
		return empty($auth['code']) ? '' : $auth['code'];
	}
}

if (!function_exists('get_auth')) {
	function get_auth()
	{
		global $_W;
		$set = pdo_fetch('select sets from ' . tablename('ewei_shop_sysset') . ' order by id asc limit 1');
		$sets = iunserializer($set['sets']);

		if (is_array($sets)) {
			return is_array($sets['auth']) ? $sets['auth'] : array();
		}

		return array();
	}
}

if (!function_exists('rc')) {
	function rc($plugin = '')
	{
		global $_W;
		global $_GPC;
		$domain = trim(preg_replace('/http(s)?:\\/\\//', '', rtrim($_W['siteroot'], '/')));
		$ip = gethostbyname($_SERVER['HTTP_HOST']);
		$setting = setting_load('site');
		$id = isset($setting['site']['key']) ? $setting['site']['key'] : '0';
		$auth = get_auth();
		load()->func('communication');
		$resp = ihttp_request(EWEI_SHOPV2_AUTH_URL, array('ip' => $ip, 'id' => $id, 'code' => $auth['code'], 'domain' => $domain, 'plugin' => $plugin), NULL, 1);
		$result = @json_decode($resp['content'], true);

		if (!empty($result['status'])) {
			return true;
		}

		return false;
	}
}

if (!function_exists('url_script')) {
	function url_script()
	{
		$url = '';
		$script_name = basename($_SERVER['SCRIPT_FILENAME']);

		if (basename($_SERVER['SCRIPT_NAME']) === $script_name) {
			$url = $_SERVER['SCRIPT_NAME'];
		}
		else if (basename($_SERVER['PHP_SELF']) === $script_name) {
			$url = $_SERVER['PHP_SELF'];
		}
		else {
			if (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $script_name) {
				$url = $_SERVER['ORIG_SCRIPT_NAME'];
			}
			else if (($pos = strpos($_SERVER['PHP_SELF'], '/' . $script_name)) !== false) {
				$url = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $script_name;
			}
			else {
				if (isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT']) === 0) {
					$url = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']));
				}
			}
		}

		return $url;
	}
}

if (!function_exists('shop_template_compile')) {
	function shop_template_compile($from, $to, $inmodule = false)
	{
		$path = dirname($to);

		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path);
		}

		$content = shop_template_parse(file_get_contents($from), $inmodule);
		if (IMS_FAMILY == 'x' && !preg_match('/(footer|header|account\\/welcome|login|register)+/', $from)) {
			$content = str_replace('微擎', '系统', $content);
		}

		file_put_contents($to, $content);
	}
}

if (!function_exists('shop_template_parse')) {
	function shop_template_parse($str, $inmodule = false)
	{
		global $_W;
		$url = url_script();

		if (strexists($url, 'app/index.php')) {
			$str = template_parse_app($str, $inmodule);
		}
		else {
			$str = template_parse_web($str, $inmodule);
		}

		if (strexists($_W['siteurl'], 'merchant.php') || strexists($_W['siteurl'], 'r=merch.mmanage')) {
			if (p('merch')) {
				$str = preg_replace('/{ifp\\s+(.+?)}/', '<?php if(mcv($1)) { ?>', $str);
				$str = preg_replace('/{ifpp\\s+(.+?)}/', '<?php if(mcp($1)) { ?>', $str);
				$str = preg_replace('/{ife\\s+(\\S+)\\s+(\\S+)}/', '<?php if( mce($1 ,$2) ) { ?>', $str);
				return $str;
			}
		}

		if (strexists($_W['siteurl'], 'newstoreant.php')) {
			if (p('newstore')) {
				$str = preg_replace('/{ifp\\s+(.+?)}/', '<?php if(mcv($1)) { ?>', $str);
				$str = preg_replace('/{ifpp\\s+(.+?)}/', '<?php if(mcp($1)) { ?>', $str);
				$str = preg_replace('/{ife\\s+(\\S+)\\s+(\\S+)}/', '<?php if( mce($1 ,$2) ) { ?>', $str);
				$str = preg_replace('/{ifs\\s+(.+?)}/', '<?php if( mcs($1) ) { ?>', $str);
				return $str;
			}
		}

		$str = preg_replace('/{ifp\\s+(.+?)}/', '<?php if(cv($1)) { ?>', $str);
		$str = preg_replace('/{ifpp\\s+(.+?)}/', '<?php if(cp($1)) { ?>', $str);
		$str = preg_replace('/{ife\\s+(\\S+)\\s+(\\S+)}/', '<?php if( ce($1 ,$2) ) { ?>', $str);
		return $str;
	}
}

if (!function_exists('template_parse_web')) {
	function template_parse_web($str, $inmodule = false)
	{
		$str = preg_replace('/<!--{(.+?)}-->/s', '{$1}', $str);
		$str = preg_replace('/{template\\s+(.+?)}/', '<?php (!empty($this) && $this instanceof WeModuleSite || ' . intval($inmodule) . ') ? (include $this->template($1, TEMPLATE_INCLUDEPATH)) : (include template($1, TEMPLATE_INCLUDEPATH));?>', $str);
		$str = preg_replace('/{php\\s+(.+?)}/', '<?php $1?>', $str);
		$str = preg_replace('/{if\\s+(.+?)}/', '<?php if($1) { ?>', $str);
		$str = preg_replace('/{else}/', '<?php } else { ?>', $str);
		$str = preg_replace('/{else ?if\\s+(.+?)}/', '<?php } else if($1) { ?>', $str);
		$str = preg_replace('/{\\/if}/', '<?php } ?>', $str);
		$str = preg_replace('/{loop\\s+(\\S+)\\s+(\\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2) { ?>', $str);
		$str = preg_replace('/{loop\\s+(\\S+)\\s+(\\S+)\\s+(\\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2 => $3) { ?>', $str);
		$str = preg_replace('/{\\/loop}/', '<?php } } ?>', $str);
		$str = preg_replace('/{(\\$[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)}/', '<?php echo $1;?>', $str);
		$str = preg_replace('/{(\\$[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff\\[\\]\'\\"\\$]*)}/', '<?php echo $1;?>', $str);
		$str = preg_replace('/{url\\s+(\\S+)}/', '<?php echo url($1);?>', $str);
		$str = preg_replace('/{url\\s+(\\S+)\\s+(array\\(.+?\\))}/', '<?php echo url($1, $2);?>', $str);
		$str = preg_replace('/{media\\s+(\\S+)}/', '<?php echo tomedia($1);?>', $str);
		$str = preg_replace_callback('/<\\?php([^\\?]+)\\?>/s', 'template_addquote', $str);
		$str = preg_replace_callback('/{hook\\s+(.+?)}/s', 'template_modulehook_parser', $str);
		$str = preg_replace('/{\\/hook}/', '<?php ; ?>', $str);
		$str = preg_replace('/{([A-Z_\\x7f-\\xff][A-Z0-9_\\x7f-\\xff]*)}/s', '<?php echo $1;?>', $str);
		$str = str_replace('{##', '{', $str);
		$str = str_replace('##}', '}', $str);

		if (!empty($GLOBALS['_W']['setting']['remote']['type'])) {
			$str = str_replace('</body>', '<script>$(function(){$(\'img\').attr(\'onerror\', \'\').on(\'error\', function(){if (!$(this).data(\'check-src\') && (this.src.indexOf(\'http://\') > -1 || this.src.indexOf(\'https://\') > -1)) {this.src = this.src.indexOf(\'' . $GLOBALS['_W']['attachurl_local'] . '\') == -1 ? this.src.replace(\'' . $GLOBALS['_W']['attachurl_remote'] . '\', \'' . $GLOBALS['_W']['attachurl_local'] . '\') : this.src.replace(\'' . $GLOBALS['_W']['attachurl_local'] . '\', \'' . $GLOBALS['_W']['attachurl_remote'] . '\');$(this).data(\'check-src\', true);}});});</script></body>', $str);
		}

		$str = '<?php defined(\'IN_IA\') or exit(\'Access Denied\');?>' . $str;
		return $str;
	}
}

if (!function_exists('template_parse_app')) {
	function template_parse_app($str)
	{
		$check_repeat_template = array('\'common\\/header\'', '\'common\\/footer\'');

		foreach ($check_repeat_template as $template) {
			if (1 < preg_match_all('/{template\\s+' . $template . '}/', $str, $match)) {
				$replace = stripslashes($template);
				$str = preg_replace('/{template\\s+' . $template . '}/i', '<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template(' . $replace . ', TEMPLATE_INCLUDEPATH)) : (include template(' . $replace . ', TEMPLATE_INCLUDEPATH));?>', $str, 1);
				$str = preg_replace('/{template\\s+' . $template . '}/i', '', $str);
			}
		}

		$str = preg_replace('/<!--{(.+?)}-->/s', '{$1}', $str);
		$str = preg_replace('/{template\\s+(.+?)}/', '<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template($1, TEMPLATE_INCLUDEPATH)) : (include template($1, TEMPLATE_INCLUDEPATH));?>', $str);
		$str = preg_replace('/{php\\s+(.+?)}/', '<?php $1?>', $str);
		$str = preg_replace('/{if\\s+(.+?)}/', '<?php if($1) { ?>', $str);
		$str = preg_replace('/{else}/', '<?php } else { ?>', $str);
		$str = preg_replace('/{else ?if\\s+(.+?)}/', '<?php } else if($1) { ?>', $str);
		$str = preg_replace('/{\\/if}/', '<?php } ?>', $str);
		$str = preg_replace('/{loop\\s+(\\S+)\\s+(\\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2) { ?>', $str);
		$str = preg_replace('/{loop\\s+(\\S+)\\s+(\\S+)\\s+(\\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2 => $3) { ?>', $str);
		$str = preg_replace('/{\\/loop}/', '<?php } } ?>', $str);
		$str = preg_replace('/{(\\$[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)}/', '<?php echo $1;?>', $str);
		$str = preg_replace('/{(\\$[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff\\[\\]\'\\"\\$]*)}/', '<?php echo $1;?>', $str);
		$str = preg_replace('/{url\\s+(\\S+)}/', '<?php echo url($1);?>', $str);
		$str = preg_replace('/{url\\s+(\\S+)\\s+(array\\(.+?\\))}/', '<?php echo url($1, $2);?>', $str);
		$str = preg_replace('/{media\\s+(\\S+)}/', '<?php echo tomedia($1);?>', $str);
		$str = preg_replace_callback('/{data\\s+(.+?)}/s', 'moduledata', $str);
		$str = preg_replace_callback('/{hook\\s+(.+?)}/s', 'template_modulehook_parser', $str);
		$str = preg_replace('/{\\/data}/', '<?php } } ?>', $str);
		$str = preg_replace('/{\\/hook}/', '<?php ; ?>', $str);
		$str = preg_replace_callback('/<\\?php([^\\?]+)\\?>/s', 'template_addquote', $str);
		$str = preg_replace('/{([A-Z_\\x7f-\\xff][A-Z0-9_\\x7f-\\xff]*)}/s', '<?php echo $1;?>', $str);
		$str = str_replace('{##', '{', $str);
		$str = str_replace('##}', '}', $str);

		if (!empty($GLOBALS['_W']['setting']['remote']['type'])) {
			$str = str_replace('</body>', '<script>var imgs = document.getElementsByTagName(\'img\');for(var i=0, len=imgs.length; i < len; i++){imgs[i].onerror = function() {if (!this.getAttribute(\'check-src\') && (this.src.indexOf(\'http://\') > -1 || this.src.indexOf(\'https://\') > -1)) {this.src = this.src.indexOf(\'' . $GLOBALS['_W']['attachurl_local'] . '\') == -1 ? this.src.replace(\'' . $GLOBALS['_W']['attachurl_remote'] . '\', \'' . $GLOBALS['_W']['attachurl_local'] . '\') : this.src.replace(\'' . $GLOBALS['_W']['attachurl_local'] . '\', \'' . $GLOBALS['_W']['attachurl_remote'] . '\');this.setAttribute(\'check-src\', true);}}}</script></body>', $str);
		}

		$str = '<?php defined(\'IN_IA\') or exit(\'Access Denied\');?>' . $str;
		return $str;
	}
}

if (!function_exists('ce')) {
	function ce($permtype = '', $item = NULL)
	{
		if (!com('perm')) {
			return true;
		}

		$perm = com_run('perm::check_edit', $permtype, $item);
		return $perm;
	}
}

if (!function_exists('cv')) {
	function cv($permtypes = '')
	{
		if (!com('perm')) {
			$arr = explode('.', $permtypes);

			if ($arr[0] == 'sale') {
				if (!com_perm_check_com('sale') && !com_perm_check_com('coupon') && !com_perm_check_com('wxcard')) {
					return false;
				}
			}

			return true;
		}

		$perm = com_run('perm::check_perm', $permtypes);
		return $perm;
	}
}

if (!function_exists('ca')) {
	function ca($permtypes = '')
	{
		global $_W;
		$err = '您没有权限操作，请联系管理员!';

		if (!cv($permtypes)) {
			if ($_W['isajax']) {
				show_json(0, $err);
			}

			show_message($err, '', 'error');
		}
	}
}

if (!function_exists('cp')) {
	function cp($pluginname = '')
	{
		$perm = com('perm');

		if ($perm) {
			return $perm->check_plugin($pluginname);
		}

		return true;
	}
}

if (!function_exists('cpa')) {
	function cpa($pluginname = '')
	{
		if (!cp($pluginname)) {
			show_message('您没有权限操作，请联系管理员!', '', 'error');
		}
	}
}

if (!function_exists('plog')) {
	function plog($type = '', $op = '')
	{
		com_run('perm::log', $type, $op);
	}
}

if (!function_exists('tpl_selector')) {
	function tpl_selector($name, $options = array())
	{
		$options['multi'] = intval($options['multi']);
		$options['buttontext'] = isset($options['buttontext']) ? $options['buttontext'] : '请选择';
		$options['items'] = isset($options['items']) && $options['items'] ? $options['items'] : array();
		$options['readonly'] = isset($options['readonly']) ? $options['readonly'] : true;
		$options['callback'] = isset($options['callback']) ? $options['callback'] : '';
		$options['key'] = isset($options['key']) ? $options['key'] : 'id';
		$options['text'] = isset($options['text']) ? $options['text'] : 'title';
		$options['thumb'] = isset($options['thumb']) ? $options['thumb'] : 'thumb';
		$options['preview'] = isset($options['preview']) ? $options['preview'] : true;
		$options['type'] = isset($options['type']) ? $options['type'] : 'image';
		$options['input'] = isset($options['input']) ? $options['input'] : true;
		$options['required'] = isset($options['required']) ? $options['required'] : false;
		$options['nokeywords'] = isset($options['nokeywords']) ? $options['nokeywords'] : 0;
		$options['placeholder'] = isset($options['placeholder']) ? $options['placeholder'] : '请输入关键词';
		$options['autosearch'] = isset($options['autosearch']) ? $options['autosearch'] : 0;

		if (empty($options['items'])) {
			$options['items'] = array();
		}
		else {
			if (!is_array2($options['items'])) {
				$options['items'] = array($options['items']);
			}
		}

		$options['name'] = $name;
		$titles = '';

		foreach ($options['items'] as $item) {
			$titles .= $item[$options['text']];

			if (1 < count($options['items'])) {
				$titles .= '; ';
			}
		}

		$options['value'] = isset($options['value']) ? $options['value'] : $titles;
		$readonly = $options['readonly'] ? 'readonly' : '';
		$required = $options['required'] ? ' data-rule-required="true"' : '';
		$callback = !empty($options['callback']) ? ', ' . $options['callback'] : '';
		$id = $options['multi'] ? $name . '[]' : $name;
		$html = '<div id=\'' . $name . '_selector\' class=\'selector\'
                     data-type="' . $options['type'] . '"
                     data-key="' . $options['key'] . '"
                     data-text="' . $options['text'] . '"
                     data-thumb="' . $options['thumb'] . '"
                     data-multi="' . $options['multi'] . '"
                     data-callback="' . $options['callback'] . '"
                     data-url="' . $options['url'] . '"
                     data-nokeywords="' . $options['nokeywords'] . '"
                  data-autosearch="' . $options['autosearch'] . '"

                 >';
		if ($options['text'] == 'nickname' && $options['value'] != '') {
			$optionsValue = &$options['value'];
			$optionsValue = preg_replace('#[\'|"]#', '', $options['value']);
			unset($optionsValue);
		}

		if ($options['input']) {
			$html .= '<div class=\'input-group\'>' . ('<input type=\'text\' id=\'' . $name . '_text\' name=\'' . $name . '_text\'  value=\'' . $options['value'] . '\' class=\'form-control text\'  ' . $readonly . '  ' . $required . '/>') . '<div class=\'input-group-btn\'>';
		}

		$html .= '<button class=\'btn btn-primary\' type=\'button\' onclick=\'biz.selector.select(' . json_encode($options, JSON_HEX_APOS) . (');\'>' . $options['buttontext'] . '</button>');

		if ($options['input']) {
			$html .= '</div>';
			$html .= '</div>';
		}

		$show = $options['preview'] ? '' : ' style=\'display:none\'';

		if ($options['type'] == 'image') {
			$html .= '<div class=\'input-group multi-img-details container\' ' . $show . '>';
		}
		else if ($options['type'] == 'coupon') {
			$html .= '<div class=\'input-group multi-audio-details\' ' . $show . '>
                        <table class=\'table\'>
                            <thead>
                            <tr>
                                <th style=\'width:100px;\'>优惠券名称</th>
                                <th style=\'width:200px;\'></th>
                                <th>优惠券总数</th>
                                <th>每人限领数量</th>
                                <th style=\'width:80px;\'>操作</th>
                            </tr>
                            </thead>
                            <tbody class=\'ui-sortable container\'>';
		}
		else if ($options['type'] == 'coupon_cp') {
			$html .= '<div class=\'input-group multi-audio-details\' ' . $show . '>
                        <table class=\'table\'>
                            <thead>
                            <tr>
                                <th style=\'width:100px;\'>优惠券名称</th>
                                <th style=\'width:200px;\'></th>
                                <th></th>
                                <th></th>
                                <th style=\'width:80px;\'>操作</th>
                            </tr>
                            </thead>
                            <tbody id=\'param-items\' class=\'ui-sortable container\'>';
		}
		else if ($options['type'] == 'coupon_share') {
			$html .= '<div class=\'input-group multi-audio-details\' ' . $show . '>
                        <table class=\'table\'>
                            <thead>
                            <tr>
                                <th style=\'width:100px;\'>优惠券名称</th>
                                <th style=\'width:200px;\'></th>
                                <th></th>
                                <th>每人领取数量</th>
                                <th style=\'width:80px;\'>操作</th>
                            </tr>
                            </thead>
                            <tbody id=\'param-items\' class=\'ui-sortable container\'>';
		}
		else if ($options['type'] == 'coupon_shares') {
			$html .= '<div class=\'input-group multi-audio-details\' ' . $show . '>
                        <table class=\'table\'>
                            <thead>
                            <tr>
                                <th style=\'width:100px;\'>优惠券名称</th>
                                <th style=\'width:200px;\'></th>
                                <th></th>
                                <th>每人领取数量</th>
                                <th style=\'width:80px;\'>操作</th>
                            </tr>
                            </thead>
                            <tbody id=\'param-items\' class=\'ui-sortable container\'>';
		}
		else {
			$html .= '<div class=\'input-group multi-audio-details container\' ' . $show . '>';
		}

		foreach ($options['items'] as $item) {
			if ($options['type'] == 'image') {
				$html .= '<div class=\'multi-item\' data-' . $options['key'] . '=\'' . $item[$options['key']] . '\' data-name=\'' . $name . '\'>
                                      <img class=\'img-responsive img-thumbnail\' src=\'' . tomedia($item[$options['thumb']]) . ('\' onerror=\'this.src="../addons/ewei_shopv2/static/images/nopic.png"\' style=\'width:100px;height:100px;\'>
                                      <div class=\'img-nickname\'>' . $item[$options['text']] . '</div>
                                     <input type=\'hidden\' value=\'' . $item[$options['key']] . '\' name=\'' . $id . '\'>
                                     <em onclick=\'biz.selector.remove(this,"' . $name . '")\'  class=\'close\'>×</em>
                            <div style=\'clear:both;\'></div>
                         </div>');
			}
			else if ($options['type'] == 'coupon') {
				$html .= '
                <tr class=\'multi-product-item\' data-' . $options['key'] . '=\'' . $item[$options['key']] . '\'>
                    <input type=\'hidden\' class=\'form-control img-textname\' readonly=\'\' value=\'' . $item[$options['text']] . '\'>
                    <input type=\'hidden\' value=\'' . $item[$options['key']] . '\' name=\'couponid[]\'>
                    <td style=\'width:80px;\'>
                        <img src=\'' . tomedia($item[$options['thumb']]) . ('\' style=\'width:70px;border:1px solid #ccc;padding:1px\'>
                    </td>
                    <td style=\'width:220px;\'>
                    ' . $item[$options['text']]);

				if (!empty($item['merchname'])) {
					$html .= '<br /><label class=\'label label-info\'>[' . $item['merchname'] . ']</label>';
				}

				$html .= '</td>
                    <td>
                        <input class=\'form-control valid\' type=\'text\' value=\'' . $item['coupontotal'] . '\' name=\'coupontotal' . $item[$options['key']] . '\'>
                    </td>
                    <td>
                        <input class=\'form-control valid\' type=\'text\' value=\'' . $item['couponlimit'] . '\' name=\'couponlimit' . $item[$options['key']] . '\'>
                    </td>
                    <td>
                        <button class=\'btn btn-default\' onclick=\'biz.selector.remove(this,"' . $name . '")\' type=\'button\'><i class=\'fa fa-remove\'></i></button>
                    </td>
                </tr>
                ';
			}
			else if ($options['type'] == 'coupon_cp') {
				$html .= '
                    <tr class=\'multi-product-item setticket\' data-' . $options['key'] . '=\'' . $item[$options['key']] . '\'>
                        <input type=\'hidden\' class=\'form-control img-textname\' readonly=\'\' value=\'' . $item[$options['text']] . '\'>
                        <input type=\'hidden\' value=\'' . $item[$options['key']] . '\' name=\'couponid[]\'>
                        <td style=\'width:80px;\'>
                            <img src=\'' . tomedia($item[$options['thumb']]) . ('\' style=\'width:70px;border:1px solid #ccc;padding:1px\'>
                        </td>
                        <td style=\'width:220px;\'>' . $item[$options['text']] . '</td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                            <button class=\'btn btn-default\' onclick=\'biz.selector.remove(this,"' . $name . '")\' type=\'button\'><i class=\'fa fa-remove\'></i></button>
                        </td>
                    </tr>
                    ');
			}
			else if ($options['type'] == 'coupon_share') {
				$html .= '
                    <tr class=\'multi-product-item shareticket\' data-' . $options['key'] . '=\'' . $item[$options['key']] . '\'>
                        <input type=\'hidden\' class=\'form-control img-textname\' readonly=\'\' value=\'' . $item[$options['text']] . '\'>
                        <input type=\'hidden\' value=\'' . $item[$options['key']] . '\' name=\'couponid[]\'>
                        <td style=\'width:80px;\'>
                            <img src=\'' . tomedia($item[$options['thumb']]) . ('\' style=\'width:70px;border:1px solid #ccc;padding:1px\'>
                        </td>
                        <td style=\'width:220px;\'>' . $item[$options['text']] . '</td>
                        <td>
                        </td>
                        <td>
                            <input class=\'form-control valid\' type=\'text\' value=\'' . $item['couponnum' . $item['id']] . '\' name=\'couponnum' . $item[$options['key']] . '\'>
                        </td>
                        <td>
                            <button class=\'btn btn-default\' onclick=\'biz.selector.remove(this,"' . $name . '")\' type=\'button\'><i class=\'fa fa-remove\'></i></button>
                        </td>
                    </tr>
                    ');
			}
			else if ($options['type'] == 'coupon_shares') {
				$html .= '
                    <tr class=\'multi-product-item sharesticket\' data-' . $options['key'] . '=\'' . $item[$options['key']] . '\'>
                        <input type=\'hidden\' class=\'form-control img-textname\' readonly=\'\' value=\'' . $item[$options['text']] . '\'>
                        <input type=\'hidden\' value=\'' . $item[$options['key']] . '\' name=\'couponids[]\'>
                        <td style=\'width:80px;\'>
                            <img src=\'' . tomedia($item[$options['thumb']]) . ('\' style=\'width:70px;border:1px solid #ccc;padding:1px\'>
                        </td>
                        <td style=\'width:220px;\'>' . $item[$options['text']] . '</td>
                        <td>
                        </td>
                        <td>
                            <input class=\'form-control valid\' type=\'text\' value=\'' . $item['couponsnum' . $item['id']] . '\' name=\'couponsnum' . $item[$options['key']] . '\'>
                        </td>
                        <td>
                            <button class=\'btn btn-default\' onclick=\'biz.selector.remove(this,"' . $name . '")\' type=\'button\'><i class=\'fa fa-remove\'></i></button>
                        </td>
                    </tr>
                    ');
			}
			else {
				$html .= '<div class=\'multi-audio-item \' data-' . $options['key'] . '=\'' . $item[$options['key']] . '\' >
                       <div class=\'input-group\'>
                       <input type=\'text\' class=\'form-control img-textname\' readonly=\'\' value=\'' . $item[$options['text']] . '\'>
                       <input type=\'hidden\'  value=\'' . $item[$options['key']] . '\' name=\'' . $id . '\'>
                       <div class=\'input-group-btn\'><button class=\'btn btn-default\' onclick=\'biz.selector.remove(this,"' . $name . '")\' type=\'button\'><i class=\'fa fa-remove\'></i></button>
                       </div></div></div>';
			}
		}

		if ($options['type'] == 'coupon') {
			$html .= '</tbody></table>';
		}
		else if ($options['type'] == 'coupon_cp') {
			$html .= '</tbody></table>';
		}
		else if ($options['type'] == 'coupon_share') {
			$html .= '</tbody></table>';
		}
		else if ($options['type'] == 'coupon_shares') {
			$html .= '</tbody></table>';
		}
		else {
			if ($options['type'] == 'coupon_sync') {
				$html .= '</tbody></table>';
			}
		}

		$html .= '</div></div>';
		return $html;
	}
}

if (!function_exists('tpl_selector_new')) {
	function tpl_selector_new($name, $options = array())
	{
		$options['multi'] = intval($options['multi']);
		$options['buttontext'] = isset($options['buttontext']) ? $options['buttontext'] : '请选择';
		$options['items'] = isset($options['items']) && $options['items'] ? $options['items'] : array();
		$options['readonly'] = isset($options['readonly']) ? $options['readonly'] : true;
		$options['callback'] = isset($options['callback']) ? $options['callback'] : '';
		$options['key'] = isset($options['key']) ? $options['key'] : 'id';
		$options['text'] = isset($options['text']) ? $options['text'] : 'title';
		$options['thumb'] = isset($options['thumb']) ? $options['thumb'] : 'thumb';
		$options['preview'] = isset($options['preview']) ? $options['preview'] : true;
		$options['type'] = isset($options['type']) ? $options['type'] : 'image';
		$options['input'] = isset($options['input']) ? $options['input'] : true;
		$options['required'] = isset($options['required']) ? $options['required'] : false;
		$options['nokeywords'] = isset($options['nokeywords']) ? $options['nokeywords'] : 0;
		$options['placeholder'] = isset($options['placeholder']) ? $options['placeholder'] : '请输入关键词';
		$options['autosearch'] = isset($options['autosearch']) ? $options['autosearch'] : 0;
		$options['optionurl'] = isset($options['optionurl']) ? $options['optionurl'] : '';
		$options['selectorid'] = isset($options['selectorid']) ? $options['selectorid'] : '';

		if (empty($options['items'])) {
			$options['items'] = array();
		}
		else {
			if (!is_array2($options['items'])) {
				$options['items'] = array($options['items']);
			}
		}

		$options['name'] = $name;
		$titles = '';

		foreach ($options['items'] as $item) {
			$titles .= $item[$options['text']];

			if (1 < count($options['items'])) {
				$titles .= '; ';
			}
		}

		$options['value'] = isset($options['value']) ? $options['value'] : $titles;
		$readonly = $options['readonly'] ? 'readonly' : '';
		$required = $options['required'] ? ' data-rule-required="true"' : '';
		$callback = !empty($options['callback']) ? ', ' . $options['callback'] : '';
		$id = $options['multi'] ? $name . '[]' : $name;
		$html = '<div id=\'' . $name . '_selector\' class=\'selector\'
                     data-type="' . $options['type'] . '"
                     data-key="' . $options['key'] . '"
                     data-text="' . $options['text'] . '"
                     data-thumb="' . $options['thumb'] . '"
                     data-multi="' . $options['multi'] . '"
                     data-callback="' . $options['callback'] . '"
                     data-url="' . $options['url'] . '",
                     data-nokeywords="' . $options['nokeywords'] . '" 
                     data-autosearch="' . $options['autosearch'] . '"
                     data-optionurl="' . $options['optionurl'] . '"
                     data-selectorid="' . $options['selectorid'] . '"
 
                 >';

		if ($options['input']) {
			$html .= '<div class=\'input-group\'>' . ('<input type=\'text\' id=\'' . $name . '_text\' name=\'' . $name . '_text\'  value=\'' . $options['value'] . '\' class=\'form-control text\'  ' . $readonly . '  ' . $required . '/>') . '<div class=\'input-group-btn\'>';
		}

		$html .= '<button class=\'btn btn-primary\' type=\'button\' onclick=\'biz.selector_new.select(' . json_encode($options) . (');\'>' . $options['buttontext'] . '</button>');

		if ($options['input']) {
			$html .= '</div>';
			$html .= '</div>';
		}

		$show = $options['preview'] ? '' : ' style=\'display:none\'';

		if ($options['type'] == 'image') {
			$html .= '<div class=\'input-group multi-img-details container\' ' . $show . '>
                    <div id=\'param-items' . $options['selectorid'] . '\' class=\'ui-sortable\'>';
		}
		else if ($options['type'] == 'product') {
			$html .= '<div class=\'input-group multi-audio-details container\' ' . $show . '>
<table class=\'table\' style=\'width:600px;\'>
                    <thead>
                        <tr>
                            <th style=\'width:80px;\'>商品名称</th>
                            <th style=\'width:220px;\'></th>
                            <th>价格/分销佣金</th>
                            <th style=\'width:50px;\'>操作</th>
                        </tr>
                    </thead>
                    <tbody id=\'param-items' . $options['selectorid'] . '\' class=\'ui-sortable\'>';
		}
		else if ($options['type'] == 'fullback') {
			$html .= '<div class=\'input-group multi-audio-details container\' ' . $show . '>
<table class=\'table\' style=\'width:600px;\'>
                    <tbody id=\'param-items' . $options['selectorid'] . '\' class=\'ui-sortable\'>';
		}
		else if ($options['type'] == 'live') {
			$html .= '<div class=\'input-group multi-audio-details container\' ' . $show . '>
<table class=\'table\' style=\'width:600px;\'>
                    <thead>
                        <tr>
                            <th style=\'width:80px;\'>商品名称</th>
                            <th style=\'width:220px;\'></th>
                            <th>直播间价格</th>
                            <th style=\'width:50px;\'>操作</th>
                        </tr>
                    </thead>
                    <tbody id=\'param-items' . $options['selectorid'] . '\' class=\'ui-sortable\'>';
		}
		else {
			$html .= '<div class=\'input-group multi-img-details container\' ' . $show . '>';
		}

		foreach ($options['items'] as $item) {
			if ($options['type'] == 'image') {
				$html .= '<div class=\'multi-item\' data-' . $options['key'] . '=\'' . $item[$options['key']] . '\' data-name=\'' . $name . '\'>
                                      <img class=\'img-responsive img-thumbnail\' src=\'' . tomedia($item[$options['thumb']]) . ('\' >
                                      <div class=\'img-nickname\'>' . $item[$options['text']] . '</div>
                                     <input type=\'hidden\' value=\'' . $item[$options['key']] . '\' name=\'' . $id . '\'>
                                     <em onclick=\'biz.selector_new.remove(this,"' . $name . '")\'  class=\'close\'>×</em>
                         </div>');
			}
			else if ($options['type'] == 'product') {
				if ($item['optiontitle']) {
					$optiontitle = $item['optiontitle'][0]['title'] . '...';
				}
				else {
					$optiontitle = '&yen;' . $item['packageprice'];
				}

				$html .= '
                    <tr class=\'multi-product-item\' data-' . $options['key'] . '=\'' . $item['goodsid'] . '\' >
                        <input type=\'hidden\' class=\'form-control img-textname\' readonly=\'\' value=\'' . $item[$options['text']] . '\'>
                       <input type=\'hidden\'  value=\'' . $item['goodsid'] . '\' name=\'' . $id . '\'>
                        <td style=\'width:80px;\'>
                            <img src=\'' . tomedia($item[$options['thumb']]) . ('\' style=\'width:70px;border:1px solid #ccc;padding:1px\' onerror="this.src=\'../addons/ewei_shopv2/static/images/nopic.png\'">
                        </td>
                        <td style=\'width:220px;\'>' . $item[$options['text']] . '</td>
                        <td>');
				$optionurl = empty($options['optionurl']) ? 'sale/package/hasoption' : str_replace('.', '/', $options['optionurl']);

				if ($item['optiontitle']) {
					$html .= '<a class=\'btn btn-default btn-sm\' data-toggle=\'ajaxModal\' href=\'' . webUrl($optionurl, array('goodsid' => $item['goodsid'], 'pid' => $item['pid'], 'selectorid' => $options['selectorid'])) . ('\' id=\'' . $options['selectorid'] . 'optiontitle') . $item['goodsid'] . '\'>' . $optiontitle . ('</a>
                            <input type=\'hidden\' id=\'' . $options['selectorid'] . 'packagegoods') . $item['goodsid'] . '\' value=\'' . $item['option'] . ('\' name=\'' . $options['selectorid'] . 'packagegoods[') . $item['goodsid'] . ']\'>';

					foreach ($item['optiontitle'] as $option) {
						$total = isset($option['total']) ? ',' . $option['total'] : '';
						$maxbuy = isset($option['maxbuy']) ? ',' . $option['maxbuy'] : '';
						$totalmaxbuy = isset($option['totalmaxbuy']) ? ',' . $option['totalmaxbuy'] : '';
						$html .= '<input type=\'hidden\' value=\'' . $option['packageprice'] . ',' . $option['commission1'] . ',' . $option['commission2'] . ',' . $option['commission3'] . ($total . $maxbuy . $totalmaxbuy . '\'
                        name=\'' . $options['selectorid'] . 'packagegoodsoption') . $option['optionid'] . '\' >';
					}
				}
				else {
					$total = isset($item['total']) ? ',' . $item['total'] : '';
					$maxbuy = isset($item['maxbuy']) ? ',' . $item['maxbuy'] : '';
					$totalmaxbuy = isset($item['totalmaxbuy']) ? ',' . $item['totalmaxbuy'] : '';
					$html .= '<a class=\'btn btn-default btn-sm\' data-toggle=\'ajaxModal\' href=\'' . webUrl($optionurl, array('goodsid' => $item['goodsid'], 'pid' => $item['pid'], 'selectorid' => $options['selectorid'])) . ('\' id=\'' . $options['selectorid'] . 'optiontitle') . $item['goodsid'] . '\'>&yen;' . $item['packageprice'] . ('</a>
                            <input type=\'hidden\' id=\'' . $options['selectorid'] . 'packagegoods') . $item['goodsid'] . ('\' value=\'\' name=\'' . $options['selectorid'] . 'packagegoods[') . $item['goodsid'] . ']\'>
                    <input type=\'hidden\' value=\'' . $item['packageprice'] . ',' . $item['commission1'] . ',' . $item['commission2'] . ',' . $item['commission3'] . ($total . $maxbuy . $totalmaxbuy . '\' name=\'' . $options['selectorid'] . 'packgoods') . $item['goodsid'] . '\' >';
				}

				$html .= '
                        </td>
                        <td><a href=\'javascript:void(0);\' class=\'btn btn-default btn-sm\' onclick=\'biz.selector_new.remove(this,"' . $name . '")\' title=\'删除\'>
                        <i class=\'fa fa-times\'></i></a></td>
                    </tr>';
			}
			else if ($options['type'] == 'fullback') {
				$html .= '
                    <tr class=\'multi-product-item\' data-' . $options['key'] . '=\'' . $item['goodsid'] . '\' >
                        <input type=\'hidden\' class=\'form-control img-textname\' readonly=\'\' value=\'' . $item[$options['text']] . '\'>
                       <input type=\'hidden\'  value=\'' . $item['goodsid'] . '\' name=\'' . $id . '\'>
                        <td style=\'width:80px;\'>
                            <img src=\'' . tomedia($item[$options['thumb']]) . ('\' style=\'width:70px;border:1px solid #ccc;padding:1px\' onerror="this.src=\'../addons/ewei_shopv2/static/images/nopic.png\'">
                        </td>
                        <td style=\'width:220px;\'>' . $item[$options['text']] . '</td>
                        <td>');
				$optionurl = empty($options['optionurl']) ? 'sale/fullback/hasoption' : str_replace('.', '/', $options['optionurl']);

				if (0 < $item['hasoption']) {
					if ($item['type'] == 0) {
						$opcontent = '&yen;' . $item['minallfullbackallprice'] . ' ~ &yen;' . $item['maxallfullbackallprice'];
					}
					else {
						$opcontent = $item['minallfullbackallratio'] . '% ~ ' . $item['maxallfullbackallratio'] . '%';
					}

					$html .= '<a class=\'btn btn-default btn-sm\' data-toggle=\'ajaxModal\' href=\'' . webUrl($optionurl, array('goodsid' => $item['goodsid'], 'id' => $item['id'])) . '\' id=\'optiontitle' . $item['goodsid'] . '\'>' . $opcontent . '</a>
                            <input type=\'hidden\' id=\'fullbackgoods' . $item['goodsid'] . '\' value=\'' . $item['optionid'] . '\' name=\'fullbackgoods[' . $item['goodsid'] . ']\'>';

					foreach ($item['option'] as $option) {
						$html .= '<input type=\'hidden\' value=\'' . $option['allfullbackprice'] . ',' . $option['fullbackprice'] . ',' . $option['allfullbackratio'] . ',' . $option['fullbackratio'] . ',' . $option['day'] . '\'
                        name=\'fullbackgoodsoption' . $option['id'] . '\' >';
					}
				}
				else {
					if ($item['type'] == 0) {
						$content = '&yen;' . $item['minallfullbackallprice'];
					}
					else {
						$content = $item['minallfullbackallratio'] . '%';
					}

					$html .= '<a class=\'btn btn-default btn-sm\' data-toggle=\'ajaxModal\' href=\'' . webUrl($optionurl, array('goodsid' => $item['goodsid'], 'id' => $item['id'])) . ('\' id=\'' . $options['selectorid'] . 'optiontitle') . $item['goodsid'] . '\'>' . $content . '</a>
                            <input type=\'hidden\' id=\'fullbackgoods' . $item['goodsid'] . '\' value=\'\' name=\'fullbackgoods[' . $item['goodsid'] . ']\'>
                    <input type=\'hidden\' value=\'' . $item['minallfullbackallprice'] . ',' . $item['fullbackprice'] . ',' . $item['minallfullbackallratio'] . ',' . $item['fullbackratio'] . ',' . $item['day'] . '\' name=\'goods' . $item['goodsid'] . '\' >';
				}

				$html .= '
                        </td>
                        <td style=\'text-align: right;\'><a href=\'javascript:void(0);\' class=\'btn btn-default btn-sm\' onclick=\'biz.selector_new.remove(this,"' . $name . '")\' title=\'删除\'>
                        <i class=\'fa fa-times\'></i></a></td>
                    </tr>';
			}
			else if ($options['type'] == 'live') {
				$html .= '
                    <tr class=\'multi-product-item\' data-' . $options['key'] . '=\'' . $item['id'] . '\' >
                        <input type=\'hidden\' class=\'form-control img-textname\' readonly=\'\' value=\'' . $item[$options['text']] . '\'>
                       <input type=\'hidden\'  value=\'' . $item['id'] . '\' name=\'' . $id . '\'>
                        <td style=\'width:80px;\'>
                            <img src=\'' . tomedia($item[$options['thumb']]) . ('\' style=\'width:70px;border:1px solid #ccc;padding:1px\' onerror="this.src=\'../addons/ewei_shopv2/static/images/nopic.png\'">
                        </td>
                        <td style=\'width:220px;\'>' . $item[$options['text']] . '</td>
                        <td>');
				$optionurl = empty($options['optionurl']) ? 'live/room/hasoption' : str_replace('.', '/', $options['optionurl']);

				if (0 < $item['hasoption']) {
					$opcontent = '&yen;' . $item['minliveprice'] . ' ~ &yen;' . $item['maxliveprice'];
					$html .= '<a class=\'btn btn-default btn-sm\' data-toggle=\'ajaxModal\' href=\'' . webUrl($optionurl, array('goodsid' => $item['id'], 'id' => $item['liveid'])) . '\' id=\'optiontitle' . $item['id'] . '\'>' . $opcontent . '</a>
                            <input type=\'hidden\' id=\'livegoods' . $item['id'] . '\' value=\'' . $item['optionid'] . '\' name=\'livegoods[' . $item['id'] . ']\'>';

					foreach ($item['option'] as $option) {
						$html .= '<input type=\'hidden\' value=\'' . $option['liveprice'] . '\' name=\'livegoodsoption' . $option['id'] . '\' >';
					}
				}
				else {
					$content = '&yen;' . $item['liveprice'];
					$html .= '<a class=\'btn btn-default btn-sm\' data-toggle=\'ajaxModal\' href=\'' . webUrl($optionurl, array('goodsid' => $item['id'], 'id' => $item['liveid'])) . ('\' id=\'' . $options['selectorid'] . 'optiontitle') . $item['id'] . '\'>' . $content . '</a>
                            <input type=\'hidden\' id=\'livegoods' . $item['id'] . '\' value=\'\' name=\'livegoods[' . $item['id'] . ']\'>
                    <input type=\'hidden\' value=\'' . $item['liveprice'] . '\' name=\'goods' . $item['id'] . '\' >';
				}

				$html .= '
                        </td>
                        <td style=\'text-align: right;\'><a href=\'javascript:void(0);\' class=\'btn btn-default btn-sm\' onclick=\'biz.selector_new.remove(this,"' . $name . '")\' title=\'删除\'>
                        <i class=\'fa fa-times\'></i></a></td>
                    </tr>';
			}
			else {
				$html .= '<div class=\'multi-audio-item \' data-' . $options['key'] . '=\'' . $item[$options['c']] . '\' >
                       <div class=\'input-group\'>
                       <input type=\'text\' class=\'form-control img-textname\' readonly=\'\' value=\'' . $item[$options['text']] . '\'>
                       <input type=\'hidden\'  value=\'' . $item[$options['key']] . '\' name=\'' . $id . '\'>
                       <div class=\'input-group-btn\'><button class=\'btn btn-default\' onclick=\'biz.selector_new.remove(this,"' . $name . '")\' type=\'button\'><i class=\'fa fa-remove\'></i></button>
                       </div></div></div>';
			}
		}

		if ($options['type'] == 'image') {
			$html .= '</div>';
		}

		$html .= '</tbody>
                </table></div></div>';
		return $html;
	}
}

if (!function_exists('tpl_daterange')) {
	function tpl_daterange($name, $value = array(), $time = false)
	{
		global $_GPC;
		$placeholder = isset($value['placeholder']) ? $value['placeholder'] : '';
		$s = '';
		if (empty($time) && !defined('TPL_INIT_DATERANGE_DATE')) {
			$s = '
<script type="text/javascript">
    myrequire(["moment"], function(){
        myrequire(["daterangepicker"], function(){
            $(function(){
                $(".daterange.daterange-date").each(function(){
                    var elm = this;
                    var container =$(elm).parent().prev();
                    $(this).daterangepicker({
                        format: "YYYY-MM-DD"
                    }, function(start, end){
                        $(elm).find(".date-title").html(start.toDateStr() + " 至 " + end.toDateStr());
                        container.find(":input:first").val(start.toDateTimeStr());
                        container.find(":input:last").val(end.toDateTimeStr());
                    });
                });
            });
		});
	});
</script> 
';
			define('TPL_INIT_DATERANGE_DATE', true);
		}

		if (!empty($time) && !defined('TPL_INIT_DATERANGE_TIME')) {
			$s = '
<script type="text/javascript">
    myrequire(["moment"], function(){
        myrequire(["daterangepicker"], function(){
            $(function(){
                $(".daterange.daterange-time").each(function(){
                    var elm = this;
                     var container =$(elm).parent().prev();
                    $(this).daterangepicker({
                        format: "YYYY-MM-DD HH:mm",
                        timePicker: true,
                        timePicker12Hour : false,
                        timePickerIncrement: 1,
                        minuteStep: 1
                    }, function(start, end){
                        $(elm).find(".date-title").html(start.toDateTimeStr() + " 至 " + end.toDateTimeStr());
                        container.find(":input:first").val(start.toDateTimeStr());
                        container.find(":input:last").val(end.toDateTimeStr());
                    });
                });
            });
		});
	});
     function clearTime(obj){
              $(obj).prev().html("<span class=date-title>" + $(obj).attr("placeholder") + "</span>");
              $(obj).parent().prev().find("input").val("");
    }
</script>
';
			define('TPL_INIT_DATERANGE_TIME', true);
		}

		$str = $placeholder;
		$small = isset($value['sm']) ? $value['sm'] : true;
		$value['starttime'] = isset($value['starttime']) ? $value['starttime'] : ($_GPC[$name]['start'] ? $_GPC[$name]['start'] : '');
		$value['endtime'] = isset($value['endtime']) ? $value['endtime'] : ($_GPC[$name]['end'] ? $_GPC[$name]['end'] : '');
		if ($value['starttime'] && $value['endtime']) {
			if (empty($time)) {
				$str = date('Y-m-d', strtotime($value['starttime'])) . '至 ' . date('Y-m-d', strtotime($value['endtime']));
			}
			else {
				$str = date('Y-m-d H:i', strtotime($value['starttime'])) . ' 至 ' . date('Y-m-d  H:i', strtotime($value['endtime']));
			}
		}

		$s .= '<div style="float:left">
	<input name="' . $name . '[start]' . '" type="hidden" value="' . $value['starttime'] . '" />
	<input name="' . $name . '[end]' . '" type="hidden" value="' . $value['endtime'] . '" />
           </div>
          <div class="btn-group ' . ($small ? 'btn-group-sm' : '') . '" style="' . $value['style'] . 'padding-right:0;"  >
          
	<button style="width:240px" class="btn btn-default daterange ' . (!empty($time) ? 'daterange-time' : 'daterange-date') . '"  type="button"><span class="date-title">' . $str . '</span></button>
        <button class="btn btn-default ' . ($small ? 'btn-sm' : '') . '" " type="button" onclick="clearTime(this)" placeholder="' . $placeholder . '"><i class="fa fa-remove"></i></button>
         </div>
	';
		return $s;
	}
}

if (!function_exists('mobileUrl')) {
	function mobileUrl($do = '', $query = NULL, $full = false)
	{
		global $_W;
		global $_GPC;
		!$query && ($query = array());
		$dos = explode('/', trim($do));
		$routes = array();
		$routes[] = $dos[0];

		if (isset($dos[1])) {
			$routes[] = $dos[1];
		}

		if (isset($dos[2])) {
			$routes[] = $dos[2];
		}

		if (isset($dos[3])) {
			$routes[] = $dos[3];
		}

		if (isset($dos[4])) {
			$routes[] = $dos[4];
		}

		$r = implode('.', $routes);

		if (!empty($r)) {
			$query = array_merge(array('r' => $r), $query);
		}

		$query = array_merge(array('do' => 'mobile'), $query);
		$query = array_merge(array('m' => 'ewei_shopv2'), $query);

		if (empty($query['mid'])) {
			$mid = intval($_GPC['mid']);

			if (!empty($mid)) {
				$query['mid'] = $mid;
			}

			if (!empty($_W['openid']) && !is_weixin() && !is_h5app()) {
				$myid = m('member')->getMid();

				if (!empty($myid)) {
					$member = pdo_fetch('select id,isagent,status from' . tablename('ewei_shop_member') . 'where id=' . $myid);
					if (!empty($member['isagent']) && !empty($member['status'])) {
						$query['mid'] = $member['id'];
					}
				}
			}
		}

		if (empty($query['merchid'])) {
			$merchid = intval($_GPC['merchid']);

			if (!empty($merchid)) {
				$query['merchid'] = $merchid;
			}
		}
		else {
			if ($query['merchid'] < 0) {
				unset($query['merchid']);
			}
		}

		if (empty($query['liveid'])) {
			$liveid = intval($_GPC['liveid']);

			if (!empty($liveid)) {
				$query['liveid'] = $liveid;
			}
		}

		if ($full) {
			return $_W['siteroot'] . 'app/' . substr(murl('entry', $query, true), 2);
		}

		return murl('entry', $query, true);
	}
}

if (!function_exists('webUrl')) {
	function webUrl($do = '', $query = array(), $full = true)
	{
		global $_W;
		global $_GPC;

		if (!empty($_W['plugin'])) {
			if ($_W['plugin'] == 'merch') {
				if (function_exists('merchUrl')) {
					return merchUrl($do, $query, $full);
				}
			}

			if ($_W['plugin'] == 'newstore') {
				if (function_exists('newstoreUrl')) {
					return newstoreUrl($do, $query, $full);
				}
			}
		}

		$dos = explode('/', trim($do));
		$routes = array();
		$routes[] = $dos[0];

		if (isset($dos[1])) {
			$routes[] = $dos[1];
		}

		if (isset($dos[2])) {
			$routes[] = $dos[2];
		}

		if (isset($dos[3])) {
			$routes[] = $dos[3];
		}

		$r = implode('.', $routes);

		if (!empty($r)) {
			$query = array_merge(array('r' => $r), $query);
		}

		$query = array_merge(array('do' => 'web'), $query);
		$query = array_merge(array('m' => 'ewei_shopv2'), $query);

		if ($full) {
			return $_W['siteroot'] . 'web/' . substr(wurl('site/entry', $query), 2);
		}

		return wurl('site/entry', $query);
	}
}

if (!function_exists('dump')) {
	function dump()
	{
		$args = func_get_args();

		foreach ($args as $val) {
			echo '<pre style="color: red">';
			var_dump($val);
			echo '</pre>';
		}
	}
}

if (!function_exists('my_scandir')) {
	$my_scenfiles = array();
	function my_scandir($dir)
	{
		global $my_scenfiles;

		if ($handle = opendir($dir)) {
			while (($file = readdir($handle)) !== false) {
				if ($file != '..' && $file != '.') {
					if (is_dir($dir . '/' . $file)) {
						my_scandir($dir . '/' . $file);
					}
					else {
						$my_scenfiles[] = $dir . '/' . $file;
					}
				}
			}

			closedir($handle);
		}
	}
}

if (!function_exists('cut_str')) {
	function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
	{
		if ($code == 'UTF-8') {
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all($pa, $string, $t_string);

			if ($sublen < count($t_string[0]) - $start) {
				return join('', array_slice($t_string[0], $start, $sublen));
			}

			return join('', array_slice($t_string[0], $start, $sublen));
		}

		$start = $start * 2;
		$sublen = $sublen * 2;
		$strlen = strlen($string);
		$tmpstr = '';
		$i = 0;

		while ($i < $strlen) {
			if ($start <= $i && $i < $start + $sublen) {
				if (129 < ord(substr($string, $i, 1))) {
					$tmpstr .= substr($string, $i, 2);
				}
				else {
					$tmpstr .= substr($string, $i, 1);
				}
			}

			if (129 < ord(substr($string, $i, 1))) {
				++$i;
			}

			++$i;
		}

		return $tmpstr;
	}
}

if (!function_exists('save_media')) {
	function save_media($url, $enforceQiniu = false)
	{
		global $_W;
		setting_load('remote');

		if (!empty($_W['setting']['remote']['type'])) {
			if ($_W['setting']['remote']['type'] == ATTACH_FTP) {
				$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['ftp']['url'] . '/';
			}
			else if ($_W['setting']['remote']['type'] == ATTACH_OSS) {
				$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['alioss']['url'] . '/';
			}
			else if ($_W['setting']['remote']['type'] == ATTACH_QINIU) {
				$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['qiniu']['url'] . '/';
			}
			else {
				if ($_W['setting']['remote']['type'] == ATTACH_COS) {
					$_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['cos']['url'] . '/';
				}
			}
		}

		static $com;

		if (!$com) {
			$com = com('qiniu');
		}

		$qiniu = m('common')->getSysset('qiniu');
		$data = $qiniu['user'];
		if ($com && 0 < $data['upload']) {
			$qiniu_url = $com->save($url, NULL, $enforceQiniu);
			if (!empty($qiniu_url) && !is_error($qiniu_url)) {
				return $qiniu_url;
			}
		}
		else {
			$data = m('cache')->getArray('qiniu', 'global');
			$path = IA_ROOT . '/addons/ewei_shopv2/data/global';
			if (empty($data['upload']) && is_file($path . '/qiniu.cache')) {
				$data_authcode = authcode(file_get_contents($path . '/qiniu.cache'), 'DECODE', 'global');
				$data = json_decode($data_authcode, true);
			}

			if ($com && 0 < $data['upload']) {
				$qiniu_url = $com->save($url, $data, $enforceQiniu);
				if (!empty($qiniu_url) && !is_error($qiniu_url)) {
					return $qiniu_url;
				}
			}
		}

		$ext = strrchr($url, '.');
		if ($ext != '.jpeg' && $ext != '.gif' && $ext != '.jpg' && $ext != '.png') {
			return $url;
		}

		if (!empty($_W['setting']['remote']['type']) && !empty($url) && !(strexists($url, 'http:') || strexists($url, 'https:'))) {
			if (is_file(ATTACHMENT_ROOT . $url)) {
				load()->func('file');
				$remotestatus = file_remote_upload($url, false);

				if (!is_error($remotestatus)) {
					$remoteurl = $_W['attachurl_remote'] . $url;
					return $remoteurl;
				}
			}
		}

		if (strexists($url, $_W['siteroot']) && !strexists($url, '/addons/')) {
			$urls = parse_url($url);
			$url = substr($urls['path'], strpos($urls['path'], 'images'));

			if (file_exists(IA_ROOT . '/' . $_W['config']['upload']['attachdir'] . '/' . $url)) {
				return $url;
			}
		}

		return $url;
	}
}

if (!function_exists('tpl_form_field_category_3level')) {
	function tpl_form_field_category_3level($name, $parents, $children, $parentid, $childid, $thirdid)
	{
		$html = '
<script type="text/javascript">
	window._' . $name . ' = ' . json_encode($children) . ';
</script>';

		if (!defined('TPL_INIT_CATEGORY_THIRD')) {
			$html .= '	
<script type="text/javascript">
	  function renderCategoryThird(obj, name){
		var index = obj.options[obj.selectedIndex].value;
		require([\'jquery\', \'util\'], function($, u){
			$selectChild = $(\'#\'+name+\'_child\');
                                                      $selectThird = $(\'#\'+name+\'_third\');
			var html = \'<option value="0">请选择二级分类</option>\';
                                                      var html1 = \'<option value="0">请选择三级分类</option>\';
			if (!window[\'_\'+name] || !window[\'_\'+name][index]) {
				$selectChild.html(html); 
                                                                        $selectThird.html(html1);
				return false;
			}
			for(var i=0; i< window[\'_\'+name][index].length; i++){
				html += \'<option value="\'+window[\'_\'+name][index][i][\'id\']+\'">\'+window[\'_\'+name][index][i][\'name\']+\'</option>\';
			}
			$selectChild.html(html);
                                                    $selectThird.html(html1);
		});
	}
        function renderCategoryThird1(obj, name){
		var index = obj.options[obj.selectedIndex].value;
		require([\'jquery\', \'util\'], function($, u){
			$selectChild = $(\'#\'+name+\'_third\');
			var html = \'<option value="0">请选择三级分类</option>\';
			if (!window[\'_\'+name] || !window[\'_\'+name][index]) {
				$selectChild.html(html);
				return false;
			}
			for(var i=0; i< window[\'_\'+name][index].length; i++){
				html += \'<option value="\'+window[\'_\'+name][index][i][\'id\']+\'">\'+window[\'_\'+name][index][i][\'name\']+\'</option>\';
			}
			$selectChild.html(html);
		});
	}
</script>
			';
			define('TPL_INIT_CATEGORY_THIRD', true);
		}

		$html .= '<div class="row row-fix tpl-category-container">
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		<select class="form-control tpl-category-parent" id="' . $name . '_parent" name="' . $name . '[parentid]" onchange="renderCategoryThird(this,\'' . $name . '\')">
			<option value="0">请选择一级分类</option>';
		$ops = '';

		foreach ($parents as $row) {
			$html .= '
			<option value="' . $row['id'] . '" ' . ($row['id'] == $parentid ? 'selected="selected"' : '') . '>' . $row['name'] . '</option>';
		}

		$html .= '
		</select>
	</div>
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		<select class="form-control tpl-category-child" id="' . $name . '_child" name="' . $name . '[childid]" onchange="renderCategoryThird1(this,\'' . $name . '\')">
			<option value="0">请选择二级分类</option>';
		if (!empty($parentid) && !empty($children[$parentid])) {
			foreach ($children[$parentid] as $row) {
				$html .= '
			<option value="' . $row['id'] . '"' . ($row['id'] == $childid ? 'selected="selected"' : '') . '>' . $row['name'] . '</option>';
			}
		}

		$html .= '
		</select> 
	</div> 
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		<select class="form-control tpl-category-child" id="' . $name . '_third" name="' . $name . '[thirdid]">
			<option value="0">请选择三级分类</option>';
		if (!empty($childid) && !empty($children[$childid])) {
			foreach ($children[$childid] as $row) {
				$html .= '
			<option value="' . $row['id'] . '"' . ($row['id'] == $thirdid ? 'selected="selected"' : '') . '>' . $row['name'] . '</option>';
			}
		}

		$html .= '</select>
	</div>
</div>';
		return $html;
	}
}

if (!function_exists('array_column')) {
	function array_column($input, $column_key, $index_key = NULL)
	{
		$arr = array();

		foreach ($input as $d) {
			if (!isset($d[$column_key])) {
				return NULL;
			}

			if ($index_key !== NULL) {
				return array($d[$index_key] => $d[$column_key]);
			}

			$arr[] = $d[$column_key];
		}

		if ($index_key !== NULL) {
			$tmp = array();

			foreach ($arr as $ar) {
				$tmp[key($ar)] = current($ar);
			}

			$arr = $tmp;
		}

		return $arr;
	}
}

if (!function_exists('is_utf8')) {
	function is_utf8($str)
	{
		return preg_match('%^(?:
            [\\x09\\x0A\\x0D\\x20-\\x7E]              # ASCII
            | [\\xC2-\\xDF][\\x80-\\xBF]             # non-overlong 2-byte
            | \\xE0[\\xA0-\\xBF][\\x80-\\xBF]         # excluding overlongs
            | [\\xE1-\\xEC\\xEE\\xEF][\\x80-\\xBF]{2}  # straight 3-byte
            | \\xED[\\x80-\\x9F][\\x80-\\xBF]         # excluding surrogates
            | \\xF0[\\x90-\\xBF][\\x80-\\xBF]{2}      # planes 1-3
            | [\\xF1-\\xF3][\\x80-\\xBF]{3}          # planes 4-15
            | \\xF4[\\x80-\\x8F][\\x80-\\xBF]{2}      # plane 16
            )*$%xs', $str);
	}
}

if (!function_exists('price_format')) {
	function price_format($price)
	{
		$prices = explode('.', $price);

		if (intval($prices[1]) <= 0) {
			$price = $prices[0];
		}
		else {
			if (isset($prices[1][1]) && $prices[1][1] <= 0) {
				$price = $prices[0] . '.' . $prices[1][0];
			}
		}

		return $price;
	}
}

if (!function_exists('createRedPack')) {
	function createRedPack($money, $sum, $min = 0.01)
	{
		if ($money / $sum < $min) {
			return false;
		}

		$_leftMoneyPackage = array('remainSize' => (int) $sum, 'remainMoney' => round($money, 2));
		$array_money = array();
		$i = 0;

		while ($i < $sum) {
			if ($money / $sum == 0.01) {
				array_push($array_money, 0.01);
				continue;
			}

			if ($_leftMoneyPackage['remainSize'] == 1) {
				--$_leftMoneyPackage['remainSize'];
				array_push($array_money, round($_leftMoneyPackage['remainMoney'], 2));
				break;
			}

			$r = lcg_value();
			$max = $_leftMoneyPackage['remainMoney'] / $_leftMoneyPackage['remainSize'] * 2;
			$tem_money = $r * $max;
			$tem_money = $tem_money <= $min ? 0.01 : $tem_money;
			$tem_money = floor($tem_money * 100) / 100;
			--$_leftMoneyPackage['remainSize'];
			$_leftMoneyPackage['remainMoney'] -= $tem_money;
			array_push($array_money, (double) $tem_money);
			++$i;
		}

		return $array_money;
	}
}

if (!function_exists('redis')) {
	function redis()
	{
		global $_W;
		static $redis;

		if (is_null($redis)) {
			if (!extension_loaded('redis')) {
				return error(-1, 'PHP 未安装 redis 扩展');
			}

			if (!isset($_W['config']['setting']['redis']) && !isset($_W['config']['setting']['ewei_shop_redis'])) {
				return error(-1, '未配置 redis, 请检查 data/config.php 中参数设置');
			}

			$config = isset($_W['config']['setting']['ewei_shop_redis']) ? $_W['config']['setting']['ewei_shop_redis'] : $_W['config']['setting']['redis'];

			if (empty($config['server'])) {
				$config['server'] = '127.0.0.1';
			}

			if (empty($config['port'])) {
				$config['port'] = '6379';
			}

			$redis_temp = new Redis();

			if ($config['pconnect']) {
				$connect = $redis_temp->pconnect($config['server'], $config['port'], $config['timeout']);
			}
			else {
				$connect = $redis_temp->connect($config['server'], $config['port'], $config['timeout']);
			}

			if (!$connect) {
				return error(-1, 'redis 连接失败, 请检查 data/config.php 中参数设置');
			}

			if (!empty($config['requirepass'])) {
				$redis_temp->auth($config['requirepass']);
			}

			try {
				$ping = $redis_temp->ping();
			}
			catch (ErrorException $e) {
				return error(-1, 'redis 无法正常工作，请检查 redis 服务');
			}

			if ($ping != '+PONG') {
				return error(-1, 'redis 无法正常工作，请检查 redis 服务');
			}

			$redis = $redis_temp;
		}
		else {
			try {
				$ping = $redis->ping();
			}
			catch (ErrorException $e) {
				$redis = NULL;
				$redis = redis();
				$ping = $redis->ping();
			}

			if ($ping != '+PONG') {
				$redis = NULL;
				$redis = redis();
			}
		}

		return $redis;
	}
}

if (!function_exists('logg')) {
	function logg($name, $data)
	{
		global $_W;
		$data = is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : $data;
		file_put_contents(IA_ROOT . '/' . $name, $data);
	}
}

if (!function_exists('is_wxerror')) {
	function is_wxerror($data)
	{
		if (!is_array($data) || !array_key_exists('errcode', $data) || array_key_exists('errcode', $data) && $data['errcode'] == 0) {
			return false;
		}

		return true;
	}
}

if (!function_exists('set_wxerrmsg')) {
	function set_wxerrmsg($data)
	{
		$errors = array(-1 => '系统繁忙，此时请稍候再试', 0 => '请求成功', 40001 => '获取access_token时AppSecret错误，或者access_token无效。请认真比对AppSecret的正确性，或查看是否正在为恰当的公众号调用接口', 40002 => '不合法的凭证类型', 40003 => '不合法的OpenID，请确认OpenID（该用户）是否已关注公众号，或是否是其他公众号的OpenID', 40004 => '不合法的媒体文件类型', 40005 => '不合法的文件类型', 40006 => '不合法的文件大小', 40007 => '不合法的媒体文件id', 40008 => '不合法的消息类型', 40009 => '不合法的图片文件大小', 40010 => '不合法的语音文件大小', 40011 => '不合法的视频文件大小', 40012 => '不合法的缩略图文件大小', 40013 => '不合法的AppID，请检查AppID的正确性，避免异常字符，注意大小写', 40014 => '不合法的access_token，请认真比对access_token的有效性（如是否过期），或查看是否正在为恰当的公众号调用接口', 40015 => '不合法的菜单类型', 40016 => '不合法的按钮个数', 40017 => '不合法的按钮个数', 40018 => '不合法的按钮名字长度', 40019 => '不合法的按钮KEY长度', 40020 => '不合法的按钮URL长度', 40021 => '不合法的菜单版本号', 40022 => '不合法的子菜单级数', 40023 => '不合法的子菜单按钮个数', 40024 => '不合法的子菜单按钮类型', 40025 => '不合法的子菜单按钮名字长度', 40026 => '不合法的子菜单按钮KEY长度', 40027 => '不合法的子菜单按钮URL长度', 40028 => '不合法的自定义菜单使用用户', 40029 => '不合法的oauth_code', 40030 => '不合法的refresh_token', 40031 => '不合法的openid列表', 40032 => '不合法的openid列表长度', 40033 => '不合法的请求字符，不能包含\\uxxxx格式的字符', 40035 => '不合法的参数', 40038 => '不合法的请求格式', 40039 => '不合法的URL长度', 40050 => '不合法的分组id', 40051 => '分组名字不合法', 40117 => '分组名字不合法', 40118 => 'media_id大小不合法', 40119 => 'button类型错误', 40120 => 'button类型错误', 40121 => '不合法的media_id类型', 40132 => '微信号不合法', 40137 => '不支持的图片格式', 40155 => '请勿添加其他公众号的主页链接', 41001 => '缺少access_token参数', 41002 => '缺少appid参数', 41003 => '缺少refresh_token参数', 41004 => '缺少secret参数', 41005 => '缺少多媒体文件数据', 41006 => '缺少media_id参数', 41007 => '缺少子菜单数据', 41008 => '缺少oauth code', 41009 => '缺少openid', 42001 => 'access_token超时，请检查access_token的有效期，请参考基础支持-获取access_token中，对access_token的详细机制说明', 42002 => 'refresh_token超时', 42003 => 'oauth_code超时', 42007 => '用户修改微信密码，accesstoken和refreshtoken失效，需要重新授权', 43001 => '需要GET请求', 43002 => '需要POST请求', 43003 => '需要HTTPS请求', 43004 => '需要接收者关注', 43005 => '需要好友关系', 43019 => '需要将接收者从黑名单中移除', 44001 => '多媒体文件为空', 44002 => 'POST的数据包为空', 44003 => '图文消息内容为空', 44004 => '文本消息内容为空', 45001 => '多媒体文件大小超过限制', 45002 => '消息内容超过限制', 45003 => '标题字段超过限制', 45004 => '描述字段超过限制', 45005 => '链接字段超过限制', 45006 => '图片链接字段超过限制', 45007 => '语音播放时间超过限制', 45008 => '图文消息超过限制', 45009 => '接口调用超过限制', 45010 => '创建菜单个数超过限制', 45011 => 'API调用太频繁，请稍候再试', 45015 => '回复时间超过限制', 45016 => '系统分组，不允许修改', 45017 => '分组名字过长', 45018 => '分组数量超过上限', 45047 => '客服接口下行条数超过上限', 46001 => '不存在媒体数据', 46002 => '不存在的菜单版本', 46003 => '不存在的菜单数据', 46004 => '不存在的用户', 47001 => '解析JSON/XML内容错误', 48001 => 'api功能未授权，请确认公众号已获得该接口，可以在公众平台官网-开发者中心页中查看接口权限', 48002 => '粉丝拒收消息（粉丝在公众号选项中，关闭了“接收消息”）', 48004 => 'api接口被封禁，请登录mp.weixin.qq.com查看详情', 48005 => 'api禁止删除被自动回复和自定义菜单引用的素材', 48006 => 'api禁止清零调用次数，因为清零次数达到上限', 50001 => '用户未授权该api', 50002 => '用户受限，可能是违规后接口被封禁', 61451 => '参数错误(invalid parameter)', 61452 => '无效客服账号(invalid kf_account)', 61453 => '客服帐号已存在(kf_account exsited)', 61454 => '客服帐号名长度超过限制(仅允许10个英文字符，不包括@及@后的公众号的微信号)(invalid   kf_acount length)', 61455 => '客服帐号名包含非法字符(仅允许英文+数字)(illegal character in     kf_account)', 61457 => '无效头像文件类型(invalid   file type)', 61450 => '系统错误(system error)', 61500 => '日期格式错误', 65301 => '不存在此menuid对应的个性化菜单', 65302 => '没有相应的用户', 65303 => '没有默认菜单，不能创建个性化菜单', 65304 => 'MatchRule信息为空', 65305 => '个性化菜单数量受限', 65306 => '不支持个性化菜单的帐号', 65307 => '个性化菜单信息为空', 65308 => '包含没有响应类型的button', 65309 => '个性化菜单开关处于关闭状态', 65310 => '填写了省份或城市信息，国家信息不能为空', 65311 => '填写了城市信息，省份信息不能为空', 65312 => '不合法的国家信息', 65313 => '不合法的省份信息', 65314 => '不合法的城市信息', 65316 => '该公众号的菜单设置了过多的域名外跳（最多跳转到3个域名的链接）', 65317 => '不合法的URL', 9001001 => 'POST数据参数不合法', 9001002 => '远端服务不可用', 9001003 => 'Ticket不合法', 9001004 => '获取摇周边用户信息失败', 9001005 => '获取商户信息失败', 9001006 => '获取OpenID失败', 9001007 => '上传文件缺失', 9001008 => '上传素材的文件类型不合法', 9001009 => '上传素材的文件尺寸不合法', 9001010 => '上传失败', 9001020 => '帐号不合法', 9001021 => '已有设备激活率低于50%，不能新增设备', 9001022 => '设备申请数不合法，必须为大于0的数字', 9001023 => '已存在审核中的设备ID申请', 9001024 => '一次查询设备ID数量不能超过50', 9001025 => '设备ID不合法', 9001026 => '页面ID不合法', 9001027 => '页面参数不合法', 9001028 => '一次删除页面ID数量不能超过10', 9001029 => '页面已应用在设备中，请先解除应用关系再删除', 9001030 => '一次查询页面ID数量不能超过50', 9001031 => '时间区间不合法', 9001032 => '保存设备与页面的绑定关系参数错误', 9001033 => '门店ID不合法', 9001034 => '设备备注信息过长', 9001035 => '设备申请参数不合法', 9001036 => '查询起始值begin不合法');

		if (array_key_exists($data['errcode'], $errors)) {
			$data['errmsg'] = $errors[$data['errcode']];
		}

		return $data;
	}
}

if (!function_exists('tpl_form_field_image2')) {
	function tpl_form_field_image2($name, $value = '', $default = '', $options = array())
	{
		global $_W;

		if (empty($default)) {
			$default = '../addons/ewei_shopv2/static/images/nopic.png';
		}

		$val = $default;

		if (!empty($value)) {
			$val = tomedia($value);
		}
		else {
			$val = '../addons/ewei_shopv2/static/images/default-pic.jpg';
		}

		if (!empty($options['global'])) {
			$options['global'] = true;
		}
		else {
			$options['global'] = false;
		}

		if (empty($options['class_extra'])) {
			$options['class_extra'] = '';
		}

		if (isset($options['dest_dir']) && !empty($options['dest_dir'])) {
			if (!preg_match('/^\\w+([\\/]\\w+)?$/i', $options['dest_dir'])) {
				exit('图片上传目录错误,只能指定最多两级目录,如: "we7_store","we7_store/d1"');
			}
		}

		$options['direct'] = true;
		$options['multiple'] = false;

		if (isset($options['thumb'])) {
			$options['thumb'] = !empty($options['thumb']);
		}

		$options['fileSizeLimit'] = intval($GLOBALS['_W']['setting']['upload']['image']['limit']) * 1024;
		$s = '';

		if (!defined('TPL_INIT_IMAGE')) {
			$s = '
		<script type="text/javascript">
			function showImageDialog(elm, opts, options) {
				require(["util"], function(util){
					var btn = $(elm);
					var ipt = btn.parent().prev();
					var val = ipt.val();
					var img = ipt.parent().next().children();
					options = ' . str_replace('"', '\'', json_encode($options)) . ';
					util.image(val, function(url){
						if(url.url){
							if(img.length > 0){
								img.get(0).src = url.url;
								img.closest(".input-group").show();
							}
							ipt.val(url.attachment);
							ipt.attr("filename",url.filename);
							ipt.attr("url",url.url);
						}
						if(url.media_id){
							if(img.length > 0){
								img.get(0).src = "";
							}
							ipt.val(url.media_id);
						}
					}, options);
				});
			}
			function deleteImage(elm){
				require(["jquery"], function($){
					$(elm).prev().attr("src", "../addons/ewei_shopv2/static/images/default-pic.jpg");
					$(elm).parent().prev().find("input").val("");
				});
			}
		</script>';
			define('TPL_INIT_IMAGE', true);
		}

		$s .= '
		<div class="input-group ' . $options['class_extra'] . '">
			<input type="text" name="' . $name . '" value="' . $value . '"' . ($options['extras']['text'] ? $options['extras']['text'] : '') . ' class="form-control" autocomplete="off">
			<span class="input-group-btn">
				<button class="btn btn-primary" type="button" onclick="showImageDialog(this);">选择图片</button>
			</span>
		</div>';
		$s .= '<div class="input-group ' . $options['class_extra'] . '" style="margin-top:.5em;"><img src="' . $val . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail" ' . ($options['extras']['image'] ? $options['extras']['image'] : '') . ' width="150" />
                <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="deleteImage(this)">×</em>
            </div>';
		return $s;
	}
}

if (!function_exists('tpl_form_field_multi_image2')) {
	function tpl_form_field_multi_image2($name, $value = array(), $options = array())
	{
		global $_W;
		$options['multiple'] = true;
		$options['direct'] = false;
		$options['fileSizeLimit'] = intval($GLOBALS['_W']['setting']['upload']['image']['limit']) * 1024;
		if (isset($options['dest_dir']) && !empty($options['dest_dir'])) {
			if (!preg_match('/^\\w+([\\/]\\w+)?$/i', $options['dest_dir'])) {
				exit('图片上传目录错误,只能指定最多两级目录,如: "we7_store","we7_store/d1"');
			}
		}

		$s = '';

		if (!defined('TPL_INIT_MULTI_IMAGE')) {
			$s = '
<script type="text/javascript">
	function uploadMultiImage(elm) {
		var name = $(elm).next().val();
		util.image( "", function(urls){
			$.each(urls, function(idx, url){
				$(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'../addons/ewei_shopv2/static/images/nopic.png\\\'; this.title=\\\'图片未找到.\\\'" src="\'+url.url+\'" class="img-responsive img-thumbnail"><input type="hidden" name="\'+name+\'[]" value="\'+url.attachment+\'"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>\');
			});
		}, ' . json_encode($options) . ');
	}
	function deleteMultiImage(elm){
		require(["jquery"], function($){
			$(elm).parent().remove();
		});
	}
</script>';
			define('TPL_INIT_MULTI_IMAGE', true);
		}

		$s .= '<div class="input-group">
	<input type="text" class="form-control" readonly="readonly" value="" placeholder="批量上传图片" autocomplete="off">
	<span class="input-group-btn">
		<button class="btn btn-primary" type="button" onclick="uploadMultiImage(this);">选择图片</button>
		<input type="hidden" value="' . $name . '" />
	</span>
</div>
<div class="input-group multi-img-details">';
		if (is_array($value) && 0 < count($value)) {
			foreach ($value as $row) {
				$s .= '
<div class="multi-item">
	<img src="' . tomedia($row) . '" onerror="this.src=\'../addons/ewei_shopv2/static/images/nopic.png\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail">
	<input type="hidden" name="' . $name . '[]" value="' . $row . '" >
	<em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em>
</div>';
			}
		}

		$s .= '</div>';
		return $s;
	}
}

if (!function_exists('tpl_form_field_video2')) {
	function tpl_form_field_video2($name, $value = '', $options = array())
	{
		$options['btntext'] = !empty($options['btntext']) ? $options['btntext'] : '选择视频';

		if ($options['disabled']) {
			$options['readonly'] = true;
		}

		$html = '';
		$html .= '<div class="input-group"';

		if ($options['disabled']) {
			$html .= ' style="width: 100%;"';
		}

		$html .= '><input class="form-control" id="select-video-' . $name . '" name="' . $name . '" value="' . $value . '" placeholder="' . $options['placeholder'] . '"';

		if ($options['readonly']) {
			$html .= ' readonly="readonly"';
		}

		$html .= '/>';

		if (!$options['disabled']) {
			$html .= '<span class="input-group-addon btn btn-primary" data-toggle="selectVideo" data-input="#select-video-' . $name . '" data-network="' . $options['network'] . '">' . $options['btntext'] . '</span>';
		}

		$html .= '</div>';
		$html .= '<div class="input-group"><div class="multi-item" style="display: block" title="预览视频" data-toggle="previewVideo" data-input="#select-video-' . $name . '"><div class="img-responsive img-thumbnail img-video" style="width: 100px; height: 100px; position: relative; text-align: center; cursor: pointer;" src=""><i class="fa fa-play-circle" style="font-size: 60px; line-height: 90px; color: #999;"></i></div>';

		if (!$options['disabled']) {
			$html .= '<em class="close" title="移除视频" data-toggle="previewVideoDel" data-element="#select-video-' . $name . '">×</em>';
		}

		$html .= '</div></div>';
		return $html;
	}
}

if (!function_exists('pagination2')) {
	function pagination2($total, $pageIndex, $pageSize = 15, $url = '', $context = array('before' => 3, 'after' => 2, 'ajaxcallback' => '', 'callbackfuncname' => ''))
	{
		global $_W;

		if (empty($_W['shopversion'])) {
			return pagination($total, $pageIndex, $pageSize, $url, $context);
		}

		$pdata = array('tcount' => 0, 'tpage' => 0, 'cindex' => 0, 'findex' => 0, 'pindex' => 0, 'nindex' => 0, 'lindex' => 0, 'options' => '');

		if ($context['ajaxcallback']) {
			$context['isajax'] = true;
		}

		if ($context['callbackfuncname']) {
			$callbackfunc = $context['callbackfuncname'];
		}

		$html = '<div class="pages"><ul class="pagination pagination-centered"><li><span class="nobg">共' . $total . '条记录</span></li></ul>';

		if (empty($_W['shopversion'])) {
			$html = '';
		}

		if (!empty($total)) {
			$pdata['tcount'] = $total;
			$pdata['tpage'] = empty($pageSize) || $pageSize < 0 ? 1 : ceil($total / $pageSize);

			if (1 < $pdata['tpage']) {
				$html .= '<ul class="pagination pagination-centered">';
				$cindex = $pageIndex;
				$cindex = min($cindex, $pdata['tpage']);
				$cindex = max($cindex, 1);
				$pdata['cindex'] = $cindex;
				$pdata['findex'] = 1;
				$pdata['pindex'] = 1 < $cindex ? $cindex - 1 : 1;
				$pdata['nindex'] = $cindex < $pdata['tpage'] ? $cindex + 1 : $pdata['tpage'];
				$pdata['lindex'] = $pdata['tpage'];

				if ($context['isajax']) {
					if (empty($url)) {
						$url = $_W['script_name'] . '?' . http_build_query($_GET);
					}

					$pdata['faa'] = 'href="javascript:;" page="' . $pdata['findex'] . '" ' . ($callbackfunc ? 'onclick="' . $callbackfunc . '(\'' . $url . '\', \'' . $pdata['findex'] . '\', this);return false;"' : '');
					$pdata['paa'] = 'href="javascript:;" page="' . $pdata['pindex'] . '" ' . ($callbackfunc ? 'onclick="' . $callbackfunc . '(\'' . $url . '\', \'' . $pdata['pindex'] . '\', this);return false;"' : '');
					$pdata['naa'] = 'href="javascript:;" page="' . $pdata['nindex'] . '" ' . ($callbackfunc ? 'onclick="' . $callbackfunc . '(\'' . $url . '\', \'' . $pdata['nindex'] . '\', this);return false;"' : '');
					$pdata['laa'] = 'href="javascript:;" page="' . $pdata['lindex'] . '" ' . ($callbackfunc ? 'onclick="' . $callbackfunc . '(\'' . $url . '\', \'' . $pdata['lindex'] . '\', this);return false;"' : '');
				}
				else if ($url) {
					$pdata['jump'] = 'href="?' . str_replace('*', $pdata['lindex'], $url) . '"';
					$pdata['faa'] = 'href="?' . str_replace('*', $pdata['findex'], $url) . '"';
					$pdata['paa'] = 'href="?' . str_replace('*', $pdata['pindex'], $url) . '"';
					$pdata['naa'] = 'href="?' . str_replace('*', $pdata['nindex'], $url) . '"';
					$pdata['laa'] = 'href="?' . str_replace('*', $pdata['lindex'], $url) . '"';
				}
				else {
					$jump_get = $_GET;
					$jump_get['page'] = '';
					$pdata['jump'] = 'href="' . $_W['script_name'] . '?' . http_build_query($jump_get) . $pdata['cindex'] . '" data-href="' . $_W['script_name'] . '?' . http_build_query($jump_get) . '"';
					$_GET['page'] = $pdata['findex'];
					$pdata['faa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
					$_GET['page'] = $pdata['pindex'];
					$pdata['paa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
					$_GET['page'] = $pdata['nindex'];
					$pdata['naa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
					$_GET['page'] = $pdata['lindex'];
					$pdata['laa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
				}

				if (1 < $pdata['cindex']) {
					$html .= '<li><a ' . $pdata['faa'] . ' class="pager-nav">首页</a></li>';
					$html .= '<li><a ' . $pdata['paa'] . ' class="pager-nav">&laquo;上一页</a></li>';
				}

				if (!$context['before'] && $context['before'] != 0) {
					$context['before'] = 3;
				}

				if (!$context['after'] && $context['after'] != 0) {
					$context['after'] = 2;
				}

				if ($context['after'] != 0 && $context['before'] != 0) {
					$range = array();
					$range['start'] = max(1, $pdata['cindex'] - $context['before']);
					$range['end'] = min($pdata['tpage'], $pdata['cindex'] + $context['after']);

					if ($range['end'] - $range['start'] < $context['before'] + $context['after']) {
						$range['end'] = min($pdata['tpage'], $range['start'] + $context['before'] + $context['after']);
						$range['start'] = max(1, $range['end'] - $context['before'] - $context['after']);
					}

					$i = $range['start'];

					while ($i <= $range['end']) {
						if ($context['isajax']) {
							$aa = 'href="javascript:;" page="' . $i . '" ' . ($callbackfunc ? 'onclick="' . $callbackfunc . '(\'' . $url . '\', \'' . $i . '\', this);return false;"' : '');
						}
						else if ($url) {
							$aa = 'href="?' . str_replace('*', $i, $url) . '"';
						}
						else {
							$_GET['page'] = $i;
							$aa = 'href="?' . http_build_query($_GET) . '"';
						}

						$html .= $i == $pdata['cindex'] ? '<li class="active"><a href="javascript:;">' . $i . '</a></li>' : '<li><a ' . $aa . '>' . $i . '</a></li>';
						++$i;
					}
				}

				if ($pdata['cindex'] < $pdata['tpage']) {
					$html .= '<li><a ' . $pdata['naa'] . ' class="pager-nav">下一页&raquo;</a></li>';
					$html .= '<li><a ' . $pdata['laa'] . ' class="pager-nav">尾页</a></li>';
				}

				$html .= '</ul>';

				if (5 < $pdata['tpage']) {
					if ($context['isajax']) {
						$html .= '<ul class="pagination pagination-centered">';
						$html .= '<li><span class=\'input\' style=\'margin-right: 0;\'><input id=\'go\' value=\'' . $pdata['cindex'] . '\' type=\'tel\'/></span></li>';
						$html .= '<li><a  href=\'javascript:;\' onclick=\'ajaxPage()\'  class="pager-nav pager-nav-jump">跳转</a></li>';
						$html .= '</ul>';
						$html .= '<script>function ajaxPage(){var numPage = $("#go").val();' . $callbackfunc . '("' . $url . '",numPage,this)}</script>';
					}
					else {
						$html .= '<ul class="pagination pagination-centered">';
						$html .= '<li><span class=\'input\' style=\'margin-right: 0;\'><input value=\'' . $pdata['cindex'] . '\' type=\'tel\'/></span></li>';
						$html .= '<li><a ' . $pdata['jump'] . ' class="pager-nav pager-nav-jump">跳转</a></li>';
						$html .= '</ul>';
						$html .= '<script>$(function() {$(".pagination .input input").bind("input propertychange", function() {var val=$(this).val(),elm=$(this).closest("ul").find(".pager-nav-jump"),href=elm.data("href");elm.attr("href", href+val)}).on("keydown", function(e) {if (e.keyCode == "13") {var val=$(this).val(),elm=$(this).closest("ul").find(".pager-nav-jump"),href=elm.data("href"); location.href=href+val;}});})</script>';
					}
				}
			}
		}

		$html .= '</div>';
		return $html;
	}
}

if (!function_exists('tpl_form_field_eweishop_daterange')) {
	function tpl_form_field_eweishop_daterange($name, $value = array(), $time = false)
	{
		$s = '';
		if (empty($time) && !defined('TPL_INIT_DATERANGE_DATE')) {
			$s = '
<script type="text/javascript">
    myrequire(["moment"], function(){
        myrequire(["daterangepicker"], function(){
            $(function(){
                $(".daterange.daterange-date").each(function(){
                    var elm = this;
                    $(this).daterangepicker({
                        startDate: $(elm).prev().prev().val(),
                        endDate: $(elm).prev().val(),
                        format: "YYYY-MM-DD"
                    }, function(start, end){
                        $(elm).find(".date-title").html(start.toDateStr() + " 至 " + end.toDateStr());
                        $(elm).prev().prev().val(start.toDateStr());
                        $(elm).prev().val(end.toDateStr());
                    });
                });
            });
		});
	});
</script>
';
			define('TPL_INIT_DATERANGE_DATE', true);
		}

		if (!empty($time) && !defined('TPL_INIT_DATERANGE_TIME')) {
			$s = '
<script type="text/javascript">
    myrequire(["moment"], function(){
        myrequire(["daterangepicker"], function(){
            $(function(){
                $(".daterange.daterange-time").each(function(){
                    var elm = this;
                    $(this).daterangepicker({
                        startDate: $(elm).prev().prev().val(),
                        endDate: $(elm).prev().val(),
                        format: "YYYY-MM-DD HH:mm",
                        timePicker: true,
                        timePicker12Hour : false,
                        timePickerIncrement: 1,
                        minuteStep: 1
                    }, function(start, end){
                        $(elm).find(".date-title").html(start.toDateTimeStr() + " 至 " + end.toDateTimeStr());
                        $(elm).prev().prev().val(start.toDateTimeStr());
                        $(elm).prev().val(end.toDateTimeStr());
                    });
                });
            });
		});
	});
</script>
';
			define('TPL_INIT_DATERANGE_TIME', true);
		}

		if ($value['starttime'] !== false && $value['start'] !== false) {
			if ($value['start']) {
				$value['starttime'] = empty($time) ? date('Y-m-d', strtotime($value['start'])) : date('Y-m-d H:i', strtotime($value['start']));
			}

			$value['starttime'] = empty($value['starttime']) ? (empty($time) ? date('Y-m-d') : date('Y-m-d H:i')) : $value['starttime'];
		}
		else {
			$value['starttime'] = '请选择';
		}

		if ($value['endtime'] !== false && $value['end'] !== false) {
			if ($value['end']) {
				$value['endtime'] = empty($time) ? date('Y-m-d', strtotime($value['end'])) : date('Y-m-d H:i', strtotime($value['end']));
			}

			$value['endtime'] = empty($value['endtime']) ? $value['starttime'] : $value['endtime'];
		}
		else {
			$value['endtime'] = '请选择';
		}

		$s .= '
	<input name="' . $name . '[start]' . '" type="hidden" value="' . $value['starttime'] . '" />
	<input name="' . $name . '[end]' . '" type="hidden" value="' . $value['endtime'] . '" />
	<button class="btn btn-default daterange ' . (!empty($time) ? 'daterange-time' : 'daterange-date') . '" type="button"><span class="date-title">' . $value['starttime'] . ' 至 ' . $value['endtime'] . '</span> <i class="fa fa-calendar"></i></button>
	';
		return $s;
	}
}

if (!function_exists('tpl_form_field_eweishop_date')) {
	function tpl_form_field_eweishop_date($name, $value = '', $withtime = false)
	{
		$s = '';
		$withtime = empty($withtime) ? false : true;

		if (!empty($value)) {
			$value = strexists($value, '-') ? strtotime($value) : $value;
		}
		else {
			$value = TIMESTAMP;
		}

		$value = $withtime ? date('Y-m-d H:i:s', $value) : date('Y-m-d', $value);
		$s .= '<input type="text" name="' . $name . '"  value="' . $value . '" placeholder="请选择日期时间" readonly="readonly" class="datetimepicker form-control" style="padding-left:12px;" />';
		$s .= '
		<script type="text/javascript">
		    myrequire(["moment"], function(){
                myrequire(["datetimepicker"], function(){
                        var option = {
                            lang : "zh",
                            step : 5,
                            timepicker : ' . (!empty($withtime) ? 'true' : 'false') . ',
                            closeOnDateSelect : true,
                            format : "Y-m-d' . (!empty($withtime) ? ' H:i"' : '"') . '
                        };
                    $(".datetimepicker[name = \'' . $name . '\']").datetimepicker(option);
                });
			});
		</script>';
		return $s;
	}
}

if (!function_exists('tpl_form_field_editor')) {
	function tpl_form_field_editor($params = array(), $callback = NULL)
	{
		$html = '<span class="form-editor-group">';
		$html .= '<span class="form-control-static form-editor-show">';
		$html .= '<a class="form-editor-text">' . $params['value'] . '</a>';
		$html .= '<a class="text-primary form-editor-btn">修改</a>';
		$html .= '</span>';
		$html .= '<span class="input-group form-editor-edit">';
		$html .= '<input class="form-control form-editor-input" value="' . $params['value'] . '" name="' . $params['name'] . '"';

		if (!empty($params['placeholder'])) {
			$html .= 'placeholder="' . $params['placeholder'] . '"';
		}

		if (!empty($params['id'])) {
			$html .= 'id="' . $params['id'] . '"';
		}

		if (!empty($params['data-rule-required']) || !empty($params['required'])) {
			$html .= ' data-rule-required="true"';
		}

		if (!empty($params['data-msg-required'])) {
			$html .= ' data-msg-required="' . $params['data-msg-required'] . '"';
		}

		$html .= ' /><span class="input-group-btn">';
		$html .= '<span class="btn btn-default form-editor-finish"';

		if ($callback) {
			$html .= 'data-callback="' . $callback . '"';
		}

		$html .= '><i class="icow icow-wancheng"></i></span>';
		$html .= '</span>';
		$html .= '</span>';
		return $html;
	}
}

if (!function_exists('tpl_form_field_textarea')) {
	function tpl_form_field_textarea($params = array(), $callback = NULL)
	{
		$html = '<span class="form-editor-group">';
		$html .= '<span class="form-control-static form-editor-show">';
		$html .= '<a class="form-editor-text"></a>';
		$html .= '<a class="text-primary form-editor-btn">修改</a>';
		$html .= '</span>';
		$html .= '<span class="input-group form-editor-edit">';
		$html .= '<textarea class="form-control" name="' . $params['name'] . '" style="height:auto;" rows="' . $params['rows'] . '"';

		if (!empty($params['placeholder'])) {
			$html .= 'placeholder="' . $params['placeholder'] . '"';
		}

		if (!empty($params['id'])) {
			$html .= 'id="' . $params['id'] . '"';
		}

		if (!empty($params['data-rule-required']) || !empty($params['required'])) {
			$html .= ' data-rule-required="true"';
		}

		if (!empty($params['data-msg-required'])) {
			$html .= ' data-msg-required="' . $params['data-msg-required'] . '"';
		}

		$html .= '>' . $params['value'] . '</textarea><span class="input-group-btn">';
		$html .= '<span class="btn btn-default form-editor-finish"';

		if ($callback) {
			$html .= 'data-callback="' . $callback . '"';
		}

		$html .= '><i class="icow icow-wancheng"></i></span>';
		$html .= '</span>';
		$html .= '</span>';
		return $html;
	}
}

if (!function_exists('tpl_form_field_position')) {
	function tpl_form_field_position($field, $value = array())
	{
		$s = '';

		if (!defined('TPL_INIT_COORDINATE')) {
			$s .= '<script type="text/javascript">
                    function showCoordinate(elm) {
                        
                            var val = {};
                            val.lng = parseFloat($(elm).parent().prev().prev().find(":text").val());
                            val.lat = parseFloat($(elm).parent().prev().find(":text").val());
                            val = biz.BdMapToTxMap(val.lat,val.lng);
                            biz.map(val, function(r){
                                var address_label = $("#address_label");
                                if (address_label.length>0)
                                {
                                    address_label.val(r.label);
                                }
                                r = biz.TxMapToBdMap(r.lat,r.lng);
                                $(elm).parent().prev().prev().find(":text").val(r.lng);
                                $(elm).parent().prev().find(":text").val(r.lat);
                            },"' . EWEI_SHOPV2_URL . 'template/web/util/area/map.html' . '");
    }
    
                </script>';
			define('TPL_INIT_COORDINATE', true);
		}

		$s .= '
            <div class="row row-fix">
                <div class="col-xs-4 col-sm-4">
                    <input type="text" name="' . $field . '[lng]" value="' . $value['lng'] . '" placeholder="地理经度"  class="form-control" />
                </div>
                <div class="col-xs-4 col-sm-4">
                    <input type="text" name="' . $field . '[lat]" value="' . $value['lat'] . '" placeholder="地理纬度"  class="form-control" />
                </div>
                <div class="col-xs-4 col-sm-4">
                    <button onclick="showCoordinate(this);" class="btn btn-default" type="button">选择坐标</button>
                </div>
            </div>';
		return $s;
	}
}

if (!function_exists('tpl_goods_selector')) {
	function tpl_goods_selector($name, $data_gs = '', $option = array())
	{
		global $_W;
		$condition = base64_encode($option['condition']);

		if (is_array($data_gs)) {
			$data_gs = json_encode($data_gs);
		}
		else {
			json_decode($data_gs);
			if (json_last_error() != JSON_ERROR_NONE || empty($data_gs)) {
				$data_gs = '{}';
			}
		}

		$ophtml = '';

		if (!empty($option['ophtml'])) {
			$ophtml = $option['ophtml'];
		}

		$name_id = 'goods_selector_' . $name;

		if (!empty($option['url'])) {
			$post_url = $option['url'];
		}

		if (!empty($option['merchid'])) {
			$_merchid = $option['merchid'];
		}

		$_type = '';

		if (!empty($option['type'])) {
			$_type = $option['type'];
		}

		$data = json_decode($data_gs, 1);
		$data_arr = array();

		foreach ($data as $value) {
			$data_arr[$value['id']] = $value;

			if (!empty($value['options'])) {
				$data_arr[$value['id']]['options'] = array();

				foreach ($value['options'] as $op) {
					$data_arr[$value['id']]['options'][$op['id']] = $op;
				}
			}
		}

		$data_gs = json_encode($data_arr);

		if (empty($data_arr)) {
			$data_gs = '{}';
		}

		$path = IA_ROOT . '/addons/ewei_shopv2/template/web_v3/util/tpl_goods_selector.html';
		include $path;
		$_W['goods_selector_js'] = 1;
	}
}

if (!function_exists('get_wxpay_sign')) {
	function get_wxpay_sign($data, $key)
	{
		$data = array_filter($data);
		ksort($data);
		$string_a = http_build_query($data);
		$string_a = urldecode($string_a);
		$string_sign_temp = $string_a . '&key=' . $key;
		$sign = md5($string_sign_temp);
		$result = strtoupper($sign);
		return $result;
	}
}

if (!function_exists('redis_getarr')) {
	function redis_getarr($key)
	{
		$open_redis = function_exists('redis') && !is_error(redis());
		if ($open_redis && !empty($key)) {
			$redis = redis();
			$data = $redis->get($key);

			if (!empty($data)) {
				$data = json_decode($data, true);
				return $data;
			}
		}

		return false;
	}
}

if (!function_exists('redis_setarr')) {
	function redis_setarr($key, $data, $timeout = 60)
	{
		$open_redis = function_exists('redis') && !is_error(redis());
		if ($open_redis && !empty($key) && !empty($data)) {
			$redis = redis();
			$data = json_encode($data);
			$redis->set($key, $data, $timeout);
		}
	}
}
/**
 * 插入任务
 * @param $job
 * @param int $delay
 * @param int $priority
 * @return mixed
 */
function queue_push($job, $delay = 0, $priority = 1024)
{
    pdo_insert("ewei_shop_queue", array("channel" => "queue", "job" => serialize($job), "pushed_at" => time(), "ttr" => NULL, "delay" => $delay, "priority" => $priority));
    return pdo_insertid();
}
function auth_user($siteid, $domain) {
    $ret = cloud_upgrade('user', array('website' => $siteid,'domain'=> $domain));
    return $ret;
}

function auth_checkauth($auth){
    $ret = cloud_upgrade('checkauth', array('code' => $auth['code']));
    return $ret;
}

function auth_grant($data) {
    $ret = cloud_upgrade('grant', $data);
    return $ret;
}

function auth_check($auth,$version,$release){
    $ret = cloud_upgrade('check', array('version' => $version,'release' => $release,'code' => $auth['code']));
    return $ret;
}

function auth_download($auth,$path){
    $ret = cloud_upgrade('download', array('path' => $path,'code' => $auth['code']));
    return $ret;
}

function auth_downaddress($auth){
    $ret = cloud_upgrade('downaddress', array('code' => $auth['code']));
    return $ret;
}

function auth_upaddress($auth,$data){
    $ret = cloud_upgrade('upaddress', array('code' => $auth['code'],'data' => $data));
    return $ret;
}

function cloud_upgrade($type, $post_data = array(), $timeout = 60)
{
    global $_W;

    load()->func('communication');

    $domain = trim(preg_replace("/http(s)?:\/\//", "", rtrim($_W['siteroot'],"/")));
    $extra['CURLOPT_REFERER'] = $domain;
    $ip = getIP();
    $post_data['type'] = $type;
    $post_data['module'] = $_W['current_module']['name'];
    $resp = ihttp_request("http://vip.zhifun.cc/api/newapi.php", $post_data, $extra, $ip, $timeout);
    $ret  = @json_decode($resp['content'], true);
    return $ret;
}
$GLOBALS['_W']['config']['db']['tablepre'] = empty($GLOBALS['_W']['config']['db']['tablepre']) ? $GLOBALS['_W']['config']['db']['master']['tablepre'] : $GLOBALS['_W']['config']['db']['tablepre'];
function db_table_schema_ab($db, $tablename = '') {
    $result = $db->fetch("SHOW TABLE STATUS LIKE '" . trim($db->tablename($tablename), '`') . "'");
    if (empty($result) || empty($result['Create_time'])) {
        return array();
    }
    $ret['tablename'] = $result['Name'];
    $ret['charset'] = $result['Collation'];
    $ret['engine'] = $result['Engine'];
    $ret['increment'] = $result['Auto_increment'];
    $result = $db->fetchall("SHOW FULL COLUMNS FROM " . $db->tablename($tablename));
    foreach ($result as $value) {
        $temp = array();
        $type = explode(" ", $value['Type'], 2);
        $temp['name'] = $value['Field'];
        $pieces = explode('(', $type[0], 2);
        $temp['type'] = $pieces[0];
        $temp['length'] = rtrim($pieces[1], ')');
        $temp['null'] = $value['Null'] != 'NO';
        $temp['signed'] = empty($type[1]);
        $temp['increment'] = $value['Extra'] == 'auto_increment';
        $ret['fields'][$value['Field']] = $temp;
    }
    $result = $db->fetchall("SHOW INDEX FROM " . $db->tablename($tablename));
    foreach ($result as $value) {
        $ret['indexes'][$value['Key_name']]['name'] = $value['Key_name'];
        $ret['indexes'][$value['Key_name']]['type'] = ($value['Key_name'] == 'PRIMARY') ? 'primary' : ($value['Non_unique'] == 0 ? 'unique' : ($value['Index_type'] == 'FULLTEXT' ? "FULLTEXT" : "index"));
        $ret['indexes'][$value['Key_name']]['fields'][] = $value['Column_name'];
        if (!empty($value['Sub_part'])) {
            $ret['indexes'][$value['Key_name']]['length'] = $value['Sub_part'];
        }
    }
    return $ret;
}
function db_table_serialize_ab($db, $dbname) {
    $tables = $db->fetchall('SHOW TABLES');
    if (empty($tables)) {
        return '';
    }
    $struct = array();
    foreach ($tables as $value) {
        $structs[] = db_table_schema_ab($db, substr($value['Tables_in_' . $dbname], strpos($value['Tables_in_' . $dbname], '_') + 1));
    }
    return iserializer($structs);
}
function db_table_create_sqll_ab($schema) {
    $pieces = explode('_', $schema['charset']);
    $charset = $pieces[0];
    $engine = $schema['engine'];
    $schema['tablename'] = str_replace('ims_', $GLOBALS['_W']['config']['db']['tablepre'], $schema['tablename']);
    $sql = "CREATE TABLE IF NOT EXISTS `{$schema['tablename']}` (\n";
    foreach ($schema['fields'] as $value) {
        $piece = _db_build_field_sql_ab($value);
        $sql.= "`{$value['name']}` {$piece},\n";
    }
    foreach ($schema['indexes'] as $value) {
        $fields = implode('`,`', $value['fields']);
        if ($value['type'] == 'index') {
            if (!empty($value['length'])) {
                $sql.= "KEY `{$value['name']}` (`{$fields}`({$value['length']})),\n";
            } else {
                $sql.= "KEY `{$value['name']}` (`{$fields}`),\n";
            }
        }
        if ($value['type'] == 'unique') {
            $sql.= "UNIQUE KEY `{$value['name']}` (`{$fields}`),\n";
        }
        if ($value['type'] == 'primary') {
            $sql.= "PRIMARY KEY (`{$fields}`),\n";
        }
        if ($value['type'] == 'FULLTEXT') {
            $sql.= "FULLTEXT KEY `{$value['name']}` (`{$fields}`),\n";
        }
    }
    $sql = rtrim($sql);
    $sql = rtrim($sql, ',');
    $sql.= "\n) ENGINE=$engine DEFAULT CHARSET=$charset;\n\n";
    return $sql;
}
function db_schema_comparel_ab($table1, $table2) {
    $table1['charset'] == $table2['charset'] ? '' : $ret['diffs']['charset'] = true;
    $fields1 = array_keys($table1['fields']);
    $fields2 = array_keys($table2['fields']);
    $diffs = array_diff($fields1, $fields2);
    if (!empty($diffs)) {
        $ret['fields']['greater'] = array_values($diffs);
    }
    $diffs = array_diff($fields2, $fields1);
    if (!empty($diffs)) {
        $ret['fields']['less'] = array_values($diffs);
    }
    $diffs = array();
    $intersects = array_intersect($fields1, $fields2);
    if (!empty($intersects)) {
        foreach ($intersects as $field) {
            if ($table1['fields'][$field] != $table2['fields'][$field]) {
                $diffs[] = $field;
            }
        }
    }
    if (!empty($diffs)) {
        $ret['fields']['diff'] = array_values($diffs);
    }
    $indexes1 = array_keys($table1['indexes']);
    $indexes2 = array_keys($table2['indexes']);
    $diffs = array_diff($indexes1, $indexes2);
    if (!empty($diffs)) {
        $ret['indexes']['greater'] = array_values($diffs);
    }
    $diffs = array_diff($indexes2, $indexes1);
    if (!empty($diffs)) {
        $ret['indexes']['less'] = array_values($diffs);
    }
    $diffs = array();
    $intersects = array_intersect($indexes1, $indexes2);
    if (!empty($intersects)) {
        foreach ($intersects as $index) {
            if ($table1['indexes'][$index] != $table2['indexes'][$index]) {
                $diffs[] = $index;
            }
        }
    }
    if (!empty($diffs)) {
        $ret['indexes']['diff'] = array_values($diffs);
    }
    return $ret;
}
function db_table_fix_sql_ab($schema1, $schema2, $strict = false) {
    if (empty($schema1)) {
        return array(db_table_create_sqll_ab($schema2));
    }
    $diff = $result = db_schema_comparel_ab($schema1, $schema2);
    if (!empty($diff['diffs']['tablename'])) {
        return array(db_table_create_sqll_ab($schema2));
    }
    $sqls = array();
    if (!empty($diff['diffs']['engine'])) {
        $sqls[] = "ALTER TABLE `{$schema1['tablename']}` ENGINE = {$schema2['engine']}";
    }
    if (!empty($diff['diffs']['charset'])) {
        $pieces = explode('_', $schema2['charset']);
        $charset = $pieces[0];
        $sqls[] = "ALTER TABLE `{$schema1['tablename']}` DEFAULT CHARSET = {$charset}";
    }
    if (!empty($diff['fields'])) {
        if (!empty($diff['fields']['less'])) {
            foreach ($diff['fields']['less'] as $fieldname) {
                $field = $schema2['fields'][$fieldname];
                $piece = _db_build_field_sql_ab($field);
                if (!empty($field['rename']) && !empty($schema1['fields'][$field['rename']])) {
                    $sql = "ALTER TABLE `{$schema1['tablename']}` CHANGE `{$field['rename']}` `{$field['name']}` {$piece}";
                    unset($schema1['fields'][$field['rename']]);
                } else {
                    if ($field['position']) {
                        $pos = ' ' . $field['position'];
                    }
                    $sql = "ALTER TABLE `{$schema1['tablename']}` ADD `{$field['name']}` {$piece}{$pos}";
                }
                $primary = array();
                $isincrement = array();
                if (strexists($sql, 'AUTO_INCREMENT')) {
                    $isincrement = $field;
                    $sql = str_replace('AUTO_INCREMENT', '', $sql);
                    foreach ($schema1['fields'] as $field) {
                        if ($field['increment'] == 1) {
                            $primary = $field;
                            break;
                        }
                    }
                    if (!empty($primary)) {
                        $piece = _db_build_field_sql_ab($primary);
                        if (!empty($piece)) {
                            $piece = str_replace('AUTO_INCREMENT', '', $piece);
                        }
                        $sqls[] = "ALTER TABLE `{$schema1['tablename']}` CHANGE `{$primary['name']}` `{$primary['name']}` {$piece}";
                    }
                }
                $sqls[] = $sql;
            }
        }
        if (!empty($diff['fields']['diff'])) {
            foreach ($diff['fields']['diff'] as $fieldname) {
                $field = $schema2['fields'][$fieldname];
                $piece = _db_build_field_sql_ab($field);
                if (!empty($schema1['fields'][$fieldname])) {
                    $sqls[] = "ALTER TABLE `{$schema1['tablename']}` CHANGE `{$field['name']}` `{$field['name']}` {$piece}";
                }
            }
        }
        if ($strict && !empty($diff['fields']['greater'])) {
            foreach ($diff['fields']['greater'] as $fieldname) {
                if (!empty($schema1['fields'][$fieldname])) {
                    $sqls[] = "ALTER TABLE `{$schema1['tablename']}` DROP `{$fieldname}`";
                }
            }
        }
    }
    if (!empty($diff['indexes'])) {
        if (!empty($diff['indexes']['less'])) {
            foreach ($diff['indexes']['less'] as $indexname) {
                $index = $schema2['indexes'][$indexname];
                $piece = _db_build_index_sql_ab($index);
                $sqls[] = "ALTER TABLE `{$schema1['tablename']}` ADD {$piece}";
            }
        }
        if (!empty($diff['indexes']['diff'])) {
            foreach ($diff['indexes']['diff'] as $indexname) {
                $index = $schema2['indexes'][$indexname];
                $piece = _db_build_index_sql_ab($index);
                $sqls[] = "ALTER TABLE `{$schema1['tablename']}` DROP " . ($indexname == 'PRIMARY' ? " PRIMARY KEY " : ($index['type'] == "FULLTEXT" ? "FULLTEXT " : "INDEX {$indexname}")) . ", ADD {$piece}";
            }
        }
        if ($strict && !empty($diff['indexes']['greater'])) {
            foreach ($diff['indexes']['greater'] as $indexname) {
                $sqls[] = "ALTER TABLE `{$schema1['tablename']}` DROP `{$indexname}`";
            }
        }
    }
    if (!empty($isincrement)) {
        $piece = _db_build_field_sql_ab($isincrement);
        $sqls[] = "ALTER TABLE `{$schema1['tablename']}` CHANGE `{$isincrement['name']}` `{$isincrement['name']}` {$piece}";
    }
    return $sqls;
}
function _db_build_index_sql_ab($index) {
    $piece = '';
    $fields = implode('`,`', $index['fields']);
    if ($index['type'] == 'index') {
        if (!empty($index['length'])) {
            $piece.= "KEY `{$index['name']}` (`{$fields}`({$index['length']}))";
        } else {
            $piece.= "KEY `{$index['name']}` (`{$fields}`)";
        }
        //$piece .= " INDEX `{$index['name']}` (`{$fields}`)";
        
    }
    if ($index['type'] == 'unique') {
        $piece.= "UNIQUE `{$index['name']}` (`{$fields}`)";
    }
    if ($index['type'] == 'primary') {
        $piece.= "PRIMARY KEY (`{$fields}`)";
    }
    if ($value['type'] == 'FULLTEXT') {
        $$piece.= "FULLTEXT KEY `{$index['name']}` (`{$fields[0]}`)";
    }
    return $piece;
}
function _db_build_field_sql_ab($field) {
    if (!empty($field['length'])) {
        $length = "({$field['length']})";
    } else {
        $length = '';
    }
    $signed = empty($field['signed']) ? ' unsigned' : '';
    if (empty($field['null'])) {
        $null = ' NOT NULL';
    } else {
        $null = '';
    }
    if (isset($field['default'])) {
        $default = " DEFAULT '" . $field['default'] . "'";
    } else {
        $default = '';
    }
    if ($field['increment']) {
        $increment = ' AUTO_INCREMENT';
    } else {
        $increment = '';
    }
    return "{$field['type']}{$length}{$signed}{$null}{$default}{$increment}";
}