<?php
global $_W, $_GPC;
include 'common.php';
load()->web('tpl'); 
$typename = empty($_GPC['typename']) ? "全部" : $_GPC['typename'];
$typeid = empty($_GPC['typeid']) ? "all" : $_GPC['typeid'];
//获取信息类型
$typelist=pdo_fetchall("SELECT * FROM".tablename('bc_community_menu')."WHERE weid=:uniacid AND jump=0 ORDER BY meid DESC",array(':uniacid'=>$_W['uniacid']));

$pindex = max(1, intval($_GPC['page']));
$psize = 10;


if ($typeid == 'all') {
	
	$newslist=pdo_fetchall("SELECT a.*,b.nickname,b.mid,c.mtitle FROM ".tablename('bc_community_news')." as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid left join ".tablename('bc_community_menu')." as c on a.nmenu=c.meid WHERE a.weid=:uniacid ORDER BY nid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') ." WHERE weid=:uniacid ORDER BY nid DESC",array(':uniacid'=>$_W['uniacid']));
	$pager = pagination($total, $pindex, $psize);
	include $this->template('web/news');
	exit;	

}else{
	$typeid=intval($_GPC['typeid']);
	//获取按类型ID信息列表
	
	$newslist=pdo_fetchall("SELECT a.*,b.nickname,b.mid,c.mtitle FROM ".tablename('bc_community_news')." as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid left join ".tablename('bc_community_menu')." as c on a.nmenu=c.meid WHERE a.weid=:uniacid AND a.nmenu=:typeid ORDER BY nid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid'],':typeid'=>$typeid));
	$total = pdo_fetchcolumn("SELECT count(nid) FROM " . tablename('bc_community_news') ." WHERE weid=:uniacid AND nmenu=:typeid ORDER BY nid DESC",array(':uniacid'=>$_W['uniacid'],':typeid'=>$typeid));
	$pager = pagination($total, $pindex, $psize);
	include $this->template('web/news');
	exit;		
}

?>