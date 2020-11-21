<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * index.ctrl
 * 个人中心控制器
 */
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$pagetitle = !empty($config['tginfo']['sname']) ? '个人中心 - '.$config['tginfo']['sname'] : '个人中心';
$time = time();
$scratch = pdo_fetch("select * from".tablename('tg_scratch')."where status=1 and uniacid={$_W['uniacid']} and starttime<'{$time}' and endtime>'{$time}'");
if($op =='display'){
	$setting=setting_get_by_name("member");
	$paytype = tgsetting_read('paytype');
	$member = getMember($openid);
	if(!$member['credit1']){
		$member['credit1'] = '0.00';
	}
	if(!$member['credit2']){
		$member['credit2'] = '0.00';
	}
	$time = time();
	$tatal1 = pdo_fetchall("select openid from".tablename('tg_coupon')."where openid='{$_W['openid']}' and uniacid={$_W['uniacid']} and use_time=0 AND `start_time` < '{$time}' AND `end_time` > '{$time}'");
	$tatal = count($tatal1);
	include wl_template('member/home');
}

if($op == 'activity'){
	$data  =   pdo_fetchall("select * from".tablename('tg_scratch_record')."where uniacid={$_W['uniacid']} and openid='{$_W['openid']}'");
	$i = 0;
	foreach($data as$key=>&$value){
		$data1 =   pdo_fetch("select * from".tablename('tg_scratch')."where uniacid={$_W['uniacid']} and id={$value['activity_id']}");
		$value['name']  = $data1['name'];
		$value['createtime']  = date('Y-m-d H:i:s',$value['createtime']);
	}
//	wl_debug($data);
	include wl_template('member/activity_list');
}
if($op == 'app'){
	include wl_template('member/app_login');
}
if($op == 'distribution'){
	$pagetitle = !empty($config['tginfo']['sname']) ? '分销中心 - '.$config['tginfo']['sname'] : '分销中心';
	$disset = tgsetting_read('distribution');
	$member = pdo_get('tg_member',array('id' => $_W['wlmember']['id']));
	$successorder = pdo_getall('tg_txapply',array('mid' => $_W['wlmember']['id'],'status'=> 2));
	$successmoney = 0;
	if($successorder){
		foreach ($successorder as $key => $v) {
			$successmoney += $v['money'];
		}
	}
	$mid = $_W['wlmember']['id'];
	$where['uniacid'] = $_W['uniacid'];
	$where['leadid'] = $mid;
	$where['#status#'] = "(1,2,3,4)";
	$orders = Util::getNumData('*',"tg_order", $where,'id DESC',0,0,TRUE);
	$allprice = 0;
	if($orders){
		foreach ($orders as $key => $value) {
			$allprice += $value['price'];
		}
	}
	$allprice = number_format($allprice,2);
	$peoplenum = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('tg_member')." WHERE leadid = {$_W['wlmember']['id']}");
	$ordernum = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('tg_order')." WHERE leadid = {$_W['wlmember']['id']} AND status > 0");
	$applynum = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('tg_txapply')." WHERE mid = {$_W['wlmember']['id']}");
	
	
	$successmoney = number_format($successmoney,2);
//	wl_debug($member);
	include wl_template('member/distribution');
}
if($op == 'apply'){
	$pagetitle = !empty($config['tginfo']['sname']) ? '分销提现 - '.$config['tginfo']['sname'] : '分销提现';
	$member = pdo_get('tg_member',array('id' => $_W['wlmember']['id']));
	$disset = tgsetting_read('distribution');
	$member['succmoney'] = $member['ingmoney'] = 0;
	$applys = pdo_getall('tg_txapply',array('mid' => $_W['wlmember']['id']));
	if($applys){
		foreach ($applys as $key => $v) {
			if($v['status'] == 1){
				$member['ingmoney'] += $v['money'];
			}elseif ($v['status'] == 2) {
				$member['ingmoney'] += $v['money'];
			}elseif ($v['status'] == 4) {
				$member['succmoney'] += $v['money'];
			}
		}
	}	
	$member['ingmoney'] = number_format($member['ingmoney'],2);
	$member['succmoney'] = number_format($member['succmoney'],2);
	
	if($_GPC['type'] == 'deling'){
		$record = pdo_fetchall("SELECT * FROM ".tablename('tg_txapply')."WHERE uniacid = {$_W['uniacid']} AND status IN (1,2) ORDER BY createtime DESC");
	}
	if($_GPC['type'] == 'finish'){
		$record = pdo_getall('tg_txapply',array('mid' => $_W['wlmember']['id'],'uniacid'=>$_W['uniacid'],'status'=>4));
	}
	if($_GPC['type'] == 'reject'){
		$record = pdo_getall('tg_txapply',array('mid' => $_W['wlmember']['id'],'uniacid'=>$_W['uniacid'],'status'=>3));
	}
	
	
	include wl_template('member/txapply');
}
if($op == 'applying'){
	$appmoney = $_GPC['money'];
	$disset = tgsetting_read('distribution');
	$member = pdo_get('tg_member',array('id' => $_W['wlmember']['id']));
	if($appmoney < $disset['lowestmoney']){
		die(json_encode(array('errno'=>1,'message'=>'提现金额小于最低提现佣金')));
	}
	if($appmoney > $member['nowmoney']){
		die(json_encode(array('errno'=>1,'message'=>'可提现金额不足')));
	}
	if($disset['frequency']){
		$lastapp = pdo_fetch("SELECT * FROM ".tablename('tg_txapply')."WHERE uniacid = {$_W['uniacid']} ORDER BY createtime DESC");
		$limittime = $lastapp['createtime'] + $disset['frequency']*24*3600;
		if($limittime > time()){
			die(json_encode(array('errno'=>1,'message'=>'您在'.$disset['frequency'].'天内有提现申请，请稍后再试')));
		}
	}
	$nowmoney = $member['nowmoney'] - $appmoney;
	$res1 = pdo_update('tg_member',array('nowmoney' => $nowmoney),array('id' => $_W['wlmember']['id']));
	if($res1){
		$data = array(
			'uniacid'   => $_W['uniacid'],
			'status' 	=> 1,
			'mid' 	    => $_W['wlmember']['id'],
			'money'     => $appmoney,
			'createtime'=> time()
		);
		$res2 = pdo_insert('tg_txapply',$data);
		if($res2){
			die(json_encode(array('errno'=>0,'message'=>'申请成功!')));
		}else {
			die(json_encode(array('errno'=>1,'message'=>'申请失败，请联系管理员')));
		}
	}else {
		die(json_encode(array('errno'=>1,'message'=>'更新个人数据失败，请联系管理员')));
	}
	
	
}
