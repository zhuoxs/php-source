<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class QpayModel extends PluginModel
{
	public $params;
	public $parameters;
	public $key;
	public $gateUrl;
	public $notify_url;
	public $private_rsa_key;

	public function RequestHandler()
	{
		global $_W;
		$this->gateUrl = 'https://pay.swiftpass.cn/pay/gateway';
		$this->parameters = array('charset' => 'UTF-8', 'sign_type' => 'MD5', 'version' => '2.0', 'mch_create_ip' => CLIENT_IP, 'nonce_str' => random(32));
		$this->notify_url = $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php';
	}

	/**
     *获取入口地址,不包含参数值
     */
	public function getGateURL()
	{
		return $this->gateUrl;
	}

	/**
     *设置入口地址,不包含参数值
     */
	public function setGateURL($gateUrl)
	{
		$this->gateUrl = $gateUrl;
	}

	/**
     *获取MD5密钥
     */
	public function getKey()
	{
		return $this->key;
	}

	/**
     *设置MD5密钥
     */
	public function setKey($key)
	{
		$this->key = $key;
	}

	public function setRSAKey($key)
	{
		$this->private_rsa_key = $key;
	}

	/**
     *获取参数值
     */
	public function getParameter($parameter)
	{
		return isset($this->parameters[$parameter]) ? $this->parameters[$parameter] : '';
	}

	/**
     *设置参数值
     */
	public function setParameter($parameter, $parameterValue)
	{
		$this->parameters[$parameter] = $parameterValue;
	}

	/**
     *删除参数值
     */
	public function removeParameter($parameter)
	{
		unset($this->parameters[$parameter]);
	}

	/**
     * 一次性设置参数
     */
	public function setReqParams($post, $filterField = NULL)
	{
		if ($filterField !== NULL) {
			foreach ($filterField as $k => $v) {
				unset($post[$v]);
			}
		}

		foreach ($post as $k => $v) {
			if (empty($v)) {
				unset($post[$k]);
			}
		}

		$this->parameters = $post;
	}

	/**
     *获取所有请求的参数
     *@return array
     */
	public function getAllParameters()
	{
		return $this->parameters;
	}

	/**
     *创建md5摘要,规则是:按参数名称a-z排序,遇到空值的参数不参加签名。
     */
	public function createSign()
	{
		if ($this->getParameter('sign_type') == 'MD5') {
			$this->createMD5Sign();
		}
		else {
			$this->createRSASign();
		}
	}

	public function createMD5Sign()
	{
		$signPars = '';
		ksort($this->parameters);

		foreach ($this->parameters as $k => $v) {
			if ('' != $v && 'sign' != $k) {
				$signPars .= $k . '=' . $v . '&';
			}
		}

		$signPars .= 'key=' . $this->getKey();
		$sign = strtoupper(md5($signPars));
		$this->setParameter('sign', $sign);
	}

	public function createRSASign()
	{
		$signPars = '';
		ksort($this->parameters);

		foreach ($this->parameters as $k => $v) {
			if ('' != $v && 'sign' != $k) {
				$signPars .= $k . '=' . $v . '&';
			}
		}

		$signPars = substr($signPars, 0, strlen($signPars) - 1);
		$res = openssl_pkey_get_private(m('common')->chackKey($this->private_rsa_key, false));

		if ($this->getParameter('sign_type') == 'RSA_1_1') {
			openssl_sign($signPars, $sign, $res);
		}
		else {
			if ($this->getParameter('sign_type') == 'RSA_1_256') {
				openssl_sign($signPars, $sign, $res, OPENSSL_ALGO_SHA256);
			}
		}

		openssl_free_key($res);
		$sign = base64_encode($sign);
		$this->setParameter('sign', $sign);
	}

	public function setMch($account = array())
	{
		$this->setParameter('mch_id', $account['sub_mch_id']);
		$this->setParameter('op_user_id', $account['sub_mch_id']);

		if ($this->getParameter('service') == 'pay.weixin.jspay') {
			$this->setParameter('is_raw', '1');
		}

		$this->setKey($account['apikey']);
		$this->setRSAKey($account['app_qpay_private_key']);
		$signtype = empty($account['qpay_signtype']) ? 'MD5' : 'RSA_1_256';
		$this->setParameter('sign_type', $signtype);
	}

	/**
     * @param $params
     * @param $wechat
     * @param int $type
     * @return array|mixed
     *
    $params = array(
    'service' => 'unified.trade.micropay',
    'body' => '二维码支付',
    'out_trade_no' => '201703311417',
    'total_fee' => 0.01,
    // 'openid' => '',
    'auth_code' => '289410670282049491',
    );
     */
	public function build($params, $account = array(), $type)
	{
		global $_W;
		$this->RequestHandler();
		$this->params = $params;

		if ($this->params['total_fee'] < 0.01) {
			return error(-1, '金额错误!');
		}

		$this->setParameter('service', $this->params['service']);
		$this->setParameter('out_trade_no', trim($this->params['out_trade_no']));
		$this->setParameter('body', trim($this->params['body']));
		$this->setParameter('attach', (isset($this->params['uniacid']) ? $this->params['uniacid'] : $_W['uniacid']) . ':' . $type);
		$this->setParameter('device_info', isset($this->params['device_info']) ? 'ewei_shopv2:' . $this->params['device_info'] : 'ewei_shopv2');
		$this->setParameter('total_fee', $this->params['total_fee'] * 100);
		$this->setMch($account);

		if ($this->getParameter('service') == 'unified.trade.micropay') {
			$this->setParameter('auth_code', trim($params['auth_code']));
			$wechat = array(10, 11, 12, 13, 14, 15);
			$alipay = array(28);
			$type = (int) substr($params['auth_code'], 0, 2);

			if (in_array($type, $alipay)) {
				$this->setParameter('service', 'pay.alipay.micropayv3');
			}
			else {
				if (in_array($type, $wechat)) {
					$this->setParameter('service', 'pay.weixin.micropay');
				}
			}
		}

		switch ($params['service']) {
		case 'unified.trade.micropay':
			return $this->micropay();
		case 'pay.weixin.native':
			return $this->native();
		case 'pay.weixin.jspay':
			return $this->jspay();
		case 'pay.alipay.native':
			$this->setParameter('service', 'pay.alipay.nativev3');
			return $this->native();
		default:
		}

		return error(-1, '没有选择合适的支付工具!');
	}

	public function result()
	{
		$this->createSign();
		$dat = array2xml($this->getAllParameters());
		load()->func('communication');
		$response = ihttp_request($this->getGateURL(), $dat);
		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string(trim($response['content']), 'SimpleXMLElement', LIBXML_NOCDATA);
		$result = json_decode(json_encode($xml), true);
		if ($result['status'] == '0' && $result['result_code'] == '0') {
			return $result;
		}

		if ($result['status'] == '0') {
			if ($result['need_query'] == 'Y') {
				return error(-2, 'need_query');
			}

			return error(-2, $result['err_code'] . '|' . $result['err_msg']);
		}

		return error(-2, $result['status'] . '|' . $result['message']);
	}

	/**
     * 订单查询
     * @param int|string $out_trade_no 订单号
     * @param array $account 全付通账户信息
     * @return array|mixed
     */
	public function query($out_trade_no, $account = array())
	{
		global $_W;
		$this->RequestHandler();
		$this->setParameter('service', 'unified.trade.query');
		$this->setParameter('out_trade_no', $out_trade_no);
		$this->setMch($account);
		return $this->result();
	}

	/**
     * @param $params
     * @param array $account
     * @return array|mixed
     *
    $params = array(
    'service' => 'unified.trade.refund',
    'out_trade_no' => '1490866019',
    'out_refund_no' => '退款订单号',
    'total_fee' => 0.01,
    'refund_fee' => 0.01,
    );
     */
	public function refund($params, $account = array())
	{
		global $_W;
		$this->RequestHandler();
		$this->params = $params;
		$this->setParameter('service', 'unified.trade.refund');
		$this->setParameter('out_trade_no', $this->params['out_trade_no']);

		if (!empty($this->params['transaction_id'])) {
			$this->setParameter('transaction_id', $this->params['transaction_id']);
		}

		$this->setParameter('out_refund_no', $this->params['out_refund_no']);
		$this->setParameter('total_fee', $this->params['total_fee']);
		$this->setParameter('refund_fee', $this->params['refund_fee']);
		$this->setMch($account);
		return $this->result();
	}

	/**
     * 统一退款查询
     * @param int|string $out_refund_no 退款订单号
     * @param array $account 全付通支付账号
     * @param bool $is_out_trade_no  是否是订单号查询
     * @return array|mixed
     */
	public function refundQuery($out_refund_no, $account = array(), $is_out_trade_no = false)
	{
		global $_W;

		if (empty($out_refund_no)) {
			return error('-1', '查询订单号为空!');
		}

		$this->RequestHandler();
		$this->setParameter('service', 'unified.trade.refundquery');

		if ($is_out_trade_no) {
			$this->setParameter('out_trade_no', $out_refund_no);
		}
		else {
			$this->setParameter('out_refund_no', $out_refund_no);
		}

		$this->setMch($account);
		return $this->result();
	}

	public function jspay()
	{
		global $_W;
		$this->setParameter('notify_url', $this->notify_url);
		$this->setParameter('sub_openid', $package['openid'] = empty($this->params['openid']) ? trim($_W['openid']) : trim($this->params['openid']));
		$sub_appid = empty($this->params['sub_appid']) ? trim($_W['account']['key']) : trim($this->params['sub_appid']);
		$this->setParameter('sub_appid', $sub_appid);
		return $this->result();
	}

	public function micropay()
	{
		return $this->result();
	}

	public function native()
	{
		$this->setParameter('notify_url', $this->notify_url);
		return $this->result();
	}
}

?>
