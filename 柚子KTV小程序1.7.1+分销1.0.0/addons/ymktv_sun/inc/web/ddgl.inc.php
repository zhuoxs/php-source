<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where = " WHERE  a.uniacid=".$_W['uniacid'] . ' and b.type=2';
if(!empty($_GPC['keywords'])){
    $op=$_GPC['keywords'];
    $where.=" and b.orderNum LIKE  '%$op%'";
    $data[':name']=$op;
}

$state=$_GPC['state'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=5;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
// $data[':uniacid']=$_W['uniacid'];
if($type=='all'){
    $sql = ' SELECT * FROM ' . tablename('ymktv_sun_integral') . ' i ' . ' JOIN ' . tablename('ymktv_sun_gift_dh') . ' g ' . ' ON ' . ' g.pid=i.id' . ' WHERE ' . ' g.uniacid=' . $_W['uniacid'] . ' ORDER BY ' . ' g.createtime DESC';
    $data = pdo_fetchall($sql);
    foreach ($data as $k=>$v){
        $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime']);
        $data[$k]['username'] = pdo_getcolumn('ymktv_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'name');
    }
}else{
    $type = $_GPC['state'];
    $sql = ' SELECT * FROM ' . tablename('ymktv_sun_integral') . ' i ' . ' JOIN ' . tablename('ymktv_sun_gift_dh') . ' g ' . ' ON ' . ' g.pid=i.id' . ' WHERE ' . ' g.uniacid=' . $_W['uniacid'] . ' AND ' . ' g.status=' . $type . ' ORDER BY ' . ' g.createtime DESC';
    $data = pdo_fetchall($sql);
    foreach ($data as $k=>$v){
        $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime']);
        $data[$k]['username'] = pdo_getcolumn('ymktv_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'name');
    }
}

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;


$servies = pdo_getall('ymktv_sun_servies',array('uniacid'=>$_W['uniacid']));
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_gift_dh',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('ddgl'), 'success');
    }else{
        message('删除失败！','','error');
    }
}

if($_GPC['op']=='delivery'){
    $res=pdo_update('ymktv_sun_gift_dh',array('status'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('ddgl',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('ymktv_sun_gift_dh',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('ddgl',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['keywords']){
    $datas = pdo_getall('ymktv_sun_gift_dh',array('uniacid'=>$_W['uniacid'],'order_num like'=>'%'.$_GPC['keywords'].'%'));
    $data = [];
    foreach ($datas as $k=>$v){
        $data[] = $v+pdo_get('ymktv_sun_integral',array('uniacid'=>$_W['uniacid'],'id'=>$v['pid']));
    }
    foreach ($data as $k=>$v){
        $data[$k]['createtime'] = date('Y-m-d H:i:s',$v['createtime']);
        $data[$k]['username'] = pdo_getcolumn('ymktv_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'name');
    }
}



include $this->template('web/ddgl');