<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class WebPage extends Page
{
	public function __construct($_init = true)
	{
		if ($_init) {
			$this->init();
		}

		$GLOBALS['_W']['shopversion'] = 1;
	}

	private function init()
	{
		global $_W;
		if ($_W['role'] != 'manager' && $_W['role'] != 'founder' && $_W['routes'] != 'shop') {
			$perm = cv($_W['routes']);

			if (com('perm')) {
				$perm_type = com('perm')->getLogTypes(true);
				$perm_type_value = array();

				foreach ($perm_type as $val) {
					$perm_type_value[] = $val['value'];
				}

				$is_xxx = com('perm')->check_xxx($_W['routes']);

				if ($is_xxx) {
					if (!$perm) {
						if (!is_array($is_xxx)) {
							if (in_array($is_xxx, $perm_type_value)) {
								$this->message('你没有相应的权限查看');
							}
						}
						else {
							foreach ($is_xxx as $item) {
								if (in_array($item, $perm_type_value)) {
									$this->message('你没有相应的权限查看');
								}
							}
						}
					}
				}
				else {
					if (strexists($_W['routes'], 'edit')) {
						if (!cv($_W['routes'])) {
							$view = str_replace('edit', 'view', $_W['routes']);
							$perm_view = cv($view);
						}
					}
					else {
						$main = $_W['routes'] . '.main';
						$perm_main = cv($main);
						if (!$perm_main && in_array($main, $perm_type_value)) {
							$this->message('你没有相应的权限查看');
						}
						else {
							if (!$perm && in_array($_W['routes'], $perm_type_value)) {
								$this->message('你没有相应的权限查看');
							}
						}
					}

					if (isset($perm_view) && !$perm_view) {
						$this->message('你没有相应的权限查看');
					}
				}
			}
		}

		if ($_W['ispost']) {
			rc();
		}

		m('system')->history_url();
	}

	public function isOpenPlugin()
	{
		$name = com_run('perm::allPerms');
		unset($name['shop']);
		unset($name['goods']);
		unset($name['member']);
		unset($name['order']);
		unset($name['finance']);
		unset($name['statistics']);
		unset($name['sysset']);
		unset($name['sale']);
		$name_keys = array_keys($name);
		return implode('|', $name_keys);
	}

	public function frame_menus()
	{
		global $_GPC;
		global $_W;

		if ($_W['plugin']) {
			include $this->template($_W['plugin'] . '/tabs');
		}
		else if ($_W['controller'] == 'system') {
			$routes = explode('.', $_W['routes']);
			$tabs = $routes[0] . (isset($routes[1]) ? '/' . $routes[1] : '') . '/tabs';
			include $this->template($tabs);
		}
		else {
			include $this->template($_W['controller'] . '/tabs');
		}
	}

	public function show_funbar()
	{
		global $_W;
		$funbardata = pdo_fetch('select * from ' . tablename('ewei_shop_funbar') . ' where uid=:uid and uniacid=:uniacid limit 1', array(':uid' => $_W['uid'], ':uniacid' => $_W['uniacid']));
		if (!empty($funbardata['datas']) && !is_array($funbardata['datas'])) {
			if (strexists($funbardata['datas'], '{"')) {
				$funbardata['datas'] = json_decode($funbardata['datas'], true);
			}
			else {
				$funbardata['datas'] = unserialize($funbardata['datas']);
			}
		}

		include $this->template('funbar');
	}
}

?>
