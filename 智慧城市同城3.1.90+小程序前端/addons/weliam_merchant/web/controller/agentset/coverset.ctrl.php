<?php
defined('IN_IA') or exit('Access Denied');

class Coverset_WeliamController{
	/*
	 * 二维码生成
	 */
	public function qr(){
		global $_W,$_GPC;
		if(empty($_GPC['url'])) return false;
		m('qrcode/QRcode')->png($_GPC['url'], false, QR_ECLEVEL_H, 4);
	}
	
	/*
	 * 首页入口
	 */
	public function index(){
		global $_W,$_GPC;
		$settings['url'] = app_url('dashboard/home/index',array('aid'=>$_W['aid']));
		$settings['name'] = '首页';
		include wl_template('agentset/cover');
	}
	
	/*
	 * 会员中心入口
	 */
	public function member(){
		global $_W,$_GPC;
		$settings['url'] = app_url('member/user',array('aid'=>$_W['aid']));
		$settings['name'] = '会员中心';
		include wl_template('agentset/cover');
	}
	
	/*
	 * 商户列表入口
	 */
	public function store(){
		global $_W,$_GPC;
		$settings['url'] = app_url('store/merchant/newindex',array('aid'=>$_W['aid']));
		$settings['name'] = '好店首页';
		include wl_template('agentset/cover');
	}
	
}
