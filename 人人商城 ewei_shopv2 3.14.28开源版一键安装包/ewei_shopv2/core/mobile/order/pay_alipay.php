<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Pay_Alipay_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$url = urldecode($_GPC['url']);

		if (!is_weixin()) {
			header('location: ' . $url);
			exit();
		}

		include $this->template('order/alipay');
	}

	public function complete()
	{
		global $_GPC;
		global $_W;
		$set = m('common')->getSysset(array('shop', 'pay'));
		$fromwechat = intval($_GPC['fromwechat']);
		$tid = $_GPC['out_trade_no'];

		if (is_h5app()) {
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			$alidata = base64_decode($_GET['alidata']);
			$alidata = json_decode($alidata, true);
			$sign_type = trim($alidata['sign_type'], '"');

			if ($sign_type == 'RSA') {
				$public_key = $sec['app_alipay']['public_key'];
			}
			else {
				if ($sign_type == 'RSA2') {
					$public_key = $sec['app_alipay']['public_key_rsa2'];
				}
			}

			if (empty($set['pay']['app_alipay']) || empty($public_key)) {
				$this->message('支付出现错误，请重试(1)!', mobileUrl('order'));
			}

			$alisign = m('finance')->RSAVerify($alidata, $public_key, false);
			$tid = $this->str($alidata['out_trade_no']);

			if ($alisign == 0) {
				$this->message('支付出现错误，请重试(2)!', mobileUrl('order'));
			}

			if (strexists($tid, 'GJ')) {
				$tids = explode('GJ', $tid);
				$tid = $tids[0];
			}
		}
		else {
			if (empty($set['pay']['alipay'])) {
				$this->message('未开启支付宝支付!', mobileUrl('order'));
			}

			if (!m('finance')->isAlipayNotify($_GET)) {
				$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':tid' => $tid));
				if ($log['status'] == 1 && $log['fee'] == $_GPC['total_fee']) {
					if ($fromwechat) {
						$this->message(array('message' => '请返回微信查看支付状态', 'title' => '支付成功!', 'buttondisplay' => false), NULL, 'success');
					}
					else {
						$this->message(array('message' => '请返回商城查看支付状态', 'title' => '支付成功!'), mobileUrl('order'), 'success');
					}
				}

				$this->message(array('message' => '支付出现错误，请重试(支付验证失败)!', 'buttondisplay' => $fromwechat ? false : true), $fromwechat ? NULL : mobileUrl('order'));
			}
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':tid' => $tid));

		if (empty($log)) {
			$this->message(array('message' => '支付出现错误，请重试(支付验证失败2)!', 'buttondisplay' => $fromwechat ? false : true), $fromwechat ? NULL : mobileUrl('order'));
		}

		if (is_h5app()) {
			$alidatafee = $this->str($alidata['total_fee']);
			$alidatastatus = $this->str($alidata['success']);
			if ($log['fee'] != $alidatafee || !$alidatastatus) {
				$this->message('支付出现错误，请重试(4)!', mobileUrl('order'));
			}
		}

		$orderid = pdo_fetchcolumn('select id from ' . tablename('ewei_shop_order') . ' where ordersn=:ordersn and uniacid=:uniacid', array(':ordersn' => $log['tid'], ':uniacid' => $_W['uniacid']));

		if (is_h5app()) {
			$url = mobileUrl('order/detail', array('id' => $orderid), true);
			exit('<script>top.window.location.href=\'' . $url . '\'</script>');
		}
		else if ($fromwechat) {
			$this->message(array('message' => '请返回微信查看支付状态', 'title' => '支付成功!', 'buttondisplay' => false), NULL, 'success');
		}
		else {
			$this->message(array('message' => '请返回商城查看支付状态', 'title' => '支付成功!'), mobileUrl('order'), 'success');
		}
	}

	public function recharge_complete()
	{
		global $_W;
		global $_GPC;
		$fromwechat = intval($_GPC['fromwechat']);
		$logno = trim($_GPC['out_trade_no']);
		$notify_id = trim($_GPC['notify_id']);
		$sign = trim($_GPC['sign']);
		$set = m('common')->getSysset(array('shop', 'pay'));

		if (is_h5app()) {
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);

			if (empty($_GET['alidata'])) {
				$this->message('支付出现错误，请重试(1)!', mobileUrl('member'));
			}

			$alidata = base64_decode($_GET['alidata']);
			$alidata = json_decode($alidata, true);
			$sign_type = $alidata['sign_type'];

			if ($sign_type == 'RSA') {
				$public_key = $sec['app_alipay']['public_key'];
			}
			else {
				if ($sign_type == 'RSA2') {
					$public_key = $sec['app_alipay']['public_key_rsa2'];
				}
			}

			if (empty($set['pay']['app_alipay']) || empty($public_key)) {
				$this->message('支付出现错误，请重试(2)!', mobileUrl('order'));
			}

			$alisign = m('finance')->RSAVerify($alidata, $public_key, false);
			$logno = $this->str($alidata['out_trade_no']);

			if ($alisign == 0) {
				$this->message('支付出现错误，请重试(3)!', mobileUrl('member'));
			}

			$transid = $alidata['trade_no'];
		}
		else {
			if (empty($logno)) {
				$this->message(array('message' => '支付出现错误，请重试(支付验证失败1)!', 'buttondisplay' => $fromwechat ? false : true), $fromwechat ? NULL : mobileUrl('member'));
			}

			if (empty($set['pay']['alipay'])) {
				$this->message(array('message' => '支付出现错误，请重试(未开启支付宝支付)!', 'buttondisplay' => $fromwechat ? false : true), $fromwechat ? NULL : mobileUrl('member'));
			}

			if (!m('finance')->isAlipayNotify($_GET)) {
				$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `logno`=:logno and `uniacid`=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':logno' => $logno));
				if (!empty($log) && !empty($log['status'])) {
					if ($fromwechat) {
						$this->message(array('message' => '请返回微信查看支付状态', 'title' => '支付成功!', 'buttondisplay' => false), NULL, 'success');
					}
					else {
						$this->message(array('message' => '请返回商城查看支付状态', 'title' => '支付成功!'), mobileUrl('member'), 'success');
					}
				}

				$this->message(array('message' => '支付出现错误，请重试(支付验证失败2)!', 'buttondisplay' => $fromwechat ? false : true), $fromwechat ? NULL : mobileUrl('member'));
			}

			$transid = $_GET['trade_no'];
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `logno`=:logno and `uniacid`=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':logno' => $logno));

		if (is_h5app()) {
			$url = mobileUrl('member', NULL, true);
			exit('<script>top.window.location.href=\'' . $url . '\'</script>');
		}
		else if ($fromwechat) {
			$this->message(array('message' => '请返回微信查看支付状态', 'title' => '支付成功!', 'buttondisplay' => false), NULL, 'success');
		}
		else {
			$this->message(array('message' => '请返回商城查看支付状态', 'title' => '支付成功!'), mobileUrl('member'), 'success');
		}
	}

	protected function str($str)
	{
		$str = str_replace('"', '', $str);
		$str = str_replace('\'', '', $str);
		return $str;
	}
}

?>
