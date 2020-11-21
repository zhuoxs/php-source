<?php
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
//所有推荐商品
    $getgoodslist  = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_goodsarr')."where uniacid ='{$uniacid}' AND tuijian=1");

	foreach ($getgoodslist as $key => $value) {

	  $getgoodslist[$key]['sthumb'] =$_W['attachurl'].$getgoodslist[$key]['sthumb'];

	} 

//所有分类商品

	$getallfenlegoods = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_goodsfenl')."where uniacid = '{$uniacid}'");

	foreach ($getallfenlegoods as $key1 => $value1) {

	  $getallfenlegoods[$key1]['fenlpic'] =$_W['attachurl'].$getallfenlegoods[$key1]['fenlpic'];

	} 
	$data =array(
     'item'     =>$getgoodslist,
     'category' =>$getallfenlegoods
	);
	echo json_encode($data);
