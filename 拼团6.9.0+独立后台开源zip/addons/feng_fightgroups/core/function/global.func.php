<?php
/**
 * [weliam] Copyright (c) 2016/3/23
 * 拼团商城公共方法
 */
defined('IN_IA') or exit('Access Denied');
/********************web页面跳转************************/
function web_url($segment, $params = array()) {
	global $_W,$_GPC;
	session_start();
	list($do, $ac, $op,$todo) = explode('/', $segment);
	if((!empty($_GPC['merchantid']) || $params['role']=='merchant')&& $_SESSION['role']=='merchant'){
		$url = $_W['siteroot'] . 'web/wlmerch.php?';
	}else{
		$url = $_W['siteroot'] . 'web/index.php?c=site&a=entry&m=feng_fightgroups&';
	}
	
	if (!empty($do)) {
		$url .= "do={$do}&";
	}
	if (!empty($ac)) {
		$url .= "ac={$ac}&";
	}
	if (!empty($op)) {
		$url .= "op={$op}&";
	}
	if (!empty($todo)) {
		$url .= "todo={$todo}&";
	}
	if (!empty($params)) {
		$queryString = http_build_query($params, '', '&');
		$url .= $queryString;
	}
	return $url;
}

/********************app页面跳转************************/
function app_url($segment, $params = array()) {
	global $_W;
	list($do, $ac, $op) = explode('/', $segment);
	$url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=feng_fightgroups&';
	if (!empty($do)) {
//		if($do == 'home' && $ac == 'index'){
//			$do = 'goods';
//		}
		$url .= "do={$do}&";
	}
	if (!empty($ac)) {
//		if($do == 'goods' && $ac == 'index'){
//			$ac = 'lottery';
//		}
		$url .= "ac={$ac}&";
	}
	if (!empty($op)) {
		$url .= "op={$op}&";
	}
	if (!empty($params)) {
		$queryString = http_build_query($params, '', '&');
		$url .= $queryString;
	}
	if(substr($url,-1) == '&'){
		$url = substr($url,0,strlen($url)-1); 
	}
	return $url;
}

function mobile_mask($mobile) {
	return substr($mobile, 0, 3) . '****' . substr($mobile, 7);
}

function wl_debug($value) {
	echo "<br><pre>";
	print_r($value);
	echo "</pre>";
	exit ;
}

function wl_log($message, $data = '') {
	if ($data) {
		pdo_insert('core_text', array('content' => iserializer($data)));
		$text_id = pdo_insertid();
	}
	$log = array('errno' => 0, 'message' => $message, 'text_id' => intval($text_id), 'createtime' => TIMESTAMP, 'ip' => CLIENT_IP);
	pdo_insert('core_error_log', $log);
}

function api_log($message, $data = '') {
	if (DEVELOPMENT && ((CURRENT_IP && CURRENT_IP == CLIENT_IP) || CURRENT_IP == '')) {
		if ($data) {
			$message .= ' -> ';
			if (is_resource($data)) {
				$message .= '资源文件';
			} elseif (gettype($data) == 'object' || is_array($data)) {
				$message .= iserializer($data);
			} else {
				$message .= $data;
			}
		}
		$filename = IA_ROOT . '/data/logs/api-log-' . date('Ymd', TIMESTAMP) . '.' . $_GET['platform'] . '.txt';
		if (!file_exists($filename)) {
			load() -> func('file');
			mkdirs(dirname($filename));
		}
		file_put_contents($filename, $message . PHP_EOL . PHP_EOL, FILE_APPEND);
	}
}

function pwd_hash($password, $salt) {
	return md5("{$password}-{$salt}-{$GLOBALS['_W']['config']['setting']['authkey']}");
}

function ajax_post_only() {
	global $_W;
	if (empty($_W['isajax']) || empty($_W['ispost'])) {
		access_denied('ajax && post only');
	}
}

function is_weixin() {
	if (empty($_SERVER['HTTP_USER_AGENT']) || strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'Windows Phone') === false) {
		return false;
	}
	return true;
}

function removeEmoji($text) {
	$clean_text = "";
	$regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
	$clean_text = preg_replace($regexEmoticons, '', $text);
	$regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
	$clean_text = preg_replace($regexSymbols, '', $clean_text);
	$regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
	$clean_text = preg_replace($regexTransport, '', $clean_text);
	$regexMisc = '/[\x{2600}-\x{26FF}]/u';
	$clean_text = preg_replace($regexMisc, '', $clean_text);
	$regexDingbats = '/[\x{2700}-\x{27BF}]/u';
	$clean_text = preg_replace($regexDingbats, '', $clean_text);

	return $clean_text;
}

