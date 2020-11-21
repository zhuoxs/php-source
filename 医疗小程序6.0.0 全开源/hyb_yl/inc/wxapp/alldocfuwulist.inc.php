<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$zid =$_GPC['zid'];
$stype =$_GPC['stype'];
$op=$_GPC['op'];
if($op =='quren'){
	$fu_id =$_GPC['fu_id'];
	$data=array(
       'ifover'=>1
		);
    $res =pdo_update("hyb_yl_fuwuyuyuelist",$data,array('uniacid'=>$uniacid,'fu_id'=>$fu_id));
    echo json_encode($res);
}
if($op =='all'){
	$res = pdo_fetchall("SELECT * FROM".tablename('hyb_yl_fuwuyuyuelist')." as a left join".tablename("hyb_yl_myinfors")."as b on b.my_id=a.my_id left join ".tablename("hyb_yl_userinfo")."as c on c.openid=b.openid where a.uniacid='{$uniacid}' and a.zid='{$zid}' and a.stype='{$stype}' order by a.zy_time desc");

	foreach ($res as $key => $value) {
        $res[$key]['zy_time'] =date("Y-m-d H:i:s",$res[$key]['zy_time']); 
	}
	echo json_encode($res);
}

