<?php
global $_W, $_GPC;
$weid = $this->_weid;
$action = 'setting';
$title = '系统设置';
$GLOBALS['frames'] = $this->getMainMenu();
$config = $this->module['config']['weisrc_dish'];
load()->func('tpl');


$menu = pdo_fetch("SELECT * FROM " . tablename("modules_bindings") . " WHERE module = 'weisrc_dish' AND entry='menu' AND
         do='login' LIMIT 1;");
if (!$menu) {
    pdo_run("insert " . tablename("modules_bindings") . "(`module`,`entry`,`title`,`do`,`direct`) values ('weisrc_dish', 'menu', '商家登录','login',1);");
} else {
    pdo_run("UPDATE " . tablename("modules_bindings") . " SET `direct`=1 WHERE eid=".$menu['eid']." LIMIT 1;");
}


//$notify_url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&do=fengniaonotify&m=weisrc_dish';
//message($notify_url);

//pdo_query("UPDATE ".tablename('modules')." SET wxapp_support=2 WHERE name = 'weisrc_dish' LIMIT 1");
//pdo_query("insert ".tablename('modules')."(`module`,`entry`,`title`,`do`,`state`,`url`,`icon`,`displayorder`) values ('weisrc_dish', 'page', '首页', 'index','','','','0');");

$stores = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid ORDER BY `id` DESC", array(':weid' => $_W['uniacid']));
if (empty($stores)) {
    $url = $this->createWebUrl('stores', array('op' => 'display'));
}

$setting = $this->getSetting();
$fans = $this->getFansByOpenid($setting['tpluser']);

if (checksubmit('submit')) {
    $data = array(
        'weid' => $_W['uniacid'],
        'title' => trim($_GPC['title']),
        'thumb' => trim($_GPC['thumb']),
        'storeid' => intval($_GPC['storeid']),
        'entrance_type' => intval($_GPC['entrance_type']),
        'entrance_storeid' => intval($_GPC['entrance_storeid']),
        'order_enable' => intval($_GPC['order_enable']),
        'mode' => intval($_GPC['mode']),
        'is_notice' => intval($_GPC['is_notice']),
        'dining_mode' => intval($_GPC['dining_mode']),
        'istplnotice' => intval($_GPC['istplnotice']),
        'is_school' => intval($_GPC['is_school']),
        'is_show_toutiao' => intval($_GPC['is_show_toutiao']),
        'is_show_visit' => intval($_GPC['is_show_visit']),
        'tplneworder' => trim($_GPC['tplneworder']),
        'tplapplynotice' => trim($_GPC['tplapplynotice']),
        'tplnewqueue' => trim($_GPC['tplnewqueue']),
        'tploperator' => trim($_GPC['tploperator']),
        'table_cover' => trim($_GPC['table_cover']),
        'table_desc' => trim($_GPC['table_desc']),
        'site_logo' => trim($_GPC['site_logo']),
        'tplboss' => trim($_GPC['tplboss']),
        'searchword' => trim($_GPC['searchword']),
        'tpluser' => trim($_GPC['from_user']),
        'is_yunzhong' => intval($_GPC['is_yunzhong']),
        'tpltype' => intval($_GPC['tpltype']),
        'sms_enable' => intval($_GPC['sms_enable']),
        'is_auto_commission' => intval($_GPC['is_auto_commission']),
        'auto_commission_coin' => intval($_GPC['auto_commission_coin']),
        'tplmission' => trim($_GPC['tplmission']),
        'tplcoupon' => trim($_GPC['tplcoupon']),
        'sms_username' => trim($_GPC['sms_username']),
        'isneedfollow' => intval($_GPC['isneedfollow']),
        'is_quick_money' => intval($_GPC['is_quick_money']),
        'follow_url' => trim($_GPC['follow_url']),
        'share_title' => trim($_GPC['share_title']),
        'share_desc' => trim($_GPC['share_desc']),
        'share_image' => trim($_GPC['share_image']),
        'sms_pwd' => trim($_GPC['sms_pwd']),
        'sms_mobile' => trim($_GPC['sms_mobile']),
        'link_card' => trim($_GPC['link_card']),
        'link_sign' => trim($_GPC['link_sign']),
        'commission_keywords' => trim($_GPC['commission_keywords']),
        'link_card_name' => trim($_GPC['link_card_name']),
        'link_sign_name' => trim($_GPC['link_sign_name']),
        'link_recharge' => trim($_GPC['link_recharge']),
        'link_recharge_name' => trim($_GPC['link_recharge_name']),
        'email_enable' => intval($_GPC['email_enable']),
        'email_host' => $_GPC['email_host'],
        'email_send' => $_GPC['email_send'],
        'email_pwd' => $_GPC['email_pwd'],
        'email_user' => $_GPC['email_user'],
        'email' => trim($_GPC['email']),
        'follow_title' => trim($_GPC['follow_title']),
        'follow_desc' => trim($_GPC['follow_desc']),
        'follow_logo' => trim($_GPC['follow_logo']),
        'dateline' => TIMESTAMP,
        'getcash_price' => intval($_GPC['getcash_price']),
        'fee_rate' => floatval($_GPC['fee_rate']),
        'one_order_getprice' => floatval($_GPC['one_order_getprice']),
        'fee_min' => intval($_GPC['fee_min']),
        'fee_max' => intval($_GPC['fee_max']),
        'credit_mode' => intval($_GPC['credit_mode']),
        'payx_credit' => intval($_GPC['payx_credit']),
        'wechat' => intval($_GPC['wechat']),
        'alipay' => intval($_GPC['alipay']),
        'credit' => intval($_GPC['credit']),
        'fengniao_mode' => intval($_GPC['fengniao_mode']),
        'is_show_home' => intval($_GPC['is_show_home']),
        'is_check_user' => intval($_GPC['is_check_user']),
        'is_speaker' => intval($_GPC['is_speaker']),
        'delivery' => intval($_GPC['delivery']),
        'is_open_price' => intval($_GPC['is_open_price']),
        'is_commission' => intval($_GPC['is_commission']),
        'commission_mode' => intval($_GPC['commission_mode']),
        'commission_level' => intval($_GPC['commission_level']),
        'commission1_rate_max' => floatval($_GPC['commission1_rate_max']),
        'commission1_value_max' => intval($_GPC['commission1_value_max']),
        'commission2_rate_max' => floatval($_GPC['commission2_rate_max']),
        'commission2_value_max' => intval($_GPC['commission2_value_max']),
        'commission3_rate_max' => floatval($_GPC['commission3_rate_max']),
        'commission3_value_max' => intval($_GPC['commission3_value_max']),
        'commission_settlement' => intval($_GPC['commission_settlement']),
        'commission_money_mode' => intval($_GPC['commission_money_mode']),
        'is_auto_address' => intval($_GPC['is_auto_address']),
        'is_contain_delivery' => intval($_GPC['is_contain_delivery']),
        'is_verify_mobile' => intval($_GPC['is_verify_mobile']),
        'tiptype' => intval($_GPC['tiptype']),
        'tipbtn' => intval($_GPC['tipbtn']),
        'auth_mode' => intval($_GPC['auth_mode']),
        'tipqrcode' => trim($_GPC['tipqrcode']),
        'kefuqrcode' => trim($_GPC['kefuqrcode']),
        'statistics' => trim($_GPC['statistics']),
        'dayu_appkey' => trim($_GPC['dayu_appkey']),
        'dayu_secretkey' => trim($_GPC['dayu_secretkey']),
        'dayu_verify_code' => trim($_GPC['dayu_verify_code']),
        'dayu_sign' => trim($_GPC['dayu_sign']),
        'style_base' => trim($_GPC['style_base']),
        'style_list_btn1' => trim($_GPC['style_list_btn1']),
        'style_list_btn2' => trim($_GPC['style_list_btn2']),
        'style_list_btn3' => trim($_GPC['style_list_btn3']),
        'style_list_base' => trim($_GPC['style_list_base']),
        'visit' => intval($_GPC['visit']),
        'is_show_virtual' => intval($_GPC['is_show_virtual'])
    );

    if ($config['is_fengniao']==1) {
        $data['fengniao_appid'] = trim($_GPC['fengniao_appid']);
        $data['fengniao_key'] = trim($_GPC['fengniao_key']);
    }

    if ($data['commission_money_mode'] == 2) {
        $data['commission_level'] = 2;
    }

    //manager//operator
    if ($_W['role'] == 'manager' || $_W['isfounder']) {
        $data['is_operator_pwd'] = intval($_GPC['is_operator_pwd']);
        $data['operator_pwd'] = trim($_GPC['operator_pwd']);
    }

    $certfile = IA_ROOT . "/addons/weisrc_dish/cert/" . 'apiclient_cert_' . $this->_weid . '.pem';
    $keyfile = IA_ROOT . "/addons/weisrc_dish/cert/" . 'apiclient_key_' . $this->_weid . '.pem';
    $rootca = IA_ROOT . "/addons/weisrc_dish/cert/" . 'rootca_' . $this->_weid . '.pem';

    if (!$this->exists()) {
        if (!empty($_GPC['apiclient_cert'])) {
            file_put_contents($certfile, 'qweqeqeqeqwewqeqweqwe');
            $data['apiclient_cert'] = 1;
        }
        if (!empty($_GPC['apiclient_key'])) {
            file_put_contents($keyfile, 'qweqeqeqeqwewqeqweqwe');
            $data['apiclient_key'] = 1;
        }
        if (!empty($_GPC['rootca'])) {
            file_put_contents($rootca, 'qweqeqeqeqwewqeqweqwe');
            $data['rootca'] = 1;
        }
    } else {
        if (!empty($_GPC['apiclient_cert'])) {
            file_put_contents($certfile, trim($_GPC['apiclient_cert']));
            $data['apiclient_cert'] = 1;
        }
        if (!empty($_GPC['apiclient_key'])) {
            file_put_contents($keyfile, trim($_GPC['apiclient_key']));
            $data['apiclient_key'] = 1;

            file_put_contents($rootca, '123123123');
            $data['rootca'] = 1;
        }
//        if (!empty($_GPC['rootca'])) {
//
//        }
    }

    if ($data['is_commission'] == 1 && $data['commission_money_mode'] == 1) {
        if ($data['commission1_rate_max'] <= 0) {
            message('请输入佣金百分比！');
        }
        if ($data['commission_level'] > 1) {
            if ($data['commission2_rate_max'] <= 0) {
                message('请输入二级佣金百分比！');
            }
        }
    }

    if ($data['email_enable'] == 1) {
        if (empty($_GPC['email_send']) || empty($_GPC['email_user']) || empty($_GPC['email_pwd'])) {
            message('请完整填写邮件配置信息', 'refresh', 'error');
        }
        if ($_GPC['email_host'] == 'smtp.qq.com' || $_GPC['email_host'] == 'smtp.gmail.com') {
            $secure = 'ssl';
            $port = '465';
        } else {
            $secure = 'tls';
            $port = '25';
        }

//        $mail_config = array();
//        $mail_config['host'] = $_GPC['email_host'];
//        $mail_config['secure'] = $secure;
//        $mail_config['port'] = $port;
//        $mail_config['username'] = $_GPC['email_user'];
//        $mail_config['sendmail'] = $_GPC['email_send'];
//        $mail_config['password'] = $_GPC['email_pwd'];
//        $mail_config['mailaddress'] = $_GPC['email'];
//        $mail_config['subject'] = '微点餐提醒';
//        $mail_config['body'] = '邮箱测试';
//        $result = $this->sendmail($mail_config);
    }
    if (empty($setting)) {
        pdo_insert($this->table_setting, $data);
    } else {
        unset($data['dateline']);
        pdo_update($this->table_setting, $data, array('weid' => $_W['uniacid']));
    }
//    echo pdo_debug();
//    exit;

    $rule = array(
        'uniacid' => $_W['uniacid'],
        'name' => "餐饮分销",
        'module' => 'weisrc_dish',
        'status' => 1,
        'displayorder' => 255
    );
    $sql = "SELECT * FROM " . tablename('rule') . ' WHERE `module` = :module AND `name` = :name AND uniacid = :uniacid';
    $pars = array();
    $pars[':module'] = 'weisrc_dish';
    $pars[':name'] = "餐饮分销";
    $pars[':uniacid'] = $_W['uniacid'];
    $reply = pdo_fetch($sql, $pars);
    if (!empty($reply)) {
        $rid = $reply['id'];
        $result = pdo_update('rule', $rule, array('id' => $rid));
    } else {
        $result = pdo_insert('rule', $rule);
        $rid = pdo_insertid();
    }

    if (!empty($rid)) {
        $sql = 'DELETE FROM ' . tablename('rule_keyword') . ' WHERE `rid`=:rid AND `uniacid`=:uniacid';
        $pars = array();
        $pars[':rid'] = $rid;
        $pars[':uniacid'] = $_W['uniacid'];
        pdo_query($sql, $pars);

        $rowtpl = array(
            'rid' => $rid,
            'uniacid' => $_W['uniacid'],
            'module' => 'weisrc_dish',
            'status' => 1,
            'displayorder' => $rule['displayorder'],
            'type' => 1,
            'content' => $_GPC['commission_keywords']
        );
        pdo_insert('rule_keyword', $rowtpl);
    }

    message('操作成功', $this->createWebUrl('setting'), 'success');
}

if (empty($setting)) {
    $setting['site_logo'] = './addons/weisrc_dish/template/images/logo.png';
}

include $this->template('web/setting');