function wl_template($filename, $flag = '') {
	global $_W;
	$name = 'feng_fightgroups';
	if (defined('IN_SYS')) {
		$template = $_W['tgsetting']['style']['webview'];
		if (empty($template)) {
			$template = "default";
		}
		$source = IA_ROOT . "/addons/{$name}/web/view/{$template}/{$filename}.html";
		$compile = IA_ROOT . "/data/tpl/web/{$name}/web/view/{$template}/{$filename}.tpl.php";
		if (!is_file($source)) {
			$source = IA_ROOT . "/addons/{$name}/web/view/default/{$filename}.html";
		}
	} else {
		$template = $_W['tgsetting']['style']['appview'];
		if (empty($template)) {
			$template = "default";
		}
		$source = IA_ROOT . "/addons/{$name}/app/view/{$template}/{$filename}.html";
		$compile = IA_ROOT . "/data/tpl/app/{$name}/app/view/{$template}/{$filename}.tpl.php";
		if (!is_file($source)) {
			$source = IA_ROOT . "/addons/{$name}/app/view/default/{$filename}.html";
		}
	}
	if (!is_file($source)) {
		exit("Error: template source '{$filename}' is not exist!!!");
	}
	if (!is_file($compile) || filemtime($source) > filemtime($compile)) {
		wl_template_compile($source, $compile, true);

	}
	if ($flag == TEMPLATE_FETCH) {
		extract($GLOBALS, EXTR_SKIP);
		ob_end_flush();
		ob_clean();
		ob_start();
		include $compile;
		$contents = ob_get_contents();
		ob_clean();
		return $contents;
		
	}else if($flag == 'template'){
			extract($GLOBALS, EXTR_SKIP);
			return $compile;
	}else{
		return $compile;
	}
	
}

/********************app端自定义页面加载************************/
function wl_template_page($id, $flag = TEMPLATE_DISPLAY) {
	global $_W;
	$page = wl_page($id);
	if (empty($page)) {
		return error(1, 'Error: Page is not found');
	}
	if (empty($page['html'])) {
		return '';
	}
	$compile = IA_ROOT . "/data/tpl/app/{$id}.default.tpl.php";
	$path = dirname($compile);
	if (!is_dir($path)) {
		load() -> func('file');
		mkdirs($path);
	}
	$content = wl_template_parse($page['html']);
	file_put_contents($compile, $content);
	switch ($flag) {
		case TEMPLATE_DISPLAY :
		default :
			extract($GLOBALS, EXTR_SKIP);
			include  wl_template('common/app_header');
			include $compile;
			include  wl_template('common/app_footer');
			break;
		case TEMPLATE_FETCH :
			extract($GLOBALS, EXTR_SKIP);
			ob_clean();
			ob_start();
			include $compile;
			$contents = ob_get_contents();
			ob_clean();
			return $contents;
			break;
		case TEMPLATE_INCLUDEPATH :
			return $compile;
			break;
	}
}

/********************web端自定义页面加载************************/
function wl_tpl_wappage_editor($editorparams = '', $editormodules = array()) {
	global $_GPC;
	$content = '';
	load() -> func('file');
	$filetree = file_tree(IA_ROOT . '/addons/feng_fightgroups/web/view/default/wapeditor');
	if (!empty($filetree)) {
		foreach ($filetree as $file) {
			if (strexists($file, 'widget-')) {
				$fileinfo = pathinfo($file);
				$_GPC['iseditor'] = false;
				$display = wl_template('wapeditor/' . $fileinfo['filename'], TEMPLATE_FETCH);
				$_GPC['iseditor'] = true;
				$editor = wl_template('wapeditor/' . $fileinfo['filename'], TEMPLATE_FETCH);
				$content .= "<script type=\"text/ng-template\" id=\"{$fileinfo['filename']}-display.html\">" . str_replace(array("\r\n", "\n", "\t"), '', $display) . "</script>";
				$content .= "<script type=\"text/ng-template\" id=\"{$fileinfo['filename']}-editor.html\">" . str_replace(array("\r\n", "\n", "\t"), '', $editor) . "</script>";
			}
		}
	}
	return $content;
}

