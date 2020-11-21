<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where = " WHERE  a.uniacid=".$_W['uniacid'] . ' and b.type=2';
// 总店数据
$system = pdo_get('ymktv_sun_system',array('uniacid'=>$_W['uniacid']));

$type=isset($_GPC['type'])?$_GPC['type']:'all';


if($type=='all'){
    $list = pdo_getall('ymktv_sun_keepwine',array('uniacid'=>$_W['uniacid']),'','','addtime DESC');
    foreach ($list as $k=>$v){
        if($v['build_id']==0){
            $list[$k]['b_name'] = $system['pt_name']."(".'总店'.")";
        }else{
            $list[$k]['b_name'] = pdo_getcolumn('ymktv_sun_building',array('uniacid'=>$_W['uniacid'],'id'=>$v['build_id']),'b_name');
        }
        $list[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
    }
}elseif ($type == 'status'){
    $type = $_GPC['status'];
    $list = pdo_getall('ymktv_sun_keepwine',array('uniacid'=>$_W['uniacid'],'status'=>$type),'','','addtime DESC');
    foreach ($list as $k=>$v){
        $list[$k]['b_name'] = pdo_getcolumn('ymktv_sun_building',array('uniacid'=>$_W['uniacid'],'id'=>$v['build_id']),'b_name');
        $list[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
    }
}
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $sql="SELECT * from ims_ymktv_sun_keepwine where uniacid=".$_W['uniacid']." and (username like '%$op%'
          or order_num like '%$op%') order by addtime desc";
    $list = pdo_fetchall($sql);
    foreach ($list as $k=>$v){
        if($v['build_id']==0){
            $list[$k]['b_name'] = $system['pt_name']."(".'总店'.")";
        }else{
            $list[$k]['b_name'] = pdo_getcolumn('ymktv_sun_building',array('uniacid'=>$_W['uniacid'],'id'=>$v['build_id']),'b_name');
        }
        $list[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
    }
}

if($_GPC['op']=='delivery'){
    $res=pdo_update('ymktv_sun_keepwine',array('status'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('编辑成功！', $this->createWebUrl('winedata'), 'success');
    }else{
        message('编辑失败！','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('ymktv_sun_keepwine',array('status'=>3),array('id'=>$_GPC['id']));
    if($res){
        message('编辑成功！', $this->createWebUrl('winedata'), 'success');
    }else{
        message('编辑失败！','','error');
    }
}
if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_keepwine',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('winedata'), 'success');
    }else{
        message('删除失败！','','error');
    }
}




include $this->template('web/winedata');