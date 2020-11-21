<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

// $list = pdo_getall('zhls_sun_storetype2',array('uniacid' => $_W['uniacid']));
$sql="select a.* ,b.type_name from " . tablename("zhls_sun_storetype2") . " a"  . " left join " . tablename("zhls_sun_storetype") . " b on b.id=a.type_id where a.uniacid=:uniacid ORDER BY num asc";
$list=pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
if($_GPC['id']){

    $res=pdo_delete('zhls_sun_storetype2',array('id'=>$_GPC['id']));

    if($res){

        message('删除成功',$this->createWebUrl('storetype2',array()),'success');

    }else{

        message('删除失败','','error');

    }

}

include $this->template('web/storetype2');