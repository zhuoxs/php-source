<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzzc_sun_active',array('aid'=>$_GPC['aid'],'uniacid'=>$_W['uniacid']));

if(checksubmit('submit')){
//	 p($_GPC);die;
    if($_GPC['title']==null){
        message('请您写完整活动标题', '', 'error');
    }elseif($_GPC['content']==null){
        message('请您写完整租车详情','','error');
    }elseif($_GPC['pic']==null){
        message('请您写上传图片','','error');die;
    }
    $data['uniacid']=$_W['uniacid'];
    $data['title']=$_GPC['title'];
    $data['content']=$_GPC['content'];
    $data['status']=1;
    $data['pic'] = $_GPC['pic'];
    $data['details'] = $_GPC['details'];
    $data['createtime']=date('Y-m-d H:i:s', time());
    if(empty($_GPC['id'])){

        $res = pdo_insert('yzzc_sun_active', $data,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('active',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{

        $res = pdo_update('yzzc_sun_active', $data, array('aid' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('修改成功',$this->createWebUrl('active',array()),'success');
    }else{
        message('修改失败','','error');
    }
}
include $this->template('web/activeinfo');