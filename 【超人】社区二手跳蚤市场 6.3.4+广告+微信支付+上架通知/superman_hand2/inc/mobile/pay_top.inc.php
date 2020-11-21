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
    'display',   //付费申请页
    'pay',     //付费提交
    'log',     //付费置顶物品记录
))?$_GPC['act']:'display';
if ($act == 'display') {
    //后台物品广告占用位置
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'item_type' => 1,
        'status' => 1,
    );
    $item_ad = pdo_getall('superman_hand2_item', $filter, array('pay_position'));
    if (!empty($item_ad)) {
        $arr = array();
        foreach ($item_ad as $li) {
            $arr[] = $li['pay_position'];
        }
        $displayorder = implode(',', $arr);
    }
    //物品广告占用位置
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'status >=' => 0,
    );
    $item_top = pdo_getall('superman_hand2_item_top', $filter, array('positionid'));
    if (!empty($item_top)) {
        $arr = array();
        foreach ($item_top as $li) {
            $arr[] = $li['positionid'];
        }
        $positionid = implode(',', $arr);
    }
    //可付费广告位置
    $sql = 'SELECT * FROM '.tablename('superman_hand2_pay_position');
    $sql .= ' WHERE uniacid=:uniacid AND status =:status';
    if ($displayorder) {
        $sql .= ' AND displayorder NOT IN ('.$displayorder.')';
    }
    if ($positionid) {
        $sql .= ' AND id NOT IN ('.$positionid.')';
    }
    $orderby = ' ORDER BY displayorder DESC, createtime DESC';
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':status' => 1,
    );
    $list = pdo_fetchall($sql.$orderby, $params);
    if ($list) {
        foreach ($list as $k => &$li) {
            $li['fields'] = $li['fields']?iunserializer($li['fields']):array();
        }
        unset($li);
    }
} else if ($act == 'pay') {
    $itemid = intval($_GPC['itemid']);
    $positionid = intval($_GPC['positionid']);
    $type = $_GPC['type'];
    $total = $_GPC['total'];
    if (empty($itemid)) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '物品id非法', 'error');
    }
    if (empty($positionid)) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '置顶位置id非法', 'error');
    }
    if (empty($type)) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '请选择置顶方式', 'error');
    }
    if (empty($total)) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '请输入数量', 'error');
    }
    $position = pdo_get('superman_hand2_pay_position', array(
        'id' => $positionid,
    ));
    $fields = $position['fields']?iunserializer($position['fields']):array();
    if (empty($fields)) {
        SupermanHandUtil::json(SupermanHandErrno::POSITION_NOT_EXIST);
    }
    foreach ($fields as $f) {
        if ($f['type'] == $type) {
            $type_price = $f['price'];
            $all_price = SupermanHandUtil::float_format($total * $f['price']);
            break;
        }
    }

    //检查待支付记录
    $log = pdo_get('superman_hand2_position_order_log', array(
        'uniacid' => $_W['uniacid'],
        'itemid' => $itemid,
        'status' => 0,
    ));
    if ($log) {
        pdo_delete('superman_hand2_position_order_log', array('id' => $log['id']));
    }

    //支付记录
    $data = array(
        'uniacid' => $_W['uniacid'],
        'itemid' => $itemid,
        'uid' => $_W['member']['uid'],
        'positionid' => $positionid,
        'paytype' => 2,
        'type' => $type,
        'total' => $total,
        'price' => $type_price,
        'all_price' => $all_price,
        'createtime' => TIMESTAMP,
    );
    pdo_insert('superman_hand2_position_order_log', $data);
    $new_id = pdo_insertid();

    //微信支付
    $params = array(
        'tid' => 'superman_hand2:'.$new_id,
        'user' => $_W['openid'],
        'fee' => $all_price,
        'title' => '出售'.$position['title'].'广告'.$total.format_time_type($type),
        'appid' => $_W['account']['key'],
    );
    $result = SupermanHandUtil::superman_wxpay_build($params, $this->module);
    if (is_error($result)) {
        WeUtility::logging('fatal', '[pay_item.inc.php:pay], result='.var_export($result, true));
        SupermanHandUtil::json(-1, '支付失败，请重试');
    }
    $result['top_audit'] = $this->module['config']['base']['top_audit']?1:0;
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'log') {
    $itemid = intval($_GPC['itemid']);
    if (empty($itemid)) {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR);
    }
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $orderby = 'createtime DESC';
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'itemid' => $itemid,
        'status !=' => 0,
    );
    $list = pdo_getall('superman_hand2_position_order_log', $filter, '', '', $orderby, array($pindex, $pagesize));
    if ($list) {
        foreach ($list as &$li) {
            if ($li['audittime']) {
                $expiretime = SupermanHandUtil::pay_item_expiretime($li['total'], $li['audittime']);
                if ($expiretime < TIMESTAMP) {
                    $li['audit'] = -2;  //已过期
                }
                $li['audittime'] = date('Y-m-d H:i:s', $li['audittime']);
                $li['expiretime'] = date('Y-m-d H:i:s', $expiretime);
            }
            $li['type'] = format_time_type($li['type']);
            $li['paytime'] = $li['paytime'] ? date('Y-m-d H:i:s', $li['paytime']) : 0;
            $li['pay_position'] = pdo_get('superman_hand2_pay_position', array('id' => $li['positionid']), array('title'));
        }
        unset($li);
    }
}
include $this->template('pay_top/'.$act);
function format_time_type($type) {
    switch ($type) {
        case 'year':
            return '年';
            break;
        case 'month':
            return '月';
            break;
        case 'day':
            return '天';
            break;
        default:
            return '小时';
            break;
    }
}
