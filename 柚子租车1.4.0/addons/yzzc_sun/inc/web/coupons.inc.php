<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('yzzc_sun_coupon', array('id' => $_GPC['id']));
if($info){
    $info['start_time']=date('Y-m-d H:i:s', $info['start_time']);
    $info['end_time']=date('Y-m-d H:i:s', $info['end_time']);
}

//var_dump($info);exit;
if (checksubmit('submit')) {

    $data['type'] =2;
    $data['title'] = $_GPC['title'];
    $data['start_time'] = strtotime($_GPC['start_time']) ;
    $data['end_time'] =strtotime($_GPC['end_time']) ;
    if ($data['start_time']>$data['end_time']){
        message('结束时间必须大于开始时间！', $this->createWebUrl('coupons'), 'error');
        return false;
    }
    $data['limit']=$_GPC['limit'];
    if($_GPC['xl']==0){
        $data['total'] = $_GPC['total'];
    }else{
        $data['total']=0;
    }
    $data['score'] = $_GPC['score'];
    $data['full'] = $_GPC['full'];
    $data['money'] = $_GPC['money'];
    $data['uniacid'] = $_W['uniacid'];
    $data['createtime'] =time();

    if (empty($_GPC['id'])) {
        $res = pdo_insert('yzzc_sun_coupon', $data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功！', $this->createWebUrl('coupon'), 'success');
        }else{
            message('添加失败！');
        }
    } else {
        $res = pdo_update('yzzc_sun_coupon', $data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('编辑成功！', $this->createWebUrl('coupon'), 'success');
    }else{
        message('编辑失败！');
    }
}

include $this->template('web/coupons');
