<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/mobile_cashier.php';
class Pay_EweiShopV2Page extends CashierMobilePage
{
	public $log;

	public function __construct()
	{
		global $_W;

		if (!is_weixin()) {
			$_W['openid'] = 'alipay';
		}

		parent::__construct();
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$cashierid = intval($_GPC['cashierid']);
		$id = false;
		$goodstitle = $_W['cashieruser']['title'];

		if (!empty($_GPC['id'])) {
			$id = $_GPC['id'];
			$qrid = authcode(base64_decode($id), 'DECODE', 'ewei_shopv2_cashier');

			if (!empty($qrid)) {
				$item = pdo_get('ewei_shop_cashier_qrcode', array('uniacid' => $_W['uniacid'], 'cashierid' => $_W['cashierid'], 'id' => $qrid));
				$goodstitle = !empty($item['goodstitle']) ? $item['goodstitle'] : $goodstitle;
			}
			else {
				$id = false;
			}
		}

		$userset = $this->model->getUserSet('', $_W['cashierid']);
		if (is_weixin() && !empty($_W['openid']) && $userset['use_credit2']) {
			$member = m('member')->getMember($_W['openid']);
		}

		$paytype = $this->model->paytype(-1);
		list(, $payment) = m('common')->public_build();

		if ($payment['is_new']) {
			if ($payment['type'] == 2 || $payment['type'] == 3) {
				if (!empty($payment['sub_appsecret'])) {
					m('member')->wxuser($payment['sub_appid'], $payment['sub_appsecret']);
				}
			}
		}

		if ($paytype == 101 && $payment['is_new'] == 1 && $payment['type'] == 4) {
			$paytype = 102;
		}

		include $this->template();
	}

	public function pay($params = array(), $mine = array())
	{
		global $_W;
		global $_GPC;
		$paytype = $this->model->paytype((int) $_GPC['paytype']);
		$money = (double) $_GPC['money'];
		$title = $_GPC['goodstitle'];
		$jie = intval($_GPC['jie']);
		$userset = $this->model->getUserSet('', $_W['cashierid']);

		if ($money <= 0) {
			show_json(0, '金额填写错误!');
		}

		$usecoupon = 0;
		if (!empty($_GPC['couponid']) || !empty($_GPC['couponmerchid'])) {
			$usecoupon = empty($_GPC['couponid']) ? intval($_GPC['couponmerchid']) : intval($_GPC['couponid']);
		}

		$deduction = 0;
		if (is_weixin() && !empty($_W['openid']) && $userset['use_credit2']) {
			$member = m('member')->getMember($_W['openid']);
			$deduction = $money <= $member['credit2'] ? $money : 0;
		}

		$this->log = $this->model->createOrder(array('openid' => $_W['openid'] != 'alipay' ? $_W['openid'] : '', 'paytype' => $paytype, 'title' => $title, 'money' => $money, 'operatorid' => intval($_GPC['operatorid']), 'usecoupon' => $usecoupon, 'deduction' => $deduction, 'mobile' => (int) $member['mobile']), empty($deduction) ? 1 : NULL);

		if (is_error($this->log)) {
			show_json(0, '数据插入错误,请重试!');
		}

		if (!empty($deduction) && $this->log['res']) {
			show_json(1, array('success' => true, 'logid' => $this->log['id'], 'log' => $this->log));
		}

		if ($this->log['money'] == 0) {
			show_json(1, array('success' => true, 'logid' => $this->log['id'], 'log' => $this->log));
		}

		if ($paytype == '0') {
			$this->paytype0($jie);
		}
		else if ($paytype == '1') {
			$this->paytype1();
		}
		else if ($paytype == '101') {
			$this->paytype101($jie);
		}
		else {
			if ($paytype == '102') {
				$this->paytype102();
			}
		}
	}

	protected function paytype0($jie)
	{
		global $_W;
		$params = array();
		$params['tid'] = $this->log['logno'];
		$params['fee'] = $this->log['money'];
		$params['title'] = $this->log['title'];
		$wechatpay = $this->model->wechayPayInfo($_W['cashieruser']);
		if (empty($wechatpay['appid']) || empty($wechatpay['mch_id'])) {
			$options = array('appid' => $wechatpay['sub_appid'], 'mchid' => $wechatpay['sub_mch_id'], 'apikey' => $wechatpay['apikey']);
			$wechat = m('common')->wechat_native_build($params, $options, 13);
		}
		else {
			$wechat = m('common')->wechat_native_child_build($params, $wechatpay, 13);
		}

		if (!is_error($wechat)) {
			$wechat['success'] = true;
			$wechat['weixin_jie'] = true;
		}

		$wechat['jie'] = $jie;

		if (!$wechat['success']) {
			show_json(0, '微信支付参数错误!');
		}

		show_json(1, array('wechat' => $wechat, 'logid' => $this->log['id'], 'log' => $this->log));
	}

