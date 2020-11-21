<?php
global $_W, $_GPC;
load()->web('tpl'); 


$pindex = max(1, intval($_GPC['page']));
$psize = 10;


	
	$commentlist=pdo_fetchall("SELECT a.*,b.nickname FROM ".tablename('bc_community_comment')." as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid WHERE a.weid=:uniacid ORDER BY cid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
	$total = pdo_fetchcolumn("SELECT count(cid) FROM " . tablename('bc_community_comment') ." WHERE weid=:uniacid ORDER BY cid DESC",array(':uniacid'=>$_W['uniacid']));
	$pager = pagination($total, $pindex, $psize);
	include $this->template('web/comment');
	exit;	




?>