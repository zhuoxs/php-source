<?php
defined('IN_IA') or exit('Access Denied');

class StoreManage_WeliamController{
	/*
	 * 管理首页 （首页。申请状态，入驻状态）
	 */
	public function index(){
		global $_W,$_GPC;
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '入驻状态 - '.$_W['wlsetting']['base']['name'] : '入驻状态';
		$ueseid = $_GPC['userid'];
		if($ueseid){
			$users = pdo_get(PDO_NAME . 'merchantuser', array('id' => $ueseid));
		}else {
			$users = Store::getSingleRegister($_W['mid']);
		}
		if(empty($users)) header('location: '.app_url('store/supervise/information',array('applyflag'=>1)));
		if(!empty($users['storeid'])){
			$data = Store::getSingleStore($users['storeid']);
			if(empty($data)){
				$res = pdo_delete('wlmerchant_merchantuser',array('id'=>$users['id']));
				header('location: '.app_url('store/supervise/information',array('applyflag'=>1)));
			}else {
				isetcookie('__wl_storeid',$data['id'], 7 * 86400);
			} 		
		}
		$ingflag = pdo_get(PDO_NAME . 'merchantuser', array('mid' => $users['mid'],'uniacid'=>$_W['uniacid'],'aid'=>$_W['aid'],'status'=>1));
        //diy信息获取
        if(p('diypage')){
            //首页菜单
            if (!empty($_W['agentset']['diypageset']['menu_index'])) {
                $menudata = Diy::getMenu($_W['agentset']['diypageset']['menu_index']);
            }
        }


		include wl_template('store/passing');
	}
	
	/*
	 * 进入申请
	 */
	public function enter(){
		global $_W,$_GPC;
		if(empty($_GPC['newflag'])){
			$me = Store::getSingleRegister($_W['mid']);
			if(!empty($me) && empty($_GPC['mid'])){
				header('location: '.app_url('store/storeManage/index'));
			}else {
				header('location: '.app_url('store/supervise/information',array('applyflag'=>1)));
			}
//			$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '入驻申请 - '.$_W['wlsetting']['base']['name'] : '入驻申请';
//			if(!empty($me['storeid'])) $data = Store::getSingleStore($me['storeid']);
		}else {
			header('location: '.app_url('store/supervise/information',array('applyflag'=>1)));
		}	
	}
	
	/*
	 * 取消申请
	 */
	public function cancel(){
		global $_W,$_GPC;
		$userid = $_GPC['userid'];
		$re = Store::deleteStoreByMid($userid);
		if($re){
			header('location: '.app_url('store/supervise/information',array('applyflag'=>1)));
		}else{
			wl_message('取消申请失败！');
		}
	}
	/*
	 * 重新申请
	 */
	public function again(){
		global $_W,$_GPC;
		$userid = $_GPC['userid'];
		$res = pdo_update(PDO_NAME.'merchantuser',array('status'=>1,'reject'=>''),array('id'=>$userid));
		if($res){
			$storeid = pdo_getcolumn(PDO_NAME.'merchantuser',array('id'=>$userid),'storeid');
			pdo_update(PDO_NAME.'merchantdata',array('status'=>1),array('id'=>$storeid));
			header('location: '.app_url('store/supervise/information',array('applyflag'=>1,'storeid'=>$storeid)));
		}else {
			wl_message('重新申请失败！');
		}
		
	}
	
