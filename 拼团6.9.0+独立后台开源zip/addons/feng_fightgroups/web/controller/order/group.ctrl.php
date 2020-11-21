<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('all','group_detail','autogroup','output');
$op = in_array($op, $ops) ? $op : 'all';
if (empty($starttime) || empty($endtime)) {//初始化时间
	$starttime = strtotime('-1 month');
	$endtime = time();
}
if ($op == 'all') {
	$will_die = $_GPC['will_die'];
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$where = array();
	$where['!=lacknum'] = 'neednum';
//	$timeSortEnd = $_GPC['timeSortEnd']?$_GPC['timeSortEnd']:'starttime desc';
//	$timeSortStart = $_GPC['timeSortStart']?$_GPC['timeSortStart']:'starttime desc';
	if(!empty($_GPC['groupstatus'])) $where['groupstatus'] = $_GPC['groupstatus'];
	if(TG_MERCHANTID)$where['merchantid'] = $_SESSION['role_id'];
	if (!empty($_GPC['time']) && !empty($_GPC['timetype'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		switch($_GPC['timetype']){
			case 1:$where['starttime>'] = $starttime;
				   $where['starttime<'] = $endtime;break;
			case 2:$where['endtime>'] = $starttime;
		           $where['endtime<'] = $endtime;break;
			default:break;
		}
	}
	if (!empty($_GPC['keyword'])) {
		if(!empty($_GPC['keywordtype'])){
			switch($_GPC['keywordtype']){
				case 1: $where['@groupnumber@'] = $_GPC['keyword'];break;
				case 2: $goods = model_goods::getNumGoods('id', array('@gname@'=>$_GPC['keyword']), 'id desc', 0, 0, 0);
						if($goods[0][0])$where['goodsid'] = $goods[0][0]['id'];break;
				case 3: $where['goodsid'] = $_GPC['keyword'];break;
				default:break;
			}
		}
	}
	if($_GPC['will_die']=='will_die'){ //查询离团结束的时间
		$lacknumber = $_GPC['lacknumber']?$_GPC['lacknumber']:'';
		if($lacknumber){
			$where['lacknum'] = $lacknumber;
			$endhour = $_GPC['endhour']? $_GPC['endhour']:''; 
		}else{
			$endhour = $_GPC['endhour']? $_GPC['endhour']:24; 
		}
		if($endhour){
			$where['endtime<'] = time()+$endhour*3600;
			$where['endtime>'] = time();
		}
	}
	$tuanData = model_group::getNumGroup('*', $where, 'starttime desc', $pindex, $psize, 1);
	$alltuan = !empty($tuanData[0])?$tuanData[0]:array();
	$pager = $tuanData[1];
	foreach ($alltuan as $key => $value) {
		$refund_orders = pdo_fetchcolumn("select COUNT(id) from" . tablename('tg_order') . "where tuan_id='{$value['groupnumber']}' and uniacid='{$_W['uniacid']}' and status=7");
		$send_orders = pdo_fetchcolumn("select COUNT(id) from" . tablename('tg_order') . "where tuan_id='{$value['groupnumber']}' and uniacid='{$_W['uniacid']}' and status in(3,4)");
		$alltuan[$key]['lasttime'] = $value['endtime'] - time();
		$alltuan[$key]['refundnum'] = $refund_orders;
		$alltuan[$key]['sendnum'] = $send_orders;
		$alltuan[$key]['goods'] = model_goods::getSingleGoods($value['goodsid'], '*');
	}
	$all = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_group') . " WHERE uniacid='{$_W['uniacid']}' AND lacknum <>neednum ".TG_MERCHANTID."");
	$status2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_group') . " WHERE uniacid='{$_W['uniacid']}' and groupstatus=2 AND lacknum <>neednum ".TG_MERCHANTID."");
	$status1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_group') . " WHERE uniacid='{$_W['uniacid']}' and groupstatus=1 AND lacknum <>neednum ".TG_MERCHANTID."");
	$status3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_group') . " WHERE uniacid='{$_W['uniacid']}' and groupstatus=3 AND lacknum <>neednum ".TG_MERCHANTID."");
	
} elseif ($op == 'group_detail') {
	$groupnumber = $_GPC['groupnumber'];
	$thistuan = model_group::getSingleGroup($groupnumber, "*");
	$orderData = model_order::getNumOrder("*", array('tuan_id'=>$groupnumber), 'createtime desc', 0, 0, 0);
	$orders = $orderData[0]; 
	$goods = model_goods::getSingleGoods($thistuan['goodsid'], "*");
	$all = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_group') . " WHERE uniacid='{$_W['uniacid']}' AND lacknum <>neednum ".TG_MERCHANTID."");
	$status2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_group') . " WHERE uniacid='{$_W['uniacid']}' and groupstatus=2 AND lacknum <>neednum ".TG_MERCHANTID."");
	$status1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_group') . " WHERE uniacid='{$_W['uniacid']}' and groupstatus=1 AND lacknum <>neednum ".TG_MERCHANTID."");
	$status3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_group') . " WHERE uniacid='{$_W['uniacid']}' and groupstatus=3 AND lacknum <>neednum ".TG_MERCHANTID."");
} elseif ($op == 'delete') {
	
} elseif ($op == 'autogroup') {
	$will_die = $_GPC['will_die'];
	$filename = TG_WEB."resource/nickname.text";
	$url=TG_WEB.'resource/images/head_imgs';
	$groupnumber = $_GPC['groupnumber'];
	//指定团的id
	$thistuan = model_group::getSingleGroup($groupnumber, "*");
	$orderData = model_order::getNumOrder("*", array('tuan_id'=>$groupnumber), 'createtime desc', 0, 0, 0);
	$orders2 = $orderData[0]; 
	$goods = pdo_fetch("select * from" . tablename('tg_goods') . "where id='{$thistuan['goodsid']}'");
	//虚拟订单
	$t = time();
	$init = $orders2[0]['createtime'];
	$num = array();
	$lacknum = $thistuan['lacknum'];
	
	$log = $_GPC['log'];
	$all = $_GPC['all'];
	$success = $_GPC['success'];
	$fail = $_GPC['fail'];
	
	if($log == '') {
		$all = $lacknum;
		message('正在准备创建'.$all.'个机器人订单，请不要关闭浏览器...', web_url('order/group/autogroup', array('log' => -1,'will_die'=>'will_die','all'=>$all,'groupnumber'=>$groupnumber,'success'=>0,'fail'=>0)), 'success');
	}else if($log == -1){
		$log = 0;
	}
	$create_num = $this_num = 100;
	$log += $create_num;
	
	if($log>=$all){
		$this_num = $all + $create_num - $log;
		$head_imgs_array = get_head_img($url, $this_num);
		$nickname_array = get_nickname($filename,$this_num);
		$time_array = get_randtime($init,$t,$this_num);
		for ($i = 0; $i < $this_num; $i++) {
			$data = array(
			 'ordertype'=>'3',
			 'uniacid' => $_W['uniacid'],
			 'gnum' => 1,
			 'openid' => $head_imgs_array[$i], 
			 'ptime' => TIMESTAMP,
			 'orderno' => date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99)),
			 'price' => 0,
			 'status' => 1,
			 'addressid' => 0, 
			 'addname' => $nickname_array[$i]['nickname'],
			 'mobile' => '虚拟', 
			 'address' => '虚拟', 
			 'g_id' => $thistuan['goodsid'], 
			 'tuan_id' => $thistuan['groupnumber'], 
			 'is_tuan' => 1, 
			 'tuan_first' => 0, 
			 'starttime' => TIMESTAMP, 
			 'createtime' => $time_array[$i]
			 
			 );
			if(pdo_insert('tg_order', $data)){
				$success += 1;
			}else{
				$fail += 1;
			}
			
		}
		pdo_update('tg_group', array('lacknum' => 0), array('groupnumber' => $thistuan['groupnumber']));
		Util::deleteCache('group', $thistuan['groupnumber']);
		$nowthistuan = pdo_fetch("select * from" . tablename('tg_group') . "where groupnumber = '{$groupnumber}' and uniacid='{$_W['uniacid']}'");
		if ($nowthistuan['lacknum'] == 0) {//组团成功
			$order_out['tuan_id'] = $groupnumber;
			$goodsInfo = model_goods::getSingleGoods($nowthistuan['goodsid'], "*");
			$merchant = model_merchant::getSingleMerchant($nowthistuan['merchantid'], '*');
			message::group_success($order_out['tuan_id'],app_url('order/group', array('tuan_id' => $order_out['tuan_id']))); //参团后组团成功消息
			pdo_update('tg_group',array('groupstatus' => 2,'successtime'=>TIMESTAMP), array('groupnumber' => $nowthistuan['groupnumber'])); //更新团状态
			
			$orders3 = pdo_fetchall("SELECT id FROM " . tablename('tg_order') . " WHERE tuan_id = '{$groupnumber}' and uniacid='{$_W['uniacid']}' and status=1 and mobile<>'虚拟' ");
			foreach ($orders3 as $key => $value) {
				if($nowthistuan['iflottery']==1) //抽奖订单
					pdo_update('tg_order',array('status' => 2,'successtime'=>TIMESTAMP,'lottery_status'=>1), array('id' => $value['id'])); // 更新订单状态
				else
					pdo_update('tg_order',array('status' => 2,'successtime'=>TIMESTAMP), array('id' => $value['id'])); // 更新订单状态
			}
			payResult::updateStockAndCreditAndMerchantAndCoupon($nowthistuan,$order_out,$goodsInfo,$merchant,0); // 参团后组团成功操作，更新库存，积分，商家进账,优惠券
		}
	}else{
		for ($i = 0; $i < $this_num; $i++) {
			$head_imgs_array = get_head_img($url, $this_num);
			$nickname_array = get_nickname($filename,$this_num);
			$time_array = get_randtime($init,$t,$this_num);
			$data = array(
			'ordertype'=>'3',
			 'uniacid' => $_W['uniacid'],
			 'gnum' => 1,
			 'openid' => $head_imgs_array[$i], 
			 'ptime' => '',
			 'orderno' => date('Ymd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99)),
			 'price' => 0,
			 'status' => 1,
			 'addressid' => 0, 
			 'addname' => $nickname_array[$i]['nickname'],
			 'mobile' => '虚拟', 
			 'address' => '虚拟', 
			 'g_id' => $thistuan['goodsid'], 
			 'tuan_id' => $thistuan['groupnumber'], 
			 'is_tuan' => 1, 
			 'tuan_first' => 0, 
			 'starttime' => TIMESTAMP, 
			 'createtime' => $time_array[$i]
			 );
			if(pdo_insert('tg_order', $data)){
				$success += 1;
			}else{
				$fail += 1;
			}
		}
	}
	$level_num = $all - $success - $fail;
	if($level_num==0) {
		message('自动组团成功，此次添加'.$all."个机器人订单，成功".$success."个,失败".$fail."个！！", web_url('order/group/group_detail',array('groupnumber'=>$groupnumber)), 'success');
	} else {
		message('正在创建机器人订单,请不要关闭浏览器,已创建 ' . $log . ' 个订单,成功'.$success.'个,失败'.$fail.'个,总共'.$all, web_url('order/group/autogroup', array('groupnumber'=>$groupnumber,'log' => $log,'all'=>$all,'will_die'=>'will_die','success'=>$success,'fail'=>$fail)));
	}
} elseif ($op == 'output') {
	$where = array();
	$where['!=lacknum'] = 'neednum';
	if(!empty($_GPC['groupstatus'])) $where['groupstatus'] = $_GPC['groupstatus'];
	if(TG_MERCHANTID)$where['merchantid'] = $_SESSION['role_id'];
		
	if (!empty($_GPC['times']) && !empty($_GPC['timetype'])) {
		$starttime = strtotime($_GPC['times']);
		$endtime = strtotime($_GPC['timee']);
		switch($_GPC['timetype']){
			case 1:$where['starttime>'] = $starttime;
				   $where['starttime<'] = $endtime;break;
			case 2:$where['endtime>'] = $starttime;
		           $where['endtime<'] = $endtime;break;
			default:break;
		}
	}
	if (!empty($_GPC['keyword'])) {
		if(!empty($_GPC['keywordtype'])){
			switch($_GPC['keywordtype']){
				case 1: $where['@groupnumber@'] = $_GPC['keyword'];break;
				case 2: $goods = model_goods::getNumGoods('id', array('@gname@'=>$_GPC['keyword']), 'id desc', 0, 0, 0);
						if($goods[0][0])$where['goodsid'] = $goods[0][0]['id'];break;
				case 3: $where['goodsid'] = $_GPC['keywordtype'];break;
				default:break;
			}
		}
	}
	$tuanData = model_group::getNumGroup('*', $where, 'starttime asc', $pindex, $psize, 1);
	$groups = $tuanData[0];
	if ($groupstatus == 1) $str = '团购失败订单_' . time();
	if ($groupstatus == 2) $str = '团购成功订单_' . time();
	if ($groupstatus == 3) $str = '组团中订单_' . time();
	if (empty($groupstatus)) $str = '所有团订单_' . time();
	$html = "\xEF\xBB\xBF";
	$filter = array('ll' => '团编号', 'mm' => '团状态', 'aa' => '订单编号', 'bb' => '姓名', 'cc' => '电话', 'dd' => '总价(元)', 'ee' => '状态', 'ff' => '下单时间', 'gg' => '商品名称', 'hh' => '收货地址', 'ii' => '微信订单号', 'jj' => '快递单号', 'kk' => '快递名称');
	foreach ($filter as $key => $title) {
		$html .= $title . "\t,";
	}
	//					$html .= "\n";
	foreach ($groups as $k => $v) {
		$html .= "\n";
		$orderData = model_order::getNumOrder("*", array('tuan_id'=>$v['groupnumber'],'mobile>'=>10000000000), 'createtime desc', 0, 0, 0); 
		$orders = $orderData[0];
		if ($v['groupstatus'] == 1) $tuanstatus = '团购失败';
		if ($v['groupstatus'] == 2) $tuanstatus = '团购成功';
		if ($v['groupstatus'] == 3) $tuanstatus = '组团中';
		foreach ($orders as $kk => $vv) {
			$goods = model_goods::getSingleGoods($vv['g_id'], "*");
			if ($vv['status'] == 0) $thistatus = '待付款';
			if ($vv['status'] == 1) $thistatus = '已支付';
			if ($vv['status'] == 2) $thistatus = !empty($goods['is_hexiao'])?'待消费':'待发货';
			if ($vv['status'] == 3) $thistatus = '已发货';
			if ($vv['status'] == 4) $thistatus = !empty($goods['is_hexiao'])?'已消费':'已签收';
			if ($vv['status'] == 5) $thistatus = '已取消';
			if ($vv['status'] == 6) $thistatus = '待退款';
			if ($vv['status'] == 7) $thistatus = '已退款';
			
			$time = date('Y-m-d H:i:s', $vv['createtime']);
			$orders[$kk]['ll'] = $v['groupnumber'];
			$orders[$kk]['mm'] = $tuanstatus;
			$orders[$kk]['aa'] = $vv['orderno'];
			$orders[$kk]['bb'] = $vv['addname'];
			$orders[$kk]['cc'] = $vv['mobile'];
			$orders[$kk]['dd'] = $vv['price'];
			$orders[$kk]['ee'] = $thistatus;
			$orders[$kk]['ff'] = $time;
			$orders[$kk]['gg'] = $goods['gname'];
			$orders[$kk]['hh'] = $vv['address'];
			$orders[$kk]['ii'] = $vv['transid'];
			$orders[$kk]['jj'] = $vv['expresssn'];
			$orders[$kk]['kk'] = $vv['express'];
			foreach ($filter as $key => $title) {
				$html .= $orders[$kk][$key] . "\t,";
			}
			$html .= "\n";
		}

	}
	/* 输出CSV文件 */
	header("Content-type:text/csv");
	header("Content-Disposition:attachment; filename={$str}.csv");
	echo $html;
	exit();
}
include wl_template('order/group');