<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and title LIKE  '%$op%'";
    $data[':name']=$op;
}
if($_GPC['status']){
    $where.=" and status={$_GPC['status']} ";

}
if(!empty($_GPC['time'])){
    $start=strtotime($_GPC['time']['start']);
    $end=strtotime($_GPC['time']['end']);
    $where.=" and ime >={$start} and time<={$end}";

}
$status=$_GPC['status'];

$type=isset($_GPC['type'])?$_GPC['type']:'all';
$data[':uniacid']=$_W['uniacid'];

$sql="SELECT * FROM".tablename('yzzc_sun_active').$where;
$list= pdo_fetchall($sql);
foreach ($list as $key =>$value){
    if($value['acttime']){
        $list[$key]['acttime']=date('Y-m-d H:i:s', $value['acttime']);
    }
}
if($_GPC['op']=='delete'){

    $res=pdo_delete('yzzc_sun_active',array('aid'=>$_GPC['aid'],'uniacid'=>$_W['uniacid']));

    if($res){
        message('删除成功！', $this->createWebUrl('active'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzzc_sun_active',array('status'=>2),array('aid'=>$_GPC['aid'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('下架成功！', $this->createWebUrl('active'), 'success');
    }else{
        message('下架失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzzc_sun_active',array('status'=>1),array('aid'=>$_GPC['aid'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('上架成功！', $this->createWebUrl('active'), 'success');
    }else{
        message('上架失败！','','error');
    }
}
include $this->template('web/active');