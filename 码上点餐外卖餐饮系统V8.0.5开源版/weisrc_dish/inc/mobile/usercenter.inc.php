<?php
global $_W, $_GPC;
$weid = $this->_weid;
$from_user = $this->_fromuser;
$cur_nave = 'my';
$setting = $this->getSetting();
$config = $this->module['config']['weisrc_dish'];
$sid = intval($_GPC['sid']);

$agentid = intval($_GPC['agentid']);
$agentid2 = 0;
$agentid3 = 0;


if ($setting['auth_mode'] == 1 || empty($setting)) {
    $method = 'UserCenter'; //method
    $host = $this->getOAuthHost();
    $authurl = $host . 'app/' . $this->createMobileUrl($method, array('agentid' => $agentid), true) . '&authkey=1';
    $url = $host . 'app/' . $this->createMobileUrl($method, array('agentid' => $agentid), true);
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
if ($agentid != 0) {
    $agent = pdo_fetch("SELECT * FROM " . tablename($this->table_fans) . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $agentid, ':weid' => $weid));
    $agent = $this->getFansById($agentid);
    if ($setting['commission_mode'] == 2) { //代理商模式
        if ($agent['is_commission'] != 2) {//用户不是代理商重新查找
            $agent = $this->getFansById($agent['agentid']);
            $agentid = intval($agent['id']);
        }
    }

    if (!empty($agent['agentid'])) {
        $agentid2 = intval($agent['agentid']);
        $agent2 = $this->getFansById($agentid2);
        if (!empty($agent2['agentid'])) {
            $agentid3 = intval($agent2['agentid']);
        }
    }
}

if ($this->_accountlevel == 4) {
    if (empty($fans) && !empty($nickname)) {
        $insert = array(
            'weid' => $weid,
            'from_user' => $from_user,
            'nickname' => $nickname,
            'headimgurl' => $headimgurl,
            'agentid' => $agentid,
            'agentid2' => $agentid2,
            'agentid3' => $agentid3,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_fans, $insert);
    } else {
        pdo_update(
            $this->table_fans,
            array(
                'headimgurl' => $headimgurl,
                'nickname' => $nickname,
            ),
            array('id' => $fans['id'])
        );
    }
} else {
    if (empty($fans) && !empty($from_user)) {
        $insert = array(
            'weid' => $weid,
            'from_user' => $from_user,
            'agentid' => $agentid,
            'agentid2' => $agentid2,
            'agentid3' => $agentid3,
            'dateline' => TIMESTAMP
        );
        pdo_insert($this->table_fans, $insert);
    }
}
$fans = $this->getFansByOpenid($from_user);

if ($setting['is_check_user'] == 1) { //判断是否需要审核
    if ($fans['is_check'] == 0) {
        message('您好，本店只支持内部人员使用!');
    }
}

if (!empty($fans)) {
    $sub = 0;
    if ($this->_accountlevel == 4) {
        $userinfo = $this->getUserInfo($from_user);
        if ($userinfo['subscribe'] == 1) {
            $sub = 1;
        }
    } else {
        if ($_W['fans']['follow'] == 1) {
            $sub = 1;
        }
    }

    if ($sub == 0) {
        if ($setting['isneedfollow'] == 1) {
            $follow_url = $setting['follow_url'];
            if (!empty($follow_url)) {
                header("location:$follow_url");
            } else {
                message("请先关注公众号！");
            }
        }
    }
}

$is_savewine = 0;
$is_savewine_store = pdo_fetch("select * from " . tablename($this->table_stores) . " WHERE weid =:weid AND is_savewine=1 AND deleted=0 LIMIT 1", array(':weid' => $weid));
if ($is_savewine_store) {
    $is_savewine = 1;
}

