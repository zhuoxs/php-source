<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/4
 * Time: 9:32
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$map_key=pdo_get('yzfc_sun_system',array('uniacid'=>$_W['uniacid']))['map_key'];
if($_GPC['id']){
    $info=pdo_get('yzfc_sun_house',array('id'=>$_GPC['id']));
    if($info['region']>0){
        $nowtype=pdo_get('yzfc_sun_region',array('id'=>$info['region']));
    }
    $info['opentime']=date('Y-m-d H:i:s',$info['opentime']);
    if(strpos($info['banner'],',')){
        $banner= explode(',',$info['banner']);
    }else{
        $banner=array(
            0=>$info['banner']
        );
    }
}
$region=pdo_getall('yzfc_sun_region',array('uniacid'=>$_W['uniacid']));


if (checksubmit('submit')){
    if($_GPC['name']==null){
        message('请输入楼盘名称','','error');
    }elseif($_GPC['opentime']==null){
        message('请选择开盘时间','','error');
    }elseif($_GPC['img']==null){
        message('请上传封面图','','error');
    }elseif($_GPC['region']==null){
        message('请选择楼盘所属区域','','error');
    }
    if($_GPC['banner']){
//        if(count($_GPC['img'])<5){
            $data['banner']=implode(",",$_GPC['banner']);
//        }else{
//            message('图片最多只能上传三张','','error');
//        }
    }else{
        $data['banner']='';
    }
    $data['name']=$_GPC['name'];
    $data['region']=$_GPC['region'];
    $data['opentime']=strtotime($_GPC['opentime']);
    $data['img']=$_GPC['img'];
    $data['price']=$_GPC['price'];
    $data['area']=$_GPC['area'];
    $data['sale_status']=$_GPC['sale_status'];
    $data['tel']=$_GPC['tel'];
    $data['icon']=$_GPC['icon'];
    $data['info']=$_GPC['info'];
    $data['facilities']=$_GPC['facilities'];
    $data['uniacid']=$_W['uniacid'];
    $data['createtime']=time();
    $data['hot']=$_GPC['hot'];
    $data['hot_sort']=$_GPC['hot_sort'];
    $data['address']=$_GPC['address'];
    $data['lng']=$_GPC['lng'];
    $data['lat']=$_GPC['lat'];
    $data['rec']=$_GPC['rec'];
    $data['detail']=$_GPC['detail'];
//    var_dump($data);exit;
    if($_GPC['id']==''){

        $res=pdo_insert('yzfc_sun_house',$data);
        if($res){
            message('添加成功',$this->createWebUrl('houselist'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res=pdo_update('yzfc_sun_house',$data,array('id'=>$_GPC['id']));
        if($res){
            message('修改成功',$this->createWebUrl('houselist',array()),'success');
        }else{
            message('修改失败','','error');
        }
    }

}
include $this->template('web/addhouse');