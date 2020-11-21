<?php
defined('IN_IA') or exit('Access Denied');

function send_authmsg($mobile){
	global $_W;
	$code = rand(1000, 9999);
	$title = !empty($_W['wlsetting']['base']['name']) ? $_W['wlsetting']['base']['name'] : '微信挪车';
	if($_W['wlsetting']['api']['jtatus'] == 1){
		$qm = !empty($_W['wlsetting']['api']['dy_qm']) ? $_W['wlsetting']['api']['dy_qm'] : '身份验证';
		m('topclient')->appkey = $_W['wlsetting']['api']['dx_appid'];
		m('topclient')->secretKey = $_W['wlsetting']['api']['dx_secretkey'];
		m('smsnum')->setExtend($code);
		m('smsnum')->setSmsType("normal");
		m('smsnum')->setSmsFreeSignName($qm);
		if($_W['wlsetting']['sms']['status'] == 2 && !empty($_W['wlsetting']['sms']['dy_sf'])){
			$sms_tpl = pdo_get('weliam_shiftcar_smstpl',array('id' => $_W['wlsetting']['sms']['dy_sf']),array('smstplid','data'));
			$data = unserialize($sms_tpl['data']);
			$datas = array(
				array('name' => '验证码', 'value' => $code),
				array('name' => '系统版权', 'value' => $_W['wlsetting']['base']['copyright']),
				array('name' => '系统名称', 'value' => $title)
			);
			foreach ($data as $d) {
				$param[$d['data_temp']] = replaceTemplate($d['data_shop'], $datas);
			}
			m('smsnum')->setSmsParam(json_encode($param));
			m('smsnum')->setSmsTemplateCode($sms_tpl['smstplid']);
		}else{
			m('smsnum')->setSmsParam('{"code":"'.$code.'","product":"'.$title.'"}');
			m('smsnum')->setSmsTemplateCode($_W['wlsetting']['api']['dy_sf']);
		}
		m('smsnum')->setRecNum($mobile);
		$resp = m('topclient')->execute(m('smsnum'),'6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805');
		$res = object_array($resp);
		if($res['result']['success'] == 1){
			//生成发送记录
			create_apirecord(-1,'',$_W['mid'],$mobile,1,'阿里大于身份验证');
			$cookie = array();
			$cookie['mobile'] = $mobile;
			$cookie['code'] = $code;
			$session = base64_encode(json_encode($cookie));
			isetcookie('__auth_session', $session, 6000, true);
			die(json_encode(array("result" => 1)));	
		}else{
			die(json_encode(array("result" => 2,"msg" => $res['sub_msg'])));
		}
	}elseif($_W['wlsetting']['api']['jtatus'] == 2){
		include_once(WL_CORE . "class/CCPRestSDK.class.php");
		$accountSid = $_W['wlsetting']['api']['yun_accountsid'];
		$accountToken = $_W['wlsetting']['api']['yun_authtoken'];
		$appId = $_W['wlsetting']['api']['yun_appid'];
		$serverIP='app.cloopen.com';
		$serverPort='8883';
		$softVersion='2013-12-26';

	    $rest = new REST($serverIP,$serverPort,$softVersion);
	    $rest->setAccount($accountSid,$accountToken);
	    $rest->setAppId($appId);
		
		if($_W['wlsetting']['sms']['status'] == 2 && !empty($_W['wlsetting']['sms']['dy_sf'])){
			$sms_tpl = pdo_get('weliam_shiftcar_smstpl',array('id' => $_W['wlsetting']['sms']['dy_sf']),array('smstplid','data'));
			$data = unserialize($sms_tpl['data']);
			$datas = array(
				array('name' => '验证码', 'value' => $code),
				array('name' => '系统版权', 'value' => $_W['wlsetting']['base']['copyright']),
				array('name' => '系统名称', 'value' => $title)
			);
			foreach ($data as $d) {
				$param[] = replaceTemplate($d['data_shop'], $datas);
			}
			$result = $rest->sendTemplateSMS($mobile,$param,$sms_tpl['smstplid']);
		}else{
			$result = $rest->sendTemplateSMS($mobile,array($code),$_W['wlsetting']['api']['yun_sf']);
		}
	    
	    if($result == NULL ) {
	        die(json_encode(array("result" => 2)));
	    }
	    if($result->statusCode!=0) {
	        die(json_encode(array("result" => 2)));
	    }else{
			create_apirecord(-1,'',$_W['mid'],$mobile,1,'云通讯身份验证');
			$cookie = array();
			$cookie['mobile'] = $mobile;
			$cookie['code'] = $code;
			$session = base64_encode(json_encode($cookie));
			isetcookie('__auth_session', $session, 600, true);
			die(json_encode(array("result" => 1)));
	    }
	}else{
		$qm = !empty($_W['wlsetting']['api']['aliyun_qm']) ? $_W['wlsetting']['api']['aliyun_qm'] : '身份验证';
		include_once WL_CORE . 'library/aliyun/Config.php';
	    //初始化访问的acsCleint
	    $profile = DefaultProfile::getProfile("cn-hangzhou", $_W['wlsetting']['api']['aliyun_AccessKeyId'], $_W['wlsetting']['api']['aliyun_AccessKeySecret']);
	    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", "Dysmsapi", "dysmsapi.aliyuncs.com");
	    $acsClient= new DefaultAcsClient($profile);
	    
		m('sendsmsrequest')->setSignName($qm);
		if($_W['wlsetting']['sms']['status'] == 2 && !empty($_W['wlsetting']['sms']['dy_sf'])){
			$sms_tpl = pdo_get('weliam_shiftcar_smstpl',array('id' => $_W['wlsetting']['sms']['dy_sf']),array('smstplid','data'));
			$data = unserialize($sms_tpl['data']);
			$datas = array(
				array('name' => '验证码', 'value' => $code),
				array('name' => '系统版权', 'value' => $_W['wlsetting']['base']['copyright']),
				array('name' => '系统名称', 'value' => $title)
			);
			foreach ($data as $d) {
				$param[$d['data_temp']] = replaceTemplate($d['data_shop'], $datas);
			}
			m('sendsmsrequest')->setTemplateParam(json_encode($param));
			m('sendsmsrequest')->setTemplateCode($sms_tpl['smstplid']);
		}else{
			m('sendsmsrequest')->setTemplateParam('{"code":"'.$code.'","product":"'.$title.'"}');
			m('sendsmsrequest')->setTemplateCode($_W['wlsetting']['api']['aliyun_sf']);
		}
		m('sendsmsrequest')->setPhoneNumbers($mobile);
		$resp = $acsClient->getAcsResponse(m('sendsmsrequest'));
		$res = object_array($resp);
		if($res['Code'] == 'OK'){
			//生成发送记录
			create_apirecord(-1,'',$_W['mid'],$mobile,1,'阿里云身份验证');
			$cookie = array();
			$cookie['mobile'] = $mobile;
			$cookie['code'] = $code;
			$session = base64_encode(json_encode($cookie));
			isetcookie('__auth_session', $session, 600, true);
			die(json_encode(array("result" => 1)));	
		}else{
			die(json_encode(array("result" => 2,"msg" => $res['Message'])));
		}
	}
}

