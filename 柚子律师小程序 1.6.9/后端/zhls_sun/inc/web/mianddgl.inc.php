<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$mid = $_GPC['mid'];

$sql = ' SELECT * FROM ' . tablename('zhls_sun_mproblem') . ' mp ' . ' JOIN ' .tablename('zhls_sun_manswer') . ' mw ' . ' ON ' . ' mp.mid=mw.mpro_id' . ' WHERE ' . ' mw.uniacid=' . $_W['uniacid'] . ' AND ' . ' mw.mpro_id=' . $mid . ' ORDER BY' . ' mw.huifutime DESC';
$info = pdo_fetchall($sql);


if($_GPC['id']){
    $res=pdo_delete('zhls_sun_manswer',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('mianddgl',array()),'success');
    }else{
        message('删除失败','','error');
    }
}
include $this->template('web/mianddgl');