<?php
defined('IN_IA') or exit('Access Denied');

class Vip_WeliamController{
	
	public function open(){
		global $_W,$_GPC;
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '开通VIP - '.$_W['wlsetting']['base']['name'] : '开通VIP';
		$vipSet = Setting::wlsetting_read('member_vip_price');
		$vip = $vipSet['mm'];
		
		$listData = Util::getNumData("*", PDO_NAME.'member_type', array('status'=>1,'uniacid'=>$_W['uniacid']));
		$list = $listData[0];
		include wl_template('member/vip_open');
	}
	
	public function createOrder(){
        global $_W,$_GPC;
        if($_W['ispost']){
            if(empty($_W['wlmember']['mobile'])){
                wl_message(array('errno'=>1,'message'=>'还未绑定手机号码，点击确定去绑定'));
            }
            wl_message(array('errno'=>0,'message'=>$orderno));
        }
        $orderno = $this->createVipOrder($_GPC['radioValue']);
        $fee = floatval($orderno['price']);
        if($fee <= 0) {
	        wl_message('支付错误, 金额小于0');
	    }
		$params = array(
	        'tid' => $orderno['orderno'],      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
	        'ordersn' => $orderno['orderno'],  //收银台中显示的订单号
	        'title' => '充值VIP会员',          //收银台中显示的标题
	        'fee' => $fee,      //收银台中显示需要支付的金额,只能大于 0
	        'plugin' => 'Merchant',     //付款插件
	        'payfor' => 'Vip',     //回调函数
	    );
		wlPay::pay($params);
	}
	
	public function vipSuccess(){
		global $_W,$_GPC;
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '开通VIP - '.$_W['wlsetting']['base']['name'] : '开通VIP';
		$orderid = $_GPC['orderid'];
		if($orderid){
			$where['id'] = $orderid;
			$order = Util::getSingelData('*','wlmerchant_vip_record',$where);
			$where2['openid'] = $order['openid'];
		}else{
			$where2['openid'] = $_W['openid'];
		}
		$member = Util::getSingelData('*','wlmerchant_member',$where2);
		$order['limittime'] = date('Y年m月d日',$member['lastviptime']);
		include wl_template('member/vip_success');
	}
	
	public function getVipSuccess(){
		global $_W,$_GPC;
		$pagetitle = !empty($_W['wlsetting']['base']['name']) ? '开通VIP - '.$_W['wlsetting']['base']['name'] : '开通VIP';
		$orderno = $_GPC['orderno'];
		$where['orderno'] = $orderno;
		$order = Util::getSingelData('*','wlmerchant_vip_record',$where);
		$where2['openid'] = $order['openid'];
		$member = Util::getSingelData('*','wlmerchant_member',$where2);
		$order['limittime'] = date('Y-m-d H:i:s',$order['limittime']);
		die(json_encode(array('data2'=>$member,'data1'=>$order)));
		
	}
	
