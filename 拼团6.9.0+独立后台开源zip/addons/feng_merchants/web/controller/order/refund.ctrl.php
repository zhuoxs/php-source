<?php

	$ops = array('display','initsync');
	$op_names = array('订单列表','订单详情','后台核销','导出');
	foreach($ops as$key=>$value){
		permissions('do', 'ac', 'op', 'order', 'refund', $ops[$key], '订单', '批量退款', $op_names[$key]);
	}
	$op = in_array($op, $ops) ? $op : 'display';
	
	wl_load()->model('goods');
	$merchants = pdo_fetchall("SELECT * FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}'  and id=".MERCHANTID);
	$allgoods = pdo_fetchall("select gname,id from".tablename('tg_goods')."where uniacid=:uniacid and isshow=:isshow and merchantid=:merchantid",array(':uniacid'=>$_W['uniacid'],':isshow'=>1,':merchantid'=>MERCHANTID));
	if($op=='display'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$condition = "  uniacid = :uniacid and merchantid=".MERCHANTID;
	$paras = array(':uniacid' => $_W['uniacid']);

	$status = $_GPC['status'];
	$transid = $_GPC['transid'];
	$pay_type = $_GPC['pay_type'];
	$keyword = $_GPC['keyword'];
	$member = $_GPC['member'];
	$time = $_GPC['time'];

	if (empty($starttime) || empty($endtime)) {
		$starttime = strtotime('-1 month');
		$endtime = time();
	}
	if (!empty($_GPC['time'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']) ;
		$condition .= " AND  createtime >= :starttime AND  createtime <= :endtime ";
		$paras[':starttime'] = $starttime;
		$paras[':endtime'] = $endtime;
	}
	if(trim($_GPC['goodsid'])!=''){
		$condition .= " and g_id like '%{$_GPC['goodsid']}%' ";
	}
	if(trim($_GPC['goodsid2'])!=''){
		$condition .= " and g_id like '%{$_GPC['goodsid2']}%' ";
	}
	if (!empty($_GPC['merchantid'])) {
		$condition .= " AND  merchantid={$_GPC['merchantid']} ";
	}
	if (!empty($_GPC['transid'])) {
		$condition .= " AND  transid =  '{$_GPC['transid']}'";
	}
	if (!empty($_GPC['pay_type'])) {
		$condition .= " AND  pay_type = '{$_GPC['pay_type']}'";
	} elseif ($_GPC['pay_type'] === '0') {
		$condition .= " AND  pay_type = '{$_GPC['pay_type']}'";
	}
	if (!empty($_GPC['keyword'])) {
		$condition .= " AND  orderno LIKE '%{$_GPC['keyword']}%'";
	}
	if (!empty($_GPC['member'])) {
		$condition .= " AND (addname LIKE '%{$_GPC['member']}%' or mobile LIKE '%{$_GPC['member']}%')";
	}
	$condition .= " AND  status = 6";
	$sql = "select  * from " . tablename('tg_order') . " where $condition and mobile<>'虚拟' ORDER BY createtime DESC " . "LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
	$list = pdo_fetchall($sql, $paras);
	$paytype = array('0' => array('css' => 'default', 'name' => '未支付'), '1' => array('css' => 'info', 'name' => '余额支付'), '2' => array('css' => 'success', 'name' => '在线支付'), '3' => array('css' => 'warning', 'name' => '货到付款'));
	$orderstatus = array('0' => array('css' => 'default', 'name' => '待付款'), '1' => array('css' => 'info', 'name' => '已付款'), '2' => array('css' => 'warning', 'name' => '待发货'), '3' => array('css' => 'success', 'name' => '已发货'), '4' => array('css' => 'success', 'name' => '已签收'), '5' => array('css' => 'default', 'name' => '已取消'), '6' => array('css' => 'danger', 'name' => '待退款'), '7' => array('css' => 'default', 'name' => '已退款'));
	foreach ($list as $key => $value) {
		$goods = goods_get_by_params(" id={$value['g_id']} ");
		$list[$key]['goods'] =$goods;
		$options  = pdo_fetch("select title,productprice,marketprice from " . tablename("tg_goods_option") . " where id=:id limit 1", array(":id" => $value['optionid']));
		$list[$key]['optionname'] = $options['title'];
		$s = $value['status'];
		$list[$key]['statuscss'] = $orderstatus[$value['status']]['css'];
		$list[$key]['status'] = $orderstatus[$value['status']]['name'];
		$list[$key]['css'] = $paytype[$value['pay_type']]['css'];
		if ($value['pay_type'] == 2) {
			if (empty($value['transid'])) {
				$list[$key]['paytype'] = '微信支付';
			} else {
				$list[$key]['paytype'] = '微信支付';
			}
		} else {
			$list[$key]['paytype'] = $paytype[$value['pay_type']]['name'];
		}
		$goodsss = pdo_fetch("select id,gname,gimg,merchantid from" . tablename('tg_goods') . "where id = '{$value['g_id']}'");
		$list[$key]['gid'] = $goodsss['id'];
		$list[$key]['gname'] = $goodsss['gname'];
		$list[$key]['gimg'] = $goodsss['gimg'];
		$list[$key]['merchant'] = pdo_fetch("select name from" . tablename('tg_merchant') . "where id = '{$value['merchantid']}' and uniacid={$_W['uniacid']}");
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tg_order') . " WHERE $condition and mobile<>'虚拟'", $paras);
	$pager = pagination($total, $pindex, $psize);
	include wl_template("order/refund");
}
if($op == 'initsync') {
	wl_load()->model('order');
	$order_ids = $_GPC['order_ids'];
	$log = $_GPC['log'];
	$all = $_GPC['all'];
	$success = $_GPC['success'];
	$fail = $_GPC['fail'];
	if($log == '') {
		if(!empty($order_ids)){
			$sql = "select  * from " . tablename('tg_order') . " where status=6 and mobile<>'虚拟' and id in($order_ids)  ORDER BY createtime DESC LIMIT 0,9";
			$list = pdo_fetchall($sql);
			$all = count($list);
		}else{
			$sql2 = "select  * from " . tablename('tg_order') . " where status=6 and mobile<>'虚拟'";
			$list2 = pdo_fetchall($sql2);
			$all = count($list2);
		}
		message('正在为'.$all.'个订单退款,请不要关闭浏览器', web_url('order/refund/initsync', array('log' => 0,'order_ids'=>$order_ids,'all'=>$all,'success'=>0,'fail'=>0)), 'success');
	}
	if(!empty($order_ids)){
		$sql = "select  * from " . tablename('tg_order') . " where status=6 and mobile<>'虚拟' and id in($order_ids)  ORDER BY createtime DESC LIMIT 0,9";
		$list = pdo_fetchall($sql, $paras);
		foreach($list as$key=>$value){
			$r=refund($value['orderno'], 2);
			if($r=='success'){
				/*退款成功消息提醒*/
				$success+=1;
				$url = app_url('order/order/detail', array('id' => $value['id']));
				refund_success($value['openid'],  $value['price'], $url);
			}else{
				$fail+=1;
			}
		}
	}else{
		$sql = "select  * from " . tablename('tg_order') . " where status=6 and mobile<>'虚拟'  ORDER BY createtime DESC LIMIT 0,9";
		$list = pdo_fetchall($sql, $paras);
		foreach($list as$key=>$value){
			$r=refund($value['orderno'], 2);
			if($r=='success'){
				/*退款成功消息提醒*/
				$success++;
				$url = app_url('order/order/detail', array('id' => $value['id']));
				refund_success($value['openid'],  $value['price'], $url);
			}else{
				$fail++;
			}
		}
	}
	$log += count($list);
	$level_num = $all - $success - $fail;
	if($level_num==0) {
		message('全部退款操作完成,总共'.$all."个退款单,成功".$success."个,失败".$fail."个！！", web_url('order/refund'), 'success');
	} else {
		message('正在退款,请不要关闭浏览器,已退 ' . $log . ' 个订单,成功'.$success.'个,失败'.$fail.'个,总共'.$all.个退款单, web_url('order/refund/initsync', array('log' => $log,'all'=>$all,'success'=>$success,'fail'=>$fail)));
	}
}
	