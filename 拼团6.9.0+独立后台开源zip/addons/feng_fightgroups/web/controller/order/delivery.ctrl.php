<?php
/**
 * [weliam] Copyright (c) 2016/4/4
 * 配送方式
 */
$ops = array('display','post','editstatus','delete');
$op = in_array($op, $ops) ? $op : 'display';
if($op == 'display'){
	$template = pdo_fetchall("select * from".tablename('tg_delivery_template')." WHERE uniacid = '{$_W['uniacid']}' ".TG_MERCHANTID."");
	$prices = array();
	
	foreach ($template as $key => $value) {
		if(empty($value)) {
			continue;
		}
		$info['merchantname'] = $_W['account']['name'];
		if($value['merchantid']){
			$merchant = pdo_fetch("SELECT name FROM " . tablename('tg_merchant') . " WHERE id = '{$value['merchantid']}'");
			$info['merchantname'] = $merchant['name'];
		}
		$info['region'] = json_decode($value['region'], true);
		$info['id'] = $value['id'];
		$info['name'] = $value['name'];
		
		$info['code'] = $value['code'];
		$info['updatetime'] = $value['updatetime'];
		$info['status'] = $value['status'];
		$info['displayorder'] = $value['displayorder'];
		$prices[$key] = $info;
	}
	unset($template);
	if (checksubmit('submit')) {
		$displayorder = $_GPC['displayorder'];
		if (!empty($displayorder)) {
			foreach ($displayorder as $id => $displayorder) {
				pdo_update('tg_delivery_template', array('displayorder' => $displayorder), array('id' => $id));
			}
		}
		message('更新成功', 'refresh', 'success');
	}

	include wl_template('order/deliverylist');
}	
if ($op=='post') {
	$id = intval($_GPC['id']);
	$merchantid = intval($_GPC['merchantid']);
	
	if($_W['ispost']){
		$name = trim($_GPC['name']);
		$code = intval($_GPC['displayorder']);
		if (empty($name)) {
			message(error(1, '模板名称不能为空'), '', 'ajax');
		}
		$insert['name'] = $name;
		$insert['uniacid'] = $_W['uniacid'];
		$insert['merchantid'] = $merchantid;
		$insert['displayorder'] = $code;
		$insert['status'] = 2;
		$insert['data'] = urldecode(trim($_GPC['data']));
		$insert['region'] = urldecode(trim($_GPC['seri']));
		$insert['updatetime'] = TIMESTAMP;
		if ($id > 0) {
			pdo_update('tg_delivery_template', $insert, array('id' => $id));
		} else {
			pdo_insert('tg_delivery_template', $insert);
			$id = pdo_insertid();
		}
		$data = json_decode($insert['data'], true);	
		$region = json_decode($insert['region'], true);	
		if (!empty($id)) {
			pdo_delete('tg_delivery_price', array('template_id' => $id));			
			if (!empty($data)) {
				foreach ($data as $key => $value) {
					if (empty($value)) {
						continue;
					}
					foreach ($value as $key1 => $value1) {
						if (empty($value1['hasChild'])) {
							$insertdata['template_id'] = $id;
							$insertdata['province'] = $value1['title'];
							$insertdata['first_fee'] = $region[$key]['first_fee'];
							pdo_insert('tg_delivery_price', $insertdata);
							$insertdata = array();
						} else {
							foreach ($value1['cities'] as $key2 => $value2) {
								if(empty($value2['hasChild'])) {
									$insertdata['template_id'] = $id;
									$insertdata['province'] = $value1['title'];
									$insertdata['city'] = $value2['title'];
									$insertdata['first_fee'] = $region[$key]['first_fee'];
									pdo_insert('tg_delivery_price', $insertdata);
									$insertdata = array();
								} else {
									foreach ($value2['districts'] as $key3 => $value3) {
										$insertdata['template_id'] = $id;
										$insertdata['province'] = $value1['title'];
										$insertdata['city'] = $value2['title'];
										$insertdata['district'] = $value3;
										$insertdata['first_fee'] = $region[$key]['first_fee'];
										pdo_insert('tg_delivery_price', $insertdata);
										$insertdata = array();
									}
								}
							}
						}
					}
				}
			}
		}
		die(json_encode(array('result'=>'success')));
	}
	if ($id > 0) {
		$item = pdo_fetch("select * from".tablename('tg_delivery_template')."where id={$id}");
		if(!empty($item)) {
			$item['serialize'] = json_decode($item['region'], true);
		}
	}
	$merchants = pdo_fetchall("SELECT * FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}' ".TG_ID."");
	include wl_template('order/area');
}
if($op == 'editstatus'){
	$id = intval($_GPC['id']);
	$status = intval($_GPC['status']);
	pdo_update('tg_delivery_template', array('status' => $status), array('id' => $id));
	die(json_encode(array('result'=>'success')));
}
if($op == 'delete'){
	$id = intval($_GPC['id']);
	pdo_delete('tg_delivery_template', array('id' => $id));
	pdo_delete('tg_delivery_price', array('template_id' => $id));
	die(json_encode(array('result'=>'success')));
}
