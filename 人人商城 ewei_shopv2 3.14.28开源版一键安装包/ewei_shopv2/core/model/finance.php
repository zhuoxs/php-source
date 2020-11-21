<?php
class Finance_EweiShopV2Model
{
	/**
     * 支付
     * @param type $openid openid
     * @param type $paytype 支付类型 0 余额 1 微信
     * @param type $money
     */
	public function pay($openid = '', $paytype = 0, $money = 0, $trade_no = '', $desc = '', $return = true)
	{
		global $_W;
		global $_GPC;

		if (empty($openid)) {
			return error(-1, 'openid不能为空');
		}

		$member = m('member')->getMember($openid);

		if (empty($member)) {
			return error(-1, '未找到用户');
		}

		if (empty($paytype)) {
			m('member')->setCredit($openid, 'credit2', $money, array(0, $desc));
			return true;
		}

		if (strpos($openid, 'sns_wa_') !== false) {
			if (p('app')) {
				$sets = m('common')->getSysset(array('app', 'pay'));
				$sec = m('common')->getSec();
				$sec = iunserializer($sec['sec']);
				if (!is_array($sec['wxapp']) || !isset($sec['wxapp'])) {
					$sec['wxapp'] = array();
				}

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
				$openid = str_replace('sns_wa_', '', $openid);
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
				$payment = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_payment') . ' WHERE uniacid=:uniacid AND  type=0  AND paytype=0 AND sub_appid=:appid', array(':uniacid' => $_W['uniacid'], ':appid' => $_W['account']['key']));
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

		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
		$pars = array();
		$pars['mch_appid'] = $payment['sub_appid'];
		$pars['mchid'] = $payment['sub_mch_id'];
		$pars['nonce_str'] = random(32);
		$pars['partner_trade_no'] = empty($trade_no) ? time() . random(4, true) : $trade_no;
		$pars['openid'] = $openid;
		$pars['check_name'] = 'NO_CHECK';
		$pars['amount'] = $money;
		$pars['desc'] = empty($desc) ? '现金提现' : $desc;
		$pars['spbill_create_ip'] = gethostbyname($_SERVER['HTTP_HOST']);
		ksort($pars, SORT_STRING);
		$string1 = '';

		foreach ($pars as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 .= 'key=' . $payment['apikey'];
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
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
		else if ($return) {
			if ($_W['ispost']) {
				show_json(0, array('message' => $errmsg));
			}

			show_message($errmsg, '', 'error');
		}
		else {
			return error(-1, $errmsg);
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
     * @param $openid
     * @param $money
     * @param string $logno 订单号
     * @param array $data 数据 array('sendmoney'=>'','senddata'=>'json')
     * @param string $desc 红包发送备注
     * @param array $config 后台查询出来的红包
     * @return array
     */
	public function payRedPack($openid, $money, $logno, $data, $desc = '红包发送', $config)
	{
		global $_W;
		$money = round($money / 100, 2);
		$sendmoney = (double) $data['sendmoney'];
		$realsendmoney = round($money - $sendmoney, 2);

		if (empty($realsendmoney)) {
			return error(-1, '发送金额错误 ,或者已经全部发送');
		}

		$error = 0;
		$senddata = array();
		$senddata_count = 0;

		if (!empty($data['senddata'])) {
			$senddata = json_decode($data['senddata'], true);
			$senddata_count = count($senddata);
		}

		if (empty($config['redpack'])) {
			$redpack = 188;
		}
		else if ($config['redpack'] == '1') {
			$redpack = 288;
		}
		else {
			$redpack = 388;
		}

		$shopset = m('common')->getSysset('shop');
		$params = array('openid' => $openid, 'tid' => '', 'send_name' => mb_substr($shopset['name'], 0, 10, 'UTF-8'), 'money' => '', 'wishing' => '恭喜发财,大吉大利!', 'act_name' => $_W['shopset']['shop']['name'] . '活动', 'remark' => $desc);

		if ($redpack < $realsendmoney) {
			$for_count = ceil($realsendmoney / $redpack);
			$end_money = round($realsendmoney - ($for_count - 1) * $redpack, 2);
			$i = 0;

			while ($i < $for_count) {
				++$senddata_count;
				$params['tid'] = $logno . 'R' . $senddata_count;
				$params['money'] = $redpack;
				if ($for_count == $i + 1 && !empty($end_money)) {
					$params['money'] = $end_money;
				}

				if ($params['money'] < 1) {
					$res = m('member')->setCredit($openid, 'credit2', $money, array(0, $desc));
				}
				else {
					$res = m('common')->sendredpack($params);
				}

				if (is_error($res)) {
					$error = $res;
					break;
				}

				$senddata[] = array('no' => $params['tid'], 'money' => $params['money']);
				$sendmoney += $params['money'];
				++$i;
			}
		}
		else {
			++$senddata_count;
			$params['tid'] = $logno . 'R' . $senddata_count;
			$params['money'] = $realsendmoney;

			if ($params['money'] < 1) {
				$res = m('member')->setCredit($openid, 'credit2', $money, array(0, $desc));
			}
			else {
				$res = m('common')->sendredpack($params);
			}

			if (is_error($res)) {
				$error = $res;
			}
			else {
				$senddata[] = array('no' => $params['tid'], 'money' => $params['money']);
				$sendmoney += $params['money'];
			}
		}

		return array('sendmoney' => $sendmoney, 'senddata' => $senddata, 'error' => $error);
	}

	/**
     * @param $aliPayAccount array('account'=>'支付宝账号','name'=>'支付宝姓名','money'=>'需要支付的金额',) 可以是 二维数组
     * @param $config array('partner'=>'PID','account_name'=>'真实的支付账户名','email'=>'支付账号','key'=>'MD5秘钥',)
     * @param string $remark 支付备注 : 默认是 : 现金提现
     * @return string|array
     */
	public function AliPay($aliPayAccount, $batch_no, $config, $remark = '现金提现')
	{
		global $_W;

		if (empty($aliPayAccount)) {
			return error('-1', '打款账户错误');
		}

		if (empty($config['partner'])) {
			return error('-1', 'partner 未配置!');
		}

		if (empty($config['account_name'])) {
			return error('-1', 'account_name 未配置!');
		}

		if (empty($config['email'])) {
			return error('-1', 'email 未配置!');
		}

		if (empty($config['key'])) {
			return error('-1', '支付秘钥 未配置!');
		}

		$data = date('YmdHis');
		$detail_data = '';
		$money = 0;
		$total = 0;

		if (is_array2($aliPayAccount)) {
			foreach ($aliPayAccount as $val) {
				if ($val['money'] <= 0) {
					continue;
				}

				$detail_data .= $data . random(8, true) . '^' . $val['account'] . '^' . $val['name'] . '^' . $val['money'] . '^' . $remark . '|';
				$money += $val['money'];
				++$total;
			}

			$detail_data = substr($detail_data, 0, -1);
		}
		else {
			$detail_data .= $data . random(8, true) . '^' . $aliPayAccount['account'] . '^' . $aliPayAccount['name'] . '^' . $aliPayAccount['money'] . '^' . $remark;
			$money = $aliPayAccount['money'];
			$total = 1;
		}

		if (empty($money)) {
			return error('-1', '打款资金错误');
		}

		$set = array();
		$set['service'] = 'batch_trans_notify';
		$set['partner'] = $config['partner'];
		$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
		$set['_input_charset'] = 'UTF-8';
		$set['sign_type'] = 'MD5';
		$set['account_name'] = $config['account_name'];
		$set['detail_data'] = $detail_data;
		$set['batch_no'] = $batch_no;
		$set['batch_num'] = $total;
		$set['batch_fee'] = $money;
		$set['email'] = $config['email'];
		$set['pay_date'] = date('Ymd');
		$prepares = array();

		foreach ($set as $key => $value) {
			if ($key != 'sign' && $key != 'sign_type') {
				$prepares[] = $key . '=' . $value;
			}
		}

		sort($prepares);
		$string = implode($prepares, '&');
		$string .= $config['key'];
		$set['sign'] = md5($string);
		$url = 'https://mapi.alipay.com/gateway.do?' . http_build_query($set, '', '&');
		return $url;
	}

	/**
     * 退款
     * @param type $openid openid
     * @param type $money
     */
	public function refund($openid, $out_trade_no, $out_refund_no, $totalmoney, $refundmoney = 0, $app = false, $refund_account = false, $normal = false)
	{
		global $_W;
		global $_GPC;

		if (empty($openid)) {
			return error(-1, 'openid不能为空');
		}

		if (strexists($openid, 'sns_wa_')) {
			return $this->wxapp_refund($openid, $out_trade_no, $out_refund_no, $totalmoney, $refundmoney, $app);
		}

		list($pay, $payment) = m('common')->public_build($app);

		if (is_error($payment)) {
			return $payment;
		}

		$certs = $payment;
		if ($payment['is_new'] == 0 && !$app) {
			$setting = uni_setting($_W['uniacid'], array('payment'));

			if (!is_array($setting['payment'])) {
				return error(1, '没有设定支付参数');
			}

			if (!empty($pay['weixin_sub'])) {
				$wechat = array('appid' => $payment['appid_sub'], 'mchid' => $payment['mchid_sub'], 'sub_appid' => !empty($payment['sub_appid_sub']) ? $payment['sub_appid_sub'] : '', 'sub_mch_id' => $payment['sub_mchid_sub'], 'apikey' => $payment['apikey_sub']);
				$row = array('key' => $payment['appid_sub']);
				$certs = $payment['sub'];
			}
			else {
				$wechat = $setting['payment']['wechat'];
				$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
				$row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
			}
		}

		if ($payment['is_new'] == 1 && !$app) {
			$wechat = array('appid' => $payment['sub_appid'], 'mchid' => $payment['sub_mch_id'], 'apikey' => $payment['apikey']);
			$sub_wechat = array('appid' => $payment['appid'], 'mchid' => $payment['mch_id'], 'sub_appid' => !empty($payment['sub_appid']) ? $payment['sub_appid'] : '', 'sub_mch_id' => $payment['sub_mch_id'], 'apikey' => $payment['apikey']);

			switch ($payment['type']) {
			case '1':
				$wechat = $sub_wechat;
				break;

			case '3':
				$wechat = $sub_wechat;
				break;

			case '4':
				$params = array('out_trade_no' => $out_trade_no, 'out_refund_no' => $out_refund_no, 'total_fee' => $totalmoney, 'refund_fee' => $refundmoney);
				$resp = m('pay')->refund($params, $payment);
				if (!is_error($resp) && $resp['result_code'] == 0 && $resp['status'] == 0) {
					$respQuery = m('pay')->refundQuery($out_refund_no, $payment);
					if ($respQuery['refund_status_0'] == 'SUCCESS' || $respQuery['refund_status_0'] == 'PROCESSING') {
						return true;
					}

					return error('-2', '退款失败!');
				}

				return $resp;
			}

			unset($sub_wechat);
			$certs = array('cert' => $payment['cert_file'], 'key' => $payment['key_file'], 'root' => $payment['root_file']);
			$row = array('key' => $payment['sub_appid']);
		}

		if ($app) {
			if (empty($payment['app_wechat']['appid']) || empty($payment['app_wechat']['appsecret']) || empty($payment['app_wechat']['merchid']) || empty($payment['app_wechat']['apikey'])) {
				return error(1, '没有设定APP支付参数');
			}

			$wechat = array('appid' => $payment['app_wechat']['appid'], 'mchid' => $payment['app_wechat']['merchid'], 'apikey' => $payment['app_wechat']['apikey']);
			$row = array('key' => $payment['app_wechat']['appid'], 'secret' => $payment['app_wechat']['appsecret']);
			$certs = array('cert' => $payment['app_wechat']['cert'], 'key' => $payment['app_wechat']['key'], 'root' => $payment['app_wechat']['root']);
		}

		$url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
		$pars = array();
		$pars['appid'] = $row['key'];
		$pars['mch_id'] = $wechat['mchid'];

		if (!empty($wechat['sub_mch_id'])) {
			$pars['sub_mch_id'] = $wechat['sub_mch_id'];
		}

		$pars['nonce_str'] = random(8);
		$pars['out_trade_no'] = $out_trade_no;
		$pars['out_refund_no'] = $out_refund_no;
		$pars['total_fee'] = $totalmoney;
		$pars['refund_fee'] = $refundmoney;
		$pars['op_user_id'] = $wechat['mchid'];

		if ($refund_account) {
			$pars['refund_account'] = $refund_account;
		}

		if (!empty($pay['weixin_sub']) && !$app) {
			if (!empty($wechat['sub_appid'])) {
				$pars['sub_appid'] = $wechat['sub_appid'];
			}

			$pars['sub_mch_id'] = $wechat['sub_mch_id'];
		}

		ksort($pars, SORT_STRING);
		$string1 = '';

		foreach ($pars as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
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
		if ($arr['return_code'] == 'FAIL' && $arr['return_msg']) {
			return error(-2, $arr['return_msg']);
		}

		if ($arr['return_code'] == 'SUCCESS' && $arr['result_code'] == 'SUCCESS') {
			return true;
		}

		if ($arr['return_code'] == 'SUCCESS' && $arr['result_code'] == 'FAIL' && $arr['return_msg'] == 'OK' && !$refund_account) {
			if ($arr['err_code'] == 'NOTENOUGH') {
				return $this->refund($openid, $out_trade_no, $out_refund_no, $totalmoney, $refundmoney, $app, 'REFUND_SOURCE_RECHARGE_FUNDS');
			}
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
     * 微信小程序退款
     * @param type $openid openid
     * @param type $money
     */
	public function wxapp_refund($openid, $out_trade_no, $out_refund_no, $totalmoney, $refundmoney = 0, $app = false, $refund_account = false)
	{
		global $_W;
		global $_GPC;

		if (empty($openid)) {
			return error(-1, 'openid不能为空');
		}

		$member = m('member')->getMember($openid);

		if (empty($member)) {
			return error(-1, '未找到用户');
		}

		$data = m('common')->getSysset('app');

		if (empty($data['appid'])) {
			return error(-1, '未设置小程序 APPID');
		}

		$sec = m('common')->getSec();
		$sec = iunserializer($sec['sec']);
		$certs = array('cert' => $sec['wxapp_cert'], 'key' => $sec['wxapp_key'], 'root' => $sec['wxapp_root']);

		if (empty($sec['wxapp']['mchid'])) {
			return error(-1, '未设置小程序微信支付商户号');
		}

		if (empty($sec['wxapp']['apikey'])) {
			return error(-1, '未设置小程序微信商户apikey');
		}

		$url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
		$pars = array();
		$pars['appid'] = $data['appid'];
		$pars['mch_id'] = $sec['wxapp']['mchid'];
		$pars['nonce_str'] = random(32);
		$pars['out_trade_no'] = $out_trade_no;
		$pars['out_refund_no'] = $out_refund_no;
		$pars['total_fee'] = $totalmoney;
		$pars['refund_fee'] = $refundmoney;
		$pars['op_user_id'] = $sec['wxapp']['mchid'];

		if ($refund_account) {
			$pars['refund_account'] = $refund_account;
		}

		ksort($pars, SORT_STRING);
		$string1 = '';

		foreach ($pars as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 .= 'key=' . $sec['wxapp']['apikey'];
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		$errmsg = '未上传完整的微信支付证书，请到【小程序】->【支付设置】中上传!';

		if (is_array($certs)) {
			if (empty($certs['cert']) || empty($certs['key'])) {
				if ($_W['ispost']) {
					show_json(0, array('message' => $errmsg));
				}

				show_message($errmsg, '', 'error');
			}

			$certfile = IA_ROOT . '/addons/ewei_shopv2/cert/' . random(64);
			file_put_contents($certfile, $certs['cert']);
			$keyfile = IA_ROOT . '/addons/ewei_shopv2/cert/' . random(64);
			file_put_contents($keyfile, $certs['key']);
			$extras['CURLOPT_SSLCERT'] = $certfile;
			$extras['CURLOPT_SSLKEY'] = $keyfile;

			if (!empty($certs['root'])) {
				$rootfile = IA_ROOT . '/addons/ewei_shopv2/cert/' . random(64);
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

		if ($arr['return_code'] == 'SUCCESS' && $arr['result_code'] == 'FAIL' && $arr['return_msg'] == 'OK' && !$refund_account) {
			if ($arr['err_code'] == 'NOTENOUGH') {
				return $this->wxapp_refund($openid, $out_trade_no, $out_refund_no, $totalmoney, $refundmoney, $app, 'REFUND_SOURCE_RECHARGE_FUNDS');
			}
		}
		else {
			if ($arr['return_msg'] == $arr['err_code_des']) {
				$error = $arr['return_msg'];
			}
			else {
				$error = $arr['return_msg'] . ' | ' . $arr['err_code_des'];
			}

			return error(-2, $error);
		}
	}

	public function refundBorrow($openid, $out_trade_no, $out_refund_no, $totalmoney, $refundmoney = 0, $gaijia = 0, $refund_account = false)
	{
		global $_W;
		global $_GPC;

		if (empty($openid)) {
			return error(-1, 'openid不能为空');
		}

		if (!empty($gaijia)) {
			$out_trade_no = $out_trade_no . '_B';
		}
		else {
			$out_trade_no = $out_trade_no . '_borrow';
		}

		list($pay, $payment) = m('common')->public_build();

		if ($payment['is_new'] == 1) {
			return $this->refund($openid, $out_trade_no, $out_refund_no, $totalmoney, $refundmoney);
		}

		$sec = m('common')->getSec();
		$sec = iunserializer($sec['sec']);
		$certs = $sec['jie'];

		if (!empty($pay['weixin_jie_sub'])) {
			$wechat = array('sub_appid' => !empty($sec['sub_appid_jie_sub']) ? $sec['sub_appid_jie_sub'] : '', 'sub_mch_id' => $sec['sub_mchid_jie_sub']);
			$sec['appid'] = $sec['appid_jie_sub'];
			$sec['mchid'] = $sec['mchid_jie_sub'];
			$sec['apikey'] = $sec['apikey_jie_sub'];
			$row = array('key' => $sec['appid_jie_sub']);
			$certs = $sec['jie_sub'];
		}
		else {
			if (empty($sec['appid']) || empty($sec['mchid']) || empty($sec['apikey'])) {
				return error(1, '没有设定支付参数');
			}
		}

		$url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
		$pars = array();
		$pars['appid'] = $sec['appid'];
		$pars['mch_id'] = $sec['mchid'];
		$pars['nonce_str'] = random(8);
		$pars['out_trade_no'] = $out_trade_no;
		$pars['out_refund_no'] = $out_refund_no;
		$pars['total_fee'] = $totalmoney;
		$pars['refund_fee'] = $refundmoney;
		$pars['op_user_id'] = $sec['mchid'];

		if ($refund_account) {
			$pars['refund_account'] = $refund_account;
		}

		if (!empty($pay['weixin_jie_sub'])) {
			$pars['sub_mch_id'] = $wechat['sub_mch_id'];
			$pars['op_user_id'] = $wechat['sub_mch_id'];

			if ($wechat['sub_appid']) {
				$pars['sub_appid'] = $wechat['sub_appid'];
			}
		}

		ksort($pars, SORT_STRING);
		$string1 = '';

		foreach ($pars as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 .= 'key=' . $sec['apikey'];
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
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

		if ($arr['return_code'] == 'SUCCESS' && $arr['result_code'] == 'FAIL' && $arr['return_msg'] == 'OK' && !$refund_account) {
			if ($arr['err_code'] == 'NOTENOUGH') {
				$this->refundBorrow($openid, $out_trade_no, $out_refund_no, $totalmoney, $refundmoney, $gaijia, 'REFUND_SOURCE_RECHARGE_FUNDS');
			}
		}
		else {
			if ($arr['return_msg'] == $arr['err_code_des']) {
				$error = $arr['return_msg'];
			}
			else {
				$error = $arr['return_msg'] . ' | ' . $arr['err_code_des'];
			}

			return error(-2, $error);
		}
	}

	/**
     * @param $params
     * @param $config
     * @return string
     */
	public function AlipayRefund($params, $batch_no, $config)
	{
		global $_W;
		$params['refund_reason'] = str_replace(array('^', '|', '$', '#'), '', $params['refund_reason']);
		$parameter = array('service' => 'refund_fastpay_by_platform_pwd', 'partner' => $config['partner'], '_input_charset' => 'UTF-8', 'notify_url' => isset($params['notify_url']) ? $params['notify_url'] : $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php', 'seller_user_id' => $config['partner'], 'seller_email' => $config['account'], 'refund_date' => date('Y-m-d H:i:s'), 'batch_no' => $batch_no, 'batch_num' => '1', 'detail_data' => $params['trade_no'] . '^' . $params['refund_price'] . '^' . $params['refund_reason']);
		$parameter = array_filter($parameter);
		$prepares = array();

		foreach ($parameter as $key => $value) {
			$prepares[] = $key . '=' . $value;
		}

		sort($prepares);
		$string = implode($prepares, '&');
		$string_md5 = $string . $config['secret'];
		$parameter['sign'] = md5($string_md5);
		$parameter['sign_type'] = 'MD5';
		load()->func('communication');
		$url = 'https://mapi.alipay.com/gateway.do?' . http_build_query($parameter, '', '&');
		return $url;
	}

	/**
     * @param $params  = array('out_trade_no' => 订单号,'refund_amount'=>退款金额,'refund_reason' => 退款原因);
     * @param $config = array('app_id' => ,'privatekey' => "",'publickey' => "",'alipublickey' => "");
     */
	public function newAlipayRefund($params, $config)
	{
		global $_W;
		$biz_content = array();
		$biz_content['out_trade_no'] = $params['out_trade_no'];
		$biz_content['refund_amount'] = $params['refund_amount'];
		$biz_content['refund_reason'] = $params['refund_reason'];
		$biz_content['out_request_no'] = $params['out_request_no'];
		$biz_content['operator_id'] = $params['operator_id'];
		$biz_content['store_id'] = $params['store_id'];
		$biz_content['terminal_id'] = $params['terminal_id'];
		$biz_content = array_filter($biz_content);
		$config['method'] = 'alipay.trade.refund';
		$config['biz_content'] = json_encode($biz_content);
		$result = m('common')->publicAliPay($config);

		if (is_error($result)) {
			return $result;
		}

		if ($result['alipay_trade_refund_response']['code'] == '10000') {
			return $result['alipay_trade_refund_response'];
		}

		return error($result['alipay_trade_refund_response']['code'], $result['alipay_trade_refund_response']['msg'] . ':' . $result['alipay_trade_refund_response']['sub_msg']);
	}

	/**
     * 下载对账单
     * @param type $type ALL，返回当日所有订单信息，默认值 SUCCESS，返回当日成功支付的订单 REFUND，返回当日退款订单 REVOKED，已撤销的订单
     * @param type $money
     */
	public function downloadbill($starttime, $endtime, $type = 'ALL', $datatype = 0)
	{
		global $_W;
		global $_GPC;
		$dates = array();
		$startdate = date('Ymd', $starttime);
		$enddate = date('Ymd', $endtime);

		if ($startdate == $enddate) {
			$dates = array($startdate);
		}
		else {
			$days = (double) ($endtime - $starttime) / 86400;
			$d = 0;

			while ($d < $days) {
				$dates[] = date('Ymd', strtotime($startdate . ('+' . $d . ' day')));
				++$d;
			}
		}

		if (empty($dates)) {
			show_message('对账单日期选择错误!', '', 'error');
		}

		list($pay, $payment) = m('common')->public_build();

		if ($payment['is_new'] == 0) {
			$setting = uni_setting($_W['uniacid'], array('payment'));

			if (!is_array($setting['payment'])) {
				return error(1, '没有设定支付参数');
			}

			if (!empty($pay['weixin_sub'])) {
				$wechat = array('appid' => $payment['appid_sub'], 'mchid' => $payment['mchid_sub'], 'sub_appid' => !empty($payment['sub_appid_sub']) ? $payment['sub_appid_sub'] : '', 'sub_mch_id' => $payment['sub_mchid_sub'], 'apikey' => $payment['apikey_sub']);
			}
			else {
				$wechat = $setting['payment']['wechat'];
			}

			$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
			$row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
			$wechat['appid'] = $row['key'];
		}
		else {
			$wechat = array('appid' => $payment['sub_appid'], 'mchid' => $payment['sub_mch_id'], 'apikey' => $payment['apikey']);
			$sub_wechat = array('appid' => $payment['appid'], 'mchid' => $payment['mch_id'], 'sub_appid' => !empty($payment['sub_appid']) ? $payment['sub_appid'] : '', 'sub_mch_id' => $payment['sub_mch_id'], 'apikey' => $payment['apikey']);

			switch ($payment['type']) {
			case '1':
				$wechat = $sub_wechat;
				break;

			case '3':
				$wechat = $sub_wechat;
				break;

			case '4':
				return error(1, '暂不支持全付通的账单下载');
			}
		}

		$content = '';

		foreach ($dates as $date) {
			$dc = $this->downloadday($date, $wechat, $type);
			if (is_error($dc) || strexists($dc, 'CDATA[FAIL]')) {
				continue;
			}

			if ($datatype && !strexists($dc, 'ewei_shopv2')) {
				continue;
			}

			$content .= $date . ' 账单

';
			$content .= $dc . '

';
		}

		if (empty($content)) {
			return error(-1, '账单为空');
		}

		$content = "\xef\xbb\xbf" . $content;
		$file = time() . '.csv';
		header('Content-type: application/octet-stream ');
		header('Accept-Ranges: bytes ');
		header('Content-Disposition: attachment; filename=' . $file);
		header('Expires: 0 ');
		header('Content-Encoding: UTF8');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0 ');
		header('Pragma: public ');
		exit($content);
	}

	private function downloadday($date, $wechat, $type)
	{
		$url = 'https://api.mch.weixin.qq.com/pay/downloadbill';
		$pars = array();
		$pars['appid'] = $wechat['appid'];
		$pars['mch_id'] = $wechat['mchid'];

		if (!empty($wechat['sub_appid'])) {
			$pars['sub_appid'] = $wechat['sub_appid'];
		}

		if (!empty($wechat['sub_mch_id'])) {
			$pars['sub_mch_id'] = $wechat['sub_mch_id'];
		}

		$pars['nonce_str'] = random(8);
		$pars['device_info'] = 'ewei_shopv2';
		$pars['bill_date'] = $date;
		$pars['bill_type'] = $type;
		ksort($pars, SORT_STRING);
		$string1 = '';

		foreach ($pars as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		load()->func('communication');
		$resp = ihttp_request($url, $xml, $extras);

		if (strexists($resp['content'], 'No Bill Exist')) {
			return error(-2, '未搜索到任何账单');
		}

		if (is_error($resp)) {
			return error(-2, $resp['message']);
		}

		if (empty($resp['content'])) {
			return error(-2, '网络错误');
		}

		return $resp['content'];
	}

	public function closeOrder($out_trade_no = '')
	{
		global $_W;
		global $_GPC;
		$setting = uni_setting($_W['uniacid'], array('payment'));

		if (!is_array($setting['payment'])) {
			return error(1, '没有设定支付参数');
		}

		$wechat = $setting['payment']['wechat'];
		$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
		$row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
		$url = 'https://api.mch.weixin.qq.com/pay/closeorder';
		$pars = array();
		$pars['appid'] = $row['key'];
		$pars['mch_id'] = $wechat['mchid'];
		$pars['nonce_str'] = random(8);
		$pars['out_trade_no'] = $out_trade_no;
		ksort($pars, SORT_STRING);
		$string1 = '';

		foreach ($pars as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		load()->func('communication');
		$resp = ihttp_post($url, $xml);

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

	public function isWeixinPay($out_trade_no, $money = 0, $app = false)
	{
		global $_W;
		global $_GPC;
		list(, $payment) = m('common')->public_build($app);

		if ($payment['is_new'] == 0) {
			if (!empty($payment['weixin_sub'])) {
				$wechat = array('appid' => $payment['appid_sub'], 'mchid' => $payment['mchid_sub'], 'sub_appid' => !empty($payment['sub_appid_sub']) ? $payment['sub_appid_sub'] : '', 'sub_mch_id' => $payment['sub_mchid_sub'], 'apikey' => $payment['apikey_sub']);
				$payment['apikey'] = $payment['apikey_sub'];
			}
			else {
				$setting = uni_setting($_W['uniacid'], array('payment'));

				if (!is_array($setting['payment'])) {
					return error(1, '没有设定支付参数');
				}

				$wechat = $setting['payment']['wechat'];
				$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
				$row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
				$wechat['appid'] = $row['key'];
			}
		}

		if ($payment['is_new'] == 1 && !$app) {
			$wechat = array('appid' => $payment['sub_appid'], 'mchid' => $payment['sub_mch_id'], 'apikey' => $payment['apikey']);
			$sub_wechat = array('appid' => $payment['appid'], 'mchid' => $payment['mch_id'], 'sub_appid' => !empty($payment['sub_appid']) ? $payment['sub_appid'] : '', 'sub_mch_id' => $payment['sub_mch_id'], 'apikey' => $payment['apikey']);

			switch ($payment['type']) {
			case '1':
				$wechat = $sub_wechat;
				break;

			case '3':
				$wechat = $sub_wechat;
				break;

			case '4':
				$resp = m('pay')->query($out_trade_no, $payment);
				if ($resp['result_code'] == 0 && $resp['status'] == 0) {
					if ($resp['trade_state'] == 'SUCCESS') {
						return true;
					}

					return error(-2, $resp['trade_state'] . '|' . '支付失败');
				}

				return $resp;
			}

			unset($sub_wechat);
		}

		if ($app) {
			$wechat = array('version' => 1, 'apikey' => $payment['app_wechat']['apikey'], 'signkey' => $payment['app_wechat']['apikey'], 'appid' => $payment['app_wechat']['appid'], 'mchid' => $payment['app_wechat']['merchid']);
		}

		$url = 'https://api.mch.weixin.qq.com/pay/orderquery';
		$pars = array();
		$pars['appid'] = $wechat['appid'];
		$pars['mch_id'] = $wechat['mchid'];
		$pars['nonce_str'] = random(32);
		$pars['out_trade_no'] = $out_trade_no;
		if (!empty($wechat['sub_mch_id']) && !is_h5app()) {
			$pars['sub_mch_id'] = $wechat['sub_mch_id'];
		}

		ksort($pars, SORT_STRING);
		$string1 = '';

		foreach ($pars as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['apikey'];
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		load()->func('communication');
		$resp = ihttp_post($url, $xml);

		if (is_error($resp)) {
			return error(-2, $resp['message']);
		}

		if (empty($resp['content'])) {
			return error(-2, '网络错误');
		}

		$xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
		$dom = new DOMDocument();

		if ($dom->loadXML($xml)) {
			$xpath = new DOMXPath($dom);
			$code = $xpath->evaluate('string(//xml/return_code)');
			$ret = $xpath->evaluate('string(//xml/result_code)');
			$trade_state = $xpath->evaluate('string(//xml/trade_state)');
			if (strtolower($code) == 'success' && strtolower($ret) == 'success' && strtolower($trade_state) == 'success') {
				$total_fee = intval($xpath->evaluate('string(//xml/total_fee)')) / 100;

				if ($total_fee != $money) {
					return error(-1, '金额出错');
				}

				return true;
			}

			if ($xpath->evaluate('string(//xml/return_msg)') == $xpath->evaluate('string(//xml/err_code_des)')) {
				$error = $xpath->evaluate('string(//xml/return_msg)');
			}
			else {
				$error = $xpath->evaluate('string(//xml/return_msg)') . ' | ' . $xpath->evaluate('string(//xml/err_code_des)');
			}

			return error(-2, $error);
		}

		return error(-1, '未知错误');
	}

	public function isWeixinPayBorrow($out_trade_no, $money = 0)
	{
		global $_W;
		global $_GPC;

		if (strexists($out_trade_no, 'GJ')) {
			$out_trade_no = $out_trade_no . '_B';
		}
		else {
			$out_trade_no = $out_trade_no . '_borrow';
		}

		list($pay, $payment) = m('common')->public_build();
		$sec = array();

		if (empty($payment['is_new'])) {
			if (!empty($pay['weixin_jie_sub'])) {
				$sec['sub_mch_id'] = $payment['sub_mchid_jie_sub'];
				$sec['appid'] = $payment['appid_jie_sub'];
				$sec['mchid'] = $payment['mchid_jie_sub'];
				$sec['apikey'] = $payment['apikey_jie_sub'];
			}
			else {
				if (empty($sec['appid']) || empty($sec['mchid']) || empty($sec['apikey'])) {
					return error(1, '没有设定支付参数');
				}
			}
		}
		else {
			if ($payment['type'] == 3) {
				$sec['sub_mch_id'] = $payment['sub_mch_id'];
			}

			$sec['appid'] = $payment['appid'];
			$sec['mchid'] = $payment['mch_id'];
			$sec['apikey'] = $payment['apikey'];
		}

		$url = 'https://api.mch.weixin.qq.com/pay/orderquery';
		$pars = array();
		$pars['appid'] = $sec['appid'];
		$pars['mch_id'] = $sec['mchid'];
		$pars['nonce_str'] = random(8);
		$pars['out_trade_no'] = $out_trade_no;

		if (!empty($sec['sub_mch_id'])) {
			$pars['sub_mch_id'] = $sec['sub_mch_id'];
		}

		ksort($pars, SORT_STRING);
		$string1 = '';

		foreach ($pars as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 .= 'key=' . $sec['apikey'];
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		load()->func('communication');
		$resp = ihttp_post($url, $xml);

		if (is_error($resp)) {
			return error(-2, $resp['message']);
		}

		if (empty($resp['content'])) {
			return error(-2, '网络错误');
		}

		libxml_disable_entity_loader(true);
		$arr = json_decode(json_encode((array) simplexml_load_string($resp['content'])), true);
		$xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
		$dom = new DOMDocument();

		if ($dom->loadXML($xml)) {
			$xpath = new DOMXPath($dom);
			$code = $xpath->evaluate('string(//xml/return_code)');
			$ret = $xpath->evaluate('string(//xml/result_code)');
			$trade_state = $xpath->evaluate('string(//xml/trade_state)');
			if (strtolower($code) == 'success' && strtolower($ret) == 'success' && strtolower($trade_state) == 'success') {
				$total_fee = intval($xpath->evaluate('string(//xml/total_fee)')) / 100;

				if ($total_fee != $money) {
					return error(-1, '金额出错');
				}

				return true;
			}

			if ($xpath->evaluate('string(//xml/return_msg)') == $xpath->evaluate('string(//xml/err_code_des)')) {
				$error = $xpath->evaluate('string(//xml/return_msg)');
			}
			else {
				$error = $xpath->evaluate('string(//xml/return_msg)') . ' | ' . $xpath->evaluate('string(//xml/err_code_des)');
			}

			return error(-2, $error);
		}

		return error(-1, '未知错误');
	}

	public function isAlipayNotify($gpc)
	{
		global $_W;

		if ($gpc['sign_type'] == 'RSA') {
			$sec_yuan = m('common')->getSec();
			$sec = iunserializer($sec_yuan['sec']);
			$public_key = $sec['alipay_pay']['public_key'];

			if (empty($public_key)) {
				exit();
			}

			$data_gpc = array('total_amount' => $gpc['total_amount'], 'timestamp' => $gpc['timestamp'], 'sign' => $gpc['sign'], 'trade_no' => $gpc['trade_no'], 'sign_type' => $gpc['sign_type'], 'auth_app_id' => $gpc['auth_app_id'], 'charset' => $gpc['charset'], 'seller_id' => $gpc['seller_id'], 'method' => $gpc['method'], 'app_id' => $gpc['app_id'], 'out_trade_no' => $gpc['out_trade_no'], 'version' => $gpc['version']);
			$verify = $this->RSAVerify($data_gpc, $public_key, true);
			return $verify;
		}

		if ($gpc['sign_type'] == 'RSA2') {
			$sec_yuan = m('common')->getSec();
			$sec = iunserializer($sec_yuan['sec']);
			$public_key = $sec['alipay_pay']['public_key'];

			if (empty($public_key)) {
				exit();
			}

			$data_gpc = array('total_amount' => $gpc['total_amount'], 'timestamp' => $gpc['timestamp'], 'sign' => $gpc['sign'], 'trade_no' => $gpc['trade_no'], 'sign_type' => $gpc['sign_type'], 'auth_app_id' => $gpc['auth_app_id'], 'charset' => $gpc['charset'], 'seller_id' => $gpc['seller_id'], 'method' => $gpc['method'], 'app_id' => $gpc['app_id'], 'out_trade_no' => $gpc['out_trade_no'], 'version' => $gpc['version']);
			$verify = $this->RSAVerify($data_gpc, $public_key, true);
			return $verify;
		}

		$notify_id = trim($gpc['notify_id']);
		$notify_sign = trim($gpc['sign']);
		if (empty($notify_id) || empty($notify_sign)) {
			return false;
		}

		$setting = uni_setting($_W['uniacid'], array('payment'));

		if (!is_array($setting['payment'])) {
			return false;
		}

		$alipay = $setting['payment']['alipay'];
		$params = array('body' => $gpc['body'], 'is_success' => $gpc['is_success'], 'notify_id' => $gpc['notify_id'], 'notify_time' => $gpc['notify_time'], 'notify_type' => $gpc['notify_type'], 'out_trade_no' => $gpc['out_trade_no'], 'payment_type' => $gpc['payment_type'], 'seller_id' => $gpc['seller_id'], 'service' => $gpc['service'], 'subject' => $gpc['subject'], 'total_fee' => $gpc['total_fee'], 'trade_no' => $gpc['trade_no'], 'trade_status' => $gpc['trade_status']);
		ksort($params, SORT_STRING);
		$string1 = '';

		foreach ($params as $k => $v) {
			$string1 .= $k . '=' . $v . '&';
		}

		$string1 = rtrim($string1, '&') . $alipay['secret'];
		$sign = strtolower(md5($string1));

		if ($notify_sign != $sign) {
			return false;
		}

		$url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&partner=' . $alipay['partner'] . '&notify_id=' . $notify_id;
		$resp = @file_get_contents($url);
		return preg_match('/true$/i', $resp);
	}

	public function RSAVerify($return_data, $public_key, $ksort = true)
	{
		if (empty($return_data) || !is_array($return_data)) {
			return false;
		}

		$public_key = m('common')->chackKey($public_key);
		$pkeyid = openssl_pkey_get_public($public_key);

		if (empty($pkeyid)) {
			return false;
		}

		$rsasign = $return_data['sign'];
		$sign_type = trim($return_data['sign_type'], '"');
		unset($return_data['sign']);
		unset($return_data['sign_type']);

		if ($ksort) {
			ksort($return_data);
		}

		if (is_array($return_data) && !empty($return_data)) {
			$strdata = '';

			foreach ($return_data as $k => $v) {
				if (empty($v)) {
					continue;
				}

				if (is_array($v)) {
					$strdata .= $k . '=' . json_encode($v) . '&';
				}
				else {
					$strdata .= $k . '=' . $v . '&';
				}
			}
		}

		$strdata = trim($strdata, '&');
		$rsasign = str_replace(' ', '+', $rsasign);
		$rsasign = base64_decode($rsasign);

		if ($sign_type == 'RSA') {
			$rsaverify = openssl_verify($strdata, $rsasign, $pkeyid);
		}
		else {
			if ($sign_type == 'RSA2') {
				$rsaverify = openssl_verify($strdata, $rsasign, $pkeyid, OPENSSL_ALGO_SHA256);
			}
		}

		openssl_free_key($pkeyid);
		return $rsaverify;
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
     * 支付宝单笔打款(author - 人人商城-洋葱)
     * @param $aliPayAccount array('account'=>'支付宝账号','name'=>'支付宝姓名','money'=>'需要支付的金额',) 可以是 二维数组
     * @param $config array('partner'=>'PID','account_name'=>'真实的支付账户名','email'=>'支付账号','key'=>'MD5秘钥',)
     * @param string $remark 支付备注 : 默认是 : 现金提现
     * @return string|array
     */
	public function singleAliPay($aliPayAccount, $out_biz_no, $config, $remark = '现金提现')
	{
		global $_W;

		if (empty($aliPayAccount)) {
			return error('-1', '打款账户错误');
		}

		if (empty($config['app_id'])) {
			return error('-1', 'APPID 未配置!');
		}

		$alipay_sign_type = intval($config['single_alipay_sign_type']) == 1 ? 'RSA2' : 'RSA';
		$public = array('app_id' => $config['app_id'], 'method' => 'alipay.fund.trans.toaccount.transfer', 'charset' => 'utf-8', 'format' => 'JSON', 'sign_type' => $alipay_sign_type, 'timestamp' => date('Y-m-d H:i:s'), 'version' => '1.0');
		$biz_content = array();
		$biz_content['out_biz_no'] = $out_biz_no;
		$biz_content['payee_type'] = 'ALIPAY_LOGONID';
		$biz_content['payee_account'] = $aliPayAccount['account'];
		$biz_content['amount'] = $aliPayAccount['money'];
		$biz_content['remark'] = $remark;
		$biz_content = array_filter($biz_content);
		$public['biz_content'] = json_encode($biz_content);
		$config['private_key'] = $config['single_private_key'];
		$public = $this->alipayRsaSign($public, $config);

		if ($public['errno'] == '-1') {
			return $public;
		}

		load()->func('communication');
		$url = 'https://openapi.alipay.com/gateway.do';
		$response = ihttp_post($url, $public);
		$result = json_decode(iconv('GBK', 'UTF-8//IGNORE', $response['content']), true);
		$query_response = $result['alipay_fund_trans_toaccount_transfer_response'];

		if ($query_response['code'] != '10000') {
			return error(-1, $query_response['code'] . ' | ' . $query_response['sub_msg']);
		}

		return $query_response;
	}

	/**
     * 查询支付宝单笔打款(author - 人人商城-洋葱)
     * @param array $config 支付宝参数配置
     * @param string $order_id 支付宝转账单据号
     * @param string $out_biz_no 商户转账唯一订单号
     * @return string|array
     */
	public function querySingleAliPay($config, $order_id, $out_biz_no)
	{
		global $_W;
		if (empty($order_id) && empty($out_biz_no)) {
			return error('-1', '支付宝转账单号和商户转账单号不能同时为空');
		}

		if (empty($config['app_id'])) {
			return error('-1', 'APPID 未配置!');
		}

		$alipay_sign_type = intval($config['single_alipay_sign_type']) == 1 ? 'RSA2' : 'RSA';
		$public = array('app_id' => $config['app_id'], 'method' => 'alipay.fund.trans.order.query', 'charset' => 'utf-8', 'format' => 'JSON', 'sign_type' => $alipay_sign_type, 'timestamp' => date('Y-m-d H:i:s'), 'version' => '1.0');
		$biz_content = array();

		if ($order_id) {
			$biz_content['order_id'] = $order_id;
		}

		if ($out_biz_no) {
			$biz_content['out_biz_no'] = $out_biz_no;
		}

		$biz_content = array_filter($biz_content);
		$public['biz_content'] = json_encode($biz_content);
		$config['private_key'] = $config['single_private_key'];
		$public = $this->alipayRsaSign($public, $config);

		if ($public['errno'] == '-1') {
			return $public;
		}

		load()->func('communication');
		$url = 'https://openapi.alipay.com/gateway.do';
		$response = ihttp_post($url, $public);
		$result = json_decode(iconv('GBK', 'UTF-8//IGNORE', $response['content']), true);
		$query_response = $result['alipay_fund_trans_order_query_response'];

		if ($query_response['code'] != '10000') {
			return error(-1, $query_response['code'] . ' | ' . $query_response['sub_msg']);
		}

		return $query_response;
	}

	/**
     * 支付宝参数生成签名(author - 人人商城-洋葱)
     * @param array $public 请求参数
     * @param array $config array('private_key'=>'应用私钥')
     * @return array
     */
	public function alipayRsaSign($public, $config)
	{
		if (empty($public)) {
			return error(-1, '参数不能为空！');
		}

		if (!is_array($public)) {
			return error(-1, '参数格式错误！');
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
		$pkeyid = openssl_pkey_get_private(m('common')->chackKey($config['private_key'], false));

		if ($pkeyid === false) {
			return error(-1, '提供的私钥格式不对');
		}

		$signature = '';

		if ($public['sign_type'] == 'RSA') {
			openssl_sign($string1, $signature, $pkeyid, OPENSSL_ALGO_SHA1);
		}
		else {
			if ($public['sign_type'] == 'RSA2') {
				openssl_sign($string1, $signature, $pkeyid, OPENSSL_ALGO_SHA256);
			}
		}

		openssl_free_key($pkeyid);
		$signature = base64_encode($signature);

		if (empty($signature)) {
			return error(-1, '签名不能为空！');
		}

		$public['sign'] = $signature;
		return $public;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
