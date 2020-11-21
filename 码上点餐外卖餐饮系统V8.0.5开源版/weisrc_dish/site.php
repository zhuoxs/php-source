<?php
/**
 * 码上点餐
 *
 * 作者:迷失卍国度
 *
 * qq : 15595755
 */
defined('IN_IA') or exit('Access Denied');
include "model.php";
include "plugin/feyin/HttpClient.class.php";
include "templateMessage.php";
include "fengniao.php";
include "plugin/ylprint.class.php";
include "plugin/jinyun_print/print.php";
define(EARTH_RADIUS, 6371); //地球半径，平均半径为6371km
define('RES', '../addons/weisrc_dish/template/');
define('CUR_MOBILE_DIR', 'dish/');
define('FEYIN_HOST', 'my.feyin.net');
define('FEYIN_PORT', 80);
define('FEIE_IP', 'dzp.feieyun.com');
define('FEIE_PORT', 80);
define('FEIE_HOSTNAME', '/FeieServer');
require 'inc/func/core.php';

class weisrc_dishModuleSite extends Core
{
    public $global_sid = 0;
    public $logo = '';
    public $more_store_psize = 10;

    function __construct()
    {
        global $_W, $_GPC;
//        $this->serverip = getServerIP();
        $this->_fromuser = $_W['fans']['from_user']; //debug
        $host = $_SERVER['HTTP_HOST'];
        if ($host == 'localhost' || $host == '127.0.0.1:81') {
            $this->_fromuser = 'debug2';
        }

        $this->_weid = $_W['uniacid'];
        $account = $_W['account'];
        $this->_auth2_openid = 'auth2_openid_' . $_W['uniacid'];
        $this->_auth2_nickname = 'auth2_nickname_' . $_W['uniacid'];
        $this->_auth2_headimgurl = 'auth2_headimgurl_' . $_W['uniacid'];

        $this->_lat = 'lat_' . $this->_weid;
        $this->_lng = 'lng_' . $this->_weid;

        $this->_appid = '';
        $this->_appsecret = '';
        $this->_accountlevel = $account['level']; //是否为高级号

        if (isset($_COOKIE[$this->_auth2_openid])) {
            $this->_fromuser = $_COOKIE[$this->_auth2_openid];
        }

        if (isset($_COOKIE['global_sid_' . $_W['uniacid']])) {
            $this->global_sid = $_COOKIE['global_sid_' . $_W['uniacid']];
        }

        if ($this->_accountlevel < 4) {
            $setting = uni_setting($this->_weid);
            $oauth = $setting['oauth'];
            if (!empty($oauth) && !empty($oauth['account'])) {
                $this->_account = account_fetch($oauth['account']);
                $this->_appid = $this->_account['key'];
                $this->_appsecret = $this->_account['secret'];
            }
        } else {
            $this->_appid = $_W['account']['key'];
            $this->_appsecret = $_W['account']['secret'];
        }

        $logo = pdo_fetch("SELECT site_logo FROM " . tablename($this->table_setting) . " WHERE weid = :weid", array
        (':weid' => $this->_weid));
        if (empty($logo['site_logo'])) {
            $this->logo = '../addons/weisrc_dish/template/images/logo.png';
        } else {
            $this->logo = tomedia($logo['site_logo']);
        }

        $template = pdo_fetch("SELECT * FROM " . tablename($this->table_template) . " WHERE weid = :weid", array(':weid' => $this->_weid));
        if (!empty($template)) {
            $this->cur_tpl = $template['template_name'];
        }
        $this->cur_res = RES . '/mobile/' . $this->cur_tpl;
        $this->cur_mobile_path = RES . '/mobile/' . $this->cur_tpl;
        $this->_file_sys_tb();


    }

    //蜂鸟配送员
    public function getRange($id, $setting)
    {
        global $_W, $_GPC;
        if (empty($setting['fengniao_appid']) || empty($setting['fengniao_key'])) return false;
        $rop = new fengniao($setting['fengniao_appid'], $setting['fengniao_key'], $setting['fengniao_mode']);
        $rop->requestToken();
        $result = $rop->queryRange($id);
        $result = json_decode($result, true);
        if ($result['code'] == "200") { //成功
            return $result['data']['ranges'];
        } else {
            wlog('rangefengniao', $result);
        }
    }

    public function yunshop_postOrders($orderid)
    {
        global $_W, $_GPC;

        $order = $this->getOrderById($orderid);
        $uid = mc_openid2uid($order['from_user']);

        $post_data = array(
            'uniacid' => $_W['uniacid'],
            'goods_total' => $order['totalnum'],
            'uid' => $uid,
            'mid' => 0,
            ' merchant_id' => 0,
            'order_sn' => $orderid,
            'price' => $order['totalprice'],
            'goods_price' => $order['totalprice'],
            'status' => 0,
            'realname' => $order['username'],
            'mobile' => $order['tel'],
            'address' => $order['address'],
            'province' => $order['address'],
            'city' => $order['address'],
            'county' => $order['address'],
            'detailed_address' => $order['address'],
        );

        //post到商城
        $url = $_W['siteroot'] . 'addons/yun_shop/api.php?i=' . $_W['uniacid'] . '&route=plugin.weisrc_dish.admin.order
        .postOrders';
        $res = ihttp_post($url, $post_data);
        $data_obj = @json_encode($res['content'], true);

    }

    public function yunshop_completeOrder($orderid)
    {
        global $_W, $_GPC;
        $post_data = [
            'status' => 3,
            'order_sn' => $orderid,
        ];
        //post到商城
        $url = $_W['siteroot'] . 'addons/yun_shop/api.php?i=' . $_W['uniacid'] . '&route=plugin.weisrc_dish.admin.order.completeOrder';
        $res = ihttp_post($url, $post_data);
        $data_obj = @json_encode($res['content'], true);
    }

    public function doMobileAutoFinishOrder()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $setting = $this->getSetting();

        //过了24小时的订单
        $addtime = TIMESTAMP - 86400;
        $condition = " WHERE weid=:weid AND ispay=1 AND status=1 AND dateline<={$addtime} ";

        $list = pdo_fetchall(
            "SELECT * FROM " . tablename($this->table_order) . " {$condition} LIMIT 50",
            array(':weid' => $this->_weid)
        );

        foreach ($list as $key => $value) {
            $id = intval($value['id']);
            if (!empty($id)) {
                if ($value) {
                    if ($value['isfinish'] == 0) {
                        //计算积分
                        $this->setOrderCredit($value['id']);
                        pdo_update($this->table_order, array('isfinish' => 1), array('id' => $id));
                        pdo_update($this->table_service_log, array('status' => 1), array('orderid' => $id));
                        if ($value['dining_mode'] == 1) { //处理店内
                            pdo_update($this->table_tables, array('status' => 0), array('id' => $value['tables']));
                        }
                        $this->set_commission($id);
                        $delivery_money = floatval($value['delivery_money']);//配送佣金
                        $delivery_id = intval($value['delivery_id']);//配送员
                        if ($delivery_money > 0) {
                            $data = array(
                                'weid' => $_W['uniacid'],
                                'storeid' => $value['storeid'],
                                'orderid' => $id,
                                'delivery_id' => $delivery_id,
                                'price' => $delivery_money,
                                'dateline' => TIMESTAMP,
                                'status' => 0
                            );
                            pdo_insert("weisrc_dish_delivery_record", $data);
                        }
                    }
                    pdo_update($this->table_order, array('status' => 3, 'finishtime' => TIMESTAMP), array('id' => $id, 'weid' => $weid));
                    $this->addOrderLog($id, $_W['user']['username'], 2, 2, 4);
                    $this->updateFansData($value['from_user']);
                    $this->updateFansFirstStore($value['from_user'], $value['storeid']);
                    $this->setOrderServiceRead($id);
                }
            }
        }
    }

    public function doMobileAutoCheckOrder()
    {
        //已支付-》未打印的订单
        $addtime = TIMESTAMP - 7*86400;
        $condition = " WHERE weid=:weid AND ispay=1 AND isprint=0 AND status<>3 AND dateline>{$addtime} ";
        $list = pdo_fetchall(
            "SELECT * FROM " . tablename($this->table_order) . " {$condition} LIMIT 50",
            array(':weid' => $this->_weid)
        );
        $setting = $this->getSetting();
        foreach ($list as $keymain => $order) {
            $orderid = intval($order['id']);
            $storeid = intval($order['storeid']);
            $order = $this->getOrderById($orderid);
            $store = $this->getStoreById($storeid);

            if ($order) {
                if ($order['dining_mode'] != 6) {
                    if ($order['isprint'] == 0) {
                        $this->_feiyinSendFreeMessage($orderid); //飞印
                        $this->_365SendFreeMessage($orderid); //365打印机
                        $this->_365lblSendFreeMessage($orderid); //365打印机
                        $this->_feieSendFreeMessage($orderid); //飞鹅
                        $this->_yilianyunSendFreeMessage($orderid); //易联云
                        $this->_jinyunSendFreeMessage($orderid);
                    }

                    $order = $this->getOrderById($orderid);
                    //用户
                    $this->sendOrderNotice($order, $store, $setting);
                    //管理
                    if (!empty($setting)) {
                        //平台提醒
                        if ($setting['is_notice'] == 1) {
                            if (!empty($setting['tpluser'])) {
                                $tousers = explode(',', $setting['tpluser']);
                                foreach ($tousers as $key => $value) {
                                    $this->sendAdminOrderNotice($orderid, $value, $setting);
                                }
                            }
                            if (!empty($setting['sms_mobile']) && !empty($setting['sms_username']) && !empty($setting['sms_pwd'])) {
                                $this->sendAdminOrderSms($setting['sms_mobile'], $order);
                            }
                        }

                        //门店提醒
                        $accounts = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND storeid=:storeid AND status=2 AND is_notice_order=1 ORDER BY id
DESC ", array(':weid' => $this->_weid, ':storeid' => $storeid));
                        foreach ($accounts as $key => $value) {
                            if (!empty($value['from_user'])) {
                                $this->sendAdminOrderNotice($orderid, $value['from_user'], $setting);
                            }
                            if (!empty($value['mobile']) && !empty($setting['sms_username']) && !empty($setting['sms_pwd'])) {
                                $smsStatus = $this->sendAdminOrderSms($value['mobile'], $order);
                            }
                        }
                    }

                    if ($order['dining_mode'] == 2 && $setting['delivery_mode'] != 1) {
                        //外卖订单,通知配送
                        if ($store['is_sys_delivery'] == 1) {
                            if ($setting['delivery_mode'] == 2) { //所有配送员
                                $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 AND (storeid=0 OR
storeid={$storeid}) ORDER BY id DESC ", array(':weid' => $this->_weid));
                                foreach ($deliverys as $key => $value) {
                                    $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                                }
                            } else if ($setting['delivery_mode'] == 3) { //区域配送员
                                $area = $this->getNearDeliveryArea($order['lat'], $order['lng']);
                                $areaid = intval($area['id']);
                                if ($areaid != 0) {
                                    $strwhere = " AND areaid={$areaid} AND (storeid=0 OR
storeid={$storeid}) ";
                                    $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 {$strwhere} ORDER BY id DESC ", array(':weid' => $this->_weid));
                                    foreach ($deliverys as $key => $value) {
                                        $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                                    }
                                }
                            }
                        } else {
                            $strwhere = "  AND storeid={$storeid}";
                            $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 {$strwhere} ORDER BY id DESC ", array(':weid' => $this->_weid));
                            foreach ($deliverys as $key => $value) {
                                $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                            }
                        }
                    }
                }
                $this->sendfengniao($order, $store, $setting);
                pdo_update($this->table_order, array('istpl' => 1), array('id' => $orderid));
            }

        }
    }

    public function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
        $ckey_length = 4;
        $key = md5($key != '' ? $key : $GLOBALS['_W']['config']['setting']['authkey']);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }

    }

    public function doMobiledaohan()
    {
        include $this->template($this->cur_tpl . '/daohang');


    }

    public function doMobileLikePopup()
    {
        global $_GPC, $_W;
        $id = intval($_GPC['popup_id']);
        if ($this->_fromuser) {
            $log = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_notice_log") . " WHERE noticeid=:id AND
        from_user=:from_user LIMIT 1", array(":id" => $id, ":from_user" => $this->_fromuser));
            if (empty($log)) {
                $data = array(
                    'from_user' => $this->_fromuser,
                    'noticeid' => $id,
                    'dateline' => TIMESTAMP
                );
                pdo_insert("weisrc_dish_notice_log", $data);
            }
        }
    }

    public function sendQuickNumNotice($orderid)
    {
        global $_W, $_GPC;
        $url = $_W['siteroot'] . 'app' . str_replace('./', '/', $this->createMobileUrl('orderdetail', array('orderid' => $orderid), true));

        $setting = $this->getSetting();
        $order = $this->getOrderById($orderid);
        $store = $this->getStoreById($order['storeid']);
        $keyword1 = $order['quicknum'];
        $keyword2 = date("Y-m-d H:i", $order['dateline']);
        if (!empty($setting['tplnewqueue']) && $setting['istplnotice'] == 1) {
            $templateid = $setting['tplnewqueue'];
            if ($setting['tpltype'] == 1) {
                $first = "您的菜品做好了，请到前台领餐";
                $remark = "门店名称：{$store['title']}";

                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#f00'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    ),
                );
            }
//            else {
//                if ($status == 1) { //排队中
//                    $first = "排号提醒：编号{$keyword1}已成功领号，您可以点击本消息提前点菜，节约等待时间哦";
//                    $remark = "门店名称：{$store['title']}";
//                    $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
//                    $remark .= "\n排队状态：排队中";
//                } else if ($status == 2) { //排队提醒
//                    $first = "排号提醒：还需等待{$wait_count}桌";
//                    $remark = "门店名称：{$store['title']}";
//                    $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
//                    $remark .= "\n排队状态：" . $queueStatus[$order['status']];
//                } else if ($status == 3) { //取消提醒
//                    $first = "排号取消提醒：编号" . $order['num'] . "已取消";
//                    $remark = "您在{$store['title']}的排队状态更新为已取消，如有疑问，请联系我们工作人员";
//                    $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
//                    $remark .= "\n排队状态：已取消";
//                }
//
//                $content = array(
//                    'first' => array(
//                        'value' => $first,
//                        'color' => '#a6a6a9'
//                    ),
//                    'keyword1' => array(
//                        'value' => $keyword1,
//                        'color' => '#a6a6a9'
//                    ),
//                    'keyword2' => array(
//                        'value' => $keyword2,
//                        'color' => '#a6a6a9'
//                    ),
//                    'keyword3' => array(
//                        'value' => $keyword3,
//                        'color' => '#a6a6a9'
//                    ),
//                    'remark' => array(
//                        'value' => $remark,
//                        'color' => '#a6a6a9'
//                    ),
//                );
//            }

            $templateMessage = new templateMessage();
            $templateMessage->send_template_message($order['from_user'], $templateid, $content, '', $url);
        }
    }

    public function doWebGetBanner()
    {
        global $_GPC, $_W;

        include $this->template('web/_banner');
    }

    public function doWebsetstyleproperty()
    {
        global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $data = intval($_GPC['data']);
        empty($data) ? ($data = 1) : $data = 0;

        pdo_update('weisrc_dish_style', array('status' => $data), array("id" => $id, "weid" => $_W['uniacid']));
        die(json_encode(array("result" => 1, "data" => $data)));
    }

    public function doWebsetfansproperty()
    {
        global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $data = intval($_GPC['data']);
        empty($data) ? ($data = 1) : $data = 0;
        pdo_update('weisrc_dish_fans', array('is_check' => $data), array("id" => $id, "weid" => $_W['uniacid']));
        die(json_encode(array("result" => 1, "data" => $data)));
    }

    public function doWebsetstorefansproperty()
    {
        global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $data = intval($_GPC['data']);
        empty($data) ? ($data = 1) : $data = 0;
        pdo_update('weisrc_dish_checkuser', array('is_check' => $data), array("id" => $id, "weid" => $_W['uniacid']));
        die(json_encode(array("result" => 1, "data" => $data)));
    }

    public function doWebsetsavewineproperty()
    {
        global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $data = intval($_GPC['data']);
        $data == 1 ? ($data = -1) : $data = 1;

        pdo_update('weisrc_dish_savewine_goods', array('status' => $data), array("id" => $id));
        die(json_encode(array("result" => 1, "data" => $data)));
    }

    public function doWebGetNotice()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $storeid = intval($_GPC['storeid']);

        $condition = "";
        if ($storeid > 0) {
            $condition = " AND storeid={$storeid} ";
        }

        $list = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_service_log") . " WHERE weid = :weid AND
        status=0 {$condition} ORDER BY id DESC LIMIT 8",
            array(':weid' => $weid));
        $data = array();
        foreach ($list as $key => $value) {
            $data[] = array(
                'create_time' => date('Y-m-d H:i', $value['dateline']),
                'message' => $value['content'],
                'url' => $this->createWebUrl('servicelog', array('op' => 'check', 'id' => $value['id'], 'storeid' => $storeid))
            );
        }
        $total = pdo_fetchcolumn("SELECT count(1) FROM " . tablename("weisrc_dish_service_log") . " WHERE weid = :weid AND status=0 {$condition}", array(':weid' => $weid));

        $result = array(
            'errno' => '0',
            'total' => $total,
            'lists' => $data
        );
        echo json_encode($result);
        exit;
    }

    public function doWebgettotalprice()
    {
        global $_W, $_GPC;

        $weid = $this->_weid;
        $from_user = $_GPC['from_user'];
        $storeid = intval($_GPC['storeid']);
        $setting = $this->getSetting();
        $is_auto_address = intval($setting['is_auto_address']);
        $mode = intval($_GPC['ordertype']) == 0 ? 1 : intval($_GPC['ordertype']);
        $lat = trim($_GPC['lat']);
        $lng = trim($_GPC['lng']);
        $store = $this->getStoreById($storeid);

        $isvip = $this->get_sys_card($from_user);

        //外卖
        if ($mode == 2) {
//            if (empty($lat) || empty($lng)) {
//                $this->showTip('请重新选择配送地址!');
//            }

            //距离
            $delivery_radius = floatval($store['delivery_radius']);
            $distance = $this->getDistance($lat, $lng, $store['lat'], $store['lng']);
            $distance = floatval($distance);
            if ($store['not_in_delivery_radius'] == 0 && $delivery_radius > 0) { //只能在距离范围内
//                if ($distance > $delivery_radius) {
//                    $this->showTip('超出配送范围，不允许下单。');
//                }
            }
        }

        $cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE weid = :weid AND from_user = :from_user AND storeid=:storeid", array(':weid' => $weid, ':from_user' => 'admin', ':storeid' => $storeid));
        if (empty($cart)) {
            $this->showTip('请先添加商品!');
        }

        $guest_name = trim($_GPC['username']); //用户名
        $tel = trim($_GPC['tel']); //电话
        $address = trim($_GPC['address']);

        $meal_time = trim($_GPC['meal_time']); //订餐时间
        $counts = intval($_GPC['counts']); //预订人数

        $remark = trim($_GPC['remark']); //备注

        $tables = intval($_GPC['tables']); //桌号
        $tablezonesid = intval($_GPC['tablezonesid']); //桌台

        $user = $this->getFansByOpenid($from_user);
        $fansdata = array('weid' => $weid,
            'from_user' => $from_user,
            'username' => $guest_name,
            'address' => $address,
            'mobile' => $tel
        );
        if (empty($guest_name)) {
            unset($fansdata['username']);
        }
        if (empty($tel)) {
            unset($fansdata['mobile']);
        }
        if (empty($address)) {
            unset($fansdata['address']);
        }
        if ($mode == 2) { //外卖
            $fansdata['lat'] = $lat;
            $fansdata['lng'] = $lng;
        }
        if (empty($user)) {
            pdo_insert($this->table_fans, $fansdata);
        } else {
            pdo_update($this->table_fans, $fansdata, array('id' => $user['id']));
        }
//2.购物车 //a.添加订单、订单产品
        $totalnum = 0;
        $totalprice = 0;
        $goodsprice = 0;
        $dispatchprice = 0;
        $freeprice = 0;
        $packvalue = 0;
        $teavalue = 0;
        $service_money = 0;

        foreach ($cart as $value) {
            $total = intval($value['total']);
            $totalnum = $totalnum + intval($value['total']);
            $goodsprice = $goodsprice + ($total * floatval($value['price']));
            if ($mode == 2) { //打包费
                $packvalue = $packvalue + ($total * floatval($value['packvalue']));
            }
        }


        if ($mode == 2) { //外卖
            $dispatchprice = $store['dispatchprice'];

            if ($store['is_delivery_distance'] == 1 && $is_auto_address == 0) { //按距离收费
                $distance = $this->getDistance($lat, $lng, $store['lat'], $store['lng']);
                $distanceprice = $this->getdistanceprice($storeid, $distance);
                $dispatchprice = floatval($distanceprice['dispatchprice']);
            }

            $freeprice = floatval($store['freeprice']);
            if ($freeprice > 0.00) {
                if ($goodsprice >= $freeprice) {
                    $dispatchprice = 0;
                }
            }
        }
        if ($mode == 1) { //店内
            if ($store['is_tea_money'] == 1) {
                $teavalue = $counts * floatval($store['tea_money']);
            }
        }

        $totalprice = $goodsprice + $dispatchprice + $packvalue + $teavalue;
        if ($mode == 1) { //店内
            $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $tables));
            $tablezonesid = $table['tablezonesid'];
            $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " WHERE id = :id", array(':id' => $tablezonesid));
            $service_rate = floatval($tablezones['service_rate']);
            if ($service_rate > 0) {
                $service_money = $totalprice * $service_rate / 100;
            }
            $totalprice = $totalprice + $service_money;
        }

        if ($mode == 2) { //外卖
            $sendingprice = floatval($store['sendingprice']);
            if ($sendingprice > 0.00) {
                if ($goodsprice < $store['sendingprice']) {
//                    $this->showTip('您的购买金额达不到起送价格!');
                }
            }
        }

        $result['code'] = 1;
        if ($mode == 1) {
            $str = '订单总价:<strong class="text-danger" id="totalprice">' . $totalprice . '</strong>';
            $str .= '(商品:<strong class="text-danger">' . $goodsprice . '</strong>';
            $str .= '服务费:<strong class="text-danger">' . $service_money . '</strong>';
            $str .= '茶位费:<strong class="text-danger">' . $teavalue . '</strong>)';
        } else if ($mode == 2) {
            $str = '订单总价:<strong class="text-danger" id="totalprice">' . $totalprice . '</strong>';
            $str .= '(商品:<strong class="text-danger">' . $goodsprice . '</strong>';
            $str .= '配送费:<strong class="text-danger">' . $dispatchprice . '</strong>';
            $str .= '打包费:<strong class="text-danger">' . $packvalue . '</strong>)';
        } else {
            $str = '订单总价:<strong class="text-danger" id="totalprice">' . $totalprice . '</strong>';
        }

        $result['totalprice'] = $str;
        message($result, '', 'ajax');
    }

    public function doMobileGetTablesById()
    {
        global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $tables = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_tables") . " WHERE id=:id LIMIT 1", array(":id" => $id));
        if ($tables) {
            $data = array(
                'thumb' => tomedia($tables['thumb'])
            );
            echo json_encode($data);
        } else {
            echo json_encode(0);
        }
    }

    public function doMobileGetCounponById()
    {
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        $weid = $this->_weid;
        $from_user = $this->_fromuser;

        if (empty($from_user)) {
            $this->showMsg('会话已过期，请重新发关键字进入系统...');
        }

        //优惠券 1.发放总数2.没人领取数量
        $coupon = pdo_fetch("SELECT * FROM " . tablename($this->table_coupon) . " WHERE id=:id LIMIT 1", array(':id' => $id));
        if (empty($coupon)) {
            $this->showMsg('优惠券不存在!');
        } else {
            //判断优惠券属性  普通券1 营销券2
            if ($coupon['attr_type'] == 2) {
                $this->showMsg('该优惠券属于营销券,不能领取!');
            }
            if (TIMESTAMP < $coupon['starttime']) {
                $this->showMsg('活动时间还未开始,不能领取!');
            }
            if (TIMESTAMP > $coupon['endtime']) {
                $this->showMsg('活动时间已经结束啦!');
            }
        }
        $coupon_usercount = $coupon['usercount'];//每个用户能领取数量 0为不限制
        $coupon_totalcount = $coupon['totalcount'];//发放总数量 0为不限制

        $user_count = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_sncode) . " WHERE weid = :weid and from_user=:from_user AND couponid=:couponid ORDER
BY id DESC", array(':weid' => $weid, ':from_user' => $from_user, ':couponid' => $id));
        $total_count = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_sncode) . " WHERE weid = :weid AND couponid=:couponid ORDER BY id DESC", array(':weid' => $weid, ':couponid' => $id));

        if ($coupon_totalcount != 0) {
            if ($total_count >= $coupon_totalcount) {
                $this->showMsg('对不起，优惠券已经发放完了!');
            }
        }

        $dcredit = intval($coupon['dcredit']);
        $is_credit = 0;
        if ($dcredit > 0) {
            load()->model('mc');
            $user = mc_fetch($from_user);
            $credit = intval($user['credit1']); //剩余积分
            if ($credit < $dcredit) {
                $this->showMsg('对不起，您的积分不足，本次兑换需要积分' . $dcredit . '!');
            } else {
                $is_credit = 1;
            }
        }

        if ($coupon_usercount != 0) {
            if ($user_count >= $coupon_usercount) {
                $this->showMsg("每人最多只能领取{$coupon_usercount}次!");
            }
        }

        $sncode = 'SN' . random(11, 1);
        $sncode = $this->getNewSncode($weid, $sncode);

        if ($is_credit == 1) {
            load()->func('compat.biz');
            $uid = mc_openid2uid($from_user);
            $fans = fans_search($uid, array("credit1"));
            if (!empty($fans)) {
                $uid = intval($fans['uid']);
                $remark = '点餐兑换积分扣除 领取ID:' . $sncode;
                $log = array();
                $log[0] = $uid;
                $log[1] = $remark;
                mc_credit_update($uid, 'credit1', -$dcredit, $log);
            }
        }

        $data = array(
            'couponid' => $id,
            'sncode' => $sncode,
            'storeid' => $coupon['storeid'],
            'weid' => $weid,
            'from_user' => $from_user,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_sncode, $data);
        $this->showMsg('优惠券领取成功!', 1);
    }

    public function doWebGetgoodsoption()
    {
        global $_GPC, $_W;
        //查询商品是否存在
        $id = intval($_GPC['id']); //商品id
        $goods = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_goods_option") . " WHERE goodsid=:goodsid
        ORDER BY displayorder DESC", array
        (":goodsid" => $id));
        $str = '';
        if (empty($goods)) {
            echo json_encode(0);
        } else {
            $goodsgroup = array();
            foreach ($goods as $key => $value) {
                if (!in_array($value['start'], $goodsgroup)) {
                    $goodsgroup[] = $value['start'];
                }
            }

            foreach ($goodsgroup as $key1 => $val) {
                $str .= '<ul class="que_box">' . '<span class="guige">' . $val . '</span>';
                foreach ($goods as $key2 => $val2) {
                    if ($val == $val2['start']) {
                        $str .= '<li onclick="return addClass(this,' . $id . ');" specid="' . $val2['id'] . '" >'
                            . $val2['title'] . '</li>';
                    }
                }
                $str .= '</ul>';
            }

            $goodsitem = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id=:id", array(":id" => $id));
            $store = $this->getStoreById($goodsitem['storeid']);
            if ($store['is_card'] == 1) {
                $iscard = $this->get_store_card($goodsitem['storeid'], $this->_fromuser);
            } else {
                $iscard = $this->get_sys_card($this->_fromuser);
            }

            $goodsitem['dprice'] = $goodsitem['marketprice'];
            if ($iscard == 1 && !empty($goodsitem['memberprice'])) {
                $goodsitem['dprice'] = $goodsitem['memberprice'];
            }

            $data = array(
                'price' => $goodsitem['dprice'],
                'title' => $goodsitem['title'],
                'content' => $str
            );
            echo json_encode($data);
        }
    }

    public function doWebClearmenu()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $storeid = intval($_GPC['storeid']);
        pdo_delete('weisrc_dish_cart', array('weid' => $weid, 'from_user' => 'admin', 'storeid' => $storeid));
        $result['code'] = 0;
        message($result, '', 'ajax');
    }

    public function doWebQueryAddress()
    {
        global $_W, $_GPC;
        $weid = $this->weid;
        $from_user = $_GPC['from_user'];

        $user = pdo_fetch("SELECT * FROM " . tablename($this->table_useraddress) . " WHERE weid=:weid AND from_user=:from_user AND isdefault=1 LIMIT 1", array(':weid' => $weid, ':from_user' => $from_user));

        if ($user) {
            $result['code'] = 0;
            $result['user'] = $user;
            message($result, '', 'ajax');
        } else {
            $result['code'] = 1;
            $result['msg'] = '用户不存在' . $from_user . $weid;
            message($result, '', 'ajax');
        }
    }

    public function doWebUpdateDishNumOfCategory()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $from_user = 'admin';
        $dish_from_user = trim($_GPC['dish_from_user']);
        $storeid = intval($_GPC['storeid']); //门店id
        $dishid = intval($_GPC['dishid']); //商品id
        $optionid = $_GPC['optionid']; //商品id
        $total = intval($_GPC['o2uNum']); //更新数量
        $optype = trim($_GPC['optype']);

        if (empty($from_user)) {
            $result['msg'] = '会话已过期，请重新发送关键字!';
            message($result, '', 'ajax');
        }

        $store = $this->getStoreById($storeid);

//查询商品是否存在
        $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id=:id", array(":id" => $dishid));
        if (empty($goods)) {
            $result['msg'] = '没有相关商品';
            message($result, '', 'ajax');
        }

        $nowtime = mktime(0, 0, 0);
        if ($goods['lasttime'] <= $nowtime) {
            pdo_query("UPDATE " . tablename($this->table_goods) . " SET today_counts=0,lasttime=:time WHERE id=:id", array(':id' => $dishid, ':time' => TIMESTAMP));
        }

        if (empty($optionid)) {
            $cart = pdo_fetch("SELECT * FROM " . tablename($this->table_cart) . " WHERE goodsid=:goodsid AND weid=:weid AND storeid=:storeid AND
from_user=:from_user", array(':goodsid' => $dishid, ':weid' => $weid, ':storeid' => $storeid, ':from_user' => $from_user));
        } else {
            //查询购物车有没该商品
            $cart = pdo_fetch("SELECT * FROM " . tablename($this->table_cart) . " WHERE goodsid=:goodsid AND weid=:weid AND storeid=:storeid AND
from_user=:from_user AND optionid=:optionid ", array(':goodsid' => $dishid, ':weid' => $weid, ':storeid' => $storeid, ':from_user' => $from_user, ':optionid' => $optionid));
        }

        if ($goods['counts'] == 0) {
            $result['msg'] = '该商品已售完!';
            message($result, '', 'ajax');
        }
        if ($goods['counts'] > 0) {
            $count = $goods['counts'] - $goods['today_counts'];
            if ($count <= 0) {
                $result['msg'] = '该商品已售完!!';
                message($result, '', 'ajax');
            }
            if (!empty($cart)) {
                if ($cart['total'] < $total) {
                    if ($total > $count) {
                        $result['msg'] = '该商品已没库存!!';
                        message($result, '', 'ajax');
                    }
                }
            } else {
                if ($total > $count) {
                    $result['msg'] = '该商品已没库存!!';
                    message($result, '', 'ajax');
                }
            }
        }

        $store = $this->getStoreById($goods['storeid']);
        if ($store['is_card'] == 1) {
            $iscard = $this->get_store_card($goods['storeid'], $dish_from_user);
        } else {
            $iscard = $this->get_sys_card($dish_from_user);
        }

        $price = floatval($goods['marketprice']);
        if ($iscard == 1 && !empty($goods['memberprice'])) {
            $price = floatval($goods['memberprice']);
        }


        $optionid = trim($_GPC['optionid']);
        $optionids = explode('_', $optionid);
        $optionprice = 0;
        $optionname = '';

        if (count($optionids) > 0) {
            $options = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_goods_option") . "  WHERE id IN ('" . implode("','", $optionids) . "')");
            $is_first = 0;
            foreach ($options as $key => $val) {
                $optionprice = $optionprice + $val['price'];
                if ($is_first == 0) {
                    $optionname .= $val['title'];
                } else {
                    $optionname .= '+' . $val['title'];
                }
                $is_first++;
            }

        }

        $price = $price + floatval($optionprice);

        if (empty($cart)) {
            //不存在的话增加商品点击量
            pdo_query("UPDATE " . tablename($this->table_goods) . " SET subcount=subcount+1 WHERE id=:id", array(':id' => $dishid));

            $addtotal = 1;
            if ($optype == 'add') {
                $addtotal = $total;
            }

            //添加进购物车
            $data = array(
                'weid' => $weid,
                'storeid' => $goods['storeid'],
                'goodsid' => $goods['id'],
                'optionid' => $optionid,
                'optionname' => $optionname,
                'goodstype' => $goods['pcate'],
                'price' => $price,
                'packvalue' => $goods['packvalue'],
                'from_user' => $from_user,
                'total' => $addtotal
            );
            pdo_insert($this->table_cart, $data);
        } else {
            if ($optype == 'add') {
                $total = intval($cart['total']) + $total;
            }
            //更新商品在购物车中的数量
            pdo_query("UPDATE " . tablename($this->table_cart) . " SET total=:total WHERE id=:id", array(':id' => $cart['id'], ':total' => $total));
        }

        $totalcount = 0;
        $totalprice = 0;
        $goodscount = 0;

        $cart = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE  storeid=:storeid AND from_user=:from_user AND weid=:weid", array(':storeid' => $storeid, ':from_user' => $from_user, ':weid' => $weid));

        $cart_html = '<tr><td style="width: 40%;">名称</td><td>数量</td><td>单价</td><td>操作</td></tr>';
        foreach ($cart as $key => $value) {
            $goods_t = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id = :id LIMIT 1 ", array(':id' => $value['goodsid']));
            if (!$this->getmodules()) {
                $value['price'] = floatval($value['price']) + 6;
            }
            $cart[$key]['goodstitle'] = $goods_t['title'];
            $totalcount = $totalcount + $value['total'];
            $totalprice = $totalprice + $value['total'] * $value['price'];

            if ($value['goodsid'] == $dishid) {
                $goodscount = $goodscount + intval($value['total']);
            }

            if ($value['total'] > 0) {
                $optionname = '';
                if (!empty($value['optionname'])) {
                    $optionname = '[' . $value['optionname'] . ']';
                }

                $cart_html .= '<tr dishid="' . $value['goodsid'] . '" optionid="' . $value['optionid'] . '"><td>' . $goods_t['title'] . $optionname . '</td><td>' . $value['total'] . '</td><td>¥<font>' . $value['price'] . '</font></td><td><i class="i-add-btn">+</i> <i class="i-remove-btn">-</i></td></tr>';
            }
        }
        $cart_html .= '';

        $result['totalprice'] = $totalprice;
        $result['totalcount'] = $totalcount;
        $result['goodscount'] = $goodscount;
        $result['cart'] = $cart_html;
        $result['code'] = 0;
        message($result, '', 'ajax');
    }

    protected function createWebUrl($do, $query = array())
    {
        global $_W, $_GPC;
        $query['do'] = $do;
        $query['m'] = strtolower($this->modulename);

        $url = $_SERVER['REQUEST_URI'];
        if (strexists($url, 'store.php')) {
            $url = './store.php?';
            $url .= "c=site&";
            $url .= "a=entry&";
            if (!empty($do)) {
                $url .= "do={$do}&";
            }
            if (!empty($query)) {
                $queryString = http_build_query($query, '', '&');
                $url .= $queryString;
            }
            return $url;
        } else {
            return wurl('site/entry', $query);
        }
    }

    public function getTablesQrcode($tablesid, $type = 1)
    {
        global $_W, $_GPC;
        $tablesid = intval($tablesid);
        $qrcode_url = "";
        if ($tablesid > 0) {
            $scene_str = 'table_' . $tablesid;
            if ($type == 2) {
                $scene_str = 'savewine_' . $tablesid;
            }

            if ($this->_accountlevel == 4) {
                $setting = $this->getSetting();
                if (!empty($setting['commission_keywords'])) {
                    $qrcode = $this->createQrcode($setting['commission_keywords'], $scene_str, '餐饮餐桌_' . $scene_str);
                    if ($qrcode) {
                        $qrcode_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($qrcode['ticket']);
                        pdo_update($this->table_tables, array('scene_str' => $scene_str), array('id' => $tablesid));
                    }
                }
            }
        }
        return $qrcode_url;
    }

    //$keyword 关键字
    //$scene_str 场景值
    public function createQrcode($keyword, $scene_str, $name)
    {
        global $_W, $_GPC;

        $acid = intval($_W['acid']);
        $uniacccount = WeAccount::create($acid);
        $scene_str = trim($scene_str) ? trim($scene_str) : itoast('场景值不能为空', '', '');
        $is_exist = pdo_fetch('SELECT * FROM ' . tablename('qrcode') . ' WHERE uniacid = :uniacid AND acid = :acid AND scene_str = :scene_str AND model = 2 LIMIT 1;', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid'], ':scene_str' => $scene_str));
        if (!empty($is_exist)) {
            return $is_exist;
        }
        $barcode['action_info']['scene']['scene_str'] = $scene_str;
        $barcode['action_name'] = 'QR_LIMIT_STR_SCENE';
        $result = $uniacccount->barCodeCreateFixed($barcode);
        if (!is_error($result)) {
            $insert = array(
                'uniacid' => $_W['uniacid'],
                'acid' => $acid,
                'qrcid' => $barcode['action_info']['scene']['scene_id'],
                'scene_str' => $barcode['action_info']['scene']['scene_str'],
                'keyword' => $keyword,
                'name' => $name,
                'model' => 2,
                'ticket' => $result['ticket'],
                'url' => $result['url'],
                'expire' => $result['expire_seconds'],
                'createtime' => TIMESTAMP,
                'status' => '1',
                'type' => 'scene',
            );
            pdo_insert('qrcode', $insert);
            return $insert;
        }
        return false;
    }

    //取得短信验证码
    public function doWebGetDyCheckCode()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $from_user = trim($_GPC['from_user']);
        $this->_fromuser = $from_user;
        $mobile = trim($_GPC['mobile']);
        $storeid = intval($_GPC['storeid']);

        $setting = $this->getSetting();

        if ($setting['is_verify_mobile'] == 0 || empty($setting['dayu_verify_code']) || empty($setting['dayu_appkey']) || empty($setting['dayu_secretkey'])) {
            $this->showMsg('商家未开启验证码!');
        }

        if (!preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|147[0-9]{8
        }$/", $mobile)
        ) {
            $this->showMsg('手机号码格式不对!');
        }

        $passcheckcode = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_sms_checkcode') . " WHERE weid = :weid  AND mobile=:mobile AND status=1 ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':mobile' => $mobile));
        if (!empty($passcheckcode)) {
            $this->showMsg('这手机号码已经使用过!', 1);
        }

//        $checkCodeCount = pdo_fetchcolumn("SELECT count(1) FROM " . tablename('weisrc_dish_sms_checkcode') . " WHERE weid = :weid  AND from_user=:from_user ", array(':weid' => $weid, ':from_user' => $from_user));
//        if ($checkCodeCount >= 3) {
//            $this->showMsg('您请求的验证码已超过最大限制..' . $checkCodeCount);
//        }

        //判断数据是否已经存在
        $data = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_sms_checkcode') . " WHERE weid = :weid  AND mobile=:mobile ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':mobile' => $mobile));
        if (!empty($data)) {
            if (TIMESTAMP - $data['dateline'] < 60) {
                $this->showMsg('每分钟只能获取短信一次!');
            }
        }

        //验证码
        $checkcode = random(6, 1);
        $checkcode = $this->getNewCheckCode($checkcode);
        $data = array(
            'weid' => $weid,
            'from_user' => $from_user,
            'mobile' => $mobile,
            'checkcode' => $checkcode,
            'status' => 0,
            'dateline' => TIMESTAMP
        );

        $sms_data = array(
            'code' => (string)$checkcode
        );

        $result = $this->sms_send($mobile, $sms_data);
        if ($result) {
            pdo_insert('weisrc_dish_sms_checkcode', $data);
            $this->showMsg('发送成功!', 1);
        } else {
            $this->showMsg($result, 1);
        }
    }

    public function sms_send($mobile, $content)
    {
        global $_W;
        load()->func('communication');
        $setting = $this->getSetting();
        $appkey = $setting['dayu_appkey'];
        $secretKey = $setting['dayu_secretkey'];
        $sms_template_code = $setting['dayu_verify_code'];
        $signname = $setting['dayu_sign'];

        if (!is_array($setting)) {
            return error(-1, '平台没有设置短信参数');
        }

//        if($config_sms['version']==2) {
//            date_default_timezone_set("GMT");
//            $post = array(
//                'PhoneNumbers' => $mobile,
//                'SignName' => $signname,
//                'TemplateCode' => trim($sms_template_code),
//                'TemplateParam' => json_encode($content),
//                'OutId' => '',
//                'RegionId' => 'cn-hangzhou',
//                'AccessKeyId' => $appkey,
//                'Format' => 'json',
//                'SignatureMethod' => 'HMAC-SHA1',
//                'SignatureVersion' => '1.0',
//                'SignatureNonce' => uniqid(),
//                'Timestamp' => date('Y-m-d\TH:i:s\Z'),
//                'Action' => 'SendSms',
//                'Version' => '2017-05-25',
//            );
//            ksort($post);
//            $str = '';
//            foreach ($post as $key => $value){
//                $str .= '&' . percentEncode($key) . '=' . percentEncode($value);
//            }
//            $stringToSign = 'GET' . '&%2F&' . percentencode(substr($str, 1));
//            $signature = base64_encode(hash_hmac('sha1', $stringToSign, "{$secretKey}&", true));
//            $post['Signature'] = $signature;
//
//            $url = 'http://dysmsapi.aliyuncs.com/?' . http_build_query($post);
//            $result = ihttp_get($url);
//            if(is_error($result)) {
//                return $result;
//            }
//            $result = @json_decode($result['content'], true);
//            if($result['Code'] != 'OK') {
//                return error(-1, $result['Message']);
//            }
//        } else {
        $post = array(
            'method' => 'alibaba.aliqin.fc.sms.num.send',
            'app_key' => $appkey,
            'timestamp' => date('Y-m-d H:i:s'),
            'format' => 'json',
            'v' => '2.0',
            'sign_method' => 'md5',
            'sms_type' => 'normal',
            'sms_free_sign_name' => $signname,
            'rec_num' => $mobile,
            'sms_template_code' => trim($sms_template_code),
            'sms_param' => json_encode($content)
        );

        ksort($post);
        $str = '';
        foreach ($post as $key => $val) {
            $str .= $key . $val;
        }
        $secret = $secretKey;
        $post['sign'] = strtoupper(md5($secret . $str . $secret));
        $query = '';
        foreach ($post as $key => $val) {
            $query .= "{$key}=" . urlencode($val) . "&";
        }
        $query = substr($query, 0, -1);
        $url = 'http://gw.api.taobao.com/router/rest?' . $query;
        $result = ihttp_get($url);
        if (is_error($result)) {
            return $result;
        }
        $result = @json_decode($result['content'], true);

        if (!empty($result['error_response'])) {
            if (isset($result['error_response']['sub_code'])) {
                $msg = sms_error_code($result['error_response']['sub_code']);
                if (empty($msg)) {
                    $msg['msg'] = $result['error_response']['sub_msg'];
                }
            } else {
                $msg['msg'] = $result['error_response']['msg'];
            }
            return error(-1, $msg['msg']);
        }
//        }
        return true;
    }

    public function cancelfengniao($order, $store, $setting)
    {
        global $_W, $_GPC;

        if ($order['dining_mode'] != 2) {
            return false;
        }

        $rop = new fengniao($setting['fengniao_appid'], $setting['fengniao_key'], $setting['fengniao_mode']);
        $rop->requestToken();

        if (empty($setting['fengniao_appid']) || empty($setting['fengniao_key']) || $store['is_fengniao'] == 0) {
            return false;
        }

        $orderid = $order['id'];

        $dataArray = array(
            "partner_order_code" => $orderid,
            "order_cancel_reason_code" => 2,
            "order_cancel_code" => 9,
            "order_cancel_description" => "商家取消订单",
            "order_cancel_time" => TIMESTAMP * 1000
        );

        $returnresult = $rop->cancelQrder($dataArray);  // second 创建订单
        $returnresult = json_decode($returnresult, true);
        file_put_contents(IA_ROOT . "/addons/weisrc_dish/canclefengniao.log", var_export($returnresult, true) .
            PHP_EOL, FILE_APPEND);

        if ($returnresult['code'] != "200") {
            message('提示:' . $returnresult['msg']);
        }
    }

    public function complaintfengniao($order, $store, $setting)
    {
        global $_W, $_GPC;

        if ($order['dining_mode'] != 2) {
            return false;
        }

        $rop = new fengniao($setting['fengniao_appid'], $setting['fengniao_key'], $setting['fengniao_mode']);
        $rop->requestToken();

        if (empty($setting['fengniao_appid']) || empty($setting['fengniao_key']) || $store['is_fengniao'] == 0) {
            return false;
        }

        $orderid = $order['id'];

        $dataArray = array(
            "partner_order_code" => $orderid,
            "order_complaint_code" => 150,
            "order_complaint_time" => TIMESTAMP * 1000
        );

        $returnresult = $rop->complaintQrder($dataArray);  // second 创建订单
        $returnresult = json_decode($returnresult, true);

        if ($returnresult['code'] != "200") {
            file_put_contents(IA_ROOT . "/addons/weisrc_dish/fengniaofail.log", var_export($dataArray, true) . PHP_EOL,
                FILE_APPEND);
            print_r($returnresult);
            exit;
        }
    }

    //蜂鸟配送员
    public function getcarrier($order, $store, $setting)
    {
        global $_W, $_GPC;

        if ($order['dining_mode'] != 2) {
            return false;
        }

        $rop = new fengniao($setting['fengniao_appid'], $setting['fengniao_key'], $setting['fengniao_mode']);
        $rop->requestToken();

        if (empty($setting['fengniao_appid']) || empty($setting['fengniao_key']) || $store['is_fengniao'] == 0) {
            return false;
        }

        $orderid = $order['id'];
        $returnresult = $rop->getcarrier($orderid);  // second 创建订单
        $returnresult = json_decode($returnresult, true);

        if ($returnresult['code'] != "200") {
            print_r($returnresult);
            exit;
        }
    }

    public function sendfengniao($order, $store, $setting)
    {
        global $_W, $_GPC;

        if ($order['dining_mode'] != 2) {
            return false;
        }

        $rop = new fengniao($setting['fengniao_appid'], $setting['fengniao_key'], $setting['fengniao_mode']);
        $rop->requestToken();

        if (empty($setting['fengniao_appid']) || empty($setting['fengniao_key']) || $store['is_fengniao'] == 0) {
            return false;
        }
        $orderid = $order['id'];
        $goodsid = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $orderid), 'goodsid');
        $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')");
        $items_json = array();
        foreach ($goods as $goodkey => $goodvalue) {
            $items_json[] = array(
                'item_id' => $goodvalue['id'],
                'item_name' => $goodvalue['title'],
                'item_quantity' => $goodsid[$goodvalue['id']]['total'],
                'item_price' => $goodvalue['marketprice'],
                'item_actual_price' => $goodsid[$goodvalue['id']]['price'],
                'is_need_package' => 1,
                'is_agent_purchase' => 0
            );
        }
        $notify_url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=fengniaonotify&m=weisrc_dish';

        $date = explode('~', $order['meal_time']);
        $sendtime = strtotime($date[0]);

        if ($sendtime > TIMESTAMP) {
            $sendtime = $sendtime * 1000;
        } else {
            $sendtime = strtotime("+5 minute") * 1000;
        }
        //BD-09(百度) 坐标转换成  GCJ-02(火星，高德) 坐标
        $hx = bd_decrypt($order['lng'], $order['lat']);
        //拼装data数据
        $dataArray = array(
            'partner_remark' => $store['title'],
            'partner_order_code' => $order['id'],     // 第三方订单号, 需唯一
            'notify_url' => $notify_url,     //第三方回调 url地址
            'order_type' => 1,
            'chain_store_code' => $order['storeid'],
            'transport_info' => array(
                'transport_name' => $store['title'],
                'transport_address' => $store['address'],
                'transport_longitude' => $store['lng'],
                'transport_latitude' => $store['lat'],
                'position_source' => 2,
                'transport_tel' => $store['tel'],
                'transport_remark' => '备注'
            ),
            'receiver_info' => array(
                'receiver_name' => $order['username'],
                'receiver_primary_phone' => $order['tel'],
                'receiver_second_phone' => $order['tel'],
                'receiver_address' => $order['address'],
                'position_source' => 3,
                'receiver_longitude' => $hx['gg_lon'],
                'receiver_latitude' => $hx['gg_lat']
            ),
            'items_json' => $items_json,
            "order_add_time" => intval($order['dateline']) * 1000,
            "order_total_amount" => $order['totalprice'],
            "order_actual_amount" => $order['totalprice'],
            "order_remark" => $order['remark'],
            "is_invoiced" => 0,
            "order_weight" => 2,
            "invoice" => "",
            "order_payment_status" => $order['ispay'],
            "order_payment_method" => 1,
            "is_agent_payment" => 0,
            "require_payment_pay" => 0,
            "goods_count" => $order['totalnum'],
            "require_receive_time" => $sendtime //时间
        );

//        $returnresult = $rop->sendOrder($dataArray);  // second 创建订单
//        file_put_contents(IA_ROOT . "/addons/weisrc_dish/fengniao_data.log", var_export($dataArray, true) . PHP_EOL, FILE_APPEND);

        $returnresult = $rop->sendOrder($dataArray);  // second 创建订单
        $returnresult = json_decode($returnresult, true);
        if ($returnresult['code'] != "200") {
            file_put_contents(IA_ROOT . "/addons/weisrc_dish/fengniaofail.log", var_export($returnresult, true) . PHP_EOL,
                FILE_APPEND);
            message('提示:' . $returnresult['msg'] . ';门店:' . $store['title'] . ';code:' . $returnresult['code']);
        } else {
            file_put_contents(IA_ROOT . "/addons/weisrc_dish/fengniaosuccess.log", var_export($returnresult, true) . PHP_EOL, FILE_APPEND);
            pdo_update($this->table_order, array('isfengniao' => 1), array('id' => $orderid));
        }
    }

    public function queryStoreDelivery($lng, $lat, $store, $setting)
    {
        global $_W, $_GPC;
        $rop = new fengniao($setting['fengniao_appid'], $setting['fengniao_key'], $setting['fengniao_mode']);
        $rop->requestToken();
        if (empty($setting['fengniao_appid']) || empty($setting['fengniao_key']) || $store['is_fengniao'] == 0) {
            return false;
        }

        $hx = bd_decrypt($lng, $lat);
        $dataArray = array(
            "chain_store_code" => $store['id'],
            "position_source" => 3,
            "receiver_longitude" => $hx['gg_lon'],
            "receiver_latitude" => $hx['gg_lat']
        );
        $result = $rop->queryStoreDelivery($dataArray);
        $result = json_decode($result, true);
        return $result;
    }

    public function doMobilefengniaonotify()
    {
        global $_GPC, $_W;
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $str = htmlspecialchars_decode($_GPC['__input']['data']);
        $str = urldecode($str);
        $data = json_decode($str, true);
        file_put_contents(IA_ROOT . "/addons/weisrc_dish/notify.log", var_export($str, true) . PHP_EOL, FILE_APPEND);
        $orderid = intval($data['partner_order_code']);
        $order = $this->getOrderById($orderid);
        $item = array(
            'weid' => $order['weid'],
            'storeid' => $order['storeid'],
            'open_order_code' => $data['open_order_code'],
            'partner_order_code' => $data['partner_order_code'],
            'order_status' => $data['order_status'],
            'push_time' => TIMESTAMP,
            'carrier_driver_name' => $data['carrier_driver_name'],
            'carrier_driver_phone' => $data['carrier_driver_phone'],
            'cancel_reason' => $data['cancel_reason'],
            'description' => $data['description'],
            'error_code' => $data['error_code'],
        );
        pdo_insert("weisrc_dish_fengniao", $item);
    }

    public function doWebQueryorder()
    {
        global $_W, $_GPC;
        $sn = $_GPC['sn'];
        $rop = new fengniao('', '');
        $rop->requestToken();
        echo $rop->queryQrder($sn);
    }

    public function doWebcancelorder()
    {
        global $_W, $_GPC;
        $sn = $_GPC['sn'];
        $rop = new fengniao('', '');
        $rop->requestToken();
        echo $rop->cancelQrder($sn);
    }

    public function getdistanceprice($storeid, $distance)
    {
        $strwhere = "  where storeid = :storeid AND weid=:weid AND :distance>=begindistance AND :distance<enddistance ";
        $data = pdo_fetch("select * from " . tablename("weisrc_dish_distance") . " {$strwhere} ORDER BY id DESC LIMIT 1", array(':storeid' => $storeid, ':weid' => $this->_weid, ':distance' => $distance));
        return $data;
    }

    public function getNewLimitPrice($storeid, $price, $mode)
    {
        $strwhere = "  where storeid = :storeid AND weid=:weid AND :price>=gmoney AND type=3 AND :time<endtime ";
        if ($mode == 1) { //店内
            $strwhere .= " AND is_meal=1 ";
        } else if ($mode == 2) { //外卖
            $strwhere .= " AND is_delivery=1 ";
        } else if ($mode == 3) { //预定
            $strwhere .= " AND is_reservation=1 ";
        } else if ($mode == 4) { //快餐
            $strwhere .= " AND is_snack=1 ";
        }

        $coupon = pdo_fetch("select * from " . tablename($this->table_coupon) . " {$strwhere} ORDER BY gmoney desc,id DESC LIMIT 1", array(':storeid' => $storeid, ':weid' => $this->_weid, ':price' => $price, ':time' => TIMESTAMP));
        return $coupon;
    }

    public function getOldLimitPrice($storeid, $price, $mode)
    {
        $strwhere = "  where storeid = :storeid AND weid=:weid AND :price>=gmoney AND type=4 AND :time<endtime ";
        if ($mode == 1) { //店内
            $strwhere .= " AND is_meal=1 ";
        } else if ($mode == 2) { //外卖
            $strwhere .= " AND is_delivery=1 ";
        } else if ($mode == 3) { //预定
            $strwhere .= " AND is_reservation=1 ";
        } else if ($mode == 4) { //快餐
            $strwhere .= " AND is_snack=1 ";
        }

        $coupon = pdo_fetch("select * from " . tablename($this->table_coupon) . " {$strwhere} ORDER BY gmoney desc,id DESC LIMIT 1", array(':storeid' => $storeid, ':weid' => $this->_weid, ':price' => $price, ':time' => TIMESTAMP));
        return $coupon;
    }

    public function isNewUser($storeid)
    {
        $isnewuser = 1;
        $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid=:weid AND storeid=:storeid AND from_user=:from_user AND
status<>-1 ORDER BY id DESC LIMIT 1", array(':from_user' => $this->_fromuser, ':weid' => $this->_weid, ':storeid' => $storeid));
        if ($order) {
            $isnewuser = 0;
        }
        return $isnewuser;
    }

    public function doMobileUserAddress()
    {
        global $_GPC, $_W;
        $storeid = intval($_GPC['storeid']);
        $mode = intval($_GPC['mode']);
        $tablesid = intval($_GPC['tablesid']);

        $rtype = !isset($_GPC['rtype']) ? 1 : intval($_GPC['rtype']);
        $timeid = intval($_GPC['timeid']);
        $selectdate = trim($_GPC['selectdate']);

        $id = intval($_GPC['id']);
        $backurl = $this->createMobileUrl('wapmenu', array('storeid' => $storeid, 'mode' => $mode, 'tablesid' => $tablesid, 'selectdate' => $selectdate, 'timeid' => $timeid, 'rtype' => $rtype),
            true);
        if ($storeid == 0 || $mode == 0) {
            $backurl = $this->createMobileUrl('usercenter', array(), true);
        }
        $addurl = $this->createMobileUrl('useraddress', array('storeid' => $storeid, 'mode' => $mode, 'tablesid' => $tablesid, 'op' => 'post', 'id' => $id, 'selectdate' => $selectdate, 'timeid' => $timeid, 'rtype' => $rtype), true);

        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'display') {
            $sql = "select * from " . tablename($this->table_useraddress) . " WHERE from_user=:from_user ORDER BY dateline DESC ";
            $paras = array(':from_user' => $this->_fromuser);
            $list = pdo_fetchall($sql, $paras);
        } else if ($operation == 'post') {
            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT * FROM " . tablename($this->table_useraddress) . " WHERE id=:id", array(":id" => $id));
        } else if ($operation == 'AddAddress') {
            $data = array(
                'weid' => $this->_weid,
                'from_user' => $this->_fromuser,
                'realname' => trim($_GPC['realname']),
                'mobile' => trim($_GPC['mobile']),
                'address' => trim($_GPC['address']),
                'doorplate' => trim($_GPC['doorplate']),
                'isdefault' => 1,
                'lat' => trim($_GPC['lat']),
                'lng' => trim($_GPC['lng']),
                'dateline' => TIMESTAMP
            );
            pdo_update($this->table_useraddress, array('isdefault' => 0), array('from_user' => $this->_fromuser));
            if (!empty($id)) {
                pdo_update($this->table_useraddress, $data, array('id' => $id, 'from_user' => $this->_fromuser));
            } else {
                pdo_insert($this->table_useraddress, $data);
            }
            exit;
        } else if ($operation == 'delete') {
            if ($id != 0) {
                pdo_delete($this->table_useraddress, array('id' => $id, 'from_user' => $this->_fromuser));
                exit;
            }
        } else if ($operation == 'setdefault') {
            if ($id != 0) {
                pdo_update($this->table_useraddress, array('isdefault' => 0), array('from_user' => $this->_fromuser));
                pdo_update($this->table_useraddress, array('isdefault' => 1), array('id' => $id, 'from_user' => $this->_fromuser));
                exit;
            }
        }
        include $this->template($this->cur_tpl . '/address');
    }

    public function doMobileGetgoodsdetail()
    {
        global $_GPC, $_W;
        $weid = $this->_weid;
        $from_user = $this->_fromuser;
        $storeid = intval($_GPC['storeid']);

        //查询商品是否存在
        $id = intval($_GPC['id']); //商品id

        $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id=:id", array(":id" => $id));
        if (empty($goods)) {
            echo json_encode(0);
        } else {
            $goods['content'] = htmlspecialchars_decode($goods['content']);
            $goods['thumb'] = tomedia($goods['thumb']);

            $store = $this->getStoreById($storeid);
            if ($store['is_card'] == 1) {
                $iscard = $this->get_store_card($storeid, $this->_fromuser);
            } else {
                $iscard = $this->get_sys_card($this->_fromuser);
            }


            $goods['dprice'] = $goods['marketprice'];
            if ($iscard == 1 && !empty($goods['memberprice'])) {
                $goods['dprice'] = $goods['memberprice'];
            }
            $goods['isoptions'] = $goods['isoptions'];

            $is_sale_end = 0;
            if ($goods['counts'] == 0) {
                $is_sale_end = 1;
            } elseif ($goods['counts'] > 0) {
                $count = $goods['counts'] - $goods['today_counts'];
                if ($count <= 0) {
                    $is_sale_end = 1;
                }
            }
            $goods['is_sale_end'] = $is_sale_end;

            $cart = pdo_fetch("SELECT * FROM " . tablename($this->table_cart) . " WHERE  storeid=:storeid AND from_user=:from_user AND weid=:weid AND
goodsid=:goodsid", array(':storeid' => $storeid, ':from_user' => $from_user, ':weid' => $weid, ':goodsid' => $id));

            $goods['total'] = intval($cart['total']);

            echo json_encode($goods);
        }
    }

    public function doWebgetselectoption()
    {
        global $_GPC, $_W;
        //查询商品是否存在
        $id = intval($_GPC['dishid']); //商品id
        $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id=:id", array(":id" => $id));
        if (empty($goods)) {
            echo json_encode(0);
        } else {
            $storeid = $goods['storeid'];
            $store = $this->getStoreById($storeid);
            if ($store['is_card'] == 1) {
                $iscard = $this->get_store_card($storeid, $this->_fromuser);
            } else {
                $iscard = $this->get_sys_card($this->_fromuser);
            }

            $goods['dprice'] = $goods['marketprice'];
            if ($iscard == 1 && !empty($goods['memberprice'])) {
                $goods['dprice'] = $goods['memberprice'];
            }
            $optionid = trim($_GPC['optionid']);
            $optionids = explode('_', $optionid);
            $optionprice = 0;

            if (count($optionids) > 0) {
                $optionprice = pdo_fetchcolumn("SELECT sum(price) FROM " . tablename("weisrc_dish_goods_option") . "  WHERE id IN ('" . implode("','", $optionids) . "')");

            }
            $goods['price'] = floatval($goods['dprice']) + floatval($optionprice);
            echo json_encode($goods);
        }
    }

    public function doMobilegetselectoption()
    {
        global $_GPC, $_W;
        //查询商品是否存在
        $id = intval($_GPC['dishid']); //商品id
        $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id=:id", array(":id" => $id));
        if (empty($goods)) {
            echo json_encode(0);
        } else {
            $storeid = $goods['storeid'];
            $store = $this->getStoreById($storeid);
            if ($store['is_card'] == 1) {
                $iscard = $this->get_store_card($storeid, $this->_fromuser);
            } else {
                $iscard = $this->get_sys_card($this->_fromuser);
            }


            $goods['dprice'] = $goods['marketprice'];
            if ($iscard == 1 && !empty($goods['memberprice'])) {
                $goods['dprice'] = $goods['memberprice'];
            }
            $optionid = trim($_GPC['optionid']);
            $optionids = explode('_', $optionid);
            $optionprice = 0;

            if (count($optionids) > 0) {
                $optionprice = pdo_fetchcolumn("SELECT sum(price) FROM " . tablename("weisrc_dish_goods_option") . "  WHERE id IN ('" . implode("','", $optionids) . "')");


//                $option = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_goods_option") . " WHERE id=:id", array
            }
            $goods['price'] = floatval($goods['dprice']) + floatval($optionprice);
            echo json_encode($goods);
        }
    }

    function array_unique_fb($array2D)
    {
        $array = array();
        foreach ($array2D as $k => $v) {
            if (!in_array($v['sncode'], $array)) {
                $array[] = $v['sncode'];
                $temp[$k] = $v;
            }
        }
        return $temp;
    }

    public function doMobileGetgoodsoption()
    {
        global $_GPC, $_W;
        //查询商品是否存在
        $id = intval($_GPC['id']); //商品id
        $goods = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_goods_option") . " WHERE goodsid=:goodsid
        ORDER BY displayorder DESC", array(":goodsid" => $id));
        $str = '';
        if (empty($goods)) {
            echo json_encode(0);
        } else {
            $goodsgroup = array();
            foreach ($goods as $key => $value) {
                if (!in_array($value['start'], $goodsgroup)) {
                    $goodsgroup[] = $value['start'];
                }
            }


            foreach ($goodsgroup as $key1 => $val) {
                $str .= '<ul class="que_box">' . '<span class="guige">' . $val . '</span>';
//                $z_index = 1;
                foreach ($goods as $key2 => $val2) {
                    $tstr = '';
//                    if ($z_index == 1) {
//                        $tstr = ' class="on"';
//                    }
                    if ($val == $val2['start']) {
                        $str .= '<li onclick="return addClass(this,' . $id . ');" specid="' . $val2['id'] . '" ' . $tstr . '>' . $val2['title'] . '</li>';
                    }
//                    $z_index++;
                }
                $str .= '</ul>';
            }

            $goodsitem = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id=:id", array(":id" =>
                $id));

            $storeid = $goodsitem['storeid'];
            $store = $this->getStoreById($storeid);
            if ($store['is_card'] == 1) {
                $iscard = $this->get_store_card($storeid, $this->_fromuser);
            } else {
                $iscard = $this->get_sys_card($this->_fromuser);
            }

            $goodsitem['dprice'] = $goodsitem['marketprice'];
            if ($iscard == 1 && !empty($goodsitem['memberprice'])) {
                $goodsitem['dprice'] = $goodsitem['memberprice'];
            }

            $data = array(
                'price' => $goodsitem['dprice'],
                'title' => $goodsitem['title'],
                'content' => $str
            );
            echo json_encode($data);
        }
    }

    public function out_fans($strwhere, $paras, $datapage)
    {
        global $_GPC, $_W;

        $pindex = max(1, intval($datapage));
        $start = ($pindex - 1) * 100;
        $limit = "";
        $limit .= " LIMIT {$start},100";

        $sql = "select * from " . tablename($this->table_fans)
            . " WHERE $strwhere ORDER BY status DESC, dateline DESC" . $limit;

        $list = pdo_fetchall($sql, $paras);

        $i = 0;
        foreach ($list as $key => $value) {
            $shenfen = '消费者';
            if ($value['is_commission'] == 2) {
                if ($value['agentid'] > 0) {
                    $shenfen = "代理商";
                } else {
                    $shenfen = "股东";
                }
            }

            $order_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . "  WHERE status=3 AND weid = :weid AND from_user=:from_user", array(':weid' => $_W['uniacid'], ':from_user' => $value['from_user']));

            $fans = mc_fetch($value['from_user'], array("credit1", "credit2"));

            $arr[$i]['nickname'] = $value['nickname'];
            $arr[$i]['shenfen'] = $shenfen;
            $arr[$i]['coin'] = floatval($fans['credit2']);

            $pay_price = pdo_fetchcolumn("SELECT sum(totalprice) FROM " . tablename($this->table_order) . " WHERE status=3 AND weid = :weid AND from_user=:from_user", array(':weid' => $_W['uniacid'], ':from_user' => $value['from_user']));

            $arr[$i]['totalprice'] = sprintf('%.2f', $pay_price);
            $arr[$i]['ordercount'] = intval($order_count);

            $mymember_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_fans) . " WHERE weid = :weid AND (agentid=:agentid OR agentid2=:agentid)", array(':weid' => $_W['uniacid'], ':agentid' => $value['id']));
            $arr[$i]['mymember_count'] = $mymember_count;

//            $pay_price = pdo_fetchcolumn("SELECT sum(totalprice) AS totalprice FROM " . tablename($this->table_order) . " WHERE ispay=1 AND status=3 AND weid =:weid AND from_user in (SELECT from_user FROM " . tablename($this->table_fans) . " WHERE weid = :weid AND (agentid=:agentid
//  OR agentid2=:agentid))  ", array(':weid' => $_W['uniacid'], ':from_user' => $value['from_user'], ':agentid' => $value['id']));
            $arr[$i]['pay_price'] = $pay_price;
            $mymember_count2 = 0;
            if ($value['is_commission'] == 2) {
                if ($value['agentid'] == 0) {
                    $mymember_count3 = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_fans) . " WHERE weid = :weid AND agentid=:agentid", array(':weid' => $_W['uniacid'], ':agentid' => $value['id']));
                    $mymember_count2 = $mymember_count3;
                } else {
                    $mymember_count2 = 0;
                }
            }
            $arr[$i]['mymember_count2'] = $mymember_count2;
            $i++;
        }

        $this->exportexcel($arr, array('微信名', '身份', '余额', '消费总额', '单数', '下线人数', '下线消费总额', '下线代理人数'), TIMESTAMP);
        exit();
    }

    public function out_order($commoncondition, $paras)
    {
        $sql = "select * from " . tablename($this->table_order)
            . " WHERE $commoncondition ORDER BY status DESC, dateline DESC ";
        $list = pdo_fetchall($sql, $paras);
        $orderstatus = array(
            '-1' => array('css' => 'default', 'name' => '已取消'),
            '0' => array('css' => 'danger', 'name' => '待处理'),
            '1' => array('css' => 'info', 'name' => '已确认'),
            '2' => array('css' => 'warning', 'name' => '已付款'),
            '3' => array('css' => 'success', 'name' => '已完成')
        );

        $paytypes = array(
            '0' => array('css' => 'danger', 'name' => '未选择'),
            '1' => array('css' => 'info', 'name' => '余额支付'),
            '2' => array('css' => 'warning', 'name' => '微信支付'),
            '3' => array('css' => 'success', 'name' => '现金支付'),
            '4' => array('css' => 'warning', 'name' => '支付宝'),
            '5' => array('css' => 'warning', 'name' => '现金'),
            '6' => array('css' => 'warning', 'name' => '银行卡'),
            '7' => array('css' => 'warning', 'name' => '会员卡'),
            '8' => array('css' => 'warning', 'name' => '微信'),
            '9' => array('css' => 'warning', 'name' => '支付宝'),
            '10' => array('css' => 'warning', 'name' => 'pos刷卡'),
            '11' => array('css' => 'warning', 'name' => '挂帐'),
        );

        $i = 0;
        foreach ($list as $key => $value) {
            $store = $this->getStoreById($value['storeid']);
            $arr[$i]['storetitle'] = $store['title'];
            $arr[$i]['ordersn'] = "'" . $value['ordersn'];
            $arr[$i]['transid'] = "'" . $value['transid'];
            $arr[$i]['paytype'] = $paytypes[$value['paytype']]['name'];
            $arr[$i]['status'] = $orderstatus[$value['status']]['name'];
            $arr[$i]['totalnum'] = "'" . $value['totalnum'];
            $arr[$i]['totalprice'] = $value['totalprice'];
            $arr[$i]['goodsprice'] = $value['goodsprice'];
            $arr[$i]['dispatchprice'] = $value['dispatchprice'];
            $arr[$i]['packvalue'] = $value['packvalue'];
            $arr[$i]['tea_money'] = $value['tea_money'];
            $arr[$i]['service_money'] = $value['service_money'];
            $arr[$i]['username'] = $value['username'];
            $arr[$i]['tel'] = $value['tel'];
            $arr[$i]['address'] = $value['address'];
            $arr[$i]['dateline'] = date('Y-m-d H:i:s', $value['dateline']);
            if ($value['delivery_id'] != 0) {
                $deliveryuser = $this->getAccountById($value['delivery_id']);
            }
            if ($value['deliveryareaid'] != 0) {
                $deliveryarea = $this->getDeliveryById($value['deliveryareaid']);
            }

            $arr[$i]['deliveryarea'] = $deliveryarea['title'];
            $arr[$i]['deliveryuser'] = empty($deliveryuser) ? $value['deliveryareaid'] : $deliveryuser['username'];
            $arr[$i]['delivery_money'] = $value['delivery_money'];


            if ($value['couponid'] != 0) {
                $coupon = pdo_fetch("SELECT a.* FROM " . tablename($this->table_coupon) . "
        a INNER JOIN " . tablename($this->table_sncode) . " b ON a.id=b.couponid
 WHERE a.weid = :weid AND b.id=:couponid ORDER BY b.id
 DESC LIMIT 1", array(':weid' => $this->weid, ':couponid' => $value['couponid']));
                if (!empty($coupon)) {
                    if ($coupon['type'] == 2) {
                        $coupon_info = "抵用金额" . $value['discount_money'];
                    } else {
                        $coupon_info = $coupon['title'];
                    }
                }
            }
            $arr[$i]['coupon_info'] = $coupon_info;
            if (!empty($value['newlimitprice'])) {
                $arr[$i]['newlimitprice'] = $value['newlimitprice'];
            } else {
                $arr[$i]['newlimitprice'] = '';
            }
            if (!empty($value['oldlimitprice'])) {
                $arr[$i]['oldlimitprice'] = $value['oldlimitprice'];
            } else {
                $arr[$i]['oldlimitprice'] = '';
            }
            $arr[$i]['remark'] = $value['remark'];

            $i++;
        }

        $this->exportexcel($arr, array('所属商家', '订单号', '商户订单号', '支付方式', '状态', '数量', '总价', '商品价格', '配送费', '打包费', '茶位费', '服务费', '真实姓名', '电话号码', '地址', '时间', '配送点', '配送员', '配送佣金', '优惠信息', '新用户满减', '老用户满减', '备注'), TIMESTAMP);
        exit();
    }

    public function getIdentityByFans($fans)
    {
        $setting = $this->getSetting();
        $tip = "消费者";
        if ($setting['is_commission'] == 1) { //开启分销
            if ($setting['commission_mode'] == 2) { //代理商模式
                if ($fans['is_commission'] == 2) { //代理商
                    $tip = "代理商";
                    $is_commission = 1;
                    if ($fans['agentid'] == 0) {
                        $tip = "股东";
                    }
                } else { //消费者
                    $tip = "消费者";
                }
            }
        }
        return $tip;
    }

    public function out_goods($commoncondition, $paras)
    {

        $sql = "select * from " . tablename($this->table_order)
            . " WHERE $commoncondition ORDER BY status DESC, dateline DESC ";
        $list = pdo_fetchall($sql, $paras);
        $orderstatus = array(
            '-1' => array('css' => 'default', 'name' => '已取消'),
            '0' => array('css' => 'danger', 'name' => '待处理'),
            '1' => array('css' => 'info', 'name' => '已确认'),
            '2' => array('css' => 'warning', 'name' => '已付款'),
            '3' => array('css' => 'success', 'name' => '已完成')
        );

        $paytypes = array(
            '0' => array('css' => 'danger', 'name' => '未选择'),
            '1' => array('css' => 'info', 'name' => '余额支付'),
            '2' => array('css' => 'warning', 'name' => '微信支付'),
            '3' => array('css' => 'success', 'name' => '现金支付'),
            '4' => array('css' => 'warning', 'name' => '支付宝'),
            '5' => array('css' => 'warning', 'name' => '现金'),
            '6' => array('css' => 'warning', 'name' => '银行卡'),
            '7' => array('css' => 'warning', 'name' => '会员卡'),
            '8' => array('css' => 'warning', 'name' => '微信'),
            '9' => array('css' => 'warning', 'name' => '支付宝'),
            '10' => array('css' => 'warning', 'name' => 'pos刷卡'),
            '11' => array('css' => 'warning', 'name' => '挂帐'),
        );

        $i = 0;
        foreach ($list as $key => $value) {
            $store = $this->getStoreById($value['storeid']);
            if ($value['delivery_id'] != 0) {
                $deliveryuser = $this->getAccountById($value['delivery_id']);
            }
            if ($value['deliveryareaid'] != 0) {
                $deliveryarea = $this->getDeliveryById($value['deliveryareaid']);
            }
            $fans = $this->getFansByOpenid($value['from_user']);
            $identity = $this->getIdentityByFans($fans);
            $agentname = '平台';
            $agentname2 = '平台';
            if ($identity == '股东') {
                $agentname = $value['username'] . '(股东)';
                $agentname2 = $value['username'] . '(股东)';
            }
            if ($fans['agentid'] <> 0) {
                $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $fans['agentid'], ':weid' => $this->_weid));
                if ($identity == "代理商") {
                    $agentname = $value['username'] . '(代理商)';
                    $identity1 = $this->getIdentityByFans($agent);
                    $agentname2 = $agent['username'] . "({$identity1})";
                } else {
                    $identity1 = $this->getIdentityByFans($agent);
                    $agentname = $agent['username'] . "({$identity1})";
                    if ($identity1 == '股东') {
                        $agentname2 = $agentname;
                    } else {
                        $agent2 = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $agent['agentid'], ':weid' => $this->_weid));
                        $identity2 = $this->getIdentityByFans($agent2);
                        $agentname2 = $agent2['username'] . "({$identity2})";
                    }
                }
            }
            $orderid = $value['id'];
            $goods = pdo_fetchall("SELECT a.goodsid,a.price, a.total,b.thumb,b.title,b.id,b.pcate,b.credit,b.commission_money1,b.commission_money2 FROM " . tablename($this->table_order_goods) . "
a INNER JOIN " . tablename($this->table_goods) . " b ON a.goodsid=b.id WHERE a.orderid = :orderid", array(':orderid' => $orderid));
            $j = 0;
            foreach ($goods as $goodkey => $goodvalue) {
                if ($j == 0) {
                    $arr[$i]['storetitle'] = $store['title'];
                    $arr[$i]['ordersn'] = "'" . $value['ordersn'];
                    $arr[$i]['transid'] = "'" . $value['transid'];
                    $arr[$i]['paytype'] = $paytypes[$value['paytype']]['name'];
                    $arr[$i]['status'] = $orderstatus[$value['status']]['name'];
                } else {
                    $arr[$i]['storetitle'] = '';
                    $arr[$i]['ordersn'] = '';
                    $arr[$i]['transid'] = '';
                    $arr[$i]['paytype'] = '';
                    $arr[$i]['status'] = '';
                }

                $arr[$i]['goodsname'] = $goodvalue['title'];
                $arr[$i]['goodstotal'] = $goodvalue['total'];
                $arr[$i]['goodsprice'] = $goodvalue['price'];
                if ($j == 0) {
                    $arr[$i]['totalprice'] = $value['totalprice'];
                } else {
                    $arr[$i]['totalprice'] = '';
                }

                $arr[$i]['dispatchprice'] = $value['dispatchprice'];
                $arr[$i]['packvalue'] = $value['packvalue'];
                $arr[$i]['tea_money'] = $value['tea_money'];
                $arr[$i]['service_money'] = $value['service_money'];
                $arr[$i]['agent1'] = $agentname;;
                $arr[$i]['commission_money1'] = floatval($goodvalue['commission_money1']) * intval($goodvalue['total']);
                $arr[$i]['agent2'] = $agentname2;
                $arr[$i]['commission_money2'] = floatval($goodvalue['commission_money2']) * intval($goodvalue['total']);
                $arr[$i]['username'] = $value['username'];
                $arr[$i]['identity'] = $identity;
                $arr[$i]['tel'] = $value['tel'];
                $arr[$i]['address'] = $value['address'];
                $arr[$i]['dateline'] = date('Y-m-d H:i:s', $value['dateline']);
                $arr[$i]['deliveryarea'] = $deliveryarea['title'];
                $arr[$i]['deliveryuser'] = $deliveryuser['username'];
                $arr[$i]['delivery_money'] = $value['delivery_money'];

                $coupon_info = '';
                if ($value['couponid'] != 0) {
                    $coupon = pdo_fetch("SELECT a.* FROM " . tablename($this->table_coupon) . "
        a INNER JOIN " . tablename($this->table_sncode) . " b ON a.id=b.couponid
 WHERE a.weid = :weid AND b.id=:couponid ORDER BY b.id
 DESC LIMIT 1", array(':weid' => $this->weid, ':couponid' => $value['couponid']));
                    if (!empty($coupon)) {
                        if ($coupon['type'] == 2) {
                            $coupon_info = "抵用金额" . $value['discount_money'];
                        } else {
                            $coupon_info = $coupon['title'];
                        }
                    }
                }
                $arr[$i]['coupon_info'] = $coupon_info;
                if (!empty($value['newlimitprice'])) {
                    $arr[$i]['newlimitprice'] = $value['newlimitprice'];
                }
                if (!empty($value['oldlimitprice'])) {
                    $arr[$i]['oldlimitprice'] = $value['oldlimitprice'];
                }

                $j++;
                $i++;
            }
        }

        $this->exportexcel($arr, array('所属商家', '订单号', '商户订单号', '支付方式', '状态', '产品详情', '数量', '商品价格', '总价', '配送费', '打包费', '茶位费', '服务费', '一级', '一级佣金', '二级', '二级佣金', '真实姓名', '消费身份', '电话号码', '地址', '时间', '配送点', '配送员', '配送佣金', '优惠信息', '新用户满减', '老用户满减'), TIMESTAMP);
        exit();
    }

    public function doWebSendusercoupon()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $id = intval($_GPC['couponid']);
        $fansid = intval($_GPC['fansid']);

        $fans = $this->getFansById($fansid);
        if (empty($fans)) {
            $this->showMsg('用户不存在!');
        } else {
            $from_user = $fans['from_user'];
        }

        //优惠券 1.发放总数2.没人领取数量
        $coupon = pdo_fetch("SELECT * FROM " . tablename($this->table_coupon) . " WHERE id=:id LIMIT 1", array(':id' => $id));
        if (empty($coupon)) {
            $this->showMsg('优惠券不存在!');
        } else {
            //判断优惠券属性  普通券1 营销券2
            if ($coupon['attr_type'] == 2) {
                $this->showMsg('该优惠券属于营销券,不能领取!');
            }
            if (TIMESTAMP < $coupon['starttime']) {
                $this->showMsg('活动时间还未开始,不能领取!');
            }
            if (TIMESTAMP > $coupon['endtime']) {
                $this->showMsg('活动时间已经结束啦!');
            }
        }
        $coupon_usercount = $coupon['usercount'];//每个用户能领取数量 0为不限制
        $coupon_totalcount = $coupon['totalcount'];//发放总数量 0为不限制

        $user_count = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_sncode) . " WHERE weid = :weid and from_user=:from_user AND couponid=:couponid ORDER
BY id DESC", array(':weid' => $weid, ':from_user' => $from_user, ':couponid' => $id));
        $total_count = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_sncode) . " WHERE weid = :weid AND couponid=:couponid ORDER BY id DESC", array(':weid' => $weid, ':couponid' => $id));

        $sncode = 'SN' . random(11, 1);
        $sncode = $this->getNewSncode($weid, $sncode);
        $data = array(
            'couponid' => $id,
            'sncode' => $sncode,
            'storeid' => $coupon['storeid'],
            'weid' => $weid,
            'from_user' => $from_user,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_sncode, $data);
        $this->showMsg('优惠券赠送成功!', 1);
    }

    public function doWebQueryFans()
    {
        global $_W, $_GPC;

        $kwd = $_GPC['keyword'];
        $sql = "SELECT * FROM " . tablename($this->table_fans) . " WHERE `weid`=:weid AND `nickname` LIKE :nickname AND `nickname`<>'' ORDER
BY lasttime DESC,id DESC LIMIT 0,8";
        $params = array();
        $params[':weid'] = $_W['uniacid'];
        $params[':nickname'] = "%{$kwd}%";
        $ds = pdo_fetchall($sql, $params);
        foreach ($ds as &$row) {
            $r = array();
            $r['id'] = $row['id'];
            $r['nickname'] = str_replace('\'', '', $row['nickname']);
            $r['headimgurl'] = $row['headimgurl'];
            $r['from_user'] = $row['from_user'];
            $row['entry'] = $r;

        }
        include $this->template('web/_query_fans');
    }

    public function doWebCardFans()
    {
        global $_W, $_GPC;

        $kwd = $_GPC['keyword'];
        $storeid = intval($_GPC['storeid']);

        $sql = "SELECT * FROM " . tablename($this->table_fans) . " WHERE `weid`=:weid AND `nickname` LIKE :nickname AND `nickname`<>'' ORDER
BY lasttime DESC,id DESC LIMIT 0,8";
        $params = array();
        $params[':weid'] = $_W['uniacid'];
        $params[':nickname'] = "%{$kwd}%";
        $ds = pdo_fetchall($sql, $params);
        foreach ($ds as &$row) {
            $r = array();
            $r['id'] = $row['id'];
            $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecard') . " WHERE storeid=:storeid AND from_user=:from_user
LIMIT 1;", array(':storeid' => $storeid, ':from_user' => $row['from_user']));
            if ($card) {
                $r['nickname'] = '(会员)' . str_replace('\'', '', $row['nickname']);
            } else {
                $r['nickname'] = str_replace('\'', '', $row['nickname']);
            }

            $r['headimgurl'] = $row['headimgurl'];
            $r['from_user'] = $row['from_user'];
            $row['entry'] = $r;
        }

        foreach ($ds as $key => $value) {
            $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecard') . " WHERE storeid=:storeid AND from_user=:from_user
LIMIT 1;", array(':storeid' => $storeid, ':from_user' => $value['from_user']));
            if ($card) {
                $ds[$key]['nickname'] = '(会员)' . str_replace('\'', '', $row['nickname']);
            } else {
                $ds[$key]['nickname'] = str_replace('\'', '', $row['nickname']);
            }
        }
        include $this->template('web/_query_card');
    }

    public function doWebQueryCouponFans()
    {
        global $_W, $_GPC;

        $kwd = $_GPC['keyword'];
        $sql = "SELECT * FROM " . tablename($this->table_fans) . " WHERE `weid`=:weid AND `nickname` LIKE :nickname AND `nickname`<>'' ORDER
BY lasttime DESC,id DESC LIMIT 0,8";
        $params = array();
        $params[':weid'] = $_W['uniacid'];
        $params[':nickname'] = "%{$kwd}%";
        $ds = pdo_fetchall($sql, $params);
        foreach ($ds as &$row) {
            $r = array();
            $r['id'] = $row['id'];
            $r['nickname'] = str_replace('\'', '', $row['nickname']);
            $r['headimgurl'] = $row['headimgurl'];
            $r['from_user'] = $row['from_user'];
            $row['entry'] = $r;

        }
        include $this->template('web/_query_coupon_fans');
    }

    public function doWebQueryStyleGoods()
    {
        global $_W, $_GPC;

        $kwd = $_GPC['keyword'];
        $storeid = intval($_GPC['storeid']);
        $sql = "SELECT * FROM " . tablename($this->table_goods) . " WHERE `weid`=:weid AND `storeid`=:storeid AND `title` LIKE :title ORDER BY id DESC LIMIT 0,15";
        $params = array();
        $params[':weid'] = $_W['uniacid'];
        $params[':storeid'] = $storeid;
        $params[':title'] = "%{$kwd}%";

        $ds = pdo_fetchall($sql, $params);
        foreach ($ds as &$row) {
            $url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&mode=2&storeid=' . $storeid . '&do=goodsdetail&id=' . $row['id'] . '&m=weisrc_dish';

            $r = array();
            $r['id'] = $row['id'];
            $r['title'] = str_replace('\'', '', $row['title']);
            $r['thumb'] = $row['thumb'];
            $r['foodurl'] = $url;
            $row['entry'] = $r;

        }
        include $this->template('web/_query_style_goods');
    }

    public function addRechargePrice($orderid) //充值返现
    {
        $order = $this->getOrderById($orderid);
        if ($order['dining_mode'] == 6) {
            $rechargeid = intval($order['rechargeid']);
            $item = pdo_fetch("SELECT * FROM " . tablename($this->table_recharge) . " where id=:id LIMIT 1", array(':id' => $rechargeid));
            $give_value = floatval($item['give_value']);
            $total = intval($item['total']);
            $givetime = TIMESTAMP;
            if ($item && $give_value > 0) { //充值返现
                if ($total == 0) { //分期
                    $price = $give_value;
                    $data = array(
                        'rechargeid' => $rechargeid,
                        'weid' => $order['weid'],
                        'from_user' => $order['from_user'],
                        'storeid' => $order['storeid'],
                        'orderid' => $orderid,
                        'price' => $price,
                        'status' => 0,
                        'givetime' => $givetime,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert("weisrc_dish_recharge_record", $data);
                } else { //分多期
                    $price = $give_value / $total;
                    for ($i = 0; $i < $total; $i++) {
                        if ($i > 0) {
                            $givetime = strtotime("+{$i}month");
                        }
                        $data = array(
                            'rechargeid' => $rechargeid,
                            'weid' => $order['weid'],
                            'from_user' => $order['from_user'],
                            'storeid' => $order['storeid'],
                            'orderid' => $orderid,
                            'price' => $price,
                            'status' => 0,
                            'givetime' => $givetime,
                            'dateline' => TIMESTAMP
                        );
                        pdo_insert("weisrc_dish_recharge_record", $data);
                    }
                }
            }
        }
    }

    public function checkRechargePrice($from_user) //用户充值返现
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $list = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_recharge_record") . " where weid=:weid AND from_user=:from_user AND status=0 AND
givetime<:givetime", array(':weid' => $weid, ':from_user' => $from_user, ':givetime' => TIMESTAMP));
        foreach ($list as $key => $val) {
            $status = $this->setFansCoin($val['from_user'], $val['price'], "订单编号{$val['orderid']}充值返现");
            if ($status) {
                pdo_update('weisrc_dish_recharge_record', array('status' => 1), array('id' => $val['id']));
            }
        }
    }

    public function sendApplyNotice($setting, $store, $money)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $url = '#';
        $first = "您有新的提现申请";
        $keyword1 = date("Y-m-d日H.i", TIMESTAMP);
        $keyword2 = $money;

        if (!empty($setting['tpluser']) && !empty($setting['tplapplynotice'])) {
            $templateid = $setting['tplapplynotice'];
            $remark = "提现用户：{$store['business_username']}\n";
            if ($store['business_type'] == 1) {
                $remark .= "提现方式：微信账号\n";
            } else {
                $remark .= "提现方式：支付宝\n";
            }
            $remark .= "提现门店：{$store['title']}\n";
            $content = array(
                'first' => array(
                    'value' => $first,
                    'color' => '#a6a6a9'
                ),
                'keyword1' => array(
                    'value' => $keyword1,
                    'color' => '#a6a6a9'
                ),
                'keyword2' => array(
                    'value' => $keyword2,
                    'color' => '#a6a6a9'
                ),
                'remark' => array(
                    'value' => $remark,
                    'color' => '#a6a6a9'
                )
            );

            $templateMessage = new templateMessage();
            $templateMessage->send_template_message($setting['tpluser'], $templateid, $content, '', $url);
        }
    }

    public function sendAdminOperatorNotice($from_user, $tablesid, $type, $setting, $storeid)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $types = array(
            '1' => '呼叫服务员',
            '2' => '我要打包'
        );

        $url = '#';
        $keyword1 = $this->getTableName($tablesid);
        $keyword2 = date("Y-m-d日H.i", TIMESTAMP);
        $store = $this->getStoreById($storeid);

        $templateid = $setting['tploperator'];
        $first = $types[$type];
        $remark = "门店名称：{$store['title']}";

        if ($setting['tpltype'] == 1) {
            $content = array(
                'first' => array(
                    'value' => $first,
                    'color' => '#a6a6a9'
                ),
                'keyword1' => array(
                    'value' => $keyword1,
                    'color' => '#a6a6a9'
                ),
                'keyword2' => array(
                    'value' => $keyword2,
                    'color' => '#a6a6a9'
                ),
                'remark' => array(
                    'value' => $remark,
                    'color' => '#a6a6a9'
                )
            );
        } else {
            $keyword1 = '桌号/房号-' . $this->getTableName($tablesid);
            $keyword2 = '日期-' . date("Y-m-d日H.i", TIMESTAMP);
            $content = array(
                'first' => array(
                    'value' => $first,
                    'color' => '#a6a6a9'
                ),
                'keyword1' => array(
                    'value' => $keyword1,
                    'color' => '#a6a6a9'
                ),
                'keyword2' => array(
                    'value' => $keyword2,
                    'color' => '#a6a6a9'
                ),
                'remark' => array(
                    'value' => $remark,
                    'color' => '#a6a6a9'
                )
            );
        }

        $templateMessage = new templateMessage();
        $templateMessage->send_template_message($from_user, $templateid, $content, '', $url);
    }

    public function getCouponInfo($couponid, $order)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $coupon = pdo_fetch("SELECT a.* FROM " . tablename($this->table_coupon) . "
        a INNER JOIN " . tablename($this->table_sncode) . " b ON a.id=b.couponid
 WHERE a.weid = :weid AND b.id=:snid ORDER BY b.id
 DESC LIMIT 1", array(':weid' => $weid, ':snid' => $couponid));

        if (!empty($coupon)) {
            if ($coupon['type'] == 2) { //代金券
                $coupon_info = "代金券抵用:" . $order['discount_money'] . '元';
            } else {
                $coupon_info = "商品赠送:" . $coupon['title'];
            }
        }
    }

    public function getQrcodeData($oid, $size = 0)
    {
//        global $_W;
//        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $this->getAccessToken2();
//
//        $params = array();
//        $params['scene'] = $oid;
//        $params['width'] = $size ? $size : 270;
//        $params['page'] = "app/pages/index/index";
//        load()->func('communication');
//        $result = ihttp_post($url, json_encode($params));
//        file_put_contents(IA_ROOT . "/addons/weisrc_dish/qrcode", $result['content']);
//        $res = json_decode($result['content'], true);
//
//        if ($res['errcode'] == '40001') {
//            $cachekey = "accesstoken:{$_W['account']['key']}";
//            load()->func('file');
//            cache_write($cachekey, array());
//            return $this->getQrcodeData($oid, $size);
//        }
//        return $result['content'];

        $acid = 59;
        $account_api = WeAccount::create($acid);
        $response = $account_api->getCodeLimit('pages/detail/detail?id=123', 430, array(
            'auto_color' => false,
            'line_color' => array(
                'r' => '#ABABAB',
                'g' => '#ABABAC',
                'b' => '#ABABAD',
            ),
        ));
        return $response['content'];
    }

    private function getAccessToken2()
    {
        global $_W;
//        $acid = $_W['acid'];
//        if (empty($acid)) {
//            $acid = $_W['uniacid'];
//        }
        $acid = 59;
        $account = WeAccount::create($acid);
        $token = $account->getAccessToken();
        return $token;
    }

    //365
    public function _365SendFreeMessage($orderid = 0, $position_type = 0)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        load()->func('communication');

        if ($orderid == 0) {
            return -2;
        }

        $order = $this->getOrderById($orderid);
        if (empty($order)) {
            return -3;
        }

        $storeid = $order['storeid'];
        //打印机配置信息
        $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='365' ", array(':storeid' => $storeid));

        if ($settings == false) {
            return -4;
        }

        $dining_mode = $order['dining_mode']; //1:店内2:外卖3:预定4:快餐5:收银
        $paytype = $this->getPayType($dining_mode);
        $store = $this->getStoreById($storeid);
        $ordertype = $this->getOrderType($store);

        //商品id数组
        $ordergoods = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $orderid));
        $goodsid = array();
        if (!empty($ordergoods)) {
            foreach ($ordergoods as $key => $row) {
                if (isset($row['goodsid'])) {
                    $goodsid[$row['goodsid']] = $row;
                } else {
                    $goodsid[] = $row;
                }
            }
        }


        $paystatus = $order['ispay'] == 0 ? '未支付' : '已支付';

        if ($dining_mode == 3) {
            $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
        }
        if (!empty($order['tables'])) {
            $table_info = $this->getTableName($order['tables']);
        }

        $dining_mode = intval($dining_mode); //1:店内2:外卖3:预定4:快餐
        foreach ($settings as $item => $value) {
            //判断打印订单类型（是否已经支付的单子）
            if ($value['print_type'] == 1 && $order['ispay'] == 0) { //支付模式未支付时
                continue;
            }
            if ($value['print_type'] == 2 && $order['status'] == 0) { //已确认模式未确认订单
                continue;
            }
            if ($position_type == 1 && $value['position_type'] == 2) { //前台模式 后厨打印机
                continue;
            }
            if ($position_type == 2 && $value['position_type'] == 1) { //后厨模式 前台打印机
                continue;
            }

            $target = "http://open.printcenter.cn:8080/addOrder";
            $deviceNo = $value['print_usr'];
            $key = $value['feyin_key'];
            $times = $value['print_nums'];

            $loop_first = 0;
            if ($value['is_meal'] == 1 && $dining_mode == 1) {
                $loop_first = 1;
            }
            if ($value['is_delivery'] == 1 && $dining_mode == 2) {
                $loop_first = 1;
            }
            if ($value['is_reservation'] == 1 && $dining_mode == 3) {
                $loop_first = 1;
            }
            if ($value['is_snack'] == 1 && $dining_mode == 4) {
                $loop_first = 1;
            }
            if ($value['is_shouyin'] == 1 && $dining_mode == 5) {
                $loop_first = 1;
            }

            if ($loop_first == 0) {
                continue;
            }

            $pos = strpos($deviceNo, "kdt1");
            if ($pos === false) {
                $pos = 2;
            }

            $bigfont = "";
            if ($pos == 0) { //s1机器
                $huanhang = "\n";
            } else { //s2机器
                $huanhang = "<BR>";
            }

            $content = '订单编号:' . $order['ordersn'] . $huanhang;
            if ($dining_mode == 4) {
                $content .= '领餐牌号:' . $order['quicknum'] . $huanhang;
            }
            $content .= '订单类型:' . $ordertype[$dining_mode] . $huanhang;
            $content .= '所属门店:' . $store['title'] . $huanhang;
            $content .= '支付方式:' . $paytype[$order['paytype']] . "(" . $paystatus . ")" . $huanhang;
            $content .= '下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . $huanhang;
            if ($dining_mode == 3 && !empty($tablezones)) {
                $content .= "桌台类型：{$tablezones['title']}" . $huanhang;
            }
            if (!empty($order['tables'])) {
                $content .= '桌台信息:' . $table_info . $huanhang;
            }
            if (!empty($order['counts'])) {
                $content .= '用餐人数:' . $order['counts'] . $huanhang;
            }
            if (!empty($order['remark'])) {
//                $content .= '备注:' . $order['remark'] . $huanhang;
                $remark = $this->getPrintContent($order['remark'], 16, $huanhang);
                $content .= $huanhang . '备注:' . $remark . $huanhang . $huanhang;
            }
            $content .= '门店地址:' . $store['address'] . $huanhang;
            $content .= '门店电话:' . $store['tel'] . $huanhang;
            $content2 = "-------------------------" . $huanhang;

            $packvalue = floatval($order['packvalue']);
            $tea_money = floatval($order['tea_money']);
            $service_money = floatval($order['service_money']);
            if ($packvalue > 0 && $dining_mode == 2) {
                $content2 .= "打包费:{$packvalue}元\n";
            }


            $dispatchprice = floatval($order['dispatchprice']);
            if ($dispatchprice > 0 && $dining_mode == 2) {
                $content2 .= "配送费:{$dispatchprice}元\n";
            }
            if ($tea_money > 0 && $dining_mode == 1) {
                $content2 .= "{$store['tea_tip']}:{$tea_money}元\n";
            }
            if ($service_money > 0 && $dining_mode == 1) {
                $content2 .= "服务费:{$service_money}元\n";
            }
            if ($order['couponid'] != 0) {
                $couponinfo = $this->getCouponInfo($order['couponid'], $order);
                $content2 .= $couponinfo;
            }

            $content2 .= "总数量:" . $order['totalnum'] . "   总价:" . number_format($order['totalprice'], 2) . "元\n";
            if ($dining_mode != 4 && !empty($order['meal_time'])) {
                $content2 .= '预定时间:' . $order['meal_time'] . $huanhang;
            }
            if ($dining_mode == 2 || $dining_mode == 3) {
                if (!empty($order['username'])) {
                    $content2 .= '姓名:' . $order['username'] . $huanhang;
                }
                if (!empty($order['tel'])) {
                    $content2 .= '手机:' . $order['tel'] . $huanhang;
                }
                if (!empty($order['address'])) {
                    $content2 .= '地址:' . $order['address'] . $huanhang;
                }
            }

            if ($order['status'] == -1) {
                $print_order_data = array(
                    'weid' => $weid,
                    'orderid' => $orderid,
                    'print_usr' => $deviceNo,
                    'print_status' => -1,
                    'dateline' => TIMESTAMP
                );
                pdo_insert($this->table_print_order, $print_order_data);
                $oid = pdo_insertid();

                $cancelcontent = '订单已取消' . $huanhang;
                $cancelcontent .= '编号:' . $order['ordersn'];
                $post_data = "deviceNo=" . $deviceNo . "&key=" . $key . "&printContent=" . $cancelcontent . "&times=" . $times;
                $result = ihttp_request($target, $post_data);
                $_365status = $result['responseCode'];
                pdo_update('weisrc_dish_print_order', array('print_status' => $_365status), array('id' => $oid));
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                return;
            }

            if (!empty($value['print_top'])) {
                $print_top = "" . $value['print_top'] . $huanhang;
            }
            if (!empty($value['print_bottom'])) {
                $print_bottom = $huanhang . $value['print_bottom'] . "";
            }

            //商品
            if ($value['print_label'] == '0') {
                $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
            } else {
                //餐桌
                $table_label = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " WHERE id=:id", array(":id" => $order['tables']));
                if (in_array($table_label['print_label'], explode(',', $value['print_label']))) {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
                } else {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "') AND labelid IN(" . $value['print_label'] . ")", array(), 'id');
                }
            }
            if (empty($goods) && $dining_mode != 3 && $dining_mode != 5) {
                continue;
            }
            $order['goods'] = $goods;
            if ($goods) {
                if ($order['isvip'] == 1) {
                    $viptip = "(会员)";
                }
                if ($order['is_append'] == 1) {
                    $appendtip = "(加单)";
                }
                $content1 = $huanhang . "商品列表{$viptip}{$appendtip}" . $huanhang;
                $content1 .= "-------------------------" . $huanhang;
            }
            if ($value['is_print_all'] == 1) {
                if ($value['type'] == '365') {
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => $orderid,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }
                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        $money = $v['price'];
                        $money = $money * $v['total'];

                        $ismoreoptions = 0;
                        $optionsstr = '';
                        if (!empty($v['optionname'])) {
                            $options = explode('|', $v['optionname']);
                            if (count($options) > 1) {
                                $ismoreoptions = 1;
                                $goodsname = $goods[$v['goodsid']]['title'];
                                $loopindex = 1;
                                foreach ($options as $option) {
                                    $optionsstr .= "用户{$loopindex}：{$option}" . $huanhang;
                                    $loopindex++;
                                }
                            } else {
                                $goodsname = $goods[$v['goodsid']]['title'] . '[' . $v['optionname'] . ']';
                            }
                        } else {
                            $goodsname = $goods[$v['goodsid']]['title'];
                        }

                        $content1 .= "" . $goodsname . ' ' . $v['total'] . $goods[$v['goodsid']]['unitname'] . ' ' . number_format($money, 2) . "元" . $huanhang;
                        if ($ismoreoptions == 1) {
                            $content1 .= $optionsstr;
                        }
                    }
                }
                if (!empty($value['qrcode_url']) && !empty($value['qrcode_status'])) {
                    if ($pos == 0) {
                        $print_bottom .= $huanhang . "^Q+" . $value['qrcode_url'] . $huanhang;
                    } else {
                        $print_bottom .= $huanhang . "<QR>" . $value['qrcode_url'] . "</QR>" . $huanhang;
                    }
                }

                if ($times > 0) {
                    if ($pos == 0) {
                        $times_str = "^F1^N{$times}";
                    }
                }
                $printContent = $times_str . $print_top . $content . $content1 . $content2 . $print_bottom;
                $post_data = "deviceNo=" . $deviceNo . "&key=" . $key . "&printContent=" . $printContent . "&times=" . $times;
                $result = ihttp_request($target, $post_data);
                $_365status = $result['responseCode'];
                pdo_update('weisrc_dish_print_order', array('print_status' => $_365status), array('id' => $oid));
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
            } else {
                $content = '订单编号:' . $order['ordersn'] . $huanhang;
                $content .= '下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . $huanhang;
                $content .= '用餐人数:' . $order['counts'] . $huanhang;
                if (!empty($order['tables'])) {
                    if ($pos == 0) {
                        $content .= '^B2桌台:' . $this->getTableName($order['tables']) . $huanhang;
                    } else {
                        $content .= '<B>桌台</B>:' . $this->getTableName($order['tables']) . $huanhang;
                    }
                }
                if ($dining_mode == 4) {
                    $content1 .= '<B>领餐牌号:' . $order['quicknum'] . '</B>' . $huanhang;
                }
                if (!empty($order['remark'])) {
                    if ($pos == 0) {
                        $content .= '^B2备注:' . $order['remark'] . $huanhang;
                    } else {
                        $content .= '<B>备注:' . $order['remark'] . '</B>' . $huanhang;
                    }
                }

                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        if ($value['type'] == '365') { //飞印
                            $print_order_data = array(
                                'weid' => $weid,
                                'orderid' => $orderid,
                                'print_usr' => $value['print_usr'],
                                'print_status' => -1,
                                'dateline' => TIMESTAMP
                            );
                            pdo_insert($this->table_print_order, $print_order_data);
                            $oid = pdo_insertid();
                        }
                        $content1 = '';
                        $content1 .= "-------------------------" . $huanhang;
                        $goodsname = $goods[$v['goodsid']]['title'];

                        if ($pos == 0) {
                            $content1 .= '^B2' . $goodsname . $huanhang;
                            if (!empty($v['optionname'])) {
                                $content1 .= '^B2' . '[' . $v['optionname'] . ']' . $huanhang;
                            }
                            $content1 .= '^B2数量:' . $v['total'] . $goods[$v['goodsid']]['unitname'] . $huanhang;
                        } else {
                            $content1 .= '<B>' . $goodsname . '</B>' . $huanhang;
                            if (!empty($v['optionname'])) {
                                $content1 .= '<B>' . '[' . $v['optionname'] . ']' . '</B>' . $huanhang;
                            }
                            $content1 .= '<B>数量:' . $v['total'] . $goods[$v['goodsid']]['unitname'] . '</B>' . $huanhang;
                        }

                        $printContent = $content . $content1;
                        $post_data = "deviceNo=" . $deviceNo . "&key=" . $key . "&printContent=" . $printContent . "&times=" . $times;
                        $result = ihttp_request($target, $post_data);
                        $_365status = $result['responseCode'];
                        pdo_update('weisrc_dish_print_order', array('print_status' => $_365status), array('id' => $oid));
                        pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                    }
                }
            }
        }
    }

    //365标签打印机
    public function _365lblSendFreeMessage($orderid = 0, $position_type = 0)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        load()->func('communication');

        if ($orderid == 0) {
            return -2;
        }

        $order = $this->getOrderById($orderid);
        if (empty($order)) {
            return -3;
        }

        $storeid = $order['storeid'];
        //打印机配置信息
        $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='365lbl' ", array(':storeid' => $storeid));

        if ($settings == false) {
            return -4;
        }

        $dining_mode = $order['dining_mode']; //1:店内2:外卖3:预定4:快餐5:收银

        $store = $this->getStoreById($storeid);


        //商品id数组
        $ordergoods = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $orderid));
        $goodsid = array();
        if (!empty($ordergoods)) {
            foreach ($ordergoods as $key => $row) {
                if (isset($row['goodsid'])) {
                    $goodsid[$row['goodsid']] = $row;
                } else {
                    $goodsid[] = $row;
                }
            }
        }

        $dining_mode = intval($dining_mode); //1:店内2:外卖3:预定4:快餐
        foreach ($settings as $item => $value) {
            //判断打印订单类型（是否已经支付的单子）
            if ($value['print_type'] == 1 && $order['ispay'] == 0) { //支付模式未支付时
                continue;
            }
            if ($value['print_type'] == 2 && $order['status'] == 0) { //已确认模式未确认订单
                continue;
            }
            if ($position_type == 1 && $value['position_type'] == 2) { //前台模式 后厨打印机
                continue;
            }
            if ($position_type == 2 && $value['position_type'] == 1) { //后厨模式 前台打印机
                continue;
            }

            $target = "http://open.printcenter.cn:8080/addOrderNew";
            $deviceNo = $value['print_usr'];
            $key = $value['feyin_key'];
            $times = $value['print_nums'];

            $loop_first = 0;
            if ($value['is_meal'] == 1 && $dining_mode == 1) {
                $loop_first = 1;
            }
            if ($value['is_delivery'] == 1 && $dining_mode == 2) {
                $loop_first = 1;
            }
            if ($value['is_reservation'] == 1 && $dining_mode == 3) {
                $loop_first = 1;
            }
            if ($value['is_snack'] == 1 && $dining_mode == 4) {
                $loop_first = 1;
            }
            if ($value['is_shouyin'] == 1 && $dining_mode == 5) {
                $loop_first = 1;
            }

            if ($loop_first == 0) {
                continue;
            }

            //商品
            if ($value['print_label'] == '0') {
                $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
            } else {
                //餐桌
                $table_label = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " WHERE id=:id", array(":id" => $order['tables']));
                if (in_array($table_label['print_label'], explode(',', $value['print_label']))) {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
                } else {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "') AND labelid IN(" . $value['print_label'] . ")", array(), 'id');
                }
            }
            if (empty($goods) && $dining_mode != 3 && $dining_mode != 5) {
                continue;
            }
            $order['goods'] = $goods;
            if ($value['is_print_all'] == 0) {
                $hc = "\n";
                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        if ($value['type'] == '365lbl') {
                            $print_order_data = array(
                                'weid' => $weid,
                                'orderid' => $orderid,
                                'print_usr' => $value['print_usr'],
                                'print_status' => -1,
                                'dateline' => TIMESTAMP
                            );
                            pdo_insert($this->table_print_order, $print_order_data);
                            $oid = pdo_insertid();
                        }
                        $goodsname = $goods[$v['goodsid']]['title'];
                        $optionname = "普通";
                        if (!empty($v['optionname'])) {
                            $optionname = $v['optionname'];
                        }

                        $times = intval($v['total']);//数量

                        for ($i = 1; $i <= $times; $i++) {
                            $content = "TEXT 40,40,\"GB16\",0,1,2,\"" . $store['title'] . "\"" . $hc;
                            $content .= "TEXT 20,80,\"GB16\",0,1,2,\"序号:" . $order['quicknum'] . "   {$i}/{$times}\"" . $hc;
                            $content .= "TEXT 20,120,\"GB16\",0,1,2,\"品名:" . $goodsname . "\"" . $hc;
                            $content .= "TEXT 20,160,\"GB16\",0,1,2,\"规格:" . $optionname . "\"" . $hc;
                            $content .= "TEXT 20,200,\"GB16\",0,1,2,\"价格:" . $v['price'] . "元\"" . $hc;
                            $content .= "PRINT 1,1" . $hc;
                            $selfMessage = array(
                                'deviceNo' => $deviceNo,
                                'printContent' => $content,
                                'key' => $key,
                                'times' => 1, //数量
                                'hsize' => 50, //宽度
                                'vsize' => 30, //高度
                                'gap' => 1 //间距
                            );
                            $post_data = getStr($selfMessage);;
                            wlog('printlog', $post_data);
                            $result = ihttp_request($target, $post_data);
                        }
                        $status = $result['responseCode'];

                        pdo_update('weisrc_dish_print_order', array('print_status' => $status), array('id' => $oid));
                        pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                    }
                }
            }
        }
    }

    function getPrintContent($str, $len, $char)
    {
        $strlen = $this->print_strlen($str, 'gbk');
        if ($strlen > $len) {
            $content = substr($str, 0, $len);
            $content = $content . $char;
            $subcontent = substr($str, $len - 1);
            $content = $content . $subcontent;
        } else {
            $content = $str;
        }
        return $content;
    }

    //酒水寄存飞鹅
    public function feieSavewineSendFreeMessage($orderid = 0, $position_type = 0)
    {
        global $_W, $_GPC;

        if ($orderid == 0) {
            return -2;
        }

        $order = pdo_fetch("SELECT * FROM " . tablename($this->table_savewine_log) . " WHERE id = :id", array(':id' => $orderid));
        if (empty($order)) {
            return -3;
        }

        $weid = $order['weid'];
        $storeid = $order['storeid'];

        $store = $this->getStoreById($storeid);
        //打印机配置信息
        $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='feie' ", array(':storeid' => $storeid));

        if ($settings == false) {
            return -4;
        }

        $content = '寄存卡号:' . $order['savenumber'] . "<BR>";
        $content .= '所属门店:' . $store['title'] . "<BR>";
        $content .= '台号信息:<B>' . $this->getTableName($order['tablesid']) . "</B><BR>";
        $content .= '寄存日期:' . date('Y-m-d H:i:s', $order['dateline']) . "<BR>";
        $content .= '姓名:' . $order['username'] . "<BR>";
        $content .= '手机:' . $order['tel'] . "<BR>";
        //打印机
        foreach ($settings as $item => $value) {
            //前台模式 后厨打印机
            if ($position_type == 1 && $value['position_type'] == 2) {
                continue;
            }
            //后厨模式 前台打印机
            if ($position_type == 2 && $value['position_type'] == 1) {
                continue;
            }

            $FEIE_IP = 'dzp.feieyun.com';
            $api_type = intval($value['api_type']);
            if ($api_type == 0) {
                $pos = strpos($value['print_usr'], '6');
                if ($pos == 2) {
                    $FEIE_IP = 'api163.feieyun.com';
                }
                $pos = strpos($value['print_usr'], '7');
                if ($pos == 2) {
                    $FEIE_IP = 'api174.feieyun.com';
                }
            } elseif ($api_type == 1) {
                $FEIE_IP = 'dzp.feieyun.com';
            } elseif ($api_type == 2) {
                $FEIE_IP = 'api163.feieyun.com';
            } elseif ($api_type == 3) {
                $FEIE_IP = 'api174.feieyun.com';
            } elseif ($api_type == 4) {
                $FEIE_IP = 'api.feieyun.cn';
            }

            $client = new HttpClient($FEIE_IP, FEIE_PORT);

            if (!empty($value['print_top'])) {
                $print_top = "<CB>" . $value['print_top'] . "</CB><BR>";
            }
            if (!empty($value['print_bottom'])) {
                $print_bottom = "<C>" . $value['print_bottom'] . "</C>";
            }

            if ($value['is_print_all'] == 1) {
                if ($value['type'] == 'feie') {
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => $orderid,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }

                if (!empty($value['qrcode_url']) && !empty($value['qrcode_status'])) {
                    $print_bottom .= "<QR>" . $value['qrcode_url'] . "</QR>";
                }
                //喇叭
                $a = array("\x1b", "\x64", "\x01", "\x1b", "\x70", "\x30", "\x1e", "\x78");
                $box = implode("", $a);

                $printContent = $print_top . $content . $print_bottom . $box;

                $feie_content = array(
                    'sn' => $value['print_usr'],
                    'printContent' => $printContent,
                    'key' => $value['feyin_key'],
                    'times' => $value['print_nums']//打印次数
                );

                $result = $client->post(FEIE_HOSTNAME . '/printOrderAction', $feie_content);
                $_feiestatus = $result['responseCode'];
            }
        }
    }

    //酒水取酒飞鹅
    public function feieGetALLWineSendFreeMessage($orderid = 0, $allgoods, $position_type = 0)
    {
        global $_W, $_GPC;

        if ($orderid == 0) {
            return -2;
        }

        $order = pdo_fetch("SELECT * FROM " . tablename($this->table_savewine_log) . " WHERE id = :id", array(':id' => $orderid));
        if (empty($order)) {
            return -3;
        }

        $weid = $order['weid'];
        $storeid = $order['storeid'];

        $store = $this->getStoreById($storeid);
        //打印机配置信息
        $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='feie' ", array(':storeid' => $storeid));

        if ($settings == false) {
            return -4;
        }

        $content = '寄存卡号:' . $order['savenumber'] . "<BR>";
        $content .= '台号信息:<B>' . $this->getTableName($order['tablesid']) . "</B><BR>";
        $content .= '取出日期:' . date('Y-m-d H:i:s', TIMESTAMP) . "<BR>";
        foreach ($allgoods as $key => $value) {
            $content .= '名称:<B>' . $value['title'] . "</B><BR>";
            $content .= '数量:<B>' . $value['total'] . "</B><BR>";
            $content .= "-------------------------<BR>";
        }

        //打印机
        foreach ($settings as $item => $value) {
            //前台模式 后厨打印机
            if ($position_type == 1 && $value['position_type'] == 2) {
                continue;
            }
            //后厨模式 前台打印机
            if ($position_type == 2 && $value['position_type'] == 1) {
                continue;
            }

            $FEIE_IP = 'dzp.feieyun.com';
            $api_type = intval($value['api_type']);
            if ($api_type == 0) {
                $pos = strpos($value['print_usr'], '6');
                if ($pos == 2) {
                    $FEIE_IP = 'api163.feieyun.com';
                }
                $pos = strpos($value['print_usr'], '7');
                if ($pos == 2) {
                    $FEIE_IP = 'api174.feieyun.com';
                }
            } elseif ($api_type == 1) {
                $FEIE_IP = 'dzp.feieyun.com';
            } elseif ($api_type == 2) {
                $FEIE_IP = 'api163.feieyun.com';
            } elseif ($api_type == 3) {
                $FEIE_IP = 'api174.feieyun.com';
            } elseif ($api_type == 4) {
                $FEIE_IP = 'api.feieyun.cn';
            }

            $client = new HttpClient($FEIE_IP, FEIE_PORT);

            if (!empty($value['print_top'])) {
                $print_top = "<CB>" . $value['print_top'] . "</CB><BR>";
            }
            if (!empty($value['print_bottom'])) {
                $print_bottom = "<C>" . $value['print_bottom'] . "</C>";
            }

            if ($value['is_print_all'] == 1) {
                if ($value['type'] == 'feie') {
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => $orderid,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }

                if (!empty($value['qrcode_url']) && !empty($value['qrcode_status'])) {
                    $print_bottom .= "<QR>" . $value['qrcode_url'] . "</QR>";
                }
                //喇叭
                $a = array("\x1b", "\x64", "\x01", "\x1b", "\x70", "\x30", "\x1e", "\x78");
                $box = implode("", $a);

                $printContent = $print_top . $content . $print_bottom . $box;

                $feie_content = array(
                    'sn' => $value['print_usr'],
                    'printContent' => $printContent,
                    'key' => $value['feyin_key'],
                    'times' => $value['print_nums']//打印次数
                );

                $result = $client->post(FEIE_HOSTNAME . '/printOrderAction', $feie_content);
                $_feiestatus = $result['responseCode'];
            }
        }
    }

    //酒水取酒飞鹅
    public function feieGetwineSendFreeMessage($orderid = 0, $goodsid = 0, $total, $position_type = 0)
    {
        global $_W, $_GPC;

        if ($orderid == 0 || $goodsid == 0) {
            return -2;
        }

        $order = pdo_fetch("SELECT * FROM " . tablename($this->table_savewine_log) . " WHERE id = :id", array(':id' => $orderid));
        if (empty($order)) {
            return -3;
        }

        $weid = $order['weid'];
        $storeid = $order['storeid'];

        $store = $this->getStoreById($storeid);
        //打印机配置信息
        $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='feie' ", array(':storeid' => $storeid));

        if ($settings == false) {
            return -4;
        }

        $goods = pdo_fetch("SELECT a.*,b.title,b.unitname FROM " . tablename('weisrc_dish_savewine_goods') . " as a
left join " . tablename($this->table_goods) . " as b on a.goodsid=b.id WHERE a.weid = '{$weid}' and a.id={$goodsid} ");
        $goodsname = $goods['title'];
        if (!empty($goods['remark'])) {
            $goodsname .= "[" . $goods['remark'] . "]";
        }

        $content = '寄存卡号:' . $order['savenumber'] . "<BR>";
        $content .= '台号信息:<B>' . $this->getTableName($order['tablesid']) . "</B><BR>";
        $content .= '取出日期:' . date('Y-m-d H:i:s', TIMESTAMP) . "<BR>";
//        $content .= '所属门店:' . $store['title'] . "<BR>";
        $content .= '名称:<B>' . $goodsname . "</B><BR>";
        $content .= '数量:<B>' . $total . "</B><BR>";


//        $content .= '姓名:' . $order['username'] . "<BR>";
//        $content .= '手机:' . $order['tel'] . "<BR>";
        //打印机
        foreach ($settings as $item => $value) {
            //前台模式 后厨打印机
            if ($position_type == 1 && $value['position_type'] == 2) {
                continue;
            }
            //后厨模式 前台打印机
            if ($position_type == 2 && $value['position_type'] == 1) {
                continue;
            }

            $FEIE_IP = 'dzp.feieyun.com';
            $api_type = intval($value['api_type']);
            if ($api_type == 0) {
                $pos = strpos($value['print_usr'], '6');
                if ($pos == 2) {
                    $FEIE_IP = 'api163.feieyun.com';
                }
                $pos = strpos($value['print_usr'], '7');
                if ($pos == 2) {
                    $FEIE_IP = 'api174.feieyun.com';
                }
            } elseif ($api_type == 1) {
                $FEIE_IP = 'dzp.feieyun.com';
            } elseif ($api_type == 2) {
                $FEIE_IP = 'api163.feieyun.com';
            } elseif ($api_type == 3) {
                $FEIE_IP = 'api174.feieyun.com';
            } elseif ($api_type == 4) {
                $FEIE_IP = 'api.feieyun.cn';
            }

            $client = new HttpClient($FEIE_IP, FEIE_PORT);

            if (!empty($value['print_top'])) {
                $print_top = "<CB>" . $value['print_top'] . "</CB><BR>";
            }
            if (!empty($value['print_bottom'])) {
                $print_bottom = "<C>" . $value['print_bottom'] . "</C>";
            }

            if ($value['is_print_all'] == 1) {
                if ($value['type'] == 'feie') {
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => $orderid,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }

                if (!empty($value['qrcode_url']) && !empty($value['qrcode_status'])) {
                    $print_bottom .= "<QR>" . $value['qrcode_url'] . "</QR>";
                }
                //喇叭
                $a = array("\x1b", "\x64", "\x01", "\x1b", "\x70", "\x30", "\x1e", "\x78");
                $box = implode("", $a);

                $printContent = $print_top . $content . $print_bottom . $box;

                $feie_content = array(
                    'sn' => $value['print_usr'],
                    'printContent' => $printContent,
                    'key' => $value['feyin_key'],
                    'times' => $value['print_nums']//打印次数
                );

                $result = $client->post(FEIE_HOSTNAME . '/printOrderAction', $feie_content);
                $_feiestatus = $result['responseCode'];
            }
        }
    }

    //易联云
    public function _yilianyunSendFreeMessage($orderid = 0, $position_type = 0)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        load()->func('communication');

        if ($orderid == 0) {
            return -2;
        }

        $order = $this->getOrderById($orderid);
        if (empty($order)) {
            return -3;
        }

        $storeid = $order['storeid'];
        //打印机配置信息
        $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='yilianyun' ", array(':storeid' => $storeid));

        if ($settings == false) {
            return -4;
        }

        $dining_mode = $order['dining_mode']; //1:店内2:外卖3:预定4:快餐
        $paytype = $this->getPayType($dining_mode);
        $store = $this->getStoreById($storeid);
        $ordertype = $this->getOrderType($store);

        //商品id数组
        $ordergoods = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $orderid));
        $goodsid = array();
        if (!empty($ordergoods)) {
            foreach ($ordergoods as $key => $row) {
                if (isset($row['goodsid'])) {
                    $goodsid[$row['goodsid']] = $row;
                } else {
                    $goodsid[] = $row;
                }
            }
        }

        $paystatus = $order['ispay'] == 0 ? '未支付' : '已支付';
        foreach ($settings as $item => $value) {
            $content2 = '';
            $yilian_type = $value['yilian_type'];
            $content = "";
            if ($dining_mode == 3) {
                $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
                $content .= "桌台类型：{$tablezones['title']}\n";
            }
            if (!empty($order['tables'])) {
                if ($yilian_type == 1) {
                    $content .= '<FS>桌台信息:' . $this->getTableName($order['tables']) . "</FS>\n";
                } else {
                    $content .= '@@2桌台信息:' . $this->getTableName($order['tables']) . "\n";
                }
            }
            $content .= '订单编号:' . $order['ordersn'] . "\n";
            if ($dining_mode == 4) {
                $content .= '领餐牌号:' . $order['quicknum'] . "\n";
            }
            $content .= '订单类型:' . $ordertype[$dining_mode] . "\n";
            $content .= '支付方式:' . $paytype[$order['paytype']] . "(" . $paystatus . ")\n";
            $content .= '下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . "\n";

            if (!empty($order['counts'])) {
                $content .= '用餐人数:' . $order['counts'] . "\n";
            }
            $content .= '所属门店:' . $store['title'] . "\n";
            if (!empty($order['remark'])) {
                $content2 = '备注:' . $order['remark'] . "\n";
            }

            $content2 .= "-------------------------\n";
            $packvalue = floatval($order['packvalue']);
            $tea_money = floatval($order['tea_money']);
            $service_money = floatval($order['service_money']);
            if ($packvalue > 0 && $dining_mode == 2) {
                $content2 .= "打包费:{$packvalue}元\n";
            }
            if ($tea_money > 0 && $dining_mode == 1) {
                $content2 .= "{$store['tea_tip']}:{$tea_money}元\n";
            }
            if ($service_money > 0 && $dining_mode == 1) {
                $content2 .= "服务费:{$service_money}元\n";
            }
            $content2 .= "<FS>总数量:" . $order['totalnum'] . "   总价:" . number_format($order['totalprice'], 2) . "元</FS>\n";
            if ($dining_mode != 4 && !empty($order['meal_time'])) {
                $content2 .= '预定时间:' . $order['meal_time'] . "\n";
            }
            if ($dining_mode == 2) {
                if (!empty($order['username'])) {
                    $content2 .= '姓名:' . $order['username'] . "\n";
                }
                if (!empty($order['tel'])) {
                    $content2 .= '手机:' . $order['tel'] . "\n";
                }
                if (!empty($order['address'])) {
                    $content2 .= '地址:' . $order['address'] . "\n";
                }
            } else {
                if (!empty($order['username'])) {
                    $content2 .= '姓名:' . $order['username'] . "\n";
                }
                if (!empty($order['tel'])) {
                    $content2 .= '手机:' . $order['tel'] . "\n";
                }
            }
            $content2 .= "-------------------------\n";
            $content2 .= '门店地址:' . $store['address'] . "\n";
            $content2 .= '门店电话:' . $store['tel'] . "\n";


            //判断打印订单类型（是否已经支付的单子）
            if ($value['print_type'] == 1 && $order['ispay'] == 0) { //支付模式未支付时
                continue;
            }
            if ($value['print_type'] == 2 && $order['status'] == 0) { //已确认模式未确认订单
                continue;
            }
            if ($position_type == 1 && $value['position_type'] == 2) { //前台模式 后厨打印机
                continue;
            }
            if ($position_type == 2 && $value['position_type'] == 1) { //后厨模式 前台打印机
                continue;
            }

            $loop_first = 0;
            if ($value['is_meal'] == 1 && $dining_mode == 1) {
                $loop_first = 1;
            }
            if ($value['is_delivery'] == 1 && $dining_mode == 2) {
                $loop_first = 1;
            }
            if ($value['is_reservation'] == 1 && $dining_mode == 3) {
                $loop_first = 1;
            }
            if ($value['is_snack'] == 1 && $dining_mode == 4) {
                $loop_first = 1;
            }
            if ($value['is_shouyin'] == 1 && $dining_mode == 5) {
                $loop_first = 1;
            }
            if ($loop_first == 0) {
                continue;
            }

            $deviceNo = $value['print_usr'];
            $key = $value['feyin_key'];
            $times = $value['print_nums'];
            $member_code = $value['member_code'];
            $api_key = $value['api_key'];

            if ($order['status'] == -1) {
                $print_order_data = array(
                    'weid' => $weid,
                    'orderid' => $orderid,
                    'print_usr' => $value['print_usr'],
                    'print_status' => -1,
                    'dateline' => TIMESTAMP
                );
                pdo_insert($this->table_print_order, $print_order_data);
                $oid = pdo_insertid();
                $cancelcontent = '订单已取消' . "\n";
                $cancelcontent .= '编号:' . $order['ordersn'];
                $print = new Yprint();
                $result = $print->action_print($member_code, $deviceNo, $cancelcontent, $api_key, $key);
                pdo_update('weisrc_dish_print_order', array('print_status' => $result['state']), array('id' => $oid));
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                return;
            }

            if (!empty($value['print_top'])) {
                $print_top = "" . $value['print_top'] . "\n";
            }
            if (!empty($value['print_bottom'])) {
                $print_bottom = "\n" . $value['print_bottom'] . "";
            }

            //商品
            if ($value['print_label'] == '0') {
                $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
            } else {
                //餐桌
                $table_label = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " WHERE id=:id", array(":id" => $order['tables']));
                if (in_array($table_label['print_label'], explode(',', $value['print_label']))) {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
                } else {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "') AND labelid IN(" . $value['print_label'] . ")", array(), 'id');
                }
            }
            if (empty($goods) && $dining_mode != 3 && $dining_mode != 5) {
                continue;
            }

            $order['goods'] = $goods;
            if ($value['is_print_all'] == 1) {
                if ($value['type'] == 'yilianyun') {
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => $orderid,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }

                $content .= "-------------------------\n";
                $content1 = "<table><tr><td>品名</td><td>数量</td><td>单价</td></tr>";


                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        $money = $v['price'];
                        $money = $money * $v['total'];

                        if (!empty($v['optionname'])) {
                            $goodsname = $goods[$v['goodsid']]['title'] . '[' . $v['optionname'] . ']';
                        } else {
                            $goodsname = $goods[$v['goodsid']]['title'];
                        }

                        $content1 .= '<tr><td>' . $goodsname . '</td><td>' . $v['total'] .
                            $goods[$v['goodsid']]['unitname'] . '</td><td>' .
                            number_format($money, 2) . "元</td></tr><tr><td></td><td></td><td></td></tr>";
                    }
                }
                $content1 .= "</table>\n";

                if (!empty($value['qrcode_url']) && !empty($value['qrcode_status'])) {
                    if ($yilian_type == 1) {
                        $print_bottom .= "<QR>" . $value['qrcode_url'] . "</QR>";
                    } else {
                        $print_bottom .= "<q>" . $value['qrcode_ql'] . "</q>";
                    }
                }

                $times = intval($value['print_nums']);
                if ($times > 0) {
                    if ($yilian_type == 1) {
                        $times_str = "<MN>{$times}</MN>";
                    } else {
                        $times_str = "**{$times}";
                    }
                }
                $printContent = $times_str . $print_top . $content . $content1 . $content2 . $print_bottom;
                $print = new Yprint();
                $result = $print->action_print($member_code, $deviceNo, $printContent, $api_key, $key);
                pdo_update('weisrc_dish_print_order', array('print_status' => $result['state']), array('id' => $oid));
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
            } else { //分单打印
                $content = '订单编号:' . $order['ordersn'] . "\n";
                $content .= '下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . "\n";
                $content .= '用餐人数:' . $order['counts'] . "\n";
                if (!empty($order['tables'])) {
                    if ($yilian_type == 1) {
                        $content .= '<FS>桌台:' . $this->getTableName($order['tables']) . "</FS>\n";
                    } else {
                        $content .= '@@2桌台:' . $this->getTableName($order['tables']) . "\n";
                    }
                }

                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        $print_total = intval($v['total']);
                        if ($value['is_nums'] == 0) { //打印总数量
                            $print_total = 1;
                            $total = $v['total'];
                        } else {
                            $total = 1;
                        }

                        for ($i = 0; $i < $print_total; $i++) {
                            if ($value['type'] == 'yilianyun') {
                                $print_order_data = array(
                                    'weid' => $weid,
                                    'orderid' => $orderid,
                                    'print_usr' => $value['print_usr'],
                                    'print_status' => -1,
                                    'dateline' => TIMESTAMP
                                );
                                pdo_insert($this->table_print_order, $print_order_data);
                                $oid = pdo_insertid();
                            }

                            if (!empty($v['optionname'])) {
                                $goodsname = $goods[$v['goodsid']]['title'] . '[' . $v['optionname'] . ']';
                            } else {
                                $goodsname = $goods[$v['goodsid']]['title'];
                            }

                            $content1 = '';
                            $content1 .= "-------------------------\n";
                            if ($yilian_type == 1) {
                                $content1 .= '<FS>' . $goodsname . "</FS>\n";
                                $content1 .= '数量:<FS>' . $total . $goods[$v['goodsid']]['unitname'] . "</FS>\n";
                            } else {
                                $content1 .= '@@2' . $goodsname . "\n";
                                $content1 .= '@@2数量:' . $total . $goods[$v['goodsid']]['unitname'] . "\n";
                            }

                            $deviceNo = $value['print_usr'];
                            $key = $value['feyin_key'];
                            $times = $value['print_nums'];
                            $member_code = $value['member_code'];
                            $api_key = $value['api_key'];
                            $printContent = $content . $content1;
                            $print = new Yprint();
                            $result = $print->action_print($member_code, $deviceNo, $printContent, $api_key, $key);
                            pdo_update('weisrc_dish_print_order', array('print_status' => $result['state']), array('id' => $oid));
                            pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                        }
                    }
                }
            }
        }
    }

    //进云
    public function _jinyunSendFreeMessage($orderid = 0, $position_type = 0)
    {
        global $_W, $_GPC;

        if ($orderid == 0) {
            return -2;
        }
        $order = $this->getOrderById($orderid);
        if (empty($order)) {
            return -3;
        }

        $weid = $order['weid'];
        $storeid = $order['storeid'];

        $store = $this->getStoreById($storeid);
        //打印机配置信息
        $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='jinyun' ", array(':storeid' => $storeid));

        if ($settings == false) {
            return -4;
        }

        //1:店内2:外卖3:预定4:快餐
        $dining_mode = $order['dining_mode'];
        $paytype = $this->getPayType($dining_mode);
        $ordertype = $this->getOrderType($store);

        //商品id数组
        $ordergoods = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $orderid));
        $goodsid = array();
        if (!empty($ordergoods)) {
            foreach ($ordergoods as $key => $row) {
                if (isset($row['goodsid'])) {
                    $goodsid[$row['goodsid']] = $row;
                } else {
                    $goodsid[] = $row;
                }
            }
        }

        $paystatus = $order['ispay'] == 0 ? '未支付' : '已支付';
        $content = "<S3>订单编号:" . $order['ordersn'] . "\n</S3>";
        if ($dining_mode == 4) {
            $content .= '<S3>领餐牌号:' . $order['quicknum'] . "\n</S3>";
        }
        $content .= '<S3>订单类型:' . $ordertype[$dining_mode] . "\n</S3>";
        $content .= '<S3>所属门店:' . $store['title'] . "\n";
        $content .= '<S3>支付方式:' . $paytype[$order['paytype']] . "(" . $paystatus . ")\n</S3>";
        $content .= '<S3>下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . "\n</S3>";
        if ($dining_mode == 3) {
            $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
            $content .= "<S3>桌台类型：{$tablezones['title']}\n</S3>";
        }
        if (!empty($order['tables'])) {
            $content .= '<S6>桌台信息:' . $this->getTableName($order['tables']) . "\n</S6>";
        }
        if (!empty($order['counts'])) {
            $content .= '<S3>用餐人数:' . $order['counts'] . "\n</S3>";
        }
        if (!empty($order['remark'])) {
            $content .= '<S3>备注:' . $order['remark'] . "\n</S3>";
        }

        $content2 = "------------------------------------------------\n";
        $packvalue = floatval($order['packvalue']);
        $tea_money = floatval($order['tea_money']);
        $service_money = floatval($order['service_money']);
        if ($packvalue > 0 && $dining_mode == 2) {
            $content2 .= "<S3>打包费:{$packvalue}元\n</S3>";
        }
        if ($tea_money > 0 && $dining_mode == 1) {
            $content2 .= "<S3>{$store['tea_tip']}:{$tea_money}元\n</S3>";
        }
        if ($service_money > 0 && $dining_mode == 1) {
            $content2 .= "<S3>服务费:{$service_money}元\n</S3>";
        }
        $content2 .= "<S3>总数量:" . $order['totalnum'] . "   总价:" . number_format($order['totalprice'], 2) . "元\n</S3>";
        if ($dining_mode != 4 && !empty($order['meal_time'])) {
            $content2 .= '<S3>预定时间:' . $order['meal_time'] . "\n</S3>";
        }
        if (!empty($order['username'])) {
            $content2 .= '<S3>姓名:' . $order['username'] . "\n</S3>";
        }
        if (!empty($order['tel'])) {
            $content2 .= '<S3>手机:' . $order['tel'] . "\n</S3>";
        }
        if (!empty($order['address'])) {
            $content2 .= '<S3>地址:' . $order['address'] . "\n</S3>";
        }
        $content2 .= "--------------------------------------------------\n";

        //打印机
        foreach ($settings as $item => $value) {
            //判断打印订单类型（是否已经支付的单子）
            //支付模式未支付时
            if ($value['print_type'] == 1 && $order['ispay'] == 0) {
                continue;
            }
            //已确认模式未确认订单
            if ($value['print_type'] == 2 && $order['status'] == 0) {
                continue;
            }
            //前台模式 后厨打印机
            if ($position_type == 1 && $value['position_type'] == 2) {
                continue;
            }
            //后厨模式 前台打印机
            if ($position_type == 2 && $value['position_type'] == 1) {
                continue;
            }

            $loop_first = 0;
            if ($value['is_meal'] == 1 && $dining_mode == 1) {
                $loop_first = 1;
            }
            if ($value['is_delivery'] == 1 && $dining_mode == 2) {
                $loop_first = 1;
            }
            if ($value['is_reservation'] == 1 && $dining_mode == 3) {
                $loop_first = 1;
            }
            if ($value['is_snack'] == 1 && $dining_mode == 4) {
                $loop_first = 1;
            }
            if ($value['is_shouyin'] == 1 && $dining_mode == 5) {
                $loop_first = 1;
            }
            if ($loop_first == 0) {
                continue;
            }

            $jinyunzn = new jinyunzn($value['member_code'], $value['api_key']);
            $seri_num = $value['print_usr'];

            if ($order['status'] == -1) {
                $print_order_data = array(
                    'weid' => $weid,
                    'orderid' => $orderid,
                    'print_usr' => $value['print_usr'],
                    'print_status' => -1,
                    'dateline' => TIMESTAMP
                );
                pdo_insert($this->table_print_order, $print_order_data);
                $oid = pdo_insertid();

                $cancelcontent = '<S3>订单已取消' . "\n</S3>";
                $cancelcontent .= '<S3>编号:' . $order['ordersn'] . '</S3>';

                $result = $jinyunzn->printing($seri_num, $cancelcontent);
                if (is_array($result) && $result['code'] == 0) {
                    //打印成功！
                    pdo_update('weisrc_dish_print_order', array('print_status' => 0), array('id' => $oid));
                } else {
                    pdo_update('weisrc_dish_print_order', array('print_status' => -1), array('id' => $oid));
                }
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                return;
            }

            if (!empty($value['print_top'])) {
                $print_top = "<S5>" . $value['print_top'] . "\n</S5>";
            }
            if (!empty($value['print_bottom'])) {
                $print_bottom = "<S5>" . $value['print_bBttom'] . "</S5>";
            }
            //商品
            if ($value['print_label'] == '0') {
                $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
            } else {
                //餐桌
                $table_label = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " WHERE id=:id", array(":id" => $order['tables']));
                if (in_array($table_label['print_label'], explode(',', $value['print_label']))) {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
                } else {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "') AND labelid IN(" . $value['print_label'] . ")", array(), 'id');
                }
            }
            if (empty($goods) && $dining_mode != 3 && $dining_mode != 5) {
                continue;
            }
            $order['goods'] = $goods;
            if ($goods) {
                if ($order['isvip'] == 1) {
                    $viptip = "(会员)";
                }
                if ($order['is_append'] == 1) {
                    $appendtip = "(加单)";
                }
                $content1 = "<S4>商品列表{$viptip}{$appendtip}\n</S4>";
                $content1 .= "------------------------------------------------\n";
            }

            if ($value['is_print_all'] == 1) {
                if ($value['type'] == 'jinyun') {
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => $orderid,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }

                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        $money = $v['price'];
                        $money = $money * $v['total'];

                        if (!empty($v['optionname'])) {
                            $goodsname = $goods[$v['goodsid']]['title'] . '[' . $v['optionname'] . ']';
                        } else {
                            $goodsname = $goods[$v['goodsid']]['title'];
                        }

                        $content1 .= '<S6>' . $goodsname . ' ' . $v['total'] . $goods[$v['goodsid']]['unitname'] . ' ' . number_format($money, 2) . "元\n</S6>";
                    }
                }

                if (!empty($value['qrcode_url']) && !empty($value['qrcode_status'])) {
                    $print_bottom .= "<QR_T>QR_CODE</QR_T><QR_S>7</QR_S><QR_D>" . $value['qrcode_QR_Dl'] . "</QR_D>";
                }

                $printContent = $print_top . $content . $content1 . $content2 . $print_bottom;

                $result = $jinyunzn->printing($seri_num, $printContent);
                if (is_array($result) && $result['code'] == 0) {
                    //打印成功！
                    pdo_update('weisrc_dish_print_order', array('print_status' => 0), array('id' => $oid));
                } else {
                    pdo_update('weisrc_dish_print_order', array('print_status' => -1), array('id' => $oid));
                }
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
            } else { //分单
                $content = '订单编号:' . $order['ordersn'] . "\n";
                $content .= '下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . "\n";
                if (!empty($order['tables'])) {
                    $content .= '<S3>桌台信息:' . $this->getTableBme($order['tables']) . "\n</S3>";
                }
                if (!empty($order['remark'])) {
                    $content .= '<S3>备注:' . $order['remark'] . "\n</S3>";
                }
                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        if ($value['type'] == 'jinyun') { //飞蛾
                            $print_order_data = array(
                                'weid' => $weid,
                                'orderid' => $orderid,
                                'print_usr' => $value['print_usr'],
                                'print_status' => -1,
                                'dateline' => TIMESTAMP
                            );
                            pdo_insert($this->table_print_order, $print_order_data);
                            $oid = pdo_insertid();
                        }

                        if (!empty($v['optionname'])) {
                            $goodsname = $goods[$v['goodsid']]['title'] . '[' . $v['optionname'] . ']';
                        } else {
                            $goodsname = $goods[$v['goodsid']]['title'];
                        }

                        $content1 = '';
                        $content1 .= "--------------------------------------------------\n";
                        $content1 .= '<S5>名称:' . $goodsname . "\n</S5>";
                        $content1 .= '<S5>数量:' . $v['total'] . $goods[$v['goodsid']]['unitname'] . "\n</S5>";
                        $money = $v['price'];
                        $content1 .= '<S5>价格:' . number_format($money, 2) . "元\n</S5>";
                        $content1 .= "--------------------------------------------------\n";
                        $printContent = $print_top . $content . $content1 . $print_bottom;

                        $result = $jinyunzn->printing($seri_num, $printContent);
                        if (is_array($result) && $result['code'] == 0) {
                            //打印成功！
                            pdo_update('weisrc_dish_print_order', array('print_status' => 0), array('id' => $oid));
                        } else {
                            pdo_update('weisrc_dish_print_order', array('print_status' => -1), array('id' => $oid));
                        }
                        pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                    }
                }
            }
        }
    }

    //飞鹅
    public function _feieSendFreeMessage($orderid = 0, $position_type = 0)
    {
        global $_W, $_GPC;

        if ($orderid == 0) {
            return -2;
        }

        $order = $this->getOrderById($orderid);
        if (empty($order)) {
            return -3;
        }

        $weid = $order['weid'];
        $storeid = $order['storeid'];

        $store = $this->getStoreById($storeid);
        //打印机配置信息
        $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='feie' ", array(':storeid' => $storeid));

        if ($settings == false) {
            return -4;
        }

        //1:店内2:外卖3:预定4:快餐
        $dining_mode = $order['dining_mode'];
        $paytype = $this->getPayType($dining_mode);
        $ordertype = $this->getOrderType($store);

        //商品id数组
        $ordergoods = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $orderid));
        $goodsid = array();
        if (!empty($ordergoods)) {
            foreach ($ordergoods as $key => $row) {
                if (isset($row['goodsid'])) {
                    $goodsid[$row['goodsid']] = $row;
                } else {
                    $goodsid[] = $row;
                }
            }
        }

        $paystatus = $order['ispay'] == 0 ? '未支付' : '已支付';
        $content = "订单编号:" . $order['ordersn'] . "<BR>";
        if ($dining_mode == 4) {
            $content .= '领餐牌号:' . $order['quicknum'] . "<BR>";
        }
        $content .= '订单类型:' . $ordertype[$dining_mode] . "<BR>";
        $content .= '所属门店:' . $store['title'] . "<BR>";
        $content .= '支付方式:' . $paytype[$order['paytype']] . "(" . $paystatus . ")<BR>";
        $content .= '下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . "<BR>";
        if ($dining_mode == 3) {
            $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
            $content .= "桌台类型：{$tablezones['title']}<BR>";
        }
        if (!empty($order['tables'])) {
            $content .= '桌台信息:<B>' . $this->getTableName($order['tables']) . "</B><BR>";
        }
        if (!empty($order['counts'])) {
            $content .= '用餐人数:' . $order['counts'] . "<BR>";
        }
        if (!empty($order['remark'])) {
            $content .= '备注:' . $order['remark'] . "<BR>";
        }
        $content .= '门店地址:' . $store['address'] . "<BR>";
        $content .= '门店电话:' . $store['tel'] . "<BR>";

        $content2 = "-------------------------<BR>";
        $packvalue = floatval($order['packvalue']);
        $tea_money = floatval($order['tea_money']);
        $service_money = floatval($order['service_money']);
        if ($packvalue > 0 && $dining_mode == 2) {
            $content2 .= "打包费:{$packvalue}元<BR>";
        }
        if ($tea_money > 0 && $dining_mode == 1) {
            $content2 .= "{$store['tea_tip']}:{$tea_money}元<BR>";
        }
        if ($service_money > 0 && $dining_mode == 1) {
            $content2 .= "服务费:{$service_money}元<BR>";
        }
        $content2 .= "总数量:" . $order['totalnum'] . "   总价:" . number_format($order['totalprice'], 2) . "元<BR>";
        if ($dining_mode != 4 && !empty($order['meal_time'])) {
            $content2 .= '预定时间:' . $order['meal_time'] . "<BR>";
        }
        if (!empty($order['username'])) {
            $content2 .= '姓名:' . $order['username'] . "<BR>";
        }
        if (!empty($order['tel'])) {
            $content2 .= '手机:' . $order['tel'] . "<BR>";
        }
        if (!empty($order['address'])) {
            $content2 .= '地址:' . $order['address'] . "<BR>";
        }
        $content2 .= "-------------------------<BR>";

        //打印机
        foreach ($settings as $item => $value) {
            //判断打印订单类型（是否已经支付的单子）
            //支付模式未支付时
            if ($value['print_type'] == 1 && $order['ispay'] == 0) {
                continue;
            }
            //已确认模式未确认订单
            if ($value['print_type'] == 2 && $order['status'] == 0) {
                continue;
            }
            //前台模式 后厨打印机
            if ($position_type == 1 && $value['position_type'] == 2) {
                continue;
            }
            //后厨模式 前台打印机
            if ($position_type == 2 && $value['position_type'] == 1) {
                continue;
            }

            $loop_first = 0;
            if ($value['is_meal'] == 1 && $dining_mode == 1) {
                $loop_first = 1;
            }
            if ($value['is_delivery'] == 1 && $dining_mode == 2) {
                $loop_first = 1;
            }
            if ($value['is_reservation'] == 1 && $dining_mode == 3) {
                $loop_first = 1;
            }
            if ($value['is_snack'] == 1 && $dining_mode == 4) {
                $loop_first = 1;
            }
            if ($value['is_shouyin'] == 1 && $dining_mode == 5) {
                $loop_first = 1;
            }
            if ($loop_first == 0) {
                continue;
            }

            $FEIE_IP = 'dzp.feieyun.com';
            $api_type = intval($value['api_type']);
            if ($api_type == 0) {
                $pos = strpos($value['print_usr'], '6');
                if ($pos == 2) {
                    $FEIE_IP = 'api163.feieyun.com';
                }
                $pos = strpos($value['print_usr'], '7');
                if ($pos == 2) {
                    $FEIE_IP = 'api174.feieyun.com';
                }
            } elseif ($api_type == 1) {
                $FEIE_IP = 'dzp.feieyun.com';
            } elseif ($api_type == 2) {
                $FEIE_IP = 'api163.feieyun.com';
            } elseif ($api_type == 3) {
                $FEIE_IP = 'api174.feieyun.com';
            } elseif ($api_type == 4) {
                $FEIE_IP = 'api.feieyun.cn';
            }

            $client = new HttpClient($FEIE_IP, FEIE_PORT);
            if ($order['status'] == -1) {
                $print_order_data = array(
                    'weid' => $weid,
                    'orderid' => $orderid,
                    'print_usr' => $value['print_usr'],
                    'print_status' => -1,
                    'dateline' => TIMESTAMP
                );
                pdo_insert($this->table_print_order, $print_order_data);
                $oid = pdo_insertid();

                $cancelcontent = '^订单已取消' . "<BR>";
                $cancelcontent .= '编号:' . $order['ordersn'];
                $feie_content = array(
                    'sn' => $value['print_usr'],
                    'printContent' => $cancelcontent,
                    'key' => $value['feyin_key'],
                    'times' => 1//打印次数
                );
                $result = $client->post(FEIE_HOSTNAME . '/printOrderAction', $feie_content);
                $_feiestatus = $result['responseCode'];
                pdo_update('weisrc_dish_print_order', array('print_status' => $_feiestatus), array('id' => $oid));
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                return;
            }

            if (!empty($value['print_top'])) {
                $print_top = "<CB>" . $value['print_top'] . "</CB><BR>";
            }
            if (!empty($value['print_bottom'])) {
                $print_bottom = "<C>" . $value['print_bottom'] . "</C>";
            }
            //商品
            if ($value['print_label'] == '0') {
                $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');

            } else {
                //餐桌
                $table_label = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " WHERE id=:id", array(":id" => $order['tables']));
                if (in_array($table_label['print_label'], explode(',', $value['print_label']))) {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
                } else {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "') AND labelid IN(" . $value['print_label'] . ")", array(), 'id');
                }
            }


            if (empty($goods) && $dining_mode != 3 && $dining_mode != 5) {
                continue;
            }


            $order['goods'] = $goods;
            if ($goods) {
                if ($order['isvip'] == 1) {
                    $viptip = "(会员)";
                }
                if ($order['is_append'] == 1) {
                    $appendtip = "(加单)";
                }
                $content1 = "商品列表{$viptip}{$appendtip}<BR>";
                $content1 .= "-------------------------<BR>";
            }

            if ($value['is_print_all'] == 1) {
                if ($value['type'] == 'feie') {
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => $orderid,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }

                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        $money = $v['price'];
                        $money = $money * $v['total'];

                        if (!empty($v['optionname'])) {
                            $goodsname = $goods[$v['goodsid']]['title'] . '[' . $v['optionname'] . ']';
                        } else {
                            $goodsname = $goods[$v['goodsid']]['title'];
                        }

                        $content1 .= $goodsname . ' ' . $v['total'] . $goods[$v['goodsid']]['unitname'] . ' ' . number_format($money, 2) . "元<BR>";
                    }
                }

                if (!empty($value['qrcode_url']) && !empty($value['qrcode_status'])) {
                    $print_bottom .= "<QR>" . $value['qrcode_url'] . "</QR>";
                }
                //喇叭
                $a = array("\x1b", "\x64", "\x01", "\x1b", "\x70", "\x30", "\x1e", "\x78");
                $box = implode("", $a);

                $printContent = $print_top . $content . $content1 . $content2 . $print_bottom . $box;

                $feie_content = array(
                    'sn' => $value['print_usr'],
                    'printContent' => $printContent,
                    'key' => $value['feyin_key'],
                    'times' => $value['print_nums']//打印次数
                );

                $result = $client->post(FEIE_HOSTNAME . '/printOrderAction', $feie_content);
                $_feiestatus = $result['responseCode'];
                pdo_update('weisrc_dish_print_order', array('print_status' => $_feiestatus), array('id' => $oid));
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
            } else { //分单
                $content = '订单编号:' . $order['ordersn'] . "<BR>";
                $content .= '下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . "<BR>";
                if (!empty($order['tables'])) {
                    $content .= '<B>桌台信息:</B><DB>' . $this->getTableName($order['tables']) . "</DB><BR>";
                }
                if (!empty($order['remark'])) {
                    $content .= '<DB>备注:' . $order['remark'] . "</DB><BR>";
                }
                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        if ($value['type'] == 'feie') { //飞蛾
                            $print_order_data = array(
                                'weid' => $weid,
                                'orderid' => $orderid,
                                'print_usr' => $value['print_usr'],
                                'print_status' => -1,
                                'dateline' => TIMESTAMP
                            );
                            pdo_insert($this->table_print_order, $print_order_data);
                            $oid = pdo_insertid();
                        }

                        if (!empty($v['optionname'])) {
                            $goodsname = $goods[$v['goodsid']]['title'] . '[' . $v['optionname'] . ']';
                        } else {
                            $goodsname = $goods[$v['goodsid']]['title'];
                        }

                        $content1 = '';
                        $content1 .= "------------------------------------------------<BR>";
                        $content1 .= '<B>名称:' . $goodsname . "</B><BR>";
                        $content1 .= '<B>数量:' . $v['total'] . $goods[$v['goodsid']]['unitname'] . "</B><BR>";
                        $money = $v['price'];
                        $content1 .= '<B>价格:' . number_format($money, 2) . "元</B><BR>";
                        $content1 .= "------------------------------------------------<BR>";
                        $printContent = $print_top . $content . $content1 . $print_bottom;
                        $feie_content = array(
                            'sn' => $value['print_usr'],
                            'printContent' => $printContent,
                            'key' => $value['feyin_key'],
                            'times' => $value['print_nums']//打印次数
                        );

                        $result = $client->post(FEIE_HOSTNAME . '/printOrderAction', $feie_content);
                        $_feiestatus = $result['responseCode'];
                        pdo_update('weisrc_dish_print_order', array('print_status' => $_feiestatus), array('id' => $oid));
                        pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                    }
                }
            }
        }
    }

    //飞印
    public function _feiyinSend($orderids, $position_type = 0)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $totalprice = 0;
        $orderinfo_content = "";
        foreach ($orderids as $k => $id) {
            $order = $this->getOrderById($id);
            $storeid = $order['storeid'];
            $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='feiyin' ", array(':storeid' => $storeid));

            $store = $this->getStoreById($storeid);
            $orderinfo_content .= "-------------------------\n";
            $orderinfo_content .= '订单编号:' . $order['ordersn'] . "\n";

            $service_money = floatval($order['service_money']);
            if ($service_money > 0) {
                $service_money_content = "服务费:{$service_money}元\n";
            }

            $tables_content = '桌台信息:' . $this->getTableName($order['tables']) . "\n";
            $totalprice = $totalprice + floatval($order['totalprice']);
            $totalprice_content = "总价:" . number_format($totalprice, 2) . "元\n";

            //商品id数组
            $goodsid = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $id), 'goodsid');
            $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')");

            foreach ($goods as $v) {
                if (!empty($goodsid[$v['id']]['optionname'])) {
                    $goodsname = $v['title'] . '[' . $goodsid[$v['id']]['optionname'] . ']';
                } else {
                    $goodsname = $v['title'];
                }

                $money = $goodsid[$v['id']]['price'];
                $orderinfo_content .= $goodsname . ' ' . $goodsid[$v['id']]['total'] . $v['unitname'] . ' ' . number_format($money, 2) . "元\n";
            }
        }

        $print_content = "商家小票\n";
        $print_content .= "-------------------------\n";
        $print_content .= $tables_content;
        $print_content .= $orderinfo_content;
        $print_content .= "-------------------------\n";
        $print_content .= $totalprice_content;

        foreach ($settings as $item => $value) {
            $this->member_code = $value['member_code'];
            $this->device_no = $value['print_usr'];
            $this->feyin_key = $value['feyin_key'];

            if ($position_type == 1 && $value['position_type'] == 2) { //前台模式 后厨打印机
                continue;
            }
            if ($position_type == 2 && $value['position_type'] == 1) { //后厨模式 前台打印机
                continue;
            }

            if ($value['is_print_all'] == 1) {
                if ($value['type'] == 'feiyin') { //飞印
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => 0,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }

                $msgNo = time() + 1;
                $freeMessage = array(
                    'memberCode' => $this->member_code,
                    'msgDetail' => $print_content,
                    'deviceNo' => $this->device_no,
                    'msgNo' => $oid,
                );
                $feiyinstatus = $this->sendFreeMessage($freeMessage);
                pdo_update('weisrc_dish_print_order', array('print_status' => $feiyinstatus), array('id' => $oid));
            }
        }

        return $msgNo;
    }

    //365
    public function _365Send($orderids, $position_type = 0)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $totalprice = 0;
        $orderinfo_content = "";
        foreach ($orderids as $k => $id) {
            $order = $this->getOrderById($id);
            $storeid = $order['storeid'];
            $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='365' ", array(':storeid' => $storeid));

            $store = $this->getStoreById($storeid);
            $orderinfo_content .= "-------------------------\n";
            $orderinfo_content .= '订单编号:' . $order['ordersn'] . "\n";

            $service_money = floatval($order['service_money']);
            if ($service_money > 0) {
                $service_money_content = "服务费:{$service_money}元\n";
            }

            $tables_content = '桌台信息:' . $this->getTableName($order['tables']) . "\n";
            $totalprice = $totalprice + floatval($order['totalprice']);
            $totalprice_content = "总价:" . number_format($totalprice, 2) . "元\n";

            //商品id数组
            $goodsid = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $id), 'goodsid');
            $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')");

            foreach ($goods as $v) {
                if (!empty($goodsid[$v['id']]['optionname'])) {
                    $goodsname = $v['title'] . '[' . $goodsid[$v['id']]['optionname'] . ']';
                } else {
                    $goodsname = $v['title'];
                }

                $money = $goodsid[$v['id']]['price'];
                $orderinfo_content .= $goodsname . ' ' . $goodsid[$v['id']]['total'] . $v['unitname'] . ' ' . number_format($money, 2) . "元\n";
            }
        }

        $print_content = "商家小票\n";
        $print_content .= "-------------------------\n";
        $print_content .= $tables_content;
        $print_content .= $orderinfo_content;
        $print_content .= "-------------------------\n";
        $print_content .= $totalprice_content;

        foreach ($settings as $item => $value) {
            $target = "http://open.printcenter.cn:8080/addOrder";
            $deviceNo = $value['print_usr'];
            $key = $value['feyin_key'];
            $times = $value['print_nums'];

            $pos = strpos($deviceNo, "kdt1");
            if ($pos === false) {
                $pos = 2;
            }
            if ($pos == 0) { //s1机器
                $huanhang = "\n";
            } else { //s2机器
                $print_content = str_replace('\n', '<BR>', $print_content);
            }

            if ($position_type == 1 && $value['position_type'] == 2) { //前台模式 后厨打印机
                continue;
            }
            if ($position_type == 2 && $value['position_type'] == 1) { //后厨模式 前台打印机
                continue;
            }

            if ($value['is_print_all'] == 1) {
                if ($value['type'] == 'feiyin') { //飞印
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => 0,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }

                $post_data = "deviceNo=" . $deviceNo . "&key=" . $key . "&printContent=" . $print_content . "&times=" . $times;
                $result = ihttp_request($target, $post_data);
                $_365status = $result['responseCode'];
                pdo_update('weisrc_dish_print_order', array('print_status' => $_365status), array('id' => $oid));
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $oid));
            }
        }
    }

    //飞鹅
    public function _feieSend($orderids, $position_type = 0, $isend = 0)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $totalprice = 0;
        $orderinfo_content = "";
        $paytype = $this->getPayType(1);
        foreach ($orderids as $k => $id) {
            $order = $this->getOrderById($id);
            $storeid = $order['storeid'];
            $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='feie' ", array(':storeid' => $storeid));

            $store = $this->getStoreById($storeid);
            $orderinfo_content .= "-------------------------<BR>";
            $orderinfo_content .= '订单编号:' . $order['ordersn'] . "<BR>";
            if ($isend == 1) {
                $orderinfo_content .= '支付方式:' . $paytype[$order['paytype']] . "<BR>";
            }

            $service_money = floatval($order['service_money']);
            if ($service_money > 0) {
                $service_money_content = "服务费:{$service_money}元<BR>";
            }

            $tables_content = '桌台信息:' . $this->getTableName($order['tables']) . "<BR>";
            $totalprice = $totalprice + floatval($order['totalprice']);
            $totalprice_content = "总价:" . number_format($totalprice, 2) . "元<BR>";

            //商品id数组
            $goodsid = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $id), 'goodsid');
            $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')");

            foreach ($goods as $v) {
                $money = $goodsid[$v['id']]['price'];
                $goodstotalprice = intval($goodsid[$v['id']]['total']) * $money;
                $goodstotalprice = number_format($goodstotalprice, 2);

                if (!empty($goodsid[$v['id']]['optionname'])) {
                    $goodsname = $v['title'] . '[' . $goodsid[$v['id']]['optionname'] . ']';
                } else {
                    $goodsname = $v['title'];
                }

                $orderinfo_content .= $goodsname . ' ' . $goodsid[$v['id']]['total'] . $v['unitname'] . ' ' .
                    number_format($money, 2) . "元" . ' ' . $goodstotalprice . "元<BR>";
            }
        }
        if ($isend == 1) {
            $print_content = "商家小票(已支付)\n";
        } else {
            $print_content = "商家小票\n";
        }

        $print_content .= "-------------------------<BR>";
        $print_content .= $tables_content;
        $print_content .= $orderinfo_content;
        $print_content .= "-------------------------<BR>";
        $print_content .= $totalprice_content;

        foreach ($settings as $item => $value) {
            $this->member_code = $value['member_code'];
            $this->device_no = $value['print_usr'];
            $this->feyin_key = $value['feyin_key'];

            if ($position_type == 1 && $value['position_type'] == 2) { //前台模式 后厨打印机
                continue;
            }
            if ($position_type == 2 && $value['position_type'] == 1) { //后厨模式 前台打印机
                continue;
            }

            $FEIE_IP = 'dzp.feieyun.com';
            $api_type = intval($value['api_type']);
            if ($api_type == 0) {
                $pos = strpos($value['print_usr'], '6');
                if ($pos == 2) {
                    $FEIE_IP = 'api163.feieyun.com';
                }
                $pos = strpos($value['print_usr'], '7');
                if ($pos == 2) {
                    $FEIE_IP = 'api174.feieyun.com';
                }
            } elseif ($api_type == 1) {
                $FEIE_IP = 'dzp.feieyun.com';
            } elseif ($api_type == 2) {
                $FEIE_IP = 'api163.feieyun.com';
            } elseif ($api_type == 3) {
                $FEIE_IP = 'api174.feieyun.com';
            } elseif ($api_type == 4) {
                $FEIE_IP = 'api.feieyun.cn';
            }
            $client = new HttpClient($FEIE_IP, FEIE_PORT);

            if ($value['is_print_all'] == 1) {
                if ($value['type'] == 'feiyin') { //飞印
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => 0,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }
                $feie_content = array(
                    'sn' => $value['print_usr'],
                    'printContent' => $print_content,
                    'key' => $value['feyin_key'],
                    'times' => 1//打印次数
                );

                $result = $client->post(FEIE_HOSTNAME . '/printOrderAction', $feie_content);
                $_feiestatus = $result['responseCode'];
                pdo_update('weisrc_dish_print_order', array('print_status' => $_feiestatus), array('id' => $oid));;
            }
        }
    }

    //飞印
    public function _feiyinSendFreeMessage($orderid = 0, $position_type = 0)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        if ($orderid == 0) {
            return -2;
        }

        $order = $this->getOrderById($orderid);

        if (empty($order)) {
            return -3;
        }

        $storeid = $order['storeid'];
        $store = $this->getStoreById($storeid);
        //打印机配置信息
        $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='feiyin' ", array(':storeid' => $storeid));

        if ($settings == false) {
            return -4;
        }

        $dining_mode = $order['dining_mode']; //1:店内2:外卖3:预定4:快餐
        $paytype = $this->getPayType($dining_mode);
        $ordertype = $this->getOrderType($store);

        //商品id数组
        $ordergoods = pdo_fetchall("SELECT * FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $orderid));
        $goodsid = array();
        if (!empty($ordergoods)) {
            foreach ($ordergoods as $key => $row) {
                if (isset($row['goodsid'])) {
                    $goodsid[$row['goodsid']] = $row;
                } else {
                    $goodsid[] = $row;
                }
            }
        }

        $paystatus = $order['ispay'] == 0 ? '未支付' : '已支付';
        $content = '订单编号:' . $order['ordersn'] . "\n";
        if ($dining_mode == 4) {
            $content .= '领餐牌号:' . $order['quicknum'] . "\n";
        }
        $content .= '订单类型:' . $ordertype[$dining_mode] . "\n";
        $content .= '所属门店:' . $store['title'] . "\n";
        $content .= '支付方式:' . $paytype[$order['paytype']] . "(" . $paystatus . ")\n";
        $content .= '下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . "\n";
        if ($dining_mode == 3) {
            $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
            $content .= "桌台类型：{$tablezones['title']}\n";
        }
        if (!empty($order['tables'])) {
            $content .= '桌台信息:' . $this->getTableName($order['tables']) . "\n";
        }
        if (!empty($order['counts'])) {
            $content .= '用餐人数:' . $order['counts'] . "\n";
        }
        if (!empty($order['remark'])) {
            $content .= '备注:' . $order['remark'] . "\n";
        }
        $content .= '门店地址:' . $store['address'] . "\n";
        $content .= '门店电话:' . $store['tel'] . "\n";

        $content2 = "-------------------------\n";
        $packvalue = floatval($order['packvalue']);
        $tea_money = floatval($order['tea_money']);
        $service_money = floatval($order['service_money']);
        if ($packvalue > 0 && $dining_mode == 2) {
            $content2 .= "打包费:{$packvalue}元\n";
        }
        if ($tea_money > 0 && $dining_mode == 1) {
            $content2 .= "{$store['tea_tip']}:{$tea_money}元\n";
        }
        if ($service_money > 0 && $dining_mode == 1) {
            $content2 .= "服务费:{$service_money}元\n";
        }
        $content2 .= "总数量:" . $order['totalnum'] . "   总价:" . number_format($order['totalprice'], 2) . "元\n";
        if ($dining_mode != 4 && !empty($order['meal_time'])) {
            $content2 .= '预定时间:' . $order['meal_time'] . "\n";
        }
        if (!empty($order['username'])) {
            $content2 .= '姓名:' . $order['username'] . "\n";
        }
        if (!empty($order['tel'])) {
            $content2 .= '手机:' . $order['tel'] . "\n";
        }
        if (!empty($order['address'])) {
            $content2 .= '地址:' . $order['address'] . "\n";
        }
        $content2 .= "-------------------------\n";


        foreach ($settings as $item => $value) {

            //判断打印订单类型（是否已经支付的单子）
            if ($value['print_type'] == 1 && $order['ispay'] == 0) { //支付模式未支付时
                continue;
            }
            if ($value['print_type'] == 2 && $order['status'] == 0) { //已确认模式未确认订单
                continue;
            }
            if ($position_type == 1 && $value['position_type'] == 2) { //前台模式 后厨打印机
                continue;
            }
            if ($position_type == 2 && $value['position_type'] == 1) { //后厨模式 前台打印机
                continue;
            }

            $loop_first = 0;
            if ($value['is_meal'] == 1 && $dining_mode == 1) {
                $loop_first = 1;
            }
            if ($value['is_delivery'] == 1 && $dining_mode == 2) {
                $loop_first = 1;
            }
            if ($value['is_reservation'] == 1 && $dining_mode == 3) {
                $loop_first = 1;
            }
            if ($value['is_snack'] == 1 && $dining_mode == 4) {
                $loop_first = 1;
            }
            if ($value['is_shouyin'] == 1 && $dining_mode == 5) {
                $loop_first = 1;
            }
            if ($loop_first == 0) {
                continue;
            }

            if (!empty($value['print_top'])) {
                $print_top = "" . $value['print_top'] . "\n";
            }
            if (!empty($value['print_bottom'])) {
                $print_bottom = "\n" . $value['print_bottom'] . "";
            }

            $this->member_code = $value['member_code'];
            $this->device_no = $value['print_usr'];
            $this->feyin_key = $value['feyin_key'];

            if ($order['status'] == -1) {
                $print_order_data = array(
                    'weid' => $weid,
                    'orderid' => $orderid,
                    'print_usr' => $value['print_usr'],
                    'print_status' => -1,
                    'dateline' => TIMESTAMP
                );
                pdo_insert($this->table_print_order, $print_order_data);
                $oid = pdo_insertid();
                $cancelcontent = '^订单已取消' . "\n";
                $cancelcontent .= '编号:' . $order['ordersn'];
                $freeMessage = array(
                    'memberCode' => $this->member_code,
                    'msgDetail' => $cancelcontent,
                    'deviceNo' => $this->device_no,
                    'msgNo' => $oid,
                );

                $feiyinstatus = $this->sendFreeMessage($freeMessage);
                pdo_update('weisrc_dish_print_order', array('print_status' => $feiyinstatus), array('id' => $oid));
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                return;
            }

            //商品
            if ($value['print_label'] == '0') {
                $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
            } else {
                //餐桌
                $table_label = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " WHERE id=:id", array(":id" => $order['tables']));
                if (in_array($table_label['print_label'], explode(',', $value['print_label']))) {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
                } else {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "') AND labelid IN(" . $value['print_label'] . ")", array(), 'id');
                }
            }

            if (empty($goods) && $dining_mode != 3 && $dining_mode != 5) {
                continue;
            }

            $order['goods'] = $goods;
            if ($goods) {
                if ($order['isvip'] == 1) {
                    $viptip = "(会员)";
                }
                if ($order['is_append'] == 1) {
                    $appendtip = "(加单)";
                }
                $content1 = "商品列表{$viptip}{$appendtip}\n";
                $content1 .= "-------------------------\n";
            }

            if ($value['is_print_all'] == 1) {

                if ($value['type'] == 'feiyin') { //飞印
                    $print_order_data = array(
                        'weid' => $weid,
                        'orderid' => $orderid,
                        'print_usr' => $value['print_usr'],
                        'print_status' => -1,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert($this->table_print_order, $print_order_data);
                    $oid = pdo_insertid();
                }

                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        $money = $v['price'];
                        $money = $money * $v['total'];

                        if (!empty($v['optionname'])) {
                            $goodsname = $goods[$v['goodsid']]['title'] . '[' . $v['optionname'] . ']';
                        } else {
                            $goodsname = $goods[$v['goodsid']]['title'];
                        }

                        $content1 .= $goodsname . ' ' . $v['total'] . $goods[$v['goodsid']]['unitname'] . ' ' . number_format($money, 2) . "元\n";
                    }
                }

                $msgDetail = $print_top . $content . $content1 . $content2 . $print_bottom;
                $msgNo = time() + 1;
                $freeMessage = array(
                    'memberCode' => $this->member_code,
                    'msgDetail' => $msgDetail,
                    'deviceNo' => $this->device_no,
                    'msgNo' => $oid,
                );
                $feiyinstatus = $this->sendFreeMessage($freeMessage);
                pdo_update('weisrc_dish_print_order', array('print_status' => $feiyinstatus), array('id' => $oid));
                pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
            } else {
                $content = '订单编号:' . $order['ordersn'] . "\n";
                $content .= '所属门店:' . $store['title'] . "\n";
                $content .= '支付方式:' . $paytype[$order['paytype']] . "(" . $paystatus . ")\n";
                $content .= '下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . "\n";
                if (!empty($order['tables'])) {
                    $content .= '桌台信息:' . $this->getTableName($order['tables']) . "\n";
                }
                if (!empty($order['counts'])) {
                    $content .= '用餐人数:' . $order['counts'] . "\n";
                }
                if (!empty($order['remark'])) {
                    $content .= '备注:' . $order['remark'] . "\n";
                }

                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        if ($value['type'] == 'feiyin') { //飞印
                            $print_order_data = array(
                                'weid' => $weid,
                                'orderid' => $orderid,
                                'print_usr' => $value['print_usr'],
                                'print_status' => -1,
                                'dateline' => TIMESTAMP
                            );
                            pdo_insert($this->table_print_order, $print_order_data);
                            $oid = pdo_insertid();
                        }


                        if (!empty($v['optionname'])) {
                            $goodsname = $goods[$v['goodsid']]['title'] . '[' . $v['optionname'] . ']';
                        } else {
                            $goodsname = $goods[$v['goodsid']]['title'];
                        }

                        $content1 = '';
                        $content1 .= "-------------------------\n";
                        $content1 .= '名称:' . $goodsname . "\n";
                        $content1 .= '数量:' . $v['total'] . $goods[$v['goodsid']]['unitname'] . "\n";
                        $content1 .= "-------------------------\n";

                        $msgDetail = $print_top . $content . $content1 . $content2 . $print_bottom;
                        $msgNo = time() + 1;
                        $freeMessage = array(
                            'memberCode' => $this->member_code,
                            'msgDetail' => $msgDetail,
                            'deviceNo' => $this->device_no,
                            'msgNo' => $oid,
                        );
                        $feiyinstatus = $this->sendFreeMessage($freeMessage);
                        pdo_update('weisrc_dish_print_order', array('print_status' => $feiyinstatus), array('id' => $oid));
                        pdo_update('weisrc_dish_order', array('isprint' => 1), array('id' => $orderid));
                    }
                }
            }
        }
        return $msgNo;
    }


    //飞鹅
    public function printgoodsfeie($orderid = 0, $position_type = 0)
    {
        global $_W, $_GPC;

        $order = $this->getOrderById($orderid);
        if (empty($order)) {
            return 0;
        }

        $weid = $order['weid'];
        $storeid = $order['storeid'];
        $store = $this->getStoreById($storeid);
        //打印机配置信息
        $settings = pdo_fetchall("SELECT * FROM " . tablename($this->table_print_setting) . " WHERE storeid = :storeid AND print_status=1 AND type='feie' ", array(':storeid' => $storeid));

        if ($settings == false) {
            return -4;
        }

        //1:店内2:外卖3:预定4:快餐
        $dining_mode = $order['dining_mode'];
        //商品id数组
        $ordergoods = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_print_goods") . " WHERE orderid = :orderid AND status=0", array(':orderid' => $orderid));
        $goodsid = array();
        if (!empty($ordergoods)) {
            foreach ($ordergoods as $key => $row) {
                if (isset($row['goodsid'])) {
                    $goodsid[$row['goodsid']] = $row;
                } else {
                    $goodsid[] = $row;
                }
            }
        }

        //打印机
        foreach ($settings as $item => $value) {
            //判断打印订单类型（是否已经支付的单子）
            //支付模式未支付时
            if ($value['print_type'] == 1 && $order['ispay'] == 0) {
                continue;
            }
            //已确认模式未确认订单
            if ($value['print_type'] == 2 && $order['status'] == 0) {
                continue;
            }
            //前台模式 后厨打印机
            if ($position_type == 1 && $value['position_type'] == 2) {
                continue;
            }
            //后厨模式 前台打印机
            if ($position_type == 2 && $value['position_type'] == 1) {
                continue;
            }

            $loop_first = 0;
            if ($value['is_meal'] == 1 && $dining_mode == 1) {
                $loop_first = 1;
            }
            if ($value['is_delivery'] == 1 && $dining_mode == 2) {
                $loop_first = 1;
            }
            if ($value['is_reservation'] == 1 && $dining_mode == 3) {
                $loop_first = 1;
            }
            if ($value['is_snack'] == 1 && $dining_mode == 4) {
                $loop_first = 1;
            }
            if ($value['is_shouyin'] == 1 && $dining_mode == 5) {
                $loop_first = 1;
            }
            if ($loop_first == 0) {
                continue;
            }

            $FEIE_IP = 'dzp.feieyun.com';
            $api_type = intval($value['api_type']);
            if ($api_type == 0) {
                $pos = strpos($value['print_usr'], '6');
                if ($pos == 2) {
                    $FEIE_IP = 'api163.feieyun.com';
                }
                $pos = strpos($value['print_usr'], '7');
                if ($pos == 2) {
                    $FEIE_IP = 'api174.feieyun.com';
                }
            } elseif ($api_type == 1) {
                $FEIE_IP = 'dzp.feieyun.com';
            } elseif ($api_type == 2) {
                $FEIE_IP = 'api163.feieyun.com';
            } elseif ($api_type == 3) {
                $FEIE_IP = 'api174.feieyun.com';
            } elseif ($api_type == 4) {
                $FEIE_IP = 'api.feieyun.cn';
            }

            $client = new HttpClient($FEIE_IP, FEIE_PORT);
            if (!empty($value['print_top'])) {
                $print_top = "<CB>" . $value['print_top'] . "</CB><BR>";
            }
            if (!empty($value['print_bottom'])) {
                $print_bottom = "<C>" . $value['print_bottom'] . "</C>";
            }

            //商品
            if ($value['print_label'] == '0') {
                $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
            } else {
                //餐桌
                $table_label = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " WHERE id=:id", array(":id" => $order['tables']));
                if (in_array($table_label['print_label'], explode(',', $value['print_label']))) {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "')", array(), 'id');
                } else {
                    $goods = pdo_fetchall("SELECT * FROM " . tablename($this->table_goods) . "  WHERE id IN ('" . implode("','", array_keys($goodsid)) . "') AND labelid IN(" . $value['print_label'] . ")", array(), 'id');
                }
            }
            if (empty($goods) && $dining_mode != 3 && $dining_mode != 5) {
                continue;
            }

            $order['goods'] = $goods;
            if ($value['is_print_all'] != 1) { //分单
                $content = '订单编号:' . $order['ordersn'] . "<BR>";
                $content .= '下单日期:' . date('Y-m-d H:i:s', $order['dateline']) . "<BR>";
                if (!empty($order['tables'])) {
                    $content .= '<B>桌台信息:</B><DB>' . $this->getTableName($order['tables']) . "</DB><BR>";
                }
                if (!empty($order['remark'])) {
                    $content .= '<DB>备注:' . $order['remark'] . "</DB><BR>";
                }

                foreach ($ordergoods as $v) {
                    if ($goods[$v['goodsid']]) {
                        if (!empty($v['optionname'])) {
                            $goodsname = $goods[$v['goodsid']]['title'] . '[' . $v['optionname'] . ']';
                        } else {
                            $goodsname = $goods[$v['goodsid']]['title'];
                        }
                        $content1 = '';
//                        $content1 .= "------------------------------------------------<BR>";
                        $content1 .= "----------------------------------<BR>";
                        $content1 .= '<B>名称:' . $goodsname . "</B><BR>";
                        $content1 .= '<B>数量:' . $v['total'] . $goods[$v['goodsid']]['unitname'] . "</B><BR>";
                        $money = $v['price'];
                        $content1 .= '<B>价格:' . number_format($money, 2) . "元</B><BR>";
                        $content1 .= "----------------------------------<BR>";
                        $printContent = $print_top . $content . $content1 . $print_bottom;
                        $feie_content = array(
                            'sn' => $value['print_usr'],
                            'printContent' => $printContent,
                            'key' => $value['feyin_key'],
                            'times' => $value['print_nums']//打印次数
                        );

                        $result = $client->post(FEIE_HOSTNAME . '/printOrderAction', $feie_content);
                        $status = $result['responseCode'];
                        pdo_update('weisrc_dish_print_goods',
                            array(
                                'status' => 1,
                                'print_type' => 'feie',
                                'print_usr' => $value['print_usr'],
                            ),
                            array('id' => $v['id']));
                    }
                }
            }
        }
    }

    public function getGoodsTitle($str1, $len, $stradd = "")
    {
        $i = 0;
        $str2 = "^B2";
        if ($len % 2 == 1)
            $len = $len + 1;
        $len1 = strlen($str1);
        for ($i = 0; $i < $len1 / $len; $i++) {
            $str2 .= '^B2' . substr($str1, $len * $i, $len) . $stradd;
            $str1 = substr($str1, $len * $i, $len1 - $len * $i);
        }
        return $str2;
    }

    //用户打印机处理订单
    private function feiyinformat($string, $length = 0, $isleft = true)
    {
        $substr = '';
        if ($length == 0 || $string == '') {
            return $string;
        }
        if ($this->print_strlen($string) > $length) {
            for ($i = 0; $i < $length; $i++) {
                $substr = $substr . "  ";
            }
            $string = $string . $substr;
        } else {
            for ($i = $this->print_strlen($string); $i < $length; $i++) {
                $substr = $substr . " ";
            }
            $string = $isleft ? ($string . $substr) : ($substr . $string);
        }
        return $string;
    }

    /**
     * @param string $l
     * @param string $r
     * @return string
     */
    public function formatstr($l = '', $r = '')
    {
        $nbsp = '                              ';
        $llen = $this->print_strlen($l);
        $rlen = $this->print_strlen($r);
        if ($l && $r) {
            $lr = $llen + $rlen;
            $nl = $this->print_strlen($nbsp);
            if ($lr >= $nl) {
                $strtxt = $l . "\r\n" . $this->formatstr(null, $r);
            } else {
                $strtxt = $l . substr($nbsp, $lr) . $r;
            }
        } elseif ($r) {
            $strtxt = substr($nbsp, $rlen) . $r;
        } else {
            $strtxt = $l;
        }
        return $strtxt;
    }

    /**
     * PHP获取字符串中英文混合长度
     * @param $str        字符串
     * @param string $charset 编码
     * @return int 返回长度，1中文=2位(utf-8为3位)，1英文=1位
     */
    private function print_strlen($str, $charset = '')
    {
        global $_W;
        if (empty($charset)) {
            $charset = $_W['charset'];
        }
        if (strtolower($charset) == 'gbk') {
            $charset = 'gbk';
            $ci = 2;
        } else {
            $charset = 'utf-8';
            $ci = 3;
        }
        if (strtolower($charset) == 'utf-8')
            $str = iconv('utf-8', 'GBK//IGNORE', $str);
        $num = strlen($str);
        $cnNum = 0;
        for ($i = 0; $i < $num; $i++) {
            if (ord(substr($str, $i + 1, 1)) > 127) {
                $cnNum++;
                $i++;
            }
        }
        $enNum = $num - ($cnNum * $ci);
        $number = $enNum + $cnNum * $ci;
        return ceil($number);
    }

    public function sendQueueNotice($oid, $status = 1)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $from_user = $this->_fromuser;

        $setting = pdo_fetch("select * from " . tablename($this->table_setting) . " WHERE weid =:weid LIMIT 1", array(':weid' => $weid));
        $order = pdo_fetch("select * from " . tablename($this->table_queue_order) . " WHERE id =:id LIMIT 1", array(':id' => $oid));
        $store = $this->getStoreById($order['storeid']);
        $keyword1 = $order['num'];
        $keyword2 = date("Y-m-d H:i", $order['dateline']);
        $host = $this->getOAuthHost();
        $url = $host . 'app' . str_replace('./', '/', $this->createMobileUrl('queue', array('storeid' => $order['storeid']), true));
        $wait_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_queue_order) . " WHERE status=1 AND storeid=:storeid AND id<:id AND queueid=:queueid ORDER BY id DESC", array(':id' => $oid, ':storeid' => $order['storeid'], ':queueid' => $order['queueid']));
        $queueStatus = array(
            '1' => '排队中',
            '2' => '已接受',
            '-1' => '已取消',
            '3' => '已过号'
        );

        if (!empty($setting['tplnewqueue']) && $setting['istplnotice'] == 1) {
            $templateid = $setting['tplnewqueue'];
            if ($setting['tpltype'] == 1) {
                if ($status == 1) { //排队中
                    $first = "排号提醒：编号{$keyword1}已成功领号，您可以点击本消息提前点菜，节约等待时间哦";
                    $remark = "门店名称：{$store['title']}";
                    $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                    $remark .= "\n前面等待：" . intval($wait_count);
                    $remark .= "\n排队状态：排队中";
                } else if ($status == 2) { //排队提醒
                    $first = "排号提醒：还需等待{$wait_count}桌";
                    $remark = "门店名称：{$store['title']}";
                    $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                    $remark .= "\n前面等待：" . intval($wait_count) . "桌";
                    $remark .= "\n排队状态：" . $queueStatus[$order['status']];
                } else if ($status == 3) { //取消提醒
                    $first = "排号取消提醒：编号" . $order['num'] . "已取消";
                    $remark = "您在{$store['title']}的排队状态更新为已取消，如有疑问，请联系我们工作人员";
                    $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                    $remark .= "\n排队状态：已取消";
                }

                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    ),
                );
            } else {
                $keyword3 = intval($wait_count);
                if ($status == 1) { //排队中
                    $first = "排号提醒：编号{$keyword1}已成功领号，您可以点击本消息提前点菜，节约等待时间哦";
                    $remark = "门店名称：{$store['title']}";
                    $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                    $remark .= "\n排队状态：排队中";
                } else if ($status == 2) { //排队提醒
                    $first = "排号提醒：还需等待{$wait_count}桌";
                    $remark = "门店名称：{$store['title']}";
                    $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                    $remark .= "\n排队状态：" . $queueStatus[$order['status']];
                } else if ($status == 3) { //取消提醒
                    $first = "排号取消提醒：编号" . $order['num'] . "已取消";
                    $remark = "您在{$store['title']}的排队状态更新为已取消，如有疑问，请联系我们工作人员";
                    $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                    $remark .= "\n排队状态：已取消";
                }

                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'keyword3' => array(
                        'value' => $keyword3,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    ),
                );
            }

            pdo_update($this->table_queue_order, array('isnotify' => 1), array('id' => $oid));
            $templateMessage = new templateMessage();
            $templateMessage->send_template_message($order['from_user'], $templateid, $content, '', $url);
        } else {
            if ($status == 1) { //排队中
                $content = '排号提醒：编号' . $keyword1 . '已成功领号，您可以<a href=\"' . $url . '\">点击本消息</a>提前点菜，节约等待时间哦';
                $content .= "\n当前排号：{$keyword1}";
                $content .= "\n取号时间：{$keyword2}";
                $content .= "\n门店名称：{$store['title']}";
                $content .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                $content .= "\n前面等待：" . intval($wait_count);
                $content .= "\n排队状态：排队中";
            } else if ($status == 2) { //排队提醒
                $content = "排号提醒：还需等待{$wait_count}桌";
                $content .= "\n当前排号：{$keyword1}";
                $content .= "\n取号时间：{$keyword2}";
                $content .= "\n门店名称：{$store['title']}";
                $content .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                $content .= "\n前面等待：" . intval($wait_count) . "桌";
                $content .= "\n排队状态：" . $queueStatus[$order['status']];
            } else if ($status == 3) { //取消提醒
                $content = "排号取消提醒：编号" . $order['num'] . "已取消";
                $content .= "\n当前排号：{$keyword1}";
                $content .= "\n取号时间：{$keyword2}";
                $content .= "\n您在{$store['title']}的排队状态更新为已取消，如果疑问，请联系我们工作人员";
                $content .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                $content .= "\n排队状态：已取消";
            }
            $this->sendText($order['from_user'], $content);
        }
    }

    public function sendAdminQueueNotice($oid, $from_user, $setting)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $order = pdo_fetch("select * from " . tablename($this->table_queue_order) . " WHERE id =:id LIMIT 1", array(':id' => $oid));
        $store = $this->getStoreById($order['storeid']);
        $keyword1 = $order['num'];
        $keyword2 = date("Y-m-d H:i", $order['dateline']);
        $url = '';
        $wait_count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_queue_order) . " WHERE status=1 AND storeid=:storeid AND queueid=:queueid ORDER BY id DESC", array(':storeid' => $order['storeid'], ':queueid' => $order['queueid']));

        if (!empty($setting['tplnewqueue']) && $setting['istplnotice'] == 1 && $setting['is_notice'] == 1 && !empty($from_user)) {
            $templateid = $setting['tplnewqueue'];

            $first = '排号提醒：有新的排号，编号' . $keyword1;
            if ($setting['tpltype'] == 1) {
                $remark = "门店名称：{$store['title']}";
                $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                $remark .= "\n排队等待：" . intval($wait_count) . '队';

                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    ),
                );
            } else {
                $remark = "门店名称：{$store['title']}";
                $remark .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];

                $keyword3 = intval($wait_count);

                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'keyword3' => array(
                        'value' => $keyword3,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    )
                );
            }

            pdo_update($this->table_queue_order, array('isnotify' => 1), array('id' => $oid));
            $templateMessage = new templateMessage();
            $templateMessage->send_template_message($from_user, $templateid, $content, '', $url);
        } else {
            if (!empty($setting['tpluser'])) { //排队中
                $content = '排号提醒：有新的排号，编号' . $keyword1;
                $content .= "\n当前排号：{$keyword1}";
                $content .= "\n取号时间：{$keyword2}";
                $content .= "\n门店名称：{$store['title']}";
                $content .= "\n排队号码：" . $this->getQueueName($order['queueid']) . " " . $order['num'];
                $content .= "\n排队等待：" . intval($wait_count) . '队';
            }
            $this->sendText($from_user, $content);
        }
    }

    public function sendOrderSms($order)
    {
        global $_W, $_GPC;
        $weid = $order['weid'];

        //发送短信提醒
        $smsSetting = pdo_fetch("SELECT * FROM " . tablename($this->table_setting) . " WHERE weid=:weid LIMIT 1", array(':weid' => $weid));
        $sendInfo = array();
        if (!empty($smsSetting)) {
            if ($smsSetting['sms_enable'] == 1 && !empty($order['tel'])) {
                //模板
                $smsSetting['sms_business_tpl'] = '您的订单：[sn]，收货人：[name] 电话：[tel]，已经成功提交。感谢您的购买！';
                //订单号
                $smsSetting['sms_business_tpl'] = str_replace('[sn]', $order['ordersn'], $smsSetting['sms_business_tpl']);
                $smsSetting['sms_business_tpl'] = str_replace('[name]', $order['username'], $smsSetting['sms_business_tpl']);
                $smsSetting['sms_business_tpl'] = str_replace('[tel]', $order['tel'], $smsSetting['sms_business_tpl']);

                $sendInfo['username'] = $smsSetting['sms_username'];
                $sendInfo['pwd'] = $smsSetting['sms_pwd'];
                $sendInfo['mobile'] = $order['tel'];
                $sendInfo['content'] = $smsSetting['sms_business_tpl'];
                //debug

                $return_result_code = $this->_sendSms($sendInfo);
                $smsStatus = $this->sms_status[$return_result_code];
            }
        }
    }

    public function sendAdminOrderSms($mobile, $order)
    {
        global $_W, $_GPC;
        $weid = $order['weid'];

        //发送短信提醒
        $smsSetting = pdo_fetch("SELECT * FROM " . tablename($this->table_setting) . " WHERE weid=:weid LIMIT 1", array(':weid' => $weid));
        $sendInfo = array();
        if (!empty($smsSetting)) {
            if ($smsSetting['sms_enable'] == 1 && !empty($mobile)) {
                $smsSetting['sms_business_tpl'] = '您有新的订单：[sn]，收货人：[name]，电话：[tel]，请及时确认订单！';
                $smsSetting['sms_business_tpl'] = str_replace('[sn]', $order['ordersn'], $smsSetting['sms_business_tpl']);
                $smsSetting['sms_business_tpl'] = str_replace('[name]', $order['username'], $smsSetting['sms_business_tpl']);
                $smsSetting['sms_business_tpl'] = str_replace('[tel]', $order['tel'], $smsSetting['sms_business_tpl']);

                $sendInfo['username'] = $smsSetting['sms_username'];
                $sendInfo['pwd'] = $smsSetting['sms_pwd'];
                $sendInfo['mobile'] = $mobile;
                $sendInfo['content'] = $smsSetting['sms_business_tpl'];
                //debug

                $return_result_code = $this->_sendSms($sendInfo);
                $smsStatus = $this->sms_status[$return_result_code];
            }
            return $smsStatus;
        }
    }

    public function sendAdminOrderEmail($toemail, $order, $store, $goods_str)
    {
        $firstArr = array(
            '-1' => '已经取消',
            '0' => '已经提交',
            '1' => '已经确认',
            '2' => '已并台',
            '3' => '已经完成'
        );

        $orderStatus = array(
            '-1' => '已取消',
            '0' => '待处理',
            '1' => '已确认',
            '2' => '已并台',
            '3' => '已完成'
        );
        $paytype = array(
            '0' => '现金付款',
            '1' => '余额支付',
            '2' => '微信支付',
            '3' => '现金付款',
            '4' => '支付宝'
        );
        $paystatus = array(
            '0' => '未支付',
            '1' => '已支付'
        );

        //发送邮件提醒
        $emailSetting = pdo_fetch("SELECT * FROM " . tablename($this->table_setting) . " WHERE weid=:weid LIMIT 1", array(':weid' => $order['weid']));

        $keyword1 = $order['ordersn'];
        $keyword2 = $orderStatus[$order['status']];
        $keyword3 = date("Y-m-d H:i", $order['dateline']);

        $email_tpl = "
        您的订单{$order['ordersn']}{$firstArr[$order['status']]}<br/>
        订单号：{$keyword1}<br/>
        订单状态：{$keyword2}<br/>
        时间：{$keyword3}<br/>
        门店名称：{$store['title']}<br/>
        支付方式：{$paytype[$order['paytype']]}<br/>
        支付状态：{$paystatus[$order['ispay']]}<br/>
        ";
        if ($order['dining_mode'] == 3) {
            $email_tpl .= "预定人信息：{$order['username']}－{$order['tel']}<br/>";
            $email_tpl .= "预定时间：{$order['meal_time']}<br/>";
        } else {
            $email_tpl .= "联系方式：{$order['username']}－{$order['tel']}<br/>";
        }
        if ($order['dining_mode'] == 1) {
            $tablename = $this->getTableName($order['tables']);
            $email_tpl .= "桌台信息：{$tablename}<br/>";
        }
        if ($order['dining_mode'] == 2) {
            if (!empty($order['address'])) {
                $email_tpl .= "配送地址：{$order['address']}<br/>";
            }
            if (!empty($order['meal_time'])) {
                $email_tpl .= "配送时间：{$order['meal_time']}<br/>";
            }
        }
        $email_tpl .= "菜单：{$goods_str}<br/>";
        $email_tpl .= "备注：{$order['remark']}<br/>";
        $email_tpl .= "应收合计：{$order['totalprice']}";

        if (!empty($emailSetting) && !empty($emailSetting['email'])) {
            if ($emailSetting['email_host'] == 'smtp.qq.com' || $emailSetting['email_host'] == 'smtp.gmail.com') {
                $secure = 'ssl';
                $port = '465';
            } else {
                $secure = 'tls';
                $port = '25';
            }

            $mail_config = array();
            $mail_config['host'] = $emailSetting['email_host'];
            $mail_config['secure'] = $secure;
            $mail_config['port'] = $port;
            $mail_config['username'] = $emailSetting['email_user'];
            $mail_config['sendmail'] = $emailSetting['email_send'];
            $mail_config['password'] = $emailSetting['email_pwd'];
            $mail_config['mailaddress'] = $toemail;
            $mail_config['subject'] = '订单提醒';
            $mail_config['body'] = $email_tpl;
            $result = $this->sendmail($mail_config);
        }
    }

    public function sendUserDeliveryNotice($order, $setting)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $orderStatus = array(
            '-1' => '已取消',
            '0' => '待处理',
            '1' => '已确认',
            '2' => '已并台',
            '3' => '已完成'
        );

        $site_url = str_replace('addons/bm_payu/', '', $_W['siteroot']);
        $site_url = str_replace('addons/bm_payms/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);//3174行加入
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);//3276行加入
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);//3550行加入
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);//3741行加入


        $url = $site_url . 'app' . str_replace('./', '/', $this->createMobileUrl('orderdetail', array('orderid' => $order['id']), true));
        $keyword1 = $order['ordersn'];
        $keyword2 = $orderStatus[$order['status']];
        $keyword3 = date("Y-m-d H:i", $order['dateline']);

        if (!empty($setting['tplneworder']) && $setting['istplnotice'] == 1) {
            $delivery_id = $order['delivery_id'];
            $deliveryuser = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " where id=:id LIMIT 1", array(':id' => $delivery_id));

            $templateid = $setting['tplneworder'];
            $first = "配送员已经接单";

            $remark = "配送员：" . $deliveryuser['username'];
            $remark .= "\n联系电话：" . $deliveryuser['mobile'];

            if ($setting['tpltype'] == 1) {
                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#FF0033'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'keyword3' => array(
                        'value' => $keyword3,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    ),
                );
            } else {
                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#FF0033'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword3,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    )
                );
            }

            $templateMessage = new templateMessage();
            $templateMessage->send_template_message($order['from_user'], $templateid, $content, '', $url);
        }
    }

    public function sendCouponNotice($from_user, $coupon, $store, $setting)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $url = $_W['siteroot'] . 'app' . str_replace('./', '/', $this->createMobileUrl('mycoupon', array(), true));
        $keyword1 = $store['title'];
        $keyword2 = $coupon['title'];
        $keyword3 = date("Y-m-d H:i", $coupon['endtime']);
        $keyword4 = date("Y-m-d H:i", TIMESTAMP);

        if (!empty($setting['tplcoupon'])) {
            $templateid = $setting['tplcoupon'];
            $first = "您好，您获得了一张优惠券";
            $remark = "感谢您的支持，谢谢";

            if ($setting['tpltype'] == 1) {
                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#FF0033'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#336699'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#336699'
                    ),
                    'keyword3' => array(
                        'value' => $keyword3,
                        'color' => '#336699'
                    ),
                    'keyword4' => array(
                        'value' => $keyword4,
                        'color' => '#336699'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#336699'
                    ),
                );
            }

            $templateMessage = new templateMessage();
            $templateMessage->send_template_message($from_user, $templateid, $content, '', $url);
        }
    }

    public function sendOrderNotice($order, $store, $setting)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $firstArr = array(
            '-1' => '已经取消',
            '0' => '已经提交',
            '1' => '已经确认',
            '2' => '已并台',
            '3' => '已经完成'
        );

        $orderStatus = array(
            '-1' => '已取消',
            '0' => '待处理',
            '1' => '已确认',
            '2' => '已并台',
            '3' => '已完成'
        );
        $paytype = array(
            '0' => '现金付款',
            '1' => '余额支付',
            '2' => '微信支付',
            '3' => '现金付款',
            '4' => '支付宝'
        );
        $paystatus = array(
            '0' => '未支付',
            '1' => '已支付'
        );

        $site_url = str_replace('addons/bm_payu/', '', $_W['siteroot']);
        $site_url = str_replace('addons/bm_payms/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);

        $url = $site_url . 'app' . str_replace('./', '/', $this->createMobileUrl('orderdetail', array('orderid' => $order['id']), true));
        $keyword1 = $order['ordersn'];
        $keyword2 = $orderStatus[$order['status']];
        $keyword3 = date("Y-m-d H:i", $order['dateline']);

        if (!empty($setting['tplneworder']) && $setting['istplnotice'] == 1) {
            $templateid = $setting['tplneworder'];
            $first = "您的订单{$order['ordersn']}{$firstArr[$order['status']]}";
            $remark = "门店名称：{$store['title']}";
            $remark .= "\n支付方式：{$paytype[$order['paytype']]}";
            $remark .= "\n支付状态：{$paystatus[$order['ispay']]}";
            if ($order['dining_mode'] == 3) {
                $remark .= "\n预定人信息：{$order['username']}－{$order['tel']}";
                $tablename = $this->getTableName($order['tables']);
                $remark .= "\n桌台信息：{$tablename}";
                $remark .= "\n预定时间：{$order['meal_time']}";
            } else {
                $remark .= "\n联系方式：{$order['username']}－{$order['tel']}";
            }
            if ($order['dining_mode'] == 1) {
                $tablename = $this->getTableName($order['tables']);
                $remark .= "\n桌台信息：{$tablename}";
            }
            if ($order['dining_mode'] == 2) {
                if (!empty($order['address'])) {
                    $remark .= "\n配送地址：{$order['address']}";
                }
                if (!empty($order['meal_time'])) {
                    $remark .= "\n配送时间：{$order['meal_time']}";
                }
            }
            if (!empty($order['remark'])) {
                $remark .= "\n备注：{$order['remark']}";
            }
            if (!empty($order['reply'])) {
                $remark .= "\n商家回复：{$order['reply']}";
            }

            $remark .= "\n应收合计：{$order['totalprice']}元";
            if ($order['credit'] > 0) {
                $remark .= "\n奖励积分：{$order['credit']}";
            }
            if ($setting['tpltype'] == 1) {
                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'keyword3' => array(
                        'value' => $keyword3,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    ),
                );
            } else {
                $remark = "订单状态：" . $keyword2 . "\n" . $remark;
                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword3,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    )
                );
            }

            $templateMessage = new templateMessage();
            $templateMessage->send_template_message($order['from_user'], $templateid, $content, '', $url);
        } else {
            $content = "您的订单{$order['ordersn']}{$firstArr[$order['status']]}";
            $content .= "\n订单号：{$keyword1}";
            $content .= "\n订单状态：{$keyword2}";
            $content .= "\n时间：{$keyword3}";
            $content .= "\n门店名称：{$store['title']}";
            $content .= "\n支付方式：{$paytype[$order['paytype']]}";
            $content .= "\n支付状态：{$paystatus[$order['ispay']]}";

            if ($order['dining_mode'] == 3) {
                if ($order['dining_mode'] == 3) {
                    $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
                }
                $content .= "\n预定人信息：{$order['username']}－{$order['tel']}";
                $content .= "\n桌台类型：{$tablezones['title']}";
                $content .= "\n预定时间：{$order['meal_time']}";
            } else {
                $content .= "\n联系方式：{$order['username']}－{$order['tel']}";
            }
            if ($order['dining_mode'] == 1) {
                $tablename = $this->getTableName($order['tables']);
                $content .= "\n桌台信息：{$tablename}";
            }
            if ($order['dining_mode'] == 2) {
                if (!empty($order['address'])) {
                    $content .= "\n配送地址：{$order['address']}";
                }
                if (!empty($order['meal_time'])) {
                    $content .= "\n配送时间：{$order['meal_time']}";
                }
            }
            if (!empty($order['remark'])) {
                $content .= "\n备注：{$order['remark']}";
            }
            if (!empty($order['reply'])) {
                $content .= "\n商家回复：{$order['reply']}";
            }

            $content .= "\n应收合计：{$order['totalprice']}元";
            if ($order['credit'] > 0) {
                $content .= "\n奖励积分：{$order['credit']}";
            }
            $this->sendText($order['from_user'], $content);
        }
    }

    public function addTplLog($order, $from_user, $content, $result)
    {
        global $_W, $_GPC;
        $insert = array(
            'weid' => $order['weid'],
            'from_user' => $from_user,
            'storeid' => $order['storeid'],
            'orderid' => $order['id'],
            'ordersn' => $order['ordersn'],
            'content' => $content,
            'result' => $result,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_tpl_log, $insert);
    }

//老板通知
    public function sendBossNotice($date, $from_user, $templateid, $content)
    {
        global $_W, $_GPC;
        $first = $date . $content['store']['title'];
        //营业总额
        $keyword1 = $content['totalNum']['totalPrice'];
        //营业收入
        $keyword2 = $content['totalNum']['totalPrice'];
        //营业数量
        $keyword3 = $content['totalNum']['totalNum'];
        //营业次数
        $keyword4 = intval($content['totalNum']['peopleNum']);
        //二次信息
        $remark = "----------------\n交易详情:\n";
        foreach ($content['payPrice'] as $v) {
            switch ($v['paytype']) {
                case 0:
                    $remark .= "现金支付：" . $v['total'] . "元（{$v['num']}单）\n";
                    break;
                case 1:
                    $remark .= "余额支付：" . $v['total'] . "元（{$v['num']}单）\n";
                    break;
                case 2:
                    $remark .= "微信支付：" . $v['total'] . "元（{$v['num']}单）\n";
                    break;
                case 3:
                    $remark .= "现金支付：" . $v['total'] . "元（{$v['num']}单）\n";
                    break;
                case 4:
                    $remark .= "支付宝支付：" . $v['total'] . "元（{$v['num']}单）\n";
                    break;
                default:
                    $remark .= "其它支付：" . $v['total'] . "元（{$v['num']}单）\n";
                    break;
            }
        }
        $remark .= "---------------";
        $remark .= "\n营业详情";
        $remark .= "\n总单数：" . intval($content['totalNum']['totalNum']);
        $remark .= "\n总交易：" . sprintf("%.2f", $content['totalNum']['totalPrice']) . "元";
        $remark .= "\n总人数：" . intval($content['totalNum']['peopleNum']);
        $remark .= "\n人均消费：" . sprintf("%.2f", $content['totalNum']['avgPrice']);
        $data = array(
            'first' => array(
                'value' => $first,
                'color' => '#a6a6a9'
            ),
            'keyword1' => array(
                'value' => $keyword1,
                'color' => '#a6a6a9'
            ),
            'keyword2' => array(
                'value' => $keyword2,
                'color' => '#a6a6a9'
            ),
            'keyword3' => array(
                'value' => $keyword3,
                'color' => '#a6a6a9'
            ),
            'keyword4' => array(
                'value' => $keyword4,
                'color' => '#a6a6a9'
            ),
            'remark' => array(
                'value' => $remark,
                'color' => '#a6a6a9'
            )
        );
        $url = "";
        $templateMessage = new templateMessage();
        $result = $templateMessage->send_template_message($from_user, $templateid, $data, '', $url);
        $result = $result['errmsg'] == 'ok' ? '发送成功' : $result['errmsg'];
        $this->addTplLog($date, $from_user, '老板信息通知', $result);
    }

    public function sendDeliveryOrderNotice($oid, $from_user, $setting, $isall = 0)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $orderStatus = array(
            '-1' => '已取消',
            '0' => '待处理',
            '1' => '已确认',
            '2' => '已并台',
            '3' => '已完成'
        );
        $paytype = array(
            '0' => '现金付款',
            '1' => '余额支付',
            '2' => '微信支付',
            '3' => '现金付款',
            '4' => '支付宝'
        );
        $ordertype = array(
            '1' => '堂点',
            '2' => '外卖',
            '3' => '预定',
            '4' => '快餐',
            '5' => '收银',
            '6' => '充值'
        );
        $paystatus = array(
            '0' => '未支付',
            '1' => '已支付'
        );

        $order = pdo_fetch("select * from " . tablename($this->table_order) . " WHERE id =:id LIMIT 1", array(':id' => $oid));
//        if ($order['ispay'] == 0) {
//            return false;
//        }
        $storeid = $order['storeid'];
        $store = $this->getStoreById($storeid);

        $site_url = str_replace('addons/bm_payu/', '', $_W['siteroot']);
        $site_url = str_replace('addons/bm_payms/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);

        $color = "#FF0033";
        if ($isall == 1) {
            $color = "#0066CC";
            $url = $site_url . 'app' . str_replace('./', '/', $this->createMobileUrl('deliveryorder', array('orderid' => $oid), true));
        } else {
            $url = $site_url . 'app' . str_replace('./', '/', $this->createMobileUrl('deliveryorderdetail', array('orderid' => $oid), true));
        }

        $keyword1 = $order['ordersn'];
        $keyword2 = $orderStatus[$order['status']];
        $keyword3 = date("Y-m-d H:i", $order['dateline']);
        if (!empty($setting['tplneworder']) && $setting['istplnotice'] == 1 && !empty($from_user)) {
            $templateid = $setting['tplneworder'];
            $first = "您有新的配送订单";
            $remark = "门店名称：{$store['title']}";
            if ($order['dining_mode'] == 1) {
                $tablename = $this->getTableName($order['tables']);
                $remark .= "\n桌台信息：{$tablename}";
            }
            $remark .= "\n订单类型：{$ordertype[$order['dining_mode']]}";
            $remark .= "\n支付方式：{$paytype[$order['paytype']]}";
            $remark .= "\n支付状态：{$paystatus[$order['ispay']]}";

            $goods = pdo_fetchall("SELECT a.*,b.title,b.unitname FROM " . tablename($this->table_order_goods) . " as a left join  " . tablename($this->table_goods) . " as b on a.goodsid=b.id WHERE a.weid = :weid and a.orderid=:orderid", array(':weid' => $weid, ':orderid' => $oid));
            if (!empty($goods)) {
                $remark .= "\n商品名称   单价 数量";
                $remark .= "\n－－－－－－－－－－－－－－－－";
                foreach ($goods as $key => $value) {
                    $remark .= "\n{$value['title']} {$value['price']}元 {$value['total']}{$value['unitname']}";
                }
            }

            if ($order['dining_mode'] == 3) {
                if ($order['dining_mode'] == 3) {
                    $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
                }
                $remark .= "\n预定人信息：{$order['username']}－{$order['tel']}";
                $tablename = $this->getTableName($order['tables']);
                $remark .= "\n桌台信息：{$tablename}";
                $remark .= "\n预定时间：{$order['meal_time']}";
            } else {
                $remark .= "\n联系方式：{$order['username']}－{$order['tel']}";
            }
            if ($order['dining_mode'] == 2) {
                if (!empty($order['address'])) {
                    $remark .= "\n配送地址：{$order['address']}";
                }
                if (!empty($order['meal_time'])) {
                    $remark .= "\n配送时间：{$order['meal_time']}";
                }
            }
            $remark .= "\n备注：{$order['remark']}";
            $remark .= "\n应收合计：{$order['totalprice']}元";

            if ($setting['tpltype'] == 1) {
                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => $color
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'keyword3' => array(
                        'value' => $keyword3,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    )
                );
            } else {
                $remark = "订单状态：" . $keyword2 . "\n" . $remark;
                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => $color
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword3,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    )
                );
            }

            $templateMessage = new templateMessage();
            $result = $templateMessage->send_template_message($from_user, $templateid, $content, '', $url);
            $result = $result['errmsg'] == 'ok' ? '发送成功' : $result['errmsg'];
            $this->addTplLog($order, $from_user, '配送员订单通知', $result);
        } else {
            $content = "您有新的配送订单";
            $content .= "\n订单类型：{$ordertype[$order['dining_mode']]}";
            $content .= "\n订单号：{$keyword1}";
            $content .= "\n订单状态：{$keyword2}";
            $content .= "\n时间：{$keyword3}";
            $content .= "\n门店名称：{$store['title']}";
            if ($order['dining_mode'] == 1) {
                $tablename = $this->getTableName($order['tables']);
                $content .= "\n桌台信息：{$tablename}";
            }
            $content .= "\n支付方式：{$paytype[$order['paytype']]}";
            $content .= "\n支付状态：{$paystatus[$order['ispay']]}";
            $goods = pdo_fetchall("SELECT a.*,b.title,b.unitname FROM " . tablename($this->table_order_goods) . " as a left join  " . tablename($this->table_goods) . " as b on a.goodsid=b.id WHERE a.weid = :weid and a.orderid=:orderid", array(':weid' => $weid, ':orderid' => $oid));
            if (!empty($goods)) {
                $content .= "\n商品名称   单价 数量";
                $content .= "\n－－－－－－－－－－－－－－－－";
                foreach ($goods as $key => $value) {
                    $content .= "\n{$value['title']} {$value['price']} {$value['total']}{$value['unitname']}";
                }
            }
            if ($order['dining_mode'] == 3) {
                if ($order['dining_mode'] == 3) {
                    $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
                }
                $content .= "\n预定人信息：{$order['username']}－{$order['tel']}";
                $content .= "\n桌台类型：{$tablezones['title']}";
                $content .= "\n预定时间：{$order['meal_time']}";
            } else {
                $content .= "\n联系方式：{$order['username']}－{$order['tel']}";
            }
            if ($order['dining_mode'] == 2) {
                if (!empty($order['address'])) {
                    $content .= "\n配送地址：{$order['address']}";
                }
                if (!empty($order['meal_time'])) {
                    $content .= "\n配送时间：{$order['meal_time']}";
                }
            }
            $content .= "\n备注：{$order['remark']}";
            $content .= "\n应收合计：{$order['totalprice']}元";
            if (!empty($from_user)) {
                $this->sendText($from_user, $content);
            }
        }
    }

    public function sendAdminOrderNotice($oid, $from_user, $setting)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $orderStatus = array(
            '-1' => '已取消',
            '0' => '待处理',
            '1' => '已确认',
            '2' => '已并台',
            '3' => '已完成'
        );
        $paytype = array(
            '0' => '现金付款',
            '1' => '余额支付',
            '2' => '微信支付',
            '3' => '现金付款',
            '4' => '支付宝'
        );
        $paystatus = array(
            '0' => '未支付',
            '1' => '已支付'
        );

        $order = $this->getOrderById($oid);
        $storeid = intval($order['storeid']);
        $store = $this->getStoreById($storeid);
        $ordertype = $this->getOrderType($store);

        $site_url = str_replace('addons/bm_payu/', '', $_W['siteroot']);
        $site_url = str_replace('addons/bm_payms/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);
        $site_url = str_replace('addons/jxkj_unipay/', '', $site_url);

        $url = $site_url . 'app' . str_replace('./', '/', $this->createMobileUrl('adminorderdetail', array('orderid' => $oid), true));
        $keyword1 = $order['ordersn'];
        $keyword2 = $orderStatus[$order['status']];
        $keyword3 = date("Y-m-d H:i", $order['dateline']);
        if (!empty($setting['tplneworder']) && $setting['istplnotice'] == 1 && !empty($from_user)) {
            $templateid = $setting['tplneworder'];
            $first = "您有新的订单";
            $remark = "门店名称：{$store['title']}";
            if ($order['dining_mode'] == 1) {
                $tablename = $this->getTableName($order['tables']);
                $remark .= "\n桌台信息：{$tablename}";
            }
            $remark .= "\n订单类型：{$ordertype[$order['dining_mode']]}";
            $remark .= "\n支付方式：{$paytype[$order['paytype']]}";
            $remark .= "\n支付状态：{$paystatus[$order['ispay']]}";

            $goods = pdo_fetchall("SELECT a.*,b.title,b.unitname FROM " . tablename($this->table_order_goods) . " as a left join  " . tablename($this->table_goods) . " as b on a.goodsid=b.id WHERE a.weid = :weid and a.orderid=:orderid", array(':weid' => $weid, ':orderid' => $oid));
            if (!empty($goods)) {
                $remark .= "\n商品名称   单价 数量";
                $remark .= "\n－－－－－－－－－－－－－－－－";
                foreach ($goods as $key => $value) {
                    $remark .= "\n{$value['title']} {$value['price']}元 {$value['total']}{$value['unitname']}";
                }
            }

            if ($order['dining_mode'] == 3) {
                if ($order['dining_mode'] == 3) {
                    $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
                }
                $remark .= "\n预定人信息：{$order['username']}－{$order['tel']}";
                $tablename = $this->getTableName($order['tables']);
                $remark .= "\n桌台信息：{$tablename}";
                $remark .= "\n预定时间：{$order['meal_time']}";
            } else {
                $remark .= "\n联系方式：{$order['username']}－{$order['tel']}";
            }
            if ($order['dining_mode'] == 2) {
                if (!empty($order['address'])) {
                    $remark .= "\n配送地址：{$order['address']}";
                }
                if (!empty($order['meal_time'])) {
                    $remark .= "\n配送时间：{$order['meal_time']}";
                }
            }
            $remark .= "\n备注：{$order['remark']}";
            $remark .= "\n应收合计：{$order['totalprice']}元";

            if ($setting['tpltype'] == 1) {
                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword2,
                        'color' => '#a6a6a9'
                    ),
                    'keyword3' => array(
                        'value' => $keyword3,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    )
                );
            } else {
                $remark = "订单状态：" . $keyword2 . "\n" . $remark;
                $content = array(
                    'first' => array(
                        'value' => $first,
                        'color' => '#a6a6a9'
                    ),
                    'keyword1' => array(
                        'value' => $keyword1,
                        'color' => '#a6a6a9'
                    ),
                    'keyword2' => array(
                        'value' => $keyword3,
                        'color' => '#a6a6a9'
                    ),
                    'remark' => array(
                        'value' => $remark,
                        'color' => '#a6a6a9'
                    )
                );
            }

            $templateMessage = new templateMessage();
            $result = $templateMessage->send_template_message($from_user, $templateid, $content, '', $url);
            $result = $result['errmsg'] == 'ok' ? '发送成功' : $result['errmsg'];
            $this->addTplLog($order, $from_user, '管理员订单通知', $result);
        } else {
            $content = "您有新的订单";
            $content .= "\n订单类型：{$ordertype[$order['dining_mode']]}";
            $content .= "\n订单号：{$keyword1}";
            $content .= "\n订单状态：{$keyword2}";
            $content .= "\n时间：{$keyword3}";
            $content .= "\n门店名称：{$store['title']}";
            if ($order['dining_mode'] == 1) {
                $tablename = $this->getTableName($order['tables']);
                $content .= "\n桌台信息：{$tablename}";
            }
            $content .= "\n支付方式：{$paytype[$order['paytype']]}";
            $content .= "\n支付状态：{$paystatus[$order['ispay']]}";
            $goods = pdo_fetchall("SELECT a.*,b.title,b.unitname FROM " . tablename($this->table_order_goods) . " as a left join  " . tablename($this->table_goods) . " as b on a.goodsid=b.id WHERE a.weid = :weid and a.orderid=:orderid", array(':weid' => $weid, ':orderid' => $oid));
            if (!empty($goods)) {
                $content .= "\n商品名称   单价 数量";
                $content .= "\n－－－－－－－－－－－－－－－－";
                foreach ($goods as $key => $value) {
                    $content .= "\n{$value['title']} {$value['price']} {$value['total']}{$value['unitname']}";
                }
            }
            if ($order['dining_mode'] == 3) {
                if ($order['dining_mode'] == 3) {
                    $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $order['tablezonesid']));
                }
                $content .= "\n预定人信息：{$order['username']}－{$order['tel']}";
                $content .= "\n桌台类型：{$tablezones['title']}";
                $content .= "\n预定时间：{$order['meal_time']}";
            } else {
                $content .= "\n联系方式：{$order['username']}－{$order['tel']}";
            }
            if ($order['dining_mode'] == 2) {
                if (!empty($order['address'])) {
                    $content .= "\n配送地址：{$order['address']}";
                }
                if (!empty($order['meal_time'])) {
                    $content .= "\n配送时间：{$order['meal_time']}";
                }
            }
            $content .= "\n备注：{$order['remark']}";
            $content .= "\n应收合计：{$order['totalprice']}元";
            if (!empty($from_user)) {
                $this->sendText($from_user, $content);
            }
        }
    }

    public function getNewSncode($weid, $sncode)
    {
        global $_W, $_GPC;
        $sn = pdo_fetch("SELECT sncode FROM " . tablename($this->table_sncode) . " WHERE weid = :weid and sncode = :sn ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':sn' => $sncode));
        if (!empty($sn)) {
            $sncode = 'A00' . random(11, 1);
            $this->getNewSncode($weid, $sncode);
        }
        return $sncode;
    }

    public function doMobileOrderlist()
    {
        $url = $this->createMobileUrl('order', array(), true);
        die('<script>location.href = "' . $url . '";</script>');
    }

    //取得购物车中的商品
    public function getDishCountInCart($storeid)
    {
        global $_GPC, $_W;
        $weid = $this->_weid;
        $from_user = $this->_fromuser;

        $dishlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_cart) . " WHERE  storeid=:storeid AND from_user=:from_user AND weid=:weid", array(':from_user' => $from_user, ':weid' => $weid, ':storeid' => $storeid));
        $dishid = 0;
        foreach ($dishlist as $key => $value) {
            $goodsid = intval($value['goodsid']);
            if ($dishid == $goodsid && $dishid != 0) {
                $arr[$value['goodsid']] = $arr[$value['goodsid']] + $value['total'];
            } else {
                $arr[$value['goodsid']] = $value['total'];
            }
            $dishid = intval($value['goodsid']);
        }
        return $arr;
    }

    public function doMobilestorecoin()
    {
        global $_W, $_GPC;
        $orderid = intval($_GPC['orderid']);
        $storeid = intval($_GPC['storeid']);
        $setting = $this->getSetting();
        $store = $this->getStoreById($storeid);

        //message('调试中' . $orderid);

        $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id", array(':id' => $orderid));
        if ($order['ispay'] == '1' || $order['status'] == '-1' || $order['status'] == '3') {
            message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', referer(), 'error');
        }

        $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecard') . " WHERE storeid=:storeid AND from_user=:from_user
LIMIT 1;", array(':storeid' => $storeid, ':from_user' => $order['from_user']));

        if (empty($card)) {
            message('您还没有开通会员卡不能使用余额支付！', referer(), 'error');
        }
        if ($card['coin'] < $order['totalprice']) {
            message('您的余额不足，请先充值！', referer(), 'error');
        }
        pdo_update('weisrc_dish_storecard', array('coin' => $card['coin'] - $order['totalprice']), array('id' => $card['id']));
        $data = array(
            'weid' => $order['weid'],
            'title' => '订单号' . $order['id'],
            'storeid' => $order['storeid'],
            'from_user' => $order['from_user'],
            'price' => $order['totalprice'],
            'type' => 2, //充值:1,消费:2
            'dateline' => TIMESTAMP
        );
        pdo_insert('weisrc_dish_storecardlog', $data);

        $orderdata['paytype'] == 1;
        $orderdata['ispay'] = 1;
        $orderdata['paytime'] = TIMESTAMP;
        if ($store['is_auto_confirm'] == 1 && $order['status'] == 0) {
            $orderdata['status'] = 1;
        }
        pdo_update($this->table_order, $orderdata, array('id' => $orderid));
        $user = $this->getFansByOpenid($order['from_user']);
        $touser = empty($user['nickname']) ? $user['from_user'] : $user['nickname'];
        $this->addOrderLog($orderid, $touser, 1, 1, 2);

        if ($order['dining_mode'] != 6) {
            if ($order['isprint'] == 0) {
                $this->_feiyinSendFreeMessage($orderid); //飞印
                $this->_365SendFreeMessage($orderid); //365打印机
                $this->_365lblSendFreeMessage($orderid); //365打印机
                $this->_feieSendFreeMessage($orderid); //飞鹅
                $this->_yilianyunSendFreeMessage($orderid); //易联云
                $this->_jinyunSendFreeMessage($orderid);
            }

            $order = $this->getOrderById($orderid);
            //用户
            $this->sendOrderNotice($order, $store, $setting);
            //管理
            if (!empty($setting)) {
                //平台提醒
                if ($setting['is_notice'] == 1) {
                    if (!empty($setting['tpluser'])) {
                        $tousers = explode(',', $setting['tpluser']);
                        foreach ($tousers as $key => $value) {
                            $this->sendAdminOrderNotice($orderid, $value, $setting);
                        }
                    }
                    if (!empty($setting['sms_mobile']) && !empty($setting['sms_username']) && !empty($setting['sms_pwd'])) {
                        $this->sendAdminOrderSms($setting['sms_mobile'], $order);
                    }
                }

                //门店提醒
                $accounts = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND storeid=:storeid AND status=2 AND is_notice_order=1 ORDER BY id
DESC ", array(':weid' => $this->_weid, ':storeid' => $storeid));
                foreach ($accounts as $key => $value) {
                    if (!empty($value['from_user'])) {
                        $this->sendAdminOrderNotice($orderid, $value['from_user'], $setting);
                    }
                    if (!empty($value['email']) && !empty($setting['email_user']) && !empty($setting['email_pwd'])) {
//                                $this->sendAdminOrderEmail($value['email'], $order, $store, $goods_str);
                    }
                    if (!empty($value['mobile']) && !empty($setting['sms_username']) && !empty($setting['sms_pwd'])) {
                        $smsStatus = $this->sendAdminOrderSms($value['mobile'], $order);
                    }
                }
            }

            if ($order['dining_mode'] == 2 && $setting['delivery_mode'] != 1) {
                //外卖订单,通知配送
                if ($store['is_sys_delivery'] == 1) {
                    if ($setting['delivery_mode'] == 2) { //所有配送员
                        $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 AND (storeid=0 OR
storeid={$storeid}) ORDER BY id DESC ", array(':weid' => $this->_weid));
                        foreach ($deliverys as $key => $value) {
                            $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                        }
                    } else if ($setting['delivery_mode'] == 3) { //区域配送员
                        $area = $this->getNearDeliveryArea($order['lat'], $order['lng']);
                        $areaid = intval($area['id']);
                        if ($areaid != 0) {
                            $strwhere = " AND areaid={$areaid} AND (storeid=0 OR
storeid={$storeid}) ";
                            $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 {$strwhere} ORDER BY id DESC ", array(':weid' => $this->_weid));
                            foreach ($deliverys as $key => $value) {
                                $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                            }
                        }
                    }
                } else {
                    $strwhere = "  AND storeid={$storeid}";
                    $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 {$strwhere} ORDER BY id DESC ", array(':weid' => $this->_weid));
                    foreach ($deliverys as $key => $value) {
                        $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                    }
                }
            }
        }
        $this->sendfengniao($order, $store, $setting);

        message('支付成功', $this->createMobileUrl('orderdetail', array('orderid' => $orderid), true), 'success');
    }


    public function doMobilePay()
    {
        global $_W, $_GPC;
        checkauth();

        //查当前订单信息
        if (!$this->inMobile) {
            message('支付功能只能在手机上使用');
        }
        $IMS_VERSION = intval(IMS_VERSION);

        $orderid = intval($_GPC['orderid']);
        $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id", array(':id' => $orderid));
        if ($order['ispay'] == '1' || $order['status'] == '-1' || $order['status'] == '3') {
            message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', referer(), 'error');
        }

        $tip = '餐后付款';
        if ($order['dining_mode'] == 2) {
            $tip = '货到付款';
        }

        $storeid = intval($order['storeid']);
        $setting = $this->getSetting();
        $store = $this->getStoreById($storeid);

        if ($store['is_card'] == 1) {
            $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecard') . " WHERE storeid=:storeid AND from_user=:from_user
LIMIT 1;", array(':storeid' => $storeid, ':from_user' => $order['from_user']));
        }

        //微信支付
        $is_wechat = 0;
        if ($setting['wechat'] == 1) {
            if ($store['wechat'] == 1) {
                $is_wechat = 1;
            }
            if ($order['dining_mode'] == 3) {
                $is_wechat = 0;
                if ($store['reservation_wechat'] == 1) {
                    $is_wechat = 1;
                }
            }
            if ($order['dining_mode'] == 1) { //店内
                if ($store['is_meal_pay_confirm'] == 1) {//确认后才允许支付
                    $is_wechat = 0;//默认关闭
                    if ($order['status'] > 0) {
                        $is_wechat = 1;
                    }
                }
            }
            if ($order['dining_mode'] == 6) {
                $is_wechat = 1;
            }
        }
        //支付宝
        $is_alipay = 0;
        if ($setting['alipay'] == 1) {
            if ($store['alipay'] == 1) {
                $is_alipay = 1;
            }
            if ($order['dining_mode'] == 3) {
                $is_alipay = 0;
                if ($store['reservation_alipay'] == 1) {
                    $is_alipay = 1;
                }
            }
            if ($order['dining_mode'] == 1) { //店内
                if ($store['is_meal_pay_confirm'] == 1) {//确认后才允许支付
                    $is_alipay = 0;//默认关闭
                    if ($order['status'] > 0) {
                        $is_alipay = 1;
                    }
                }
            }
        }
        //余额付款
        $is_credit = 0;
        if ($setting['credit'] == 1) {
            if ($store['credit'] == 1) {
                $is_credit = 1;
            }
            if ($order['dining_mode'] == 3) {
                $is_credit = 0;
                if ($store['reservation_credit'] == 1) {
                    $is_credit = 1;
                }
            }
            if ($order['dining_mode'] == 1) { //店内
                if ($store['is_meal_pay_confirm'] == 1) {//确认后才允许支付
                    $is_credit = 0;//默认关闭
                    if ($order['status'] > 0) {
                        $is_credit = 1;
                    }
                }
            }
            if ($order['dining_mode'] == 6) { //收银
                $is_credit = 0;
            }
        }
        //货到付款
        $is_delivery = 0;
        if ($setting['delivery'] == 1) {
            if ($store['delivery'] == 1) {
                $is_delivery = 1;
            }
            if ($order['dining_mode'] == 3) {
                $is_delivery = 0;
                if ($store['reservation_delivery'] == 1) {
                    $is_delivery = 1;
                }
            }
            if ($order['dining_mode'] == 5) { //收银
//                $is_delivery = 0;
            }
            if ($order['dining_mode'] == 6) { //充值
                $is_delivery = 0;
            }
        }
        $params['tid'] = $orderid;
        $params['user'] = $_W['fans']['from_user'];
        $params['fee'] = $order['totalprice'];
        $params['ordersn'] = $order['ordersn'];
        $params['virtual'] = true;
        $params['module'] = 'weisrc_dish';
        $params['title'] = '餐饮' . $order['ordersn'];


        if (IMS_VERSION >= '1.5.1') {
            load()->model('activity');
            load()->model('module');
            activity_coupon_type_init();
            if (!$this->inMobile) {
                message('支付功能只能在手机上使用', '', '');
            }
            $params['module'] = $this->module['name'];
            if ($params['fee'] <= 0) {
                $pars = array();
                $pars['from'] = 'return';
                $pars['result'] = 'success';
                $pars['type'] = '';
                $pars['tid'] = $params['tid'];
                $site = WeUtility::createModuleSite($params['module']);
                $method = 'payResult';
//                if XQ(method_exists($site, $method)) {
//                    exit($site->$method($pars));
//                }
            }
            $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
            if (empty($log)) {
                $log = array(
                    'uniacid' => $_W['uniacid'],
                    'acid' => $_W['acid'],
                    'openid' => $_W['member']['uid'],
                    'module' => $this->module['name'],
                    'tid' => $params['tid'],
                    'fee' => $params['fee'],
                    'card_fee' => $params['fee'],
                    'status' => '0',
                    'is_usecard' => '0',
                );
                pdo_insert('core_paylog', $log);
            } else {
                pdo_update('core_paylog', array('fee' => $params['fee'], 'card_fee' => $params['fee']), array('plid' => $log['plid']));
            }
            if ($log['status'] == '1') {
                message('这个订单已经支付成功, 不需要重复支付.', '', 'info');
            }
            $setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
            if (!is_array($setting['payment'])) {
//                message('没有有效的支付方式, 请联系网站管理员.', '', 'error');
            }
            $pay = $setting['payment'];
            $we7_coupon_info = module_fetch('we7_coupon');
            if (!empty($we7_coupon_info)) {
                $cards = activity_paycenter_coupon_available();
                if (!empty($cards)) {
                    foreach ($cards as $key => &$val) {
                        if ($val['type'] == '1') {
                            $val['discount_cn'] = sprintf("%.2f", $params['fee'] * (1 - $val['extra']['discount'] * 0.01));
                            $coupon[$key] = $val;
                        } else {
                            $val['discount_cn'] = sprintf("%.2f", $val['extra']['reduce_cost'] * 0.01);
                            $token[$key] = $val;
                            if ($log['fee'] < $val['extra']['least_cost'] * 0.01) {
                                unset($token[$key]);
                            }
                        }
                        unset($val['icon']);
                        unset($val['description']);
                    }
                }
                $cards_str = json_encode($cards);
            }
            if (empty($_W['member']['uid'])) {
                $pay['credit']['switch'] = false;
            }
            if ($params['module'] == 'paycenter') {
                $pay['delivery']['switch'] = false;
                $pay['line']['switch'] = false;
            }
            if (!empty($pay['credit']['switch'])) {
                $credtis = mc_credit_fetch($_W['member']['uid']);
            }
            $you = 0;
        } elseif (IMS_VERSION != '0.7') {
            load()->classs('coupon');
            $coupon_api = new coupon($_W['acid']);
            $is_coupon_supported = $coupon_api->isCouponSupported();
            if (!empty($is_coupon_supported)) {
                define('COUPON_TYPE', WECHAT_COUPON);
            } else {
                define('COUPON_TYPE', SYSTEM_COUPON);
            }
            load()->model('activity');

            if (!$this->inMobile) {
                message('支付功能只能在手机上使用');
            }

            $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
            if (empty($log)) {
                $log = array(
                    'uniacid' => $_W['uniacid'],
                    'acid' => $_W['acid'],
                    'openid' => $_W['member']['uid'],
                    'module' => $this->module['name'], //模块名称，请保证$this可用
                    'tid' => $params['tid'],
                    'fee' => $params['fee'],
                    'card_fee' => $params['fee'],
                    'status' => '0',
                    'is_usecard' => '0',
                );
                pdo_insert('core_paylog', $log);
            }

            if ($log['status'] == '1') {
                message('这个订单已经支付成功, 不需要重复支付.');
            }
            $setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
            if (!is_array($setting['payment'])) {
//                message('没有有效的支付方式, 请联系网站管理员.');
            }
            $pay = $setting['payment'];
            $cards = activity_paycenter_coupon_available();

            if (!empty($cards)) {
                foreach ($cards as $key => &$val) {
                    if ($val['type'] == '1') {
                        $val['discount_cn'] = sprintf("%.2f", $params['fee'] * (1 - $val['extra']['discount'] * 0.01));
                        $coupon[$key] = $val;
                    } else {
                        $val['discount_cn'] = sprintf("%.2f", $val['extra']['reduce_cost'] * 0.01);
                        $token[$key] = $val;
                        if ($log['fee'] < $val['extra']['least_cost'] * 0.01) {
                            unset($token[$key]);
                        }
                    }
                    unset($val['icon']);
                }
            }
            $cards_str = json_encode($cards);
            if (empty($_W['member']['uid'])) {
                $pay['credit']['switch'] = false;
            }
            if ($params['module'] == 'paycenter') {
                $pay['delivery']['switch'] = false;
                $pay['line']['switch'] = false;
            }
            if (!empty($pay['credit']['switch'])) {
                $credtis = mc_credit_fetch($_W['member']['uid']);
            }
            $you = 0;
        } else {
            $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => $params['module'], 'tid' => $params['tid']));
            if (empty($log)) {
                $log = array(
                    'uniacid' => $_W['uniacid'],
                    'acid' => $_W['acid'],
                    'openid' => $_W['member']['uid'],
                    'module' => $this->module['name'], //模块名称，请保证$this可用
                    'tid' => $params['tid'],
                    'fee' => $params['fee'],
                    'card_fee' => $params['fee'],
                    'status' => '0',
                    'is_usecard' => '0',
                );
                pdo_insert('core_paylog', $log);
            }
            if ($log['status'] == '1') {
                message('这个订单已经支付成功, 不需要重复支付.');
            }
            $setting = uni_setting($_W['uniacid'], array('payment', 'creditbehaviors'));
            if (!is_array($setting['payment'])) {
//                message('没有有效的支付方式, 请联系网站管理员.');
            }
            $pay = $setting['payment'];
            if (empty($_W['member']['uid'])) {
                $pay['credit']['switch'] = false;
            }
            if (!empty($pay['credit']['switch'])) {
                $credtis = mc_credit_fetch($_W['member']['uid']);
            }
            $you = 0;
            if ($pay['card']['switch'] == 2 && !empty($_W['openid'])) {
                if ($_W['card_permission'] == 1 && !empty($params['module'])) {
                    $cards = pdo_fetchall('SELECT a.id,a.card_id,a.cid,b.type,b.title,b.extra,b.is_display,b.status,b.date_info FROM ' . tablename('coupon_modules') . ' AS a LEFT JOIN ' . tablename('coupon') . ' AS b ON a.cid = b.id WHERE a.acid = :acid AND a.module = :modu AND b.is_display = 1 AND b.status = 3 ORDER BY a.id DESC', array(':acid' => $_W['acid'], ':modu' => $params['module']));
                    $flag = 0;
                    if (!empty($cards)) {
                        foreach ($cards as $temp) {
                            $temp['date_info'] = iunserializer($temp['date_info']);
                            if ($temp['date_info']['time_type'] == 1) {
                                $starttime = strtotime($temp['date_info']['time_limit_start']);
                                $endtime = strtotime($temp['date_info']['time_limit_end']);
                                if (TIMESTAMP < $starttime || TIMESTAMP > $endtime) {
                                    continue;
                                } else {
                                    $param = array(':acid' => $_W['acid'], ':openid' => $_W['openid'], ':card_id' => $temp['card_id']);
                                    $num = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('coupon_record') . ' WHERE acid = :acid AND openid = :openid AND card_id = :card_id AND status = 1', $param);
                                    if ($num <= 0) {
                                        continue;
                                    } else {
                                        $flag = 1;
                                        $card = $temp;
                                        break;
                                    }
                                }
                            } else {
                                $deadline = intval($temp['date_info']['deadline']);
                                $limit = intval($temp['date_info']['limit']);
                                $param = array(':acid' => $_W['acid'], ':openid' => $_W['openid'], ':card_id' => $temp['card_id']);
                                $record = pdo_fetchall('SELECT addtime,id,code FROM ' . tablename('coupon_record') . ' WHERE acid = :acid AND openid = :openid AND card_id = :card_id AND status = 1', $param);
                                if (!empty($record)) {
                                    foreach ($record as $li) {
                                        $time = strtotime(date('Y-m-d', $li['addtime']));
                                        $starttime = $time + $deadline * 86400;
                                        $endtime = $time + $deadline * 86400 + $limit * 86400;
                                        if (TIMESTAMP < $starttime || TIMESTAMP > $endtime) {
                                            continue;
                                        } else {
                                            $flag = 1;
                                            $card = $temp;
                                            break;
                                        }
                                    }
                                }
                                if ($flag) {
                                    break;
                                }
                            }
                        }
                    }
                    if ($flag) {
                        if ($card['type'] == 'discount') {
                            $you = 1;
                            $card['fee'] = sprintf("%.2f", ($params['fee'] * ($card['extra'] / 100)));
                        } elseif ($card['type'] == 'cash') {
                            $cash = iunserializer($card['extra']);
                            if ($params['fee'] >= $cash['least_cost']) {
                                $you = 1;
                                $card['fee'] = sprintf("%.2f", ($params['fee'] - $cash['reduce_cost']));
                            }
                        }
                        load()->classs('coupon');
                        $acc = new coupon($_W['acid']);
                        $card_id = $card['card_id'];
                        $time = TIMESTAMP;
                        $randstr = random(8);
                        $sign = array($card_id, $time, $randstr, $acc->account['key']);
                        $signature = $acc->SignatureCard($sign);
                        if (is_error($signature)) {
                            $you = 0;
                        }
                    }
                }
            }

            if ($pay['card']['switch'] == 3 && $_W['member']['uid']) {
                $cards = array();
                if (!empty($params['module'])) {
                    $cards = pdo_fetchall('SELECT a.id,a.couponid,b.type,b.title,b.discount,b.condition,b.starttime,b.endtime FROM ' . tablename('activity_coupon_modules') . ' AS a LEFT JOIN ' . tablename('activity_coupon') . ' AS b ON a.couponid = b.couponid WHERE a.uniacid = :uniacid AND a.module = :modu AND b.condition <= :condition AND b.starttime <= :time AND b.endtime >= :time  ORDER BY a.id DESC', array(':uniacid' => $_W['uniacid'], ':modu' => $params['module'], ':time' => TIMESTAMP, ':condition' => $params['fee']), 'couponid');
                    if (!empty($cards)) {
                        foreach ($cards as $key => &$card) {
                            $has = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('activity_coupon_record') . ' WHERE uid = :uid AND uniacid = :aid AND couponid = :cid AND status = 1' . $condition, array(':uid' => $_W['member']['uid'], ':aid' => $_W['uniacid'], ':cid' => $card['couponid']));
                            if ($has > 0) {
                                if ($card['type'] == '1') {
                                    $card['fee'] = sprintf("%.2f", ($params['fee'] * $card['discount']));
                                    $card['discount_cn'] = sprintf("%.2f", $params['fee'] * (1 - $card['discount']));
                                } elseif ($card['type'] == '2') {
                                    $card['fee'] = sprintf("%.2f", ($params['fee'] - $card['discount']));
                                    $card['discount_cn'] = $card['discount'];
                                }
                            } else {
                                unset($cards[$key]);
                            }
                        }
                    }
                }
                if (!empty($cards)) {
                    $cards_str = json_encode($cards);
                }
            }
        }
        load()->model('mc');
        $user = mc_fetch($this->_fromuser);
        $score = intval($user['credit1']); //剩余积分
        $coin = $user['credit2']; //余额
        $coin = empty($coin) ? '0.00' : $coin;

        //美丽心情
        if ($store['is_business'] == 1) {
            $business_id = intval($store['business_id']);
            if ($business_id > 0) {
                $business_url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&tid=' . $params['tid'] . '&title=' . $params['title'] . '&fee=' . $params['fee'] . '&ordersn=' . $params['ordersn'] . '&user=' . $params['user'] . '&rid=' . $business_id . '&ms=weisrc_dish&do=payex&m=bm_payu';
            }
        }

        //美丽心情
        if ($store['is_bank_pay'] == 1) {
            $bank_pay_id = intval($store['bank_pay_id']);
            if ($bank_pay_id > 0) {
                $bank_pay_url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&tid=' . $params['tid'] . '&title=' . $params['title'] . '&fee=' . $params['fee'] . '&ordersn=' . $params['ordersn'] . '&user=' . $params['user'] . '&rid=' . $bank_pay_id . '&ms=weisrc_dish&do=payex&m=bm_payms';
            }
        }
        if ($store['is_jxkj_unipay'] == 1) {
            $jxkj_pay_id = intval($store['jxkj_pay_id']);
            if ($jxkj_pay_id > 0) {
                $jxkj_pay_url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&tid=' . $params['tid'] . '&title=' . $params['title'] . '&fee=' . $params['fee'] . '&ordersn=' . $params['ordersn'] . '&user=' . $params['user'] . '&rid=' . $jxkj_pay_id . '&ms=weisrc_dish&do=payex&m=jxkj_unipay';
            }
        }

        //快捷云支付
        if ($store['is_vtiny_bankpay'] == 1) {
            $vtiny_bankpay_url = $store['vtiny_bankpay_url'] . '&params=' . base64_encode(json_encode($params));
        }
        //test6688  一码付服务商版
        if ($store['is_ld_wxserver'] == 1) {
            $ld_wxserver_url = $store['ld_wxserver_url'] . '&params=' . base64_encode(json_encode($params));
        }

        if ($store['is_jueqi_ymf'] == 1) {
            //需要获取的参数
            $host = $store['jueqi_host'];//本机服务器一码付的域名前缀（可能为独立域名，可能为微擎域名路径，具体看接口文档）
            $uid = 'weisrc_dish';//模块标识

//            $prikey = 'y4Ko5Sg9a9mPTVg0';//秘钥
            $prikey = $store['jueqi_secret'];//秘钥
            //需要获取的参数
            $selfOrdernum = $params['ordersn'];
            $openId = $_W['fans']['from_user'];

            $customerId = trim($store['jueqi_customerId']);
            $money = $order['totalprice'];
            $back_url = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('pay', 'jueqiBack', $_SERVER['REQUEST_URI']);

            $notifyUrl = base64_encode(urlencode(($back_url)));//异步URL，必须带参数
            $successUrl = base64_encode(urlencode(($back_url)));//成功跳转URL，必须带参数
            $uid = 'weisrc_dish';//模块标识
            $prikey = $prikey;//秘钥
            $goodsName = $params['title'];//商品名称
            $remark = '';//备注
            //跳转到在线支付
            $post_data1['money'] = $money;
            $post_data1['selfOrdernum'] = $selfOrdernum;
            $post_data1['remark'] = $remark;
            $post_data1['openId'] = $openId;
            $post_data1['customerId'] = $customerId;
            $post_data1['notifyUrl'] = $notifyUrl;
            $post_data1['successUrl'] = $successUrl;
            $post_data1['uid'] = $uid;
            $post_data1['goodsName'] = $goodsName;

            ksort($post_data1);
            // 说明如果有汉字请使用utf-8编码
            $o = "";
            foreach ($post_data1 as $k => $v) {
                $o .= "$k=" . ($v) . "&";
            }
            $post_data1 = substr($o, 0, -1);

            $post_data_temp1 = $prikey . $post_data1;

            $signIn = strtoupper(md5($post_data_temp1));
            $url = $host . '/index.php?s=/Home/linenew/m_pay';//集成接口url
            $url = $url . '/selfOrdernum/' . $selfOrdernum . '/openId/' . $openId . '/customerId/' . $customerId . '/money/' . $money . '/notifyUrl/' . $notifyUrl . '/successUrl/' . $successUrl . '/uid/' . $uid . '/goodsName/' . $goodsName . '/remark/' . $remark . '/sign/' . $signIn;
            $jueqi_ymf_url = $url;
        }

//        if (IMS_VERSION >= '1.5.1') {
//            include $this->template('paycenter_1.5.1');
//        } elseif (IMS_VERSION != '0.7') {
//            include $this->template('paycenter_v8_2');
//        } else {
//            include $this->template('paycenter');
//        }

        include $this->template('paycenter_v8_2');
    }

    public function doMobileJueqiBack()
    {
        global $_W, $_GPC;
        $data['weid'] = $this->_weid;
        $data['uniacid'] = $_W['uniacid'];
        $data['acid'] = $_W['acid'];
        $data['result'] = 'success';
        $data['type'] = 'wechat';
        $data['from'] = 'notify';
        $data['tid'] = $_GPC['selfOrdernum'];
        $data['uniontid'] = $_GPC['orderno'];
        $data['transaction_id'] = $_GPC['orderno'];
        //$data['trade_type'] =$this->_weid;
        //$data['follow'] =$this->_weid;
        $data['user'] = $_GPC['uuid'];
        $data['fee'] = $_GPC['money'];
        $data['tag']['transaction_id'] = $_GPC['orderno'];
        //$data['is_usecard'] =$this->_weid;
        //$data['card_type'] =$this->_weid;
        //$data['card_fee'] =$this->_weid;
        //$data['card_id'] =$this->_weid;
        //$data['cash_fee'] =$this->_weid;
        $data['total_fee'] = $_GPC['money'];
        $data['paysys'] = 'bm_payms';
        $data['paytime'] = $_GPC['paytime'];
        $this->payResult($data);
    }

    public function sendText($openid, $content)
    {
        $send['touser'] = trim($openid);
        $send['msgtype'] = 'text';
        $send['text'] = array('content' => urlencode($content));
        $acc = WeAccount::create();
        $data = $acc->sendCustomNotice($send);
        return $data;
    }

    public function getCardNumber($weid)
    {
        global $_W, $_GPC;
        $user_card = pdo_fetch("select cardno from " . tablename('weisrc_dish_card') . " where weid =" . $weid . " order by id desc limit 1");
        if (!empty($user_card)) {
            return intval($user_card['cardno']) + 1;
        } else {
            if (empty($cardstart)) {
                return 1000001;
            } else {
                return $cardstart;
            }
        }
    }

    public function getStoreCardNumber($weid)
    {
        global $_W, $_GPC;
        $user_card = pdo_fetch("select cardno from " . tablename('weisrc_dish_storecard') . " where weid =" . $weid . " order by id desc limit 1");
        if (!empty($user_card)) {
            return intval($user_card['cardno']) + 1;
        } else {
            if (empty($cardstart)) {
                return 1000001;
            } else {
                return $cardstart;
            }
        }
    }

    public function setCard($orderid)
    {
        $order = $this->getOrderById($orderid);
        $weid = $this->_weid;
        $daycount = intval($order['daycount']);

        $cardsetting = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_cardsetting') . " WHERE weid=:weid LIMIT 1", array
        (':weid' => $weid));

        $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_card') . " WHERE from_user=:from_user
LIMIT 1;", array(':from_user' => $order['from_user']));

        if (empty($card)) { //新卡
            $time = strtotime('+' . $daycount . ' days', TIMESTAMP);
            $data_card = array(
                'weid' => $order['weid'],
                'storeid' => $order['storeid'],
                'from_user' => $order['from_user'],
                'cardpre' => '',
                'carnumber' => '',
                'cardno' => $this->getCardNumber($weid),
                'coin' => 0,
                'balance_score' => $cardsetting['opencardcredit'],
                'total_score' => 0,
                'spend_score' => 0,
                'sign_score' => 0,
                'money' => 0,
                'status' => 1,
                'lasttime' => $time,
                'dateline' => TIMESTAMP
            );
            $data_card['carnumber'] = $data_card['cardno'];
            pdo_insert('weisrc_dish_card', $data_card);
            //奖励推荐人
            if ($cardsetting['sendcredit'] > 0) {
                $fans = $this->getFansByOpenid($order['from_user']);
                if ($fans['agentid'] > 0) {
                    $agent = $this->getFansById($fans['agentid']);
                    if ($agent) {
                        $agentcard = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_card') . " WHERE from_user=:from_user
LIMIT 1;", array(':from_user' => $agent['from_user']));
                        if ($agentcard) {
                            $datalog = array(
                                'weid' => $weid,
                                'title' => '推荐奖励',
                                'from_user' => $agentcard['from_user'],
                                'type' => 1,
                                'price' => $cardsetting['sendcredit'],
                                'remark' => '推荐奖励积分',
                                'dateline' => TIMESTAMP
                            );
                            pdo_insert('weisrc_dish_cardlog', $datalog);

                            pdo_update('weisrc_dish_card', array('balance_score' => $agentcard['balance_score'] + $cardsetting['sendcredit']), array('id' => $agentcard['id']));
                        }
                    }
                }
            }
        } else {
            $time = strtotime('+' . $daycount . ' days', $card['lasttime']);
            pdo_update('weisrc_dish_card', array('lasttime' => $time), array('id' => $card['id']));
        }
    }

    public function setStoreCard($orderid)
    {
        $order = $this->getOrderById($orderid);
        $weid = $this->_weid;
        $daycount = intval($order['daycount']);

        $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecard') . " WHERE storeid=:storeid AND from_user=:from_user
LIMIT 1;", array(':storeid' => $order['storeid'], ':from_user' => $order['from_user']));

        if (empty($card)) { //新卡
            $time = strtotime('+' . $daycount . ' days', TIMESTAMP);
            $data_card = array(
                'weid' => $order['weid'],
                'storeid' => $order['storeid'],
                'from_user' => $order['from_user'],
                'cardpre' => '',
                'carnumber' => '',
                'cardno' => $this->getStoreCardNumber($weid),
                'coin' => 0,
                'balance_score' => 0,
                'total_score' => 0,
                'spend_score' => 0,
                'sign_score' => 0,
                'money' => 0,
                'status' => 1,
                'lasttime' => $time,
                'dateline' => TIMESTAMP
            );
            $data_card['carnumber'] = $data_card['cardno'];
            pdo_insert('weisrc_dish_storecard', $data_card);
        } else {
            $time = strtotime('+' . $daycount . ' days', $card['lasttime']);
            pdo_update('weisrc_dish_storecard', array('lasttime' => $time), array('id' => $card['id']));
        }
    }

    public function setStoreCardCoin($orderid)
    {
        $order = $this->getOrderById($orderid);
        $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecard') . " WHERE storeid=:storeid AND from_user=:from_user
LIMIT 1;", array(':storeid' => $order['storeid'], ':from_user' => $order['from_user']));
        if ($card) {
            $data = array(
                'weid' => $order['weid'],
                'storeid' => $order['storeid'],
                'from_user' => $order['from_user'],
                'price' => $order['totalprice'],
                'type' => 1, //充值:1,消费:2
                'dateline' => TIMESTAMP
            );
            pdo_insert('weisrc_dish_storecardlog', $data);
            pdo_update('weisrc_dish_storecard', array('coin' => $card['coin'] + $order['totalprice']), array('id' => $card['id']));
        }
    }

    public function payResult($params)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $orderid = $params['tid'];
        $fee = intval($params['fee']);
        $paytype = array('credit' => '1', 'wechat' => '2', 'alipay' => '4', 'baifubao' => '5', 'delivery' => '3');

        // 卡券代金券备注
        if (!empty($params['is_usecard'])) {
            $cardType = array('1' => '微信卡券', '2' => '系统代金券');
            $result_price = ($params['fee'] - $params['card_fee']);
            $data['paydetail'] = '使用' . $cardType[$params['card_type']] . '支付了' . $result_price;
            $data['paydetail'] .= '元，实际支付了' . $params['card_fee'] . '元。';
            $data['totalprice'] = $params['card_fee'];
        }

        $data['paytype'] = $paytype[$params['type']];

        if ($params['type'] == 'alipay') {
            if (!empty($params['transaction_id'])) {
                $data['transid'] = $params['transaction_id'];
            }
        }
        if ($params['type'] == 'wechat') {
            if (!empty($params['tag']['transaction_id'])) {
                $data['transid'] = $params['tag']['transaction_id'];
            }
        }

        if (($params['paysys'] == 'bm_payms') || ($params['paysys'] == 'jxkj_unipay')) {
            $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE ordersn = :ordersn", array(':ordersn' => $params['tid']));
            $orderid = $order['id'];
        } else {
            $order = $this->getOrderById($orderid);
        }

        if (empty($order)) {
            message('订单不存在!!!');
        }

        if ($order['ispay'] == 0) {
            $storeid = $order['storeid'];
            $store = $this->getStoreById($storeid);

            //本订单产品
            $goods = pdo_fetchall("SELECT a.*,b.title,b.unitname FROM " . tablename($this->table_order_goods) . " as a left join  " . tablename($this->table_goods) . " as b on a.goodsid=b.id WHERE a.orderid=:orderid ", array(':orderid' => $orderid));
            $goods_str = '';
            $goods_tplstr = '';
            $flag = false;
            foreach ($goods as $key => $value) {
                if (!$flag) {
                    $goods_str .= "{$value['title']} 价格：{$value['price']} 数量：{$value['total']}{$value['unitname']}";
                    $goods_tplstr .= "{$value['title']} {$value['total']}{$value['unitname']}";
                    $flag = true;
                } else {
                    $goods_str .= "<br/>{$value['title']} 价格：{$value['price']} 数量：{$value['total']}{$value['unitname']}";
                    $goods_tplstr .= ",{$value['title']} {$value['total']}{$value['unitname']}";
                }
            }

            if ($order['dining_mode'] == 1) { //店内
                if ($data['paytype'] == 3) { //现金
                    pdo_update($this->table_tables, array('status' => 2), array('id' => $order['tables']));
                } else {
                    pdo_update($this->table_tables, array('status' => 3), array('id' => $order['tables']));
                }
            }
            $setting = $this->getSettingByWeid($order['weid']);

            //后台通知，修改状态
            if ($params['result'] == 'success' && $params['from'] == 'notify') {
                if ($data['paytype'] == 1 || $data['paytype'] == 2 || $data['paytype'] == 4) { //在线，余额支付
                    $data['ispay'] = 1;
                    $data['paytime'] = TIMESTAMP;
                    if ($store['is_auto_confirm'] == 1 && $order['status'] == 0) {
                        $data['status'] = 1;
                    }
                    pdo_update($this->table_order, $data, array('id' => $orderid));

                    $user = $this->getFansByOpenid($order['from_user']);
                    $touser = empty($user['nickname']) ? $user['from_user'] : $user['nickname'];
                    $this->addOrderLog($orderid, $touser, 1, 1, 2);
                }
//                file_put_contents(IA_ROOT . "/addons/weisrc_dish/params.log", var_export($params, true) . PHP_EOL, FILE_APPEND);
                if ($params['paysys'] != 'payu' && $params['paysys'] != 'bm_payms' && $params['paysys'] != 'jxkj_unipay') {
                    if ($params['type'] == 'alipay') {
                        if (empty($params['transaction_id'])) {
                            return false;
                        }
                    }
                    if ($params['type'] == 'wechat') {
                        if (empty($params['tag']['transaction_id'])) {
                            return false;
                        }
                    }
                }

                if ($order['dining_mode'] == 7) {
                    $this->setStoreCard($orderid);
                }
                if ($order['dining_mode'] == 8) { //门店卡充值
                    $this->setStoreCardCoin($orderid);
                }
                if ($order['dining_mode'] == 9) {
                    $this->setCard($orderid);
                }

                if ($order['dining_mode'] == 6) { //充值
                    $status = $this->setFansCoin($order['from_user'], $order['totalprice'], "订单编号{$orderid}充值");
                    $this->addRechargePrice($orderid);
                    pdo_update($this->table_order, array('status' => 3), array('id' => $orderid));
                }

                if ($params['type'] == 'credit') {
                    pdo_update($this->table_order, array('istpl' => 1), array('id' => $orderid));
                }

                if ($order['dining_mode'] != 6) {
                    if ($order['isprint'] == 0) {
                        $this->_feiyinSendFreeMessage($orderid); //飞印
                        $this->_365SendFreeMessage($orderid); //365打印机
                        $this->_365lblSendFreeMessage($orderid); //365打印机
                        $this->_feieSendFreeMessage($orderid); //飞鹅
                        $this->_yilianyunSendFreeMessage($orderid); //易联云
                        $this->_jinyunSendFreeMessage($orderid);
                    }

                    $order = $this->getOrderById($orderid);
                    //用户
                    $this->sendOrderNotice($order, $store, $setting);
                    //管理
                    if (!empty($setting)) {
                        //平台提醒
                        if ($setting['is_notice'] == 1) {
                            if (!empty($setting['tpluser'])) {
                                $tousers = explode(',', $setting['tpluser']);
                                foreach ($tousers as $key => $value) {
                                    $this->sendAdminOrderNotice($orderid, $value, $setting);
                                }
                            }
                            if (!empty($setting['email']) && !empty($setting['email_user']) && !empty($setting['email_pwd'])) {
//                                $this->sendAdminOrderEmail($setting['email'], $order, $store, $goods_str);
                            }
                            if (!empty($setting['sms_mobile']) && !empty($setting['sms_username']) && !empty($setting['sms_pwd'])) {
                                $this->sendAdminOrderSms($setting['sms_mobile'], $order);
                            }
                        }

                        //门店提醒
                        $accounts = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND storeid=:storeid AND status=2 AND is_notice_order=1 ORDER BY id
DESC ", array(':weid' => $this->_weid, ':storeid' => $storeid));
                        foreach ($accounts as $key => $value) {
                            if (!empty($value['from_user'])) {
                                $this->sendAdminOrderNotice($orderid, $value['from_user'], $setting);
                            }
                            if (!empty($value['email']) && !empty($setting['email_user']) && !empty($setting['email_pwd'])) {
//                                $this->sendAdminOrderEmail($value['email'], $order, $store, $goods_str);
                            }
                            if (!empty($value['mobile']) && !empty($setting['sms_username']) && !empty($setting['sms_pwd'])) {
                                $smsStatus = $this->sendAdminOrderSms($value['mobile'], $order);
                            }
                        }
                    }

                    if ($order['dining_mode'] == 2 && $setting['delivery_mode'] != 1) {
                        //外卖订单,通知配送
                        if ($store['is_sys_delivery'] == 1) {
                            if ($setting['delivery_mode'] == 2) { //所有配送员
                                $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 AND (storeid=0 OR
storeid={$storeid}) ORDER BY id DESC ", array(':weid' => $this->_weid));
                                foreach ($deliverys as $key => $value) {
                                    $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                                }
                            } else if ($setting['delivery_mode'] == 3) { //区域配送员
                                $area = $this->getNearDeliveryArea($order['lat'], $order['lng']);
                                $areaid = intval($area['id']);
                                if ($areaid != 0) {
                                    $strwhere = " AND areaid={$areaid} AND (storeid=0 OR
storeid={$storeid}) ";
                                    $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 {$strwhere} ORDER BY id DESC ", array(':weid' => $this->_weid));
                                    foreach ($deliverys as $key => $value) {
                                        $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                                    }
                                }
                            }
                        } else {
                            $strwhere = "  AND storeid={$storeid}";
                            $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 {$strwhere} ORDER BY id DESC ", array(':weid' => $this->_weid));
                            foreach ($deliverys as $key => $value) {
                                $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                            }
                        }
                    }
                }
                $this->sendfengniao($order, $store, $setting);
                pdo_update($this->table_order, array('istpl' => 1), array('id' => $orderid));
//                }
            }

            //前台通知
            if ($params['from'] == 'return') {
                if ($order['istpl'] == 0 && $params['type'] == 'delivery') {
                    $data['istpl'] = 1;//
                    if ($data['paytype'] == 3) { //现金
                        if ($store['is_order_autoconfirm'] == 1 && $order['status'] == 0) {
                            $data['status'] = 1;
                        }
                    }

                    pdo_update($this->table_order, $data, array('id' => $orderid));
                    $this->_feiyinSendFreeMessage($orderid);
                    $this->_365SendFreeMessage($orderid);
                    $this->_365lblSendFreeMessage($orderid); //365打印机
                    $this->_feieSendFreeMessage($orderid);
                    $this->_yilianyunSendFreeMessage($orderid);
                    $this->_jinyunSendFreeMessage($orderid);

                    $this->sendfengniao($order, $store, $setting);

                    $order = $this->getOrderById($orderid);
                    //用户
                    $this->sendOrderNotice($order, $store, $setting);
                    //管理
                    if (!empty($setting)) {
                        //平台提醒
                        if ($setting['is_notice'] == 1) {
                            if (!empty($setting['tpluser'])) {
                                $tousers = explode(',', $setting['tpluser']);
                                foreach ($tousers as $key => $value) {
                                    $this->sendAdminOrderNotice($orderid, $value, $setting);
                                }
                            }
                            if (!empty($setting['email'])) {
//                                $this->sendAdminOrderEmail($setting['email'], $order, $store, $goods_str);
                            }
                            if (!empty($setting['sms_mobile'])) {
                                $smsStatus = $this->sendAdminOrderSms($setting['sms_mobile'], $order);
                            }
                        }
                        //门店提醒
                        $accounts = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND storeid=:storeid AND status=2 AND is_notice_order=1 ORDER BY id DESC ", array(':weid' => $this->_weid, ':storeid' => $storeid));
                        foreach ($accounts as $key => $value) {
                            if (!empty($value['from_user'])) {
                                $this->sendAdminOrderNotice($orderid, $value['from_user'], $setting);
                            }
                            if (!empty($value['email'])) {
//                                $this->sendAdminOrderEmail($value['email'], $order, $store, $goods_str);
                            }
                            if (!empty($value['mobile'])) {
                                $smsStatus = $this->sendAdminOrderSms($value['mobile'], $order);
                            }
                        }
                    }

                    if ($order['dining_mode'] == 2 && $setting['delivery_mode'] != 1) { //外卖
                        $strwhere = '';
                        if ($setting['delivery_mode'] == 2) { //所有配送员
                            $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 ORDER BY id DESC ", array(':weid' => $this->_weid));
                            foreach ($deliverys as $key => $value) {
                                $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                            }
                        } else if ($setting['delivery_mode'] == 3) { //区域配送员
                            $fans = $this->getFansByOpenid($order['from_user']);
                            $area = $this->getNearDeliveryArea($order['lat'], $order['lng']);
                            $areaid = intval($area['id']);
                            if ($areaid != 0) {
                                $strwhere = " WHERE weid =:weid AND areaid=:areaid AND role=4 AND status=2 ";
                                $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " {$strwhere} ORDER BY id DESC ", array(':weid' => $this->_weid, ':areaid' => $areaid));
                                foreach ($deliverys as $key => $value) {
                                    $this->sendDeliveryOrderNotice($orderid, $value['from_user'], $setting);
                                }
                            }
                        }
                    }
                }
            }
        }

        $tip_msg = '支付成功';
        if ($params['type'] == 'delivery') {
            $tip_msg = '下单成功';
        }

        $setting = uni_setting($_W['uniacid'], array('creditbehaviors'));
        $credit = $setting['creditbehaviors']['currency'];

        $url = '../../app/' . $this->createMobileUrl('orderdetail', array('orderid' => $orderid));
        if ($order['dining_mode'] == 6) {
            $tip_msg = '充值成功';
            $url = '../../app/' . $this->createMobileUrl('usercenter', array());
        }

        if ($params['type'] == $credit) {

            if ($params['type'] == 'baifubao') {
                message($tip_msg, '../../app/' . $this->createMobileUrl('orderdetail', array('orderid' => $orderid), true), 'success');
            } else {
                message($tip_msg, $this->createMobileUrl('orderdetail', array('orderid' => $orderid), true), 'success');
            }
        } else {

            if ($params['paysys'] == 'payu' || $params['paysys'] == 'bm_payms' || $params['paysys'] == 'jxkj_unipay') {
                Header("Location: {$url}");
            } else {
                message($tip_msg, $url, 'success');
            }
        }
    }

    public function getNearDeliveryArea($lat, $lng)
    {
        $weid = $this->_weid;

        $strwhere = " WHERE weid=:weid ";
        $strorder = " ORDER BY dist ";

        $area = pdo_fetch("SELECT *,(lat-:lat) * (lat-:lat) + (lng-:lng) * (lng-:lng) as dist FROM " . tablename($this->table_deliveryarea) . " {$strwhere} {$strorder} LIMIT 1", array(':weid' => $weid, ':lat' => $lat, ':lng' => $lng));

        return $area;
    }

    public function getNearSchool($lat, $lng)
    {
        $strwhere = " WHERE weid=:weid ";
        $strorder = " ORDER BY dist ";
        $area = pdo_fetch("SELECT *,(lat-:lat) * (lat-:lat) + (lng-:lng) * (lng-:lng) as dist FROM " . tablename('weisrc_dish_school') . " {$strwhere} {$strorder} LIMIT 1", array(':weid' => $this->_weid, ':lat' => $lat, ':lng' => $lng));
        return $area;
    }

    public function sendOrderEmail($order, $store, $goods_str)
    {
        $firstArr = array(
            '-1' => '已经取消',
            '0' => '已经提交',
            '1' => '已经确认',
            '2' => '已并台',
            '3' => '已经完成'
        );

        $orderStatus = array(
            '-1' => '已取消',
            '0' => '待处理',
            '1' => '已确认',
            '2' => '已并台',
            '3' => '已完成'
        );
        $paytype = array(
            '0' => '现金付款',
            '1' => '余额支付',
            '2' => '微信支付',
            '3' => '现金付款',
            '4' => '支付宝'
        );

        //发送邮件提醒
        $emailSetting = pdo_fetch("SELECT * FROM " . tablename($this->table_setting) . " WHERE weid=:weid AND storeid=:storeid LIMIT 1", array(':weid' => $order['weid'], ':storeid' => $order['storeid']));

        $keyword1 = $order['ordersn'];
        $keyword2 = $orderStatus[$order['status']];
        $keyword3 = date("Y-m-d H:i", $order['dateline']);

        $email_tpl = "
        您的订单{$order['ordersn']}{$firstArr[$order['status']]}<br/>
        订单号：{$keyword1}<br/>
        订单状态：{$keyword2}<br/>
        时间：{$keyword3}<br/>
        门店名称：{$store['title']}<br/>
        支付方式：{$paytype[$order['paytype']]}<br/>
        ";
        if ($order['dining_mode'] == 3) {
            $email_tpl .= "预定人信息：{$order['username']}－{$order['tel']}<br/>";
            $email_tpl .= "预定时间：{$order['meal_time']}<br/>";
        } else {
            $email_tpl .= "联系方式：{$order['username']}－{$order['tel']}<br/>";
        }
        if ($order['dining_mode'] == 1) {
            $tablename = $this->getTableName($order['tables']);
            $email_tpl .= "桌台信息：{$tablename}<br/>";
        }
        if ($order['dining_mode'] == 2) {
            if (!empty($order['address'])) {
                $email_tpl .= "配送地址：{$order['address']}<br/>";
            }
            if (!empty($order['meal_time'])) {
                $email_tpl .= "配送时间：{$order['meal_time']}<br/>";
            }
        }
        $email_tpl .= "菜单：{$goods_str}<br/>";
        $email_tpl .= "备注：{$order['remark']}<br/>";
        $email_tpl .= "应收合计：{$order['totalprice']}";

        if (!empty($emailSetting) && !empty($emailSetting['email'])) {
            if ($emailSetting['email_host'] == 'smtp.qq.com' || $emailSetting['email_host'] == 'smtp.gmail.com') {
                $secure = 'ssl';
                $port = '465';
            } else {
                $secure = 'tls';
                $port = '25';
            }

            $mail_config = array();
            $mail_config['host'] = $emailSetting['email_host'];
            $mail_config['secure'] = $secure;
            $mail_config['port'] = $port;
            $mail_config['username'] = $emailSetting['email_user'];
            $mail_config['sendmail'] = $emailSetting['email_send'];
            $mail_config['password'] = $emailSetting['email_pwd'];
            $mail_config['mailaddress'] = $emailSetting['email'];
            $mail_config['subject'] = '订单提醒';
            $mail_config['body'] = $email_tpl;
            $result = $this->sendmail($mail_config);
        }
    }

    public function showTip($msg, $code = 0)
    {
        $result['code'] = $code;
        $result['msg'] = $msg;
        message($result, '', 'ajax');
    }

    public function showMsg($msg, $status = 0)
    {
        $result = array('msg' => $msg, 'status' => $status);
        echo json_encode($result);
        exit();
    }

    public function doMobileAjaxdelete()
    {
        global $_GPC;
        $delurl = $_GPC['pic'];
        load()->func('file');
        if (file_delete($delurl)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function img_url($img = '')
    {
        global $_W;
        if (empty($img)) {
            return "";
        }
        if (substr($img, 0, 6) == 'avatar') {
            return $_W['siteroot'] . "resource/image/avatar/" . $img;
        }
        if (substr($img, 0, 8) == './themes') {
            return $_W['siteroot'] . $img;
        }
        if (substr($img, 0, 1) == '.') {
            return $_W['siteroot'] . substr($img, 2);
        }
        if (substr($img, 0, 5) == 'http:') {
            return $img;
        }
        return $_W['attachurl'] . $img;
    }

    //发送短信
    public function _sendSms($sendinfo)
    {
        global $_W;
        load()->func('communication');
        $weid = $_W['uniacid'];
        $username = $sendinfo['username'];
        $pwd = $sendinfo['pwd'];
        $mobile = $sendinfo['mobile'];
        $content = $sendinfo['content'];
//        $target = "http://www.dxton.com/webservice/sms.asmx/Submit";
        $target = "http://sms.106jiekou.com/utf8/sms.aspx";
        //替换成自己的测试账号,参数顺序和wenservice对应
        $post_data = "account=" . $username . "&password=" . $pwd . "&mobile=" . $mobile . "&content=" . rawurlencode($content);
        //请自己解析$gets字符串并实现自己的逻辑
        //<result>100</result>表示成功,其它的参考文档
//        $this->showMsg($username . '|' . $pwd);
        $result = $this->smsPost($post_data, $target);
//        $xml = simplexml_load_string($result['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
//        $result = (string) $xml->result;
//        $message = (string) $xml->message;
        return $result;
    }

    public function smsPost($curlPost, $url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

    public function sendmail($config)
    {
        require_once 'plugin/email/class.phpmailer.php';
        $mail = new PHPMailer();
        $mail->CharSet = "utf-8";
        $body = $config['body'];
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = $config['secure']; // sets the prefix to the servier
        $mail->Host = $config['host']; // sets the SMTP server
        $mail->Port = $config['port'];
        $mail->Username = $config['sendmail']; // 发件邮箱用户名
        $mail->Password = $config['password']; // 发件邮箱密码
        $mail->From = $config['sendmail']; //发件邮箱
        $mail->FromName = $config['username']; //发件人名称
        $mail->Subject = $config['subject']; //主题
        $mail->WordWrap = 50; // set word wrap
        $mail->MsgHTML($body);
        $mail->AddAddress($config['mailaddress'], ''); //收件人地址、名称
        $mail->IsHTML(true); // send as HTML
        if (!$mail->Send()) {
            $status = 0;
        } else {
            $status = 1;
        }
        return $status;
    }

    public function doMobileValidatecheckcode()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $from_user = $_GPC['from_user'];
        $this->_fromuser = $from_user;
        $mobile = trim($_GPC['mobile']);
        $checkcode = trim($_GPC['checkcode']);

        if (empty($mobile)) {
            $this->showMsg('请输入手机号码!');
        }

        if (empty($checkcode)) {
            $this->showMsg('请输入验证码!');
        }

        $item = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_sms_checkcode') . " WHERE weid = :weid  AND from_user=:from_user AND checkcode=:checkcode ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':from_user' => $from_user, ':checkcode' => $checkcode));

        if (empty($item)) {
            $this->showMsg('验证码输入错误!');
        } else {
            pdo_update('weisrc_dish_sms_checkcode', array('status' => 1), array('id' => $item['id']));
            pdo_update($this->table_fans, array('mobile' => $item['mobile']), array('from_user' => $item['from_user'], 'weid' => $weid));
        }

        $this->showMsg('验证成功!', 1);
    }

    public function doMobileAddQrcodeFood()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $storeid = intval($_GPC['storeid']);
        $dishid = intval($_GPC['id']);
        $mode = intval($_GPC['mode']);
        $setting = $this->getSetting();
        if ($setting['auth_mode'] == 1 || empty($setting)) {
            $method = 'AddQrcodeFood';
            $host = $this->getOAuthHost();
            $authurl = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'mode' => $mode, 'id' => $dishid), true) . '&authkey=1';
            $url = $host . 'app/' . $this->createMobileUrl($method, array('storeid' => $storeid, 'mode' => $mode, 'id' => $dishid), true);
            if (isset($_COOKIE[$this->_auth2_openid])) {
                $from_user = $_COOKIE[$this->_auth2_openid];
                $nickname = $_COOKIE[$this->_auth2_nickname];
                $headimgurl = $_COOKIE[$this->_auth2_headimgurl];
            } else {
                if (isset($_GPC['code'])) {
                    $userinfo = $this->oauth2($authurl);
                    if (!empty($userinfo)) {
                        $from_user = $userinfo["openid"];
                        $nickname = $userinfo["nickname"];
                        $headimgurl = $userinfo["headimgurl"];
                    } else {
                        message('授权失败!');
                    }
                } else {
                    if (!empty($this->_appsecret)) {
                        $this->getCode($url);
                    }
                }
            }
        } else {
            load()->model('mc');
            if (empty($_W['fans']['nickname'])) {
                mc_oauth_userinfo();
            }
            $from_user = $_W['fans']['openid'];
            $nickname = $_W['fans']['nickname'];
            $headimgurl = $_W['fans']['tag']['avatar'];
        }


        $fans = $this->getFansByOpenid($from_user);
        if ($this->_accountlevel == 4) {
            if (empty($fans) && !empty($nickname)) {
                $insert = array(
                    'weid' => $weid,
                    'from_user' => $from_user,
                    'nickname' => $nickname,
                    'headimgurl' => $headimgurl,
                    'agentid' => 0,
                    'agentid2' => 0,
                    'agentid3' => 0,
                    'dateline' => TIMESTAMP
                );
                pdo_insert($this->table_fans, $insert);
            }
        } else {
            if (empty($fans) && !empty($from_user)) {
                $insert = array(
                    'weid' => $weid,
                    'from_user' => $from_user,
                    'agentid' => 0,
                    'agentid2' => 0,
                    'agentid3' => 0,
                    'dateline' => TIMESTAMP
                );
                pdo_insert($this->table_fans, $insert);
            }
        }
        $fans = $this->getFansByOpenid($from_user);
        $total = 1; //更新数量
        $optype = 'add';
        $jumpurl = $host . 'app/' . $this->createMobileUrl('waplist', array('storeid' => $storeid, 'mode' => $mode, 'qrid' => $dishid), true);

        //查询商品是否存在
        $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE id=:id", array(":id" => $dishid));
        if (empty($goods)) {
            message('没有相关商品');
        }
        if ($goods['isoptions'] == 1) {
            message('暂时不支持多规格商品！', $jumpurl);
        }

        $nowtime = mktime(0, 0, 0);
        if ($goods['lasttime'] <= $nowtime) {
            pdo_query("UPDATE " . tablename($this->table_goods) . " SET today_counts=0,lasttime=:time WHERE id=:id", array(':id' => $dishid, ':time' => TIMESTAMP));
        }
        if (empty($optionid)) {
            $cart = pdo_fetch("SELECT * FROM " . tablename($this->table_cart) . " WHERE goodsid=:goodsid AND weid=:weid AND storeid=:storeid AND
from_user=:from_user", array(':goodsid' => $dishid, ':weid' => $weid, ':storeid' => $storeid, ':from_user' => $from_user));
        } else {
            //查询购物车有没该商品
            $cart = pdo_fetch("SELECT * FROM " . tablename($this->table_cart) . " WHERE goodsid=:goodsid AND weid=:weid AND storeid=:storeid AND
from_user=:from_user AND optionid=:optionid ", array(':goodsid' => $dishid, ':weid' => $weid, ':storeid' => $storeid, ':from_user' => $from_user, ':optionid' => $optionid));
        }

        if ($goods['counts'] == 0) {
            message('该商品已售完!');
        }
        if ($goods['counts'] > 0) {
            $count = $goods['counts'] - $goods['today_counts'];
            if ($count <= 0) {
                message('该商品已售完!', $jumpurl);
            }
            if (!empty($cart)) {
                if ($cart['total'] < $total) {
                    if ($total > $count) {
                        message('该商品已没库存!', $jumpurl);
                    }
                }
            } else {
                if ($total > $count) {
                    message('该商品已没库存!', $jumpurl);
                }
            }
        }

        $storeid = $goods['storeid'];
        $store = $this->getStoreById($storeid);
        if ($store['is_card'] == 1) {
            $iscard = $this->get_store_card($storeid, $from_user);
        } else {
            $iscard = $this->get_sys_card($from_user);
        }

        $price = floatval($goods['marketprice']);
        if ($iscard == 1 && !empty($goods['memberprice'])) {
            $price = floatval($goods['memberprice']);
        }

        $optionid = trim($_GPC['optionid']);
        $optionids = explode('_', $optionid);
        $optionprice = 0;
        $optionname = '';

        if (count($optionids) > 0) {
            $options = pdo_fetchall("SELECT * FROM " . tablename("weisrc_dish_goods_option") . "  WHERE id IN ('" . implode("','", $optionids) . "')");
            $is_first = 0;
            foreach ($options as $key => $val) {
                $optionprice = $optionprice + $val['price'];
                if ($is_first == 0) {
                    $optionname .= $val['title'];
                } else {
                    $optionname .= '+' . $val['title'];
                }
                $is_first++;
            }

        }

        $price = $price + floatval($optionprice);
        if (empty($cart)) {
            //不存在的话增加商品点击量
            pdo_query("UPDATE " . tablename($this->table_goods) . " SET subcount=subcount+1 WHERE id=:id", array(':id' => $dishid));

            $addtotal = 1;
            if ($optype == 'add') {
                $addtotal = $total;
            }

            //添加进购物车
            $data = array(
                'weid' => $weid,
                'storeid' => $goods['storeid'],
                'goodsid' => $goods['id'],
                'optionid' => $optionid,
                'optionname' => $optionname,
                'goodstype' => $goods['pcate'],
                'price' => $price,
                'packvalue' => $goods['packvalue'],
                'from_user' => $from_user,
                'total' => $addtotal
            );
            pdo_insert($this->table_cart, $data);
        } else {
            if ($optype == 'add') {
                $total = intval($cart['total']) + $total;
            }
            //更新商品在购物车中的数量
            pdo_query("UPDATE " . tablename($this->table_cart) . " SET total=:total WHERE id=:id", array(':id' => $cart['id'], ':total' => $total));
        }

        header("location:$jumpurl");
    }

    //取得短信验证码
    public function doMobileGetCheckCode()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $from_user = trim($_GPC['from_user']);
        $this->_fromuser = $from_user;
        $mobile = trim($_GPC['mobile']);
        $storeid = intval($_GPC['storeid']);


        if (!preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|147[0-9]{8
        }$/", $mobile)
        ) {
            $this->showMsg('手机号码格式不对!');
        }

        $passcheckcode = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_sms_checkcode') . " WHERE weid = :weid  AND from_user=:from_user AND status=1 ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':from_user' => $from_user));
        if (!empty($passcheckcode)) {
            $this->showMsg('发送成功!', 1);
        }

        $smsSetting = pdo_fetch("SELECT * FROM " . tablename($this->table_setting) . " WHERE weid=:weid LIMIT 1", array(':weid' => $weid));
        if (empty($smsSetting) || empty($smsSetting['sms_username']) || empty($smsSetting['sms_pwd'])) {
            $this->showMsg('商家未开启验证码!');
        }

        $checkCodeCount = pdo_fetchcolumn("SELECT count(1) FROM " . tablename('weisrc_dish_sms_checkcode') . " WHERE weid = :weid  AND from_user=:from_user ", array(':weid' => $weid, ':from_user' => $from_user));
        if ($checkCodeCount >= 3) {
            $this->showMsg('您请求的验证码已超过最大限制..' . $checkCodeCount);
        }

        //判断数据是否已经存在
        $data = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_sms_checkcode') . " WHERE weid = :weid  AND from_user=:from_user ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':from_user' => $from_user));
        if (!empty($data)) {
            if (TIMESTAMP - $data['dateline'] < 60) {
                $this->showMsg('每分钟只能获取短信一次!');
            }
        }

        //验证码
        $checkcode = random(6, 1);
        $checkcode = $this->getNewCheckCode($checkcode);
        $data = array(
            'weid' => $weid,
            'from_user' => $from_user,
            'mobile' => $mobile,
            'checkcode' => $checkcode,
            'status' => 0,
            'dateline' => TIMESTAMP
        );

        $sendInfo = array();
        $sendInfo['username'] = $smsSetting['sms_username'];
        $sendInfo['pwd'] = $smsSetting['sms_pwd'];
        $sendInfo['mobile'] = $mobile;
        $sendInfo['content'] = "您的验证码是：" . $checkcode . "。如需帮助请联系客服。";
        $return_result_code = $this->_sendSms($sendInfo);
        if ($return_result_code != '100') {
            $code_msg = $this->sms_status[$return_result_code];
            $this->showMsg($code_msg . $return_result_code);
        } else {
            pdo_insert('weisrc_dish_sms_checkcode', $data);
            $this->showMsg('发送成功!', 1);
        }
    }

    public function getNewCheckCode($checkcode)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $from_user = $this->_from_user;

        $data = pdo_fetch("SELECT checkcode FROM " . tablename('weisrc_dish_sms_checkcode') . " WHERE weid = :weid AND checkcode = :checkcode AND from_user=:from_user ORDER BY `id` DESC limit 1", array(':weid' => $weid, ':checkcode' => $checkcode, ':from_user' => $from_user));

        if (!empty($data)) {
            $checkcode = random(6, 1);
            $this->getNewCheckCode($checkcode);
        }
        return $checkcode;
    }

    //用户打印机处理订单
    private function stringformat($string, $length = 0, $isleft = true)
    {
        $substr = '';
        if ($length == 0 || $string == '') {
            return $string;
        }
        if (strlen($string) > $length) {
            for ($i = 0; $i < $length; $i++) {
                $substr = $substr . "_";
            }
            $string = $string . '%%' . $substr;
        } else {
            for ($i = strlen($string); $i < $length; $i++) {
                $substr = $substr . " ";
            }
            $string = $isleft ? ($string . $substr) : ($substr . $string);
        }
        return $string;
    }

    public function oauth2($url)
    {
        global $_GPC, $_W;
        load()->func('communication');
        $code = $_GPC['code'];
        if (empty($code)) {
            message('code获取失败.');
        }
        $token = $this->getAuthorizationCode($code);
        $from_user = $token['openid'];
        $userinfo = $this->getUserInfo($from_user);
        $sub = 1;
        if ($userinfo['subscribe'] == 0) {
            //未关注用户通过网页授权access_token
            $sub = 0;
            $authkey = intval($_GPC['authkey']);
            if ($authkey == 0) {
                $oauth2_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $this->_appid . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_userinfo&state=0#wechat_redirect";
                header("location:$oauth2_code");
            }
            $userinfo = $this->getUserInfo($from_user, $token['access_token']);
        }

        if (empty($userinfo) || !is_array($userinfo) || empty($userinfo['openid']) || empty($userinfo['nickname'])) {
            echo '<h1>获取微信公众号授权失败[无法取得userinfo], 请稍后重试！ 公众平台返回原始数据为: <br />' . $sub . $userinfo['meta'] . '<h1>';
            exit;
        }

//        $_W['fans']['tag']['nickname'];
//        $_W['fans']['tag']['headimgurl'];
//        $_W['fans']['tag']['sex'];
//        $userinfo = $_W['fans']['tag'];
//        $from_user = $_W['fans']['openid'];

        //、、、、、、、、新、、、、、睿、、、、、、、社、、、、、、、、区、、、、、、、、
        setcookie($this->_auth2_headimgurl, $userinfo['headimgurl'], time() + 3600 * 24);
        setcookie($this->_auth2_nickname, $userinfo['nickname'], time() + 3600 * 24);
        setcookie($this->_auth2_openid, $from_user, time() + 3600 * 24);
        setcookie($this->_auth2_sex, $userinfo['sex'], time() + 3600 * 24);
//        print_r($userinfo);
//        exit;
        return $userinfo;
    }

    public function getUserInfo($from_user, $ACCESS_TOKEN = '')
    {
        if ($ACCESS_TOKEN == '') {
            $ACCESS_TOKEN = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$ACCESS_TOKEN}&openid={$from_user}&lang=zh_CN";
        } else {
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$ACCESS_TOKEN}&openid={$from_user}&lang=zh_CN";
        }

        $json = ihttp_get($url);
        $userInfo = @json_decode($json['content'], true);
        return $userInfo;
    }

    public function getAuthorizationCode($code)
    {
        $oauth2_code = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->_appid}&secret={$this->_appsecret}&code={$code}&grant_type=authorization_code";
        $content = ihttp_get($oauth2_code);
        $token = @json_decode($content['content'], true);
        if (empty($token) || !is_array($token) || empty($token['access_token']) || empty($token['openid'])) {
            $oauth2_code = $this->createMobileUrl('waprestlist', array(), true);
            header("location:$oauth2_code");
//            echo '微信授权失败, 请稍后重试! 公众平台返回原始数据为: <br />' . $content['meta'] . '<h1>';
            exit;
        }
        return $token;
    }

    public function getAccessToken()
    {
        global $_W;
        $account = $_W['account'];
        if ($this->_accountlevel < 4) {
            if (!empty($this->_account)) {
                $account = $this->_account;
            }
        }
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($account['acid']);
        $access_token = $accObj->fetch_token();
        return $access_token;
    }

    public function getCode($url)
    {
        global $_W;
        $url = urlencode($url);
        $oauth2_code = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->_appid}&redirect_uri={$url}&response_type=code&scope=snsapi_base&state=0#wechat_redirect";
//        $oauth2_code = $url . "&code=1111";
        header("location:$oauth2_code");
    }

    public $actions_titles = array(
        'stores' => '门店信息',
//        'statistics' => '统计中心',
        'order' => '订单管理',
        'coupon' => '优惠券管理',
        'tables' => '餐桌管理',
        'queueorder' => '排号管理',
        'fans' => '会员管理',
        'goods' => '商品管理',
        'category' => '商品类别',
        'intelligent' => '智能推荐',
        'reservation' => '预定管理',
        'feedback' => '评论管理',
        'printsetting' => '打印机设置',
        'businesscenter' => '商户中心',
        'savewine' => '寄存管理',
    );
    public $sms_status = array(
        '100' => '发送成功',
        '101' => '验证失败',
        '102' => '手机号码格式不正确',
        '103' => '会员级别不够',
        '104' => '内容未审核',
        '105' => '内容过多',
        '106' => '账户余额不足',
        '107' => 'Ip受限',
        '108' => '手机号码发送太频繁，请换号或隔天再发',
        '109' => '帐号被锁定',
        '110' => '手机号发送频率持续过高，黑名单屏蔽数日',
        '111' => '系统升级',
    );

    public function doWebDeletemealtime()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $id = intval($_GPC['id']);
        $storeid = intval($_GPC['storeid']);

        if (empty($storeid)) {
            $url = $this->createWebUrl('stores', array('op' => 'post', 'id' => $storeid));
        }

        pdo_delete('weisrc_dish_mealtime', array('id' => $id, 'weid' => $weid));
        message('操作成功', $url, 'success');
    }

    public function doWebSetAdProperty()
    {
        global $_GPC, $_W;
        $id = intval($_GPC['id']);
        $type = $_GPC['type'];
        $data = intval($_GPC['data']);
        empty($data) ? ($data = 1) : $data = 0;
        if (!in_array($type, array('status'))) {
            die(json_encode(array("result" => 0)));
        }
        pdo_update($this->table_ad, array($type => $data), array("id" => $id, "uniacid" => $_W['uniacid']));
        die(json_encode(array("result" => 1, "data" => $data)));
    }

    //统计中心
    public function doWebStatistics()
    {
        global $_W, $_GPC, $code;
        $weid = $this->_weid;
        $returnid = $this->checkPermission();
        $action = 'statistics';
        $title = '统计中心';
        $storeid = intval($_GPC['storeid']);
        if (empty($storeid)) {
            message('请选择门店!');
        }
        $url = $this->createWebUrl($action, array('op' => 'display'));
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'display') {
            $shoptypeid = intval($_GPC['shoptypeid']);
            $areaid = intval($_GPC['areaid']);
            $keyword = trim($_GPC['keyword']);

            if (checksubmit('submit')) { //排序
                if (is_array($_GPC['displayorder'])) {
                    foreach ($_GPC['displayorder'] as $id => $val) {
                        $data = array('displayorder' => intval($_GPC['displayorder'][$id]));
                        pdo_update($this->table_stores, $data, array('id' => $id));
                    }
                }
                message('操作成功!', $url);
            }
            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
            $where = "WHERE weid = {$weid}";

            if (!empty($keyword)) {
                $where .= " AND title LIKE '%{$keyword}%'";
            }
            if ($shoptypeid != 0) {
                $where .= " AND typeid={$shoptypeid} ";
            }
            if ($areaid != 0) {
                $where .= " AND areaid={$areaid} ";
            }
            if ($returnid != 0) {
                $where .= " AND id={$returnid} ";
            }

            $storeslist = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " {$where} order by displayorder desc,id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            if (!empty($storeslist)) {
                $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_stores) . " $where");
                $pager = pagination($total, $pindex, $psize);
            }
        } elseif ($operation == 'post') {
            load()->func('tpl');
            $id = intval($_GPC['id']); //门店编号
            $reply = pdo_fetch("select * from " . tablename($this->table_stores) . " where id=:id and weid =:weid", array(':id' => $id, ':weid' => $weid));
            $timelist = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_mealtime') . " WHERE weid = :weid AND storeid=:storeid order by id", array(':weid' => $weid, ':storeid' => $id));

            if (empty($reply)) {
                $reply['begintime'] = "09:00";
                $reply['endtime'] = "18:00";
            }

            $piclist = unserialize($reply['thumb_url']);

            if (checksubmit('submit')) {
                $data = array(
                    'weid' => intval($_W['uniacid']),
                    'areaid' => intval($_GPC['area']),
                    'typeid' => intval($_GPC['type']),
                    'title' => trim($_GPC['title']),
                    'info' => trim($_GPC['info']),
                    'from_user' => trim($_GPC['from_user']),
                    'content' => trim($_GPC['content']),
                    'tel' => trim($_GPC['tel']),
                    'announce' => trim($_GPC['announce']),
                    'logo' => trim($_GPC['logo']),
                    'address' => trim($_GPC['address']),
                    'location_p' => trim($_GPC['location_p']),
                    'location_c' => trim($_GPC['location_c']),
                    'location_a' => trim($_GPC['location_a']),
                    'lng' => trim($_GPC['baidumap']['lng']),
                    'lat' => trim($_GPC['baidumap']['lat']),
                    'password' => trim($_GPC['password']),
                    'recharging_password' => trim($_GPC['recharging_password']),
                    'is_show' => intval($_GPC['is_show']),
                    'place' => trim($_GPC['place']),
                    'qq' => trim($_GPC['qq']),
                    'weixin' => trim($_GPC['weixin']),
                    'hours' => trim($_GPC['hours']),
                    'consume' => trim($_GPC['consume']),
                    'level' => intval($_GPC['level']),
                    'enable_wifi' => intval($_GPC['enable_wifi']),
                    'enable_card' => intval($_GPC['enable_card']),
                    'enable_room' => intval($_GPC['enable_room']),
                    'enable_park' => intval($_GPC['enable_park']),
                    'is_meal' => intval($_GPC['is_meal']),
                    'is_delivery' => intval($_GPC['is_delivery']),
                    'is_snack' => intval($_GPC['is_snack']),
                    'is_queue' => intval($_GPC['is_queue']),
                    'is_intelligent' => intval($_GPC['is_intelligent']),
                    'is_reservation' => intval($_GPC['is_reservation']),
                    'is_sms' => intval($_GPC['is_sms']),
                    'is_hot' => intval($_GPC['is_hot']),
                    'btn_reservation' => trim($_GPC['btn_reservation']),
                    'btn_eat' => trim($_GPC['btn_eat']),
                    'btn_delivery' => trim($_GPC['btn_delivery']),
                    'btn_snack' => trim($_GPC['btn_snack']),
                    'btn_queue' => trim($_GPC['btn_queue']),
                    'btn_intelligent' => trim($_GPC['btn_intelligent']),
                    'coupon_title1' => trim($_GPC['coupon_title1']),
                    'coupon_title2' => trim($_GPC['coupon_title2']),
                    'coupon_title3' => trim($_GPC['coupon_title3']),
                    'coupon_link1' => trim($_GPC['coupon_link1']),
                    'coupon_link2' => trim($_GPC['coupon_link2']),
                    'coupon_link3' => trim($_GPC['coupon_link3']),
                    'sendingprice' => trim($_GPC['sendingprice']),
                    'dispatchprice' => trim($_GPC['dispatchprice']),
                    'freeprice' => trim($_GPC['freeprice']),
                    'begintime' => trim($_GPC['begintime']),
                    'endtime' => trim($_GPC['endtime']),
                    'updatetime' => TIMESTAMP,
                    'dateline' => TIMESTAMP,
                    'delivery_within_days' => intval($_GPC['delivery_within_days']),
                    'delivery_radius' => floatval($_GPC['delivery_radius']),
                    'not_in_delivery_radius' => intval($_GPC['not_in_delivery_radius'])
                );

                if (istrlen($data['title']) == 0) {
                    message('没有输入标题.', '', 'error');
                }
                if (istrlen($data['title']) > 30) {
                    message('标题不能多于30个字。', '', 'error');
                }
                if (istrlen($data['tel']) == 0) {
//                    message('没有输入联系电话.', '', 'error');
                }
                if (istrlen($data['address']) == 0) {
                    //message('请输入地址。', '', 'error');
                }

                if (is_array($_GPC['thumbs'])) {
//                    $data['thumb_url'] = serialize($_GPC['thumbs']);
                }

                if (!empty($id)) {
                    unset($data['dateline']);
                    pdo_update($this->table_stores, $data, array('id' => $id, 'weid' => $_W['uniacid']));
                } else {
                    $shoptotal = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_stores) . " WHERE weid=:weid", array(':weid' => $this->_weid));
                    if (!empty($config['storecount'])) {
                        if ($shoptotal >= $config['storecount']) {
                            message('您只能添加' . $config['storecount'] . '家门店');
                        }
                    }
                    $id = pdo_insert($this->table_stores, $data);
                }

                if (is_array($_GPC['begintimes'])) {
                    foreach ($_GPC['begintimes'] as $oid => $val) {
                        $begintime = $_GPC['begintimes'][$oid];
                        $endtime = $_GPC['endtimes'][$oid];
                        if (empty($begintime) || empty($endtime)) {
                            continue;
                        }

                        $data = array(
                            'weid' => $weid,
                            'storeid' => $id,
                            'begintime' => $begintime,
                            'endtime' => $endtime,
                        );
                        pdo_update('weisrc_dish_mealtime', $data, array('id' => $id));
                    }
                }

                //增加
                if (is_array($_GPC['newbegintime'])) {
                    foreach ($_GPC['newbegintime'] as $nid => $val) {
                        $begintime = $_GPC['newbegintime'][$nid];
                        $endtime = $_GPC['newendtime'][$nid];
                        if (empty($begintime) || empty($endtime)) {
                            continue;
                        }

                        $data = array(
                            'weid' => $weid,
                            'storeid' => $id,
                            'begintime' => $begintime,
                            'endtime' => $endtime,
                            'dateline' => TIMESTAMP
                        );
                        pdo_insert('weisrc_dish_mealtime', $data);
                    }
                }
                message('操作成功!', $url);
            }
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            $store = pdo_fetch("SELECT id FROM " . tablename($this->table_stores) . " WHERE id = '$id'");
            if (empty($store)) {
                message('抱歉，不存在或是已经被删除！', $this->createWebUrl('stores', array('op' => 'display')), 'error');
            }
            pdo_delete($this->table_stores, array('id' => $id, 'weid' => $_W['uniacid']));
            message('删除成功！', $this->createWebUrl('stores', array('op' => 'display')), 'success');
        }

        $echarts_path = $_W['siteroot'] . "/addons/weisrc_dish/template/js/dist";
        include $this->template('data');
    }

    public function updateFansFirstStore($from_user, $storeid)
    {
        global $_GPC, $_W;
        $weid = $this->_weid;
        $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user = :from_user AND weid=:weid", array(':from_user' => $from_user, ':weid' => $this->_weid));
        if (!empty($fans) && $fans['storeid'] == 0) {
            pdo_update($this->table_fans, array('storeid' => $storeid), array('id' => $fans['id']));
        }
    }

    public function updateFansData($from_user)
    {
        global $_GPC, $_W;
        $weid = $this->_weid;
        $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user = :from_user AND weid=:weid", array(':from_user' => $from_user, ':weid' => $this->_weid));
        if (!empty($fans)) {
            $count = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . "  WHERE weid = :weid AND status=3 AND from_user = :from_user", array(':weid' => $weid, ':from_user' => $from_user));
            $totalprice = pdo_fetchcolumn("SELECT sum(totalprice) FROM " . tablename($this->table_order) . "  WHERE weid = :weid AND status=3 AND from_user = :from_user", array(':weid' => $weid, ':from_user' => $from_user));
            $avgprice = pdo_fetchcolumn("SELECT AVG(totalprice) FROM " . tablename($this->table_order) . "  WHERE weid = :weid AND status=3 AND from_user = :from_user", array(':weid' => $weid, ':from_user' => $from_user));

            pdo_update($this->table_fans, array('totalprice' => $totalprice, 'avgprice' => $avgprice, 'totalcount' => $count), array('id' => $fans['id']));
        }
    }

    public function set_commission($orderid)
    {
        global $_GPC, $_W;
        $weid = $this->_weid;

        $setting = $this->getSetting();
        if ($setting['is_commission'] == 1) {
            $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $orderid, ':weid' => $this->_weid));
            if ($order) {
                $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $order['from_user'], ':weid' => $this->_weid));
                if ($fans['agentid'] > 0 || $fans['is_commission'] == 2) { //粉丝有上级或者是代理商
                    if ($fans['is_commission'] == 2 && $setting['commission_money_mode'] == 2) { //用户是代理商,商品佣金模式
                        $agent = $fans;
                    } else {
                        $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $fans['agentid'], ':weid' => $this->_weid));
                    }

                    $is_commission = 1;
                    if ($setting['commission_mode'] == 2) { //代理商模式
                        if ($agent['is_commission'] == 1) {//普通用户
                            $is_commission = 0;
                        }
                    }

                    $totalprice = floatval($order['totalprice']);
                    //1级
                    if ($agent && $is_commission == 1) {
                        $commission1_price = 0;
                        if ($setting['commission_money_mode'] == 1) { //以订单金额计算
                            $commission1_rate_max = floatval($setting['commission1_rate_max']);
                            $commission1_value_max = intval($setting['commission1_value_max']);
                            $commission1_price = $totalprice * $commission1_rate_max / 100;
                            if ($commission1_value_max > 0) {
                                if ($commission1_price > $commission1_value_max) {
                                    $commission1_price = $commission1_value_max;
                                }
                            }
                        } else { //以商品佣金计算
                            $goods = $this->get_commission_money($orderid);
                            foreach ($goods as $key => $val) {
                                $commission_money1 = floatval($val['commission_money1']) * intval($val['total']);
                                $commission_money2 = floatval($val['commission_money2']) * intval($val['total']);
                                if ($agent['agentid'] == 0) { //顶级
                                    $commission1_price = $commission1_price + $commission_money1 + $commission_money2;
                                } else {
                                    $commission1_price = $commission1_price + $commission_money1;
                                }
                            }
                        }

                        $data = array(
                            'weid' => $weid,
                            'storeid' => $order['storeid'],
                            'orderid' => $order['id'],
                            'agentid' => intval($agent['id']),//奖励上级
                            'ordersn' => $order['ordersn'],
                            'level' => 1,
                            'from_user' => $order['from_user'], //买家
                            'price' => $commission1_price,
                            'status' => $setting['commission_settlement'] == 1 ? 1 : 0,
                            'dateline' => TIMESTAMP
                        );
                        pdo_insert($this->table_commission, $data);
                        if ($setting['commission_settlement'] == 1) {
                            $this->updateFansCommission($agent['from_user'], 'commission_price', $commission1_price, "单号{$order['ordersn']}一级佣金奖励");
                            $this->sendCommissionNotice($agent['from_user'], '一级佣金奖励', $commission1_price, $order['ordersn']);
                        }
                    }
                    //2级
                    if ($setting['commission_level'] > 1) {
                        if ($agent['agentid'] > 0) {
                            $agent2 = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $agent['agentid'], ':weid' => $this->_weid));

                            $is_commission = 1;
                            if ($setting['commission_mode'] == 2) { //代理商模式
                                if ($agent2['is_commission'] == 1) {//普通用户
                                    $is_commission = 0;
                                }
                            }
                            $commission2_price = 0;
                            if ($is_commission == 1) {
                                if ($setting['commission_money_mode'] == 1) { //以订单金额计算
                                    $commission2_rate_max = floatval($setting['commission2_rate_max']);
                                    $commission2_value_max = intval($setting['commission2_value_max']);
                                    $commission2_price = $totalprice * $commission2_rate_max / 100;
                                    if ($commission2_value_max > 0) {
                                        if ($commission2_price > $commission2_value_max) {
                                            $commission2_price = $commission2_value_max;
                                        }
                                    }
                                } else {
                                    $goods = $this->get_commission_money($orderid);
                                    foreach ($goods as $key => $val) {
                                        $commission_money2 = floatval($val['commission_money2']) * intval($val['total']);
                                        $commission2_price = $commission2_price + $commission_money2;
                                    }
                                }

                                $data = array(
                                    'weid' => $weid,
                                    'storeid' => $order['storeid'],
                                    'orderid' => $order['id'],
                                    'agentid' => intval($agent2['id']),//奖励上级用户
                                    'ordersn' => $order['ordersn'],
                                    'level' => 2,
                                    'from_user' => $order['from_user'], //买家
                                    'price' => $commission2_price,
                                    'status' => $setting['commission_settlement'] == 1 ? 1 : 0,
                                    'dateline' => TIMESTAMP
                                );
                                pdo_insert($this->table_commission, $data);
                                if ($setting['commission_settlement'] == 1) {
                                    $this->updateFansCommission($agent2['from_user'], 'commission_price', $commission2_price, "单号{$order['ordersn']}二级佣金奖励");
                                    $this->sendCommissionNotice($agent2['from_user'], '二级佣金奖励', $commission2_price, $order['ordersn']);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function sendCommissionNotice($from_user, $title, $price, $ordersn)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $setting = $this->getSetting();

        $url = $_W['siteroot'] . 'app' . str_replace('./', '/', $this->createMobileUrl('usercenter', array(), true));
        if (!empty($setting['tplmission'])) {
            $templateid = $setting['tplmission'];
            $first = "您获得了一笔新的佣金";
            $remark = "订单号:" . $ordersn;
            $remark .= "\n奖励类型:" . $title;

            $content = array(
                'first' => array(
                    'value' => $first,
                    'color' => '#a6a6a9'
                ),
                'keyword1' => array(
                    'value' => $price,
                    'color' => '#a6a6a9'
                ),
                'keyword2' => array(
                    'value' => date('Y-m-d H:i:s'),
                    'color' => '#a6a6a9'
                ),
                'remark' => array(
                    'value' => $remark,
                    'color' => '#a6a6a9'
                ),
            );


            $templateMessage = new templateMessage();
            $templateMessage->send_template_message($from_user, $templateid, $content, '', $url);
        }
    }

    public function updateFansCommission($from_user, $credittype, $price, $log)
    {
        global $_GPC, $_W;
        $weid = $this->_weid;

        $price = floatval($price);
        if (empty($price)) {
            return true;
        }

        $value = pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename($this->table_fans) . " WHERE `from_user` = :from_user AND weid=:weid", array(':from_user' => $from_user, ':weid' => $weid));

        if ($price > 0 || ($value + $price >= 0)) {
            pdo_update($this->table_fans, array($credittype => $value + $price), array('from_user' => $from_user, 'weid' => $weid));
        } else {
            return error('-1', "积分类型为“{$credittype}”的积分不够，无法操作。");
        }

        $data = array(
            'weid' => $_W['uniacid'],
            'from_user' => $from_user,
            'credittype' => $credittype,
            'num' => $price,
            'dateline' => TIMESTAMP,
            'operator' => '',
            'remark' => $log,
        );
        pdo_insert('weisrc_dish_credits_record', $data);
    }

    public function get_commission_money($orderid)
    {
        $goods = pdo_fetchall("SELECT a.goodsid,a.total,b.commission_money1,b.commission_money2 FROM " . tablename($this->table_order_goods) . " a INNER JOIN
" . tablename($this->table_goods) . " b ON a.goodsid=b.id WHERE a.orderid = :orderid", array(':orderid' => $orderid));
        return $goods;
    }

    public function doMobileGetQrcode()
    {
        global $_W, $_GPC;
        $url = $_GPC['url'];
        require(IA_ROOT . '/framework/library/qrcode/phpqrcode.php');
        $errorCorrectionLevel = "L";
        $matrixPointSize = "5";
        QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize);
        exit();
    }

    public function doWebGetQrcode()
    {
        global $_W, $_GPC;
        $url = $_GPC['url'];
        require(IA_ROOT . '/framework/library/qrcode/phpqrcode.php');
        $errorCorrectionLevel = "L";
        $matrixPointSize = "5";
        QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize);
        exit();
    }

    //卡号码
    public function get_save_number($weid)
    {
        global $_W, $_GPC;
        $save_number = pdo_fetch("select savenumber from " . tablename($this->table_savewine_log) . " where weid =:weid order by id desc limit 1", array(':weid' => $weid));
        if (!empty($save_number)) {
            return intval($save_number['savenumber']) + 1;
        } else {
            return 1000001;
        }
    }

    public function doWebCheckOrder()
    {
        global $_W, $_GPC;
        $setting = $this->getSetting();

        if ($setting['is_speaker'] == 1) {
            $is_speaker = 1;
            $storeid = intval($_GPC['storeid']);
            if ($storeid == 0) {
                $strwhere = " WHERE weid=:weid AND status=0 ";
                $param = array(':weid' => $this->_weid);
            } else {
                $store = $this->getStoreById($storeid);
                if ($store['is_speaker'] == 1) {
                    $strwhere = " WHERE weid=:weid AND status=0 AND storeid=:storeid ";
                    $param = array(':weid' => $this->_weid, ':storeid' => $storeid);
                } else {
                    $is_speaker = 0;
                }
            }

            if ($is_speaker == 1) {
                $service = pdo_fetch("SELECT * FROM " . tablename($this->table_service_log) . " {$strwhere} ORDER BY id DESC LIMIT 1", $param);
                if ($service) {
//                    if (!empty($service['content'])) {
//
//                    }
                    switch($service['type']) {
                        case 1 :
                            return 'audio/order.mp3';
                            break;
                        case 2 :
                            return 'audio/fuwuyuan.mp3';
                            break;
                        case 3 :
                            return 'audio/dabao.mp3';
                            break;
                        case 4 :
                            return 'audio/order.mp3';
                            break;
                    }
                }
            }
        }
    }

    public function doMobileCheckOrder()
    {
        global $_W, $_GPC;
        $setting = $this->getSetting();
        if ($setting['is_speaker'] == 1) {
            $storeid = intval($_GPC['storeid']);
            if ($storeid == 0) {
                $service = pdo_fetch("SELECT content FROM " . tablename($this->table_service_log) . " WHERE weid=:weid AND status=0 ORDER BY id DESC LIMIT 1", array(':weid' => $this->_weid));
            } else {
                $service = pdo_fetch("SELECT content FROM " . tablename($this->table_service_log) . " WHERE weid=:weid AND status=0 AND storeid=:storeid ORDER BY id DESC LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid));
            }

            if ($service) {
                if (!empty($service['content'])) {
                    exit($service['content']);
                }
            }
        }
    }

    public function doWebCheckDeliveryOrder()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $setting = $this->getSetting();
        $limittime = intval($setting['delivery_auto_time']);//定时推送
        if ($limittime > 0) {
            $strwhere = " WHERE weid=:weid AND paytype<>0 AND delivery_status=0 AND delivery_notice=0 AND status<>-1 AND status<>3 AND dining_mode=2 AND   unix_timestamp(now())-dateline>{$limittime}  ";

            $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " {$strwhere} ORDER BY
id LIMIT 1 ", array(':weid' => $weid));
            if (!empty($order)) {
                pdo_update($this->table_order, array('delivery_notice' => 1), array('id' => $order['id']));

                $deliverys = pdo_fetchall("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND role=4 AND status=2 ORDER BY id DESC ", array(':weid' => $this->_weid));
                foreach ($deliverys as $key => $value) {
                    $this->sendDeliveryOrderNotice($order['id'], $value['from_user'], $setting, 1);
                }

            }
        }

        $delivery_finish_time = intval($setting['delivery_finish_time']);//定时完成
        if ($delivery_finish_time > 0) {
            $strwhere = " WHERE weid = '{$weid}' AND dining_mode=2 AND status<>3 AND status<>-1 AND delivery_finish_time<>0 ";
            $strwhere .= " AND delivery_status=2 ";
            $strwhere .= "  AND unix_timestamp(now())-delivery_finish_time>{$delivery_finish_time} ";
            $orderlist = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " {$strwhere} ORDER BY id DESC LIMIT 200");
            foreach ($orderlist as $key => $value) {
                if ($value['isfinish'] == 0) {
                    //计算积分
                    $this->setOrderCredit($value['id']);
                    pdo_update($this->table_order, array('isfinish' => 1), array('id' => $value['id']));
                    $this->set_commission($value['id']);
                    //奖励配送员
                    $delivery_money = floatval($value['delivery_money']);//配送佣金
                    $delivery_id = intval($value['delivery_id']);//配送员
//                    if ($delivery_money > 0) {
//                        $deliveryuser = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " where weid=:weid AND id=:id LIMIT 1", array(':weid' => $weid, ':id' => $delivery_id));
//                        if (!empty($deliveryuser)) {
//                            $this->updateFansCommission($deliveryuser['from_user'], 'delivery_price', $delivery_money, "单号{$value['ordersn']}配送佣金奖励");
//                        }
//                    }
                    if ($delivery_money > 0) {
                        $data = array(
                            'weid' => $_W['uniacid'],
                            'storeid' => $value['storeid'],
                            'orderid' => $value['id'],
                            'delivery_id' => $delivery_id,
                            'price' => $delivery_money,
                            'dateline' => TIMESTAMP,
                            'status' => 0
                        );
                        pdo_insert("weisrc_dish_delivery_record", $data);
                    }

                    pdo_update($this->table_order, array('status' => 3, 'finishtime' => TIMESTAMP), array('id' => $value['id'], 'weid' => $weid));
                    $this->addOrderLog($value['id'], $_W['user']['username'], 2, 2, 4);
                    $this->updateFansData($value['from_user']);
                    $this->updateFansFirstStore($value['from_user'], $value['storeid']);
                    $value = $this->getOrderById($value['id']);
                    $store = $this->getStoreById($value['storeid']);
                    $this->sendOrderNotice($value, $store, $setting);
                }
            }
        }
    }

    public function doWebOperatorNotice()
    {
        global $_W, $_GPC;
        $storeid = intval($_GPC['storeid']);
        $returnid = $this->checkPermission($storeid);

        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'new';
        if ($storeid == 0) {
            $service = pdo_fetch("SELECT * FROM " . tablename($this->table_service_log) . " WHERE weid=:weid AND status=0 ORDER by id DESC LIMIT 1", array(':weid' => $this->_weid));
            if ($operation == 'new') {
                pdo_update($this->table_service_log, array('status' => 1), array('id' => $service['id']));
            }
            if ($operation == 'all') {
                pdo_update($this->table_service_log, array('status' => 1), array('weid' => $this->_weid));
            }
            message('操作成功！', $this->createWebUrl('allorder', array('op' => 'display', 'storeid' => $storeid)), 'success');
        } else {
            $service = pdo_fetch("SELECT * FROM " . tablename($this->table_service_log) . " WHERE weid=:weid AND status=0 AND storeid=:storeid ORDER by id DESC LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid));
            if ($operation == 'new') {
                pdo_update($this->table_service_log, array('status' => 1), array('id' => $service['id']));
            }
            if ($operation == 'all') {
                pdo_update($this->table_service_log, array('status' => 1), array('weid' => $this->_weid, 'storeid' => $storeid));
            }
            message('操作成功！', $this->createWebUrl('order', array('op' => 'display', 'storeid' => $storeid)), 'success');
        }
    }

    public function getOrderPrice($goodsprice, $order)
    {
        //订单价 = 商品价格 + 茶位费 + 服务费 + 配送费 + 打包费
        $newtotalprice = $goodsprice + floatval($order['tea_money']) + floatval($order['service_money']) + floatval($order['dispatchprice']) + floatval($order['packvalue']);
        $discount_money = floatval($order['discount_money']);//抵扣金额
        $newlimitpricevalue = floatval($order['newlimitpricevalue']);
        $oldlimitpricevalue = floatval($order['oldlimitpricevalue']);
        //订单价 (减去抵扣金额-新用户满减-老用户满减)
        $totalprice = $newtotalprice - $discount_money - $newlimitpricevalue - $oldlimitpricevalue;
        return $totalprice;
    }

    public function doMobilePayTip()
    {
        global $_W, $_GPC;
        $orderid = intval($_GPC['orderid']);
        $url = $this->createMobileUrl('pay', array('orderid' => $orderid), true);
        message('订单创建，等待付款', $url, 'success');
    }

    //设置会员金额
    public function setFansCoin($from_user, $credit2, $remark)
    {
        load()->model('mc');
        load()->func('compat.biz');
        $uid = mc_openid2uid($from_user);
        $fans = mc_fetch($uid, array("credit2"));
        if (!empty($fans)) {
            $uid = intval($fans['uid']);
            $log = array();
            $log[0] = $uid;
            $log[1] = $remark;
            return mc_credit_update($uid, 'credit2', $credit2, $log);
        }
    }

    //设置订单积分
    public function setOrderCredit($orderid, $add = true)
    {
        $setting = $this->getSetting();

        $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id=:id LIMIT 1", array(':id' => $orderid));
        if (empty($order)) {
            return false;
        }
        $credit = 0.00;

        //商品积分
        if ($setting['credit_mode'] == 1) {
            $ordergoods = pdo_fetchall("SELECT goodsid, total FROM " . tablename($this->table_order_goods) . " WHERE orderid = :orderid", array(':orderid' => $orderid));
            if (!empty($ordergoods)) {
                $sql = 'SELECT `credit` FROM ' . tablename($this->table_goods) . ' WHERE `id` = :id';
                foreach ($ordergoods as $goods) {
                    $goodsCredit = pdo_fetchcolumn($sql, array(':id' => $goods['goodsid']));
                    $credit += $goodsCredit * floatval($goods['total']);
                }
            }
        } else {
            //订单积分
            $storeid = intval($order['storeid']);
            $store = $this->getStoreById($storeid);

            if ($store['is_default_givecredit'] == 1) {
                $payx_credit = intval($setting['payx_credit']);
            } else {
                $payx_credit = intval($store['givecredit']);
            }

            //本次消费积分
            if ($payx_credit != 0) {
                $credit = floatval($order['totalprice']) * $payx_credit;
                $credit = intval($credit);
            }
        }

        $debugdata = array(
            'payx_score' => $payx_credit,
            'totalprice' => $order['totalprice'],
            'orderid' => $orderid
        );

        file_put_contents(IA_ROOT . "/addons/weisrc_dish/credit.log", var_export($debugdata, true) . PHP_EOL, FILE_APPEND);

        //增加积分
        if (!empty($credit)) {
            load()->model('mc');
            load()->func('compat.biz');
            $uid = mc_openid2uid($order['from_user']);
            $fans = fans_search($uid, array("credit1"));
            if (!empty($fans)) {
                $uid = intval($fans['uid']);
                $remark = $add == true ? '点餐积分奖励 订单ID:' . $orderid : '点餐积分扣除 订单ID:' . $orderid;
                $log = array();
                $log[0] = $uid;
                $log[1] = $remark;
                mc_credit_update($uid, 'credit1', $credit, $log);
            }
        }
        pdo_update($this->table_order, array('credit' => $credit), array('id' => $orderid));
        return true;
    }

    public function exportexcel($data = array(), $title = array(), $filename = 'report')
    {
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k] = iconv("UTF-8", "GB2312", $v);
            }
            $title = implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck] = iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key] = implode("\t", $data[$key]);
            }
            echo implode("\n", $data);
        }
    }

    public function doWebUploadExcel()
    {
        global $_GPC, $_W;

        if ($_GPC['leadExcel'] == "true") {
            $filename = $_FILES['inputExcel']['name'];
            $tmp_name = $_FILES['inputExcel']['tmp_name'];

            $flag = $this->checkUploadFileMIME($_FILES['inputExcel']);
            if ($flag == 0) {
                message('文件格式不对.');
            }

            if (empty($tmp_name)) {
                message('请选择要导入的Excel文件！');
            }

            $msg = $this->uploadFile($filename, $tmp_name, $_GPC);

            if ($msg == 1) {
                message('导入成功！', referer(), 'success');
            } else {
                message($msg, '', 'error');
            }
        }
    }

    function uploadFile($file, $filetempname, $array)
    {
        global $_GPC, $_W;

        //自己设置的上传文件存放路径
        $filePath = '../addons/weisrc_dish/upload/';
        include 'plugin/phpexcelreader/reader.php';

        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('utf-8');

        //注意设置时区
        $time = date("y-m-d-H-i-s"); //去当前上传的时间
        $extend = strrchr($file, '.');
        //上传后的文件名
        $name = $time . $extend;
        $uploadfile = $filePath . $name; //上传后的文件名地址

        if (copy($filetempname, $uploadfile)) {
            if (!file_exists($filePath)) {
                echo '文件路径不存在.';
                return;
            }
            if (!is_readable($uploadfile)) {
                echo("文件为只读,请修改文件相关权限.");
                return;
            }
            $data->read($uploadfile);
            error_reporting(E_ALL ^ E_NOTICE);
            $count = 0;

            $setting = $this->getSetting();
            $schoolid = 0;
            if ($setting['is_school'] == 1) {
                if ($_W['role'] == 'operator') { //操作员
                    $curadmin = $this->getCurAdmin();
                    if ($curadmin['role'] == 3) { //分站站长 固定分站id
                        $schoolid = intval($curadmin['schoolid']);

                    }
                }
            }

            for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { //$=2 第二行开始
                //以下注释的for循环打印excel表数据
                for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
                    //echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
                }

                $row = $data->sheets[0]['cells'][$i];
                //message($data->sheets[0]['cells'][$i][1]);

                if ($array['ac'] == "category") {
                    $count = $count + $this->upload_category($row, TIMESTAMP, $schoolid, $array);
                } else if ($array['ac'] == "goods") {
                    $count = $count + $this->upload_goods($row, TIMESTAMP, $schoolid, $array);
                } else if ($array['ac'] == "store") {
                    $count = $count + $this->upload_store($row, TIMESTAMP, $schoolid, $array);
                }
            }
        }
        if ($count == 0) {
            $msg = "导入失败,数据已经存在！";
        } else {
            $msg = 1;
        }
        return $msg;
    }

    private function checkUploadFileMIME($file)
    {
        // 1.through the file extension judgement 03 or 07
        $flag = 0;
        $file_array = explode(".", $file ["name"]);
        $file_extension = strtolower(array_pop($file_array));

        // 2.through the binary content to detect the file
        switch ($file_extension) {
            case "xls" :
                // 2003 excel
                $fh = fopen($file ["tmp_name"], "rb");
                $bin = fread($fh, 8);
                fclose($fh);
                $strinfo = @unpack("C8chars", $bin);
                $typecode = "";
                foreach ($strinfo as $num) {
                    $typecode .= dechex($num);
                }
                if ($typecode == "d0cf11e0a1b11ae1") {
                    $flag = 1;
                }
                break;
            case "xlsx" :
                // 2007 excel
                $fh = fopen($file ["tmp_name"], "rb");
                $bin = fread($fh, 4);
                fclose($fh);
                $strinfo = @unpack("C4chars", $bin);
                $typecode = "";
                foreach ($strinfo as $num) {
                    $typecode .= dechex($num);
                }
                echo $typecode . 'test';
                if ($typecode == "504b34") {
                    $flag = 1;
                }
                break;
        }
        return $flag;
    }

    function upload_goods($strs, $time, $schoolid, $array)
    {
        global $_W;
        $insert = array();

        if (empty($strs[1])) {
            return 0;
        }

        $storeid = $array['storeid'];
        $weid = $this->_weid;

        //类别
        $category = pdo_fetch("SELECT id FROM " . tablename($this->table_category) . " WHERE name=:name AND weid=:weid AND storeid=:storeid", array(':name' => trim($strs[2]), ':weid' => $weid, ':storeid' => $storeid));
        //标签
        $label = pdo_fetch("SELECT id FROM " . tablename($this->table_print_label) . " WHERE title=:title AND weid=:weid AND storeid=:storeid", array(':title' => trim($strs[12]), ':weid' => $weid, ':storeid' => $storeid));

        $insert['pcate'] = empty($category) ? 0 : intval($category['id']);
        $insert['title'] = $strs[1];
        $insert['displayorder'] = $strs[3];
        $insert['unitname'] = $strs[4];
        $insert['marketprice'] = $strs[5];
        $insert['memberprice'] = $strs[6];
        $insert['productprice'] = $strs[7];
        $insert['packvalue'] = $strs[8];
        $insert['credit'] = $strs[9];
        $insert['subcount'] = $strs[10];
        $insert['thumb'] = $strs[11];
        $insert['labelid'] = empty($label) ? 0 : intval($label['id']);
        $insert['description'] = $strs[13];
        $insert['counts'] = $strs[14];
        $insert['sales'] = $strs[15];
        $insert['dateline'] = TIMESTAMP;
        $insert['status'] = 1;
        $insert['recommend'] = 0;
        $insert['ccate'] = 0;
        $insert['deleted'] = 0;
        $insert['storeid'] = $array['storeid'];
        $insert['weid'] = $_W['uniacid'];

        $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_goods) . " WHERE title=:title AND weid=:weid AND storeid=:storeid", array(':title' => $strs[1], 'pcate' => $category['id'], ':weid' => $weid, ':storeid' => $storeid));


        if (empty($goods)) {
            $oid = pdo_insert($this->table_goods, $insert);
        } else {
            upset($insert['sales']);
            $oid = pdo_update($this->table_goods, $insert, array('id' => $goods['id']));
        }

//        pdo_debug(true);
//        exit;

        return $oid;
    }

    function upload_category($strs, $time, $schoolid, $array)
    {
        global $_W;
        if (empty($strs[1])) {
            return 0;
        }

        $storeid = $array['storeid'];
        $weid = $this->_weid;

        $insert = array();
        $insert['name'] = $strs[1];
        $insert['parentid'] = 0;
        $insert['displayorder'] = 0;
        $insert['enabled'] = 1;
        $insert['storeid'] = $array['storeid'];
        $insert['weid'] = $_W['uniacid'];

        $category = pdo_fetch("SELECT * FROM " . tablename($this->table_category) . " WHERE name=:name AND weid=:weid AND storeid=:storeid", array(':name' => $strs[1], ':weid' => $weid, ':storeid' => $storeid));

        if (empty($category)) {
            return pdo_insert($this->table_category, $insert);
        } else {
            return pdo_insert($this->table_category, $insert, array('id' => $category['id']));
        }
    }

    function upload_store($strs, $time, $schoolid, $array)
    {
        global $_W;
        $weid = $this->_weid;

        if (empty($strs[1])) {
            return 0;
        }

        //类别
        $type = pdo_fetch("SELECT id FROM " . tablename($this->table_type) . " WHERE name=:name AND weid=:weid ", array(':name' => trim($strs[2]), ':weid' => $weid));

        if (!empty($type)) {
            $typeid = $type['id'];
        } else {
            $data = array(
                'weid' => $weid,
                'name' => trim($strs[2]),
                'thumb' => '',
                'url' => '',
                'schoolid' => $schoolid,
                'displayorder' => 0,
                'parentid' => 0,
            );
            pdo_insert($this->table_type, $data);
            $typeid = pdo_insertid();
        }

        $area = pdo_fetch("SELECT id FROM " . tablename($this->table_area) . " WHERE name=:name AND weid=:weid ", array(':name' => trim($strs[3]), ':weid' => $weid));
        if (!empty($area)) {
            $areaid = $area['id'];
        } else {
            $data = array(
                'weid' => $_W['uniacid'],
                'name' => trim($strs[3]),
                'displayorder' => 0,
                'schoolid' => $schoolid,
                'parentid' => 0,
            );
            pdo_insert($this->table_area, $data);
            $areaid = pdo_insertid();
        }

        $insert = array();
        $insert['weid'] = $_W['uniacid'];
        $insert['title'] = $strs[1];
        $insert['areaid'] = $areaid;
        $insert['typeid'] = $typeid;
        $insert['level'] = intval($strs[4]);
        $insert['consume'] = $strs[5];

        $insert['info'] = $strs[6];
        $insert['logo'] = $strs[7];
        $insert['content'] = $strs[8];
        $insert['schoolid'] = $schoolid;
        $insert['tel'] = $strs[9];
        $insert['address'] = $strs[10];
        $insert['begintime'] = $strs[11];
        $insert['endtime'] = $strs[12];
        $insert['place'] = '';
        $insert['hours'] = '';
        $insert['password'] = '';
        $insert['recharging_password'] = '';
        $insert['is_show'] = 1;

        $insert['lng'] = $strs[13];
        $insert['lat'] = $strs[14];
        $insert['enable_wifi'] = 1;
        $insert['enable_card'] = 1;
        $insert['enable_room'] = 1;
        $insert['enable_park'] = 1;
        $insert['is_meal'] = 1;
        $insert['is_delivery'] = 1;
        $insert['is_snack'] = 1;
        $insert['is_queue'] = 1;

        $insert['updatetime'] = TIMESTAMP;
        $insert['dateline'] = TIMESTAMP;

        $store = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_stores') . " WHERE title=:title AND weid=:weid LIMIT 1", array(':title' => $strs[1], ':weid' => $_W['uniacid']));

        if (empty($store)) {
            return pdo_insert('weisrc_dish_stores', $insert);
        } else {
            return pdo_update('weisrc_dish_stores', $insert, array('id' => $store['id']));
        }
    }

    public function message($error, $url = '', $errno = -1)
    {
        $data = array();
        $data['errno'] = $errno;
        if (!empty($url)) {
            $data['url'] = $url;
        }
        $data['error'] = $error;
        echo json_encode($data);
        exit;
    }

    public function doMobilegetSpreadToptenOrderInfo()
    {
        global $_GPC, $_W;

        $data = array(
            '0' => array('head_path' => 'http://wx.qlogo.cn/mmopen/9Ja7zrhJ1wiaIwXvTVJmGRWZnEGibSQH3wNdRsa1mlA4jzPMnot3KeWwQ6ica6Ktbib6jHqtwjCm9UjInTKJ780MZbVicSgZl8euB/0',
                'nick_name' => '迷失卍国度', 'time' => '10秒'),
            '1' => array('head_path' => 'http://wx.qlogo.cn/mmopen/9Ja7zrhJ1wjibFGBYVvdX1fibC2agT41iaNNshRucnlibNsYw90UMBSeEbCViabReibtXjU8I8xFFibOSYmvupP5YjSB75GzGz1bTXj/0',
                'nick_name' => 'landy', 'time' => '12秒'),
            '2' => array('head_path' => 'http://wx.qlogo.cn/mmopen/aGD7McZvCePC1ib1zMudFpdcARiaZHzggKKTRhgL9AvRsZO6bLItTbrFFrBOwVPc7fAeV5BNPasVVl8rGF2Xne5DvBvTDOH2gD/0',
                'nick_name' => '晨曦', 'time' => '20秒'),
            '3' => array('head_path' => 'http://wx.qlogo.cn/mmopen/t6wsdnA9OHAtpbm5qqoTEXqDLSpfgyqK3ibnTHkaH71OopV6lS74yBrSozIB8iccQ1vGexCkKzS6OgBaPJc7c994E3nCj0q7qV/0',
                'nick_name' => '老农', 'time' => '22秒'),
            '4' => array('head_path' => 'http://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eoWh32Z5sia8BfGjzgic668ejjiawywMwHmsUrSibwic7pZfjNcuoF29bzlSmUvMVSztico4Dw7sQYV5CLg/0',
                'nick_name' => '三哥', 'time' => '25秒'),
            '5' => array('head_path' => 'http://wx.qlogo.cn/mmopen/ibyje3LZHiaXI3icaZEIRGkwh6zh5tfyiaw5x5G99aQUxM28dMjqc0Kibwy98jcX24jeqqNfMYwsOMJib1tvILjottfGu7PEGKGpLt/0',
                'nick_name' => '陆险赢', 'time' => '30秒'),
            '6' => array('head_path' => 'http://wx.qlogo.cn/mmopen/Xewa2JUmZ1oPE6RTWxcDc4RQETl3ib4UECwnY2w9E1yPvRgLx9USSayG8DrYmHbbfuDuNvnnkeBV3zqVxPtBUVGlt2qVKjI9d/0',
                'nick_name' => '海纳鹏程', 'time' => '33秒'),
            '7' => array('head_path' => 'http://wx.qlogo.cn/mmopen/9Ja7zrhJ1wjibFGBYVvdX1cVbbgvjepSX4YjXWCQOsZRnOxPibK9ia0dWno5SNN6htoh03fX2Uf2FpHESBlxQzRDia6icToD6ua2d/0',
                'nick_name' => '易波', 'time' => '40秒'),
        );
        $result = array(
            'code' => '100',
            'data' => $data
        );
        echo json_encode($result);
        exit;


//        $weid = $this->_weid;
//        $list = pdo_fetchall("SELECT b.nickname as nickname,b.headimgurl as headimgurl,a.dateline as dateline FROM " .
// tablename
//($this->table_order) . " AS a LEFT JOIN
//" . tablename($this->table_fans) . " AS b ON a
//.from_user=b
//.from_user WHERE a.weid = '{$weid}' ORDER BY a.id DESC LIMIT 10");
//
//        if ($list) {
//            $data = array();
//            foreach ($list as $key => $value) {
//                $data[] = array('head_path' => $value['headimgurl'],
//                    'nick_name' => $value['nickname'], 'time' => $value['dateline']);
//            }
//            $result = array(
//                'code' => '100',
//                'data' => $data
//            );
//            echo json_encode($result);
//            exit;
//        } else {
//            $result = array(
//                'code' => '101',
//                'data' => ''
//            );
//            echo json_encode($result);
//            exit;
//        }
    }

    //----------------------以下是接口定义实现，第三方应用可根据具体情况直接修改----------------------------
    function sendFreeMessage($msg)
    {
        $msg['reqTime'] = number_format(1000 * time(), 0, '', '');
        $content = $msg['memberCode'] . $msg['msgDetail'] . $msg['deviceNo'] . $msg['msgNo'] . $msg['reqTime'] . $this->feyin_key;
        $msg['securityCode'] = md5($content);
        $msg['mode'] = 2;

        return $this->sendMessage($msg);
    }

    function sendFormatedMessage($msgInfo)
    {
        $msgInfo['reqTime'] = number_format(1000 * time(), 0, '', '');
        $content = $msgInfo['memberCode'] . $msgInfo['customerName'] . $msgInfo['customerPhone'] . $msgInfo['customerAddress'] . $msgInfo['customerMemo'] . $msgInfo['msgDetail'] . $msgInfo['deviceNo'] . $msgInfo['msgNo'] . $msgInfo['reqTime'] . $this->feyin_key;

        $msgInfo['securityCode'] = md5($content);
        $msgInfo['mode'] = 1;

        return $this->sendMessage($msgInfo);
    }

    function sendMessage($msgInfo)
    {
        $client = new HttpClient(FEYIN_HOST, FEYIN_PORT);
        file_put_contents(IA_ROOT . "/addons/weisrc_dish/feiyin.log", var_export($msgInfo, true) . PHP_EOL, FILE_APPEND);
        if (!$client->post('/api/sendMsg', $msgInfo)) { //提交失败
            file_put_contents(IA_ROOT . "/addons/weisrc_dish/feiyin.log", 'faild' . PHP_EOL, FILE_APPEND);
            return 'faild';
        } else {
            file_put_contents(IA_ROOT . "/addons/weisrc_dish/feiyin.log", $client->getContent() . PHP_EOL, FILE_APPEND);
            return $client->getContent();
        }
    }

    function queryState($msgNo)
    {
        $now = number_format(1000 * time(), 0, '', '');
        $client = new HttpClient(FEYIN_HOST, FEYIN_PORT);
        if (!$client->get('/api/queryState?memberCode=' . $this->member_code . '&reqTime=' . $now . '&securityCode=' . md5($this->member_code . $now . $this->feyin_key . $msgNo) . '&msgNo=' . $msgNo)) { //请求失败
            return 'faild';
        } else {
            return $client->getContent();
        }
    }

    function listDevice()
    {
        $now = number_format(1000 * time(), 0, '', '');
        $client = new HttpClient(FEYIN_HOST, FEYIN_PORT);
        if (!$client->get('/api/listDevice?memberCode=' . $this->member_code . '&reqTime=' . $now . '&securityCode=' . md5($this->member_code . $now . $this->feyin_key))) { //请求失败
            return 'faild';
        } else {
            $xml = $client->getContent();
            $sxe = new SimpleXMLElement($xml);
            foreach ($sxe->device as $device) {
                $id = $device['id'];
                echo "设备编码：$id    ";

                $deviceStatus = $device->deviceStatus;
                echo "状态：$deviceStatus";
                echo '<br>';
            }
        }
    }

    function listException()
    {
        $now = number_format(1000 * time(), 0, '', '');
        $client = new HttpClient(FEYIN_HOST, FEYIN_PORT);
        if (!$client->get('/api/listException?memberCode=' . MEMBER_CODE . '&reqTime=' . $now . '&securityCode=' . md5(MEMBER_CODE . $now . $this->feyin_key))) { //请求失败
            return 'faild';
        } else {
            return $client->getContent();
        }
    }

    function feiyinstatus($code)
    {
        switch ($code) {
            case 0:
                $text = "正常";
                break;
            case -1:
                $text = "IP地址不允许";
                break;
            case -2:
                $text = "关键参数为空或请求方式不对";
                break;
            case -3:
                $text = "客户编码不对";
                break;
            case -4:
                $text = "安全校验码不正确";
                break;
            case -5:
                $text = "请求时间失效";
                break;
            case -6:
                $text = "订单内容格式不对";
                break;
            case -7:
                $text = "重复的消息";
                break;
            case -8:
                $text = "消息模式不对";
                break;
            case -9:
                $text = "服务器错误";
                break;
            case -10:
                $text = "服务器内部错误";
                break;
            case -111:
                $text = "打印终端不属于该账户";
                break;
            default:
                $text = "未知";
                break;
        }
        return $text;
    }

    //支付宝退款
    public function aliayRefund($orderid, $price)
    {
        global $_W;

        $refund_order = $this->getOrderById($orderid);
        $data = array(
            'from_user' => $refund_order['from_user'],
            'orderid' => $refund_order['id'],
            'transaction_id' => $refund_order['transid'],
            'total_fee' => $refund_order['totalprice'],
            'refund_fee' => $price,
            'status' => '0',
            'dateline' => TIMESTAMP,
        );
        pdo_insert('weisrc_dish_refund_log', $data);
        $refundid = pdo_insertid();
        if ($refundid > 0) {
            if ($refund_order['transid']) {
                $setting = uni_setting($_W['uniacid'], 'payment');
                $alipay = $setting['payment']['ali_refund'];
                $set = array();
                $set['app_id'] = $alipay['app_id'];
                $set['method'] = 'alipay.trade.refund';
                $set['charset'] = 'utf-8';
                $set['sign_type'] = 'RSA';
                $set['timestamp'] = date('Y-m-d H:i:s');
                $set['version'] = '1.0';
                $content = array('trade_no' => $refund_order['transid'], 'refund_amount' => $refund_order['price'], 'refund_reason' => '购币失败', 'out_request_no' => $refundid);
                $set['biz_content'] = json_encode($content);
                $string = 'app_id=' . $set['app_id'] . '&biz_content=' . $set['biz_content'] . "&charset=" . $set['charset'] . "&method=" . $set['method'] . "&sign_type=" . $set['sign_type'] . "&timestamp=" . $set['timestamp'] . "&version=" . $set['version'];
//                $prikeyfile = OD_ROOT . md5("alipay_{$_W['uniacid']}_key") . ".pem";
                $set['sign'] = $this->sign($string, $alipay['private_key']);
                load()->func('communication');
                $response = ihttp_get('https://openapi.alipay.com/gateway.do?' . http_build_query($set, '', '&'));
//            file_put_contents(IA_ROOT."/addons/junsion_coinsel/refund", date('Y-m-d H:i:s').$response['content']."\n",FILE_APPEND);
                $res = json_decode($response['content'], true);
                if ($res['alipay_trade_refund_response']['code'] == '10000') {
//                    pdo_update('junsion_coinsel_order', array('status' => -1), array('id' => $order['id']));

                    pdo_update('weisrc_dish_refund_log', array('status' => 1, 'refund_id' => $res['alipay_trade_refund_response']['out_trade_no']), array('id' => $refundid));

                    $totalrefundprice = $price + $refund_order['refund_price'];
                    if ($refund_order['totalprice'] == $totalrefundprice) {
                        pdo_update($this->table_order, array('ispay' => 3, 'refund_price' => $totalrefundprice), array('id' =>
                            $refund_order['id']));
                    } else {
                        $totalprice = floatval($refund_order['totalprice']) - $price;
                        pdo_update($this->table_order, array('ispay' => 2, 'refund_price' => $refund_order['refund_price'] + $price, 'totalprice' => $totalprice), array('id' => $refund_order['id']));
                    }
                    pdo_update('weisrc_dish_refund_log', array('status' => 1, 'refund_id' => $res['alipay_trade_refund_response']['out_trade_no']), array
                    ('id' => $refundid));
                } else {
                    wlog('alipayrefund_falid', $res);
                    pdo_update($this->table_order, array('ispay' => 4), array('id' => $orderid));
                    pdo_update('weisrc_dish_refund_log', array('err_code_des' => $res['alipay_trade_refund_response']['sub_msg']), array('id' => $refundid));
                }
            }

        }
    }

    public function sign($data, $priKey)
    {
//        $priKey = file_get_contents($prikeyfile);
        $res = openssl_get_privatekey($priKey);
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }

    function refund2($orderid, $price)
    {
        global $_W;
        include_once IA_ROOT . '/addons/weisrc_dish/cert/WxPay.Api.php';
        load()->model('account');
        load()->func('communication');

        $WxPayApi = new WxPayApi();
        $input = new WxPayRefund();

        $path_cert = IA_ROOT . '/addons/weisrc_dish/cert/apiclient_cert_' . $_W['uniacid'] . '.pem';
        $path_key = IA_ROOT . '/addons/weisrc_dish/cert/apiclient_key_' . $_W['uniacid'] . '.pem';
        $account_info = $_W['account'];
        $refund_order = $this->getOrderById($orderid);

        if ($refund_order['paytype'] == 2) {
            $data = array(
                'from_user' => $refund_order['from_user'],
                'orderid' => $refund_order['id'],
                'transaction_id' => $refund_order['transid'],
                'total_fee' => $refund_order['totalprice'],
                'refund_fee' => $price,
                'status' => '0',
                'dateline' => TIMESTAMP,
            );
            pdo_insert('weisrc_dish_refund_log', $data);
            $refundid = pdo_insertid();
            if ($refundid > 0) {
                $paysetting = uni_setting($_W['uniacid'], array('payment'));
                $wechatpay = $paysetting['payment']['wechat'];
                $mchid = $wechatpay['mchid'];
                $key = $wechatpay['apikey'];
                $appid = $account_info['key'];
                $fee = $refund_order['oldtotalprice'] * 100;
                $refundfee = $price * 100;
                $transid = $refund_order['transid'];
                $input->SetAppid($appid);
                $input->SetMch_id($mchid);
                $input->SetOp_user_id($mchid);
                $input->SetRefund_fee($refundfee);
                $input->SetTotal_fee($fee);
                $input->SetTransaction_id($transid);
                $input->SetOut_refund_no($refundid);
                $result = $WxPayApi->refund($input, 6, $path_cert, $path_key, $key);

                if ($result['result_code'] == 'SUCCESS') {
                    $input2 = new WxPayOrderQuery();
                    $input2->SetAppid($appid);
                    $input2->SetMch_id($mchid);
                    $input2->SetTransaction_id($transid);
                    $result2 = $WxPayApi->orderQuery($input2, 6, $key);
                    if ($result2['return_code'] == 'SUCCESS' && $result2['trade_state'] == 'REFUND') {
                        $totalrefundprice = $price + $refund_order['refund_price'];
                        if ($refund_order['totalprice'] == $totalrefundprice) {
                            pdo_update($this->table_order, array('ispay' => 3, 'refund_price' => $totalrefundprice), array('id' =>
                                $refund_order['id']));
                        } else {
                            $totalprice = floatval($refund_order['totalprice']) - $price;
                            pdo_update($this->table_order, array('ispay' => 2, 'refund_price' => $refund_order['refund_price'] + $price, 'totalprice' => $totalprice), array('id' => $refund_order['id']));
                        }
                        pdo_update('weisrc_dish_refund_log', array('status' => 1, 'refund_id' => $result['refund_id']), array
                        ('id' => $refundid));
                        return 1;
                    } else {
                        pdo_update($this->table_order, array('ispay' => 4), array('id' => $refund_order['id']));
                        return 0;
                    }
                } else {
                    wlog('refund_falid', $input);
                    pdo_update($this->table_order, array('ispay' => 4), array('id' => $orderid));
                    pdo_update('weisrc_dish_refund_log', array('err_code_des' => $result['err_code_des']), array('id' => $refundid));
                    message($result['err_code_des']);
                    return 0;
                }
            }
        } else {
            message('非微信支付!');
        }
    }

    function refund3($id, $storeid)
    {
        global $_W;
        $store = $this->getStoreById($storeid);
        $refund_order = $this->getOrderById($id);

        if ($store['is_jueqi_ymf'] == 1 && $refund_order['paytype'] == 2) {
            //需要获取的参数
            $host = $store['jueqi_host'];//本机服务器一码付的域名前缀（可能为独立域名，可能为微擎域名路径，具体看接口文档）
            $uid = 'weisrc_dish';//模块标识
            $prikey = $store['jueqi_secret'];//秘钥

            $post_data1['uid'] = $uid;
            $post_data1['orderno'] = $refund_order['transid'];

            ksort($post_data1);
            // 说明如果有汉字请使用utf-8编码
            $o = "";
            foreach ($post_data1 as $k => $v) {
                $o .= "$k=" . ($v) . "&";
            }
            $post_data1 = substr($o, 0, -1);

            $post_data_temp1 = $prikey . $post_data1;

            $signIn = strtoupper(md5($post_data_temp1));

            $url = $host . '/index.php?s=/Home/linenew/m_backpay';//接口基础url
            $url = $url . '/uid/' . $uid . '/orderno/' . $refund_order['transid'] . '/sign/' . $signIn;//带参数
            $result = json_decode(file_get_contents($url), true);

            if ($result['result'] == '0000') {
                pdo_update($this->table_order, array('ispay' => 3), array('id' => $refund_order['id']));
                return 1;
            } else {
                pdo_update($this->table_order, array('ispay' => 4), array('id' => $refund_order['id']));
                message('操作失败，原因:' . $result['desc']);
                return 0;
            }
        } else {
            message('不是微信支付或者一码付没开启.');
        }

    }

    //万容
    function refund4($id, $storeid)
    {
        global $_W;
        $store = $this->getStoreById($storeid);
        $refund_order = $this->getOrderById($id);
        if ($store['is_jxkj_unipay'] == 1 && $refund_order['paytype'] == 2) {
            $url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&tid=' . $refund_order['ordersn'] . '&ms=weisrc_dish&do=refundex&m=jxkj_unipay';
            $result = json_decode(file_get_contents($url), true);
            if ($result['result'] == '1') {
                pdo_update($this->table_order, array('ispay' => 3), array('id' => $refund_order['id']));
                return 1;
            } else {
                pdo_update($this->table_order, array('ispay' => 4), array('id' => $refund_order['id']));
                message('操作失败，原因:' . $result['desc']);
                return 0;
            }
        } else {
            message('退款失败！');
        }
        $res = $storeid . '-' . $id;
        return $res;
    }

    //预订订单是否存在
    public function doMobileExistReservationOrder()
    {
        global $_W, $_GPC;
        $storeid = intval($_GPC['storeid']);
        $tables = intval($_GPC['tables']);
        $reservation_time = trim($_GPC['meal_time']);

        $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND tables=:tables AND
meal_time=:meal_time AND dining_mode=3 AND status<>-1 AND paytype<>0 LIMIT 1", array(':weid' => $this->_weid, ':storeid' => $storeid, ':meal_time' => $reservation_time, ':tables' => $tables));
        $status = 0;
        if ($order) {
            $status = 1;
        }
        $vars['status'] = $status;
        exit(json_encode($vars));
    }

    public function sendMoney($openid, $money, $re_user_name = '', $desc, $trade_no = '')
    {
        global $_W;
        $paysetting = uni_setting($_W['uniacid'], array('payment'));
        $wechatpay = $paysetting['payment']['wechat'];
        $account_info = $_W['account'];
        $mchid = $wechatpay['mchid'];
        $key = $wechatpay['apikey'];
        $appid = $account_info['key'];

        $desc = isset($desc) ? $desc : '余额提现';
        $money = $money * 100;

        $pars = array();
        $pars['mch_appid'] = $appid;
        $pars['mchid'] = $mchid;
        $pars['nonce_str'] = random(32);
        $pars['partner_trade_no'] = empty($trade_no) ? $mchid . date('Ymd') . rand(1000000000, 9999999999) : $trade_no;
        $pars['openid'] = $openid;
        if (empty($re_user_name)) {
            $pars['check_name'] = 'NO_CHECK';
        } else {
            $pars['check_name'] = 'FORCE_CHECK';
            $pars['re_user_name'] = $re_user_name;
        }
        //NO_CHECK：不校验真实姓名
        //FORCE_CHECK：强校验真实姓名（未实名认证的用户会校验失败，无法转账）
        //OPTION_CHECK：针对已实名认证的用户才校验真实姓名（未实名认证用户不校验，可以转账成功）

        $pars['amount'] = $money;
        $pars['desc'] = $desc;
//        $pars['spbill_create_ip'] = isset($wechat['ip']) ? $wechat['ip'] : $_SERVER['SERVER_ADDR'];

        $pars['spbill_create_ip'] = gethostbyname($_SERVER["SERVER_NAME"]);
//        $pars['spbill_create_ip'] = $_SERVER['SERVER_ADDR'];

        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$key}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();

        $path_cert = IA_ROOT . '/addons/weisrc_dish/cert/apiclient_cert_' . $_W['uniacid'] . '.pem';
        $path_key = IA_ROOT . '/addons/weisrc_dish/cert/apiclient_key_' . $_W['uniacid'] . '.pem';
        $path_rootca = IA_ROOT . '/addons/weisrc_dish/cert/rootca_' . $_W['uniacid'] . '.pem';

        $extras['CURLOPT_CAINFO'] = $path_rootca;
        $extras['CURLOPT_SSLCERT'] = $path_cert;
        $extras['CURLOPT_SSLKEY'] = $path_key;

        load()->func('communication');
        $procResult = null;
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
        $response = ihttp_request($url, $xml, $extras);

        if ($response['code'] == 200) {
            $responseObj = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $responseObj = (array)$responseObj;
            $return['code'] = $responseObj['return_code'];
            $return['result_code'] = $responseObj['result_code'];
            $return['err_code'] = $responseObj['err_code'];
            $return['msg'] = $responseObj['return_msg'];
            $return['trade_no'] = $pars['partner_trade_no'];
            $return['payment_no'] = $responseObj['payment_no'];

            if ($responseObj['result_code'] != 'SUCCESS') {
                print_r($responseObj);
                exit;
            }
            return $return;
        } else {
            echo '证书错误:';
            print_r($response);
            exit;
        }
    }

    public function sendRedPack($openid, $money, $send_name = '余额提现', $act_name = '余额提现', $wishing = '祝您生活愉快', $trade_no
    = '')
    {
        global $_W;
        $paysetting = uni_setting($_W['uniacid'], array('payment'));
        $wechatpay = $paysetting['payment']['wechat'];
        $account_info = $_W['account'];
        $mchid = $wechatpay['mchid'];
        $key = $wechatpay['apikey'];
        $appid = $account_info['key'];

        $money = $money * 100;
        $num = 1;
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
        $pars = array();
        $pars['wxappid'] = $appid;
        $pars['mch_id'] = $mchid;
        $pars['nonce_str'] = random(32);
        $pars['mch_billno'] = empty($trade_no) ? $mchid . date('Ymd') . rand(1000000000, 9999999999) : $trade_no;
        $pars['send_name'] = $send_name;
        $pars['re_openid'] = $openid;
        $pars['total_amount'] = $money;
        $pars['total_num'] = $num;
        $pars['wishing'] = $wishing;
//        $pars['client_ip'] = isset($wechat['ip']) ? $wechat['ip'] : $_SERVER['SERVER_ADDR'];
        $pars['client_ip'] = $_SERVER['SERVER_ADDR'];
        $pars['act_name'] = $act_name;
        $pars['remark'] = $act_name;
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key={$key}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $extras = array();

        $path_cert = IA_ROOT . '/addons/weisrc_dish/cert/apiclient_cert_' . $_W['uniacid'] . '.pem';
        $path_key = IA_ROOT . '/addons/weisrc_dish/cert/apiclient_key_' . $_W['uniacid'] . '.pem';
        $path_rootca = IA_ROOT . '/addons/weisrc_dish/cert/rootca_' . $_W['uniacid'] . '.pem';
        $extras['CURLOPT_CAINFO'] = $path_rootca;
        $extras['CURLOPT_SSLCERT'] = $path_cert;
        $extras['CURLOPT_SSLKEY'] = $path_key;

        load()->func('communication');
        $procResult = null;
        $response = ihttp_request($url, $xml, $extras);
        if ($response['code'] == 200) {
            $responseObj = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $responseObj = (array)$responseObj;
            $return['code'] = $responseObj['return_code'];
            $return['result_code'] = $responseObj['result_code'];
            $return['err_code'] = $responseObj['err_code'];
            $return['msg'] = $responseObj['return_msg'];
            $return['trade_no'] = $pars['mch_billno']; //返回订单号 用于重试
            return $return;
        }
    }

    /*
     * @param unknown $appid 支付宝appid
     * @param unknown $transid 要退款的支付宝单号
     * @param unknown $fee 退款金额
     * @param unknown $ordersn 本地商户单号 ($transid和$ordersn不可同时为空)
     * @param unknown $reason 退款理由
     * @param unknown $prikeyfile 证书绝对路径
     */

    public function alipayRefund($appid, $transid, $fee, $ordersn, $reason, $prikeyfile)
    {
        $set = array();
        $set['app_id'] = $appid;
        $set['method'] = 'alipay.trade.refund';
        $set['charset'] = 'utf-8';
        $set['sign_type'] = 'RSA';
        $set['timestamp'] = date('Y-m-d H:i:s');
        $set['version'] = '1.0';
        $content = array('trade_no' => $transid, 'refund_amount' => $fee, 'refund_reason' => $reason, 'out_request_no' => $ordersn);
        $set['biz_content'] = json_encode($content);
        $string = 'app_id=' . $set['app_id'] . '&biz_content=' . $set['biz_content'] . "&charset=" . $set['charset'] . "&method=" . $set['method'] . "&sign_type=" . $set['sign_type'] . "×tamp=" . $set['timestamp'] . "&version=" . $set['version'];

        $priKey = file_get_contents($prikeyfile);
        $res = openssl_get_privatekey($priKey);
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($string, $sign, $res);
        openssl_free_key($res);
        $set['sign'] = base64_encode($sign);

        load()->func('communication');
        $response = ihttp_get('https://openapi.alipay.com/gateway.do?' . http_build_query($set, '', '&'));
        $res = json_decode($response['content'], true);
        if ($res['alipay_trade_refund_response']['code'] == '10000') {
            die('退款成功！');
        }
    }
}
/**
 * 码 上 点 餐
 *
 * 作 者:迷 失 卍 国 度
 *
 * q q : 1 5 5 9 5 7 5 5
 */