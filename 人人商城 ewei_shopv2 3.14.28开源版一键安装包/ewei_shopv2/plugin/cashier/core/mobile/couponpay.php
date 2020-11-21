<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'cashier/core/inc/mobile_cashier.php';
class Couponpay_EweiShopV2Page extends CashierMobilePage
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
		$type = intval($_GPC['type']);
		$id = false;
		$goodstitle = $_W['cashieruser']['title'] . '优惠买单';
		$couponpay = $this->model->getUserSet('couponpay', $_W['cashierid']);

		if (empty($couponpay['goodsids'])) {
			$this->message('未选择优惠买单商品!', '', 'error');
		}

		$can = $this->discount($couponpay, $type);
		$paytype = $this->model->paytype(-1);
		include $this->template();
	}

	public function pay()
	{
		global $_W;
		global $_GPC;
		$paytype = $this->model->paytype((int) $_GPC['paytype']);
		$money = (double) $_GPC['money'];
		$no_money = (double) $_GPC['no_money'];
		$title = $_GPC['goodstitle'];
		$jie = intval($_GPC['jie']);
		$type = intval($_GPC['type']);

		if ($money <= 0) {
			show_json(0, '金额填写错误!');
		}

		$couponpay = $this->model->getUserSet('couponpay', $_W['cashierid']);

		if (!empty($type)) {
			$couponpay['goodsids'] = $couponpay['goodsids' . $type];
		}

		$couponpaymoney = $this->discountMoney($money, $no_money, $type);
		$paymoney = $money - $couponpaymoney;
		$goods = array(
			array('goodsid' => $couponpay['goodsids'], 'optionid' => 0, 'price' => $paymoney, 'marketprice' => $money, 'total' => 1)
		);
		$this->log = $this->model->goodsCalculate(array(), $goods, array('paytype' => $paytype, 'openid' => $_W['openid'] != 'alipay' ? $_W['openid'] : '', 'money' => $paymoney, 'couponpay' => $couponpaymoney, 'nosalemoney' => $no_money, 'deduction' => 0, 'mobile' => 0, 'title' => $title, 'operatorid' => intval($_GPC['operatorid'])), 1);

		if (is_error($this->log)) {
			show_json(0, '数据插入错误,请重试!');
		}

		if ($paytype == '0') {
			$this->paytype0($jie);
		}
		else if ($paytype == '1') {
			$this->paytype1();
		}
		else {
			if ($paytype == '101') {
				$this->paytype101($jie);
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

		show_json(1, array('wechat' => $wechat, 'logid' => $this->log['id']));
	}

	protected function paytype1()
	{
		global $_W;
		$params = array('out_trade_no' => $this->log['logno'], 'seller_id' => '', 'total_amount' => $this->log['money'], 'subject' => $this->log['title'], 'body' => $_W['uniacid'] . ':2:' . $_W['cashierid']);
		$config = json_decode($_W['cashieruser']['alipay'], true);

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
				$wechat['weixin'] = true;
				$wechat['success'] = true;
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

		show_json(1, array('wechat' => $wechat, 'logid' => $this->log['id']));
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

	protected function discountMoney($money, $no_money, $type)
	{
		global $_W;
		$yes_money = $money - $no_money;
		$couponpay = $this->model->getUserSet('couponpay', $_W['cashierid']);
		$can = $this->discount($couponpay, $type);

		if ($can) {
			$return_money = $yes_money * (10 - $can) / 10;
			return max(0, round($return_money, 2));
		}

		return 0;
	}

	protected function discount($couponpay, $type)
	{
		if (empty($couponpay)) {
			return false;
		}

		if (!empty($type)) {
			$couponpay['time'] = $couponpay['time' . $type];
			$couponpay['discount'] = $couponpay['discount' . $type];
		}

		if ($couponpay['time']['start'] < time() && time() < $couponpay['time']['end']) {
			if (10 <= $couponpay['discount']) {
				return false;
			}

			return (double) $couponpay['discount'];
		}

		return false;
	}
}

?>
