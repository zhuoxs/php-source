<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$sql="select * from".tablename('ymmf_sun_money').'where uniacid='.$_W['uniacid'];
$lisr = pdo_fetchall($sql);

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('ymmf_sun_money',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('txsz',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}
if($_GPC['op']=='change'){
    $res=pdo_update('ymmf_sun_money',array('status'=>$_GPC['status']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('txsz',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/txsz');