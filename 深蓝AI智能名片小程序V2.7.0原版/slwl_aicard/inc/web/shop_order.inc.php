<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 */

defined('IN_IA') or exit('Access Denied');

global $_GPC, $_W;
load()->func('tpl');
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    $status = $_GPC['status'];


} else if ($operation == 'display_table') {
    $status = $_GPC['status'];

    if ($status == '') {
        $where = '';
    } else if ($status == 2) {
        $where.=" and ( status=1 or status=2 ) ";
    } else {
        $where.=" and status=$status ";
    }
    $condition = ' AND weid=:weid ';
    $condition .= $where;
    $params = array(':weid' => $_W['uniacid']);
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $sql = "SELECT * FROM " . tablename('slwl_aicard_shop_order'). ' WHERE 1 ' . $condition . " ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize .',' .$psize;

    $list = pdo_fetchall($sql, $params);
    if ($list) {
        $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_shop_order') . ' WHERE 1 ' . $condition, $params);
        // $pager = pagination($total, $pindex, $psize);

        //配送方式
        $condition_dispatch = " AND weid=:uniacid AND enabled='1' ";
        $params_dispatch = array(':uniacid'=>$_W['uniacid']);
        $dispatch = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_shop_dispatch') . ' WHERE 1 ' . $condition_dispatch, $params_dispatch);

        $order_status = array(
            '-1'=>'已取消',
            '0'=>'待付款',
            '1'=>'待发货',
            '2'=>'待收货',
            '3'=>'已完成',
        );
        foreach ($list as $k => $v) {
            $tmp = array();
            @list($tmp['username'], $tmp['mobile']) = @explode('|', $v['address']);

            $list[$k]['username'] = $tmp['username'];
            $list[$k]['mobile'] = $tmp['mobile'];

            if ((!empty($dispatch)) && ($dispatch['id'] == $v['dispatch'])) {
                $list[$k]['dispatch_cn'] = $dispatch['dispatchname'];
            } else {
                $list[$k]['dispatch_cn'] = '未知';
            }
            $list[$k]['status_format'] = $v['status']?'已支付':'未支付';
            if ($v['sendtype']=='3') {
                $list[$k]['sendtype_format'] = '无需配送';
            } else if ($v['sendtype']=='2') {
                $list[$k]['sendtype_format'] = '自提';
            } else {
                $list[$k]['sendtype_format'] = $list[$k]['dispatch_cn'];
            }
            $list[$k]['goodstype_format'] = $order_status[$v['goodstype']];
            $list[$k]['date_format'] = date('Y-m-d',$item['createtime']);
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


} elseif ($operation == 'detail') {
    $id = intval($_GPC['id']);
    $order = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_shop_order') . " where id=:id and weid=:weid", array(":id" => $id, ":weid" => $_W['uniacid']));
    if (empty($order)) {
        iajax(1, '抱歉，不存在或是已经被删除！');
        exit;
    }

    //配送方式
    $condition_dispatch = ' AND weid=:uniacid AND enabled=1 ';
    $params_dispatch = array(':uniacid'=>$_W['uniacid']);
    $dispatch = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_shop_dispatch') . ' WHERE 1 ' . $condition_dispatch, $params_dispatch);

    $order['dispatch_cn'] = $dispatch['dispatchname'];

    // 收货地址信息
    $order['user'] = explode('|', $order['address']);

    $goods = pdo_fetchall("SELECT g.*, o.total,g.type,o.optionname,o.optionid,o.price as orderprice FROM " . tablename('slwl_aicard_shop_order_goods') .
                " o left join " . tablename('slwl_aicard_shop_goods') . " g on o.goodsid=g.id " . " WHERE o.orderid='{$id}'");
    $item['goods'] = $goods;


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
        if (!empty($id)) {
            pdo_update('slwl_aicard_shop_order', $data, array('id' => $id));
        } else {
            $data['addtime'] = date('Y-m-d H:i:s', time());
            pdo_insert('slwl_aicard_shop_order', $data);
            $id = pdo_insertid();
        }
        iajax(0, '保存成功！');
        exit;
    }
    $order = pdo_fetch("select * from " . tablename('slwl_aicard_shop_order') .
        " where id=:id and uniacid=:uniacid", array(":id" => $id, ":uniacid" => $_W['uniacid']));


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

    $rst = @pdo_delete('slwl_aicard_shop_order', $where);

    if ($rst !== false) {
        iajax(0, '成功');
    } else {
        iajax(1, '不存在或已删除');
    }


} else {
    message('请求方式不存在');
}

include $this->template('web/shop/order');
?>