function send_smsnotice($mobile,$calltel,$carmember){
	global $_W,$_GPC;
	$title = $_W['wlsetting']['base']['name'];
	if($_W['wlsetting']['api']['jtatus'] == 1){
		m('topclient')->appkey = $_W['wlsetting']['api']['dx_appid'];
		m('topclient')->secretKey = $_W['wlsetting']['api']['dx_secretkey'];
		m('smsnum')->setSmsType("normal");
		m('smsnum')->setSmsFreeSignName($_W['wlsetting']['api']['dy_qm']);
		if($_W['wlsetting']['sms']['status'] == 2 && !empty($_W['wlsetting']['sms']['dy_dx'])){
			$sms_tpl = pdo_get('weliam_shiftcar_smstpl',array('id' => $_W['wlsetting']['sms']['dy_dx']),array('smstplid','data'));
			$data = unserialize($sms_tpl['data']);
			$datas = array(
				array('name' => '挪车人手机号', 'value' => $calltel),
				array('name' => '挪车人昵称', 'value' => $_W['wlmember']['nickname']),
				array('name' => '车主手机号', 'value' => $mobile),
				array('name' => '车主昵称', 'value' => $carmember['nickname']),
				array('name' => '车牌', 'value' => $carmember['plate1'].$carmember['plate2'].$carmember['plate_number']),
				array('name' => '当前位置', 'value' => trim($_GPC['nowlocation'])),
				array('name' => '系统版权', 'value' => $_W['wlsetting']['base']['copyright']),
				array('name' => '系统名称', 'value' => $title)
			);
			foreach ($data as $d) {
				$param[$d['data_temp']] = replaceTemplate($d['data_shop'], $datas);
			}
			m('smsnum')->setSmsParam(json_encode($param));
			m('smsnum')->setSmsTemplateCode($sms_tpl['smstplid']);
		}else{
			m('smsnum')->setSmsParam('{"name":"'.$title.'","tel":"'.$calltel.'"}');
			m('smsnum')->setSmsTemplateCode($_W['wlsetting']['api']['dy_dx']);
		}
		m('smsnum')->setRecNum($mobile);
		$resp = m('topclient')->execute(m('smsnum'),'6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805');
		$res = object_array($resp);
		if($res['result']['success'] == 1){
			create_apirecord($_W['mid'],$calltel,$carmember['id'],$mobile,2,'阿里大于短信通知');
			return array("result" => 1);	
		}else{
		 	die(json_encode(array("result" => 2,"msg" => $res['sub_msg'])));
		}
	}elseif($_W['wlsetting']['api']['jtatus'] == 2){
		include_once(WL_CORE . "class/CCPRestSDK.class.php");
		$accountSid = $_W['wlsetting']['api']['yun_accountsid'];
		$accountToken = $_W['wlsetting']['api']['yun_authtoken'];
		$appId = $_W['wlsetting']['api']['yun_appid'];
		$serverIP='app.cloopen.com';
		$serverPort='8883';
		$softVersion='2013-12-26';

	    $rest = new REST($serverIP,$serverPort,$softVersion);
	    $rest->setAccount($accountSid,$accountToken);
	    $rest->setAppId($appId);
		
		if($_W['wlsetting']['sms']['status'] == 2 && !empty($_W['wlsetting']['sms']['dy_dx'])){
			$sms_tpl = pdo_get('weliam_shiftcar_smstpl',array('id' => $_W['wlsetting']['sms']['dy_dx']),array('smstplid','data'));
			$data = unserialize($sms_tpl['data']);
			$datas = array(
				array('name' => '挪车人手机号', 'value' => $calltel),
				array('name' => '挪车人昵称', 'value' => $_W['wlmember']['nickname']),
				array('name' => '车主手机号', 'value' => $mobile),
				array('name' => '车主昵称', 'value' => $carmember['nickname']),
				array('name' => '车牌', 'value' => $carmember['plate1'].$carmember['plate2'].$carmember['plate_number']),
				array('name' => '当前位置', 'value' => trim($_GPC['nowlocation'])),
				array('name' => '系统版权', 'value' => $_W['wlsetting']['base']['copyright']),
				array('name' => '系统名称', 'value' => $title)
			);
			foreach ($data as $d) {
				$param[] = replaceTemplate($d['data_shop'], $datas);
			}
			die(json_encode(array("result" => 2,"msg" => $param[1])));
	    	$result = $rest->sendTemplateSMS($mobile,$param,$sms_tpl['smstplid']);
		}else{
	    	$result = $rest->sendTemplateSMS($mobile,array($calltel),$_W['wlsetting']['api']['yun_dx']);
		}
		
	    if($result == NULL ) {
	        die(json_encode(array("result" => 2,"msg" => '短信通知发送失败')));
	    }
	    if($result->statusCode!=0) {
	        die(json_encode(array("result" => 2,"msg" => $result->statusCode.$result->statusMsg)));
	    }else{
			create_apirecord($_W['mid'],$calltel,$carmember['id'],$mobile,2,'云通讯短信通知');
			return array("result" => 1);
	    }
	}else{
		include_once WL_CORE . 'library/aliyun/Config.php';
	    //初始化访问的acsCleint
	    $profile = DefaultProfile::getProfile("cn-hangzhou", $_W['wlsetting']['api']['aliyun_AccessKeyId'], $_W['wlsetting']['api']['aliyun_AccessKeySecret']);
	    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", "Dysmsapi", "dysmsapi.aliyuncs.com");
	    $acsClient= new DefaultAcsClient($profile);

		m('sendsmsrequest')->setSignName($_W['wlsetting']['api']['aliyun_qm']);
		if($_W['wlsetting']['sms']['status'] == 2 && !empty($_W['wlsetting']['sms']['dy_dx'])){
			$sms_tpl = pdo_get('weliam_shiftcar_smstpl',array('id' => $_W['wlsetting']['sms']['dy_dx']),array('smstplid','data'));
			$data = unserialize($sms_tpl['data']);
			$datas = array(
				array('name' => '挪车人手机号', 'value' => $calltel),
				array('name' => '挪车人昵称', 'value' => $_W['wlmember']['nickname']),
				array('name' => '车主手机号', 'value' => $mobile),
				array('name' => '车主昵称', 'value' => $carmember['nickname']),
				array('name' => '车牌', 'value' => $carmember['plate1'].$carmember['plate2'].$carmember['plate_number']),
				array('name' => '当前位置', 'value' => trim($_GPC['nowlocation'])),
				array('name' => '系统版权', 'value' => $_W['wlsetting']['base']['copyright']),
				array('name' => '系统名称', 'value' => $title)
			);
			foreach ($data as $d) {
				$param[$d['data_temp']] = replaceTemplate($d['data_shop'], $datas);
			}
			m('sendsmsrequest')->setTemplateParam(json_encode($param));
			m('sendsmsrequest')->setTemplateCode($sms_tpl['smstplid']);
		}else{
			m('sendsmsrequest')->setTemplateParam('{"name":"'.$title.'"}');
			m('sendsmsrequest')->setTemplateCode($_W['wlsetting']['api']['aliyun_dx']);
		}
		m('sendsmsrequest')->setPhoneNumbers($mobile);
		$resp = $acsClient->getAcsResponse(m('sendsmsrequest'));
		$res = object_array($resp);
		if($res['Code'] == 'OK'){
			create_apirecord($_W['mid'],$calltel,$carmember['id'],$mobile,2,'阿里云短信通知');
			return array("result" => 1);	
		}else{
		 	die(json_encode(array("result" => 2,"msg" => $res['Message'])));
		}
	}
}

