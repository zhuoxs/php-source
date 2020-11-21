<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

if ($_W['isfounder']) {
	$dos = array('operator', 'menu','management');
} else {
	$dos = array('management');
}
$do = in_array($do, $dos) ? $do : 'management';

if ($do == 'operator') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	
	$wechatmembers = pdo_fetchall('SELECT memberid FROM '.tablename('uni_account_users')." WHERE weid=:weid", array(':weid'=>$_W['weid']), 'memberid');
	if (empty($wechatmembers)) {
		message('抱歉，请您先选择能操作此功能的用户！');
	}
	$where = ' WHERE uid in ('.implode(',', array_keys($wechatmembers)).')';
	if (!empty($_GPC['username'])) {
		$where .= " AND `username` LIKE '%{$_GPC['username']}%'";
	}
	
	$sql = 'SELECT * FROM '.tablename('members').$where." LIMIT ".($pindex - 1) * $psize .','.$psize;
	$members = pdo_fetchall($sql);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename('members').$where);
	$pager = pagination($total, $pindex, $psize);

}

if($do == 'menu') {
	$modulename = $_GPC['module'];
	if(empty($_W['modules'][$modulename])){
		message('抱歉，该模块已经被删除或是您没有权限使用！');
	}
	$uid = intval($_GPC['memberid']);
	if(!empty($uid)){
		$haspermission = pdo_fetch("SELECT id FROM ".tablename('uni_account_users')." WHERE memberid = :memberid", array(':memberid' => $uid));
	}
	if(empty($haspermission)){
		message('抱歉，该用户没有权限操作该功能或是用户已经被删除！');
	}
	
	if (checksubmit('submit')) {
		if (empty($_GPC['check'])) {
			message('抱歉，请您选择要赋予操作人员的菜单权限。');
		}
		pdo_delete('modules_solution_bindings', array('acid'=>$_W['weid'], 'memberid' => $uid, 'module' => $modulename));
		
		foreach ($_GPC['check'] as $i => $check) {
			$eid = $_GPC['eid'][$i];
			$state = $_GPC['state'][$i];
			$do = $_GPC['doname'][$i];
			$title = $_GPC['title'][$i];
			
			if (empty($eid) && empty($state)) {
				continue;
			}
			
			$data = array(
				'acid' => $_W['weid'],
				'memberid' => $uid,
				'module' => $modulename,
				'do' => $do,
				'title' => $title,
				'enable' => 1,
			);
			if (empty($check) || $check != 'true') {
				$data['enable'] = 0;
			}
			if (!empty($eid)) {
				$data['eid'] = $eid;
			} else {
				$data['state'] = $state;
			}
			pdo_insert('modules_solution_bindings', $data);
		}
		message('编辑成功.',url('site/solution/menu', array('module' => $modulename, 'memberid' => $uid)));
	}
		
	$sql = "SELECT id, enable, eid, state FROM ".tablename('modules_solution_bindings')." WHERE memberid = :memberid AND acid = :acid AND module=:module";
	$mymenus = pdo_fetchall($sql, array(':memberid' => $uid, ':acid' => $_W['weid'], ':module' => $modulename));
	
	$menus = array();
	foreach ($mymenus as $menu) {
		if (!empty($menu['eid'])) {
			$menus[$menu['eid']] = $menu;
		} else {
			$menus[$menu['state']] = $menu;
		}
	}
	
	$allmenus = array();
	$bindings = pdo_fetchall('SELECT * FROM '.tablename('modules_bindings')." WHERE module = :module AND entry IN ('menu', 'cover') ORDER BY entry ASC", array(':module' => $modulename));
	
	foreach ($bindings as $binding) {
		if(empty($binding['call'])){
			$allmenus[] = array(
				'eid' => $binding['eid'],
				'do' => $binding['do'],
				'state' => $binding['state'],
				'title' => $binding['title'],
				'url' => $binding['entry'] == 'cover' ? url('rule/cover', array('eid' => $binding['eid'])) : url('site/module/'.$binding['do'], array('name'=>$binding['module'],'weid'=>$_W['weid']))
			);
		} else {
			$call = $binding['call'];
			$site = WeUtility::createModuleSite($modulename);
			if (method_exists($site, $call)) {
				$callmenus = $site->$call();
				if (empty($callmenus) && !is_array($callmenus)) {
					continue;
				}
				foreach ($callmenus as $callmenu) {
					if(empty($callmenu['url']) || empty($callmenu['title'])){
						continue;
					}
					$url_result = parse_url($callmenu['url']);
					if (empty($url_result) || empty($url_result['query'])) {
						continue;
					}
					$query = $url_result['query'];
					parse_str($query, $queryarr);
					ksort($queryarr);
					
					$menu = array();
					$menu['do'] = $queryarr['do'];
					$menu['state'] = http_build_query($queryarr);
					$menu['module'] = $queryarr['name'];
					$menu['memberid'] = $uid;
					$menu['acid'] = $_W['weid'];
					$menu['title'] = $callmenu['title'];
					$menu['url'] = url('site', $queryarr);
					$allmenus[] = $menu;
				}
			}
		}
	}
}

