<?php
/**
 * dd_activity2模块微站定义
 *
 * @author 易福网
 * @url
 */
defined('IN_IA') or exit('Access Denied');

class Dd_activity2ModuleSite extends WeModuleSite {
	public $table_category = 'baoming_category';
	public $table_activity = 'baoming_activity';
	public $table_members = 'mc_members';
	public $table_sign_up = 'baoming_activity_sign_up';
	public $table_collection = 'baoming_collection';




	public function doMobileActivity_list() {
		$this->__mobile(__FUNCTION__);
	}

	public function doMobileActivity_category() {
		$this->__mobile(__FUNCTION__);
	}

	public function doMobileActivity_detail() {
		$this->__mobile(__FUNCTION__);
	}

	public function doMobileSelf() {
		$this->__mobile(__FUNCTION__);
	}


	public function doMobileMy_sign_up() {
		$this->__mobile(__FUNCTION__);
	}






	public function doWebActivity_list() {
		$this->__web(__FUNCTION__);
	}
	public function doWebSign_up() {
		$this->__web(__FUNCTION__);
	}
	public function doWebUsers_list() {
		$this->__web(__FUNCTION__);
	}




	public function __web($f_name)
	{

		global $_W, $_GPC;
		$uniacid = $_W['uniacid'];
		$uid = $_W['fans']['uid'];
		$op = $operation = $_GPC['op'] ? $_GPC['op'] : 'display';
		$do = strtolower(substr($f_name, 5));
		include_once 'web/' . strtolower(substr($f_name, 5)) . '.php';
	}
	public function __mobile($f_name)
	{
		global $_W, $_GPC;
		$uid = $_W['fans']['uid'];
		$uniacid = $_W['uniacid'];
		$userinfo = $this->login();//登录
		$op = $operation = $_GPC['op'] ? $_GPC['op'] : 'display';
		$do = strtolower(substr($f_name, 8));
		include_once 'mobile/' . strtolower(substr($f_name, 8)) . '.php';
	}
	


	//登录更新
    public function login(){
        global $_W;
        if(isset($_SESSION['userinfo'])){
            $userinfo = unserialize(base64_decode($_SESSION['userinfo']));
            $userinfo['headimgurl'] = str_replace("132132","132",$userinfo['headimgurl']);
            $userinfo['avatar'] = str_replace("132132","132",$userinfo['avatar']);
        }else{
            $userinfo = mc_oauth_userinfo();
            $userinfo['headimgurl'] = str_replace("132132","132",$userinfo['headimgurl']);
            $userinfo['avatar'] = str_replace("132132","132",$userinfo['avatar']);

        }

        //判断是否微信客户端操作
        if(!$userinfo){
            message('请在微信客户端打开','','error');
            exit();
        }
        if ($_W['container'] != 'wechat') {
            message('请在微信客户端打开','','error');
            exit();
        }
        return $userinfo;
    }

}
?>