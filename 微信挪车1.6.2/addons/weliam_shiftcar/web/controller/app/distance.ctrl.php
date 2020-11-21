<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('list','post','setting','tpl','cover');
$op = in_array($op, $ops) ? $op : 'list';
if(!pdo_tableexists('wlmerchant_merchantdata') && $op != 'tpl'){
	message('您还未安装或购买智慧城市O2O，无法使用此功能！');
}
wl_load()->model('setting');

if($op == 'list'){
	$pindex = max(1, intval($_GPC['page']));
  	$psize = 10;
	$wheresql = " WHERE uniacid = '{$_W['uniacid']}'";
	$keyword = trim($_GPC['keyword']);
	if(!empty($keyword)) {
		$wheresql .= " AND storename LIKE '%{$keyword}%' ";
	}
	
  	$total = pdo_fetchcolumn("select count(id) from" . tablename('wlmerchant_merchantdata') . $wheresql);
  	$pager = pagination($total, $pindex, $psize);
  	$list = pdo_fetchall("select * from" . tablename('wlmerchant_merchantdata') .$wheresql. " order by id desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
	foreach ($list as $key => &$value) {
		$remark_arr = pdo_fetchall('SELECT distinct remark FROM ' . tablename('weliam_shiftcar_qrcode') . "WHERE uniacid = {$_W['uniacid']} AND sid = {$value['id']}");
		if(!empty($remark_arr)){
			$value['carremark'] = $remark_arr;
		}
	}
	
	include wl_template('app/distance/distance_list');
}

if($op == 'post'){
	$id = intval($_GPC['id']);
	if(empty($id)) message('请先选择店铺，再进行操作！');
	
	$item = pdo_fetchall('select distinct remark from ' . tablename('weliam_shiftcar_qrcode'). " WHERE uniacid = '{$_W['uniacid']}' AND sid = {$id} ");
	$remark_arr = pdo_fetchall('SELECT distinct remark FROM ' . tablename('weliam_shiftcar_qrcode') . "WHERE uniacid = {$_W['uniacid']} AND sid = 0");
	$remark_arr = Util::i_array_column($remark_arr,'remark');
	
	if (checksubmit('submit')) {
		if($id){
			pdo_update('weliam_shiftcar_qrcode', array('sid'=>$id), array('remark' => trim($_GPC['remark'])));
		}	
		message('更新店铺成功！', web_url('app/distance/list'));
	}
	
	include wl_template('app/distance/distance_post');
}

if ($op == 'setting') {
	$settings = wlsetting_read('merchant');
	if (checksubmit('submit')) {
		$base = array(
			'vipstatus'=>intval($_GPC['vipstatus']),
			'sendstatus'=>intval($_GPC['sendstatus']),
			'sendtimes'=>intval($_GPC['sendtimes']),
			'm_sendmsg'=>$_GPC['m_sendmsg'],
			'viptime'=>intval($_GPC['viptime']),
			'sendmsg'=>$_GPC['sendmsg'],
			'rechangestatus'=>intval($_GPC['rechangestatus'])
		);
		wlsetting_save($base, 'merchant');
		message('更新设置成功！', web_url('app/distance/setting'));
	}
	include wl_template('app/distance/distance_set');
}

if($op == 'tpl'){
	include wl_template('app/distance/sendmsgtpl');
}

if ($op == 'cover') {
	load()->model('reply');
	$url = app_url('app/distance/cardlist');
	$name = '会员卡列表';
	
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