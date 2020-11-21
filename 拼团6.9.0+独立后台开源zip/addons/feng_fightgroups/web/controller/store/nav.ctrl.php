<?php
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$ops = array('display','post','delete');
if ($operation == 'display') {
	$list = pdo_fetchall("SELECT * FROM " . tablename('tg_nav') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
} elseif ($operation == 'post') {
	$id = intval($_GPC['id']);
	if (checksubmit('submit')) {
		$data = array(
			'uniacid' => $_W['uniacid'],
			'name' => $_GPC['advname'],
			'link' => $_GPC['link'],
			'enabled' => intval($_GPC['enabled']),
			'displayorder' => intval($_GPC['displayorder']),
			'thumb'=>$_GPC['thumb']
		);
		if (!empty($id)) {
			pdo_update('tg_nav', $data, array('id' => $id));
		} else {
			pdo_insert('tg_nav', $data);
			$id = pdo_insertid();
		}
		message('更新导航成功！', web_url('store/nav', array('op' => 'display')), 'success');
	}
	$adv = pdo_fetch("select * from " . tablename('tg_nav') . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $id, ":uniacid" => $_W['uniacid']));
} 

if ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$adv = pdo_fetch("SELECT id FROM " . tablename('tg_nav') . " WHERE id = '$id' AND uniacid = " . $_W['uniacid'] . "");
	if (empty($adv)) {
		message('抱歉，首页导航不存在或是已经被删除！', web_url('store/nav', array('op' => 'display')), 'error');
	}
	pdo_delete('tg_nav', array('id' => $id));
	message('导航删除成功！', web_url('store/nav', array('op' => 'display')), 'success');
}
include wl_template('store/nav');
