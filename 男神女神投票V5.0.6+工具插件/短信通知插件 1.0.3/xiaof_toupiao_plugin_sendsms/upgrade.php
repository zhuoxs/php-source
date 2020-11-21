<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
defined('IN_IA') or exit('Access Denied');
include IA_ROOT.'/addons/xiaof_toupiao_plugin_sendsms/install.php';
$sql = "SELECT version FROM " . tablename('modules') . " WHERE name = :name";
$module_version = pdo_fetchcolumn($sql, array(':name' => 'xiaof_toupiao_plugin_sendsms'));

if (defined('SUPERMAN_DEVELOPMENT')) {

}
if (version_compare($module_version, '1.0.7', '<')) {

}
