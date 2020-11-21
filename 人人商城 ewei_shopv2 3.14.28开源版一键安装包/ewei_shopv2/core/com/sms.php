<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Sms_EweiShopV2ComModel extends ComModel
{
	/**
     * 发送短信
     * @param int $mobile 手机号
     * @param string $tplid 商城短信模板iID
     * @param array $data  发送数据  $replace=true $data替换模板数据  $replace=false 则直接使用$data作为发送数据
     * @param true $replace  是否替换数据
     * @return array  return status
     */
	public function send($mobile, $tplid, $data, $replace = true)
	{
		global $_W;
		$smsset = $this->sms_set();
		$template = $this->sms_verify($tplid, $smsset);

		if (empty($template['status'])) {
			return $template;
		}

		if ($template['type'] == 'aliyun_new' || $template['type'] == 'aliyun') {
			foreach ($data as $key => $val) {
				if (20 < mb_strlen($val)) {
					$data[$key] = mb_substr($val, 0, 7, 'UTF-8') . '....' . mb_substr($val, -8, NULL, 'UTF-8');
				}
			}
		}

		$params = $this->sms_data($template['type'], $data, $replace, $template);

		if ($template['type'] == 'juhe') {
			$data = array('mobile' => $mobile, 'tpl_id' => $template['smstplid'], 'tpl_value' => $params, 'key' => $smsset['juhe_key']);
			load()->func('communication');
			$result = ihttp_post('http://v.juhe.cn/sms/send', $data);
			$result = json_decode($result['content'], true);
			if (empty($result) || isset($result['error_code']) && 0 < $result['error_code']) {
				return array('status' => 0, 'message' => '短信发送失败(' . $result['error_code'] . ')：' . $result['reason']);
			}
		}
		else if ($template['type'] == 'dayu') {
			include_once EWEI_SHOPV2_VENDOR . 'dayu/TopSdk.php';
			$dayuClient = new TopClient();
			$dayuClient->appkey = $smsset['dayu_key'];
			$dayuClient->secretKey = $smsset['dayu_secret'];
			$dayuRequest = new AlibabaAliqinFcSmsNumSendRequest();
			$dayuRequest->setSmsType('normal');
			$dayuRequest->setSmsFreeSignName($template['smssign']);
			$dayuRequest->setSmsParam($params);
			$dayuRequest->setRecNum('' . $mobile);
			$dayuRequest->setSmsTemplateCode($template['smstplid']);
			$dayuResult = $dayuClient->execute($dayuRequest);
			$dayuResult = (array) $dayuResult;
			if (empty($dayuResult) || !empty($dayuResult['code'])) {
				return array('status' => 0, 'message' => '短信发送失败(' . $dayuResult['sub_msg'] . '/code: ' . $dayuResult['code'] . '/sub_code: ' . $dayuResult['sub_code'] . ')');
			}
		}
		else if ($template['type'] == 'aliyun') {
			load()->func('communication');
			$paramstr = http_build_query(array('ParamString' => $params, 'RecNum' => $mobile, 'SignName' => $template['smssign'], 'TemplateCode' => $template['smstplid']));
			$header = array('Authorization' => 'APPCODE ' . $smsset['aliyun_appcode']);
			$request = ihttp_request('http://sms.market.alicloudapi.com/singleSendSms?' . $paramstr, '', $header);
			$result = json_decode($request['content'], true);
			if (!$result['success'] || $request['code'] != 200) {
				if ($request['code'] != 200) {
					$result['message'] = $request['headers']['X-Ca-Error-Message'];
				}

				return array('status' => 0, 'message' => '短信发送失败(错误信息: ' . $result['message'] . ')');
			}
		}
		else if ($template['type'] == 'aliyun_new') {
			include_once EWEI_SHOPV2_VENDOR . 'aliyun/sendSms.php';
			$option = array('keyid' => $smsset['aliyun_new_keyid'], 'keysecret' => $smsset['aliyun_new_keysecret'], 'phonenumbers' => $mobile, 'signname' => $template['smssign'], 'templatecode' => $template['smstplid'], 'templateparam' => $params);
			$result = sendSms($option);

			if ($result['Message'] != 'OK') {
				return array('status' => 0, 'message' => '短信发送失败(错误信息: ' . $result['Message'] . ')');
			}
		}
		else if ($template['type'] == 'emay') {
			include_once EWEI_SHOPV2_VENDOR . 'emay/SMSUtil.php';
			$balance = $this->sms_num('emay', $smsset);

			if ($balance <= 0) {
				return array('status' => 0, 'message' => '短信发送失败(亿美软通余额不足, 当前余额' . $balance . ')');
			}

			$emayClient = new SMSUtil($smsset['emay_url'], $smsset['emay_sn'], $smsset['emay_pw'], $smsset['emay_sk'], array('proxyhost' => $smsset['emay_phost'], 'proxyport' => $smsset['pport'], 'proxyusername' => $smsset['puser'], 'proxypassword' => $smsset['ppw']), $smsset['emay_out'], $smsset['emay_outresp']);
			$emayResult = $emayClient->send($mobile, '【' . $template['smssign'] . '】' . $params);

			if (!empty($emayResult)) {
				return array('status' => 0, 'message' => '短信发送失败(错误信息: ' . $emayResult . ')');
			}
		}
		else {
			return array('status' => 0, 'message' => '短信发送失败(未识别的短信服务商)');
		}

		return array('status' => 1);
	}

	public function sms_set()
	{
		global $_W;
		return pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_sms_set') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));
	}

	public function sms_temp()
	{
		global $_W;
		$list = pdo_fetchall('SELECT id, `type`, `name` FROM ' . tablename('ewei_shop_sms') . ' WHERE status=1 and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));

		foreach ($list as $i => &$item) {
			if ($item['type'] == 'juhe') {
				$item['name'] = '[聚合]' . $item['name'];
			}
			else if ($item['type'] == 'dayu') {
				$item['name'] = '[大于]' . $item['name'];
			}
			else if ($item['type'] == 'aliyun') {
				$item['name'] = '[阿里云]' . $item['name'];
			}
			else if ($item['type'] == 'aliyun_new') {
				$item['name'] = '[新版阿里云]' . $item['name'];
			}
			else {
				if ($item['type'] == 'emay') {
					$item['name'] = '[亿美]' . $item['name'];
				}
			}
		}

		unset($item);
		return $list;
	}

	public function sms_num($type, $smsset = NULL)
	{
		if (empty($type)) {
			return NULL;
		}

		if (empty($smsset) || !is_array($smsset)) {
			$smsset = $this->sms_set();
		}

		if ($type == 'emay') {
			include_once EWEI_SHOPV2_VENDOR . 'emay/SMSUtil.php';
			$emayClient = new SMSUtil($smsset['emay_url'], $smsset['emay_sn'], $smsset['emay_pw'], $smsset['emay_sk'], array('proxyhost' => $smsset['emay_phost'], 'proxyport' => $smsset['pport'], 'proxyusername' => $smsset['puser'], 'proxypassword' => $smsset['ppw']), $smsset['emay_out'], $smsset['emay_outresp']);
			$num = $emayClient->getBalance();
			if (!empty($smsset['emay_warn']) && !empty($smsset['emay_mobile']) && $num < $smsset['emay_warn'] && $smsset['emay_warn_time'] + 60 * 60 * 24 < time()) {
				$emayClient = new SMSUtil($smsset['emay_url'], $smsset['emay_sn'], $smsset['emay_pw'], $smsset['emay_sk'], array('proxyhost' => $smsset['emay_phost'], 'proxyport' => $smsset['pport'], 'proxyusername' => $smsset['puser'], 'proxypassword' => $smsset['ppw']), $smsset['emay_out'], $smsset['emay_outresp']);
				$emayResult = $emayClient->send($smsset['emay_mobile'], '【系统预警】' . '您的亿美软通SMS余额为:' . $num . '，低于预警值:' . $smsset['emay_warn'] . ' (24小时内仅通知一次)');

				if (empty($emayResult)) {
					pdo_update('ewei_shop_sms_set', array('emay_warn_time' => time()), array('id' => $smsset['id']));
				}
			}

			return $num;
		}
	}

	protected function sms_verify($tplid, $smsset)
	{
		global $_W;
		$template = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_sms') . ' WHERE id=:id and uniacid=:uniacid ', array(':id' => $tplid, ':uniacid' => $_W['uniacid']));
		$template['data'] = iunserializer($template['data']);

		if (empty($template)) {
			return array('status' => 0, 'message' => '模板不存在!');
		}

		if (empty($template['status'])) {
			return array('status' => 0, 'message' => '模板未启用!');
		}

		if (empty($template['type'])) {
			return array('status' => 0, 'message' => '模板类型错误!');
		}

		if ($template['type'] == 'juhe') {
			if (empty($smsset['juhe'])) {
				return array('status' => 0, 'message' => '未开启聚合数据!');
			}

			if (empty($smsset['juhe_key'])) {
				return array('status' => 0, 'message' => '未填写聚合数据Key!');
			}

			if (empty($template['data']) || !is_array($template['data'])) {
				return array('status' => 0, 'message' => '模板类型错误!');
			}
		}
		else if ($template['type'] == 'dayu') {
			if (empty($smsset['dayu'])) {
				return array('status' => 0, 'message' => '未开启阿里大于!');
			}

			if (empty($smsset['dayu_key'])) {
				return array('status' => 0, 'message' => '未填写阿里大于Key!');
			}

			if (empty($smsset['dayu_secret'])) {
				return array('status' => 0, 'message' => '未填写阿里大于Secret!');
			}

			if (empty($template['data']) || !is_array($template['data'])) {
				return array('status' => 0, 'message' => '模板类型错误!');
			}

			if (empty($template['smssign'])) {
				return array('status' => 0, 'message' => '未填写阿里大于短信签名!');
			}
		}
		else if ($template['type'] == 'aliyun') {
			if (empty($smsset['aliyun'])) {
				return array('status' => 0, 'message' => '未开启阿里云短信(旧版)!');
			}

			if (empty($smsset['aliyun_appcode'])) {
				return array('status' => 0, 'message' => '未填写阿里云短信AppCode!');
			}

			if (empty($template['data']) || !is_array($template['data'])) {
				return array('status' => 0, 'message' => '模板类型错误!');
			}

			if (empty($template['smssign'])) {
				return array('status' => 0, 'message' => '未填写阿里云短信(旧版)签名!');
			}
		}
		else if ($template['type'] == 'aliyun_new') {
			if (empty($smsset['aliyun_new'])) {
				return array('status' => 0, 'message' => '未开启阿里云短信(新版)!');
			}

			if (empty($smsset['aliyun_new_keyid'])) {
				return array('status' => 0, 'message' => '未填写阿里云短信(新版)KeyID!');
			}

			if (empty($smsset['aliyun_new_keysecret'])) {
				return array('status' => 0, 'message' => '未填写阿里云短信(新版)keySecret!');
			}

			if (empty($template['data']) || !is_array($template['data'])) {
				return array('status' => 0, 'message' => '模板类型错误!');
			}

			if (empty($template['smssign'])) {
				return array('status' => 0, 'message' => '未填写阿里云短信(新版)签名!');
			}
		}
		else {
			if ($template['type'] == 'emay') {
				if (empty($smsset['emay'])) {
					return array('status' => 0, 'message' => '未开启亿美软通!');
				}

				if (empty($smsset['emay_url'])) {
					return array('status' => 0, 'message' => '未填写亿美软通网关!');
				}

				if (empty($smsset['emay_sn'])) {
					return array('status' => 0, 'message' => '未填写亿美软通序列号!');
				}

				if (empty($smsset['emay_pw'])) {
					return array('status' => 0, 'message' => '未填写亿美软通密码!');
				}

				if (empty($smsset['emay_sk'])) {
					return array('status' => 0, 'message' => '未填写亿美软通SessionKey!');
				}

				if (empty($template['smssign'])) {
					return array('status' => 0, 'message' => '未填写亿美软通短信签名!');
				}
			}
		}

		return $template;
	}

	protected function sms_data($type, $data, $replace, $template)
	{
		if ($replace) {
			if ($type == 'emay') {
				$tempdata = $template['content'];

				foreach ($data as $key => $value) {
					$tempdata = str_replace('[' . $key . ']', $value, $tempdata);
				}

				$data = $tempdata;
			}
			else {
				$tempdata = iunserializer($template['data']);

				foreach ($tempdata as &$td) {
					foreach ($data as $key => $value) {
						$td['data_shop'] = str_replace('[' . $key . ']', $value, $td['data_shop']);
					}
				}

				unset($td);
				$newdata = array();

				foreach ($tempdata as $td) {
					$newdata[$td['data_temp']] = $td['data_shop'];
				}

				$data = $newdata;
			}
		}

		if ($type == 'juhe') {
			$result = '';
			$count = count($data);
			$i = 0;

			foreach ($data as $key => $value) {
				if (0 < $i && $i < $count) {
					$result .= '&';
				}

				$result .= '#' . $key . '#=' . $value;
				++$i;
			}
		}
		else {
			if ($type == 'dayu' || $type == 'aliyun' || $type == 'aliyun_new') {
				$result = json_encode($data);
			}
			else {
				if ($type == 'emay') {
					$result = $data;
				}
			}
		}

		return $result;
	}

	protected function http_post($url, $postData)
	{
		$postData = http_build_query($postData);
		$options = array(
			'http' => array('method' => 'POST', 'header' => 'Content-type:application/x-www-form-urlencoded', 'content' => $postData, 'timeout' => 15 * 60)
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);

		if (!is_array($result)) {
			$result = json_decode($result, true);
		}

		return $result;
	}

	protected function http_get($url)
	{
		$result = file_get_contents($url, false);

		if (!is_array($result)) {
			$result = json_decode($result, true);
		}

		return $result;
	}

	public function callsms(array $params)
	{
		global $_W;
		$tag = isset($params['tag']) ? $params['tag'] : '';
		$datas = isset($params['datas']) ? $params['datas'] : array();
		$tm = $_W['shopset']['notice'];

		if (empty($tm)) {
			$tm = m('common')->getSysset('notice');
		}

		$smsid = $tm[$tag . '_sms'];
		$smsclose = $tm[$tag . '_close_sms'];
		if (!empty($smsid) && empty($smsclose) && !empty($params['mobile'])) {
			$sms_data = array();

			foreach ($datas as $i => $value) {
				$sms_data[$value['name']] = $value['value'];
			}

			$this->send($params['mobile'], $smsid, $sms_data);
		}
	}
}

?>
