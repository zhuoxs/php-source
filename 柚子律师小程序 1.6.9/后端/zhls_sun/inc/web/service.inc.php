<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$pid = $_GPC['pid'];
//var_dump($pid);die;
$sql = ' SELECT * FROM ' . tablename('zhls_sun_problem') . ' p ' . ' JOIN ' .tablename('zhls_sun_answer') . ' w ' . ' ON ' . ' p.pid=w.pro_id' . ' WHERE ' . ' w.uniacid=' . $_W['uniacid'] . ' ORDER BY' . ' w.huifutime DESC';
$info = pdo_fetchall($sql);


if($_GPC['id']){
    $res=pdo_delete('zhls_sun_answer',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('service',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/service');