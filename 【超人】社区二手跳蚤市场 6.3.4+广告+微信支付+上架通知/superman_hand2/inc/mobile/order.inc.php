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
$act = in_array($_GPC['act'], array(
    'display',
    'post',   //修改状态
    'delete', //删除订单
    'comment', //评价
))?$_GPC['act']:'display';
if ($act == 'display') {
    $title = '订单列表';
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $start = ($pindex - 1) * $pagesize;
    $orderby = 'createtime DESC';
    $type = $_GPC['type'];
    if (!empty($type)) {
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'status >' => 0,
        );
        if ($type == 'sell') {
            $filter['seller_uid'] = $_W['member']['uid'];
        } else {
            $filter['buyer_uid'] = $_W['member']['uid'];
        }
        $list = pdo_getall('superman_hand2_order', $filter);
        if (!empty($list)) {
            foreach ($list as &$li) {
                $li['item'] = pdo_get('superman_hand2_item', array(
                    'uniacid' => $_W['uniacid'],
                    'id' => $li['itemid'],
                ));
                SupermanHandModel::superman_hand2_item($li['item']);
            }
            unset($li);
        }
    }
} else if ($act == 'post') {
    $orderid = intval($_GPC['orderid']);
    $status = intval($_GPC['status']);
    $order = pdo_get('superman_hand2_order', array(
        'uniacid' => $_W['uniacid'],
        'id' => $orderid,
    ));
    if (!$order) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '订单不存在', 'error');
    }
    $data = array(
        'status' => $status,
        'reason' => $_GPC['reason'],
    );
    if ($status == 2) {
        $data['sendtime'] = TIMESTAMP;
        //统计日成交量
        SupermanHandUtil::stat_day_item_trade();
    }
    $ret = pdo_update('superman_hand2_order', $data, array(
        'id' => $orderid
    ));
    if ($ret === false) {
        SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '数据库更新失败', 'error');
    }
    $item = pdo_get('superman_hand2_item', array(
        'uniacid' => $_W['uniacid'],
        'id' => $order['itemid'],
    ));
    if ($status == 2) {
        //发送模板消息
        //todo
    }
    if ($status == 3) {
        //确认收货积分逻辑
        if ($order['credit'] > 0) {
            //返卖家卖出物品积分
            $credit_log = array(
                $item['seller_uid'],
                '卖出物品'.$item['title'],
                'superman_hand2',
            );
            $ret1 = mc_credit_update($item['seller_uid'], 'credit1', $order['credit'], $credit_log);
            if (is_error($ret1)) {
                WeUtility::logging('fatal', '[[order.inc.php: post] update seller_uid credit fail], ret1='.var_export($ret, true));
            }
            //扣买家花费积分
            $credit_log = array(
                $_W['member']['uid'],
                '兑换'.$item['title'].'物品',
                'superman_hand2',
            );
            $ret2 = mc_credit_update($item['buyer_uid'], 'credit1', -$order['credit'], $credit_log);
            if (is_error($ret2)) {
                WeUtility::logging('fatal', '[[order.inc.php: post] update buyer_uid credit fail], ret1='.var_export($ret2, true));
                SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '扣除积分失败', 'error');
            }
            //删除冻结积分
            pdo_delete('superman_hand2_member_block_credit', array(
                'uniacid' => $_W['uniacid'],
                'uid' => $item['buyer_uid'],
                'itemid' => $order['itemid'],
            ));

            //发送模板消息
            //todo
        }
        //完成结算订单资金
        if ($order['paytype'] == 2) {
            $ret1 = pdo_update('superman_hand2_member', array(
                'balance +=' => $order['price'],
                'updatetime' => TIMESTAMP,
            ), array(
                'uniacid' => $_W['uniacid'],
                'uid' => $order['seller_uid']
            ));
            $ret2 = pdo_update('superman_hand2_order', array(
                'settlement_status' => 1,
            ), array('id' => $order['id']));
            if ($ret1 === false || $ret2 === false) {
                WeUtility::logging('fatal', ' order.inc.php, order settlement failed, ret1='.var_export($ret1, true).', ret2='.var_export($ret2, true).', order='.var_export($order, true));
            }
            $log = array(
                'uniacid' => $_W['uniacid'],
                'uid' => $order['seller_uid'],
                'type' => 1,
                'money' => $order['price'],
                'operator' => $_W['member']['nickname'],
                'remark' => '用户结算：订单号='.$order['ordersn'],
                'createtime' => TIMESTAMP,
            );
            pdo_insert('superman_hand2_member_money_log', $log);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                WeUtility::logging('fatal', ' order.inc.php, order settlement failed, log='.var_export($log, true).', order='.var_export($order, true));
            }
        }
    }
    //取消删除冻结积分
    if ($status == -1) {
        if ($order['credit'] > 0) {
            pdo_delete('superman_hand2_member_block_credit', array(
                'uniacid' => $_W['uniacid'],
                'uid' => $item['buyer_uid'],
                'itemid' => $order['itemid'],
            ));
        }
        pdo_update('superman_hand2_item', array(
            'status' => 1,
        ), array(
            'id' => $item['id']
        ));
        //发送模板消息
        //todo
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
} else if ($act == 'delete') {
    $orderid = intval($_GPC['orderid']);
    $order = pdo_get('superman_hand2_order', array(
        'uniacid' => $_W['uniacid'],
        'id' => $orderid,
    ));
    if (!$order) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '订单不存在', 'error');
    }
    $ret = pdo_delete('superman_hand2_order', array('id' => $orderid));
    if ($ret === false) {
        SupermanHandUtil::json(SupermanHandErrno::DELETE_FAIL);
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
} else if ($act == 'comment') {
    $orderid = intval($_GPC['orderid']);
    $level = intval($_GPC['level']);
    $message = $_GPC['message'];
    $order = pdo_get('superman_hand2_order', array(
        'uniacid' => $_W['uniacid'],
        'id' => $orderid,
    ));
    if (!$order) {
        message('订单不存在', '', 'error');
    }
    if (checksubmit()) {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid'],
            'seller_uid' => $order['seller_uid'],
            'orderid' =>$orderid,
            'itemid' => $order['itemid'],
            'level' => $level,
            'message' => $message,
            'dateline' => TIMESTAMP,
        );
        pdo_insert('superman_hand2_grade', $data);
        $new_id = pdo_insertid();
        if (empty($new_id)) {
            SupermanHandUtil::json(SupermanHandErrno::INSERT_FAIL);
        }
        pdo_update('superman_hand2_order', array(
            'status' => 4,
        ), array(
            'id' => $orderid
        ));
        SupermanHandUtil::json(SupermanHandErrno::OK);
    }
}
include $this->template('order/'.$act);
