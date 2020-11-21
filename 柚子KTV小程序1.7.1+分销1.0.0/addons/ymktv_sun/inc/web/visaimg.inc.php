<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('fyly_sun_banner',array('location' => 2,'uniacid' => $_W['uniacid']));
$lb_imgs= explode(',',$info['lb_imgs']);

if(checksubmit('submit')){
    if($_GPC['lb_imgs']){
        $data['lb_imgs']=implode(',',$_GPC['lb_imgs']);
    }else{
        $data['lb_imgs']='';
    }
    $data['bname']=$_GPC['bname'];
    $data['uniacid'] = $_W['uniacid'];
    $data['location'] = 2; //此处添加的是签证页顶部图
    if ($info == null || $info == ''){
        $res = pdo_insert('fyly_sun_banner',$data);
    }else{
        $res = pdo_update('fyly_sun_banner',$data,array('uniacid' => $_W['uniacid'],'location' => 2));
    }

    if ($res){
        message('添加成功',$this->createWebUrl('visaimg'),'success');
    }else{
        message('添加失败',$this->createWebUrl('visaimg'),'error');
    }
}
include $this->template('web/visaimg');