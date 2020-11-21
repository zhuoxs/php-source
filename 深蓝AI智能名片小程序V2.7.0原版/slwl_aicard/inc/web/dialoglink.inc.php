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


} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);

    $rst = pdo_delete('slwl_aicard_adsp', array('id' => $id));
    if ($rst !== false) {
        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }


} elseif ($operation == 'search') {
    $keyword = $_GPC['keyword'];

    $condition = " AND uniacid=:uniacid AND enabled='1' AND title like :keyword ";
    $params = array(':uniacid' => $_W['uniacid'], ':keyword'=>'%'.$keyword.'%');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 100;
    $sql = "SELECT id,title FROM " . tablename('slwl_aicard_news'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    // $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_news') . ' WHERE 1 ' . $condition, $params);
    // $pager = pagination($total, $pindex, $psize);

    if ($list) {
        iajax(0, $list);
    } else {
        iajax(1, '没有查到数据！');
    }


} elseif ($operation == 'search_adact') {
    $keyword = $_GPC['keyword'];

    $condition = " AND uniacid=:uniacid AND enabled='1' AND title like :keyword ";
    $params = array(':uniacid' => $_W['uniacid'], ':keyword'=>'%'.$keyword.'%');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 100;
    $sql = "SELECT id,title FROM " . tablename('slwl_aicard_adact'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    // $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_adact') . ' WHERE 1 ' . $condition, $params);
    // $pager = pagination($total, $pindex, $psize);

    if ($list) {
        iajax(0, $list);
    } else {
        iajax(2, '没有查到数据！');
    }


} elseif ($operation == 'search_wxapp') {
    $keyword = $_GPC['keyword'];

    $condition = " AND uniacid=:uniacid AND enabled='1' AND title like :keyword ";
    $params = array(':uniacid' => $_W['uniacid'], ':keyword'=>'%'.$keyword.'%');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 100;
    $sql = "SELECT id,title,appid FROM " . tablename('slwl_aicard_mod_wxapp'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    // $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_adact') . ' WHERE 1 ' . $condition, $params);
    // $pager = pagination($total, $pindex, $psize);

    if ($list) {
        iajax(0, $list);
    } else {
        iajax(2, '没有查到数据！');
    }


// 官网分类
} elseif ($operation == 'search_ws_term') {
    $keyword = $_GPC['keyword'];

    $condition = " AND uniacid=:uniacid AND enabled='1' AND termname like :keyword ";
    $params = array(':uniacid' => $_W['uniacid'], ':keyword'=>'%'.$keyword.'%');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 100;
    $sql = "SELECT id,termname FROM " . tablename('slwl_aicard_website_act_term'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    // $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_website_act_term') . ' WHERE 1 ' . $condition, $params);
    // $pager = pagination($total, $pindex, $psize);

    if ($list) {
        iajax(0, $list);
    } else {
        iajax(2, '没有查到数据！');
    }
    exit;


// 官网文章
} elseif ($operation == 'search_ws_news') {
    $keyword = $_GPC['keyword'];

    $condition = " AND uniacid=:uniacid AND enabled='1' AND title like :keyword ";
    $params = array(':uniacid' => $_W['uniacid'], ':keyword'=>'%'.$keyword.'%');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 100;
    $sql = "SELECT id,title FROM " . tablename('slwl_aicard_website_act_news'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    // $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_website_act_news') . ' WHERE 1 ' . $condition, $params);
    // $pager = pagination($total, $pindex, $psize);

    if ($list) {
        iajax(0, $list);
    } else {
        iajax(2, '没有查到数据！');
    }


// 商城分类
} elseif ($operation == 'search_store_term') {
    $keyword = $_GPC['keyword'];

    $condition_store = " AND uniacid=:uniacid AND enabled='1' AND parentid>'0' AND title like :keyword ";
    $params_store = array(':uniacid' => $_W['uniacid'], ':keyword'=>'%'.$keyword.'%');
    $pindex_store = max(1, intval($_GPC['page']));
    $psize_store = 100;
    $sql_store = "SELECT id,title FROM " . tablename('slwl_aicard_store_category'). ' WHERE 1 '
        . $condition_store . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex_store - 1) * $psize_store .',' .$psize_store;

    $list_store = pdo_fetchall($sql_store, $params_store);
    // $total_store = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_store_category') . ' WHERE 1 '
    //     . $condition_store, $params_store);
    // $pager_store = pagination($total_store, $pindex_store, $psize_store);

    if ($list_store) {
        iajax(0, $list_store);
    } else {
        iajax(2, '没有查到数据！');
    }


// 商城商品
} elseif ($operation == 'search_store_good') {
    $keyword = $_GPC['keyword'];

    $condition = " AND uniacid=:uniacid AND deleted='0' AND title like :keyword ";
    $params = array(':uniacid' => $_W['uniacid'], ':keyword'=>'%'.$keyword.'%');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 100;
    $sql = "SELECT id,title FROM " . tablename('slwl_aicard_store_goods'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);

    if ($list) {
        iajax(0, $list);
    } else {
        iajax(2, '没有查到数据！');
    }


} elseif ($operation == 'search_pro') {
    $keyword = $_GPC['keyword'];

    $condition = " AND uniacid=:uniacid AND enabled='1' AND title like :keyword ";
    $params = array(':uniacid' => $_W['uniacid'], ':keyword'=>'%'.$keyword.'%');
    $pindex = max(1, intval($_GPC['page']));
    $psize = 100;
    $sql = "SELECT id,title FROM " . tablename('slwl_aicard_product_list'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    // $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_adact') . ' WHERE 1 ' . $condition, $params);
    // $pager = pagination($total, $pindex, $psize);

    if ($list) {
        iajax(0, $list);
    } else {
        iajax(2, '没有查到数据！');
    }


} else {
    message('请求方式不存在');
}

include $this->template('web/dialoglink');

?>