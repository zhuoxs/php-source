<?php
global $_W,$_GPC;
load()->func('tpl');
$uniacid = $_W['uniacid'];
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
//查询商品分类
$fenl = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_goodsfenl')."where uniacid = '{$uniacid}'");
	if($op =='display'){
	  $total = pdo_fetchcolumn('SELECT COUNT(*) FROM '.tablename("hyb_yl_goodsarr")."where uniacid = '{$uniacid}'");
	  $pindex = max(1, intval($_GPC['page'])); 
	  $pagesize = 10;
	  $p = ($pindex-1) * $pagesize; 
      $products = pdo_fetchall('SELECT * FROM '.tablename('hyb_yl_goodsarr')."as a left join ".tablename('hyb_yl_goodsfenl')."as b on b.fid = a.spfenlei where a.uniacid = '{$uniacid}' ORDER BY a.spaixu limit ".$p.",".$pagesize);
      foreach ($products as $key => $value) {
      	$products[$key]['sfbtime'] = date('Y-m-d H:i:s',$products[$key]['sfbtime']);
      }
		if(checksubmit("paixu")){
			$zid=$_GPC['sid'];
			$sord = $_GPC['sord'];
			for($i=0;$i<count($zid);$i++){
				$id = $zid[$i];
				$sid = $sord[$i];
				$data= array(
					'spaixu'=>$sid
					);
				$update_sql=pdo_update('hyb_yl_goodsarr',$data,array('sid'=>$sid,'uniacid'=>$uniacid));
			}
			message('排序成功', $this->createWebUrl('goodssite',array('op'=>'display')), 'success');
		}  
	}
	if($op =='post'){
		  $sid  =$_GPC['sid'];
		  $items =pdo_fetch('SELECT * FROM'.tablename('hyb_yl_goodsarr')."where uniacid='{$uniacid}' and sid='{$sid}'");
		  $items['spic'] = unserialize($items['spic']);
		if(checksubmit()){
			
			 $data = array(
			     'uniacid'  =>$_W['uniacid'],
			     'sname'    =>$_GPC['sname'],
			     'snum'     =>$_GPC['snum'],
			     'tuijian'  =>$_GPC['tuijian'],
			     'ifground' =>$_GPC['ifground'],
			     'spic'     =>serialize($_GPC['spic']),
			     'sdescribe'=>$_GPC['sdescribe'],
			     'scontent' =>$_GPC['scontent'],
			     'sfbtime'  =>strtotime('now'),
			     'sthumb'   =>$_GPC['sthumb'],
			     'spfenlei' =>$_GPC['spfenlei'],
			     'smoney'    =>$_GPC['smoney']
		  	);
			
			 if(empty($sid)){
	            pdo_insert('hyb_yl_goodsarr',$data);
	            message("添加成功!",$this->createWebUrl("goodssite",array("op"=>"display")),"success");
			 }else{
			 	pdo_update('hyb_yl_goodsarr',$data,array('uniacid'=>$uniacid,'sid'=>$sid));
			 	message("更新成功!",$this->createWebUrl("goodssite",array("op"=>"display")),"success");
			 }
		}

	}

include $this->template("goodssite/goodssite");