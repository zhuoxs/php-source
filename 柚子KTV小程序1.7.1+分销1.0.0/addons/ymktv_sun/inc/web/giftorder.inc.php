<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_getall('ymktv_sun_gift_order',array('uniacid' => $_W['uniacid']));
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pindex = max(1, intval($_GPC['page']));
$psize = 10;
$condition = ' WHERE `uniacid` = :uniacid ';
$params = array(':uniacid' => $_W['uniacid']);
// 门店数据
$build = pdo_getall('ymktv_sun_building',array('uniacid'=>$_W['uniacid']));
if ($operation == 'post') {
    $id = $_GPC['id'];
    if (!empty($id)) {
        $item = pdo_fetch("SELECT *  FROM " . tablename('ymktv_sun_gift_order') . " WHERE id = :id", array(':id' => $id));
    }
    if (checksubmit('submit')) {

        $data = array(
            'uniacid' => $_W['uniacid'],
            'title'=>$_GPC['title'],
            'content' => htmlspecialchars_decode($_GPC['content']),
            'sort'=>$_GPC['sort'],
            'thumb'=>$_GPC['thumb'],
            'createtime' => TIMESTAMP,
        );
        if (!empty($id)) {
            unset($data['createtime']);
            pdo_update('ymktv_sun_gift_order', $data, array('id' => $id));
        } else {
            pdo_insert('ymktv_sun_gift_order', $data);
            $id = pdo_insertid();
        }
        message('更新成功！', $this->createWebUrl('order', array('op' => 'display')), 'success');
    }
} elseif($operation == 'done'){

    $id = intval($_GPC['id']);

    $row = pdo_fetch("SELECT id FROM " . tablename('ymktv_sun_gift_order') . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，订单不存在或是已经被删除！');
    }
    pdo_update('ymktv_sun_gift_order', array('state'=>1), array('id' => $id));

    message('操作成功！', referer(), 'success');

}elseif ($operation == 'display') {
    $isshow = $_GPC['isshow'];
    if(!isset($isshow))
        $isshow = -1;
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $condition = ' WHERE `uniacid` = :uniacid ';
    $params = array(':uniacid' => $_W['uniacid']);

    if (!empty($_GPC['member'])) {
        $condition .= ' AND `tel` LIKE :title';
        $params[':title'] = '%' . trim($_GPC['member']) . '%';
    }
    if($isshow ==-1)
    {
        $condition .= '';
    }elseif($isshow ==-2)
    {
        $condition .= '  AND state =0 ';
    }elseif($isshow == -3){

        $condition .= '  AND state =1 ';
    }else{
        $condition .= ' AND build_id='.$isshow;
    }


    $sql = 'SELECT COUNT(*) FROM ' . tablename('ymktv_sun_gift_order') .$condition ;

    $total = pdo_fetchcolumn($sql, $params);

    if (!empty($total)) {
        $sql = 'SELECT * FROM  ' . tablename('ymktv_sun_gift_order') .$condition.' ORDER BY  `createtime`  DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
        $list = pdo_fetchall($sql, $params);
//        foreach($list as $k=>$v)
//        {
//            $actives = pdo_fetch("SELECT title FROM " . tablename('ymktv_sun_active') . " WHERE id = :id", array(':id' => $v['pid']));
//            $list[$k]['title'] = $actives['title'];
//        }

        $pager = pagination($total, $pindex, $psize);

    }

} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $row = pdo_fetch("SELECT id FROM " . tablename('ymktv_sun_gift_order') . " WHERE id = :id", array(':id' => $id));
    if (empty($row)) {
        message('抱歉，订单不存在或是已经被删除！');
    }
    pdo_delete('ymktv_sun_gift_order', array('id' => $id));
    message('删除成功！', referer(), 'success');
}


include $this->template('web/giftorder');