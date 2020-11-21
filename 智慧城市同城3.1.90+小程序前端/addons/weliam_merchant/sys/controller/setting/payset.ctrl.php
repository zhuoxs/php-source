<?php
defined('IN_IA') or exit('Access Denied');

class Payset_WeliamController {
	function index() {
		global $_W, $_GPC;
		$payset = Setting::wlsetting_read('payset');
		$value = unserialize($payset['value']);
		$status = unserialize($payset['status']);
		$partner = unserialize($payset['partner']);
		$cert = file_exists(PATH_DATA . "cert/" . $_W['uniacid'] . "/wechat/apiclient_cert.pem");
		$key = file_exists(PATH_DATA . "cert/" . $_W['uniacid'] . "/wechat/apiclient_key.pem");
		$path = is_dir(PATH_DATA . "cert/" . $_W['uniacid'] . "/wechat/") ? PATH_DATA . "cert/" . $_W['uniacid'] . "/wechat/" : mkdir(PATH_DATA . "cert/" . $_W['uniacid'] . "/wechat/", 0777, true);
		$message = Setting::wlsetting_read('payset');
		$moduels = uni_modules();
		if (checksubmit('submit')) {
			if (!empty($_FILES["cert"]["tmp_name"])) {
				if ($_FILES["cert"]["error"] > 0) {
					wl_message("上传失败！", '', 'error');
				} else {
					if ($cert) {
						unlink($_FILES["cert"]["name"]);
						$r1 = move_uploaded_file($_FILES["cert"]["tmp_name"], $path . $_FILES["cert"]["name"]);
					} else {
						$r1 = move_uploaded_file($_FILES["cert"]["tmp_name"], $path . $_FILES["cert"]["name"]);
					}
				}
			}
			if (!empty($_FILES["key"]["tmp_name"])) {
				if ($_FILES["key"]["error"] > 0) {
					wl_message("上传失败！", '', 'error');
				} else {
					if ($key) {
						unlink($_FILES["key"]["name"]);
						$r2 = move_uploaded_file($_FILES["key"]["tmp_name"], $path . $_FILES["key"]["name"]);
					} else {
						$r2 = move_uploaded_file($_FILES["key"]["tmp_name"], $path . $_FILES["key"]["name"]);
					}
				}
			}
			$partner = $_GPC['partner'];
			$value = $_GPC['value'];
			$p_status = $_GPC['p_status'];
			$data1['wechatstatus'] = $_GPC['wechatstatus'];
			$data1['status'] = iserializer($p_status);
			$data1['value'] = iserializer($value);
			$data1['partner'] = iserializer($partner);
			Setting::wlsetting_save($data1, 'payset');
			wl_message("提交成功！", '', 'success');
		}
		include wl_template('setting/payset');
	}

	function trade() {
		global $_W, $_GPC;
		$settings = Setting::wlsetting_read('trade');;
		if (checksubmit('submit')) {
			$base = Util::trimWithArray($_GPC['data']);
			Setting::wlsetting_save($base,'trade');
			wl_message('更新设置成功！', web_url('setting/payset/trade'));
		}
		include wl_template('setting/tradeset');
	}

}
