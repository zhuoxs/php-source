<?php
	global $_W, $_GPC;
	$uid=$_GPC['uid'];//share id 
  $itemidmore=base64_decode($_GPC['itemidmore']);
	//echo "<pre>";
	//echo $uid."<br>";
	//echo $itemidmore;
	$arr=explode(",", $itemidmore);
	$arritemid=array_filter($arr);//去除空值
	//print_r($arritemid);
	//exit;
	$list=array();
	foreach($arritemid as $k=>$v){
		$fxgoods = pdo_fetchall("select * from ".tablename($this->modulename."_shoucang")." where weid='{$_W['uniacid']}' and uid='{$uid}' and goodsid='{$v}'");
		$list[]=$fxgoods[0];
		
	}
// 	
// 	echo "<pre>";
// 	echo $v;
// 	print_r($list);
// 	exit;
			 
	include $this->template ( 'zt/shoucangfx' );

        