<?php
defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
$u_id =$_GPC['u_id'];

if($op=='display'){
  $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_yishuo")."as a left join".tablename("hyb_yl_zhuanjia")."as b on b.zid =a.zid where a.uniacid='{$uniacid}'  order by a.yisid desc");
  foreach ($res as $key => $value) {
  	 $u_ids =unserialize($value['user']);

  	 foreach ($u_ids as $key1 => $value1) {
  	 	$arr = explode(',', $value1['u_id']);
  	 	if(in_array($u_id, $arr)){
  	 		$res1 =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_yishuo")."as a left join".tablename("hyb_yl_zhuanjia")."as b on b.zid =a.zid where a.uniacid='{$uniacid}' and a.hid=0  order by a.yisid desc");
  	 		foreach ($res1 as $key => $value) {

  	 			  	 $res1[$key]['ystime'] =date('Y-m-d H:i:s',$res1[$key]['ystime']);
				  	 $res1[$key]['yspic'] =unserialize($res1[$key]['yspic']);
				  	 $num= count($res1[$key]['yspic']);
				  	 for ($i=0; $i <$num ; $i++) { 
				  	 	$res1[$key]['yspic'][$i] =$_W['attachurl'].$res1[$key]['yspic'][$i];
				  	 }
          if(!empty($res1[$key]['z_thumbs'])){
            $res1[$key]['z_thumbs']= $_W['attachurl'].$res1[$key]['z_thumbs'];
          }
				  	 
  	 		}
           return $this->result(0, "sucess", $res1);
  	 	}
  	 }

  }
}
if($op=='huanjiao'){

  $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_yishuo")."as a left join".tablename("hyb_yl_zhuanjia")."as b on b.zid =a.zid where a.uniacid='{$uniacid}'  order by a.yisid desc");
  foreach ($res as $key => $value) {
  	 $u_ids =unserialize($value['user']);

  	 foreach ($u_ids as $key1 => $value1) {
  	 	$arr = explode(',', $value1['u_id']);
  	 	if(in_array($u_id, $arr)){
  	 		$res1 =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_yishuo")."as a left join".tablename("hyb_yl_zhuanjia")."as b on b.zid =a.zid where a.uniacid='{$uniacid}' and a.hid!=0  order by a.yisid desc");
  	 		

  	 		foreach ($res1 as $key => $value) {
  	 			    //查询患教
  	 			     $h_id =$value['hid'];
  	 			     $res1[$key]['hjlist'] = pdo_fetch("SELECT * FROM".tablename('hyb_yl_hjiaosite')."where uniacid='{$uniacid}' and h_id='{$h_id}'");
  	 			     $res1[$key]['hjlist']['sfbtime'] =date('Y-m-d H:i:s',$res1[$key]['hjlist']['sfbtime']);
  	                 $res1[$key]['hjlist']['h_pic'] =$_W['attachurl'].$res1[$key]['hjlist']['h_pic'];


  	                 $res1[$key]['hjlist']['h_thumb']=unserialize($res1[$key]['hjlist']['h_thumb']);
  	                 $count = count($res1[$key]['hjlist']['h_thumb']);
  	                 for ($i=0; $i <$count ; $i++) { 
  	                 	$res1[$key]['hjlist']['h_thumb'][$i] =$_W['attachurl'].$res1[$key]['hjlist']['h_thumb'][$i];
  	                 }
  	 			  	 $res1[$key]['ystime'] =date('Y-m-d H:i:s',$res1[$key]['ystime']);
				  	 $res1[$key]['yspic'] =unserialize($res1[$key]['yspic']);
				  	 $num= count($res1[$key]['yspic']);
				  	 for ($i=0; $i <$num ; $i++) { 
				  	 	$res1[$key]['yspic'][$i] =$_W['attachurl'].$res1[$key]['yspic'][$i];
				  	 }
				  	 $res1[$key]['z_thumbs']= $_W['attachurl'].$res1[$key]['z_thumbs'];
  	 		}
           return $this->result(0, "sucess", $res1);
  	 	}
  	 }

  }
 
}
if($op=='allyishuo'){
  $zid =$_GPC['zid'];
  $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_yishuo")."as a left join".tablename("hyb_yl_zhuanjia")."as b on b.zid =a.zid where a.uniacid='{$uniacid}' and a.zid='{$zid}' order by a.yisid desc");
  foreach ($res as $key => $value) {
     $h_id=$value['hid'];
     $res[$key]['hjlist'] = pdo_fetch("SELECT * FROM".tablename('hyb_yl_hjiaosite')."where uniacid='{$uniacid}' and h_id='{$h_id}'");
     $res[$key]['hjlist']['sfbtime'] =date('Y-m-d H:i:s',$res[$key]['hjlist']['sfbtime']);
     $res[$key]['hjlist']['h_pic'] =$_W['attachurl'].$res[$key]['hjlist']['h_pic'];
     $res[$key]['hjlist']['h_thumb']=unserialize($res[$key]['hjlist']['h_thumb']);
     $count = count($res1[$key]['hjlist']['h_thumb']);
     for ($i=0; $i <$count ; $i++) { 
      $res1[$key]['hjlist']['h_thumb'][$i] =$_W['attachurl'].$res1[$key]['hjlist']['h_thumb'][$i];
     }
     $res[$key]['ystime'] =date('Y-m-d H:i:s',$res[$key]['ystime']);
     $res[$key]['yspic'] =unserialize($res[$key]['yspic']);
     $res[$key]['user'] =unserialize($res[$key]['user']);
     if($res[$key]['hid'] ==0){
          $res[$key]['types']=0;
     }else{
          $res[$key]['types']=1;
     }
     $num= count($res[$key]['yspic']);
     $res[$key]['z_thumbs']=$_W['attachurl'].$res[$key]['z_thumbs'];
     $res[$key]['count'] = count($res[$key]['user']);
     for ($i=0; $i <$num ; $i++) { 
      $res[$key]['yspic'][$i] =$_W['attachurl'].$res[$key]['yspic'][$i];
     }
  }
  return $this->result(0, "sucess", $res); 
}
if($op=='xiangiqng'){
  $yisid =$_GPC['yisid'];
  $res =pdo_fetch("SELECT * FROM".tablename("hyb_yl_yishuo")."as a left join".tablename("hyb_yl_zhuanjia")."as b on b.zid =a.zid where a.uniacid='{$uniacid}' and a.yisid='{$yisid}' ");
  $res['ystime'] =date('Y-m-d H:i:s',$res['ystime']);
  $res['z_thumbs'] =$_W['attachurl'].$res['z_thumbs'];
  $res['h_text'] =$res['ystext'];
  $num= count($res['yspic']);
     for ($i=0; $i <$num ; $i++) { 
      $res['yspic'][$i] =$_W['attachurl'].$res['yspic'][$i];
     }
  return $this->result(0, "sucess", $res); 
}