/********************web端自定义页面加载************************/
//function wl_tpl_ueditor($id, $value = '') {
//	$s = '';
//	if (!defined('TPL_INIT_UEDITOR')) {
//		$s .= '<script type="text/javascript" src="../../../../web/resource/components/ueditor/ueditor.config.js"></script><script type="text/javascript" src="../../../../web/resource/components/ueditor/ueditor.all.min.js"></script><script type="text/javascript" src="../../../../web/resource/components/ueditor/lang/zh-cn/zh-cn.js"></script>';
//	}
//	$s .= !empty($id) ? "<textarea id=\"{$id}\" name=\"{$id}\" type=\"text/plain\" style=\"height:300px;\">{$value}</textarea>" : '';
//	$s .= '<script type="text/javascript">var ueditoroption={autoClearinitialContent:!1,toolbars:[["fullscreen","source","preview","|","bold","italic","underline","strikethrough","forecolor","backcolor","|","justifyleft","justifycenter","justifyright","|","insertorderedlist","insertunorderedlist","blockquote","emotion","insertvideo","link","removeformat","|","rowspacingtop","rowspacingbottom","lineheight","indent","paragraph","fontsize","|","inserttable","deletetable","insertparagraphbeforetable","insertrow","deleterow","insertcol","deletecol","mergecells","mergeright","mergedown","splittocells","splittorows","splittocols","|","anchor","map","print","drafts"]],elementPathEnabled:!1,initialFrameHeight:500,focus:!1,maximumWords:9999999999999,autoFloatEnabled:!1,imageScaleEnabled:!1};UE.registerUI("myinsertimage",function(a,b){a.registerCommand(b,{execCommand:function(){require(["uploader"],function(b){b.show(function(b){if(0!=b.length)if(b.url)a.execCommand("insertimage",{src:b.url,_src:b.url,width:"100%",alt:b.filename});else{var c=[];for(i in b)c.push({src:b[i].url,_src:b[i].url,width:"100%",alt:b[i].filename});a.execCommand("insertimage",c)}})})}});var c=new UE.ui.Button({name:"插入图片",title:"插入图片",cssRules:"background-position: -726px -77px",onclick:function(){a.execCommand(b)}});return a.addListener("selectionchange",function(){var d=a.queryCommandState(b);-1==d?(c.setDisabled(!0),c.setChecked(!1)):(c.setDisabled(!1),c.setChecked(d))}),c},19)' . (!empty($id) ? ',$(function(){var a=UE.getEditor("' . $id . '",ueditoroption);$("#' . $id . '").data("editor",a),$("#' . $id . '").parents("form").submit(function(){a.queryCommandState("source")&&a.execCommand("source")})});' : ';') . "</script>";
//	return $s;
//}

function wl_template_compile($from, $to, $inmodule = false) {
	$path = dirname($to);
	if (!is_dir($path)) {
		load() -> func('file');
		mkdirs($path);
	}
	$content = wl_template_parse(file_get_contents($from), $inmodule);
	if (IMS_FAMILY == 'x' && !preg_match('/(footer|header)+/', $from)) {
		$content = str_replace('微擎', '系统', $content);
	}
	file_put_contents($to, $content);
}

function wl_template_parse($str, $inmodule = false) {
	$str = preg_replace('/<!--{(.+?)}-->/s', '{$1}', $str);
	$str = preg_replace('/{template\s+(.+?)}/', '<?php (!empty($this) && $this instanceof WeModuleSite || ' . intval($inmodule) . ') ? (include $this->template($1, TEMPLATE_INCLUDEPATH)) : (include template($1, TEMPLATE_INCLUDEPATH));?>', $str);

	$str = preg_replace('/{php\s+(.+?)}/', '<?php $1?>', $str);
	$str = preg_replace('/{if\s+(.+?)}/', '<?php if($1) { ?>', $str);
	$str = preg_replace('/{else}/', '<?php } else { ?>', $str);
	$str = preg_replace('/{else ?if\s+(.+?)}/', '<?php } else if($1) { ?>', $str);
	$str = preg_replace('/{\/if}/', '<?php } ?>', $str);
	$str = preg_replace('/{loop\s+(\S+)\s+(\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2) { ?>', $str);
	$str = preg_replace('/{loop\s+(\S+)\s+(\S+)\s+(\S+)}/', '<?php if(is_array($1)) { foreach($1 as $2 => $3) { ?>', $str);
	$str = preg_replace('/{\/loop}/', '<?php } } ?>', $str);
	$str = preg_replace('/{(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)}/', '<?php echo $1;?>', $str);
	$str = preg_replace('/{(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff\[\]\'\"\$]*)}/', '<?php echo $1;?>', $str);
	$str = preg_replace('/{url\s+(\S+)}/', '<?php echo url($1);?>', $str);
	$str = preg_replace('/{url\s+(\S+)\s+(array\(.+?\))}/', '<?php echo url($1, $2);?>', $str);
	$str = preg_replace_callback('/<\?php([^\?]+)\?>/s', "template_addquote", $str);
	$str = preg_replace('/{([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)}/s', '<?php echo $1;?>', $str);
	$str = str_replace('{##', '{', $str);
	$str = str_replace('##}', '}', $str);
	$str = "<?php defined('IN_IA') or exit('Access Denied');?>" . $str;
	return $str;
}

