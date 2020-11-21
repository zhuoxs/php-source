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
    'login',   //每天登录
))?$_GPC['act']:'display';
if ($act == 'display') {
    $title = '首页';
    $pindex = max(1, intval($_GPC['page']));
    $pagesize = 10;
    $start = ($pindex - 1) * $pagesize;
    if ($_GPC['op'] == 'location') {//距离排序
        $latitude = $_GPC['lat'];
        $longitude = $_GPC['lng'];
        $sql = "SELECT *,(ROUND(6378.137 * 2 * ASIN(SQRT(POW(SIN(((lat * PI()) / 180 - (:latitude * PI()) / 180) / 2), 2) + COS((:latitude * PI()) / 180) * COS((lat * PI()) / 180) * POW(SIN(((lng * PI()) / 180 - (:longitude * PI()) / 180) / 2), 2))), 2)) AS distance FROM ".tablename('superman_hand2_item');
        $sql .= " WHERE uniacid=:uniacid AND status IN (1,2)";
        $sql .= " ORDER BY distance ASC LIMIT {$start},{$pagesize}";
        $params = array(
            ':uniacid' => $_W['uniacid'],
            ':latitude' => $latitude,
            ':longitude' => $longitude,
        );
    } else if ($_GPC['op'] == 'popular') {//人气排序
        $sql = "SELECT * FROM ".tablename('superman_hand2_item')." AS a LEFT JOIN (SELECT item_id, COUNT(*) AS num FROM ".tablename('superman_hand2_comment')." GROUP BY item_id) AS b ON a.id = b.item_id";
        $sql .= " WHERE uniacid=:uniacid AND status IN (1,2)";
        $sql .= " ORDER BY num DESC LIMIT {$start},{$pagesize}";
        $params = array(
            ':uniacid' => $_W['uniacid'],
        );
    } else {
        $params = array(
            ':uniacid' => $_W['uniacid'],
        );
        $sql = "SELECT * FROM " . tablename('superman_hand2_item') . " WHERE uniacid=:uniacid";
        $sql .= " AND status IN(1,2)";
        $sql .= " ORDER BY pay_position DESC, createtime DESC LIMIT {$start},{$pagesize}";
    }
    $list = pdo_fetchall($sql, $params);

    if ($list) {
        foreach ($list as &$li) {
            SupermanHandModel::superman_hand2_item($li);
        }
        unset($li);
    }
    //无限滚动
    if ($_W['isajax'] && $_GPC['load'] == 'infinite') {
        die(json_encode($list));
    }
    //幻灯图
    $slide = $this->module['config']['slide'];
    //分类
    $category = pdo_getall('superman_hand2_category', array('uniacid' => $_W['uniacid'], 'status' => 1), '*', '', 'displayorder DESC');
    //公告
    $notice = pdo_getall('superman_hand2_notice', array(
        'uniacid' => $_W['uniacid'],
        'position LIKE' => "%home%",
        'status' => 1
    ), '*', '', 'displayorder DESC');
    //分享
    $_share = array(
        'title' => $this->module['config']['seo']['title'],
        'desc' => $this->module['config']['seo']['description'],
        'imgUrl' => $this->module['config']['slide'][0]['img'] ? tomedia($this->module['config']['slide'][0]['img']) : $_W['account']['logo']
    );
    //每天登录
    $member_login = pdo_get('superman_hand2_member_login', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
    ));
    $starttime = strtotime(date('Y-m-d 00:00:00', TIMESTAMP));
    $login_tip = $member_login['dateline'] > $starttime ? 1 : 0;
} else if ($act == 'login') {
    $credit_setting = $this->module['config']['credit'];
    $member_login = pdo_get('superman_hand2_member_login', array(
        'uniacid' => $_W['uniacid'],
        'uid' => $_W['member']['uid'],
    ));
    $starttime = strtotime(date('Y-m-d 00:00:00', TIMESTAMP));
    if ($member_login['dateline'] > $starttime) {
        SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '今天已领取登录积分', 'error');
    }
    if ($credit_setting['open'] == 1 && $credit_setting['day']) {
        $credit_log = array(
            $_W['member']['uid'],
            '每天登录赠送积分',
            'superman_hand2',
        );
        $ret = mc_credit_update($_W['member']['uid'], 'credit1', $credit_setting['day'], $credit_log);
        if (is_error($ret)) {
            WeUtility::logging('fatal', '[home.inc.php: mc_credit_update], ret=' . var_export($ret, true));
            SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '赠送积分失败', 'error');
        }
        if ($member_login) {
            $ret1 = pdo_update('superman_hand2_member_login', array(
                'dateline' => TIMESTAMP
            ), array(
                'id' => $member_login['id']
            ));
            if ($ret1 === false) {
                SupermanHandUtil::json(SupermanHandErrno::INVALID_REQUEST, '数据库更新失败', 'error');
            }
        } else {
            $data = array(
                'uniacid' => $_W['uniacid'],
                'uid' => $_W['member']['uid'],
                'dateline' => TIMESTAMP,
            );
            pdo_insert('superman_hand2_member_login', $data);
            $new_id = pdo_insertid();
            if (empty($new_id)) {
                SupermanHandUtil::json(SupermanHandErrno::UPDATE_FAIL, '数据库更新失败', 'error');
            }
        }
        SupermanHandUtil::json(SupermanHandErrno::OK, '每天登录+'.$credit_setting['day'].'积分');
    }
}
include $this->template('home');
