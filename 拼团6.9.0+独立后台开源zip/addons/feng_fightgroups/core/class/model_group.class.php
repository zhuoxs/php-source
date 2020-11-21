<?php 
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2020.
// +----------------------------------------------------------------------
// | Describe: 拼团团购处理模型
// +----------------------------------------------------------------------
// | Author: weliam<937991452@qq.com>
// +----------------------------------------------------------------------

class model_group
{
	 /** 
 	* 获取单条团数据 
 	* 
 	* @access static
 	* @name getSingleGroup 
 	* @param $where   查询条件 
 	* @param $select  查询参数 
 	* @return array 
 	*/  
	static function getSingleGroup($groupNumber,$select,$where=array()){
		$where['groupnumber'] = $groupNumber;
//		$groupInfo = Util::getDataByCacheFirst('group',$groupNumber,array('Util','getSingelData'),array($select,'tg_group',$where));
		$groupInfo = Util::getSingelData($select,'tg_group',$where);
		if(empty($groupInfo)) return array();
		return $groupInfo;
		//需删除缓存
	}
	/** 
	* 获取多个团信息 
	* 
	* @access static
	* @name getNumGroup 
	* @param $where   查询条件 
 	* @param $select  查询参数 
 	* @param $order   排序 
 	* @param $pindex  页码 
 	* @param $psize   页显示数 
 	* @param $ifpage  是否需要分页 
	*/  
	static function getNumGroup($select,$where,$order,$pindex,$psize,$ifpage){
		$groupInfo = Util::getNumData($select, 'tg_group', $where, $order, $pindex, $psize, $ifpage);
		foreach($groupInfo[0] as $k=>$v){
			$newGroupInfo[$k] = self::initSingleGroup($v);
		}
		return array($newGroupInfo,$groupInfo[1],$groupInfo[2]);
	}
	/** 
 	* 初始化团数据 
 	* 
 	* @access static
 	* @name  initSingleGroup 
 	* @param $groupInfo  团数据 
 	* @return $groupInfo 
 	*/
	static function initSingleGroup($groupInfo){
		global $_W;
		return $groupInfo;
	}
	/** 
	* 更新团的状态 
	* 
	* @access static
	* @name updateGourpStatus 
	*/ 
	static function updateGourpStatus() {
		global $_W;
		$now = time();
		$allgroups = pdo_fetchall("select endtime,lacknum,groupnumber from" . tablename('tg_group') . "where groupstatus=3 and uniacid='{$_W['uniacid']}'");
		foreach ($allgroups as $key => $value) {
			if ($value['endtime'] < $now && $value['lacknum'] > 0) {
				pdo_update('tg_group', array('groupstatus' => 1), array('groupnumber' => $value['groupnumber']));
				$orders = pdo_fetchall("select id,pay_type,couponid from" . tablename('tg_order') . "where tuan_id='{$value['groupnumber']}' and uniacid='{$_W['uniacid']}' and status in(1,2,3,4)");
				foreach ($orders as $k => $v) {
					if($v['pay_type'] == 4){
						$res = pdo_update('tg_order', array('status' => 7), array('id' => $v['id']));
					}else{
						$res = pdo_update('tg_order', array('status' => 6), array('id' => $v['id']));
					}
					Util::deleteCache('order', $v['id']);
				}
			}
		}
	}
	/*获取指定活动所有是抽奖团但还未抽奖的团的编号*/
	static function getLotteryGroup($lottery_id){
		global $_W;		
		$distinct=pdo_fetchall("select distinct groupnumber from".tablename("tg_group")."where  iflottery=1 and lottery_id={$lottery_id} and lottery_status=1 and uniacid={$_W['uniacid']}");
		return $distinct;
	}
	/*获取指定团的所有订单*/
	static function getGroupOrder($groupnumber){
		global $_W;		
		$orders=pdo_fetchall("select  orderno,lottery_status,pay_price,openid from".tablename("tg_order")."where tuan_id='{$groupnumber}' and uniacid={$_W['uniacid']}");
		return $orders;
	}
	/*指定抽奖活动的所有订单*/
	static function getLotteryOrdersNum($lottery_id){
		global $_W;		
		$num = pdo_fetchcolumn("select count(id) from".tablename("tg_order")."where lotteryid={$lottery_id} and status=2 and uniacid={$_W['uniacid']} and lottery_status not in(5,6,7)");
		return $num;
	}
	static function array_diff_assoc2_deep($array1, $array2){ 
            $ret = array(); 
            foreach ($array1 as $k1 => $v1) {
				foreach($array2  as $k2 => $v2){
					if($v1 == $v2){
						unset($array1[$k1]);
					}
				}
			}
            return $array1; 
	}
	/*判断是否有时间到了的抽奖团更改状态*/
	static function setLotteryOver(){
		global $_W;
		$now = time();
		//判断是否有待开始的抽奖团
		$lotterydai = pdo_fetchall("select id,status,fk_goodsid from".tablename("tg_lottery")."where starttime<={$now}  and uniacid={$_W['uniacid']} and status=2");
		foreach($lotterydai as $item){
			pdo_update("tg_lottery",array('status'=>1),array('id'=>$item['id']));
		}
		
		$lottery = pdo_fetchall("select id,status,fk_goodsid from".tablename("tg_lottery")."where endtime<{$now}  and uniacid={$_W['uniacid']} and status=1");
		foreach($lottery as $item){
			pdo_update("tg_lottery",array('status'=>3),array('id'=>$item['id']));
			pdo_update("tg_goods",array('isshow'=>4),array('id'=>$item['fk_goodsid']));
		}
	}
	/*获取所有抽奖活动ID*/
	static function getLottery(){
		global $_W;		
		$distinct=pdo_fetchall("select id from".tablename("tg_lottery")."where status=3  and uniacid={$_W['uniacid']} and dostatus=0");//已结束，未抽奖
		return $distinct;
	}
	/*获取所有刚结束的抽奖团并抽奖*/
	static function doLotteryOver(){
		global $_W;
		self::setLotteryOver();
		$lottery = self::getLottery();
		foreach($lottery as $item){
			self::doLottery($item['id']);
		}
	}
	
