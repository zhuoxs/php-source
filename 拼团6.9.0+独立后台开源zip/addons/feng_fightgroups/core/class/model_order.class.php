<?php 
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2020.
// +----------------------------------------------------------------------
// | Describe: 订单操作模型
// +----------------------------------------------------------------------
// | Author: weliam<937991452@qq.com>
// +----------------------------------------------------------------------

class model_order
{
	 /** 
 	* 获取单条订单数据 
 	* 
 	* @access static
 	* @name getSingleOrder 
 	* @param $where   查询条件 
 	* @param $select  查询参数 
 	* @return array 
 	*/  
	static function getSingleOrder($id,$select,$where=array()){
		$where['id'] = $id;
//		$orderInfo = Util::getDataByCacheFirst('order',$id,array('Util','getSingelData'),array($select,'tg_order',$where));
		$orderInfo = Util::getSingelData($select, 'tg_order', $where); //订单信息不采用缓存存取，因为修改比较频繁
		if(empty($orderInfo)) return array();
		return self::initSingleOrder($orderInfo);
		//需删除缓存
	}
	/** 
 	* 获取多条订单数据 
 	* 
 	* @access static
 	* @name getNumOrder 
 	* @param $where   查询条件 
 	* @param $select  查询参数 
 	* @param $order   排序 
 	* @param $pindex  页码 
 	* @param $psize   页显示数 
 	* @param $ifpage  是否需要分页 
 	* @return array 
 	*/
	static function getNumOrder($select,$where,$order,$pindex,$psize,$ifpage){
		$orderInfo = Util::getNumData($select, 'tg_order', $where, $order, $pindex, $psize, $ifpage);
		foreach($orderInfo[0] as $k=>$v){
			$newOrderInfo[$k] = self::initSingleOrder($v);
		}
		return array($newOrderInfo,$orderInfo[1],$orderInfo[2]);
	}
	/** 
 	* 初始化订单数据 
 	* 
 	* @access static
 	* @name  initSingleOrder 
 	* @param $orderInfo  订单数据 
 	* @return $orderInfo 
 	*/
	static function initSingleOrder($orderInfo){
		global $_W;
		$goodsInfo = model_goods::getSingleGoods($orderInfo['g_id'], "*");
		if($goodsInfo){
			$orderInfo['gimg'] = tomedia($goodsInfo['gimg']);
			$orderInfo['gname'] = $goodsInfo['gname'];
			$orderInfo['unit'] = $goodsInfo['unit']?$goodsInfo['unit']:'件';
			$orderInfo['merchantname'] = $goodsInfo['merchantname']?$goodsInfo['merchantname']:$_W['account']['name'];
			$paytype = array('0' => array('css' => 'default', 'name' => '未支付'), '1' => array('css' => 'info', 'name' => '余额支付'), '2' => array('css' => 'success', 'name' => '微信支付'), '3' => array('css' => 'warning', 'name' => '支付宝支付'), '4' => array('css' => 'danger', 'name' => '货到付款'));
			if($orderInfo['is_hexiao']==0)
			$orderstatus = array('0' => array('css' => 'default', 'name' => '待付款'), '1' => array('css' => 'info', 'name' => '已付款'), '2' => array('css' => 'warning', 'name' => '待发货'), '3' => array('css' => 'success', 'name' => '已发货'), '4' => array('css' => 'success', 'name' => '已签收'), '5' => array('css' => 'default', 'name' => '已取消'), '6' => array('css' => 'danger', 'name' => '待退款'), '7' => array('css' => 'default', 'name' => '已退款'),'9' => array('css' => 'default', 'name' => '已过期'),'10' => array('css' => 'default', 'name' => '已删除'));
			else
			$orderstatus = array('0' => array('css' => 'default', 'name' => '待付款'), '1' => array('css' => 'info', 'name' => '已付款'), '2' => array('css' => 'warning', 'name' => '待消费'), '3' => array('css' => 'success', 'name' => '待消费'), '4' => array('css' => 'success', 'name' => '已消费'), '5' => array('css' => 'default', 'name' => '已取消'), '6' => array('css' => 'danger', 'name' => '待退款'), '7' => array('css' => 'default', 'name' => '已退款'),'9' => array('css' => 'default', 'name' => '已过期'),'10' => array('css' => 'default', 'name' => '已删除'));
			$orderInfo['pay_typeCss'] = $paytype[$orderInfo['pay_type']]['css'];
			$orderInfo['pay_typeName'] = $paytype[$orderInfo['pay_type']]['name'];
			$orderInfo['statusCss'] = $orderstatus[$orderInfo['status']]['css'];
			$orderInfo['statusName'] = $orderstatus[$orderInfo['status']]['name'];
		}
		if(!empty($orderInfo['transid']) && empty($orderInfo['pay_type'])){
			if(pdo_update('tg_order',array('pay_type'=>2),array('id'=>$orderInfo['id'])))
			Util::deleteCache('order', $orderInfo['id']);
		}
		return $orderInfo;
	}
	/** 
 	* 获取多条订单数据 
 	* 
 	* @access static
 	* @name getNumOrder 
 	* @param $where   查询条件 
 	* @param $select  查询参数 
 	* @return array 
 	*/
	static function getAllOrder($select,$where,$order,$pindex,$psize,$ifpage){
		$orderInfo = Util::getDataByCacheFirst('order','allOrder',array('Util','getNumData'),array($select,'tg_order',$where,$order,$pindex, $psize,$ifpage));
		return array($orderInfo[0],$orderInfo[1],$orderInfo[2]);
	}
	/** 
	* 获取指定用户指定团订单数量 
	* 
	* @access static
	* @name 方法名称 
	* @param mixed  参数一的说明 
	* @return array 
	*/  
	static function getMemberOrderNumWithGoods($openid,$goodsid){
		global $_W;
		return self::getNumOrder('id',array('openid'=>$openid,'g_id'=>$goodsid,'#status#'=>'(1,2,3,4)') , 'id desc', 0, 0, 1);
		
	}
	/** 
	* 单个订单退款 
	* 
	* @access static
	* @name refundMoney 
	* @param $orderno  订单号
	* @param $money    退款金额
	* @param $refund_reason  退款原因
	* @param $type     退款类型
	* @return array 
	*/  
	static function refundMoney($id,$money,$refund_reason,$type=5){
		global $_W;	
		$orderinfo=model_order::getSingleOrder($id, '*');
		$goods = model_goods::getSingleGoods($orderinfo['g_id'], '*');
		
		if($orderinfo['pay_type']==1)$orderinfo['transid']='余额支付';
		
		if($money<=0 || $orderinfo['price']<=0 || empty($orderinfo['transid'])){
			pdo_update("tg_order",array('status'=>7),array('id'=>$orderinfo['id']));
			Util::deleteCache('order', $id);
			return FALSE;
		}
		$paytype = array('credit' => 1, 'wechat' => 2, 'alipay' => 3, 'delivery' => 4);
		$data2 = array('refund_id'=>'','merchantid' => $orderinfo['merchantid'], 'transid' => $orderinfo['transid'], 'createtime' => TIMESTAMP, 'status' => 0, 'type' => $type, 'goodsid' => $orderinfo['g_id'], 'orderid' => $orderinfo['id'], 'payfee' => $orderinfo['price'], 'refundfee' => $money, 'refundername' => $orderinfo['addname'], 'refundermobile' => $orderinfo['mobile'], 'goodsname' => $goods['gname'], 'uniacid' => $_W['uniacid']);
		pdo_insert('tg_refund_record', $data2);
		
		if($orderinfo['pay_type'] == '1'){ //余额支付
			wl_load()->model('setting');
			wl_load()->model('credit');
			load()->model('mc');
			$tgsetting=setting_get_by_name("member");
			$credit_type = $tgsetting['credit_type']?$tgsetting['credit_type']:1; //$credit_type=1为微擎积分余额
			$uid = mc_openid2uid($orderinfo['openid']);	
			if(credit_update_credit2($uid ,$money,$credit_type,'退款：'.$goods['gname']))
			$refund = TRUE;
		}elseif($orderinfo['pay_type'] == '2'){ //微信支付
			$pay = new WeixinPay;
			$arr = array('transid'=>$orderinfo['transid'],'totalmoney'=>$orderinfo['price'],'refundmoney'=>$money);
			$data = $pay -> refund($arr);
			if($data['err_code'] == 'NOTENOUGH') {
				$arr['refund_account']=2;
				$data = $pay -> refund($arr);
			}
			if(!empty($data['refund_id']) && $data['return_code']=='SUCCESS' && $data['result_code']=='SUCCESS') $refund = TRUE;
		}
		
		if($refund){
			if(!empty($goods['merchantid'])) 
				model_merchant::updateAmount(0-$orderinfo['price'], $goods['merchantid'],$orderinfo['id'],1,'订单退款');  //商家减帐
			if(!empty($orderinfo['merchantid']))
				pdo_insert("tg_merchant_money_record",array('merchantid'=>$orderinfo['merchantid'],'uniacid'=>$_W['uniacid'],'money'=>0-$money,'orderid'=>$orderinfo['id'],'createtime'=>TIMESTAMP,'type'=>5,'detail'=>'退款：订单号'.$orderinfo['orderno']));
			if ($type == 3) {
				pdo_update('tg_order', array('status' => 7, 'is_tuan' => 2), array('id' => $orderinfo['id']));
			} else {
				pdo_update('tg_order', array('status' => 7), array('id' => $orderinfo['id']));
			}
			if($goods['givecouponid']){
				model_coupon::coupon_grant($orderinfo['openid'],$goods['givecouponid']);
			}
			pdo_fetch("select * from".tablename('tg_refund_record')."where orderid = {$orderinfo['id']}");
			
			pdo_update('tg_refund_record', array('status' => 1, 'refund_id' => $orderinfo['pay_type']==1?'余额退款':$data['refund_id']), array('orderid' => $orderinfo['id']));
			$url = app_url('order/order/detail',array('id'=>$id));
			$refund_reason=empty($refund_reason)?'购买失败':$refund_reason;
			if($orderinfo['lottery_status']==1)$refund_reason='未中奖，已退款。';
			if($orderinfo['lottery_status']==2)$refund_reason='一等奖奖励，退款。';
			if($orderinfo['lottery_status']==3)$refund_reason='二等奖奖励，退款。';
			if($orderinfo['lottery_status']==4)$refund_reason='三等奖奖励，退款。';
			message::refund_success($orderinfo['orderno'], $orderinfo['openid'], $money, $url,$refund_reason);
			$res['status'] = true;					
			$res['message'] = '退款成功';		
			$orderinfo['time'] = date("Y-m-d H:i:s",time());
			file_put_contents(TG_DATA."/refundSuccess.log", var_export($orderinfo, true).PHP_EOL, FILE_APPEND);			
		}else{
			pdo_update('tg_refund_record', array('refund_id' => $orderinfo['pay_type']==1?'余额退款':$data['err_code_des']), array('orderid' => $orderinfo['id']));
			if(empty($orderinfo['failrefund'])){
				$newnum = 1;
			}else {
				$newnum = $orderinfo['failrefund'] + 1; 
			}
			pdo_update('tg_order',array('failrefund' =>$newnum),array('id'=>$orderinfo['id']));
			$res['status'] = false;
			$res['message'] = $orderinfo['pay_type']==1?'余额退款失败':$data['err_code_des'];					
			$res['error_code'] = $orderinfo['pay_type']==1?'余额退款失败':$data['err_code_des'];
			$orderinfo['time'] = date("Y-m-d H:i:s",time());
			file_put_contents(TG_DATA."/refundFail.log", var_export($orderinfo, true).PHP_EOL, FILE_APPEND);			
		}
		return $res;
	}
	/** 
	* 获取多个退款订单
	* 
	* @access static
	* @name getNumRefundOrder 
	* @param $num  个数
	* @return array 
	*/  
	static function getNumRefundOrder($num){
		global $_W;
		if($num==0){
			return pdo_fetchall("select price,status,transid,pay_type,orderno,id from".tablename("tg_order")."where uniacid={$_W['uniacid']} and failrefund < 3 and status=6");
		}else{
			return pdo_fetchall("select * from".tablename("tg_order")."where uniacid={$_W['uniacid']} and failrefund < 3  and status=6 ORDER BY ptime ASC LIMIT 0,{$num}");
		}
	}
		
