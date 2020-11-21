<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
if($op =='dianzan'){
	//查询我是否点赞
	$parentid =$_GPC['parentid'];
	$data =array(
    'uniacid'=>$uniacid,
    'parentid'=>$parentid,
    'types'  =>$_GPC['types'],
    'openid' =>$_GPC['openid'],
    'time'   =>strtotime('now')
 		);
    $res =pdo_insert("hyb_yl_dianzanshare",$data);
    //增加点赞数
    $zen = pdo_getcolumn("hyb_yl_share",array('a_id'=>$parentid,'uniacid'=>$uniacid),'dianj');
    $datas = array('dianj' => $zen+1);
    $dianzane = pdo_update("hyb_yl_share",$datas,array('uniacid'=>$uniacid,'a_id'=>$parentid));
	echo json_encode($dianzane);
}
if($op =='overdianzan'){
   $parentid=$_GPC['parentid'];
   $openid =$_GPC['openid'];
   $types =$_GPC['types'];
   $res =pdo_get("hyb_yl_dianzanshare",array('uniacid'=>$uniacid,'openid'=>$openid,'parentid'=>$parentid,'types'=>$types));
   if($res){
    	echo '1';
   }else{
    	echo '0';
   }

}
