<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if($op =='display'){
	$pagetitle = !empty($config['tginfo']['sname']) ? '商品分类 - '.$config['tginfo']['sname'] : '商品分类';
	$categoryData=pdo_fetchall("SELECT * FROM " . tablename('tg_category') . " where uniacid={$_W['uniacid']} and enabled=1 and parentid=0  ORDER BY parentid ASC, displayorder DESC");
	$category = $categoryData;
	include wl_template('goods/class');
}
if($op =='ajax'){
	$cid = intval($_GPC['id']);
	$categoryData=model_category::getSingleCategory($cid, '*', array('id'=>$cid));
	$list = $categoryData;
	$lists = pdo_fetchall("SELECT * FROM " . tablename('tg_category') . " where parentid = {$cid} and uniacid={$_W['uniacid']} and enabled=1 ORDER BY parentid ASC, displayorder DESC");
	if(!empty($lists)){
		foreach($lists as $key=>&$value){
			$lists[$key]['url'] = app_url('goods/list/display', array('gid' => $cid,'cid' => $value['id']));
			$lists[$key]['thumb'] = tomedia($value['thumb']);
		}
	}
	$list['url'] = app_url('goods/list/display', array('gid' => $list['id']));
	$list['thumb'] = tomedia($list['thumb']);
	$data = array();
	$data['list'] = $list;
	$data['lists'] = $lists;
	die(json_encode($data));
}
