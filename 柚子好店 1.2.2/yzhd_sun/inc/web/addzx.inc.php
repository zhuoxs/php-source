<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
// $type=pdo_getall('yzhd_sun_selectedtype',array('uniacid'=>$_W['uniacid']));
$system=pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
$info=pdo_get('yzhd_sun_vip_card',array('id'=>$_GPC['id']));
//var_dump($info);die;
if(checksubmit('submit')){

    if(empty($_GPC['money'])) {
        message('请填写价格', '', 'error');
    }
    if(empty($_GPC['expire_time'])){
        message('请填写有效期','','error');
    }
	if(empty($_GPC['v_pay_num'])){
        message('请填写虚拟购买数量','','error');
    }
    if(empty($_GPC['vip_power'])){
        message('请填写粉丝卡特权','','error');
    }

    if(empty($_GPC['vip_rule'])){
        message('请填写粉丝卡规则','','error');
    }
	$data['money'] = $_GPC['money'];
	$data['expire_time'] = intval($_GPC['expire_time']);
	$data['v_pay_num'] = intval($_GPC['v_pay_num']);
	$data['vip_power'] = $_GPC['vip_power'];
	$data['vip_rule'] = $_GPC['vip_rule'];
	$data['create_time'] = time();
    $data['uniacid'] = $_W['uniacid'];
         if($_GPC['id']==''){

        $res=pdo_insert('yzhd_sun_vip_card',$data,array());

        if($res){
             message('添加成功！', $this->createWebUrl('zx'), 'success');
        }else{
             message('添加失败！','','error');
        }
    }else{

        $res=pdo_update('yzhd_sun_vip_card',$data,array('id'=>$_GPC['id']));
        if($res){
             message('编辑成功！', $this->createWebUrl('zx'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }
}

include $this->template('web/addzx');
