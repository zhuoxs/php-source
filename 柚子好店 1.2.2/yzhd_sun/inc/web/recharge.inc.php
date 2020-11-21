<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where = " WHERE  a.uniacid=".$_W['uniacid'] . ' and b.type=2';
if(!empty($_GPC['keywords'])){
    $op=$_GPC['keywords'];
    $where.=" and b.orderNum LIKE  '%$op%'";
    $data[':name']=$op;
}

$status=$_GPC['status'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=5;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
// $data[':uniacid']=$_W['uniacid'];
if($type=='all'){
    $sql = "select * from ".tablename('yzhd_sun_kjorderlist')."a left join ".tablename('yzhd_sun_kjorder')."b on a.order_id=b.id".$where;

    $lit=pdo_fetchall($sql);
}else{
//    p($status);die;
//    $sql = "select * from ".tablename('yzhd_sun_kjorderlist')."a left join ".tablename('yzhd_sun_kjorder')."b on a.order_id=b.id"." WHERE  a.uniacid=".$_W['uniacid'] . ' and b.type=2' . ' and b.status=' . $status;
    $sql = ' SELECT * FROM ' .tablename('yzhd_sun_kjorderlist') . ' a ' . ' JOIN ' . tablename('yzhd_sun_kjorder') . ' b ' . ' ON ' . ' a.order_id=b.id ' . '  WHERE' . ' b.uniacid=' . $_W['uniacid'] .  ' AND' . ' b.type=2' .  ' AND' . ' b.status=' . $status;
    $lit=pdo_fetchall($sql);
}

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
//p($status);die;
$lits=array();
foreach ($lit as $k =>$v){
    $gid = $v['oid'];
    $wher="WHERE id=$gid  AND uniacid =".$_W['uniacid'];
    $val ="select * from ".tablename("yzhd_sun_new_bargain").$wher;
    $valu= pdo_fetch($val);
    $lits[$k]['gname']=$valu['gname'];
    $lits[$k]['id']=$v['order_id'];
    $lits[$k]['orderNum']=$v['orderNum'];
    $lits[$k]['telNumber']=$v['telNumber'];
    $lits[$k]['name']=$v['name'];
    $lits[$k]['time']=$v['time'];
    $lits[$k]['detailInfo']=$v['detailInfo'];
    $lits[$k]['countyName']=$v['countyName'];
    $lits[$k]['provinceName']=$v['provinceName'];
    $lits[$k]['status']=$v['status'];
    $lits[$k]['sid']=$v['sid'];
    $lits[$k]['text']=$v['text'];
}
$servies = pdo_getall('yzhd_sun_recharges',array('uniacid'=>$_W['uniacid']));

if($_GPC['op'] == 'delete'){
    $res = pdo_delete('yzhd_sun_recharges',array('rid'=>$_GPC['rid']));
    if($res){
        message('删除成功',$this->createWebUrl('recharge',array()),'success');
    }else{
        message('删除失败','','error');
    }
}


include $this->template('web/recharge');