function wl_template_addquote($matchs) {
	$code = "<?php {$matchs[1]}?>";
	$code = preg_replace('/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\](?![a-zA-Z0-9_\-\.\x7f-\xff\[\]]*[\'"])/s', "['$1']", $code);
	return str_replace('\\\"', '\"', $code);
}

$my_scenfiles = array();
function my_scandir($dir) {
	global $my_scenfiles;
	if ($handle = opendir($dir)) {
		while (($file = readdir($handle)) !== false) {
			if ($file != ".." && $file != ".") {
				if (is_dir($dir . "/" . $file)) {
					my_scandir($dir . "/" . $file);
				} else {
					$my_scenfiles[] = $dir . "/" . $file;
				}
			}
		}
		closedir($handle);
	}
}

function currency_format($currency, $decimals = 2) {
	$currency = floatval($currency);
	if (empty($currency)) {
		return '0.00';
	}
	$currency = number_format($currency, $decimals);
	$currency = str_replace(',', '', $currency);
	return $currency;
}

function finance($openid = '', $paytype = 0, $money = 0, $trade_no = '', $desc = '') {
	global $_W;
	if (empty($openid)) {
		return error(-1, 'openid不能为空');
	}
	$setting = uni_setting($_W['uniacid'], array('payment'));
	if (!is_array($setting['payment'])) {
		return error(1, '没有设定支付参数');
	}
	$wechat = $setting['payment']['wechat'];
	$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
	$row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
	$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
	$pars = array();
	$pars['mch_appid'] = $row['key'];
	$pars['mchid'] = $wechat['mchid'];
	$pars['nonce_str'] = random(32);
	$pars['partner_trade_no'] = empty($trade_no) ? time() . random(4, true) : $trade_no;
	$pars['openid'] = $openid;
	$pars['check_name'] = 'NO_CHECK';
	$pars['amount'] = $money;
	$pars['desc'] = empty($desc) ? '商家佣金提现' : $desc;
	$pars['spbill_create_ip'] = gethostbyname($_SERVER["HTTP_HOST"]);
	ksort($pars, SORT_STRING);
	$string1 = '';
	foreach ($pars as $k => $v) {
		$string1 .= "{$k}={$v}&";
	}
	$string1 .= "key=" . $wechat['apikey'];
	$pars['sign'] = strtoupper(md5($string1));
	$xml = array2xml($pars);
	$path_cert = IA_ROOT . '/attachment/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_cert.pem';
	//证书路径
	$path_key = IA_ROOT . '/attachment/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_key.pem';
	//证书路径
	if (!file_exists($path_cert) || !file_exists($path_key)) {
		$path_cert = IA_ROOT . '/addons/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_cert.pem';
		$path_key = IA_ROOT . '/addons/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_key.pem';
	}
	$extras = array();
	$extras['CURLOPT_SSLCERT'] = $path_cert;
	$extras['CURLOPT_SSLKEY'] = $path_key;
	//			$extras['CURLOPT_CAINFO'] = IA_ROOT . str_replace("../", "/", $pay['weixin_root']);
	load() -> func('communication');
	$resp = ihttp_request($url, $xml, $extras);
	
	if (empty($resp['content'])) {
		return error(-2, '网络错误');
	} else {
		$arr = json_decode(json_encode((array) simplexml_load_string($resp['content'])), true);
		$xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
		$dom = new \DOMDocument();
		if ($dom -> loadXML($xml)) {
			$xpath = new \DOMXPath($dom);
			$code = $xpath -> evaluate('string(//xml/return_code)');
			$ret = $xpath -> evaluate('string(//xml/result_code)');
			if (strtolower($code) == 'success' && strtolower($ret) == 'success') {
				return true;
			} else {
				$error = $xpath -> evaluate('string(//xml/err_code_des)');
				return error(-2, $error);
			}
		} else {
			return error(-1, '未知错误');
		}
	}

}

