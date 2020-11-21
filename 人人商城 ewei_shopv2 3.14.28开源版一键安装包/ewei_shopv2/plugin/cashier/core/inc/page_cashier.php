<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/common.php';
class CashierWebPage extends PluginWebPage
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
		$user = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_cashier_user') . ' WHERE id=:id AND uniacid=:uniacid AND status=1 AND deleted=0 LIMIT 1', array(':id' => $_W['cashieruser']['id'], ':uniacid' => $_W['uniacid']));

		if ($user) {
			$_W['cashieruser']['merchid'] = $user['merchid'];
		}

		if ($_W['ispost']) {
			rc($this->pluginname);
		}

		$_W['routes'] = str_replace('cashier.manage.', '', $_W['routes']);

		if (empty($this->set['isopen'])) {
			if ($_W['routes'] != 'login' && $_W['routes'] != 'quit') {
				$this->message('暂未开启,收银台插件!', cashierUrl('quit'));
			}
		}

		if ($_W['cashieruser']['lifetimeend'] < time()) {
			if ($_W['routes'] != 'login' && $_W['routes'] != 'quit') {
				$this->message('账号已到期!', cashierUrl('quit'));
			}
		}

		if (!$this->model->is_perm($_W['routes']) && $_W['routes'] != 'login' && $_W['routes'] != 'quit' && $_W['routes'] != 'qr') {
			$this->message('暂时没有权限查看!');
		}
	}

	public function template($filename = '', $type = TEMPLATE_INCLUDEPATH, $account = false)
	{
		global $_W;
		global $_GPC;
		load()->func('tpl');

		if (empty($filename)) {
			$filename = str_replace('.', '/', $_W['routes']);
		}

		$filename = str_replace('/add', '/post', $filename);
		$filename = str_replace('/edit', '/post', $filename);
		$name = 'ewei_shopv2';
		$moduleroot = IA_ROOT . '/addons/ewei_shopv2';
		$compile = IA_ROOT . ('/data/tpl/web/' . $_W['template'] . '/cashier/' . $name . '/' . $filename . '.tpl.php');
		$source = $moduleroot . ('/template/' . $filename . '.html');

		if (!is_file($source)) {
			$source = $moduleroot . ('/template/' . $filename . '/index.html');
		}

		if (!is_file($source)) {
			$explode = explode('/', $filename);
			$source = $moduleroot . '/plugin/cashier/template/web/manage/' . implode('/', $explode) . '.html';

			if (!is_file($source)) {
				$source = $moduleroot . '/plugin/cashier/template/web/manage/' . implode('/', $explode) . '/index.html';
			}
		}

		if (!is_file($source)) {
			$explode = explode('/', $filename);
			$temp = array_slice($explode, 1);
			$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web/' . implode('/', $temp) . '.html';

			if (!is_file($source)) {
				$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web/' . implode('/', $temp) . '/index.html';
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

	public function manageMenus()
	{
		global $_GPC;
		global $_W;
		$routes = explode('.', $_W['routes']);
		$tab = isset($routes[0]) ? $routes[0] : '';
		include $this->template($tab . '/tabs');
	}

	public function getUserSet($name = '')
	{
		global $_W;
		return $this->model->getUserSet($name, $_W['cashierid']);
	}

	public function updateUserSet($data = array())
	{
		global $_W;
		return $this->model->updateUserSet($data, $_W['cashierid']);
	}

	public function qr()
	{
		global $_W;
		global $_GPC;
		$url = trim($_GPC['url']);
		require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
		QRcode::png($url, false, QR_ECLEVEL_L, 16, 1);
	}
}

?>
