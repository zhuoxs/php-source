<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class CashierMobilePage extends PluginMobilePage
{
	public function __construct()
	{
		global $_W;
		global $_GPC;
		parent::__construct();

		if (!empty($_GPC['cashierid'])) {
			$_W['cashieruser'] = $this->model->userInfo((int) $_GPC['cashierid']);
			$_W['cashierid'] = $_W['cashieruser']['id'];
			$_W['cashierset'] = json_decode($_W['cashieruser']['set'], true);
		}
		else {
			$this->message('参数错误!', 'close', 'error');
		}

		if (empty($_W['cashieruser'])) {
			$this->message('未发现该收银台!', 'close', 'error');
		}

		if (empty($this->set['isopen'])) {
			$this->message('该收银台暂时关闭!', 'close', 'error');
		}

		if (empty($_W['cashierset']['mobile_pay'])) {
			$this->message('手机端收银台暂时关闭!', 'close', 'error');
		}

		if ($_W['cashieruser']['lifetimeend'] < time()) {
			if ($_W['routes'] != 'login' && $_W['routes'] != 'quit') {
				$this->message('账号已到期!', 'close', 'error');
			}
		}
	}
}

?>
