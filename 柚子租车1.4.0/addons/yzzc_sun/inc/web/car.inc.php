<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where=" WHERE  uniacid=".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and name LIKE  '%$op%'";
    $data[':name']=$op;
}
if($_GPC['status']){
    $where.=" and status={$_GPC['status']} ";

}

$info=pdo_get('yzzc_sun_system',array('uniacid'=>$_W['uniacid']),array('is_open_car'));
$where .=" and is_del =0";
$states=$_GPC['states'];

$type=isset($_GPC['type'])?$_GPC['type']:'all';
$data[':uniacid']=$_W['uniacid'];
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = 'SELECT * FROM '.tablename('yzzc_sun_car')."{$where} ORDER BY sort asc LIMIT ".(($page-1) * $size).','.$size;
$list = pdo_fetchall($sql);
foreach ($list as $key => $value) {
    $list[$key]['carbrand']=pdo_get('yzzc_sun_carbrand',array('id'=>$value['carbrand']),'name')['name'];
    $list[$key]['carcity']=pdo_get('yzzc_sun_carcity',array('id'=>$value['carcity']),'name')['name'];
}
$total=pdo_fetchcolumn("select count(*) from " . tablename("yzzc_sun_car") .$where);
$pager = pagination($total, $page, $size);

//$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('yzzc_sun_car')." . $where");
//$sql='SELECT * FROM'.tablename('yzzc_sun_car')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;
//$list= pdo_fetchall($sql);

if($_GPC['op']=='delete'){
    $info=pdo_get('yzzc_sun_car',array('id'=>$_GPC['id']));
    if($info['status']==1){
        $res=pdo_update('yzzc_sun_car',array('is_del'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('删除成功！', $this->createWebUrl('car'), 'success');
        }else{
            message('删除失败！','','error');
        }
    }else{
        message('空闲车辆才能删除，当前车辆无法删除！','','error');
    }

}
if($_GPC['op']=='rec2'){
    $res=pdo_update('yzzc_sun_car',array('rec'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('推荐成功！', $this->createWebUrl('car'), 'success');
    }else{
        message('推荐失败！','','error');
    }
}
if($_GPC['op']=='rec1'){
    $res=pdo_update('yzzc_sun_car',array('rec'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('取消推荐成功！', $this->createWebUrl('car'), 'success');
    }else{
        message('取消推荐失败！','','error');
    }
}

if($_GPC['op']=='xj'){
    $res=pdo_update('yzzc_sun_car',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功！', $this->createWebUrl('car'), 'success');
    }else{
        message('操作失败！','','error');
    }
}
if($_GPC['op']=='sj'){
    $res=pdo_update('yzzc_sun_car',array('status'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功！', $this->createWebUrl('car'), 'success');
    }else{
        message('操作失败！','','error');
    }
}
if($_GPC['op']=='change'){
        $data1['is_open_car']=intval($_GPC['is_open_car']);
        $res = pdo_update('yzzc_sun_system', $data1, array('uniacid' => $_W['uniacid']));
        if($res){
            message('设置成功',$this->createWebUrl('car'),'success');
        }else{
            message('设置失败','','error');
        }
}
include $this->template('web/car');