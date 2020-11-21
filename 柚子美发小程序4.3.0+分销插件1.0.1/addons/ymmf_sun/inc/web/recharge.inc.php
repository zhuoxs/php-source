<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//$servies = pdo_getall('ymmf_sun_recharges',array('uniacid'=>$_W['uniacid']));

$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  uniacid=:uniacid';
$sql="SELECT * FROM ".tablename('ymmf_sun_recharges') .$where." ORDER BY  rid  DESC";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$servies=pdo_fetchall($select_sql,$data);
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('ymmf_sun_recharges') . $where." ORDER BY rid DESC",$data);
$pager = pagination($total, $pageindex, $pagesize);


if($_GPC['op'] == 'delete'){
    $res = pdo_delete('ymmf_sun_recharges',array('rid'=>$_GPC['rid']));
    if($res){
        message('删除成功',$this->createWebUrl('recharge',array()),'success');
    }else{
        message('删除失败','','error');
    }
}


include $this->template('web/recharge');