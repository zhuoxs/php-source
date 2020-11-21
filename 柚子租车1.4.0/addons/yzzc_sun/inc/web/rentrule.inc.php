<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzzc_sun_allrule',array('type'=>1,'uniacid'=>$_W['uniacid']));


if(checksubmit('submit')){
//	 p($_GPC);die;
    if($_GPC['content']==null){
        message('请您写使用说明', '', 'error');
    }
    $data['uniacid']=$_W['uniacid'];
    $data['content']=$_GPC['content'];
    $data['selftime']=date('Y-m-d H:i:s', time());
    $data['type']=1;
//    var_dump($_GPC['id']);exit;
    if($_GPC['id']==''){
        $res = pdo_insert('yzzc_sun_allrule', $data,array('uniacid'=>$_W['uniacid']));

        if($res){
            message('添加成功',$this->createWebUrl('rentrule',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzzc_sun_allrule', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('修改成功',$this->createWebUrl('rentrule',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }

}
include $this->template('web/rentrule');