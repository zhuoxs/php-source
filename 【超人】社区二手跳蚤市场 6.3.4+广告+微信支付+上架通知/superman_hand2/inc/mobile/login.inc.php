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
$act = in_array($_GPC['act'], array('check'))?$_GPC['act']:'check';
if ($act == 'check') {
    $openid = $_W['openid']?$_W['openid']:($_SESSION['openid']?$_SESSION['openid']:($_W['fans']?$_W['fans']['openid']:''));
    if (empty($_W['member']) && !empty($openid)) {
        $_W['member'] = mc_fetch(mc_openid2uid($openid));
        if (empty($_W['openid'])) {
            $_W['openid'] = $openid;
        }
    }
    $params = array();
    if (!empty($_SERVER['HTTP_REFERER'])) {
        $params = explode('?', $_SERVER['HTTP_REFERER']);
    }
    $url = murl("auth/login", array("forward" => base64_encode($params[1])));
    if (empty($_W['member'])) {
        SupermanHandUtil::json(SupermanHandErrno::NOT_LOGIN, '', array('url' => $url));
    }
    SupermanHandUtil::json(SupermanHandErrno::OK, '');
}
