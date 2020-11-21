<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('chbl_sun_vipcard',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['name']=$_GPC['name'];
    $data['price']=$_GPC['price'];
    $data['discount']=$_GPC['discount'];
    $data['img']=$_GPC['img'];
    $data['desc']=$_GPC['desc'];
    if(strlen($data['discount'])>4){
        message('会员折扣保留两位小数');
    };
    if($data['discount']>1 || $data['discount']<=0){
        message('请设置正确的会员折扣');
    }
    if($_GPC['id']==''){
        $ress=pdo_insert('chbl_sun_vipcard',$data);
        if($res){
            message('添加成功',$this->createWebUrl('vipcardopen',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('chbl_sun_vipcard', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('vipcardopen',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/vipcardopen');