<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

$where = " WHERE  d.uniacid=".$_W['uniacid']." ";
$type = 0;

if(!empty($_GPC['keywords'])){
    $keywords=$_GPC['keywords'];
    $where.=" and u.name LIKE  '%$keywords%'";
	$type = 0;
}

if($_GPC['op']=='cz'){
	$cz = '充值';
	$where.=" and d.details_name='充值' ";
	$type = 1;
}

if(!empty($_GPC['keywords']) && $_GPC['cz']){
    $keywords=$_GPC['keywords'];
    $where.=" and u.name LIKE  '%$keywords%'";
	$where.=" and d.details_name='充值' ";
	$type = 1;
}

$sql = "select d.*,u.name,u.img from ".tablename('ymktv_sun_detailed')." as d left join ".tablename('ymktv_sun_user')." as u on d.openid=u.openid ".$where." order by d.id desc";


$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$total=pdo_fetchcolumn("select count(*) as wname from ".tablename('ymktv_sun_detailed')." as d left join ".tablename('ymktv_sun_user')." as u on d.openid=u.openid ".$where." ");

$list = pdo_fetchall($select_sql);


$pager = pagination($total, $pageindex, $pagesize);

include $this->template('web/balance');