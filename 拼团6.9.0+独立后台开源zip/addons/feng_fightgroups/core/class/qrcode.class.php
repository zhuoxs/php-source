<?php
class creat_qrcode {
	public function creategroupQrcode($mid = 0) {
		
		global $_W, $_GPC;
		$path = IA_ROOT . "/attachment/feng_fightgroups/qrcode/" . $_W['uniacid'] . "/";
		$path2 = IA_ROOT . "/addons/feng_fightgroups/data/qrcode/" . $_W['uniacid'] . "/";
		if (!is_dir($path)) {
			load() -> func('file');
			mkdirs($path);
		}
		if (!is_dir($path2)) {
			load() -> func('file');
			mkdirs($path2);
		} 
		$url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=feng_fightgroups&do=order&ac=check&mid=' . $mid;
		$file = $mid . '.png';
		$qrcode_file = $path . $file;
		$qrcode_file2 = $path2 . $file;
		if (!is_file($qrcode_file)) {
			require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
			QRcode :: png($url, $qrcode_file, QR_ECLEVEL_H, 4);
			QRcode :: png($url, $qrcode_file2, QR_ECLEVEL_H, 4);
		} 
		return $_W['siteroot'] . 'addons/feng_fightgroups/data/qrcode/' . $_W['uniacid'] . '/' . $file;
	
	}
	
	public function createverQrcode($mid = 0 , $goodsid = 0, $posterid = 0) {
		global $_W, $_GPC;
		$path = IA_ROOT . "/addons/feng_fightgroups/qrcode/" . $_W['uniacid'];
		if (!is_dir($path)) {
			load() -> func('file');
			mkdirs($path);
		} 
		$url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=feng_fightgroups&do=shop&p=detail&id=' . $goodsid . '&mid=' . $mid;
		if (!empty($posterid)) {
			$url .= '&posterid=' . $posterid;
		} 
		$file = 'ver_qrcode_' . $posterid . '_' . $mid . '_' . $goodsid . '.png';
		$qrcode_file = $path . '/' . $file;
		if (!is_file($qrcode_file)) {
			require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
			QRcode :: png($url, $qrcode_file, QR_ECLEVEL_H, 4);
		} 
		return $_W['siteroot'] . 'addons/feng_fightgroups/qrcode/' . $_W['uniacid'] . '/' . $file;
	} 
} 
