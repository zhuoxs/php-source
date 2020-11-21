<?php
defined('IN_IA') or exit('Access Denied');

class Banner_WeliamController{
	/*
	 * 广告位查询
	 */
	public function index(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$banneres = Dashboard::getAllBanner($pindex-1,$psize);
		$banners = $banneres['data'];
		$pager = pagination($banneres['count'], $pindex, $psize);
		include wl_template('dashboard/bannerIndex');
	}
	
	/*
	 * 编辑广告位
	 */
	 public function edit(){
	 	global $_W,$_GPC;
		if(checksubmit('submit')){
			$banner = $_GPC['banner'];
			$banner['name'] = trim($banner['name']);
			$banner['displayorder'] = intval($banner['displayorder']);
			$banner['enabled'] = intval($_GPC['enabled']);
			if(!empty($_GPC['id'])){
				if(Dashboard::editBanner($banner,$_GPC['id'])) wl_message('保存成功',web_url('dashboard/banner/index'),'success');
			}else{
				if(Dashboard::editBanner($banner)) wl_message('保存成功',web_url('dashboard/banner/index'),'success');
			}
			wl_message('保存失败',referer(),'error');
		}
		if(!empty($_GPC['id'])) $banner = Dashboard::getSingleBanner($_GPC['id']);
		include wl_template('dashboard/bannerEdit');
	 }
	 
	/*
	 * 删除广告位
	 */
	 public function delete(){
	 	global $_W,$_GPC;
		if(Dashboard::deleteBanner($_GPC['id'])) wl_message('删除成功',web_url('dashboard/banner/index'),'success');
		wl_message('删除失败',referer(),'error');
	 }
}
