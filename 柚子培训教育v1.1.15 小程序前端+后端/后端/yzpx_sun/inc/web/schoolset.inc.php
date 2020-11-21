<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/13
 * Time: 10:01
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

    $info=pdo_get('yzpx_sun_system',array('uniacid'=>$_W['uniacid']),array('open_school','id'));

if (checksubmit('submit')){
    $data['open_school']=$_GPC['open_school'];
    if($_GPC['id']>0){
        $res=pdo_update('yzpx_sun_system',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('schoolset',array(),'success'));
        }else{
            message('修改失败','','error');
        }
    }else{
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('yzpx_sun_system',$data);
        if($res){

            message('设置成功',$this->createWebUrl('schoolset',array(),'success'));
        }else{
            message('设置失败','','error');
        }

    }

}
if($_GPC['op']=='select_school'){
    $teacher=pdo_getall('yzpx_sun_teacher',array('uniacid'=>$_W['uniacid'],'sid'=>$_GPC['sid'],'status'=>1));
    echo json_encode($teacher);exit;
}

include $this->template('web/schoolset');