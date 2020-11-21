<?php
/**
 * 【超人】超级商城模块定义
 *
 * @author 超人
 * @url http://bbs.we7.cc/thread-13060-1-1.html
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = $_GPC['do'];
$act = in_array($_GPC['act'], array(
    'display',    //提现申请列表
    'post',       //提现申请编辑
    'delete',     //提现申请删除
    'balance',    //团长钱包
    'money_log',  //流水明细
))?$_GPC['act']:'display';
$title = '财务管理';
if ($act == 'display') {
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    $nickname = trim($_GPC['nickname']);
    $status = in_array($_GPC['status'], array( '-1', '0', '1', 'all'))?$_GPC['status']:'all';
    $account_type = in_array($_GPC['account_type'], array( 'wechat', 'alipay', 'bank', 'all'))?$_GPC['account_type']:'all';
    if ($status != 'all') {
        $filter['status'] = $status;
    }
    if ($account_type != 'all') {
        $filter['account_type'] = $account_type;
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
            $filter['uid'] = implode(',', $arr);
        } else {
            $filter['uid'] = 0;
        }
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $orderby = 'createtime DESC, id DESC';
    $limit = 'LIMIT '.($pindex-1)* $psize.','.$psize;
    $total = pdo_getcolumn('superman_hand2_member_getcash_log', $filter, 'COUNT(*)');
    if ($total) {
        $list = pdo_getall('superman_hand2_member_getcash_log', $filter, '', '', $orderby, $limit);
        if (!empty($list)) {
            foreach ($list as &$li) {
                $li['member'] = mc_fetch($li['uid'], array('avatar', 'nickname'));
            }
            unset($li);
        }
        $pager = pagination($total, $pindex, $psize);
    }
} else if ($act == 'post') {
    $id = intval($_GPC['id']);
    if ($id <= 0) {
        message('非法访问', referer(), 'error');
    }
    $row = pdo_get('superman_hand2_member_getcash_log', array('id' => $id));
    if (!$row) {
        message('此申请不存在或已删除', referer(), 'error');
    }
    $row['account'] = $row['account']?iunserializer($row['account']):array();
    $member = mc_fetch($row['uid'], array('nickname'));
    if ($row['account_type'] == 'wechat' && $row['account']['openid']) {
        $row['member'] = mc_fetch($row['account']['openid'], array('nickname', 'avatar'));
    }
    if (checksubmit()) {
        $remark = $_GPC['remark'];
        $status = $_GPC['status'];
        if ($row['status'] == 1) {
            itoast('已经支付，不需要重复提交', referer(), 'error');
        }
        if ($status == -1 && $row['status'] != -1) {
            pdo_begin();
            $info = '提现失败，退回未提现的余额:getcash_logid='.$row['id'];
            $res = return_getcash_money($row, $info);
            if ($res[0] === false || empty($res[1])) {
                pdo_rollback();
                itoast('数据库更新出错，请稍候再试！', referer(), 'error');
            }
            pdo_commit();
            $formid = SupermanHand2PluginWechatUtil::get_uid_formid($log['uid']);
            if ($formid['formid']) {
                $openid = SupermanHand2PluginWechatUtil::uid2openid($log['uid']);
                $member = mc_fetch($log['uid'], array('nickname'));
                $tpl_id = $this->module['config']['minipg']['getcash_fail']['tmpl_id'];
                $url = 'pages/my/index';
                $message_data = array(
                    'keyword1' => array(
                        'value' => '您的二手市场提现订单已被取消，请重新提交审核',  //温馨提示
                    ),
                    'keyword2' => array(
                        'value' => SupermanHand2PluginWechatUtil::get_getcash_account_type_title($log['account_type']),  //提现账号
                    ),
                    'keyword3' => array(
                        'value' => $log['money'],  //提现金额
                    ),
                    'keyword4' => array(
                        'value' => $remark,    //原因
                    ),
                );
                $ret = SupermanHand2PluginWechatUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
                if ($ret) {
                    SupermanHand2PluginWechatUtil::delete_uid_formid($res['id']);
                }
            }
        }
        $data = array(
            'remark' => $remark,
            'status' => $status,
            'paytime' => $_GPC['paytime']?$_GPC['paytime']:TIMESTAMP,
            'operator' => $_W['account']['setmeal']['username'],
            'updatetime' => TIMESTAMP,
        );
        $ret = pdo_update('superman_hand2_member_getcash_log', $data, array('id' => $id));
        if ($ret !== false) {
            $url = $_W['siteroot'].'web/'.$this->createWebUrl('finance').'&version_id='.$_GPC['version_id'];
            itoast('操作成功！', $url, 'success');
        } else {
            itoast('数据库出错，请稍候再试', referer(), 'error');
        }
    }

    //微信付款
    if (checksubmit('wxpay_submit')) {
        if ($row['status'] != 0) {
           message('支付状态错误', referer(), 'error');
        }
        if ($row['account_type'] != 'wechat') {
           message('非法请求', referer(), 'error');
        }
        $row['account'] = iunserializer($row['account']);

        //读取微信支付配置
        $payment = $_W['account']['setting']['payment'];
        if (empty($_W['account']['key'])
            || empty($payment['wechat']['mchid'])) {
            if ($_W['account']['type'] == 4) {
                message('支付参数未配置', url('wxapp/payment'), 'error');
            } else {
                message('支付参数未配置', url('profile/payment'), 'error');
            }
        }
        if (empty($payment['wechat_refund']['cert'])
            || empty($payment['wechat_refund']['key'])) {
            if ($_W['account']['type'] == 4) {
                message('支付证书未配置', url('wxapp/refund'), 'error');
            } else {
                message('支付证书未配置', url('profile/refund'), 'error');
            }
        }
        $orderno = date('Ymd') . random(8, 1);
        $openid = $row['account']['openid'];
        $money = SupermanHand2PluginWechatUtil::float_format($row['money'] - $row['service_fee']);
        $params = array(
            'mch_appid' => $_W['account']['key'],
            'mchid' => $payment['wechat']['mchid'],
            'nonce_str' => random(32),
            'partner_trade_no' => $orderno,
            'openid' => $openid,
            'check_name' => 'NO_CHECK',
            're_user_name' => '',
            'amount' => $money,
            'desc' => '用户'.$member['nickname'].'钱包提现',
            'spbill_create_ip' => CLIENT_IP,
        );
        $extra = array();
        $extra['sign_key'] = $payment['wechat']['signkey'];
        $ret = SupermanHand2PluginWechatUtil::pay($params, $extra);
        if (is_array($ret) && isset($ret['success'])) {
            $data = array(
                'wxpay_result' => is_array($ret)?implode("\n", $ret):$ret,
                'wxpay_orderno' => $orderno,
                'wxpay_paymentno' => $ret['payment_no'],
                'operator' => $_W['user']['username'],
                'status' => 1,
                'paytime' => strtotime($ret['payment_time']),
                'remark' => $_GPC['remark'],
                'updatetime' => TIMESTAMP
            );
            $ret = pdo_update('superman_hand2_member_getcash_log', $data, array('id' => $id));
            if ($ret === false) {
                itoast('数据库更新出错，请稍候再试！', '', 'error');
            }
            $url = $_W['siteroot'].'web/'.$this->createWebUrl('finance').'&version_id='.$_GPC['version_id'];
            itoast('付款成功！', $url, 'success');
        } else {
            $data = array(
                'wxpay_result' => is_array($ret)?implode("\n", $ret):$ret,
                'operator' => $_W['user']['username'],
                'remark' => $_GPC['remark'],
                'status' => -1,
                'updatetime' => TIMESTAMP
            );
            pdo_begin();
            $ret = pdo_update('superman_hand2_member_getcash_log', $data, array('id' => $id));
            $info = '商户付款失败，退回未提现的余额:getcash_logid='.$row['id'];
            $res = return_getcash_money($row, $info);
            if ($ret === false || $res[0] === false || empty($res[1])) {
                pdo_rollback();
                itoast('付款失败，数据库更新出错，请稍候再试！', referer(), 'error');
            }
            pdo_commit();
            $formid = SupermanHand2PluginWechatUtil::get_uid_formid($log['uid']);
            if ($formid['formid']) {
                $openid = SupermanHand2PluginWechatUtil::uid2openid($log['uid']);
                $member = mc_fetch($log['uid'], array('nickname'));
                $tpl_id = $this->module['config']['minipg']['getcash_fail']['tmpl_id'];
                $url = 'pages/my/index';
                $message_data = array(
                    'keyword1' => array(
                        'value' => '您的二手市场提现订单已被取消，请重新提交审核',  //温馨提示
                    ),
                    'keyword2' => array(
                        'value' => SupermanHand2PluginWechatUtil::get_getcash_account_type_title($log['account_type']),  //提现账号
                    ),
                    'keyword3' => array(
                        'value' => $log['money'],  //提现金额
                    ),
                    'keyword4' => array(
                        'value' => '商户付款失败',    //原因
                    ),
                );
                $ret = SupermanHand2PluginWechatUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
                if ($ret) {
                    SupermanHand2PluginWechatUtil::delete_uid_formid($res['id']);
                }
            }
            itoast('付款失败，请查看微信付款结果信息, 提现金额已回退', referer(), 'error');
        }
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if ($id <= 0) {
        itoast('非法访问', referer(), 'error');
    }
    $log = pdo_get('superman_hand2_member_getcash_log', array('id' => $id));
    if (!$log) {
        itoast('该提现申请不存在或已删除', referer(), 'error');
    }
    pdo_begin();
    if ($log['status'] == 0) {  //未提现成功
        $info = '删除未提现的记录，退回未提现的余额:getcash_logid='.$log['id'];
        $res = return_getcash_money($log, $info);
        $ret1 = $res[0];
        $ret2 = $res[1];
    } else {
        $ret1 = $ret2 = 1;
    }
    $ret3 = pdo_delete('superman_hand2_member_getcash_log', array('id' => $id));
    if ($ret1 !== false && $ret2 > 0 && $ret3 !== false) {
        pdo_commit();
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('finance').'&version_id='.$_GPC['version_id'];
        itoast('删除成功！', $url, 'success');
        //发送模板消息
        if ($log['status'] == 0) {
            $formid = SupermanHand2PluginWechatUtil::get_uid_formid($log['uid']);
            if ($formid['formid']) {
                $openid = SupermanHand2PluginWechatUtil::uid2openid($log['uid']);
                $member = mc_fetch($log['uid'], array('nickname'));
                $tpl_id = $this->module['config']['minipg']['getcash_fail']['tmpl_id'];
                $url = 'pages/my/index';
                $message_data = array(
                    'keyword1' => array(
                        'value' => '您的二手市场提现订单已被取消，请重新提交审核',  //温馨提示
                    ),
                    'keyword2' => array(
                        'value' => SupermanHand2PluginWechatUtil::get_getcash_account_type_title($log['account_type']),  //提现账号
                    ),
                    'keyword3' => array(
                        'value' => $log['money'],  //提现金额
                    ),
                    'keyword4' => array(
                        'value' => '提现订单已被取消',    //原因
                    ),
                );
                $ret = SupermanHand2PluginWechatUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
                if ($ret) {
                    SupermanHand2PluginWechatUtil::delete_uid_formid($res['id']);
                }
            }
        }
    } else {
        pdo_rollback();
        itoast('数据库出错，请稍候再试！', referer(), 'error');
    }

} else if ($act == 'balance') {
    $url = murl('module/manage-account/setting', array('m' => 'superman_hand2', 'version_id' => $_GPC['version_id']));
    $url .= '#setting_getcash';
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $orderby = 'updatetime DESC, id DESC';
    $limit = 'LIMIT '.($pindex-1)* $psize.','.$psize;
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    $nickname = trim($_GPC['nickname']);
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
            $filter['uid'] = implode(',', $arr);
        } else {
            $filter['uid'] = 0;
        }
    }
    $total = pdo_getcolumn('superman_hand2_member', $filter, 'COUNT(*)');
    $balance_total = 0;
    if ($total) {
        $list = pdo_getall('superman_hand2_member', $filter, '', '', $orderby, $limit);
        if (!empty($list)) {
            foreach ($list as &$li) {
                $balance_total += $li['balance'];
                $li['member'] = mc_fetch($li['uid'], array('avatar', 'nickname'));
            }
            unset($li);
        }
        $pager = pagination($total, $pindex, $psize);
    }
    $balance_total = SupermanHand2PluginWechatUtil::float_format($balance_total);
} else if ($act == 'money_log') {
    $uid = intval($_GPC['uid']);
    if (empty($uid)) {
        itoast('参数非法', referer(), 'error');
    }
    $member_info = pdo_get('superman_hand2_member', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $uid,
    ));
    if ($member_info) {
        $member = mc_fetch($member_info['uid'], array('avatar', 'nickname'));
    }
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $orderby = 'createtime DESC, id DESC';
    $limit = 'LIMIT '.($pindex-1)* $psize.','.$psize;
    $type = in_array($_GPC['type'], array(1, 2))?$_GPC['type']:'';
    $starttime = $_GPC['dateline']['start'] ? strtotime($_GPC['dateline']['start']) : strtotime('-1years');
    $endtime = $_GPC['dateline']['end'] ? strtotime($_GPC['dateline']['end']) : strtotime(date('Y-m-d 23:59:59'));
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $uid,
        'createtime >=' => $starttime,
        'createtime <=' => $endtime,
    );
    $sql = 'SELECT SUM(money) FROM '.tablename('superman_hand2_member_money_log');
    $sql .= ' WHERE uniacid='.$_W['uniacid'].' AND createtime>='."'".$starttime."'".' AND createtime<='."'".$endtime."'";
    if (!empty($type)) {
        $filter['type'] = $type;
        $sql .= 'AND type='.$type;
    }
    $total_amount = 0;
    $subtotal_amount = 0;
    $total = pdo_getcolumn('superman_hand2_member_money_log', $filter, 'COUNT(*)');
    if ($total) {
        $total_amount = pdo_fetchcolumn($sql);
        $list = pdo_getall('superman_hand2_member_money_log', $filter, '', '', $orderby, $limit);
        foreach ($list as $li) {
            if ($li['type'] == 1) {
                $subtotal_amount += $li['money'];
            } else if ($li['type'] == 2) {
                $subtotal_amount -= $li['money'];
            }
        }
        $pager = pagination($total, $pindex, $pagesize);
    }
    $total_amount = SupermanHand2PluginWechatUtil::float_format($total_amount);
    $subtotal_amount = SupermanHand2PluginWechatUtil::float_format($subtotal_amount);
}
//退款提现金额
function return_getcash_money($data, $remark) {
    global $_W;
    $ret1 = pdo_update('superman_hand2_member', array(
        'balance +=' => $data['money']
    ), array(
        'uniacid' => $_W['uniacid'],
        'uid' => $data['uid'],
    ));
    $ret2 = pdo_insert('superman_hand2_member_money_log', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $data['uid'],
        'type' => 1,
        'money' => $data['money'],
        'operator' => $_W['user']['username'],
        'remark' => $remark,
        'createtime' => TIMESTAMP
    ));
   return array($ret1, $ret2);
}
include $this->template('web/finance/index');