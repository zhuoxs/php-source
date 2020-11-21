<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('delete','display','detail','confirm','output','confrimpay','confirmsend','cancelsend','refund');
$op = in_array($op, $ops) ? $op : 'display';
load() -> func('tpl');
wl_load()->model("merchant");
wl_load()->model("goods");
$uniacid= $_W['uniacid'];
$merchants = pdo_fetchall("SELECT * FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}' ".TG_ID." ORDER BY id DESC");
$allgoods = pdo_fetchall("select gname,id from".tablename('tg_goods')."where uniacid=:uniacid ".TG_MERCHANTID."",array(':uniacid'=>$_W['uniacid']));
$salers = pdo_fetchall("select nickname,openid from".tablename('tg_saler')."where uniacid={$_W['uniacid']} and status=1 ".TG_MERCHANTID."");
$stores = pdo_fetchall("select storename,id from" . tablename('tg_store') . "where uniacid='{$_W['uniacid']}' and status=1 ".TG_MERCHANTID."");

if($op=='confirm'){
	$id = $_GPC['id'];
	$item = pdo_fetch("SELECT * FROM " . tablename('tg_order') . " WHERE id = :id", array(':id' => $id));
	if (pdo_update('tg_order', array('status' => 4),array('id'=>$id))) {
		/*更新可结算金额*/
		if(!empty($item['merchantid'])){merchant_update_no_money($item['price'], $item['merchantid']);}
		/*记录操作*/
		$oplogdata = serialize($item);
		oplog('admin', "后台列表核销", web_url('order/fetch/confirm'), $oplogdata);
		die(json_encode(array('errno'=>0,'message'=>'核销成功！')));
	} else {
		die(json_encode(array('errno'=>1,'message'=>'核销失败！')));
	}
}

if ($op == 'display') {
	header("Location: ".web_url('order/order/received',array('type'=>'fetch')));exit;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$condition = "  uniacid = :uniacid";
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
		$endtime = strtotime($_GPC['time']['end']);
		$condition .= " AND  createtime >= :starttime AND  createtime <= :endtime ".TG_MERCHANTID."";
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
	if (!empty($_GPC['hexiaoma'])) {
		$condition .= " AND  hexiaoma LIKE '%{$_GPC['hexiaoma']}%'";
	}
	if (!empty($_GPC['member'])) {
		$condition .= " AND (addname LIKE '%{$_GPC['member']}%' or mobile LIKE '%{$_GPC['member']}%')";
	}
	if (!empty($_GPC['nickname'])) {
		$condition .= " AND (addname LIKE '%{$_GPC['member']}%' or mobile LIKE '%{$_GPC['member']}%')";
	}
	if (!empty($_GPC['veropenid'])) {
		$condition .= " AND veropenid='{$_GPC['veropenid']}' ";
	}
	if (!empty($_GPC['storeid'])) {
		$condition .= " AND storeid = {$_GPC['storeid']}";
	}

	if ($status != '') {
		$condition .= " AND  status = '" . intval($status) . "'";
	}
	$sql = "select  * from " . tablename('tg_order') . " where $condition and mobile<>'虚拟' and is_hexiao in(1,2)  ORDER BY createtime DESC " . "LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
	$list = pdo_fetchall($sql, $paras);
	$paytype = array('0' => array('css' => 'default', 'name' => '未支付'), '1' => array('css' => 'info', 'name' => '余额支付'), '2' => array('css' => 'success', 'name' => '在线支付'), '3' => array('css' => 'warning', 'name' => '货到付款'));
	$orderstatus = array('0' => array('css' => 'default', 'name' => '待付款'), '1' => array('css' => 'info', 'name' => '已付款'), '2' => array('css' => 'warning', 'name' => '待消费'), '3' => array('css' => 'success', 'name' => '已消费'), '4' => array('css' => 'success', 'name' => '已完成'), '5' => array('css' => 'success', 'name' => '已取消'), '6' => array('css' => 'danger', 'name' => '待退款'), '7' => array('css' => 'success', 'name' => '已退款'));
	foreach ($list as &$value) {
		$s = $value['status'];
		$value['statuscss'] = $orderstatus[$value['status']]['css'];
		$value['status'] = $orderstatus[$value['status']]['name'];
		$value['css'] = $paytype[$value['pay_type']]['css'];
		if ($value['pay_type'] == 2) {
			if (empty($value['transid'])) {
				$value['paytype'] = '微信支付';
			} else {
				$value['paytype'] = '微信支付';
			}
		} else {
			$value['paytype'] = $paytype[$value['pay_type']]['name'];
		}
		$goodsss = pdo_fetch("select * from" . tablename('tg_goods') . "where id = '{$value['g_id']}'");
		$value['gid'] = $goodsss['id'];
		$value['gname'] = $goodsss['gname'];
		$value['gimg'] = $goodsss['gimg'];
		$value['merchant'] = pdo_fetch("select name from" . tablename('tg_merchant') . "where id = '{$value['merchantid']}' and uniacid={$_W['uniacid']}");
		if(!empty($value['veropenid'])){
			$value['saler'] = pdo_fetch("select * from".tablename('tg_member')."where openid='{$value['veropenid']}'");
		}
		if(!empty($value['storeid'])){
			$value['store'] = pdo_fetch("select * from".tablename('tg_store')."where id='{$value['storeid']}'");
		}
	}
//wl_debug($list);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tg_order') . " WHERE $condition and mobile<>'虚拟' and is_hexiao<>0", $paras);
	$pager = pagination($total, $pindex, $psize);
	
	$all = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and mobile<>'虚拟' and is_hexiao<>0 ");
	$status0 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and status=0 and mobile<>'虚拟' and is_hexiao<>0 ".TG_MERCHANTID."");
	$status1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and status=1 and mobile<>'虚拟' and is_hexiao<>0 ".TG_MERCHANTID."");
	$status2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and status=2 and mobile<>'虚拟' and is_hexiao<>0 ".TG_MERCHANTID."");
	$status4 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and status=4 and mobile<>'虚拟' and is_hexiao<>0 ".TG_MERCHANTID."");
	$status5 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and status=5 and mobile<>'虚拟' and is_hexiao<>0 ".TG_MERCHANTID."");
	$status6 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and status=6 and mobile<>'虚拟' and is_hexiao<>0 ".TG_MERCHANTID."");
	$status7 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and status=7 and mobile<>'虚拟' and is_hexiao<>0 ".TG_MERCHANTID."");
}

