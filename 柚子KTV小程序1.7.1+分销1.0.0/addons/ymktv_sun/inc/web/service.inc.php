<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$hair_id = $_GPC['hair_id'];
$sql = ' SELECT * FROM ' . tablename('ymmf_sun_goods') . ' g ' . ' JOIN ' . tablename('ymmf_sun_service') . ' s ' . ' ON ' . ' g.id=s.goods_id'. ' WHERE ' . 's.hair_id='.$hair_id;
$info = pdo_fetchall($sql);


if($_GPC['id']){
    $res=pdo_delete('ymmf_sun_service',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('service',array('hair_id'=>$_GPC['hair_id'])),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/service');