/*创建或更新浏览量*/
function puv($openid = '', $goodsid = '') {
	global $_W;
	if(empty($openid)) return flase;
	if (!empty($goodsid)) {
		$goods = pdo_fetch("select pv,uv,merchantid from" . tablename('tg_goods') . "where uniacid={$_W['uniacid']} and id={$goodsid}");
		$mygp = pdo_fetch("select openid from" . tablename('tg_puv_record') . "where uniacid={$_W['uniacid']} and openid='{$openid}' and goodsid={$goodsid}");
		pdo_insert('tg_puv_record', array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'goodsid' => $goodsid, 'createtime' => TIMESTAMP,'merchantid'=>$goods['merchantid']));
		$id = pdo_insertid();
		if (!empty($mygp)) {
			pdo_update('tg_goods', array('pv' => $goods['pv'] + 1), array('id' => $goodsid));
		} else {
			pdo_update('tg_goods', array('pv' => $goods['pv'] + 1, 'uv' => $goods['uv'] + 1), array('id' => $goodsid));
			pdo_update('tg_puv_record', array('status'=>1,'merchantid'=>$goods['merchantid']), array('id' => $id));
		}
	}
}

function puvindex($openid = '') {
	global $_W;
	if(empty($openid)) return flase;
	$pu = pdo_fetch("select * from" . tablename('tg_puv') . "where uniacid={$_W['uniacid']} limit 1");
	if (empty($pu)) {
		pdo_insert('tg_puv', array('uniacid' => $_W['uniacid'], 'pv' => 0, 'uv' => 0));
		$pu = pdo_fetch("select * from" . tablename('tg_puv') . "where uniacid={$_W['uniacid']} limit 1");
	}
	$myp = pdo_fetch("select openid from" . tablename('tg_puv_record') . "where uniacid={$_W['uniacid']} and openid='{$openid}' ");
	pdo_insert('tg_puv_record', array('uniacid' => $_W['uniacid'], 'openid' => $openid, 'goodsid' => 0, 'createtime' => TIMESTAMP));
	$id = pdo_insertid();
	if (!empty($myp)) {
		pdo_update('tg_puv', array('pv' => $pu['pv'] + 1), array('id' => $pu['id']));
	} else {
		pdo_update('tg_puv', array('pv' => $pu['pv'] + 1, 'uv' => $pu['uv'] + 1), array('id' => $pu['id']));
		pdo_update('tg_puv_record', array('status'=>1), array('id' => $id));
	}

}

function wl_message($msg, $redirect = '', $type = '') {
	global $_W;
	if ($redirect == 'refresh') {
		$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
	} elseif (!empty($redirect) && !strexists($redirect, 'http://')) {
		$urls = parse_url($redirect);
		$redirect = $_W['siteroot'] . 'app/index.php?' . $urls['query'];
	}
	if ($redirect == '') {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
	} else {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
	}
	if ($_W['isajax'] || $type == 'ajax') {
		$vars = array();
		if(is_array($msg)) {
			$vars['errno'] = $msg['errno'];
			$vars['message'] = $msg['message'];
		}else{
			$vars['message'] = $msg;
		}
		$vars['redirect'] = $redirect;
		$vars['type'] = $type;
		
		exit(json_encode($vars));
	}
	if (empty($msg) && !empty($redirect)) {
		header('location: ' . $redirect);
	}
	$label = $type;
	if ($type == 'error') {
		$label = 'danger';
	}
	if ($type == 'ajax' || $type == 'sql') {
		$label = 'warning';
	}
	if (defined('IN_API')) {
		exit($msg);
	}
	include  wl_template('common/message', TEMPLATE_INCLUDEPATH);
	exit();
}

function wl_json($status = 1, $return = null) {
	$ret = array('status' => $status);
	if ($return) {
		$ret['result'] = $return;
	}
	die(json_encode($ret));
}

