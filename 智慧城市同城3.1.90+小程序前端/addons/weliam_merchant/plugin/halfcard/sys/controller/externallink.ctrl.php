<?php
defined('IN_IA') or exit('Access Denied');

class Externallink_WeliamController {
	//外链礼包列表
	public function lists() {
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$where = array('uniacid'=>$_W['uniacid'],'type'=>1);
		if ($_GPC['keyword']){
			$keyword = trim($_GPC['keyword']);
			$where['title@'] = $keyword;
		}
		if($_GPC['status']){
			if($_GPC['status'] == 4){
				$where['status'] = 0;
			}else{
				$where['status'] = $_GPC['status'];
			}
		}
		$packagelist = Halfcard::getNumPackActive('*',$where,'sort DESC', $pindex, $psize, 1);
		$pager = $packagelist[1];
		$packagelist = $packagelist[0];
		foreach($packagelist as $key => &$package){
			$merchant = unserialize($package['extinfo']);
			$package['storename'] = $merchant['storename'];
			$package['logo'] = $merchant['storelogo'];
			if($package['packtimestatus']){
				$package['datestarttime'] = date('Y-m-d H:i',$package['datestarttime']);
				$package['dateendtime'] = date('Y-m-d H:i',$package['dateendtime']);
			}
		}
		include wl_template('halfcardsys/extlinklist');
	}
	
	//外链礼包编辑
	public function createpackage(){
		global $_W, $_GPC;
		$id = $_GPC['id'];
		$levels = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_halflevel')."WHERE uniacid = {$_W['uniacid']} AND status = 1 ORDER BY sort DESC"); 
		if($id){
			$package = pdo_get('wlmerchant_package',array('id' => $id));
			$extinfo = unserialize($package['extinfo']);
			$package['storename'] = $extinfo['storename'];
			$package['storelogo'] = $extinfo['storelogo'];
			$package['level'] = unserialize($package['level']);
			$datestarttime = $package['datestarttime'];
			$dateendtime = $package['dateendtime'];
		}
		
		if(empty($datestarttime) || empty($dateendtime)){
			$datestarttime = time();
			$dateendtime = strtotime('+1 month');
		}
		
		if (checksubmit('submit')) {
			$package = $_GPC['package'];
			$extinfo = $_GPC['extinfo'];
			if(empty($package['title'])) wl_message('请填写活动名称');
			if(empty($package['price'])) wl_message('请填写礼包价值');
			if(empty($package['extlink'])) wl_message('请填写礼包外链地址');
			if ($package['status'] == 'on') {
				$package['status'] = 1;
			} else {
				$package['status'] = 0;
			}
			$package['describe'] = htmlspecialchars_decode($package['describe']);
			$package['extinfo'] = serialize($extinfo);
			$package['level'] = serialize($package['level']);
			$datetime = $_GPC['datetime'];
			$package['datestarttime'] = strtotime($datetime['start']);
			$package['dateendtime'] = strtotime($datetime['end']);
			if(empty($id)){
				$package['uniacid'] = $_W['uniacid'];
				$package['type'] = 1;
				$package['createtime'] = time();
				$res = pdo_insert(PDO_NAME.'package',$package);
			}else {
				$res = pdo_update(PDO_NAME.'package',$package,array('id' => $id));
			}
			if ($res){
				wl_message('操作成功',web_url('halfcard/externallink/lists'),'success');
			} else {
				wl_message('操作失败', referer(), 'error');
			}
		}	
		include  wl_template('halfcardsys/createpackage');
	}
	
	//外链礼包列表修改函数
    function changeinfo(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$type = $_GPC['type'];
		$newvalue = trim($_GPC['value']);
		if($type == 1){
			$res = pdo_update('wlmerchant_package',array('title'=>$newvalue),array('id' => $id));
		}elseif ($type == 2) {
			$res = pdo_update('wlmerchant_package',array('pv'=>$newvalue),array('id' => $id));
		}elseif ($type == 3) {
			$res = pdo_update('wlmerchant_package',array('sort'=>$newvalue),array('id' => $id));
		}elseif ($type == 4) {
			$res = pdo_delete('wlmerchant_package',array('id'=>$id));
		}elseif ($type == 5) {
			$res = pdo_update('wlmerchant_package',array('limit'=>$newvalue),array('id' => $id));
		}
		if($res){
			show_json(1,'修改成功');
		}else {
			show_json(0,'修改失败，请重试');
		}
	}
	
