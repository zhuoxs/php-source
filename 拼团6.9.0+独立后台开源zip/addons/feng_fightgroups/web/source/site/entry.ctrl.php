<?php
defined('IN_IA') or exit('Access Denied');

$sql = 'SELECT * FROM ' . tablename('modules_bindings') . ' WHERE module = :module AND do = :do';
$entry = pdo_fetch($sql, array(':module' => trim($_GPC['m']), ':do' => trim($_GPC['do'])));
if (empty($entry)) {
    $entry = array(
        'module' => 'feng_fightgroups',
        'do' => 'store',
        'state' => $_GPC['state'],
        'direct' => $_GPC['direct']
    );
}

if(empty($entry) || empty($entry['do'])) {
    message('非法参数！', '', 'error');
}
//if(!$entry['direct']) {
//	checklogin();
//	load()->model('module');
//	$module = module_fetch($entry['module']);
//	if(empty($module)) {
//		message("访问非法, 没有操作权限. (module: {$entry['module']})");
//	}
//	if(!uni_user_module_permission_check($entry['module'] . '_menu_' . $entry['do'], $entry['module'])) {
//		message('您没有权限进行该操作');
//	}
//}

$_GPC['__entry'] = $entry['title'];
$_GPC['__state'] = $entry['state'];

$site = WeUtility::createModuleSite($entry['module']);
define('IN_MODULE', $entry['module']);

if(!is_error($site)) {
	$sysmodule = system_modules();
	if(in_array($m, $sysmodule)) {
		$site_urls = $site->getTabUrls();
	}
	$method = 'doWeb' . ucfirst($entry['do']);
	exit($site->$method());
}
exit("访问的方法 {$method} 不存在.");