	public function vipToken(){
		global $_W,$_GPC;
		$token = trim($_GPC['token']);
		if(empty($token)){die(json_encode(array('errno'=>1,'message'=>'请输入验证码！')));} 
		$type = Util::getSingelData("*", PDO_NAME.'token', array('number'=>$token));
		if(empty($type)) die(json_encode(array('errno'=>1,'message'=>'激活码不存在！')));
		$halfflag = pdo_getcolumn(PDO_NAME.'member_type',array('id'=>$type['type']),'is_half');
		if($type['status']!=0) die(json_encode(array('errno'=>2,'message'=>'该激活码已使用！')));
		$num= $type['days']; //开通VIP时长
		$vipInfo = Util::getSingelData('*', PDO_NAME."member", array('uniacid'=>$_W['uniacid'],'id'=>$_W['mid']));
		$lastviptime = Member::vip($vipInfo['id']); //上次VIP结束时间
		if($lastviptime){
			$limittime = $lastviptime+$num*24*60*60;
			$vipleveltime = floor($limittime/24*60*60);
		}else{
			$limittime = time()+$num*24*60*60;
			$vipleveltime = $num;
		}
		$aid = Util::idSwitch('areaid', 'aid', $_W['areaid']);
		$memberData = array(
			'level'       =>1,
			'vipstatus'   =>1,
			'vipleveldays'=>$type['days'],
			'lastviptime' =>$limittime,
			'areaid'      =>$_W['areaid'],
			'aid'         =>$aid
		);
		if(pdo_update(PDO_NAME.'member',$memberData,array('id'=>$_W['mid']))){
			if(pdo_update(PDO_NAME.'token',array('status'=>1,'mid'=>$_W['mid'],'openid'=>$_W['openid']),array('number'=>$token))){
				if($halfflag){
					$mdata = array('uniacid'=>$_W['uniacid'],'mid'=>$_W['mid']);
					if($_W['wlsetting']['halfcard']['halfcardtype'] != 1){
						$mdata['aid'] = $_W['aid'];
					}
					$halfInfo = Util::getSingelData('*', PDO_NAME."halfcardmember",$mdata);
					$lastviptime = $halfInfo['expiretime'];
					if($lastviptime && $lastviptime > time()){
						$limittime2 = $lastviptime + $type['days']*24*60*60;
					}else{
						$limittime2 = time() + $type['days']*24*60*60;
					}
					
					$halfcarddata = array(
						'uniacid'    => $_W['uniacid'],
						'aid'        => $_W['aid'],
						'mid'        => $_W['mid'],
						'expiretime' => $limittime2,
						'createtime' => time()
					);
					if($halfInfo){
						pdo_update(PDO_NAME.'halfcardmember',$halfcarddata,array('mid'=>$order_out['mid']));
					}else {
						pdo_insert(PDO_NAME.'halfcardmember',$halfcarddata);
					}
					$member = pdo_get('wlmerchant_member',array('id' => $halfcarddata['mid']),array('openid','mobile'));
					$openid = $member['openid'];
					$mobile = $member['mobile'];
					$url = app_url('halfcard/halfcard_app/userhalfcard');
					$time = date('Y-m-d H:i:s',$halfcarddata['expiretime']);
					Halfcard::openSuccessNotice($openid, '一卡通', $time, $mobile, $url);
				}
				die(json_encode(array('errno'=>0,'message'=>'激活成功')));
			}else{
				die(json_encode(array('errno'=>3,'message'=>'更新激活码失败！')));
			}
		}else{
			die(json_encode(array('errno'=>3,'message'=>'更新会员失败！')));
		}
	}

	private function createVipOrder($monthNum){
		global $_W;
		$type = Util::getSingelData("*", PDO_NAME.'member_type', array('id'=>$monthNum));
		if($type['num']){
			$times = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('wlmerchant_vip_record') . " WHERE uniacid = {$_W['uniacid']} AND mid = {$_W['mid']} AND status = 1  AND typeid = {$type['id']}");
			if($times>$type['num'] || $times == $type['num']){
				wl_message('选择的充值卡最多充值'.$type['num'].'次。');
			}
		}
		$vipSet = Setting::wlsetting_read('member_vip_price');
		$num = $type['price'];
		$num2 = $type['days']/30; //开通VIP时长
		$vipInfo = Util::getSingelData('*', PDO_NAME."member", array('uniacid'=>$_W['uniacid'],'id'=>$_W['mid']));
		$lastviptime = Member::vip($vipInfo['id']); //上次VIP结束时间
		if($lastviptime){
			$limittime = $lastviptime+$num2*30*24*60*60;
			$vipleveltime = floor($limittime/24*60*60);
		}else{
			$limittime = time()+$num2*30*24*60*60;
			$vipleveltime = $num2*30;
		}
		$aid = Util::idSwitch('areaid', 'aid', $_W['areaid']);
		$disorderid = Distribution::disCore($_W['mid'],$num,'vip');
		$data = array(
			'aid'         	 =>$aid, 
			'uid'         	 =>$vipInfo['uid'],
			'uniacid'     	 => $_W['uniacid'],
			'unionid'     	 => $_W['unionid'],
			'mid'         	 => $_W['mid'],
			'openid'      	 => $_W['openid'],
			'areaid'      	 => $_W['areaid'],
			'orderno'     	 => createUniontid(),
			'status'      	 => 0,//订单状态：0未支,1支付，2待发货，3已发货，4已签收，5已取消，6待退款，7已退款
			'createtime'  	 => TIMESTAMP,
			'price'       	 => $num,
			'limittime'    	 => $limittime,
			'typeid'      	 => $type['id'],
			'howlong'     	 => $type['days'],
			'is_half'     	 => $type['is_half'],
			'todistributor'  => $type['todistributor']
		);
		if($disorderid){
			$data['disorderid'] = $disorderid;
		}
		pdo_insert(PDO_NAME.'vip_record',$data);
		$vipid = pdo_insertid();
		if($disorderid){
			pdo_update('wlmerchant_disorder',array('orderid' => $vipid),array('id' => $disorderid));
		}
		return $data;
	}
}