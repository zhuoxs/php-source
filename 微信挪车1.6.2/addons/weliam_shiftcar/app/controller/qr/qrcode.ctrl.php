<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '绑定挪车卡 - '.$_W['wlsetting']['base']['name'] : '绑定挪车卡';
wl_load()->model('qr');

if($op == 'display'){
	$qrcode = trim($_GPC['ncnumber']);
	if(empty($qrcode)){
		wl_message('参数错误，请重新获取二维码！','close');
	}
	$card = pdo_get('weliam_shiftcar_qrcode',array('uniacid' => $_W['uniacid'],'cardsn' => $qrcode));
	$carmember = pdo_get('weliam_shiftcar_member',array('uniacid' => $_W['uniacid'],'id' => $card['mid']),array('message','id'));
	//判断挪车卡加密盐
	if($card['createtime'] > 1478426406 && $card['salt'] != $_GPC['salt']){
		wl_message('参数错误，请重新获取二维码！','close');
	}
	//挪车卡未绑定
	if($card['status'] == 1 && empty($_W['wlmember']['ncnumber'])){
		checkgz($qrcode,1);
		header("Location: ".app_url('member/mycar/display',array('ncnum' => $card['cardsn'],'salt' => $card['salt'])));
		exit;
	}
	if($card['status'] == 1 && !empty($_W['wlmember']['ncnumber'])){
		checkgz($qrcode,1);
		$message = "您好，您确定绑定新的挪车卡吗？旧挪车卡将失效。";
		$url = app_url('member/mycar/display',array('ncnum' => $card['cardsn'],'salt' => $card['salt']));
		wl_message($message,$url);
	}
	//挪车卡已绑定
	if($card['status'] == 2 ){
		checkgz($qrcode,2);
		if($carmember['id'] == $_W['mid']){
			wl_message('调皮，你是要自己通知自己挪车吗？','close');
		}else{
			if($_W['wlsetting']['merchant']['sendstatus'] == 2 || $_W['wlsetting']['merchant']['rechangestatus'] == 2){
				$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']), 'id');
				$mis = pdo_getcolumn('wlmerchant_merchantuser',array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'status'=>2,'enabled'=>1),'id');
				if($mis){
					$sendmsg_url = app_url('app/distance',array('userid' => $carmember['id']));
					if($_W['wlsetting']['merchant']['sendstatus'] == 2) $movecar_url = app_url('home/movecar',array('ncnum' => $card['cardsn'],'salt' => $card['salt']));
					if($_W['wlsetting']['merchant']['rechangestatus'] == 2) {
						$recharge_url = app_url('app/distance',array('userid' => $carmember['id'],'op'=>'recharge'));
						$consume_url = app_url('app/distance',array('userid' => $carmember['id'],'op'=>'consume'));
					}
					include wl_template('qr/choice');
					exit;
				}
			}
			header("Location: ".app_url('home/movecar',array('ncnum' => $card['cardsn'],'salt' => $card['salt'])));
			exit;
		}
	}
	//挪车卡已禁止
	if($card['status'] == 3){
		qr_log($qrcode,2);
		wl_message('抱歉，此挪车卡已失效！','close');
	}
}

if($op == 'show'){
	require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
	$qrcode = $_GPC['ncnumber'];
	if($qrcode){
		$wq_qr = app_url('qr/qrcode',array('ncnumber' => $qrcode,'salt' => $_GPC['salt']));
	}else{
		$wq_qr = urldecode($_GPC['url']);
	}
	QRcode :: png($wq_qr, false, QR_ECLEVEL_L, 8.8);
}
