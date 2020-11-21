<?php
defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$op =$_GPC['op'];
$fenzuid = $_GPC['fenzuid'];
$zid = $_GPC['zid'];
if($op=='display'){
  if($fenzuid==0){
	$res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_collect")."as a left join".tablename("hyb_yl_userinfo")."as b on b.openid=a.openid left join".tablename("hyb_yl_myinfors")."as c on c.openid=b.openid where a.uniacid='{$uniacid}' and a.goods_id='{$zid}' AND a.ifqianyue=1 order by a.id desc");
  }else{
   $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_collect")."as a left join".tablename("hyb_yl_userinfo")."as b on b.openid=a.openid left join".tablename("hyb_yl_myinfors")."as c on c.openid=b.openid where a.uniacid='{$uniacid}' and a.fenzuid='{$fenzuid}' and a.goods_id='{$zid}' AND a.ifqianyue=2 order by a.id desc");
    }
	$message = 'success';
	$errno = 0;
	$new = array_unique($res);
	return $this->result($errno, $message, $new); 
}
if($op=='sousuo'){
  $kewords=$_GPC['kewords'];
  $zid =$_GPC['zid'];
  $res = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_collect")."as a left join".tablename("hyb_yl_userinfo")."as b on b.openid=a.openid left join".tablename("hyb_yl_myinfors")."as c on c.openid=b.openid where a.uniacid='{$uniacid}' and a.goods_id='{$zid}' AND a.ifqianyue=2 AND (c.myname like '%{$kewords}%' or b.u_name like '%{$kewords}%')  order by a.id desc");
  echo json_encode($res);
}

