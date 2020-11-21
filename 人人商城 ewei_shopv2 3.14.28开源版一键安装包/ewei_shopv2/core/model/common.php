<?php

class Common_EweiShopV2Model
{
	public $public_build;

	public function getSetData($uniacid = 0)
	{
		global $_W;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$set = m('cache')->getArray('sysset', $uniacid);

		if (empty($set)) {
			$set = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

			if (empty($set)) {
				$set = array();
			}

			m('cache')->set('sysset', $set, $uniacid);
		}

		return $set;
	}

	/**
     * 获取配置
     */
	public function getSysset($key = '', $uniacid = 0)
	{
		global $_W;
		global $_GPC;
		$set = $this->getSetData($uniacid);
		$allset = iunserializer($set['sets']);
		$retsets = array();

		if (!empty($key)) {
			if (is_array($key)) {
				foreach ($key as $k) {
					$retsets[$k] = isset($allset[$k]) ? $allset[$k] : array();
				}
			}
			else {
				$retsets = isset($allset[$key]) ? $allset[$key] : array();
			}

			return $retsets;
		}

		return $allset;
	}

	public function getPluginset($key = '', $uniacid = 0)
	{
		global $_W;
		global $_GPC;
		$set = $this->getSetData($uniacid);
		$allset = iunserializer($set['plugins']);
		$retsets = array();

		if (!empty($key)) {
			if (is_array($key)) {
				foreach ($key as $k) {
					$retsets[$k] = isset($allset[$k]) ? $allset[$k] : array();
				}
			}
			else {
				$retsets = isset($allset[$key]) ? $allset[$key] : array();
			}

			return $retsets;
		}

		return $allset;
	}

	public function updateSysset($values, $uniacid = 0)
	{
		global $_W;
		global $_GPC;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$setdata = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

		if (empty($setdata)) {
			$res = pdo_insert('ewei_shop_sysset', array('sets' => iserializer($values), 'uniacid' => $uniacid));
			$setdata = array('sets' => $values);
		}
		else {
			$sets = iunserializer($setdata['sets']);
			$sets = is_array($sets) ? $sets : array();

			foreach ($values as $key => $value) {
				foreach ($value as $k => $v) {
					$sets[$key][$k] = $v;
				}
			}

			$res = pdo_update('ewei_shop_sysset', array('sets' => iserializer($sets)), array('id' => $setdata['id']));

			if ($res) {
				$setdata['sets'] = $sets;
			}
		}

		if (empty($res)) {
			$setdata = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		}

		m('cache')->set('sysset', $setdata, $uniacid);
		$this->setGlobalSet($uniacid);
	}

