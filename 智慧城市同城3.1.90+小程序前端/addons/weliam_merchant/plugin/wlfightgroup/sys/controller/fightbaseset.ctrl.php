<?php
defined('IN_IA') or exit('Access Denied');

class Fightbaseset_WeliamController {
	function fightgroupset(){
		global $_W, $_GPC;
		$settings = Setting::wlsetting_read('wlfightgroup');
		if (checksubmit('submit')) {
			$base = array(
				'groupresult'=>$_GPC['groupresult'],
				'groupSwitch'=>intval($_GPC['groupSwitch']),
				'sendremind'=>$_GPC['sendremind'],
				'sendSwitch'=>intval($_GPC['sendSwitch']),
			);
			Setting::wlsetting_save($base,'wlfightgroup');
			wl_message('更新设置成功！', web_url('wlfightgroup/fightbaseset/fightgroupset'));
		}	
		
//		wl_debug($settings);
		include wl_template('fightsys/fightgroupset');
	}
}
?>