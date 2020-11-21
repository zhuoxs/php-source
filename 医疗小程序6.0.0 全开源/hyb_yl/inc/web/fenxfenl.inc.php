<?php
global $_W,$_GPC;
load()->func('tpl');
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
    $fenl = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_fenxfenl')."where uniacid = '{$uniacid}'");
	if($op =='display'){
	  $total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename("hyb_yl_fenxfenl")."where uniacid = '{$uniacid}'");
	  $pindex = max(1, intval($_GPC['page'])); 
	  $pagesize = 10;
	  $p = ($pindex-1) * $pagesize; 
      $products = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_fenxfenl')."where uniacid = '{$uniacid}' ORDER BY a.spaixu limit ".$p.",".$pagesize);
		if(checksubmit("paixu")){
			$zid=$_GPC['sid'];
			$sord = $_GPC['sord'];
			for($i=0;$i<count($zid);$i++){
				$id = $zid[$i];
				$sid = $sord[$i];
				$data= array(
					'spaixu'=>$sid
					);
				$update_sql=pdo_update('hyb_yl_fenxfenl',$data,array('fxid'=>$sid,'uniacid'=>$uniacid));
			}
			message('排序成功', $this->createWebUrl('fenxfenl',array('op'=>'display')), 'success');
		}  
	}
	if($op =='post'){
		  $fxid  =$_GPC['fxid'];
		  $items =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_fenxfenl')."where uniacid='{$uniacid}' and fxid='{$fxid}'");
		 
		if(checksubmit()){
			
			 $data = array(
			     'uniacid'  =>$_W['uniacid'],
                  'fname'   =>$_GPC['fname'],
                  'type'    =>$_GPC['type'],
                  'spaixu'  =>$_GPC['spaixu'],
		  	);
			 //var_dump($data);exit();
			 if(empty($fxid)){
	            pdo_insert('hyb_yl_fenxfenl',$data);
	            message("添加成功!",$this->createWebUrl("fenxfenl",array("op"=>"display")),"success");
			 }else{
			 	pdo_update('hyb_yl_fenxfenl',$data,array('uniacid'=>$uniacid,'fxid'=>$fxid));
			 	message("更新成功!",$this->createWebUrl("fenxfenl",array("op"=>"display")),"success");
			 }
		}

	}

include $this->template("fenxfenl/fenxfenl");