function refund($orderno, $type) {
	global $_W;
	include_once TG_CERT . 'WxPay.Api.php';
	load() -> model('account');
	load() -> func('communication');
	wl_load() -> model('setting');
	$WxPayApi = new WxPayApi();
	$input = new WxPayRefund();
	$accounts = uni_accounts();
	$acid = $_W['uniacid'];
	$path_cert = IA_ROOT . '/attachment/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_cert.pem';
	$path_key = IA_ROOT . '/attachment/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_key.pem';
	$account_info = pdo_fetch("select * from" . tablename('account_wechats') . "where uniacid={$_W['uniacid']}");
	$refund_order = pdo_fetch("select * from" . tablename('tg_order') . "where orderno ='{$orderno}'");
	$goods = pdo_fetch("select * from" . tablename('tg_goods') . "where id='{$refund_order['g_id']}'");
	$settings = setting_get_by_name('refund');

	if (!file_exists($path_cert) || !file_exists($path_key)) {
		$path_cert = TG_CERT . $_W['uniacid'] . '/apiclient_cert.pem';
		$path_key = TG_CERT . $_W['uniacid'] . '/apiclient_key.pem';
	}
	$key = $settings['apikey'];
	$mchid = $settings['mchid'];
	$appid = $account_info['key'];
	$fee = $refund_order['price'] * 100;
	$refundid = $refund_order['transid'];
	$input -> SetAppid($appid);
	$input -> SetMch_id($mchid);
	$input -> SetOp_user_id($mchid);
	$input -> SetRefund_fee($fee);
	$input -> SetTotal_fee($refund_order['price'] * 100);
	$input -> SetTransaction_id($refundid);
	$input -> SetOut_refund_no($refund_order['orderno']);
	$result = $WxPayApi -> refund($input, 6, $path_cert, $path_key, $key);

	$data = array('merchantid' => $refund_order['merchantid'], 'transid' => $refund_order['transid'], 'refund_id' => $result['refund_id'], 'createtime' => TIMESTAMP, 'status' => 0, 'type' => $type, 'goodsid' => $refund_order['g_id'], 'orderid' => $refund_order['id'], 'payfee' => $refund_order['price'], 'refundfee' => $fee * 0.01, 'refundername' => $refund_order['addname'], 'refundermobile' => $refund_order['mobile'], 'goodsname' => $goods['gname'], 'uniacid' => $_W['uniacid']);
	pdo_insert('tg_refund_record', $data);
	if ($result['return_code'] == 'SUCCESS') {
		if ($type == 3) {
			pdo_update('tg_order', array('status' => 7, 'is_tuan' => 2), array('id' => $refund_order['id']));
		} else {
			pdo_update('tg_order', array('status' => 7), array('id' => $refund_order['id']));
		}
		pdo_update('tg_refund_record', array('status' => 1), array('transid' => $refund_order['transid']));
		pdo_query("update" . tablename('tg_goods') . " set gnum=gnum+1 where id = '{$refund_order['g_id']}'");
		return 'success';
	} else {
		if ($type == 3) {
			pdo_update('tg_order', array('status' => 6, 'is_tuan' => 2), array('id' => $refund_order['id']));
		} else {
			pdo_update('tg_order', array('status' => 6), array('id' => $refund_order['id']));
		}
		return 'fail';
	}
}

function check_refund() {
	global $_W;
	$sql = "SELECT orderno,id,openid,price,pay_price,id FROM " . tablename('tg_order') . " where mobile<>'虚拟' and status=:status and openid=:openid  and uniacid=:uniacid";
	$params[':status'] = 6;
	$params[':openid'] = $_W['openid'];
	$params[':uniacid'] = $_W['uniacid'];
	$orders = pdo_fetchall($sql, $params);
	foreach ($orders as $key => $value) {
		$res= model_order::refundMoney($value['id'],$value['price'],'',1);;
	}

}

/*openid=>uid*/
function mc_openidTouid($openid = '') {
	global $_W;
	if (is_numeric($openid)) {
		return $openid;
	}
	if (is_string($openid)) {
		$sql = 'SELECT uid FROM ' . tablename('mc_mapping_fans') . ' WHERE `uniacid`=:uniacid AND `openid`=:openid';
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
		$pars[':openid'] = $openid;
		$uid = pdo_fetchcolumn($sql, $pars);
		return $uid;
	}
	if (is_array($openid)) {
		$uids = array();
		foreach ($openid as $k => $v) {
			if (is_numeric($v)) {
				$uids[] = $v;
			} elseif (is_string($v)) {
				$fans[] = $v;
			}
		}
		if (!empty($fans)) {
			$sql = 'SELECT uid, openid FROM ' . tablename('mc_mapping_fans') . " WHERE `uniacid`=:uniacid AND `openid` IN ('" . implode("','", $fans) . "')";
			$pars = array(':uniacid' => $_W['uniacid']);
			$fans = pdo_fetchall($sql, $pars, 'uid');
			$fans = array_keys($fans);
			$uids = array_merge((array)$uids, $fans);
		}
		return $uids;
	}
	return false;
}