	protected function paytype1()
	{
		global $_W;
		$params = array('out_trade_no' => $this->log['logno'], 'seller_id' => '', 'total_amount' => $this->log['money'], 'subject' => $this->log['title'], 'body' => $_W['uniacid'] . ':2:' . $_W['cashierid']);
		$config = json_decode($_W['cashieruser']['alipay'], true);

		if ($config['sign_type'] == 0) {
			$config['sign_type'] = 'RSA';
		}
		else {
			if ($config['sign_type'] == 1) {
				$config['sign_type'] = 'RSA2';
			}
		}

		if (is_array($config)) {
			$config['return_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/return.php';
		}
		else {
			show_json(0);
		}

		$AliPay = m('common')->AliPayWap($params, $config);
		if (!empty($AliPay) && !is_error($AliPay)) {
			show_json(1, array('list' => $AliPay));
		}

		show_json(0, '支付宝设置参数错误!');
	}

	protected function paytype101($jie)
	{
		global $_W;
		$set = m('common')->getSysset(array('shop', 'pay'));
		$set['pay']['weixin'] = !empty($set['pay']['weixin_sub']) ? 1 : $set['pay']['weixin'];
		$set['pay']['weixin_jie'] = !empty($set['pay']['weixin_jie_sub']) ? 1 : $set['pay']['weixin_jie'];
		if (!is_weixin() && empty($jie)) {
			show_json(0, '非微信环境!');
		}

		if (empty($set['pay']['weixin']) && empty($set['pay']['weixin_jie'])) {
			show_json(0, '未开启微信支付!');
		}

		$wechat = array('success' => false);
		$params = array();
		$params['tid'] = $this->log['logno'];
		$params['user'] = $_W['openid'];
		$params['fee'] = $this->log['money'];
		$params['title'] = $this->log['title'];
		if (isset($set['pay']) && $set['pay']['weixin'] == 1 && $jie !== 1) {
			load()->model('payment');
			$setting = uni_setting($_W['uniacid'], array('payment'));
			$options = array();

			if (is_array($setting['payment'])) {
				$options = $setting['payment']['wechat'];
				$options['appid'] = $_W['account']['key'];
				$options['secret'] = $_W['account']['secret'];
			}

			$wechat = m('common')->wechat_build($params, $options, 13);

			if (!is_error($wechat)) {
				$wechat['success'] = true;

				if (!empty($wechat['code_url'])) {
					$wechat['weixin_jie'] = true;
				}
				else {
					$wechat['weixin'] = true;
				}
			}
		}

		if (isset($set['pay']) && $set['pay']['weixin_jie'] == 1 && !$wechat['success'] || $jie === 1) {
			$sec = m('common')->getSec();
			$sec = iunserializer($sec['sec']);
			$options = array();
			$options['appid'] = $sec['appid'];
			$options['mchid'] = $sec['mchid'];
			$options['apikey'] = $sec['apikey'];
			if (!empty($set['pay']['weixin_jie_sub']) && !empty($sec['sub_secret_jie_sub'])) {
				$wxuser = m('member')->wxuser($sec['sub_appid_jie_sub'], $sec['sub_secret_jie_sub']);
				$params['openid'] = $wxuser['openid'];
			}
			else {
				if (!empty($sec['secret'])) {
					$wxuser = m('member')->wxuser($sec['appid'], $sec['secret']);
					$params['openid'] = $wxuser['openid'];
				}
			}

			$wechat = m('common')->wechat_native_build($params, $options, 13);

			if (!is_error($wechat)) {
				$wechat['success'] = true;

				if (!empty($params['openid'])) {
					$wechat['weixin'] = true;
				}
				else {
					$wechat['weixin_jie'] = true;
				}
			}
		}

		$wechat['jie'] = $jie;

		if (!$wechat['success']) {
			show_json(0, '微信支付参数错误!');
		}

		show_json(1, array('wechat' => $wechat, 'logid' => $this->log['id'], 'log' => $this->log));
	}

	protected function paytype102()
	{
		global $_W;
		list(, $payment) = m('common')->public_build();
		$params = array('service' => 'pay.alipay.native', 'body' => $this->log['title'], 'out_trade_no' => $this->log['logno'], 'total_fee' => $this->log['money']);
		$AliPay = m('pay')->build($params, $payment, 13);
		if (!empty($AliPay) && !is_error($AliPay)) {
			$AliPay['out_trade_no'] = $this->log['logno'];
			show_json(1, $AliPay);
		}

		show_json(0, '支付宝设置参数错误!');
	}

	public function get_discount()
	{
		global $_W;
		global $_GPC;
		$money = floatval($_GPC['money']);
		$no_money = floatval($_GPC['no_money']);
		$type = intval($_GPC['type']);
		$return_money = $this->discountMoney($money, $no_money, $type);
		show_json(1, array('discountmoney' => $return_money));
	}

	protected function discountMoney($money, $no_money)
	{
		global $_W;
		$yes_money = $money - $no_money;
		$couponpay = $this->model->getUserSet('couponpay', $_W['cashierid']);
		$can = $this->discount($couponpay);

		if ($can) {
			$return_money = $yes_money * (10 - $can) / 10;
			return max(0, round($return_money, 2));
		}

		return 0;
	}

	protected function discount($couponpay)
	{
		if (empty($couponpay)) {
			return false;
		}

		if ($couponpay['time']['start'] < time() && time() < $couponpay['time']['end']) {
			if (10 <= $couponpay['discount']) {
				return false;
			}

			return (double) $couponpay['discount'];
		}

		return false;
	}

	public function orderquery()
	{
		global $_W;
		global $_GPC;
		$orderid = $_GPC['orderid'];

		if (!empty($orderid)) {
			$res = $this->model->orderQuery($orderid);

			if (!empty($res)) {
				show_json(1, array('list' => $res));
			}
		}

		show_json(0, '支付结果等待中!');
	}

	public function success()
	{
		global $_W;
		global $_GPC;
		$orderid = $_GPC['orderid'];
		$log = $this->model->payResult($orderid, true);
		if ($log && $log['status'] == 1) {
			$item = array('title' => $log['title'], 'goodstitle' => $log['title'] . '消费', 'money' => $log['money'] + $log['deduction'], 'paytype' => $log['paytype'], 'time' => date('Y-m-d H:i:s', $log['paytime']), 'out_trade_no' => $log['logno'], 'randommoney' => (double) $log['randommoney'], 'enough' => (double) $log['enough'], 'deduction' => (double) $log['deduction'], 'discountmoney' => (double) $log['discountmoney'], 'orderprice' => (double) $log['orderprice'], 'goodsprice' => (double) $log['goodsprice'], 'couponpay' => (double) $log['usecouponprice'], 'present_credit1' => (int) $log['present_credit1']);
			if (empty($log['paytype']) || $log['paytype'] == '101') {
				$item['paytype'] = '微信支付';
			}
			else {
				if ($log['paytype'] == '1' || $log['paytype'] == '102') {
					$item['paytype'] = '支付宝支付';
				}
				else if ($log['paytype'] == '2') {
					$item['paytype'] = '余额支付';
				}
				else {
					if ($log['paytype'] == '3') {
						$item['paytype'] = '现金收款';
					}
				}
			}

			if (com('coupon') && !empty($log['coupon'])) {
				$coupon = com('coupon')->getCoupon($log['coupon']);

				if (!empty($coupon)) {
					$coupon['thumb'] = tomedia($coupon['thumb']);
					$coupon['timestr'] = '永久有效';

					if (empty($coupon['timelimit'])) {
						if (!empty($coupon['timedays'])) {
							$coupon['timestr'] = date('Y-m-d H:i', $coupon['gettime'] + $coupon['timedays'] * 86400);
						}
					}
					else if (time() <= $coupon['timestart']) {
						$coupon['timestr'] = date('Y-m-d H:i', $coupon['timestart']) . '-' . date('Y-m-d H:i', $coupon['timeend']);
					}
					else {
						$coupon['timestr'] = date('Y-m-d H:i', $coupon['timeend']);
					}

					if ($coupon['backtype'] == 0) {
						$coupon['backstr'] = '立减';
						$coupon['css'] = 'deduct';
						$coupon['backmoney'] = $coupon['deduct'];
						$coupon['backpre'] = true;

						if ($coupon['enough'] == '0') {
							$coupon['color'] = 'org ';
						}
						else {
							$coupon['color'] = 'blue';
						}
					}
					else if ($coupon['backtype'] == 1) {
						$coupon['backstr'] = '折';
						$coupon['css'] = 'discount';
						$coupon['backmoney'] = $coupon['discount'];
						$coupon['color'] = 'red ';
					}
					else {
						if ($coupon['backtype'] == 2) {
							if ($coupon['coupontype'] == '0') {
								$coupon['color'] = 'red ';
							}
							else {
								$coupon['color'] = 'pink ';
							}

							if (0 < $coupon['backredpack']) {
								$coupon['backstr'] = '返现';
								$coupon['css'] = 'redpack';
								$coupon['backmoney'] = $coupon['backredpack'];
								$coupon['backpre'] = true;
							}
							else if (0 < $coupon['backmoney']) {
								$coupon['backstr'] = '返利';
								$coupon['css'] = 'money';
								$coupon['backpre'] = true;
							}
							else {
								if (!empty($coupon['backcredit'])) {
									$coupon['backstr'] = '返积分';
									$coupon['css'] = 'credit';
									$coupon['backmoney'] = $coupon['backcredit'];
								}
							}
						}
					}
				}
			}

			include $this->template('cashier/success');
			exit();
		}

		show_json(0);
	}

	public function getcoupon()
	{
		global $_GPC;
		global $_W;
		$money = floatval($_GPC['money']);

		if (0 < $money) {
			$coupon = com_run('coupon::getCashierCoupons', $_W['openid'], floatval($_GPC['money']), $_W['cashieruser']['merchid']);

			if ($coupon) {
				show_json(1, array('coupons' => $coupon));
			}
		}

		show_json(0, array(
			'coupons' => array()
		));
	}
}

?>
