<?php
global $_W,$_GPC;
load()->func('tpl');
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$id =$_GPC['id'];
$lng = $_GPC['lng'];
$lat = $_GPC['lat'];
$pid =$_GPC['pid'];

//查询商品分类
	if($op =='display'){

      //$products = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_yiyuankeshi')."where uniacid = '{$uniacid}' and id='{$id}'");
		$products=pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_addresshospitai')."where uniacid = '{$uniacid}' and parentid='{$id}'");
	}
	if($op =='post'){
		  $id1  =$_GPC['id1'];
		  $id =$_GPC['id'];   
		  $items =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_addresshospitai')."where uniacid='{$uniacid}' and id='{$id1}'");
		  if(checksubmit('tijiao')){
				 $data = array(
			     'uniacid'=> $_W['uniacid'],
                 'name'=> $_GPC['name'],
                 'parentid'  => $id,
                 'hos_pic'  => $_GPC['hos_pic'],
                 'hos_desc' =>$_GPC['hos_desc'],
                 'lng' =>$lng,
                 'lat' =>$lat,
                 'par_id' =>$pid		  	
                 );
			 if(empty($id1)){
	            pdo_insert('hyb_yl_addresshospitai',$data);
	            message("添加成功!",$this->createWebUrl("diqukeshi",array("op"=>"display",'id'=>$id,'pid'=>$pid,'lng'=>$lng,'lat'=>$lat)),"success");
			 }else{
			 	pdo_update('hyb_yl_addresshospitai',$data,array('uniacid'=>$uniacid,'id'=>$id1));
			 	message("更新成功!",$this->createWebUrl("diqukeshi",array("op"=>"display",'id'=>$id,'pid'=>$pid,'lng'=>$lng,'lat'=>$lat)),"success");
			 }
		}
	}
	//id=5&op=display&pid=110100&do=diqukeshi
	if($op =='delete'){

	}
include $this->template("diqukeshi/diqukeshi");