<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if(checksubmit('submit')){
    $data['province_id'] = $_GPC['province_id'];
    $data['city_id'] = $_GPC['city_id'];
    $data['county_id'] = $_GPC['county_id'];
    $data['uniacid'] = $_W['uniacid'];
    if(!$data['province_id'] || !$data['city_id'] || !$data['county_id']){
        message('请填写完整信息','','error');
    }
    $county_id = pdo_getcolumn('chbl_sun_county_city',array('uniacid'=>$_W['uniacid'],'county_id'=>$_GPC['county_id']),'county_id');
    if(!empty($county_id)){
       message('请勿重复添加城市区域');
    }
    if($_GPC['id']==''){
        $res = pdo_insert('chbl_sun_county_city', $data);
        if($res){
            message('新增成功',$this->createWebUrl('city',array()),'success');
        }else{
            message('新增失败','','error');
        }
        }else{
        $res = pdo_update('chbl_sun_county_city', $data,array('id'=>$_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('city',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/addcity');