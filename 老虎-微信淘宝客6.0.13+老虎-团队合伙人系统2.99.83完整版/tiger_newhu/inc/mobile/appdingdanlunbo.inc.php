<?php
global $_GPC,$_W;
$cfg = $this->module['config'];
$weid=$_W['uniacid'];

    $list = pdo_fetchall("select * from ".tablename("tiger_newhu_msg")." where weid='{$weid}' ORDER BY id desc");
		
	exit(json_encode(array('errcode'=>0,'data'=>$list))); 
		
?>