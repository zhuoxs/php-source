<?php
defined('IN_IA') or exit('Access Denied');

class WlCommon_WeliamController{
	/** 
	* 上传图片公共函数 
	* 
	* @access public
	* @name uploadImage 
	*/  
	public function uploadImage(){
		global $_W,$_GPC;
		
		$info = Util::uploadImageInWeixin($_GPC['serverId']);
		die($info);
	}
	
	public function memberFollow(){
		global $_W,$_GPC;
		if ($_W['fans']['follow'] != 1) {
			$showurl = !empty($_W['wlsetting']['share']['gz_image']) ? $_W['wlsetting']['share']['gz_image'] : 'qrcode_'.$_W['acid'].'.jpg';
			pdo_insert('wlmerchant_halfcard_qrscan', array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'scantime' => time(), 'cardid' => intval($_GPC['id']), 'type' => trim($_GPC['type'])));
			show_json(0, tomedia($showurl));
		}
	}
	
	//图形验证码
	public function captcha() {
		global $_W,$_GPC;
		load()->classs("captcha");
		error_reporting(0);
		session_start();
		
		$captcha = new Captcha();
		$captcha->build(108, 44);
		$hash = md5(strtolower($captcha->phrase) . $_W["config"]["setting"]["authkey"]);
		isetcookie("__code", $hash);
		$_SESSION["__code"] = $hash;
		
		$captcha->output();
	}
	
	/** 
	* 智慧城市构建支付公共函数 
	* 
	* @access public
	* @name wlPay 
	* @param  $orderType 订单类型  ，$orderId 订单ID，  $payType 支付方式 ，$done是否支付完成（微信支付）,$toPay 1为进入收银台
	* @return  
	*/  
	public function wlPay(){
		global $_W,$_GPC;
		$payType = $_GPC['payType'];
		$params = @json_decode(base64_decode($_GPC['params']), true);
		$plugins = getAllPluginsName();
		if(empty($params) || !in_array($params['plugin'], $plugins)) {
			message(error(1, '模块不存在'), '', 'ajax');
		}
		
		$dos = unserialize($_W['wlsetting']['payset']['status']);
		$type = in_array($payType, $dos) ? $payType : '';
		if(empty($type)) {
			wl_message(error(1, '暂无有效支付方式,请联系商家'), '', 'ajax');
		}
		$uniontid = createUniontid();
		
		$paylog = pdo_get(PDO_NAME.'paylog', array('uniacid' => $_W['uniacid'], 'plugin' => $params['plugin'], 'tid' => $params['tid']));
		if (empty($paylog)) {
			$paylog = array(
				'uniacid' => $_W['uniacid'],
				'acid' => $_W['acid'],
				'openid' => $_W['openid'], 
				'module' => 'weliam_merchant',
				'plugin' => $params['plugin'],
				'payfor' => $params['payfor'],
				'uniontid' => $uniontid,
				'tid' => $params['tid'],
				'fee' => $params['fee'],
				'card_fee' => $params['fee'],
				'status' => '0',
				'is_usecard' => '0',
				'type'=>$type
			);
			pdo_insert(PDO_NAME.'paylog', $paylog);
			$paylog['plid'] = pdo_insertid();
		}else{
			pdo_update(PDO_NAME.'paylog',array('type'=>$type),array('uniacid' => $_W['uniacid'], 'plugin' => $params['plugin'], 'tid' => $params['tid']));
		}
		if(!empty($paylog) && $paylog['status'] != '0') {
			wl_message(error(1, '这个订单已经支付成功, 不需要重复支付.'), '', 'ajax');
		}
		if (!empty($paylog) && empty($paylog['uniontid'])) {
			pdo_update(PDO_NAME.'paylog', array('uniontid' => $uniontid), array('plid' => $paylog['plid']));
			$paylog['uniontid'] = $uniontid;
		}
		$paylog['title'] = $params['title'];
		if ($payType == 'wechat') {
			return $this->PayWechat($paylog);
		} elseif ($payType == 'credit') {
			return $this->PayCredit($paylog);
		}
	}
	
	public function wlPayReturn(){
		global $_W,$_GPC;
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '支付完成 - '.$_W['wlsetting']['base']['name'] : '支付完成';
		$params = @json_decode(base64_decode($_GPC['params']), true);
		$plugins = getAllPluginsName();
		if(empty($params) || !in_array($params['plugin'], $plugins)) {
			message(error(1, '模块不存在'), '', 'ajax');
		}
		$log = pdo_get(PDO_NAME.'paylog', array('uniacid' => $_W['uniacid'], 'plugin' => $params['plugin'], 'tid' => $params['tid']));
		if(!empty($log)) { //支付成功后 点击完成按钮执行。
			if (!empty($log['tag'])) {
				$tag = iunserializer($log['tag']);
				$log['uid'] = $tag['uid'];
			}
			$ret = array();
			$ret['weid'] = $log['uniacid'];
			$ret['uniacid'] = $log['uniacid'];
			$ret['result'] = 'success';
			$ret['type'] = $log['type'];
			$ret['from'] = 'return';
			$ret['tid'] = $log['tid'];
			$ret['uniontid'] = $log['uniontid'];
			$ret['user'] = $log['openid'];
			$ret['fee'] = $log['fee'];
			$ret['tag'] = $tag;
			$ret['is_usecard'] = $log['is_usecard'];
			$ret['card_type'] = $log['card_type'];
			$ret['card_fee'] = $log['card_fee'];
			$ret['card_id'] = $log['card_id'];
			
			$className = $log['plugin'];
			$functionName = 'pay'.$log['payfor'].'Return';
			exit($className::$functionName($ret));
		}
	}

	private function PayWechat($paylog = array()) {
		global $_W;
		pdo_update(PDO_NAME.'paylog', array(
			'openid' => $_W['openid'], 
			'tag' => iserializer(array('acid' => $_W['acid'], 'uid' => $_W['member']['uid']))
		), array('plid' => $paylog['plid']));
		
		$_W['uniacid'] = $paylog['uniacid'];
		$_W['openid'] = $paylog['openid'];
		
		$setting = uni_setting($_W['uniacid'], array('payment'));
		$wechat_payment = $setting['payment']['wechat'];
		
		$partner = unserialize($payset['partner']);
		
		$account = pdo_get('account_wechats', array('acid' => $wechat_payment['account']), array('key', 'secret'));
		
		$wechat_payment['appid'] = $account['key'];
		$wechat_payment['secret'] = $account['secret'];
		
		$params = array(
			'tid' => $paylog['tid'],
			'fee' => $paylog['card_fee'],
			'user' => $paylog['openid'],
			'title' => urldecode($paylog['title']),
			'uniontid' => $paylog['uniontid'],
			'type' => 'wechat',
		);
	
		if (intval($wechat_payment['switch']) == 2 || intval($wechat_payment['switch']) == 3 ) {
			$wechat_payment_params = PayBuild::wechat_proxy_build($params, $wechat_payment);
		} else {
			unset($wechat_payment['sub_mch_id']);
			$wechat_payment_params = PayBuild::wechat_build($params, $wechat_payment);
		}
		if (is_error($wechat_payment_params)) {
			wl_message($wechat_payment_params, '', 'ajax');
		} else {
			die(json_encode(array('errno'=>0,'message'=>"支付成功",'data'=>$wechat_payment_params)));
		}
	}

    /**
     * Comment: 将图片资源转换为图片并且保存在本地
     * Author: zzw
     */
	public function createImages(){
        global $_W,$_GPC;
        $abpath = PATH_ATTACHMENT."images/".MODULE_NAME;
        $dir = iconv("UTF-8", "GBK", $abpath);
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }
        foreach ($_FILES as $k =>$v){
            $imageName = "upload_img".time().rand(1000,9999).'.png';
            $imageName = "images/" . MODULE_NAME. "/" . $imageName;//文件储存路径  图片地址
            $fullName  = PATH_ATTACHMENT . $imageName;//文件在本地服务器暂存地址
            move_uploaded_file($v['tmp_name'],$fullName);
            if($_W['setting']['remote']['type'] > 0){
                WeChat::file_remote_upload($imageName);
            }
            $imgurl[$k]['img'] = $imageName;
            $imgurl[$k]['val'] = tomedia($imageName);
        }
        wl_json(1,'保存成功',$imgurl);
    }
    /**
     * Comment: 删除本地的图片资源  远程服务器上的不管
     * Author: zzw
     */
    public function deleteImages(){
        global $_W,$_GPC;
        $name = explode('/',$_GPC['url']);
        $name = $name[count($name) - 1];
        $imageName = "images/" . MODULE_NAME. "/" . $name;//文件储存路径  图片地址
        $fullName  = PATH_ATTACHMENT . $imageName;//文件在本地服务器暂存地址
        $result = file_get_contents($fullName);
        if($result){
            //存在即删除
            unlink($fullName);
        }
        wl_json(1,'删除成功');
    }
}














