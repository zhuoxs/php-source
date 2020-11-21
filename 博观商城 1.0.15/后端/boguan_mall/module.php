<?php
/**
 * boguan_mall模块定义
 *
 * @author 阿莫源码社区
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');

class Boguan_mallModule extends WeModule {


	public function welcomeDisplay($menus = array()) {
		//这里来展示DIY管理界面
        global $_GPC, $_W;
        $url = $this->createWebUrl('index');
        Header("Location: " . $url);
		include $this->template('welcome');
	}
}