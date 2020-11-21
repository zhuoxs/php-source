<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('extension');
load()->model('cloud');
load()->model('cache');
load()->func('file');
$dos = array('installed', 'check', 'prepared', 'install', 'upgrade', 'uninstall', 'designer', 'permission', 'batch-install', 'info', 'recycle');
$do = in_array($do, $dos) ? $do : 'installed';

$points = ext_module_bindings();
$sysmodules = system_modules();

if ($do == 'recycle') {
	$operate = $_GPC['op'];
	$name = trim($_GPC['name']);
	if ($operate == 'delete') {
		pdo_insert('modules_recycle', array('modulename' => $name));
		message('模块已放入回收站', url('extension/module/prepared', array('status' => 'recycle')), 'success');
	} elseif ($operate == 'recover') {
		pdo_delete('modules_recycle', array('modulename' => $name));
		message('模块恢复成功', url('extension/module/install', array('m' => $name)), 'success');
	}
	template('extension/module');
}
if($do == 'batch-install') {
	if(empty($_W['isfounder'])) {
		message('您没有安装模块的权限', '', 'error');
	}
	
	if($_W['ispost']) {
		$modulename = $_GPC['m_name'];
		if(pdo_fetchcolumn("SELECT mid FROM " . tablename('modules') . " WHERE name = :name", array(':name' => $modulename))) {
			exit('error');
		}
		
		$modulepath = IA_ROOT . '/addons/' . $modulename . '/';
		$manifest = ext_module_manifest($modulename);
		if (!empty($manifest)) {
			$r = cloud_m_prepare($modulename);
			if(is_error($r)) {
				exit('error');
			}
		}
		if(empty($manifest)) {
			exit('error');
		}
		manifest_check($modulename, $manifest);
		if(pdo_fetchcolumn("SELECT mid FROM " . tablename('modules') . " WHERE name = :name", array(':name' => $manifest['application']['identifie']))) {
			exit('error');
		}
		if(!file_exists($modulepath . 'processor.php') && !file_exists($modulepath . 'module.php') && !file_exists($modulepath . 'receiver.php') && !file_exists($modulepath . 'site.php')) {
			exit('error');
		}
		$module = ext_module_convert($manifest);
		ext_module_clean($modulename);
		$bindings = array_elements(array_keys($points), $module, false);
		foreach($points as $p => $row) {
			unset($module[$p]);
			if(is_array($bindings[$p]) && !empty($bindings[$p])) {
				foreach($bindings[$p] as $entry) {
					$entry['module'] = $manifest['application']['identifie'];
					$entry['entry'] = $p;
					pdo_insert('modules_bindings', $entry);
				}
			}
		}
		$module['permissions'] = iserializer($module['permissions']);
		if(pdo_insert('modules', $module)) {
			load()->model('module');
			module_build_privileges();
			cache_build_account_modules();
			if(strexists($manifest['install'], '.php')) {
				if(file_exists($modulepath . $manifest['install'])) {
					include_once $modulepath . $manifest['install'];
				}
			} else {
				pdo_run($manifest['install']);
			}
			update_handle($module['name']);
			exit('success');
		} else {
			exit('error');
		}
	}
}

if($do == 'info') {
	$m = trim($_GPC['m']);
	if($_W['isajax']) {
		$data = pdo_fetch('SELECT name, title, ability, description FROM ' . tablename('modules') . ' WHERE name = :m', array(':m' => $m));
		exit(json_encode($data));
	} else {
		if(checksubmit('submit')) {
			$update = array();
			!empty($_GPC['title']) && $update['title'] = $_GPC['title'];
			!empty($_GPC['ability']) && $update['ability'] = $_GPC['ability'];
			!empty($_GPC['description']) && $update['description'] = $_GPC['description'];
			if(!empty($update)) {
				pdo_update('modules', $update, array('name' => $m));
				cache_build_account_modules();
			}
			$sysmodules = system_modules();
			if(in_array($m, $sysmodules)) {
				$root = IA_ROOT . '/framework/builtin/' . $m;
			} else {
				$root = IA_ROOT . '/addons/' . $m;
			}
			if($_FILES['icon'] && $_FILES['icon']['error'] == '0' && !empty($_FILES['icon']['tmp_name'])) {
				$icon = $_FILES['icon']['tmp_name'];
			}
			if($_FILES['preview'] && $_FILES['preview']['error'] == '0' && !empty($_FILES['preview']['tmp_name'])) {
				$preview = $_FILES['preview']['tmp_name'];
			}
			load()->func('file');
			mkdirs($root);
			if($icon) {
				file_move($icon, "{$root}/icon-custom.jpg");
			}
			if($preview) {
				file_move($preview, "{$root}/preview-custom.jpg");
			}
			message('更新模块信息成功', referer(), 'success');
		}
	}
}

if($do == 'installed') {
	$_W['page']['title'] = '已安装的模块 - 模块 - 扩展';
	load()->model('module');
	$modtypes = module_types();
	$modules = pdo_fetchall("SELECT * FROM " . tablename('modules') .' ORDER BY `issystem` DESC, `mid` ASC', array(), 'mid');
	if (!empty($modules)) {
		foreach ($modules as $mid => $module) {
			$manifest = ext_module_manifest($module['name']);
			$modules[$mid]['official'] = empty($module['issystem']) && (strexists($module['author'], 'WeEngine Team') || strexists($module['author'], ' '));
			$modules[$mid]['description'] = strip_tags($module['description']);
			if(is_array($manifest) && ver_compare($module['version'], $manifest['application']['version']) == '-1') {
				$modules[$mid]['upgrade'] = true;
			}
						if(in_array($module['name'], $sysmodules)) {
				$modules[$mid]['imgsrc'] = '../framework/builtin/' . $module['name'] . '/icon-custom.jpg';
				if(!file_exists($modules[$mid]['imgsrc'])) {
					$modules[$mid]['imgsrc'] = '../framework/builtin/' . $module['name'] . '/icon.jpg';
				}
			} else {
				$modules[$mid]['imgsrc'] = '../addons/' . $module['name'] . '/icon-custom.jpg';
				if(!file_exists($modules[$mid]['imgsrc'])) {
					$modules[$mid]['imgsrc'] = '../addons/' . $module['name'] . '/icon.jpg';
				}
			}
		}
	}
	
	$sysmodules = implode("', '", $sysmodules);
	template('extension/module');
}

