<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzhyk_sun_plugin_scoretask_goods',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
    if(empty($_GPC['title'])){
        message('请填写商品名称');
    }
    $data['uniacid']=$_GPC['__uniacid'];
    $data['title']=$_GPC['title'];
    $data['pic']=$_GPC['pic'];
    $data['price']=$_GPC['price'];
    $data['score']=$_GPC['score'];
    $data['bargain_score']=$_GPC['bargain_score'];
    $data['num']=$_GPC['num'];
    $data['min_score']=$_GPC['min_score'];
    $data['max_score']=$_GPC['max_score'];
    $data['begin_time']=strtotime($_GPC['begin_time']);
    $data['end_time']=strtotime($_GPC['end_time']);
    $data['content']=htmlspecialchars_decode($_GPC['content']);
    $data['add_time']= time();
    if(empty($_GPC['id'])){
        $res = pdo_insert('yzhyk_sun_plugin_scoretask_goods', $data);
    }else{
        $res = pdo_update('yzhyk_sun_plugin_scoretask_goods', $data, array('id' => $_GPC['id']));
    }
    if($res){
        message('编辑成功',$this->createWebUrl('goods',array()),'success');
    }else{
        message('编辑失败','','error');
    }
}
include $this->template('web/goodsinfo');