	public function deleteSysset($key, $uniacid = 0)
	{
		global $_W;
		global $_GPC;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$setdata = pdo_fetch('select id, sets from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

		if (!empty($setdata)) {
			$sets = iunserializer($setdata['sets']);
			$sets = is_array($sets) ? $sets : array();

			if (!empty($key)) {
				if (is_array($key)) {
					foreach ($key as $k) {
						unset($sets[$k]);
					}
				}
				else {
					unset($sets[$key]);
				}
			}

			pdo_update('ewei_shop_sysset', array('sets' => iserializer($sets)), array('id' => $setdata['id']));
		}

		$setdata = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		m('cache')->set('sysset', $setdata, $uniacid);
		$this->setGlobalSet($uniacid);
	}

	public function updatePluginset($values, $uniacid = 0)
	{
		global $_W;
		global $_GPC;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$setdata = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

		if (empty($setdata)) {
			$res = pdo_insert('ewei_shop_sysset', array('plugins' => iserializer($values), 'uniacid' => $uniacid));
			$setdata = array('plugins' => $values);
		}
		else {
			$plugins = iunserializer($setdata['plugins']);

			if (!is_array($plugins)) {
				$plugins = array();
			}

			foreach ($values as $key => $value) {
				foreach ($value as $k => $v) {
					if (!isset($plugins[$key]) || !is_array($plugins[$key])) {
						$plugins[$key] = array();
					}

					$plugins[$key][$k] = $v;
				}
			}

			$res = pdo_update('ewei_shop_sysset', array('plugins' => iserializer($plugins)), array('id' => $setdata['id']));

			if ($res) {
				$setdata['plugins'] = $plugins;
			}
		}

		if (empty($res)) {
			$setdata = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		}

		m('cache')->set('sysset', $setdata, $uniacid);
		$this->setGlobalSet($uniacid);
	}

	public function setGlobalSet($uniacid = 0)
	{
		$sysset = $this->getSysset('', $uniacid);
		$sysset = is_array($sysset) ? $sysset : array();
		$pluginset = $this->getPluginset('', $uniacid);

		if (is_array($pluginset)) {
			foreach ($pluginset as $k => $v) {
				$sysset[$k] = $v;
			}
		}

		m('cache')->set('globalset', $sysset, $uniacid);
		return $sysset;
	}

	public function alipay_build($params, $alipay = array(), $type = 0, $openid = '')
	{
		global $_W;
		$sec = $this->getSec();
		$sec = iunserializer($sec['sec']);
		$pay = m('common')->getSysset('pay');
		$tid = $params['tid'];
		$set = array();

		if (0 < $pay['alipay_id']) {
			$pars = array();
			$pars['out_trade_no'] = $tid;
			$pars['public_key'] = $sec['alipay_pay']['public_key'];
			$pars['total_amount'] = $params['fee'];
			$pars['subject'] = trim($params['title']);
			$pars['body'] = $_W['uniacid'] . ':' . $type;
			$config = array();
			$config['privatekey'] = trim($sec['alipay_pay']['private_key']);
			$config['app_id'] = trim($sec['alipay_pay']['appid']);
			if (!empty($sec['alipay_pay']['alipay_sign_type']) && $sec['alipay_pay']['alipay_sign_type'] == 1) {
				$config['sign_type'] = 'RSA2';
			}
			else {
				if ($sec['alipay_pay']['alipay_sign_type'] == 0) {
					$config['sign_type'] = 'RSA';
				}
			}

			$biz_content = array_filter($pars);

			if (empty($type)) {
				$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
				$config['return_url'] = mobileUrl('order/pay_alipay/complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
			}
			else if ($type == 20) {
				$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
				$config['return_url'] = mobileUrl('creditshop/detail/creditshop_complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
			}
			else if ($type == 21) {
				$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
				$config['return_url'] = mobileUrl('creditshop/log/dispatch_complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
			}
			else if ($type == 6) {
				$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
				$config['return_url'] = mobileUrl('threen/register/threen_complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
			}
			else if ($type == 22) {
				$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
				$config['return_url'] = mobileUrl('membercard/detail/membercard_complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
			}
			else {
				$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
				$config['return_url'] = mobileUrl('order/pay_alipay/recharge_complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
			}

			$config['biz_content'] = json_encode($biz_content);
			$result = $this->AliPayWap($pars, $config);

			if ($result['errno'] == -1) {
				return error(-1, $result['message']);
			}

			return array('url' => ALIPAY_GATEWAY . '?' . http_build_query($result, '', '&'));
		}

		$set['service'] = 'alipay.wap.create.direct.pay.by.user';
		$set['partner'] = $alipay['partner'];
		$set['_input_charset'] = 'utf-8';
		$set['sign_type'] = 'MD5';

		if (empty($type)) {
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('order/pay_alipay/complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
		}
		else if ($type == 20) {
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('creditshop/detail/creditshop_complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
		}
		else if ($type == 21) {
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('creditshop/log/dispatch_complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
		}
		else if ($type == 6) {
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('threen/register/threen_complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
		}
		else if ($type == 22) {
			$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$config['return_url'] = mobileUrl('membercard/detail/membercard_complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
		}
		else {
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('order/pay_alipay/recharge_complete', array('openid' => $openid, 'fromwechat' => is_weixin() ? 1 : 0), true);
		}

		$set['out_trade_no'] = $tid;
		$set['subject'] = trim($params['title']);
		$set['total_fee'] = $params['fee'];
		$set['seller_id'] = $alipay['account'];
		$set['app_pay'] = 'Y';
		$set['payment_type'] = 1;
		$set['body'] = $_W['uniacid'] . ':' . $type;
		$prepares = array();

		foreach ($set as $key => $value) {
			if ($key != 'sign' && $key != 'sign_type') {
				$prepares[] = $key . '=' . $value;
			}
		}

		sort($prepares);
		$string = implode($prepares, '&');
		$string .= $alipay['secret'];
		$set['sign'] = md5($string);
		return array('url' => ALIPAY_GATEWAY . '?' . http_build_query($set, '', '&'));
	}

	public function publicAliPay($params = array(), $return = NULL)
	{
		if (is_numeric($params['sign_type'])) {
			$params['sign_type'] = intval($params['sign_type']) == 1 ? 'RSA2' : 'RSA';
		}

		$public = array('app_id' => $params['app_id'], 'method' => $params['method'], 'format' => 'JSON', 'charset' => 'utf-8', 'sign_type' => $params['sign_type'], 'timestamp' => date('Y-m-d H:i:s'), 'version' => '1.0');

		if (!empty($params['return_url'])) {
			$public['return_url'] = $params['return_url'];
		}

		if (!empty($params['app_auth_token'])) {
			$public['app_auth_token'] = $params['app_auth_token'];
		}

		if (!empty($params['notify_url'])) {
			$public['notify_url'] = $params['notify_url'];
		}

		if (!empty($params['biz_content'])) {
			$public['biz_content'] = is_array($params['biz_content']) ? json_encode($params['biz_content']) : $params['biz_content'];
		}

		ksort($public);
		$string1 = '';

		foreach ($public as $key => $v) {
			if (empty($v)) {
				continue;
			}

			$string1 .= $key . '=' . $v . '&';
		}

		$string1 = rtrim($string1, '&');
		$pkeyid = openssl_pkey_get_private($this->chackKey($params['privatekey'], false));

		if ($pkeyid === false) {
			return error(-1, '提供的私钥格式不对');
		}

		$signature = '';

		if ($params['sign_type'] == 'RSA') {
			openssl_sign($string1, $signature, $pkeyid, OPENSSL_ALGO_SHA1);
		}
		else {
			if ($params['sign_type'] == 'RSA2') {
				openssl_sign($string1, $signature, $pkeyid, OPENSSL_ALGO_SHA256);
			}
		}

		openssl_free_key($pkeyid);
		$signature = base64_encode($signature);

		if (empty($signature)) {
			return error(-1, '签名不能为空！');
		}

		$public['sign'] = $signature;
		load()->func('communication');
		$url = EWEI_SHOPV2_DEBUG ? 'https://openapi.alipaydev.com/gateway.do' : 'https://openapi.alipay.com/gateway.do';

		if ($return !== NULL) {
			return $public;
		}

		$response = ihttp_post($url, $public);
		$result = json_decode(iconv('GBK', 'UTF-8//IGNORE', $response['content']), true);
		return $result;
	}

	public function chackKey($key, $public = true)
	{
		if (empty($key)) {
			return $key;
		}

		if ($public) {
			if (strexists($key, '-----BEGIN PUBLIC KEY-----')) {
				$key = str_replace(array('-----BEGIN PUBLIC KEY-----', '-----END PUBLIC KEY-----'), '', $key);
			}

			$head_end = '-----BEGIN PUBLIC KEY-----
{key}
-----END PUBLIC KEY-----';
		}
		else {
			if (strexists($key, '-----BEGIN RSA PRIVATE KEY-----')) {
				$key = str_replace(array('-----BEGIN RSA PRIVATE KEY-----', '-----END RSA PRIVATE KEY-----'), '', $key);
			}

			$head_end = '-----BEGIN RSA PRIVATE KEY-----
{key}
-----END RSA PRIVATE KEY-----';
		}

		$key = str_replace(array('
', '
', '
'), '', trim($key));
		$key = wordwrap($key, 64, '
', true);
		return str_replace('{key}', $key, $head_end);
	}

	/**
     *
     * 支付宝条码支付
     * @param $params  = array('out_trade_no' => 订单号,'auth_code' => 支付授权码,'total_amount' => 0.01 支付金额,'subject' => '标题','body' => '内容',);
     * @param $config = array('app_id' => ,'seller_id'=>'','privatekey' => "",'publickey' => "",'alipublickey' => "");
     * @return array|mixed
     */
	public function AliPayBarcode($params, $config)
	{
		global $_W;
		$biz_content = array();
		$biz_content['out_trade_no'] = $params['out_trade_no'];
		$biz_content['scene'] = 'bar_code';
		$biz_content['auth_code'] = $params['auth_code'];
		$biz_content['seller_id'] = $config['seller_id'];
		$biz_content['total_amount'] = $params['total_amount'];
		$biz_content['subject'] = $params['subject'];
		$biz_content['body'] = $params['body'];
		$biz_content['timeout_express'] = '90m';
		$biz_content = array_filter($biz_content);
		$config['method'] = 'alipay.trade.pay';
		$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
		$config['biz_content'] = json_encode($biz_content);

		if ($config['sign_type'] == 1) {
			$config['sign_type'] = 'RSA2';
		}
		else {
			if ($config['sign_type'] == 0) {
				$config['sign_type'] = 'RSA';
			}
		}

		$result = $this->publicAliPay($config);

		if (is_error($result)) {
			return $result;
		}

		$key = str_replace('.', '_', $config['method']) . '_response';

		if ($result[$key]['code'] == '10000') {
			return $result[$key];
		}

		return error($result[$key]['code'], $result[$key]['msg'] . ':' . $result[$key]['sub_msg']);
	}

	/**
     *
     * 支付宝条码支付
     * @param $params  = array('out_trade_no' => 订单号,'seller_id'=>'','total_amount' => 0.01 支付金额,'subject' => '标题','body' => '内容',);
     * @param $config = array('app_id' => ,'seller_id'=>,'privatekey' => "",'publickey' => "",'alipublickey' => "");
     * @return array|mixed
     */
	public function AliPayWap($params, $config)
	{
		global $_W;
		$biz_content = array();
		$biz_content['out_trade_no'] = trim($params['out_trade_no']);
		$biz_content['seller_id'] = $config['seller_id'];
		$biz_content['total_amount'] = $params['total_amount'];
		$biz_content['subject'] = trim($params['subject']);
		$biz_content['body'] = trim($params['body']);
		$biz_content['product_code'] = 'QUICK_WAP_PAY';
		$biz_content['timeout_express'] = '90m';
		$biz_content = array_filter($biz_content);
		$config['method'] = 'alipay.trade.wap.pay';
		$config['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
		$config['biz_content'] = json_encode($biz_content);
		$result = $this->publicAliPay($config, 1);
		return $result;
	}

	/**
     * 支付宝订单查询
     * @param $out_trade_no 订单号码
     * @param $config array('app_id' => ,'privatekey' => "",'publickey' => "",'alipublickey' => "");
     * @return array|mixed
     */
	public function AliPayQuery($out_trade_no, $config)
	{
		$biz_content = array();
		$biz_content['out_trade_no'] = $out_trade_no;
		$config['method'] = 'alipay.trade.query';
		$config['biz_content'] = json_encode($biz_content);

		if ($config['sign_type'] == 1) {
			$config['sign_type'] = 'RSA2';
		}
		else {
			if ($config['sign_type'] == 0) {
				$config['sign_type'] = 'RSA';
			}
		}

		$result = $this->publicAliPay($config);

		if (is_error($result)) {
			return $result;
		}

		$key = str_replace('.', '_', $config['method']) . '_response';
		if ($result[$key]['code'] == '10000' && $result[$key]['trade_status'] == 'TRADE_SUCCESS') {
			return $result[$key];
		}

		if (!empty($result[$key]['trade_status']) && $result[$key]['trade_status'] == 'TRADE_CLOSED') {
			return error($result[$key]['code'], '该订单已经关闭或者已经退款');
		}

		return error($result[$key]['code'], $result[$key]['msg'] . ':' . $result[$key]['sub_msg']);
	}

	/**
     * 支付宝订单查询
     * @param $out_trade_no 订单号码
     * @param $config array('app_id' => ,'privatekey' => "",'publickey' => "",'alipublickey' => "");
     * @return array|mixed
     */
	public function AliPayRefundQuery($out_trade_no, $config)
	{
		$biz_content = array();
		$biz_content['out_trade_no'] = $out_trade_no;
		$biz_content['out_request_no'] = $out_trade_no;
		$config['method'] = 'alipay.trade.fastpay.refund.query';
		$config['biz_content'] = json_encode($biz_content);
		$result = $this->publicAliPay($config);

		if (is_error($result)) {
			return $result;
		}

		$key = str_replace('.', '_', $config['method']) . '_response';
		if ($result[$key]['code'] == '10000' && $result[$key]['msg'] == 'Success') {
			return $result[$key];
		}

		return error($result[$key]['code'], $result[$key]['msg'] . ':' . $result[$key]['sub_msg']);
	}

	/**
     * 支付宝订单查询
     * @param $app_auth_token 啦啦啦
     * @param $config array('app_id' => ,'privatekey' => "",'publickey' => "",'alipublickey' => "");
     * @return array|mixed
     */
	public function AlipayOpenAuthTokenAppRequest($app_code, $config)
	{
		$biz_content = array();
		$biz_content['grant_type'] = 'authorization_code';
		$biz_content['code'] = $app_code;
		$config['method'] = 'alipay.open.auth.token.app';
		$config['biz_content'] = json_encode($biz_content);
		$result = $this->publicAliPay($config);

		if (is_error($result)) {
			return $result;
		}

		$key = str_replace('.', '_', $config['method']) . '_response';
		if ($result[$key]['code'] == '10000' && $result[$key]['msg'] == 'Success') {
			return $result[$key];
		}

		return error($result[$key]['code'], $result[$key]['msg'] . ':' . $result[$key]['sub_msg']);
	}

	public function AlipayOpenAuthTokenAppQueryRequest($app_auth_token, $config)
	{
		$biz_content = array();
		$biz_content['app_auth_token'] = $app_auth_token;
		$config['method'] = 'alipay.open.auth.token.app.query';
		$config['biz_content'] = json_encode($biz_content);
		$result = $this->publicAliPay($config);

		if (is_error($result)) {
			return $result;
		}

		$key = str_replace('.', '_', $config['method']) . '_response';
		if ($result[$key]['code'] == '10000' && $result[$key]['msg'] == 'Success') {
			return $result[$key];
		}

		return error($result[$key]['code'], $result[$key]['msg'] . ':' . $result[$key]['sub_msg']);
	}

	public function ToXml($arr)
	{
		if (!is_array($arr) || count($arr) <= 0) {
			return error(-1, '数组数据异常！');
		}

		$xml = '<xml>';

		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function FromXml($xml)
	{
		if (!$xml) {
			return error(-1, 'xml数据异常！');
		}

		libxml_disable_entity_loader(true);
		$arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		return $arr;
	}

	/**
     * 格式化参数格式化成url参数
     */
	public function ToUrlParams($arr)
	{
		$buff = '';

		foreach ($arr as $k => $v) {
			if ($k != 'sign' && $v != '' && !is_array($v)) {
				$buff .= $k . '=' . $v . '&';
			}
		}

		$buff = trim($buff, '&');
		return $buff;
	}

	public function changeTitle($title)
	{
		$title = preg_replace('/[^\\x{4e00}-\\x{9fa5}A-Za-z0-9_]/u', '', $title);
		return $title;
	}

	/**
     * @param bool $isapp
     * @return array
     */
	public function public_build($isapp = false)
	{
		global $_W;

		if (!empty($this->public_build)) {
			return $this->public_build;
		}

		$set = $this->getSysset('pay');
		if (!empty($set['weixin_id']) && $isapp == false) {
			$payments = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_payment') . ' WHERE uniacid=:uniacid AND id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $set['weixin_id']));

			if (empty($payments)) {
				error(-1, '支付参数不存在!');
			}

			$payments['is_new'] = 1;
		}
		else {
			$payments = m('common')->getSec();
			$payments = iunserializer($payments['sec']);
			$payments['is_new'] = 0;
		}

		$this->public_build = array($set, $payments);
		return $this->public_build;
	}

	/**
     * 微信支付
     * @param $params
     * @param $wechat
     * @param int $type
     * @return array
     */
	public function wechat_build($params, $wechat, $type = 0)
	{
		global $_W;
		list(, $payment) = $this->public_build();

		if (is_error($payment)) {
			return $payment;
		}

		$params['title'] = $this->changeTitle(trim($params['title']));
		if ($payment['is_new'] == 0 && !empty($payment['weixin_sub'])) {
			$wechat = array('appid' => trim($payment['appid_sub']), 'mch_id' => trim($payment['mchid_sub']), 'sub_appid' => !empty($payment['sub_appid_sub']) ? trim($payment['sub_appid_sub']) : '', 'sub_mch_id' => trim($payment['sub_mchid_sub']), 'apikey' => trim($payment['apikey_sub']));
			$params['openid'] = isset($params['user']) ? trim($params['user']) : trim($_W['openid']);
			return $this->wechat_child_build($params, $wechat, $type);
		}

		if ($payment['is_new'] == 1) {
			if (empty($payment['type'])) {
				return $this->wechat_jspay($params, $payment, $type);
			}

			if ($payment['type'] == 1) {
				$params['openid'] = isset($params['user']) ? trim($params['user']) : trim($_W['openid']);
				return $this->wechat_child_build($params, $payment, $type);
			}

			if ($payment['type'] == 2) {
				$wechat = array('appid' => trim($payment['sub_appid']), 'mchid' => trim($payment['sub_mch_id']), 'apikey' => trim($payment['apikey']));

				if (!empty($payment['sub_appsecret'])) {
					$wxuser = m('member')->wxuser(trim($payment['sub_appid']), trim($payment['sub_appsecret']));
					$params['openid'] = trim($wxuser['openid']);
				}

				return $this->wechat_native_build($params, $wechat, $type);
			}

			if ($payment['type'] == 3) {
				return $this->wechat_native_child_build($params, $payment, $type);
			}

			if ($payment['type'] == 4) {
				$params = array('service' => 'pay.weixin.jspay', 'body' => trim($params['title']), 'out_trade_no' => $params['tid'], 'total_fee' => $params['fee'], 'openid' => empty($params['openid']) ? trim($_W['openid']) : trim($params['openid']), 'sub_appid' => trim($wechat['appid']));
				$payRes = m('pay')->build($params, $payment, $type);

				if (is_error($payRes)) {
					return $payRes;
				}

				return json_decode($payRes['pay_info'], true);
			}
		}

		$payment['sub_appid'] = trim($wechat['appid']);
		$payment['sub_mch_id'] = trim($wechat['mchid']);
		$payment['apikey'] = trim($wechat['apikey']);
		return $this->wechat_jspay($params, $payment, $type);
	}

	public function wechat_jspay($params, $wechat, $type = 0)
	{
		global $_W;
		load()->func('communication');
		$wOpt = array();
		$package = array();
		$package['appid'] = trim($wechat['sub_appid']);
		$package['mch_id'] = trim($wechat['sub_mch_id']);
		$package['nonce_str'] = random(32);
		$package['body'] = trim($params['title']);
		$package['device_info'] = 'ewei_shopv2';
		$package['attach'] = $_W['uniacid'] . ':' . $type;
		$package['out_trade_no'] = trim($params['tid']);
		$package['total_fee'] = $params['fee'] * 100;
		$package['spbill_create_ip'] = CLIENT_IP;

		if (!empty($params['goods_tag'])) {
			$package['goods_tag'] = trim($params['goods_tag']);
		}

		$package['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php';
		$package['trade_type'] = 'JSAPI';
		$package['openid'] = empty($params['openid']) ? trim($_W['openid']) : trim($params['openid']);
		ksort($package, SORT_STRING);
		$string1 = '';

		foreach ($package as $key => $v) {
			if (empty($v)) {
				continue;
			}

			$string1 .= $key . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5(trim($string1)));
		$dat = array2xml($package);
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);

		if (is_error($response)) {
			return $response;
		}

		libxml_disable_entity_loader(true);
		$xml = @simplexml_load_string(trim($response['content']), 'SimpleXMLElement', LIBXML_NOCDATA);

		if (strval($xml->return_code) == 'FAIL') {
			return error(-1, strval($xml->return_msg));
		}

		if (strval($xml->result_code) == 'FAIL') {
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}

		$prepayid = $xml->prepay_id;
		$wOpt['appId'] = trim($wechat['sub_appid']);
		$wOpt['timeStamp'] = TIMESTAMP . '';
		$wOpt['nonceStr'] = random(32);
		$wOpt['package'] = 'prepay_id=' . $prepayid;
		$wOpt['signType'] = 'MD5';
		ksort($wOpt, SORT_STRING);
		$string = '';

		foreach ($wOpt as $key => $v) {
			$string .= $key . '=' . $v . '&';
		}

		$string .= 'key=' . $wechat['apikey'];
		$wOpt['paySign'] = strtoupper(md5(trim($string)));
		return $wOpt;
	}

	public function wechat_child_build($params, $wechat, $type = 0)
	{
		global $_W;
		load()->func('communication');
		$package = array();
		$package['appid'] = trim($wechat['appid']);
		$package['mch_id'] = trim($wechat['mch_id']);
		$package['sub_mch_id'] = trim($wechat['sub_mch_id']);
		$package['nonce_str'] = random(32);
		$package['body'] = trim($params['title']);
		$package['device_info'] = isset($params['device_info']) ? 'ewei_shopv2:' . $params['device_info'] : 'ewei_shopv2';
		$package['attach'] = (isset($params['uniacid']) ? $params['uniacid'] : $_W['uniacid']) . ':' . $type;
		$package['out_trade_no'] = trim($params['tid']);
		$package['total_fee'] = floatval($params['fee']) * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['product_id'] = $params['goods_id'];

		if (!empty($params['goods_tag'])) {
			$package['goods_tag'] = trim($params['goods_tag']);
		}

		$package['time_start'] = date('YmdHis', TIMESTAMP);
		$package['time_expire'] = date('YmdHis', TIMESTAMP + 3600);
		$package['notify_url'] = empty($params['notify_url']) ? $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php' : $params['notify_url'];
		$package['trade_type'] = 'JSAPI';

		if (!empty($wechat['sub_appid'])) {
			$package['sub_appid'] = trim($wechat['sub_appid']);
			$package['sub_openid'] = trim($params['openid']);
		}
		else {
			$package['openid'] = trim($params['openid']);
		}

		ksort($package, SORT_STRING);
		$string1 = '';

		foreach ($package as $key => $v) {
			if (empty($v)) {
				continue;
			}

			$string1 .= $key . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5(trim($string1)));
		$dat = array2xml($package);
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);

		if (is_error($response)) {
			return $response;
		}

		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string(trim($response['content']), 'SimpleXMLElement', LIBXML_NOCDATA);

		if (strval($xml->return_code) == 'FAIL') {
			return error(-1, strval($xml->return_msg));
		}

		if (strval($xml->result_code) == 'FAIL') {
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}

		libxml_disable_entity_loader(true);
		$prepayid = $xml->prepay_id;
		$wOpt = array('appId' => trim($wechat['sub_appid']), 'timeStamp' => TIMESTAMP . '', 'nonceStr' => random(32), 'package' => 'prepay_id=' . $prepayid, 'signType' => 'MD5');
		ksort($wOpt, SORT_STRING);
		$string = '';

		foreach ($wOpt as $key => $v) {
			$string .= $key . '=' . $v . '&';
		}

		$string .= 'key=' . $wechat['apikey'];
		$wOpt['paySign'] = strtoupper(md5($string));
		return $wOpt;
	}

	public function wechat_native_build($params, $wechat, $type = 0, $diy = NULL)
	{
		global $_W;

		if ($diy === NULL) {
			list(, $payment) = $this->public_build();

			if (is_error($payment)) {
				return $payment;
			}

			if ($payment['is_new'] == 0 && !empty($payment['weixin_jie_sub'])) {
				$wechat = array('appid' => $payment['appid_jie_sub'], 'mch_id' => $payment['mchid_jie_sub'], 'sub_appid' => !empty($payment['sub_appid_jie_sub']) ? $payment['sub_appid_jie_sub'] : '', 'sub_appsecret' => !empty($payment['sub_secret_jie_sub']) ? $payment['sub_secret_jie_sub'] : '', 'sub_mch_id' => $payment['sub_mchid_jie_sub'], 'apikey' => $payment['apikey_jie_sub']);
				return $this->wechat_native_child_build($params, $wechat, $type);
			}

			if ($payment['is_new'] == 1) {
				if ($payment['type'] == 3) {
					return $this->wechat_native_child_build($params, $payment, $type);
				}

				if ($payment['type'] == 4) {
					$params = array('service' => 'pay.weixin.jspay', 'body' => $params['title'], 'out_trade_no' => $params['tid'], 'total_fee' => $params['fee'], 'openid' => empty($params['openid']) ? $_W['openid'] : $params['openid']);
					$payRes = m('pay')->build($params, $payment, 0);

					if (is_error($payRes)) {
						return $payRes;
					}

					return $payRes;
				}
			}
		}

		if (!empty($params['openid'])) {
			$wechat['sub_appid'] = trim($wechat['appid']);
			$wechat['sub_mch_id'] = trim($wechat['mchid']);
			return $this->wechat_jspay($params, $wechat, $type);
		}

		$package = array();
		$package['appid'] = trim($wechat['appid']);
		$package['mch_id'] = trim($wechat['mchid']);
		$package['nonce_str'] = random(32);
		$package['body'] = trim($params['title']);
		$package['device_info'] = isset($params['device_info']) ? 'ewei_shopv2:' . $params['device_info'] : 'ewei_shopv2';
		$package['attach'] = (isset($params['uniacid']) ? $params['uniacid'] : $_W['uniacid']) . ':' . $type;
		$package['out_trade_no'] = trim($params['tid']);
		$package['total_fee'] = floatval($params['fee']) * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['product_id'] = $params['tid'];

		if (!empty($params['goods_tag'])) {
			$package['goods_tag'] = trim($params['goods_tag']);
		}

		$package['time_start'] = date('YmdHis', TIMESTAMP);
		$package['time_expire'] = date('YmdHis', TIMESTAMP + 3600);
		$package['notify_url'] = empty($params['notify_url']) ? $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php' : $params['notify_url'];
		$package['trade_type'] = 'NATIVE';
		ksort($package, SORT_STRING);
		$string1 = '';

		foreach ($package as $key => $v) {
			if (empty($v)) {
				continue;
			}

			$string1 .= $key . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5(trim($string1)));
		$dat = array2xml($package);
		load()->func('communication');
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);

		if (is_error($response)) {
			return $response;
		}

		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string(trim($response['content']), 'SimpleXMLElement', LIBXML_NOCDATA);

		if (strval($xml->return_code) == 'FAIL') {
			return error(-1, strval($xml->return_msg));
		}

		if (strval($xml->result_code) == 'FAIL') {
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}

		$result = json_decode(json_encode($xml), true);
		return $result;
	}

	public function wechat_native_child_build($params, $wechat, $type = 0)
	{
		global $_W;

		if (!empty($wechat['sub_appsecret'])) {
			$wxuser = m('member')->wxuser($wechat['sub_appid'], $wechat['sub_appsecret']);
			$params['openid'] = $wxuser['openid'];
			return $this->wechat_child_build($params, $wechat, $type);
		}

		$package = array();
		$package['appid'] = $wechat['appid'];

		if (!empty($wechat['sub_appid'])) {
			$package['sub_appid'] = $wechat['sub_appid'];
		}

		$package['mch_id'] = $wechat['mch_id'];
		$package['sub_mch_id'] = $wechat['sub_mch_id'];
		$package['nonce_str'] = random(32);
		$package['body'] = $params['title'];
		$package['device_info'] = isset($params['device_info']) ? 'ewei_shopv2:' . $params['device_info'] : 'ewei_shopv2';
		$package['attach'] = (isset($params['uniacid']) ? $params['uniacid'] : $_W['uniacid']) . ':' . $type;
		$package['out_trade_no'] = $params['tid'];
		$package['total_fee'] = $params['fee'] * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['product_id'] = $params['tid'];

		if (!empty($params['goods_tag'])) {
			$package['goods_tag'] = $params['goods_tag'];
		}

		$package['time_start'] = date('YmdHis', TIMESTAMP);
		$package['time_expire'] = date('YmdHis', TIMESTAMP + 3600);
		$package['notify_url'] = empty($params['notify_url']) ? $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php' : $params['notify_url'];
		$package['trade_type'] = 'NATIVE';
		ksort($package, SORT_STRING);
		$string1 = '';

		foreach ($package as $key => $v) {
			if (empty($v)) {
				continue;
			}

			$string1 .= $key . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$dat = array2xml($package);
		load()->func('communication');
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);

		if (is_error($response)) {
			return $response;
		}

		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);

		if (strval($xml->return_code) == 'FAIL') {
			return error(-1, strval($xml->return_msg));
		}

		if (strval($xml->result_code) == 'FAIL') {
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}

		$result = json_decode(json_encode($xml), true);
		return $result;
	}

	public function authCodeToOpenid($auth_code, $wechat)
	{
		$package = array();
		$package['appid'] = trim($wechat['appid']);
		$package['mch_id'] = trim($wechat['mch_id']);
		$package['auth_code'] = $auth_code;
		$package['nonce_str'] = random(32);
		ksort($package, SORT_STRING);
		$string1 = '';

		foreach ($package as $key => $v) {
			$string1 .= $key . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5(trim($string1)));
		$dat = array2xml($package);
		load()->func('communication');
		$response = ihttp_post('https://api.mch.weixin.qq.com/tools/authcodetoopenid', $dat);

		if (is_error($response)) {
			return $response;
		}

		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);

		if (strval($xml->return_code) == 'FAIL') {
			return error(-1, strval($xml->return_msg));
		}

		if (strval($xml->result_code) == 'FAIL') {
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}

		$result = json_decode(json_encode($xml), true);
		return $result;
	}

	/**
     * @param $params
     * $params = array(
    'openid'=>'',  openid
    'tid'=>'',订单编号
    'send_name'=>'', 发送红包的人  或者  红包事件
    'money'=>'', 发送红包金额 最低 1元
    'wishing'=>'', 祝福语  : 感谢您关注
    'act_name'=>'  ',  参与活动名臣
    'remark'=>'', 备注信息 居然是必填!!!
    );
     * @param $wechat
     *$wechat = array(
    'appid' => '', appid
    'mchid' => '', mchid
    'apikey' => '',apikey
    'certs' => array(
    'cert'=>'',证书内容
    'key'=>'',证书内容
    'root'=>'' 证书内容
    )
    );
     * @return array|bool
     */
	public function sendredpack($params)
	{
		global $_W;

		if (strpos($params['openid'], 'sns_wa_') !== false) {
			if (p('app')) {
				return error(-1, '小程序暂不支持微信红包打款，请选择企业打款');

				if (empty($sec['wxapp'])) {
					return error(-1, '未开启小程序微信支付');
				}

				if (empty($sec['wxapp_cert']) || empty($sec['wxapp_key'])) {
					return error(-1, '未上传完整的微信支付证书');
				}

				$payment['sub_appid'] = $sets['app']['appid'];
				$payment['sub_mch_id'] = $sec['wxapp']['mchid'];
				$payment['apikey'] = $sec['wxapp']['apikey'];
				$certs = array('cert' => $sec['wxapp_cert'], 'key' => $sec['wxapp_key'], 'root' => $sec['wxapp_root']);
				$params['openid'] = str_replace('sns_wa_', '', $params['openid']);
			}
			else {
				return error(-1, '没有设定支付参数');
			}
		}
		else {
			$set = $this->getSysset('pay');

			if (!empty($set['weixin_id'])) {
				$payment = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_payment') . ' WHERE uniacid=:uniacid AND id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $set['weixin_id']));

				if (empty($payment)) {
					error(-1, '支付参数不存在!');
				}

				$payment['is_new'] = 1;
			}
			else {
				$payment = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_payment') . ' WHERE uniacid=:uniacid AND `type`=\'0\'', array(':uniacid' => $_W['uniacid']));
			}

			if (empty($payment)) {
				$payment = array();
				$setting = uni_setting($_W['uniacid'], array('payment'));

				if (!is_array($setting['payment'])) {
					return error(1, '没有设定支付参数');
				}

				$sec = m('common')->getSec();
				$sec = iunserializer($sec['sec']);
				$wechat = $setting['payment']['wechat'];
				$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
				$row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
				$payment['sub_appid'] = $row['key'];
				$payment['sub_mch_id'] = $wechat['mchid'];
				$payment['apikey'] = $wechat['apikey'];
				$certs = $sec;
			}
			else {
				$certs = array('cert' => $payment['cert_file'], 'key' => $payment['key_file'], 'root' => $payment['root_file']);
			}
		}

		$package = array();
		if ($payment['type'] == 1 || $payment['type'] == 3) {
			$package['wxappid'] = $payment['appid'];
			$package['msgappid'] = $payment['sub_appid'];
			$package['sub_mch_id'] = $payment['sub_mch_id'];
			$package['mch_id'] = $payment['mch_id'];
		}
		else {
			$package['wxappid'] = $payment['sub_appid'];
			$package['mch_id'] = $payment['sub_mch_id'];
		}

		$package['mch_billno'] = $params['tid'];
		$package['send_name'] = $params['send_name'];
		$package['nonce_str'] = random(32);
		$package['re_openid'] = $params['openid'];
		$package['total_amount'] = $params['money'] * 100;
		$package['total_num'] = 1;
		$package['wishing'] = isset($params['wishing']) ? $params['wishing'] : '恭喜发财,大吉大利';
		$package['client_ip'] = CLIENT_IP;
		$package['act_name'] = $params['act_name'];
		$package['remark'] = isset($params['remark']) ? $params['remark'] : '暂无备注';
		$package['scene_id'] = isset($params['scene_id']) ? $params['scene_id'] : 'PRODUCT_1';
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		ksort($package, SORT_STRING);
		$string1 = '';

		foreach ($package as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 .= 'key=' . $payment['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$xml = array2xml($package);
		$extras = array();
		$errmsg = '未上传完整的微信支付证书，请到【系统设置】->【支付方式】中上传!';

		if (is_array($certs)) {
			if (empty($certs['cert']) || empty($certs['key'])) {
				if ($_W['ispost']) {
					show_json(0, array('message' => $errmsg));
				}

				show_message($errmsg, '', 'error');
			}

			$certfile = IA_ROOT . '/addons/ewei_shopv2/cert/' . random(128);
			file_put_contents($certfile, $certs['cert']);
			$keyfile = IA_ROOT . '/addons/ewei_shopv2/cert/' . random(128);
			file_put_contents($keyfile, $certs['key']);
			$extras['CURLOPT_SSLCERT'] = $certfile;
			$extras['CURLOPT_SSLKEY'] = $keyfile;

			if (!empty($certs['root'])) {
				$rootfile = IA_ROOT . '/addons/ewei_shopv2/cert/' . random(128);
				file_put_contents($rootfile, $certs['root']);
				$extras['CURLOPT_CAINFO'] = $rootfile;
			}
		}
		else {
			if ($_W['ispost']) {
				show_json(0, array('message' => $errmsg));
			}

			show_message($errmsg, '', 'error');
		}

		load()->func('communication');
		$resp = ihttp_request($url, $xml, $extras);
		@unlink($certfile);
		@unlink($keyfile);
		@unlink($rootfile);

		if (is_error($resp)) {
			return error(-2, $resp['message']);
		}

		if (empty($resp['content'])) {
			return error(-2, '网络错误');
		}

		libxml_disable_entity_loader(true);
		$arr = json_decode(json_encode(simplexml_load_string($resp['content'], 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		if ($arr['return_code'] == 'SUCCESS' && $arr['result_code'] == 'SUCCESS') {
			return true;
		}

		if ($arr['return_msg'] == $arr['err_code_des']) {
			$error = $arr['return_msg'];
		}
		else {
			$error = $arr['return_msg'] . ' | ' . $arr['err_code_des'];
		}

		return error(-2, $error);
	}

	/**
     * @param $params
     * @param $wechat
     * @param int $type
     * @return array|mixed
     *
     * $params = array(
    'title' => '刷卡消费',
    'tid' => '',
    'fee' => 0.01,
    'auth_code' => '',
    );

    $wechat = array(
    'appid' => '',
    'mchid' => '',
    'apikey' => '',
    );
     */
	public function wechat_micropay_build($params, $wechat, $type = 0)
	{
		global $_W;

		if (empty($params['old'])) {
			list(, $payment) = $this->public_build();

			if (is_error($payment)) {
				return $payment;
			}

			$wechat = array();

			if ($payment['is_new'] == 1) {
				if (empty($payment['type']) || $payment['type'] == 2) {
					$wechat['appid'] = $payment['sub_appid'];
					$wechat['mch_id'] = $payment['sub_mch_id'];
					$wechat['apikey'] = $payment['apikey'];
				}
				else {
					if ($payment['type'] == 1 || $payment['type'] == 3) {
						$wechat = $payment;
					}
					else {
						if ($payment['type'] == 4) {
							$params = array('service' => 'unified.trade.micropay', 'body' => $params['title'], 'out_trade_no' => $params['tid'], 'total_fee' => $params['fee'], 'auth_code' => $params['auth_code']);
							$payRes = m('pay')->build($params, $payment, $type);

							if (is_error($payRes)) {
								return $payRes;
							}

							return $payRes;
						}
					}
				}
			}
		}

		load()->func('communication');
		$package = array();
		$package['appid'] = trim($wechat['appid']);
		$package['mch_id'] = trim($wechat['mch_id']);
		$package['nonce_str'] = random(32);
		$package['body'] = trim($params['title']);
		$package['device_info'] = isset($params['device_info']) ? 'ewei_shopv2:' . $params['device_info'] : 'ewei_shopv2';
		$package['attach'] = (isset($params['uniacid']) ? $params['uniacid'] : $_W['uniacid']) . ':' . $type;
		$package['out_trade_no'] = trim($params['tid']);
		$package['total_fee'] = $params['fee'] * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['auth_code'] = $params['auth_code'];

		if (!empty($wechat['sub_mch_id'])) {
			$package['sub_mch_id'] = trim($wechat['sub_mch_id']);
		}

		ksort($package, SORT_STRING);
		$string1 = '';

		foreach ($package as $key => $v) {
			if (empty($v)) {
				continue;
			}

			$string1 .= $key . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5(trim($string1)));
		$dat = array2xml($package);
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/micropay', $dat);

		if (is_error($response)) {
			return $response;
		}

		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
		$result = json_decode(json_encode($xml), true);

		if ($result['return_code'] == 'FAIL') {
			return error(-1, $result['return_msg']);
		}

		if ($result['result_code'] == 'FAIL') {
			return error(-2, $result['err_code'] . ': ' . $result['err_code_des']);
		}

		return $result;
	}

	/**
     * @param $out_trade_no
     * @param $money
     * @param $wechat = array(
    'appid' => '',
    'mchid' => '',
    'apikey' => '',
    );
     * @param bool $app
     * @return array|mixed
     */
	public function wechat_order_query($out_trade_no, $money = 0, $wechat)
	{
		$package = array();
		$package['appid'] = trim($wechat['appid']);
		$package['mch_id'] = trim($wechat['mch_id']);
		$package['nonce_str'] = random(32);
		$package['out_trade_no'] = trim($out_trade_no);

		if (!empty($wechat['sub_mch_id'])) {
			$package['sub_mch_id'] = trim($wechat['sub_mch_id']);
		}

		ksort($package, SORT_STRING);
		$string1 = '';

		foreach ($package as $key => $v) {
			if (empty($v)) {
				continue;
			}

			$string1 .= $key . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5(trim($string1)));
		$dat = array2xml($package);
		load()->func('communication');
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/orderquery', $dat);

		if (is_error($response)) {
			return $response;
		}

		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);

		if (strval($xml->return_code) == 'FAIL') {
			return error(-1, strval($xml->return_msg));
		}

		if (strval($xml->result_code) == 'FAIL') {
			return error(-2, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}

		libxml_disable_entity_loader(true);
		$result = json_decode(json_encode($xml), true);
		if ($result['total_fee'] != $money * 100 && $money != 0) {
			return error(-1, '金额出错');
		}

		return $result;
	}

	public function getAccount()
	{
		global $_W;
		load()->model('account');

		if (!empty($_W['acid'])) {
			return WeAccount::create($_W['acid']);
		}

		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		return WeAccount::create($acid);
	}

	public function createNO($table, $field, $prefix)
	{
		$billno = date('YmdHis') . random(6, true);

		while (1) {
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_' . $table) . (' where ' . $field . '=:billno limit 1'), array(':billno' => $billno));

			if ($count <= 0) {
				break;
			}

			$billno = date('YmdHis') . random(6, true);
		}

		return $prefix . $billno;
	}

	public function html_images($detail = '', $enforceQiniu = false)
	{
		$detail = htmlspecialchars_decode($detail);
		preg_match_all('/<img.*?src=[\\\\\'| \\"](.*?(?:[\\.gif|\\.jpg|\\.png|\\.jpeg]?))[\\\\\'|\\"].*?[\\/]?>/', $detail, $imgs);
		$images = array();

		if (isset($imgs[1])) {
			foreach ($imgs[1] as $img) {
				$im = array('old' => $img, 'new' => save_media($img, $enforceQiniu));
				$images[] = $im;
			}
		}

		foreach ($images as $img) {
			$detail = str_replace($img['old'], $img['new'], $detail);
		}

		return $detail;
	}

	public function html_to_images($detail = '')
	{
		$detail = htmlspecialchars_decode($detail);
		preg_match_all('/<img.*?src=[\\\\\'| \\"](.*?(?:[\\.gif|\\.jpg|\\.png|\\.jpeg]?))[\\\\\'|\\"].*?[\\/]?>/', $detail, $imgs);
		$images = array();

		if (isset($imgs[1])) {
			foreach ($imgs[1] as $img) {
				$im = array('old' => $img, 'new' => tomedia($img));
				$images[] = $im;
			}
		}

		foreach ($images as $img) {
			$detail = str_replace($img['old'], $img['new'], $detail);
		}

		return $detail;
	}

	public function array_images($arr)
	{
		foreach ($arr as &$a) {
			$a = save_media($a);
		}

		unset($a);
		return $arr;
	}

	public function getSec($uniacid = 0)
	{
		global $_W;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$set = pdo_fetch('select sec from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

		if (empty($set)) {
			$set = array();
		}

		$data = m('common')->getSysset('pay');

		if (0 < $data['alipay_id']) {
			$paymentalis = pdo_fetch('SELECT alipay_sec FROM ' . tablename('ewei_shop_payment') . ' WHERE id = :id and uniacid=:uniacid and paytype = 1 ', array(':uniacid' => $_W['uniacid'], ':id' => $data['alipay_id']));
			if (!empty($paymentalis) && !empty($paymentalis['alipay_sec'])) {
				$paymentalis['alipay_sec'] = iunserializer($paymentalis['alipay_sec']);
				$set['sec'] = iunserializer($set['sec']);
				$setting = uni_setting($_W['uniacid'], array('payment'));

				if (is_array($setting['payment'])) {
					$options = $setting['payment']['alipay'];
				}

				$set['sec']['alipay_pay']['appid'] = $paymentalis['alipay_sec']['appid'];
				$set['sec']['alipay_pay']['public_key'] = $paymentalis['alipay_sec']['public_key'];
				$set['sec']['alipay_pay']['private_key'] = $paymentalis['alipay_sec']['private_key'];
				$set['sec']['alipay_pay']['alipay_sign_type'] = $paymentalis['alipay_sec']['alipay_sign_type'];
				$set['sec']['alipay_id'] = $data['alipay_id'];

				if (empty($set['sec']['alipay_pay']['appid'])) {
					$set['sec']['alipay_pay']['app_id'] = $paymentalis['alipay_sec']['appid'];
					$set['sec']['alipay_pay']['single_public_key'] = $paymentalis['alipay_sec']['public_key'];
					$set['sec']['alipay_pay']['single_private_key'] = $paymentalis['alipay_sec']['private_key'];
					$set['sec']['alipay_pay']['single_alipay_sign_type'] = $paymentalis['alipay_sec']['alipay_sign_type'];
				}

				$set['sec'] = iserializer($set['sec']);
			}
		}
		else {
			$set['sec'] = iunserializer($set['sec']);
			$set['sec']['alipay_id'] = 0;
			$set['sec'] = iserializer($set['sec']);
		}

		return $set;
	}

	public function paylog($log = '')
	{
		global $_W;
		$openpaylog = m('cache')->getString('paylog', 'global');

		if (!empty($openpaylog)) {
			$path = IA_ROOT . '/addons/ewei_shopv2/data/paylog/' . $_W['uniacid'] . '/' . date('Ymd');

			if (!is_dir($path)) {
				load()->func('file');
				@mkdirs($path, '0777');
			}

			$file = $path . '/' . date('H') . '.log';
			file_put_contents($file, $log, FILE_APPEND);
		}
	}

	public function getAreas()
	{
		$area_set = m('util')->get_area_config_set();
		$new_area = intval($area_set['new_area']);

		if (!empty($new_area)) {
			$file = IA_ROOT . '/addons/ewei_shopv2/static/js/dist/area/AreaNew.xml';
		}
		else {
			$file = IA_ROOT . '/addons/ewei_shopv2/static/js/dist/area/Area.xml';
		}

		$file_str = file_get_contents($file);
		$areas = json_decode(json_encode(simplexml_load_string($file_str)), true);
		if (!empty($new_area) && !empty($areas['province'])) {
			foreach ($areas['province'] as $k => &$row) {
				if (0 < $k) {
					if (empty($row['city'][0])) {
						$row['city'][0]['@attributes'] = $row['city']['@attributes'];
						$row['city'][0]['county'] = $row['city']['county'];
						unset($row['city']['@attributes']);
						unset($row['city']['county']);
					}
				}
				else {
					unset($areas['province'][0]);
				}

				foreach ($row['city'] as $k1 => $v1) {
					if (empty($v1['county'][0])) {
						$row['city'][$k1]['county'][0]['@attributes'] = $v1['county']['@attributes'];
						unset($row['city'][$k1]['county']['@attributes']);
					}
				}
			}

			unset($row);
		}

		return $areas;
	}

	public function getWechats()
	{
		return pdo_fetchall('SELECT  a.uniacid,a.name FROM ' . tablename('ewei_shop_sysset') . ' s  ' . ' left join ' . tablename('account_wechats') . ' a on a.uniacid = s.uniacid' . ' left join ' . tablename('account') . ' acc on acc.uniacid = a.uniacid where acc.isdeleted=0 GROUP BY uniacid');
	}

	public function getCopyright($ismanage = false)
	{
		global $_W;
		$copyrights = m('cache')->getArray('systemcopyright', 'global');

		if (!is_array($copyrights)) {
			$copyrights = pdo_fetchall('select *  from ' . tablename('ewei_shop_system_copyright'));
			m('cache')->set('systemcopyright', $copyrights, 'global');
		}

		$copyright = false;

		foreach ($copyrights as $cr) {
			if ($cr['uniacid'] == $_W['uniacid']) {
				if ($ismanage && $cr['ismanage'] == 1) {
					$copyright = $cr;
					break;
				}

				if (!$ismanage && $cr['ismanage'] == 0) {
					$copyright = $cr;
					break;
				}
			}
		}

		if (!$copyright) {
			foreach ($copyrights as $cr) {
				if ($cr['uniacid'] == -1) {
					if ($ismanage && $cr['ismanage'] == 1) {
						$copyright = $cr;
						break;
					}

					if (!$ismanage && $cr['ismanage'] == 0) {
						$copyright = $cr;
						break;
					}
				}
			}
		}

		$merchid = intval($_W['merchid']);

		if (!empty($merchid)) {
			$merch = pdo_fetch('select logo from ' . tablename('ewei_shop_merch_user') . ' where id = :id and uniacid = :uniacid ', array(':id' => $merchid, ':uniacid' => $_W['uniacid']));

			if (!empty($merch['logo'])) {
				$copyright['logo'] = tomedia($merch['logo']);
			}
		}

		return $copyright;
	}

	public function keyExist($key = '')
	{
		global $_W;

		if (empty($key)) {
			return NULL;
		}

		$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and uniacid=:uniacid limit 1 ', array(':content' => trim($key), ':uniacid' => $_W['uniacid']));

		if (!empty($keyword)) {
			$rule = pdo_fetch('SELECT * FROM ' . tablename('rule') . ' WHERE id=:id and uniacid=:uniacid limit 1 ', array(':id' => $keyword['rid'], ':uniacid' => $_W['uniacid']));

			if (!empty($rule)) {
				return $rule;
			}
		}
	}

	public function createStaticFile($url, $regen = false)
	{
		global $_W;

		if (empty($url)) {
			return NULL;
		}

		$url = preg_replace('/(&|\\?)mid=[^&]+/', '', $url);
		$cache = md5($url) . '_html';
		$content = m('cache')->getString($cache);
		if (empty($content) || $regen) {
			load()->func('communication');
			$resp = ihttp_request($url, array('site' => 'createStaticFile'));
			$content = $resp['content'];
			m('cache')->set($cache, $content);
		}

		return $content;
	}

	public function delrule($rids)
	{
		if (!is_array($rids)) {
			$rids = array($rids);
		}

		foreach ($rids as $rid) {
			$rid = intval($rid);
			load()->model('reply');
			$reply = reply_single($rid);

			if (pdo_delete('rule', array('id' => $rid))) {
				pdo_delete('rule_keyword', array('rid' => $rid));
				pdo_delete('stat_rule', array('rid' => $rid));
				pdo_delete('stat_keyword', array('rid' => $rid));
				$module = WeUtility::createModule($reply['module']);

				if (method_exists($module, 'ruleDeleted')) {
					$module->ruleDeleted($rid);
				}
			}
		}
	}

	public function deleteFile($attachment, $fileDelete = false)
	{
		global $_W;
		$attachment = trim($attachment);

		if (empty($attachment)) {
			return false;
		}

		$media = pdo_get('core_attachment', array('uniacid' => $_W['uniacid'], 'attachment' => $attachment));

		if (empty($media)) {
			return false;
		}

		if (empty($_W['isfounder']) && $_W['role'] != 'manager') {
			return false;
		}

		if ($fileDelete) {
			load()->func('file');

			if (!empty($_W['setting']['remote']['type'])) {
				$status = file_remote_delete($media['attachment']);
			}
			else {
				$status = file_delete($media['attachment']);
			}

			if (is_error($status)) {
				exit($status['message']);
			}
		}

		pdo_delete('core_attachment', array('uniacid' => $_W['uniacid'], 'id' => $media['id']));
		return true;
	}

	/**
     * 判断是否有插件权限
     * @date 2018/10/16
     * @author Vencenty
     * @param $pluginName string 插件名称
     * @return bool
     */
	public function pluginPermissions($pluginName)
	{
		$category = m('plugin')->getList(1);
		$flag = false;
		array_walk_recursive($category, function($value) use(&$flag, $pluginName) {
			if ($value == $pluginName) {
				$flag = true;
			}
		});
		return $flag;
	}

	/**
     * 获取商品详情页底部固定信息配置
     * @return mixed
     */
	public function getGoodsBottomFixedImageSetting()
	{
		$shopSetting = m('common')->getSysset('shop');
		return $shopSetting['bottomFixedImage'];
	}

	/**
     * 二维数组根据key排序
     * @return void
     */
	public function sortArrayByKey(&$arr, $key)
	{
		if ($arr) {
			array_multisort(array_column($arr, $key), SORT_DESC, $arr);
		}
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
