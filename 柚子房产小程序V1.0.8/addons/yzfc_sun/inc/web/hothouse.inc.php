<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/9
 * Time: 16:06
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('yzfc_sun_hothouse_set',array('uniacid'=>$_W['uniacid']));
if (checksubmit('submit')){
    $data['img']=$_GPC['img'];
    $data['title']=$_GPC['title'];
    $data['info']=$_GPC['info'];
    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('yzfc_sun_hothouse_set',$data);
        if($res){
            message('添加成功',$this->createWebUrl('hothouse'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzfc_sun_hothouse_set',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('hothouse',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }

}
include $this->template('web/hothouse');