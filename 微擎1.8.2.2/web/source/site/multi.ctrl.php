<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('site');
load()->model('extension');

$dos = array('display', 'post', 'del', 'default', 'copy', 'switch', 'quickmenu_display', 'quickmenu_post');
$do = in_array($do, $dos) ? $do : 'display';
$_W['page']['title'] = '微官网';
$setting = uni_setting($_W['uniacid'], 'default_site');
$default_site = intval($setting['default_site']);
$default_site_status = pdo_getcolumn('site_multi', array('id' => $default_site), 'status');
if ($default_site_status != 1) {
	pdo_update('site_multi', array('status' => 1), array('id' => $default_site));
}

if ($do == 'post') {
	if ($_W['isajax'] && $_W['ispost']) {
				$name = trim($_GPC['name']);
		$sql = "SELECT s.*, t.`name` AS `tname`, t.`title`, t.`type` FROM " . tablename('site_styles') . " AS s LEFT JOIN " . tablename('site_templates') . " AS t ON s.`templateid` = t.`id` WHERE s.`uniacid` = :uniacid AND s.`name` LIKE :name";
		$styles = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'], ':name' => "%{$name}%"));
		iajax(0, $styles, '');
	}
	$id = intval($_GPC['multiid']);

	if (checksubmit('submit')) {
		$bindhost = parse_url($_W['siteroot']);
		if ($bindhost['host'] == trim($_GPC['bindhost'])) {
			itoast('绑定域名有误', referer(), 'error');
		}
		$data = array(
			'uniacid' => $_W['uniacid'],
			'title' => trim($_GPC['title']),
			'styleid' => intval($_GPC['styleid']),
			'status' => intval($_GPC['status']),
			'site_info' => iserializer(array(
				'thumb' => trim($_GPC['thumb']),
				'keyword' => trim($_GPC['keyword']),
				'description' => trim($_GPC['description']),
				'footer' => htmlspecialchars($_GPC['footer'])
			)),
			'bindhost' => trim($_GPC['bindhost']),
		);
		if (empty($data['title'])) {
			itoast('请填写站点名称', referer(), 'error');
		}
		if (!empty($id)) {
						if ($id == $default_site) {
				$data['status'] = 1;
			}
			pdo_update('site_multi', $data, array('id' => $id));
		} else {
			pdo_insert('site_multi', $data);
			$id = pdo_insertid();
		}
		if (!empty($_GPC['keyword'])) {
			$cover = array(
				'uniacid' => $_W['uniacid'],
				'title' => $data['title'],
				'keyword' => trim($_GPC['keyword']),
				'url' => url('home', array('i' => $_W['uniacid'], 't' => $id)),
				'description' => trim($_GPC['description']),
				'thumb' => trim($_GPC['thumb']),
				'module' => 'site',
				'multiid' => $id,
			);
			site_cover($cover);
		}
		itoast('更新站点信息成功！', url('site/multi/display'), 'success');
	}

	if (!empty($id)) {
		$multi = pdo_fetch('SELECT * FROM ' . tablename('site_multi') . ' WHERE uniacid = :uniacid AND id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		if (empty($multi)) {
			itoast('微站不存在或已删除', referer(), 'error');
		}
		$multi['site_info'] = iunserializer($multi['site_info']) ? iunserializer($multi['site_info']) : array();
	}


	$temtypes = ext_template_type();
	$temtypes[] = array('name' => 'all', 'title' => '全部');

	$sql = 'SELECT `s`.*, `t`.`id` as `tid`, `t`.`name` AS `tname`, `t`.`title`, `t`.`type`, `t`.`sections` FROM ' . tablename('site_styles') . ' AS `s` LEFT JOIN ' . tablename('site_templates') . ' AS `t` ON `s`.`templateid` = `t`.`id` WHERE `s`.`uniacid` = :uniacid';
	$styles = pdo_fetchall($sql, array(':uniacid' => $_W['uniacid']), 'id');

	if (empty($multi)) {
		$multi = array(
			'site_info' => array(),
			'status' => 1,
		);
	}
	$multi['style'] = $styles[$multi['styleid']];
	template('site/post');
}

