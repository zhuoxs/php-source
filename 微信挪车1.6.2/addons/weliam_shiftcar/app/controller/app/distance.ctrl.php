<?php 
defined('IN_IA') or exit('Access Denied');
$ops = array('display','post','recharge','repost','consume','conpost','cardlist','re_record','platform','memberlist');
$op = in_array($op, $ops) ? $op : 'display';

if ($op == 'display') {
	$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '发送消息 - '.$_W['wlsetting']['base']['name'] : '发送消息';
	$userid = intval($_GPC['userid']);
	$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']), 'id');
	$mis = pdo_getcolumn('wlmerchant_merchantuser',array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'status'=>2,'enabled'=>1),'storeid');
	if(empty($mis)) wl_message('抱歉你没有发送消息的权限','close');
	$remark_arr = pdo_fetchall('SELECT distinct content FROM ' . tablename('wlmerchant_store_notice') . "WHERE uniacid = {$_W['uniacid']} and sid = {$mis} ");
	include wl_template('app/distance');
}
if ($op == 'post') {
	$userid = intval($_GPC['userid']);
	$sid = intval($_GPC['sid']);
	$sendcontent = $_GPC['sendcontent'];
	if(empty($userid) || empty($sid) || empty($sendcontent)){
		die(json_encode(array("result" => 2,'msg' => '缺少重要参数，请重新扫描车主二维码')));
	}
	
	//判断发送次数是否超过限制
	$openid = pdo_get('weliam_shiftcar_member', array('id' => $userid), array('openid','mobile'));
	$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$openid['openid']), 'id');
	if(empty($mid)) {
		wl_merge_member($openid);
		$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$openid['openid']), 'id');
	}
	$today = strtotime(date('Y-m-d'));
	$yestaday = strtotime(date('Y-m-d',strtotime('+1 day')));
	$sendtime = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('wlmerchant_store_notice') . " WHERE uniacid = '{$_W['uniacid']}' and sid = '{$sid}' and mid = {$mid} and createtime >= {$today} and createtime < {$yestaday}");
    $m_send = $_W['wlsetting']['merchant']['sendtimes'];
	if(($sendtime >= $m_send && !empty($m_send)) || ($sendtime >= 2 && empty($m_send))){
		die(json_encode(array("result" => 2,'msg' => '超过发送限制，无法发送')));
	}
	
	//发送模板消息并记录
	wl_load()->model('notice');
	sendstore_notice($openid['openid'],$sid,$sendcontent);
	pdo_insert('wlmerchant_store_notice',array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'sid'=>$sid,'createtime'=>time(),'status'=>1,'content'=>$sendcontent));
	die(json_encode(array("result" => 1)));
}

if($op == 'recharge'){
	$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '车主充值 - '.$_W['wlsetting']['base']['name'] : '车主充值';
	$userid = intval($_GPC['userid']);
	$carmember = pdo_get('weliam_shiftcar_member', array('id' => $userid), array('openid','mobile'));
	$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']), 'id');
	$mis = pdo_getcolumn('wlmerchant_merchantuser',array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'status'=>2,'enabled'=>1),'storeid');
	if(empty($mis)) wl_message('抱歉你没有给车主充值的权限','close');
	$storename = pdo_getcolumn('wlmerchant_merchantdata',array('uniacid'=>$_W['uniacid'],'id'=>$mis),'storename');
	include wl_template('app/distance_recharge');
}

if($op == 'repost'){
	$userid = intval($_GPC['userid']);
	$sid = intval($_GPC['sid']);
	$mid = intval($_GPC['mid']);
	$retype = intval($_GPC['retype']);
	$sendcontent = $_GPC['sendcontent'];
	if(empty($userid) || empty($sid) || empty($sendcontent) || empty($retype) || empty($mid)){
		die(json_encode(array("result" => 2,'msg' => '缺少重要参数，请重新扫描车主二维码')));
	}
	$card = membercard::get_cardid($userid, $sid);
	$restatus = membercard::recharge($retype, $sendcontent, $card, $mid, $sid, $userid);
	if($restatus){
		die(json_encode(array("result" => 1)));
	}else{
		die(json_encode(array("result" => 2,'msg' => '充值失败，请重试')));
	}
}

if($op == 'consume'){
	$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '核销车主消费 - '.$_W['wlsetting']['base']['name'] : '核销车主消费';
	$userid = intval($_GPC['userid']);
	$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']), 'id');
	$mis = pdo_getcolumn('wlmerchant_merchantuser',array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'status'=>2,'enabled'=>1),'storeid');
	if(empty($mis)) wl_message('抱歉你没有给车主充值的权限','close');
	$mccard = pdo_get('weliam_shiftcar_membercard', array('uniacid'=>$_W['uniacid'],'mid'=>$userid,'sid'=>$mis));
	if(empty($mccard)) wl_message('抱歉车主还没有本店会员卡，无法核销','close');
	$carmember = pdo_get('weliam_shiftcar_member', array('id' => $userid), array('openid','mobile'));
	$storename = pdo_getcolumn('wlmerchant_merchantdata',array('uniacid'=>$_W['uniacid'],'id'=>$mis),'storename');
	include wl_template('app/distance_consume');
}

