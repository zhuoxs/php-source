<?php

defined('IN_IA') or exit ('Access Denied');

class Core extends WeModuleSite
{
    //模块标识
    public $modulename = 'weisrc_dish';
    public $cur_tpl = 'style1';
    public $cur_mobile_path = '';
    public $cur_res = '';
    public $cur_version = 1;

    public $member_code = '';
    public $feyin_key = '';
    public $device_no = '';

    public $msg_status_success = 1;
    public $msg_status_bad = 0;
    public $_debug = '1'; //default:0
    public $_weixin = '1'; //default:1

    public $_appid = '';
    public $_appsecret = '';
    public $_accountlevel = '';
    public $_account = '';

    public $_weid = '';
    public $_fromuser = '';
    public $_nickname = '';
    public $_headimgurl = '';

    public $_auth2_openid = '';
    public $_auth2_nickname = '';
    public $_auth2_headimgurl = '';
    public $_auth2_key = 'bHYzNjAubmV0LmNu';
    public $_lat = '';
    public $_lng = '';
    public $table_area = 'weisrc_dish_area';
    public $table_blacklist = 'weisrc_dish_blacklist';
    public $table_cart = 'weisrc_dish_cart';
    public $table_category = 'weisrc_dish_category';
    public $table_email_setting = 'weisrc_dish_email_setting';
    public $table_goods = 'weisrc_dish_goods';
    public $table_intelligent = 'weisrc_dish_intelligent';
    public $table_nave = 'weisrc_dish_nave';
    public $table_order = 'weisrc_dish_order';
    public $table_order_goods = 'weisrc_dish_order_goods';
    public $table_print_order = 'weisrc_dish_print_order';
    public $table_print_setting = 'weisrc_dish_print_setting';
    public $table_reply = 'weisrc_dish_reply';
    public $table_setting = 'weisrc_dish_setting';
    public $table_sms_checkcode = 'weisrc_dish_sms_checkcode';
    public $table_sms_setting = 'weisrc_dish_sms_setting';
    public $table_store_setting = 'weisrc_dish_store_setting';
    public $table_mealtime = 'weisrc_dish_mealtime';
    public $table_stores = 'weisrc_dish_stores';
    public $table_coupon = 'weisrc_dish_coupon';
    public $table_sncode = 'weisrc_dish_sncode';
    public $table_collection = 'weisrc_dish_collection';
    public $table_type = 'weisrc_dish_type';
    public $table_ad = 'weisrc_dish_ad';
    public $table_template = "weisrc_dish_template";
    public $table_account = "weisrc_dish_account";
    public $table_queue_setting = "weisrc_dish_queue_setting";
    public $table_queue_order = "weisrc_dish_queue_order";
    public $table_tablezones = "weisrc_dish_tablezones";
    public $table_tables = "weisrc_dish_tables";
    public $table_tables_order = "weisrc_dish_tables_order";
    public $table_reservation = "weisrc_dish_reservation";
    public $table_fans = "weisrc_dish_fans";
    public $table_feedback = "weisrc_dish_feedback";
    public $table_businesslog = "weisrc_dish_businesslog";
    public $table_tpl_log = "weisrc_dish_tpl_log";
    public $table_savewine_log = "weisrc_dish_savewine_log";
    public $table_commission = "weisrc_dish_commission";
    public $table_service_log = "weisrc_dish_service_log";
    public $table_print_label = "weisrc_dish_print_label";
    public $table_order_log = "weisrc_dish_order_log";
    public $table_dispatcharea = "weisrc_dish_dispatcharea";
    public $table_deliveryarea = "weisrc_dish_deliveryarea";
    public $table_recharge = "weisrc_dish_recharge";
    public $table_useraddress = "weisrc_dish_useraddress";

    public $serverip = '';

    public function uploadImg($name)
    {
        if ($_FILES[$name]['error'] != 0) {
            $this->result("上传失败，请重试！1", $this->createMobileUrl('editinfo', array(), true));
        }
        $_W['uploadsetting'] = array();
        $_W['uploadsetting']['image']['folder'] = 'images';
        $_W['uploadsetting']['image']['extentions'] = $_W['config']['upload']['image']['extentions'];
        $_W['uploadsetting']['image']['limit'] = 1024;
        load()->func('file');
        $file = file_upload($_FILES[$name], 'image');
        if (is_error($file)) {
            print_r($file);
            exit;
//            $this->result("上传失败，请重试！", $this->createMobileUrl('editinfo', array(), true));
        }
        $result['url'] = $file['url'];
        $result['error'] = 0;
        $result['filename'] = $file['path'];
        $result['url'] = $_W['attachurl'] . $result['filename'];
        return $result['filename'];
    }

