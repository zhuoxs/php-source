<?php
global $_GPC, $_W;
load()->func('tpl');
$weid = $this->_weid;
$action = 'savewine';
$title = $this->actions_titles[$action];

$storeid = intval($_GPC['storeid']);
$this->checkStore($storeid);
$returnid = $this->checkPermission($storeid);
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);

$status = !isset($_GPC['status']) ? -2 : $_GPC['status'];
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $condition = " AND storeid={$storeid} ";
    if (!empty($_GPC['keyword'])) {
        $condition .= " AND (title LIKE '%{$_GPC['keyword']}%' OR savenumber LIKE '%{$_GPC['keyword']}%' OR username LIKE '%{$_GPC['keyword']}%') ";
    }

    if ($status != -2) {
        $condition .= " AND status = '" . intval($_GPC['status']) . "'";
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_savewine_log) . " WHERE weid = '{$weid}' $condition ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);

    foreach ($list as $key => $value) {
        $list[$key]['goods'] = pdo_fetchall("SELECT a.*,b.title,b.unitname FROM " . tablename
            ('weisrc_dish_savewine_goods') . " as a
left join
" . tablename($this->table_goods) . " as b
 on a.goodsid=b.id WHERE a.weid = '{$weid}' and a.savewineid={$value['id']}");

        $tablesid = intval($order['tablesid']);
        $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tablesid));
        $table_title = $table['title'];
        $list[$key]['tablename'] = $table_title;
    }

    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_savewine_log) . " WHERE weid = '{$weid}' $condition");

    $pager = pagination($total, $pindex, $psize);
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    $discount = pdo_fetchall("SELECT * FROM " . tablename($this->table_category) . " WHERE weid=:weid and storeid=:storeid", array(":weid" => $weid, ":storeid" => $storeid));
    //加菜查询begin
    if ($_POST['selectDish']) {
        $dishCondition = '';
        if ($_POST['addDishName']) {
            $dishCondition = "AND pcate=" . intval($_POST['addDishName']);
        }
        $allGoods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . " WHERE storeid=:storeid AND weid=:weid  AND deleted=0 " . $dishCondition, array(":storeid" => $storeid, ":weid" => $this->_weid));
        foreach ($allGoods as $key => $value) {
            $allGoods[$key]['thumb'] = tomedia($value['thumb']);
        }
        exit(json_encode($allGoods));
    }

    if ($_POST['addDish'] && !empty($_POST['dish'])) {
        $dish = $_POST['dish'];
        $dishInfo = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_savewine_goods') . " WHERE weid=:weid AND storeid=:storeid AND savewineid=:savewineid", array(":weid" => $weid, ":storeid" => $storeid, ":savewineid" => $id));
        foreach ($dishInfo as $v) {
            $dishid[] = $v['goodsid'];
        }
        foreach ($dish as $k => $v) {
            if ($v['status'] != "己选择" || empty($v['num'])) {
                unset($dish[$k]);
            } else {
                if (!empty($dish)) {
                    if (in_array($k, $dishid)) { //更新数量的
                        $dishParm = array("total" => "total+{$v['num']}", "dateline" => time);
                        $dishCon = array(":weid" => $weid, ":storeid" => $storeid, ":savewineid" => $id, ":goodsid" => $k);
                        $sql = "UPDATE " . tablename('weisrc_dish_savewine_goods') . " SET total=total+{$v['num']},dateline=" . TIMESTAMP . ",status=1 WHERE weid=:weid AND storeid=:storeid AND savewineid=:savewineid AND goodsid=:goodsid";
                        pdo_query($sql, $dishCon);
                    } else { //新增
                        $cate = pdo_fetch("SELECT * FROM " . tablename($this->table_category) . " WHERE id=(SELECT pcate FROM " . tablename($this->table_goods) . " WHERE
id=:goodsid)", array(":goodsid" => $k));

                        $savewinetime = intval($cate['savewinetime']);
                        $savetime = 0;
                        if ($savewinetime > 0) {
                            $savetime = strtotime("+{$savewinetime} day");
                        }

                        $parm = array(
                            "weid" => $weid,
                            "storeid" => $storeid,
                            "savewineid" => $id,
                            "goodsid" => $k,
                            "total" => $v['num'],
                            "remark" => $v['remark'],
                            'dateline' => TIMESTAMP,
                            'savetime' => $savetime
                        );
                        pdo_insert('weisrc_dish_savewine_goods', $parm);
                    }

                    //存入
                    $data = array(
                        'weid' => $weid,
                        'type' => 2,
                        'storeid' => $storeid,
                        'savewineid' => $id,
                        'goodsid' => $k,
                        'total' => $v['num'],
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert("weisrc_dish_savewine_record", $data);
                }
            }
        }
        $newOrder = pdo_fetchall("SELECT price,total FROM " . tablename($this->table_order_goods) . " WHERE orderid=:id", array(":id" => $id));
        foreach ($newOrder as $v) {
            $dishTotal['num'] += $v['total'];
            $dishTotal['price'] += (number_format(floatval($v['price']), 2) * $v['total']);
        }

        $newtotalprice = 0;
        $newtotalprice = $dishTotal['price'] + floatval($order['tea_money']) + floatval($order['service_money']) + floatval($order['dispatchprice']) + floatval($order['packvalue']);
        pdo_update($this->table_order, array("totalnum" => $dishTotal['num'], "totalprice" => $newtotalprice, "goodsprice" => $dishTotal['price']), array("id" => $id));
        message('操作成功！', referer(), 'success');
    }

    if (!empty($id)) {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_savewine_log) . " WHERE id = :id", array(':id' => $id));
        if (empty($item)) {
            message('抱歉，活动不存在或是已经删除！', '', 'error');
        }
        $loglist = pdo_fetchall("SELECT a.*,b.title AS title FROM " . tablename("weisrc_dish_savewine_record") . " a LEFT JOIN
" . tablename("weisrc_dish_goods") . " b
ON a
.goodsid=b.id WHERE a.savewineid=:savewineid ORDER BY a.id
desc", array(':savewineid' => $id));

        $goodslist = pdo_fetchall("SELECT a.*,b.title,b.unitname,b.thumb FROM " . tablename('weisrc_dish_savewine_goods') . "
        as a
left join
" . tablename($this->table_goods) . " as b
 on a.goodsid=b.id WHERE a.weid = '{$weid}' and a.savewineid={$id}");

        if (!empty($_GPC['confirmtable'])) { //取出
            $goodsid = intval($_GPC['goodsid']);
            $total = intval($_GPC['goodsnum']);
            $goods = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_savewine_goods") . " WHERE id ={$goodsid} LIMIT 1");
            if ($goods) {
                $data = array(
                    'weid' => $weid,
                    'type' => 1,
                    'storeid' => $item['storeid'],
                    'savewineid' => $goods['savewineid'],
                    'goodsid' => $goods['goodsid'],
                    'total' => $total,
                    'dateline' => TIMESTAMP
                );
                pdo_insert("weisrc_dish_savewine_record", $data);
            }
            if ($total > $goods['total']) {
                message('输入的数量不能大于寄存数量！', '', 'error');
            }

            if ($total == $goods['total']) { //取出全部
                pdo_update("weisrc_dish_savewine_goods",
                    array(
                        'status' => -1,
                        'takeouttime' => TIMESTAMP,
                        'total' => 0),
                    array('id' => $goodsid));
            } else {
                pdo_update("weisrc_dish_savewine_goods",
                    array('total' => intval($goods['total']) - $total, 'takeouttime' => TIMESTAMP), array('id' => $goodsid));
            }
            message('操作成功！', referer(), 'success');
        }

    } else {
        $item['savenumber'] = $this->get_save_number($weid);
    }

    if (checksubmit('submit')) {
        $data = array(
            'weid' => $weid,
            'storeid' => $storeid,
            'savenumber' => trim($_GPC['savenumber']),
            'title' => trim($_GPC['title']),
            'username' => trim($_GPC['username']),
            'tel' => trim($_GPC['tel']),
            'remark' => trim($_GPC['remark']),
            'status' => intval($_GPC['status']),
            'dateline' => TIMESTAMP,
        );

        if ($status == 1) {
            $data['savetime'] = TIMESTAMP;
        }
        if ($status == -1) {
            $data['takeouttime'] = TIMESTAMP;
        }

        if (empty($id)) {
            pdo_insert($this->table_savewine_log, $data);
        } else {
            unset($data['dateline']);
            pdo_update($this->table_savewine_log, $data, array('id' => $id));
        }
        message('操作成功！', $this->createWebUrl('savewine', array('op' => 'display', 'storeid' => $storeid)),
            'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename($this->table_savewine_log) . " WHERE id = :id", array(':id' => $id));
    if (empty($item)) {
        message('数据不存在或是已经被删除！', $this->createWebUrl('savewine', array('op' => 'display', 'storeid' =>
            $storeid)), 'error');
    }
    pdo_delete($this->table_savewine_log, array('id' => $id, 'weid' => $weid));
    message('删除成功！', $this->createWebUrl('savewine', array('op' => 'display', 'storeid' => $storeid)), 'success');
}
include $this->template('web/savewine');