function send_landingcall($mobile,$calltel,$carmember){
	global $_W,$_GPC;
	$title = !empty($_W['wlsetting']['base']['name']) ? $_W['wlsetting']['base']['name'] : '微信挪车';
	if($_W['wlsetting']['api']['ytatus'] == 3){
		include_once(WL_CORE . "class/235httpUtil.php");
		$ACCOUNT_SID = $_W['wlsetting']['api']['253yun_accountsid']; // 主账户SID
		$AUTH_TOKEN = $_W['wlsetting']['api']['253yun_authtoken']; // 主账号TOKEN
		$appId = $_W['wlsetting']['api']['253yun_appid'];//应用唯一标识(必须为已上线APPID或测试应用APPID)
		$funAndOperate = "Calls/voiceNotify?";
		// 参数详述请参考
		$content = !empty($_W['wlsetting']['api']['253yun_yywb']) ? $_W['wlsetting']['api']['253yun_yywb'] : '您的爱车挡住了他人车辆，请您挪动一下，谢谢！';//文本内容（必填）
		$to = $mobile;//被叫电话号码（必填）
		$type = 0;//0：文本（必填）
		$toSerNum = $_W['wlsetting']['api']['253yun_shownum'];//被叫显示号码（选填）
		$playTimes = "2";//循环播放的次数（选填）
		$body = "{\"voiceNotify\": {\"appId\":\"" . $appId . "\",\"content\":\"" . $content . "\",\"to\":\"". $to . "\",\"type\":\"" . $type ."\",\"playTimes\":\"" . $playTimes . "\",\"toSerNum\":\"" . $toSerNum . "\"}}";
		// 提交请求
		$result = callbackpost($funAndOperate, $ACCOUNT_SID, $AUTH_TOKEN, $body);
		$result = json_decode($result);
		if($result->result->respCode != '00000') {
	        die(json_encode(array("result" => 2,"msg" => $result->result->respCode.'语音通知发送失败')));
	    } else {
	        create_apirecord($_W['mid'],$calltel,$carmember['id'],$mobile,3,'253云通讯语音通知');
            return array("result" => 1);
	    }
	}elseif($_W['wlsetting']['api']['ytatus'] == 2){
        include_once(WL_CORE . "class/CCPRestSDK.class.php");
		$accountSid = $_W['wlsetting']['api']['yun_accountsid'];
		$accountToken = $_W['wlsetting']['api']['yun_authtoken'];
		$appId = $_W['wlsetting']['api']['yun_appid'];
		$serverIP='app.cloopen.com';
		$serverPort='8883';
		$softVersion='2013-12-26';
		
		if(!empty($_W['wlsetting']['api']['yun_hm'])){
			$displayNum = $_W['wlsetting']['api']['yun_hm'];
		}
	    // 初始化REST SDK
	    $rest = new REST($serverIP,$serverPort,$softVersion);
	    $rest->setAccount($accountSid,$accountToken);
	    $rest->setAppId($appId);
	    
	    //调用外呼通知接口
	    $result = $rest->landingCall($mobile,'nuoche.wav',$mediaTxt,$displayNum,2,$respUrl,$userData,$maxCallTime,$speed,$volume,$pitch,$bgsound);
	    if($result == NULL ) {
	        die(json_encode(array("result" => 2,"msg" => '语音通知发送失败')));
	    }
	    if($result->statusCode!=0) {
	    	die(json_encode(array("result" => 2,"msg" => $result->statusCode.$result->statusMsg)));
	    } else{
	        create_apirecord($_W['mid'],$calltel,$carmember['id'],$mobile,3,'云通讯语音通知');
            return array("result" => 1);
	    }  
	}elseif($_W['wlsetting']['api']['ytatus'] == 1){
		m('topclient')->appkey = $_W['wlsetting']['api']['dx_appid'];
		m('topclient')->secretKey = $_W['wlsetting']['api']['dx_secretkey'];
        m('singlecall')->setCalledNum($mobile);
        m('singlecall')->setCalledShowNum($_W['wlsetting']['api']['dy_yynum']);
		if($_W['wlsetting']['sms']['status'] == 2 && !empty($_W['wlsetting']['sms']['dy_yy'])){
			$sms_tpl = pdo_get('weliam_shiftcar_smstpl',array('id' => $_W['wlsetting']['sms']['dy_yy']),array('smstplid','data'));
			$data = unserialize($sms_tpl['data']);
			$datas = array(
				array('name' => '挪车人手机号', 'value' => $calltel),
				array('name' => '挪车人昵称', 'value' => $_W['wlmember']['nickname']),
				array('name' => '车主手机号', 'value' => $mobile),
				array('name' => '车主昵称', 'value' => $carmember['nickname']),
				array('name' => '车牌', 'value' => $carmember['plate1'].$carmember['plate2'].$carmember['plate_number']),
				array('name' => '当前位置', 'value' => trim($_GPC['nowlocation'])),
				array('name' => '系统版权', 'value' => $_W['wlsetting']['base']['copyright']),
				array('name' => '系统名称', 'value' => $title)
			);
			foreach ($data as $d) {
				$param[$d['data_temp']] = replaceTemplate($d['data_shop'], $datas);
			}
			m('singlecall')->setTtsParam(json_encode($param));
			m('singlecall')->setTtsCode($sms_tpl['smstplid']);
		}else{
			m('singlecall')->setTtsCode($_W['wlsetting']['api']['dy_yy']);
        	m('singlecall')->setTtsParam('{"name":"'.$title.'","mobile":"'.$calltel.'"}');
		}
        $resp = m('topclient')->execute(m('singlecall') , "6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805");
        $res = object_array($resp);
        if ($res['result']['success'] == 1) {
        	create_apirecord($_W['mid'],$calltel,$carmember['id'],$mobile,3,'阿里大于语音通知');
            return array("result" => 1);
        } else {
            die(json_encode(array("result" => 2,"msg" => $res['sub_msg'])));
        }
	}else{
		include_once WL_CORE . 'library/aliyun/Config.php';
	    //初始化访问的acsCleint
	    $profile = DefaultProfile::getProfile("cn-hangzhou", $_W['wlsetting']['api']['aliyun_AccessKeyId'], $_W['wlsetting']['api']['aliyun_AccessKeySecret']);
	    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", "Dyvmsapi", "dyvmsapi.aliyuncs.com");
	    $acsClient= new DefaultAcsClient($profile);
		
        m('singlecallbyttsrequest')->setCalledNumber($mobile);
        m('singlecallbyttsrequest')->setCalledShowNumber($_W['wlsetting']['api']['aliyun_yynum']);
		if($_W['wlsetting']['sms']['status'] == 2 && !empty($_W['wlsetting']['sms']['dy_yy'])){
			$sms_tpl = pdo_get('weliam_shiftcar_smstpl',array('id' => $_W['wlsetting']['sms']['dy_yy']),array('smstplid','data'));
			$data = unserialize($sms_tpl['data']);
			$datas = array(
				array('name' => '挪车人手机号', 'value' => $calltel),
				array('name' => '挪车人昵称', 'value' => $_W['wlmember']['nickname']),
				array('name' => '车主手机号', 'value' => $mobile),
				array('name' => '车主昵称', 'value' => $carmember['nickname']),
				array('name' => '车牌', 'value' => $carmember['plate1'].$carmember['plate2'].$carmember['plate_number']),
				array('name' => '当前位置', 'value' => trim($_GPC['nowlocation'])),
				array('name' => '系统版权', 'value' => $_W['wlsetting']['base']['copyright']),
				array('name' => '系统名称', 'value' => $title)
			);
			foreach ($data as $d) {
				$param[$d['data_temp']] = replaceTemplate($d['data_shop'], $datas);
			}
			m('singlecallbyttsrequest')->setTtsParam(json_encode($param));
			m('singlecallbyttsrequest')->setTtsCode($sms_tpl['smstplid']);
		}else{
			m('singlecallbyttsrequest')->setTtsCode($_W['wlsetting']['api']['aliyun_yy']);
        	m('singlecallbyttsrequest')->setTtsParam('{"name":"'.$title.'"}');
		}
       	$resp = $acsClient->getAcsResponse(m('singlecallbyttsrequest'));
        $res = object_array($resp);
        if ($res['Code'] == 'OK') {
        	create_apirecord($_W['mid'],$calltel,$carmember['id'],$mobile,3,'阿里云语音通知');
            return array("result" => 1);
        } else {
            die(json_encode(array("result" => 2,"msg" => $res['Message'])));
        }
	}
}

