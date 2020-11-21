<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/13
 * Time: 16:11
 */
defined("IN_IA")or exit("Access Denied");
!defined('ROOT_PATH') && define('ROOT_PATH', IA_ROOT . '/addons/kundian_farm/');
require_once ROOT_PATH .'model/common.php';
$commonModel=new Common_KundianFarmModel("cqkundian_farm_plugin_funding_set");
checklogin();  //验证是否登录
global $_GPC,$_W;
$uniacid=$_W['uniacid'];
$op=$_GPC['op'] ? $_GPC['op'] : "system_set";
if($op=='system_set'){
    $filed=array('is_open_funding','funding_risk_desc','funding_return_sms','funding_send_sms','is_open_funding_share_bonus','funding_thing_desc','funding_bonus_desc','fund_contract');
    $setData=$commonModel->getSetData($filed,$uniacid);
    include $this->template("web/system/index");
}

if($op=='system_set_save'){
    $data=$_POST;
    if(empty($data['is_open_funding'])){
        $data['is_open_funding']=0;
    }
    if(empty($data['is_open_funding_share_bonus'])){
        $data['is_open_funding_share_bonus']=0;
    }
    $res=$commonModel->insertSetData($data,$uniacid);
    if($res){
        message('操作成功',url("site/entry/system",array('m'=>'kundian_farm_plugin_funding','version_id'=>$_GPC['version_id'])));die;
    }else{
        message('操作失败');die;
    }
}