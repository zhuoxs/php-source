<?php

defined('IN_IA') or exit('Access Denied');
load()->model('material');
load()->model('mc');
load()->model('account');
load()->model('attachment');
load()->func('file');

//$dos = array('display', 'sync', 'delete', 'send');
$dos = array( 'delete');
$do = in_array($do, $dos) ? $do : 'display';

$_W['page']['title'] = '永久素材-' . $_W['account']['type_name'] . '素材';

if ($do == 'send') {
	$group = intval($_GPC['group']);
	$type = trim($_GPC['type']);
	$id = intval($_GPC['id']);
	$media = pdo_get('wechat_attachment', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if (empty($media)) {
		iajax(1, '素材不存在', '');
	}
	$group = $group > 0 ? $group : -1;
	$account_api = WeAccount::create();
	$result = $account_api->fansSendAll($group, $type, $media['media_id']);
	if (is_error($result)) {
		iajax(1, $result['message'], '');
	}
	$groups = pdo_get('mc_fans_groups', array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid']));
	if (!empty($groups)) {
		$groups = iunserializer($groups['groups']);
	}
	if ($group == -1) {
		$groups = array(
				$group => array(
						'name' => '全部粉丝',
						'count' => 0
				)
		);
	}
	$record = array(
		'uniacid' => $_W['uniacid'],
		'acid' => $_W['acid'],
		'groupname' => $groups[$group]['name'],
		'fansnum' => $groups[$group]['count'],
		'msgtype' => $type,
		'group' => $group,
		'attach_id' => $id,
		'media_id' => $media['media_id'],
		'status' => 0,
		'type' => 0,
		'sendtime' => TIMESTAMP,
		'createtime' => TIMESTAMP,
	);
	pdo_insert('mc_mass_record', $record);
	iajax(0, '发送成功！', '');
}

if ($do == 'delete') {
	if(isset($_GPC['uniacid'])) { 		
		$requniacid = intval($_GPC['uniacid']);
		attachment_reset_uniacid($requniacid);
	}

	$material_id = intval($_GPC['material_id']);
	$server = $_GPC['server'] == 'local' ? 'local' : 'wechat';
	$type = trim($_GPC['type']);
	$cron_record = pdo_get('mc_mass_record', array('uniacid' => $_W['uniacid'], 'attach_id' => $material_id, 'sendtime >=' => TIMESTAMP), array('id'));
	if (!empty($cron_record)) {
		iajax('-1', '有群发消息未发送，不可删除');
	}
	if ($type == 'news'){
		$result = material_news_delete($material_id);
	} else {
				$result = material_delete($material_id, $server);
	}
	if (is_error($result)){
		iajax('-1', $result['message']);
	}
	iajax('0', '删除素材成功');
}