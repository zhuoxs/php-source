<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('list','post','imgandurl','dele');
$op = in_array($op, $ops) ? $op : 'list';

if($op == 'list'){
	$pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $total = pdo_fetchcolumn("select count(id) from" . tablename('weliam_shiftcar_advertisement') . "where uniacid = '{$_W['uniacid']}'");
    $pager = pagination($total, $pindex, $psize);
	$list = pdo_fetchall("select * from" . tablename('weliam_shiftcar_advertisement') . "where uniacid = '{$_W['uniacid']}' order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	foreach($list as $key => $value){
		$list[$key]['signtime'] = unserialize($value['signtime']);
	}
	include wl_template('app/advertisement/advertisement_list');
}

if ($op == 'dele') {
    $id = intval($_GPC['id']);
    $result = pdo_delete("weliam_shiftcar_advertisement", array('id' => $id));
    if(empty($result)){
		message('删除广告模板失败！', web_url('app/advertisement/list'));
    } else {
		message('删除广告模板成功！', web_url('app/advertisement/list'));
    }
}

if ($op == 'post') {
	$id = intval($_GPC['id']);
	if($id){
		$item = pdo_get('weliam_shiftcar_advertisement',array('id' => $id));
		$item['content']  = unserialize($item['content']);
		$time = unserialize($item['signtime']);
	}
	$remark_arr = pdo_fetchall('SELECT distinct remark FROM ' . tablename('weliam_shiftcar_qrcode') . "WHERE uniacid = {$_W['uniacid']}");
	$remark_arr = Util::i_array_column($remark_arr,'remark');
	
	if (checksubmit('submit')) {
		//处理数据值
		$data_img = $_GPC['data_img'];
		$data_url = $_GPC['data_url'];
		$len = count($data_img);
		$paramids = array();
		for ($k = 0; $k < $len; $k++) {
			$paramids[$k]['data_img'] = $data_img[$k];
			$paramids[$k]['data_url'] = $data_url[$k];
		}
		if(trim($_GPC['position'])){
			$position = trim($_GPC['position']);
		}else {
			$position = 1;
		}
		if($_GPC['advtype'] == 1 && empty($_GPC['cardnumber'])) message('请填写挪车卡号码段');
		if($_GPC['advtype'] == 2 && empty($_GPC['remark'])) message('请选择挪车卡场景备注');
		//广告持续时间
		if (!empty($_GPC['time'])) {
			$signtime = serialize($_GPC['time']);
		}
		$base = array(
			'uniacid' => $_W['uniacid'],
			'name' => trim($_GPC['name']),
			'position' => $position,
			'content' => serialize($paramids),
			'createtime' => time(),
			'advtype' => intval($_GPC['advtype']),
			'issettime' => intval($_GPC['issettime']),
			'cardnumber' => $_GPC['cardnumber'],
			'remark' => $_GPC['remark'],
			'status' => intval($_GPC['status']),
			'signtime'=>$signtime
		);
		if($id){
			pdo_update('weliam_shiftcar_advertisement', $base, array('id' => $id));
		}else{
			pdo_insert('weliam_shiftcar_advertisement', $base);
		}
		message('更新设置成功！', web_url('app/advertisement/list'));
	}
	include wl_template('app/advertisement/advertisement_post');
}

if ($op == 'imgandurl') {
	include wl_template('app/advertisement/imgandurl');
}

