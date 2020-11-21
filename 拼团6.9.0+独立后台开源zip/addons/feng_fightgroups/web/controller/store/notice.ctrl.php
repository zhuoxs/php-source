<?php
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$ops = array('display','post','delete');

if ($operation == 'display') {
	$list = pdo_fetchall("SELECT * FROM " . tablename('tg_notice') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY id DESC");
} elseif ($operation == 'post') {
	$id = intval($_GPC['id']);
	if (checksubmit('submit')) {
		$data = array(
			'uniacid' => $_W['uniacid'],
			'title' => $_GPC['title'],
			'content' => htmlspecialchars_decode($_GPC['content']),
			'enabled' => intval($_GPC['enabled']),
			'createtime'=> time()
		);
		if (!empty($id)) {
			pdo_update('tg_notice', $data, array('id' => $id));
		} else {
			pdo_insert('tg_notice', $data);
			$id = pdo_insertid();
		}
		message('更新公告成功！', web_url('store/notice', array('op' => 'display')), 'success');
	}
	$adv = pdo_fetch("select * from " . tablename('tg_notice') . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $id, ":uniacid" => $_W['uniacid']));
} 

if ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$adv = pdo_fetch("SELECT id FROM " . tablename('tg_notice') . " WHERE id = '$id' AND uniacid = " . $_W['uniacid'] . "");
	if (empty($adv)) {
		message('抱歉，首页公告不存在或是已经被删除！', web_url('store/notice', array('op' => 'display')), 'error');
	}
	pdo_delete('tg_notice', array('id' => $id));
	message('公告删除成功！', web_url('store/notice', array('op' => 'display')), 'success');
}
include wl_template('store/notice');
