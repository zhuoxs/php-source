<?php
defined('IN_IA') or exit('Access Denied');

class Order_WeliamController{
	/*
	 * 入口函数
	 */
	
	function orderList(){
		global $_W,$_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$where =array('aid'=>$_W['aid']);
		$where['orderno!='] = '666666';
		if($_GPC['activeid']) $where['activityid'] = $_GPC['activeid'];
		if(!empty($_GPC['status'])){
			if(intval($_GPC['status']) == 10){
				$where['applyrefund'] = 1;
			}else if(intval($_GPC['status']) == 11){
				$where['#status'] = '(1,2,3,6,7,9)';
			}else if(intval($_GPC['status']) == 12){
				$where['#status'] = '(2,3)';
			}else {
				$where['status'] = intval($_GPC['status']);
			}	
		}else{
			$where['#status'] = '(1,2,3,6,7,9,0)';
		}
		if (!empty($_GPC['keyword'])) {
			if(!empty($_GPC['keywordtype'])){
				switch($_GPC['keywordtype']){
					case 1: $where['id'] = $_GPC['keyword'];break;
					case 2: $where['@orderno@'] = $_GPC['keyword'];break;
					case 3: $where['activityid'] = $_GPC['keyword'];break;
					case 4: $where['@sid@'] = $_GPC['keyword'];break;
					case 6: $where['@mobile@'] = $_GPC['keyword'];break;
					case 7: $where['@checkcode@'] = $_GPC['keyword'];break;
					default:break;
				}
				if($_GPC['keywordtype'] == 5){
					$keyword = $_GPC['keyword'];
					$params[':name'] = "%{$keyword}%";
					$members = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_member')."WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND nickname LIKE :name",$params);
					if($members){
						$mids = "(";
						foreach ($members as $key => $v) {
							if($key == 0){
								$mids.= $v['id'];
							}else{
								$mids.= ",".$v['id'];
							}	
						}
						$mids.= ")";
						$where['mid#'] = $mids;
					}else {
						$where['mid#'] = "(0)";
					}
				}
				if($_GPC['keywordtype'] == 8){
					$keyword = $_GPC['keyword'];
					$params[':storename'] = "%{$keyword}%";
					$members = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_merchantdata')."WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND storename LIKE :storename",$params);
					if($members){
						$mids = "(";
						foreach ($members as $key => $v) {
							if($key == 0){
								$mids.= $v['id'];
							}else{
								$mids.= ",".$v['id'];
							}	
						}
						$mids.= ")";
						$where['sid#'] = $mids;
					}else {
						$where['sid#'] = "(0)";
					}
				}
			}
		}
		$orders = Rush::getNumOrder("*",$where,'ID DESC',$pindex,$psize,1);		
		$pager = $orders[1];
		$orders = $orders[0];
		$status0 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'rush_order') . " WHERE uniacid={$_W['uniacid']} and orderno != 666666 and status in (1,2,3,5,6,7,9) and aid={$_W['aid']}");
		$status1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'rush_order') . " WHERE uniacid={$_W['uniacid']} and orderno != 666666 and status = 1 and aid={$_W['aid']}");
		$status2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'rush_order') . " WHERE uniacid={$_W['uniacid']} and orderno != 666666 and status = 2 and aid={$_W['aid']}");
		$status3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'rush_order') . " WHERE uniacid={$_W['uniacid']} and orderno != 666666 and status = 3 and aid={$_W['aid']}");
		$status5 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'rush_order') . " WHERE uniacid={$_W['uniacid']} and orderno != 666666 and status = 5 and aid={$_W['aid']}");
		$status6 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'rush_order') . " WHERE uniacid={$_W['uniacid']} and orderno != 666666 and status = 6 and aid={$_W['aid']}");
		$status7 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'rush_order') . " WHERE uniacid={$_W['uniacid']} and orderno != 666666 and status = 7 and aid={$_W['aid']}");
		$status9 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'rush_order') . " WHERE uniacid={$_W['uniacid']} and orderno != 666666 and status = 9 and aid={$_W['aid']}");
		$status10 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'rush_order') . " WHERE uniacid={$_W['uniacid']} and orderno != 666666 and applyrefund = 1 and aid={$_W['aid']}");
		
		if($_GPC['export'] != ''){
			$this->export($where);
		}
		
		include wl_template('order/order_list');
	}
	
	public function export($where){
		if(empty($where)) return FALSE;
		set_time_limit(0);
		$list = Rush::getNumOrder("*",$where,'ID DESC',0,0,0);
		$list = $list[0];
		/* 输出表头 */
		$filter = array(
			'orderno' => '订单号',
			'gname' => '抢购名称',
			'optionid' => '商品型号',
			'num' => '数量',
			'merchantName' => '所属商家',
			'nickname' => '买家昵称',
			'mobile' => '买家电话',
			'address'=> '买家地址',
			'status' => '订单状态',
			'paytype' => '支付方式',
			'createtime' => '下单时间',
			'paytime' => '支付时间',
			'actualprice' => '实付金额',
			'adminremark' => '备注',
			'hexiaotime'  => '核销时间',
			'vermember'  => '核销员'
		);
		
		$data = array();
		foreach ($list as $k => $v) {
			foreach ($filter as $key => $title) {
				if($key == 'status'){
					switch ($v[$key]) {
						case '1':
							$data[$k][$key] = '已支付';
							break;
						case '2':
							$data[$k][$key] = '已消费';
							break;
						case '3':
							$data[$k][$key] = '已完成';
							break;
						case '4':
							$data[$k][$key] = '待使用';
							break;	
						case '5':
							$data[$k][$key] = '已取消';
							break;
						case '6':
							$data[$k][$key] = '待退款';
							break;
						case '7':
							$data[$k][$key] = '已退款';
							break;
						case '9':
							$data[$k][$key] = '已过期';
							break;	
						default:
							$data[$k][$key] = '未支付';
							break;
					}
				}elseif($key == 'createtime'){
					$data[$k][$key] = date('Y-m-d H:i:s',$v[$key]);
				}elseif($key == 'paytime'){
					if(!empty($v['paytime'])){
						$data[$k][$key] = date('Y-m-d H:i:s',$v[$key]);
					}else{
						$data[$k][$key] = '未支付';
					}
				}elseif($key == 'paytype'){
					switch ($v[$key]) {
						case '1':
							$data[$k][$key] = '余额支付';
							break;
						case '2':
							$data[$k][$key] = '微信支付';
							break;
						case '3':
							$data[$k][$key] = '支付宝支付';
							break;
						case '4':
							$data[$k][$key] = '货到付款';
							break;
						default:
							$data[$k][$key] = '其他或未支付';
							break;
					}
				}else if($key == 'optionid'){
					$data[$k][$key] = pdo_getcolumn(PDO_NAME.'goods_option',array('id'=>$v[$key]),'title');
				}else if($key == 'hexiaotime'){
					$usedrecord = '';
					$usedtime = unserialize($v['usedtime']);
					if($usedtime){
						foreach ($usedtime as $kK => $used) {
							if($kK != 0){
								$usedrecord .= ' || '.date('Y-m-d H:i:s',$used['time']);
							}else {
								$usedrecord .= date('Y-m-d H:i:s',$used['time']);
							}
						}	
					}
					$data[$k][$key] = $usedrecord;
				}else if($key == 'vermember'){
					$vermembers = '';
					$usedtime = unserialize($v['usedtime']);
					if($usedtime){
						foreach ($usedtime as $kKs => $user2) {
							$user2['vername'] = pdo_getcolumn(PDO_NAME.'merchantuser',array('mid'=>$user2['ver']),'name');
							if($user2['type'] == 3){
								$user2['vername'] = '后台核销';
							}else if($user2['type'] == 4){
								$user2['vername'] = '密码核销';
							}
							if($kKs != 0){
								$vermembers .= ' || '.$user2['vername'];
							}else {
								$vermembers .= $user2['vername'];
							}
						}
					}
					$data[$k][$key] = $vermembers;
				}else {
					$data[$k][$key] = $v[$key];
				}
			}
		}
		/* 输出CSV文件 */
		util_csv::export_csv_2($data, $filter, '抢购订单.csv');
		exit();
	}
	
	function deleteOrder(){
		global $_W,$_GPC;	
		$id = $_GPC['id'];
		$ids = $_GPC['ids'];
		if($id){
			$res = Rush::deleteOrder(array('id' => $id));
			if($res){
				die(json_encode(array('errno'=>0,'message'=>$res,'id'=>$id)));
			}else {
				die(json_encode(array('errno'=>2,'message'=>$res,'id'=>$id)));
			}
		}
		if($ids){
			foreach ($ids as $key => $id) {
				Rush::deleteOrder(array('id' => $id));
			}
			die(json_encode(array('errno'=>0,'message'=>'','id'=>'')));
		}
	}
	
	function remark(){
		global $_W,$_GPC;	
		$id = $_GPC['id'];
		$remark = $_GPC['remark'];
		$res = Rush::updateOrder(array('adminremark' => $remark),array('id' => $id));
		if($res){
			die(json_encode(array('errno'=>0,'message'=>$res,'id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>$res,'id'=>$id)));
		}
	}
	
	function hexiaotime(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$coupon = pdo_get('wlmerchant_rush_order',array('id' => $id),array('usetimes','usedtime'));
		$coupon['usedtime'] = unserialize($coupon['usedtime']);
		foreach ($coupon['usedtime'] as $key => &$v) {
			$v['time'] = date('Y-m-d H:i:s',$v['time']);
			switch ($v['type']){
				case '1':
					$v['typename'] = '输码核销';
					break;
				case '2':
					$v['typename'] = '扫码核销';
					break;
				case '3':
					$v['typename'] = '后台核销';
					break;
				case '4':
					$v['typename'] = '密码核销';
					break;
				default:
					$v['typename'] = '未知方式';
					break;
			}
			if($v['type'] == 1 || $v['type'] == 2){
				$v['vername'] = pdo_getcolumn(PDO_NAME.'member',array('id'=>$v['ver']),'nickname');
			}else {
				$v['vername'] = '无';
			}
		}
		die(json_encode(array('errno'=>0,'times'=>$coupon['usetimes'],'data'=>$coupon['usedtime'])));
	}
	
	function confirmHexiao(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$item = Rush::getSingleOrder($id, '*');
		$res = Rush::hexiaoorder($id,-1,$item['usetimes'],3);
		$active = Rush::getSingleActive($item['activityid'],'name');
		if($res){
			pdo_insert(PDO_NAME.'merchant_money_record',array('plugin'=>'rush','sid'=>$item['sid'],'uniacid'=>$_W['uniacid'],'money'=>$item['price'],'orderid'=>$item['id'],'createtime'=>TIMESTAMP,'type'=>2,'detail'=>'核销成功：'.$item['orderno']));
			SingleMerchant::updateNoSettlementMoney($item['price'], $item['sid']);//更新可结算金额
			die(json_encode(array('errno'=>0,'message'=>'核销成功','id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>'error','id'=>$id)));
		}
	}
	function cancleHexiao(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$res = Rush::updateOrder(array('status' => 1,'usetimes'=>1),array('id' => $id));
		$item = Rush::getSingleOrder($id, '*');
		if($res){
//			pdo_delete('wlmerchant_verifrecord',array('orderid'=>$id));
			pdo_insert(PDO_NAME.'merchant_money_record',array('plugin'=>'rush','sid'=>$item['sid'],'uniacid'=>$_W['uniacid'],'money'=>0-$item['price'],'orderid'=>$item['id'],'createtime'=>TIMESTAMP,'type'=>3,'detail'=>'取消核销成功：'.$item['orderno']));
			SingleMerchant::updateNoSettlementMoney(0-$item['price'], $item['sid']);//更新可结算金额
			die(json_encode(array('errno'=>0,'message'=>'取消成功','id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>'error','id'=>$id)));
		}
	}
	function refundOrder(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$res = Rush::refund($id);
		if($res['status']){
			die(json_encode(array('errno'=>0,'message'=>$res['message'],'id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>$res['message'],'id'=>$id)));
		}
	}
	function delefalseorder(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$res = pdo_delete('wlmerchant_rush_order',array('id'=>$id));
		if($res){
			die(json_encode(array('errno'=>0,'message'=>'删除成功','id'=>$id)));
		}else {
			die(json_encode(array('errno'=>1,'message'=>'删除失败','id'=>$id)));
		}
	}
	
}