<?php 
	
class api 
{
	//违章提醒发送短信
	static function send_sys_sms($carmember,$controller,$message,$data){
		global $_W;
		$getlistFrames = 'get_'.$controller.'_param';
		$param = self::$getlistFrames($carmember,$data);
		if($param['type'] == 'ytx'){
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
			
		    $result = $rest->sendTemplateSMS($carmember['mobile'],array_values($param['data']),$param['code']);
		    if($result == NULL ) {
		        die(json_encode(array("result" => 2,"msg" => '短信通知发送失败')));
		    }
		    if($result->statusCode!=0) {
		        die(json_encode(array("result" => 2,"msg" => $result->statusCode.$result->statusMsg)));
		    }else{
				self::create_apirecord(-1,'',$carmember['id'],$carmember['mobile'],2,$message);
				return array("result" => 1);
		    }
		}else{
			$title = !empty($_W['wlsetting']['api']['dy_qm']) ? $_W['wlsetting']['api']['dy_qm'] : $_W['wlsetting']['base']['name'];
			m('topclient')->appkey = $_W['wlsetting']['api']['dx_appid'];
			m('topclient')->secretKey = $_W['wlsetting']['api']['dx_secretkey'];
			m('smsnum')->setSmsType("normal");
			m('smsnum')->setSmsFreeSignName($title);
			m('smsnum')->setSmsParam(json_encode($param['data']));
			m('smsnum')->setRecNum($carmember['mobile']);
			m('smsnum')->setSmsTemplateCode($param['code']);
			$resp = m('topclient')->execute(m('smsnum'),'6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805');
			$res = object_array($resp);
			if($res['result']['success'] == 1){
				self::create_apirecord(-1,'',$carmember['id'],$carmember['mobile'],2,$message);
				return array("result" => 1);	
			}else{
			 	die(json_encode(array("result" => 2,"msg" => $res['sub_msg'])));
			}
		}
	}
	
	//违章提醒发送语音
	static function send_yy_sms($carmember,$controller,$message,$data){
		global $_W;
		$getlistFrames = 'get_'.$controller.'_param';
		$param = self::$getlistFrames($carmember,$data,2);
		m('topclient')->appkey = $_W['wlsetting']['api']['dx_appid'];
		m('topclient')->secretKey = $_W['wlsetting']['api']['dx_secretkey'];
        m('singlecall')->setCalledNum($carmember['mobile']);
        m('singlecall')->setCalledShowNum($_W['wlsetting']['api']['dy_yynum']);
		m('singlecall')->setTtsParam(json_encode($param['data']));
		m('singlecall')->setTtsCode($param['code']);
        $resp = m('topclient')->execute(m('singlecall') , "6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805");
        $res = object_array($resp);
        if ($res['result']['success'] == 1) {
        	self::create_apirecord(-1,'',$carmember['id'],$carmember['mobile'],3,$message);
            return array("result" => 1);
        } else {
            die(json_encode(array("result" => 2,"msg" => $res['sub_msg'])));
        }
	}
	
	static function create_apirecord($sendmid,$sendmobile = '',$takemid,$takemobile,$type,$remark){
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
	
	static function get_pecc_param($carmember,$pecc,$type = 1){
		global $_W;
		if($type == 1){
			$sms_tpl = pdo_get('weliam_shiftcar_smstpl',array('id' => $_W['wlsetting']['pecc']['dx_tz']),array('smstplid','data','type'));
		}else{
			$sms_tpl = pdo_get('weliam_shiftcar_smstpl',array('id' => $_W['wlsetting']['pecc']['yy_tz']),array('smstplid','data','type'));
		}
		$data = unserialize($sms_tpl['data']);
		$datas = array(
			array('name' => '违章时间', 'value' => date("Y-m-d H:i:s",$pecc['acttime'])),
			array('name' => '违章地点', 'value' => $pecc['address']),
			array('name' => '违章内容', 'value' => $pecc['info']),
			array('name' => '扣分', 'value' => $pecc['fen']),
			array('name' => '罚款', 'value' => $pecc['money']),
			array('name' => '车主手机号', 'value' => $carmember['mobile']),
			array('name' => '车主昵称', 'value' => $carmember['nickname']),
			array('name' => '车牌', 'value' => $pecc['hphm']),
			array('name' => '系统版权', 'value' => $_W['wlsetting']['base']['copyright']),
			array('name' => '系统名称', 'value' => $_W['wlsetting']['base']['name'])
		);
		foreach ($data as $d) {
			$param[$d['data_temp']] = self::replaceTemplate($d['data_shop'], $datas);
		}
		
		return array('data' => $param,'code' => $sms_tpl['smstplid'],'type' => $sms_tpl['type']);
	}
	
	
	static function replaceTemplate($str, $datas = array()){
		foreach ($datas as $d) {
			$str = str_replace('【' . $d['name'] . '】', $d['value'], $str);
		}
		return $str;
	}
}
?>