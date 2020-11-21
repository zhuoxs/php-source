<?php 
defined('IN_IA') or exit('Access Denied');
load()->model('reply');
require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
$dos = array('index','order','group','member');
$allcovers = array('index' => array('url' => app_url('home/index'), 'name' => '首页'),'order' => array('url' => app_url('order/order'), 'name' => '我的订单'),'group' => array('url' => app_url('order/mygroup'), 'name' => '我的团'),'member' => array('url' => app_url('member/home'), 'name' => '个人中心'));
$ado = in_array($_GPC['ado'], $dos) ? $_GPC['ado'] : 'index';
$ops = array('display','qr');
$op = in_array($op, $ops) ? $op : 'display';
$url = $allcovers[$ado]['url'];
$name = $allcovers[$ado]['name'];

if($op == 'display'){
	$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => TG_NAME . $name . '入口设置'));

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
			if ($keyword1['name'] != (TG_NAME . $name . '入口设置')) {
				message('关键字已存在!');
			}
		}
		if (!empty($rule)) {
			pdo_delete('rule', array('id' => $rule['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('rule_keyword', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('cover_reply', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
		}
	
		$rule_data = array('uniacid' => $_W['uniacid'], 'name' => TG_NAME . $name . '入口设置', 'module' => 'cover', 'displayorder' => 0, 'status' => intval($data['status']));
		pdo_insert('rule', $rule_data);
		$rid = pdo_insertid();
		
		$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => intval($data['status']));
		pdo_insert('rule_keyword', $keyword_data);
		
		$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => TG_NAME, 'title' => trim($data['title']), 'description' => trim($data['desc']), 'thumb' => $data['thumb'], 'url' => $url);
		pdo_insert('cover_reply', $cover_data);
		message('保存成功！');
	}
	
	$cover = array('rule' => $rule, 'cover' => $cover, 'keyword' => $keyword, 'url' => $url,'name' => $name);
	include wl_template('store/cover');
}

if($op == 'qr'){
	$url = urldecode($_GPC['url']);
	QRcode::png($url, false, QR_ECLEVEL_H, 4);
}
