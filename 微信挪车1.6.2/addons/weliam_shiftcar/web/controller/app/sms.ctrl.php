<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $total = pdo_fetchcolumn("select count(id) from" . tablename('weliam_shiftcar_smstpl') . "where uniacid = '{$_W['uniacid']}'");
    $pager = pagination($total, $pindex, $psize);
    $list = pdo_fetchall("select * from" . tablename('weliam_shiftcar_smstpl') . "where uniacid = '{$_W['uniacid']}' order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);

    include wl_template('app/sms/sms_list');
}

if ($op == 'dele') {
    $id = intval($_GPC['id']);
    $result = pdo_delete("weliam_shiftcar_smstpl", array('id' => $id));
    if(empty($result)){
		message('删除短信模板失败！', web_url('app/sms/display'));
    } else {
		message('删除短信模板成功！', web_url('app/sms/display'));
    }
}

if ($op == 'post') {
	$id = intval($_GPC['id']);
	if($id){
		$item = pdo_get('weliam_shiftcar_smstpl',array('id' => $id));
		$item['data'] = unserialize($item['data']);
	}
	
	if (checksubmit('submit')) {
		//处理数据值
		$data_temp = $_GPC['data_temp'];
		$data_shop = $_GPC['data_shop'];
		$len = count($data_temp);
		$paramids = array();
		for ($k = 0; $k < $len; $k++) {
			$paramids[$k]['data_temp'] = $data_temp[$k];
			$paramids[$k]['data_shop'] = $data_shop[$k];
		}

		$base = array(
			'uniacid' => $_W['uniacid'],
			'name' => trim($_GPC['name']),
			'type' => trim($_GPC['type']),
			'smstplid' => trim($_GPC['smstplid']),
			'data' => serialize($paramids),
			'createtime' => time(),
			'status' => intval($_GPC['status'])
		);
		if($id){
			pdo_update('weliam_shiftcar_smstpl', $base, array('id' => $id));
		}else{
			pdo_insert('weliam_shiftcar_smstpl', $base);
		}
		message('更新设置成功！', web_url('app/sms/display'));
	}
    include wl_template('app/sms/sms_post');
}

if ($op == 'tpl') {
	$kw = $_GPC['kw'];
    include wl_template('app/sms/sms_tpl');
}

if ($op == 'setting') {
	wl_load()->model('setting');
	$smses = pdo_getall('weliam_shiftcar_smstpl',array('uniacid' => $_W['uniacid']),array('id','name'));
	$settings = wlsetting_read('sms');
	if (checksubmit('submit')) {
		$base = array(
			'status'=>intval($_GPC['status']),
            'dy_sf' => intval($_GPC['dy_sf']),
            'dy_dx' => intval($_GPC['dy_dx']),
            'dy_yy' => intval($_GPC['dy_yy'])
		);
		wlsetting_save($base, 'sms');
		message('更新设置成功！', web_url('app/sms/setting'));
	}
    include wl_template('app/sms/sms_setting');
}