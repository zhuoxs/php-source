<?php
defined('IN_IA') or exit('Access Denied');

class Foot_WeliamController{
	public function index(){
		global $_W,$_GPC;
		$foot = Setting::agentsetting_read('foot');
		if(checksubmit('submit')){
			$foot = $_GPC['foot'];
			$res1 = Setting::agentsetting_save($foot,'foot');
			if ($res1) {
				wl_message('保存设置成功！', referer(), 'success');
			} else {
				wl_message('保存设置失败！', referer(), 'error');
			}
		}
		include wl_template('dashboard/footIndex');
	}
}
?>