if ($do == 'display') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$condition = '';
	$params = array();

	if (!empty($_GPC['keyword'])) {
		$condition .= " AND `title` LIKE :keyword";
		$params[':keyword'] = "%{$_GPC['keyword']}%";
	}

	$templates = uni_templates();
	$params[':uniacid'] = $_W['uniacid'];
	$multis = pdo_fetchall('SELECT * FROM ' . tablename('site_multi') . ' WHERE uniacid = :uniacid'.$condition.' ORDER BY id ASC LIMIT '.($pindex -1)* $psize.','.$psize, $params);
	foreach ($multis as &$li) {
		$li['style'] = pdo_fetch('SELECT * FROM ' .tablename('site_styles') . ' WHERE uniacid = :uniacid AND id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $li['styleid']));
		$li['template'] = pdo_fetch("SELECT * FROM ".tablename('site_templates')." WHERE id = :id", array(':id' => $li['style']['templateid']));
		$li['site_info'] = (array)iunserializer($li['site_info']);
		$li['site_info']['thumb'] = tomedia($li['site_info']['thumb']);
		if (file_exists('../app/themes/'.$li['template']['name'].'/preview.jpg')) {
			$li['preview_thumb'] = $_W['siteroot'].'app/themes/'.$li['template']['name'].'/preview.jpg';
		} else {
			$li['preview_thumb'] = $_W['siteroot'].'web/resource/images/nopic-203.png';
		}
	}
	unset($li);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('site_multi') . " WHERE uniacid = :uniacid".$condition, $params);
	$pager = pagination($total, $pindex, $psize);
	template('site/display');
}

if ($do == 'del') {
	$id = intval($_GPC['id']);
	if ($default_site == $id) {
		itoast('您删除的微站是默认微站,删除前先指定其他微站为默认微站', referer(), 'error');
	}
		pdo_delete('site_nav', array('uniacid' => $_W['uniacid'], 'multiid' => $id));
		$rid = pdo_fetchcolumn('SELECT rid FROM ' .tablename('cover_reply') . ' WHERE uniacid = :uniacid AND multiid = :id', array(':uniacid' => $_W['uniacid'], ':id' => $id));
	if(pdo_delete('rule', array('id' => $rid, 'uniacid' => $_W['uniacid'])) !== false) {
		pdo_delete('rule_keyword', array('rid' => $rid));
		pdo_delete('cover_reply', array('rid' => $rid, 'multiid' => $id));
	}
		pdo_delete('site_multi', array('uniacid' => $_W['uniacid'], 'id' => $id));
	itoast('删除微站成功', referer(), 'success');
}

