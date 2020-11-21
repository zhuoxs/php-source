<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
global $_W;
defined('IN_IA') or exit('Access Denied');
define('SUPERMAN_MODULE_NAME', 'xiaof_toupiao_plugin_sendsms');
if (!defined('MODULE_ROOT')) {
    define('MODULE_ROOT', IA_ROOT.'/addons/'.SUPERMAN_MODULE_NAME.'/');
}
if (file_exists(IA_ROOT.'/local.lock')) {
    define('LOCAL_DEVELOPMENT', true);
} else if (file_exists(IA_ROOT.'/online-dev.lock')) {
    define('ONLINE_DEVELOPMENT', true);
}
if (defined('LOCAL_DEVELOPMENT') || defined('ONLINE_DEVELOPMENT')) {
    define('SUPERMAN_DEVELOPMENT', true);
}
define('MODULE_URL', $_W['siteroot'].'addons/'.SUPERMAN_MODULE_NAME.'/');
define('SUPERMAN_REGULAR_MOBILE', '/1\d{10}/');
