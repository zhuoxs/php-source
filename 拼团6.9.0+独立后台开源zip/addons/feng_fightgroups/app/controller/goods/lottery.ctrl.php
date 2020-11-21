<?php
defined('IN_IA') or exit('Access Denied');
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if($op =='display'){
	$pagetitle = !empty($config['tginfo']['sname']) ? '抽奖 - '.$config['tginfo']['sname'] : '抽奖';
	$lotterys=pdo_fetchall("select fk_goodsid,endtime from".tablename("tg_lottery")."where status=1  and uniacid={$_W['uniacid']}");
	$goodses = array();
	foreach($lotterys as$key=> $value){
		$goodses[$key] = model_goods::getSingleGoods($value['fk_goodsid'], '*', array('id'=>$value['fk_goodsid']));
		$goodses[$key]['endtime'] = $value['endtime'];
	}
	$listData=model_order::getNumOrder('openid,g_id', array('#status#'=>'(1,2,3,4)','mobile>'=>10000000000), 'id desc', 0, 10, 1);
	$lists = $listData[0];
	foreach($lists as $k => $va){
		$sql = 'SELECT nickname FROM '.tablename('tg_member').' WHERE openid=:openid and uniacid=:uniacid';
		$paramse = array(':openid'=>$va['openid'], ':uniacid'=>$_W['uniacid']);
		$members = pdo_fetch($sql, $paramse);
		$lists[$k]['nickname'] = mb_substr($members['nickname'], 0,3,'utf-8');
		$lists[$k]['title'] = pdo_fetchcolumn('SELECT gname FROM '.tablename('tg_goods')." WHERE id = {$va['g_id']}");
	}
	wl_load()->model('setting');
	$page1 = tgsetting_read('lotery_page1');
	include wl_template('goods/lottery_list');
}
