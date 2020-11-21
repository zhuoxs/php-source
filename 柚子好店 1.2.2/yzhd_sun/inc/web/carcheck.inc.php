<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where = array('type' => 2,'uniacid'=>$_W['uniacid']);
switch ($_GPC['type']) {
	case 'wait':
		$where['state'] = 1;
		break;
	case 'ok':
		$where['state'] = 3;
		break;
	case 'no':
		$where['state'] = 4;
		break;
	default:
		break;
}
if (! empty($_GPC['keywords'])) {
	$where['out_trade_no'] = $_GPC['keywords'];
}
$list = pdo_getall('yzhd_sun_order', $where);
foreach ($list as $k=>$v){
    $list[$k]['vipcard_id'] = pdo_getcolumn('yzhd_sun_user_vipcard',array('uniacid'=>$_W['uniacid'],'uid'=>$v['openid']),'vipcard_id');
}
foreach ($list as $k=>$v){
    $list[$k]['card_type'] = pdo_getcolumn('yzhd_sun_vip',array('uniacid'=>$_W['uniacid'],'id'=>$v['vipcard_id']),'title');
}
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhd_sun_order',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('carcheck'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzhd_sun_car',array('state'=>2,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
        message('通过成功！', $this->createWebUrl('carcheck'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzhd_sun_car',array('state'=>3,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('carcheck'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}
if($_GPC['op']=='delivery'){
    $res=pdo_update('yzhd_sun_order',array('state'=>3),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('yzhd_sun_order',array('status'=>4),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('操作失败','','error');
    }
}



include $this->template('web/carcheck');
