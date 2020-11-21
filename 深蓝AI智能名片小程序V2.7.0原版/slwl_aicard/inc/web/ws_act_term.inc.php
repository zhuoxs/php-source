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
        $condition .= ' AND (termname LIKE :termname) ';
        $params[':termname'] = '%'.$keyword.'%';
    }

    $sql = "SELECT * FROM " . tablename('slwl_aicard_website_act_term'). ' WHERE 1 '
        . $condition . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);

    if ($list) {
        foreach ($list as $k => $v) {
            $list[$k]['thumb_url'] = tomedia($v['thumb']);
            $list[$k]['isrecommand_format'] = $v['isrecommand'] ? '推荐':'';
            $list[$k]['enabled_format'] = $v['enabled'] ? '启用':'禁用';
        }
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_website_act_term') . ' WHERE 1 ' . $condition, $params);
        // $pager = pagination($total, $pindex, $psize);
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
            'displayorder' => $_GPC['displayorder'],
            'termname' => $_GPC['termname'],
            'isrecommand' => intval($_GPC['isrecommand']),
            'list_style' => $_GPC['list_style'],
            'click_type' => intval($_GPC['click_type']),
            'enabled' => intval($_GPC['enabled']),
            'thumb' => $_GPC['thumb'],
        );
        if ($id) {
            pdo_update('slwl_aicard_website_act_term', $data, array('id' => $id));
        } else {
            $data['addtime'] = $_W['slwl']['datetime']['now'];
            pdo_insert('slwl_aicard_website_act_term', $data);
            $id = pdo_insertid();
        }
        iajax(0, '保存成功！');
    }

    $condition = " AND uniacid=:uniacid AND id=:id ";
    $params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
    $one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_website_act_term') . ' WHERE 1 ' . $condition, $params);


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

    $rst = @pdo_delete('slwl_aicard_website_act_term', $where);

    if ($rst !== false) {
        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }


} else {
    message('请求方式不存在');
}

include $this->template('web/website/act-term');

?>