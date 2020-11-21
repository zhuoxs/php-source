<?php
defined('IN_IA') or exit('Access Denied');

function qr_createkeywords(){
	global $_W;
	$rid = pdo_fetchcolumn("select id from " . tablename('rule') . 'where uniacid=:uniacid and module=:module and name=:name', array(
		':uniacid' => $_W['uniacid'],
		':module' => 'weliam_shiftcar',
		':name' => "微信挪车二维码入口"
	));
	if (empty($rid)) {
		$rule_data = array(
			'uniacid' => $_W['uniacid'],
			'name' => '微信挪车二维码入口',
			'module' => 'weliam_shiftcar',
			'displayorder' => 0,
			'status' => 1
		);
		pdo_insert('rule', $rule_data);
		$rid          = pdo_insertid();
		$keyword_data = array(
			'uniacid' => $_W['uniacid'],
			'rid' => $rid,
			'module' => 'weliam_shiftcar',
			'content' => 'weliam_shiftcar_qr',
			'type' => 1,
			'displayorder' => 0,
			'status' => 1
		);
		pdo_insert('rule_keyword', $keyword_data);
	}
	
	return $rid;
}

function qr_log($cardsn,$type){
	global $_W;
	if(empty($cardsn) || empty($_W['openid'])){
		return;
	}
	$qrid = pdo_getcolumn('weliam_shiftcar_qrcode',array('uniacid' => $_W['uniacid'],'cardsn' => $cardsn),'qrid');
	$qrcode = pdo_get('qrcode',array('id' => $qrid),array('scene_str','name'));
	$log = array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'],'qid' => $qrid,'openid' => $_W['openid'],'type' => $type,'scene_str'=>$qrcode['scene_str'],'name'=>$qrcode['name'],'createtime'=>time());
	pdo_insert('qrcode_stat',$log);
}

function checkgz($qrcode,$status = 1){
	global $_W;
	if($_W['fans']['follow'] != 1 && $_W['wlsetting']['qrset']['gzstatus'] == 2 && $status == 1){
		qr_log($qrcode,1);
		$showurl = !empty($_W['wlsetting']['qrset']['gzlogo']) ? $_W['wlsetting']['qrset']['gzlogo'] : 'qrcode_'.$_W['acid'].'.jpg';
		include wl_template('qr/qrcode');
		exit;
	}
	if($_W['fans']['follow'] != 1 && $_W['wlsetting']['qrset']['gznc'] == 2 && $status == 2){
		qr_log($qrcode,1);
		$showurl = !empty($_W['wlsetting']['qrset']['gzlogo']) ? $_W['wlsetting']['qrset']['gzlogo'] : 'qrcode_'.$_W['acid'].'.jpg';
		include wl_template('qr/qrcode');
		exit;
	}
	qr_log($qrcode,2);
}
