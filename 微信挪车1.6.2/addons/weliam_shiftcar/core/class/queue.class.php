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
		$this->deleteLock();
		if($this->checkLock()){
			die('false');//锁定的时候直接返回
		}else{
			$this->setLock(); //没锁的话锁定
		}
		
		//do something
		$this->send_limitline();//发送限行提醒
		$this->autopecc(); //自动查询违章信息
		$this->auto_long2short(); //自动处理长链
		$this->sendMessage(); //发消息

		$this->deleteLock(); //执行完删除锁
		die('true');
	}
	
	
/************以下是自动查询违章记录*****************/	
	//自动查询违章信息
	static function autopecc(){
		global $_W;
		if(empty($_W['wlsetting']['pecc']['pecc_status'])) return false;
		$pt = !empty($_W['wlsetting']['pecc']['ptime']) ? $_W['wlsetting']['pecc']['ptime'] : 1;
		$ptime = time() - $pt*86400;	
		$data = pdo_fetchall("select * from".tablename('weliam_shiftcar_member')."where uniacid = {$_W['uniacid']} and tasktime < {$ptime} and status = 2 and engine_number <> ' ' and frame_number <> ' ' limit 0,10 ");
		if(empty($data)) return false;
		
		//逐条查询每个车主的违章记录
		foreach($data as $v){
			model_pecc::query_task($v);
		}
		
	}
	
/*************以下是发消息******************/	

	//删除消息队列
	public function deleteMessage($id){
		global $_W;		
		pdo_delete('weliam_shiftcar_waitmessage',array('uniacid'=>$_W['uniacid'],'id'=>$id),'AND');
	}
	
	//查询需要发消息的记录
	public function getNeedMessageItem(){
		global $_W;
		$array = array(':uniacid'=>$_W['uniacid']);
		return pdo_fetchall("SELECT * FROM ".tablename('weliam_shiftcar_waitmessage')." WHERE `uniacid` = :uniacid ORDER BY `id` ASC ",$array);
	}
	
	//发消息
	public function sendMessage(){
		global $_W;
		$message = $this->getNeedMessageItem();

		foreach($message as $k=>$v){
			if($v['type'] == 1){ //违章信息提醒
				$this->sendpeccMessage($v['str']);
				$this->deleteMessage($v['id']); //删除已发的
			}
			if($v['type'] == 2){
				$sendtime = strtotime($_W['wlsetting']['limitline']['sendtime']);
				if($sendtime <= time()){
					wl_load()->model('notice');
					$str = unserialize($v['str']);
					sendlimit_notice($str);
					$this->deleteMessage($v['id']); //删除已发的
				}
			}
			if($v['type'] == 3){
				wl_load()->model('notice');
				hidelimit_notice($v['str']);
				$this->deleteMessage($v['id']); //删除已发的
			}
		}
	}
	
	//违章信息提醒
	public function sendpeccMessage($id){
		global $_W;	
		wl_load()->model('notice');
		$id = intval($id);	
		if(empty($id) || empty($_W['wlsetting']['pecc']['pecc_status'])) return false;
		$order = pdo_get('weliam_shiftcar_peccrecord',array('id' => $id));
		if(empty($order)) return false;
		if($_W['wlsetting']['pecc']['noticetype'] == 1){
			pecc_notice($order);
		}elseif($_W['wlsetting']['pecc']['noticetype'] == 2){
			$carmember = pdo_get('weliam_shiftcar_member',array('id' => $order['mid']));
			api::send_sys_sms($carmember,'pecc','违章信息短信通知',$order);
		}elseif($_W['wlsetting']['pecc']['noticetype'] == 3){
			pecc_notice($order);
			$carmember = pdo_get('weliam_shiftcar_member',array('id' => $order['mid']));
			api::send_sys_sms($carmember,'pecc','违章信息短信通知',$order);
		}elseif($_W['wlsetting']['pecc']['noticetype'] == 4){
			$carmember = pdo_get('weliam_shiftcar_member',array('id' => $order['mid']));
			api::send_yy_sms($carmember,'pecc','违章信息语音通知',$order);
		}elseif($_W['wlsetting']['pecc']['noticetype'] == 5){
			pecc_notice($order);
			$carmember = pdo_get('weliam_shiftcar_member',array('id' => $order['mid']));
			api::send_yy_sms($carmember,'pecc','违章信息语音通知',$order);
		}else{
			pecc_notice($order);
			$carmember = pdo_get('weliam_shiftcar_member',array('id' => $order['mid']));
			api::send_sys_sms($carmember,'pecc','违章信息短信通知',$order);
			api::send_yy_sms($carmember,'pecc','违章信息语音通知',$order);
		}
	}	
	
