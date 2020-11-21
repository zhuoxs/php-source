<?php
defined('IN_IA') or exit('Access Denied');

class Register_WeliamController{
	/*
	 * 申请展示
	 */
	public function index(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		
		$where['uniacid'] =  $_W['uniacid'];
		$where['aid'] =  $_W['aid']; 
        $where['status'] = array(0, 1); 
		
		$registers = pdo_getslice('wlmerchant_merchantuser', $where, array($pindex, $psize) , $total, array(), '', "id DESC");
		$pager = pagination($total, $pindex, $psize);
		foreach($registers as $key => $value){
			$registers[$key]['member'] = Member::getMemberByMid($value['mid'],array('id','nickname'));
			$registers[$key]['storedata'] = Store::getSingleStore($value['storeid']);
		}
		
		include wl_template('store/registerIndex');
	}
	
	/*
	 * 添加商户
	 */
	public function add(){
		global $_W,$_GPC;
		if($_GPC['op']=='selectnickname'){
			//搜索会员
			$con = "uniacid='{$_W['uniacid']}' ";
			$keyword = $_GPC['keyword'];
			if ($keyword != '') {
				$con .= " and (openid LIKE '%{$keyword}%' or uid LIKE '%{$keyword}%' or nickname LIKE '%{$keyword}%') ";
			}
			$ds =Store::registerNickname($con);
			if($ds){
				foreach ($ds as $key => &$v) {
					$v['nickname'] = str_replace("'",'',$v['nickname']);
				}
			}
			include wl_template('store/registerQueryNickname');exit;
		}
	}
	
	/*
	 * 编辑申请
	 */
	public function edit(){
		global $_W,$_GPC;
		if($_GPC['op']=='reject'){
			if(pdo_update(PDO_NAME . 'merchantdata',array('status'=>3),array('id'=>$_GPC['id']))){
				Store::editSingleRegister($_GPC['uid'], array('status'=>3,'reject'=>$_GPC['reject']));
				$member = pdo_get('wlmerchant_merchantuser',array('id' => $_GPC['uid']),array('mid'));
				$member = pdo_get('wlmerchant_member',array('id' => $member['mid']),array('openid'));
				$openid = $member['openid'];
				$store = pdo_get('wlmerchant_merchantdata',array('id' => $_GPC['id']),array('storename'));
				$storename = $store['storename'];
				Message::settledSuccess($openid,$storename,'reject');
				wl_message('驳回成功',referer(),'succuss');
			}else{
				wl_message('驳回失败',referer(),'error');
			}
		}
		if($_GPC['op']=='pass'){
			if(pdo_update(PDO_NAME . 'merchantdata',array('status'=>2,'enabled'=>1),array('id'=>$_GPC['id']))){
				Store::editSingleRegister($_GPC['uid'], array('status'=>2,'reject'=>$_GPC['reject']));
				$member = pdo_get('wlmerchant_merchantuser',array('id' => $_GPC['uid']),array('mid'));
				$member = pdo_get('wlmerchant_member',array('id' => $member['mid']),array('openid'));
				$openid = $member['openid'];
				$store = pdo_get('wlmerchant_merchantdata',array('id' => $_GPC['id']),array('storename'));
				$storename = $store['storename'];
				Message::settledSuccess($openid,$storename,'pass');
				wl_message('通过操作成功',web_url('store/merchant/index',array('enabled'=>1)),'succuss');
			}else{
				wl_message('通过操作失败',referer(),'error');
			}
		}
		if($_GPC['op']=='del'){
			if(pdo_delete(PDO_NAME . 'merchantuser',array('id'=>$_GPC['uid']))){
				pdo_delete(PDO_NAME . 'merchantdata', array('id'=>$_GPC['id']));
				wl_message('删除申请成功',referer(),'succuss');
			}else{
				wl_message('删除申请失败',referer(),'error');
			}
		}
	}

	/*
	 * 入驻设置
	 */
	public function set(){
		global $_W,$_GPC;
		if($_GPC['set']){
			$_GPC['set']['detail'] = htmlspecialchars_decode($_GPC['set']['detail']);
			$res1 = Setting::agentsetting_save($_GPC['set'], 'register');
			wl_message('保存成功！',referer(),'succuss');
		}
		$set = Setting::agentsetting_read('register');
		include wl_template('store/registerSet');exit;
	}
	//付费记录
	public function chargerecode(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$where = array(
			'uniacid' => $_W['uniacid'],
			'aid'     => $_W['aid'],
			'status'  => 3,
			'plugin'  => 'store'
		);
		
		if($_GPC['orderid']){
			$where['id'] = $_GPC['orderid'];
		}
		
		$records = pdo_getslice('wlmerchant_order', $where, array($pindex, $psize) , $total, array(), '', "id DESC");
		$pager = pagination($total, $pindex, $psize);
		
		foreach ($records as $key => &$re){
			$merchant = pdo_get('wlmerchant_merchantdata',array('id' => $re['sid']),array('logo','storename'));
			$re['logo'] = $merchant['logo'];
			$re['storename'] = $merchant['storename'];
			$re['typename'] = pdo_getcolumn(PDO_NAME.'chargelist',array('id'=>$re['fkid']),'name');
		}
		
		
		include wl_template('store/chargerecode');exit;
	}
	//付费设置
	public function agentcharge(){
		global $_W,$_GPC;
		$pindex = max(1, $_GPC['page']);
		$listData = Util::getNumData("*", PDO_NAME . 'chargelist', array('uniacid' => $_W['uniacid'],'aid'=>$_W['aid']), 'sort desc', $pindex, 10, 1);
		$list = $listData[0];
		$page = $listData[1];
		include wl_template('store/chargelist');
	}
	//添加信息
	public function chargeadd(){
		global $_W, $_GPC;
		$memberType = $_GPC['data'];
		if ($_GPC['id']) {
			$data = Util::getSingelData("*", PDO_NAME . 'chargelist', array('id' => $_GPC['id']));
		}
		if ($_GPC['data']) {
			$memberType['uniacid'] = $_W['uniacid'];
			$memberType['aid'] = $_W['aid'];
			if ($_GPC['id']) {
				pdo_update(PDO_NAME . 'chargelist', $memberType, array('id' => $_GPC['id']));
			} else {
				pdo_insert(PDO_NAME . 'chargelist', $memberType);
			}
			wl_message('操作成功！', web_url('store/register/agentcharge'), 'success');
		}
		include  wl_template('store/chargeadd');
	}
	public function delete() {
		global $_W, $_GPC;
		pdo_delete(PDO_NAME . 'chargelist', array('id' => $_GPC['id']));
		wl_message('操作成功！', web_url('setting/register/chargelist'), 'success');
	}
	
}
