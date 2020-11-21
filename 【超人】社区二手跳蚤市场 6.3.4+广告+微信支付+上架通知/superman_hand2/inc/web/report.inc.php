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
    'black',     //黑名单
    'setattr',   //修改状态
))?$_GPC['act']:'display';
$title = '举报管理';
if ($act == 'display') {
    //审核
    if (checksubmit('audit_submit')) {
        $reportid = intval($_GPC['reportid']);
        $uid = intval($_GPC['uid']);
        $blacklist = pdo_get('superman_hand2_member_blacklist', array(
            'uniacid' => $_W['uniacid'],
            'uid' => $uid,
        ));
        $data = array(
            'day' => $_GPC['day'],
            'remark' => $_GPC['remark'],
            'blocktime' => $_GPC['day'] == -1 ? 1:strtotime('+'.$_GPC['day'].' day'),
        );
        if ($blacklist) {
            $ret = pdo_update('superman_hand2_member_blacklist', $data, array('id' => $blacklist['id']));
            if ($ret === false) {
                itoast('数据库更新失败！', '', 'error');
            }
        } else {
            $fans = pdo_get('mc_mapping_fans', array(
                'uniacid' => $_W['uniacid'],
                'uid' => $uid,
            ), array('openid'));
            $data['uniacid'] = $_W['uniacid'];
            $data['uid'] = $uid;
            $data['openid'] = $fans['openid'];
            pdo_insert('superman_hand2_member_blacklist', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                itoast('数据库更新失败！', '', 'error');
            }
        }
        pdo_update('superman_hand2_report', array(
            'status' => 1,
        ), array('id' => $reportid));
        //发送模板消息
        $res = SupermanHandUtil::get_uid_formid($uid);
        $openid = SupermanHandUtil::uid2openid($uid);
        if ($res['formid']) {
            $nickname = mc_fetch($uid, array('nickname'));
            $tpl_id = $this->module['config']['minipg']['block']['tmpl_id'];
            $url = 'pages/my/index';
            $message_data = array(
                'keyword1' => array(
                    'value' => $nickname['nickname'].'您的账号涉嫌违规，已被封禁',  //温馨提示
                ),
                'keyword2' => array(
                    'value' => $_GPC['remark']?$_GPC['remark']:'物品涉嫌违规',    // 冻结原因
                ),
                'keyword3' => array(
                    'value' => '发布物品功能不可用',   //受限功能
                ),
                'keyword4' => array(
                    'value' => $_GPC['day'] == -1 ? '永久':date('Y-m-d H:i:s', strtotime('+'.$_GPC['day'].' day')),   // 冻结时长
                ),
            );
            $ret = SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
            if ($ret) {
                SupermanHandUtil::delete_uid_formid($res['id']);
            }
        } else {
            $uni_tpl_id = $this->module['config']['tmpl']['block']['tmpl_id'];
            $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
            if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                $message_data = array(
                    'first' => array(
                        'value' => '您的账号已被封禁',
                        'color' => '#173177'
                    ),
                    'keyword1' => array(
                        'value' => $_GPC['day'] == -1 ? '永久封禁' : '封禁'.$_GPC['day'].'天',
                    ),
                    'keyword2' => array(
                        'value' => $_GPC['remark'],
                    ),
                    'remark' => array(
                        'value' => '如有疑问请联系管理员解除封禁',
                        'color' => '#173177'
                    ),
                );
                SupermanHandUtil::send_uniform_msg($message_data, $openid, $uni_tpl_id, $gzh_appid);
            }
        }
        itoast('操作成功！', referer(), 'success');
    }

    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    $nickname = trim($_GPC['nickname']);
    $item_title = trim($_GPC['item_title']);
    $status = in_array($_GPC['status'], array('0', '1', '-1'))?$_GPC['status']:'-1';
    if ($status != '-1') {
        $filter['status'] = $status;
    }
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    if (!empty($item_title)) {
        $items = pdo_getall('superman_hand2_item', array(
            'uniacid' => $_W['uniacid'],
            'title LIKE' => "%{$item_title}%"
        ), array('id'));
        if (!empty($items)) {
            $arr = array();
            foreach ($items as $it) {
                $arr[] = $it['id'];
            }
            $filter['itemid'] = $arr;
        } else{
            $filter['itemid'] = 0;
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
            $filter['seller_uid'] = $arr;
        } else{
            $filter['seller_uid'] = 0;
        }
    }
    $total = pdo_getcolumn('superman_hand2_report', $filter, 'COUNT(*)');
    $orderby = 'createtime DESC';
    $list = pdo_getall('superman_hand2_report', $filter, '*', '', $orderby, array($pindex, $pagesize));
    $pager = pagination($total, $pindex, $pagesize);
    if ($list) {
        foreach ($list as &$li) {
            $li['createtime'] = date('Y-m-d H:i:s', $li['createtime']);
            $li['item'] = pdo_get('superman_hand2_item', array('id' => $li['itemid']), array('title'));
            if ($li['seller_uid'] > 0) {
                $user = pdo_get('mc_members', array('uid' => $li['seller_uid']));
                $li['nickname'] = $user['nickname'];
                $li['blacklist'] = pdo_get('superman_hand2_member_blacklist', array(
                    'uniacid' => $_W['uniacid'],
                    'uid' => $li['seller_uid']
                ));
                SupermanHandModel::superman_hand2_blacklist($li['blacklist']);
            }
        }
        unset($li);
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if (empty($id)) {
        itoast('非法请求！', '', 'error');
    }
    $ret = pdo_delete('superman_hand2_report', array('id' => $id));
    if ($ret === false) {
        itoast('数据库删除失败！', '', 'error');
    }
    itoast('删除成功！', 'referer', 'success');
} if ($act == 'black') {
    $op = in_array($_GPC['op'], array(
        'display',
        'delete',
    ))?$_GPC['op']:'display';
    if ($op == 'display') {
        if (checksubmit('audit_submit')) {
            $blackid = intval($_GPC['blackid']);
            $day = $_GPC['day'];
            if (empty($day)) {
                itoast('封禁天数为空，请填写！', '', 'error');
            }
            $blacklist = pdo_get('superman_hand2_member_blacklist', array('id' => $blackid));
            if (empty($blacklist)) {
                itoast('黑名单用户不存在！', '', 'error');
            }
            if ($day == -1){
                $data = array(
                    'day' => $day,
                    'blocktime' => 1
                );
            } else {
                if ($blacklist['day'] == -1) {
                    $data = array(
                        'day' => $day,
                        'blocktime ' => strtotime('+'.$_GPC['day'].' day')
                    );
                } else {
                    $data = array(
                        'day +' => $day,
                        'blocktime +' => strtotime(date('Y-m-d H:i:s', $blacklist['blocktime']).' +'.$day.' day')
                    );
                }
            }
            //备注
            if (!empty($_GPC['remark'])) {
                $data['remark'] = $_GPC['remark'];
            }
            $ret = pdo_update('superman_hand2_member_blacklist', $data, array('id' => $blackid));
            if ($ret === false) {
                itoast('数据库插入失败！', '', 'error');
            }
            //发送模板消息
            $row = pdo_get('superman_hand2_member_blacklist', array('id' => $blackid));
            $res = SupermanHandUtil::get_uid_formid($row['uid']);
            if ($res['formid']) {
                $nickname = mc_fetch($row['uid'], array('nickname'));
                $tpl_id = $this->module['config']['minipg']['block']['tmpl_id'];
                $url = 'pages/my/index';
                $message_data = array(
                    'keyword1' => array(
                        'value' => $nickname['nickname'].'您的账号涉嫌违规，已被封禁',  //温馨提示
                    ),
                    'keyword2' => array(
                        'value' => $_GPC['remark']?$_GPC['remark']:'物品涉嫌违规',    // 冻结原因
                    ),
                    'keyword3' => array(
                        'value' => '发布物品功能不可用',   //受限功能
                    ),
                    'keyword4' => array(
                        'value' => $_GPC['day'] == -1 ? '永久':date('Y-m-d H:i:s', strtotime('+'.$_GPC['day'].' day')),   // 冻结时长
                    ),
                );
                $ret = SupermanHandUtil::send_wxapp_msg($message_data, $row['openid'], $tpl_id, $url, $res['formid']);
                if ($ret) {
                    SupermanHandUtil::delete_uid_formid($res['id']);
                }
            } else {
                $uni_tpl_id = $this->module['config']['tmpl']['block']['tmpl_id'];
                $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
                if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                    $message_data = array(
                        'first' => array(
                            'value' => '您的账号已被封禁',
                            'color' => '#173177'
                        ),
                        'keyword1' => array(
                            'value' => $_GPC['day'] == -1 ? '永久封禁' : '封禁'.$_GPC['day'].'天',
                        ),
                        'keyword2' => array(
                            'value' => $_GPC['remark'],
                        ),
                        'remark' => array(
                            'value' => '如有疑问请联系管理员解除封禁',
                            'color' => '#173177'
                        ),
                    );
                    SupermanHandUtil::send_uniform_msg($message_data, $row['openid'], $uni_tpl_id, $gzh_appid);
                }
            }
            itoast('操作成功！', referer(), 'success');
        }
        $nickname = trim($_GPC['nickname']);
        $pindex = max(1, intval($_GPC['page']));
        $pagesize = 20;
        $filter = array(
            'uniacid' => $_W['uniacid'],
        );
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
                $filter['uid'] = $arr;
            } else {
                $filter['uid'] = 0;
            }
        }
        $total = pdo_getcolumn('superman_hand2_member_blacklist', $filter, 'COUNT(*)');
        $orderby = 'blocktime DESC';
        $list = pdo_getall('superman_hand2_member_blacklist', $filter, '*', '', $orderby, array($pindex, $pagesize));
        $pager = pagination($total, $pindex, $pagesize);
        if ($list) {
            foreach ($list as &$li) {
                SupermanHandModel::superman_hand2_blacklist($li);
            }
            unset($li);
        }
    } else if ($op == 'delete') {
        $id = intval($_GPC['id']);
        if (empty($id)) {
            itoast('非法请求！', '', 'error');
        }
        $row = pdo_get('superman_hand2_member_blacklist', array('id' => $id));
        $ret = pdo_delete('superman_hand2_member_blacklist', array('id' => $id));
        if ($ret === false) {
            itoast('数据库删除失败！', '', 'error');
        }
        //发送模板消息
        $res = SupermanHandUtil::get_uid_formid($row['uid']);
        $nickname = mc_fetch($row['uid'], array('nickname'));
        if ($res['formid']) {
            $tpl_id = $this->module['config']['minipg']['relieve']['tmpl_id'];
            $url = 'pages/my/index';
            $message_data = array(
                'keyword1' => array(
                    'value' => $nickname['nickname'],  //用户昵称
                ),
                'keyword2' => array(
                    'value' => '您的账号已解封，欢迎再次使用',    // 备注
                ),
                'keyword3' => array(
                    'value' => date('Y-m-d H:i:s', TIMESTAMP),   // 冻结时长
                ),
            );
            $ret = SupermanHandUtil::send_wxapp_msg($message_data, $row['openid'], $tpl_id, $url, $res['formid']);
            if ($ret) {
                SupermanHandUtil::delete_uid_formid($res['id']);
            }
        } else {
            $uni_tpl_id = $this->module['config']['tmpl']['relieve']['tmpl_id'];
            $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
            if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                $message_data = array(
                    'first' => array(
                        'value' => '您的账号已经解封',
                        'color' => '#173177'
                    ),
                    'keyword1' => array(
                        'value' => $nickname,
                    ),
                    'keyword2' => array(
                        'value' => date('Y-m-d H:i:s', TIMESTAMP),
                    ),
                    'remark' => array(
                        'value' => '您可继续进入小程序发布物品了',
                        'color' => '#173177'
                    ),
                );
                SupermanHandUtil::send_uniform_msg($message_data, $row['openid'], $uni_tpl_id, $gzh_appid);
            }
        }
        itoast('删除成功！', 'referer', 'success');
    }
} else if ($act == 'setattr') {
    $id = intval($_GPC['id']);
    if ($id == '') {
        echo '非法请求';
        exit;
    }
    $data = array(
        'status' => 1
    );
    $ret = pdo_update('superman_hand2_report', $data, array('id' => $id));
    if ($ret !== false) {
        echo 'success';
    } else {
        echo '系统错误';
    }
    exit;
}
include $this->template($this->web_template_path);