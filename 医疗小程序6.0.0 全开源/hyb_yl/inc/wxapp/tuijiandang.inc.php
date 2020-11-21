<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$res =pdo_fetchall("SELECT * FROM".tablename("hyb_yl_jdcategory")."where uniacid='{$uniacid}' and enabled=1");
foreach ($res as $key => $value) {
	$res[$key]['icon']=$_W['attachurl'].$res[$key]['icon'];
}
return $this->result(0, 'success', $res);
