<?php 
load()->func('tpl');
$ops = array('display','post','delete');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	$list = pdo_fetchall("SELECT * FROM " . tablename('tg_adv') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
	include wl_template('store/adv');
} elseif ($operation == 'post') {
	$id = intval($_GPC['id']);
	if (checksubmit('submit')) {
		$data = array(
			'uniacid' => $_W['uniacid'],
			'advname' => $_GPC['advname'],
			'link' => $_GPC['link'],
			'enabled' => intval($_GPC['enabled']),
			'displayorder' => intval($_GPC['displayorder']),
			'thumb'=>$_GPC['thumb']
		);
		if (!empty($id)) {
			pdo_update('tg_adv', $data, array('id' => $id));
		} else {
			pdo_insert('tg_adv', $data);
			$id = pdo_insertid();
		}
		message('更新幻灯片成功！', web_url('store/adv', array('op' => 'display')), 'success');
	}
	$adv = pdo_fetch("select * from " . tablename('tg_adv') . " where id=:id and uniacid=:uniacid limit 1", array(":id" => $id, ":uniacid" => $_W['uniacid']));
	include wl_template('store/adv');
} elseif ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$adv = pdo_fetch("SELECT id FROM " . tablename('tg_adv') . " WHERE id = '$id' AND uniacid=" . $_W['uniacid'] . "");
	if (empty($adv)) {
		message('抱歉，幻灯片不存在或是已经被删除！', web_url('store/adv', array('op' => 'display')), 'error');
	}
	pdo_delete('tg_adv', array('id' => $id));
	message('幻灯片删除成功！', web_url('store/adv', array('op' => 'display')), 'success');
} else {
	message('请求方式不存在');
}