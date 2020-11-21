<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  a.uniacid=".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and a.name LIKE  '%$op%'";
    $data[':name']=$op;
}
if($_GPC['status']){
    $where.=" and a.status={$_GPC['status']} ";

}
if($_GPC['storename']){
    $storename=$_GPC['storename'];
    $where.=" and b.name LIKE  '%$storename%'";
    $data[':storename']=$storename;
}
$where .=" and a.is_del =0";
$states=$_GPC['states'];

$type=isset($_GPC['type'])?$_GPC['type']:'all';
$data[':uniacid']=$_W['uniacid'];
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = 'SELECT a.*,b.name as storename FROM '.tablename('yzzc_sun_goods')."a left join ".tablename('yzzc_sun_branch')."b on b.id = a.sid ".$where." ORDER BY a.id DESC LIMIT ".(($page-1) * $size).','.$size;

$list = pdo_fetchall($sql);
$total=pdo_fetchcolumn("select count(*) from " . tablename("yzzc_sun_goods") ."a left join ".tablename('yzzc_sun_branch')."b on b.id = a.sid ".$where);
$pager = pagination($total, $page, $size);
$ordertime=pdo_get('yzzc_sun_ordertime',array('uniacid'=>$_W['uniacid']));


if($_GPC['op']=='delete'){
    $info=pdo_get('yzzc_sun_goods',array('id'=>$_GPC['id']));
    if($info['status']==1){
        $res=pdo_update('yzzc_sun_goods',array('is_del'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('删除成功！', $this->createWebUrl('goods'), 'success');
        }else{
            message('删除失败！','','error');
        }
    }else{
        message('空闲车辆才能删除，当前车辆无法删除！','','error');
    }

}
if($_GPC['op']=='rec2'){
    $res=pdo_update('yzzc_sun_goods',array('rec'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('推荐成功！', $this->createWebUrl('goods'), 'success');
    }else{
        message('推荐失败！','','error');
    }
}
if($_GPC['op']=='rec1'){
    $res=pdo_update('yzzc_sun_goods',array('rec'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('取消推荐成功！', $this->createWebUrl('goods'), 'success');
    }else{
        message('取消推荐失败！','','error');
    }
}
if($_GPC['op']=='hot2'){
    $res=pdo_update('yzzc_sun_goods',array('hot'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('设置成功！', $this->createWebUrl('goods'), 'success');
    }else{
        message('设置失败！','','error');
    }
}
if($_GPC['op']=='hot1'){
    $res=pdo_update('yzzc_sun_goods',array('hot'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('设置成功！', $this->createWebUrl('goods'), 'success');
    }else{
        message('设置失败！','','error');
    }
}
if($_GPC['op']=='xj'){
    $res=pdo_update('yzzc_sun_goods',array('status'=>3),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('下架成功！', $this->createWebUrl('goods'), 'success');
    }else{
        message('下架失败！','','error');
    }
}
if($_GPC['op']=='sj'){
    $res=pdo_update('yzzc_sun_goods',array('status'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('上架成功！', $this->createWebUrl('goods'), 'success');
    }else{
        message('上架失败！','','error');
    }
}
if($_GPC['op']=='add'){
    // $order = pdo_getall('yzzc_sun_order',array('uniacid'=>$_W['uniacid'],'status'))
    $order= pdo_fetchall('select * from '.tablename('yzzc_sun_order')." where uniacid =".$_W['uniacid']." and (status = 2 or status = 3 or status =0 )");
    // var_dump('select * from '.tablename('yzzc_sun_order')." where uniacid =".$_W['uniacid']." and (status = 2 or status = 3 or status =0 )");die;
    foreach ($order as $key => $value) {
        $data1['carnum']=$value['carnum'];
        $data1['start_time']=$value['start_time'];
        $data1['end_time']=$value['end_time'];
        $data1['uniacid']=$value['uniacid'];
        // var_dump($data1);
        pdo_insert('yzzc_sun_ordertime',$data1);
    }
    // die;

    message('同步成功！', $this->createWebUrl('goods'), 'success');
    
}
include $this->template('web/goods');