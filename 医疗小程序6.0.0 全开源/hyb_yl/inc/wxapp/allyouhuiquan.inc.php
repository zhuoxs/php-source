<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op = $_GPC['op'];
if($op == 'youhuilist'){
  $res = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_youhuiquansite")."where uniacid='{$uniacid}'");
  echo json_encode($res);
}
if($op == 'lingqu'){
  $yh_id =$_GPC['yh_id'];
  $iflu =pdo_get("hyb_yl_lingquyouhuiq",array('yh_id'=>$yh_id,'openid'=>$_GPC['openid']));
	if($iflu){
		echo "0";
	}else{
	  $data=array(
     'uniacid'=>$uniacid,
     'yh_id'  =>$yh_id,
     'openid' =>$_GPC['openid'],
     'lqtimes'=>strtotime('now') 
  	);
	  $res = pdo_insert("hyb_yl_lingquyouhuiq",$data);
	  echo json_encode($res);	
	}

}
if($op =='wodeyouhuquan'){
  $money =$_GPC['money'];
  $openid =$_GPC["openid"];
  $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_lingquyouhuiq")."as a left join".tablename("hyb_yl_youhuiquansite")."as b on b.yh_id=a.yh_id where a.uniacid='{$uniacid}' and a.types=0 and b.yh_moner<'{$money}'");
  echo json_encode($res);
}
if($op =="wodeaillyouhuiquan"){
  $openid =$_GPC["openid"];
  $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_lingquyouhuiq")."as a left join".tablename("hyb_yl_youhuiquansite")."as b on b.yh_id=a.yh_id where a.uniacid='{$uniacid}' and openid='{$openid}' ");
    echo json_encode($res);
}