	//外链特权列表
	public function halflists() {
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$where = array('uniacid'=>$_W['uniacid'],'type'=>1);
		if ($_GPC['keyword']){
			$keyword = trim($_GPC['keyword']);
			$where['title@'] = $keyword;
		}
		if($_GPC['status']){
			if($_GPC['status'] == 4){
				$where['status'] = 0;
			}else{
				$where['status'] = $_GPC['status'];
			}
		}
		$halflist = Halfcard::getNumActive('*',$where,'sort DESC', $pindex, $psize, 1);
		$pager = $halflist[1];
		$halflist = $halflist[0];
		foreach($halflist as $key => &$half){
			$merchant = unserialize($half['extinfo']);
			$half['storename'] = $merchant['storename'];
			$half['logo'] = $merchant['storelogo'];
			if($half['timingstatus']){
				$half['starttime'] = date('Y-m-d H:i',$half['starttime']);
				$half['endtime'] = date('Y-m-d H:i',$half['endtime']);
			}
		}
		include wl_template('halfcardsys/exthalflist');
	}
	
	//外链特权编辑
	public function createhalfcard(){
		global $_W, $_GPC;
		$id = $_GPC['id'];
		$levels = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_halflevel')."WHERE uniacid = {$_W['uniacid']} AND status = 1 ORDER BY sort DESC"); 
		if($id){
			$halfcard = pdo_get('wlmerchant_halfcardlist',array('id' => $id));
			$extinfo = unserialize($halfcard['extinfo']);
			$halfcard['storename'] = $extinfo['storename'];
			$halfcard['storelogo'] = $extinfo['storelogo'];
			$halfcard['level'] = unserialize($halfcard['level']);
			$datestarttime = $halfcard['starttime'];
			$dateendtime = $halfcard['endtime'];
		}
		
		if(empty($datestarttime) || empty($dateendtime)){
			$datestarttime = time();
			$dateendtime = strtotime('+1 month');
		}
		
		if (checksubmit('submit')) {
			$halfcard = $_GPC['halfcard'];
			$extinfo = $_GPC['extinfo'];
			if(empty($halfcard['title'])) wl_message('请填写活动名称');
			if(empty($halfcard['activediscount'])) wl_message('请填写活动折扣');
			if(empty($halfcard['extlink'])) wl_message('请填写活动外链地址');
			if ($halfcard['status'] == 'on') {
				$halfcard['status'] = 1;
			} else {
				$halfcard['status'] = 0;
			}
			$halfcard['activediscount'] = sprintf("%.1f",$halfcard['activediscount']);
			$halfcard['describe'] = htmlspecialchars_decode($halfcard['describe']);
			$halfcard['extinfo'] = serialize($extinfo);
			$halfcard['level'] = serialize($halfcard['level']);
			$datetime = $_GPC['datetime'];
			$halfcard['starttime'] = strtotime($datetime['start']);
			$halfcard['endtime'] = strtotime($datetime['end']);
			if(empty($id)){
				$halfcard['uniacid'] = $_W['uniacid'];
				$halfcard['type'] = 1;
				$halfcard['aid'] = 0;
				$halfcard['createtime'] = time();
				$res = pdo_insert(PDO_NAME.'halfcardlist',$halfcard);
			}else {
				$res = pdo_update(PDO_NAME.'halfcardlist',$halfcard,array('id' => $id));
			}
			if ($res){
				wl_message('操作成功',web_url('halfcard/externallink/halflists'),'success');
			} else {
				wl_message('操作失败', referer(), 'error');
			}
		}	
		include  wl_template('halfcardsys/createhalfcard');
	}
	
	//外链特权列表修改函数
    function changehalf(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$type = $_GPC['type'];
		$newvalue = trim($_GPC['value']);
		if($type == 1){
			$res = pdo_update('wlmerchant_halfcardlist',array('title'=>$newvalue),array('id' => $id));
		}elseif ($type == 2) {
			$res = pdo_update('wlmerchant_halfcardlist',array('pv'=>$newvalue),array('id' => $id));
		}elseif ($type == 3) {
			$res = pdo_update('wlmerchant_halfcardlist',array('sort'=>$newvalue),array('id' => $id));
		}elseif ($type == 4) {
			$res = pdo_delete('wlmerchant_halfcardlist',array('id'=>$id));
		}elseif ($type == 5) {
			$res = pdo_update('wlmerchant_halfcardlist',array('limit'=>$newvalue),array('id' => $id));
		}
		if($res){
			show_json(1,'修改成功');
		}else {
			show_json(0,'修改失败，请重试');
		}
	}
	
