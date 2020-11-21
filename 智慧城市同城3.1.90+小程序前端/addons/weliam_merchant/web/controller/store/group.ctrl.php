<?php
defined('IN_IA') or exit('Access Denied');

class Group_WeliamController{
	/*
	 * 商户分组列表
	 */
	public function index(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$groupes = Store::getAllGroup($pindex-1,$psize);
		$groups = $groupes['data'];
		$pager = pagination($groupes['count'], $pindex, $psize);
		include wl_template('store/sgroupIndex');
	}
	
	/*
	 * 编辑商户分组
	 */
	public function edit(){
		global $_W,$_GPC;
		$chargelist = pdo_getall('wlmerchant_chargelist',array('uniacid' => $_W['uniacid'],'status'=>1),array('id','name'));
		$agentgroupid = pdo_getcolumn(PDO_NAME.'agentusers',array('id'=>$_W['aid']),'groupid');
		$pluginswitch = pdo_getcolumn(PDO_NAME.'agentusers_group',array('id'=>$agentgroupid),'package');
		$pluginswitch = unserialize($pluginswitch);
		if(checksubmit('submit')){
			$group = $_GPC['group'];
			$group['createtime'] = time();
			$group['name'] = trim($group['name']);
			$group['enabled'] = $_GPC['enabled'];
			$group['isdefault'] = $_GPC['isdefault'];
			$group['package'] = $group['package'];
			$group['authority'] = serialize($_GPC['authority']);
			if(!empty($_GPC['id'])){
				if(Store::editGroup($group,$_GPC['id'])) wl_message('保存成功',web_url('store/group/index'),'success');
			}else{
				if(Store::editGroup($group)) wl_message('保存成功',web_url('store/group/index'),'success');
			}
			wl_message('保存失败',referer(),'error');
		}
		if(!empty($_GPC['id'])){
			$group = Store::getSingleGroup($_GPC['id']);
			$group['authority'] = unserialize($group['authority']);
		} 
		include wl_template('store/sgroupEdit');
	}
	
	/*
	 * 删除分组
	 */
	public function delete(){
		global $_W,$_GPC;
		if(Store::deleteGroup($_GPC['id'])) wl_message('删除成功',web_url('store/group/index'),'success');
		wl_message('删除失败',referer(),'error');
		
	}
}
