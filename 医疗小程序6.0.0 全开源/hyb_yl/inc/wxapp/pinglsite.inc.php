<?php
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
$uniacid = $_W['uniacid'];
$op = $_GPC['op'];
$sid = $_GPC['sid'];
$danhao = date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
if($op =='add'){
  $data =array(
   'uniacid'=>$uniacid,
   'openid' =>$_GPC['openid'],
   'sid' =>$sid,
   'shaddress' =>$_GPC['shaddress'],
   'paystate'  =>$_GPC['paystate'],
   'orders'    =>$danhao,
   'com'       =>$_GPC['com'],
   'num'       =>$_GPC['num'],
   'p_id'      =>$_GPC['p_id'],
   'gsname'    =>$_GPC['gsname'],
   'time'      =>strtotime("now"),
   'shname'    =>$_GPC['shname'],
   'shphone'   =>$_GPC['shphone'],
   'shyoubian' =>$_GPC['shyoubian'],
   'paymoney'  =>$_GPC['paymoney'],
   'count'     =>$_GPC['count'],
   'gouwuche'  =>$_GPC['gouwuche']
  	);
   pdo_insert('hyb_yl_shopgoods',$data);
   $spid =pdo_insertid();

   echo json_encode($spid);
}
if($op =='update'){
	$spid = $_GPC['spid'];
	$data = array(
      'paystate'=>1
		);
    $res = pdo_update('hyb_yl_shopgoods',$data,array('spid'=>$spid));
    //增加销量
    $sid = $_GPC['sid'];
    $syxs = pdo_getcolumn('hyb_yl_goodsarr',array('sid'=>$sid),'syxs');
    $data1 = array(
     'syxs'=>$syxs['syxs']+1
    	);
    pdo_update('hyb_yl_goodsarr',$data1,array('sid'=>$sid));
    echo json_encode($res);
}
if($op =='del'){
	$spid = $_GPC['spid'];
    $res = pdo_delete('hyb_yl_shopgoods',array('spid'=>$spid));
    echo json_encode($res);
}
