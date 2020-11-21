<?php
global $_W,$_GPC;
load()->func('tpl');
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$fenl = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_hjfenl')."where uniacid = '{$uniacid}'");
if($op =='display'){
  $total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename("hyb_yl_hjiaosite")."where uniacid = '{$uniacid}'");
  $pindex = max(1, intval($_GPC['page'])); 
  $pagesize = 10;
  $p = ($pindex-1) * $pagesize; 
  $products = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_hjiaosite')."as a left join ".tablename('hyb_yl_hjfenl')."as b on b.hj_id = a.h_flname where a.uniacid = '{$uniacid}' ORDER BY a.h_id limit ".$p.",".$pagesize);
  foreach ($products as $key => $value) {
  	$products[$key]['sfbtime'] = date('Y-m-d H:i:s',$products[$key]['sfbtime']);
  }  
}
	if($op =='post'){
		  $h_id  =$_GPC['h_id'];
		  $items =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_hjiaosite')."where uniacid='{$uniacid}' and h_id='{$h_id}'");
		 
		if(checksubmit()){
			 if($_GPC['h_type'] ==1){
               $h_type =$_GPC['aliaut'];
			 }else{
			   $h_type =$_GPC['h_video'];
			 }

			 $data = array(
			     'uniacid'  =>$_W['uniacid'],
			     'h_title'    =>$_GPC['h_title'],
			     'h_pic'   =>$_GPC['h_pic'],
			     'h_video' =>$h_type,
			     'h_type' =>$_GPC['h_type'],
			     'h_admin' =>$_GPC['h_admin'],
			     'h_text' =>$_GPC['h_text'],
			     'h_dianzan' =>$_GPC['h_dianzan'],
			     'h_read' =>$_GPC['h_read'],
			     'h_zhuanfa' =>$_GPC['h_zhuanfa'],
			     'h_tuijian' =>$_GPC['h_tuijian'],
			     'h_flname' =>$_GPC['h_flname'],
			     'sfbtime'  =>strtotime('now')

		  	);
			 //var_dump($data);exit();
			 if(empty($h_id)){
	            pdo_insert('hyb_yl_hjiaosite',$data);
	            message("添加成功!",$this->createWebUrl("hjiaolist",array("op"=>"display")),"success");
			 }else{
			 	pdo_update('hyb_yl_hjiaosite',$data,array('uniacid'=>$uniacid,'h_id'=>$h_id));
			 	message("更新成功!",$this->createWebUrl("hjiaolist",array("op"=>"display")),"success");
			 }
		}

	}

include $this->template("hjiaofenl/hjiaolist");