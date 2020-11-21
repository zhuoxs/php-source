<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '挪车记录 - '.$_W['wlsetting']['base']['name'] : '挪车记录';

if($op == 'display'){
	if($_W['ispost']){
		$condition = " and uniacid = {$_W['uniacid']} and (sendmid = {$_W['mid']} or takemid = {$_W['mid']})";
		$page = $_GPC['page'];
		$pagesize = $_GPC['pagesize'];

		$sql = "SELECT id,sendmid,createtime,location,takemid FROM " . tablename('weliam_shiftcar_record') . " where 1 {$condition} order by id desc LIMIT " . ($page - 1) * $pagesize . ',' . $pagesize;
		$list = pdo_fetchall($sql);
		foreach($list as $key => $value){
			$member = pdo_get('weliam_shiftcar_member', array('id' => $value['sendmid']), array('avatar','nickname'));
			$take_member = pdo_get('weliam_shiftcar_member', array('id' => $value['takemid']), array('plate1','plate2','plate_number'));
			$list[$key]['avatar'] = $member['avatar'];
			$list[$key]['nickname'] = $member['nickname'];
			$list[$key]['carcard'] = $take_member['plate1'].$take_member['plate2'].$take_member['plate_number'];
			$list[$key]['url'] = app_url('member/record/detail',array('id' => $value['id']));
			$list[$key]['createtime'] = date('m-d H:i', $value['createtime']);
		}
		die(json_encode($list));
	}
	include wl_template('member/msg_list');
}

if($op == 'detail'){
	$record = pdo_get('weliam_shiftcar_record', array('id' => intval($_GPC['id'])));
	$send_member = pdo_get('weliam_shiftcar_member', array('id' => $record['sendmid']), array('avatar','nickname'));
	$take_member = pdo_get('weliam_shiftcar_member', array('id' => $record['takemid']), array('avatar','nickname','plate1','plate2','plate_number'));
	include wl_template('member/msg_detail');
}

if($op == 'comment'){
	$comment = $_GPC['value'];
	if(empty($comment)) die(json_encode(array("result" => 2,'msg' => '请输入您的点评内容')));
	pdo_insert('weliam_shiftcar_comment',array('uniacid'=>$_W['uniacid'],'mid'=>$_W['mid'],'reid'=>$_GPC['reid'],'status'=>1,'comment'=>$comment,'createtime'=>time()));
	pdo_update('weliam_shiftcar_record',array('comment'=>1),array('id'=>$_GPC['reid']));
	mc_credit_update($_W['member']['uid'],'credit1',$_W['wlsetting']['qrset']['integral']);
	mc_notice_credit1($_W['openid'],$_W['member']['uid'],$_W['wlsetting']['qrset']['integral'],'微信挪车车主点评赠送积分');
	die(json_encode(array("result" => 1)));
}
