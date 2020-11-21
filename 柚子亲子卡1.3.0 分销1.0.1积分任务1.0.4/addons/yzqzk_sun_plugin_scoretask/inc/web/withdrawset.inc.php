<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzqzk_sun_withdrawset',array('uniacid'=>$_W['uniacid']));
$wd_type = $item["wd_type"]?explode(",",$item["wd_type"]):array();

if(checksubmit('submit')){
    $data['is_open']=$_GPC['is_open'];
    $data['wd_type']=$_GPC['wd_type']?implode(",",$_GPC['wd_type']):1;
    $data['wd_content']=html_entity_decode($_GPC['wd_content']);
    $data['min_money']=$_GPC['min_money'];
    $data['avoidmoney']=$_GPC['avoidmoney'];
    $data['wd_wxrates']=$_GPC['wd_wxrates'];
    $data['cms_rates']=$_GPC['cms_rates'];
    $data['add_time']=time();

    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('yzqzk_sun_withdrawset',$data);
        if($res){
            message('添加成功',$this->createWebUrl('withdrawset',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        unset($data['ad_time']);
        $res = pdo_update('yzqzk_sun_withdrawset', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('withdrawset',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/withdrawset');