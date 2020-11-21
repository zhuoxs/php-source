<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');


function app_navs($type = 'home', $multiid = 0, $section = 0) {
	global $_W;
	$pos = array();
	$pos['home'] = 1;
	$pos['profile'] = 2;
	$pos['shortcut'] = 3;
	if (empty($multiid) && $type != 'profile') {
		load()->model('account');
		$setting = uni_setting($_W['uniacid'], array('default_site'));
		$multiid = $setting['default_site'];
	}
	$params = array(
		'position' => $pos[$type],
		'status' => 1,
		'uniacid' => $_W['uniacid'],
		'multiid' => $multiid
	);
	$navs = table('site')->siteNavList($params);
	if (!empty($navs)) {
		foreach ($navs as &$row) {
			if (!strexists($row['url'], 'tel:') && !strexists($row['url'], '://') && !strexists($row['url'], 'www') && !strexists($row['url'], 'i=')) {
				$row['url'] .= strexists($row['url'], '?') ? "&i={$_W['uniacid']}" : "?i={$_W['uniacid']}";
			}
			if (is_serialized($row['css'])) {
				$row['css'] = iunserializer($row['css']);
			}
			if (empty($row['css'])) {
				$row['css'] = array(
					'icon' => array(
						'icon' => 'fa fa-external-link',
						'font-size' => '35px',
						'color' => '',
					),
					'name' => array('color' => ''),
				);
			}
			if (empty($row['css']['icon']['icon'])) {
				$row['css']['icon']['icon'] = 'fa fa-external-link';
			}
			if ($row['position'] == '3') {
				if (!empty($row['css'])) {
					unset($row['css']['icon']['font-size']);
				}
			}
			$row['css']['icon']['style'] = "color:{$row['css']['icon']['color']};font-size:{$row['css']['icon']['font-size']}px;";
			$row['css']['name'] = "color:{$row['css']['name']['color']};";
		}
		unset($row);
	}
	return $navs;
}


function app_update_today_visit($module_name) {
	global $_W;
	$module_name = trim($module_name);
	if (empty($module_name) || !in_array($_W['account']['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH, ACCOUNT_TYPE_WEBAPP_NORMAL))) {
		return false;
	}
	$today = date('Ymd');

	$statistics_table = table('statistics');
	$params = array(
		'date' => $today,
		'uniacid' => $_W['uniacid'],
		'module' => $module_name,
		'type' => 'app'
	);
	$today_exist = $statistics_table->visitList($params, 'one');

	if (empty($today_exist)) {
		$insert_data = array(
			'uniacid' => $_W['uniacid'],
			'module' => $module_name,
			'type' => 'app',
			'date' => $today,
			'count' => 1
		);
		pdo_insert('stat_visit', $insert_data);
	} else {
		$data = array('count' => $today_exist['count'] + 1);
		pdo_update('stat_visit' , $data, array('id' => $today_exist['id']));
	}

	return true;
}


function app_pass_visit_limit($uniacid = 0) {

	global $_W;
	if ($_W['isajax'] || $_W['ispost'] || strpos($_W['siteurl'], 'c=utility&a=visit') !== false) {
		return false;
	}
	$uniacid = intval($uniacid) > 0 ? intval($uniacid) : $_W['uniacid'];

	$limit = uni_setting_load('statistics', $uniacid);
	$limit = $limit['statistics'];

	if (empty($limit)) {
		return false;
	}
	$cachekey = cache_system_key('statistics', array('uniacid' => $uniacid));
	$cache = cache_load($cachekey);
	if (!empty($cache) && ($cache['time'] + $limit['interval'] > TIMESTAMP)) {
		return $cache['limit'];
	}
	$data = array('time'=> TIMESTAMP, 'limit' => false);

	$today_num = app_today_visit($uniacid);
	if (!empty($limit['founder'])) {
		$order_num = 0;
		$orders = table('store')->apiOrderWithUniacid($uniacid);
		if (!empty($orders)) {
			foreach ($orders as $order) {
				$order_num += $order['duration'] * $order['api_num'] * 10000;
			}
		}
				$before_num = app_month_visit_till_today($uniacid);
		$sum_num = intval($limit['founder']) + $order_num - intval($limit['use']);
		if ($sum_num <= 0) {
			$data['limit'] = true;
			cache_write($cachekey, $data);
			return true;
		}
	}
		if (!empty($limit['owner']) && $today_num > $limit['owner']) {
		$data['limit'] = true;
		cache_write($cachekey, $data);
		return true;
	}

	if (!empty($limit['founder']) && ($before_num + $today_num) > $limit['founder']) {
		$limit['use'] = !empty($limit['use']) ? (intval($limit['use']) + 1) : 1;
		uni_setting_save('statistics', $limit);
	}
	cache_write($cachekey, $data);
	return false;
}


function app_month_visit_till_today($uniacid = 0) {
	global $_W;
	$result = 0;
	$uniacid = intval($uniacid) > 0 ? intval($uniacid) : $_W['uniacid'];
	$today = date('Ymd');
	$cachekey = cache_system_key('uniacid_visit', array('uniacid' => $uniacid, 'today' => $today));
	$cache = cache_load($cachekey);
	if (!empty($cache)) {
		return $cache;
	}
	$start = date('Ym01', strtotime(date("Ymd")));
	$end = date('Ymd', strtotime('-1 day'));
	$params = array('date >=' => $start, 'date <=' => $end, 'uniacid' => $uniacid, 'type' => 'app');
	$visit = table('statistics')->visitList($params);
	if (!empty($visit)) {
		foreach ($visit as $val) {
			$result += $val['count'];
		}
	}
	cache_write($cachekey, $result);
	return $result;
}


function app_today_visit($uniacid = 0) {
	global $_W;
	$result = 0;
	$uniacid = intval($uniacid) > 0 ? intval($uniacid) : $_W['uniacid'];

	$params = array('date' => date('Ymd'), 'uniacid' => $uniacid, 'type' => 'app');
	$today = table('statistics')->visitList($params);
	if (!empty($today)) {
		foreach ($today as $val) {
			$result += $val['count'];
		}
	}
	return $result;
}


function app_link_uniaicd_info($module_name) {
	global $_W;
	$result = 0;
	if (empty($module_name)) {
		return $result;
	}
	$module_info = module_fetch($module_name);
	if (empty($module_info)) {
		return $result;
	}
	if (!empty($module_info['config'])) {
		$settings = (array)$module_info['config'];
		$result = !empty($settings['link_uniacid']) ? intval($settings['link_uniacid']) : 0;
	}
	return $result;
}
