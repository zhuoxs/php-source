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
    'credit_log',  //积分明细
    'get_credit',  //任务中心
))?$_GPC['act']:'display';
checkauth();
if ($act == 'display') {
    $title = '个人中心';
    $my = array();
    //个人信息
    $member = mc_fetch_one($_W['member']['uid']);
    $my['nickname'] = $member['nickname'];
    $my['avatar'] = $member['avatar'];
    $my['uid'] = $member['uid'];
    //点赞和收藏数量
    $my['zan'] = pdo_getcolumn('superman_hand2_action', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
        'type' => 1
    ), 'COUNT(*)');
    $my['collect'] = pdo_getcolumn('superman_hand2_action', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
        'type' => 2
    ), 'COUNT(*)');
    //物品收入
    if ($this->plugin_module['plugin_wechat']['module']
        && !$this->plugin_module['plugin_wechat']['module']['is_delete']) {
        $my['balance'] = pdo_get('superman_hand2_member', array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid']
        ), array('balance'));
    }
    $sql = 'SELECT SUM(credit) AS credit FROM '.tablename('superman_hand2_member_block_credit').'WHERE uniacid=:uniacid AND uid=:uid';
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':uid' => $_W['member']['uid']
    );
    $block_credit = pdo_fetch($sql, $params);
    $my['block_credit'] = $block_credit['credit']?$block_credit['credit']:0;  //冻结积分
    $my['credit1'] = $_W['member']['credit1'] - $block_credit['credit'];  //积分
} else if ($act == 'item_list') {
    $title = '物品列表';
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $start = ($pindex - 1) * $pagesize;
    $orderby = 'createtime DESC';

    $action = $_GPC['action'];
    if (!empty($action)) {
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid'],
            'type' => $action
        );
        $list = pdo_getall('superman_hand2_action', $filter, '', '', $orderby, array($pindex, $pagesize));
        if (!empty($list)) {
            foreach ($list as &$li) {
                SupermanHandModel::superman_hand2_action($li);
            }
            unset($li);
        }
    }
    $type = $_GPC['type'];
    if (!empty($type)) {
        if ($type == 'publish') {
            $filter = array(
                'uniacid' => $_W['uniacid'],
                'seller_uid' => $_W['member']['uid'],
                'status' => array(-1, 0, 1, 2)
            );
        }
        $list = pdo_getall('superman_hand2_item', $filter, '*', '', $orderby, array($pindex, $pagesize));
        if (!empty($list)) {
            foreach ($list as &$li) {
                SupermanHandModel::superman_hand2_item($li);
                if ($this->plugin_module['plugin_ad']['module']
                    && !$this->plugin_module['plugin_ad']['module']['is_delete']) {
                    $item_top = pdo_get('superman_hand2_position_order_log', array(
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
} else if ($act == 'delete') {
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'id' => $_GPC['id']
    );
    $ret = pdo_update('superman_hand2_item', array('status' => -2), $filter);
    if ($ret === false) {
        SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '数据库更新失败', 'error');
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '删除成功');
} else if ($act == 'credit_log') {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $limit = 'LIMIT '.($pindex-1)* $psize.','.$psize;
    $orderby = 'createtime DESC';
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
    );
    if ($_GPC['type'] == 'block') {   //冻结积分记录
        $list = pdo_getall('superman_hand2_member_block_credit', $filter, '', '', $orderby);
        if ($list) {
            foreach ($list as &$li) {
                $li['createtime'] = date('Y-m-d H:i:s', $li['createtime']);
                $li['num'] = '-'.$li['credit'];
            }
            unset($li);
        }
    } else {  //积分明细
        $filter['credittype'] = 'credit1';
        $list = pdo_getall('mc_credits_record', $filter, '', '', $orderby, $limit);
        if ($list) {
            foreach ($list as &$li) {
                $li['createtime'] = date('Y-m-d H:i:s', $li['createtime']);
                if ($li['num'] > 0) {
                    $li['num'] = '+'.$li['num'];
                }
            }
            unset($li);
        }
    }
} else if ($act == 'get_credit') {
    $list = array();
    $category = pdo_getall('superman_hand2_category', array(
        'uniacid' => $_W['uniacid'],
    ), '', 'id', 'displayorder DESC');
    $member_log = pdo_get('superman_hand2_member_log', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
    ));
    $credit_setting = $this->module['config']['credit'];
    if ($credit_setting['open'] == 1) {
        foreach ($credit_setting as $k => $cs) {
            if ($k == 'open') {
                continue;
            } else if (in_array($k, array('login', 'upload', 'day')) && $cs > 0) {
                if ($k == 'login') {
                    $title = '首次登录';
                    $disabled = $member_log['login']==1?true:false;
                } else if ($k == 'upload') {
                    $title = '首次上传';
                    $disabled = $member_log['upload']==1?true:false;
                } else if ($k == 'day') {
                    $member_login = pdo_get('superman_hand2_member_login', array(
                        'uniacid' => $_W['uniacid'],
                        'uid' => $_W['member']['uid'],
                        'dateline >' => strtotime(date('Y-m-d 0:0:0', TIMESTAMP)),
                    ));
                    $title = '每天登录';
                    $disabled = $member_login?true:false;
                }
                $list[] = array(
                    'type' => $k,
                    'title' => $title,
                    'disabled' => $disabled,
                    'credit' => $cs,
                    'url' => $k == 'upload'?$this->createMobileUrl('item', array('act' => 'post')):'',
                    'status_title' => $disabled?'已赚积分':'去赚积分',
                );
            } else if ($k == 'category') {
                foreach ($cs as $c => $cate) {
                    if ($cate > 0) {
                        $list[] = array(
                            'type' => $k,
                            'title' => '上传分类为'.$category[$c]['title'].'物品',
                            'disabled' => false,
                            'credit' => $cate,
                            'url' => $this->createMobileUrl('item', array('act' => 'post')),
                            'status_title' => '去赚积分',
                        );
                    }
                }
            }
        }
    }
}
include $this->template('my/'.$act);