<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('zhls_sun_winindex',array('uniacid'=>$_W['uniacid']));
if($info['img1']){
    $img1 = $info['img1'];
}
if($info['img2']){
    $img2 = $info['img2'];
}
if($info['img3']){
    $img3 = $info['img3'];
}

if(checksubmit('submit')){
    $data['uniacid']=$_W['uniacid'];
    $data['img1']=$_GPC['img1'];
    $data['img2']=$_GPC['img2'];
    $data['img3']=$_GPC['img3'];

    $data['path1']=$_GPC['path1'];
    $data['path2']=$_GPC['path2'];
    $data['path3']=$_GPC['path3'];


    if($_GPC['id']==''){
        $res=pdo_insert('zhls_sun_winindex',$data,array('uniacid'=>$_W['uniacid']));


        if($res){
            message('添加成功',$this->createWebUrl('winindex',array()),'success');
        }else{
            message('添加失败','','error');
        }

    }else{

        $res = pdo_update('zhls_sun_winindex', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));

        if($res){
            message('编辑成功',$this->createWebUrl('winindex',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/winindex');