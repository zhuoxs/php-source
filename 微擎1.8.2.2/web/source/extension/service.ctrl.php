<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
if(empty($_W['isfounder'])) {
	$dos = array('switch');
} else {
	$dos = array('switch', 'display', 'delete', 'post', 'import');
}
$do = in_array($do, $dos) ? $do : 'switch';
load()->model('extension');
load()->model('reply');
load()->model('module');
$predefines = s_predefines();

if($do == 'switch') {
	global $_W, $_GPC;
	$m = module_fetch('userapi');
	$cfg = $m['config'];
	if($_W['ispost']) {
		$rids = explode(',', $_GPC['rids']);
		if(is_array($rids)) {
			$cfg = array();
			foreach($rids as $rid) {
				$cfg[intval($rid)] = true;
			}
			$this->saveSettings($cfg);
		}
		exit();
	}
	load()->model('reply');
	$rs = reply_search("weid = 0 AND module = 'userapi' AND `status`=1");
	$ds = array();
	foreach($rs as $row) {
		$reply = pdo_fetch('SELECT * FROM ' . tablename('userapi_reply') . ' WHERE `rid`=:rid', array(':rid' => $row['id']));
		$r = array();
		$r['title'] = $row['name'];
		$r['rid'] = $row['id'];
		$r['description'] = $reply['description'];
		$r['switch'] = $cfg[$r['rid']] ? ' checked="checked"' : '';
		$ds[] = $r;
	}
	template('extension/switch');
}

if($do == 'display') {
	$_W['page']['title'] = '管理服务 - 常用服务 - 扩展';
	load()->model('reply');
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$types = array('', '等价', '包含', '正则表达式匹配');

	$condition = 'uniacid = 0 AND module = \'userapi\'';
	$params = array();

	if (isset($_GPC['status'])) {
		$condition .= " AND status = :status";
		$params[':status'] = intval($_GPC['status']);
	}
	if(isset($_GPC['keyword'])) {
		$condition .= ' AND `name` LIKE :keyword';
		$params[':keyword'] = "%{$_GPC['keyword']}%";
	}
	$ds = reply_search($condition, $params, $pindex, $psize, $total);
	$pager = pagination($total, $pindex, $psize);

	if (!empty($ds)) {
		foreach($ds as &$item) {
			$reply = pdo_fetch('SELECT * FROM ' . tablename('userapi_reply') . ' WHERE `rid`=:rid', array(':rid' => $item['id']));
			$item['description'] = $reply['description'];
		}
	}
	$import = false;
	$apis = implode('\',\'', array_keys($predefines));
	$apis = "'{$apis}'";
	$sql = 'SELECT DISTINCT `apiurl` FROM ' . tablename('userapi_reply') . ' AS `e` LEFT JOIN ' . tablename('rule') . " AS `r` ON (`e`.`rid`=`r`.`id`) WHERE `r`.`uniacid`='0' AND `apiurl` IN ({$apis})";
	$apiurls = pdo_fetchall($sql);
	if(count($apiurls) != count($predefines)) {
		$import = true;
	}
	template('extension/service');
}

if($do == 'import') {
	$apis = implode('\',\'', array_keys($predefines));
	$apis = "'{$apis}'";
	$sql = 'SELECT DISTINCT `apiurl` FROM ' . tablename('userapi_reply') . ' AS `e` LEFT JOIN ' . tablename('rule') . " AS `r` ON (`e`.`rid`=`r`.`id`) WHERE `r`.`uniacid`='0' AND `apiurl` IN ({$apis})";
	$apiurls = pdo_fetchall($sql);
	$as = array();
	foreach($apiurls as $url) {
		$as[] = $url['apiurl'];
	}
	foreach($predefines as $key => $v) {
		if(!in_array($key, $as)) {
			$rule = array(
				'uniacid' => 0,
				'name' => $v['title'],
				'module' => 'userapi',
				'displayorder' => 255,
				'status' => 1,
			);
			pdo_insert('rule', $rule);
			$rid = pdo_insertid();
			if(!empty($rid)) {
				foreach($v['keywords'] as $row) {
					$data = array(
						'content' => $row[1],
						'type' => $row[0],
						'rid' => $rid,
						'uniacid' => 0,
						'module' => 'userapi',
						'status' => $rule['status'],
						'displayorder' => $rule['displayorder'],
					);
					pdo_insert('rule_keyword', $data);
				}
				$reply = array(
					'rid' => $rid,
					'description' => htmlspecialchars($v['description']),
					'apiurl' => $key,
					'token' => '',
					'default_text' => '',
					'cachetime' => 0
				);
				pdo_insert('userapi_reply', $reply);
			}
		}
	}
	message('成功导入.', referer());
}

