<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('wnjz_sun_kanjia_banner',array('uniacid'=>$_W['uniacid']));
if($info['img']){
    $img = $info['img'];
}
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

    $data['name']=$_GPC['name'];
    $data['url']=$_GPC['url'];
    $data['uniacid']=$_W['uniacid'];

    $data['name1']=$_GPC['name1'];
    $data['url1']=$_GPC['url1'];

    $data['name2']=$_GPC['name2'];
    $data['url2']=$_GPC['url2'];

    $data['name3']=$_GPC['name3'];
    $data['url3']=$_GPC['url3'];
    $data['img']=$_GPC['img'];
    $data['img2']=$_GPC['img2'];
    $data['img1']=$_GPC['img1'];
    $data['img3']=$_GPC['img3'];

    if($_GPC['id']==''){
        $res=pdo_insert('wnjz_sun_kanjia_banner',$data);


        if($res){
            message('添加成功',$this->createWebUrl('kanjia_banner',array()),'success');
        }else{
            message('添加失败','','error');
        }

    }else{

        $res = pdo_update('wnjz_sun_kanjia_banner', $data, array('id' => $_GPC['id']));

        if($res){
            message('编辑成功',$this->createWebUrl('kanjia_banner',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/kanjia_banner');