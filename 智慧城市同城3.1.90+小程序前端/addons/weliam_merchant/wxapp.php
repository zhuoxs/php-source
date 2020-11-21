<?php
defined('IN_IA') or exit('Access Denied');
require_once IA_ROOT . "/addons/weliam_merchant/core/common/defines.php";
require_once PATH_CORE . "common/autoload.php";
Func_loader::core('global');

class Weliam_merchantModuleWxapp extends WeModuleWxapp {
	
	public function doPageIndex() {
		global $_W, $_GPC;
		
		$this->result(0, '登录成功', array('uid' => 1235));
	}
	
	public function doPageCopyright() {
		global $_W, $_GPC;
		$_W['uniacid'] = Wxapp::get_uniacid($_W['uniacid']);
		$settings = Setting::wlsetting_read('base');
		$settings['logo'] = tomedia($settings['logo']);
		
		$this->result(0, '', $settings);
	}
	
	public function doPagePay() {
		global $_W, $_GPC;
		$order_info = pdo_get('core_paylog', array('module' => $this->module['name'], 'tid' => safe_gpc_string($_GPC['orderid'])), array('tid', 'fee'));
		$order = array(
			'tid' => $order_info['tid'],
			'user' => $_SESSION['openid'],
			'fee' => $order_info['fee'],
			'title' => trim($_GPC['title'])
		);
		$paydata = $this->pay($order);
		$this->result(0, '', $paydata);
	}
	
	public function doPagePayResult() {
		global $_GPC, $_W;
		$log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $this->module['name'], 'tid' => safe_gpc_string($_GPC['orderid'])));
		if (!empty($log) && !empty($log['status'])) {
			if (!empty($log['tag'])) {
				$tag = iunserializer($log['tag']);
				$log['uid'] = $tag['uid'];
			}
			$_W['uniacid'] = Wxapp::get_uniacid($_W['uniacid']);
			
			$ret = array();
			$ret['weid'] = $_W['uniacid'];
			$ret['uniacid'] = $_W['uniacid'];
			$ret['result'] = 'success';
			$ret['type'] = $log['type'];
			$ret['from'] = 'return';
			$ret['tid'] = $log['tid'];
			$ret['uniontid'] = $log['uniontid'];
			$ret['user'] = $log['openid'];
			$ret['fee'] = $log['fee'];
			$ret['tag'] = $tag;
			$ret['is_usecard'] = $log['is_usecard'];
			$ret['card_type'] = $log['card_type'];
			$ret['card_fee'] = $log['card_fee'];
			$ret['card_id'] = $log['card_id'];
			PayResult::main($ret, 1);
		}
	}
	
	public function payResult($params) {
		global $_GPC, $_W;
		WeUtility::logging('payResult', var_export($params, true));
		
		$params['uniacid'] = $_W['uniacid'] = Wxapp::get_uniacid($_W['uniacid']);
		$_W['acid'] = pdo_getcolumn('account_wechats', array('uniacid' => $_W['uniacid']), 'acid');
		
		PayResult::main($params);
	}
	
}
