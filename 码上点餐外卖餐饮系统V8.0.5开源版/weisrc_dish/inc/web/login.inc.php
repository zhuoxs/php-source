<?php

global $_W, $_GPC;
$weid = $this->_weid;
$action = 'start';
$title = $this->actions_titles[$action];
load()->func('tpl');

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    if (checksubmit('submit')) {
        load()->model('user');
        load()->model('message');
        load()->classs('oauth2/oauth2client');
        load()->model('setting');

        $member = array();
        $username = trim($_GPC['username']);
        if(empty($username)) {
            message('请输入要登录的用户名');
        }
        $member['username'] = $username;
        $member['password'] = $_GPC['password'];
        if(empty($member['password'])) {
            message('请输入密码');
        }
        $record = user_single($member);

        if(!empty($record)) {
            if($record['status'] == 1) {
                message('您的账号正在审核或是已经被系统禁止，请联系网站管理员解决！');
            }

            $account = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_account") . " WHERE status=2 AND uid=:uid ORDER BY id DESC LIMIT 1", array(':uid' => $record['uid']));
            if (!empty($account)) {
                $storeid = $account['storeid'];
                $_W['uniacid'] = $account['weid'];
            } else {
                message('您的账号正在审核或是已经被系统禁止，请联系网站管理员解决！!!');
            }

            $founders = explode(',', $_W['config']['setting']['founder']);
            $_W['isfounder'] = in_array($record['uid'], $founders);
            if (empty($_W['isfounder'])) {
                if (!empty($record['endtime']) && $record['endtime'] < TIMESTAMP) {
                    message('您的账号有效期限已过，请联系网站管理员解决！');
                }
            }
            if (!empty($_W['siteclose']) && empty($_W['isfounder'])) {
                message('站点已关闭，关闭原因：' . $_W['setting']['copyright']['reason']);
            }
            $cookie = array();
            $cookie['uid'] = $record['uid'];
            $cookie['lastvisit'] = $record['lastvisit'];
            $cookie['lastip'] = $record['lastip'];
            $cookie['hash'] = md5($record['password'] . $record['salt']);
            $session = $this->authcode(json_encode($cookie), 'encode');
            isetcookie('__session', $session, !empty($_GPC['rember']) ? 7 * 86400 : 0, true);
            $status = array();
            $status['uid'] = $record['uid'];
            $status['lastvisit'] = TIMESTAMP;
            $status['lastip'] = CLIENT_IP;
            user_update($status);

            $role = uni_permission($record['uid'], $_W['uniacid']);
            isetcookie('__uniacid', $_W['uniacid'], 7 * 86400);
            isetcookie('__uid', $record['uid'], 7 * 86400);

            $data = array(
                'lastvisit' => TIMESTAMP,
                'lastip' => CLIENT_IP,
            );
            pdo_update("weisrc_dish_account", $data, array('id' => $record['id']));

            if ($account['role'] == 1) { //店长
                message("欢迎回来～，{$record['username']}！", url('site/entry/start', array('m' => 'weisrc_dish', 'storeid' => $storeid)), 'success');
            } else if ($account['role'] == 3) { //站长
                message("欢迎回来～，{$record['username']}！", url('site/entry/stores', array('m' => 'weisrc_dish')), 'success');
            }
        } else {
            if (empty($failed)) {
                pdo_insert('users_failed_login', array('ip' => CLIENT_IP, 'username' => $username, 'count' => '1', 'lastupdate' => TIMESTAMP));
            } else {
                pdo_update('users_failed_login', array('count' => $failed['count'] + 1, 'lastupdate' => TIMESTAMP), array('id' => $failed['id']));
            }
            message('登录失败，请检查您输入的用户名和密码！');
        }
    }
} elseif ($operation == 'logout') {
    isetcookie('__session', '', -10000);
    isetcookie('__switch', '', -10000);
    $forward = url('site/entry/login', array('m' => 'weisrc_dish'));
    header('Location:' . $forward);
}

include $this->template('user/slogin');