if ($do == 'check') {
	if ($_W['isajax']) {
		$foo = $_GPC['foo'];
		$r = cloud_prepare();
		if (is_error($r)) {
			exit('cloud service is unavailable');
		}
		if ($foo == 'upgrade') {
			$mods = array();

			$ret = cloud_m_query();

			if (!is_error($ret)) {
				foreach ($ret as $k => $v) {
					$mods[$k] = array(
						'from' => 'cloud',
						'version' => $v['version'],
						'name' => $v['name'],
						'branches' => $v['branches'],
						'site_branch' => $v['branches'][$v['branch']],
					);
				}
				$mods['pirate_apps'] = $ret['pirate_apps'];
			}
			if (!empty($mods)) {
				exit(json_encode($mods));
			} else {
				exit(json_encode(array('')));
			}
		} else {
			$moduleids = array();
			$modules = pdo_fetchall("SELECT `name` FROM " . tablename('modules') . ' ORDER BY `issystem` DESC, `mid` ASC');
			if (!empty($modules)) {
				foreach ($modules as $m) {
					$moduleids[] = $m['name'];
				}
			}
			
			$ret = cloud_m_query();

			if (!is_error($ret)) {
				$cloudUninstallModules = array();
				if ($ret['pirate_apps']) {
					unset($ret['pirate_apps']);
				}
				foreach ($ret as $k => $v) {
					if (!in_array(strtolower($k), $moduleids) && $v['id']) {
						$v['name'] = $k;
						$cloudUninstallModules[] = $v;
						$moduleids[] = $k;
					}
				}
				foreach ($cloudUninstallModules as &$cloudUninstallModule) {
					$cloudUninstallModule['description'] = strip_tags($cloudUninstallModule['description']);
				}
				exit(json_encode($cloudUninstallModules));
			}
		}
	}
	exit('failure');
}

if($do == 'prepared') {
	$_W['page']['title'] = '安装模块 - 模块 - 扩展';
	$status = $_GPC['status'];
	$recycle_modules = pdo_getall('modules_recycle', array(), array(), 'modulename');
	$recycle_modules = array_keys($recycle_modules);
	$moduleids = array();
	$modules = pdo_fetchall("SELECT `name` FROM " . tablename('modules') . ' ORDER BY `issystem` DESC, `mid` ASC');
	if(!empty($modules)) {
		foreach($modules as $m) {
			$moduleids[] = $m['name'];
		}
	}
	$path = IA_ROOT . '/addons/';
	if (is_dir($path)) {
		$localUninstallModules_noso = array();
		$localUninstallModules_title = array();
		$localUninstallModules = array();
		if ($handle = opendir($path)) {
			while (false !== ($modulepath = readdir($handle))) {
				$manifest = ext_module_manifest($modulepath);
				if (!empty($status) && in_array($manifest['application']['identifie'], $recycle_modules) || empty($status) && !in_array($manifest['application']['identifie'], $recycle_modules)) {
					if (is_array($manifest) && !empty($manifest['application']['identifie']) && !in_array($manifest['application']['identifie'], $moduleids)) {
						$m = ext_module_convert($manifest);
						$localUninstallModules[$m['name']] = $m;
						if ($m['issolution'] <> 1) {
							$localUninstallModules_noso[$m['name']] = $m;
							$localUninstallModules_title[$m['name']] = $m['title'];
						}
						$moduleids[] = $manifest['application']['identifie'];
					}
				}
			}
		}
	}
	$prepare_module = json_encode(array_keys($localUninstallModules_noso));
	$prepare_module_title = json_encode($localUninstallModules_title);
	template('extension/module');
}

if($do == 'permission') {
	load()->model('module');
	$id = $_GPC['id'];
	$module = pdo_fetch("SELECT mid, name FROM " . tablename('modules') . " WHERE name = :name", array(':name' => $id));
	if(!empty($module[''])) {}
	$isinstall = false;
	$from = '';
		cache_load('modules');
	if(!empty($module)) {
		$module = $_W['modules'][$module['name']];
				if (empty($module)) {
			$data = pdo_getall('modules');
			$update = array();
			foreach ($data as &$mod) {
				unset($mod['permission']);
				$mod['subscribes'] = unserialize($mod['subscribes']);
				$mod['handles'] = unserialize($mod['handles']);
				$update[$mod['name']] = $mod;
			}
			cache_write('modules', $update);
			cache_load('modules');
			$module = $_W['modules'][$module['name']];
		}
		$bindings = pdo_fetchall('SELECT * FROM ' . tablename('modules_bindings') . ' WHERE `module`=:module', array(':module' => $id));
		if(!empty($bindings)) {
			foreach($bindings as $entry) {
				$module[$entry['entry']][] = array_elements(array('title', 'do', 'direct', 'state'), $entry);
			}
		}
		$manifest = ext_module_manifest($module['name']);
		if(is_array($manifest) && ver_compare($module['version'], $manifest['application']['version']) == -1) {
			$module['upgrade'] = 1;
		}
		$isinstall = true;
		$from = 'installed';
		if(in_array($module['name'], $sysmodules)) {
			$issystem = 1;
		}
		$manifest = ext_module_manifest($id);
		$from = 'local';
	}
	if (empty($module)) {
		message('你访问的模块不存在. 或许你愿意去微擎云服务平台看看. ', 'http://v2.addons.we7.cc/web/index.php?keyword=' . $_GPC['title']);
	}
	$module['isinstall'] = $isinstall;
	$module['from'] = $from;
	$mtypes = ext_module_msg_types();
	$modtypes = module_types();
	$issystem = $module['issystem'];
	if($issystem) {
		$path = '../framework/builtin/' . $module['name'];
	} else {
		$path = '../addons/' . $module['name'];
	}
	$cion = $path . '/icon-custom.jpg';
	$preview = $path . '/preview-custom.jpg';
	if(!file_exists($cion)) {
		$cion = $path . '/icon.jpg';
	}
	if(!file_exists($preview)) {
		$preview = $path . '/preview.jpg';
	}
	template('extension/permission');
}

