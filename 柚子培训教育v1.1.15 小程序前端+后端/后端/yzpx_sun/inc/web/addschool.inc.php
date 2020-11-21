<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/27
 * Time: 17:49
 */

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzpx_sun_school',array('id'=>$_GPC['id']));
$map_key=pdo_get('yzpx_sun_system',array('uniacid'=>$_W['uniacid']))['map_key'];
//var_dump($item['banner']);exit;
if(strpos($item['banner'],',')){

    $lb_imgs= explode(',',$item['banner']);
}else{
    $lb_imgs=array(
        0=>$item['banner']
    );
}
//var_dump($lb_imgs);exit;
if(checksubmit('submit')){
    if($_GPC['name']==null) {
        message('请您填写分校名称', '', 'error');
    }elseif($_GPC['content']==null) {
        message('请您填写分校简介', '', 'error');
    }elseif($_GPC['tel']==null) {
        message('请您填写电话号码', '', 'error');
    }elseif($_GPC['address']==null) {
        message('请您填写分校地址', '', 'error');
    }elseif($_GPC['lng']==null) {
        message('请您先定位分校地址', '', 'error');
    }
    if($_GPC['banner']){
        $_GPC['banner']=array_filter($_GPC['banner']);
        if(count($_GPC['banner'])<5){
            $data['banner']=implode(",",$_GPC['banner']);
        }else{
            message('图片最多只能上传三张','','error');
        }
    }else{
        $data['banner']='';
    }
    $data['uniacid'] = $_W['uniacid'];
    $data['name']=$_GPC['name'];
    $data['pic']=$_GPC['pic'];
    $data['content']=$_GPC['content'];
    $data['tel']=$_GPC['tel'];
    $data['address']=$_GPC['address'];
    $data['lng']=$_GPC['lng'];
    $data['lat']=$_GPC['lat'];
    $data['selftime']=date('Y-m-d H:i:s', time());
    $data['join_card']=$_GPC['join_card'];

    if($_GPC['id']==''){

        $res=pdo_insert('yzpx_sun_school',$data);

        if($res){
            message('添加成功',$this->createWebUrl('schoollist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzpx_sun_school', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('schoollist',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/addschool');