if ($op == 'detail') {
	$id = intval($_GPC['id']);
	$item = pdo_fetch("SELECT * FROM " . tablename('tg_order') . " WHERE id = :id", array(':id' => $id));
	if ($item['status'] == 7) {
		$refund_record = pdo_fetch("SELECT * FROM " . tablename('tg_refund_record') . " WHERE orderid = :id", array(':id' => $id));
	}
	if (empty($item)) {
		message("抱歉，订单不存在!", referer(), "error");
	}
	if ($item['veropenid']){
		if($item['veropenid'] == 'houtai'){
			$item['verstore'] = '后台核销';
			$item['vername'] = '后台核销';
		}else{
			$list = pdo_fetch("select * from" . tablename('tg_saler') . "where uniacid='{$_W['uniacid']}' and openid = '{$item['veropenid']}'");
			if($list['storeid']){
				$storeid_arr = explode(',', $list['storeid']);
				$storename   = '';
				foreach ($storeid_arr as $k => $v) {
					if ($v) {
						$store = pdo_fetch("select * from" . tablename('tg_store') . "where id='{$v}'");
						$storename .= $store['storename'] . "/";
					}
				}
				$storename               = substr($storename, 0, strlen($storename) - 1);
			}else{
				$storename = '全局核销员';
			}
			$item['verstore'] = $storename;
			$item['vername'] = $list['nickname'];
		}
	}
	
	if (checksubmit('getgoods')) {
		if ($_GPC['recvname']=='' || $_GPC['recvmobile']=='' || $_GPC['recvaddress']=='' || $_GPC['addresstype']=='') {
			message('请输入完整信息！');
		} else {
			pdo_update('tg_order', array('addname' => $_GPC['recvname'], 'mobile' => $_GPC['recvmobile'], 'address' => $_GPC['recvaddress'],'addresstype'=>$_GPC['addresstype']), array('id' => $id));
		}
		message('修改成功！', referer(), 'success');
	}
	$item['user'] = pdo_fetch("SELECT * FROM " . tablename('tg_address') . " WHERE id = {$item['addressid']}");
	$goods = goods_get_by_params(" id={$item['g_id']} ");
	$item['goods'] = $goods;
	include wl_template('order/bdelete_detail');exit;
}