if($do == 'install') {
	if (empty($_W['isfounder'])) {
		message('您没有安装模块的权限', '', 'error');
	}
	$modulename = $_GPC['m'];
	if (pdo_fetchcolumn("SELECT mid FROM " . tablename('modules') . " WHERE name = :name", array(':name' => $modulename))) {
		message('模块已经安装或是唯一标识已存在！', '', 'error');
	}

	$manifest = ext_module_manifest($modulename);
	if (!empty($manifest)) {
		$r = cloud_m_prepare($modulename);
		if (is_error($r)) {
			message($r['message'], url('extension/module/prepared'), 'error');
		}
	}

	if (empty($manifest)) {
		$r = cloud_prepare();
		if (is_error($r)) {
			message($r['message'], url('cloud/profile'), 'error');
		}
		$info = cloud_m_info($modulename);
		if (!is_error($info)) {
			if (empty($_GPC['flag'])) {
				header('location: ' . url('cloud/process', array('m' => $modulename)));
				exit;
			} else {
				define('ONLINE_MODULE', true);
				$packet = cloud_m_build($modulename);
				$manifest = ext_module_manifest_parse($packet['manifest']);
			}
		} else {
			message($info['message'], '', 'error');
		}
	}

	if (empty($manifest)) {
		message('模块安装配置文件不存在或是格式不正确，请刷新重试！', '', 'error');
	}

	manifest_check($modulename, $manifest);
	$modulepath = IA_ROOT . '/addons/' . $modulename . '/';
	if (!file_exists($modulepath . 'processor.php') && !file_exists($modulepath . 'module.php') && !file_exists($modulepath . 'receiver.php') && !file_exists($modulepath . 'site.php')) {
		message('模块处理文件 site.php, processor.php, module.php, receiver.php 一个都不存在 ！', '', 'error');
	}
	$module = ext_module_convert($manifest);
	$groups = uni_groups();
	if (!$_W['ispost'] || empty($_GPC['flag'])) {
		template('extension/select-groups');
		exit;
	}
	$post_groups = $_GPC['group'];
	ext_module_clean($modulename);
	$bindings = array_elements(array_keys($points), $module, false);
	foreach ($points as $p => $row) {
		unset($module[$p]);
		if (is_array($bindings[$p]) && !empty($bindings[$p])) {
			foreach ($bindings[$p] as $entry) {
				$entry['module'] = $manifest['application']['identifie'];
				$entry['entry'] = $p;
				pdo_insert('modules_bindings', $entry);
			}
		}
	}
	$module['permissions'] = iserializer($module['permissions']);
	if (!empty($info['version']['cloud_setting'])) {
		$module['settings'] = 2;
	}
	if ($modulename == 'we7_coupon') {
		$module['issystem'] = 1;
		$module['settings'] = 2;
	}
	if (pdo_insert('modules', $module)) {
		if (strexists($manifest['install'], '.php')) {
			if (file_exists($modulepath . $manifest['install'])) {
				include_once $modulepath . $manifest['install'];
			}
		} else {
			pdo_run($manifest['install']);
		}
		update_handle($module['name']);

				if (defined('ONLINE_MODULE')) {
			ext_module_script_clean($module['name'], $manifest);
		}

		if ($_GPC['flag'] && !empty($post_groups) && $module['name']) {
			foreach ($post_groups as $post_group) {
				$item = pdo_fetch("SELECT id,name,modules FROM " . tablename('uni_group') . " WHERE id = :id", array(':id' => intval($post_group)));
				if (empty($item)) {
					continue;
				}
				$item['modules'] = iunserializer($item['modules']);
				if (in_array($module['name'], $item['modules'])) {
					continue;
				}
				$item['modules'][] = $module['name'];
				$item['modules'] = iserializer($item['modules']);
				pdo_update('uni_group', $item, array('id' => $post_group));
			}
		}
		$module_subscribe_success = true;
		if (!empty($module['subscribes'])) {
			$subscribes = iunserializer($module['subscribes']);
			if (!empty($subscribes)) {
				$module_subscribe_success = ext_check_module_subscribe($module['name']);
			}
		}
		load()->model('module');
		module_build_privileges();
		cache_build_module_subscribe_type();
		cache_build_account_modules();
		if (empty($module_subscribe_success)) {
			message('模块安装成功, 请按照【公众号服务套餐】【用户组】来分配权限！模块订阅消息有错误，系统已禁用该模块的订阅消息，详细信息请查看 <div><a class="btn btn-primary" style="width:80px;" href="' . url('extension/subscribe/subscribe') . '">订阅管理</a> &nbsp;&nbsp;<a class="btn btn-default" href="' . url('extension/module') . '">返回模块列表</a></div>', '', 'tips');
		} else {
			message('模块安装成功, 请按照【公众号服务套餐】【用户组】来分配权限！', url('extension/module'), 'success');
		}
	} else {
		message('模块安装失败, 请联系模块开发者！');
	}
}