	//外链卡券列表
	public function couponlists() {
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$where = array('uniacid'=>$_W['uniacid'],'extflag'=>1);
		if ($_GPC['keyword']){
			$keyword = trim($_GPC['keyword']);
			$where['title@'] = $keyword;
		}
		if($_GPC['status']){
			if($_GPC['status'] == 4){
				$where['status'] = 0;
			}else{
				$where['status'] = $_GPC['status'];
			}
		}
		$couponlist = wlCoupon::getNumCoupons('*',$where,'indexorder DESC', $pindex, $psize, 1);
		
		$pager = $couponlist[1];
		$couponlist = $couponlist[0];
		foreach($couponlist as $key => &$cou){
			$merchant = unserialize($cou['extinfo']);
			$cou['storename'] = $merchant['storename'];
			$cou['timingstatus'] = 1;
			$cou['starttime'] = date('Y-m-d H:i',$cou['starttime']);
			$cou['endtime'] = date('Y-m-d H:i',$cou['endtime']);
		}
		include wl_template('halfcardsys/extcoulist');
	}
	
	//外链卡券编辑
	public function createcoupon(){
		global $_W, $_GPC;
		$id = $_GPC['id'];
		$levels = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_halflevel')."WHERE uniacid = {$_W['uniacid']} AND status = 1 ORDER BY sort DESC"); 
		if($id){
			$coupon = pdo_get('wlmerchant_couponlist',array('id' => $id));
			$extinfo = unserialize($coupon['extinfo']);
			$coupon['storename'] = $extinfo['storename'];
			$coupon['storelogo'] = $extinfo['storelogo'];
			$coupon['level'] = unserialize($coupon['level']);
			$datestarttime = $coupon['starttime'];
			$dateendtime = $coupon['endtime'];
		}
		
		if(empty($datestarttime) || empty($dateendtime)){
			$datestarttime = time();
			$dateendtime = strtotime('+1 month');
		}
		
		if (checksubmit('submit')) {
			$coupon = $_GPC['coupon'];
			$extinfo = $_GPC['extinfo'];
			if(empty($coupon['title'])) wl_message('请填写卡券名称');
			if(empty($coupon['price'])) wl_message('请填写卡券价值');
			if(empty($coupon['extlink'])) wl_message('请填写卡券外链地址');
			if ($coupon['status'] == 'on') {
				$coupon['status'] = 1;
			} else {
				$coupon['status'] = 0;
			}
			$coupon['description'] = htmlspecialchars_decode($coupon['description']);
			$coupon['extinfo'] = serialize($extinfo);
			$coupon['level'] = serialize($coupon['level']);
			$datetime = $_GPC['datetime'];
			$coupon['starttime'] = strtotime($datetime['start']);
			$coupon['endtime'] = strtotime($datetime['end']);
			if(empty($id)){
				$coupon['uniacid'] = $_W['uniacid'];
				$coupon['extflag'] = 1;
				$coupon['vipstatus'] = 1;
				$coupon['aid'] = 0;
				$coupon['createtime'] = time();
				$res = pdo_insert(PDO_NAME.'couponlist',$coupon);
			}else {
				$res = pdo_update(PDO_NAME.'couponlist',$coupon,array('id' => $id));
			}
			if ($res){
				wl_message('操作成功',web_url('halfcard/externallink/couponlists'),'success');
			} else {
				wl_message('操作失败', referer(), 'error');
			}
		}	
		include  wl_template('halfcardsys/createcoupon');
	}

	//外链卡券列表修改函数
    function changecou(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$type = $_GPC['type'];
		$newvalue = trim($_GPC['value']);
		if($type == 1){
			$res = pdo_update('wlmerchant_couponlist',array('title'=>$newvalue),array('id' => $id));
		}elseif ($type == 2) {
			$res = pdo_update('wlmerchant_couponlist',array('pv'=>$newvalue),array('id' => $id));
		}elseif ($type == 3) {
			$res = pdo_update('wlmerchant_couponlist',array('indexorder'=>$newvalue),array('id' => $id));
		}elseif ($type == 4) {
			$res = pdo_delete('wlmerchant_couponlist',array('id'=>$id));
		}elseif ($type == 5) {
			$res = pdo_update('wlmerchant_couponlist',array('sub_title'=>$newvalue),array('id' => $id));
		}
		if($res){
			show_json(1,'修改成功');
		}else {
			show_json(0,'修改失败，请重试');
		}
	}
	
	
}
?>