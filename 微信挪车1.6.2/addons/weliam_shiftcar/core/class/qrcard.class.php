<?php 
class qrcard{

	//获取违章信息
	static function handle($message,$covertype = 'processor'){
		global $_W;
		wl_load()->model('setting');
		file_put_contents(WL_DATA."qr.log", var_export($message, true).PHP_EOL, FILE_APPEND);
		if($covertype == 'receiver' && $message['type'] == 'subscribe'){
			$covertype = 'processor';
		}
		if (strtolower($message['msgtype']) == 'event' && $covertype == 'processor') {
			//获取数据
			$returnmess = array();
			$qrid = self::get_qrid($message);
			$data = self::get_member($message, $qrid);
			$card = $data['card'];
			$carmember = $data['carmember'];
			$member = $data['member'];
			$settings = wlsetting_read('qrset');
			
			//挪车卡未绑定
			if($card['status'] == 1 && empty($member['ncnumber'])){
				$returnmess[] = array('title' => urlencode("您好，绑定挪车卡，点击开始绑定！"),'description' => '','picurl' =>tomedia($settings['bdtuwen']),'url' => app_url('member/mycar/display',array('ncnum' => $card['cardsn'],'salt' => $card['salt'])));
				self::send_news($returnmess, $message);
			}
			if($card['status'] == 1 && !empty($member['ncnumber'])){
				$returnmess[] = array('title' => urlencode("您好，您确定绑定新的挪车卡吗？"),'description' => urlencode('旧挪车卡将失效，点击开始绑定。'),'picurl' =>tomedia($settings['bdtuwen']),'url' => app_url('member/mycar/display',array('ncnum' => $card['cardsn'],'salt' => $card['salt'])));
				self::send_news($returnmess, $message);
			}
			
			//挪车卡已绑定
			if($card['status'] == 2 ){
				if($carmember['openid'] == $message['from']){
					self::send_text('调皮，你是要自己通知自己挪车吗？', $message);
				}
				if($carmember['message']){
					$returnmess[] = array('title' => urlencode("您好，我是【".$carmember['plate1'].$carmember['plate2'].$carmember['plate_number']."】车主："),'description' => urlencode($carmember['message']."点击呼叫我挪车~~"),'picurl' =>tomedia($settings['nctuwen']),'url' => app_url('home/movecar',array('ncnum' => $card['cardsn'],'salt' => $card['salt'])));
				}else{
					$returnmess[] = array('title' => urlencode("您好，我是【".$carmember['plate1'].$carmember['plate2'].$carmember['plate_number']."】车主："),'description' => urlencode('临时停车，给您带来不便尽请谅解！点击呼叫我挪车~~'),'picurl' =>tomedia($settings['nctuwen']),'url' => app_url('home/movecar',array('ncnum' => $card['cardsn'],'salt' => $card['salt'])));
				}
				$mer_set = wlsetting_read('merchant');
				if($mer_set['sendstatus'] == 2){
					$retunarr = self::send_storemsg($message['from'],$carmember,$card);
					if(!empty($retunarr)) $returnmess[] = $retunarr;
				}
				if($mer_set['rechangestatus'] == 2){
					$retunarr = self::store_rechange($message['from'],$carmember,$card);
					if(!empty($retunarr['recharge'])) $returnmess[] = $retunarr['recharge'];
					if(!empty($retunarr['consume'])) $returnmess[] = $retunarr['consume'];
				}
				self::send_news($returnmess, $message);
			}
			
			//挪车卡已禁止
			if($card['status'] == 3){
				self::send_text('抱歉，此挪车卡已失效！', $message);
			}
		}
	}
	
	static function send_news($returnmess,$message){
		global $_W;
		$send['touser'] = $message['from'];
		$send['msgtype'] = 'news';
		$send['news']['articles'] = $returnmess;
		$acc = WeAccount::create($_W['acid']);
		$data = $acc->sendCustomNotice($send);
		if(is_error($data)) {
			file_put_contents(WL_DATA."qr.log", var_export($message, true).PHP_EOL, FILE_APPEND);
			self::salerEmpty();
		}else{
			self::salerEmpty();
		}
	}
	
	static function send_text($mess,$message){
		global $_W;
		$send['touser'] = $message['from'];
		$send['msgtype'] = 'text';
		$send['text'] = array('content' => urlencode($mess));
		$acc = WeAccount::create($_W['acid']);
		$data = $acc->sendCustomNotice($send);
		if(is_error($data)) {
			file_put_contents(WL_DATA."qr.log", var_export($message, true).PHP_EOL, FILE_APPEND);
			self::salerEmpty();
		}else{
			self::salerEmpty();
		}
	}
	