if ($do == 'uninstall') {
	if (empty($_W['isfounder'])) {
		message('您没有卸载模块的权限', '', 'error');
	}
	$id = $_GPC['id'];

	$module = pdo_fetch("SELECT `name`, `isrulefields`, `issystem`, `version` FROM " . tablename('modules') . " WHERE name = :name", array(':name' => $id));

	if (empty($module)) {
		message('模块已经被卸载或是不存在！', '', 'error');
	}

	if (!empty($module['issystem'])) {
		message('系统模块不能卸载！', '', 'error');
	}
	if ($module['isrulefields'] && !isset($_GPC['confirm'])) {
		message('卸载模块时同时删除规则数据吗, 删除规则数据将同时删除相关规则的统计分析数据？<div><a class="btn btn-primary" style="width:80px;" href="' . url('extension/module/uninstall', array('id' => $_GPC['id'], 'confirm' => 1)) . '">是</a> &nbsp;&nbsp;<a class="btn btn-default" style="width:80px;" href="' . url('extension/module/uninstall', array('id' => $_GPC['id'], 'confirm' => 0)) . '">否</a></div>', '', 'tips');
	} else {
		$modulepath = IA_ROOT . '/addons/' . $id . '/';
		$manifest = ext_module_manifest($module['name']);
		if (empty($manifest)) {
			$r = cloud_prepare();
			if (is_error($r)) {
				message($r['message'], url('cloud/profile'), 'error');
			}

			$packet = cloud_m_build($module['name'], $do);

			if ($packet['sql']) {
				pdo_run(base64_decode($packet['sql']));
			} elseif ($packet['script']) {
				$uninstall_file = $modulepath . TIMESTAMP . '.php';
				file_put_contents($uninstall_file, base64_decode($packet['script']));
				require($uninstall_file);
				unlink($uninstall_file);
			}
		} elseif (!empty($manifest['uninstall'])) {
			if (strexists($manifest['uninstall'], '.php')) {
				if (file_exists($modulepath . $manifest['uninstall'])) {
					require($modulepath . $manifest['uninstall']);
				}
			} else {
				pdo_run($manifest['uninstall']);
			}
		}

		ext_module_clean($id, $_GPC['confirm'] == '1');

		cache_build_account_modules();

		cache_build_module_subscribe_type();

		pdo_insert('modules_recycle', array('modulename' => $module['name']));

		message('模块已放入回收站！', url('extension/module'), 'success');
	}
}

