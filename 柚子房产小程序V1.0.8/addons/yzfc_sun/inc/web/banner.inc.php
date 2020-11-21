<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$infos=pdo_get('yzfc_sun_banner',array('uniacid' => $_W['uniacid']));
if($infos['lb_imgs']){
    if(strpos($infos['lb_imgs'],',')){
        $lb_imgs= explode(',',$infos['lb_imgs']);

    }else{
        $lb_imgs=array(
            0=>$infos['lb_imgs']
        );
    }
}
//$info=pdo_get('yzfc_sun_system',array('uniacid' => $_W['uniacid']));
if(checksubmit('submit')){
    $data['bname']=$_GPC['bname'];
    $data['uniacid'] = $_W['uniacid'];
    if($_GPC['lb_imgs']){
        if(count($_GPC['lb_imgs'])<4){
            $data['lb_imgs']=implode(",",$_GPC['lb_imgs']);
        }else{
            message('图片最多只能上传三张','','error');
        }
    }else{
        $data['lb_imgs']='';
    }

    if($_GPC['bid']==''){
        $res=pdo_insert('yzfc_sun_banner',$data);
    }else{
        $res3 = pdo_update('yzfc_sun_banner', $data, array('id' => $_GPC['bid']));
    }
    if($res || $res1 || $res2 ||$res3){
        message('设置成功',$this->createWebUrl('banner',array()),'success');
    }else{
        message('设置失败','','error');
    }
}
include $this->template('web/banner');