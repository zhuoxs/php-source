<?php
global $_W,$_GPC;
load()->func('tpl');
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
//查询商品分类
	if($op =='display'){
      $products = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_hjfenl')."where uniacid = '{$uniacid}'");
	}
	if($op =='post'){
		  $hj_id  =$_GPC['hj_id'];
		  
		  $items =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_hjfenl')."where uniacid='{$uniacid}' and hj_id='{$hj_id}'");

		if(checksubmit()){
			
			 $data = array(
			     'uniacid'  =>$_W['uniacid'],
                 'hj_name' =>$_GPC['hj_name'],
                 'hj_color'  =>$_GPC['hj_color'],
		  	);
			 //var_dump($data);exit();
			 if(empty($hj_id)){
	            pdo_insert('hyb_yl_hjfenl',$data);
	            message("添加成功!",$this->createWebUrl("hjiaofenl",array("op"=>"display")),"success");
			 }else{
			 	pdo_update('hyb_yl_hjfenl',$data,array('uniacid'=>$uniacid,'hj_id'=>$hj_id));
			 	message("更新成功!",$this->createWebUrl("hjiaofenl",array("op"=>"display")),"success");
			 }
		}
	}
include $this->template("hjiaofenl/hjiaofenl");