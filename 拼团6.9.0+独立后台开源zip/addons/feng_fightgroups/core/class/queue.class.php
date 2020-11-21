<?php 

class queue {
	private $islock = array('value'=>0,'expire'=>0);
	private $expiretime = 900; //锁过期时间，秒
	
	//初始赋值
	public function __construct(){
		$lock = Util::getCache('queuelock','first');
		if(!empty($lock)) $this->islock = $lock;
	}
	
	//加锁
	private function setLock(){
		$array = array('value'=>1,'expire'=>time());
		Util::setCache('queuelock','first',$array);
		$this->islock = $array;
	}
	
	//删除锁
	private function deleteLock(){
		Util::deleteCache('queuelock','first');
		$this->islock = array('value'=>0,'expire'=>time());
	}	
	
	//检查是否锁定
	public function checkLock(){
		$lock = $this->islock;	
		if($lock['value'] == 1 && $lock['expire'] < (time() - $this->expiretime )){ //过期了，删除锁
			$this->deleteLock();
			return false;
		}
		if(empty($lock['value'])){
			return false;
		}else{
			return true;
		}
	}
	
	public function queueMain(){
		global $_W;
		set_time_limit(0); //解除超时限制	
		if(self::checkLock()){
			return false; //锁定的时候直接返回
		}else{
			self::setLock(); //没锁的话锁定
		}
		//获取所有公众号
		$sets = pdo_fetchall('select distinct uniacid from ' . tablename('tg_setting'));
		foreach ($sets as $set) {
			$_W['uniacid'] = $set['uniacid'];
			self::checkGroup(); //改变失败团状态
			self::auto_lottery(); //自动抽奖
			self::auto_notice(); //发送过期通知
			self::doTask();
			self::hexiaolimit_order(); //将超过最迟提货时间的订单改为待退款
			self::auto_refund(); //自动退款
			self::autoDealOrder(); //自动处理订单
	//		self::autodissettlement(); //自动把完成订单结算给分销
			self::lackNumTips();
		}
		self::deleteLock(); //执行完删除锁
	}
	
	//自动更新团状态
	static function checkGroup(){
		global $_W;
		wl_load()->model('setting');
		model_group::updateGourpStatus();
	}
	//自动退款
	static function auto_refund(){
		global $_W;
		$now = time();
		wl_load()->model('setting');
		//自动退款，一次退10条
		$refundOrder = model_order::getNumRefundOrder(10);
		foreach($refundOrder as $order){
			model_order::refundMoney($order['id'],$order['price'],'购买失败');
		}
	}
	//自动发送提醒
	static function auto_notice(){
		global $_W;
		$now = time();
		$uid = $_W['uniacid'];
		$noticeorders = pdo_getall('tg_order',array('uniacid' => $uid,'status'=>2,'is_hexiao'=>1,'limitnotice'=>0));
		if($noticeorders){
			foreach ($noticeorders as $key => $v) {
				$goods = pdo_get('tg_goods',array('id' => $v['g_id']),array('gname','noticetime','hexiaolimittime','hexiaolimittimetype','g_type'));
				if($goods['hexiaolimittime'] && $goods['hexiaolimittimetype'] && ($goods['g_type'] == 1)){
					if($goods['hexiaolimittimetype'] == 1){
						$cutofftime = $goods['hexiaolimittime'];
					}else if($goods['hexiaolimittimetype'] == 2){
						$cutofftime = $v['ptime'] + $goods['hexiaolimittime']*24*3600;
					}
					if($goods['noticetime']){
						if($now > ($cutofftime - $goods['noticetime']*24*3600)){
							$flag = 1;
						}
					}else {
						if($now > ($cutofftime - 604800)){
							$flag = 1;
						}
					}
					if($flag){
						$msg = '';
						$msg .= "【到期提醒】您购买的商品即将过期，请速去商家自提核销。". "\n";
						$msg .= "商品名称：".$goods['gname']. "\n";
						$msg .= "截止时间：".date('Y-m-d H:i:s',$cutofftime). "\n";
						$msg .= "";	
						$url = app_url('order/order/detail',array('id'=>$v['id']));
						sendCustomNotice($v['openid'],$msg,$url,'');
						pdo_update('tg_order',array('limitnotice' => 1),array('id' => $v['id']));
					}
				}
			}
		}
	}
	
