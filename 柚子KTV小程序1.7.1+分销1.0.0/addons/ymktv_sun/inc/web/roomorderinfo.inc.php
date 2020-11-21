<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$sql = ' SELECT * FROM ' . tablename('ymktv_sun_goods') . ' g ' . ' JOIN ' . tablename('ymktv_sun_roomorder') . ' r ' . ' ON ' . ' g.id=r.gid' . ' WHERE ' . ' r.uniacid=' . $_W['uniacid'] . ' AND ' . ' r.id='.$_GPC['id'];
$order = pdo_fetch($sql);

$order['type_name'] = pdo_getcolumn('ymktv_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$order['type_id']),'type_name');
if(checksubmit('submit')){
    if($_W['ispost']){

        $res = pdo_update('ymktv_sun_roomorder',array('status'=>$_GPC['status']),array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));

        if($res){
            message('编辑成功！', $this->createWebUrl('roomorder'), 'success');
        }else{
            message('编辑失败！','','error');
        }
    }
}
include $this->template('web/roomorderinfo');