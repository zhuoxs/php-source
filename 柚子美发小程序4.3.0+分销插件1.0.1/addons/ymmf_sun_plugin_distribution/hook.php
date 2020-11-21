<?php
/**
 * 微商城公告模块插件定义
 *
 * @author 微擎团队
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Ewei_shopping_plugin_noticeModuleHook extends WeModuleHook {
	public function hookMobileNotice() {
		global $_W;
		$notice = pdo_getcolumn('shopping_notice', array('uniacid' => $_W['uniacid']), 'content');
		include $this->template('notice');
	}
}