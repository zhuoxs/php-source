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
    'list',
    'detail',
    'post',
    'status',
    'audit',
    'confirm',
))?$_GPC['act']:'list';
if (isset($_GPC['state']) && in_array($_GPC['state'], array('list', 'post'))) {
    $act = $_GPC['state'];
}
if ($act == 'list') {
    $title = '分类列表';
    //取分类
    $cate_filter = array(
        'uniacid' => $_W['uniacid'],
        'status' => 1
    );
    $category = pdo_getall('superman_hand2_category', $cate_filter, '*', '', 'displayorder DESC');
    //banner图
    if ($this->plugin_module['plugin_ad']['module']
        && !$this->plugin_module['plugin_ad']['module']['is_delete']) {
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'skey' => 'banner_slide',
        );
        $setting = pdo_get('superman_hand2_kv', $filter, array('svalue'));
        $result['banner'] = $setting['svalue'] ? iunserializer($setting['svalue']) : array();
        if ($result['banner']) {
            foreach ($result['banner'] as &$baner) {
                $baner['img'] = tomedia($baner['img']);
                $link = SupermanHandUtil::get_links($_W['account']['type'], $baner['url']);
                if ($link) {
                    $baner['url'] = $link;
                }
            }
            unset($baner);
        }
    }
    //取列表
    $kw = trim($_GPC['kw']);
    $cid = intval($_GPC['cid']);
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 10;
    $start = ($pindex - 1) * $pagesize;
    if ($_GPC['op'] == 'location') {//距离排序
        $latitude = $_GPC['lat'];
        $longitude = $_GPC['lng'];
        $sql = "SELECT *,(ROUND(6378.137 * 2 * ASIN(SQRT(POW(SIN(((lat * PI()) / 180 - (:latitude * PI()) / 180) / 2), 2) + COS((:latitude * PI()) / 180) * COS((lat * PI()) / 180) * POW(SIN(((lng * PI()) / 180 - (:longitude * PI()) / 180) / 2), 2))), 2)) AS distance FROM ".tablename('superman_hand2_item');
        $sql .= " WHERE uniacid=:uniacid AND status IN (1,2)";
        if (!empty($cid)) {
            $sql .= " AND cid=:cid";
        }
        if (!empty($kw)) {
            $sql .= " AND (title LIKE '%{$kw}%' OR description LIKE '%{$kw}%')";
        }
        $sql .= " ORDER BY distance ASC LIMIT {$start},{$pagesize}";
        $params = array(
            ':uniacid' => $_W['uniacid'],
            ':latitude' => $latitude,
            ':longitude' => $longitude,
            ':cid' => $cid
        );
    } else if ($_GPC['op'] == 'popular') {//人气排序
        $params = array(
            ':uniacid' => $_W['uniacid'],
        );
        $sql = "SELECT * FROM ".tablename('superman_hand2_item')." AS a LEFT JOIN (SELECT item_id, COUNT(*) AS num FROM ".tablename('superman_hand2_comment')." GROUP BY item_id) AS b ON a.id = b.item_id";
        $sql .= " WHERE uniacid=:uniacid AND status IN (1,2)";
        if (!empty($cid)) {
            $sql .= " AND cid=:cid";
            $params[':cid'] = $cid;
        }
        if (!empty($kw)) {
            $sql .= " AND (title LIKE '%{$kw}%' OR description LIKE '%{$kw}%')";
        }
        $sql .= " ORDER BY num DESC LIMIT {$start},{$pagesize}";
    } else {
        $params = array(
            ':uniacid' => $_W['uniacid'],
        );
        $sql = "SELECT * FROM " . tablename('superman_hand2_item') . " WHERE uniacid=:uniacid";
        $sql .= " AND status IN(1,2)";
        if (!empty($cid)) {
            $sql .= " AND cid=:cid";
            $params[':cid'] = $cid;
        }
        if (!empty($kw)) {
            $sql .= " AND (title LIKE '%{$kw}%' OR description LIKE '%{$kw}%')";
        }
        $sql .= " ORDER BY pay_position DESC, createtime DESC LIMIT {$start},{$pagesize}";
    }

    $list = pdo_fetchall($sql, $params);
    if (!empty($list)) {
        foreach ($list as &$li) {
            SupermanHandModel::superman_hand2_item($li);
        }
        unset($li);
    }
    //无限滚动
    if ($_W['isajax'] && $_GPC['load'] == 'infinite') {
        die(json_encode($list));
    }
} else if ($act == 'detail') {
    $title = '物品详情';
    $id = $_GPC['id'];
    if (empty($id)) {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '', 'error');
    }
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'id' => $id
    );
    $detail = pdo_get('superman_hand2_item', $filter);
    //print_r($detail);
    SupermanHandModel::superman_hand2_item($detail);
    //查询此uid是否点赞或收藏
    $detail['is_favour'] = pdo_getcolumn('superman_hand2_action', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
        'item_id' => $id,
        'type' => 1
    ), 'COUNT(*)');
    $detail['is_collect'] = pdo_getcolumn('superman_hand2_action', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
        'item_id' => $id,
        'type' => 2
    ), 'COUNT(*)');
    //物品兑换订单
    if ($_GPC['orderid'] > 0) {
        $detail['order'] = pdo_get('superman_hand2_order', array(
            'uniacid' => $_W['uniacid'],
            'id' => $_GPC['orderid'],
        ), array('name', 'mobile', 'address', 'reply', 'reason'));
    }
    //物品浏览量+1
    pdo_update('superman_hand2_item', array(
        'page_view +=' => 1
    ), array('id' => $id));
    //共卖出多少物品及评价数量
    $detail['sell_count'] = pdo_getcolumn('superman_hand2_item', array(
        'uniacid' => $_W['uniacid'],
        'seller_uid' => $detail['seller_uid'],
        'status' => 2,
    ), 'COUNT(*)');
    $detail['level_one'] = pdo_getcolumn('superman_hand2_grade', array(
        'uniacid' => $_W['uniacid'],
        'seller_uid' => $detail['seller_uid'],
        'level' => 1,
    ), 'COUNT(*)');
    $detail['level_two'] = pdo_getcolumn('superman_hand2_grade', array(
        'uniacid' => $_W['uniacid'],
        'seller_uid' => $detail['seller_uid'],
        'level' => 2,
    ), 'COUNT(*)');
    $detail['level_three'] = pdo_getcolumn('superman_hand2_grade', array(
        'uniacid' => $_W['uniacid'],
        'seller_uid' => $detail['seller_uid'],
        'level' => 3,
    ), 'COUNT(*)');
    $notice = pdo_getall('superman_hand2_notice', array(
        'uniacid' => $_W['uniacid'],
        'position LIKE' => "%detail%",
        'status' => 1
    ), '*', '', 'displayorder DESC');
    //分享
    $_share = array(
        'title' => $detail['title'],
        'desc' => $detail['description'],
        'imgUrl' => $detail['cover'] ? tomedia($detail['cover']) : $_W['account']['logo']
    );
    //查询留言条数
    $com_filter = array(
        'uniacid' => $_W['uniacid'],
        'item_id' => $id,
        'status' => 1
    );
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 10;
    $start = ($pindex - 1) * $pagesize;
    $total = pdo_getcolumn('superman_hand2_comment', $filter, 'COUNT(*)');
    $orderby = 'createtime DESC';
    $list = pdo_getall('superman_hand2_comment', $com_filter, '*', '', $orderby, array($pindex, $pagesize));
    if (!empty($list)) {
        foreach ($list as &$li) {
            SupermanHandModel::superman_hand2_comment($li);
        }
        unset($li);
    }
    //发表留言
    if ($_GPC['comment']) {
        $comment_type = $this->module['config']['base']['comment'];
        $data = array(
            'uniacid' => $_W['uniacid'],
            'item_id' => $_GPC['id'],
            'uid' => $_W['member']['uid'],
            'message' => $_GPC['comment'],
            'createtime' => TIMESTAMP
        );
        if ($comment_type == 0) {
            $data['status'] = 1;
            $msg = '留言发布成功';
        } else {
            $data['status'] = 0;
            $msg = '留言提交成功，请等待管理员审核';
        }
        pdo_insert('superman_hand2_comment', $data);
        $new_id = pdo_insertid();
        if (empty($new_id)) {
            SupermanHandUtil::json(SupermanHandErrno::INSERT_FAIL, '留言发布失败');
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, $msg);
    }
    //回复留言
    if ($_GPC['reply']) {
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'id' => $_GPC['msg_id'],
        );
        $ret = pdo_update('superman_hand2_comment', array('reply' => $_GPC['reply']), $filter);
        if ($ret === false) {
            SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '');
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, '');
    }
    //点赞或收藏
    if ($_GPC['type']) {
        if ($_GPC['status']) {
            $filter = array(
                'uniacid' => $_W['uniacid'],
                'item_id' => $_GPC['id'],
                'uid' => $_W['member']['uid'],
                'type' => $_GPC['type']
            );
            $ret = pdo_delete('superman_hand2_action', $filter);
            if ($ret === false) {
                SupermanHandUtil::json(SupermanHandErrno::DELETE_FAIL);
            }
        } else {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'item_id' => $_GPC['id'],
                'uid' => $_W['member']['uid'],
                'type' => $_GPC['type'],
                'createtime' => TIMESTAMP
            );
            pdo_insert('superman_hand2_action', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                SupermanHandUtil::json(SupermanHandErrno::INSERT_FAIL);
            }
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, '');
    }
    //和ta聊聊
    if ($_GPC['chat']) {
        $chat_filter = array(
            'uniacid' => intval($_W['uniacid']),
            'itemid' => intval($_GPC['id']),
            'uid' => intval($_GPC['from_uid']),
            'from_uid' => intval($detail['seller_uid'])
        );
        $message = pdo_get('superman_hand2_message_list', $chat_filter);
        $url = '';
        if (!empty($message)) {
            $data = array(
                'status' => 1,
                'updatetime' => TIMESTAMP
            );
            $ret = pdo_update('superman_hand2_message_list', $data, array('id' => $message['id']));
            if ($ret === false) {
                SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '');
            } else {
                $url = $this->createMobileUrl('message', array('act' => 'list', 'from' => 'detail', 'id' => $message['id']));
            }
        } else {
            $data = array(
                'uniacid' => intval($_W['uniacid']),
                'itemid' => intval($_GPC['id']),
                'uid' => intval($_GPC['from_uid']),
                'from_uid' => intval($detail['seller_uid']),
                'status' => 1,
                'updatetime' => TIMESTAMP
            );
            pdo_insert('superman_hand2_message_list', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                SupermanHandUtil::json(SupermanHandErrno::INSERT_FAIL, '');
            } else {
                $url = $this->createMobileUrl('message', array('act' => 'list', 'from' => 'detail', 'id' => $new_id));
            }
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, '', array('url' => $url));
    }
    //切换物品状态
    if ($_GPC['status']) {
        $data = array(
            'status' => $_GPC['status']
        );
        $ret = pdo_update('superman_hand2_item', $data, array('uniacid' => $_W['uniacid'], 'id' => $id));
        if ($ret === false) {
            SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '更改物品状态失败');
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, '更改物品状态成功');
    }
} else if ($act == 'post') {
    checkauth();
    $id = $_GPC['id'];
    if ($id) {
        $title = '编辑';
        $detail = pdo_get('superman_hand2_item', array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']));
        SupermanHandModel::superman_hand2_item($detail);
    } else {
        $title = '发布物品';
    }
    $category = pdo_getall('superman_hand2_category', array('uniacid' => $_W['uniacid'], 'status' => 1), '*', '', 'displayorder DESC');
    $district = pdo_getall('superman_hand2_district', array('uniacid' => $_W['uniacid'], 'status' => 1), '*', '', 'displayorder DESC');
    if (checksubmit()) {
        $serverIds = $_GPC['serverIds'];
        if (!empty($serverIds)) {
            if (strpos($serverIds, ',') === false) {
                $serverIds = array($serverIds);
            } else {
                $serverIds = explode(',', $serverIds);
            }
            foreach ($serverIds as &$li) {
                if (strpos($li, 'http') === false) {
                    $li = saveItemImg($li);
                }
            }
            unset($li);
        }
        $cid = intval($_GPC['cid']);
        $data = array(
            'title' => $_GPC['title'],
            'cid' => $cid,
            'description' => $_GPC['description'],
            'album' => $serverIds != ''?iserializer($serverIds):'',
            'price' => $_GPC['price'],
            'credit' => $_GPC['credit'],
            'address' => $_GPC['address'],
            'buy_type' => $_GPC['buy_type'],
            'wechatpay' => $_GPC['wechatpay'],
        );
        //自定义表单
        $add_fields = $this->module['config']['post']['form_fields'];
        $fields_value = $_GPC['fields_value'];
        if (!empty($add_fields) && !empty($fields_value)) {
            foreach ($add_fields as $key => $val) {
                if ($val['required'] == 1) { //判断是否必填
                    if (!isset($fields_value[$key]) || $fields_value[$key] == ''
                        || $fields_value[$key] == array()) {
                        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '请输入'.$val['title']);
                    }
                }
                if (empty($fields_value[$key])) {
                    $fields[$key] = array(
                        'title' => $val['title'],
                        'type' => $val['type'],
                        'required' => $val['required'],
                        'value' => '',
                        'extra' => $val['extra'],
                    );
                } else {
                    if (strpos($fields_value[$key], ',') !== false) {
                        $fields_value[$key] = explode(',', $fields_value[$key]);
                    }
                    $fields[$key] = array(
                        'title' => $val['title'],
                        'type' => $val['type'],
                        'required' => $val['required'],
                        'value' => $fields_value[$key],
                        'extra' => $val['extra'],
                    );
                }
            }
            $data['add_fields'] = iserializer($fields);
        }
        $audit_type = $this->module['config']['base']['audit'];
        if ($audit_type == 0) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        if ($id) {
            if (empty($detail['province']) || empty($detail['city']) && $detail['lat'] && $detail['lng']) {
                $location = SupermanHandUtil::location_transition($detail['lat'], $detail['lng'], $this->module['config']['base']['lbs_key']);
                if ($location['province'] && $location['city']) {
                    $data['province'] = $location['province'];
                    $data['city'] = $location['city'];
                    $data['address'] = $location['address'];
                }
            }
            $data['updatetime'] = TIMESTAMP;
            $ret = pdo_update('superman_hand2_item', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
            if ($ret === false) {
                SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '物品更新失败');
            }
            $url = $_W['siteroot'].'app/'.$this->createMobileUrl('item', array('act' => 'audit', 'id' => $id));
            $settop_url = $_W['siteroot'].'app/'.$this->createMobileUrl('pay_top', array('itemid' => $id));
        } else {
            if (!empty($_GPC['longitude']) && !empty($_GPC['latitude'])) {
                $location = SupermanHandUtil::location_transition($_GPC['latitude'], $_GPC['longitude'], $this->module['config']['base']['lbs_key']);
                if ($location['province'] && $location['city']) {
                    $data['province'] = $location['province'];
                    $data['city'] = $location['city'];
                    $data['address'] = $location['address'];
                }
            }
            $data['lng'] = $_GPC['longitude'];
            $data['lat'] = $_GPC['latitude'];
            $data['createtime'] = TIMESTAMP;
            $data['uniacid'] = $_W['uniacid'];
            $data['seller_uid'] = $_W['member']['uid'];
            pdo_insert('superman_hand2_item', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                SupermanHandUtil::json(SupermanHandErrno::INSERT_FAIL, '物品发布失败');
            }
            $url = $_W['siteroot'].'app/'.$this->createMobileUrl('item', array('act' => 'audit', 'id' => $new_id));
            $settop_url = $_W['siteroot'].'app/'.$this->createMobileUrl('pay_top', array('itemid' => $new_id));
        }
        //发送模版消息
        if ($audit_type == '1') {
            $openid = $this->module['config']['tmpl']['audit_remind']['openids'];
            $tpl_id = $this->module['config']['tmpl']['audit_remind']['tmpl_id'];
            $post_data = SupermanHandModel::superman_hand2_item($data);
            $message_data = array(
                'first' => array(
                    'value' => '用户:'.$post_data['nickname'].'发布新品，待您审核',
                ),
                'keyword1' => array(
                    'value' => $post_data['title'],
                ),
                'keyword2' => array(
                    'value' => $id?$data['updatetime']:$post_data['createtime'],
                ),
                'keyword3' => array(
                    'value' => $post_data['description']?$post_data['description']:$post_data['title'],
                ),
                'remark' => array(
                    'value' => '点此进入审核该物品',
                ),
            );
            if (is_array($openid)) {
                foreach ($openid as $id) {
                    if ($id) {
                        $id = trim($id);
                        SupermanHandUtil::send_tmplmsg($message_data, $id, $tpl_id, $url);
                    }
                }
            }
            $msg = '已提交，请等待管理员审核';
        } else {
            $msg = '发布成功';
        }
        //日发布数量统计
        $sql = "UPDATE ".tablename('superman_hand2_stat').' SET item_submit=item_submit+1 WHERE ';
        $sql .= " uniacid={$_W['uniacid']} AND daytime=".date('Ymd');
        pdo_query($sql);

        $config_credit = $this->module['config']['credit'];
        //首次发布赠送积分
        $member_log = pdo_get('superman_hand2_member_log', array(
            'uniacid' => $_W['uniacid'],
            'uid' => $_W['member']['uid'],
        ));
        $credit_uplimit = SupermanHandUtil::credit_uplimit($config_credit, $config_credit['upload']);
        if ($data['status'] == 1
            && $member_log['upload'] == 0
            && $credit_uplimit) {
            $credit_log = array(
                $_W['member']['uid'],
                '首次发布商品'.$_GPC['title'],
                'superman_hand2',
            );
            $ret = mc_credit_update($_W['member']['uid'], 'credit1', $config_credit['upload'], $credit_log);
            if (is_error($ret)) {
                WeUtility::logging('fatal', '[item.inc.php: post], ret='.var_export($ret, true));
            }
            $data = array(
                'upload' => 1
            );
            pdo_update('superman_hand2_member_log', $data, array(
                'id' => $member_log['id'],
            ));
        }
        //物品分类赠送积分
        $credit_uplimit = SupermanHandUtil::credit_uplimit($config_credit, $config_credit['category'][$cid]);
        if ($data['status'] == 1
            && empty($id)
            && $credit_uplimit) {
            $credit_log = array(
                $_W['member']['uid'],
                '发布物品分类为'.$_GPC['category'].'商品'.$_GPC['title'],
                'superman_hand2',
            );
            $ret = mc_credit_update($_W['member']['uid'], 'credit1', $config_credit['category'][$cid], $credit_log);
            if (is_error($ret)) {
                WeUtility::logging('fatal', '[item.inc.php: post credit update fail], ret='.var_export($ret, true));
            }
            pdo_update('superman_hand2_item', array(
                'credit_tip' => 1,
            ), array(
                'id' => $new_id,
                'uniacid' => $_W['uniacid']
            ));
            $msg .= '+'.$config_credit['category'][$cid].'积分';
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, $msg, array(
            'url' => $this->createMobileUrl('home'),
            'settop_url' => $settop_url,
        ));
    }
} else if ($act == 'status') {
    $status = intval($_GPC['status']);
    //TODO

    if ($status == 2) {
        //日交易量统计
        $sql = "UPDATE ".tablename('superman_hand2_stat').' SET item_trade=item_trade+1 WHERE ';
        $sql .= " uniacid={$_W['uniacid']} AND daytime=".date('Ymd');
        pdo_query($sql);
    }
} else if ($act == 'audit') {
    $title = '物品审核';
    $id = $_GPC['id'];
    if (empty($id)) {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '', 'error');
    }
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'id' => $id
    );
    $item = pdo_get('superman_hand2_item', $filter);
    SupermanHandModel::superman_hand2_item($item);
    if (checksubmit()) {
        $ret = pdo_update('superman_hand2_item', array('status' => $_GPC['status'], 'reason' => $_GPC['reason']), $filter);
        if ($ret === false) {
            SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '数据库更新失败', 'error');
        }
        //发送模版消息
        $openid = mc_uid2openid($item['seller_uid']);
        $tpl_id = $this->module['config']['tmpl']['audit_result']['tmpl_id'];
        $message_data = array(
            'first' => array(
                'value' => '您好，以下是您发布信息的审核结果',
                //'color' => '#173177',
            ),
            'keyword1' => array(
                'value' => $item['category'],
                //'color' => '#173177',
            ),
            'keyword2' => array(
                'value' => $item['title'],
                //'color' => '#173177',
            ),
            'keyword3' => array(
                'value' => $item['createtime'],
                //'color' => '#173177',
            ),
            'keyword4' => array(
                'value' => $_GPC['status']==1?'审核通过':'审核不通过，原因是'.$_GPC['reason'],
            ),
            'remark' => array(
                'value' => '如有疑问请联系客服',
            ),
        );
        SupermanHandUtil::send_tmplmsg($message_data, $openid, $tpl_id, '');
        SupermanHandUtil::json(SupermanHandErrno::OK, '提交成功', array('url' => $this->createMobileUrl('home')));
    }
} else if ($act == 'confirm') {
    $title = '购买物品';
    if ($_GPC['type'] == 'credit') {
        $title = '兑换物品';
    }
    $id = intval($_GPC['id']);
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'id' => $id
    );
    $item = pdo_get('superman_hand2_item', $filter);
    if (empty($item)) {
        message('物品不存在', '', 'error');
    }
    SupermanHandModel::superman_hand2_item($item);
    if (checksubmit()) {
        if ($item['status'] != 1) {
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '物品状态未上架或已交易');
        }
        //积分兑换
        if ($item['buy_type'] == 1) {
            if ($item['seller_uid'] == $_W['member']['uid']) {
                SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '发布者不可以兑换自己的物品');
            }
            $sql = 'SELECT SUM(credit) AS credit FROM '.tablename('superman_hand2_member_block_credit').'WHERE uniacid=:uniacid AND uid=:uid';
            $params = array(
                ':uniacid' => $_W['uniacid'],
                ':uid' => $_W['member']['uid']
            );
            $block_credit = pdo_fetch($sql, $params);
            $credit1 = $_W['member']['credit1'] - $block_credit['credit'];
            if ($item['credit'] > $credit1) {
                SupermanHandUtil::json(SupermanHandErrno::CREDIT_NOT_ENOUGH);
            }
        }

        //待支付订单删除
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'itemid' => $id,
            'buyer_uid' => $_W['member']['uid'],
            'status' => 0,
        );
        $row = pdo_get('superman_hand2_order', $filter);
        if ($row) {
            pdo_delete('superman_hand2_order', array('id' => $row['id']));
        }
        //创建兑换订单
        $ordersn = SupermanHandUtil::create_ordersn();
        $data = array(
            'uniacid' => $_W['uniacid'],
            'itemid' => $id,
            'title' => $item['title'],
            'ordersn' => $ordersn,
            'seller_uid' => $item['seller_uid'],
            'buyer_uid' => $_W['member']['uid'],
            'credit' => $item['credit'],
            'price' => $item['price'],
            'paytype' => $item['buy_type'] == 1 ? 1 : 2,
            'name' => $_GPC['username'],
            'mobile' => $_GPC['mobile'],
            'address' => $_GPC['address'],
            'status' => 0,
            'reply' => $_GPC['remark'],
            'createtime' => TIMESTAMP,
        );
        pdo_insert('superman_hand2_order', $data);
        $orderid = pdo_insertid();
        if (empty($orderid)) {
            SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '订单插入失败', 'error');
        }
        if ($item['buy_type'] == 1) {  //积分兑换
            //更新物品状态
            $ret = pdo_update('superman_hand2_item', array(
                'status' => 2,
                'buyer_uid' => $_W['member']['uid']
            ), array(
                'id' => $item['id'],
            ));
            if ($ret === false) {
                SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '物品状态更新失败', 'error');
            }
            //冻结买家积分
            $block_data = array(
                'uniacid' => $_W['uniacid'],
                'itemid' => $itemid,
                'credit' => $item['credit'],
                'uid' => $_W['member']['uid'],
                'remark' => '兑换商品'.$item['title'],
                'createtime' => TIMESTAMP,
            );
            pdo_insert('superman_hand2_member_block_credit', $block_data);
            $block_id = pdo_insertid();
            if (empty($block_id)) {
                SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '数据库更新失败', 'error');
            }
            pdo_update('superman_hand2_order', array(
                'status' => 1,
                'paytype' => 1,
            ), array(
                'id' => $orderid,
            ));
            //发送模板消息
            //todo
        } else {  //微信支付
            if (!$this->plugin_module['plugin_wechat']['module']
                || $this->plugin_module['plugin_wechat']['module']['is_delete']) {
                SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '微信支付插件未开启', 'error');
            }
            //微信支付
            $params = array(
                'tid' => 'superman_hand2_wechat:'.$orderid,
                'user' => $_W['openid'],
                'fee' => $item['price'],
                'title' => '购买物品订单('.$ordersn.')支付',
                'uniacid' => $_W['uniacid'],
                'appid' => $_W['account']['key'],
            );
            $file = IA_ROOT . "/addons/{$this->plugin_module['plugin_wechat']['module']['name']}/mobile.php";
            $classname = "{$this->plugin_module['plugin_wechat']['module']['name']}ModuleMobile";
            if (is_file($file)) {
                require $file;
            } else {
                WeUtility::logging('fatal', '缺少微信支付插件模块文件, file='.$file);
                SupermanHandUtil::json(-1, '支付失败，请重试');
            }
            $site = new $classname();
            $result = $site->wechat_pay($params);
            if (is_error($result)) {
                WeUtility::logging('fatal', '[cashier.inc.php], result='.var_export($result, true));
                SupermanHandUtil::json(-1, '支付失败，请重试');
            }
        }
        $result['redirect_url'] = murl('entry', array(
            'do' => 'order',
            'm' => 'superman_hand2',
            'act' => 'display',
            'type' => 'buy',
        ), true, true);
        SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
    }
}
include $this->template('item/'.$act);
//下载微信图片
function saveItemImg($serverId) {
    global $_W;
    //初始化路径
    $path = "images/{$_W['uniacid']}/" . date('Y/m');
    $filename = md5($serverId) . '.jpg';
    $thumbname = md5($serverId) . '_thumb.jpg';
    $allpath = IA_ROOT .'/attachment/'. $path;
    $avatar_file = $allpath . '/' . $filename;
    $thumb_file = $allpath . '/' . $thumbname;//缩略图
    mkdirs($allpath);

    //下载微信图片
    load()->model('account');
    $acc = WeAccount::create($_W['account']['acid']);
    $token = $acc->getAccessToken();
    if (is_error($token)) {
        WeUtility::logging('fatal', 'token error, message=' . $token['message']);
        SupermanHandUtil::json(SupermanHandErrno::SYSTEM_ERROR, 'token error');
    }
    load()->func('communication');
    $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token={$token}&media_id={$serverId}";
    $resp = ihttp_request($url);
    if (is_error($resp)) {
        WeUtility::logging('fatal', 'request error, message=' . $resp['message']);
        SupermanHandUtil::json(SupermanHandErrno::SYSTEM_ERROR, 'request error');
    }
    //检查图片是否下载成功
    $content = json_decode($resp['content'], true);
    if (isset($content['errcode']) && $content['errcode'] > 0) {
        WeUtility::logging('fatal', '[save_img]get media_id error, $content=' . var_export($content, true));
    } else {
        //保存图片
        $fp = @fopen($avatar_file, 'wb');
        @fwrite($fp, $resp['content']);
        @fclose($fp);
        $new_avatar = $path . '/' . $filename;
        file_image_thumb($avatar_file, $thumb_file, 100);
        //上传至远程附件
        $img = $path . $filename;
        $thumb = $path . $thumbname;
        $img_arr = array($img, $thumb);
        SupermanHandUtil::sync_remote_file($img_arr);

        return $new_avatar;
    }
}