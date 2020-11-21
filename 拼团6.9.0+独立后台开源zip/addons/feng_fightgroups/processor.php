<?php
/**
 * 拼团模块处理程序
 *
 * @author 甜筒君
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Feng_fightgroupsModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W;
		//这里定义此模块进行消息处理时的具体过程, 请查看微擎文档来编写你的代码
		$message = $this -> message;
		$openid = $this -> message['from'];
		$content = $this -> message['content'];
		$msgtype = strtolower($message['msgtype']);
		$event = strtolower($message['event']);
		if ($msgtype == 'text' || $event == 'click') {
			$saler = pdo_fetch('select * from ' . tablename('tg_saler') . ' where openid=:openid and status=:status', array(':status' => 1, ':openid' => $openid));
			if (empty($saler)) {
				return $this -> salerEmpty();
			} 
			if (!$this -> inContext) {
				$this -> beginContext();
				return $this -> respText('请输入核销码:');
			} else if ($this -> inContext && is_numeric($content)) {
				$order = pdo_fetch('select * from ' . tablename('tg_order') . ' where hexiaoma=:hexiaoma and uniacid=:uniacid', array(':hexiaoma' => $content, ':uniacid' => $_W['uniacid']));
				if (empty($order)) {
					return $this -> respText('未找到要核销的订单,请重新输入!');
				} 
				$orderid = $order['id'];
				if ($order['is_hexiao'] == 0) {
					$this -> endContext();
					return $this -> respText('订单无需核销!');
				} 
				if ($order['is_hexiao'] == 2) {
					$this -> endContext();
					return $this -> respText('此订单已核销，无需重复核销!');
				} 
				if ($order['status'] != 2) {
					$this -> endContext();
					return $this -> respText('订单状态错误，无法核销!');
				} 
				$storeids = array();
				$salerids = array();
				$goods = pdo_fetch("select hexiao_id from " . tablename('tg_goods')." where id=:id and uniacid=:uniacid ", array(':uniacid' => $_W['uniacid'], ':id' => $order['g_id']));
				$storeids = array_merge(unserialize($goods['hexiao_id']), $storeids);
				$salerids = array_merge(explode(',', $saler['storeid']), $salerids);
				$inter = array_intersect($storeids, $salerids);
				if (!empty($storeids)) {
					if (!empty($saler['storeid'])) {
						if (empty($inter)) {
							return $this -> respText('您无此门店的核销权限!');
						} 
					} 
				}
				$time = time();
				pdo_update('tg_order', array('status' => 4, 'sendtime' => $time, 'gettime' => $time, 'is_hexiao' => 2, 'veropenid' => $openid), array('id' => $order['id']));
				if($order['pay_type']!=4){
					pdo_insert("tg_merchant_money_record",array('merchantid'=>$order['merchantid'],'uniacid'=>$order['uniacid'],'money'=>$order['price'],'orderid'=>$order['id'],'createtime'=>TIMESTAMP,'type'=>2,'detail'=>'核销码核销成功：核销订单号：'.$order['orderno']));
					
					$merchant = pdo_fetch("select no_money from".tablename('tg_merchant_account')."where uniacid={$_W['uniacid']} and merchantid={$order['merchantid']} ");
					if(empty($merchant)){
						pdo_insert("tg_merchant_account",array('no_money'=>0,'merchantid'=>$order['merchantid'],'uniacid'=>$_W['uniacid'],'uid'=>$_W['uid'],'amount'=>0,'updatetime'=>TIMESTAMP));
					}else{
						$m = $merchant['no_money']+$order['price'];
						pdo_update("tg_merchant_account",array('no_money'=>$merchant['no_money']+$order['price'],'updatetime'=>TIMESTAMP),array('merchantid'=>$order['merchantid']));
					}
				}
				$this -> endContext();
				return $this -> respText('核销成功!');
			} 
		} 
	}
	private function salerEmpty() {
		ob_clean();
		ob_start();
		echo '';
		ob_flush();
		ob_end_flush();
		exit(0);
	}
}