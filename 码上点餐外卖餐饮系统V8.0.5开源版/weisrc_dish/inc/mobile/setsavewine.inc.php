<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$storeid = intval($_GPC['storeid']);
$tablesid = intval($_GPC['tablesid']);

$savenumber = $this->get_save_number($weid);
$result = array('status' => 1);

if (empty($from_user)) {
    $this->showMsg('请先登录');
}

$table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));

$param = array(':weid' => $weid, ':storeid' => $storeid);
$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid = :weid AND storeid=:storeid {$condition} ORDER BY
displayorder DESC,id DESC", $param);
$count = 0;
foreach ($category as $key => $value) {
    $id = intval($value['id']);
    $goodsid = intval($_GPC['cate_name_' . $id]);
    $goodscount = intval($_GPC['cate_count_' . $id]);
    if ($goodsid > 0 && $goodscount > 0) {
        $count++;
    }
}
//if ($count == 0) {
//    $this->showMsg('请先选择寄存商品');
//}

$data = array(
    'weid' => $weid,
    'tablesid' => $tablesid,
    'storeid' => $storeid,
    'from_user' => $from_user,
    'savenumber' => $savenumber,
    'title' => $_GPC['title'],
    'username' => $_GPC['username'],
    'tel' => $_GPC['usermobile'],
    'remark' => '',
    'displayorder' => 0,
    'status' => 0,
    'dateline' => TIMESTAMP
);
pdo_insert($this->table_savewine_log, $data);
$savewineid = pdo_insertid();
if ($savewineid > 0) {
    $this->feieSavewineSendFreeMessage($savewineid);
}

//if ($savewineid > 0) {
//    foreach ($category as $key => $value) {
//        $id = intval($value['id']);
//        $goodsid = intval($_GPC['cate_name_' . $id]);
//        $goodscount = intval($_GPC['cate_count_' . $id]);
//        $savewinetime = intval($value['savewinetime']);
//        $savetime = 0;
//        if ($savewinetime > 0) {
//            $savetime = strtotime("+{$savewinetime} day");
//        }
//
//        if ($goodsid > 0 && $goodscount > 0) {
//            pdo_insert('weisrc_dish_savewine_goods', array(
//                'weid' => $_W['uniacid'],
//                'storeid' => $storeid,
//                'goodsid' => $goodsid,
//                'savewineid' => $savewineid,
//                'total' => $goodscount,
//                'savetime' => $savetime,
//                'dateline' => TIMESTAMP,
//            ));
//        }
//    }
//}

$this->showMsg('操作成功', 1);