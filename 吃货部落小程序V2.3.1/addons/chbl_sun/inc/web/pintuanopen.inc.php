<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('chbl_sun_system',array('uniacid'=>$_W['uniacid']));
$info = [
    '0'=>'24小时',
    '1'=>'48小时',
    '2'=>'72小时',
    '3'=>'活动结束自动退款',
    '4'=>'不退款，直接发货',
];

if(checksubmit('submit')){
//    p($_GPC);die;
    $data['is_pintuanopen']=$_GPC['is_pintuanopen'];
    $data['uniacid']=$_W['uniacid'];
    $data['refund']=$_GPC['refund'];
    $data['refund_time']=$_GPC['refund_time'];
    $data['groups_title']=$_GPC['groups_title'];
    if($_GPC['id']==''){                
        $res=pdo_insert('chbl_sun_system',$data);
        if($res){
            message('编辑成功',$this->createWebUrl('pintuanopen',array()),'success');
        }else{
            message('编辑成功','','error');
        }
    }else{
        $res = pdo_update('chbl_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('pintuanopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/pintuanopen');