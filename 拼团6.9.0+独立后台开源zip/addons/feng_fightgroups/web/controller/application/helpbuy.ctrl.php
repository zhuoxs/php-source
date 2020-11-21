<?php 
/**
 * [weliam] Copyright (c) 2016/4/12
 * 代付
 */

defined('IN_IA') or exit('Access Denied');

$ops = array('ajax','list', 'create', 'edit', 'delete');
$op = in_array($op, $ops) ? $op : 'list';
wl_load()->model('setting');
$setting=setting_get_by_name("helpbuy");
if ($op == 'ajax') {
	if(empty($setting)){
		$value = array('helpbuy'=>1);
		$data = array(
			'uniacid'=>$_W['uniacid'],
			'key'=>'helpbuy',
			'value'=>serialize($value)
		);
		setting_insert($data);
		die(json_encode(array('errno'=>0,'message'=>"保存成功")));
	}else{
		$status = $setting['helpbuy']==1?2:1;
		setting_update_by_params(array('value'=>serialize(array('helpbuy'=>$status))), array('key'=>'helpbuy','uniacid'=>$_W['uniacid']));
		die(json_encode(array('errno'=>0,'message'=>"保存成功")));
	}
}
if ($op == 'list') {
	$list = pdo_fetchall("select * from".tablename('tg_helpbuy')."where uniacid={$_W['uniacid']}");
	include wl_template('application/helpbuy/list');
}
if ($op == 'create' || $op == 'edit') {
	$id = $_GPC['id'];
	$remark = $_GPC['remark'];
	if(!empty($id)){
		if (pdo_update('tg_helpbuy', array('name' => $remark),array('id'=>$id))) {
			die(json_encode(array('errno'=>0,'id'=>$id)));
		} else {
			die(json_encode(array('errno'=>1)));
		}
	}else{
		if (pdo_insert('tg_helpbuy', array('name' => $remark,'uniacid'=>$_W['uniacid']))) {
			$id = pdo_insertid();
			die(json_encode(array('errno'=>0,'id'=>$id)));
		} else {
			die(json_encode(array('errno'=>1)));
		}
	}
}

if ($op == 'delete') {
	$id = $_GPC['id'];
	if (pdo_delete('tg_helpbuy',array('id'=>$id))) {
		die(json_encode(array('errno'=>0,'id'=>$id,'message'=>'删除成功')));
	} else {
		die(json_encode(array('errno'=>1,'message'=>'删除失败')));
	}
}
