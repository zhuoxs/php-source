<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$fid = $_GPC['fid'];

$sql = ' SELECT * FROM ' . tablename('zhls_sun_fproblem') . ' mp ' . ' JOIN ' .tablename('zhls_sun_fanswer') . ' mw ' . ' ON ' . ' mp.fid=mw.fpro_id' . ' WHERE ' . ' mw.uniacid=' . $_W['uniacid'] . ' AND ' . ' mw.fpro_id=' . $fid . ' ORDER BY' . ' mw.huifutime DESC';
$info = pdo_fetchall($sql);


if($_GPC['id']){
    $res=pdo_delete('zhls_sun_fanswer',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('payddgl',array('fid'=>$_GPC['fid'])),'success');
    }else{
        message('删除失败','','error');
    }
}

include $this->template('web/payddgl');