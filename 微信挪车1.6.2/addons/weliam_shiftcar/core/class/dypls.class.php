<?php
defined('IN_IA') or exit('Access Denied');

class dypls {

	static function bindmobile($a = '', $b = '') {
		global $_W;
		if (empty($a)) {
			die(json_encode(array("result" => 2,"msg" => '电话号码不能为空')));
		}
		//删除所有过期的绑定
		pdo_delete('weliam_shiftcar_bindrecord', array('uniacid' => $_W['uniacid'], 'expiration <' => time()));
		if ($_W['wlsetting']['api']['btatus'] == 1) {
			if (empty($b)) {
				die(json_encode(array("result" => 2,"msg" => '电话号码不能为空')));
			}
			$record = pdo_get('weliam_shiftcar_bindrecord', array('type' => 0, 'uniacid' => $_W['uniacid'], 'phonea' => $a, 'phoneb' => $b, 'expiration >' => time()));
			if ($record) {
				return $record;
			}
			$record = pdo_get('weliam_shiftcar_bindrecord', array('type' => 0, 'uniacid' => $_W['uniacid'], 'phonea' => $b, 'phoneb' => $a, 'expiration >' => time()));
			if ($record) {
				return $record;
			}
			return self::bindAxb($a, $b);
		} else {
			$record = pdo_get('weliam_shiftcar_bindrecord', array('type' => 1, 'uniacid' => $_W['uniacid'], 'phonea' => $a, 'phoneb' => $b, 'expiration >' => time()));
			if ($record) {
				return $record;
			}
			return self::bindAxn($a, $b);
		}
	}

	/**
	 * AXB绑定
	 */
	static function bindAxb($a = '', $b = '') {
		global $_W;
		$params = array();
		//必填:号池Key
        $params["PoolKey"] = $_W['wlsetting']['api']['aliyun_PoolKey'];
		// fixme 必填: AXB关系中的A号码
		$params["PhoneNoA"] = $a;
		// fixme 必填: AXB关系中的B号码
		$params["PhoneNoB"] = $b;
		// fixme 必填: 绑定关系对应的失效时间-不能早于当前系统时间
		$params["Expiration"] = date('Y-m-d H:i:s', time() + 7200);
		// fixme 可选: 是否需要录制音频-默认是"false"
		$params["IsRecordingEnabled"] = "false";
		$params["OutId"] = "movecar";

		// *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
		$content = self::request($_W['wlsetting']['api']['aliyun_AccessKeyId'], $_W['wlsetting']['api']['aliyun_AccessKeySecret'], "dyplsapi.aliyuncs.com", array_merge($params, array(
			"RegionId" => "cn-hangzhou",
			"Action" => "BindAxb",
			"Version" => "2017-05-25",
		)));
		if ($content['Message'] == 'OK') {
			$data = array('uniacid' => $_W['uniacid'], 'phonea' => $a, 'phoneb' => $b, 'expiration' => time() + 7200, 'secretno' => $content['SecretBindDTO']['SecretNo'] == '6855' ? $_W['wlsetting']['api']['aliyun_ysnum'] : $content['SecretBindDTO']['SecretNo'] , 'subsid' => $content['SecretBindDTO']['SubsId']);
			pdo_insert('weliam_shiftcar_bindrecord', $data);
			return $data;
		} else {
			die(json_encode(array("result" => 2,"msg" => $content['Message'])));
		}
	}

	/**
	 * AXN绑定
	 */
	static function bindAxn($a = '', $b = '') {
		global $_W;
	    $params = array ();
	    // fixme 必填: 号池Key
	    $params["PoolKey"] = $_W['wlsetting']['api']['aliyun_PoolKey'];
	    // fixme 必填:AXN关系中的A号码
	    $params["PhoneNoA"] = $a;
	    // fixme 必填:95中间号, 目前支持2种号码类型, NO_95代表95接入号, NO_170代表170中间号
	    $params["NoType"] = "NO_95";
	    // fixme 必填:绑定关系对应的失效时间-不能早于当前系统时间
	    $params["Expiration"] = date('Y-m-d H:i:s', time() + 7200);
	    // fixme 可选:是否需要录制音频-默认是"false"
	    $params["IsRecordingEnabled"] = "false";
	    $params["OutId"] = "movecar";
	
	    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
		$content = self::request($_W['wlsetting']['api']['aliyun_AccessKeyId'], $_W['wlsetting']['api']['aliyun_AccessKeySecret'], "dyplsapi.aliyuncs.com", array_merge($params, array(
			"RegionId" => "cn-hangzhou",
			"Action" => "BindAxn",
			"Version" => "2017-05-25",
		)));
		if ($content['Message'] == 'OK') {
			$data = array('type' => 1, 'uniacid' => $_W['uniacid'], 'phonea' => $a, 'phoneb' => $b, 'expiration' => time() + 7200, 'secretno' => $content['SecretBindDTO']['SecretNo'] == '6855' ? $_W['wlsetting']['api']['aliyun_ysnum'] : $content['SecretBindDTO']['SecretNo'] , 'subsid' => $content['SecretBindDTO']['SubsId']);
			pdo_insert('weliam_shiftcar_bindrecord', $data);
			return $data;
		} else {
			die(json_encode(array("result" => 2,"msg" => $content['Message'])));
		}
	
	    return $content;
	}