if ($do == 'management') {
	$eid = intval($_GPC['eid']);
	$eid = json_decode(base64_decode($_GPC['eid']), true);
	$modulename = $eid['module'];
	$_W['weid'] = $eid['weid'];
	
	$mod = module_fetch($modulename);
	if (empty($mod)) {
		message('抱歉，该功能未被启用或是您没有使用该功能的权限！');
	}
	
	load()->model('extension');
	
	if (ext_module_checkupdate($modulename)) {
		message('系统检测到该模块有更新，请点击“<a href="'.url('extension/module/upgrade', array('id' => $modulename)).'">更新模块</a>”后继续使用！', '', 'error');
	}
	if (!empty($_W['isfounder'])) {
		$menus = array();
		$bindings = pdo_fetchall('SELECT * FROM ' . tablename('modules_bindings')." WHERE module = :module ORDER BY eid ASC", array(':module' => $modulename));
		if(!empty($bindings) && is_array($bindings)) {
			foreach($bindings as $opt) {
				if(!empty($opt['call'])) {
					$site = WeUtility::createModuleSite($modulename);
					if(method_exists($site, $opt['call'])) {
						$ret = $site->$opt['call']();
						if(is_array($ret)) {
							foreach($ret as $et) {
								$menus[] = array($et['title'], $et['url']);
							}
						}
					}
				} else {
					$menus[] = array(
						$opt['title'],
						url("site/entry", array('eid' => $opt['eid']))
					);
				}
			}
		}
	} else {
		$sql = "SELECT * FROM ".tablename('modules_solution_bindings')." WHERE memberid = :memberid AND acid = :acid AND module=:module AND enable = 1";
		$mymenus = pdo_fetchall($sql, array(':memberid' => $_W['uid'], ':acid' => $_W['weid'], ':module' => $modulename));
		
		foreach ($mymenus as $menu) {
			if (!empty($menu['eid'])) {
				$eids[] = $menu['eid'];
			} else {
				$menus[] = array(
					$menu['title'],
					'site.php?' . $menu['state']
				);
			}
		}
		if (!empty($eids)) {
			$bindings = pdo_fetchall('SELECT * FROM ' . tablename('modules_bindings')." WHERE eid IN (".implode(',', $eids).") ORDER BY eid ASC");
			if(!empty($bindings) && is_array($bindings)) {
				foreach($bindings as $opt) {
					$menus[] = array(
							$opt['title'],
							url("site/entry", array('eid' => $opt['eid']))
					);
				}
			}
		}
	}
	
	if (empty($menus)) {
		message('抱歉，您没有任何操作权限，请联系管理员！');
	}
}

template('site/solution');