if($do == 'upgrade') {
	$id = $_GPC['m'];
	$module = pdo_fetch("SELECT mid, name, version FROM " . tablename('modules') . " WHERE name = :name", array(':name' => $id));
	if (empty($module)) {
		message('模块已经被卸载或是不存在！', '', 'error');
	}

	$type = $_GPC['type'];
	$modulepath = IA_ROOT . '/addons/' . $id . '/';

		if ($type == 'getinfo') {
		$manifest = '';
	} else {
		$manifest = ext_module_manifest($module['name']);
	}

	if (empty($manifest)) {
		$r = cloud_prepare();
		if (is_error($r)) {
			message($r['message'], url('cloud/profile'), 'error');
		}

		$info = cloud_m_upgradeinfo($id);
		
		if ($_W['isajax'] && $type == 'getinfo') {
			if ($info['free']) {
				foreach ($info['branches'] as &$branch) {
					$branch['upgrade_price'] = 0;
				}
			}
			message($info, '', 'ajax');
		}
		if (is_error($info)) {
			message($info['message'], referer(), 'error');
		}

		if (!is_error($info)) {
			if (empty($_GPC['flag'])) {
				$site_branch_displayorder = $info['branches'][$info['version']['branch_id']]['displayorder'];
				$upgrade_branch_displayorder = $info['branches'][intval($_GPC['branch'])]['displayorder'];
				if (($upgrade_branch_displayorder > $site_branch_displayorder) || ($site_branch_displayorder == $upgrade_branch_displayorder && intval($_GPC['branch']) > $info['version']['branch_id'])) {
					header('location: ' . url('cloud/redirect/buybranch', array('m' => $id, 'branch' => intval($_GPC['branch']), 'is_upgrade' => 1)));
					exit;
				}
				header('location: ' . url('cloud/process', array('m' => $id, 'is_upgrade' => 1)));
				exit;
			} else {
				define('ONLINE_MODULE', true);
				$packet = cloud_m_build($id);
				$manifest = ext_module_manifest_parse($packet['manifest']);
			}
		}
	}
	
	if (empty($manifest)) {
		message('模块安装配置文件不存在或是格式不正确！', '', 'error');
	}
	manifest_check($id, $manifest);

	if (!file_exists($modulepath . 'processor.php') && !file_exists($modulepath . 'module.php') && !file_exists($modulepath . 'receiver.php') && !file_exists($modulepath . 'site.php')) {
		message('模块处理文件 site.php, processor.php, module.php, receiver.php 一个都不存在 ！', '', 'error');
	}
	$module = ext_module_convert($manifest);
	unset($module['name']);
	unset($module['id']);
	$bindings = array_elements(array_keys($points), $module, false);
	foreach ($points as $p => $row) {
		unset($module[$p]);
		if (is_array($bindings[$p]) && !empty($bindings[$p])) {
			foreach ($bindings[$p] as $entry) {
				$entry['module'] = $manifest['application']['identifie'];
				$entry['entry'] = $p;
				if ($entry['title'] && $entry['do']) {
										$delete_do[] = $entry['do'];
					$delete_title[] = $entry['title'];

					$sql = 'SELECT * FROM ' . tablename('modules_bindings') . ' WHERE `module`=:module AND `entry`=:entry AND `title`=:title AND `do`=:do';
					$pars = array();
					$pars[':module'] = $manifest['application']['identifie'];
					$pars[':entry'] = $p;
					$pars[':title'] = $entry['title'];
					$pars[':do'] = $entry['do'];
					$rec = pdo_fetch($sql, $pars);
					if (!empty($rec)) {
						pdo_update('modules_bindings', $entry, array('eid' => $rec['eid']));
						continue;
					}
				} elseif ($entry['call']) {
					$delete_call[] = $entry['call'];

					$sql = 'SELECT * FROM ' . tablename('modules_bindings') . ' WHERE `module`=:module AND `entry`=:entry AND `call`=:call';
					$pars = array();
					$pars[':module'] = $manifest['application']['identifie'];
					$pars[':entry'] = $p;
					$pars[':call'] = $entry['call'];
					$rec = pdo_fetch($sql, $pars);
					if (!empty($rec)) {
						pdo_update('modules_bindings', $entry, array('eid' => $rec['eid']));
						continue;
					}
				}
				pdo_insert('modules_bindings', $entry);
			}
						if (!empty($delete_do)) {
				pdo_query('DELETE FROM ' . tablename('modules_bindings') . " WHERE module = :module AND entry = :entry AND `call` = '' AND do NOT IN ('" . implode("','", $delete_do) . "')", array(':module' => $manifest['application']['identifie'], ':entry' => $p));
				unset($delete_do);
			}
			if (!empty($delete_title)) {
				pdo_query('DELETE FROM ' . tablename('modules_bindings') . " WHERE module = :module AND entry = :entry AND `call` = '' AND title NOT IN ('" . implode("','", $delete_title) . "')", array(':module' => $manifest['application']['identifie'], ':entry' => $p));
				unset($delete_title);
			}
			if (!empty($delete_call)) {
				pdo_query('DELETE FROM ' . tablename('modules_bindings') . " WHERE module = :module AND  entry = :entry AND do = '' AND title = '' AND `call` NOT IN ('" . implode("','", $delete_call) . "')", array(':module' => $manifest['application']['identifie'], ':entry' => $p));
				unset($delete_call);
			}
		}
	}
	if (!empty($manifest['upgrade'])) {
		if (strexists($manifest['upgrade'], '.php')) {
			if (file_exists($modulepath . $manifest['upgrade'])) {
				include_once $modulepath . $manifest['upgrade'];
			}
		} else {
			pdo_run($manifest['upgrade']);
		}
	}
		if (defined('ONLINE_MODULE')) {
		ext_module_script_clean($id, $manifest);
	}
	
	$module['permissions'] = iserializer($module['permissions']);
	
	if (!empty($info['version']['cloud_setting'])) {
		$module['settings'] = 2;
	} else {
		if (empty($manifest['application']['setting'])) {
			$module['settings'] = 0;
		} else {
			$module['settings'] = 1;
		}
	}
	pdo_update('modules', $module, array('name' => $id));
	cache_build_account_modules();
	if (!empty($module['subscribes'])) {
		$module_subscribe_success = ext_check_module_subscribe($module['name']);
	}
	cache_delete('cloud:transtoken');
	if ($_GPC['flag'] == 1) {
		message('模块更新成功！ <br> 由于数据库更新, 可能会产生多余的字段. 你可以按照需要删除.<div><a class="btn btn-primary" href="' . url('system/database/trim') . '">现在去删除</a>&nbsp;&nbsp;&nbsp;<a class="btn btn-default" href="' . url('extension/module/') . '">返回模块列表</a></div>', '', 'success');
	} else {
		message('模块更新成功！', referer(), 'success');
	}
}

