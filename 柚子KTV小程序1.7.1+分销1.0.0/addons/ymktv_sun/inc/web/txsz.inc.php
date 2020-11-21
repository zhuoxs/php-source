<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type = isset($_GPC['type'])?$_GPC['type']:0;

$lisr = pdo_getall('ymktv_sun_money',array('uniacid'=>$_W['uniacid']));

if($_GPC['op']=='delete'){

        $res=pdo_delete('ymktv_sun_money',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('txsz',array()),'success');
        }else{
            message('操作失败','','error');
        }

}
if($_GPC['op']=='change'){
    $res=pdo_update('ymktv_sun_money',array('status'=>$_GPC['status']),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('操作成功',$this->createWebUrl('txsz',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

include $this->template('web/txsz');