	/*
	 * 管理员审核页面
	 */
	public function adminpage(){
		global $_W,$_GPC;
		$admin = pdo_get('wlmerchant_agentadmin',array('mid' => $_W['mid']));
		if($admin['manage']){
			$storeid = $_GPC['appstoreid'];
			$data = Store::getSingleStore($storeid);
			$users = pdo_get('wlmerchant_merchantuser',array('uniacid' => $_W['uniacid'],'aid'=> $_W['aid'],'storeid'=>$storeid,'ismain'=>1));

            //diy信息获取
            if(p('diypage')){
                //首页菜单
                if (!empty($_W['agentset']['diypageset']['menu_index'])) {
                    $menudata = Diy::getMenu($_W['agentset']['diypageset']['menu_index']);
                }
            }

			include wl_template('store/adminpage');
		}else {
			wl_message('无审核权限','close','error');
		}
		
	}
	/*
	 * 管理员通过审核流程
	 */
	public function passing(){
		global $_W,$_GPC;
		$storeid = $_GPC['storeid'];
		$res = pdo_update(PDO_NAME.'merchantdata',array('status'=>2,'enabled'=>1),array('id'=>$storeid));
		if($res){
			$user = pdo_get(PDO_NAME.'merchantuser',array('storeid' => $storeid),array('id','mid'));
			pdo_update(PDO_NAME.'merchantuser',array('status'=>2),array('id'=>$user['id']));
			$member = pdo_get('wlmerchant_member',array('id' => $user['mid']),array('openid'));
			$openid = $member['openid'];
			$store = pdo_get('wlmerchant_merchantdata',array('id' => $storeid),array('storename'));
			$storename = $store['storename'];
			Message::settledSuccess($openid,$storename,'pass');
			header('location: '.app_url('store/storeManage/adminpage',array('appstoreid'=> $storeid)));
		}
	}
	
	/*
	 * 管理员驳回审核流程
	 */
	public function reject(){
		global $_W,$_GPC;
		$storeid = $_GPC['storeid'];
		$reject = $_GPC['reject'];
		$res = pdo_update(PDO_NAME.'merchantdata',array('status'=>3),array('id'=>$storeid));
		if($res){
			$user = pdo_get(PDO_NAME.'merchantuser',array('storeid' => $storeid,'uniacid'=>$_W['uniacid'],'aid'=>$_W['aid']),array('id','mid'));
			pdo_update(PDO_NAME.'merchantuser',array('status'=>0,'reject'=>$reject),array('id'=>$user['id']));
			$member = pdo_get('wlmerchant_member',array('id' => $user['mid']),array('openid'));
			$openid = $member['openid'];
			$store = pdo_get('wlmerchant_merchantdata',array('id' => $storeid),array('storename'));
			$storename = $store['storename'];
			Message::settledSuccess($openid,$storename,'reject');
			header('location: '.app_url('store/storeManage/adminpage',array('appstoreid'=> $storeid)));
		}
	}
	
	/*
	 * 审核申请资料
	 */
	public function checkApplyAccount(){
		global $_W,$_GPC;
		$set = Setting::wlsetting_read('register');
		$store['storename'] = trim($_GPC['storename']);
		$store['uniacid'] = $_W['uniacid'];
		$store['aid'] = $_W['aid'];
		$store['areaid'] = $_W['areaid'];
		$store['createtime'] = time();
		if($set['chargestatus']){
			$store['status'] = 0;
			$store['endtime'] = time();
		}else {
			$store['status'] = 1;
			$store['endtime'] = time()+365*24*60*60;
		}		
		$store['enabled'] = 0;
		$store['realname'] = trim($_GPC['name']);
		$store['tel'] = $_GPC['mobile'];
		$store['score'] = 5;
		$store['groupid'] = pdo_getcolumn(PDO_NAME.'storeusers_group',array('uniacid'=>$_W['uniacid'],'aid'=>$_W['aid'],'isdefault'=>1),'id');
		$arr['storeid'] = Store::registerEditData($store,$_GPC['id']);
		
		$arr['name'] = trim($_GPC['name']);
		$arr['mobile'] = $_GPC['mobile'];
		$arr['createtime'] = time();
		$arr['areaid'] = $_W['areaid'];
		$arr['limit'] = serialize($_GPC['funcs']);
		$arr['status'] = 1;
		$arr['enabled'] = 1;
		$arr['ismain'] = 1;
		$arr['uniacid'] = $_W['uniacid'];
		$arr['aid'] = $_W['aid'];
		$re = Store::saveSingleRegister($arr,$_GPC['mid']);
		isetcookie('__wl_storeid',$arr['storeid'], 7 * 86400);
		die(json_encode(array('status'=>$re,'data'=>$_GPC['funcs'])));
	}
		
	public function a(){
		include wl_template('store/passing');
	}
}
