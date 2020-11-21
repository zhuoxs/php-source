<?php
/**
 * 模块微站定义
 *
 * @author 众惠科技
 * @url http://bbs.we7.cc/ 
 */
global $_W;
defined('IN_IA') or exit('Access Denied');
define('POSETERH_ROOT',IA_ROOT.'/addons/zofui_posterhelp/');
define('POSETERH_URL',$_W['siteroot'].'addons/zofui_posterhelp/');
define('MODULE','zofui_posterhelp');
require_once(POSETERH_ROOT.'class/autoload.php');

class Zofui_posterhelpModuleSite extends WeModuleSite {
	
	
	
}