<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = $_GPC['op'] ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    // $condition = ' AND uniacid=:uniacid ';
    // $params = array(':uniacid' => $_W['uniacid']);
    // $pindex = max(1, intval($_GPC['page']));
    // $psize = 10;
    // $sql = "SELECT * FROM " . tablename('slwl_aicard_adsp'). ' WHERE 1 ' . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    // $list = pdo_fetchall($sql, $params);
    // $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_adsp') . ' WHERE 1 ' . $condition, $params);
    // $pager = pagination($total, $pindex, $psize);

} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    if ($_W['ispost']) {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'displayorder' => $_GPC['displayorder'],
            'name' => $_GPC['name'],
            'enabled' => intval($_GPC['enabled']),
            'thumb' => $_GPC['thumb'],
        );
        if ($id) {
            pdo_update('slwl_aicard_adsp', $data, array('id' => $id));
        } else {
            $data['addtime'] = $_W['slwl']['datetime']['now'];
            pdo_insert('slwl_aicard_adsp', $data);
            $id = pdo_insertid();
        }
        iajax(0, '保存成功！');
    }
    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_adsp') . ' WHERE 1 ' . $condition, $params);

} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);

    $rst = pdo_delete('slwl_aicard_adsp', array('id' => $id));
    if ($rst !== false) {
        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }


// 商城商品
} elseif ($operation == 'store_search_good') {
    $keyword = $_GPC['keyword'];

    $condition = " AND uniacid=:uniacid AND deleted='0' AND title like :keyword ";
    $params = array(':uniacid' => $_W['uniacid'], ':keyword'=>'%'.$keyword.'%');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 100;
    $sql = "SELECT id,title FROM " . tablename('slwl_aicard_store_goods'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    // $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_store_goods') . ' WHERE 1 ' . $condition, $params);
    // $pager = pagination($total, $pindex, $psize);

    if ($list) {
        iajax(0, $list);
    } else {
        iajax(2, '没有查到数据！');
    }


} elseif ($operation == 'store_good_recommand') {
    $good_id = intval($_GPC['id']);
    $card_id = intval($_GPC['cid']);

    if ($_W['ispost']) {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'card_id' => $card_id,
            'good_id' => $good_id,
        );

        $condition = " AND uniacid=:uniacid AND card_id=:card_id AND good_id=:good_id ";
        $params = array(':uniacid' => $_W['uniacid'], ':card_id'=>$card_id, ':good_id'=>$good_id);
        $one = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_card_goods') . ' WHERE 1 ' . $condition, $params);

        if ($one) {
            iajax(1, '商品好像已存在！');
        } else {
            $data['addtime'] = $_W['slwl']['datetime']['now'];
            $pod_ins_id = pdo_insert('slwl_aicard_card_goods', $data);

            if ($pod_ins_id) {
                iajax(0, '保存成功！');
            } else {
                iajax(1, '保存失败！');
            }
        }
    }


} else {
    message('请求方式不存在');
}

include $this->template('web/dialoggood');

?>