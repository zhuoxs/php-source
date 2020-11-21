<?php
defined('IN_IA') or exit('Access Denied');

class Nav_WeliamController{
	/*
	 * 导航栏查询
	 */
	public function index(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$naves = Dashboard::getAllNav($pindex-1,$psize);
		$navs = $naves['data'];
		$pager = pagination($naves['count'], $pindex, $psize);
		include wl_template('dashboard/navIndex');
	}
	
	/*
	 * 编辑导航栏
	 */
	 public function edit(){
	 	global $_W,$_GPC;
		if(checksubmit('submit')){
			$nav = $_GPC['nav'];
			$nav['name'] = trim($nav['name']);
			$nav['displayorder'] = intval($nav['displayorder']);
			$nav['enabled'] = intval($_GPC['enabled']);
			$nav['link'] = $_GPC['link'];
			if(!empty($_GPC['id'])){
			
				if(Dashboard::editNav($nav,$_GPC['id'])) wl_message('保存成功',web_url('dashboard/nav/index'),'success');
			}else{
				if(Dashboard::editNav($nav)) wl_message('保存成功',web_url('dashboard/nav/index'),'success');
			}
			wl_message('保存失败',referer(),'error');
		}
		
		if(!empty($_GPC['id'])) $nav = Dashboard::getSingleNav($_GPC['id']);
		
		include wl_template('dashboard/navEdit');
	 }
	 
	/*
	 * 删除导航栏
	 */
	 public function delete(){
	 	global $_W,$_GPC;
		if(Dashboard::deleteNav($_GPC['id'])){
			if($_GPC['merchantid']){
				wl_message('删除成功',web_url('store/merchant/urlindex',array('id'=>$_GPC['merchantid'])),'success');
			}else {
				wl_message('删除成功',web_url('dashboard/nav/index'),'success');
			}
		} 
		wl_message('删除失败',referer(),'error');
	 }
}
