<?php
global $_W, $_GPC;

$pindex = max(1, intval($_GPC['page']));
$psize = 10;



	
	$proposallist=pdo_fetchall("SELECT a.*,b.tname,c.realname FROM ".tablename('bc_community_proposal')." as a left join ".tablename('bc_community_type')." as b on a.ptype=b.tid left join ".tablename('bc_community_member')." as c on a.mid=c.mid WHERE a.weid=:uniacid ORDER BY pid DESC LIMIT ". ($pindex -1) * $psize . ",{$psize}",array(':uniacid'=>$_W['uniacid']));
	$total = pdo_fetchcolumn("SELECT count(pid) FROM " . tablename('bc_community_proposal') ." WHERE weid=:uniacid ORDER BY pid DESC",array(':uniacid'=>$_W['uniacid']));
	$pager = pagination($total, $pindex, $psize);
	include $this->template('web/proposal');




?>