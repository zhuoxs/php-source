<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$sql = ' SELECT * FROM ' . tablename('wnjz_sun_order') . ' o ' . ' JOIN ' . tablename('wnjz_sun_comment') . ' co ' . ' ON ' . ' co.oid=o.oid' . ' WHERE ' . ' co.uniacid='.$_W['uniacid'];
$comment = pdo_fetchall($sql);

foreach ($comment as $k=>$v){
    $comment[$k]['servies_name'] = pdo_getcolumn('wnjz_sun_servies',array('uniacid'=>$_W['uniacid'],'sid'=>$v['sid']),'servies_name');
    $comment[$k]['gid'] = pdo_getcolumn('wnjz_sun_orderlist',array('uniacid'=>$_W['uniacid'],'order_id'=>$v['oid']),'gid');
}
foreach ($comment as $k=>$v){
    $comment[$k]['gname'] = pdo_getcolumn('wnjz_sun_goods',array('uniacid'=>$_W['uniacid'],'gid'=>$v['gid']),'gname');
    $comment[$k]['imgs'] = explode(',',$v['imgs']);
}

if($_GPC['op']=='delete'){

    $res=pdo_delete('wnjz_sun_comment',array('eid'=>$_GPC['eid']));
    if($res){
        message('删除成功！', $this->createWebUrl('pingjia'), 'success');
    }else{
        message('删除失败！','','error');
    }
}



include $this->template('web/pingjia');