	/**
	 * 获取录音文件下载链接
	 */
	static function queryRecordFileDownloadUrl() {
		$params = array();
		// fixme 必填: 号池Key
    	$params["PoolKey"] = $_W['wlsetting']['api']['aliyun_PoolKey'];
		// fixme 必填: 对应的产品类型,目前一共支持三款产品AXB_170,AXN_170,AXN_95
		$params["ProductType"] = "AXB_170";
		// fixme 必填: 话单回执中返回的标识每一通唯一通话行为的callId
		$params["CallId"] = "abcedf1234";
		// fixme 必填: 话单回执中返回的callTime字段
		$params["CallTime"] = "2017-09-05 12:00:00";

		// *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
		$content = self::request($_W['wlsetting']['api']['aliyun_AccessKeyId'], $_W['wlsetting']['api']['aliyun_AccessKeySecret'], "dyplsapi.aliyuncs.com", array_merge($params, array(
			"RegionId" => "cn-hangzhou",
			"Action" => "QueryRecordFileDownloadUrl",
			"Version" => "2017-05-25",
		)));

		return $content;
	}

	/**
	 * 查询绑定关系详情
	 */
	static function querySubscriptionDetail() {
		global $_W;
		$params = array();
		// fixme 必填: 号池Key
    	$params["PoolKey"] = $_W['wlsetting']['api']['aliyun_PoolKey'];
		// fixme 必填: 产品类型,目前一共支持三款产品AXB_170,AXN_170,AXN_95
		$params["ProductType"] = "AXB_170";
		// fixme 必填: 绑定关系ID
		$params["SubsId"] = "123456";
		// fixme 必填: 绑定关系对应的X号码
		$params["PhoneNoX"] = "170000000";
		// *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
		$content = self::request($_W['wlsetting']['api']['aliyun_AccessKeyId'], $_W['wlsetting']['api']['aliyun_AccessKeySecret'], "dyplsapi.aliyuncs.com", array_merge($params, array(
			"RegionId" => "cn-hangzhou",
			"Action" => "QuerySubscriptionDetail",
			"Version" => "2017-05-25",
		)));

		return $content;
	}

	/**
	 * 解除绑定关系
	 */
	static function unbindSubscription($a = '') {
		global $_W;
		if (empty($a)) {
			return;
		}
		$params = array();
		// fixme 必填: 号池Key
    	$params["PoolKey"] = $_W['wlsetting']['api']['aliyun_PoolKey'];
		// fixme 必填: 您所选择的产品类型,目前支持AXB_170、AXN_170、AXN_95三种产品类型
		$params["ProductType"] = "AXB_170";
		// fixme 必填: 分配的X小号-对应到绑定接口中返回的secretNo(三元绑定关系对应的绑定ID)
		$params["SecretNo"] = $a['secretno'];
		// fixme 必填: 绑定关系对应的ID-对应到绑定接口中返回的subsId(调用绑定接口时分配的隐私号码)
		$params["SubsId"] = $a['subsid'];
		// *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
		$content = self::request($_W['wlsetting']['api']['aliyun_AccessKeyId'], $_W['wlsetting']['api']['aliyun_AccessKeySecret'], "dyplsapi.aliyuncs.com", array_merge($params, array(
			"RegionId" => "cn-hangzhou",
			"Action" => "UnbindSubscription",
			"Version" => "2017-05-25",
		)));

		return $content;
	}

