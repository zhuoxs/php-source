<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$openid =$_GPC['openid'];
$index = $_GPC['index'];
$op =$_GPC['op'];
if($op == 'display'){
if($index ==0){
    $res =pdo_fetchall("SELECT * FROM".tablename('hyb_yl_shopgoods')."as a left join".tablename('hyb_yl_goodsarr')."as b on b.sid=a.sid where a.uniacid='{$uniacid}' and a.openid='{$openid}' and a.gouwuche=0 order by a.spid desc");
}
if($index ==1){
	$res =pdo_fetchall("SELECT * FROM".tablename('hyb_yl_shopgoods')."as a left join".tablename('hyb_yl_goodsarr')."as b on b.sid=a.sid where a.uniacid='{$uniacid}' and a.openid='{$openid}' and a.gouwuche=0  and a.paystate=0 order by a.spid desc");
}
if($index==2){
  $res =pdo_fetchall("SELECT * FROM".tablename('hyb_yl_shopgoods')."as a left join".tablename('hyb_yl_goodsarr')."as b on b.sid=a.sid where a.uniacid='{$uniacid}' and a.openid='{$openid}' and a.gouwuche=0  and (a.paystate=2 or a.paystate=1) order by a.spid desc");
 }
if($index==3){
  $res =pdo_fetchall("SELECT * FROM".tablename('hyb_yl_shopgoods')."as a left join".tablename('hyb_yl_goodsarr')."as b on b.sid=a.sid where a.uniacid='{$uniacid}' and a.openid='{$openid}' and a.gouwuche=0  and (a.paystate=3 or a.paystate=4) order by a.spid desc");
 }
 foreach ($res as $key => $value) {
   $res[$key]['sthumb'] =$_W['attachurl'].$res[$key]['sthumb'];
   $res[$key]['time'] =date('Y-m-d H:i:s',$res[$key]['time']);
   $res[$key]['shtime'] =date('Y-m-d H:i:s',$res[$key]['shtime']);
   if($res[$key]['paystate']==0){
   	 $res[$key]['state']='支付';
   	 $res[$key]['state1']='待付款';
   	 $res[$key]['fukuan']='需付款';
   	 $res[$key]['bindtap']='zhifu';
   }
   if($res[$key]['paystate']==1){
   	 $res[$key]['state']='待出库';
   	 $res[$key]['state1']='待出库';
   	 $res[$key]['fukuan']='实付款';
     $res[$key]['bindtap']='cuidan';
     $res[$key]['goumai']='goumai';
   }
   if($res[$key]['paystate']==2){
   	 $res[$key]['state']='查看物流';
   	 $res[$key]['state1']='配送中';
   	 $res[$key]['fukuan']='实付款';
   	 $res[$key]['bindtap']='chakwliu';
   	 $res[$key]['goumai']='goumai';
   }

   if($res[$key]['paystate']==3){
   	 $res[$key]['state']='评价晒单';
   	 $res[$key]['state1']='已完成';
   	 $res[$key]['fukuan']='实付款';
   	 $res[$key]['bindtap']='pingjia';
   	 $res[$key]['goumai']='goumai';
   }
   if($res[$key]['paystate']==4){
     $res[$key]['state']='已完成';
     $res[$key]['state1']='已完成';
     $res[$key]['fukuan']='实付款';
     $res[$key]['bindtap']='';
     $res[$key]['goumai']='goumai';
   }

 }
 echo json_encode($res);
}
if($op == 'delete'){
	$spid =$_GPC['spid'];
	$res = pdo_delete("hyb_yl_shopgoods",array('spid'=>$spid));
    $this->result($res,'删除成功','json');
}
if($op == 'gouwuche'){
$res =pdo_fetchall("SELECT * FROM".tablename('hyb_yl_shopgoods')."as a left join".tablename('hyb_yl_goodsarr')."as b on b.sid=a.sid where a.uniacid='{$uniacid}' and a.openid='{$openid}' and a.gouwuche=1 order by a.spid desc");
 foreach ($res as $key => $value) {
   $res[$key]['sthumb'] =$_W['attachurl'].$res[$key]['sthumb'];
   $res[$key]['time'] =date('Y-m-d',$res[$key]['time']);
}
echo json_encode($res);
}
if($op == 'update'){
   $spid =$_GPC['spid'];
   $data =array(
       'paystate'=>1
   	);
   $res=pdo_update("hyb_yl_shopgoods",$data,array('uniacid'=>$uniacid,'spid'=>$spid));
   echo json_encode($res);
}
if($op == 'update2'){
   $spid =$_GPC['spid'];
   $data =array(
       'paystate'=>3,
        'shtime' =>strtotime("now")
   	);
   $res=pdo_update("hyb_yl_shopgoods",$data,array('uniacid'=>$uniacid,'spid'=>$spid));
   echo json_encode($res);
}
if($op == 'upgouwuche'){
    $arrs =$_GPC['arrs'];
	$value = htmlspecialchars_decode($arrs);
	$array = json_decode($value);
	$gouwu = json_decode(json_encode($array), true);
    $nerarr =array_filter($gouwu);
    foreach ($nerarr as $key => $value) {
    	//批量更新
    	$spid  = $value['id'];
    	$price = $value['price'];
    	$count = $value['count'];

    	$data=array(
         'paymoney'=>$price,
         'count'=>$count,
         'gouwuche'=>0,
         'paystate'=>1
    		);
    	$res = pdo_update("hyb_yl_shopgoods",$data,array('spid'=>$spid));

    }

	echo json_encode($res);
}

if($op == 'delte'){
    $arrs =$_GPC['spid'];
    $spidarr = explode(',', $arrs);
    foreach ($spidarr as $key => $value) {
      //批量删除
      $res = pdo_delete("hyb_yl_shopgoods",array('spid'=>$value));
    }
  echo json_encode($res);
}