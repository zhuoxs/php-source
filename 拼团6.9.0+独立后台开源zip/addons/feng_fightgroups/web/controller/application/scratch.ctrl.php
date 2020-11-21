<?php 
/**
 * [weliam] Copyright (c) 2016/4/4
 * 阶梯团
 */

defined('IN_IA') or exit('Access Denied');

$ops = array('list', 'create', 'edit', 'ajax','record');
$op = in_array($op, $ops) ? $op : 'list';
if ($op == 'list') {
	$_W['page']['title'] = '应用和营销  - 活动列表';
	$data  =   pdo_fetchall("select * from".tablename('tg_scratch')."where uniacid={$_W['uniacid']}");
	include wl_template('application/scratch/scratch_list');
}
if ($op == 'create' || $op == 'edit') {
	$id = $_GPC['id'];
	if($id){
		$scratch = pdo_fetch("select * from".tablename('tg_scratch')."where id={$id}");
		$prize = unserialize($scratch['prize']);
	}else{
		$scratch['starttime'] = strtotime('-1 month');
		$scratch['endtime'] = time();
	}
	/*优惠券*/
	$sql = "select * from".tablename('tg_coupon_template')." WHERE uniacid = {$_W['uniacid']} ";
	$tg_coupon_templates = pdo_fetchall($sql);
	/*赠品*/
	$time= TIMESTAMP;
	$sql = "select * from".tablename('tg_gift')." WHERE uniacid = {$_W['uniacid']} and starttime<'{$time}' and endtime>'{$time}'";
	$gift = pdo_fetchall($sql);
	if (checksubmit('submit')) {
		$time = $_GPC['time'];
		$scratch = $_GPC['scratch'];
		$scratch['starttime'] = strtotime($time['start']);
		$scratch['endtime'] = strtotime($time['end']);
		$scratch['uniacid']=$_W['uniacid'];
		$first = $_GPC['first'];
		$second = $_GPC['second'];
		$third = $_GPC['third'];
		$forth = $_GPC['forth'];
		if($scratch['status']==1){
			pdo_update('tg_scratch',array('status'=>2),array('status'=>1));
		}
		$data=array('first'=>$first,'second'=>$second,'third'=>$third,'forth'=>$forth);
		foreach($data as $key=>&$value){
			if($value['radio']==1){
				$value['coupon_id']='';$value['gift_id']='';
			}elseif($value['radio']==2){
				$value['credits']='';$value['gift_id']='';
			}elseif($value['radio']==3){
				$value['coupon_id']='';$value['credits']='';
			}
		}
		$prize=serialize($data);
		$scratch['prize'] = $prize;
		if (empty($id)) {
			if(pdo_insert('tg_scratch',$scratch))
				message('创建成功', web_url('application/scratch/list'), 'success');exit;
			
		} else {
			pdo_update('tg_scratch',$scratch);
			message('修改成功', web_url('application/scratch/list'), 'success');exit;
		}
	}
	
	include wl_template('application/scratch/scratch_edit');
}

if ($op == 'ajax') {
	$id = $_GPC['id'];
	if(pdo_update('tg_scratch_record',array('status'=>3),array('id'=>$id))){
		die(json_encode(array('errno'=>0)));
	}
	
	die(json_encode(array('errno'=>1)));
}
if ($op == 'record') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$id = $_GPC['id'];
	$data  =   pdo_fetch("select * from".tablename('tg_scratch')."where uniacid={$_W['uniacid']} and id = {$id}");
	$records = pdo_fetchall("select * from".tablename('tg_scratch_record')."where uniacid={$_W['uniacid']} and activity_id={$id} " . "LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	wl_load()->model('member');
	foreach($records as$key=>&$value){
		$value['member'] = $member = getMember($value['openid']);
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tg_scratch_record') . " WHERE uniacid={$_W['uniacid']} and activity_id={$id}");
	$pager = pagination($total, $pindex, $psize);
//	wl_debug($records);
	include wl_template('application/scratch/scratch_record');
}