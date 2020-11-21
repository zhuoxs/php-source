<?php
$ops = array('display','output','import');
$op = in_array($op, $ops) ? $op : 'display';
load() -> func('tpl');
if ($op == 'display') {
	if (empty($starttime) || empty($endtime)) {//初始化时间
		$starttime = strtotime('-1 month');
		$endtime = time();
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$where = array();
	$where['!=mobile'] = "'虚拟'";//排除虚拟订单
	$where['status'] = 2;
	$where['#lottery_status#'] = '(0,2)';
	if($_GPC['orderType']=='fetch')
		$where['#is_hexiao#'] = '(1,2)';
	else
		$where['is_hexiao'] = 0;
	if(!empty($_GPC['status'])) $where['is_tuan'] = $_GPC['status']==1?1:0;
	if(TG_MERCHANTID)$where['merchantid'] = $_SESSION['role_id'];
	if (!empty($_GPC['time']) && !empty($_GPC['timetype'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		switch($_GPC['timetype']){
			case 1:$where['starttime>'] = $starttime;
				   $where['starttime<'] = $endtime;break;
			case 2:$where['successtime>'] = $starttime;
		           $where['successtime<'] = $endtime;break;
			default:break;
		}
	}
	if (!empty($_GPC['keyword'])) {
		if(!empty($_GPC['keywordtype'])){
			switch($_GPC['keywordtype']){
				case 1: $where['@orderno@'] = $_GPC['keyword'];break;
				case 2: $where['@transid@'] = $_GPC['keyword'];break;
				case 3: $where['g_id'] = $_GPC['keyword'];break;
				case 4: $where['merchantid'] = $_GPC['keyword'];break;
				case 5: $where['@addname@'] = $_GPC['keyword'];break;
				case 6: $where['@mobile@'] = $_GPC['keyword'];break;
				default:break;
			}
		}
	}
	$orderData = model_order::getNumOrder('*', $where, 'createtime desc', $pindex, $psize, 1);
	$list = $orderData[0];
	$pager = $orderData[1];
	
	$total_tuan = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and lottery_status in(0,2) and status=2 and mobile<>'虚拟' and is_tuan=1 and is_hexiao=0 ".TG_MERCHANTID."");
	$total_single = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and lottery_status in(0,2) and status=2 and mobile<>'虚拟' and is_tuan=0 and is_hexiao=0 ".TG_MERCHANTID."");
	$total_all = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename('tg_order') . " WHERE uniacid='{$_W['uniacid']}' and lottery_status in(0,2) and status=2 and mobile<>'虚拟' and is_tuan in (0,1) and is_hexiao=0 ".TG_MERCHANTID."");
} elseif ($op == 'import') {
	$file = $_FILES['fileName'];
	$max_size = "2000000";
	$fname = $file['name'];
	$ftype = strtolower(substr(strrchr($fname, '.'), 1));
	//文件格式
	$uploadfile = $file['tmp_name'];
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (is_uploaded_file($uploadfile)) {
			if ($file['size'] > $max_size) {
				echo "Import file is too large";
				exit ;
			}
			if ($ftype == 'xls') {
				require_once '../framework/library/phpexcel/PHPExcel.php';
				$objReader = PHPExcel_IOFactory::createReader('Excel5');
				$objPHPExcel = $objReader -> load($uploadfile);
				$sheet = $objPHPExcel -> getSheet(0);
				$highestRow = $sheet -> getHighestRow();
				$succ_result = 0;
				$error_result = 0;
				for ($j = 2; $j <= $highestRow; $j++) {
					$orderNo = trim($objPHPExcel -> getActiveSheet() -> getCell("A$j") -> getValue());
					$expressOrder = trim($objPHPExcel -> getActiveSheet() -> getCell("J$j") -> getValue());
					$expressName = trim($objPHPExcel -> getActiveSheet() -> getCell("K$j") -> getValue());
					if (!empty($expressOrder) && !empty($expressName)) {
						$order = pdo_fetch("select * from" . tablename('tg_order') . "where orderno ='{$orderNo}'");
						$res = pdo_update('tg_order', array('status' => 3, 'express' => $expressName, 'expresssn' => $expressOrder,'sendtime'=>TIMESTAMP), array('orderno' => $orderNo));
						Util::deleteCache('order', $order['id']);
						if ($res) {
							/*更新可结算金额*/
							if(!empty($order['merchantid'])){
								pdo_insert("tg_merchant_money_record",array('merchantid'=>$order['merchantid'],'uniacid'=>$_W['uniacid'],'money'=>$order['price'],'orderid'=>$order['id'],'createtime'=>TIMESTAMP,'type'=>2,'detail'=>'批量发货成功：订单号：'.$order['orderno']));
								model_merchant::updateNoSettlementMoney($order['price'], $order['merchantid']);//更新可结算金额
							}
							/*记录操作*/
							$oplogdata = serialize($item);
							oplog('admin', "后台批量发货", web_url('order/import/import'), $oplogdata);
							$url = app_url('order/order/detail', array('id' => $order['id']));
							message::send_success($order['orderno'], $order['openid'], $expressName, $expressOrder, $url);
							$succ_result += 1;
						} else {
							$error_result += 1;
						}
					} else {
						if (!empty($orderNo)) {
							$error_result += 1;
						}
					}
				}
			}elseif ($ftype == 'csv') {
			    if (empty ($uploadfile)) { 
			        echo '请选择要导入的CSV文件！'; 
			        exit; 
			    } 
			    $handle = fopen($uploadfile, 'r'); 
				$n = 0; 
			    while ($data = fgetcsv($handle, 10000)) { 
			        $num = count($data); 
			        for ($i = 0; $i < $num; $i++) { 
			            $out[$n][$i] = $data[$i]; 
			        } 
			        $n++; 
			    } 
			    $result = $out; //解析csv 
			    $len_result = count($result); 
			    if($len_result==0){ 
			        echo '没有任何数据！'; 
			        exit; 
			    } 
				$succ_result = 0;
				$error_result = 0;
			    for ($i = 1; $i < $len_result; $i++) { //循环获取各字段值 
			        $orderNo = trim(iconv('gb2312', 'utf-8', $result[$i][0])); //中文转码 
			        if($orderNo==''){			
			        	continue;
			        }
			       
			        $expressOrder = trim(iconv('gb2312', 'utf-8', $result[$i][9])); 
			        $expressName =trim(iconv('gb2312', 'utf-8', $result[$i][10]));
				
					if (!empty($expressOrder) && !empty($expressName)) {
						$order = pdo_fetch("select * from" . tablename('tg_order') . "where orderno ='{$orderNo}'");
						$res = pdo_update('tg_order', array('status' => 3, 'express' => $expressName, 'expresssn' => $expressOrder,'sendtime'=>TIMESTAMP), array('orderno' => $orderNo));
						Util::deleteCache('order', $order['id']);
						if ($res) {
							$url = app_url('order/order/detail', array('id' => $order['id']));
							message::send_success($order['orderno'], $order['openid'], $expressName, $expressOrder, $url);
							if(!empty($order['merchantid'])){
								pdo_insert("tg_merchant_money_record",array('merchantid'=>$order['merchantid'],'uniacid'=>$_W['uniacid'],'money'=>$order['price'],'orderid'=>$order['id'],'createtime'=>TIMESTAMP,'type'=>2,'detail'=>'批量发货成功：订单号：'.$order['orderno']));
								model_merchant::updateNoSettlementMoney($order['price'], $order['merchantid']);//更新可结算金额
							}
							$succ_result += 1;
						} else {
							$error_result += 1;
						}
					}else{
							$error_result += 1;
					}
			    } 
			    fclose($handle); //关闭指针 
			}else{
				echo "文件后缀格式必须为xls或csv";
				exit ;
			}
		} else {
			echo "文件名不能为空!";
			exit ;
		}
	}
	message('导入发货订单操作成功！成功' . $succ_result . '条，失败' . $error_result . '条', referer(), 'success');
} elseif ($op == 'output') {
	$where = array();
	$where['mobile>'] = 10000000000;//排除虚拟订单
	$where['status'] = 2;
	$where['#lottery_status#'] = '(0,2)';
	if($_GPC['orderType']=='fetch')
		$where['#is_hexiao#'] = '(1,2)';
	else
		$where['is_hexiao'] = 0;
	if(!empty($_GPC['status'])) $where['is_tuan'] = $_GPC['status']==1?1:0;
	if(TG_MERCHANTID)$where['merchantid'] = $_SESSION['role_id'];
	if (!empty($_GPC['times']) && !empty($_GPC['timetype'])) {
		$starttime = strtotime($_GPC['times']);
		$endtime = strtotime($_GPC['timee']);
		switch($_GPC['timetype']){
			case 1:$where['starttime>'] = $starttime;
				   $where['starttime<'] = $endtime;break;
			case 2:$where['successtime>'] = $starttime;
		           $where['successtime<'] = $endtime;break;
			default:break;
		}
	}
	if (!empty($_GPC['keyword'])) {
		if(!empty($_GPC['keywordtype'])){
			switch($_GPC['keywordtype']){
				case 1: $where['@orderno@'] = $_GPC['keyword'];break;
				case 2: $where['@transid@'] = $_GPC['keyword'];break;
				case 3: $where['g_id'] = $_GPC['keyword'];break;
				case 4: $where['merchantid'] = $_GPC['keyword'];break;
				case 5: $where['@addname@'] = $_GPC['keyword'];break;
				case 6: $where['@mobile@'] = $_GPC['keyword'];break;
				default:break;
			}
		}
	}
	$orderData = model_order::getNumOrder('*', $where, 'pay_type desc', 0, 0, 0);
	$orders = $orderData[0];
	if ($status == '0') $str = '单独购买待发货订单_' . time();
	if ($status == '1') $str = '团购成功待发货订单_' . time();
	if ($status == '') $str = '全部待发货订单' . time();
	$html = "\xEF\xBB\xBF";
	$filter = array('aa' => '订单编号', 'bb' => '姓名', 'cc' => '电话', 'dd' => '总价(元)', 'ee' => '状态', 'ff' => '下单时间', 'gg' => '商品名称', 'hh' => '收货地址', 'ii' => '微信订单号', 'jj' => '快递单号', 'kk' => '快递名称','ll'=>'团ID','pp'=>'商品规格','oo'=>'购买数量','mm'=>'买家留言','tt'=>'支付方式');
	foreach ($filter as $key => $title) {
		$html .= $title . "\t,";
	}
	$html .= "\n";
	
		foreach ($orders as $k => $v) {
			$thistatus = '待发货';
			$goods = model_goods::getSingleGoods($v['g_id'], "*"); 
			$time = date('Y-m-d H:i:s', $v['createtime']);
			if(empty($v['optionname']))$v['optionname'] = '不限';
			$orders[$k]['aa'] = $v['orderno'];
			$orders[$k]['bb'] = $v['addname'];
			$orders[$k]['cc'] = $v['mobile'];
			$orders[$k]['dd'] = $v['price'];
			$orders[$k]['ee'] = $thistatus;
			$orders[$k]['ff'] = $time;
			$orders[$k]['gg'] = $goods['gname'];
			$orders[$k]['hh'] = $v['address'];
			$orders[$k]['ii'] = $v['transid'];
			$orders[$k]['jj'] = $v['expresssn'];
			$orders[$k]['kk'] = $v['express'];
			$orders[$k]['ll'] = $v['tuan_id'];
			$orders[$k]['mm'] = $v['remark'];
			$orders[$k]['oo'] = $v['gnum'];
			$orders[$k]['pp'] = $v['optionname'];
			$orders[$k]['tt'] = $v['pay_typeName'];
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
include wl_template('order/import');
?>