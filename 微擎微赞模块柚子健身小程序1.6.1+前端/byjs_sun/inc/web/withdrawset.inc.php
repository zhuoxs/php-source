<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('byjs_sun_withdrawset',array('uniacid'=>$_W['uniacid']));
// $wd_type = $item["wd_type"]?explode(",",$item["wd_type"]):array();

if(checksubmit('submit')){
    $data['is_open']=$_GPC['is_open'];
    $data['wd_type']=1;
    $data['wd_content']=html_entity_decode($_GPC['wd_content']);
    $data['min_money']=$_GPC['min_money'];
    $data['avoidmoney']=$_GPC['avoidmoney'];
    $data['wd_wxrates']=$_GPC['wd_wxrates'];
    // $data['wd_alipayrates']=$_GPC['wd_alipayrates'];
    // $data['wd_bankrates']=$_GPC['wd_bankrates'];
    $data['cms_rates']=$_GPC['cms_rates'];

    if($_GPC['id']==''){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('byjs_sun_withdrawset',$data);
        if($res){
            message('添加成功',$this->createWebUrl('withdrawset',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('byjs_sun_withdrawset', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('编辑成功',$this->createWebUrl('withdrawset',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template('web/withdrawset');