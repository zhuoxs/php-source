<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzzc_sun_taocan',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){
//	 p($_GPC);die;
    if($_GPC['day']==null){
        message('请您填写天数', '', 'error');
    }elseif($_GPC['money']==null){
        message('请您写填写金额百分比','','error');
    }elseif($_GPC['name']==null){
        message('请您写填写套餐名称','','error');
    }elseif($_GPC['money']>100){
        message('请您写填写正确金额百分比','','error');
    }
    if(preg_match("/^[1-9][0-9]*$/",$_GPC['money'])==false){
        message('金额百分比只能填写正整数','','error');
    }
    $data['uniacid']=$_W['uniacid'];
//    $data['type']=$_GPC['type'];
    $data['day']=$_GPC['day'];
    $data['money']=$_GPC['money'];
    $data['createtime']=date('Y-m-d H:i:s', time());
    $data['status']=1;
    $data['name']=$_GPC['name'];

    if(empty($_GPC['id'])){
        $res = pdo_insert('yzzc_sun_taocan', $data,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('taocan',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzzc_sun_taocan',$data, array('id' => $_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('taocan',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }

}
include $this->template('web/taocanadd');