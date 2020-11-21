<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'post';
$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '违章查询 - '.$_W['wlsetting']['base']['name'] : '违章查询';

if($op == 'post'){
	$member = $_W['wlmember'];
	$city = explode(',', $_W['wlsetting']['base']['abbre']);
	$city1 = !empty($city[0]) ? $city[0] : '京';
	$city2 = !empty($city[1]) ? strtoupper($city[1]) : 'A';
	$advs = newadv::get_adv(3);
	
	if($_W['ispost']){
		$data = array(
	        'plate1' => trim($_GPC['plate1']),
	        'plate2' => trim($_GPC['plate2']),
	        'plate_number' => strtoupper($_GPC['plate_number']),
	        'engine_number' => $_GPC['engine_number'],
	        'frame_number' => $_GPC['frame_number']
	    );
		if(empty($_W['wlmember']['frame_number']) || empty($_W['wlmember']['engine_number']) || empty($_W['wlmember']['plate_number'])){
			pdo_update('weliam_shiftcar_member',$data,array('id' => $_W['mid']));
		}
		$data['mobile'] = $_W['wlmember']['mobile'];
		$data['id'] = $_W['mid'];
		if($_W['wlsetting']['pecc']['lubang_api'] == 1){
			$jsonarr = model_pecc::lubang_api($data);
			$return = model_pecc::lubang_save($jsonarr,$data,2);
		}elseif($_W['wlsetting']['pecc']['jisu_api'] == 1){
			$jsonarr = model_pecc::jusu_api($data);
			$return = model_pecc::jusu_save($jsonarr,$data,2);
		}else{
			$jsonarr = model_pecc::free_api($data);
			$return = model_pecc::free_save($jsonarr,$data,2);
		}
		if($return == 2){
			die(json_encode(array("result" => 2)));
		}elseif($return == 1){
			die(json_encode(array("result" => 1)));
		}else{
			die(json_encode(array("result" => $return['status'],'msg' =>$return['msg'])));
		}
	}
	include wl_template('app/pecc_post');
}

if($op == 'list'){
	$cp = $_GPC['cp'];
	$order = pdo_getall('weliam_shiftcar_peccrecord', array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid'],'hphm'=>$cp));
	$listnum = count($order);
	$fen = 0;$money = 0;
	foreach ($order as $key => $value) {
		$fen += $value['fen'];
		$money += $value['money'];
	}
	include wl_template('app/pecc_list');
}

if ($op == 'seek') {
	$num = trim($_GPC['num']);
	$provinces = trim($_GPC['provinces']);
	if($_W['wlsetting']['pecc']['lubang_api'] == 1){
		$carmess = model_pecc::lubang_cities();
		foreach($carmess['data'] as $key => $prov){
			if (trim($prov['province_short_name']) == $provinces) {
				foreach($prov['citys'] as $key => $asd){
					if(trim($asd['car_head']) == $provinces){
						$fdjnum = $asd['engine_num'];
						$cjnum = $asd['body_num'];
					}
					if(trim($asd['car_head']) == $provinces.$num){
						$fdjnum = $asd['engine_num'];
						$cjnum = $asd['body_num'];
					}
				}
			}
		}
		if($fdjnum == -1) $fdjnum = 100;
		if($cjnum == -1) $cjnum = 100;
		die(json_encode(array("fdjnum" => intval($fdjnum),'cjnum' => intval($cjnum))));
	}elseif($_W['wlsetting']['pecc']['jisu_api'] == 1){
		$carmess = model_pecc::get_allcarorg();
		foreach($carmess['data'] as $key => $prov){
			if (trim($prov['lsprefix']) == $provinces) {
				if (empty($prov['list'])){
					$fdjnum = $prov['engineno'];
					$cjnum = $prov['frameno'];
				}else {
					foreach($prov['list'] as $key => $asd){
						if (trim($asd['lsnum']) == $num) {
							$fdjnum = $asd['engineno'];
							$cjnum = $asd['frameno'];
						}
					}
				}
			}
		}
		die(json_encode(array("fdjnum" => intval($fdjnum),'cjnum' => intval($cjnum))));
	}
	die(json_encode(array("fdjnum" => 100,'cjnum' => 100)));
}

if($op == 'mycar'){
	$remark_arr = pdo_fetchall('SELECT distinct hphm FROM ' . tablename('weliam_shiftcar_peccrecord') . "WHERE uniacid = {$_W['uniacid']} and mid = {$_W['mid']}");
	include wl_template('app/pecc_mycar');
}
