<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
//查询所有合作医院
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'kuaidi';
if($op =='kuaidi'){
  $get = pdo_get('hyb_yl_kuaidi100',array('uniacid'=>$uniacid));
  $data=array(
      'uniacid'=>$uniacid,
      'customer'=>$_GPC['customer'],
      'key'=>$_GPC['key']
  	);
  if($_W['ispost']){
     $kdid=$_GPC['kdid'];
     if(empty($kdid)){
      pdo_insert('hyb_yl_kuaidi100',$data);
      message("添加成功!",$this->createWebUrl("peisite",array("op"=>"kuaidi")),"success");
     }else{
      pdo_update('hyb_yl_kuaidi100',$data,array('kdid'=>$kdid));
      message("修改成功!",$this->createWebUrl("peisite",array("op"=>"kuaidi")),"success");
     }
  }
}
if($op =='display'){
	$res = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_peisong")."where uniacid=:uniacid ",array(":uniacid"=>$_W['uniacid']));
}
if($op =='post'){
	$post = pdo_get('hyb_yl_peisong',array('uniacid'=>$uniacid));
	$data=array(
       'uniacid'=>$_W['uniacid'],
       'gsname' =>$_GPC['gsname'],
       'com'    =>$_GPC['com'],
       'icon'   =>$_GPC['icon'],
		);
  if($_W['ispost']){
  	 $p_id =$_GPC['p_id'];
	   if(empty($p_id)){
	      pdo_insert('hyb_yl_peisong',$data);
	      message("添加成功!",$this->createWebUrl("peisite",array("op"=>"display")),"success");
	   }else{
	      pdo_update('hyb_yl_peisong',$data,array('p_id'=>$p_id));
	      message("修改成功!",$this->createWebUrl("peisite",array("op"=>"display")),"success");
	   }
  }
}
if($op =='delete'){
	$p_id =$_GPC['p_id'];
	pdo_delete('hyb_yl_peisong',array('p_id'=>$p_id));
	message("删除成功!",$this->createWebUrl("peisite",array("op"=>"display")),"success");
}
include $this->template('peisite/peisite');