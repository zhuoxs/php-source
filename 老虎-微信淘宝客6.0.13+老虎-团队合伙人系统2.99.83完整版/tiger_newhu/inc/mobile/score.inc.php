<?php
global $_W, $_GPC;
$dluid=$_GPC['dluid'];//share id
//		$userAgent = $_SERVER['HTTP_USER_AGENT'];
//		$openid = $_W['fans']['from_user'];
//		if (!strpos($userAgent, 'MicroMessenger')) {
//			message('请使用微信浏览器打开！');
//			$openid = 'opk4HsyhyQpJvVAUhA6JGhdMSImo';
//		}
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	echo "请在微信端打开!";
	        	exit;
	        }	        
        }
        $openid=$fans['openid'];
		$pid = $_GPC['pid'];
		$items = pdo_fetch ( 'select * from ' . tablename ( $this->modulename . "_poster" ) . " where id='{$pid}'" );
		$name = $items['credit']?'余额':'积分';
		if (empty($items) && $items['type'] != 1) die('扫码送'.$name.'活动已经结束！');
		$sliders = unserialize($items['sliders']);
		$atimes = '';
		foreach ($sliders as $key => $value) {
			$atimes[$key] = $value['displayorder'];
		}
		array_multisort($atimes,SORT_NUMERIC,SORT_DESC,$sliders);
		
		$follow = pdo_fetchcolumn('select follow from '.tablename("mc_mapping_fans")." where openid='{$openid}'");
		$record = pdo_fetch('select * from '.tablename($this->modulename."_record")." where openid='{$openid}' and pid='{$pid}'");
		$items['score3'] = $items['score'];
		if ($items['score2']){
			$items['score1'] = $items['score']."—".$items['score2']." ";
			$items['score3'] = intval(mt_rand($items['score'],$items['score2']));
		}
		$cfg = $this->module['config'];
		include $this->template ( 'qrcode' );