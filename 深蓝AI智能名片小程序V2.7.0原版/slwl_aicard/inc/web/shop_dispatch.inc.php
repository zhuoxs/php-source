<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    $condition = ' AND weid=:weid ';
    $params = array(':weid' => $_W['uniacid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $sql = "SELECT * FROM " . tablename('slwl_aicard_shop_dispatch'). ' WHERE 1 ' . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_shop_dispatch') . ' WHERE 1 ' . $condition, $params);
    $pager = pagination($total, $pindex, $psize);

} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    if ($_W['ispost']) {
        $data = array(
            'weid' => $_W['uniacid'],
            'displayorder' => intval($_GPC['displayorder']),
            'dispatchtype' => intval($_GPC['dispatchtype']),
            'dispatchname' => $_GPC['dispatchname'],
            'express' => $_GPC['express'],
            'firstprice' => $_GPC['firstprice'],
            'firstweight' => $_GPC['firstweight'],
            'secondprice' => $_GPC['secondprice'],
            'secondweight' => $_GPC['secondweight'],
            'description' => $_GPC['description'],
            'enabled'  => $_GPC['enabled'],
        );
        if (!empty($id)) {
            pdo_update('slwl_aicard_shop_dispatch', $data, array('id' => $id));
        } else {
            $data['addtime'] = $_W['slwl']['datetime']['now'];
            pdo_insert('slwl_aicard_shop_dispatch', $data);
            $id = pdo_insertid();
        }
        iajax(0, '保存成功！');
        exit;
    }
    $one = pdo_fetch("select * from " . tablename('slwl_aicard_shop_dispatch') . " where id=:id and weid=:weid", array(":id" => $id, ":weid" => $_W['uniacid']));
    $express = pdo_fetchall("select * from " . tablename('slwl_aicard_shop_express') . " WHERE weid = '{$_W['uniacid']}' ORDER BY displayorder DESC");

} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $one = pdo_fetch("SELECT id  FROM " . tablename('slwl_aicard_shop_dispatch') . " WHERE id = '{$id}' AND uniacid=" . $_W['uniacid'] . "");

    if (empty($one)) {
        iajax(1, '抱歉，不存在或是已经被删除！');
        exit;
    }
    pdo_delete('slwl_aicard_shop_dispatch', array('id' => $id));
    iajax(0, '删除成功！');
    exit;
} else {
    message('请求方式不存在');
}

include $this->template('web/shop-dispatch');

?>