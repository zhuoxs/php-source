<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = $_GPC['do'];
$act = in_array($_GPC['act'], array('display', 'refund_list', 'refund'))?$_GPC['act']:'display';
$title = '订单管理';
if ($act == 'display') {
    //搜索
    $ordersn = trim($_GPC['ordersn']);
    $order_title = trim($_GPC['title']);
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    if (!empty($ordersn)) {
        $filter['ordersn'] = $ordersn;
    }
    if (!empty($order_title)) {
        $filter['title LIKE'] = "%{$order_title}%";
    }
    $status = in_array($_GPC['status'], array( '-2', '-1', '0', '1', '2', '3', '4', 'all'))?$_GPC['status']:'all';
    if ($status != 'all') {
        $filter['status'] = $status;
    }
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $total = pdo_getcolumn('superman_hand2_order', $filter, 'COUNT(*)');
    $orderby = 'createtime DESC';
    $list = pdo_getall('superman_hand2_order', $filter, '', '', $orderby, array($pindex, $pagesize));
    $pager = pagination($total, $pindex, $pagesize);
    if (!empty($list)) {
        foreach ($list as &$li) {
            $li['_status_title'] = SupermanHandUtil::order_status_title($li['status']);
            $li['seller'] = mc_fetch($li['seller_uid'], array('nickname'));
            $li['buyer'] = mc_fetch($li['buyer_uid'], array('nickname'));
            $li['_createtime'] = $li['createtime']?date('Y-m-d H:i:s', $li['createtime']):'';
        }
        unset($li);
    }
} else if ($act == 'refund_list') {
    //搜索
    $ordersn = trim($_GPC['ordersn']);
    $order_title = trim($_GPC['title']);
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    if (!empty($ordersn)) {
        $filter['ordersn'] = $ordersn;
    }
    if (!empty($order_title)) {
        $filter['title LIKE'] = "%{$order_title}%";
    }
    $filter['status'] = array(-1, -3);
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $total = pdo_getcolumn('superman_hand2_order', $filter, 'COUNT(*)');
    $orderby = 'createtime DESC';
    $list = pdo_getall('superman_hand2_order', $filter, '', '', $orderby, array($pindex, $pagesize));
    $pager = pagination($total, $pindex, $pagesize);
    if (!empty($list)) {
        foreach ($list as &$li) {
            $li['_status_title'] = SupermanHandUtil::order_status_title($li['status']);
            $li['seller'] = mc_fetch($li['seller_uid'], array('nickname'));
            $li['buyer'] = mc_fetch($li['buyer_uid'], array('nickname'));
            $li['_createtime'] = $li['createtime']?date('Y-m-d H:i:s', $li['createtime']):'';
        }
        unset($li);
    }
} else if ($act == 'refund') {
    $orderid = intval($_GPC['id']);
    $order = pdo_get('superman_hand2_order', array('uniacid' => $_W['uniacid'], 'id' => $orderid,));
    if (!$order) {
        itoast('订单不存在！', '', 'error');
    }
    $item = pdo_get('superman_hand2_item', array(
        'uniacid' => $_W['uniacid'],
        'id' => $order['itemid'],
    ));
    if ($order['credit'] > 0) {
        pdo_delete('superman_hand2_member_block_credit', array(
            'uniacid' => $_W['uniacid'],
            'uid' => $item['buyer_uid'],
            'itemid' => $order['itemid'],
        ));
    } else if ($order['price'] > 0) {
        if ($order['payno'] == '') {
            itoast('微信支付单号为空，无法进行退款操作！', '', 'error');
        }
        $payment = $_W['account']['setting']['payment'];
        if (empty($_W['account']['key']) || empty($payment['wechat']['mchid'])) {
            itoast('支付参数未配置', '', 'error');
        }
        if (empty($payment['wechat_refund']['cert']) || empty($payment['wechat_refund']['key'])) {
            itoast('支付证书未配置！', '', 'error');
        }
        $params = array(
            'appid' => $_W['account']['key'],
            'mch_id' => $payment['wechat']['mchid'],
            'nonce_str' => random(32),
            'transaction_id' => $order['payno'],
            'out_refund_no' => random(22, true),   //退款订单号
            'total_fee' => $order['price'],
            'refund_fee' => $order['price'],
            'op_user_id' => $payment['wechat']['mchid'],
            'refund_account' => 1   //未结算资金退款
        );
        $extra = array('sign_key' => $payment['wechat']['signkey']);
        $ret = SupermanHandUtil::order_refund($params, $extra);
        if (!is_array($ret) && !isset($ret['success'])) {
            itoast('退款失败！', '', 'error');
        }
    }
    pdo_update('superman_hand2_order', array('status' => -3), array('id' => $orderid));
    pdo_update('superman_hand2_item', array('status' => 1, 'stock +=' => $order['total'],), array('id' => $item['id']));
    itoast('操作成功！', 'referer', 'success');
}
include $this->template($this->web_template_path);