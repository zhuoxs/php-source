<?php 

class queue {
	
	private $islock = array('value'=>0,'expire'=>0);
	private $expiretime = 600; //锁过期时间，秒
	private $setting;
	//初始赋值
	public function __construct(){
		$lock = Util::getCache('queuelock','first');
		if(!empty($lock)) $this->islock = $lock;
		$this->setting = Util::getModuleConfig();
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

		if($this->checkLock()){
			return false; //锁定的时候直接返回
		}else{
			$this->setLock(); //没锁的话锁定
		}

		//do something
		//$this->sendMessage(); //发消息
		//$this->checkGroup(); //处理团
		//$this->autoDealOrder(); //自动处理订单
		
		$this->deleteLock(); //执行完删除锁
	}
	
	
/************以下是自动处理订单*****************/	
	

	
	
	
	
/*************以下是自动处理团*****************/	
	

	
	
	

/*************以下是发消息*****************/		
	
	//删除消息队列
	public function deleteMessage($id){
		global $_W;		
		pdo_delete('zofui_supergroup_message',array('uniacid'=>$_W['uniacid'],'id'=>$id),'AND');
	}
	
	//查询需要发消息的记录
	public function getNeedMessageItem(){
		global $_W;
		$array = array(':uniacid'=>$_W['uniacid']);
		return pdo_fetchall("SELECT * FROM ".tablename('zofui_supergroup_message')." WHERE `uniacid` = :uniacid ORDER BY `id` ASC ",$array);
	}
	
	//发消息
	public function sendMessage(){
		$message = $this->getNeedMessageItem();
		/*
		foreach($message as $k=>$v){
			if($v['type'] == 1){ //发货消息
				$order = model_order::getSingleOrder($v['str']);
				if( !empty( $order ) ){
					Message::sendOrder($order['openid'],$order['orderid'],$this->setting['omesage'],$order['title'],$order['fee'],$order['expressname'],$order['expressnum'],$order['address']);
				}
			}
			
			// 给管理员的消息
			if($v['type'] == 2){ //发货消息
				$order = model_order::getSingleOrder($v['str']);
				if( !empty( $order ) ){
					Message::saleSuccess($v['openid'],$order['orderid'],$this->setting['omesage'],$order['title'],$order['fee'],$order['paytype'],$order['sendtype']);
				}
			}			

			$this->deleteMessage($v['id']); //删除已发的
		}*/
	}
		
	
	

	
}

