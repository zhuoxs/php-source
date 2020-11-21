<?php
/**
 * boguan_mall模块微站定义
 *
 * @author 阿莫源码社区
 * @url www.lanrenzhijia.com
 */
defined('IN_IA') or exit('Access Denied');
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

class Boguan_mallModuleSite extends WeModuleSite {


	public function doWebIndex() {
        global $_W;

        //print_r($_W);die;

        //session('W',$_W);
        redirect("../addons/".$_W['current_module']['name']."/boguan/index.php/boguan?uniacid={$_W['uniacid']}&uid={$_W['uid']}&name={$_W['username']}&ver={$_W['current_module']['version']}");
	}
	

}