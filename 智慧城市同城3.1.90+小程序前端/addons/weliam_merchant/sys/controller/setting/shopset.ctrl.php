<?php
defined('IN_IA') or exit('Access Denied');

class Shopset_WeliamController{
	/*
	 * 基础设置
	 */
	public function base(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('base');
		$settings['plugin'] = unserialize($settings['plugin']);
		if (checksubmit('submit')) {
			$base = Util::trimWithArray($_GPC['shop']);
			$base['statistics'] = $_POST['shop']['statistics'];
			$base['qrstatus'] = $_GPC['qrstatus'];
			$base['telbindpwd'] = $_GPC['telbindpwd'];
            $base['independent_name'] = $_GPC['independent_name'];
			$base['plugin'] = serialize($_GPC['plugin']);
			$base['describe'] = htmlspecialchars_decode($base['describe']);
			$base['useflow'] = htmlspecialchars_decode($base['useflow']);
			Setting::wlsetting_save($base,'base');
			wl_message('更新设置成功！', web_url('setting/shopset/base'));
		}
		include wl_template('setting/shopBase');
	}
	
	//充值设置
	public function recharge(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('recharge');
		$count = count($settings['kilometre']);
		for ($i = 0; $i < $count; $i++) {
			$array[$i]['kilometre'] = $settings['kilometre'][$i];
			$array[$i]['kilmoney'] = $settings['kilmoney'][$i];
		}
		
		if (checksubmit('submit')) {
			$base = Util::trimWithArray($_GPC['recharge']);
			Setting::wlsetting_save($base, 'recharge');
			wl_message('更新设置成功！', web_url('setting/shopset/recharge'));
		}
		include wl_template('setting/recharge');
	}
	
	
	//积分设置
	public function creditset(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('creditset');
		if (checksubmit('submit')) {
			$base = Util::trimWithArray($_GPC['data']);
			Setting::wlsetting_save($base, 'creditset');
			wl_message('更新设置成功！', web_url('setting/shopset/creditset'));
		}
		
		include wl_template('setting/creditset');
	}
	
	/*
	 * 分享与关注设置
	 */
	public function share(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('share');;
		if (checksubmit('submit')) {
			$base = Util::trimWithArray($_GPC['share']);
			$base['forcefollow'] = $_GPC['forcefollow'];
			Setting::wlsetting_save($base,'share');
			wl_message('更新设置成功！', web_url('setting/shopset/share'));
		}
		include wl_template('setting/shopShare');
	}
	
	/*
	 * 模板设置
	 */
	public function templat(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('templat');;
		$styles = Util::traversingFiles(PATH_APP."view/");
		if (checksubmit('submit')) {
			$base = Util::trimWithArray($_GPC['templat']);
			Setting::wlsetting_save($base,'templat');
			wl_message('更新设置成功！', web_url('setting/shopset/templat'));
		}
		include wl_template('setting/shopTemplat');
	}

	public function api(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('api');;
		if (checksubmit('submit')) {
			$base = array(
				'txmapkey'=>$_GPC['txmapkey'],
				'guide'=>$_GPC['guide'],
				'cachetime'=> intval($_GPC['cachetime']),
			);
			Setting::wlsetting_save($base,'api');
			wl_message('更新设置成功！', web_url('setting/shopset/api'));
		}
		include wl_template('setting/shopApi');
	}

	/*
	 * 全网通设置
	 */
	public function wap(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('wap');;
		if (checksubmit('submit')) {
			$base = array(
				'share_title'=>$_GPC['share_title'],
				'share_image'=>$_GPC['share_image'],
				'share_desc'=>$_GPC['share_desc']
			);
			Setting::wlsetting_save($base,'wap');
			wl_message('更新设置成功！', web_url('setting/shopset/wap'));
		}
		include wl_template('setting/shopTemplat');
	}
	
	//客服设置
	public function customer(){
		global $_W,$_GPC;
		$settings = Setting::wlsetting_read('customer');;
		if (checksubmit('submit')) {
			$base = Util::trimWithArray($_GPC['customer']);
			Setting::wlsetting_save($base,'customer');
			wl_message('更新设置成功！', web_url('setting/shopset/customer'));
		}
		include wl_template('setting/customer');
	}

}
