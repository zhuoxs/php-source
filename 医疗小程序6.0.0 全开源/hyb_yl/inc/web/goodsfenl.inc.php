<?php
global $_W,$_GPC;
load()->func('tpl');
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
//查询商品分类
	if($op =='display'){
      $products = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_goodsfenl')."where uniacid = '{$uniacid}'");
	}
	if($op =='post'){
		  $fid  =$_GPC['fid'];
		  $items =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_goodsfenl')."where uniacid='{$uniacid}' and fid='{$fid}'");
		if(checksubmit()){
			
			 $data = array(
			     'uniacid'  =>$_W['uniacid'],
                 'fenlname' =>$_GPC['fenlname'],
                 'fenlpic'  =>$_GPC['fenlpic'],
		  	);
			 //var_dump($data);exit();
			 if(empty($fid)){
	            pdo_insert('hyb_yl_goodsfenl',$data);
	            message("添加成功!",$this->createWebUrl("goodsfenl",array("op"=>"display")),"success");
			 }else{
			 	pdo_update('hyb_yl_goodsfenl',$data,array('uniacid'=>$uniacid,'fid'=>$fid));
			 	message("更新成功!",$this->createWebUrl("goodsfenl",array("op"=>"display")),"success");
			 }
		}
	}
include $this->template("goodssite/goodsfenl");