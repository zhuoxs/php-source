<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('yzzc_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');
$info = pdo_getall('yzzc_sun_coupon',['uniacid'=>$_W['uniacid'],'type'=>2]);
foreach ($info as $key =>$value){
    $info[$key]['createtime']=date('Y-m-d H:i:s', $value['createtime']);
    $info[$key]['start_time']=date('Y-m-d H:i:s', $value['start_time']);
    $info[$key]['end_time']=date('Y-m-d H:i:s', $value['end_time']);
}
global $_W, $_GPC;

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('yzzc_sun_coupon',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('coupon',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('yzzc_sun_coupon',array('status'=>$_GPC['status']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('coupon',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/coupon');