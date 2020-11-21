<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$id = intval($_GPC['goodsid']);
$savewineid = intval($_GPC['savewineid']);
$total = intval($_GPC['total']);

if (empty($from_user)) {
    $this->showMsg('请先登录');
}

$order = pdo_fetch("SELECT * FROM " . tablename($this->table_savewine_log) . " WHERE id ={$savewineid} AND from_user='{$from_user}' ORDER BY
id DESC LIMIT 1");

if (empty($order)) {
    $this->showMsg('没有存酒记录');
}

if ($id == 0) {
    //存酒主表
    pdo_query("UPDATE ".tablename('weisrc_dish_savewine_log')." SET status=:status,takeouttime=:takeouttime WHERE id
    =:id AND status=1",
        array(
            ':id' => $savewineid,
            ':takeouttime' => TIMESTAMP,
            ':status' => -1,

        )
    );

    //存酒商品表（//全部取出//未过期的）
//    pdo_query("UPDATE ".tablename('weisrc_dish_savewine_goods')." SET status=:status,takeouttime=:takeouttime WHERE savewineid =:savewineid AND takeouttime=0 AND (savetime=0 OR (savetime>0 AND savetime>:savetime))",
//        array(
//            ':status' => -1,
//            ':savewineid' => $savewineid,
//            ':takeouttime' => TIMESTAMP,
//            ':savetime' => TIMESTAMP,
//        )
//    );

    $alls = pdo_fetchall("SELECT * FROM" . tablename('weisrc_dish_savewine_goods') . " WHERE savewineid =:savewineid AND takeouttime=0 AND (savetime=0 OR (savetime>0 AND savetime>:savetime))",
        array(
            ':savewineid' => $savewineid,
            ':savetime' => TIMESTAMP
        )
    );
    $allgoods = array();
    foreach ($alls as $key => $value) {
        pdo_query("UPDATE ".tablename('weisrc_dish_savewine_goods')." SET status=:status,takeouttime=:takeouttime,total=0 WHERE id =:id ",
            array(
                ':id' => $value['id'],
                ':status' => -1,
                ':takeouttime' => TIMESTAMP
            )
        );

        $data = array(
            'weid' => $weid,
            'storeid' => $order['storeid'],
            'savewineid' => $savewineid,
            'goodsid' => $value['goodsid'],
            'total' => $value['total'],
            'dateline' => TIMESTAMP
        );
        pdo_insert("weisrc_dish_savewine_record", $data);

        $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE weid = '{$weid}' and id={$value['goodsid']} ");
        $goodsname = $goods['title'];
        if (!empty($value['remark'])) {
            $goodsname .= "[".$value['remark']."]";
        }

        $allgoods[] = array(
            'title' => $goodsname,
            'total' => $value['total']
        );
    }


    //批量打印
    $this->feieGetAllWineSendFreeMessage($savewineid, $allgoods);
} else {
    if ($total <= 0) {
        $this->showMsg('请输入取出数量');
    }

    $goods = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_savewine_goods") . " WHERE id ={$id} LIMIT 1");
    if ($goods) {
        if ($total > $goods['total']) {
            $this->showMsg('取出的数量不能大于库存数量');
        }

        $data = array(
            'weid' => $weid,
            'storeid' => $order['storeid'],
            'savewineid' => $savewineid,
            'goodsid' => $goods['goodsid'],
            'total' => $total,
            'dateline' => TIMESTAMP
        );
        pdo_insert("weisrc_dish_savewine_record", $data);

        $this->feieGetwineSendFreeMessage($savewineid, $goods['id'], $total);
    }
    if ($total >= $goods['total']) {
        pdo_update("weisrc_dish_savewine_goods", array('total' => 0,'status' => -1, 'takeouttime' => TIMESTAMP), array
        ('id' => $id));
    } else {
        pdo_update("weisrc_dish_savewine_goods", array('total' => intval($goods['total']) - $total, 'takeouttime' => TIMESTAMP), array('id' => $id));
    }
}
$this->showMsg('操作成功', 1);







