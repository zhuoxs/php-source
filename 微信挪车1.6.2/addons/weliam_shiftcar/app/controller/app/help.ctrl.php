<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pagetitle = !empty($config['tginfo']['sname']) ? '帮助中心 - '.$config['tginfo']['sname'] : '帮助中心';

if($op == 'display'){
	$lists = pdo_getall('weliam_shifcar_category',array('uniacid'=>$_W['uniacid'],'is_show' => 2));
	$question = pdo_getall('weliam_shifcar_question',array('uniacid'=>$_W['uniacid'],'is_importent' => 2,'is_show' => 2));
	include wl_template('app/help_list');
}

if($op == 'list'){
	if(intval($_GPC['id'])){
		$question = pdo_getall('weliam_shifcar_question',array('uniacid'=>$_W['uniacid'],'categoryid' => intval($_GPC['id']),'is_show' => 2));
	}
	include wl_template('app/help_list');
}

if($op == 'detail'){
	if(intval($_GPC['id'])){
		$question = pdo_get('weliam_shifcar_question',array('uniacid'=>$_W['uniacid'],'id' => intval($_GPC['id'])));
		$scan = $question['scan'] + 1;
		pdo_update('weliam_shifcar_question',array('scan'=>$scan),array('uniacid'=>$_W['uniacid'],'id' => intval($_GPC['id'])));
	}
	include wl_template('app/help_detail');
}
