<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = ($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {


} else if ($operation == 'display_table') {
    $keyword = $_GPC['keyword'];

    $condition = ' AND uniacid=:uniacid ';
    $params = array(':uniacid' => $_W['uniacid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    if ($keyword != '') {
        $condition .= ' AND (title LIKE :title) ';
        $params[':title'] = '%'.$keyword.'%';
    }

    $sql = "SELECT * FROM " . tablename('slwl_aicard_website_act_news'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    if ($list) {
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_website_act_news') . ' WHERE 1 ' . $condition, $params);
        // $pager = pagination($total, $pindex, $psize);

        $condition_term = " AND uniacid=:uniacid ";
        $params_term = array(':uniacid' => $_W['uniacid']);
        $term = pdo_fetchall('SELECT id,termname FROM ' . tablename('slwl_aicard_website_act_term') . ' WHERE 1 '
            . $condition_term, $params_term);

        foreach ($list as $k => $v) {
            foreach ($term as $key => $value) {
                if ($value['id'] == $v['termid']) {
                    $list[$k]['term_cn'] = $value['termname'];
                    break;
                }
            }
            $list[$k]['thumb_url'] = tomedia($v['thumb']);
            $list[$k]['enabled_format'] = $v['enabled'] ? '启用':'禁用';
        }
    }
    $data_return = array(
        'code' => '0',
        'msg' => '',
        'count' => $total,
        'data' => $list,
    );
    echo json_encode($data_return);
    exit;


} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    if ($_W['ispost']) {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'termid' => $_GPC['termid'],
            'displayorder' => $_GPC['displayorder'],
            'thumb' => $_GPC['thumb'],
            'title' => $_GPC['title'],
            'subtitle' => $_GPC['subtitle'],
            'detail' => htmlspecialchars_decode($_GPC['detail']),
            'enabled' => intval($_GPC['enabled']),
            'createtime' => $_GPC['createtime'],
            'out_thumb' => $_GPC['out_thumb'],
            'out_link' => $_GPC['out_link'],
        );
        if ($id) {
            pdo_update('slwl_aicard_website_act_news', $data, array('id' => $id));
        } else {
            $data['addtime'] = $_W['slwl']['datetime']['now'];
            pdo_insert('slwl_aicard_website_act_news', $data);
            $id = pdo_insertid();
        }
        iajax(0, '保存成功！');
    }

    $condition_news = " AND uniacid=:uniacid AND id=:id ";
    $params_news = array(':uniacid' => $_W['uniacid'], ':id' => $id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_website_act_news') . ' WHERE 1 '
        . $condition_news, $params_news);

    $condition_term = " AND uniacid=:uniacid ";
    $params_term = array(':uniacid' => $_W['uniacid']);
    $term = pdo_fetchall('SELECT id,termname FROM ' . tablename('slwl_aicard_website_act_term') . ' WHERE 1 '
        . $condition_term, $params_term);

    if ($one) {
        $createtime = date('Y-m-d H:i', $one['createtime']);
    } else {
        $createtime = $_W['slwl']['datetime']['now'];
    }


} elseif ($operation == 'delete') {

    $post = file_get_contents('php://input');
    if (!$post) {iajax(1, '参数不存在'); }

    $params = @json_decode($post, true);
    if (!$params) { iajax(1, '参数解析出错'); }

    $ids = isset($params['ids']) ? $params['ids'] : '';
    if (!$ids) { iajax(1, 'ID为空'); }

    foreach ($ids as $k => $v) {
        $flags .= $v . ',';
    }
    $flags = substr($flags, 0, strlen($flags)-1);
    $where = ' id IN(' . $flags . ')';

    $rst = @pdo_delete('slwl_aicard_website_act_news', $where);

    if ($rst !== false) {
        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }


} else {
    message('请求方式不存在');
}

include $this->template('web/website/act-news');

