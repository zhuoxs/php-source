<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$hair_id = $_GPC['hair_id'];
//p($hair_id);die;
$sql = ' SELECT * FROM ' . tablename('zhls_sun_hairers') . ' a ' . ' JOIN ' . tablename('zhls_sun_gallery') . ' b ' . ' ON ' . ' a.id=b.hair_id' . ' WHERE ' . ' b.hair_id=' . $hair_id;
$list = pdo_fetchall($sql);
//p($list);die;
foreach ($list as $key=>$value){
    $list[$key]['imgs'] = explode(',',$value['imgs']);
}
//p($list);die;
if($_GPC['id']){
    $res=pdo_delete('zhls_sun_gallery',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('type2',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/type2');