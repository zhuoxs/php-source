<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $total = pdo_fetchcolumn("select count(id) from" . tablename('weliam_shiftcar_limitlinetpl') . "where uniacid = '{$_W['uniacid']}'");
    $pager = pagination($total, $pindex, $psize);
    $list = pdo_fetchall("select * from" . tablename('weliam_shiftcar_limitlinetpl') . "where uniacid = '{$_W['uniacid']}' order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	foreach ($list as $key => &$value) {
		$value['limittime'] = unserialize($value['limittime']);
	}
    include wl_template('app/limitline/limit_list');
}

if ($op == 'dele') {
    $id = intval($_GPC['id']);
    $result = pdo_delete("weliam_shiftcar_limitlinetpl", array('id' => $id));
    if(empty($result)){
		message('删除限行模板失败！', web_url('app/limitline/display'));
    } else {
		message('删除限行模板成功！', web_url('app/limitline/display'));
    }
}

if ($op == 'post') {
	$id = intval($_GPC['id']);
	if($id){
		$item = pdo_get('weliam_shiftcar_limitlinetpl',array('id' => $id));
		$item['data'] = unserialize($item['data']);
		$item['limittime'] = unserialize($item['limittime']);
		$item['interval'] = unserialize($item['interval']);
	}
	if(empty($item['limittime'])){
		$item['limittime']['start'] = time();
		$item['limittime']['end'] = time();
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
		$starttime = strtotime($_GPC['limittime']['start']);
		$endtime = strtotime($_GPC['limittime']['end']);
		$limittime = array('start'=>$starttime,'end'=>$endtime);

		$base = array(
			'uniacid' => $_W['uniacid'],
			'name' => trim($_GPC['name']),
			'type' => trim($_GPC['type']),
			'limitweek' => trim($_GPC['limitweek']),
			'limitday' => trim($_GPC['limitday']),
			'islimittime' => intval($_GPC['islimittime']),
			'data' => serialize($paramids),
			'limittime' => serialize($limittime),
			'reason' => trim($_GPC['reason']),
			'region' => trim($_GPC['region']),
			'interval' => serialize(array('start'=>$_GPC['intervalstart'],'end'=>$_GPC['intervalend'])),
			'createtime' => time(),
			'status' => intval($_GPC['status']),
			'isnumber' => intval($_GPC['isnumber']),
			'isshare' => intval($_GPC['isshare'])
		);
		if($id){
			pdo_update('weliam_shiftcar_limitlinetpl', $base, array('id' => $id));
		}else{
			pdo_insert('weliam_shiftcar_limitlinetpl', $base);
		}
		message('编辑限行模板成功', web_url('app/limitline/display'));
	}
    include wl_template('app/limitline/limit_post');
}

if ($op == 'tpl') {
	$kw = $_GPC['kw'];
    include wl_template('app/limitline/limit_tpl');
}

if ($op == 'setting') {
	wl_load()->model('setting');
	$settings = wlsetting_read('limitline');
	if (checksubmit('submit')) {
		$base = array(
			'status'=>intval($_GPC['status']),
            'sendtime'=>trim($_GPC['sendtime']),
            'm_limit'=>trim($_GPC['m_limit'])
		);
		wlsetting_save($base, 'limitline');
		message('更新设置成功！', web_url('app/limitline/setting'));
	}
    include wl_template('app/limitline/limit_setting');
}

if ($op == 'sync') {
	$share = pdo_getall('weliam_shiftcar_limitlinetpl',array('isshare'=>1,'shareid'=>0));
	if(empty($share)){
		message('没有共享的限行模板');
	}
	foreach ($share as $key => $value) {
		$haves = pdo_getcolumn('weliam_shiftcar_limitlinetpl', array('uniacid'=>$_W['uniacid'],'shareid'=>$value['id']),'id');
		if(empty($haves) && $value['uniacid'] != $_W['uniacid']){
			$base = array(
				'uniacid' => $_W['uniacid'],
				'name' => trim($value['name']),
				'type' => trim($value['type']),
				'limitweek' => trim($value['limitweek']),
				'limitday' => trim($value['limitday']),
				'islimittime' => intval($value['islimittime']),
				'data' => $value['data'],
				'limittime' => $value['limittime'],
				'reason' => trim($value['reason']),
				'region' => trim($value['region']),
				'interval' => $value['interval'],
				'createtime' => time(),
				'status' => intval($value['status']),
				'shareid' => intval($value['id'])
			);
			pdo_insert('weliam_shiftcar_limitlinetpl',$base);
		}
	}
	message('限行模板同步成功');
}