if($do == 'delete') {
	$rid = intval($_GPC['rid']);
	$sql = 'DELETE FROM ' . tablename('rule') . " WHERE `uniacid`=0 AND `module`='userapi' AND `id`={$rid}";
	pdo_query($sql);
	$sql = 'DELETE FROM ' . tablename('rule_keyword') . " WHERE `uniacid`=0 AND `module`='userapi' AND `rid`={$rid}";
	pdo_query($sql);
	$sql = 'DELETE FROM ' . tablename('userapi_reply') . " WHERE `rid`={$rid}";
	pdo_query($sql);
	message('成功删除.', referer());
}

if($do == 'post') {
	$rid = intval($_GPC['rid']);
	$_W['page']['title'] = $rid ? '编辑常用服务 - 常用服务 - 扩展' : '添加常用服务 - 常用服务 - 扩展';
	$m = 'userapi';
	if(!empty($rid)) {
		$reply = reply_single($rid);

		$reply['description'] = pdo_fetchcolumn('SELECT description FROM ' . tablename('userapi_reply') . ' WHERE rid = :rid', array(':rid' => $rid));
		if(empty($reply)) {
			message('抱歉，您操作的服务不在存或是已经被删除！', url('extension/service', array('m' => $m)), 'error');
		}
		
		foreach($reply['keywords'] as &$kw) {
			$kw = array_elements(array('type', 'content'), $kw);
		}
	}
	if(checksubmit('submit')) {
		if(empty($_GPC['name'])) {
			message('必须填写服务名称.');
		}

		$keywords = @json_decode(htmlspecialchars_decode($_GPC['keywords']), true);
		if(empty($keywords)) {
			message('必须填写有效的触发关键字.');
		}
		$rule = array(
			'uniacid' => 0,
			'name' => $_GPC['name'],
			'module' => $m,
			'status' => intval($_GPC['status']),
		);
		if(!empty($_GPC['istop']) && $_GPC['istop'] == 'true') {
			$rule['displayorder'] = 255;
		} else {
			$rule['displayorder'] = range_limit($_GPC['displayorder'], 0, 254);
		}
		$module = WeUtility::createModule($m);
		if(empty($module)) {
			message('抱歉，模块不存在请重新其它模块！');
		}
		$msg = $module->fieldsFormValidate();
		if(is_string($msg) && trim($msg) != '') {
			message($msg);
		}
		if (!empty($rid)) {
			$result = pdo_update('rule', $rule, array('id' => $rid));
		} else {
			$result = pdo_insert('rule', $rule);
			$rid = pdo_insertid();
		}
		if (!empty($rid)) {
						$sql = 'DELETE FROM '. tablename('rule_keyword') . ' WHERE `rid`=:rid AND `uniacid`=:uniacid';
			$pars = array();
			$pars[':rid'] = $rid;
			$pars[':uniacid'] = 0;
			pdo_query($sql, $pars);
	
			$rowtpl = array(
				'rid' => $rid,
				'uniacid' => 0,
				'module' => $rule['module'],
				'status' => $rule['status'],
				'displayorder' => $rule['displayorder'],
			);
			foreach($keywords as $kw) {
				$krow = $rowtpl;
				$krow['type'] = range_limit($kw['type'], 1, 4);
				$krow['content'] = $kw['content'];
				pdo_insert('rule_keyword', $krow);
			}
			$module->fieldsFormSubmit($rid);



			message('服务保存成功！', url('extension/service/post', array('m' => $m, 'rid' => $rid)));
		} else {
			message('服务保存失败, 请联系网站管理员！');
		}
	}
	template('extension/service-post');
}


function s_predefines() {
	$predefines = array(
		'weather.php' => array(
			'title' => '城市天气',
			'description' => '"城市名+天气", 如: "北京天气"',
			'keywords' => array(
				array('3', '^.+天气$')
			)
		),
		'baike.php' => array(
			'title' => '百度百科',
			'description' => '"百科+查询内容" 或 "定义+查询内容", 如: "百科姚明", "定义自行车"',
			'keywords' => array(
				array('3', '^百科.+$'),
				array('3', '^定义.+$'),
			)
		),
		'translate.php' => array(
			'title' => '即时翻译',
			'description' => '"@查询内容(中文或英文)"',
			'keywords' => array(
				array('3', '^@.+$'),
			)
		),
		'calendar.php' => array(
			'title' => '今日老黄历',
			'description' => '"日历", "万年历", "黄历"或"几号"',
			'keywords' => array(
				array('1', '日历'),
				array('1', '万年历'),
				array('1', '黄历'),
				array('1', '几号'),
			)
		),
		'news.php' => array(
			'title' => '看新闻',
			'description' => '"新闻"',
			'keywords' => array(
				array('1', '新闻'),
			)
		),
		'express.php' => array(
			'title' => '快递查询',
			'description' => '"快递+单号", 如: "申通1200041125"',
			'keywords' => array(
				array('3', '^(申通|圆通|中通|汇通|韵达|顺丰|EMS) *[a-z0-9]{1,}$')
			)
		),
	);
	return $predefines;
}