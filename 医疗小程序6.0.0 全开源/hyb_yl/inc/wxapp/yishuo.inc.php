<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;

$op =$_GPC['op'];  
if($op =='list'){
	$zid = $_GPC['zid'];
	$uniacid = $_W['uniacid'];
	//查询所有分组
    $res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_zhuanjiafenzu")."where uniacid='{$uniacid}' and zid='{$zid}' order by fenzuid desc");
    foreach ($res as $key => $value) {
  	//查询分组下面的所有用户
    	$fenzuid =$value['fenzuid'];
    	$res[$key]['user'] = pdo_fetchall("SELECT a.openid as aopenid,a.*,b.*,c.* FROM".tablename("hyb_yl_collect")."as a left join".tablename("hyb_yl_userinfo")."as b on b.openid=a.openid left join".tablename("hyb_yl_myinfors")."as c on c.openid=b.openid where a.uniacid='{$uniacid}' and a.fenzuid='{$fenzuid}' and a.ifqianyue=2 and a.cerated_type=0 order by a.id desc");
        
      }
    $res['user']=$res;
    $res['weifenzu']=pdo_fetchall("SELECT a.openid as aopenid,a.*,b.*,c.* FROM".tablename("hyb_yl_collect")."as a left join".tablename("hyb_yl_userinfo")."as b on b.openid=a.openid left join".tablename("hyb_yl_myinfors")."as c on c.openid=b.openid where a.uniacid='{$uniacid}' and a.fenzuid=0 and a.ifqianyue=2 and a.goods_id='{$zid}' and a.cerated_type=0 order by a.id desc");

  echo json_encode($res); 
} 


