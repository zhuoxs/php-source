<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$where=" WHERE s.uniacid=".$_W['uniacid']." ";

if($_GPC['keywords']){
    $keywords=$_GPC['keywords'];
    $where.=" and u.name LIKE '%$keywords%'";
}

$pageindex = max(1, intval($_GPC['page']));

$pagesize=10;

$sql="SELECT s.id,u.name,s.type,s.sign,s.score,s.add_time FROM ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." as s left join ".tablename('mzhk_sun_user')." as u on u.openid=s.openid".$where." ORDER BY s.id DESC";

$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('mzhk_sun_plugin_scoretask_taskrecord')." as s left join ".tablename('mzhk_sun_user')." as u on u.openid=s.openid".$where." ORDER BY s.id DESC");

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql);

$pager = pagination($total, $pageindex, $pagesize);


include $this->template('web/integraldetails');