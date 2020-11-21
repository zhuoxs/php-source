<?php
//__weliam_fix_siteroot();
load()->model('user');
load()->func('tpl');

$_W['token'] = token();
$session = json_decode(base64_decode($_GPC['___shop_session___']), true);
if (is_array($session)) {
    $_W['merch_id'] = $session['tg_mall']['merch_id'];
    $_W['uniacid'] = $session['tg_mall']['uniacid'];
	if(empty($controller) || empty($action)){
		$controller = 'site';
		$action = 'entry';
	}
} else {
    isetcookie('___shop_session___', false, -100);
}
//unset($session);

if (!empty($_W['uniacid'])) {
    $_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
    $_W['acid'] = $_W['account']['acid'];
    $_W['weid'] = $_W['uniacid'];
    isetcookie('__uniacid', $_W['uniacid'], 7 * 86400);
}

$_W['template'] = 'default';
load()->func('compat.biz');

//function __weliam_fix_siteroot() {
//  global $_W;
//  $urls = parse_url($_W['siteroot']);
//  $arr = explode('/', $urls['path']);
//  do {
//      $val = array_pop($arr);
//  } while ($val != 'addons');
//  $path = implode('/', $arr);
//  if(substr($path, -1) != '/') {
//      $path .= '/';
//  }
//  $urls['path'] = $path;
//  $_W['siteroot'] = $urls['scheme'].'://'.$urls['host'].((!empty($urls['port']) && $urls['port']!='80') ? ':'.$urls['port'] : '').$urls['path'];
//  $_W['siteurl'] = $urls['scheme'].'://'.$urls['host'].((!empty($urls['port']) && $urls['port']!='80') ? ':'.$urls['port'] : '') . $_W['script_name'].(empty($_SERVER['QUERY_STRING'])?'':'?') . $_SERVER['QUERY_STRING'];
//}