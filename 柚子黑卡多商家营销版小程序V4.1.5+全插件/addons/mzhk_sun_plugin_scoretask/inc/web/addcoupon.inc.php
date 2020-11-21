<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('mzhk_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
$id = $_GPC['id'];
$store=pdo_getall('mzhk_sun_store',array('uniacid'=>$_W['uniacid'],'state'=>2));
if(checksubmit('submit')){
        if(strlen($_GPC['title'])> 42){
            message('优惠券名称字数限制14个');
        }
        $data = array(
            'title' => $_GPC['title'],
            'uniacid' => $_W['uniacid'],
            'type'=>1,
            'sign'=>$_GPC['sign'],
            'm_price'=>$_GPC['m_price'],
            'mj_price'=>$_GPC['mj_price'],
            'num'=>$_GPC['num'],
            'expiry_day' => $_GPC['expiry_day'],
            'start_time' =>strtotime($_GPC['start_time']),
            'end_time' =>strtotime($_GPC['end_time']),
            'add_time' => time(),
            'show_index'=>$_GPC['show_index'],
            'info'=>$_GPC['info'],
            'remark'=>$_GPC['remark'],
            'store_id'=>$_GPC['store_id'],
            'is_vip'=>$_GPC['is_vip'],
            'type'=>$_GPC['type'],
            'is_punch'=>$_GPC['is_punch'],
        );
        if (!empty($id)) {
            unset($data['add_time']);
           $res = pdo_update('mzhk_sun_coupon',$data, array('id' => $id));
        } else {
           $res = pdo_insert('mzhk_sun_coupon',$data);
           $id = pdo_insertid();
        }
        if($res){
            message('更新成功！', $this->createWebUrl('coupon'), 'success');
        }
        exit;

}
include $this->template('web/addcoupon');