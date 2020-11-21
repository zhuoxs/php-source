<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('display','post','get','seek','findnum');
$op = in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'display';
$title = !empty($_GPC['ncnum']) ? '绑定挪车卡 ' : '我的车辆';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? $title.' - '.$_W['wlsetting']['base']['name'] : $title;

if ($op == 'display') {
	if(!empty($_GPC['ncnum'])){
		qrcard::check_qrcode($_GPC['ncnum'], $_GPC['salt']);
	}
    $member = $_W['wlmember'];
    $brands = pdo_fetchall('select * from ' . tablename('weliam_shiftcar_brand'));
	$brand = array();
	for ($i=1; $i <= 27; $i++) {
        $brand[$i] = returnnum_array($brands,$i);
    }
	$city = explode(',', $_W['wlsetting']['base']['abbre']);
	$city1 = !empty($city[0]) ? $city[0] : '京';
	$city2 = !empty($city[1]) ? strtoupper($city[1]) : 'A';
	
    include wl_template('member/mycar');
}

if ($op == 'post') {
    $data = array(
        'brand' => trim($_GPC['brand']) ,
        'brandimg' => $_GPC['brandimgv'],
        'plate1' => trim($_GPC['plate1']),
        'plate2' => trim($_GPC['plate2']),
        'plate_number' => strtoupper($_GPC['plate_number']),
        'engine_number' => $_GPC['engine_number'],
        'frame_number' => $_GPC['frame_number']
    );
	if($_GPC['ncnumber']){
		$qrcard = pdo_get('weliam_shiftcar_qrcode',array('cardsn' => trim($_GPC['ncnumber']),'uniacid'=>$_W['uniacid']));
		if($qrcard['status'] != 1){
			die(json_encode(array("result" => 2,'msg' => '挪车卡不存在或已失效')));
		}
		if($_W['wlsetting']['veri']['bdstatus'] != 1){
			$session = json_decode(base64_decode($_GPC['__auth_session']), true);
			if(is_array($session)) {
				if($session['mobile'] != $_GPC['mobile']){
					die(json_encode(array("result" => 2,'msg' => '手机号码不匹配')));
				}
				if($session['code'] != $_GPC['inputcode']){
					die(json_encode(array("result" => 2,'msg' => '验证码错误，请重试')));
				}
			}else{
				die(json_encode(array("result" => 2,'msg' => '验证码已过期，请重新发送')));	
			}
		}
		$data['ncnumber'] = trim($_GPC['ncnumber']);
		$data['mobile'] = trim($_GPC['mobile']);
		$data['acttime'] = time();
		$data['status'] = 2;
		$data['mstatus'] = 1;
		pdo_update('weliam_shiftcar_qrcode', array('mid' => $_W['mid'],'status' => 2), array('cardsn' => trim($_GPC['ncnumber']),'uniacid'=>$_W['uniacid']));
		if($_W['wlmember']['ncnumber']){
			pdo_update('weliam_shiftcar_qrcode', array('mid' => 0,'status' => 3), array('cardsn' => $_W['wlmember']['ncnumber'],'uniacid'=>$_W['uniacid']));
		}
		
		if(pdo_tableexists('wlmerchant_member')){
			//绑定挪车卡，赠送VIP
			if($_W['wlsetting']['merchant']['vipstatus'] == 2 && !empty($_W['wlsetting']['merchant']['viptime'])){
				$member_s = pdo_get('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']), array('vipstatus','lastviptime'));
				if(empty($member_s)) wl_merge_member($data);
				if($member_s['vipstatus'] == 1){
					$lastviptime = 60*60*24*$_W['wlsetting']['merchant']['viptime'] + $member_s['lastviptime'];
				}else{
					$lastviptime = 60*60*24*$_W['wlsetting']['merchant']['viptime'] + time();
				}
				pdo_update('wlmerchant_member',array('vipstatus'=>1,'lastviptime'=>$lastviptime),array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']));
			}
			//绑定挪车卡，成为店铺粉丝
			if(!empty($qrcard['sid'])){
				$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$_W['openid']), 'id');
				if(empty($mid)) wl_merge_member($data);
				pdo_insert('wlmerchant_storefans',array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'sid'=>$qrcard['sid']));
			}
		}
	}

    $re = pdo_update('weliam_shiftcar_member', $data, array('id' => $_W['mid'],'uniacid'=>$_W['uniacid']));
    if ($re) {
    	if($_GPC['ncnumber']){
    		if($_GPC['line'] == 'mail'){
    			die(json_encode(array("result" => 3,'url' => app_url('app/apply/send_mail'))));
    		}
    		die(json_encode(array("result" => 3)));
    	}
        die(json_encode(array("result" => 1)));
    } else {
        die(json_encode(array("result" => 2,'msg' => '车辆信息保存失败')));
    }
}

if ($op == 'get') {
    $bid = intval($_GPC['bid']);
    $brand = pdo_fetch('select * from ' . tablename('weliam_shiftcar_brand') . "where id = '{$bid}'");
    $class = pdo_fetchall('select name,id from ' . tablename('weliam_shiftcar_class') . "where brandid = '{$bid}'");
    $result = '<div class="panel panel-right panel-cover" id="panel-right-demo' . $bid . '" style="z-index: 99999;background: #FFFFFF;box-shadow: 0 0 1rem rgba(0, 0, 0, 0.3);"><div class="content-block" style="padding: 0;margin: 0;"><div class="list-block contacts-block" style="margin-top: 0rem;">';
    foreach ($class as $key => $value) {
        $result.= '<div class="list-group"><ul><li class="list-group-title">' . $value['name'] . '</li>';
        $sclass = pdo_fetchall('select name from ' . tablename('weliam_shiftcar_sclass') . "where classid = '{$value['id']}'");
        foreach ($sclass as $key1 => $value1) {
            $result.= '<li><a href="javascript:addbrand(' . "'" . trim($brand['brand']) . " — " . $value1['name'] . "','" . $brand['imgs'] . "'" . ');" class="item-link item-content external"><div class="item-inner"><div class="item-title">' . $value1['name'] . '</div></div></a></li>';
        }
        $result.= '</ul></div>';
    }
    $result.= '</div></div></div>';
    echo $result;
}