    public function checkPermission($storeid = 0)
    {
        global $_GPC, $_W;//manager//operator

        if ($_W['role'] == 'operator') {
            $exists = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " WHERE uid = :uid AND weid = :weid", array(':weid' => $this->_weid, ':uid' => $_W['user']['uid']));

            if ($exists['role'] == 1) { //店长
                if (empty($exists['storeid'])) {
                    return '';
                } elseif ($exists['storeid'] != $storeid && $storeid != 0) {
                    message('您没有该门店的操作权限');
                } else {
                    return $exists['storeid'];
                }
            } else if ($exists['role'] == 3) { //分站
                if ($storeid > 0) {
                    $store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " WHERE id = :id", array(':id' => $storeid));
                    if ($store['schoolid'] != $exists['schoolid']) {
                        message('您没有该门店的操作权限');
                    }
                }
            }
        }
    }

    public function getCurAdmin() {
        global $_GPC, $_W;//manager//operator
        $user = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " WHERE uid = :uid AND weid = :weid", array(':weid' => $this->_weid, ':uid' => $_W['user']['uid']));
        return $user;
    }

    public function checkTrade()
    {
//        if (IMS_VERSION == '0.8') {
//            load()->classs('cloudapi');
//            $api = new CloudApi();
//            $result = $api->get('site', 'module');
//            if ($result) {
//                if ($result['development'] != 1) {
//                    if ($result['trade'] != 1) {
//                        return 0;
//                    }
//                }
//            }
//        }
        return 1;
    }

    public function checkModule($name)
    {
        $module = pdo_fetch("SELECT * FROM " . tablename("modules") . " WHERE name=:name LIMIT 1", array(':name' => $name));
        return $module;
    }

    /*
     * @param unknown $fromtype
     */
    public function addOrderLog($orderid = 0 , $username, $usertype = 1, $fromtype = 1, $paytype = 1, $oldprice ='', $newprice ='')
    {
        global $_GPC, $_W;
        $weid = $this->_weid;
        $payarr = array(
            '1' => '提交订单' ,
            '2' => '支付订单',
            '3' => '确认订单',
            '4' => '完成订单',
            '5' => '取消订单',
            '6' => '退款',
            '7' => '改价',
            '8' => '开启订单',
            '9' => '扫码收货',//消费者
            '10' => '接单配送',//配送员
            '11' => '收款',//配送员
        );
        $userarr = array('1' => '用户', '2' => '管理员', '3' => '配送员');
        $content = $userarr[$usertype] . $username . $payarr[$paytype];
        if ($paytype == 7) {
            $content = $content . '，' . $oldprice . '改为' . $newprice . '。';
        }
        $data = array(
            'weid' => $weid,
            'orderid' => $orderid,
            'content' => $content,
            'fromtype' => $fromtype,
            'status' => 0,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_order_log, $data);
    }

    public function getmodules()
    {
        return pdo_tableexists('modules_reply');
    }

    public function checkStore($id = 0)
    {
        $exists = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $id, ':weid' => $this->_weid));
        if (empty($exists)) {
            message('请选择门店');
        }
    }

    public function get_sys_card($openid)
    {
        $iscard = 0;
        $card = pdo_get('mc_card', array('uniacid' => $this->_weid));
        if ($card && $card['status'] == 1) { //会员卡开启
            $exists = pdo_tableexists('mc_card_members');
            if ($exists) {
                $mcard = pdo_get('mc_card_members', array('uniacid' => $this->_weid, 'openid' => $openid));
                if ($mcard['status'] == 1) {
                    if ($card['times_status'] == 1) { //有日期
                        if ($mcard['endtime'] >= time()) { //在有效期内
                            $iscard = 1;
                        }
                    } else {
                        $iscard = 1;
                    }
                }
            }
        }
        return $iscard;
    }

    public function get_store_card($storeid, $from_user)
    {
        $iscard = 0;
        $card = pdo_fetch("SELECT * FROM " . tablename('weisrc_dish_storecard') . " WHERE storeid=:storeid AND from_user=:from_user
LIMIT 1;", array(':storeid' => $storeid, ':from_user' => $from_user));
        if ($card['status'] == 1) {
            if ($card['lasttime'] > TIMESTAMP) {
                $iscard = 1;
            }
        }
        return $iscard;
    }

    public function exists()
    {
        return pdo_tableexists('wechat_reply');
    }

    public function formatMoney($money){
        if($money >= 10000){
            return sprintf("%.2f", $money/10000) . '万';
        }else{
            return $money;
        }
    }

    public function getMainMenu()
    {
        global $_W, $_GPC;

        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
        if ($_W['role'] == 'operator') {
            $curadmin = $this->getCurAdmin();
            if ($curadmin['role'] == 3) {
                $navemenu[0] = array(
                    'title' => '<icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  业务菜单',
                    'items' => array(
                        0 => $this->createMainMenu('门店管理 ', $do, 'stores2', 'fa-home'),
                        1 => $this->createMainMenu('账号管理 ', $do, 'account', ''),
                        2 => $this->createMainMenu('广告管理 ', $do, 'ad', ''),
                        3 => $this->createMainMenu('通知管理 ', $do, 'notice', ''),
                        4 => $this->createMainMenu('门店类型 ', $do, 'type', ''),
                        5 => $this->createMainMenu('门店区域 ', $do, 'area', ''),
                    )
                );
            } else {
                $navemenu[0] = array(
                    'title' => '<icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  业务菜单',
                    'items' => array(
                        0 => $this->createMainMenu('门店管理 ', $do, 'stores2', 'fa-home')
                    )
                );
            }
        } elseif($_W['isfounder'] || $_W['role'] == 'manager') {
            $navemenu[0] = array(
                'title' => '<icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  业务菜单',
                'items' => array(
                    0 => $this->createMainMenu('门店管理 ', $do, 'stores2', ''),
                    9 => $this->createMainMenu('账号管理 ', $do, 'account', ''),
                    15 => $this->createMainMenu('分站管理 ', $do, 'school', ''),
                    2 => $this->createMainMenu('商户提现 ', $do, 'business', ''),
                    1 => $this->createMainMenu('订单中心 ', $do, 'allorder', ''),
                    4 => $this->createMainMenu('配送管理 ', $do, 'delivery', ''),
                    3 => $this->createMainMenu('充值返现 ', $do, 'recharge', ''),
                    6 => $this->createMainMenu('广告管理 ', $do, 'ad', ''),
                    12 => $this->createMainMenu('通知管理 ', $do, 'notice', ''),
                    16 => $this->createMainMenu('会员管理 ', $do, 'card', ''),
                    8 => $this->createMainMenu('顾客管理 ', $do, 'allfans', ''),
                    5 => $this->createMainMenu('门店类型 ', $do, 'type', ''),
                    7 => $this->createMainMenu('门店区域 ', $do, 'area', ''),
                    10 => $this->createMainMenu('模版管理 ', $do, 'template', ''),
                    13 => $this->createMainMenu('主题设置 ', $do, 'style', ''),
                    14 => $this->createMainMenu('海报设置 ', $do, 'poster', ''),
                    11 => $this->createMainMenu('系统设置 ', $do, 'setting', ''),
                )
            );

            $navemenu[1] = array(
                'title' => '<icon style="color:#8d8d8d;" class="fa fa-inbox"></icon>  入口设置',
                'items' => array(
                    0 => $this->createCoverMenu('平台首页', 'cover', 'index', ''),
                    1 => $this->createCoverMenu('门店列表 ', 'cover', 'waprestList', ''),
                    2 => $this->createCoverMenu('我的订单 ', 'cover', 'order', ''),
                    3 => $this->createCoverMenu('用户中心 ', 'cover', 'usercenter', ''),
                    4 => $this->createCoverMenu('酒水寄存 ', 'cover', 'savewineform', ''),
                    5 => $this->createCoverMenu('商家订单管理 ', 'cover', 'adminorder', ''),
                    6 => $this->createCoverMenu('配送中心入口 ', 'cover', 'deliveryorder', ''),
                    7 => $this->createCoverMenu('我邀请的好友 ', 'cover', 'mymemberlist', ''),
                    8 => $this->createCoverMenu('全屏广告 ', 'cover', 'adscreen', ''),
                )
            );
        }
        return $navemenu;
    }

    public function getOAuthHost()
    {
        global $_W;
        $host = $_W['siteroot'];
//        $set = 'unisetting:' . $_W['uniacid'];
//        if (!empty($_W['cache'][$set]['oauth']['host'])) {
//            $host = $_W['cache'][$set]['oauth']['host'];
//            return $host . '/';
//        }
//        print_r($_W['account']['setting']['oauth']);
//        exit;

//        if (!empty($_W['account']['setting']['oauth']['host'])) {
//            $host = $_W['account']['setting']['oauth']['host'];
//            return $host . '/';
//        }

        return $host;
    }

    function createCoverMenu($title, $method, $op, $icon = "fa-image", $color = '#d9534f')
    {
        global $_GPC, $_W;
        $cur_op = $_GPC['op'];
        $color = ' style="color:'.$color.';" ';
        return array('title' => $title, 'url' => $op != $cur_op ? $this->createWebUrl($method, array('op' => $op)) : '',
            'active' => $op == $cur_op ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa fa-angle-right"></i>',
            )
        );
    }

    function createMainMenu($title, $do, $method, $icon = "fa-image", $color = '')
    {
        $color = ' style="color:'.$color.';" ';

        return array('title' => $title, 'url' => $do != $method ? $this->createWebUrl($method, array('op' => 'display')) : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i '.$color.' class="fa fa-angle-right"></i>',
            )
        );
    }

    function createSubMenu($title, $do, $method, $icon = "fa-image", $color = '#d9534f', $storeid)
    {
        $color = ' style="color:'.$color.';" ';
        $url = $this->createWebUrl($method, array('op' => 'display', 'storeid' => $storeid));
        if ($method == 'stores2') {
            $url = $this->createWebUrl('stores2', array('op' => 'post', 'id' => $storeid, 'storeid' => $storeid));
        }

        return array('title' => $title, 'url' => $do != $method ? $url : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa '.$icon.'"></i>',
            )
        );
    }

    public function getNaveMenu($storeid, $action)
    {
        global $_W, $_GPC;

        $ordertotal = pdo_fetchcolumn("SELECT COUNT(1) FROM " . tablename($this->table_order) . " WHERE
        storeid=:storeid and status=0 ", array(':storeid' => $storeid));
        $ordertotal = intval($ordertotal);

        $do = $_GPC['do'];
        $navemenu = array();
//        $cur_color = ' style="color:#d9534f;" ';
        $cur_color = '#8d8d8d';

        $setting = $this->getSetting();

        $navemenu[] = array(
            'title' => '<icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  基础设置',
            'items' => array(
                0 => $this->createSubMenu('首页概览 ', $do, 'start', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('门店信息 ', $do, 'stores2', 'fa-angle-right', $cur_color, $storeid),
                2 => $this->createSubMenu('订单管理 ', $do, 'order', 'fa-angle-right', $cur_color, $storeid),
                3 => $this->createSubMenu('顾客管理 ', $do, 'fans', 'fa-angle-right', $cur_color, $storeid),
                6 => $this->createSubMenu('门店会员 ', $do, 'storecard', 'fa-angle-right', $cur_color, $storeid),
                4 => $this->createSubMenu('员工管理 ', $do, 'coreuser', 'fa-angle-right', $cur_color, $storeid),
                5 => $this->createSubMenu('消费排行 ', $do, 'storerank', 'fa-angle-right', $cur_color, $storeid),
            ),
            'icon' => 'fa fa-user-md'
        );
        $cur_color = '#8d8d8d';
        $navemenu[] = array(
            'title' => '<icon style="color:' . $cur_color . ';" class="fa fa-database"></icon>  数据管理',
            'items' => array(
                0 => $this->createSubMenu('商品管理 ', $do, 'goods', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('分类管理 ', $do, 'category', 'fa-angle-right', $cur_color, $storeid),
                2 => $this->createSubMenu('活动推荐 ', $do, 'intelligent', 'fa-angle-right', $cur_color, $storeid),
                3 => $this->createSubMenu('酒水寄存 ', $do, 'savewine', 'fa-angle-right', $cur_color, $storeid),
                4 => $this->createSubMenu('评论管理 ', $do, 'feedback', 'fa-angle-right', $cur_color, $storeid),
                5 => $this->createSubMenu('配送区域 ', $do, 'dispatcharea', 'fa-angle-right', $cur_color, $storeid),
            )
        );
        $cur_color = '#8d8d8d';
        $navemenu[] = array(
            'title' => '<icon style="color:' . $cur_color . ';" class="fa fa-wechat"></icon> 店内设置',
            'items' => array(
                0 => $this->createSubMenu('餐桌管理 ', $do, 'tables', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('餐桌类型 ', $do, 'tablezones', 'fa-angle-right', $cur_color, $storeid),
                2 => $this->createSubMenu('排队管理 ', $do, 'queueorder', 'fa-angle-right', $cur_color, $storeid),
                3 => $this->createSubMenu('预订管理 ', $do, 'reservation', 'fa-angle-right', $cur_color, $storeid),
                4 => $this->createSubMenu('营销管理 ', $do, 'coupon', 'fa-angle-right', $cur_color, $storeid),
            )
        );

        $cur_color = '#8d8d8d';

        if ($setting['is_open_price'] == 1) {
            $navemenu[] = array(
                'title' => '<icon style="color:' . $cur_color . ';" class="fa fa-money"></icon>  财务管理',
                'items' => array(
                    0 => $this->createSubMenu('提现管理 ', $do, 'businesscenter', 'fa-angle-right', $cur_color, $storeid),
                    1 => $this->createSubMenu('账号设置 ', $do, 'businesssetting', 'fa-angle-right', $cur_color, $storeid)
                ),
            );
        }

        $cur_color = '#8d8d8d';
        $navemenu[] = array(
            'title' => '<icon style="color:' . $cur_color . ';" class="fa fa-credit-card"></icon>  打印机管理',
            'items' => array(
                0 => $this->createSubMenu('打印设备 ', $do, 'printsetting', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('打印记录 ', $do, 'printorder', 'fa-angle-right', $cur_color, $storeid),
                2 => $this->createSubMenu('打印标签 ', $do, 'printlabel', 'fa-angle-right', $cur_color, $storeid),
            )
        );
        return $navemenu;
    }

    function getDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 2)
    {
        $radLat1 = $lat1 * M_PI / 180;
        $radLat2 = $lat2 * M_PI / 180;
        $a = $lat1 * M_PI / 180 - $lat2 * M_PI / 180;
        $b = $lng1 * M_PI / 180 - $lng2 * M_PI / 180;

        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * EARTH_RADIUS;
        $s = round($s * 1000);
        if ($len_type > 1) {
            $s /= 1000;
        }
        $s /= 1000;
        return round($s, $decimal);
    }

    public function getAllTableByStoreid($id)
    {
        $data = pdo_fetchall("SELECT * FROM " . tablename($this->table_tables) . " WHERE weid = :weid AND storeid=:storeid", array(':weid' => $this->_weid, ':storeid' => $id));
        return $data;
    }
    public function getTableById($id)
    {
        $data = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $this->_weid, ':id' => $id));
        return $data;
    }
    public function getAccountById($id)
    {
        $data = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " where id=:id LIMIT 1", array(':id' => $id));
        return $data;
    }
    public function getDeliveryById($id)
    {
        $data = pdo_fetch("SELECT * FROM " . tablename($this->table_deliveryarea) . " where id=:id LIMIT 1", array(':id' => $id));
        return $data;
    }



    /**
     *    功能 二维码创建函数；
     * @param string $value 内容（可以是：链接、文字等）
     * @param string $filename 文件名字
     * @param string $pathname 路径名字
     * @param string $errorCorrectionLevel 容错率 L M Q H
     * @return $fileurllogo 中间带logo的二维码；
     * @Author Fmoons
     * @Time 2015.06.04 01:27
     **/
    public function fm_qrcode($value = 'http://www.we7.cc', $filename = '', $pathname = '', $logo = '', $scqrcode = array('errorCorrectionLevel' => 'M', 'matrixPointSize' => '4', 'margin' => '5'))
    {
        global $_W;
        $uniacid = !empty($_W['uniacid']) ? $_W['uniacid'] : $_W['acid'];
        require_once IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
        load()->func('file');

//        $filename = empty($filename) ? date("YmdHis") . '' . random(10) : date("YmdHis") . '' . random(istrlen($filename));
        $filename = empty($filename) ? date("YmdHis") . '' . random(10) : $filename;

        if (!empty($pathname)) {
            $dfileurl = 'attachment/images/' . $uniacid . '/qrcode/cache/' . date("Ymd") . '/' . $pathname;
            if (defined('IN_weisrc_dish_ADMIN')) {
                $fileurl = '../' . $dfileurl;
            } else {
                $fileurl = '../' . $dfileurl;
            }
        } else {
            $dfileurl = 'attachment/images/' . $uniacid . '/qrcode/cache/' . date("Ymd");
            if (defined('IN_weisrc_dish_ADMIN')) {
                $fileurl = '../' . $dfileurl;
            } else {
                $fileurl = '../' . $dfileurl;
            }
        }
        mkdirs($fileurl);
        $fileurl = empty($pathname) ? $fileurl . '/' . $filename . '.png' : $fileurl . '/' . $filename . '.png';
        QRcode::png($value, $fileurl, $scqrcode['errorCorrectionLevel'], $scqrcode['matrixPointSize'], $scqrcode['margin']);
        return $_W['siteroot']. str_replace('../', '', $fileurl);

        $dlogo = $_W['attachurl'] . 'headimg_' . $uniacid . '.jpg?uniacid=' . $uniacid;

        if (!$logo) {
            $logo = toimage($dlogo);
        }

        $QR = $_W['siteroot'] . $dfileurl . '/' . $filename . '.png';
        if ($logo !== FALSE) {
            $QR = imagecreatefromstring(file_get_contents($QR));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);
            $QR_height = imagesy($QR);
            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
        }
        if (!empty($pathname)) {
            $dfileurllogo = 'attachment/images/' . $uniacid . '/qrcode/fm_qrcode/' . date("Ymd") . '/' . $pathname;
            $fileurllogo = '../' . $dfileurllogo;
        } else {
            $dfileurllogo = 'attachment/images/' . $uniacid . '/qrcode/fm_qrcode';
            $fileurllogo = '../' . $dfileurllogo;
        }
        mkdirs($fileurllogo);
        $fileurllogo = empty($pathname) ? $fileurllogo . '/' . $filename . '_logo.png' : $fileurllogo . '/' . $filename . '_logo.png';;

        imagepng($QR, $fileurllogo);
        return $fileurllogo;
    }

    public function getOrderById($id)
    {
        $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id=:id LIMIT 1", array(':id' => $id));
        return $order;
    }

    public function getQuickNum($storeid)
    {
        $order = pdo_fetch("SELECT quicknum FROM " . tablename($this->table_order) . " WHERE storeid=:storeid AND dining_mode=4 ORDER BY id DESC LIMIT 1", array(':storeid' => $storeid));
        if ($order) {
            $quicknum = intval($order['quicknum']);
            $quicknum++;
            if ($quicknum > 998) {
                $quicknum = 1;
            }
            $quicknum = str_pad($quicknum, 3, "0", STR_PAD_LEFT);
        } else {
            $quicknum = '001';
        }
        return $quicknum;
    }

    public function setOrderServiceRead($orderid)
    {
        pdo_update($this->table_fans, array('status' => 1), array('orderid' => $orderid));
    }

    public function getFansByOpenid($openid)
    {
        $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $openid, ':weid' => $this->_weid));
        return $fans;
    }

    public function getFansById($id)
    {
        $fans = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $id, ':weid' => $this->_weid));
        return $fans;
    }

    public function addFans($nickname, $headimgurl)
    {
        $insert = array(
            'weid' => $this->_weid,
            'from_user' => $this->_fromuser,
            'nickname' => $nickname,
            'headimgurl' => $headimgurl,
            'dateline' => TIMESTAMP
        );
        if (!empty($this->_account)) {
            if (!empty($nickname)) {
                pdo_insert($this->table_fans, $insert);
            }
        } else {
            pdo_insert($this->table_fans, $insert);
        }

    }

    public function updateFans($nickname, $headimgurl, $id)
    {
        pdo_update($this->table_fans, array('nickname' => $nickname, 'headimgurl' => $headimgurl, 'lasttime' => TIMESTAMP)
            , array('id' => $id));
    }

    public function getSlidesByPos($pos = 2, $setting = array(), $schoolid = 0)
    {
        $strwhere = "";
        if ($setting['is_school'] == 1) {
            $strwhere = " AND schoolid={$schoolid} ";
        }

        $datas = pdo_fetchall("SELECT * FROM " . tablename($this->table_ad) . " WHERE uniacid = :uniacid AND position=:position AND status=1 AND :time >starttime AND :time < endtime {$strwhere} ORDER BY displayorder DESC,id DESC LIMIT 6", array(':uniacid' => $this->_weid, ':time' =>
            TIMESTAMP, ':position' => $pos));
        return $datas;
    }

    public function getSetting()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_setting) . " where weid = :weid LIMIT 1", array(':weid' => $this->_weid));
        return $setting;
    }

    public function getSettingByWeid($weid)
    {
        $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_setting) . " where weid = :weid LIMIT 1", array(':weid' => $weid));
        return $setting;
    }

    public function resetHour()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $stores = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid ", array(':weid' => $weid));
        foreach($stores as $key => $value) {
            $status = 1;
            if (!empty($value['begintime']) && !empty($value['endtime'])) {
                $state = $this->check_hourtime($value['begintime'], $value['endtime']);
                if ($state >= 1) {
                    $status = 0;
                }
            }
            if (!empty($value['begintime1']) && !empty($value['endtime1'])) {
                $state = $this->check_hourtime($value['begintime1'], $value['endtime1']);
                if ($state >= 1) {
                    $status = 0;
                }
            }
            if (!empty($value['begintime2']) && !empty($value['endtime2'])) {
                $state = $this->check_hourtime($value['begintime2'], $value['endtime2']);
                if ($state >= 1) {
                    $status = 0;
                }
            }
            pdo_update($this->table_stores, array('is_rest' => $status), array('id' => $value['id']));
        }
    }

    //1：营业中,0：休息
    public function getstoretimestatus($store) {
        $status = 0;
        if (!empty($store['begintime']) && !empty($store['endtime'])) {
            $state = $this->check_hourtime($store['begintime'], $store['endtime']);
            if ($state >= 1) {
                return $state;//营业中
            }
        }
        if (!empty($store['begintime1']) && !empty($store['endtime1'])) {
            $state = $this->check_hourtime($store['begintime1'], $store['endtime1']);
            if ($state >= 1) {
                return $state;
            }
        }
        if (!empty($value['begintime2']) && !empty($value['endtime2'])) {
            $state = $this->check_hourtime($store['begintime2'], $store['endtime2']);
            if ($state >= 1) {
                return $state;
            }
        }
        return 0;
    }

    public function check_hourtime($begintime, $endtime)
    {
        global $_W, $_GPC;
        $nowtime = intval(date("Hi"));
        $begintime = intval(str_replace(':', '', $begintime));
        $endtime = intval(str_replace(':', '', $endtime));

        if ($begintime < $endtime) { //开始时间小于结束时间
            if ($begintime <= $nowtime && $nowtime <= $endtime) { //开始时间小于现在时间
                return 1;//在营业时间
            }
        } else {
            if ($begintime <= $nowtime || $nowtime <= $endtime) {
                return 1;//在营业时间
            }
        }
        return 0;
    }

    public function getPriceByTime($storeid)
    {
        global $_W, $_GPC;

        $list = pdo_fetchall("SELECT * FROM " . tablename('weisrc_dish_deliverytime') . " WHERE storeid=:storeid order by id", array(':storeid' => $storeid));
        $price = 0;

        foreach ($list as $key => $val) {
            $nowtime = intval(date("Hi"));
            $begintime = intval(str_replace(':', '', $val['begintime']));
            $endtime = intval(str_replace(':', '', $val['endtime']));

            if ($begintime < $endtime) { //开始时间小于结束时间
                if ($nowtime >= $begintime  && $nowtime <= $endtime) { //开始时间小于现在时间
                    $price = floatval($val['price']);
                }
            } else {
                if ($begintime <= $nowtime || $nowtime <= $endtime) {
                    $price = floatval($val['price']);
                }
            }
        }
        return $price;
    }

    public function getStoreById($id)
    {
        $store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . " WHERE id=:id LIMIT 1", array(':id' => $id));
        return $store;
    }

    public function getStoreID()
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_setting) . " WHERE weid=:weid  ORDER BY id DESC LIMIT 1", array(':weid' => $weid));
        if (!empty($setting)) {
            return intval($setting['storeid']);
        } else {
            $store = pdo_fetch("SELECT * FROM " . tablename($this->table_stores) . "  WHERE weid={$weid}  ORDER BY id DESC LIMIT 1");
            return intval($store['id']);
        }
    }



    public function getTablezonesById($id)
    {
        $data = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where weid = :weid AND id=:id LIMIT 1", array(':weid' => $this->_weid, ':id' => $id));
        return $data;
    }

    public function getTableName($id)
    {
        $table = pdo_fetch("SELECT * FROM " . tablename($this->table_tables) . " where id=:id LIMIT 1", array(':id' => $id));
        if (empty($table)) {
            return '未知数据！';
        } else {
            $tablezones = pdo_fetch("SELECT * FROM " . tablename($this->table_tablezones) . " where id=:id LIMIT 1", array(':id' => $table['tablezonesid']));
            $table_title = $tablezones['title'] . '-' . $table['title'];
        }
        return $table_title;
    }

    public function getQueueName($id)
    {
        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_queue_setting) . " where id=:id LIMIT 1", array(':id' => $id));
        return $item['title'];
    }

    public function isWeixin()
    {
        if ($this->_weixin == 1) {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            if (!strpos($userAgent, 'MicroMessenger')) {
                include $this->template('s404');
                exit();
            }
        }
    }

    public function getPayType($type)
    {
        $data = array(
            '0' => '线下付款',
            '1' => '余额支付',
            '2' => '微信支付',
            '3' => $type == 1 ? '现金付款' : '货到付款',
            '4' => '支付宝',
            '10'  => 'pos刷卡',
            '11'  => '挂帐',
        );
        return $data;
    }

    public function getOrderType($store)
    {
        $data = array(
            '1' => '堂点',
            '2' => '外卖',
            '3' => '预定',
            '4' => '快餐',
            '5' => '收银',
            '6' => '充值',
            '7' => '开卡',
            '8' => '门店卡充值'
        );
        if ($store) {
            if (!empty($store['btn_eat'])) {
                $data['1'] = $store['btn_eat'];
            }
            if (!empty($store['btn_delivery'])) {
                $data['2'] = $store['btn_delivery'];
            }
            if (!empty($store['btn_reservation'])) {
                $data['3'] = $store['btn_reservation'];
            }
            if (!empty($store['btn_snack'])) {
                $data['4'] = $store['btn_snack'];
            }
            if (!empty($store['btn_shouyin'])) {
                $data['5'] = $store['btn_shouyin'];
            }
        }
        return $data;
    }

    /*
    ** 设置切换导航
    */
    public function set_tabbar($action, $storeid)
    {
        $actions_titles = $this->actions_titles;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles as $key => $value) {
            if ($key == 'stores2') {
                $url = $this->createWebUrl('stores2', array('op' => 'post', 'id' => $storeid));
            } else {
                $url = $this->createWebUrl($key, array('op' => 'display', 'storeid' => $storeid));
            }

            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public function _file_sys_tb()
    {
        $this->table_queue_order = "we" . "isrc_di" . "sh_que" . "ue_order";
        $this->table_print_order = "weis" . "rc_di" . "sh_print_order";
        $this->table_mealtime = 'weis' . 'rc_di' . 'sh_me' . 'altime';
    }

    public function getWeek(){
        $week = date("w");
        switch($week){
            case 1:
                return "星期一";
                break;
            case 2:
                return "星期二";
                break;
            case 3:
                return "星期三";
                break;
            case 4:
                return "星期四";
                break;
            case 5:
                return "星期五";
                break;
            case 6:
                return "星期六";
                break;
            case 0:
                return "星期日";
                break;
        }
    }

    public function getStoreOrderTotalPrice($storeid, $is_contain_delivery)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;

        $totalprice = 0;
        if ($is_contain_delivery == 1) { //包含配送费
            $totalprice = pdo_fetchcolumn("SELECT sum(totalprice-one_order_getprice) FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND ispay=1 AND
ismerge=0 AND status=3 AND (paytype=1 OR paytype=2 OR paytype=4)", array(':weid' => $weid, ':storeid' => $storeid));
            $totalprice = floatval($totalprice);
        } else {
            //不包含配送费
            $time = strtotime('2017-07-17 00:00:00');
            $totalprice1 = pdo_fetchcolumn("SELECT sum(totalprice-one_order_getprice) FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid AND ispay=1 AND
ismerge=0 AND status=3 AND (paytype=1 OR paytype=2 OR paytype=4) AND dateline<:dateline", array(':weid' => $weid,
                ':storeid' => $storeid, ':dateline' => $time));
            $totalprice1 = floatval($totalprice1);

            $totalprice2 = pdo_fetchcolumn("SELECT sum(totalprice-dispatchprice-one_order_getprice) FROM " . tablename($this->table_order) . " WHERE weid = :weid AND storeid=:storeid
AND ispay=1 AND
ismerge=0 AND status=3 AND (paytype=1 OR paytype=2 OR paytype=4) AND dateline>=:dateline", array(':weid' => $weid,
                ':storeid' => $storeid, ':dateline' => $time));

            $totalprice2 = floatval($totalprice2);
            $totalprice = $totalprice1 + $totalprice2;
        }
        return $totalprice;
    }

    public function getStoreOutTotalPrice($storeid)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $totalprice1 = pdo_fetchcolumn("SELECT sum(price) FROM " . tablename($this->table_businesslog) . " WHERE weid = :weid AND storeid=:storeid AND status=1", array(':weid' => $weid, ':storeid' => $storeid));
        $totalprice1 = floatval($totalprice1);
        $totalprice1 = sprintf('%.2f', $totalprice1);
        return $totalprice1;
    }

    public function getStoreGetTotalPrice($storeid)
    {
        global $_W, $_GPC;
        $weid = $this->_weid;
        $totalprice2 = pdo_fetchcolumn("SELECT sum(price) FROM " . tablename($this->table_businesslog) . " WHERE weid = :weid AND storeid=:storeid AND status=0", array(':weid' => $weid, ':storeid' => $storeid));
        $totalprice2 = floatval($totalprice2);
        $totalprice2 = sprintf('%.2f', $totalprice2);
        return $totalprice2;
    }
}