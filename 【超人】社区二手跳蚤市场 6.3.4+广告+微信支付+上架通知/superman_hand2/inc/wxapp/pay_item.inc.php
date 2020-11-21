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
    'apply',   //付费申请页
    'pay',     //付费提交
    'log',     //付费置顶物品记录
))?$_GPC['act']:'display';
if ($act == 'display') {
    //todo
} else if ($act == 'apply') {
    //可付费广告位置
    $params = array(
        'uniacid' => $_W['uniacid'],
        'status' => 1,
    );
    $list = pdo_getall('superman_hand2_pay_position', $params, '*', '', 'displayorder DESC');
    if ($list) {
        foreach ($list as $k => &$li) {
            $li['area'] = explode(',', $li['area']);
            $li['district'] = $li['area'][2];
            $li['fields'] = $li['fields']?iunserializer($li['fields']):array();
        }
        unset($li);
    }
    $result = array(
        'list' => $list,
        'rule' => $this->module['config']['set_top']['rule'] ? htmlspecialchars_decode($this->module['config']['set_top']['rule']) : ''
    );
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'pay') {
    $itemid = intval($_GPC['itemid']);
    $fields = base64_decode($_GPC['fields']);
    $top_fields = json_decode(urldecode($fields), true);
    $total = floatval($_GPC['total']);
    $paytype = $_GPC['paytype'];
    $money = floatval($_GPC['money']);
    $credit = floatval($_GPC['credit']);
    if (empty($itemid)) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '物品id非法', 'error');
    }
    if (empty($total)) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '请输入数量', 'error');
    }
    if ($paytype == 1) {
        $sql = 'SELECT SUM(credit) AS credit FROM '.tablename('superman_hand2_member_block_credit').'WHERE uniacid=:uniacid AND uid=:uid';
        $params = array(
            ':uniacid' => $_W['uniacid'],
            ':uid' => $_W['member']['uid']
        );
        $block_credit = pdo_fetch($sql, $params);
        $credit1 = $_W['member']['credit1'] - $block_credit['credit'];
        if ($credit > $credit1) {
            SupermanHandUtil::json(SupermanHandErrno::CREDIT_NOT_ENOUGH);
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
        'set_top_fields' => iserializer($top_fields),
        'paytype' => $paytype,
        'type' => 'day',
        'total' => $total,
        'all_price' => $paytype == 1 ? $credit : $money,
        'createtime' => TIMESTAMP,
    );
    pdo_insert('superman_hand2_position_order_log', $data);
    $new_id = pdo_insertid();

    if ($paytype == 1) {  //积分兑换
        $credit_log = array(
            $_W['member']['uid'],
            '购买物品置顶',
            'superman_hand2',
        );
        $ret = mc_credit_update($_W['member']['uid'], 'credit1', '-'.$credit, $credit_log);
        if (is_error($ret)) {
            WeUtility::logging('fatal', '[pay_item.inc.php: mc_credit_update], ret=' . var_export($ret, true));
            return false;
        }
        $result = array(
            'top_audit' => $this->module['config']['base']['top_audit'] ? 1 : 0
        );
        if ($result['top_audit'] == 0) {
            pdo_begin();
            //付费物品位置设置
            $ret1 = pdo_update('superman_hand2_item', array(
                'pay_position' => 1,
                'set_top_fields' => iserializer($top_fields)
            ), array(
                'id' => $itemid
            ));
            //付费订单通过
            $ret2 = pdo_update('superman_hand2_position_order_log', array(
                'audit' => 1,
                'status' => 1,
                'audittime' => TIMESTAMP,
                'paytime' => TIMESTAMP,
                'expiretime' => pay_item_expiretime($total),
            ), array(
                'id' => $new_id
            ));
            if ($ret1 === false || $ret2 === false){
                SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL);
            }
            pdo_commit();
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
    } else {
        //微信支付
        $params = array(
            'tid' => 'superman_hand2:' . $new_id,
            'user' => $_W['openid'],
            'fee' => $money,
            'title' => '出售物品置顶广告' . $total . '天',
        );
        $result = $this->pay($params);
        if (is_error($result)) {
            WeUtility::logging('fatal', '[pay_item.inc.php:pay], result=' . var_export($result, true));
            SupermanHandUtil::json(-1, '支付失败，请重试');
        }
        //发送模板消息需要prepay_id参数
        $prepay_id = str_replace('prepay_id=', '', $result['package']);
        pdo_update('superman_hand2_position_order_log', array(
            'prepay_id' => $prepay_id,
        ), array('id' => $new_id));
        $result['top_audit'] = $this->module['config']['base']['top_audit'] ? 1 : 0;
        SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
    }
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
                $li['audittime'] = date('Y-m-d H:i:s', $li['audittime']);
                $li['expiretime'] = date('Y-m-d H:i:s', $li['expiretime']);
            }
            $li['type'] = format_time_type($li['type']);
            $li['paytime'] = $li['paytime'] ? date('Y-m-d H:i:s', $li['paytime']) : 0;
            $li['set_top_fields'] = unserialize($li['set_top_fields']);
        }
        unset($li);
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $list);
}

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
function pay_item_expiretime($num) {
    if ($num > 1) {
        return strtotime("+{$num} day");
    } else {
        $hour = ceil($num * 24);
        return strtotime("+{$hour} hour");
    }
}