<?php
global $_W, $_GPC;
include 'common.php';

//获取认证会员列表

$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$memberlist=pdo_fetchall("SELECT * FROM ".tablename('nx_information_member')." WHERE weid=:uniacid ORDER BY mid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
$total = pdo_fetchcolumn("SELECT count(mid) FROM " . tablename('nx_information_member') ."WHERE weid=:uniacid ORDER BY mid DESC",array(':uniacid'=>$_W['uniacid']));
$pager = pagination($total, $pindex, $psize);



include $this->template('web/member');
?>