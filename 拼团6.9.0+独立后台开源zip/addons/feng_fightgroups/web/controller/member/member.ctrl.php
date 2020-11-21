<?php
/**
 * [weliam] Copyright (c) 2014 WE7.CC
 * 会员
 */
defined('IN_IA') or exit('Access Denied');
$ops = array('setting','display','modal','credit_record','ajax');
$op = in_array($op, $ops) ? $op : 'setting';
load()->model('mc');
load()->func('tpl');
wl_load()->model('setting');
wl_load()->model('credit');
$setting=setting_get_by_name("member");
if (checksubmit('credit_type_submit')) {
	$status = $_GPC['credit_type'];
	if(empty($setting)){
		$value = array('credit_type'=>$status);
		$data = array(
			'uniacid'=>$_W['uniacid'],
			'key'=>'member',
			'value'=>serialize($value)
		);
		setting_insert($data);
	}else{
		setting_update_by_params(array('value'=>serialize(array('credit_type'=>$status))), array('key'=>'member','uniacid'=>$_W['uniacid']));
	}
	message('保存成功',referer(),'success');
}
if ($op == 'setting') {
	include wl_template('member/setting');exit;
}

if ($op == 'display') {
	$where = " WHERE 1 and uniacid={$_W['uniacid']} ";
	$params = array();
	$type = intval($_GPC['type']);
	$keyword = trim($_GPC['keyword']);

	if (!empty($keyword)) {
		switch($type) {
			case 2 :
				$where .= " AND mobile LIKE :mobile";
				$params[':mobile'] = "%{$keyword}%";
				break;
			case 3 :
				$where .= " AND nickname LIKE :nickname";
				$params[':nickname'] = "%{$keyword}%";
				break;
			default :
				$where .= " AND realname LIKE :realname";
				$params[':realname'] = "%{$keyword}%";
		}
	}
	if($setting['credit_type']==1){
		$table = 'mc_members';
	}else{
		$table = 'tg_member';
	}
	$size = 15;
	$page = $_GPC['page'];
	$sqlTotal = pdo_sql_select_count_from($table) . $where;
	$sqlData = pdo_sql_select_all_from($table) . $where . ' ORDER BY `credit1` DESC ';
	$list = pdo_pagination($sqlTotal, $sqlData, $params, '', $total, $page, $size);
	$pager = pagination($total, $page, $size);
	
}
if ($op == 'modal') {
	$uid = $_GPC['uid'];
	$remark = $_GPC['remark'];
	if(empty($remark)){
		$remark = "拼团后台系统操作！";
	}
	$credit1_type =$_GPC['credit1_type'];
	$credit1_value = $_GPC['credit1_value'];
	if($credit1_type==2){
		$credit1_value = 0-$credit1_value;
	}
	$credit2_type = $_GPC['credit2_type'];
	$credit2_value = $_GPC['credit2_value'];
	if($credit2_type==2){
		$credit2_value = 0-$credit2_value;
	}
	if(is_numeric($credit1_value) && is_numeric($credit2_value)){
		$v1 = credit_update_credit1($uid,$credit1_value,$setting['credit_type'],$remark);
		$v2 = credit_update_credit2($uid,$credit2_value,$setting['credit_type'],$remark);
		$credit=credit_get_by_uid($uid,$setting['credit_type']);
		if(empty($credit1_value))$v1=1;
		if(empty($credit2_value))$v2=1;
		if($v1 && $v2){
			die(json_encode(array('errno'=>0,'message'=>'操作成功'.$v1,'credit1'=>$credit['credit1'],'credit2'=>$credit['credit2'])));
		}else{
			die(json_encode(array('errno'=>1,'message'=>'操作失败')));
		}
	}else{
		die(json_encode(array('errno'=>2,'message'=>'输入不正确')));
	}
	
}

if ($op == 'credit_record') {
	wl_load()->model('member');
	$uid = $_GPC['uid'];
	$member = member_get_by_params(" uid='{$uid}' ");
	load()->model('mc');
	$status = !empty($_GPC['status'])?$_GPC['status']:1;
	$size = 20;
	$page = max(1, intval($_GPC['page']));
	$where = ' WHERE `uid` = :uid AND type=:type';
	$params = array(':uid' => $uid,':type'=>$status);
	$sqlTotal = pdo_sql_select_count_from('tg_credit_record') . $where;
	$sqlData = pdo_sql_select_all_from('tg_credit_record') . $where . ' ORDER BY `id` DESC ';
	$credits_records = pdo_pagination($sqlTotal, $sqlData, $params, '', $total, $page, $size);
	$pager = pagination($total, $page, $size);
	include wl_template('member/member');
	exit;
}
include wl_template('member/member');