if ($do == 'copy') {
	$id = intval($_GPC['multiid']);
	$multi = pdo_fetch('SELECT * FROM ' . tablename('site_multi') . ' WHERE uniacid = :uniacid AND id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $id));
	if (empty($multi)) {
		itoast('微站不存在或已删除', referer(), 'error');
	}
	$multi['title'] = $multi['title'] . '_' . random(6);
	unset($multi['id']);
	pdo_insert('site_multi', $multi);
	$multi_id = pdo_insertid();
	if (!$multi_id) {
		itoast('复制微站出错', '', 'error');
	} else {
				$navs = pdo_fetchall('SELECT * FROM ' . tablename('site_nav') . ' WHERE uniacid = :uniacid AND multiid = :id', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		if (!empty($navs)) {
			foreach ($navs as &$nav) {
				unset($nav['id']);
				$nav['multiid'] = $multi_id;
				pdo_insert('site_nav', $nav);
			}
			unset($nav);
		}
				$cover = pdo_fetch('SELECT * FROM ' . tablename('cover_reply') . ' WHERE uniacid = :uniacid AND multiid = :id', array(':uniacid' => $_W['uniacid'], ':id' => $id));
		if (!empty($cover)) {
			$rule = pdo_fetch('SELECT * FROM ' . tablename('rule') . ' WHERE uniacid = :uniacid AND id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $cover['rid']));
			$keywords = pdo_fetchall('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE uniacid = :uniacid AND rid = :id', array(':uniacid' => $_W['uniacid'], ':id' => $cover['rid']));
			if (!empty($rule) && !empty($keywords)) {
				$rule['name'] = $multi['title'] . '入口设置';
				unset($rule['id']);
				pdo_insert('rule', $rule);
				$new_rid = pdo_insertid();
				foreach($keywords as &$keyword) {
					unset($keyword['id']);
					$keyword['rid'] = $new_rid;
					pdo_insert('rule_keyword', $keyword);
				}
				unset($keyword);
				unset($cover['id']);
				$cover['title'] =  $multi['title'] . '入口设置';
				$cover['multiid'] =  $multi_id;
				$cover['rid'] =  $new_rid;
				pdo_insert('cover_reply', $cover);
			}
		}
		itoast('复制微站成功', url('site/multi/post', array('multiid' => $multi_id)), 'success');
	}
}

if ($do == 'switch') {
	$id = intval($_GPC['id']);
	$multi_info = pdo_get('site_multi', array('id' => $id, 'uniacid' => $_W['uniacid']));
	if(empty($multi_info)) {
		itoast('微站不存在或已删除', referer(), 'error');
	}
	$data = array('status' => $multi_info['status'] == 1 ? 0 : 1);
	$result = pdo_update('site_multi', $data, array('id' => $id));
	if(!empty($result)) {
		iajax(0, '更新成功！', '');
	}else {
		iajax(-1, '请求失败！', '');
	}
}
if ($do == 'quickmenu_display' && $_W['isajax'] && $_W['ispost'] && $_W['role'] != 'operator') {
	$multiid = intval($_GPC['multiid']);
	if($multiid > 0){
		$page = pdo_get('site_page', array('multiid' => $multiid, 'type' => 2));
	}
	$params = !empty($page['params']) ? $page['params'] : 'null';
	$status = $page['status'] == 1 ? 1 : 0;
	$modules = uni_modules();
	$modules = !empty($modules) ? $modules : 'null';
	iajax(0, array('params' => json_decode($params), 'status' => $status, 'modules' => $modules), '');
}

if ($do == 'quickmenu_post' && $_W['isajax'] && $_W['ispost']) {
	$params = $_GPC['postdata']['params'];
	if (empty($params)) {
		iajax(1, '请您先设计手机端页面.');
	}
	foreach ($params['position'] as &$val) {
		$val = $val == 'true' ? 1 : 0;
	}
	unset($val);
	$html = safe_gpc_html(htmlspecialchars_decode($_GPC['postdata']['html'], ENT_QUOTES));
	$html = preg_replace('/background\-image\:(\s)*url\(\"(.*)\"\)/U', 'background-image: url($2)', $html);
	$data = array(
		'uniacid' => $_W['uniacid'],
		'multiid' => intval($_GPC['multiid']),
		'title' => '快捷菜单',
		'description' => '',
		'status' => intval($_GPC['status']),
		'type' => 2,
		'params' => json_encode($params),
		'html' => $html,
		'createtime' => TIMESTAMP,
	);
	$id = pdo_fetchcolumn("SELECT id FROM ".tablename('site_page')." WHERE multiid = :multiid AND type = 2", array(':multiid' => intval($_GPC['multiid'])));
	if (!empty($id)) {
		$result = pdo_update('site_page', $data, array('id' => $id));
	} else {
		$result = pdo_insert('site_page', $data);
		$id = pdo_insertid();
	}
	if ($result) {
		iajax(0, '保存成功！', '');
	} else {
		iajax(1, '保存失败！', '');
	}
}