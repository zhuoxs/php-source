<?php
defined('IN_IA') or exit('Access Denied');

class Notice_WeliamController{
	/*
	 * 公告列表
	 */
	public function index(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$notices = Dashboard::getAllNotice($pindex-1,$psize);
		$notice = $notices['data'];
		$pager = pagination($notices['count'], $pindex, $psize);
		include wl_template('dashboard/noticeIndex');
	}
	
	/*
	 * 编辑公告
	 */
	 public function edit(){
	 	global $_W,$_GPC;
		if(checksubmit('submit')){
			$notice = $_GPC['notice'];
			$notice['title'] = trim($notice['title']);
			$notice['content'] = htmlspecialchars_decode($notice['content']);
			$notice['enabled'] = intval($_GPC['enabled']);
			$notice['createtime'] = time();
			if(!empty($_GPC['id'])){
				if(Dashboard::editNotice($notice,$_GPC['id'])) wl_message('保存成功',web_url('dashboard/notice/index'),'success');
			}else{
				if(Dashboard::editNotice($notice)) wl_message('保存成功',web_url('dashboard/notice/index'),'success');
			}
			wl_message('保存失败',referer(),'error');
		}
		if(!empty($_GPC['id'])) $notice = Dashboard::getSingleNotice($_GPC['id']);
		include wl_template('dashboard/noticeEdit');
	 }
	 
	/*
	 * 删除公告
	 */
	 public function delete(){
	 	global $_W,$_GPC;
		if(Dashboard::deleteNotice($_GPC['id'])) wl_message('删除成功',web_url('dashboard/notice/index'),'success');
		wl_message('删除失败',referer(),'error');
	 }
}
