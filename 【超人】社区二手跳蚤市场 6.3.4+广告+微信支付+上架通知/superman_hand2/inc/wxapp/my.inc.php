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
    'item_list',
    'delete',
    'blacklist',   //黑名单
    'post_count',  //每日发布数量
    'init_chat', // 点赞收藏页面和他聊聊
    'check_action', // 点赞收藏已读
))?$_GPC['act']:'display';
if ($act == 'display') {
    $title = '个人中心';
    $my = array();
    //个人信息
    $member = mc_fetch_one($_W['member']['uid']);
    $my['nickname'] = $member['nickname'];
    $my['avatar'] = $member['avatar'];
    $my['uid'] = $member['uid'];
    //点赞和收藏数量
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'seller_uid' => $_W['member']['uid'],
        'status' => array(1, 2)
    );
    $list = pdo_getall('superman_hand2_item', $filter, array('id'));
    if (!empty($list)) {
        $ids = array();
        for ($i = 0; $i < count($list); $i++) {
            $ids[$i] = $list[$i]['id'];
        }
        $my['zan'] = pdo_getcolumn('superman_hand2_action', array(
            'uniacid' => $_W['uniacid'],
            'item_id' => $ids,
            'is_check' => 0,
            'type' => 1
        ), 'COUNT(*)');
    }
    $my['collect'] = pdo_getcolumn('superman_hand2_action', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
        'is_check' => 0,
        'type' => 2
    ), 'COUNT(*)');
    $my['wxapp'] = $this->module['config']['my']['wxapp'];
    if ($my['wxapp']) {
        foreach ($my['wxapp'] as &$li) {
            $li['img'] = tomedia($li['img']);
        }
        unset($li);
    }
    $sql = 'SELECT SUM(credit) AS credit FROM '.tablename('superman_hand2_member_block_credit').'WHERE uniacid=:uniacid AND uid=:uid';
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':uid' => $_W['member']['uid']
    );
    $block_credit = pdo_fetch($sql, $params);
    if ($block_credit['credit'] > 0) {
        $block_arr = explode('.', $block_credit['credit']);
        if ($block_arr[1] == 0) {
            $block_credit['credit'] = $block_arr[0];
        }
    }
    $my['block_credit'] = $block_credit['credit']?$block_credit['credit']:0;  //冻结积分
    $my['credit1'] = $_W['member']['credit1'] - $block_credit['credit'];  //积分
    $my['uni_qrcode'] = $this->module['config']['base']['uni_qrcode']?tomedia($this->module['config']['base']['uni_qrcode']):'';
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'seller_uid' => $_W['member']['uid'],
        'status' => 1
    );
    $my['sell_count'] = pdo_getcolumn('superman_hand2_order', $filter ,'COUNT(*)');
    //微信支付插件
    if ($this->plugin_module['plugin_wechat']['module']
        && !$this->plugin_module['plugin_wechat']['module']['is_delete']) {
        $my['balance'] = pdo_get('superman_hand2_member', array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid']
        ), array('balance'));
    }
    //上架通知插件
    if ($this->plugin_module['plugin_notice']['module']
        && !$this->plugin_module['plugin_notice']['module']['is_delete']) {
        $notice_config = $this->plugin_module['plugin_notice']['module']['config'];
        $askItem = pdo_get('superman_hand2_ask_item', array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid'],
        ));
        $notice_config = $this->plugin_module['plugin_notice']['module']['config'];
        $my['plugin_notice'] = array(
            'switch' => $notice_config['base']['switch'] ? 1 : 0,
            'askid' => $askItem ? $askItem['id'] : 0,
        );
    }
    // 客服
    $my['service'] = $this->module['config']['base']['service']?$this->module['config']['base']['service']:0;
    $my['service_img'] = $this->module['config']['base']['service_img']?tomedia($this->module['config']['base']['service_img']):'';
    // 积分开关
    $my['credit_setting'] = $this->module['config']['credit']['open'];
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $my);
} else if ($act == 'item_list') {
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $orderby = 'createtime DESC';
    $action = $_GPC['action'];
    $result = array();
    if (!empty($action)) {
        if ($action == 1) {
            $filter = array(
                'uniacid' => $_W['uniacid'],
                'seller_uid' => $_W['member']['uid'],
                'status' => array(1, 2)
            );
            $id_list = pdo_getall('superman_hand2_item', $filter, array('id'));
            if (!empty($id_list)) {
                $ids = array();
                for ($i = 0; $i < count($id_list); $i++) {
                    $ids[$i] = $id_list[$i]['id'];
                }
                $list = pdo_getall('superman_hand2_action', array(
                    'uniacid' => $_W['uniacid'],
                    'item_id' => $ids,
                    'type' => 1
                ), '', '', $orderby);
            }
        } else {
            $list = pdo_getall('superman_hand2_action', array(
                'uniacid' => $_W['uniacid'],
                'uid' => $_W['member']['uid'],
                'type' => 2
            ), '', '', $orderby);
        }
        if (!empty($list)) {
            foreach ($list as &$li) {
                SupermanHandModel::superman_hand2_action($li);
            }
            unset($li);
        }
    }
    if ($_GPC['type']) {
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'seller_uid' => $_W['member']['uid'],
            'status !=' => -2
        );
        $list = pdo_getall('superman_hand2_item', $filter, '*', '', $orderby, array($pindex, $pagesize));
        if (!empty($list)) {
            foreach ($list as &$li) {
                SupermanHandModel::superman_hand2_item($li);
                if ($this->plugin_module['plugin_ad']['module'] && !$this->plugin_module['plugin_ad']['module']['is_delete']) {
                    $item_top = pdo_getall('superman_hand2_position_order_log', array(
                        'uniacid' => $_W['uniacid'],
                        'itemid' => $li['id'],
                    ));
                    if (!empty($item_top)) {
                        $li['item_top'] = $item_top;
                    }
                }
            }
            unset($li);
        }
    }
    $result = array (
        'item' => $list,
    );
    //广告插件
    if ($this->plugin_module['plugin_ad']['module'] && !$this->plugin_module['plugin_ad']['module']['is_delete']) {
        $result['pay_item'] = 1;
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'delete') {
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'id' => $_GPC['id']
    );
    $item = pdo_get('superman_hand2_item', $filter);
    if ($item['status'] == 1
        && $item['credit_tip'] == 1
        && $this->module['config']['credit']['open'] == 1) {
        $credit = $this->module['config']['credit']['category'][$item['cid']];
        $credit_log = array(
            $item['seller_uid'],
            '删除物品'.$item['title'],
            'superman_hand2',
        );
        $ret1 = mc_credit_update($item['seller_uid'], 'credit1', -$credit, $credit_log);
        if (is_error($ret1)) {
            WeUtility::logging('fatal', '[my.inc.php: delete, update seller_uid credit fail], ret1='.var_export($ret1, true));
        }
    }
    $ret2 = pdo_update('superman_hand2_item', array(
        'status' => -2,
        'pay_position' => 0,
    ), array('id' => $_GPC['id']));
    $ret3 = pdo_delete('superman_hand2_action', array('item_id' => $_GPC['id']));
    if ($ret2 === false || $ret3 === false) {
        SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '数据库更新失败', 'error');
    }
    if ($this->plugin_module['plugin_ad']['module'] && !$this->plugin_module['plugin_ad']['module']['is_delete']) {
        pdo_delete('superman_hand2_position_order_log', array(
            'uniacid' => $_W['uniacid'],
            'itemid' => $_GPC['id']
        ));
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '删除成功');
} else if ($act == 'blacklist') {
    //检查是否为黑名单用户
    $blacklist = SupermanHandUtil::check_blacklist();
    if ($blacklist) {
        SupermanHandModel::superman_hand2_blacklist($blacklist);
        SupermanHandUtil::json(SupermanHandErrno::ACCOUNT_BLOCK, '账号已封禁, 封禁截止时间:'.$blacklist['blocktime'], 'error');
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
} else if ($act == 'post_count') {
    //检查每日发布物品的次数限制
    $base_post_count = $this->module['config']['base']['post_count'];
    $limit_tips = $this->module['config']['base']['limit_tips'];
    if ($base_post_count > 0) {
        $post_count = pdo_get('superman_hand2_member_post_count', array(
            'uniacid' => $_W['uniacid'],
            'openid' => $_W['openid'],
            'daytime' => date('Ymd', TIMESTAMP),
        ));
        if ($post_count
            && $base_post_count == $post_count['count']) {
            $msg = '每天仅可发布'.$base_post_count.'次物品，明日再来发布吧';
            $msg = $limit_tips ? $limit_tips : $msg;
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, $msg, 'error');
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
} else if ($act == 'init_chat') {
    $chat_filter = array(
        'uniacid' => $_W['uniacid'],
        'itemid' => $_GPC['item_id'],
        'uid' => intval($_GPC['from_uid']),
        'from_uid' => intval($_W['member']['uid'])
    );
    $message = pdo_get('superman_hand2_message_list', $chat_filter);
    if (!empty($message)) {
        $data = array(
            'status' => 1,
            'updatetime' => TIMESTAMP
        );
        $ret = pdo_update('superman_hand2_message_list', $data, array('id' => $message['id']));
        if ($ret === false) {
            SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '');
        }
    } else {
        $data = array(
            'uniacid' => intval($_W['uniacid']),
            'itemid' => intval($_GPC['item_id']),
            'uid' => intval($_GPC['from_uid']),
            'from_uid' => intval($_W['member']['uid']),
            'status' => 0,
            'updatetime' => TIMESTAMP
        );
        pdo_insert('superman_hand2_message_list', $data);
        $new_id = pdo_insertid();
        if (empty($new_id)) {
            SupermanHandUtil::json(SupermanHandErrno::INSERT_FAIL, '');
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '');
} else if ($act == 'check_action') {
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'item_id' => $_GPC['itemid'],
        'uid' => $_GPC['uid'],
        'type' => $_GPC['action']
    );
    $ret = pdo_update('superman_hand2_action', array(
        'is_check' => 1
    ), $filter);
    if ($ret === false) {
        SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '');
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '');
}