if($op == 'conpost'){
	$userid = intval($_GPC['userid']);
	$sid = intval($_GPC['sid']);
	$mid = intval($_GPC['mid']);
	$retype = intval($_GPC['retype']);
	$sendcontent = $_GPC['sendcontent'];
	$jifennum = $_GPC['jifennum'];
	if(empty($userid) || empty($sid) || empty($sendcontent) || empty($retype) || empty($mid)){
		die(json_encode(array("result" => 2,'msg' => '缺少重要参数，请重新扫描车主二维码')));
	}
	$card = membercard::get_cardid($userid, $sid);
	if($retype == 1 && $card['credit2'] < $sendcontent){
		die(json_encode(array("result" => 2,'msg' => '车主余额不足，无法核销')));
	}
	if($retype == 2 && $card['times'] < $sendcontent){
		die(json_encode(array("result" => 2,'msg' => '车主次数不足，无法核销')));
	}
	
	$restatus = membercard::consume($retype, $sendcontent, $card, $mid, $sid, $userid, $jifennum);
	if($restatus){
		die(json_encode(array("result" => 1)));
	}else{
		die(json_encode(array("result" => 2,'msg' => '核销失败，请重试')));
	}
}

if($op == 'cardlist'){
	$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '会员卡列表 - '.$_W['wlsetting']['base']['name'] : '会员卡列表';
	$cardlist = pdo_getall('weliam_shiftcar_membercard',array('uniacid'=>$_W['uniacid'],'mid'=>$_W['mid']));
	foreach ($cardlist as $key => &$value) {
		$store = pdo_get('wlmerchant_merchantdata',array('uniacid'=>$_W['uniacid'],'id'=>$value['sid']),array('storename','logo'));
		$value['storename'] = $store['storename'];
		$value['logo'] = tomedia($store['logo']);
	}
	include wl_template('app/distance_cardlist');
}

if($op == 're_record'){
	$type = !empty($_GPC['type']) ? intval($_GPC['type']) : 1;
	if($type == 1){
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '充值记录 - '.$_W['wlsetting']['base']['name'] : '充值记录';
	}else{
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '消费记录 - '.$_W['wlsetting']['base']['name'] : '消费记录';
	}
	
	$sid = intval($_GPC['sid']);
	if(empty($sid)) wl_message('缺少重要参数','close');
	$selcet = array('uniacid'=>$_W['uniacid'],'sid'=>$sid,'model'=>$type,'type'=>array('1','2'));
	if($_GPC['time'] == 'week'){
		$week = time() - 7*24*60*60;
		$selcet['createtime >'] = $week;
	}elseif($_GPC['time'] == 'today'){
		$today = strtotime(date('Y-m-d', time()));
		$selcet['createtime >'] = $today;
	}
	
	$records = pdo_getall('weliam_shiftcar_mcrecord',$selcet, array() , '' , 'id DESC');
	foreach ($records as $key => &$value) {
		$value['createtime'] = date("Y-m-d H:i:s",$value['createtime']);
		$value['nickname'] = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'id'=>$value['remid']), 'nickname');
		$carmember = pdo_get('weliam_shiftcar_member', array('id' => $value['mid']), array('openid','mobile','plate1','plate2','plate_number'));
		$value['carmemeber'] = $carmember['plate1'].$carmember['plate2'].$carmember['plate_number']."  ".$carmember['mobile'];
	}
	include wl_template('app/distance_record');
}

if($op == 'platform'){
	$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '商户工具 - '.$_W['wlsetting']['base']['name'] : '商户工具';
	$sid = intval($_GPC['sid']);
	$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']), 'id');
	$mis = pdo_getcolumn('wlmerchant_merchantuser',array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'status'=>2,'enabled'=>1,'storeid'=>$sid),'id');
	if(empty($mis)) wl_message('你没有管理店铺的权限','close');
	
	$today = strtotime(date('Y-m-d', time()));
	$membernum = pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('weliam_shiftcar_membercard')." WHERE uniacid = '{$_W['uniacid']}' and sid = {$sid}");
	$todayprice = pdo_fetchcolumn("SELECT SUM(fee) FROM ".tablename('weliam_shiftcar_mcrecord')." WHERE uniacid = '{$_W['uniacid']}' and sid = {$sid} and model = 2 and type = 1 and  createtime >= {$today}");
	$todaynum = pdo_fetchcolumn("SELECT SUM(times) FROM ".tablename('weliam_shiftcar_mcrecord')." WHERE uniacid = '{$_W['uniacid']}' and sid = {$sid} and model = 2 and type = 2 and  createtime >= {$today}");
	
	include wl_template('app/distance_platform');
}

if($op == 'memberlist'){
	$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '会员列表 - '.$_W['wlsetting']['base']['name'] : '会员列表';
	$sid = intval($_GPC['sid']);
	$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']), 'id');
	$mis = pdo_getcolumn('wlmerchant_merchantuser',array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'status'=>2,'enabled'=>1,'storeid'=>$sid),'id');
	if(empty($mis)) wl_message('你没有管理店铺的权限','close');
	$memberlist = pdo_fetchall("SELECT * FROM ".tablename('weliam_shiftcar_membercard')." WHERE uniacid = '{$_W['uniacid']}' and sid = {$sid}");
	foreach ($memberlist as $key => &$value) {
		$value['carmember'] = pdo_get('weliam_shiftcar_member', array('id' => $value['mid']), array('nickname','avatar','mobile','plate1','plate2','plate_number'));
	}
	
	include wl_template('app/distance_memberlist');
}
