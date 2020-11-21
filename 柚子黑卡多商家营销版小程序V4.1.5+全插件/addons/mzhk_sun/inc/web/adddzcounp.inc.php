<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info = pdo_get('mzhk_sun_coupon', array('id' => $_GPC['id']));
$val = json_decode($info['val'],true);

if (checksubmit('submit')) {
    $data['uniacid'] =$_W['uniacid'];
    $data['title'] =$_GPC['title'];
    $data['type'] = 1;
    
    $brand = $_GPC['bid'];
    $brandarr = array();
    if(!empty($brand)){
        $brandarr = explode("$$$",$brand);
    }
    $data['bid'] = $brandarr[0];
    
    $data['money'] = $_GPC['money'];
    $data['antime'] = $_GPC['antime'];
    $data['astime'] = $_GPC['astime'];
    $data['expiryDate'] = $_GPC['expiryDate'];
    $data['allowance'] = $_GPC['allowance'];
    $data['total'] = $_GPC['total'];
    $data['showIndex'] = $_GPC['showIndex'];
    $data['remarks'] = $_GPC['remarks'];
    $data['isvip'] = $_GPC['isvip'];
    $data['img'] = $_GPC['img'];
    $data['content'] = html_entity_decode($_GPC['content']);
    if (empty($_GPC['id'])) {
        $res = pdo_insert('mzhk_sun_coupon', $data,array('uniacid'=>$_W['uniacid']));
        if($res){
            message('添加成功！', $this->createWebUrl('dzcounp'), 'success');
        }else{
            message('添加失败！');
        }
    } else {
        $res = pdo_update('mzhk_sun_coupon', $data, array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    }
        if($res){
            message('编辑成功！', $this->createWebUrl('dzcounp'), 'success');
        }else{
            message('编辑失败！');
        }
}

include $this->template('web/adddzcounp');
