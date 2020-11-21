<?php
defined('IN_IA') or exit('Access Denied');

class Set_WeliamController{
	/*
	 * 二维码生成
	 */
	function qr(){
		global $_W,$_GPC;
		if(empty($_GPC['url'])) return false;
		m('qrcode/QRcode')->png($_GPC['url'], false, QR_ECLEVEL_H, 4);
	}
	/*
	 * 入口函数
	 */
	
	function entry(){
		global $_W,$_GPC;
		$settings['name'] = '抢购入口';
		$areaid = pdo_getcolumn(PDO_NAME.'oparea',array('uniacid'=>$_W['uniacid'],'aid'=>$_W['aid']),'areaid');
		$settings['url'] = app_url('rush/home/index',array('areaid'=>$areaid));
		include wl_template('set/entry');
	}
	
	function base(){
		global $_W,$_GPC;
		$base = Setting::agentsetting_read('rush');
		$distri = Setting::wlsetting_read('distribution');
		if (checksubmit('submit')) {
			//处理数据值
			$data_img = $_GPC['data_img'];
			$data_url = $_GPC['data_url'];
			$paramids = array();
			$len = count($data_img);
			for ($k = 0; $k < $len; $k++) {
				if(!empty($data_img[$k])){
					$paramids[$k]['data_img'] = $data_img[$k];
					$paramids[$k]['data_url'] = $data_url[$k];
				}
			}
			$base = $_GPC['base'];
			$base['content'] = $paramids;
			$res1 = Setting::agentsetting_save($base,'rush');
			wl_message('保存设置成功！', referer(),'success');
		}
		include wl_template('set/base');
	}
}