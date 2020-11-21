<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$hair_id = $_GPC['hair_id'];
$sql = ' SELECT * FROM ' . tablename('wnjz_sun_goods') . ' g ' . ' JOIN ' . tablename('wnjz_sun_service') . ' s ' . ' ON ' . ' g.id=s.goods_id';
$info = pdo_fetchall($sql);


if($_GPC['id']){
    $res=pdo_delete('wnjz_sun_service',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('service',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/service');