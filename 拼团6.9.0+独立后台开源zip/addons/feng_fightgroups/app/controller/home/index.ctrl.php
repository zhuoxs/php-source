<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * index.ctrl
 * 首页控制器
 */

defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
wl_load()->model('setting');
$time = time();
$scratch = pdo_fetch("select * from".tablename('tg_scratch')."where status=1 and uniacid={$_W['uniacid']} and starttime<'{$time}' and endtime>'{$time}'");
if($op == 'display'){
	puvindex($_W['openid']);
	$page = $config['home'];
	$pagetitle = !empty($config['tginfo']['sname']) ? '首页 - '.$config['tginfo']['sname'] : '首页';
	$advs = pdo_fetchall("select * from " . tablename('tg_adv') . " where enabled = 1 and uniacid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
	foreach ($advs as &$adv) {
		if (substr($adv['link'], 0, 5) != 'http:' && substr($adv['link'], 0,6) != 'https:') {
			$adv['link'] = "http://" . $adv['link'];
		}
	}
	unset($adv);
	$banner= array();
	$nav = pdo_fetchall("SELECT * FROM " . tablename('tg_nav') . " WHERE enabled = 1 and uniacid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
	$banner = pdo_fetchall("SELECT * FROM " . tablename('tg_banner') . " WHERE enabled = 1 and uniacid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
	$notice = pdo_fetchall("SELECT * FROM " . tablename('tg_notice') . " WHERE enabled = 1 and uniacid = '{$_W['uniacid']}' ORDER BY id DESC");
	$cubes=tgsetting_read('cube');
	foreach($cubes?$cubes:array() as $k => $v){
		if(empty($v['thumb']) || $v['on'] == 0){
			unset($cubes[$k]);
		}
	}
	/*顶部菜单栏*/
	$cates = pdo_fetchall("SELECT * FROM " . tablename('tg_category') . " WHERE enabled = 1 and visible_level = 1 and parentid = 0 and uniacid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
	//wl_debug($cates);
	include wl_template('home/index');exit;
}

if($op == 'notice'){
	$pagetitle = !empty($config['tginfo']['sname']) ? '公告详情 - '.$config['tginfo']['sname'] : '公告详情';
	$id = intval($_GPC['id']);
	if($id){
		$notice = pdo_fetch("SELECT * FROM " . tablename('tg_notice') . " WHERE id = '{$id}'");
	}else{
		wl_message('缺少参数，请返回首页！');
	}
	include wl_template('home/notice_detail');
}

