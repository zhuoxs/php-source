<?php
defined('IN_IA') or exit('Access Denied');
//$redis = new Redis();
// $redis->connect('127.0.0.1', 6379);
// echo "Connection to server sucessfully";
//       //查看服务是否运行
// echo "Server is running: " . $redis->ping();exit;
//$s = cache_write('name','qidadadad');
//$ss=cache_read('name');
//wl_debug($ss);



$ops = array('sign','delete','summary','received','detail','output','remark','address','confrimpay','confirmsend','cancelsend','refund','confirmHexiao','cancelHexiao');
$op = in_array($op, $ops) ? $op : 'summary';
if($op == 'summary' ){
	if($_GPC['refresh']){
		if(TG_MERCHANTID)
			Util::deleteCache('order', 'orderData'.$_SESSION['role_id']);
		else
			Util::deleteCache('order', 'orderData');
		$orderWhere = array();
		if(TG_MERCHANTID)$orderWhere['merchantid'] = $_SESSION['role_id'];
		$data = model_order::getNumAndTimeOrder($orderWhere);
		die(json_encode($data));
	}
	if(TG_MERCHANTID)
		$data = Util::getCache('order', 'orderData'.$_SESSION['role_id']);
	else
		$data = Util::getCache('order', 'orderData');
	if($data){
		$seven_orders =  $data[0];
		$obligations =  $data[1];
		$undelivereds =  $data[2];
		$incomes =  $data[3];
		$wek_num = $data[4];/*折线图*/
		$wek_money = $data[5];
		$mon_num = $data[6];/*柱状图*/
		$mon_money = $data[7];
		$all1 = $data[8];/*饼状图*/
		$all2 = $data[9];
		$all3 = $data[10];
		$all4 = $data[11];
		$all5 = $data[12];
		$pv1 = $data[13];/*浏览量*/
		$pv2 = $data[14];
		$pv3 = $data[15];
		$pv4 = $data[16];
		$pu1 = $data[17];
		$pu2 = $data[18];
		$pu3 = $data[19];
		$pu4 = $data[20];
		$address_arr=$data[21];/*地图*/
		$time = $data[22];
	}
	include wl_template('order/summary');
	exit;
}

