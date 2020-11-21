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
    'detail',  //物品详情
    'get',     //获取分类、小区列表信息
    'edit',    //编辑的物品信息
    'post',    //表单提交
    'upload',  //上传文件
    'status',  //物品切换状态
    'audit',
    'submit',  //提交物品订单,
    'report',  //举报
    'get_phone_number' //获取微信手机号
))?$_GPC['act']:'list';
if (isset($_GPC['state']) && in_array($_GPC['state'], array('list', 'post'))) {
    $act = $_GPC['state'];
}
if ($act == 'list') {
    $category = pdo_getall('superman_hand2_category', array(
        'uniacid' => $_W['uniacid'],
        'status' => 1
    ), '*', '', 'displayorder DESC');
    //取列表
    $kw = trim($_GPC['kw']);
    $cid = intval($_GPC['cid']);
    $city = trim($_GPC['city']);
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 10;
    $start = ($pindex - 1) * $pagesize;
    $params = array(
        ':uniacid' => $_W['uniacid'],
        ':cid' => $cid
    );
    if ($_GPC['op'] == 'location') {//距离排序
        $latitude = $_GPC['lat'];
        $longitude = $_GPC['lng'];
        $sql = "SELECT *,(ROUND(6378.137 * 2 * ASIN(SQRT(POW(SIN(((lat * PI()) / 180 - (:latitude * PI()) / 180) / 2), 2) + COS((:latitude * PI()) / 180) * COS((lat * PI()) / 180) * POW(SIN(((lng * PI()) / 180 - (:longitude * PI()) / 180) / 2), 2))), 2)) AS distance FROM ".tablename('superman_hand2_item')." WHERE uniacid=:uniacid AND cid=:cid";
        $orderby = " ORDER BY distance ASC LIMIT {$start},{$pagesize}";
        $params[':latitude'] = $latitude;
        $params[':longitude'] = $longitude;
    } else if ($_GPC['op'] == 'popular') {//人气排序
        $sql = "SELECT * FROM ".tablename('superman_hand2_item')." WHERE uniacid=:uniacid AND cid=:cid";
        $orderby = " ORDER BY page_view DESC, createtime DESC LIMIT {$start},{$pagesize}";
    } else {
        $sql = "SELECT * FROM " . tablename('superman_hand2_item') . " WHERE uniacid=:uniacid AND cid=:cid";
        $orderby = " ORDER BY id DESC LIMIT {$start},{$pagesize}";
    }
    if ($this->module['config']['base']['hide_sold']) {
        $sql .= " AND status=1";
    } else {
        $sql .= " AND status IN (1,2)";
    }
    $sql .= " AND (expiretime = 0 OR expiretime >".TIMESTAMP.")";
    $list = pdo_fetchall($sql.$orderby, $params);
    if (!empty($list)) {
        foreach ($list as &$li) {
            SupermanHandModel::superman_hand2_item($li);
        }
        unset($li);
        // 筛选后台发布的不在指定区域的物品
        if($_GPC['lng'] && $_GPC['lat']) {
            foreach ($list as $key => $li) {
                if ($li['item_type'] == -1) {
                    if ($li['expiretime'] > 0 && $li['expiretime'] < TIMESTAMP) {
                        unset($list[$key]);
                        continue;
                    }
                    if (empty($li['area_points'])) {
                        continue;
                    }
                    $tencent_points = array();
                    $area_points = $li['area_points'] ? iunserializer($li['area_points']) : array();
                    foreach ($area_points as $ap) {
                        $tencent_points[] = SupermanHandUtil::Convert_BD09_To_GCJ02($ap['lat'], $ap['lng']);
                    }
                    $point = array(
                        'lng' => $_GPC['lng'],
                        'lat' => $_GPC['lat']
                    );
                    $ret = SupermanHandUtil::is_point_in_polygon($point, $tencent_points);
                    if (!$ret) {
                        unset($list[$key]);
                        $list = array_values($list);
                    }
                }
            }
        }
        // 删除list中的置顶物品
        if ($_GPC['op'] != 'location') {
            foreach ($list as $key => $li) {
                if ($li['pay_position'] == 1) {
                    $fields = $li['set_top_fields'];
                    foreach ($fields as $fl) {
                        if ($fl['district'] == $_GPC['district']) {
                            if ($_GPC['op'] == 'new' && $fl['position'] != 2) {
                                unset($list[$key]);
                                break;
                            }
                            if ($_GPC['op'] == 'popular' && $fl['position'] != 1) {
                                unset($list[$key]);
                                break;
                            }
                        }
                    }
                }
            }
            $list = array_values($list);
        }
    }
    // 筛选出置顶物品
    $top_list = pdo_getall('superman_hand2_item', array(
        'uniacid' => $_W['uniacid'],
        'status' => 1,
        'pay_position' => 1,
        'cid' => $cid
    ));
    if (!empty($top_list)) {
        shuffle($top_list); // 置顶物品随机排序
        foreach ($top_list as &$li) {
            SupermanHandModel::superman_hand2_item($li);
        }
        unset($li);
    }
    $result = array(
        'category' => $category,
        'thumb' => $this->module['config']['base']['thumb']?$this->module['config']['base']['thumb']:0,
        'list' => $list,
        'top_items' => $top_list, // 置顶物品
    );
    //banner图
    if ($this->plugin_module['plugin_ad']['module'] && !$this->plugin_module['plugin_ad']['module']['is_delete']) {
        //幻灯图
        $slide = pdo_getall('superman_hand2_banner', array('uniacid' => $_W['uniacid'], 'position' => 2), '*', '', 'displayorder DESC');
        if ($slide) {
            //限制幻灯图地区
            if($_GPC['lng'] && $_GPC['lat']) {
                foreach ($slide as $key => $ia) {
                    if (($ia['endtime'] > 0 && $ia['endtime'] < TIMESTAMP) || $ia['starttime'] > TIMESTAMP) {
                        unset($slide[$key]);
                        continue;
                    }
                    if (empty($ia['area_points'])) {
                        continue;
                    }
                    $tencent_points = array();
                    $area_points = $ia['area_points'] ? iunserializer($ia['area_points']) : array();
                    foreach ($area_points as $ap) {
                        $tencent_points[] = SupermanHandUtil::Convert_BD09_To_GCJ02($ap['lat'], $ap['lng']);
                    }
                    $point = array(
                        'lng' => $_GPC['lng'],
                        'lat' => $_GPC['lat']
                    );
                    $ret = SupermanHandUtil::is_point_in_polygon($point, $tencent_points);
                    if (!$ret) {
                        unset($slide[$key]);
                    }
                }
                $slide = array_values($slide);
            }
            if ($this->module['config']['banner']['random'] == 1) {
                shuffle($slide); //随机排列
            }
            foreach ($slide as &$item) {
                $item['img'] = tomedia($item['thumb']);
            }
            unset($item);
            $result['banner'] = $slide;
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'detail') {
    $id = $_GPC['id'];
    if (empty($id)) {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '', 'error');
    }
    $detail = pdo_get('superman_hand2_item', array(
        'uniacid' => $_W['uniacid'],
        'id' => $id
    ));
    SupermanHandModel::superman_hand2_item($detail);
    //发表留言
    if ($_GPC['comment']) {
        $comment_type = $this->module['config']['base']['comment'];
        $data = array(
            'uniacid' => $_W['uniacid'],
            'item_id' => $id,
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
        if ($comment_type == 0) {
            //发送模板消息
            $res = SupermanHandUtil::get_uid_formid($detail['seller_uid']);
            $openid = SupermanHandUtil::uid2openid($detail['seller_uid']);
            $url = 'pages/detail/index?id='.$id;
            $member = mc_fetch_one($_W['member']['uid']);
            if ($res['formid']) {
                $tpl_id = $this->module['config']['minipg']['msg_remind']['tmpl_id'];
                $message_data = array(
                    'first' => array(
                        'value' => '您有新的留言消息。。。',
                        //'color' => '#173177',
                    ),
                    'keyword1' => array(
                        'value' => date('Y-m-d h:i:s', TIMESTAMP),  //留言时间
                        //'color' => '#173177',
                    ),
                    'keyword2' => array(
                        'value' => $_GPC['comment'],  //留言内容
                        //'color' => '#173177',
                    ),
                    'keyword3' => array(
                        'value' => $member['nickname'],  //留言人
                        //'color' => '#173177',
                    ),
                    'keyword4' => array(
                        'value' => $detail['title'],
                    ),
                );
                $ret = SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
                if ($ret) {
                    SupermanHandUtil::delete_uid_formid($res['id']);
                }
            } else {
                $uni_tpl_id = $this->module['config']['tmpl']['msg_remind']['tmpl_id'];
                $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
                if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                    $message_data = array(
                        'first' => array(
                            'value' => '您收到了新的留言',
                            'color' => '#173177'
                        ),
                        'keyword1' => array(
                            'value' => $member['nickname'],
                        ),
                        'keyword2' => array(
                            'value' => date('Y-m-d h:i:s', TIMESTAMP),
                        ),
                        'keyword3' => array(
                            'value' => $_GPC['comment'],
                        ),
                        'remark' => array(
                            'value' => '请进入小程序查看',
                            'color' => '#173177'
                        ),
                    );
                    SupermanHandUtil::send_uniform_msg($message_data, $openid, $uni_tpl_id, $gzh_appid, $url);
                }
            }
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, $msg);
    }
    //回复留言
    if ($_GPC['reply']) {
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'id' => $_GPC['msg_id'],
        );
        $message = pdo_get('superman_hand2_comment', $filter);
        $ret = pdo_update('superman_hand2_comment', array('reply' => $_GPC['reply']), $filter);
        if ($ret === false) {
            SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '');
        }
        //发送模板消息
        $res = SupermanHandUtil::get_uid_formid($message['uid']);
        $openid = SupermanHandUtil::uid2openid($message['uid']);
        $url = 'pages/detail/index?id='.$id;
        $member = mc_fetch_one($detail['seller_uid']);
        if ($res['formid']) {
            $tpl_id = $this->module['config']['minipg']['msg_remind']['tmpl_id'];
            $message_data = array(
                'first' => array(
                    'value' => '您有新的留言回复消息。。。',
                    //'color' => '#173177',
                ),
                'keyword1' => array(
                    'value' => date('Y-m-d h:i:s', time()),  //留言时间
                    //'color' => '#173177',
                ),
                'keyword2' => array(
                    'value' => $_GPC['reply'],  //留言内容
                    //'color' => '#173177',
                ),
                'keyword3' => array(
                    'value' => $member['nickname'],  //留言人
                    //'color' => '#173177',
                ),
                'keyword4' => array(
                    'value' => $detail['title'],
                ),
            );
            $ret = SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
            if ($ret) {
                SupermanHandUtil::delete_uid_formid($res['id']);
            }
        } else {
            $uni_tpl_id = $this->module['config']['tmpl']['msg_remind']['tmpl_id'];
            $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
            if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                $message_data = array(
                    'first' => array(
                        'value' => '您的留言有了新的回复',
                        'color' => '#173177'
                    ),
                    'keyword1' => array(
                        'value' => $member['nickname'],
                    ),
                    'keyword2' => array(
                        'value' => date('Y-m-d h:i:s', TIMESTAMP),
                    ),
                    'keyword3' => array(
                        'value' => $_GPC['reply'],
                    ),
                    'remark' => array(
                        'value' => '请进入小程序查看',
                        'color' => '#173177'
                    ),
                );
                SupermanHandUtil::send_uniform_msg($message_data, $openid, $uni_tpl_id, $gzh_appid, $url);
            }
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, '');
    }
    //点赞或收藏
    if ($_GPC['type']) {
        if ($_GPC['status']) {
            $filter = array(
                'uniacid' => $_W['uniacid'],
                'item_id' => $id,
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
                'item_id' => $id,
                'uid' => $_W['member']['uid'],
                'type' => $_GPC['type'],
                'is_check' => 0,
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
    //物品浏览量+1
    pdo_update('superman_hand2_item', array(
        'page_view +=' => 1
    ), array('id' => $id));
    //物品兑换订单
    if ($_GPC['orderid'] > 0) {
        $detail['order'] = pdo_get('superman_hand2_order', array(
            'uniacid' => $_W['uniacid'],
            'id' => $_GPC['orderid'],
        ), array('name', 'mobile', 'address', 'reply', 'reason'));
    }
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
    //和他聊聊是否隐藏
    $detail['chat'] = $this->module['config']['base']['chat'] ? 0 : 1;
    $detail['chat_text'] = $this->module['config']['base']['chatText'] ? $this->module['config']['base']['chatText'] : '和他聊聊';
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

    //和ta聊聊
    if ($_GPC['chat']) {
        $chat_filter = array(
            'uniacid' => intval($_W['uniacid']),
            'itemid' => intval($id),
            'uid' => intval($_GPC['from_uid']),
            'from_uid' => intval($detail['seller_uid'])
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
                'itemid' => intval($_GPC['id']),
                'uid' => intval($_GPC['from_uid']),
                'from_uid' => intval($detail['seller_uid']),
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
        $config_credit = $this->module['config']['credit'];
        $credit_uplimit = SupermanHandUtil::credit_uplimit($config_credit, $config_credit['category'][$detail['cid']]);
        //下架扣除积分
        if ($_GPC['status'] == -1
            && $config_credit['open'] == 1) {
            $credit_log = array(
                $detail['seller_uid'],
                '下架物品'.$detail['title'],
                'superman_hand2',
            );
            $ret1 = mc_credit_update($detail['seller_uid'], 'credit1', -$config_credit['category'][$detail['cid']], $credit_log);
            if (is_error($ret1)) {
                WeUtility::logging('fatal', '[[item.inc.php: post] update seller_uid credit fail], ret1='.var_export($ret, true));
            }
        } else if ($_GPC['status'] == 1
            && $detail['status'] == -1
            && $credit_uplimit) {
            $credit_log = array(
                $detail['seller_uid'],
                '发布物品'.$detail['title'],
                'superman_hand2',
            );
            $ret1 = mc_credit_update($detail['seller_uid'], 'credit1', $config_credit['category'][$detail['cid']], $credit_log);
            if (is_error($ret1)) {
                WeUtility::logging('fatal', '[[item.inc.php: post] update seller_uid credit fail], ret1='.var_export($ret, true));
            }
        }
        if ($_GPC['status'] == 2) {
            //统计日成交量
            SupermanHandUtil::stat_day_item_trade();
            //创建订单
            $item = pdo_get('superman_hand2_item', array(
                'id' => $id
            ));
            $data = array(
                'uniacid' => $_W['uniacid'],
                'itemid' => $item['id'],
                'title' => $item['title'],
                'seller_uid' => $_W['member']['uid'],
                'buyer_uid' => 0,
                'price' => $item['price'],
                'status' => 3,
                'createtime' => TIMESTAMP,
            );
            pdo_insert('superman_hand2_order', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '订单插入失败', 'error');
            }
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, '更改物品状态成功');
    }
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
    //公告
    $notice = pdo_getall('superman_hand2_notice', array(
        'uniacid' => $_W['uniacid'],
        'status' => 1,
        'position LIKE' => "%detail%",
        'starttime <' => TIMESTAMP,
        'endtime >' => TIMESTAMP,
    ), '*', '', 'displayorder DESC');
    //限制公告地区
    if($_GPC['lng'] && $_GPC['lat'] && $notice) {
        foreach ($notice as $key => $ia) {
            if (empty($ia['area_points'])) {
                continue;
            }
            $tencent_points = array();
            $area_points = $ia['area_points'] ? iunserializer($ia['area_points']) : array();
            foreach ($area_points as $ap) {
                $tencent_points[] = SupermanHandUtil::Convert_BD09_To_GCJ02($ap['lat'], $ap['lng']);
            }
            $point = array(
                'lng' => $_GPC['lng'],
                'lat' => $_GPC['lat']
            );
            $ret = SupermanHandUtil::is_point_in_polygon($point, $tencent_points);
            if (!$ret) {
                unset($notice[$key]);
                $notice = array_values($notice);
            }
        }
    }
    $result = array(
        'item' => $detail,
        'message' => $list,
        'set_top' => $this->module['config']['set_top']['open'] == 0 ? 0 : 1,
        'notice' => $notice,
        'notice_type' => $this->module['config']['base']['notice_type']?$this->module['config']['base']['notice_type']:0,
    );
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'get') {
    $category = pdo_getall('superman_hand2_category', array('uniacid' => $_W['uniacid'], 'status' => 1), '*', '', 'displayorder DESC');
    if ($category) {
        foreach ($category as &$li) {
            $li['cover'] = tomedia($li['cover']);
        }
        unset($li);
    }
    $district = pdo_getall('superman_hand2_district', array('uniacid' => $_W['uniacid'], 'status' => 1), '*', '', 'displayorder DESC');
    $base = $this->module['config']['base'];
    $rule = htmlspecialchars_decode($base['rule']);
    $notice = htmlspecialchars_decode($base['notice']);  //发布须知
    $video_switch = $base['video']?1:0;
    $result = array(
        'category' => $category,
        'district' => $district,
        'rule' => $rule,
        'video_switch' => $video_switch,
        'notice' => $notice,
        'default_unit' => $this->module['config']['base']['default_unit']?$this->module['config']['base']['default_unit']:0,
        'post_notice' => $this->module['config']['base']['notice_open']?$this->module['config']['base']['notice_open']:0,
        'show_trade' => $this->module['config']['base']['show_trade']?$this->module['config']['base']['show_trade']:0,
        'audit_type' => $this->module['config']['base']['audit'],
        'add_fields' => $this->module['config']['post']['fields_on'] ? $this->module['config']['post']['form_fields'] : '',
        'set_top' => $this->module['config']['set_top']['open'] == 0 ? 0 : 1,
        'book_status' => $this->module['config']['base']['book'] ? $this->module['config']['base']['book'] : 0,
        'unit_list' => $this->module['config']['currency']?$this->module['config']['currency']:'',
    );
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'edit') {
    $id = $_GPC['id'];
    if ($id) {
        $detail = pdo_get('superman_hand2_item', array('uniacid' => $_W['uniacid'], 'id' => $_GPC['id']));
        SupermanHandModel::superman_hand2_item($detail);
        SupermanHandUtil::json(SupermanHandErrno::OK, '', $detail);
    } else {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '', 'error');
    }
} else if ($act == 'post') {
    $result = array();
    $blacklist = SupermanHandUtil::check_blacklist();
    if ($blacklist) {
        SupermanHandModel::superman_hand2_blacklist($blacklist);
        SupermanHandUtil::json(SupermanHandErrno::ACCOUNT_BLOCK, '账号已封禁, 封禁截止时间:'.$blacklist['blocktime'], 'error');
    }
    //检查图书
    if (!empty($_GPC['isbn'])) {
        $filter = array(
            'uniacid' => $_W['uniacid'],
            'seller_uid' => $_W['member']['uid'],
            'status' => 1,
            'isbn' => $_GPC['isbn']
        );
        $row = pdo_get('superman_hand2_item', $filter);
        if ($row) {
            SupermanHandUtil::json(SupermanHandErrno::BOOK_EXIST, '', 'error');
        }
    }
    $album = $_GPC['album'];
    if($album) {
        $album = json_decode(base64_decode($album), true);
        if (count($album) > 9) {
            SupermanHandUtil::json(SupermanHandErrno::UPLOAD_MAX, '', 'error');
        }
    }
    $thumb = $_GPC['thumb'];
    if($thumb) {
        $thumb = json_decode(base64_decode($thumb), true);
    }
    $video = $_GPC['video'];
    if($video) {
        $video = json_decode(base64_decode($video), true);
        if (count($video) > 9) {
            SupermanHandUtil::json(SupermanHandErrno::UPLOAD_MAX, '', 'error');
        }
    }
    $cid = intval($_GPC['cid']);
    $data = array(
        'title' => $_GPC['title'],
        'cid' => $cid,
        'isbn' => $_GPC['isbn'],
        'description' => $_GPC['description'],
        'tags' => $_GPC['tags'],
        'summary' => $_GPC['summary'],
        'album' => $album != ''?iserializer($album):'',
        'thumb' => $thumb != ''?iserializer($thumb):'',
        'video' => $video != ''?iserializer($video):'',
        'price' => $_GPC['price'],
        'address' => $_GPC['address'],
        'city' => $_GPC['city'],
        'stock' => $_GPC['stock'],
        'buy_type' => intval($_GPC['buy_type']),
        'wechatpay' => intval($_GPC['wechatpay']),
        'unit' => intval($_GPC['unit_type']),
        'unit_title' => $_GPC['unit_title'],
        'credit' => $_GPC['credit'],
        'trade_type' => $_GPC['trade_type'] ? $_GPC['trade_type'] : 0,
        'fetch_address' => $_GPC['fetch_address']
    );
    //获取自定义字段数据
    $fields = array();
    $form_field = base64_decode($_GPC['add_field']);
    $fields_value = json_decode(urldecode($form_field), true);

    $add_fields = $this->module['config']['post']['form_fields'];
    if (!empty($add_fields) && !empty($fields_value)) {
        foreach ($add_fields as $key => $val) {
            if ($val['required'] == 1) { //判断是否必填
                if (!isset($fields_value[$key]) || $fields_value[$key] == '') {
                    SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '请输入'.$val['title']);
                }
            }
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
        $data['add_fields'] = iserializer($fields);
    }
    //获取图书信息
    if (!empty($_GPC['book_field'])) {
        $book_field = base64_decode($_GPC['book_field']);
        $book_field = json_decode(urldecode($book_field), true);
        $data['book_fields'] = iserializer($book_field);
    }
    $audit_type = $this->module['config']['base']['audit'];
    if ($audit_type == 0) {
        $data['status'] = 1;
    } else if ($audit_type == 2) { // 人工智能自动审核
        // 默认审核通过
        $data['status'] = 1;

        $account = WeAccount::create();
        $access_token = $account->getAccessToken();
        if (is_error($access_token)) {
            WeUtility::logging('fatal', 'getAccessToken failed: '.$access_token);
            $data['status'] = 0;
        } else {
            // 检查文本
            if ($data['status'] != 0
                && (!empty($_GPC['description']) || !empty($_GPC['title']))) {
                $content = $_GPC['title'].$_GPC['description'];
                $url = "https://api.weixin.qq.com/wxa/msg_sec_check?access_token=" . $access_token;
                $post_data = array(
                    'content' => $content,
                );
                $response = ihttp_post($url, json_encode($post_data));
                if (is_error($response)) {
                    WeUtility::logging('fatal', "msg_sec_check failed: content={$content}, response=".var_export($response, true).", access_token=$access_token, url=$url, data=".var_export($post_data, true));
                    $data['status'] = 0;
                } else {
                    $result = json_decode($response['content'], true);
                    WeUtility::logging('debug', "msg_sec_check: content={$content}, url=$url, post_data=".var_export($post_data, true).", response=".var_export($response, true).", result=".var_export($result, true));
                    if ($result['errcode'] != 0) {
                        $data['status'] = 0; // 待审核
                        SupermanHandUtil::json(SupermanHandErrno::TEXT_ILLEGAL, '', 'error');
                    }
                }
            }
        }
    } else {
        $data['status'] = 0;
    }
    if ($_GPC['id']) {
        $data['updatetime'] = TIMESTAMP;
        $ret = pdo_update('superman_hand2_item', $data, array('id' => $_GPC['id'], 'uniacid' => $_W['uniacid']));
        if ($ret === false) {
            SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '物品更新失败');
        }
        $url = 'pages/audit/index?id='.$_GPC['id'];
    } else {
        $data['lng'] = $_GPC['lng'];
        $data['lat'] = $_GPC['lat'];
        $data['createtime'] = TIMESTAMP;
        $data['uniacid'] = $_W['uniacid'];
        $data['seller_uid'] = $_W['member']['uid'];

        //转换坐标
        $location = SupermanHandUtil::location_transition($data['lat'], $data['lng'], $this->module['config']['base']['lbs_key']);
        if ($location) {
            $data['province'] =  $location['province'];
            $data['city'] =  $location['city'];
        }
        pdo_insert('superman_hand2_item', $data);
        $new_id = pdo_insertid();
        if (empty($new_id)) {
            SupermanHandUtil::json(SupermanHandErrno::INSERT_FAIL, '物品发布失败');
        }
        $url = 'pages/audit/index?id='.$new_id;

        //累计用户每天发布次数
        $post_count = pdo_get('superman_hand2_member_post_count', array(
            'uniacid' => $_W['uniacid'],
            'openid' => $_W['openid'],
            'daytime' => date('Ymd', TIMESTAMP),
        ));
        if ($post_count) {
            pdo_update('superman_hand2_member_post_count', array(
                'count +='=> 1,
                'itemids'=> $post_count['itemids'].','.$new_id,
            ), array(
                'id' => $post_count['id']
            ));
        } else {
            pdo_insert('superman_hand2_member_post_count', array(
                'uniacid' => $_W['uniacid'],
                'openid' => $_W['openid'],
                'itemids' => $new_id,
                'count' => 1,
                'daytime' => date('Ymd', TIMESTAMP),
            ));
        }
    }
    $result = array(
        'itemid' => $_GPC['id']?$_GPC['id']:$new_id,
    );

    $config_credit = $this->module['config']['credit'];
    //检查赠送积分上限
    $credit_uplimit = SupermanHandUtil::credit_uplimit($config_credit, $config_credit['category'][$cid]);
    //物品分类赠送积分
    if ($data['status'] == 1
        && empty($_GPC['id'])
        && $credit_uplimit) {
        $category = pdo_get('superman_hand2_category', array('uniacid' => $_W['uniacid'], 'id' => $cid));
        $credit_log = array(
            $_W['member']['uid'],
            '发布物品分类为'.$category['title'].'的商品：'.$_GPC['title'],
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
        $result['category'] = array(
            'title' => '发布物品分类',
            'credit' => $config_credit['category'][$cid],
        );
    }

    //发送模版消息
    if ($data['status'] == 0) {
        $form_id = $_GPC['formid'];
        $openid = $this->module['config']['minipg']['audit_remind']['openids'];
        $tpl_id = $this->module['config']['minipg']['audit_remind']['tmpl_id'];
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
                    SupermanHandUtil::send_wxapp_msg($message_data, $id, $tpl_id, $url,$form_id);
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
        $result['upload'] = array(
            'title' => '首次发布',
            'credit' => $config_credit['upload'],
        );
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, $msg, $result);
} else if ($act == 'upload') {
    if ($_FILES['imgData']) {
        $files = $_FILES['imgData'];
        if ($files['error'] > 0) {
            WeUtility::logging("trace", "上传失败：files=" . var_dump($files));
            SupermanHandUtil::json(SupermanHandErrno::UPLOAD_FAIL, '', 'error');
        } else {
            if ($this->module['config']['base']['audit'] == 2) {
                $account = WeAccount::create();
                $access_token = $account->getAccessToken();
                if (is_error($access_token)) {
                    WeUtility::logging('fatal', 'getAccessToken failed: ' . $access_token);
                    SupermanHandUtil::json(SupermanHandErrno::UPLOAD_FAIL, '智能审核失败，请切换到人工审核', 'error');
                } else {
                    $media = $files["tmp_name"];
                    $url = "https://api.weixin.qq.com/wxa/img_sec_check?access_token=" . $access_token;
                    $post_data = array(
                        'media' => "@{$media}",
                    );
                    $headers = array('Content-Type' => 'multipart/form-data');
                    $response = ihttp_request($url, $post_data, $headers);
                    if (is_error($response)) {
                        WeUtility::logging('fatal', "img_sec_check failed: media={$media}, response=" . var_export($response, true) . ", access_token=$access_token, post_data=" . var_export($post_data, true));
                    }
                    $result = json_decode($response['content'], true);
                    WeUtility::logging('debug', "img_sec_check: media={$media}, url=$url, post_data=" . var_export($post_data, true) . ", response=" . var_export($response, true) . ", result=" . var_export($result, true));
                    if ($result['errcode'] != 0) {
                        SupermanHandUtil::json(SupermanHandErrno::UPLOAD_ILLEGAL, '', 'error');
                    }
                }
            }
            $path = "images/{$_W['uniacid']}/" . date('Y/m') . '/';
            $allpath = IA_ROOT . '/attachment/' . $path;
            $filename = md5($files['name']) . '.jpg';
            $thumbname = md5($files['name']) . '_thumb.jpg';//缩略图
            $thumbfile = $allpath . $thumbname;
            $orignfile = $allpath . $filename;
            mkdirs($allpath);
            $ret = move_uploaded_file($files["tmp_name"], $orignfile);
            if ($ret) {
                file_image_thumb($orignfile, $thumbfile, 100);
                $img = $path . $filename;
                $thumb = $path . $thumbname;
                //上传至远程附件
                $img_arr = array($img, $thumb);
                SupermanHandUtil::sync_remote_file($img_arr);
                $list = array(
                    'orignal' => tomedia($img),
                    'thumb' => tomedia($thumb)
                );
                SupermanHandUtil::json(SupermanHandErrno::OK, '上传成功', $list);
            } else {
                WeUtility::logging("trace", "上传失败：path=" . $allpath . ", ret=" . var_dump($ret));
                SupermanHandUtil::json(SupermanHandErrno::UPLOAD_FAIL, '', 'error');
            }
        }
    } else {
        $files = $_FILES['videoData'];
        if ($files['error'] > 0) {
            SupermanHandUtil::json(SupermanHandErrno::UPLOAD_FAIL, '', 'error');
        } else {
            $path = "videos/{$_W['uniacid']}/" . date('Y/m') . '/';
            $allpath = IA_ROOT . '/attachment/' . $path;
            $type = substr($files['name'], strripos($files['name'], '.'));
            $filename = md5($files['name']) . $type;
            $orignfile = $allpath . $filename;
            mkdirs($allpath);
            $ret = move_uploaded_file($files["tmp_name"], $orignfile);
            if ($ret) {
                $video = $path . $filename;
                /*$video_root = $allpath . $filename;
                $result = ffmpeg_thumbnail($video_root);
                if ($result !== true) {
                    $tips = '视频上传成功但缩略图生成失败';
                } else {
                    $tips = '视频上传成功';
                }
                //上传至远程附件
                SupermanHandUtil::sync_remote_file(array($video));*/
                $video = tomedia($video);
                SupermanHandUtil::json(SupermanHandErrno::OK, '视频上传成功', $video);
            } else {
                WeUtility::logging("trace", "上传失败：path=" . $allpath . ", ret=" . var_dump($ret));
                SupermanHandUtil::json(SupermanHandErrno::UPLOAD_FAIL, '', 'error');
            }
        }
    }
} else if ($act == 'status') {
    $status = intval($_GPC['status']);
    if ($status == 2) {
        //日交易量统计
        $sql = "UPDATE ".tablename('superman_hand2_stat').' SET item_trade=item_trade+1 WHERE ';
        $sql .= " uniacid={$_W['uniacid']} AND daytime=".date('Ymd');
        pdo_query($sql);
    }
} else if ($act == 'audit') {
    $id = $_GPC['id'];
    if (empty($id)) {
        SupermanHandUtil::json(SupermanHandErrno::PARAM_ERROR, '', 'error');
    }
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'id' => $id
    );
    $ret = pdo_update('superman_hand2_item', array('status' => $_GPC['status'], 'reason' => $_GPC['reason']), $filter);
    if ($ret === false) {
        SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '数据库更新失败', 'error');
    }
    //发送模版消息
    $openid = mc_uid2openid($item['seller_uid']);
    $tpl_id = $this->module['config']['minipg']['audit_result']['tmpl_id'];
    $message_data = array(
        'first' => array(
            'value' => '您好，以下是您发布信息的审核结果',
            //'color' => '#173177',
        ),
        'keyword1' => array(
            'value' => $_GPC['title'],
            //'color' => '#173177',
        ),
        'keyword2' => array(
            'value' => $_GPC['description'],
            //'color' => '#173177',
        ),
        'keyword3' => array(
            'value' => date("Y-m-d H:i"),
            //'color' => '#173177',
        ),
        'keyword4' => array(
            'value' => $_GPC['status']==1?'审核通过':'审核不通过，原因是'.$_GPC['reason'],
        ),
        'remark' => array(
            'value' => '如有疑问请联系客服',
        ),
    );
    SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, '', $_GPC['form_id']);
    SupermanHandUtil::json(SupermanHandErrno::OK, '');
} else if ($act == 'submit') {
    $itemid = intval($_GPC['itemid']);
    $payType = $_GPC['payType'];
    $count = intval($_GPC['count']);
    if (!in_array($payType, array('credit', 'wechat'))) {
        SupermanHandUtil::json(SupermanHandErrno::ORDER_NOT_FOUND_PAYTYPE);
    }
    $item = pdo_get('superman_hand2_item', array(
        'uniacid' => $_W['uniacid'],
        'id' => $itemid,
    ));
    if (empty($item)) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '物品不存在');
    }
    if ($item['status'] != 1) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '物品状态未上架或已交易');
    }
    if ($item['stock'] == 0) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '物品已售罄');
    }
    if ($item['stock'] < $count) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '购买数量已超出物品库存数量');
    }
    if ($payType == 'credit') {  //积分兑换
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
        $total_credit = SupermanHandUtil::float_format($item['credit'] * $count);
        if ($total_credit > $credit1) {
            SupermanHandUtil::json(SupermanHandErrno::CREDIT_NOT_ENOUGH);
        }
    }

    //待支付订单删除
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'itemid' => $itemid,
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
        'itemid' => $itemid,
        'title' => $item['title'],
        'ordersn' => $ordersn,
        'seller_uid' => $item['seller_uid'],
        'buyer_uid' => $_W['member']['uid'],
        'total' => $count,
        'credit' => SupermanHandUtil::float_format($item['credit'] * $count),
        'price' => SupermanHandUtil::float_format($item['price'] * $count),
        'paytype' => $payType == 'credit' ? 1 : 2,
        'name' => $_GPC['name'],
        'mobile' => $_GPC['mobile'],
        'address' => $_GPC['address'],
        'buy_formid' => $_GPC['formId'],
        'status' => 0,
        'reply' => $_GPC['reply'],
        'createtime' => TIMESTAMP,
    );
    pdo_insert('superman_hand2_order', $data);
    $orderid = pdo_insertid();
    if (empty($orderid)) {
        SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '订单插入失败', 'error');
    }

    if ($payType == 'credit') {  //积分兑换
        //更新物品状态
        $status = $item['stock'] - $count > 0 ? 1 : 2;
        $ret = pdo_update('superman_hand2_item', array(
            'stock -=' => $count,
            'status' => $status
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
            'credit' => SupermanHandUtil::float_format($item['credit'] * $count),
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
        $res = SupermanHandUtil::get_uid_formid($item['seller_uid']);
        $openid = SupermanHandUtil::uid2openid($item['seller_uid']);
        $url = 'pages/my_order/index?type=sell';
        if ($res['formid']) {
            $tpl_id = $this->module['config']['minipg']['buy']['tmpl_id'];
            $message_data = array(
                'keyword1' => array(
                    'value' => $item['title'],  //物品名称
                ),
                'keyword2' => array(
                    'value' => $item['credit']>0?$item['credit'].'积分':'面议',    //物品价格
                ),
                'keyword3' => array(
                    'value' => $_W['fans']['nickname'],    //购买人
                ),
            );
            $ret = SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $res['formid']);
            if ($ret) {
                SupermanHandUtil::delete_uid_formid($res['id']);
            }
        } else {
            $uni_tpl_id = $this->module['config']['tmpl']['buy']['tmpl_id'];
            $gzh_appid = $this->module['config']['minipg']['bind_gzh']['appid'];
            if (!empty($uni_tpl_id) && !empty($gzh_appid)) {
                $user = mc_fetch($_W['member']['uid'], array('nickname'));
                $message_data = array(
                    'first' => array(
                        'value' => '您发布的以下物品已被购买',
                        'color' => '#173177'
                    ),
                    'keyword1' => array(
                        'value' => $user['nickname'],
                    ),
                    'keyword2' => array(
                        'value' => $item['title'],
                    ),
                    'keyword3' => array(
                        'value' => $item['price'] > 0 ? $item['price'].'元' : $item['credit'].'积分',
                    ),
                    'keyword4' => array(
                        'value' => date('Y-m-d H:i:s', $item['createtime']),
                    ),
                    'remark' => array(
                        'value' => '请尽快发货或联系客户自提',
                        'color' => '#173177'
                    ),
                );
                SupermanHandUtil::send_uniform_msg($message_data, $openid, $uni_tpl_id, $gzh_appid, $url);
            }
        }
    } else if ($payType == 'wechat') {  //微信支付
        if ($this->plugin_module['plugin_wechat']['module'] && !$this->plugin_module['plugin_wechat']['module']['is_delete']) {
            //微信支付
            $params = array(
                'tid' => 'superman_hand2_wechat:'.$orderid,
                'user' => $_W['openid'],
                'fee' => SupermanHandUtil::float_format($item['price'] * $count),
                'title' => '购买物品订单('.$ordersn.')支付',
            );
            $site = WeUtility::createModuleWxapp($this->plugin_module['plugin_wechat']['module']['name']);
            $result = $site->pay($params);
            if (is_error($result)) {
                WeUtility::logging('fatal', '[cashier.inc.php], result='.var_export($result, true));
                SupermanHandUtil::json(-1, '支付失败，请重试');
            }
            //发送模板消息需要prepay_id参数
            $prepay_id = str_replace('prepay_id=', '', $result['package']);
            $openid = SupermanHandUtil::uid2openid($item['seller_uid']);
            $tpl_id = $this->module['config']['minipg']['buy']['tmpl_id'];
            $url = 'pages/my_order/index?type=sell';
            $message_data = array(
                'keyword1' => array(
                    'value' => $item['title'],  //物品名称
                ),
                'keyword2' => array(
                    'value' => $item['price']>0?$item['price'].'元':'面议',    //物品价格
                ),
                'keyword3' => array(
                    'value' => $_W['fans']['nickname'],    //购买人
                ),
            );
            SupermanHandUtil::send_wxapp_msg($message_data, $openid, $tpl_id, $url, $prepay_id);
        }
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '', $result);
} else if ($act == 'report') {
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'report_uid' => $_W['member']['uid'],
        'itemid' => intval($_GPC['itemid']),
    );
    $row = pdo_get('superman_hand2_report', $filter);
    if ($row) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '该物品已举报过', 'error');
    }
    $filter = array(
        'uniacid' => $_W['uniacid'],
        'id' => $_GPC['itemid'],
    );
    $item = pdo_get('superman_hand2_item', $filter);
    $data = array(
        'uniacid' => $_W['uniacid'],
        'itemid' => $_GPC['itemid'],
        'seller_uid' => $item['seller_uid'],
        'report_uid' => $_W['member']['uid'],
        'formid' => $_GPC['formid'],
        'reason' => $_GPC['content'],
        'createtime' => TIMESTAMP,
    );
    pdo_insert('superman_hand2_report', $data);
    $new_id = pdo_insertid();
    if (empty($new_id)) {
        SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '数据库更新失败', 'error');
    }
    SupermanHandUtil::json(SupermanHandErrno::OK);
} else if ($act = 'get_phone_number') {
    $account = WeAccount::create();
    $encrypt_data = $_GPC['encryptedData'];
    $iv = $_GPC['iv'];
    $phoneInfo = $account->pkcs7Encode($encrypt_data, $iv);
    if (is_error($phoneInfo)) {
        WeUtility::logging('fatal', '[wxapp:member]手机号解密失败，result='.var_export($phoneInfo, true).',session_key='.$_W['session_key']);
        SupermanHandUtil::json(SupermanHandErrno::DECODE_FAIL);
    }
    $phoneNumber = $phoneInfo['purePhoneNumber'];
    $ret = pdo_update('mc_members', array(
        'mobile' => $phoneNumber,
    ), array('uid' => $_W['member']['uid'], 'uniacid' => $_W['uniacid']));
    if ($ret === false) {
        SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '更新数据库失败', 'error');
    } else {
        SupermanHandUtil::json(SupermanHandErrno::OK, '', $phoneInfo);
    }
}

