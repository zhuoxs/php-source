<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzqzk_sun_coupon',array('uniacid' => $_W['uniacid']));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$condition = ' WHERE `uniacid` = :uniacid ';
$params = array(':uniacid' => $_W['uniacid']);
if (!empty($_GPC['keyword'])) {
    $condition .= ' AND `title` LIKE :title';
    $params[':title'] = '%' . trim($_GPC['keyword']) . '%';
}
$sql = 'SELECT COUNT(*) FROM ' . tablename('yzqzk_sun_coupon') .$condition ;
$total = pdo_fetchcolumn($sql, $params);

if (!empty($total)) {
    $sql = 'SELECT * FROM  ' . tablename('yzqzk_sun_coupon') .$condition.' ORDER BY  `add_time`  DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
    $list = pdo_fetchall($sql, $params);
    foreach($list as &$val) {
        $val['store_name'] = pdo_getcolumn('yzqzk_sun_store', array('uniacid' => $_W['uniacid'], 'id' => $val['store_id']), 'store_name', 1);
    }
    $pager = pagination($total, $pindex, $psize);
}
if($operation == 'done'){
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM " . tablename('yzqzk_sun_coupon') . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，优惠券不存在或是已经被删除！');
    }
    $state= intval($_GPC['state']);
    if($state == 1)
    {
        $condition = ' WHERE `uniacid` = :uniacid AND `state` =:state ';
        $params = array(':uniacid' => $_W['uniacid'],':state'=>$state);
        $active = pdo_fetch("SELECT id FROM " . tablename('yzqzk_sun_coupon') .$condition , $params);
        pdo_update('yzqzk_sun_coupon', array('state'=>$state), array('id' => $id));
        message('活动开启成功！', referer(), 'success');
    }else{
        pdo_update('yzqzk_sun_coupon', array('state'=>$state), array('id' => $id));
        message('活动关闭成功！', referer(), 'success');
    }
}
if($operation == 'delete'){
    $id = intval($_GPC['id']);
    $res = pdo_delete('yzqzk_sun_coupon',array('id'=>$id));
    if($res){
        message('删除成功！',referer(), 'success');
    }else{
        message('删除失败！');
    }
}
include $this->template('web/coupon');