<?php
defined('IN_IA') or exit('Access Denied');

class Adv_WeliamController{
	/*
	 * 幻灯片查询
	 */
	public function index(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$adves = Dashboard::getAllAdv($pindex-1,$psize,'',$_GPC['type'],$_GPC['keyname']);
		$advs = $adves['data'];
		foreach ($advs as $k => &$val) {
			if (!empty($val['cateid'])) {
				$val['catename'] = pdo_getcolumn('wlmerchant_groupon_category', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'id' => $val['cateid']), 'name');
			}
		}
		$pager = pagination($adves['count'], $pindex, $psize);
		include wl_template('dashboard/advIndex');
	}
	
	/*
	 * 编辑幻灯片
	 */
	 public function edit(){
	 	global $_W,$_GPC;
		$cateid = intval($_GPC['cateid']);
		if(checksubmit('submit')){
			$adv = $_GPC['adv'];
			$adv['advname'] = trim($adv['advname']);
			$adv['displayorder'] = intval($adv['displayorder']);
			$adv['enabled'] = intval($_GPC['enabled']);
			if(!empty($_GPC['id'])){
				if(Dashboard::editAdv($adv,$_GPC['id'])) wl_message('保存成功',web_url('dashboard/adv/index'),'success');
			}else{
				$adv['cateid'] = $cateid;
				if(Dashboard::editAdv($adv)) wl_message('保存成功',web_url('dashboard/adv/index'),'success');
			}
			wl_message('保存失败',referer(),'error');
		}
		if(!empty($_GPC['id'])) $adv = Dashboard::getSingleAdv($_GPC['id']);
		if (!empty($cateid) && p('groupon')) {
			$catename = pdo_getcolumn('wlmerchant_groupon_category', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'id' => $cateid), 'name');
		}
		
		include wl_template('dashboard/advEdit');
	 }
	 
	/*
	 * 删除幻灯片
	 */
	 public function delete(){
	 	global $_W,$_GPC;
		if(Dashboard::deleteAdv($_GPC['id'])) wl_message('删除成功',web_url('dashboard/adv/index'),'success');
		wl_message('删除失败',referer(),'error');
	 }
}
