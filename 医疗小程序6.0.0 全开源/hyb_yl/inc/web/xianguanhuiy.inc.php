<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$hosid = $_GPC['id'];

if($op =='display'){
 //所有会员
	$res = pdo_fetchall("SELECT * FROM".tablename('hyb_yl_lianmenghuiy')."where uniacid='{$uniacid}' and hosid='{$hosid}'");

}
if($op =='post'){
  $hy_id=$_GPC['hy_id'];
  $hosid=$_GPC['hosid'];

  $get=pdo_fetch("SELECT * FROM".tablename('hyb_yl_lianmenghuiy')."as a left join".tablename('hyb_yl_addresshospitai')."as b on b.id =a.hosid  where a.uniacid='{$uniacid}' and hy_id='{$hy_id}'");
 
  $data=array(
	 'uniacid'=>$uniacid,
	 'hy_title'=>$_GPC['hy_title'],
	 'hy_thumb'=>$_GPC['hy_thumb'],
     'hosid' =>$_GPC['id'],
     'hy_desc'=>$_GPC['hy_desc'],
     'hy_admin'=>$_GPC['hy_admin'],
     'hy_time' =>strtotime("now"),
  	);
  if(checksubmit('tijiao')){

    if(!empty($hy_id)){
        pdo_update("hyb_yl_lianmenghuiy",$data,array('uniacid'=>$uniacid,'hy_id'=>$hy_id));
        message("更新成功!",$this->createWebUrl("xianguanhuiy",array("op"=>"display",'id'=>$hosid)),"success");
    }else{
    	pdo_insert("hyb_yl_lianmenghuiy",$data);
        message("添加成功!",$this->createWebUrl("xianguanhuiy",array("op"=>"display",'id'=>$hosid)),"success");
    }
  }
}
include $this->template('xianguanhuiy/xianguanhuiy');