	//分销自动结算到分销商
//	static function autodissettlement(){
//		global $_W;
//		$disorders = pdo_fetchall("SELECT * FROM ".tablename('tg_order')."WHERE uniacid = {$_W['uniacid']} AND status = 4 AND leadmoney > 0 AND dissettlement = 0 ORDER BY id DESC");
//		if($disorders){
//			foreach ($disorders as $key => $v) {
//				$lead = pdo_get('tg_member',array('id' => $v['leadid']),array('dismoney','nowmoney'));
//				$dismoney = $v['leadmoney'] + $lead['dismoney'];
//				$nowmoney = $v['leadmoney'] + $lead['nowmoney'];
//				$res = pdo_update('tg_member',array('dismoney' => $dismoney,'nowmoney'=>$nowmoney),array('id' => $v['leadid']));
//				if($res){
//					pdo_update('tg_order',array('dissettlement' => 1),array('id' => $v['id']));
//				}
//			}
//		}
//	}
	



	
	//将超过最迟提货时间的订单改为待退款
	static function hexiaolimit_order(){
		global $_W;
		$now = time();
		$uid = $_W['uniacid'];
		$goods = pdo_getall('tg_goods',array('uniacid' => $uid));
		foreach ($goods as $k => $v) {
			if($v['hexiaolimittimetype'] == 1){
				if($v['hexiaolimittime'] && $v['hexiaolimittime'] < $now){
					$order = pdo_getall('tg_order',array('uniacid' => $uid,'g_id' => $v['id'],'status' => 2,'is_hexiao' => 1));
					if($order){
						foreach ($order as $ok => $ov) {
							if(empty($v['is_norefund'])){
								pdo_update('tg_order',array('status' => 6),array('id' => $ov['id']));
							}else {
								pdo_update('tg_order',array('status' => 9),array('id' => $ov['id']));
							}	
						}
					}	
				}
			}
			if($v['hexiaolimittimetype'] == 2){
				if($v['hexiaolimittime']>=1){
					$t = $now - $v['hexiaolimittime']*24*3600;
					$orders = pdo_fetchall("select id from".tablename('tg_order')."where uniacid={$_W['uniacid']} and g_id = {$v['id']} and status=2 and is_hexiao=1 and ptime<'{$t}'");
					if($orders){
						foreach ($orders as $ok => $ov) {
							if(empty($v['is_norefund'])){
								pdo_update('tg_order',array('status' => 6),array('id' => $ov['id']));
							}else {
								pdo_update('tg_order',array('status' => 9),array('id' => $ov['id']));
							}
						}
					}
				}
			}
		}
	}
	//自动抽奖
	static function auto_lottery(){
		global $_W;
		model_group::doLotteryOver();
	}
	//自动处理订单
	static function autoDealOrder(){
		global $_W;			
		wl_load()->model('setting');
		
		$config = tgsetting_load();
		//自动取消订单
		$config['base']['cancle_time'] = !empty($config['base']['cancle_time'])?$config['base']['cancle_time']:1;
		$canceltime = time() - $config['base']['cancle_time']*3600;
		$orderdata = pdo_fetchall("select status,id from".tablename("tg_order")."where uniacid={$_W['uniacid']} and status=0 and createtime < '{$canceltime}'");		
		foreach($orderdata as $k=>$v){
			model_order::cancelDoNotPayOrder($v);
		}
		
		//自动完成订单
		$config['base']['received_time'] = !empty($config['base']['received_time'])?$config['base']['received_time']:5;
		$confirmtime = time() - $config['base']['received_time']*24*60*60;
		$orderdata = pdo_fetchall("select status,id from".tablename("tg_order")."where uniacid={$_W['uniacid']} and status=3  and sendtime< '{$confirmtime}'");			
		foreach($orderdata as $k=>$v){
			model_order::confirmOrder($v);
		}
		
		//自动处理拼团单号为0的订单
		$orders = pdo_fetchall("select id from".tablename('tg_order')."where tuan_id=0 and is_tuan=1 and tuan_first=1 and status in(1,2,3,4,6,7) limit 200");
		foreach($orders as $key =>$value){
			pdo_update('tg_order',array('tuan_id'=>$value['id']),array('id'=>$value['id']));
		}
	}
	//拼团人数不足提醒
	
