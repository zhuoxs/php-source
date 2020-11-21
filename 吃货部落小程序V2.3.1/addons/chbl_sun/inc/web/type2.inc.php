<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$sql="select a.* ,b.type_name from " . tablename("chbl_sun_type2") . " a"  . " left join " . tablename("chbl_sun_type") . " b on b.id=a.type_id where a.uniacid=:uniacid order by num asc";
$list=pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
if($_GPC['id']){
    $res=pdo_delete('chbl_sun_type2',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('type2',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/type2');