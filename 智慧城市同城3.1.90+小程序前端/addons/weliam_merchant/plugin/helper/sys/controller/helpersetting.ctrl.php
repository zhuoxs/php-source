<?php
defined('IN_IA') or exit('Access Denied');

class Helpersetting_WeliamController{
	public function index(){
		global $_W, $_GPC;
		$url = app_url('helper/helper_app/index');
		include wl_template('helper/settingindex');
	}
	
	function settingbase(){
		global $_W, $_GPC;
		
		$settings = Setting::wlsetting_read('helper');
//		$status = $settings['status'];
//		$type = $settings['type'];
		if(checksubmit('submit')){
			$status = $_GPC['status'];
			$type = $_GPC['type'];
			if($status!==false && $type!==false){
				$base['status'] = $status;
				$base['type'] = $type;
				Setting::wlsetting_save($base,'helper');
				wl_message('更新设置成功！', web_url('helper/helpersetting/settingbase'));
			}
		}
		include wl_template('helper/settingbase');
	}	
	
	function qrcodeimg(){
		global $_W, $_GPC;
		$url = $_GPC['url'];
		m('qrcode/QRcode')->png($url, false, QR_ECLEVEL_H, 4);
	}
}

?>