if ($op == 'received') {if (empty($starttime) || empty($endtime)) {//初始化时间
		$starttime = strtotime('-1 month');
		$endtime = time();
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$where = array();
	$where['!=mobile'] = "'虚拟'";//排除虚拟订单
	if($_GPC['orderType']=='fetch')
		$where['#is_hexiao#'] = '(1,2)';
	else
		$where['is_hexiao'] = 0;
	if(TG_MERCHANTID)$where['merchantid'] = $_SESSION['role_id'];
	if($_GPC['status']!='') $where['status'] = $_GPC['status'];
//	$where['#lottery_status#'] = '(0,2)';
	if(!empty($_GPC['pay_type'])) $where['pay_type'] = $_GPC['pay_type'];
	
	if (!empty($_GPC['time']) && !empty($_GPC['timetype'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		switch($_GPC['timetype']){
			case 1:$where['createtime>'] = $starttime;
				   $where['createtime<'] = $endtime;break;
			case 2:$where['ptime>'] = $starttime;
		           $where['ptime<'] = $endtime;break;
			case 3:$where['sendtime>'] = $starttime;
		           $where['sendtime<'] = $endtime;break;
			default:break;
		}
	}
	if (!empty($_GPC['keyword'])) {
		if(!empty($_GPC['keywordtype'])){
			switch($_GPC['keywordtype']){
				case 1: $where['@orderno@'] = $_GPC['keyword'];break;
				case 2: $where['@transid@'] = $_GPC['keyword'];break;
				case 3: $where['@addname@'] = $_GPC['keyword'];break;
				case 4: $where['@mobile@'] = $_GPC['keyword'];break;
				case 5: if(TG_MERCHANTID)$where2['merchantid'] = $_SESSION['role_id'];
						$where2['@gname@'] = $_GPC['keyword'];
						$goods = model_goods::getNumGoods('id', $where2, 'id desc', 0, 0, 0);
						if($goods[0][0])$where['g_id'] = $goods[0][0]['id'];
						break;
				case 6: $merchant =pdo_fetch("select id from".tablename('tg_merchant')."where name like '%{$_GPC['keyword']}%' and uniacid={$_W['uniacid']}");
						if($merchant['id'])$where['merchantid'] = $merchant['id'];
						break;
				case 7: $where['@hexiaoma@'] = $_GPC['keyword'];$where['#status#'] = '(2,4,6,7)';break;
				case 8: $asd = pdo_fetch("SELECT id FROM ".tablename('tg_store')."WHERE uniacid = {$_W['uniacid']} and storename like '%{$_GPC['keyword']}%'");
						$where['storeid'] = $asd['id'];break;
				case 9: if($_GPC['keyword'] == '后台核销'){
							$where['veropenid'] = 'houtai';
						}else {
							$asd = pdo_fetch("SELECT openid FROM ".tablename('tg_saler')."WHERE uniacid = {$_W['uniacid']} and nickname like '%{$_GPC['keyword']}%'");
							$where['veropenid'] = $asd['openid'];
						}break;
				case 10: $where['g_id'] = $_GPC['keyword'];break;
						
				default:break;
			}
		}
	}
	//wl_debug($where);
	
	
	$orderData = model_order::getNumOrder('*', $where, 'createtime desc', $pindex, $psize, 1);
	$list = $orderData[0];
	load()->model('mc');
	if($list){
			foreach($list as $k=>&$v){
			$v['member'] = mc_fansinfo($v['openid']);
			if($v['storeid']){
				$asd = pdo_get('tg_store',array('id' => $v['storeid']),array('storename'));
				$v['hexiaostore'] = $asd['storename'];
			}
			if($v['veropenid']){
				if( $v['veropenid'] == 'houtai'){
					$v['salername'] = '后台核销';
				}else {
					$asd = pdo_get('tg_saler',array('openid' => $v['veropenid']),array('nickname'));
					$v['salername'] = $asd['nickname']; 
				}	
			}
		}
	}
	
	$pager = $orderData[1];
	$isHexiaoStr = $_GPC['orderType']!='fetch' ?" and uniacid='{$_W['uniacid']}' and mobile<>'虚拟' and is_hexiao=0  ".TG_MERCHANTID : " and uniacid='{$_W['uniacid']}' and mobile<>'虚拟' and is_hexiao in(1,2)  and mobile<>'虚拟' ".TG_MERCHANTID;
	$all = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE 1 $isHexiaoStr");
	$status0 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE status=0 $isHexiaoStr");
	$status1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE status=1 $isHexiaoStr");
	$status2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE status=2 $isHexiaoStr");
	$status3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE status=3 $isHexiaoStr");
	$status4 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE status=4 $isHexiaoStr");
	$status5 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE status=5 $isHexiaoStr");
	$status9 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE status=9 $isHexiaoStr");
	$status6 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE status=6 $isHexiaoStr");
	$status7 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE status=7 $isHexiaoStr");
} 

if ($op == 'detail') {
	$id = intval($_GPC['id']);
	$item = model_order::getSingleOrder($id, '*');
	$orderMarket = unserialize($item['marketing']);//营销优惠
	$enough_give = unserialize($orderMarket['enough_give']);
	$edmoney = $orderMarket['edmoney'];
	$ednum =  $orderMarket['ednum'];
	$deduct = unserialize($orderMarket['deduct']);
	if (empty($item)) message("抱歉，订单不存在!", referer(), "error");
	if (!empty($item['couponid']))$coupon_template = model_coupon::coupon_template($item['couponid']);
	if (!empty($item['getcouponid']))$getcoupon = model_coupon::coupon_template($item['getcouponid']);
	if (!empty($item['giftid']))$gift = pdo_fetch("SELECT goodsid,name FROM " . tablename('tg_gift') . " WHERE id = :id", array(':id' => $item['giftid']));
	if($item['status']==7) $item['refund'] = pdo_fetch("select createtime from".tablename('tg_refund_record')."where orderid={$item['id']}");
	$item['goods'] = model_goods::getSingleGoods($item['g_id'],'*');
	if(!empty($item['is_hexiao']) && !empty($item['storeid']))  $orderStore = pdo_fetch("select storename from" . tablename('tg_store') . "where id={$item['storeid']} ");
	if ($item['veropenid']){
		if($item['veropenid'] == 'houtai'){
			$item['verstore'] = '后台核销';
			$item['vername'] = '后台核销';
		}else{
			$list = pdo_fetch("select nickname,storeid from" . tablename('tg_saler') . "where uniacid='{$_W['uniacid']}' and openid = '{$item['veropenid']}'");
			if($list['storeid']){
				$storeid_arr = explode(',', $list['storeid']);
				$storename   = '';
				foreach ($storeid_arr as $k => $v) {
					if ($v) {
						$store = pdo_fetch("select storename from" . tablename('tg_store') . "where id='{$v}'");
						$storename .= $store['storename'] . "/";
					}
				}
				$storename = substr($storename, 0, strlen($storename) - 1);
			}else{
				$storename = '全局核销员';
			}
			$item['verstore'] = $storename;
			$item['vername'] = $list['nickname'];
		}
	}
	include wl_template('order/order_detail');
	exit;
} 
if($op=='confrimpay'){
	$id = $_GPC['id'];
	$item = model_order::getSingleOrder($id, '*');
	pdo_update('tg_order', array('status' => 1, 'pay_type' => 2,'ptime'=>TIMESTAMP), array('id' => $id));
	$nowthistuan = pdo_fetch("select * from" . tablename('tg_group') . "where groupnumber = '{$item['tuan_id']}' and uniacid='{$_W['uniacid']}'");
	if ($nowthistuan['lacknum'] == 1) {//组团成功
		pdo_update('tg_group', array('lacknum' => 0), array('groupnumber' => $item['tuan_id']));
		$groupnumber = $item['tuan_id'];
		$goodsInfo = model_goods::getSingleGoods($nowthistuan['goodsid'], "*");
		$merchant = model_merchant::getSingleMerchant($nowthistuan['merchantid'], '*');
		message::group_success($item['tuan_id'],app_url('order/group', array('tuan_id' => $item['tuan_id']))); //参团后组团成功消息
		pdo_update('tg_group',array('groupstatus' => 2,'successtime'=>TIMESTAMP), array('groupnumber' => $nowthistuan['groupnumber'])); //更新团状态
		
		$orders3 = pdo_fetchall("SELECT id FROM " . tablename('tg_order') . " WHERE tuan_id = '{$groupnumber}' and uniacid='{$_W['uniacid']}' and status=1 and mobile<>'虚拟' ");
		foreach ($orders3 as $key => $value) {
			if($nowthistuan['iflottery']==1) //抽奖订单
				pdo_update('tg_order',array('status' => 2,'successtime'=>TIMESTAMP,'lottery_status'=>1), array('id' => $value['id'])); // 更新订单状态
			else
				pdo_update('tg_order',array('status' => 2,'successtime'=>TIMESTAMP), array('id' => $value['id'])); // 更新订单状态
		}
		payResult::updateStockAndCreditAndMerchantAndCoupon($nowthistuan,$item,$goodsInfo,$merchant,0); // 参团后组团成功操作，更新库存，积分，商家进账,优惠券
	}else{
		pdo_update('tg_group', array('lacknum' => $nowthistuan['lacknum']-1), array('groupnumber' => $item['tuan_id']));
	}
	$oplogdata = serialize($item);
	oplog('admin', "后台确认付款", web_url('order/order/confrimpay'), $oplogdata);
	message('确认订单付款操作成功！', referer(), 'success');
}
if($op=='confirmsend'){
	$id = $_GPC['id'];
	$item = model_order::getSingleOrder($id, '*');
	$r=pdo_update('tg_order', array('status' => 3, 'express' => $_GPC['express'], 'expresssn' => $_GPC['expresssn'], 'sendtime' => TIMESTAMP), array('id' => $id));
	Util::deleteCache('order', $id);
	if($r){
		if(!empty($item['merchantid'])){
			pdo_insert("tg_merchant_money_record",array('merchantid'=>$item['merchantid'],'uniacid'=>$_W['uniacid'],'money'=>$item['price'],'orderid'=>$item['id'],'createtime'=>TIMESTAMP,'type'=>2,'detail'=>'发货成功：运单号'.$_GPC['expresssn']));
			if($item['pay_type']!=4)model_merchant::updateNoSettlementMoney($item['price'], $item['merchantid']);//更新可结算金额
		}
		$oplogdata = serialize($item);
		oplog('admin', "后台确认发货", web_url('order/order/confirmsend'), $oplogdata);
		
		$url = app_url('order/order/detail', array('id' => $item['id']));
		message::send_success($item['orderno'], $item['openid'], $_GPC['express'], $_GPC['expresssn'], $url);
		header("Location: ".web_url('order/order/detail',array('id'=>$id)));
	}else{
		message('发货操作失败！', referer(), 'error');
	}
	
}
if($op=='cancelsend'){
	$id = $_GPC['id'];
	$item = model_order::getSingleOrder($id, '*');
//	if($item['issettlement']==1){
//		message('取消发货操作失败，该订单金额已结算到指定商家。', referer(), 'error');
//	}
	$r=pdo_update('tg_order', array('status' => 2, 'express' => '', 'expresssn' => '', 'sendtime' => ''), array('id' => $id));
	Util::deleteCache('order', $id);
	if($r){
		if(!empty($item['merchantid'])){
			pdo_insert("tg_merchant_money_record",array('merchantid'=>$item['merchantid'],'uniacid'=>$_W['uniacid'],'money'=>0-$item['price'],'orderid'=>$item['id'],'createtime'=>TIMESTAMP,'type'=>3,'detail'=>'取消发货：订单号'.$item['orderno']));
			model_merchant::updateNoSettlementMoney(0-$item['price'], $item['merchantid']);//更新可结算金额
		}
		$oplogdata = serialize($item);
		oplog('admin', "后台取消发货", web_url('order/order/cancelsend'), $oplogdata);
		header("Location: ".web_url('order/order/detail',array('id'=>$id)));
	}else{
		message('取消发货操作失败！', referer(), 'error');
	}
	
}
if($op=='refund'){
	$id = $_GPC['id'];
	$item = model_order::getSingleOrder($id, '*');
	$res = model_order::refundMoney($id,$item['price'],'',2);
	if($res['status']){
		Util::deleteCache('order', $id);
		message($res['message'], referer(), 'success');
	} else {
		message($res['message'], referer(), 'fail');
	}
}
if ($op == 'remark') {
	$orderid = intval($_GPC['id']);
	$remark = $_GPC['remark'];
	if (pdo_update('tg_order', array('adminremark' => $remark),array('id'=>$orderid))) {
		die(json_encode(array('errno'=>0)));
	} else {
		die(json_encode(array('errno'=>1)));
	}
}
if ($op == 'address') {
	$orderid = intval($_GPC['id']);
	$address = $_GPC['address'];
	$realname = $_GPC['realname'];
	$mobile = $_GPC['mobile'];
	$item = model_order::getSingleOrder($orderid, '*');
	if (pdo_update('tg_order', array('address' => $address,'addname'=>$realname,'mobile'=>$mobile),array('id'=>$orderid))) {
		Util::deleteCache('order', $orderid);
		$oplogdata = serialize($item);
		oplog('admin', "后台修改地址", web_url('order/order/confrimpay'), $oplogdata);
		die(json_encode(array('errno'=>0)));
	} else {
		die(json_encode(array('errno'=>1)));
	}
}
if($op == 'delete'){
	if(!empty($_GPC['id'])){
		$id = $_GPC['id'];
		$data = model_order::getSingleOrder($id, '*');
		$data = serialize($data);
		if(pdo_delete('tg_order', array('id' => $id))){
			Util::deleteCache('order', $id);
			oplog('admin',"删除订单",web_url('order/order/delete'), $data);
			die(json_encode(array('errno'=>0)));
		} else {
			die(json_encode(array('errno'=>1)));
		}	
	}else {
		$ids = $_GPC['ids'];
		foreach($ids as $key=>$value){
			$data = pdo_fetch("SELECT * FROM " . tablename('tg_order') . " WHERE id = :id", array(':id' => $value));
			$data = serialize($data);
			if(pdo_delete('tg_order', array('id' => $value))){
				Util::deleteCache('order', $id);
				oplog('admin',"删除订单",web_url('order/order/delete'), $data);
			}
		} 
		die(json_encode(array('errno'=>0)));
	}
}	
if($op=='confirmHexiao'){ //确认核销
	$id = $_GPC['id'];
	$item = model_order::getSingleOrder($id, "*");
	if (pdo_update('tg_order', array('status' => 4,'veropenid'=>'houtai'),array('id'=>$id))) {
		Util::deleteCache('order', $id);
		if(!empty($item['merchantid'])){
			pdo_insert("tg_merchant_money_record",array('merchantid'=>$item['merchantid'],'uniacid'=>$_W['uniacid'],'money'=>$item['price'],'orderid'=>$item['id'],'createtime'=>TIMESTAMP,'type'=>2,'detail'=>'核销成功：'.$item['orderno']));
			if($item['pay_type']!=4)model_merchant::updateNoSettlementMoney($item['price'], $item['merchantid']);//更新可结算金额
		}
		$oplogdata = serialize($item);
		oplog('admin', "后台列表核销", web_url('order/fetch/confirm'), $oplogdata);
		message::comment_notice($id);
		die(json_encode(array('errno'=>0,'message'=>'核销成功！')));
	} else {
		die(json_encode(array('errno'=>1,'message'=>'核销失败！')));
	}
}
if($op=='cancelHexiao'){ //取消核销
	$id = $_GPC['id'];
	$item = model_order::getSingleOrder($id, "*");
	if(pdo_update('tg_order', array('status' => 2,'sendtime'=>'','express' => '', 'expresssn' => ''), array('id' => $id))){
		Util::deleteCache('order', $id);
		if(!empty($item['merchantid'])){
			pdo_insert("tg_merchant_money_record",array('merchantid'=>$item['merchantid'],'uniacid'=>$_W['uniacid'],'money'=>0-$item['price'],'orderid'=>$item['id'],'createtime'=>TIMESTAMP,'type'=>3,'detail'=>'取消核销成功：'.$item['orderno']));
			model_merchant::updateNoSettlementMoney(0-$item['price'], $item['merchantid']);//更新可结算金额
		}
		$oplogdata = serialize($item);
		oplog('admin', "后台取消核销", web_url('order/fetch/confirmsend'), $oplogdata);
	}
	message('操作成功！', referer(), 'success');
}
if($op == 'output'){
	$where = array();
	$where['!=mobile'] = "'虚拟'";//排除虚拟订单
//	$where['#lottery_status#'] = '(0,2)';
	if($_GPC['orderType']=='fetch')
		$where['#is_hexiao#'] = '(1,2)';
	else
		$where['is_hexiao'] = 0;
	if(TG_MERCHANTID)$where['merchantid'] = $_SESSION['role_id'];
	if(!empty($_GPC['status'])) $where['status'] = $_GPC['status'];
	if(!empty($_GPC['pay_type'])) $where['pay_type'] = $_GPC['pay_type'];
	
	if (!empty($_GPC['times']) && !empty($_GPC['timetype'])) {
		$starttime = strtotime($_GPC['times']);
		$endtime = strtotime($_GPC['timee']);
		switch($_GPC['timetype']){
			case 1:$where['createtime>'] = $starttime;
				   $where['createtime<'] = $endtime;break;
			case 2:$where['ptime>'] = $starttime;
		           $where['ptime<'] = $endtime;break;
			case 3:$where['sendtime>'] = $starttime;
		           $where['sendtime<'] = $endtime;break;
			default:break;
		}
	}
	if (!empty($_GPC['keyword'])) {
		if(!empty($_GPC['keywordtype'])){
			switch($_GPC['keywordtype']){
				case 1: $where['@orderno@'] = $_GPC['keyword'];break;
				case 2: $where['@transid@'] = $_GPC['keyword'];break;
				case 3: $where['@addname@'] = $_GPC['keyword'];break;
				case 4: $where['@mobile@'] = $_GPC['keyword'];break;
				case 5: $goods = model_goods::getNumGoods('id', array('@gname@'=>$_GPC['keyword']), 'id desc', 0, 0, 0);
						if($goods[0][0])$where['g_id'] = $goods[0][0]['id'];
						break;
				case 6: $merchant =pdo_fetch("select id from".tablename('tg_merchant')."where name like '%{$_GPC['keyword']}%' and uniacid={$_W['uniacid']}");
						if($merchant['id'])$where['merchantid'] = $merchant['id'];
						break;
				case 7: $where['@hexiaoma@'] = $_GPC['keyword'];$where['#status#'] = '(2,4,6,7)';break;
				case 8: $asd = pdo_fetch("SELECT id FROM ".tablename('tg_store')."WHERE uniacid = {$_W['uniacid']} and storename like '%{$_GPC['keyword']}%'");
						$where['storeid'] = $asd['id'];break;
				case 9: if($_GPC['keyword'] == '后台核销'){
							$where['veropenid'] = 'houtai';
						}else {
							$asd = pdo_fetch("SELECT openid FROM ".tablename('tg_saler')."WHERE uniacid = {$_W['uniacid']} and nickname like '%{$_GPC['keyword']}%'");
							$where['veropenid'] = $asd['openid'];
						}break;		
				case 10: $where['g_id'] = $_GPC['keyword'];break;
				default:break;
			}
		}else{
			$condition .=" AND orderno = '无查询结果' ";
		}
	}
	$orderData = model_order::getNumOrder('*', $where, 'pay_type desc', 0, 0, 0);
	$orders = $orderData[0];
	switch($_GPC['status']){
		case NULL: $str=$_GPC['orderType']=='fetch'?'自提-全部订单'. time():'快递-全部订单' . time();break;
		case 1: $str = '已支付订单_' . time();break;
		case 2: $str = $_GPC['orderType']=='fetch'?'待消费订单'. time():'待发货订单' . time();break;
		case 3: $str = '已发货订单' . time();break;
		case 4: $str = $_GPC['orderType']=='fetch'?'已消费订单'. time():'已签收订单' . time();break;
		case 5: $str = '已取消订单' . time();break;
		case 6: $str = '待退款订单' . time();break;
		case 7: $str = '已退款订单' . time();break;
		default:$str = '待支付订单' . time();break;
	}
	$html = "\xEF\xBB\xBF";
	$filter = array('aa' => '订单编号', 'bb' => '姓名', 'cc' => '电话', 'dd' => '总价(元)', 'ee' => '状态', 'ff' => '下单时间', 'gg' => '商品名称', 'hh' => '收货地址', 'ii' => '微信订单号', 'jj' => '快递单号', 'kk' => '快递名称','ll'=>'地址类型','mm'=>'商品规格','nn'=>'购买数量','oo'=>'客户留言','pp'=>'我的备注','qq'=>'订单类型','rr'=>'核销门店','ss'=>'核销店员','tt'=>'支付方式','uu'=>'核销码','vv'=>'商品编码');
	foreach ($filter as $key => $title) {
		$html .= $title . "\t,";
	}
	$html .= "\n";
	foreach ($orders as $k => $v) {
		if ($v['status'] == '0') $thisstatus = '未支付';
		if ($v['status'] == '1') $thisstatus = '已支付';
		if ($v['status'] == '2') $thisstatus = $_GPC['orderType']=='fetch'?'待消费':'待发货';
		if ($v['status'] == '3') $thisstatus = '已发货';
		if ($v['status'] == '4') $thisstatus = $_GPC['orderType']=='fetch'? '已消费':'已签收';
		if ($v['status'] == '5') $thisstatus = '已取消';
		if ($v['status'] == '6') $thisstatus = '待退款';
		if ($v['status'] == '7') $thisstatus = '已退款';
		if ($v['status'] == '')  $thisstatus = '全部订单';
		$goods = model_goods::getSingleGoods($v['g_id'], 'gname,goodscode');
		$time = date('Y-m-d H:i:s', $v['createtime']);
		if($v['addresstype']==1)
			$addresstype='公司';
		else
			$addresstype='家庭';
		if(empty($v['optionname']))$v['optionname'] = '不限';
		$orders[$k]['aa'] = $v['orderno'];
		$orders[$k]['bb'] = $v['addname'];
		$orders[$k]['cc'] = $v['mobile'];
		$orders[$k]['dd'] = $v['price'];
		$orders[$k]['ee'] = $thisstatus;
		$orders[$k]['ff'] = $time;
		$orders[$k]['gg'] = $goods['gname'];
		$orders[$k]['hh'] = $v['address'];
		$orders[$k]['ii'] = $v['transid'];
		$orders[$k]['jj'] = $v['expresssn'];
		$orders[$k]['kk'] = $v['express'];
		$orders[$k]['ll'] = $addresstype;
		$orders[$k]['mm'] = $v['optionname'];
		$orders[$k]['nn'] = $v['gnum'];
		$orders[$k]['oo'] = $v['remark'];
		$orders[$k]['pp'] = $v['adminremark'];
		$orders[$k]['qq'] = $_GPC['orderType']=='fetch'?'自提订单':'快递订单';
		$orders[$k]['tt'] = $v['pay_typeName'];
		$orders[$k]['uu'] = $v['hexiaoma'];
		$orders[$k]['vv'] = $goods['goodscode'];
		$asd = pdo_fetch("SELECT storename FROM ".tablename('tg_store')."WHERE id = '{$v['storeid']}' ");
		$orders[$k]['rr'] = $asd['storename'];
		if($v['veropenid'] == 'houtai'){
			$orders[$k]['ss'] = '后台核销';
		}else {
			$asd = pdo_fetch("SELECT nickname FROM ".tablename('tg_saler')."WHERE openid = '{$v['veropenid']}'");
			$orders[$k]['ss'] = $asd['nickname'];
		}
		
		
		foreach ($filter as $key => $title) {
			$html .= $orders[$k][$key] . "\t,";
		}
		$html .= "\n";
	}
	header("Content-type:text/csv");
	header("Content-Disposition:attachment; filename={$str}.csv");
	echo $html;
	exit();
}

include wl_template('order/order');