	/** 
	* 更改订单为取消
	* 
	* @access static
	* @name cancelDoNotPayOrder 
	* @param $orderinfo  订单信息
	* @return  
	*/  
	static function cancelDoNotPayOrder($orderinfo){
		global $_W;
		if($orderinfo['status'] != 0) return false; //不是待支付的订单
		$res = pdo_update('tg_order',array('status'=>5),array('id'=>$orderinfo['id'],'status'=>0));
		return $res;
	}
	
	/** 
	* 更改订单为已收货
	* 
	* @access static
	* @name confirmOrder 
	* @param $orderinfo  订单信息
	* @return  
	*/  
	static function confirmOrder($orderinfo){
		if($orderinfo['status'] != 3) return false; //不是已发货的订单
		$res = pdo_update('tg_order',array('status'=>4,'gettime'=>time()),array('id'=>$orderinfo['id'],'status'=>3));
		return $res;	
	}
	/** 
	* 订单概况统计
	* 
	* @access getNumAndTimeOrder
	* @name confirmOrder 
	* @param $where  共用条件
	* @return  
	*/ 
	static function getNumAndTimeOrder($where){
		global $_W;
		$uniacid = $_W['uniacid'];
		$data = Util::getCache('order', 'orderData'.$where['merchantid']);
		if(empty($data)){
			$seven_orders =  0;
			$obligations =  0;
			$undelivereds =  0;
			$incomes =  0;
			$stime = strtotime(date('Y-m-d')) - 6 * 86400;
			$etime = strtotime(date('Y-m-d')) + 86400;
			$where['lottery_status'] = 0;
			$where['createtime>']=$stime;
			$where['createtime<']=$etime;
			/*最近7天*/
			$where['#status#']='(1,2,3,4,6,7)';
			$sevenOrderData = self::getNumOrder('price', $where, 'createtime desc', 0, 0, TRUE);
			$seven_orders = $sevenOrderData[2];
			unset($where['status']);
			$where['status']=0;
			$obligationsData = self::getNumOrder('price', $where, 'createtime desc', 0, 0, TRUE);
			$obligations = $obligationsData[2];
//			$obligations = sprintf("%.2f",$obligations);
			unset($where['status']);
			$where['status']=2;
			$undeliveredsData = self::getNumOrder('price', $where, 'createtime desc', 0, 0, TRUE);
			$undelivereds = $undeliveredsData[2];
			unset($where['status']);
			$where['#status#']='(1,2,3,4,6,7)';
			$sevenData = self::getNumOrder('price', $where, 'createtime desc', 0, 0, TRUE);
			$seven = $sevenData[0]?$sevenData[0]:array();
			foreach($seven as$key=>$value){
				$incomes += $value['price'];
			}
			$incomes = sprintf("%.2f",$incomes);
			/*折线图*/
			unset($where['status'],$where['createtime>'],$where['createtime<']);
			$wek_num = array();
			$wek_money = array();
			for($i=1;$i<=7;$i++){
				$wek_num_order=0;
				$wek_money_order=0;
				$stime = mktime(0, 0 , 0,date("m"),date("d")-date("w")+$i,date("Y"));
				$etime = mktime(23,59,59,date("m"),date("d")-date("w")+$i,date("Y"));
				$where['ptime>']=$stime;
				$where['ptime<']=$etime;
				$where['#status#']='(1,2,3,4,6,7)';
				$numData = model_order::getNumOrder('price,gnum', $where, 'ptime desc', 0, 0, TRUE);
				$num = $numData[0]?$numData[0]:array();
				foreach($num as $value){
					$wek_num_order +=  $value['gnum'];
					$wek_money_order += $value['price'];
				}
				$wek_num[] = $wek_num_order;
				$wek_money[] =  sprintf("%.2f",$wek_money_order);
			}
			
			/*柱状图*/
			unset($where['status'],$where['ptime>'],$where['ptime<']);
			$mon_num = array();
			$mon_money = array();
			for($i=1;$i<=12;$i++){
				$mon_num_order=0;
				$mon_money_order=0;
				$y = date("Y");
				if (in_array($i, array('1', '3', '5', '7', '8', '01', '03', '05', '07', '08', '10', '12'))) {  
		            $text = '31';  
				}elseif ($i == 2){  
		            if ($y % 400 == 0 || ($y % 4 == 0 && $y % 100 !== 0)) {        //判断是否是闰年  
		                $text = '29';  
		            } else {  
		                $text = '28';  
		            }  
		        } else {  
		            $text = '30';  
		        }
				$stime = mktime(0, 0 , 0, $i,    1,date("Y"));
				$etime = mktime(23,59,59, $i,$text,date("Y"));
				$where['ptime>']=$stime;
				$where['ptime<']=$etime;
				$where['#status#']='(1,2,3,4,6,7)';
				$numData = model_order::getNumOrder('price,gnum', $where, 'ptime desc', 0, 0, TRUE);
				$num = $numData[0]?$numData[0]:array();;
				foreach($num as $value){
					$mon_num_order +=  $value['gnum'];
					$mon_money_order += $value['price'];
				}
				$mon_num[] = $mon_num_order;
				$mon_money[] = sprintf("%.2f",$mon_money_order);
			}

			/*饼状图*/
			unset($where['status'],$where['ptime>'],$where['ptime<']);
			$where['#status#']='(0,5)';
			$numData = model_order::getNumOrder('id', $where, 'ptime desc', 0, 0, TRUE);
			$all1= $numData[2];
			$where['#status#']='(1)';
			$numData2 = model_order::getNumOrder('id', $where, 'ptime desc', 0, 0, TRUE);
			$all2= $numData2[2];
			
			$where['#status#']='(2)';
			$numData3= model_order::getNumOrder('id', $where, 'ptime desc', 0, 0, TRUE);
			$all3= $numData3[2];
			
			$where['#status#']='(3,4)';
			$numData4= model_order::getNumOrder('id', $where, 'ptime desc', 0, 0, TRUE);
			$all4= $numData4[2];
			
			$where['#status#']='(6,7)';
			$numData5= model_order::getNumOrder('id', $where, 'ptime desc', 0, 0, TRUE);
			$all5= $numData5[2];
			
			/*浏览量*/
			$merchantid = !empty($where['merchantid'])?' and merchantid = '.$where['merchantid']:'';
			//昨日
			$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
			$endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
			$pv1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_puv_record') . " WHERE  createtime >= '{$beginYesterday}' and createtime <= '{$endYesterday}' and openid<>''  ".$merchantid."  ");
			$pu1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_puv_record') . " WHERE  createtime >= '{$beginYesterday}' and createtime <= '{$endYesterday}' and openid<>''  and goodsid=0 and status=1 ".$merchantid."  ");
			//今日
			$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
			$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
			$pv2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_puv_record') . " WHERE  createtime >= '{$beginToday}' and createtime <= '{$endToday}' and openid<>''  ".$merchantid."  and uniacid={$uniacid}  ");
			$pu2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_puv_record') . " WHERE  createtime >= '{$beginToday}' and createtime <= '{$endToday}' and openid<>'' and goodsid=0  and status=1  ".$merchantid." and uniacid={$uniacid}  ");
			//这周
			$beginLastweek=mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
			$endLastweek=mktime(23,59,59,date('m'),date('d'),date('Y'));
			$pv3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_puv_record') . " WHERE  createtime >= '{$beginLastweek}' and createtime <= '{$endLastweek}' and openid<>''   ".$merchantid." and uniacid={$uniacid}  ");
			$pu3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_puv_record') . " WHERE  createtime >= '{$beginLastweek}' and createtime <= '{$endLastweek}' and openid<>'' and goodsid=0  and status=1  ".$merchantid."  and uniacid={$uniacid} ");
			//这月
			$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
			$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
			$pv4 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_puv_record') . " WHERE  createtime >= '{$beginThismonth}' and createtime <= '{$endThismonth}'  and openid<>''   ".$merchantid." and uniacid={$uniacid}  ");
			$pu4 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_puv_record') . " WHERE  createtime >= '{$beginThismonth}' and createtime <= '{$endThismonth}' and openid<>'' and goodsid=0  and status=1  ".$merchantid."  and uniacid={$uniacid} ");
			
			 //*地图*/
			$orders= pdo_fetchall('SELECT address FROM ' . tablename('tg_order') . "  WHERE   uniacid={$uniacid} and ptime>'1' ".$merchantid."");
			$address_arr['beijing']=0;
			$address_arr['tianjing']=0;
			$address_arr['shanghai']=0;
			$address_arr['chongqing']=0;
			$address_arr['hebei']=0;
			$address_arr['yunnan']=0;
			$address_arr['liaoning']=0;
			$address_arr['heilongjiang']=0;
			$address_arr['hunan']=0;
			$address_arr['anhui']=0;
			$address_arr['shandong']=0;
			$address_arr['xingjiang']=0;
			$address_arr['jiangshu']=0;
			$address_arr['zhejiang']=0;
			$address_arr['jiangxi']=0;
			$address_arr['hubei']=0;
			$address_arr['guangxi']=0;
			$address_arr['ganshu']=0;
			$address_arr['shanxi']=0;
			$address_arr['neimenggu']=0;
			$address_arr['sanxi']=0;
			$address_arr['jiling']=0;
			$address_arr['fujian']=0;
			$address_arr['guizhou']=0;
			$address_arr['guangdong']=0;
			$address_arr['qinghai']=0;
			$address_arr['xizhang']=0;
			$address_arr['shichuan']=0;
			$address_arr['ningxia']=0;
			$address_arr['hainan']=0;
			foreach($orders as$key=>$value){
				$address_name = mb_strcut($value['address'], 0, 6, 'utf-8'); 
				switch($address_name){
					case '北京':$address_arr['beijing'] += 1;break;
					case '天津':$address_arr['tianjing']+= 1;break;
					case '上海':$address_arr['shanghai']+= 1;break;
					case '重庆':$address_arr['chongqing']+= 1;break;
					case '河北':$address_arr['hebei']+= 1;break;
					case '河南':$address_arr['henan']+= 1;break;
					case '云南':$address_arr['yunnan']+= 1;break;
					case '辽宁':$address_arr['liaoning']+= 1;break;
					case '黑龙':$address_arr['heilongjiang']+= 1;break;
					case '湖南':$address_arr['hunan']+= 1;break;
					case '安徽':$address_arr['anhui']+= 1;break;
					case '山东':$address_arr['shandong']+= 1;break;
					case '新疆':$address_arr['xingjiang']+= 1;break;
					case '江苏':$address_arr['jiangshu']+= 1;break;
					case '浙江':$address_arr['zhejiang']+= 1;break;
					case '江西':$address_arr['jiangxi']+= 1;break;
					case '湖北':$address_arr['hubei']+= 1;break;
					case '广西':$address_arr['guangxi']+= 1;break;
					case '甘肃':$address_arr['ganshu']+= 1;break;
					case '山西':$address_arr['shanxi']+= 1;break;
					case '内蒙':$address_arr['neimenggu']+= 1;break;
					case '陕西':$address_arr['sanxi']+= 1;break;
					case '吉林':$address_arr['jiling']+= 1;break;
					case '福建':$address_arr['fujian']+= 1;break;
					case '贵州':$address_arr['guizhou']+= 1;break;
					case '广东':$address_arr['guangdong']+= 1;break;
					case '青海':$address_arr['qinghai']+= 1;break;
					case '西藏':$address_arr['xizhang']+= 1;break;
					case '四川':$address_arr['shichuan']+= 1;break;
					case '宁夏':$address_arr['ningxia']+= 1;break;
					case '海南':$address_arr['hainan']+= 1;break;
				}
			}
			$time = date("Y-m-d H:i:s",time());
			$data = array($seven_orders,$obligations,$undelivereds,$incomes,$wek_num,$wek_money,$mon_num,$mon_money,$all1,$all2,$all3,$all4,$all5,$pv1,$pv2,$pv3,$pv4,$pu1,$pu2,$pu3,$pu4,$address_arr,$time);
			Util::setCache('order', 'orderData'.$where['merchantid'], $data);
		}
		return $data;
	}
	/** 
	* 处理订单生成时商品营销优惠 
	* 
	* @access static
	* @name getAfterMarketingPrice 
	* @param $pay_price  处理前 商品个数*商品数量价格（不包括运费） 
	* @param $num  商品个数
	* @param $goodsid  商品ID 
	* @param $shouldFreight  应该支付的运费 
	* @param $deduct  是否抵扣 
	* @return array 
	*/  
	static function getAfterMarketingPrice($pay_price,$num,$goodsid,$shouldFreight,$deduct){
		global $_W;
		$marketing = model_goods::getMarketing($goodsid); //获取营销参数
		$m1 = $m2 = $m3 = $m4 = FALSE;
		$max=$p=0;
		$payFreight = $shouldFreight;
		$orderMarket=array();
		if($marketing[0]){ //满减
			foreach($marketing[0] as $value){
				if($pay_price > $value['enough']){
					$p = $value['enough']>$max?$value['give']:$p;
					$max = $value['enough']>$max?$value['enough']:$max;
					$m1 = TRUE;
				}
			}
			$max=sprintf("%.2f", $max);
			$p=sprintf("%.2f", $p);
			$orderMarket['enough_give'] = serialize(array($max,$p));
			$pay_price = $pay_price - $p;
		}
		if($marketing[1]['edmoney']){ //满N元包邮
			if($pay_price >=$marketing[1]['edmoney']){
				$m2 = TRUE;
				$marketing[1]['edmoney']=sprintf("%.2f", $marketing[1]['edmoney']);
				$orderMarket['edmoney'] = $shouldFreight;
				$payFreight = 0;
			}
		}
		if($marketing[1]['ednum']  && !$m2){ //包邮
			if($num >= $marketing[1]['ednum']){
				$m3 = TRUE;
				$orderMarket['ednum'] = $shouldFreight;
				$payFreight = 0;
			}
		}
		if($marketing[2]['deduct']){ //积分抵扣
			$m4=TRUE;
			wl_load()->model('credit');
			wl_load()->model('setting');
			$tgsetting=setting_get_by_name("member");
			$credit_type = $tgsetting['credit_type']?$tgsetting['credit_type']:1; //$credit_type=1为微擎积分余额
			$credits = credit_get_by_uid($_W['member']['uid'],$credit_type);
			$money = $marketing[2]['money']; //1积分抵扣多少钱
			$singleMax=$marketing[2]['deduct']; // 单件最多抵扣
			if($marketing[2]['manydeduct']){ //累计抵扣
				$manydeduct=$num*$singleMax; //累计可以抵扣金额
				if($money*$credits['credit1'] >= $manydeduct) {//有足够积分
					$deductMoney = sprintf("%.2f",$manydeduct);
					$deductCredit = $manydeduct/$money;
				}else{
					$deductMoney = sprintf("%.2f",$money*$credits['credit1']);
					$deductCredit = $credits['credit1'];
				}
			}else{ //只抵扣一件商品
				if($money*$credits['credit1'] >= $singleMax) {//有足够积分
					$deductMoney = sprintf("%.2f",$singleMax);
					$deductCredit = $singleMax/$money;
				}else{
					$deductMoney = sprintf("%.2f",$money*$credits['credit1']);
					$deductCredit = $credits['credit1'];
				}
			}
			$orderMarket['deduct'] = serialize(array($deductCredit,$deductMoney));
			if($deduct) $pay_price = $pay_price - $deductMoney;
		}  
		return array(
				'pay_price'=>$pay_price,
				'm1'=>$m1,
				'm2'=>$m2,
				'm3'=>$m3,
				'm4'=>$m4,
				'max'=>$max,
				'p'=>$p,
				'edunum'=>$marketing[1]['ednum'],
				'edumoney'=>$marketing[1]['edmoney'],
				'credits'=>$credits['credit1'],
				'payFreight'=>$payFreight,
				'deductMoney'=>$deductMoney,
				'deductCredit'=>$deductCredit,
				'orderMarket'=>$orderMarket
			); 
	}
}