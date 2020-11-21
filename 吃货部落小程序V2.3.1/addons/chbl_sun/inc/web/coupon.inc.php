<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('chbl_sun_coupon',array('uniacid' => $_W['uniacid']));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$condition = ' WHERE `uniacid` = :uniacid and del=0';
$params = array(':uniacid' => $_W['uniacid']);

if(!empty($_GPC['keywords'])){
    $condition.=" and title LIKE  concat('%', :title,'%') ";
    $params[':title']=$_GPC['keywords'];
}

$sql = 'SELECT COUNT(*) FROM ' . tablename('chbl_sun_coupon') .$condition ;

$total = pdo_fetchcolumn($sql, $params);

if (!empty($total)) {
    $sql = 'SELECT * FROM  ' . tablename('chbl_sun_coupon') .$condition.' ORDER BY  `selftime`  DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
    $list = pdo_fetchall($sql, $params);
    foreach ($list as $k=>$v){
        if($list[$k]['store_id']==0){
            $list[$k]['store_name'] = '平台活动';
        }else{
            $list[$k]['store_name'] = pdo_getcolumn('chbl_sun_store_active',array('uniacid'=>$_W['uniacid'],'id'=>$v['store_id']),'store_name');
        }
        $list[$k]['new_val'] = json_decode($v['val'],true);
    }

    $pager = pagination($total, $pindex, $psize);
}
if($operation == 'done'){
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM " . tablename('chbl_sun_coupon') . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，订单不存在或是已经被删除！');
    }
    $status= intval($_GPC['status']);
    if($status == 1)
    {
        $condition = ' WHERE `uniacid` = :uniacid AND `status` =:status ';
        $params = array(':uniacid' => $_W['uniacid'],':status'=>$status);
        $active = pdo_fetch("SELECT id FROM " . tablename('chbl_sun_coupon') .$condition , $params);

        pdo_update('chbl_sun_coupon', array('status'=>$status), array('id' => $id));

        message('活动开启成功！', referer(), 'success');

    }else{
        pdo_update('chbl_sun_coupon', array('status'=>$status), array('id' => $id));

        message('活动关闭成功！', referer(), 'success');

    }
}
if($operation == 'delete'){
    $id = intval($_GPC['id']);

    $res = pdo_delete('chbl_sun_coupon',array('id'=>$id));
    if($res){
        message('删除成功！',referer(), 'success');
    }else{
        message('删除失败！');
    }
}

include $this->template('web/coupon');