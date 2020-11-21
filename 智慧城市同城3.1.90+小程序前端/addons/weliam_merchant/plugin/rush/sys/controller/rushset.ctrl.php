<?php
defined('IN_IA') or exit('Access Denied');

class Rushset_WeliamController{
	
	public function base(){
		global $_W,$_GPC;
			$settings = Setting::wlsetting_read('rush');
			if (checksubmit('submit')) {
				$base = array(
					'rushsuccess' => trim($_GPC['rushsuccess']),
					'rushswitch' => intval($_GPC['rushswitch']),
					'startnotice' => trim($_GPC['startnotice']),
					'startswitch' => intval($_GPC['startswitch'])
				);
				Setting::wlsetting_save($base,'rush');
				wl_message('更新设置成功！', web_url('rush/rushset/base'));
			}
		include wl_template('rushsys/baseset');
	}
}