<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 14:29
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzzc_sun_level',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

if(checksubmit('submit')){
    if($_GPC['level_name']==null) {
        message('请填写会员等级名称', '', 'error');
    }elseif($_GPC['level_score']==null) {
        message('请输入等级积分', '', 'error');
    }elseif($_GPC['level_img']==null) {
        message('请上传等级图标', '', 'error');
    }

    $data['level_name']=$_GPC['level_name'];
    $data['level_score']=$_GPC['level_score'];
    $data['uniacid']=$_W['uniacid'];
    $data['level_img']=$_GPC['level_img'];
    $data['level_privileges']=$_GPC['level_privileges'];
    $data['delay']=$_GPC['delay'];
    
    if($_GPC['id']==''){
        $num=pdo_count('yzzc_sun_level',array('uniacid'=>$_W['uniacid']));
        if($num>=3){
            message('最多只能添加3个会员等级','','error');
        }
        $res=pdo_insert('yzzc_sun_level',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('memberslist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzzc_sun_level', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('memberslist',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/member');