<?php
defined('IN_IA') or exit('Access Denied');

class Consumptionset_WeliamController {

	public function consumptionapi() {
		global $_W, $_GPC;
		$settings = Setting::wlsetting_read('consumption');
		if (checksubmit('submit')) {
			$base = $_GPC['set'];
			$res1 = Setting::wlsetting_save($base, 'consumption');
			wl_message('保存设置成功！', referer(), 'success');
		}
		include  wl_template('consumption/consumptionapi');
	}

	public function consumptionentry() {
		global $_W, $_GPC;
		$set['url'] = app_url('consumption/goods/goods_index');
		include  wl_template('consumption/consumptionentry');
	}
	
}