	static function get_qrid($message){
		global $_W;
		$stat = pdo_fetchcolumn("SELECT qid FROM ".tablename('qrcode_stat')." WHERE uniacid = {$_W['uniacid']} AND openid = '{$message['from']}' AND type = 1 AND acid = '{$_W['acid']}' order by id desc");
		if(!empty($message['ticket'])){
			if (is_numeric($message['scene'])) {
				$qrid = pdo_fetchcolumn('select id from ' . tablename('qrcode') . ' where uniacid=:uniacid and qrcid=:qrcid', array(':uniacid' => $_W['uniacid'], ':qrcid' => $message['scene']));
			}else{
				$qrid = pdo_fetchcolumn('select id from ' . tablename('qrcode') . ' where uniacid=:uniacid and scene_str=:scene_str', array(':uniacid' => $_W['uniacid'], ':scene_str' => $message['scene']));
			}
			if($message['event'] == 'subscribe'){
				self::qr_log($qrid,$message['from'],1);
			}else{
				self::qr_log($qrid,$message['from'],2);
			}
		}elseif(!empty($stat)){
			$qrid = $stat;
		}else{
			self::send_text('欢迎关注我们!', $message);
		}
		return $qrid;
	}
	
	static function get_member($message,$qrid){
		global $_W;
		$card = pdo_get('weliam_shiftcar_qrcode',array('uniacid' => $_W['uniacid'],'qrid' => $qrid),array('sid','cardsn','mid','status','salt'));
		$carmember = pdo_get('weliam_shiftcar_member',array('uniacid' => $_W['uniacid'],'id' => $card['mid']),array('id','message','openid','plate1','plate2','plate_number'));
		$member = pdo_get('weliam_shiftcar_member',array('uniacid' => $_W['uniacid'],'openid' => $message['from']),array('ncnumber','id'));
		if(empty($member['id'])){
			$member = array(
				'uniacid' => $_W['uniacid'], 
				'invid' => !empty($card['mid']) ? $card['mid'] : -1, 
				'openid' => $message['from'], 
				'status' => 1,
				'mstatus' => 1,
				'userstatus' => 1,
				'createtime' => time()
			);
			pdo_insert('weliam_shiftcar_member', $member);
		}
		return array('card'=>$card,'carmember'=>$carmember,'member'=>$member);
	}
	
	static function salerEmpty() {
		ob_clean();
		ob_start();
		echo '';
		ob_flush();
		ob_end_flush();
		exit(0);
	}
	
	static function qr_log($qrid,$openid,$type){
		global $_W;
		if(empty($qrid) || empty($openid)){
			return;
		}
		$qrcode = pdo_get('qrcode',array('id' => $qrid),array('scene_str','name'));
		$log = array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'],'qid' => $qrid,'openid' => $openid,'type' => $type,'scene_str'=>$qrcode['scene_str'],'name'=>$qrcode['name'],'createtime'=>time());
		pdo_insert('qrcode_stat',$log);
	}
	
	static function check_qrcode($cardsn,$salt){
		global $_W;
		if(empty($cardsn) || empty($salt)){
			wl_message('挪车卡缺少关键参数，请联系管理员进行处理！','close');
		}
		$qrcode = pdo_get('weliam_shiftcar_qrcode',array('cardsn' => $cardsn,'uniacid' => $_W['uniacid']));
		if(empty($qrcode) || $qrcode['salt'] != $salt){
			wl_message('挪车卡不存在或存在异常，请联系管理员进行处理！','close');
		}
		return $qrcode;
	}
	
	static function send_storemsg($openid,$user,$qrcode){
		global $_W;
		if(empty($openid) || empty($user)) return;
		$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$openid), 'id');
		if(empty($mid) || empty($user)) return;
		$mis = pdo_getcolumn('wlmerchant_merchantuser',array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'status'=>2,'enabled'=>1),'id');
		if($mis){
			$returnmess = array('title' => urlencode("给车主发送服务通知"),'description' => urlencode('发送通知'),'picurl' =>WL_URL_ARES."images/notification_fill.png",'url' => app_url('app/distance',array('userid' => $user['id'])));
			return $returnmess;
		}
		return;
	}
	
	static function store_rechange($openid,$user,$qrcode){
		global $_W;
		if(empty($openid) || empty($user)) return;
		$mid = pdo_getcolumn('wlmerchant_member', array('uniacid'=>$_W['uniacid'],'openid'=>$openid), 'id');
		if(empty($mid) || empty($user)) return;
		$mis = pdo_getcolumn('wlmerchant_merchantuser',array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'status'=>2,'enabled'=>1),'id');
		if($mis){
			$returnmess['recharge'] = array('title' => urlencode("给车主充值"),'description' => urlencode('充值'),'picurl' =>WL_URL_ARES."images/notification_fill.png",'url' => app_url('app/distance/recharge',array('userid' => $user['id'])));
			$returnmess['consume'] = array('title' => urlencode("核销车主消费"),'description' => urlencode('核销'),'picurl' =>WL_URL_ARES."images/notification_fill.png",'url' => app_url('app/distance/consume',array('userid' => $user['id'])));
			return $returnmess;
		}
		return;
	}
}