function send_callback($mobile,$calltel,$takemid){
	global $_W;
	if($_W['wlsetting']['api']['btatus'] == 1 || $_W['wlsetting']['api']['btatus'] == 4){
		$result = dypls::bindmobile($mobile, $calltel);
		if ($result) {
			create_apirecord($_W['mid'],$calltel,$takemid,$mobile,4,'阿里云号码隐私保护');
	        return array("result" => 1, 'tel' => $result['secretno']);
		}
	}elseif($_W['wlsetting']['api']['btatus'] == 2){
		include_once(WL_CORE . "class/CCPRestSDK.class.php");
		$accountSid = $_W['wlsetting']['api']['yun_accountsid'];
		$accountToken = $_W['wlsetting']['api']['yun_authtoken'];
		$appId = $_W['wlsetting']['api']['yun_appid'];
		$serverIP ='sandboxapp.cloopen.com';
		$serverPort ='8883';
		$softVersion ='2013-12-26';
		
		$rest = new REST($serverIP,$serverPort,$softVersion);
	    $rest->setSubAccount($_W['wlsetting']['api']['SubAccountSid'],$_W['wlsetting']['api']['SubAccountToken'],$_W['wlsetting']['api']['VoIPAccount'],$_W['wlsetting']['api']['VoIPPassword']);
	    $rest->setAppId($appId);
	
	    $result = $rest->callBack($calltel,$mobile,$customerSerNum,$fromSerNum,$promptTone,$alwaysPlay,$terminalDtmf,$userData,$maxCallTime,$hangupCdrUrl,$needBothCdr,$needRecord,$countDownTime,$countDownPrompt);
	    if($result == NULL ) {
	        die(json_encode(array("result" => 2,"msg" => '电话互通发起失败')));
	    }
	    if($result->statusCode!=0) {
	        die(json_encode(array("result" => 2,"msg" => $result->statusCode.$result->statusMsg)));
	    } else {
	        create_apirecord($_W['mid'],$calltel,$takemid,$mobile,4,'云通讯电话回拨');
	        return array("result" => 1);
	    }
	}else{
		include_once(WL_CORE . "class/235httpUtil.php");
		$ACCOUNT_SID = $_W['wlsetting']['api']['253yun_accountsid']; // 主账户SID
		$AUTH_TOKEN = $_W['wlsetting']['api']['253yun_authtoken']; // 主账号TOKEN
		$appId = $_W['wlsetting']['api']['253yun_appid'];//应用唯一标识(必须为已上线APPID或测试应用APPID)
		$funAndOperate = "call/callBack?";
		$caller = $calltel;//主叫电话号码(必填)
		// $clientNumber = "77186767571170"; //子账号（必填）
		//其中$clientNumber与$caller必须设置其中一个！！！
		$called = $mobile;//被叫电话号码（必填）
		$fromSerNum = $_W['wlsetting']['api']['253yun_fromSerNum'];//主叫侧显示的号码（选填）
		$toSerNum = $_W['wlsetting']['api']['253yun_toSerNum'];//被叫侧显示的号码（选填）
		$body = "{ \"callback\" : { \"appId\" : \"" . $appId . "\", \"caller\" : \"" . $caller . "\", \"called\" : \"". $called . "\", \"fromSerNum\" : \"" . $fromSerNum . "\", \"toSerNum\" : \"" . $toSerNum . "\"}}";
		$result = callbackpost($funAndOperate, $ACCOUNT_SID, $AUTH_TOKEN, $body);
		$result = json_decode($result);
		if($result->result->respCode != '00000') {
	        die(json_encode(array("result" => 2,"msg" => $result->result->respCode)));
	    } else {
	        create_apirecord($_W['mid'],$calltel,$takemid,$mobile,4,'253云通讯语音双呼接口');
	        return array("result" => 1);
	    }
	}
}

function create_apirecord($sendmid,$sendmobile = '',$takemid,$takemobile,$type,$remark){
	global $_W;
	$data = array(
		'uniacid' => $_W['uniacid'],
		'sendmid' => $sendmid,
		'sendmobile' => $sendmobile,
		'takemid' => $takemid,
		'takemobile' => $takemobile,
		'type' => $type,
		'remark' => $remark,
		'createtime' => time()
	);
	pdo_insert('weliam_shiftcar_apirecord',$data);
}

function replaceTemplate($str, $datas = array()){
	foreach ($datas as $d) {
		$str = str_replace('【' . $d['name'] . '】', $d['value'], $str);
	}
	return $str;
}