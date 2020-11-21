<?php
global $_GPC,$_W;
$cfg = $this->module['config'];
$weid=$_W['uniacid'];
$uid=$_GPC['uid'];//会员ID
$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and id='{$uid}'");
$list=pdo_fetchall("select * from ".tablename('tiger_app_hb')." where weid='{$weid}'");
$list1=array();
foreach($list as $k=>$v){
	$list1[$k]['id']=$v['id'];
	$list1[$k]['pic']=tomedia($v['pic']);
}

$url1=$cfg['tknewurl']."app/index.php?i=".$weid."&c=entry&do=apphbfx&m=tiger_newhu&yq=".$share['yaoqingma']."&hid=".$share['id'];
$dwz=$this->dwzw($url1);
exit(json_encode(array('errcode'=>0,'data'=>$list1,'fxurl'=>$dwz))); 
		
?>