if($do == 'designer') {
	if(empty($_W['isfounder'])) {
		message('您没有设计新模块的权限', '', 'error');
	}

	$_W['page']['title'] = '设计新模块 - 模块 - 扩展';
	load()->model('module');
	$available = array();
	$available['download'] = class_exists('ZipArchive');
	$available['create'] = @is_writable(IA_ROOT . '/addons');

	$mtypes = ext_module_msg_types();
	$modtypes = module_types();
	$versions = array();
	$versions[] = '0.6';

	$m = array();
	$m['platform'] = array();
	$m['platform']['subscribes'] = array();
	$m['platform']['handles'] = array();
	$m['site'] = array();
	$m['versions'] = array();
	if(checksubmit() && $available[$_GPC['method']]) {
		$m['application']['name'] = trim($_GPC['application']['name']);
		if(empty($m['application']['name']) || preg_match('/\*\/|\/\*|eval|\$\_/i', $m['application']['name'])) {
			message('请输入有效的模块名称. ');
		}
		$m['application']['identifie'] = trim($_GPC['application']['identifie']);
		if(empty($m['application']['identifie']) || !preg_match('/^[a-z][a-z\d_]+$/i', $m['application']['identifie'])) {
			message('必须输入模块标识符(仅支持字母和数字, 且只能以字母开头). ');
		}
		$m['application']['version'] = trim($_GPC['application']['version']);
		if(empty($m['application']['version']) || !preg_match('/^[\d\.]+$/i', $m['application']['version'])) {
			message('必须输入模块版本号(仅支持数字和句点). ');
		}
		$m['application']['ability'] = trim($_GPC['application']['ability']);
		if(empty($m['application']['ability'])) {
			message('必须输入模块功能简述. ');
		}
		$m['application']['type'] = array_key_exists($_GPC['application']['type'], $modtypes) ? $_GPC['application']['type'] : 'other';
		$m['application']['description'] = trim($_GPC['application']['description']);
		$m['application']['author'] = trim($_GPC['application']['author']);
		if(preg_match('/\*\/|\/\*|eval|\$\_/i', $m['application']['author'])) {
			message('请输入有效的模块作者');
		}
		$m['application']['url'] = trim($_GPC['application']['url']);
		if(preg_match('/\*\/|\/\*|eval|\$\_/i', $m['application']['url'])) {
			message('请输入有效的模块发布页');
		}
		$m['application']['setting'] = $_GPC['application']['setting'] == 'true';
		if(is_array($_GPC['subscribes'])) {
			foreach($_GPC['subscribes'] as $s) {
				if(array_key_exists($s, $mtypes)) {
					$m['platform']['subscribes'][] = $s;
				}
			}
		}
		if(is_array($_GPC['handles'])) {
			foreach($_GPC['handles'] as $s) {
				if(array_key_exists($s, $mtypes) && $s != 'unsubscribe') {
					$m['platform']['handles'][] = $s;
				}
			}
		}
		$m['platform']['rule'] = $_GPC['platform']['rule'] == 'true';
		if($m['platform']['rule']) {
			if(!in_array('text', $m['platform']['handles'])) {
				$m['platform']['handles'][] = 'text';
			}
		}
		$m['platform']['card'] = $_GPC['platform']['card'] == 'true';
		$m['bindings'] = array();
		foreach($points as $p => $row) {
			if(!is_array($_GPC['bindings'][$p]['titles'])) {
				continue;
			}
			foreach($_GPC['bindings'][$p]['titles'] as $key => $t) {
				$entry = array();
				$entry['title'] = trim($t);
				$entry['do'] = $_GPC['bindings'][$p]['dos'][$key];
				$entry['state'] = $_GPC['bindings'][$p]['state'][$key];
				$entry['direct'] = $_GPC['bindings'][$p]['direct'][$key] == 'true';
				if(!empty($entry['title']) && preg_match('/^[a-z\d]+$/i', $entry['do'])) {
					$m['bindings'][$p][] = $entry;
				}
			}
		}
				$permission = trim($_GPC['permission']);
		if(!empty($permission)) {
			$permission = str_replace(array('：'), array(':'), $permission);
			$permission = explode("\n", $permission);
			$arr = array();
			foreach($permission as $li) {
				$li = trim($li);
				$li = explode(':', $li);
				if(!empty($li[0]) && !empty($li[1])) {
					$arr[] = array('title' => $li[0], 'permission' => $li[1]);
				}
			}
			$m['permission'] = $arr;
		}
		if(is_array($_GPC['versions'])) {
			foreach($_GPC['versions'] as $ver) {
				if(in_array($ver, $versions)) {
					$m['versions'][] = $ver;
				}
			}
		}
		$m['install'] = trim($_GPC['install']);
		$m['uninstall'] = trim($_GPC['uninstall']);
		$m['upgrade'] = trim($_GPC['upgrade']);
		if($_FILES['icon'] && $_FILES['icon']['error'] == '0' && !empty($_FILES['icon']['tmp_name'])) {
			$m['icon'] = $_FILES['icon']['tmp_name'];
		}
		if($_FILES['preview'] && $_FILES['preview']['error'] == '0' && !empty($_FILES['preview']['tmp_name'])) {
			$m['preview'] = $_FILES['preview']['tmp_name'];
		}
		
		$manifest = manifest($m);
		$mDefine = define_module($m);
		$pDefine = define_processor($m);
		$rDefine = define_receiver($m);
		$sDefine = define_site($m);
		$ident = strtolower($m['application']['identifie']);
		
		if ($_GPC['method'] == 'create') {
			load()->func('file');
			$mRoot = IA_ROOT . "/addons/{$ident}";
			if(file_exists($mRoot)) {
				message("目标位置 {$mRoot} 已存在, 请更换标识或删除现有内容. ");
			}
			mkdirs($mRoot);
			f_write("{$mRoot}/manifest.xml", $manifest);
			if($mDefine) {
				f_write("{$mRoot}/module.php", $mDefine);
			}
			if($pDefine) {
				f_write("{$mRoot}/processor.php", $pDefine);
			}
			if($rDefine) {
				f_write("{$mRoot}/receiver.php", $rDefine);
			}
			if($sDefine) {
				f_write("{$mRoot}/site.php", $sDefine);
			}
			mkdirs("{$mRoot}/template");
			if($m['application']['setting']) {
				f_write("{$mRoot}/template/setting.html", "{template 'common/header'}\r\n这里定义页面内容\r\n{template 'common/footer'}");
			}
			if($m['icon']) {
				file_move($m['icon'], "{$mRoot}/icon.jpg");
			}
			if($m['preview']) {
				file_move($m['preview'], "{$mRoot}/preview.jpg");
			}
			message("生成成功. 请访问 {$mRoot} 继续实现你的模块.", 'refresh');
			die;
		}
		if($_GPC['method'] == 'download') {
			$fname = IA_ROOT . "/data/tmp.zip";
			$zip = new ZipArchive();
			$zip->open($fname, ZipArchive::CREATE);
			$zip->addFromString('manifest.xml', $manifest);
			if($mDefine) {
				$zip->addFromString('module.php', $mDefine);
			}
			if($pDefine) {
				$zip->addFromString('processor.php', $pDefine);
			}
			if($rDefine) {
				$zip->addFromString('receiver.php', $rDefine);
			}
			if($sDefine) {
				$zip->addFromString('site.php', $sDefine);
			}
			$zip->addEmptyDir('template');
			if($m['application']['setting']) {
				$zip->addFromString("template/setting.html", "{template 'common/header'}\r\n这里定义页面内容\r\n{template 'common/footer'}");
			}
			if($m['icon']) {
				$zip->addFile($m['icon'], 'icon.jpg');
				
			}
			if($m['preview']) {
				$zip->addFile($m['preview'], 'preview.jpg');
				
			}
			$zip->close();
			header('content-type: application/zip');
			header('content-disposition: attachment; filename="' . $ident . '.zip"');
			readfile($fname);
			@unlink($m['icon']);
			@unlink($m['preview']);
			@unlink($fname);
		}
	}
	template('extension/designer');
}



