<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid =$_W['uniacid'];
 //发布分享
$op =$_GPC['op'];
if($op =='post'){
	$idarr =htmlspecialchars_decode($_GPC['data_arr']);
	$array =json_decode($idarr);
	$object =json_decode(json_encode($array),true);
	$data =array(
	  'uniacid'=>$uniacid,
	  'sharetitle'  =>$_GPC['sharetitle'],
	  'sharetext' =>$_GPC['sharetext'],
	  'sharepic' =>serialize($object),
	  'zid'    =>$_GPC['zid'],
	  'dateTime'  =>strtotime("now"),
	  'fxid' =>$_GPC['fxid']
	);
	$res =pdo_insert('hyb_yl_sharearr',$data);
	echo json_encode($res);
 }
if($op =='display'){
  $fx_id =$_GPC['fx_id'];
  $res = pdo_fetch('SELECT * FROM'.tablename('hyb_yl_sharearr')."as a left join".tablename('hyb_yl_zhuanjia')."as b on b.zid=a.zid where a.uniacid='{$uniacid}' and a.fx_id='{$fx_id}' ");
  if(!empty($res['z_thumbs'])){
     $res['z_thumbs'] =$_W['attachurl'].$res['z_thumbs'];
  }
	
	$res['sharepic'] =unserialize($res['sharepic']);
	$res['dateTime'] =date("Y-m-d H:i:s",$res['dateTime']);
	$num =count($res['sharepic']);
	for ($i=0; $i <$num ; $i++) { 
		$res['sharepic'][$i] =$_W['attachurl'].$res['sharepic'][$i];
	}
  echo json_encode($res);
}
if($op=='fenxiang'){
	$res = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_fenxfenl')."where uniacid='{$uniacid}' and type=1 ");
	if(!empty($_GPC['fxid'])){
	  $fxid = $_GPC['fxid'];
	}else{
	  $fxid = $res[0]['fxid'];
	}

	//查询分享列表
	$fenliest = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_sharearr')."as a left join".tablename('hyb_yl_zhuanjia')."as b on b.zid=a.zid where a.uniacid='{$uniacid}' and a.fxid='{$fxid}' order by a.fxid desc");
	foreach ($fenliest as $key => $value) {

		if(!empty($value['z_thumbs'])){
           $fenliest[$key]['z_thumbs'] =$_W['attachurl'].$fenliest[$key]['z_thumbs'];
		}
		
		$fenliest[$key]['sharepic'] =unserialize($fenliest[$key]['sharepic']);
		$fenliest[$key]['dateTime'] =date("Y-m-d H:i:s",$fenliest[$key]['dateTime']);
		$num =count($fenliest[$key]['sharepic']);
		for ($i=0; $i <$num ; $i++) { 
			$fenliest[$key]['sharepic'][$i] =$_W['attachurl'].$fenliest[$key]['sharepic'][$i];
		}
	}
	$data =array(
	   'fxinfo'=>$res,
	   'fxlist'=>$fenliest
		);
	echo json_encode($data);
}
//查询医生的所有分享
if($op=='docfenxiang'){
 $zid= $_GPC['zid'];
 $res = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_sharearr')."as a left join".tablename('hyb_yl_zhuanjia')."as b on b.zid=a.zid where a.uniacid='{$uniacid}'  and a.zid='{$zid}' order by a.fx_id desc");
 	foreach ($res as $key => $value) {
		$res[$key]['z_thumbs'] =$_W['attachurl'].$res[$key]['z_thumbs'];
		$res[$key]['sharepic'] =unserialize($res[$key]['sharepic']);
		$res[$key]['dateTime'] =date("Y-m-d H:i:s",$res[$key]['dateTime']);
		$num =count($res[$key]['sharepic']);
		for ($i=0; $i <$num ; $i++) { 
			$res[$key]['sharepic'][$i] =$_W['attachurl'].$res[$key]['sharepic'][$i];
		}
	}
	echo json_encode($res);
}