	static function lackNumTips(){
		global $_W;
		$time = time();
		$groups = pdo_fetchall("select goodsname,id,groupnumber,endtime,lacknum,lacktimetip from".tablename('tg_group')."where groupstatus=3 and lacktimetip>0 and (iftip=0 or iftip is null) limit 100");
		foreach($groups as $key =>$value){
			$should = $value['endtime'] - $value['lacktimetip']*3600;
			if($time>=$should){
				$orders = pdo_fetchall("select openid from".tablename('tg_order')."where tuan_id='{$value['groupnumber']}' and is_tuan=1 and status =1 ");
				foreach($orders as $k =>$v){
					message::lack_num($value['goodsname'], $value['lacktimetip'], $value['lacknum'], $v['openid'], app_url('order/group',array('tuan_id'=>$value['groupnumber'])));
				}
				pdo_update('tg_group',array('iftip'=>1),array('id'=>$value['id']));
			}
		}
	}
	//队列任务
		//增加待发消息
	public function addTask($key,$value){
		global $_W;
		$data = array(
			'uniacid' => $_W['uniacid'],
			'key' => $key,
			'value' => $value
		);
		$res = pdo_insert('tg_waittask',$data);
		return $res;
	}
	
	//删除消息队列
	public function deleteTask($id){
		global $_W;		
		pdo_delete('tg_waittask',array('uniacid'=>$_W['uniacid'],'id'=>$id));
	}
	
