<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Page extends WeModuleSite
{
	public function runTasks()
	{
		global $_W;
		load()->func('communication');
		$lasttime = strtotime(m('cache')->getString('receive', 'global'));
		$interval = intval(m('cache')->getString('receive_time', 'global'));

		if (empty($interval)) {
			$interval = 60;
		}

		$interval *= 60;
		$current = time();

		if ($lasttime + $interval <= $current) {
			m('cache')->set('receive', date('Y-m-d H:i:s', $current), 'global');
			var_dump(ihttp_request(EWEI_SHOPV2_TASK_URL . 'order/receive.php', NULL, NULL, 10));
		}

		$lasttime = strtotime(m('cache')->getString('closeorder', 'global'));
		$interval = intval(m('cache')->getString('closeorder_time', 'global'));

		if (empty($interval)) {
			$interval = 60;
		}

		$interval *= 60;
		$current = time();

		if ($lasttime + $interval <= $current) {
			m('cache')->set('closeorder', date('Y-m-d H:i:s', $current), 'global');
			ihttp_request(EWEI_SHOPV2_TASK_URL . 'order/close.php', NULL, NULL, 10);
		}

		$lasttime = strtotime(m('cache')->getString('closeorder_virtual', 'global'));
		$interval_v = intval(m('cache')->getString('closeorder_virtual_time', 'global'));

		if (empty($interval_v)) {
			$interval_v = 60;
		}

		$current = time();

		if ($lasttime + $interval_v <= $current) {
			m('cache')->set('closeorder_virtual', date('Y-m-d H:i:s', $current), 'global');
			ihttp_request(EWEI_SHOPV2_TASK_URL . 'order/close.php', array('uniacid' => $_W['uniacid']), NULL, 10);
		}

		$lasttime = strtotime(m('cache')->getString('fullback_receive', 'global'));
		$interval = intval(m('cache')->getString('fullback_receive_time', 'global'));

		if (empty($interval)) {
			$interval = 60;
		}

		$interval *= 60;
		$current = time();

		if ($lasttime + $interval <= $current) {
			m('cache')->set('fullback_receive', date('Y-m-d H:i:s', $current), 'global');
			ihttp_request(EWEI_SHOPV2_TASK_URL . 'order/fullback.php', NULL, NULL, 10);
		}

		$lasttime = strtotime(m('cache')->getString('presell_status', 'global'));
		$interval = intval(m('cache')->getString('presell_status_time', 'global'));

		if (empty($interval)) {
			$interval = 60;
		}

		$interval *= 60;
		$current = time();

		if ($lasttime + $interval <= $current) {
			m('cache')->set('presell_status', date('Y-m-d H:i:s', $current), 'global');
			ihttp_request(EWEI_SHOPV2_TASK_URL . 'goods/presell.php', NULL, NULL, 10);
		}

		$lasttime = strtotime(m('cache')->getString('status_receive', 'global'));
		$interval = intval(m('cache')->getString('status_receive_time', 'global'));

		if (empty($interval)) {
			$interval = 60;
		}

		$interval *= 60;
		$current = time();

		if ($lasttime + $interval <= $current) {
			m('cache')->set('status_receive', date('Y-m-d H:i:s', $current), 'global');
			ihttp_request(EWEI_SHOPV2_TASK_URL . 'goods/status.php', NULL, NULL, 10);
		}

		if (com('coupon')) {
			$lasttime = strtotime(m('cache')->getString('willcloseorder', 'global'));
			$interval = intval(m('cache')->getString('willcloseorder_time', 'global'));

			if (empty($interval)) {
				$interval = 20;
			}

			$interval *= 60;
			$current = time();

			if ($lasttime + $interval <= $current) {
				m('cache')->set('willcloseorder', date('Y-m-d H:i:s', $current), 'global');
				ihttp_request(EWEI_SHOPV2_TASK_URL . 'order/willclose.php', NULL, NULL, 10);
			}
		}

		if (com('coupon')) {
			$lasttime = strtotime(m('cache')->getString('couponback', 'global'));
			$interval = intval(m('cache')->getString('couponback_time', 'global'));

			if (empty($interval)) {
				$interval = 60;
			}

			$interval *= 60;
			$current = time();

			if ($lasttime + $interval <= $current) {
				m('cache')->set('couponback', date('Y-m-d H:i:s', $current), 'global');
				ihttp_request(EWEI_SHOPV2_TASK_URL . 'coupon/back.php', NULL, NULL, 10);
			}
		}

		$lasttime = strtotime(m('cache')->getString('sendnotice', 'global'));
		$interval = intval(m('cache')->getString('sendnotice_time', 'global'));

		if (empty($interval)) {
			$interval = 60;
		}

		$interval *= 60;
		$current = time();

		if ($lasttime + $interval <= $current) {
			m('cache')->set('sendnotice', date('Y-m-d H:i:s', $current), 'global');
			ihttp_request(EWEI_SHOPV2_TASK_URL . 'notice/sendnotice.php', array('uniacid' => $_W['uniacid']), NULL, 10);
		}

		$lasttime = strtotime(m('cache')->getString('sendcycelbuy', 'global'));
		$interval = intval(m('cache')->getString('sendcycelbuy_time', 'global'));

		if (empty($interval)) {
			$interval = 60;
		}

		$interval *= 60;
		$current = time();

		if ($lasttime + $interval <= $current) {
			m('cache')->set('sendcycelbuy', date('Y-m-d H:i:s', $current), 'global');
			ihttp_request(EWEI_SHOPV2_TASK_URL . 'cycelbuy/sendnotice.php', array('uniacid' => $_W['uniacid']), NULL, 10);
		}

		$lasttime = strtotime(m('cache')->getString('cycelbuyreceive', 'global'));
		$interval = intval(m('cache')->getString('cycelbuyreceive_time', 'global'));

		if (empty($interval)) {
			$interval = 60;
		}

		$interval *= 60;
		$current = time();

		if ($lasttime + $interval <= $current) {
			m('cache')->set('cycelbuyreceive', date('Y-m-d H:i:s', $current), 'global');
			ihttp_request(EWEI_SHOPV2_TASK_URL . 'cycelbuy/receive.php', array('uniacid' => $_W['uniacid']), NULL, 10);
		}

		if (p('groups')) {
			$groups_order_lasttime = strtotime(m('cache')->getString('groups_order_cancelorder', 'global'));
			$groups_order_interval = intval(m('cache')->getString('groups_order_cancelorder_time', 'global'));

			if (empty($groups_order_interval)) {
				$groups_order_interval = 60;
			}

			$groups_order_interval *= 60;
			$groups_order_current = time();

			if ($groups_order_lasttime + $groups_order_interval <= $groups_order_current) {
				m('cache')->set('groups_order_cancelorder', date('Y-m-d H:i:s', $groups_order_current), 'global');
				ihttp_request($_W['siteroot'] . 'addons/ewei_shopv2/plugin/groups/task/order.php', NULL, NULL, 10);
			}

			$groups_team_lasttime = strtotime(m('cache')->getString('groups_team_refund', 'global'));
			$groups_team_interval = intval(m('cache')->getString('groups_team_refund_time', 'global'));

			if (empty($groups_team_interval)) {
				$groups_team_interval = 60;
			}

			$groups_team_interval *= 60;
			$groups_team_current = time();

			if ($groups_team_lasttime + $groups_team_interval <= $groups_team_current) {
				m('cache')->set('groups_team_refund', date('Y-m-d H:i:s', $groups_team_current), 'global');
				ihttp_request($_W['siteroot'] . ('addons/ewei_shopv2/plugin/groups/task/refund.php?uniacid=' . $_W['uniacid']), NULL, NULL, 10);
			}

			$groups_receive_lasttime = strtotime(m('cache')->getString('groups_receive', 'global'));
			$groups_receive_interval = intval(m('cache')->getString('groups_receive_time', 'global'));

			if (empty($groups_receive_interval)) {
				$groups_receive_interval = 60;
			}

			$groups_receive_interval *= 60;
			$groups_receive_current = time();

			if ($groups_receive_lasttime + $groups_receive_interval <= $groups_receive_current) {
				m('cache')->set('groups_receive', date('Y-m-d H:i:s', $groups_receive_current), 'global');
				ihttp_request($_W['siteroot'] . 'addons/ewei_shopv2/plugin/groups/task/receive.php', NULL, NULL, 10);
			}
		}

		if (p('seckill')) {
			$lasttime = strtotime(m('cache')->getString('seckill_delete_lasttime', 'global'));
			$interval = 5 * 60;
			$current = time();

			if ($lasttime + $interval <= $current) {
				m('cache')->set('seckill_delete_lasttime', date('Y-m-d H:i:s', $current), 'global');
				ihttp_request($_W['siteroot'] . 'addons/ewei_shopv2/plugin/seckill/task/delete.php', NULL, NULL, 10);
			}
		}

		if (p('friendcoupon')) {
			$lasttime = strtotime(m('cache')->getString('friendcoupon_send_failed_message', 'global'));
			$interval = 60;
			$current = time();

			if ($lasttime + $interval <= $current) {
				m('cache')->set('friendcoupon_send_failed_message', date('Y-m-d H:i:s', $current), 'global');
				ihttp_request($_W['siteroot'] . ('addons/ewei_shopv2/plugin/friendcoupon/task/sendMessage.php?uniacid=' . $_W['uniacid']), NULL, NULL, 10);
			}
		}

		if (p('merch')) {
			$lasttime = strtotime(m('cache')->getString('merch_expire', 'global'));
			$interval = 5 * 60;
			$current = time();

			if ($lasttime + $interval <= $current) {
				m('cache')->set('merch_expire', date('Y-m-d H:i:s', $current), 'global');
				ihttp_request(EWEI_SHOPV2_TASK_URL . 'plugin/merch.php', NULL, NULL, 10);
			}
		}
	}

	public function template($filename = '', $type = TEMPLATE_INCLUDEPATH, $account = false)
	{
		global $_W;
		global $_GPC;
		$isv3 = true;

		if (isset($_W['shopversion'])) {
			$isv3 = $_W['shopversion'];
		}

		if ($isv3 && !empty($_GPC['v2'])) {
			$isv3 = false;
		}

		if (!empty($_W['plugin']) && $isv3) {
			$plugin_config = m('plugin')->getConfig($_W['plugin']);
			if (is_array($plugin_config) && empty($plugin_config['v3']) || !$plugin_config) {
				$isv3 = false;
			}
		}

		$bsaeTemp = array('_header', '_header_base', '_footer', '_tabs', 'funbar');
		if ($_W['plugin'] == 'merch' && $_W['merch_user'] && (!in_array($filename, $bsaeTemp) || !$isv3)) {
			return $this->template_merch($filename, $isv3);
		}

		if (empty($filename)) {
			$filename = str_replace('.', '/', $_W['routes']);
		}

		if ($_GPC['do'] == 'web' || defined('IN_SYS')) {
			$filename = str_replace('/add', '/post', $filename);
			$filename = str_replace('/edit', '/post', $filename);
			$filename_default = str_replace('/add', '/post', $filename);
			$filename_default = str_replace('/edit', '/post', $filename_default);
			$filename = 'web/' . $filename_default;
			$filename_v3 = 'web_v3/' . $filename_default;
		}

		$name = 'ewei_shopv2';
		$moduleroot = IA_ROOT . '/addons/ewei_shopv2';

		if (defined('IN_SYS')) {
			if (!$isv3) {
				$compile = IA_ROOT . ('/data/tpl/web/' . $_W['template'] . '/' . $name . '/' . $filename . '.tpl.php');
				$source = $moduleroot . ('/template/' . $filename . '.html');

				if (!is_file($source)) {
					$source = $moduleroot . ('/template/' . $filename . '/index.html');
				}
			}

			if ($isv3 || !is_file($source)) {
				if ($isv3) {
					$compile = IA_ROOT . ('/data/tpl/web_v3/' . $_W['template'] . '/' . $name . '/' . $filename . '.tpl.php');
				}

				$source = $moduleroot . ('/template/' . $filename_v3 . '.html');

				if (!is_file($source)) {
					$source = $moduleroot . ('/template/' . $filename_v3 . '/index.html');
				}
			}

			if (!is_file($source)) {
				$explode = array_slice(explode('/', $filename), 1);
				$temp = array_slice($explode, 1);

				if ($isv3) {
					$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web_v3/' . implode('/', $temp) . '.html';

					if (!is_file($source)) {
						$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web_v3/' . implode('/', $temp) . '/index.html';
					}
				}

				if (!$isv3 || !is_file($source)) {
					$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web/' . implode('/', $temp) . '.html';

					if (!is_file($source)) {
						$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web/' . implode('/', $temp) . '/index.html';
					}
				}
			}
		}
		else if ($account) {
			$template = $_W['shopset']['wap']['style'];

			if (empty($template)) {
				$template = 'default';
			}

			if (!is_dir($moduleroot . '/template/account/' . $template)) {
				$template = 'default';
			}

			$compile = IA_ROOT . ('/data/tpl/app/' . $name . '/' . $template . '/account/' . $filename . '.tpl.php');
			$source = IA_ROOT . ('/addons/' . $name . '/template/account/' . $template . '/' . $filename . '.html');

			if (!is_file($source)) {
				$source = IA_ROOT . ('/addons/' . $name . '/template/account/default/' . $filename . '.html');
			}

			if (!is_file($source)) {
				$source = IA_ROOT . ('/addons/' . $name . '/template/account/default/' . $filename . '/index.html');
			}
		}
		else {
			$template = m('cache')->getString('template_shop');

			if (empty($template)) {
				$template = 'default';
			}

			if (!is_dir($moduleroot . '/template/mobile/' . $template)) {
				$template = 'default';
			}

			$compile = IA_ROOT . ('/data/tpl/app/' . $name . '/' . $template . '/mobile/' . $filename . '.tpl.php');
			$source = IA_ROOT . ('/addons/' . $name . '/template/mobile/' . $template . '/' . $filename . '.html');

			if (!is_file($source)) {
				$source = IA_ROOT . ('/addons/' . $name . '/template/mobile/' . $template . '/' . $filename . '/index.html');
			}

			if (!is_file($source)) {
				$source = IA_ROOT . ('/addons/' . $name . '/template/mobile/default/' . $filename . '.html');
			}

			if (!is_file($source)) {
				$source = IA_ROOT . ('/addons/' . $name . '/template/mobile/default/' . $filename . '/index.html');
			}

			if (!is_file($source)) {
				$names = explode('/', $filename);
				$pluginname = $names[0];
				$ptemplate = m('cache')->getString('template_' . $pluginname);
				if (empty($ptemplate) || $pluginname == 'creditshop') {
					$ptemplate = 'default';
				}

				if (!is_dir($moduleroot . '/plugin/' . $pluginname . '/template/mobile/' . $ptemplate)) {
					$ptemplate = 'default';
				}

				unset($names[0]);
				$pfilename = implode('/', $names);
				$compile = IA_ROOT . ('/data/tpl/app/' . $name . '/plugin/' . $pluginname . '/' . $ptemplate . '/mobile/' . $filename . '.tpl.php');
				$source = $moduleroot . '/plugin/' . $pluginname . '/template/mobile/' . $ptemplate . ('/' . $pfilename . '.html');

				if (!is_file($source)) {
					$source = $moduleroot . '/plugin/' . $pluginname . '/template/mobile/' . $ptemplate . '/' . $pfilename . '/index.html';
				}

				if (!is_file($source)) {
					$source = $moduleroot . '/plugin/' . $pluginname . ('/template/mobile/default/' . $pfilename . '.html');
				}

				if (!is_file($source)) {
					$source = $moduleroot . '/plugin/' . $pluginname . '/template/mobile/default/' . $pfilename . '/index.html';
				}
			}
		}

		if (!is_file($source)) {
			exit('Error: template source \'' . $filename . '\' is not exist!');
		}

		if (DEVELOPMENT || !is_file($compile) || filemtime($compile) < filemtime($source)) {
			shop_template_compile($source, $compile, true);
		}

		return $compile;
	}

	public function template_merch($filename, $isv3)
	{
		global $_W;

		if (empty($filename)) {
			$filename = str_replace('.', '/', $_W['routes']);
		}

		$filename = str_replace('/add', '/post', $filename);
		$filename = str_replace('/edit', '/post', $filename);
		$name = 'ewei_shopv2';
		$moduleroot = IA_ROOT . '/addons/ewei_shopv2';
		$compile = IA_ROOT . ('/data/tpl/web/' . $_W['template'] . '/merch/' . $name . '/' . $filename . '.tpl.php');
		$explode = explode('/', $filename);

		if ($isv3) {
			$source = $moduleroot . '/plugin/merch/template/web_v3/manage/' . implode('/', $explode) . '.html';

			if (!is_file($source)) {
				$source = $moduleroot . '/plugin/merch/template/web_v3/manage/' . implode('/', $explode) . '/index.html';
			}
		}

		if (!$isv3 || !is_file($source)) {
			$source = $moduleroot . '/plugin/merch/template/web/manage/' . implode('/', $explode) . '.html';

			if (!is_file($source)) {
				$source = $moduleroot . '/plugin/merch/template/web/manage/' . implode('/', $explode) . '/index.html';
			}
		}

		if (!is_file($source)) {
			$explode = explode('/', $filename);
			$temp = array_slice($explode, 1);

			if ($isv3) {
				$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web_v3/' . implode('/', $temp) . '.html';

				if (!is_file($source)) {
					$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web_v3/' . implode('/', $temp) . '/index.html';
				}
			}

			if (!$isv3 || !is_file($source)) {
				$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web/' . implode('/', $temp) . '.html';

				if (!is_file($source)) {
					$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web/' . implode('/', $temp) . '/index.html';
				}
			}
		}

		if (!is_file($source)) {
			exit('Error: template source \'' . $filename . '\' is not exist!');
		}

		if (DEVELOPMENT || !is_file($compile) || filemtime($compile) < filemtime($source)) {
			shop_template_compile($source, $compile, true);
		}

		return $compile;
	}

	public function message($msg, $redirect = '', $type = '')
	{
		global $_W;
		$title = '';
		$buttontext = '';
		$message = $msg;
		$buttondisplay = true;

		if (is_array($msg)) {
			$message = isset($msg['message']) ? $msg['message'] : '';
			$title = isset($msg['title']) ? $msg['title'] : '';
			$buttontext = isset($msg['buttontext']) ? $msg['buttontext'] : '';
			$buttondisplay = isset($msg['buttondisplay']) ? $msg['buttondisplay'] : true;
		}

		if (empty($redirect)) {
			$redirect = 'javascript:history.back(-1);';
		}
		else if ($redirect == 'close') {
			$redirect = 'javascript:WeixinJSBridge.call("closeWindow")';
		}
		else {
			if ($redirect == 'exit') {
				$redirect = '';
			}
		}

		include $this->template('_message');
		exit();
	}

	public function checkSubmit($key, $time = 2, $message = '操作频繁，请稍后再试!')
	{
		global $_W;
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['setting']['site']['key'] . '_' . $_W['account']['key'] . '_' . $_W['uniacid'] . '_' . $_W['openid'] . '_mobilesubmit_' . $key;
			$redis = redis();

			if ($redis->setnx($redis_key, time())) {
				$redis->expireAt($redis_key, time() + $time);
			}
			else {
				return error(-1, $message);
			}
		}

		return true;
	}

	public function checkSubmitGlobal($key, $time = 2, $message = '操作频繁，请稍后再试!')
	{
		global $_W;
		$open_redis = function_exists('redis') && !is_error(redis());

		if ($open_redis) {
			$redis_key = $_W['setting']['site']['key'] . '_' . $_W['account']['key'] . '_' . $_W['uniacid'] . '_mobilesubmit_' . $key;
			$redis = redis();

			if ($redis->setnx($redis_key, time())) {
				$redis->expireAt($redis_key, time() + $time);
			}
			else {
				return error(-1, $message);
			}
		}

		return true;
	}
}

?>
