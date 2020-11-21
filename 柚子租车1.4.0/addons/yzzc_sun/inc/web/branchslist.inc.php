<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('wyzc_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
//$info = pdo_getall('yzzc_sun_branch',array('uniacid'=>$_W['uniacid']));
$where="where uniacid =".$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and name LIKE  '%$op%'";
}
if($_GPC['type']=='wait'){
    $where .=" and status =1";
}elseif ($_GPC['type']=='ok'){
    $where .=" and status =2";
}
$type=$_GPC['type']?$_GPC['type']:'all';
//var_dump($where);exit;
$page = max(1, intval($_GPC['page']));
$size = intval($_GPC['psize']) ? intval($_GPC['psize']) : 10;
$sql = 'SELECT * FROM '.tablename('yzzc_sun_branch')."{$where} ORDER BY id DESC LIMIT ".(($page-1) * $size).','.$size;

$info = pdo_fetchall($sql);
$total=pdo_fetchcolumn("select count(*) from " . tablename("yzzc_sun_branch") .$where);
$pager = pagination($total, $page, $size);
global $_W, $_GPC;

if($_GPC['op']=='delete'){
    $is=pdo_get('yzzc_sun_goods',array('sid'=>$_GPC['id']));
    if($is){
        message('请先至车辆列表下架所有车辆才能删除','','error');
    }else{
        $res=pdo_delete('yzzc_sun_branch',array('id'=>$_GPC['id']));
        if($res){
            message('操作成功',$this->createWebUrl('branchslist',array()),'success');
        }else{
            message('操作失败','','error');
        }

    }

}
if($_GPC['op']=='change'){
    if($_GPC['states']==2){
        $is=pdo_get('yzzc_sun_goods',array('sid'=>$_GPC['id'],'status'=>1));
        if($is){
            message('请先至车辆列表下架所有车辆才能停业','','error');
        }
    }

    $res=pdo_update('yzzc_sun_branch',array('status'=>$_GPC['states']),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('branchslist',array()),'success');
    }else{
        message('操作失败','','error');
    }


}

include $this->template('web/branchslist');