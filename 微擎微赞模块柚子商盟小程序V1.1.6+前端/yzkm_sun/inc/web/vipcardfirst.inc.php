<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzkm_sun_customcard',array('uniacid'=>$_W['uniacid']));
if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['img']=$_GPC['img'];//会员卡图片
    $data['title']=$_GPC['title'];//会员卡规则
    if($_GPC['id']==''){
        $res=pdo_insert('yzkm_sun_customcard',$data);
        if($res){
            message('添加成功',$this->createWebUrl('vipcardfirst',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzkm_sun_customcard', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('vipcardfirst',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/vipcardfirst');