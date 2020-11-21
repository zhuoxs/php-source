<?php
/**
 * Created by PhpStorm.
 * User: lts
 * Date: 2018/4/28
 * Time: 16:53
 */

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('yzzc_sun_coupon', array('id' => $_GPC['id']));
if($info){
    $info['start_time']=date('Y-m-d H:i:s', $info['start_time']);
    $info['end_time']=date('Y-m-d H:i:s', $info['end_time']);
}

if (checksubmit('submit')) {
    $data['type'] =1;
    $data['title'] = $_GPC['title'];
    $data['start_time'] = strtotime($_GPC['start_time']) ;
    $data['end_time'] =strtotime($_GPC['end_time']) ;
    if ($data['start_time']>$data['end_time']){
        message('结束时间必须大于开始时间！', $this->createWebUrl('rentings'), 'error');
        return false;
    }
    if($_GPC['xl']==0){
        $data['total'] = $_GPC['total'];
    }else{
        $data['total']=0;
    }
    if($_GPC['money']>999){
        message('租车券价格不能超过999元！', $this->createWebUrl('rentings'), 'error');
    }
    $data['limit'] = $_GPC['limit'];
    $data['full'] = $_GPC['full'];
    $data['money'] = $_GPC['money'];
    $data['score'] = $_GPC['score'];
    $data['uniacid'] = $_W['uniacid'];
    $data['createtime'] =time();
    if (empty($_GPC['id'])) {
        $res = pdo_insert('yzzc_sun_coupon', $data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功！', $this->createWebUrl('renting'), 'success');
        }else{
            message('添加失败！');
        }
    } else {
        $res = pdo_update('yzzc_sun_coupon', $data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
    if($res){
        message('编辑成功！', $this->createWebUrl('renting'), 'success');
    }else{
        message('编辑失败！');
    }
}

include $this->template('web/rentings');
