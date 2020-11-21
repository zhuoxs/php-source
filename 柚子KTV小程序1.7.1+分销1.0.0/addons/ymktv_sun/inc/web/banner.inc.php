<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('ymktv_sun_banner',array('location' =>1,'uniacid' => $_W['uniacid']));
$lb_imgs= explode(',',$info['lb_imgs']);
//

//
if(checksubmit('submit')){
    if($_GPC['lb_imgs']){
        $data['lb_imgs']=implode(',',$_GPC['lb_imgs']);
    }else{
        $data['lb_imgs']='';
    }

    $data['uniacid'] = $_W['uniacid'];
    $data['location'] = 1; //此处添加的是首页的顶部图
    if ($_GPC['id'] ==  null || $_GPC['id'] == ''){
        $res = pdo_insert('ymktv_sun_banner',$data);
    }else{
        $res = pdo_update('ymktv_sun_banner',$data,array('id' => $_GPC['id'],'location' => 1));
    }

    if ($res){
        message('添加成功',$this->createWebUrl('banner'),'success');
    }else{
        message('添加失败',$this->createWebUrl('banner'),'error');
    }
}
include $this->template('web/banner');