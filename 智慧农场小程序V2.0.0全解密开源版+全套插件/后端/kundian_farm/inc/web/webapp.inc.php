<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/26 0026
 * Time: 10:46
 */
defined("IN_IA")or exit("Access Denied");
checklogin();  //验证是否登录
global $_W,$_GPC;
$uniacid=$_W['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] : "index";
if($op=='index'){
}
//品牌设置
if($op=='brand_set'){
    $list=getWebappSetData(array('brand_name','brand_detail'),array('uniacid'=>$uniacid));
    include $this->template("webapp/webappSet/brand_set");
}
if($op=='brand_set_save'){
    $data=$_POST;
    $res=insertSetData($data,$uniacid);
    if($res){
        message("操作成功",url("site/entry/webapp",array('m'=>'kundian_farm','op'=>'brand_set')));
    }else{
        message('操作失败');
    }
}

//基本设置
if($op=='webapp_basic_set'){
    $list=getWebappSetData(array('webapp_version','webapp_phone','webapp_email','webapp_qq','webapp_address','webapp_kefu_img','webapp_miniapp_img','webapp_logo_img'),array('uniacid'=>$uniacid));
    include $this->template("webapp/webappSet/webapp_basic_set");
}
if($op=='webapp_basic_set_save'){
    $data=$_POST;
    $data['webapp_kefu_img']=tomedia($data['webapp_kefu_img']);
    $data['webapp_miniapp_img']=tomedia($data['webapp_miniapp_img']);
    $data['webapp_logo_img']=tomedia($data['webapp_logo_img']);
    $res=insertSetData($data,$uniacid);
    if($res){
        message("操作成功",url("site/entry/webapp",array('m'=>'kundian_farm','op'=>'webapp_basic_set')));
    }else{
        message('操作失败');
    }
}
//监控设置
if($op=='live_set'){
    $list=getWebappSetData(array('webapp_live_url'),array('uniacid'=>$uniacid));
    include $this->template("webapp/webappSet/live_set");
}
if($op=='live_set_save'){
    $data=$_POST;
    $res=insertSetData($data,$uniacid);
    if($res){
        message("操作成功",url("site/entry/webapp",array('m'=>'kundian_farm','op'=>'live_set')));
    }else{
        message('操作失败');
    }
}

//轮播图设置
if($op=='slide_set'){
    $list=pdo_getall('cqkundian_farm_webapp_slide',array('uniacid'=>$uniacid));
    include $this->template('webapp/webappSlide/index');
}

//编辑轮播图
if($op=='slide_set_edit'){
    if($_GPC['id']){
        $list=pdo_get('cqkundian_farm_webapp_slide',array('uniacid'=>$uniacid,'id'=>$_GPC['id']));
    }
    include $this->template('webapp/webappSlide/edit');
}

if($op=='slide_set_edit_save'){
    $data=$_POST;
    if(empty($data['status'])){
        $data['status']=0;
    }
    $updateData=array(
        'slide_src'=>tomedia($data['slide_src']),
        'status'=>$data['status'],
        'rank'=>$data['rank'],
        'uniacid'=>$uniacid,
    );

    if(empty($_GPC['id'])){
        $res=pdo_insert('cqkundian_farm_webapp_slide',$updateData);
    }else{
        $res=pdo_update('cqkundian_farm_webapp_slide',$updateData,array('id'=>$data['id'],'uniacid'=>$uniacid));
    }
    if($res){
        message('操作成功',url('site/entry/webapp',array('m'=>'kundian_farm','op'=>'slide_set')));die;
    }else{
        message('操作失败');die;
    }
}

//删除轮播图信息
if($op=='slide_delete'){
    $res=pdo_delete('cqkundian_farm_webapp_slide',array('uniacid'=>$uniacid,'id'=>$_GPC['id']));
    if($res){
        echo json_encode(array('status'=>1));die;
    }else{
        echo json_encode(array('status'=>2));die;
    }
}


/**
 * 配置信息插入
 * @param $data
 * @param $uniacid
 * @return bool|int
 */
function insertSetData($data,$uniacid){
    $res=0;
    foreach ($data as $key=>$v){
        $updateData=array(
            'ikey'=>$key,
            'value'=>$v,
            'uniacid'=>$uniacid,
        );
        $cond=array(
            'ikey'=>$key,
            'uniacid'=>$uniacid,
        );
        $farmData=pdo_get('cqkundian_farm_webappset',$cond);
        if(empty($farmData)){
            $res+=pdo_insert('cqkundian_farm_webappset',$updateData);
        }else{
            $res+=pdo_update('cqkundian_farm_webappset',$updateData,$cond);
        }
    }
    return $res;
}


/**
 * 获取小程序的配置信息
 * @param $field
 * @param $condition
 * @return array
 */
function getWebappSetData($field,$condition){
    $condition['ikey']=$field;
    $setData=pdo_getall('cqkundian_farm_webappset',$condition);
    $list=array();
    foreach ($setData as $key=>$value){
        $list[$value['ikey']]=$value['value'];
    }
    return $list;
}

?>