<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $total = pdo_fetchcolumn("select count(id) from" . tablename('weliam_shiftcar_peccrecord') . "where uniacid = '{$_W['uniacid']}'");
    $pager = pagination($total, $pindex, $psize);
    $list = pdo_fetchall("select * from" . tablename('weliam_shiftcar_peccrecord') . "where uniacid = '{$_W['uniacid']}' order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	if (!empty($list)) {
		foreach ($list as $index => &$qrcode) {
			$wq_qr = pdo_get('weliam_shiftcar_member', array('id' => $qrcode['mid']), array('avatar', 'nickname','openid'));
			$fanid = pdo_getcolumn('mc_mapping_fans', array('openid' => $wq_qr['openid']), 'fanid');
			$qrcode['avatar'] = $wq_qr['avatar'];
			$qrcode['nickname'] = $wq_qr['nickname'];
			$qrcode['fanid'] = $fanid;
		}
	}

    include wl_template('app/pecc/pecc_list');
}

if ($op == 'dele') {
    $id = intval($_GPC['id']);
    $result = pdo_delete("weliam_shiftcar_peccrecord", array('id' => $id));
    if(empty($result)){
		message('删除违章记录失败！', web_url('app/pecc/display'));
    } else {
		message('删除违章记录成功！', web_url('app/pecc/display'));
    }
}

if ($op == 'setting') {
	wl_load()->model('setting');
	$smses = pdo_getall('weliam_shiftcar_smstpl',array('uniacid' => $_W['uniacid']),array('id','name'));
	$settings = wlsetting_read('pecc');
	if (checksubmit('submit')) {
		$base = array(
			'pecc_status'=>intval($_GPC['pecc_status']),
            'ptime' => intval($_GPC['ptime']),
            'noticetype' => intval($_GPC['noticetype']),
            'm_pecc' => $_GPC['m_pecc'],
            'dx_tz' => intval($_GPC['dx_tz']),
            'yy_tz' => intval($_GPC['yy_tz']),
//          'free_api' => intval($_GPC['free_api']),
            'jisu_api' => intval($_GPC['jisu_api']),
            'jisu_appkey' => $_GPC['jisu_appkey'],
            'lubang_api' => intval($_GPC['lubang_api']),
            'lubang_apiid' => $_GPC['lubang_apiid'],
            'lubang_appkey' => $_GPC['lubang_appkey']
		);
		wlsetting_save($base, 'pecc');
		message('更新设置成功！', web_url('app/pecc/setting'));
	}
    include wl_template('app/pecc/pecc_setting');
}

if ($op == 'cover') {
	load()->model('reply');
	$url = app_url('app/pecc');
	$name = '违章查询';
	
	$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => WL_NAME . $name . '入口设置'));
	
	if (!empty($rule)) {
		$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
		$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
	}
	
	if (checksubmit('submit')) {
		$data = (is_array($_GPC['cover']) ? $_GPC['cover'] : array());
	
		if (empty($data['keyword'])) {
			message('请输入关键词!');
		}
		$keyword1 = keyExist($data['keyword']);
		if (!empty($keyword1)) {
			if ($keyword1['name'] != (WL_NAME . $name . '入口设置')) {
				message('关键字已存在!');
			}
		}
		if (!empty($rule)) {
			pdo_delete('rule', array('id' => $rule['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('rule_keyword', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('cover_reply', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
		}
	
		$rule_data = array('uniacid' => $_W['uniacid'], 'name' => WL_NAME . $name . '入口设置', 'module' => 'cover', 'displayorder' => 0, 'status' => intval($data['status']));
		pdo_insert('rule', $rule_data);
		$rid = pdo_insertid();
		
		$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => intval($data['status']));
		pdo_insert('rule_keyword', $keyword_data);
		
		$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => WL_NAME, 'title' => trim($data['title']), 'description' => trim($data['desc']), 'thumb' => $data['thumb'], 'url' => $url);
		pdo_insert('cover_reply', $cover_data);
		message('保存成功！');
	}
	
	$cover = array('rule' => $rule, 'cover' => $cover, 'keyword' => $keyword, 'url' => $url,'name' => $name);
	
	include wl_template('setting/cover');
}