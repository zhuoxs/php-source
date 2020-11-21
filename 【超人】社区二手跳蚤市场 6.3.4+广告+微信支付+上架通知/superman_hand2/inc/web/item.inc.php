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
    'post',
    'add',
    'delete',
    'search',
    'test',
    'set_top',
    'cancel_set_top',
    'sync_location',
    'get_authip',
    'sold'
))?$_GPC['act']:'display';
$title = '发布管理';
if ($act == 'display') {
    $sql = "SELECT COUNT(*) FROM ".tablename('superman_hand2_item');
    $sql .= " WHERE uniacid={$_W['uniacid']} AND status=1  AND lng !='' AND lat !='' AND lng !='undefined' AND lat !='undefined' AND (province='' OR province='undefined' OR city='' OR city='undefined')";
    $sync_count = pdo_fetchcolumn($sql);
    //物品分类
    $filter = array(
        'uniacid' => $_W['uniacid'],
    );
    $category = pdo_getall('superman_hand2_category', $filter, '*', '', $orderby);
    //获取分类
    if (isset($_GPC['get_category']) && $_GPC['get_category'] == 1) {
        die(json_encode($category));
    }
    //获取商品详情信息
    if (isset($_GPC['get_item']) && $_GPC['get_item'] == 1 && $_GPC['itemid'] > 0) {
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'id' => $_GPC['itemid'],
        );
        $item = pdo_get('superman_hand2_item', $filter);
        SupermanHandModel::superman_hand2_item($item);
        die(json_encode($item));
    }
    //更改物品分类
    if (checksubmit('update_category')) {
        $itemid = intval($_GPC['itemid']);
        $cid = intval($_GPC['categoryid']);
        $ret = pdo_update('superman_hand2_item', array(
            'cid' => $cid,
        ), array('id' => $itemid));
        if ($ret === false) {
            itoast('更改失败', referer(), 'error');
        }
        itoast('更改成功！', referer(), 'success');
    }
    // 加入黑名单
    if (checksubmit('add_black')) {
        if (empty($_GPC['day'])) {
            itoast('请填写封禁天数！', '', 'error');
        }
        $uid = intval($_GPC['seller_uid']);
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
                itoast('数据库插入失败！', '', 'error');
            }
        }
        pdo_update('superman_hand2_item', array('status' => -2), array('id' => $_GPC['itemid']));
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
    $nickname = trim($_GPC['nickname']);
    $item_title = trim($_GPC['item_title']);
    $cid = intval($_GPC['cid']);
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $start = ($pindex - 1) * $pagesize;
    $filter = array(
        ':uniacid' => $_W['uniacid'],
        //':item_type' => array(-1, 0),
    );
    $params = array(
        'uniacid' => $_W['uniacid'],
        'item_type' => array(-1, 0),
    );
    $sql = "SELECT * FROM " . tablename('superman_hand2_item') . " WHERE uniacid=:uniacid AND item_type in (-1, 0)";
    if (!empty($item_title)) {
        $sql .= ' AND title LIKE "%'.$item_title.'%"';
        $params['title LIKE'] = "%{$item_title}%";
    }
    $status = in_array($_GPC['status'], array( '-1', '0', '1', '2', 'all'))?$_GPC['status']:'all';
    if ($status != 'all') {
        $filter[':status'] = $status;
        $params['status'] = $status;
        $sql .= ' AND status=:status';
    } else {
        $sql .= ' AND status != -2';
        $params['status !='] = -2;
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
            $filter[':seller_uid'] = implode(',', $arr);
            $params['seller_uid'] = implode(',', $arr);
        } else {
            $filter[':seller_uid'] = 0;
            $params['seller_uid'] = 0;
        }
        $sql .= ' AND seller_uid=:seller_uid';
    }
    if ($cid > 0) {
        $filter[':cid'] = $cid;
        $params['cid'] = $cid;
        $sql .= ' AND cid=:cid';
    }
    $total = pdo_getcolumn('superman_hand2_item', $params, 'COUNT(*)');
    $orderby .= ' ORDER BY CASE WHEN status = 0 THEN -1 ELSE -2 END DESC, createtime DESC, updatetime DESC';
    $limit .= $pagesize > 0?" LIMIT {$start},{$pagesize}":'';
    $list = pdo_fetchall($sql.$orderby.$limit, $filter);
    $pager = pagination($total, $pindex, $pagesize);
    if ($list) {
        foreach ($list as &$li) {
            $li['createtime'] = date('Y-m-d H:i:s', $li['createtime']);
            $li['category'] = pdo_get('superman_hand2_category', array(
                'uniacid' => $_W['uniacid'],
                'id' => $li['cid'],
            ));
            if ($li['seller_uid'] > 0) {
                $user = pdo_get('mc_members', array('uid' => $li['seller_uid']));
                $li['nickname'] = $user['nickname'];
            }
            if ($this->plugin_module['plugin_ad']['module']
                && !$this->plugin_module['plugin_ad']['module']['is_delete']) {
                $li['position_title'] = !empty($li['set_top_fields']) ? '是' : '否';
                $li['pay_position'] = $user = pdo_get('superman_hand2_pay_position', array(
                    'uniacid' => $_W['uniacid'],
                    'displayorder' => $li['pay_position']
                ), array('title'));
            }
        }
        unset($li);
    }
    if (checksubmit('batch_submit')) {
        if (empty($_GPC['itemids'])) {
            itoast('未选择物品', referer(), 'error');
        }
        $itemids = $_GPC['itemids'];
        $batch_operate = $_GPC['batch_submit'];
        foreach ($itemids as $itemid) {
            if ($batch_operate == '批量审核通过') {
                $ret = pdo_update('superman_hand2_item', array('status' => 1), array('id' => $itemid));
                if ($ret === false) {
                    itoast('数据库更新失败！', '', 'error');
                }
                get_credit(1, $itemid, $this->module['config']);
                //发送模板消息
                $item = pdo_get('superman_hand2_item', array('id' => $itemid));
                $res = SupermanHandUtil::get_uid_formid($item['seller_uid']);
                $openid = SupermanHandUtil::uid2openid($item['seller_uid']);
                $url = 'pages/detail/index?id='.$item['id'];
                if ($res['formid']) {
                    $tpl_id = $this->module['config']['minipg']['audit_result']['tmpl_id'];
                    $message_data = array(
                        'keyword1' => array(
                            'value' => $item['title'],  //商品名称
                        ),
                        'keyword2' => array(
                            'value' => '批量审核通过',    // 审核结果
                        ),
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s', TIMESTAMP),   // 审核时间
                        ),
                    );
                    $ret = SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
                    if ($ret) {
                        SupermanHandUtil::delete_uid_formid($res['id']);
                    }
                } else {
                    $uni_tpl_id = $this->module['config']['tmpl']['audit_result']['tmpl_id'];
                    $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
                    if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                        $category = pdo_get('superman_hand2_category', array('id' => $item['cid']));
                        $message_data = array(
                            'first' => array(
                                'value' => '您好，以下是您发布物品的审核结果',
                                'color' => '#173177'
                            ),
                            'keyword1' => array(
                                'value' => $category['title'],
                            ),
                            'keyword2' => array(
                                'value' => $item['title'],
                            ),
                            'keyword3' => array(
                                'value' => date('Y-m-d H:i:s', $item['createtime']),
                            ),
                            'keyword4' => array(
                                'value' => '审核通过',
                            ),
                            'remark' => array(
                                'value' => '点击进入小程序查看',
                                'color' => '#173177'
                            ),
                        );
                        SupermanHandUtil::send_uniform_msg($message_data, $openid, $uni_tpl_id, $gzh_appid, $url);
                    }
                }
            } else {
                $item = pdo_get('superman_hand2_item', array('id' => $itemid));
                $ret = pdo_update('superman_hand2_item', array(
                    'status' => -2,
                    'pay_position' => 0,
                ), array('id' => $itemid));
                $ret2 = pdo_delete('superman_hand2_action', array('item_id' => $itemid));
                if ($ret === false || $ret2 === false) {
                    itoast('数据库删除失败！', '', 'error');
                }
                if ($this->plugin_module['plugin_ad']['module'] && !$this->plugin_module['plugin_ad']['module']['is_delete']) {
                    pdo_delete('superman_hand2_position_order_log', array(
                        'uniacid' => $_W['uniacid'],
                        'itemid' => $itemid
                    ));
                }
                //扣除已赠送积分
                if ($item['credit_tip'] == 1 && $item['status'] == 1) {
                    $credit_log = array(
                        $item['seller_uid'],
                        '删除物品'.$item['title'],
                        'superman_hand2',
                    );
                    $ret = mc_credit_update($item['seller_uid'], 'credit1', -$this->module['config']['credit']['category'][$item['cid']], $credit_log);
                    if (is_error($ret)) {
                        WeUtility::logging('fatal', '[item.inc.php: delete credit update fail], ret='.var_export($ret, true));
                    }
                }
            }
        }
        $url = $this->createWebUrl('item');
        itoast('操作成功！', $url, 'success');
    }
} else if ($act == 'sold') {
    //获取商品详情信息
    if (isset($_GPC['get_item']) && $_GPC['get_item'] == 1 && $_GPC['itemid'] > 0) {
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'id' => $_GPC['itemid'],
        );
        $item = pdo_get('superman_hand2_item', $filter);
        SupermanHandModel::superman_hand2_item($item);
        die(json_encode($item));
    }
    $nickname = trim($_GPC['nickname']);
    $item_title = trim($_GPC['item_title']);
    $cid = intval($_GPC['cid']);
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 20;
    $start = ($pindex - 1) * $pagesize;
    $filter = array(
        ':uniacid' => $_W['uniacid'],
    );
    $params = array(
        'uniacid' => $_W['uniacid'],
        'item_type' => 0,
        'status' => 2
    );
    $sql = "SELECT * FROM " . tablename('superman_hand2_item') . " WHERE uniacid=:uniacid AND item_type=0 AND status=2";
    if (!empty($item_title)) {
        $sql .= ' AND title LIKE "%'.$item_title.'%"';
        $params['title LIKE'] = "%{$item_title}%";
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
            $filter[':seller_uid'] = implode(',', $arr);
            $params['seller_uid'] = implode(',', $arr);
        } else {
            $filter[':seller_uid'] = 0;
            $params['seller_uid'] = 0;
        }
        $sql .= ' AND seller_uid=:seller_uid';
    }
    if ($cid > 0) {
        $filter[':cid'] = $cid;
        $params['cid'] = $cid;
        $sql .= ' AND cid=:cid';
    }
    $total = pdo_getcolumn('superman_hand2_item', $params, 'COUNT(*)');
    $orderby .= ' ORDER BY createtime DESC, updatetime DESC';
    $limit .= $pagesize > 0?" LIMIT {$start},{$pagesize}":'';
    $list = pdo_fetchall($sql.$orderby.$limit, $filter);
    $pager = pagination($total, $pindex, $pagesize);
    if ($list) {
        foreach ($list as &$li) {
            $li['createtime'] = date('Y-m-d H:i:s', $li['createtime']);
            $li['category'] = pdo_get('superman_hand2_category', array(
                'uniacid' => $_W['uniacid'],
                'id' => $li['cid'],
            ));
            if ($li['seller_uid'] > 0) {
                $user = pdo_get('mc_members', array('uid' => $li['seller_uid']));
                $li['nickname'] = $user['nickname'];
            }
            $li['order'] = pdo_get('superman_hand2_item', array('uniacid' => $_W['uniacid'], 'itemid' => $li['id']));
            $li['soldtime'] = date('Y-m-d H:i:s', $li['order']['createtime']);
        }
        unset($li);
    }
} else if ($act == 'post') {
    $id = intval($_GPC['id']);
    $status = intval($_GPC['status']);
    if (checksubmit()) {
        $data = array(
            'title' => $_GPC['title'],
            'status' => $status,
        );
        $ret = pdo_update('superman_hand2_item', $data, array('id' => $id));
        if ($ret === false) {
            itoast('数据库更新失败！', '', 'error');
        }
        //统计日成交量
        if ($status == 2) {
            SupermanHandUtil::stat_day_item_trade();
        }
        get_credit($status, $id, $this->module['config']);
        //发送模板消息
        if (in_array($status, array('-3', '1'))) {
            $item = pdo_get('superman_hand2_item', array('id' => $id));
            $res = SupermanHandUtil::get_uid_formid($item['seller_uid']);
            $openid = SupermanHandUtil::uid2openid($item['seller_uid']);
            $url = 'pages/detail/index?id='.$item['id'];
            if ($res['formid']) {
                $tpl_id = $this->module['config']['minipg']['audit_result']['tmpl_id'];
                $message_data = array(
                    'keyword1' => array(
                        'value' => $item['title'],  //商品名称
                    ),
                    'keyword2' => array(
                        'value' => $status == 1?'商品审核已通过':'商品被拒绝',    // 审核结果
                    ),
                    'keyword3' => array(
                        'value' => date('Y-m-d H:i:s', TIMESTAMP),   // 审核时间
                    ),
                );
                $ret = SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
                if ($ret) {
                    SupermanHandUtil::delete_uid_formid($res['id']);
                }
            } else {
                $uni_tpl_id = $this->module['config']['tmpl']['audit_result']['tmpl_id'];
                $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
                if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                    $category = pdo_get('superman_hand2_category', array('id' => $item['cid']));
                    $message_data = array(
                        'first' => array(
                            'value' => '您好，以下是您发布物品的审核结果',
                            'color' => '#173177'
                        ),
                        'keyword1' => array(
                            'value' => $category['title'],
                        ),
                        'keyword2' => array(
                            'value' => $item['title'],
                        ),
                        'keyword3' => array(
                            'value' => date('Y-m-d H:i:s', $item['createtime']),
                        ),
                        'keyword4' => array(
                            'value' => '审核通过',
                        ),
                        'remark' => array(
                            'value' => '点击进入小程序查看',
                            'color' => '#173177'
                        ),
                    );
                    SupermanHandUtil::send_uniform_msg($message_data, $openid, $uni_tpl_id, $gzh_appid, $url);
                }
            }
        }
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('item').'&version_id='.$_GPC['version_id'];
        itoast('操作成功！', $url, 'success');
    }
    if (!empty($id) && $status != null) {
        $data = array(
            'status' => $status
        );
        $ret = pdo_update('superman_hand2_item', $data, array('uniacid' => $_W['uniacid'], 'id' => $id));
        if ($ret === false) {
            itoast('数据库更新失败！', '', 'error');
        }
        get_credit($status, $id, $this->module['config']);
        //发送模板消息
        $item = pdo_get('superman_hand2_item', array('id' => $id));
        $res = SupermanHandUtil::get_uid_formid($item['seller_uid']);
        $openid = SupermanHandUtil::uid2openid($item['seller_uid']);
        $url = 'pages/detail/index?id='.$item['id'];
        if ($res['formid']) {
            $tpl_id = $this->module['config']['minipg']['audit_result']['tmpl_id'];
            $message_data = array(
                'keyword1' => array(
                    'value' => $item['title'],  //商品名称
                ),
                'keyword2' => array(
                    'value' => $status == 1?'商品审核已通过':'商品被拒绝',    // 审核结果
                ),
                'keyword3' => array(
                    'value' => date('Y-m-d H:i:s', TIMESTAMP),   // 审核时间
                ),
            );
            $ret = SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
            if ($ret) {
                SupermanHandUtil::delete_uid_formid($res['id']);
            }
        } else {
            $uni_tpl_id = $this->module['config']['tmpl']['audit_result']['tmpl_id'];
            $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
            if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                $category = pdo_get('superman_hand2_category', array('id' => $item['cid']));
                $message_data = array(
                    'first' => array(
                        'value' => '您好，以下是您发布物品的审核结果',
                        'color' => '#173177'
                    ),
                    'keyword1' => array(
                        'value' => $category['title'],
                    ),
                    'keyword2' => array(
                        'value' => $item['title'],
                    ),
                    'keyword3' => array(
                        'value' => date('Y-m-d H:i:s', $item['createtime']),
                    ),
                    'keyword4' => array(
                        'value' => '审核通过',
                    ),
                    'remark' => array(
                        'value' => '点击进入小程序查看',
                        'color' => '#173177'
                    ),
                );
                SupermanHandUtil::send_uniform_msg($message_data, $openid, $uni_tpl_id, $gzh_appid, $url);
            }
        }
        $url = $this->createWebUrl('item');
        itoast('操作成功！', $url, 'success');
    }
    if (!empty($id)) {
        $item = pdo_get('superman_hand2_item', array('id' => $id));
    }
} else if ($act == 'delete') {
    $id = intval($_GPC['id']);
    if (empty($id)) {
        itoast('非法请求！', '', 'error');
    }
    $item = pdo_get('superman_hand2_item', array('id' => $id));
    $ret = pdo_update('superman_hand2_item', array(
        'status' => -2,
        'pay_position' => 0,
    ), array('id' => $id));
    $ret1 = pdo_delete('superman_hand2_action', array('item_id' => $id));
    if ($ret === false || $ret1 === false) {
        itoast('数据库删除失败！', '', 'error');
    }
    if ($this->plugin_module['plugin_ad']['module'] && !$this->plugin_module['plugin_ad']['module']['is_delete']) {
        pdo_delete('superman_hand2_position_order_log', array(
            'uniacid' => $_W['uniacid'],
            'itemid' => $id
        ));
    }
    //扣除已赠送积分
    if ($item['credit_tip'] == 1 && $item['status'] == 1) {
        $credit_log = array(
            $item['seller_uid'],
            '删除物品'.$item['title'],
            'superman_hand2',
        );
        $ret = mc_credit_update($item['seller_uid'], 'credit1', -$this->module['config']['credit']['category'][$item['cid']], $credit_log);
        if (is_error($ret)) {
            WeUtility::logging('fatal', '[item.inc.php: delete credit update fail], ret='.var_export($ret, true));
        }
    }
    itoast('操作成功！', 'referer', 'success');
} else if ($act == 'add') {
    $category = pdo_getall('superman_hand2_category', array('uniacid' => $_W['uniacid']));
    $unit = $this->module['config']['currency']?$this->module['config']['currency']:array();
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $item = pdo_get('superman_hand2_item', array('id' => $id, 'uniacid' => $_W['uniacid']));
        if ($item['album']) {
            $item['album'] = unserialize($item['album']);
        }
        if ($item['video']) {
            $item['video'] = unserialize($item['video']);
        }
        $area_points = $item['area_points'] ? iunserializer($item['area_points']) : array();
        $item['location']['lng'] = $item['lng'];
        $item['location']['lat'] = $item['lat'];
        if ($item['expiretime'] > 0) {
            $item['expiretime'] = date('Y-m-d H:i:s', $item['expiretime']);
        }
    }
    if (checksubmit()) {
        if (empty($_GPC['title'])) {
            itoast('请输入物品名称！', 'referer', 'error');
        }
        if ($_GPC['video']) {
            $video = array($_GPC['video']);
        }
        $info = array();
        if ($_GPC['location']) {
            $info = SupermanHandUtil::location_transition($_GPC['location']['lat'], $_GPC['location']['lng'], $this->module['config']['base']['lbs_key']);
        }
        $data = array(
            'seller_uid' => 0,
            'title' => $_GPC['title'],
            'cid' => $_GPC['cid'],
            'description' => $_GPC['description'],
            'album' => $_GPC['album']?iserializer($_GPC['album']):'',
            'video' => $video?iserializer($video):'',
            'item_type' => -1, //标识后台发布
            'avatar' => $this->module['config']['base']['avatar'],
            'nickname' => $this->module['config']['base']['nickname'],
            'lng' => $_GPC['location'] ? $_GPC['location']['lng'] : '',
            'lat' => $_GPC['location'] ? $_GPC['location']['lat'] : '',
            'price' => $_GPC['price'],
            'province' => !empty($info) ? $info['province'] : '',
            'city' => !empty($info) ? $info['city'] : '',
            'address' => $_GPC['address'],
            'unit' => $_GPC['unit_title'] == '元' ? 0 : 1,
            'unit_title' => $_GPC['unit_title'],
            'status' => 1,
            'phone' => $_GPC['phone'],
            'wechat' => $_GPC['wechat'],
            'area_points' => $_GPC['area_points']?iserializer(json_decode(base64_decode($_GPC['area_points']), true)):'',
            'expiretime' => $_GPC['set_expire'] == 1 ? strtotime($_GPC['expiretime']) : 0
        );
        if (empty($item)) {
            $data['uniacid'] = $_W['uniacid'];
            $data['createtime'] = TIMESTAMP;
            pdo_insert('superman_hand2_item', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                itoast('数据库添加失败！', '', 'error');
            }
        } else {
            $data['updatetime'] = TIMESTAMP;
            $ret = pdo_update('superman_hand2_item', $data, array('id' => $id));
            if ($ret === false) {
                itoast('数据库更新失败！', '', 'error');
            }
        }
        $url = $_W['siteroot'].'web/'.$this->createWebUrl('item').'&version_id='.$_GPC['version_id'];
        itoast('发布成功！', $url, 'success');
    }
} else if ($act == 'search') {
    $name = $_GPC['name'];
    if (empty($name)) {
        itoast('请填写用户名！', '', 'error');
    }
    $list = pdo_getall('mc_mapping_fans', array('nickname' => $name, 'uniacid' => $_W['uniacid']), array('openid'));
    @header('Content-Type: application/json; charset=utf-8');
    die(json_encode($list));
} else if ($act == 'set_top') {
    $params = array(
        'uniacid' => $_W['uniacid'],
        'status' => 1,
    );
    $list = pdo_getall('superman_hand2_pay_position', $params);
    if ($list) {
        foreach ($list as &$li) {
            $li['area'] = explode(',', $li['area']);
            $li['district'] = $li['area'][2];
        }
        unset($li);
    }
    if (checksubmit()) {
        $itemid = intval($_GPC['id']);
        $district = explode(',', $_GPC['dt_list']);
        $position = intval($_GPC['position']);
        $total = floatval($_GPC['count']);
        $fields = array();
        if (count($district) > 1) {
            foreach ($district as $item) {
                $arr = array(
                    'district' => $item,
                    'position' => $position
                );
                $fields[] = $arr;
            }
        } else {
            $fields = array(
                array(
                    'district' => $_GPC['dt_list'],
                    'position' => $position
                )
            );
        }
        pdo_begin();
        //支付记录
        $data = array(
            'uniacid' => $_W['uniacid'],
            'itemid' => $itemid,
            'uid' => $_W['member']['uid'],
            'set_top_fields' => iserializer($fields),
            'paytype' => 3,//后台操作
            'type' => 'day',
            'total' => $total,
            'all_price' => 0,
            'status' => 1,
            'createtime' => TIMESTAMP,
            'audit' => 1,
            'audittime' => TIMESTAMP,
            'paytime' => TIMESTAMP,
            'expiretime' => pay_item_expiretime($total),
        );
        $ret1 = pdo_insert('superman_hand2_position_order_log', $data);
        //付费物品位置设置
        $ret2 = pdo_update('superman_hand2_item', array(
            'pay_position' => 1,
            'set_top_fields' => iserializer($fields)
        ), array(
            'id' => $itemid
        ));
        if ($ret1 === false || $ret2 === false){
            itoast('置顶失败, 失败原因：数据库更新失败', '', 'error');
        }
        pdo_commit();
        $url = $this->createWebUrl('item');
        itoast('操作成功！', $url, 'success');
    }
} else if ($act == 'cancel_set_top') {
    $itemid = $_GPC['id'];
    pdo_update('superman_hand2_item', array(
        'pay_position' => 0,
        'set_top_fields' => NULL,
    ), array('id' => $itemid));
    pdo_update('superman_hand2_position_order_log', array(
        'audit' => -2,
    ), array('itemid' => $itemid));
    itoast('操作成功！', '', 'success');
} else if ($act == 'sync_location') {
    $sql = "SELECT id, lng, lat FROM ".tablename('superman_hand2_item');
    $sql .= " WHERE uniacid={$_W['uniacid']} AND status=1  AND lng !='' AND lat !='' AND lng !='undefined' AND lat !='undefined' AND (province='' OR province='undefined' OR city='' OR city='undefined')";
    $pagesize = $this->module['config']['base']['lbs_api_count'] ? $this->module['config']['base']['lbs_api_count'] : 5;
    $sql .= " LIMIT 0, {$pagesize}";
    $list = pdo_fetchall($sql);
    if ($list) {
        foreach ($list as $li) {
            $location = SupermanHandUtil::location_transition($li['lat'], $li['lng'], $this->module['config']['base']['lbs_key']);
            if ($location['province'] && $location['city']) {
                $data = array(
                    'province' => $location['province'],
                    'city' => $location['city'],
                );
                pdo_update('superman_hand2_item', $data, array(
                    'id' => $li['id'],
                ));
            }
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
} else if ($act == 'get_authip') {
    $lat = '36.8183';
    $lng = '117.9906';
    $res = SupermanHandUtil::location_transition($lat, $lng, $_GPC['lbs_key']);
    if ($res && !is_array($res)) {
        $data_arr = explode('：', $res);
        $data = array(
            'ip' => $data_arr[1]
        );
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, $data);
}
include $this->template($this->web_template_path);
//物品过期时间
function pay_item_expiretime($num) {
    if ($num > 1) {
        return strtotime("+{$num} day");
    } else {
        $hour = ceil($num * 24);
        return strtotime("+{$hour} hour");
    }
}
//发布物品分类赠送积分
function get_credit($status, $itemid, $config) {
    $item = pdo_get('superman_hand2_item', array('id' => $itemid));
    $credit_uplimit = SupermanHandUtil::credit_uplimit($config['credit'], $config['credit']['category'][$item['cid']]);
    if ($status == 1
        && $item['credit_tip'] == 0
        && $credit_uplimit) {
        $category = pdo_get('superman_hand2_category', array(
            'id' => $item['cid'],
        ), 'title');
        $credit_log = array(
            $item['seller_uid'],
            '发布物品分类为'.$category['title'].'商品'.$item['title'],
            'superman_hand2',
        );
        $ret = mc_credit_update($item['seller_uid'], 'credit1', $config['credit']['category'][$item['cid']], $credit_log);
        if (is_error($ret)) {
            WeUtility::logging('fatal', '[item.inc.php: post credit update fail], ret='.var_export($ret, true));
        } else {
            pdo_update('superman_hand2_item', array(
                'credit_tip' => 1,
            ), array(
                'id' => $item['id'],
            ));
        }
    }
}