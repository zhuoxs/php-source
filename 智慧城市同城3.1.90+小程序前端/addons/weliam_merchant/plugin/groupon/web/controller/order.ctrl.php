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
		if($_GPC['activeid']) $where['fkid'] = $_GPC['activeid'];
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
			$where['#status'] = '(1,2,3,6,7,9)';
		}
		if (!empty($_GPC['keyword'])) {
			if(!empty($_GPC['keywordtype'])){
				switch($_GPC['keywordtype']){
					case 1: $where['@id@'] = $_GPC['keyword'];break;
					case 2: $where['@orderno@'] = $_GPC['keyword'];break;
					case 3: $where['@fkid@'] = $_GPC['keyword'];break;
					case 4: $where['@sid@'] = $_GPC['keyword'];break;
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
				if($_GPC['keywordtype'] == 6){
					$keyword = $_GPC['keyword'];
					$params[':name'] = "%{$keyword}%";
					$members = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_member')."WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND mobile LIKE :name",$params);
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
				if($_GPC['keywordtype'] == 7){
					$keyword = $_GPC['keyword'];
					$params[':qrcode'] = "%{$keyword}%";
					$members = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_groupon_userecord')."WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND qrcode LIKE :qrcode",$params);
					if($members){
						$mids = "(";
						foreach ($members as $key => $v) {
							if($key == 0){
								$mids.= $v['orderid'];
							}else{
								$mids.= ",".$v['orderid'];
							}	
						}
						$mids.= ")";
						$where['id#'] = $mids;
					}else {
						$where['id#'] = "(0)";
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
		$orders = Groupon::getNumOrder("*",$where,'ID DESC',$pindex,$psize,1);		
		$pager = $orders[1];
		$orders = $orders[0];
		$status0 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'order') . " WHERE uniacid={$_W['uniacid']} and plugin = 'groupon' and status in (1,2,3,5,6,7,9) and aid={$_W['aid']}");
		$status1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'order') . " WHERE uniacid={$_W['uniacid']} and plugin = 'groupon' and status = 1 and aid={$_W['aid']}");
		$status2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'order') . " WHERE uniacid={$_W['uniacid']} and plugin = 'groupon' and status = 2 and aid={$_W['aid']}");
		$status3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'order') . " WHERE uniacid={$_W['uniacid']} and plugin = 'groupon' and status = 3 and aid={$_W['aid']}");
		$status5 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'order') . " WHERE uniacid={$_W['uniacid']} and plugin = 'groupon' and status = 5 and aid={$_W['aid']}");
		$status6 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'order') . " WHERE uniacid={$_W['uniacid']} and plugin = 'groupon' and status = 6 and aid={$_W['aid']}");
		$status7 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'order') . " WHERE uniacid={$_W['uniacid']} and plugin = 'groupon' and status = 7 and aid={$_W['aid']}");
		$status9 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME.'order') . " WHERE uniacid={$_W['uniacid']} and plugin = 'groupon' and status = 9 and aid={$_W['aid']}");
		
		if($_GPC['export'] != ''){
			$this->export($where);
		}
		
		include wl_template('grouponorder/order_list');
	}
	
	public function export($where){
		if(empty($where)) return FALSE;
		set_time_limit(0);
		$list = Groupon::getNumOrder("*",$where,'ID DESC',0,0,0);
		$list = $list[0];
		/* 输出表头 */
		$filter = array(
			'orderno' => '订单号',
			'gname' => '团购名称',
			'num' => '数量',
			'merchantName' => '所属商家',
			'nickname' => '买家昵称',
			'mobile' => '买家电话',
			'status' => '订单状态',
			'paytype' => '支付方式',
			'createtime' => '下单时间',
			'paytime' => '支付时间',
			'price' => '实付金额',
			'remark' => '备注'
		);
		$data = array();
		for ($i=0; $i < count($list) ; $i++) {
			foreach ($filter as $key => $title) {
				if ($key == 'createtime' || $key == 'paytime') {
					$data[$i][$key] = date('Y-m-d H:i:s', $list[$i][$key]);
				}else if($key == 'status') {
					switch ($list[$i][$key]) {
						case '1':
							$data[$i][$key] = '已支付';
							break;
						case '2':
							$data[$i][$key] = '已消费';
							break;
						case '3':
							$data[$i][$key]  = '已完成';
							break;
						case '4':
							$data[$i][$key]  = '待使用';
							break;	
						case '5':
							$data[$i][$key]  = '已取消';
							break;
						case '6':
							$data[$i][$key]  = '待退款';
							break;
						case '7':
							$data[$i][$key]  = '已退款';
							break;
						case '9':
							$data[$i][$key]  = '已过期';
							break;	
						default:
							$data[$i][$key]  = '未支付';
							break;
					}
				}else if($key == 'paytype'){
					switch ($list[$i][$key]) {
						case '1':
							$data[$i][$key] = '余额支付';
							break;
						case '2':
							$data[$i][$key] = '微信支付';
							break;
						case '3':
							$data[$i][$key] = '支付宝支付';
							break;
						case '4':
							$data[$i][$key] = '货到付款';
							break;	
						default:
							$data[$i][$key]  = '其他或未支付';
							break;			
					}
				}else {
					$data[$i][$key] = $list[$i][$key];
				}
			}
		}
		util_csv::export_csv_2($data, $filter, '团购订单表.csv');
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
		$res = Groupon::updateOrder(array('remark' => $remark),array('id' => $id));
		if($res){
			die(json_encode(array('errno'=>0,'message'=>$res,'id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>$res,'id'=>$id)));
		}
	}
	
	function hexiaotime(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$record = pdo_get('wlmerchant_groupon_userecord',array('orderid' => $id),array('usetimes','usedtime'));
		$record['usedtime'] = unserialize($record['usedtime']);
		foreach ($record['usedtime'] as $key => &$v) {
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
		die(json_encode(array('errno'=>0,'times'=>$record['usetimes'],'data'=>$record['usedtime'])));
	}
	
	function confirmHexiao(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$usetimes = pdo_getcolumn(PDO_NAME.'groupon_userecord',array('orderid'=>$id),'usetimes'); 
		$res = Groupon::hexiaoorder($id,-1,$usetimes,3);
		if($res){
			die(json_encode(array('errno'=>0,'message'=>'核销成功','id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>'error','id'=>$id)));
		}
	}
	function cancleHexiao(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$res = pdo_update('wlmerchant_groupon_userecord',array('usetimes' => 1),array('orderid' => $id));
		$res = pdo_update('wlmerchant_order',array('status' => 1),array('id' => $id));
		if($res){
			die(json_encode(array('errno'=>0,'message'=>'取消成功','id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>'error','id'=>$id)));
		}
	}
	
	function refundOrder(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$res = Groupon::refund($id);
		if($res['status']){
			die(json_encode(array('errno'=>0,'message'=>$res['message'],'id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>$res['message'],'id'=>$id)));
		}
	}
	
	function delefalseorder(){
		global $_W,$_GPC;
		$id = $_GPC['id'];
		$res = pdo_delete('wlmerchant_order',array('id'=>$id));
		if($res){
			die(json_encode(array('errno'=>0,'message'=>'删除成功','id'=>$id)));
		}else {
			die(json_encode(array('errno'=>1,'message'=>'删除失败','id'=>$id)));
		}
	}
	
}