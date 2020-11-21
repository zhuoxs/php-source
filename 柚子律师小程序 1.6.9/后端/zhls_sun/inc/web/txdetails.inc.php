<?php

global $_GPC, $_W;

// $action = 'ad';

// $title = $this->actions_titles[$action];

$GLOBALS['frames'] = $this->getMainMenu2();


$pageindex = max(1, intval($_GPC['page']));

$pagesize=10;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

$type=empty($_GPC['type']) ? 'wait' :$_GPC['type'];
$status=empty($_GPC['status']) ? '1' :$_GPC['status'];


$data=array(':account_id'=>$_COOKIE['account_id'],':uniacid'=>$_W['uniacid']);

if($type=='all'){      

   $sql="SELECT * FROM ".tablename('zhls_sun_yjtx') . "where account_id=:account_id and uniacid=:uniacid ORDER BY cerated_time DESC";

   $total=pdo_fetchcolumn("SELECT * FROM ".tablename('zhls_sun_yjtx') . "where account_id=:account_id and uniacid=:uniacid ORDER BY cerated_time DESC",$data);

}else{

    $sql="SELECT * FROM ".tablename('zhls_sun_yjtx') . "where account_id=:account_id and uniacid=:uniacid and status=$status ORDER BY cerated_time DESC";



    $total=pdo_fetchcolumn("SELECT * FROM ".tablename('zhls_sun_yjtx') . "where account_id=:account_id and uniacid=:uniacid and status=$status ORDER BY cerated_time DESC",$data);

}

$list=pdo_fetch( $sql,$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list=pdo_fetchall($select_sql,$data);

$pager = pagination($total, $pageindex, $pagesize);



include $this->template('web/txdetails');