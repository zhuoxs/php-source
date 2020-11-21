<?php
/**
 * 【超人】模块定义
 *
 * @author 超人
 * @url https://s.we7.cc/index.php?c=home&a=author&do=index&uid=59968
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$act = in_array($_GPC['act'], array(
    'display',
    'getcash',      //申请提现
    'getcash_log',  //提现记录
    'money_log',    //明细记录
))?$_GPC['act']:'display';
if ($act == 'display') {
    $balance = pdo_get('superman_hand2_member', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid']
    ), array('balance'));
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $balance);
} else if ($act == 'getcash') {
    $getcash = $this->module['config']['getcash'];
    $result = array(
        'getcash' => $getcash,
    );
    $result['member_info'] = pdo_get('superman_hand2_member', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid']
    ));

    ///未设置提现账户时初始化
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid']
    );
    $getcash_user = pdo_get('superman_hand2_member_getcash_user', $filter);
    if (empty($getcash_user)) {
        $getcash_user = array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid'],
            'openid' => SupermanHandUtil::uid2openid($_W['member']['uid']),  
            'createtime' => TIMESTAMP,
        );
        pdo_insert('superman_hand2_member_getcash_user', $getcash_user);
        $getcash_user['id'] = pdo_insertid();
    }
    if ($_GPC['submit']) {
        //检查提现方式
        $account_type = $_GPC['account_type'];
        switch ($account_type) {
            case '微信':
                $account_type = 'wechat';break;
            case '银行卡':
                $account_type = 'bank';break;
            case '支付宝':
                $account_type = 'alipay';break;
            default:
                $account_type = 'unknown';break;
        }
        if (!in_array($account_type, array('wechat', 'alipay', 'bank'))) {
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '提现方式非法请求');
        }

        //检查金额
        $money = floatval($_GPC['money']);
        if ($money > $result['member_info']['balance']) {
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '提现金额高于可提现的余额，无法提现');
        }
        if ($money < $getcash['limit']) {
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '提现金额低于最低提现金额，无法提现');
        }
        if ($money <= $getcash['fee_min']) {
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '提现金额低于最低服务费'.$getcash['fee_min'].'，无法提现');
        }

        //服务费计算
        $service_fee = SupermanHandUtil::float_format($money * ($getcash['fee_rate']/100));
        if ($service_fee < $getcash['fee_min']) {
            $service_fee = $getcash['fee_min'];
        } else if ($getcash['fee_max'] > 0 && $service_fee > $getcash['fee_max']) {
            $service_fee = $getcash['fee_max'];
        }
        if ($money <= $service_fee) {
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '提现金额低于服务费，无法提现');
        }

        //获取提现账号数据
        if ($account_type == 'wechat') {
            if ($getcash_user['openid'] == '') {
                SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '本团长不能使用微信提现');
            }
            $account = array(
                'openid' => $getcash_user['openid']
            );
        } else if ($account_type == 'alipay') {
            $alipay_account = $_GPC['alipay_account'];
            $alipay_username = $_GPC['alipay_username'];
            if ($alipay_account == '' || $alipay_username == '') {
                SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '提现账户中支付宝信息未设置完全');
            }
            $account = array(
                'alipay_account' => $alipay_account,
                'alipay_username' => $alipay_username
            );
        } else {
            $bank_name = $_GPC['bank_name'];
            $bank_account = $_GPC['bank_account'];
            $bank_cardno = $_GPC['bank_cardno'];
            $bank_username = $_GPC['bank_username'];
            if ($bank_name == '' || $bank_account == '' || $bank_cardno == '' || $bank_username == '') {
                SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '提现账户中银行信息未设置完全');
            }
            $account = array(
                'bank_name' => $bank_name,
                'bank_account' => $bank_account,
                'bank_cardno' => $bank_cardno,
                'bank_username' => $bank_username
            );
        }
        pdo_update('superman_tuan_member_getcash_user', $account, array('id' => $getcash_user['id']));

        //保存提现数据
        pdo_begin();
        $ret1 = pdo_update('superman_hand2_member', array(
            'balance -=' => $money,
        ), array('id' => $result['member_info']['id']));
        pdo_insert('superman_hand2_member_getcash_log', array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid'],
            'account_type' => $account_type,
            'account' => $account ? iserializer($account) : '',
            'apply_remark' => $_GPC['apply_remark'],
            'createtime' => TIMESTAMP,
            'money' => $money,
            'fee_rate' => $getcash['fee_rate'],
            'fee_min' => $getcash['fee_min'],
            'fee_max' => $getcash['fee_max'],
            'service_fee' => $service_fee
        ));
        $ret2 = pdo_insertid();
        $member = mc_fetch($_W['member']['uid'], array('nickname'));
        pdo_insert('superman_hand2_member_money_log', array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid'],
            'type' => 2,
            'money' => $money,
            'operator' => $member['nickname'],
            'remark' => '申请提现操作:getcash_logid='.$ret2,
            'createtime' => TIMESTAMP
        ));
        $ret3 = pdo_insertid();
        if ($ret1 !== false && $ret2 > 0 && $ret3 > 0) {
            pdo_commit();
            SupermanHandUtil::json(SupermanHandErrno::OK);
        } else {
            pdo_rollback();
            SupermanHandUtil::json(SupermanHandErrno::INSERT_FAIL);
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'getcash_log') {
    $result = array();
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $limit = 'LIMIT '.($pindex-1)* $psize.','.$psize;
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
    );
    $result['log'] = pdo_getall('superman_hand2_member_getcash_log', $filter, '', '', '', $limit);
    if (!empty($result['log'])) {
        foreach ($result['log'] as &$log) {
            $log['status_title'] = SupermanHandUtil::get_getcash_status_title($log['status']);
            $log['createtime'] = date('Y-m-d H:i:s', $log['createtime']);
        }
        unset($log);
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'money_log') {
    $result = array();
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $limit = 'LIMIT '.($pindex-1)* $psize.','.$psize;
    $orderby = 'createtime DESC, id DESC';
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid']
    );
    $result['log'] = pdo_getall('superman_hand2_member_money_log', $filter, '', '', $orderby, $limit);
    if (!empty($result['log'])) {
        foreach ($result['log'] as &$log) {
            $log['createtime'] = date('Y-m-d H:i:s', $log['createtime']);
        }
        unset($log);
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
}
