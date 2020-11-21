<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    $condition = " AND weid=:weid ";
    $params = array(':weid' => $_W['uniacid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 1000;
    $sql = "SELECT * FROM " . tablename('slwl_aicard_shop_category'). ' WHERE 1 ' . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
    $list = pdo_fetchall($sql, $params);

} elseif ($operation == 'post') {
    $parentid = intval($_GPC['parentid']);
    $id = intval($_GPC['id']);

    if ($id) {
        $category = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_shop_category') . " WHERE id = :id AND weid = :weid", array(':id' => $id, ':weid' => $_W['uniacid']));
    } else {
        $category = array(
            'displayorder' => 0,
        );
    }
    if ($parentid) {
        $parent = pdo_fetch("SELECT id, name FROM " . tablename('slwl_aicard_shop_category') . " WHERE id = '$parentid'");
        if (empty($parent)) {
            iajax(1, '抱歉，上级分类不存在或是已经被删除！');
            exit;
        }
    }
    if ($_W['ispost']) {
        if (empty($_GPC['catename'])) {
            iajax(1, '抱歉，请输入分类名称！');
            exit;
        }
        $data = array(
            'weid' => $_W['uniacid'],
            'name' => $_GPC['catename'],
            'enabled' => intval($_GPC['enabled']),
            'displayorder' => intval($_GPC['displayorder']),
            'isrecommand' => intval($_GPC['isrecommand']),
            'description' => $_GPC['description'],
            'parentid' => $parentid,
            'thumb' => $_GPC['thumb'],
            'adthumb' => $_GPC['adthumb'],
        );

        if ($id) {
            unset($data['parentid']);
            pdo_update('slwl_aicard_shop_category', $data, array('id' => $id, 'weid' => $_W['uniacid']));
        } else {
            pdo_insert('slwl_aicard_shop_category', $data);
            $id = pdo_insertid();
        }
        iajax(0, '保存成功！');
    }


} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);

    $rst = pdo_delete('slwl_aicard_shop_category', array('id' => $id));
    if ($rst !== false) {
        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }


} else {
    message('请求方式不存在');
}


include $this->template('web/shop/category');

?>