/*模板消息*/
function sendtplnotice($touser, $template_id, $postdata, $url = '', $account = null) {
	global $_W;
	load() -> model('account');
	if (!$account) {
		if (!empty($_W['acid'])) {
			$account = WeAccount::create($_W['acid']);
		} else {
			$acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE `uniacid`=:uniacid LIMIT 1", array(':uniacid' => $_W['uniacid']));
			$account = WeAccount::create($acid);
		}
	}
	if (!$account) {
		return;
	}
	return $account -> sendTplNotice($touser, $template_id, $postdata, $url);
}

/*自动成团*/
function get_head_img($url, $num) {
	$imgs_array = array();
	$random_array = array();
	$files = array();
	if (is_dir($url)){
		if ($handle = opendir($url)) {
			while (($file = readdir($handle)) !== false){
				if ($file != "." && $file != "..") {
					if (substr($file, -3) == 'gif' || substr($file, -3) == 'jpg')
						$files[count($files)] = $file;
				}
			}
			closedir($handle);
		}
	}
	
	for ($i = 0; $i < $num; $i++) {
		$random = rand(0, count($files) - 1);
		while (in_array($random, $random_array)) {
			$random = rand(0, count($files) - 1);
		}
		$random_array[$i] = $random;
		$imgs_url ="../addons/feng_fightgroups/web/resource/images/head_imgs/" . $files[$random];
		$imgs_array[$i] = $imgs_url;

	}
	return $imgs_array;
}

function get_nickname($filename, $num) {
	$nickname_array = array();
	$random_array = array();
	$file_new = fopen($filename, "r");
	$file_read = fread($file_new, filesize($filename));
	fclose($file_new);
	$arr_new = unserialize($file_read);
	for ($i = 0; $i < $num; $i++) {
		$random = rand(0, count($arr_new) - 1);
		while (in_array($random, $random_array)) {
			$random = rand(0, count($arr_new) - 1);
		}
		$random_array[$i] = $random;
		$nickname = $arr_new[$random];
		$nickname_array[$i] = $nickname;

	}
	return $nickname_array;
}

function get_randtime($inittime = 0, $now = 0, $num) {
	$randtime_array = array();
	$max = $now - $inittime;
	for ($i = 0; $i < $num; $i++) {
			$r2 = rand(1, $max);
			$randtime_array[$i] = $inittime + $r2;
		}
	
	return $randtime_array;
}

function permissions($do, $ac, $op, $v1, $v2, $v3, $n1, $n2, $n3) {
	global $_W;
	$role_do = pdo_fetch("select * from" . tablename('tg_user_node') . "where do='{$v1}' and ac= '' and op = ''");
	$role_ac = pdo_fetch("select * from" . tablename('tg_user_node') . "where do='{$v1}' and ac='{$v2}' and op = '' ");
	$role_op = pdo_fetch("select * from" . tablename('tg_user_node') . "where do='{$v1}' and ac='{$v2}' and op='{$v3}' ");
	if (empty($role_do)) {
		$user_do = array('do'=>$v1,'ac'=>'','op'=>'','do_id'=>0,'ac_id'=>0,'level'=>1,'status'=>2 ,'name'=>$n1);
		pdo_insert('tg_user_node',$user_do);
		$do_id = pdo_insertid();
	}else{
		$do_id = $role_do['id'];
	}
	if (empty($role_ac)) {
		$user_ac = array('do'=>$v1,'ac'=>$v2,'op'=>'','do_id'=>$do_id,'ac_id'=>0,'level'=>2,'status'=>2 ,'name'=>$n2);
		pdo_insert('tg_user_node',$user_ac);
		$ac_id = pdo_insertid();
	}else{
		$ac_id = $role_ac['id'];
	}
	if (empty($role_op)) {
		$user_op = array('do'=>$v1,'ac'=>$v2,'op'=>$v3,'do_id'=>$do_id,'ac_id'=>$ac_id,'level'=>3,'status'=>2 ,'name'=>$n3);
		pdo_insert('tg_user_node',$user_op);
	}
}

