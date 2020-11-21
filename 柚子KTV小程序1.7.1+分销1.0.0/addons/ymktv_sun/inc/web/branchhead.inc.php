<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('ymktv_sun_branchhead',array('uniacid' => $_W['uniacid']),array(),'','addtime DESC');
foreach ($list as $k=>$v){
    $list[$k]['b_name'] = pdo_getcolumn('ymktv_sun_building',array('uniacid'=>$_W['uniacid'],'id'=>$v['b_id']),'b_name');
}
if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_branchhead',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功',$this->createWebUrl('branchhead',array()),'success');
    }else{
        message('删除失败','','error');
    }
}

include $this->template('web/branchhead');