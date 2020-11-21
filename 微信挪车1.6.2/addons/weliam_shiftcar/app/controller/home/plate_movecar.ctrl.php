<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '呼叫车主挪车 - '.$_W['wlsetting']['base']['name'] : '呼叫车主挪车';
wl_load()->model('api');
wl_load()->model('notice');

$city = explode(',', $_W['wlsetting']['base']['abbre']);
$city1 = !empty($city[0]) ? $city[0] : '京';
$city2 = !empty($city[1]) ? strtoupper($city[1]) : 'A';
$advs = newadv::get_adv(2);

if($_W['ispost']){
	$plate1 = trim($_GPC['plate1']);
	$plate2 = trim($_GPC['plate2']);
	$plate_number = strtoupper($_GPC['plate_number']);
	if(empty($plate_number)){
		die(json_encode(array("result" => 2,"msg" => '车牌号为空，请重新输入！')));
	}
	
	$carmember = pdo_get('weliam_shiftcar_member',array('uniacid' => $_W['uniacid'],'plate1' => $plate1,'plate2' => $plate2,'plate_number' => $plate_number));
	$carcard = $plate1.$plate2.$plate_number;
	
	if(empty($carmember)){
		die(json_encode(array("result" => 2,"msg" => '未找到车主，请检查车牌号是否正确！')));
	}
	if(!empty($_GPC['inputcode'])){
		$session = json_decode(base64_decode($_GPC['__auth_session']), true);
		if(is_array($session)) {
			if($session['mobile'] != trim($_GPC['mobile'])){
				die(json_encode(array("result" => 2,'msg' => '手机号码不匹配')));
			}
			if($session['code'] != trim($_GPC['inputcode'])){
				die(json_encode(array("result" => 2,'msg' => '验证码错误，请重试')));
			}
		}else{
			die(json_encode(array("result" => 2,'msg' => '验证码已过期，请重新发送')));	
		}
		pdo_update('weliam_shiftcar_member', array('mobile' => trim($_GPC['mobile'])), array('id' => $_W['mid']));
	}
	//判断是否为自己
	if($carmember['id'] == $_W['wlmember']['id']){
		die(json_encode(array("result" => 2,"msg" => '调皮，你是要自己通知自己挪车吗？')));
	}
	//挪车状态判断
	if($carmember['mstatus'] != 1){
		die(json_encode(array("result" => 2,"msg" => '抱歉，车主已关闭挪车，无法发起挪车通知！')));
	}
	//防骚扰设置判断
	if($carmember['harrystatus'] == 1){
		if($carmember['harrytime1'] > $carmember['harrytime2']){
			if(date("H") >= $carmember['harrytime1'] || date("H") <= $carmember['harrytime2']){
				die(json_encode(array("result" => 2,"msg" => '抱歉，在防骚扰期间，无法发起挪车通知！')));
			}
		}else{
			if(date("H") >= $carmember['harrytime1'] && date("H") <= $carmember['harrytime2']){
				die(json_encode(array("result" => 2,"msg" => '抱歉，在防骚扰期间，无法发起挪车通知！')));
			}
		}
	}
	//判断通知方式
	if($_GPC['mtype'] == 1){
		//挪车通知间隔判断
		$intervaltime = !empty($_W['wlsetting']['notice']['intervaltime']) ? $_W['wlsetting']['notice']['intervaltime'] : 10;
		$notice_record = pdo_get('weliam_shiftcar_record',array('sendmid' => $_W['mid'],'takemid' => $carmember['id'],'createtime >' => time()-60*$intervaltime),'id');
		if($notice_record){
			die(json_encode(array("result" => 2,"msg" => '车主正快马加鞭，请勿重复发送通知哦！')));
		}
		//每天挪车次数判断
		if(!empty($_W['wlsetting']['notice']['noticetimes'])){
			$today = strtotime(date('Ymd'));
			$notice_times = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_record') . " WHERE uniacid = '{$_W['uniacid']}' and createtime >= {$today} and sendmid = {$_W['mid']}");
			if($notice_times >= $_W['wlsetting']['notice']['noticetimes']){
				die(json_encode(array("result" => 2,"msg" => '您今天发起过多的挪车通知，请明日再试！')));
			}
		}
		if($_W['wlsetting']['notice']['noticetype'] == 1 && empty($notice_record)){
			$re = send_smsnotice($carmember['mobile'],trim($_GPC['mobile']),$carmember['id']);
		}elseif($_W['wlsetting']['notice']['noticetype'] == 2 && empty($notice_record)){
			$re = send_landingcall($carmember['mobile'],trim($_GPC['mobile']),$carmember['id']);
		}else{
			$re = send_smsnotice($carmember['mobile'],trim($_GPC['mobile']),$carmember['id']);
			$re = send_landingcall($carmember['mobile'],trim($_GPC['mobile']),$carmember['id']);
		}
	}else{
		$record = pdo_get('weliam_shiftcar_bindrecord', array('uniacid' => $_W['uniacid'], 'phonea' => $carmember['mobile'], 'phoneb' => trim($_GPC['mobile']), 'expiration >' => time()));
		if ($record) {
			die(json_encode(array("result" => 1,'mtype' => 2, 'tel' => $record['secretno'])));
		}
		$re = send_callback($carmember['mobile'],trim($_GPC['mobile']),$carmember['id']);
	}
	
	if($re['result'] == 1){
		$data = array(
			'uniacid' => $_W['uniacid'],
			'sendmid' => $_W['mid'],
			'takemid' => $carmember['id'],
			'longitude' => $_COOKIE["longitude"],
			'latitude' => $_COOKIE["latitude"],
			'location' => trim($_GPC['nowlocation']),
			'createtime' => time()
		);
		pdo_insert('weliam_shiftcar_record',$data);
		$recordid = pdo_insertid();
		movecar_notice($carmember['openid'],$recordid);
		movecarsch_notice($_W['wlmember']['openid'],$carcard,$recordid);
		if($_GPC['mtype'] == 1){
			die(json_encode(array("result" => 1,'mtype' => 1)));
		}else{
			die(json_encode(array("result" => 1,'mtype' => 2, 'tel' => $re['tel'])));
		}
		
	}
	die(json_encode(array("result" => 2,"msg" => '通知发送失败，请稍后再试！')));
}
include wl_template('home/plate_movecar');