$is_permission = false;
$tousers = explode(',', $setting['tpluser']);
if (in_array($from_user, $tousers)) {
    $is_permission = true;
}
if ($is_permission == false) {
    $accounts = pdo_fetchall("SELECT storeid FROM " . tablename($this->table_account) . " WHERE weid = :weid AND from_user=:from_user AND
 status=2 ORDER BY id DESC ", array(':weid' => $this->_weid, ':from_user' => $from_user));
    if ($accounts) {
        $arr = array();
        foreach ($accounts as $key => $val) {
            $arr[] = $val['storeid'];
        }
        $storeids = implode(',', $arr);
        $is_permission = true;
    }
}

$deliveryuser = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " where weid=:weid AND role=4 AND from_user=:from_user AND status=2
LIMIT 1", array(':weid' => $weid, ':from_user' => $from_user));

$count = pdo_fetchcolumn("SELECT count(1) FROM " . tablename($this->table_stores) . " a INNER JOIN " . tablename($this->table_collection) . " b ON a.id = b.storeid where  a.weid = :weid and is_show=1 and b.from_user=:from_user ORDER BY a.displayorder DESC, a.id DESC", array(':weid' => $weid, ':from_user' => $from_user));

$this->checkRechargePrice($from_user);

load()->model('mc');
$user = mc_fetch($from_user);
$score = intval($user['credit1']); //剩余积分
$coin = $user['credit2']; //余额
$coin = empty($coin) ? '0.00' : $coin;

$share_title = !empty($setting['share_title']) ? str_replace("#username#", $nickname, $setting['share_title']) : "您的朋友{$nickname}邀请您来吃饭";
$share_desc = !empty($setting['share_desc']) ? str_replace("#username#", $nickname, $setting['share_desc']) : "最新潮玩法，快来试试！";
$share_image = !empty($setting['share_image']) ? tomedia($setting['share_image']) : tomedia("../addons/weisrc_dish/icon.jpg");
$share_url = $_W['siteroot'] . 'app/' . $this->createMobileUrl('usercenter', array('agentid' => $fans['id']), true);

$is_commission = 0;
$commission_tip = "";
$agent_url = $_W['siteroot'] . 'app/' . $this->createMobileUrl('usercenter', array('agentid' => $fans['id']), true);
$qrcode_url = $this->createMobileUrl('GetQrcode',array('url'=>$agent_url)); //

$auto_commission_coin = intval($setting['auto_commission_coin']);
if ($setting['is_auto_commission']==1 && $auto_commission_coin > 0) { //自动成为分销商
    if ($coin >= $auto_commission_coin) { //条件达到
        pdo_update($this->table_fans, array('is_commission' => 2), array('id' => $fans['id']));
        $fans = $this->getFansByOpenid($from_user);
    }
}

if ($setting['is_commission']==1) { //开启分销
    if ($setting['commission_mode'] == 2) { //代理商模式
        $scene_str = 'fxdish_' . $fans['id'];
        if ($fans['is_commission']==2) { //代理商
            if ($this->_accountlevel == 4) {
                if (!empty($setting['commission_keywords'])) {
                    $qrcode = $this->createQrcode($setting['commission_keywords'], $scene_str, '餐饮分销' . $scene_str);
                    if ($qrcode) {
                        $qrcode_url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($qrcode['ticket']);
                        pdo_update($this->table_fans, array('scene_str' => $scene_str), array('id' => $fans['id']));
                    }
                }
            }
            $commission_tip = "[代理商]";
            $is_commission = 1;
            if ($fans['agentid'] == 0) {
                $commission_tip = "[股东]";
            }
        } else { //消费者
            $commission_tip = "[消费者]";
        }
    } else {
        $is_commission = 1;
    }
}

$ispop = 0;
if ($setting['tiptype'] == 1) { //关注后隐藏
    if ($sub == 0) {
        $ispop = 1;
    }
} else if ($setting['tiptype'] == 2) {
    $ispop = 1;
}
$follow_title = !empty($setting['follow_title']) ? $setting['follow_title'] : "立即关注";
$follow_desc = !empty($setting['follow_desc']) ? $setting['follow_desc'] : "欢迎关注智慧点餐点击马上加入,
助力品牌推广 ";
$follow_image = !empty($setting['follow_logo']) ? tomedia($setting['follow_logo']) : tomedia(".
./addons/weisrc_dish/icon.jpg");
$tipqrcode = tomedia($setting['tipqrcode']);
$tipbtn = intval($setting['tipbtn']);
$follow_url = $setting['follow_url'];

include $this->template($this->cur_tpl . '/usercenter');