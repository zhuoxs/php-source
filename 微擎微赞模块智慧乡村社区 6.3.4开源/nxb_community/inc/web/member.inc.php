<?php
global $_W, $_GPC;
include 'common.php';
$key=$_GPC['key'];
$cxtj='';
if($key=='' || $key==null){
	$cxtj='';
}else{
	$cxtj=" AND nickname LIKE '%".$key."%' OR tel LIKE '%".$key."%'";
}


//获取所有会员列表

$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$memberlist=pdo_fetchall("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid ".$cxtj." AND isrz=1 ORDER BY mid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
$total = pdo_fetchcolumn("SELECT count(mid) FROM " . tablename('bc_community_member') ."WHERE weid=:uniacid  AND isrz=1 ORDER BY mid DESC",array(':uniacid'=>$_W['uniacid']));
$pager = pagination($total, $pindex, $psize);

//获取申请认证村民的用户开表

$rzlist=pdo_fetchall("SELECT a.*, b.coname FROM ".tablename('bc_community_member')." as a left join ".tablename('bc_community_community')." as b on a.coid=b.coid WHERE a.weid=:uniacid AND isrz!=1 ORDER BY mid DESC",array(':uniacid'=>$_W['uniacid']));



include $this->template('web/member');
?>