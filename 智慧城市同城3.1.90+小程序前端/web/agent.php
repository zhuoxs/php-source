<?php
define('IN_WEB', true);
require '../framework/bootstrap.inc.php';
require_once IA_ROOT."/addons/weliam_merchant/core/common/defines.php";
require_once PATH_CORE."common/autoload.php";
Func_loader::core('global');
load()->model('attachment');

$_W['catalog'] = 'web';
$_W['plugin'] = $plugin = !empty($_GPC['p']) ? $_GPC['p'] : 'dashboard';
$_W['controller'] = $controller = !empty($_GPC['ac']) ? $_GPC['ac'] : 'dashboard';
$_W['method'] = $method = !empty($_GPC['do']) ? $_GPC['do'] : 'index';
Func_loader::web('cover');
$_W['wlsetting'] = Setting::wlsetting_load();
$_W['attachurl'] = attachment_set_attach_url();

wl_new_method($plugin, $controller, $method, $_W['catalog']);