function ffmpeg_thumbnail($video_file, $time = 1, $width = 300, $height = 200) {
    $url_prefix = strstr($video_file, 'video', -1);
    $url_suffix = substr($video_file, strpos($video_file, 'video'));
    $output_file = $url_prefix.$url_suffix.'.jpg';
    //$output_file = strstr($video_file, '.', -1).'.jpg';
    $cmd = "ffmpeg -i " . $video_file . " -f image2 -ss 1 -vframes {$time} -s $width*$height $output_file";

    $programs = array('exec', 'system', 'passthru');
    $status = 0;
    $data = null;
    $res = -1;
    foreach ($programs as $p) {
        if (function_exists($p)) {
            if ($p == 'exec') {
                $p($cmd, $data, $res);
            } else {
                $p($cmd, $res);
            }
        } else {
            $status++;
        }
        if ($res == 0) {
            break; // success
        }
    }
    if ($status == 3) {
        WeUtility::logging('fatal', 'exec、system、passthru方法都被禁用了，无法生成缩略图！');
        return false;
    }
    if ($res == 1) {
        WeUtility::logging('fatal', '图片截取失败: video='.$video_file.', thumb='.$output_file);
        return false;
    }
    WeUtility::logging('trace', '图片截取成功: video='.$video_file.', thumb='.$output_file);
    return true;
}