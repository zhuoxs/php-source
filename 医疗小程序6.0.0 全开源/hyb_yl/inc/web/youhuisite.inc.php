<?php
global $_W,$_GPC;
load()->func('tpl');
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
//查询商品分类
	if($op =='display'){
      $products = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_youhuiquansite')."where uniacid = '{$uniacid}'");
	}
	if($op =='post'){
		  $yh_id  =$_GPC['yh_id'];
		  
		  $items =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_youhuiquansite')."where uniacid='{$uniacid}' and yh_id='{$yh_id}'");

		if(checksubmit()){
			
			 $data = array(
			     'uniacid'  =>$_W['uniacid'],
                 'yh_title' =>$_GPC['yh_title'],
                 'yh_color'  =>$_GPC['yh_color'],
                 'yh_moner'  =>$_GPC['yh_moner'],
                 'yh_kc'    =>$_GPC['yh_kc'],
		  	);
			 //var_dump($data);exit();
			 if(empty($yh_id)){
	            pdo_insert('hyb_yl_youhuiquansite',$data);
	            message("添加成功!",$this->createWebUrl("youhuisite",array("op"=>"display")),"success");
			 }else{
			 	pdo_update('hyb_yl_youhuiquansite',$data,array('uniacid'=>$uniacid,'yh_id'=>$yh_id));
			 	message("更新成功!",$this->createWebUrl("youhuisite",array("op"=>"display")),"success");
			 }
		}
	}
include $this->template("youhuisite/youhuisite");