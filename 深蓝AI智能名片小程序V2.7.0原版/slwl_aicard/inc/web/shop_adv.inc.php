<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    $condition = ' AND uniacid=:uniacid ';
    $params = array(':uniacid' => $_W['uniacid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $sql = "SELECT * FROM " . tablename('slwl_aicard_shop_adv'). ' WHERE 1 ' . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_shop_adv') . ' WHERE 1 ' . $condition, $params);
    $pager = pagination($total, $pindex, $psize);

} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    if ($_W['ispost']) {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'displayorder' => $_GPC['displayorder'],
            'advname' => $_GPC['advname'],
            'enabled' => intval($_GPC['enabled']),
            'page_url' => $_GPC['page_url'],
            'thumb' => $_GPC['thumb']
        );
        if ($id) {
            pdo_update('slwl_aicard_shop_adv', $data, array('id' => $id));
        } else {
            $data['addtime'] = $_W['slwl']['datetime']['now'];
            pdo_insert('slwl_aicard_shop_adv', $data);
            $id = pdo_insertid();
        }
        iajax(0, '保存成功！');
        exit;
    }
    $adv = pdo_fetch("select * from " . tablename('slwl_aicard_shop_adv') . " where id=:id and uniacid=:uniacid", array(":id" => $id, ":uniacid" => $_W['uniacid']));

} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);

    $rst = pdo_delete('slwl_aicard_shop_adv', array('id' => $id));
    if ($rst !== false) {
        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }


} else {
    message('请求方式不存在');
}

include $this->template('web/shop-adv');

?>