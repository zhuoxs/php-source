<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

if(!defined('IN_IA')) { exit('Access Denied'); }

global $_GPC, $_W;

if (!function_exists('dump'))
{
	function dump()
	{
		$args = func_get_args();
		foreach ($args as $val)
		{
			echo '<pre style="color: red">';
			var_dump($val);
			echo "</pre>";
		}
	}
}

// 当前时间
$time = time();

$_W['slwl']['datetime']['timestamp'] = $time;
$_W['slwl']['datetime']['time'] = date('H:i:s', $time);
$_W['slwl']['datetime']['date'] = date('Y-m-d', $time);
$_W['slwl']['datetime']['now'] = date('Y-m-d H:i:s', $time);
$_W['slwl']['datetime']['now000000'] = date('Y-m-d 00:00:00', $time);
$_W['slwl']['datetime']['nowYmdHis'] = date('YmdHis', $time);

$ver_mysql = pdo_fetchcolumn("SELECT VERSION() as version");
$ver_mysql = empty($ver_mysql)?'未知':$ver_mysql;

$_W['slwl']['system']['ver_php'] = PHP_VERSION;
$_W['slwl']['system']['ver_mysql'] = $ver_mysql;

// 检测环境
if(version_compare(PHP_VERSION, '5.4.0', '<')) { die('系统需要 PHP 5.4+'); };
if(version_compare($ver_mysql, '5.1.0', '<')) { die('系统需要 MYSQL 5.1+'); };

// site_settings = 基本设置
// default_set_settings = 首页配置
// site_color_settings = 颜色配置
// set_buttons = 按钮组配置
// set_menus = 底部菜单
// cpright_site_settings = 版权设置
// set_adgroup = 组合广告
// calc_set_settings = 计算器配置
// adpop_set_settings = 广告弹窗
// suspend_set_settings = 悬浮按钮

// set_store_config = 商城-基本设置---但没有使用了
// set_store_default = 商城-首页配置
// set_store_buttons = 商城-首页按钮组
// set_store_adgroup = 商城-组合广告
// auth_settings = 授权配置
// style_set_settings = 免费设计配置
// guestbook_set_settings = 留言配置
// reserve_set_settings = 在线预约配置
// designer_set_settings = 设计师配置

// 配置
$condition_setting = " AND uniacid=:uniacid OR uniacid='0' ";
$params_setting = [':uniacid' => $_W['uniacid']];
$list_setting = @pdo_fetchall("SELECT * FROM " . tablename(SLWL_PREFIX.'settings') . ' WHERE 1 '
	. $condition_setting, $params_setting);
if ($list_setting) {
	foreach ($list_setting as $k => $v) {
		$tmp_name = $v['setting_name'];
		$_W['slwl']['set'][$tmp_name] = json_decode($v['setting_value'], TRUE);
	}
}

// 系统名
$_W['slwl']['lang']['sys_name'] = $_W['account']['name'];

// 版权信息
$_W['slwl']['copyright']['web'] = '@ '. $_W['slwl']['lang']['sys_name'] .' 版权所有';
if ($_W['slwl']['set']['cpright_site_settings']['copyright']) {
	$_W['slwl']['copyright']['web'] = $_W['slwl']['set']['cpright_site_settings']['copyright'];
}

// https域名
// https://c003.com/
$is_https = stripos($_W['siteroot'], 'https');
if ($is_https !== FALSE) {
	$siteroot = $_W['siteroot'];
} else {
	$siteroot = preg_replace('/http/', 'https', $_W['siteroot'], 1);
}
$_W['slwl']['domain']['https_url'] = $siteroot;


// 获取权限设置-应用菜单开启项
$sys_id = $_W['uniacid'];
$where = array(
	'uniacid' => $sys_id,
	'uid' => $_W['uid'],
	'type' => SLWL_MAIN_MODULE,
);
$menus_permission = pdo_get('users_permission', $where, array('permission'));
if($menus_permission) {
	$sys_menus_auth = explode('|', $menus_permission['permission']);
}
$_W['slwl']['menus_auth'] = $sys_menus_auth;
