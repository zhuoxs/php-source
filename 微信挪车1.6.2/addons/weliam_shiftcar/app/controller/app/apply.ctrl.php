<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'list';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '申请挪车卡 - '.$_W['wlsetting']['base']['name'] : '申请挪车卡';

if($op == 'post'){
	if($_W['ispost']){
		$postage = $_GPC['postage'];
		if ($postage != 0) {
			$status = 5;
		}else{
			$status = 1;
		}
		$data = array(
			'name' => $_GPC['name'],
			'mobile' => $_GPC['phoneumber'],
			'area' => $_GPC['address'],
			'address' => $_GPC['deaddress'],
			'status' => $status,
			'postage' => $postage,
			'createtime' => time()
		);
		if(empty($_GPC['id'])){
			$data['uniacid'] = $_W['uniacid'];
			$data['mid'] = $_W['mid'];
			$data['ordersn'] = date('Ymd').substr(time(), -5).substr(microtime(), 2, 5).sprintf('%02d', rand(0, 99));
			$re = pdo_insert('weliam_shiftcar_apply',$data);
		}else{
			$re = pdo_update('weliam_shiftcar_apply',$data,array('id' => intval($_GPC['id'])));
		}
		if($re){
			$orderno = $data['ordersn'];
			die(json_encode(array("result" => 1 , "orderno" => $orderno)));
		}
		die(json_encode(array("result" => 2,'msg' => '提交申请失败，请稍后重试')));
	}
	$times = $_W['wlsetting']['apply']['times'];
	$postage = $_W['wlsetting']['apply']['postage'];
	$nckexplain = $_W['wlsetting']['apply']['nckexplain'];
	include wl_template('app/apply_card');
}

if($op == 'list'){
	$order = pdo_getall('weliam_shiftcar_apply', array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid']));
	$times = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('weliam_shiftcar_apply')."WHERE uniacid = {$_W['uniacid']} AND mid = {$_W['mid']}");
	include wl_template('app/apply_list');
}

if($op == 'get'){
	$type = intval($_GPC['type']);
	$id = intval($_GPC['id']);
	if($type == 1){
		if($id){
			$re = pdo_update('weliam_shiftcar_apply', array('status' => 4), array('id' => $id));
			if($re){
				die(json_encode(array("result" => 1)));
			}else{
				die(json_encode(array("result" => 2)));
			}
		}else{
			die(json_encode(array("result" => 2)));
		}
	}elseif($type == 2){
		if($id){
			$re = pdo_update('weliam_shiftcar_apply', array('status' => 3), array('id' => $id));
			if($re){
				die(json_encode(array("result" => 1)));
			}else{
				die(json_encode(array("result" => 2)));
			}
		}else{
			die(json_encode(array("result" => 2)));
		}
	}else{
		die(json_encode(array("result" => 2)));
	}
}
if ($op == 'pay') {
	$orderno = $_GPC['orderno'];
	$order = pdo_get('weliam_shiftcar_apply', array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid'],'ordersn' => $orderno));
	$params = array(
        'tid' => $orderno,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
        'ordersn' => $orderno,  //收银台中显示的订单号
        'title' => '挪车卡邮费支付',          //收银台中显示的标题
        'fee' => $order['postage'],      //收银台中显示需要支付的金额,只能大于 0
        'user' => $_W['mid'],     //付款用户, 付款的用户名(选填项)
    );
    $this->pay($params);
}
if ( $op == 'times') {
	$times = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('weliam_shiftcar_apply')."WHERE uniacid = {$_W['uniacid']} AND mid = {$_W['mid']}");
	if ( !empty($_W['wlsetting']['apply']['times']) && $times >= $_W['wlsetting']['apply']['times'] ) {
		die(json_encode(array("result" => 2)));
	}else {
		die(json_encode(array("result" => 1)));
	}
}

if($op == 'storelist'){
	$stores = array();
	$remark_arr = pdo_fetchall('SELECT distinct sid FROM ' . tablename('weliam_shiftcar_qrcode') . "WHERE uniacid = {$_W['uniacid']} ");
	foreach ($remark_arr as $key => $value) {
		if(!empty($value['sid'])){
			$st = pdo_get('wlmerchant_merchantdata',array('uniacid'=>$_W['uniacid'],'id'=>$value['sid']));
			$st['location'] = unserialize($st['location']);
			$stores[] = $st;
		}
	}
	include wl_template('app/apply_storelist');
}

if($op == 'send_mail'){
	if($_W['ispost']){
		if($_W['wlmember']['status'] == 2){
			die(json_encode(array("result" => 1)));
		}
		$qrcode = pdo_get('weliam_shiftcar_qrcode',array('uniacid'=>$_W['uniacid'],'sid'=>-1,'status'=>1,'remark'=>$_W['wlsetting']['apply']['remark']));
		if($qrcode){
			$url = app_url('member/mycar/display',array('ncnum' => $qrcode['cardsn'],'salt' => $qrcode['salt'],'line'=>'mail'));
			die(json_encode(array("result" => 2,'msg'=>'挪车卡申请成功，去绑定','url'=>$url)));
		}
		die(json_encode(array("result" => 3,'msg'=>'挪车卡已使用完毕，暂时无法申请')));
	}
	if($_W['wlmember']['ncnumber']){
		$qrcode = pdo_get('weliam_shiftcar_qrcode', array('cardsn' => $_W['wlmember']['ncnumber'],'uniacid'=> $_W['uniacid']), array('qrid','model','salt'));
		if($qrcode['model'] == 2){
			$ticket = pdo_getcolumn('qrcode', array('id' => $qrcode['qrid']), 'url');
			$showurl = app_url('qr/qrcode/show',array('url' => urlencode($ticket)));
		}else{
			$showurl = app_url('qr/qrcode/show',array('ncnumber' => $_W['wlmember']['ncnumber'],'salt' => $qrcode['salt']));
		}
		$onlineqr = onlineqr::createPoster($_W['wlmember'], $showurl);
	}
	include wl_template('app/apply_send_mail');
}

if($op == 'send_mailajax'){
	$email = $_GPC['email'];
	if($email){
		$qrcode = pdo_get('weliam_shiftcar_qrcode', array('cardsn' => $_W['wlmember']['ncnumber'],'uniacid'=> $_W['uniacid']), array('qrid','model','salt'));
		if($qrcode['model'] == 2){
			$ticket = pdo_getcolumn('qrcode', array('id' => $qrcode['qrid']), 'url');
			$showurl = app_url('qr/qrcode/show',array('url' => urlencode($ticket)));
		}else{
			$showurl = app_url('qr/qrcode/show',array('ncnumber' => $_W['wlmember']['ncnumber'],'salt' => $qrcode['salt']));
		}
		$onlineqr = onlineqr::createPoster($_W['wlmember'], $showurl);
		$body = "<h3>微信挪车挪车卡二维码</h3> <br />";
		$body.= "<img src='".$onlineqr."'>";
		load()->func('communication');
		ihttp_email($email, '微信挪车挪车卡二维码', $body);
		die(json_encode(array("result" => 1)));
	}
	die(json_encode(array("result" => 2,'msg'=>'缺少邮箱地址，请重新填写')));
}
