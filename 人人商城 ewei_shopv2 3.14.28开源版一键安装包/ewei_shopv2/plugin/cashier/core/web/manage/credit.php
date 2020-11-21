<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/page_cashier.php';
class Credit_EweiShopV2Page extends CashierWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$data = $_GPC['data'];
			$data['paytocredit'] = intval($data['paytocredit']);
			$data['credit2'] = floatval($data['credit2']);
			$data['credit1'] = floatval($data['credit1']);
			$this->updateUserSet($data);
			show_json(1);
		}

		$user = $this->model->userInfo($_W['cashierid']);
		$set = empty($user['set']) ? array() : json_decode($user['set'], true);
		$sysset = m('common')->getPluginset('cashier');
		include $this->template();
	}

	public function recharge()
	{
		global $_W;
		global $_GPC;
		$credit2 = (double) $_W['shopset']['cashier']['credit2'];
		$credit1 = (double) $_W['shopset']['cashier']['credit1'];
		if (empty($_W['shopset']['cashier']['credit2']) || empty($_W['shopset']['cashier']['credit1'])) {
			$credit2 = $credit1 = 1;
		}

		include $this->template();
	}

	public function recharge_submit()
	{
		global $_W;
		global $_GPC;
		$paytype = (int) $_GPC['paytype'];
		$money = (double) $_GPC['money'];

		if ($money <= 0) {
			show_json(0, '金额填写错误!');
		}

		if (empty($_W['shopset']['cashier']['pay_credit'])) {
			show_json(0, '积分充值尚未开启!');
		}

		$logno = m('common')->createNO('cashier_log', 'logno', 'ST');
		$log = array('uniacid' => $_W['uniacid'], 'cashierid' => $_W['cashierid'], 'paytype' => $paytype, 'logno' => $logno, 'title' => '收银台积分充值!', 'createtime' => time(), 'status' => 0, 'money' => $money);
		pdo_delete('ewei_shop_cashier_log', array('cashierid' => $_W['cashierid'], 'status' => 0, 'uniacid' => $_W['uniacid']));
		pdo_insert('ewei_shop_cashier_log', $log);
		$logid = pdo_insertid();

		if (!$logid) {
			show_json(0, '数据插入错误,请重试!');
		}

		$params = array('uniacid' => $_W['uniacid'], 'tid' => $logno, 'fee' => $money, 'title' => '收银台积分充值');

		if ($paytype == 0) {
			$res = $this->wechat_pay($money, $params);
		}

		show_json(1, array('code_url' => $res['code_url']));
	}

	protected function wechat_pay($money, $params)
	{
		global $_W;
		global $_GPC;
		$set = m('common')->getSysset(array('shop', 'pay'));
		if (isset($set['pay']) && $set['pay']['weixin_jie'] == 1) {
			$params['tid'] = $params['tid'] . '_borrow';
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			$options = array();
			$options['appid'] = $sec['appid'];
			$options['mchid'] = $sec['mchid'];
			$options['apikey'] = $sec['apikey'];
			$wechat = m('common')->wechat_native_build($params, $options, 11);

			if (!is_error($wechat)) {
				$wechat['success'] = true;
				$wechat['weixin_jie'] = true;
			}
		}
		else {
			show_json(0, '支付方式未开启,请联系管理员!');
		}

		return $wechat;
	}
}

?>
