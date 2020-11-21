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
    'refund',
    'comment_list', // 评价列表
    'express_info' // 物流信息
))?$_GPC['act']:'display';
if ($act == 'display') {
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $orderby = 'createtime DESC';
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'status !=' => -2,
    );
    if ($_GPC['type'] == 'sell') {
        $filter['seller_uid'] = $_W['member']['uid'];
    } else {
        $filter['buyer_uid'] = $_W['member']['uid'];
    }
    $list = pdo_getall('superman_hand2_order', $filter, '', '', $orderby, array($pindex, $pagesize));
    if (!empty($list)) {
        foreach ($list as &$li) {
            $li['_status_title'] = SupermanHandUtil::order_status_title($li['status']);
            $item = pdo_get('superman_hand2_item', array(
                'uniacid' => $_W['uniacid'],
                'id' => $li['itemid'],
            ));
            SupermanHandModel::superman_hand2_item($item);
            $li['description'] = $item['description'];
            $li['cover'] = $item['cover'];
            $li['title'] = $item['title'];
            $li['unit'] = $item['unit'] == 0?'元':$item['unit_title'];
            $li['trade_type'] = $item['trade_type'];
            $li['fetch_address'] = $item['fetch_address'];
        }
        unset($li);
    }
    $result = array(
        'list' => $list
    );
    // 是否显示查看物流按钮
    $express_userid = $this->module['config']['base']['express_userid'];
    $express_apikey = $this->module['config']['base']['express_apikey'];
    $result['show_express'] = $express_userid && $express_apikey ? 1 : 0;
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
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
    $item = pdo_get('superman_hand2_item', array(
        'uniacid' => $_W['uniacid'],
        'id' => $order['itemid'],
    ));
    $data = array(
        'status' => $status,
        'reason' => $_GPC['reason'],
    );
    if ($status == 2) {
        $data['sell_formid'] = $_GPC['formId'];
        $data['sendtime'] = TIMESTAMP;
        $data['express_company'] = $_GPC['express_company'];
        $data['express_no'] = $_GPC['express_no'];
        //统计日成交量
        SupermanHandUtil::stat_day_item_trade();
        //发送模板消息
        $res = SupermanHandUtil::get_uid_formid($order['buyer_uid']);
        $openid = SupermanHandUtil::uid2openid($order['buyer_uid']);
        $url = 'pages/my_order/index?type=buy';
        if ($res['formid']) {
            $tpl_id = $this->module['config']['minipg']['send']['tmpl_id'];
            $message_data = array(
                'keyword1' => array(
                    'value' => $item['title'],
                ),
                'keyword2' => array(
                    'value' => '已发货',
                ),
            );
            $ret = SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
            if ($ret) {
                SupermanHandUtil::delete_uid_formid($res['id']);
            }
        } else {
            $uni_tpl_id = $this->module['config']['tmpl']['send']['tmpl_id'];
            $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
            if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                $user = mc_fetch($_W['member']['uid'], array('nickname'));
                $message_data = array(
                    'first' => array(
                        'value' => '您购买的以下物品已发货',
                        'color' => '#173177'
                    ),
                    'keyword1' => array(
                        'value' => $order['ordersn'],
                    ),
                    'keyword2' => array(
                        'value' => date('Y-m-d H:i:s', $order['createtime']),
                    ),
                    'keyword3' => array(
                        'value' => $item['price'] > 0 ? $item['price'].'元' : $item['credit'].'积分',
                    ),
                    'keyword4' => array(
                        'value' => $item['title'],
                    ),
                    'remark' => array(
                        'value' => '查看更多订单信息，请点击下方【详情】',
                        'color' => '#173177'
                    ),
                );
                SupermanHandUtil::send_uniform_msg($message_data, $openid, $uni_tpl_id, $gzh_appid, $url);
            }
        }
    }
    //确认收货积分逻辑
    if ($status == 3) {
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
            $ret2 = mc_credit_update($order['buyer_uid'], 'credit1', -$order['credit'], $credit_log);
            if (is_error($ret2)) {
                WeUtility::logging('fatal', '[[order.inc.php: post] update buyer_uid credit fail], ret1='.var_export($ret2, true));
                SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '扣除积分失败', 'error');
            }
            //删除冻结积分
            pdo_delete('superman_hand2_member_block_credit', array(
                'uniacid' => $_W['uniacid'],
                'uid' => $order['buyer_uid'],
                'itemid' => $order['itemid'],
            ));
        }
        //完成结算订单资金
        if ($order['price'] > 0) {
            $data['settlement_status'] = 1;
            $ret1 = pdo_update('superman_hand2_member', array(
                'balance +=' => $order['price'],
                'updatetime' => TIMESTAMP,
            ), array(
                'uniacid' => $_W['uniacid'],
                'uid' => $order['seller_uid']
            ));
            if ($ret1 === false) {
                WeUtility::logging('fatal', ' order.inc.php, order settlement failed, ret1='.var_export($ret1, true).', order='.var_export($order, true));
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
        //发送模板消息
        $res = SupermanHandUtil::get_uid_formid($item['seller_uid']);
        $openid = SupermanHandUtil::uid2openid($item['seller_uid']);
        $url = 'pages/my_order/index?type=sell';
        if ($res['formid']) {
            $tpl_id = $this->module['config']['minipg']['receiver']['tmpl_id'];
            $text = $order['paytype'] == 2?$item['price'].'元':$item['credit'].'积分';
            $message_data = array(
                'keyword1' => array(
                    'value' => $item['title'],
                ),
                'keyword2' => array(
                    'value' => '已收货',
                ),
                'keyword3' => array(
                    'value' => '卖出物品获得'.$text,
                ),
            );
            $ret = SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
            if ($ret) {
                SupermanHandUtil::delete_uid_formid($res['id']);
            }
        } else {
            $uni_tpl_id = $this->module['config']['tmpl']['receiver']['tmpl_id'];
            $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
            if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                $message_data = array(
                    'first' => array(
                        'value' => '您的以下订单已确认收货',
                        'color' => '#173177'
                    ),
                    'keyword1' => array(
                        'value' => $order['ordersn'],
                    ),
                    'keyword2' => array(
                        'value' => $item['title'],
                    ),
                    'keyword3' => array(
                        'value' => date('Y-m-d H:i:s', $order['createtime']),
                    ),
                    'keyword4' => array(
                        'value' => date('Y-m-d H:i:s', $order['sendtime']),
                    ),
                    'keyword5' => array(
                        'value' => date('Y-m-d H:i:s', TIMESTAMP),
                    ),
                    'remark' => array(
                        'value' => '查看更多订单信息，请点击下方【详情】',
                        'color' => '#173177'
                    ),
                );
                SupermanHandUtil::send_uniform_msg($message_data, $openid, $uni_tpl_id, $gzh_appid, $url);
            }
        }
    }
    //申请退款
    if ($status == -1) {
        //发送模板消息
        $res = SupermanHandUtil::get_uid_formid($item['seller_uid']);
        $openid = SupermanHandUtil::uid2openid($item['seller_uid']);
        $url = 'pages/my_order/index?type=sell';
        if ($res['formid']) {
            $tpl_id = $this->module['config']['minipg']['cancel']['tmpl_id'];
            $message_data = array(
                'keyword1' => array(
                    'value' => $item['title'],   //商品名称
                ),
                'keyword2' => array(
                    'value' => $_GPC['reason'],  //取消原因
                ),
                'keyword3' => array(
                    'value' => $_W['fans']['nickname'],   //买家昵称
                ),
            );
            $ret = SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
            if ($ret) {
                SupermanHandUtil::delete_uid_formid($res['id']);
            }
        } else {
            $uni_tpl_id = $this->module['config']['tmpl']['cancel']['tmpl_id'];
            $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
            if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                $message_data = array(
                    'first' => array(
                        'value' => '您的以下订单已被取消并申请退款',
                        'color' => '#173177'
                    ),
                    'keyword1' => array(
                        'value' => $order['ordersn'],
                    ),
                    'keyword2' => array(
                        'value' => $item['title'],
                    ),
                    'keyword3' => array(
                        'value' => $_GPC['reason'],
                    ),
                    'remark' => array(
                        'value' => '请确认信息后联系该用户具体退款事宜',
                        'color' => '#173177'
                    ),
                );
                SupermanHandUtil::send_uniform_msg($message_data, $openid, $uni_tpl_id, $gzh_appid, $url);
            }
        }
    }
    $ret = pdo_update('superman_hand2_order', $data, array('id' => $orderid));
    if ($ret === false) {
        SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '数据库更新失败', 'error');
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
} else if ($act == 'refund') {
    $orderid = intval($_GPC['orderid']);
    $order = pdo_get('superman_hand2_order', array('uniacid' => $_W['uniacid'], 'id' => $orderid,));
    if (!$order) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '订单不存在', 'error');
    }
    $item = pdo_get('superman_hand2_item', array(
        'uniacid' => $_W['uniacid'],
        'id' => $order['itemid'],
    ));
    if ($order['credit'] > 0) {
        pdo_delete('superman_hand2_member_block_credit', array(
            'uniacid' => $_W['uniacid'],
            'uid' => $order['buyer_uid'],
            'itemid' => $order['itemid'],
        ));
    } else if ($order['price'] > 0) {
        if ($order['payno'] == '') {
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '微信支付单号为空，无法进行退款操作');
        }
        $payment = $_W['account']['setting']['payment'];
        if (empty($_W['account']['key']) || empty($payment['wechat']['mchid'])) {
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '支付参数未配置, 请联系平台管理员');
        }
        if (empty($payment['wechat_refund']['cert']) || empty($payment['wechat_refund']['key'])) {
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '支付证书未配置, 请联系平台管理员');
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
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '退款失败，错误原因：'.$ret);
        }
    }
    $ret1 = pdo_update('superman_hand2_order', array('status' => -3), array('id' => $orderid));
    $ret2 = pdo_update('superman_hand2_item', array('status' => 1, 'stock +=' => $order['total'],), array('id' => $item['id']));
    if ($ret1 === false || $ret2 === false) {
        SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '数据库更新失败', 'error');
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
    $uid = intval($_GPC['uid']);
    if (!$uid) {
        SupermanHandUtil::json(SupermanHandErrno::DELETE_FAIL, '删除失败', 'error');
    }
    if ($uid == $order['seller_uid']) {
        pdo_update('superman_hand2_order', array(
            'delete_type' => 1,
        ), array(
            'id' => $orderid
        ));
    } else if ($uid == $order['buyer_uid']) {
        pdo_update('superman_hand2_order', array(
            'delete_type' => 2,
        ), array(
            'id' => $orderid
        ));
    } else {
        SupermanHandUtil::json(SupermanHandErrno::DELETE_FAIL, '删除失败', 'error');
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
} else if ($act == 'comment') {
    $orderid = intval($_GPC['orderid']);
    $level = intval($_GPC['level']);
    $content = $_GPC['content'];
    $order = pdo_get('superman_hand2_order', array(
        'uniacid' => $_W['uniacid'],
        'id' => $orderid,
    ));
    if (!$order) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '订单不存在', 'error');
    }
    $data = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
        'seller_uid' => $order['seller_uid'],
        'orderid' =>$orderid,
        'itemid' => $order['itemid'],
        'level' => $level,
        'message' => $content,
        'anonymous' => $GPC['anonymous'],
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
} else if ($act == 'comment_list') {
    $uid = $_GPC['uid'];
    if (empty($uid)) {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR);
    }
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'seller_uid' => $uid
    );
    if (!empty($_GPC['level'])) {
        $filter['level'] = $_GPC['level'];
    }
    $list = pdo_getall('superman_hand2_grade', $filter, '', '', 'dateline DESC');
    if ($list) {
        foreach ($list as &$row) {
            if ($row['uid'] > 0) {
                $user = mc_fetch($row['uid'], array('nickname', 'avatar'));
                $row['nickname'] = $user['nickname'];
                $row['avatar'] = $user['avatar'];
            }
            $row['createtime'] = $row['dateline']?date('Y-m-d H:i:s', $row['dateline']):'';
        }
        unset($row);
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $list);
} else if ($act == 'express_info') {
    $orderid = intval($_GPC['orderid']);
    $order = pdo_get('superman_hand2_order', array(
        'uniacid' => $_W['uniacid'],
        'id' => $orderid,
    ));
    if (!$order) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '订单不存在', 'error');
    }
    $express_userid = $this->module['config']['base']['express_userid'];
    $express_apikey = $this->module['config']['base']['express_apikey'];
    if (!$express_userid && !$express_apikey) {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '未设置物流查询参数，请联系管理员设置', 'error');
    }
    $express = new SupermanHandExpress($express_userid, $express_apikey, $order['express_company'], $order['express_no']);
    $info = $express->query();
    $express_info = $info ? $info : array();
    $express_info['order'] = array(
        'ordersn' => $order['ordersn'],
        'express_company' => $order['express_company'],
        'express_no' => $order['express_no'],
    );
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $express_info);
}
