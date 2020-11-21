<?php
defined('IN_IA') or exit('Access Denied');

class Register_WeliamController{
		
	public function baseset(){
		global $_W,$_GPC;
		$register = Setting::wlsetting_read('register');
		if (checksubmit('submit')){
			$base = $_GPC['base'];
			$base['detail'] = htmlspecialchars_decode($base['detail']);
			$base['description'] = htmlspecialchars_decode($base['description']);
			Setting::wlsetting_save($base,'register');
			wl_message('设置成功', 'referer', 'success');
		}
		include wl_template('setting/register');
	}
	
	public function chargelist(){
		global $_W,$_GPC;
		$pindex = max(1, $_GPC['page']);
		$listData = Util::getNumData("*", PDO_NAME . 'chargelist', array('uniacid' => $_W['uniacid']), 'sort desc', $pindex, 10, 1);
		$list = $listData[0];
		$page = $listData[1];
		foreach ($list as $key => &$v) {
			if($v['aid']){
				$v['agentname'] = pdo_getcolumn(PDO_NAME.'agentusers',array('id'=>$v['aid']),'agentname');
			}else{
				$v['agentname'] = '全部代理';
			}
		}
		include wl_template('setting/chargelist');
	}
	
	public function add() {
		global $_W, $_GPC;
		$memberType = $_GPC['data'];
		$agents = pdo_getall('wlmerchant_agentusers',array('uniacid' => $_W['uniacid'],'status'=>1),array('id','agentname'));
		if ($_GPC['id']) {
			$data = Util::getSingelData("*", PDO_NAME . 'chargelist', array('id' => $_GPC['id']));
		}
		if ($_GPC['data']) {
			$memberType['uniacid'] = $_W['uniacid'];
			if ($_GPC['id']) {
				pdo_update(PDO_NAME . 'chargelist', $memberType, array('id' => $_GPC['id']));
			} else {
				pdo_insert(PDO_NAME . 'chargelist', $memberType);
			}
			wl_message('操作成功！', web_url('setting/register/chargelist'), 'success');
		}
		include  wl_template('setting/chargeadd');
	}

	public function delete() {
		global $_W, $_GPC;
		pdo_delete(PDO_NAME . 'chargelist', array('id' => $_GPC['id']));
		wl_message('操作成功！', web_url('setting/register/chargelist'), 'success');
	}
}