	/*抽奖*/
	static function doLottery($lottery_id,$tuan_id=''){
		global $_W;	
		$now = time();
		$lottery = pdo_fetch("select id,prize,num,num2,num3,gname,pattern,endtime from".tablename("tg_lottery")."where id={$lottery_id}  and uniacid={$_W['uniacid']}");
		$prize = unserialize($lottery['prize']);
		$ordersNum = self::getLotteryOrdersNum($lottery_id);
		$con = '';
		if($lottery['pattern']==2 && !empty($tuan_id)) $con .= "and tuan_id='{$tuan_id}'";
		
		//内定1,2,3等奖
		$default1 =  pdo_fetchcolumn("select count(id) from".tablename('tg_order')."where lotteryid={$lottery_id} and uniacid={$_W['uniacid']} and lottery_status = 5 {$con}") ;
		$default2 =  pdo_fetchcolumn("select count(id) from".tablename('tg_order')."where lotteryid={$lottery_id} and uniacid={$_W['uniacid']} and lottery_status = 6 {$con}") ;
		$default3 =  pdo_fetchcolumn("select count(id) from".tablename('tg_order')."where lotteryid={$lottery_id} and uniacid={$_W['uniacid']} and lottery_status = 7 {$con}") ;
				
		$num  = $lottery['num'] - $default1;
		$num2 = $lottery['num2'] - $default2;
		$num3 = $lottery['num3'] - $default3;
		if($num<0)return false;
		if(($lottery['endtime'] < $now) && $lottery['pattern']==2){
			//抽奖团时间结束
			
		}else{
			$sql = "SELECT orderno,id FROM ".tablename('tg_order')."WHERE lotteryid={$lottery_id} and status=2 and uniacid={$_W['uniacid']} and lottery_status not in(2,3,4,5,6,7) {$con}";
			
			$firsterOrderAll = pdo_fetchall($sql);
			
			$firsterOrder = array();
			if(count($firsterOrderAll)<=$num){
				$firsterOrder = $firsterOrderAll;
			}else{
				$firsterOrderIndex = array_rand($firsterOrderAll,$num);
				if(is_array($firsterOrderIndex)){
					foreach($firsterOrderIndex as $firsterOrderIndexValue){
						$firsterOrder[] = $firsterOrderAll[$firsterOrderIndexValue];
					}
				}else{
					$firsterOrder[0] = $firsterOrderAll[$firsterOrderIndex];
				}
			}
			
			foreach($firsterOrder as$k=> $first){ //一等奖
				if(pdo_update("tg_order",array('lottery_status'=>2),array('orderno'=>$first['orderno']))){
					if ($prize['self']['radio']==2){
						pdo_update('tg_order',array('status'=>6),array('id'=>$first['id']));
					}
				}
			}
			if($lottery['num2'] == -1){ //除了一等奖全是二等奖
				if(pdo_update("tg_order",array('lottery_status'=>3),array('lotteryid'=>$lottery_id,'lottery_status'=>1)))
					if ($prize['first']['radio']==1 || $prize['first']['radio']==3){
						if($lottery['pattern']==2 && !empty($tuan_id)){ // 组团成功就抽奖
							pdo_update('tg_order',array('status'=>6),array('lotteryid'=>$lottery_id,'lottery_status'=>3,'tuan_id'=>$tuan_id));
						}else{
							pdo_update('tg_order',array('status'=>6),array('lotteryid'=>$lottery_id,'lottery_status'=>3));
						}
					}
			}elseif($lottery['num2'] ==0 || $lottery['num2'] < -1){
				//不执行任何操作
			}else{ //正常数量奖品
				$seconderOrderAll = pdo_fetchall($sql);
				$seconderOrder = array();
				if(count($seconderOrderAll)<=$num2){
					$seconderOrder=$seconderOrderAll;
				}else{
					$seconderOrderIndex = array_rand($seconderOrderAll,$num2);
					if(is_array($seconderOrderIndex)){
						foreach($seconderOrderIndex as $seconderOrderValue){
							$seconderOrder[] = $seconderOrderAll[$seconderOrderValue];
						}
					}else{
						$seconderOrder[0] = $seconderOrderAll[$seconderOrderIndex];
					}
				}
				foreach($seconderOrder as $second){
					if(pdo_update("tg_order",array('lottery_status'=>3),array('orderno'=>$second['orderno']))){
						if ($prize['first']['radio']==1 || $prize['first']['radio']==3){
							 pdo_update('tg_order',array('status'=>6),array('id'=>$second['id']));
						}
					}
				}
					 
				if($lottery['num3']==-1){ //除了一等奖二等奖全部是三等奖
					if(pdo_update("tg_order",array('lottery_status'=>4),array('lotteryid'=>$lottery_id,'lottery_status'=>1)))
						if ($prize['second']['radio']==1 ||$prize['second']['radio']==3){
							if($lottery['pattern']==2 && !empty($tuan_id)){ // 组团成功就抽奖
								pdo_update('tg_order',array('status'=>6),array('lotteryid'=>$lottery_id,'lottery_status'=>4,'tuan_id'=>$tuan_id));
							}else{
								pdo_update('tg_order',array('status'=>6),array('lotteryid'=>$lottery_id,'lottery_status'=>4));
							}
						}
						 	
					
				}elseif($lottery['num3'] ==0 || $lottery['num3'] < -1){
					//不执行任何操作
				}else{ //正常数量奖品
					$thirderOrderAll = pdo_fetchall($sql);
					$thirderOrder = array();
					if(count($thirderOrderAll)<=$num3){
						$thirderOrder = $thirderOrderAll;
					}else{
						$thirderOrderIndex = array_rand($thirderOrderAll,$num3);
						if(is_array($thirderOrderIndex)){
							foreach($thirderOrderIndex as $thirderOrderIndexValue){
								$thirderOrder[] = $thirderOrderAll[$thirderOrderIndexValue];
							}
						}else{
							$thirderOrder[0] = $thirderOrderAll[$thirderOrderIndex];
						}
					}
					
					foreach($thirderOrder as $third){
						if(pdo_update("tg_order",array('lottery_status'=>4),array('orderno'=>$third['orderno']))){
							if ($prize['second']['radio']==1 || $prize['second']['radio']==3){
								pdo_update('tg_order',array('status'=>6),array('id'=>$third['id']));
							}
							
						}
					}
						
				}
			}
			
		} 
		/*抽奖完成*/
		if($lottery['pattern']!=2 && empty($tuan_id)){ // 活动结束时抽奖
			queue::addTask(2,$lottery_id); //加入队列处理
			pdo_update("tg_lottery",array('dostatus'=>1),array('id'=>$lottery_id));//更新为已抽
		}
		if($lottery['pattern']==2 && !empty($tuan_id) && !empty($firsterOrder[0]['orderno'])){ // 成团就抽奖
			queue::addTask(3,$firsterOrder[0]['orderno']); //加入队列处理
		}
		 
		return TRUE;
	}
	
}