if($op == 'output'){
	$status = $_GPC['status'];
	$keyword = $_GPC['keyword'];
	$member = $_GPC['member'];
	$time = $_GPC['time'];
	$transid = $_GPC['transid'];
	$paytype = $_GPC['pay_type'];
	$starttime = $_GPC['starttime'];
	$endtime = $_GPC['endtime'];
	$condition = " uniacid='{$_W['uniacid']}' and is_hexiao <>0  ".TG_MERCHANTID."";
	if(trim($starttime)!=''){
		$condition .= " and createtime> '{$starttime}' ";
	}
	if(trim($endtime)!=''){
		$condition .= " and createtime< '{$endtime}' ";
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
	if ($status != '') {
		$condition .= " AND status= '{$status}' ";
	}
	if ($keyword != '') {
		$condition .= " AND orderno = '{$keyword}'";
	}
	if (!empty($member)) {
		$condition .= " AND (addname LIKE '%{$member}%' or mobile LIKE '%{$member}%')";
	}
	if (!empty($time)) {
		$condition .= " AND  createtime >= $starttime AND  createtime <= $endtime  ";
	}
	if (!empty($transid)) {

		$condition .= " AND  transid =  '{$transid}'";
	}
	if (!empty($paytype)) {
		$condition .= " AND  pay_type = '{$paytype}'";
	}
	$orders = pdo_fetchall("select * from" . tablename('tg_order') . "where $condition  and mobile<>'虚拟'");
//	echo "<pre>";print_r($condition);exit;
	switch($status){
		case NULL: 
		$str = '全部订单_' . time();
		break;
		case 1: 
		$str = '已支付订单_' . time();
		break;
		case 2: 
		$str = '待消费订单' . time();
		break;
		case 3: 
		$str = '已完成订单' . time();
		break;
		case 4:
		$str = '已完成订单' . time();
		break;
		case 5:
		$str = '已取消订单' . time();
		break;
		case 6: 
		$str = '待退款订单' . time();
		break;
		case 7:
		$str = '已退款订单' . time();
		break;
		default:
		$str = '待支付订单' . time();break;
	}
	

	/* 输入到CSV文件 */
	$html = "\xEF\xBB\xBF";
	/* 输出表头 */
	$filter = array('aa' => '订单编号', 'bb' => '姓名', 'cc' => '电话', 'dd' => '总价(元)', 'ee' => '状态', 'ff' => '下单时间', 'gg' => '商品名称', 'hh' => '收货地址', 'ii' => '微信订单号', 'jj' => '快递单号', 'kk' => '快递名称','ll'=>'地址类型','mm'=>'商品规格','oo'=>'客户留言','pp'=>'我的备注');
	foreach ($filter as $key => $title) {
		$html .= $title . "\t,";
	}
	$html .= "\n";
	foreach ($orders as $k => $v) {
		if ($v['status'] == '0') {
			$thisstatus = '未支付';
		}
		if ($v['status'] == '1') {
			$thisstatus = '已支付';
		}
		if ($v['status'] == '2') {
			$thisstatus = '待消费';
		}
		if ($v['status'] == '3') {
			$thisstatus = '已完成';
		}
		if ($v['status'] == '4') {
			$thisstatus = '已完成';
		}
		if ($v['status'] == '5') {
			$thisstatus = '已取消';
		}
		if ($v['status'] == '6') {
			$thisstatus = '待退款';
		}
		if ($v['status'] == '7') {
			$thisstatus = '已退款';
		}
		if ($v['status'] == '') {
			$thisstatus = '全部订单';
		}
		$thistatus = '待发货';
		$goods = pdo_fetch("select * from" . tablename('tg_goods') . "where id = '{$v['g_id']}' and uniacid='{$_W['uniacid']}'");
		$time = date('Y-m-d H:i:s', $v['createtime']);
		$options  = pdo_fetch("select title,productprice,marketprice from " . tablename("tg_goods_option") . " where id=:id limit 1", array(":id" => $v['optionid']));
		if(empty($options['title'])){
			$options['title'] = '不限';
		}
		$orders[$k]['aa'] = $v['orderno'];
		$orders[$k]['bb'] = $v['addname'];
		$orders[$k]['cc'] = $v['mobile'];
		$orders[$k]['dd'] = $v['price'];
		$orders[$k]['ee'] = $thisstatus;
		$orders[$k]['ff'] = $time;
		$orders[$k]['gg'] = $goods['gname'];
		$orders[$k]['ii'] = $v['transid'];
		$orders[$k]['mm'] = $options['title'];
		$orders[$k]['oo'] = $v['remark'];
		$orders[$k]['pp'] = $v['adminremark'];
		foreach ($filter as $key => $title) {
			$html .= $orders[$k][$key] . "\t,";
		}
		$html .= "\n";
	}
	/* 输出CSV文件 */
	header("Content-type:text/csv");
	header("Content-Disposition:attachment; filename={$str}.csv");
	echo $html;
	exit();
}

if($op=='confrimpay'){
	$id = $_GPC['id'];
	pdo_update('tg_order', array('status' => 1, 'pay_type' => 2, 'ptime' => TIMESTAMP), array('id' => $id));
	message('确认订单付款操作成功！', referer(), 'success');
}

if($op=='confirmsend'){
	$id = $_GPC['id'];
	$item = pdo_fetch("SELECT * FROM " . tablename('tg_order') . " WHERE id = :id", array(':id' => $id));
	$r=pdo_update('tg_order', array('status' => 4, 'express' => $_GPC['express'], 'expresssn' => $_GPC['expresssn'], 'sendtime' => TIMESTAMP), array('id' => $id));
	if($r){
		/*更新可结算金额*/
		if(!empty($item['merchantid'])){merchant_update_no_money($item['price'], $item['merchantid']);}
		/*记录操作*/
		$oplogdata = serialize($item);
		oplog('admin', "后台确认核销", web_url('order/fetch/confirmsend'), $oplogdata);
	}
	message('操作成功！', referer(), 'success');
}

if($op=='cancelsend'){
	$id = $_GPC['id'];
	$item = pdo_fetch("SELECT * FROM " . tablename('tg_order') . " WHERE id = :id", array(':id' => $id));
	$r=pdo_update('tg_order', array('status' => 2,'sendtime'=>'','express' => '', 'expresssn' => ''), array('id' => $id));
	if($r){
		/*更新可结算金额*/
		if(!empty($item['merchantid'])){merchant_update_no_money(0-$item['price'], $item['merchantid']);}
		/*记录操作*/
		$oplogdata = serialize($item);
		oplog('admin', "后台取消核销", web_url('order/fetch/confirmsend'), $oplogdata);
	}
	message('操作成功！', referer(), 'success');
}

if($op=='refund'){
	$id = $_GPC['id'];
	$item = pdo_fetch("SELECT * FROM " . tablename('tg_order') . " WHERE id = :id", array(':id' => $id));
	$orderno = $item['orderno'];
	$res=refund($orderno,2);
	if($res=='success'){
		/*记录操作*/
		$oplogdata = serialize($item);
		oplog('admin', "后台订单详情退款", web_url('order/order/refund'), $oplogdata);
		/*退款成功消息提醒*/
		$url = app_url('goods/list');
		refund_success($value['orderno'],$item['openid'],  $item['price'], $url);
		message('退款成功了！', referer(), 'success');
	} else {
		message('退款失败，服务器正忙，请稍等等！', referer(), 'fail');
	}
}

if($op == 'delete'){
	if(!empty($_GPC['id'])){
		$id = $_GPC['id'];
		$data = pdo_fetch("SELECT * FROM " . tablename('tg_order') . " WHERE id = :id", array(':id' => $id));
		$data = serialize($data);
		$result = pdo_delete('tg_order', array('id' => $id));
		if($result){
			oplog('admin',"删除订单",web_url('order/fetch/delete'), $data);
			die(json_encode(array('errno'=>0)));
			
		} else {
			die(json_encode(array('errno'=>1)));
		}	
	}else {
		$ids = $_GPC['ids'];
		foreach($ids as $key=>$value){
			$data = pdo_fetch("SELECT * FROM " . tablename('tg_order') . " WHERE id = :id", array(':id' => $value));
			$data = serialize($data);	
			$result = pdo_delete('tg_order', array('id' => $value));
			if($result){
				oplog('admin',"删除订单",web_url('order/fecth/delete'), $data);
			}
		} 
		die(json_encode(array('errno'=>0)));
	}
}	

include wl_template('order/bdelete');
