<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhyk_sun_plugin_scoretask_lotteryprize',array('id'=>$_GPC['id']));
$category=array(
    array('id'=>1,'name'=>'积分商城实物'),
    array('id'=>2,'name'=>'积分'),
    array('id'=>3,'name'=>'谢谢参与'),
);
$goods=pdo_getall('yzhyk_sun_plugin_scoretask_goods',array('uniacid'=>$_W['uniacid'],'state'=>1,'lid'=>1),array(),'','id desc');
if(checksubmit('submit')){
    $count=pdo_getcolumn('yzhyk_sun_plugin_scoretask_lotteryprize',array('uniacid'=>$_W['uniacid']),array('count(id) as count'));
    if($count>=8&&empty($_GPC['id'])){
        message('最多添加8个奖品','','error');
    }
    $data['uniacid']=$_W['uniacid'];
    $data['name']=$_GPC['name'];
    $data['type']=$_GPC['type'];
    $data['pic']=$_GPC['pic'];
    $data['gid']=$_GPC['gid'];
    $data['score']=$_GPC['score'];
    $data['rate']=$_GPC['rate'];
    $data['num']=$_GPC['num'];
    $data['add_time']= time();
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzhyk_sun_plugin_scoretask_lotteryprize', $data);
    }else{
        $res = pdo_update('yzhyk_sun_plugin_scoretask_lotteryprize', $data, array('id' => $_GPC['id']));
    }
    if($res){
        message('编辑成功',$this->createWebUrl('lotteryprize',array()),'success');
    }else{
        message('编辑失败','','error');
    }
}
include $this->template('web/addlotteryprize');