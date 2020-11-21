<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$infos=pdo_get('yzfc_sun_banner',array('uniacid' => $_W['uniacid']));
//if($infos['lb_imgs']){
//    if(strpos($infos['lb_imgs'],',')){
//        $lb_imgs= explode(',',$infos['lb_imgs']);
//
//    }else{
//        $lb_imgs=array(
//            0=>$infos['lb_imgs']
//        );
//    }
//}
$info=pdo_get('yzfc_sun_system',array('uniacid' => $_W['uniacid']));
if(checksubmit('submit')){
//    $data['bname']=$_GPC['bname'];
//    $data['uniacid'] = $_W['uniacid'];
//    if($_GPC['lb_imgs']){
//        if(count($_GPC['lb_imgs'])<4){
//            $data['lb_imgs']=implode(",",$_GPC['lb_imgs']);
//        }else{
//            message('图片最多只能上传三张','','error');
//        }
//    }else{
//        $data['lb_imgs']='';
//    }
    $set['uniacid'] = $_W['uniacid'];
    $set['sup_logo'] = $_GPC['sup_logo'];
    $set['sup_name'] = $_GPC['sup_name'];
    $set['sup_tel'] = $_GPC['sup_tel'];
    $set['ht_logo'] = $_GPC['ht_logo'];
    $set['ht_title'] = $_GPC['ht_title'];
    $set['top_title'] = $_GPC['top_title'];

    $set['top_font_color']=$_GPC['top_font_color']?$_GPC['top_font_color']:'#000000';
    $set['top_color']=$_GPC['top_color']?$_GPC['top_color']:'#ffffff';
    $set['foot_color']=$_GPC['foot_color']?$_GPC['foot_color']:'#ffffff';
    $set['foot_font_color_one']=$_GPC['foot_font_color_one']?$_GPC['foot_font_color_one']:'#000000';
    $set['foot_font_color_two']=$_GPC['foot_font_color_two']?$_GPC['foot_font_color_two']:'#005aff';
    if($_GPC['id']==''){
        $res1=pdo_insert('yzfc_sun_system', $set);
    }else{
        $res2=pdo_update('yzfc_sun_system', $set, array('id' => $_GPC['id']));
    }
//    if($_GPC['bid']==''){
//        $res=pdo_insert('yzfc_sun_banner',$data);
//    }else{
//        $res3 = pdo_update('yzfc_sun_banner', $data, array('id' => $_GPC['bid']));
//    }
    if($res1 || $res2){
        message('设置成功',$this->createWebUrl('systemset',array()),'success');
    }else{
        message('设置失败','','error');
    }
}
include $this->template('web/systemset');