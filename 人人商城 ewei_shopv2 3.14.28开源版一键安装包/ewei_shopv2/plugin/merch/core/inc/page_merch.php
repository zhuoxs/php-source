<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/common.php';
class MerchWebPage extends PluginWebPage
{
	public $pluginname;
	public $model;
	public $plugintitle;
	public $set;

	public function __construct($_com = '', $_init = false)
	{
		global $_W;

		if (!empty($_com)) {
			if (com('perm') && !com('perm')->check_com($_com)) {
				$this->message('你没有相应的权限查看');
			}
		}
		else {
			parent::__construct(false);
		}

		$this->pluginname = $_W['plugin'];
		$this->modulename = 'ewei_shopv2';
		$this->plugintitle = m('plugin')->getName($this->pluginname);
		$this->model = m('plugin')->loadModel($this->pluginname);
		$this->set = $this->model->getSet();
		$_W['shopset'] = m('common')->getSysset();

		if ($_W['ispost']) {
			rc($this->pluginname);
		}

		$this->init();
		m('system')->set_version(1);
	}

	private function init()
	{
		global $_W;
		if ($_W['merchisfounder'] != '1' && $_W['routes'] != 'shop') {
			$perm = mcv($_W['routes']);
			$perm_type = array();

			if (p('merch')) {
				$perm_type = p('merch')->getLogTypes(true);
			}

			$perm_type_value = array();

			foreach ($perm_type as $val) {
				$perm_type_value[] = $val['value'];
			}

			$is_xxx = false;

			if (p('merch')) {
				$is_xxx = p('merch')->check_xxx($_W['routes']);
			}

			if ($is_xxx) {
				if (!$perm) {
					foreach ($is_xxx as $item) {
						if (in_array($item, $perm_type_value)) {
							$this->message('你没有相应的权限查看');
						}
					}
				}
			}
			else {
				if (strexists($_W['routes'], 'edit')) {
					if (!mcv($_W['routes'])) {
						$view = str_replace('edit', 'view', $_W['routes']);
						$perm_view = mcv($view);
					}
				}
				else {
					$main = $_W['routes'] . '.main';
					$perm_main = mcv($main);
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

		m('system')->history_url();
	}

	public function getSet($name = '')
	{
		return $name ? $this->set[$name] : $this->set;
	}

	public function updateSet($data = array())
	{
		$this->model->updateSet($data);
	}

	public function manageMenus()
	{
		global $_GPC;
		global $_W;
		$routes = explode('.', $_W['routes']);
		$tab = isset($routes[0]) ? $routes[0] : '';
		include $this->template($tab . '/tabs');
	}
}

?>