	//查询需要发消息的记录
	public function getNeedTaskItem(){
		global $_W;
		$array = array(':uniacid'=>$_W['uniacid']);
		return pdo_fetchall("SELECT * FROM ".tablename('tg_waittask')." WHERE `uniacid` = :uniacid ORDER BY `id` ASC ",$array);
	}
	//执行等待中任务
	public function doTask(){
		global $_W;
		set_time_limit(0); //解除超时限制	
		$message =self::getNeedTaskItem();
		foreach($message as $k=>$v){
			if($v['key'] == 1){
				
			}
			if($v['key'] == 2){
				
				$lottery = pdo_fetch("select prize,gname,nogetmessage,dostatus from".tablename("tg_lottery")."where uniacid={$_W['uniacid']} and dostatus=1 and status=3 and id={$v['value']}");//已结束，未抽奖
				$prize = unserialize($lottery['prize']);
				
				//给一等奖发消息
				$defaultFirst = pdo_fetchall("select openid,id,tuan_id from".tablename('tg_order')."where lotteryid={$v['value']} and limitnotice = 0 and lottery_status in(2,5)");
				foreach($defaultFirst as $defaultFirstValue){ //一等奖
					if ($prize['self']['radio']==1){
						$content = "恭喜获得一等奖【".$lottery['gname']."】";
					}else{
						$content = "恭喜获得一等奖,我们将尽快发货，并给您退款！";
					}
					$url = app_url("order/group",array('tuan_id'=>$defaultFirstValue['tuan_id']));
					message::activity_tip($content, $defaultFirstValue['openid'], $lottery['gname'], $url);
					pdo_update('tg_order',array('limitnotice' => 1),array('id' => $defaultFirstValue['id']));
				}
				//二等奖中奖发送优惠券
				$openidsFirst = pdo_fetchall("select openid,id,tuan_id from".tablename('tg_order')."where lotteryid={$v['value']} and limitnotice = 0 and lottery_status in(3,6)"); 
				if ($prize['first']['radio']==1){
					$content = "很遗憾您与大奖擦肩而过,我们已将抽奖金额全额退还给您。";
				}
				if ($prize['first']['radio']==2 || $prize['first']['radio']==3){
					if($prize['first']['coupon_type']==1){
						$coupon = model_coupon::coupon_templates($prize['first']['coupon_template_id']);
						$content = $prize['first']['radio']==2? "恭喜你获得【".$coupon['name']."】":"恭喜你获得【".$coupon['name']."】，并将抽奖金额全额退还给您。";
						$url = app_url('member/coupon');
					}else{
						$content = $prize['first']['radio']==2? "很遗憾您与大奖擦肩而过,我们已赠送给您优惠券,点击领取》》":"很遗憾您与大奖擦肩而过,我们已将抽奖金额全额退还给您，并赠送给您优惠券，点击领取》》";
						$url = $prize['first']['coupon_a'];
					}
				}
				//发送二等奖通知
				foreach($openidsFirst as $openid){ 
					if ($prize['first']['radio']==2 || $prize['first']['radio']==3){
						if($prize['first']['coupon_type']==1)
						model_coupon::coupon_grant($openid['openid'], $prize['first']['coupon_template_id']);
					}
					$url = !empty($url)?$url:app_url("order/group",array('tuan_id'=>$openid['tuan_id']));
					message::activity_tip($content, $openid['openid'], $lottery['gname'], $url);
					pdo_update('tg_order',array('limitnotice' => 1),array('id' => $openid['id']));
				}
				
				//三等奖中奖发送优惠券
				$url='';
				$openidsSecond = pdo_fetchall("select openid,id,tuan_id from".tablename('tg_order')."where lotteryid={$v['value']} and limitnotice = 0 and lottery_status in(4,7)");//三等奖
				if ($prize['second']['radio']==1){
					$content = "很遗憾您与大奖擦肩而过,我们已将抽奖金额全额退还给您。";
				}
				if ($prize['second']['radio']==2 || $prize['second']['radio']==3){
					if($prize['second']['coupon_type']==1){
						$coupon = model_coupon::coupon_templates($prize['second']['coupon_template_id']);
						$content =$prize['second']['radio']==2? "很遗憾您与大奖擦肩而过,我们赠送给您【".$coupon['name']."】":"很遗憾您与大奖擦肩而过,我们赠送给您【".$coupon['name']."】，并将抽奖金额全额退还给您。";
						$url = app_url('member/coupon');
					}else{
						$content = $prize['second']['radio']==2? "很遗憾您与大奖擦肩而过,我们已赠送给您优惠券，点击领取》》":"很遗憾您与大奖擦肩而过,我们已将抽奖金额全额退还给您，并赠送给您优惠券，点击领取》》";
						$url = $prize['second']['coupon_a'];
					}
				}
				if ($prize['second']['radio']==4){
					$content = "很遗憾您与大奖擦肩而过。";
				}
				//发送三等奖通知
				foreach($openidsSecond as $openid){
					if ($prize['second']['radio']==2 || $prize['second']['radio']==3){
						if($prize['second']['coupon_type']==1)
						model_coupon::coupon_grant($openid['openid'], $prize['second']['coupon_template_id']);
					}
					$url = !empty($url)?$url:app_url("order/group",array('tuan_id'=>$openid['tuan_id']));
					message::activity_tip($content, $openid['openid'], $lottery['gname'], $url);
					pdo_update('tg_order',array('limitnotice' => 1),array('id' => $openid['id']));
					Util::deleteCache('order',$openid['id']);
				}
				//给未中奖的用户发送消息
				if($lottery['nogetmessage']==1 && $lottery['dostatus']==1){
					$noGetOrders = pdo_fetchall("select openid,id,tuan_id from".tablename('tg_order')."where lotteryid={$v['value']} and limitnotice = 0 and lottery_status not in(2,3,4,5,6,7)");//三等奖
					foreach($noGetOrders as$k=> $openid){
						$content = "很遗憾,您没有中任何奖项";
						$url = !empty($url)?$url:app_url("order/group",array('tuan_id'=>$openid['tuan_id']));
						message::activity_tip($content, $openid['openid'], $lottery['gname'], $url);
						pdo_update('tg_order',array('limitnotice' => 1),array('id' => $openid['id']));
					}
				}
			}
			if($v['key'] == 3){ //成团就开奖  通知及更新奖品数据
				$sql = "SELECT orderno,id,tuan_id,lotteryid FROM ".tablename('tg_order')."WHERE orderno='{$v['value']}'";
				$order = pdo_fetch($sql);
				$lottery = pdo_fetch("select prize,gname,nogetmessage from".tablename("tg_lottery")."where uniacid={$_W['uniacid']}  and status=1 and id={$order['lotteryid']}");//已结束，未抽奖
				$prize = unserialize($lottery['prize']);
				
				//给一等奖发消息
				$defaultFirst = pdo_fetchall("select openid,id,tuan_id from".tablename('tg_order')."where lottery_status in(2,5) and limitnotice = 0  and tuan_id={$order['tuan_id']} and status in(2,6,7) ");
				foreach($defaultFirst as $default=>$defaultFirstValue){ //一等奖
					if ($prize['self']['radio']==2){
						$content = "一等奖退款：【".$lottery['gname']."】";
					}else{
						$content = "恭喜获得一等奖,我们将尽快发货！";
					}
					$url = app_url("order/group",array('tuan_id'=>$defaultFirstValue['tuan_id']));
					message::activity_tip($content, $defaultFirstValue['openid'], $lottery['gname'], $url);
					pdo_update('tg_order',array('limitnotice' => 1),array('id' => $defaultFirstValue['id']));
				}
				//二等奖中奖发送优惠券
				$openidsFirst = pdo_fetchall("select openid,id,tuan_id from".tablename('tg_order')."where lottery_status in(3,6) and limitnotice = 0 and tuan_id='{$order['tuan_id']}' and status in(2,6,7) "); 
				if ($prize['first']['radio']==1){
					$content = "很遗憾您与大奖擦肩而过,我们已将抽奖金额全额退还给您。";
				}
				if ($prize['first']['radio']==2 || $prize['first']['radio']==3){
					if($prize['first']['coupon_type']==1){
						$coupon = model_coupon::coupon_templates($prize['first']['coupon_template_id']);
						$content = $prize['first']['radio']==2? "恭喜你获得【".$coupon['name']."】":"恭喜你获得【".$coupon['name']."】，并将抽奖金额全额退还给您。";
						$url = app_url('member/coupon');
					}else{
						$content = $prize['first']['radio']==2? "很遗憾您与大奖擦肩而过,我们已赠送给您优惠券,点击领取》》":"很遗憾您与大奖擦肩而过,我们已将抽奖金额全额退还给您，并赠送给您优惠券，点击领取》》";
						$url = $prize['first']['coupon_a'];
					}
				}
				//发送二等奖通知
				foreach($openidsFirst as$k=> $openid){ 
					if ($prize['first']['radio']==2 || $prize['first']['radio']==3){
						if($prize['first']['coupon_type']==1)
						model_coupon::coupon_grant($openid['openid'], $prize['first']['coupon_template_id']);
					}
					$url = !empty($url)?$url:app_url("order/group",array('tuan_id'=>$openid['tuan_id']));
					message::activity_tip($content, $openid['openid'], $lottery['gname'], $url);
					pdo_update('tg_order',array('limitnotice' => 1),array('id' => $openid['id']));
				}
				
				//三等奖中奖发送优惠券
				$url='';
				$openidsSecond = pdo_fetchall("select openid,id,tuan_id from".tablename('tg_order')."where lottery_status in(4,7) and limitnotice = 0 and tuan_id='{$order['tuan_id']}' and status  in(2,6,7) ");//三等奖
				if ($prize['second']['radio']==1){
					$content = "很遗憾您与大奖擦肩而过,我们已将抽奖金额全额退还给您。";
				}
				if ($prize['second']['radio']==2 || $prize['second']['radio']==3){
					if($prize['second']['coupon_type']==1){
						$coupon = model_coupon::coupon_templates($prize['second']['coupon_template_id']);
						$content =$prize['second']['radio']==2? "恭喜你获得【".$coupon['name']."】":"恭喜你获得【".$coupon['name']."】，并将抽奖金额全额退还给您。";
						$url = app_url('member/coupon');
					}else{
						$content = $prize['second']['radio']==2? "很遗憾您与大奖擦肩而过,我们已赠送给您优惠券，点击领取》》":"很遗憾您与大奖擦肩而过,我们已将抽奖金额全额退还给您，并赠送给您优惠券，点击领取》》";
						$url = $prize['second']['coupon_a'];
					}
				}
				if ($prize['second']['radio']==4){
					$content = "很遗憾您与大奖擦肩而过。";
				}
				//发送三等奖通知
				foreach($openidsSecond as$kk=> $openid){
					if ($prize['second']['radio']==2 || $prize['second']['radio']==3){
						if($prize['second']['coupon_type']==1)
						model_coupon::coupon_grant($openid['openid'], $prize['second']['coupon_template_id']);
					}
					$url = !empty($url)?$url:app_url("order/group",array('tuan_id'=>$openid['tuan_id']));
					message::activity_tip($content, $openid['openid'], $lottery['gname'], $url);
					pdo_update('tg_order',array('limitnotice' => 1),array('id' => $openid['id']));
					Util::deleteCache('order',$openid['id']);
				}
				//给未中奖的用户发送消息
				if($lottery['nogetmessage']==1){
					$noGetOrders = pdo_fetchall("select openid,id,tuan_id from".tablename('tg_order')."where  lottery_status not in(2,3,4,5,6,7) and tuan_id='{$order['tuan_id']}' and status in(2,6,7) ");//三等奖
					foreach($noGetOrders as$k=> $openid){
						$content = "很遗憾,您没有中任何奖项";
						$url = !empty($url)?$url:app_url("order/group",array('tuan_id'=>$openid['tuan_id']));
						message::activity_tip($content, $openid['openid'], $lottery['gname'], $url);
						pdo_update('tg_order',array('limitnotice' => 1),array('id' => $openid['id']));
					}
				}
			}
			self::deleteTask($v['id']); //删除已发的
		}
	}
}

