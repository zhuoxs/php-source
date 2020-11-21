<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('extension');
load()->model('module');
load()->func('file');

$dos = array('default', 'designer', 'module', 'template', 'copy', 'build', 'del');
$do = in_array($do, $dos) ? $do : 'template';
permission_check_account_user('platform_site');

$templateid = intval($_GPC['templateid']);

if ($do == 'template') {
	$setting = uni_setting($_W['uniacid'], array('default_site'));
	$setting['styleid'] = pdo_fetchcolumn('SELECT styleid FROM ' . tablename('site_multi') . ' WHERE uniacid = :uniacid AND id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $setting['default_site']));
	$_W['page']['title'] = '风格管理 - 网站风格设置 - 微站功能';
	$params = array();
	$params[':uniacid'] = $_W['uniacid'];
	$condition = '';
	if (!empty($_GPC['keyword'])) {
		$condition .= " AND a.name LIKE :keyword";
		$params[':keyword'] = "%{$_GPC['keyword']}%";
	}
	$styles = pdo_fetchall("SELECT a.* FROM ".tablename('site_styles')." AS a LEFT JOIN ".tablename('site_templates')." AS b ON a.templateid = b.id WHERE uniacid = :uniacid ".(!empty($condition) ? " $condition" : ''), $params);
	$templates = uni_templates();

		$stylesResult = array();
	foreach ($templates as $k => $v) {
		if (!empty($_GPC['keyword'])) {
			if (strpos($v['title'], $_GPC['keyword']) !== false) {
				$stylesResult[$k] = array(
					'templateid' => $v['id'],
					'name' => $v['name'],
					'title' => $v['title'],
					'type' => $v['type']
				);
			}
		} else {
			$stylesResult[$k] = array(
				'templateid' => $v['id'],
				'name' => $v['name'],
				'title' => $v['title'],
				'type' => $v['type']
			);
			foreach ($styles as $style_val) {
				if ($v['id'] == $style_val['templateid']) {
					unset($stylesResult[$k]);
				}
			}
		}

	}
	$templates_id = array_keys($templates);
	foreach ($styles as $v) {
				if (!in_array($v['templateid'], $templates_id)) {
			continue;
		}
		$stylesResult[] =  array(
			'styleid' => $v['id'],
			'templateid' => $v['templateid'],
			'name' => $templates[$v['templateid']]['name'],
			'title' => $v['name'],
			'type' => $templates[$v['templateid']]['type']
		);
	}
	if (!empty($_GPC['type']) && $_GPC['type'] != 'all') {
		$tmp = array();
		foreach ($stylesResult as $k => $v) {
			if ($v['type'] == $_GPC['type']) {
				$tmp[] = $v;
			}
		}
		$stylesResult = $tmp;
	}
	array_multisort($stylesResult, SORT_DESC);
	$temtypes = ext_template_type();
	template('site/tpl-display');
}

if ($do == 'default') {
	$setting = uni_setting($_W['uniacid'], array('default_site'));
	$multi = pdo_fetch('SELECT id,styleid FROM ' . tablename('site_multi') . ' WHERE uniacid = :uniacid AND id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $setting['default_site']));
	if (empty($multi)) {
		itoast('您的默认微站找不到,请联系网站管理员', '', 'error');
	}

	$styleid = intval($_GPC['styleid']);
	$style = pdo_fetch("SELECT * FROM ".tablename('site_styles')." WHERE id = :styleid AND uniacid = :uniacid", array(':styleid' => $styleid, ':uniacid' => $_W['uniacid']));
	if (empty($style)) {
		itoast('抱歉，风格不存在或是您无权限使用！', '', 'error');
	}
	$templateid = $style['templateid'];
	$template = array();
	$templates = uni_templates();
	if (!empty($templates)) {
		foreach ($templates as $row) {
			if ($row['id'] == $templateid) {
				$template = $row;
				break;
			}
		}
	}
	if (empty($template)) {
		itoast('抱歉，模板不存在或是您无权限使用！', '', 'error');
	}
	pdo_update('site_multi', array('styleid' => $styleid), array('uniacid' => $_W['uniacid'], 'id' => $setting['default_site']));
	$styles = pdo_fetchall("SELECT variable, content FROM " . tablename('site_styles_vars') . " WHERE styleid = :styleid  AND uniacid = '{$_W['uniacid']}'", array(':styleid' => $styleid), 'variable');
	$styles_tmp = array_keys($styles);
	$templatedata = ext_template_manifest($template['name']);
	if (empty($styles)) {
		if (!empty($templatedata['settings'])) {
			foreach ($templatedata['settings'] as $list) {
				pdo_insert('site_styles_vars', array('variable' => $list['key'], 'content' => $list['value'], 'description' => $list['desc'], 'templateid' => $templateid, 'styleid' => $styleid, 'uniacid' => $_W['uniacid']));
			}
		}
	} else {
		if (!empty($templatedata['settings'])) {
			foreach ($templatedata['settings'] as $list) {
				if (!in_array($list['key'], $styles_tmp)) {
					pdo_insert('site_styles_vars', array(
						'content' => $list['value'],
						'templateid' => $templateid,
						'styleid' => $styleid,
						'variable' => $list['key'],
						'description' => $list['desc'],
						'uniacid' => $_W['uniacid']
					));
				}
			}
		}
	}
	itoast('默认模板更新成功！', url('site/style/template'), 'success');
}

if ($do == 'designer') {
	$styleid = intval($_GPC['styleid']);
	$style = pdo_fetch("SELECT * FROM ".tablename('site_styles')." WHERE id = :id AND uniacid = :unacid", array(':id' => $styleid, ':unacid' => $_W['uniacid']));
	if (empty($style)) {
		itoast('抱歉，风格不存在或是已经被删除！', '', 'error');
	}
	$templateid = $style['templateid'];
	$template = pdo_fetch("SELECT * FROM " . tablename('site_templates') . " WHERE id = '{$templateid}'");
	if (empty($template)) {
		itoast('抱歉，模板不存在或是已经被删除！', '', 'error');
	}
	$styles = pdo_fetchall("SELECT variable, content, description FROM " . tablename('site_styles_vars') . " WHERE styleid = :styleid AND uniacid = :uniacid", array(':styleid' => $styleid, ':uniacid' => $_W['uniacid']), 'variable');
	if (checksubmit('submit')) {

		if (!empty($_GPC['style'])) {
			$_GPC['style'] = safe_gpc_array($_GPC['style']);
			foreach ($_GPC['style'] as $variable => $value) {
				$value = safe_gpc_html(htmlspecialchars_decode($value, ENT_QUOTES));
				if ($variable == 'imgdir') {
					$value = safe_gpc_path($value);
				}
				if (!empty($styles[$variable])) {
					if ($styles[$variable]['content'] != $value) {
						pdo_update('site_styles_vars', array('content' => $value), array(
							'styleid' => $styleid,
							'variable' => $variable,
						));
					}
					unset($styles[$variable]);
				} elseif (!empty($value)) {
					pdo_insert('site_styles_vars', array(
						'content' => $value,
						'templateid' => $templateid,
						'styleid' => $styleid,
						'variable' => $variable,
						'uniacid' => $_W['uniacid']
					));
				}
			}
		}
		if (!empty($_GPC['custom']['name'])) {
			$_GPC['custom']['name'] = safe_gpc_array($_GPC['custom']['name']);
			foreach ($_GPC['custom']['name'] as $i => $variable) {
				$value = $_GPC['custom']['value'][$i];
				$desc = $_GPC['custom']['desc'][$i];
				if (!empty($value)) {
					if (!empty($styles[$variable])) {
						if ($styles[$variable] != $value) {
							pdo_update('site_styles_vars', array('content' => $value, 'description' => $desc), array(
								'templateid' => $templateid,
								'variable' => $variable,
								'uniacid' => $_W['uniacid'],
								'styleid' => $styleid
							));
						}
						unset($styles[$variable]);
					} else {
						pdo_insert('site_styles_vars', array(
							'content' => $value,
							'templateid' => $templateid,
							'styleid' => $styleid,
							'variable' => $variable,
							'description' => $desc,
							'uniacid' => $_W['uniacid']
						));
					}
				}
			}
		}

		if (!empty($styles)) {
			$stylekeys = array_keys($styles);
			$stylekeys = array_map(function($item){
				return str_replace(' ','',$item);
			},$stylekeys);
			$stylekeys_str = implode(',', $stylekeys);
			pdo_query("DELETE FROM " . tablename('site_styles_vars') . " WHERE variable IN ('" . $stylekeys_str . "') AND styleid = :styleid AND uniacid = '{$_W['uniacid']}'", array(':styleid' => $styleid));
		}
		pdo_update('site_styles', array('name' => $_GPC['name']), array('id' => $styleid));
		itoast('更新风格成功！', url('site/style'), 'success');
	}
	$systemtags = array(
		'imgdir',
		'indexbgcolor',
		'indexbgimg',
		'indexbgextra',
		'fontfamily',
		'fontsize',
		'fontcolor',
		'fontnavcolor',
		'linkcolor',
		'css'
	);
	template('site/tpl-post');
}

if ($do == 'module') {
		$_W['page']['title'] = '模块扩展模板说明 - 网站风格设置 - 微站功能';
	if (empty($_W['isfounder'])) {
		itoast('您无权进行该操作！', '', '');
	}
	$setting = uni_setting($_W['uniacid'], array('default_site'));
	$styleid = pdo_fetchcolumn("SELECT styleid FROM ".tablename('site_multi')." WHERE id = :id", array(':id' => $setting['default_site']));
	$templateid = pdo_fetchcolumn("SELECT templateid FROM ".tablename('site_styles')." WHERE id = :id", array(':id' => $styleid));
	$ts = uni_templates();
	$currentTemplate = !empty($ts[$templateid]) ? $ts[$templateid]['name'] : 'default';
	$modules = uni_modules();
	$path = IA_ROOT . '/addons';
	if (is_dir($path)) {
		if ($handle = opendir($path)) {
			while (false !== ($modulepath = readdir($handle))) {
				if ($modulepath != '.' && $modulepath != '..' && !empty($modules[$modulepath])) {
					if (is_dir($path . '/' . $modulepath . '/template/mobile')) {
						if ($handle1 = opendir($path . '/' . $modulepath . '/template/mobile')) {
							while (false !== ($mobilepath = readdir($handle1))) {
								if ($mobilepath != '.' && $mobilepath != '..' && strexists($mobilepath, '.html')) {
									$templates[$modulepath][] = $mobilepath;
								}
							}
						}
					}
				}
			}
		}
	}
	template('site/style');
}



if ($do == 'build') {
	$templateid = intval($_GPC['styleid']);
	$template = array();
	$templates = uni_templates();
	if (!empty($templates)) {
		foreach ($templates as $row) {
			if ($row['id'] == $templateid) {
				$template = $row;
				break;
			}
		}
	}
	if (empty($template)) {
		itoast('抱歉，模板不存在或是您无权限使用！', '', 'error');
	}
	list($templatetitle) = explode('_', $template['title']);
	$newstyle = array(
		'uniacid' => $_W['uniacid'],
		'name' => $templatetitle.'_'.random(4),
		'templateid' => $template['id'],
	);
	pdo_insert('site_styles', $newstyle);
	$id = pdo_insertid();

	$templatedata = ext_template_manifest($template['name']);
	if (!empty($templatedata['settings'])) {
		foreach ($templatedata['settings'] as $style_var) {
			if (!empty($style_var['key']) && !empty($style_var['desc'])) {
				pdo_insert('site_styles_vars', array(
					'content' => $style_var['value'],
					'templateid' => $templateid,
					'styleid' => $id,
					'variable' => $style_var['key'],
					'uniacid' => $_W['uniacid'],
					'description' => $style_var['desc'],
				));
			}
		}
	}
	itoast('风格创建成功，进入“设计风格”界面。', url('site/style/designer', array('templateid' => $template['id'], 'styleid' => $id)), 'success');
}

if ($do == 'copy') {
	$styleid = intval($_GPC['styleid']);
	$style = pdo_fetch("SELECT * FROM ".tablename('site_styles')." WHERE id = :id AND uniacid = '{$_W['uniacid']}'", array(':id' => $styleid));
	if (empty($style)) {
		itoast('抱歉，风格不存在或是已经被删除！', '', 'error');
	}
	$templateid = $style['templateid'];
	$template = pdo_fetch("SELECT * FROM " . tablename('site_templates') . " WHERE id = '{$templateid}'");
	if (empty($template)) {
		itoast('抱歉，模板不存在或是已经被删除！', '', 'error');
	}

	list($name) = explode('_', $style['name']);
	$newstyle = array(
		'uniacid' => $_W['uniacid'],
		'name' => $name.'_'.random(4),
		'templateid' => $style['templateid'],
	);
	pdo_insert('site_styles', $newstyle);
	$id = pdo_insertid();

	$styles = pdo_fetchall("SELECT variable, content, templateid, uniacid FROM " . tablename('site_styles_vars') . " WHERE styleid = :styleid AND uniacid = '{$_W['uniacid']}'", array(':styleid' => $styleid));
	if (!empty($styles)) {
		foreach($styles as $data) {
			$data['styleid'] = $id;
			pdo_insert('site_styles_vars', $data);
		}
	}
	itoast('风格复制成功，进入“设计风格”界面。', url('site/style/designer', array('templateid' => $style['templateid'], 'styleid' => $id)), 'success');
}

if ($do == 'del') {
	$styleid = intval($_GPC['styleid']);
	pdo_delete('site_styles_vars', array('uniacid' => $_W['uniacid'], 'styleid' => $styleid));
	pdo_delete('site_styles', array('uniacid' => $_W['uniacid'], 'id' => $styleid));
	itoast('删除风格成功。', referer(), 'success');
}