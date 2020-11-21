<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid =$_W['uniacid'];
$t_id =$_GPC['t_id'];
$op = $_GPC['op'];

//查询一条最新置顶记录
if($op=='get'){
	$res =pdo_get("hyb_yl_zhuanjteam",array('t_id'=>$t_id,'uniacid'=>$uniacid));
	echo json_encode($res);
}
if($op=='post'){
    $res = pdo_fetchall("SELECT * FROM".tablename("hyb_yl_zhuanjteam")."as a left join ".tablename("hyb_yl_zhuanjia")."as b on b.zid=a.zid where a.uniacid='{$uniacid}' and a.t_id='{$t_id}'");
    foreach ($res as $key => $value) {
    	$res[$key]['z_thumbs'] = $_W['attachurl'].$res[$key]['z_thumbs'];
    }
	echo json_encode($res);
}