	/**
	 * 更新绑定关系
	 */
	static function updateSubscription() {
		global $_W;
		$params = array();
		// fixme 必填: 号池Key
    	$params["PoolKey"] = $_W['wlsetting']['api']['aliyun_PoolKey'];
		// fixme 必填: 您所选择的产品类型,目前支持AXB_170、AXN_170、AXN_95三种产品类型
		$params["ProductType"] = "AXB_170";
		// fixme 必填: 创建绑定关系API接口所返回的订购关系ID
		$params["SubsId"] = "123456";
		// fixme 必填: 创建绑定关系API接口所返回的X号码
		$params["PhoneNoX"] = "170000000";

		// todo 以下操作三选一, 目前支持三种类型: updateNoA(修改A号码)、updateNoB(修改B号码)、updateExpire(更新绑定关系有效期)

		// -------------------------------------------------------------------

		// 1. 修改A号码示例：
		// fixme 必填: 操作类型
		$params["OperateType"] = "updateNoA";

		// fixme OperateType为updateNoA时必选: 需要修改的A号码
		$params["PhoneNoA"] = "150000000";

		// -------------------------------------------------------------------

		// 2. 修改B号码示例：
		// fixme 必填: 操作类型
		$params["OperateType"] = "updateNoB";

		// fixme OperateType为updateNoB时必选: 需要修改的B号码
		$params["PhoneNoB"] = "150000000";

		// -------------------------------------------------------------------

		// 3. 更新绑定关系有效期示例：
		// fixme 必填: 操作类型
		$params["OperateType"] = "updateExpire";

		// fixme OperateType为updateExpire时必选: 需要修改的绑定关系有效期
		$params["Expiration"] = "2017-09-05 12:00:00";

		// -------------------------------------------------------------------

		//若修改B号码，请调用：$params["OperateType"] = "updateNoB"; $params["PhoneNoA"] = ".....";

		// *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
		$content = self::request($_W['wlsetting']['api']['aliyun_AccessKeyId'], $_W['wlsetting']['api']['aliyun_AccessKeySecret'], "dyplsapi.aliyuncs.com", array_merge($params, array(
			"RegionId" => "cn-hangzhou",
			"Action" => "UpdateSubscription",
			"Version" => "2017-05-25",
		)));

		return $content;
	}

	/**
	 * 生成签名并发起请求
	 *
	 * @param $accessKeyId string AccessKeyId (https://ak-console.aliyun.com/)
	 * @param $accessKeySecret string AccessKeySecret
	 * @param $domain string API接口所在域名
	 * @param $params array API具体参数
	 * @param $security boolean 使用https
	 * @return bool|\stdClass 返回API接口调用结果，当发生错误时返回false
	 */
	static function request($accessKeyId, $accessKeySecret, $domain, $params, $security = false) {
		$apiParams = array_merge(array(
			"SignatureMethod" => "HMAC-SHA1",
			"SignatureNonce" => uniqid(mt_rand(0, 0xffff), true),
			"SignatureVersion" => "1.0",
			"AccessKeyId" => $accessKeyId,
			"Timestamp" => gmdate("Y-m-d\TH:i:s\Z"),
			"Format" => "JSON",
		), $params);
		ksort($apiParams);

		$sortedQueryStringTmp = "";
		foreach ($apiParams as $key => $value) {
			$sortedQueryStringTmp .= "&" . self::encode($key) . "=" . self::encode($value);
		}

		$stringToSign = "GET&%2F&" . self::encode(substr($sortedQueryStringTmp, 1));

		$sign = base64_encode(hash_hmac("sha1", $stringToSign, $accessKeySecret . "&", true));

		$signature = self::encode($sign);

		$url = ($security ? 'https' : 'http') . "://{$domain}/?Signature={$signature}{$sortedQueryStringTmp}";

		try {
			$content = self::fetchContent($url);
			return json_decode($content, TRUE);
		} catch( \Exception $e) {
			return false;
		}
	}

	static function encode($str) {
		$res = urlencode($str);
		$res = preg_replace("/\+/", "%20", $res);
		$res = preg_replace("/\*/", "%2A", $res);
		$res = preg_replace("/%7E/", "~", $res);
		return $res;
	}

	static function fetchContent($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("x-sdk-client" => "php/2.0.0"));

		if (substr($url, 0, 5) == 'https') {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		$rtn = curl_exec($ch);

		if ($rtn === false) {
			trigger_error("[CURL_" . curl_errno($ch) . "]: " . curl_error($ch), E_USER_ERROR);
		}
		curl_close($ch);

		return $rtn;
	}

}
