<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$map_key=pdo_get('yzzc_sun_system',array('uniacid'=>$_W['uniacid']))['map_key'];
$item=pdo_get('yzzc_sun_branch',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
if($item['pic']){
    if(strpos($item['pic'],',')){
        $lb_imgs= explode(',',$item['pic']);

    }else{
        $lb_imgs=array(
            0=>$item['pic']
        );
    }
}
if($item){
    function getcode($code){
        $cityinfo=pdo_get('yzzc_sun_city',array('code'=>$code));
        return $cityinfo;
    }
  $item['province_name']=getcode($item['province'])['fullname'];
  $item['city_name']=getcode($item['city'])['fullname'];
  $item['area_name']=getcode($item['area'])['fullname'];
}

/**获取省份*/
$province=pdo_getall('yzzc_sun_city',array('pcode'=>0),array('code','fullname'));
/**获取市区*/
if($_GPC['op']=='getcity'){
    $city=pdo_getall('yzzc_sun_city',array('pcode'=>$_GPC['code']),array('code','fullname'));
    exit (json_encode($city));
}

if(checksubmit('submit')){
    if($_GPC['province']==null) {
        message('请选择省份', '', 'error');
    }elseif($_GPC['city']==null) {
        message('请选择城市', '', 'error');
    }
    // elseif($_GPC['area']==null) {
    //     message('请选择区域', '', 'error');
    // }
    elseif($_GPC['address']==null) {
        message('请您写门店详细地址', '', 'error');
    }elseif($_GPC['name']==null) {
        message('请您写门店名称', '', 'error');
    }elseif($_GPC['lng']==null){
        message('请先定位', '', 'error');
    }
    if($_GPC['pic']){
        if(count($_GPC['pic'])<4){
            $data['pic']=implode(",",$_GPC['pic']);
        }else{
            message('图片最多只能上传三张','','error');
        }
    }else{
        $data['pic']='';
    }
    $data['name']=$_GPC['name'];
    $data['province']=$_GPC['province'];
    $data['city']=$_GPC['city'];
    $data['area']=$_GPC['area'];
    $data['uniacid']=$_W['uniacid'];
    $data['address']=$_GPC['address'];
    $data['lng']=$_GPC['lng'];
    $data['lat']=$_GPC['lat'];
    if($_GPC['sm']>0){
        $data['ranges']=$_GPC['ranges'];
    }else{
        $data['ranges']=0;
    }
    $data['business_hours']=$_GPC['business_hours'];
    $data['service_tel']=$_GPC['service_tel'];
    $data['shop_tel']=$_GPC['shop_tel'];
    $data['createtime']=time();

    if($_GPC['id']==''){
        $res=pdo_insert('yzzc_sun_branch',$data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功',$this->createWebUrl('branchslist',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('yzzc_sun_branch', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('branchslist',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}

include $this->template('web/branch');