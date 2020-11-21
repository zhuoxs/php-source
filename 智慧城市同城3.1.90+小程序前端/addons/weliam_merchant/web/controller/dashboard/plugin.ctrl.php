<?php
defined('IN_IA') or exit('Access Denied');

class Plugin_WeliamController{
	public function index(){
		global $_W,$_GPC;
		$plugin = Setting::agentsetting_read('pluginlist');
		if(checksubmit('submit')){
			$plugin = $_GPC['plugin'];
			$res1 = Setting::agentsetting_save($plugin,'pluginlist');
			if ($res1) {
				wl_message('保存设置成功！', referer(), 'success');
			} else {
				wl_message('保存设置失败！', referer(), 'error');
			}
		}
		include wl_template('dashboard/pluginIndex');
	}
}
?>