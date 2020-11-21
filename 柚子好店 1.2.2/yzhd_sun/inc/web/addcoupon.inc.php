<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhd_sun_coupon',array('id'=>$_GPC['cid']));
    if($res){
        message('操作成功',$this->createWebUrl('coupons',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
$branch  = pdo_getall('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'stutes'=>1));
$info=pdo_get('yzhd_sun_coupon',array('id' => $_GPC['id']));


if(checksubmit('submit')){
        if(empty($_GPC['branch_id'])) {
            message('请选择所属商家', '', 'error');
        }
        if (empty($_GPC['desc'])) {
            message('优惠券描述不能为空', '', 'error');
        }

        if (empty($_GPC['num'])) {
            message('请填写优惠券数量', '', 'error');
        }
        if (empty($_GPC['start_time'])) {
            message('优惠券过期时间不能为空', '', 'error');
        }
        if (empty($_GPC['expire_time'])) {
            message('优惠券过期时间不能为空', '', 'error');
        }
        if($_GPC['start_time']>=$_GPC['expire_time']){
            message('请设置正确的时间');
        }
        if($_GPC['type']==1){
            if($_GPC['price']<=$_GPC['dis_price']){
                message('请设置正确的满减金额');
            }
        }else{
            if($_GPC['reduce_money']<0 || $_GPC['reduce_money']>=100){
                message('折扣不得小于0或大于等于100');
            }
            if(floor($_GPC['reduce_money'])==$_GPC['reduce_money']){

            }else{
                message('折扣百分比仅限填写整数');
            }
        }
        if (! strtotime($_GPC['expire_time'])) message('优惠券过期时间错误', '', 'error');
        $data['name'] = $_GPC['name'];
        $data['money'] = $_GPC['money'];
        $data['reduce_money'] = $_GPC['reduce_money'];
        $data['price'] = $_GPC['price'];
        $data['desc'] = $_GPC['desc'];
        $data['dis_price'] = $_GPC['dis_price'];
        $data['expire_time'] = strtotime($_GPC['expire_time']);
        $data['start_time'] = strtotime($_GPC['start_time']);
        $data['expire_date'] = $_GPC['expire_time'];
        $data['create_time'] = time();
        $data['branch_id'] = $_GPC['branch_id'];
        $data['num'] = $_GPC['num'];
        $data['ps'] = $_GPC['ps'];
        $data['state'] = 1;
        $data['type'] = $_GPC['type'];
        $data['sy_num'] = $_GPC['num'];
        $data['xl_frequency'] = $_GPC['xl_frequency'] ? $_GPC['xl_frequency']:0;
        $data['uniacid'] = $_W['uniacid'];
        if(empty($_GPC['id'])){
            $res = pdo_insert('yzhd_sun_coupon', $data,array());

            if($res){
                message('添加成功',$this->createWebUrl('coupons',array()),'success');
            }else{
                message('添加失败','','error');
            }
        }else{
            $res = pdo_update('yzhd_sun_coupon', $data, array('id' => $_GPC['id']));
        }
            if($res){
                message('修改成功',$this->createWebUrl('coupons',array()),'success');
            }else{
                message('修改失败','','error');
            }
    }
include $this->template('web/addcoupon');
