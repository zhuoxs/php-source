<?php
/**
 * 万能门店小程序模块定义
 *
 * @author 懒人源码
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');

class Sudu8_pageModule extends WeModule {

	public function welcomeDisplay($menus = array()) {
		global $_W;
		$eid = pdo_getcolumn("modules_bindings",['module' => 'sudu8_page','title' => '基础设置'], 'eid');
        header('Location:'.$_W['siteroot'].'web/index.php?c=site&a=entry&eid='.$eid);
    }
}