function manifest_check($id, $m) {
	if(is_string($m)) {
		message('模块配置项定义错误, 具体错误内容为: <br />' . $m);
	}
	if(empty($m['application']['name'])) {
		message('模块名称未定义. ');
	}
	if(empty($m['application']['identifie']) || !preg_match('/^[a-z][a-z\d_]+$/i', $m['application']['identifie'])) {
		message('模块标识符未定义或格式错误(仅支持字母和数字, 且只能以字母开头). ');
	}
	if(strtolower($id) != strtolower($m['application']['identifie'])) {
		message('模块名称定义与模块路径名称定义不匹配. ');
	}
	if(empty($m['application']['version']) || !preg_match('/^[\d\.]+$/i', $m['application']['version'])) {
		message('模块版本号未定义(仅支持数字和句点). ');
	}
	if(empty($m['application']['ability'])) {
		message('模块功能简述未定义. ');
	}
	if($m['platform']['isrulefields'] && !in_array('text', $m['platform']['handles'])) {
		message('模块功能定义错误, 嵌入规则必须要能够处理文本类型消息. ');
	}
	if((!empty($m['cover']) || !empty($m['rule'])) && !$m['platform']['isrulefields']) {
		message('模块功能定义错误, 存在封面或规则功能入口绑定时, 必须要嵌入规则. ');
	}
	global $points;
	foreach($points as $p => $row) {
		if(is_array($m[$p])) {
			foreach($m[$p] as $o) {
				if(trim($o['title']) == ''  || !preg_match('/^[a-z\d]+$/i', $o['do']) && empty($o['call'])) {
					message($row['title'] . ' 扩展项功能入口定义错误, (操作标题[title], 入口方法[do])格式不正确.');
				}
			}
		}
	}
		if(is_array($m['permissions']) && !empty($m['permissions'])) {
		foreach($m['permissions'] as $permission) {
			if(trim($permission['title']) == ''  || !preg_match('/^[a-z\d_]+$/i', $permission['permission'])) {
				message("名称为： {$permission['title']} 的权限标识格式不正确,请检查标识名称或标识格式是否正确");
			}
		}
	}
	if(!is_array($m['versions'])) {
		message('兼容版本格式错误. ');
	}
}

function manifest($m) {
	$versions = implode(',', $m['versions']);
	$setting = $m['application']['setting'] ? 'true' : 'false';
	$subscribes = '';
	foreach($m['platform']['subscribes'] as $s) {
		$subscribes .= "\r\n\t\t\t<message type=\"{$s}\" />";
	}
	$handles = '';
	foreach($m['platform']['handles'] as $h) {
		$handles .= "\r\n\t\t\t<message type=\"{$h}\" />";
	}
	$rule = $m['platform']['rule'] ? 'true' : 'false';
	$card = $m['platform']['card'] ? 'true' : 'false';
	$bindings = '';
	global $points;
	foreach($points as $p => $row) {
		if(is_array($m['bindings'][$p]) && !empty($m['bindings'][$p])) {
			$piece = "\r\n\t\t<{$p}>";
			foreach($m['bindings'][$p] as $entry) {
				$direct = $entry['direct'] ? 'true' : 'false';
				$piece .= "\r\n\t\t\t<entry title=\"{$entry['title']}\" do=\"{$entry['do']}\" state=\"{$entry['state']}\" direct=\"{$direct}\" />";
			}
			$piece .= "\r\n\t\t</{$p}>";
			$bindings .= $piece;
		}
	}
	if(is_array($m['permission']) && !empty($m['permission'])) {
		$permissions = '';
		foreach($m['permission'] as $entry) {
			$piece .= "\r\n\t\t\t<entry title=\"{$entry['title']}\" do=\"{$entry['permission']}\" />";
		}
		$permissions .= $piece;
	}
	$tpl = <<<TPL
<?xml version="1.0" encoding="utf-8"?>
<manifest xmlns="http://www.we7.cc" versionCode="{$versions}">
	<application setting="{$setting}">
		<name><![CDATA[{$m['application']['name']}]]></name>
		<identifie><![CDATA[{$m['application']['identifie']}]]></identifie>
		<version><![CDATA[{$m['application']['version']}]]></version>
		<type><![CDATA[{$m['application']['type']}]]></type>
		<ability><![CDATA[{$m['application']['ability']}]]></ability>
		<description><![CDATA[{$m['application']['description']}]]></description>
		<author><![CDATA[{$m['application']['author']}]]></author>
		<url><![CDATA[{$m['application']['url']}]]></url>
	</application>
	<platform>
		<subscribes>{$subscribes}
		</subscribes>
		<handles>{$handles}
		</handles>
		<rule embed="{$rule}" />
		<card embed="{$card}" />
	</platform>
	<bindings>{$bindings}
	</bindings>
	<permissions>{$permissions}
	</permissions>
	<install><![CDATA[{$m['install']}]]></install>
	<uninstall><![CDATA[{$m['uninstall']}]]></uninstall>
	<upgrade><![CDATA[{$m['upgrade']}]]></upgrade>
</manifest>
TPL;
	return ltrim($tpl);
}

