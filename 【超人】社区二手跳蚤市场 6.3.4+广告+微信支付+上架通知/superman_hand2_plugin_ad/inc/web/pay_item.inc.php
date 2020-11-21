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
    'delete',
    'audit',  //审核
))?$_GPC['act']:'display';
$title = '付费物品';
if ($act == 'display') {
    $nickname = trim($_GPC['nickname']);
    $item_title = trim($_GPC['item_title']);
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $start = ($pindex - 1) * $pagesize;
    $params = array(
        'uniacid' => $_W['uniacid'],
    );
    if (!empty($item_title)) {
        $items = pdo_getall('superman_hand2_item', array(
            'uniacid' => $_W['uniacid'],
            'title LIKE' => "%{$item_title}%"
        ), array('id'));
        if (!empty($items)) {
            $arr = array();
            foreach ($items as $li) {
                $arr[] = $li['id'];
            }
            $params['itemid'] = $arr;
        } else {
            $params['itemid'] = 0;
        }
    }
    if (!empty($nickname)) {
        $users = pdo_getall('mc_members', array(
            'uniacid' => $_W['uniacid'],
            'nickname LIKE' => "%{$nickname}%"
        ), array('uid'));
        if (!empty($users)) {
            $arr = array();
            foreach ($users as $li) {
                $arr[] = $li['uid'];
            }
            $params['uid'] = implode(',', $arr);
        } else {
            $params['uid'] = 0;
        }
    }
    $total = pdo_getcolumn('superman_hand2_position_order_log', $params, 'COUNT(*)');
    if ($total) {
        $orderby = 'paytime DESC';
        $list = pdo_getall('superman_hand2_position_order_log', $params, '*', '', $orderby, array($pindex, $pagesize));
        if ($list) {
            foreach ($list as &$li) {
                $li['item'] = pdo_get('superman_hand2_item', array(
                    'id' => $li['itemid'],
                ), array('title'));
                $li['set_top_fields'] = unserialize($li['set_top_fields']);
                $li['member'] = pdo_get('mc_members', array(
                    'uid' => $li['uid'],
                ), array('nickname'));
            }
            unset($li);
        }
        $pager = pagination($total, $pindex, $pagesize);
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    $item_top = pdo_get('superman_hand2_position_order_log', array('id' => $id));
    if (empty($item_top)) {
        itoast('置顶记录不存在！', '', 'error');
    }
    pdo_update('superman_hand2_item', array(
        'pay_position' => 0,
        'set_top_fields' => NULL,
    ), array('id' => $item_top['itemid']));
    pdo_delete('superman_hand2_position_order_log', array('id' => $id));
    itoast('删除成功！', '', 'success');
} else if ($act == 'audit') {
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status']);
    $order_log = pdo_get('superman_hand2_position_order_log', array(
        'id' => $id,
    ));
    $item = pdo_get('superman_hand2_item',array(
        'id' => $order_log['itemid']
    ));
    if ($status == 1) {
        //设置物品排序
        pdo_begin();
        //付费物品位置设置
        $ret1 = pdo_update('superman_hand2_item', array(
            'pay_position' => 1,
            'set_top_fields' => $order_log['set_top_fields']
        ), array(
            'id' => $order_log['itemid']
        ));
        //付费订单通过
        $top_data = array(
            'expiretime' => pay_item_expiretime($order_log['total']),
            'audit' => 1,
            'audittime' => TIMESTAMP,
        );
        $ret2 = pdo_update('superman_hand2_position_order_log', $top_data, array(
            'id' => $id
        ));
        if ($ret1 === false || $ret2 === false){
            itoast('审核失败, 失败原因：数据库更新失败', '', 'error');
        }
        pdo_commit();
        //发送模板消息
        $openid = SupermanHand2PluginAdUtil::uid2openid($order_log['uid']);
        $tpl_id = $this->module['config']['minipg']['pay_top']['tmpl_id'];
        $url = 'pages/home/index';
        $message_data = array(
            'keyword1' => array(
                'value' => '置顶物品:'.$item['title'],   //置顶内容
            ),
            'keyword2' => array(
                'value' => '已置顶',   //置顶状态
            ),
            'keyword3' => array(
                'value' => '置顶过期时间'.date('Y-m-d H:i:s', $top_data['expiretime']),   //置顶详情
            ),
        );
        SupermanHand2PluginAdUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $order_log['prepay_id']);
    } else {
        //付费物品退款
        if (!in_array($order_log['paytype'], array(2))) {
            itoast('审核失败, 错误原因：非微信支付订单，无法返回到微信钱包', referer(), 'error');
        }
        if ($order_log['payno'] == '') {
            itoast('审核失败, 错误原因：微信支付单号为空，无法进行退款操作', referer(), 'error');
        }
        $payment = $_W['account']['setting']['payment'];
        if (empty($_W['account']['key'])
            || empty($payment['wechat']['mchid'])) {
            itoast('审核失败, 错误原因：支付参数未配置', url('wxapp/payment'), 'error');
        }
        if (empty($payment['wechat_refund']['cert'])
            || empty($payment['wechat_refund']['key'])) {
            itoast('审核失败, 错误原因：支付证书未配置', url('wxapp/refund'), 'error');
        }
        $params = array(
            'appid' => $_W['account']['key'],
            'mch_id' => $payment['wechat']['mchid'],
            'nonce_str' => random(32),
            'transaction_id' => $order_log['payno'],
            'out_refund_no' => random(22, true),   //退款订单号
            'total_fee' => $order_log['all_price'],
            'refund_fee' => $order_log['all_price'],
            'op_user_id' => $payment['wechat']['mchid'],
        );
        $extra = array();
        $extra['sign_key'] = $payment['wechat']['signkey'];
        $ret = SupermanHand2PluginAdUtil::order_refund($params, $extra);
        if (!is_array($ret) || !isset($ret['success'])) {
            itoast('审核失败，错误原因：'.var_export($ret, true), referer(), 'error');
        }
        pdo_update('superman_hand2_position_order_log', array(
            'status' => -1,
            'audit' => -1,
            'refund_no' => $params['out_refund_no'],
            'extend' => is_array($ret) ? iserializer($ret): '',
        ), array(
            'id' => $order_log['id']
        ));
        //发送模板消息
        $openid = SupermanHand2PluginAdUtil::uid2openid($order_log['uid']);
        $tpl_id = $this->module['config']['minipg']['exchange_fail']['tmpl_id'];
        $url = 'pages/home/index';
        $message_data = array(
            'keyword1' => array(
                'value' => '您付费置顶物品:'.$item['title'].'已被平台拒绝，请换个物品置顶吧',   //温馨提示
            ),
            'keyword2' => array(
                'value' => $order_log['all_price'],   //交易金额
            ),
        );
        SupermanHand2PluginAdUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $order_log['prepay_id']);
    }
    itoast('审核成功！', '', 'success');
}
//物品过期时间
function pay_item_expiretime($num) {
    if ($num > 1) {
        return strtotime("+{$num} day");
    } else {
        $hour = ceil($num * 24);
        return strtotime("+{$hour} hour");
    }
}
include $this->template('web/pay_item/index');
