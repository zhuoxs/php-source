<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where = " WHERE  a.uniacid=".$_W['uniacid'];
if(!empty($_GPC['keywords'])){
    $op=$_GPC['keywords'];
    $where.=" and a.orderNum LIKE  '%$op%'";
    $data[':name']=$op;
}

$status=$_GPC['status'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=5;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
// $data[':uniacid']=$_W['uniacid'];
if($type=='all'){


    $sql = "select * from ".tablename('mzhk_sun_order')."a left join ".tablename('mzhk_sun_groups')."b on b.order_id=a.oid".$where;

    $lit=pdo_fetchall($sql);

}else{
    $where.= " and status =$status";


    $sql = "select * from ".tablename('mzhk_sun_order')."a left join ".tablename('mzhk_sun_groups')."b on b.order_id=a.oid".$where;

    $lit=pdo_fetchall($sql);
}
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;


$lits=array();
foreach ($lit as $k =>$v){
    $gid = $v['gid'];
    $wher="WHERE gid=$gid  AND uniacid =".$_W['uniacid'];
    $val ="select * from ".tablename("mzhk_sun_goods").$wher;
    $valu= pdo_fetch($val);
    $lits[$k]['gname']=$valu['gname'];
    $lits[$k]['oid']=$v['oid'];
    $lits[$k]['orderNum']=$v['orderNum'];
    $lits[$k]['telNumber']=$v['telNumber'];
    $lits[$k]['name']=$v['name'];
    $lits[$k]['time']=$v['time'];
    $lits[$k]['sincetype']=$v['sincetype'];
    $lits[$k]['detailInfo']=$v['detailInfo'];
    $lits[$k]['countyName']=$v['countyName'];
    $lits[$k]['provinceName']=$v['provinceName'];
    $lits[$k]['status']=$v['status'];

}

$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('mzhk_sun_order',array('oid'=>$_GPC['oid']));
    if($res){
        message('删除成功！', $this->createWebUrl('orderinfo'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('mzhk_sun_car',array('state'=>2,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
        message('通过成功！', $this->createWebUrl('carinfo'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('mzhk_sun_car',array('state'=>3,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('carinfo'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}
include $this->template('web/orderinfo');