function define_module($m) {
	$name = ucfirst($m['application']['identifie']);

	$rule = '';
	if($m['platform']['rule']) {
		$rule = <<<TPL
	public function fieldsFormDisplay(\$rid = 0) {
		//要嵌入规则编辑页的自定义内容，这里 \$rid 为对应的规则编号，新增时为 0
	}

	public function fieldsFormValidate(\$rid = 0) {
		//规则编辑保存时，要进行的数据验证，返回空串表示验证无误，返回其他字符串将呈现为错误提示。这里 \$rid 为对应的规则编号，新增时为 0
		return '';
	}

	public function fieldsFormSubmit(\$rid) {
		//规则验证无误保存入库时执行，这里应该进行自定义字段的保存。这里 \$rid 为对应的规则编号
	}

	public function ruleDeleted(\$rid) {
		//删除规则时调用，这里 \$rid 为对应的规则编号
	}

TPL;
	}

	$setting = '';
	if($m['application']['setting']) {
		$setting = <<<TPL
	public function settingsDisplay(\$settings) {
		global \$_W, \$_GPC;
		//点击模块设置时将调用此方法呈现模块设置页面，\$settings 为模块设置参数, 结构为数组。这个参数系统针对不同公众账号独立保存。
		//在此呈现页面中自行处理post请求并保存设置参数（通过使用\$this->saveSettings()来实现）
		if(checksubmit()) {
			//字段验证, 并获得正确的数据\$dat
			\$this->saveSettings(\$dat);
		}
		//这里来展示设置项表单
		include \$this->template('setting');
	}

TPL;
	}

	$tpl = <<<TPL
<?php
/**
 * {$m['application']['name']}模块定义
 *
 * @author {$m['application']['author']}
 * @url {$m['application']['url']}
 */
defined('IN_IA') or exit('Access Denied');

class {$name}Module extends WeModule {
{$rule}
{$setting}
}
TPL;
	return ltrim($tpl);
}

function define_processor($m) {
	$name = ucfirst($m['application']['identifie']);
	$tpl = '';
	if($m['platform']['handles']) {
	$tpl = <<<TPL
<?php
/**
 * {$m['application']['name']}模块处理程序
 *
 * @author {$m['application']['author']}
 * @url {$m['application']['url']}
 */
defined('IN_IA') or exit('Access Denied');

class {$name}ModuleProcessor extends WeModuleProcessor {
	public function respond() {
		\$content = \$this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
	}
}
TPL;
	}
	return ltrim($tpl);
}

function define_receiver($m) {
	$name = ucfirst($m['application']['identifie']);
	$tpl = '';
	if($m['platform']['subscribes']) {
	$tpl = <<<TPL
<?php
/**
 * {$m['application']['name']}模块订阅器
 *
 * @author {$m['application']['author']}
 * @url {$m['application']['url']}
 */
defined('IN_IA') or exit('Access Denied');

class {$name}ModuleReceiver extends WeModuleReceiver {
	public function receive() {
		\$type = \$this->message['type'];
		//这里定义此模块进行消息订阅时的, 消息到达以后的具体处理过程, 请查看微擎文档来编写你的代码
	}
}
TPL;
	}
	return ltrim($tpl);
}

function define_site($m) {
	global $points;
	$name = ucfirst($m['application']['identifie']);
	$tpl = '';

	$dos = '';
	if(is_array($m['bindings']) && !empty($m['bindings'])) {
		$webdos = array();
		$appdos = array();
		foreach($points as $p => $row) {
			if(!empty($m['bindings'][$p]) && in_array($p, array('rule', 'menu'))) {
				foreach($m['bindings'][$p] as $opt) {
					if(in_array($opt['do'], $webdos)){
						continue;
					}
					$webdos[] = $opt['do'];
					$dName = ucfirst($opt['do']);
					$dos .= <<<TPL
	public function doWeb{$dName}() {
		//这个操作被定义用来呈现 {$row['title']}
	}

TPL;
				}
			}
			if(!empty($m['bindings'][$p]) && in_array($p, array('cover', 'home', 'profile', 'shortcut'))) {
				foreach($m['bindings'][$p] as $opt) {
					if(in_array($opt['do'], $appdos)){
						continue;
					}
					$appdos[] = $opt['do'];
					$dName = ucfirst($opt['do']);
					$dos .= <<<TPL
	public function doMobile{$dName}() {
		//这个操作被定义用来呈现 {$row['title']}
	}

TPL;
				}
			}
		}
		$tpl = <<<TPL
<?php
/**
 * {$m['application']['name']}模块微站定义
 *
 * @author {$m['application']['author']}
 * @url {$m['application']['url']}
 */
defined('IN_IA') or exit('Access Denied');

class {$name}ModuleSite extends WeModuleSite {

{$dos}
}
TPL;
	}

	return ltrim($tpl);
}

function f_write($filename, $data) {
	global $_W;
	mkdirs(dirname($filename));
	file_put_contents($filename, $data);
	@chmod($filename, $_W['config']['setting']['filemode']);
	return is_file($filename);
}

function update_handle($module = '') {
	$isupdate = 0;
	if(file_exists(IA_ROOT . '/data/modules_log.php')) {
		$isupdate = 1;
	}
	if(!$isupdate || empty($module)) {
		return true;
	} else {
		@require IA_ROOT . '/data/modules_log.php';
		if(!empty($module_log)) {
			if(isset($module_log[$module])) {
				pdo_update('modules', array('version' => $module_log[$module]), array('name' => $module));
				unset($module_log[$module]);
			}

			if(empty($module_log)) {
				@unlink(IA_ROOT . '/data/modules_log.php');
			} else {
				$content_update = "<?php\r\n";
				$content_update .= "\$module_log = " . var_export($module_log, true) . ";\r\n";
				$content_update .= "?>";
				file_put_contents(IA_ROOT . '/data/modules_log.php', $content_update);
			}
		} else {
			@unlink(IA_ROOT . '/data/modules_log.php');
		}
		return true;
	}
}