/************以下是自动长链转短链*****************/	
	//自动处理长链
	static function auto_long2short(){
		global $_W;
//		$lock = Util::getCache('long2shortlock','first');;	
//		if($lock['value'] == 1 && $lock['expire'] > (time() - 30)){
//			return false;
//		}
		
		$data = pdo_fetchall("select id from".tablename('qrcode')."where uniacid = {$_W['uniacid']} and model = 3 and url not like '%http://w.url.cn%' limit 0,10 ");
		if(empty($data)) return false;

		foreach($data as $v){
			$cardsn = pdo_get('weliam_shiftcar_qrcode',array('qrid' => $v['id']),array('cardsn','salt'));
			$showurl = app_url('qr/qrcode',array('ncnumber' => $cardsn['cardsn'],'salt' => $cardsn['salt']));
			$result = Util::long2short($showurl);
			if($result['errcode'] == 0){
				pdo_update('qrcode',array('url' => $result['short_url']),array('id' => $v['id']));
			}
		}
//		$array = array('value'=>1,'expire'=>time());
//		Util::setCache('long2shortlock','first',$array);
	}
	
	//发送限行提醒
	static function send_limitline(){
		global $_W;
		if(empty($_W['wlsetting']['limitline']['status']) || empty($_W['wlsetting']['limitline']['sendtime']) || empty($_W['wlsetting']['limitline']['m_limit'])) return false;
		$ptime = time() - 86400;
		$data = pdo_fetchall("select id,plate1,plate2,plate_number from".tablename('weliam_shiftcar_member')."where uniacid = {$_W['uniacid']} and limitlinetime < {$ptime} and status = 2 limit 0,100 ");
		if(empty($data)) return false;
		$alltpl = pdo_getall('weliam_shiftcar_limitlinetpl',array('uniacid'=>$_W['uniacid']));
		if(empty($alltpl)) return false;
		foreach ($alltpl as $kk => &$v) {
			$v['data'] = unserialize($v['data']);
			if($v['islimittime'] == 2){
				$v['limittime'] = unserialize($v['limittime']);
			}
		}
		foreach ($data as $key => $value) {
			$islimt = '';
			$issend = '';
			foreach ($alltpl as $k => $val) {
				if($val['islimittime'] == 1 || ($val['islimittime'] == 2 && $val['limittime']['start'] < time() && $val['limittime']['end'] > time())){
					if(!empty($val['data'])){
						foreach ($val['data'] as $dk => $da) {
							if($da['data_shop'] == 'ALL'){
								if($da['data_temp'] == $value['plate1']) $islimt = TRUE;
							}else{
								if($da['data_temp'] == $value['plate1'] && $da['data_shop'] == $value['plate2']) $islimt = TRUE;
							}
							if($islimt) break;
						}
					}
					if($val['isnumber'] == 1){
						$plate_number = substr($value['plate_number'],-1);
						if(!is_numeric($plate_number)){
							$plate_number = 0;
						}
					}else{
						$plate_number = preg_replace('/[\.a-zA-Z]/s','',$value['plate_number']);
						$plate_number = substr($plate_number,-1);
					}
					if($val['type'] == 1 && $islimt){
						$limitweek = explode(';', $val['limitweek']);
						$week = date('w');
						$limitweek = explode(',', $limitweek[$week]);
						if(in_array($plate_number, $limitweek)){
							$issend = $val['id'];
						}
					}elseif($val['type'] == 2 && $islimt){
						$limitday = explode(';', $val['limitday']);
						$day = date('j');
						$day = $day%2;
						if($day == 0){
							$limitday = explode(',', $limitday[0]);
						}else{
							$limitday = explode(',', $limitday[1]);
						}
						if(in_array($plate_number, $limitday)){
							$issend = $val['id'];
						}
					}
				}
				if($islimt && $issend) break;
			}
			if($islimt && $issend){
				pdo_insert('weliam_shiftcar_waitmessage',array('uniacid'=>$_W['uniacid'],'type'=>2,'str'=>serialize(array('mid'=>$value['id'],'tplid'=>$issend))));
			}
			pdo_update('weliam_shiftcar_member',array('limitlinetime'=>time()),array('id'=>$value['id']));
		}
	}
}

