<?php
defined('IN_IA') or exit('Access Denied');

class Bdstoreqr_WeliamController{
	
	public function binding(){
		global $_W,$_GPC;
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '绑定二维码 - '.$_W['wlsetting']['base']['name'] : '绑定二维码';
		$qrcode = Storeqr::check_qrcode($_GPC['cardsn'], $_GPC['salt']);
		if($_W['ispost']){
			$storeid = intval($_GPC['storeid']);
			if(empty($storeid)) die(json_encode(array("result" => 2,'msg' => '缺少商户ID，请重新绑定')));
			$oldqr = pdo_getcolumn(PDO_NAME.'qrcode',array('uniacid' => $_W['uniacid'],'sid' => $storeid),'id');
			if($oldqr){
				pdo_update(PDO_NAME.'qrcode', array('sid' => 0,'status' => 3), array('id' => $oldqr['id']));
			}
			pdo_update(PDO_NAME.'qrcode', array('sid' => $storeid,'status' => 2), array('id' => $qrcode['id']));
			pdo_update(PDO_NAME.'merchantdata', array('cardsn' => $_GPC['cardsn']), array('id' => $storeid));
			die(json_encode(array("result" => 1)));
		}
		if($qrcode['sid'])  wl_message('二维码已绑定商户，请检查二维码是否可用！','close','warning');
		$storeids = pdo_getall(PDO_NAME . 'merchantuser', array('uniacid'=>$_W['uniacid'],'mid'=>$_W['mid'],'status'=>2,'enabled'=>1),'storeid');
		if(empty($storeids)) wl_message('您还不是商家或账户正在审核中，请先申请入驻平台。',app_url('store/storeManage/enter'),'warning');
		foreach ($storeids as $key => $value) {
			$stores[$key] = pdo_get(PDO_NAME . 'merchantdata', array('id'=>$value['storeid']),array('id','storename','cardsn'));
		}
		include wl_template('bdstoreqr/binding');
	}
	
	public function enterfast(){
		global $_W,$_GPC;
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '店铺快速入驻 - '.$_W['wlsetting']['base']['name'] : '店铺快速入驻';
		$qrcode = Storeqr::check_qrcode($_GPC['cardsn'], $_GPC['salt']);
		if(!empty($qrcode['sid'])) wl_message('二维码已绑定商户，请检查二维码是否可用！','close','warning');
		if(checksubmit('token')){
			$base = Setting::agentsetting_read('storeqr');
			$store = $_GPC['merchant'];
			$store['logo'] = $_GPC['images'][0];
			$store['location'] = serialize(array('lng'=>$_GPC['lng'],'lat'=>$_GPC['lat']));
			$store['uniacid'] = $_W['uniacid'];
			$store['aid'] = $_W['aid'];
			$store['areaid'] = $_W['areaid'];
			$store['createtime'] = time();
			$store['endtime'] = time()+365*24*60*60;
			if($base['status'] == 2){
				$store['enabled'] = 1;
			}else{
				$store['enabled'] = 0;
			}
			$store['status'] = 2;
			$store['cardsn'] = $_GPC['cardsn'];
			$arr['storeid'] = Store::registerEditData($store);
			
			$arr['name'] = $store['realname'];
			$arr['mobile'] = $store['tel'];
			$arr['createtime'] = time();
			$arr['areaid'] = $_W['areaid'];
			$arr['status'] = 2;
			$arr['enabled'] = 1;
			$arr['ismain'] = 1;
			$arr['uniacid'] = $_W['uniacid'];
			$arr['aid'] = $_W['aid'];
			$arr['mid'] = $_W['mid'];
			pdo_insert(PDO_NAME.'merchantuser', $arr);
			$re = pdo_update(PDO_NAME.'qrcode', array('sid' => $arr['storeid'],'status' => 2), array('id' => $qrcode['id']));
			if($re){
				wl_message('入驻成功，去管理我的店铺',app_url('store/storeManage/enter'),'success');
			}else{
				wl_message('入驻失败，请重新提交','close','warning');
			}
		}
		include wl_template('bdstoreqr/enterfast');
	}
}
?>