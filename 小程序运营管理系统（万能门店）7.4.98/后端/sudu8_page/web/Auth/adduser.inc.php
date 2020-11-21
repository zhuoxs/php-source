<?php $act = isset(self::$_GPC["act"])?self::$_GPC["act"]:"display";

global $_W,$_GPC;

$uniacid = $_W['uniacid'];

load()->model('user');

$group = user_group();

$module_name = trim($_GPC['m']);

$modulelist = uni_modules(false);

$module = $_W['current_module'] = $modulelist[$module_name];

$module_and_plugins = array();

$all_permission = array();

if (!empty($module['plugin_list'])) {

    $module_and_plugins = array_reverse($module['plugin_list']);

}

array_push($module_and_plugins, $module_name);

$module_and_plugins = array_reverse($module_and_plugins);



foreach ($module_and_plugins as $key => $module_val) {

    $all_permission[$module_val]['info'] = module_fetch($module_val);

    $all_permission[$module_val]['permission'] = module_permission_fetch($module_val);

}

$usergroup = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_usergroup') ." WHERE `uniacid` = :uniacid", array(":uniacid" => $uniacid));


return include self::template('web/Auth/adduser');