function allow($do, $ac, $op, $merchantid) {
	global $_W;
	if(empty($op)){
		if($do == 'data'){
			$op = 'display';
		}elseif ($do == 'order') {
			$op = 'all';
		}
	}
	$role_op = pdo_fetch_one('tg_user_node', array('do' => $do, 'ac' => $ac, 'op' => $op));
	$role = pdo_fetch("select * from" . tablename('tg_user_role') . "where uniacid={$_W['uniacid']} and merchantid={$merchantid}");
	$nodes = unserialize($role['nodes']);
	if (!empty($role_op['id']) && !empty($nodes)) {
		if (in_array($role_op['id'], $nodes)) {
			return TRUE;
		} else {
			return FALSE;
		}
	} else {
		return FALSE;
	}

}

function merchant() {
	global $_W;
	$uid = $_W['uid'];
	$merchant = pdo_fetch("select * from" . tablename('tg_merchant') . "where uid=:uid ", array(':uid' => $uid));
	if (empty($merchant)) {
		message("未分配帐号，无权查看！您可以去拼团主程序添加商家并分配帐号，用分配的帐号登录多商家后台！");
		exit ;
	} else {
		return $merchant['id'];
	}
}

function oplog($user, $describe, $view_url, $data) {
	global $_W;
	$data = array('user' => $user, 'uniacid' => $_W['uniacid'], 'describe' => $describe, 'view_url' => $view_url, 'data' => $data, 'ip' => CLIENT_IP, 'createtime' => TIMESTAMP);
	pdo_insert("tg_oplog", $data);
}

function sendCustomNotice($openid, $msg, $url = '', $account = null) {
	global $_W;
	if (!$account) {
		load() -> model('account');
		$acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE `uniacid`=:uniacid LIMIT 1", array(':uniacid' => $_W['uniacid']));
		$account = WeAccount::create($acid);
	}
	if (!$account) {
		return;
	}
	$content = "";
	if (is_array($msg)) {
		foreach ($msg as $key => $value) {
			if (!empty($value['title'])) {
				$content .= $value['title'] . ":" . $value['value'] . "\n";
			} else {
				$content .= $value['value'] . "\n";
				if ($key == 0) {
					$content .= "\n";
				}
			}
		}
	} else {
		$content = $msg;
	}
	if (!empty($url)) {
		$content .= "<a href='{$url}'>点击查看详情</a>";
	}
	return $account -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode($content))));
}

function doRequest($url, $param=array()){  
    $urlinfo = parse_url($url);  
  
    $host = $urlinfo['host'];  
    $path = $urlinfo['path'];  
    $query = isset($param)? http_build_query($param) : '';  
  
    $port = 80;  
    $errno = 0;  
    $errstr = '';  
    $timeout = 10;  
  
    $fp = fsockopen($host, $port, $errno, $errstr, $timeout);  
  
    $out = "POST ".$path." HTTP/1.1\r\n";  
    $out .= "host:".$host."\r\n";  
    $out .= "content-length:".strlen($query)."\r\n";  
    $out .= "content-type:application/x-www-form-urlencoded\r\n";  
    $out .= "connection:close\r\n\r\n";  
    $out .= $query;  
  
    fputs($fp, $out);  
    fclose($fp);  
}

function keyExist($key = ''){
	global $_W;

	if (empty($key)) {
		return NULL;
	}

	$keyword = pdo_fetch('SELECT rid FROM ' . tablename('rule_keyword') . ' WHERE content=:content and uniacid=:uniacid limit 1 ', array(':content' => trim($key), ':uniacid' => $_W['uniacid']));

	if (!empty($keyword)) {
		$rule = pdo_fetch('SELECT * FROM ' . tablename('rule') . ' WHERE id=:id and uniacid=:uniacid limit 1 ', array(':id' => $keyword['rid'], ':uniacid' => $_W['uniacid']));

		if (!empty($rule)) {
			return $rule;
		}
	}
}
function createUniontid(){
	$randNum = substr(time(), -5).substr(microtime(), 2, 5).sprintf('%02d', rand(0, 99));
	$uniontid = date('YmdHis').$randNum;//生成商户订单号
	return $uniontid;
}
