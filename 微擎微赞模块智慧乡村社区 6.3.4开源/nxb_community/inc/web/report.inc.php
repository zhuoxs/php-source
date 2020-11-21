<?php
global $_W, $_GPC;
include 'common.php';
$nid=intval($_GPC['nid']);
$cxtj='';
if($nid==0){
	$cxtj='';
}else{
	$cxtj=' AND newsid='.$nid;
}

//查找志愿活动这个栏目的ID变量
$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE weid=:uniacid AND mtitle=:mtitle",array(':uniacid'=>$_W['uniacid'],':mtitle'=>'志愿活动'));
if(!empty($res)){
	$zyfwid=$res['meid'];
}else{
	$zyfwid=0;
}


//获取所有志愿活动
$pindex1 = max(1, intval($_GPC['page1']));
$psize1 = 10;
$reportlist1=pdo_fetchall("SELECT * FROM ".tablename('bc_community_news')." WHERE weid=:uniacid AND nmenu=".$zyfwid." ORDER BY nid DESC LIMIT ". ($pindex1 -1) * $psize1 . ",{$psize1}",array(':uniacid'=>$_W['uniacid']));
$total1 = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') ."WHERE weid=:uniacid AND nid=".$zyfwid." ORDER BY nid DESC",array(':uniacid'=>$_W['uniacid']));
$pager1 = pagination($total1, $pindex1, $psize1);




//获取所有报名记录列表

$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$reportlist=pdo_fetchall("SELECT a.*,b.ntitle,c.avatar FROM ".tablename('bc_community_report')." as a left join ".tablename('bc_community_news')." as b on a.newsid=b.nid left join ".tablename('bc_community_member')." as c on a.mid=c.mid WHERE a.weid=:uniacid ".$cxtj." ORDER BY reid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
$total = pdo_fetchcolumn("SELECT count(reid) FROM " . tablename('bc_community_report') ."WHERE weid=:uniacid ORDER BY reid DESC",array(':uniacid'=>$_W['uniacid']));
$pager = pagination($total, $pindex, $psize);



include $this->template('web/report');
?>