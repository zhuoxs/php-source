<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('fyly_sun_banner',array('location' => 3,'uniacid' => $_W['uniacid']));
$lb_imgs= explode(',',$info['lb_imgs']);

if(checksubmit('submit')){
    if($_GPC['lb_imgs']){
        $data['lb_imgs']=implode(',',$_GPC['lb_imgs']);
    }else{
        $data['lb_imgs']='';
    }
    $data['bname']=$_GPC['bname'];
    $data['uniacid'] = $_W['uniacid'];
    $data['location'] = 3; //此处添加的是周边游的顶部图片

    if ($info == null || $info == ''){
        $res = pdo_insert('fyly_sun_banner',$data);
    }else{
        $res = pdo_update('fyly_sun_banner',$data,array('uniacid' => $_W['uniacid'],'location' => 3));
    }

    if ($res){
        message('添加成功',$this->createWebUrl('aroundimg'),'success');
    }else{
        message('添加失败',$this->createWebUrl('aroundimg'),'error');
    }

}
include $this->template('web/aroundimg');