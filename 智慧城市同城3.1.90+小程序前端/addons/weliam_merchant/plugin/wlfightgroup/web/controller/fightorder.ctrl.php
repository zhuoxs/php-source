<?php
defined('IN_IA') or exit('Access Denied');

class Fightorder_WeliamController{
	//订单列表	
	function orderlist(){
		global $_W, $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$wheres = array();
		$wheres['uniacid'] = $_W['uniacid'];
		$wheres['aid'] = $_W['aid'];
		$wheres['plugin'] = 'wlfightgroup';
		$status0 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_order')." WHERE plugin = 'wlfightgroup' AND uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status != 0 AND orderno != 666666");
		$status1 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_order')." WHERE plugin = 'wlfightgroup' AND uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 1 AND orderno != 666666");
		$status2 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_order')." WHERE plugin = 'wlfightgroup' AND uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 2 AND orderno != 666666");
		$status3 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_order')." WHERE plugin = 'wlfightgroup' AND uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 3 AND orderno != 666666");
		$status4 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_order')." WHERE plugin = 'wlfightgroup' AND uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 4 AND orderno != 666666");
		$status5 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_order')." WHERE plugin = 'wlfightgroup' AND uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 5 AND orderno != 666666");
		$status6 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_order')." WHERE plugin = 'wlfightgroup' AND uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 6 AND orderno != 666666");
		$status7 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_order')." WHERE plugin = 'wlfightgroup' AND uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 7 AND orderno != 666666");
		$status8 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_order')." WHERE plugin = 'wlfightgroup' AND uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 8 AND orderno != 666666");
		$status9 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_order')." WHERE plugin = 'wlfightgroup' AND uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND applyrefund = 1 AND orderno != 666666");

		$status = $_GPC['status'];
		if($status){
			if($status == 9){
				$wheres['applyrefund'] = 1;
			}else {
				$wheres['status'] = $status;
			}
		}else {
			$wheres['status>'] = 1;
		}
//		if($type == 2){
//			$wheres['status'] = 4;
//		}else {
//			$wheres['status!='] = 4;
//		}
		if (!empty($_GPC['keyword'])){
			if(!empty($_GPC['keywordtype'])){
				switch($_GPC['keywordtype']){
					case 1: $wheres['@id@'] = $_GPC['keyword'];break;
					case 2: $wheres['@orderno@'] = $_GPC['keyword'];break;
					case 3: $wheres['@fkid@'] = $_GPC['keyword'];break;
					case 4: $wheres['@sid@'] = $_GPC['keyword'];break;
					default:break;
				}
				if($_GPC['keywordtype'] == 5){
					$keyword = $_GPC['keyword'];
					$params[':name'] = "%{$keyword}%";
					$goods = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_fightgroup_goods')."WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND name LIKE :name",$params);
					if($goods){
						$goodids = "(";
						foreach ($goods as $key => $v) {
							if($key == 0){
								$goodids.= $v['id'];
							}else{
								$goodids.= ",".$v['id'];
							}	
						}
						$goodids.= ")";
						$wheres['fkid#'] = $goodids;
					}else {
						$wheres['fkid#'] = "(0)";
					}
				}
				if($_GPC['keywordtype'] == 6){
					$keyword = $_GPC['keyword'];
					$params[':nickname'] = "%{$keyword}%";
					$member = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_member')."WHERE uniacid = {$_W['uniacid']}  AND nickname LIKE :nickname",$params);
					if($member){
						$mids = "(";
						foreach ($member as $key => $v) {
							if($key == 0){
								$mids.= $v['id'];
							}else{
								$mids.= ",".$v['id'];
							}	
						}
						$mids.= ")";
						$wheres['mid#'] = $mids;
					}else {
						$wheres['mid#'] = "(0)";
					}
				}
				if($_GPC['keywordtype'] == 7){
					$keyword = $_GPC['keyword'];
					$params[':storename'] = "%{$keyword}%";
					$merchant = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_merchantdata')."WHERE uniacid = {$_W['uniacid']}  AND storename LIKE :storename",$params);
					if($merchant){
						$sids = "(";
						foreach ($merchant as $key => $v) {
							if($key == 0){
								$sids.= $v['id'];
							}else{
								$sids.= ",".$v['id'];
							}	
						}
						$sids.= ")";
						$wheres['sid#'] = $sids;
					}else {
						$wheres['sid#'] = "(0)";
					}
				}
				if($_GPC['keywordtype'] == 8){
					$keyword = $_GPC['keyword'];
					$params[':mobile'] = "%{$keyword}%";
					$member = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_member')."WHERE uniacid = {$_W['uniacid']}  AND mobile LIKE :mobile",$params);
					if($member){
						$mids = "(";
						foreach ($member as $key => $v) {
							if($key == 0){
								$mids.= $v['id'];
							}else{
								$mids.= ",".$v['id'];
							}	
						}
						$mids.= ")";
						$wheres['mid#'] = $mids;
					}else {
						$wheres['mid#'] = "(0)";
					}
				}
			}
		}
		if (!empty($_GPC['fightgroupid'])) {
			$wheres['fightgroupid'] = $_GPC['fightgroupid'];
		}else {
			$wheres['orderno!='] = 666666;
		}
		if($_GPC['time_limit']){
			$time_limit = $_GPC['time_limit'];
			$starttime = strtotime($_GPC['time_limit']['start']);
			$endtime = strtotime($_GPC['time_limit']['end']) ;
			$wheres['createtime>'] = $starttime;
			$wheres['createtime<'] = $endtime;
		}
		
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}
		
		$orderlist = Wlfightgroup::getNumOrder('*',$wheres,'ID DESC',$pindex, $psize, 1);
		$pager = $orderlist[1];
		$list = $orderlist[0];
		foreach ($list as $key => &$v) {
			$merchant = pdo_get('wlmerchant_merchantdata',array('id' => $v['sid']),array('storename'));
			$goods = pdo_get('wlmerchant_fightgroup_goods',array('id' => $v['fkid']),array('name','logo','unit'));
			if($v['orderno'] == '666666'){
				if($v['mid']){
					$member = pdo_get('wlmerchant_fightgroup_falsemember',array('id' => $v['mid']),array('nickname','avatar'));
				}else {
					$member = pdo_get('wlmerchant_fightgroup_falsemember',array('id' => 1),array('nickname','avatar'));
				}
			}else {
				$member = pdo_get('wlmerchant_member',array('id' => $v['mid']),array('nickname','avatar','mobile'));
			}			
			$group = pdo_get('wlmerchant_fightgroup_group',array('id' => $v['fightgroupid']),array('status'));
			$v['storename'] = $merchant['storename'];
			$v['name'] = $goods['name'];
			$v['logo'] = $goods['logo'];
			$v['unit'] = $goods['unit'];
			$v['nickname'] = $member['nickname'];
			$v['avatar'] = $member['avatar'];
			if($member['mobile']){
				$v['mobile'] = $member['mobile'];
			}else {
				$v['mobile'] = '暂无';
			}
			$v['groupstatus'] = $group['status'];
			if($v['recordid']){
				$v['qrcode'] = pdo_getcolumn(PDO_NAME.'fightgroup_userecord',array('id'=>$v['recordid']),'qrcode');
			}
		}
		if($_GPC['export'] != ''){
			$this->export($wheres);
		}

		include wl_template('ptorder/orderlist');
	}
	//订单详情
	function orderdeail(){
		global $_W, $_GPC;
		$id = $_GPC['id'];
		$item = pdo_get('wlmerchant_order',array('id' => $id));
		switch ($item['status']) {
			case '1':
				$item['statusName'] = '已支付';
				break;
			case '2':
				$item['statusName'] = '已消费';
				break;
			case '8':
				$item['statusName'] = '待发货';
				break;
			case '4':
				if($item['expressid']){
					$item['statusName'] = '待收货';
				}else {
					$item['statusName'] = '待消费';
				}
				break;
			case '5':
			$item['statusName'] = '已取消';
			break;
			case '6':
				$item['statusName'] = '待退款';
				break;
			case '7':
				$item['statusName'] = '已退款';
				break;				
			default:
				$item['statusName'] = '已完成';
				break;
		}
		//商品信息
		$goods = pdo_get('wlmerchant_fightgroup_goods',array('id' => $item['fkid']));
		//团信息
		if($item['fightgroupid']){
			$group = pdo_get('wlmerchant_fightgroup_group',array('id' => $item['fightgroupid']));
		}
		//物流信息
		if($item['expressid']){
			$express = pdo_get('wlmerchant_express',array('id' => $item['expressid']));
		}
		//到店消费信息
		if($item['recordid']){
			$record = pdo_get('wlmerchant_fightgroup_userecord',array('id' => $item['recordid']));
			if($record['usedtime']){
				$record['usedtime'] = unserialize($record['usedtime']);
				foreach ($record['usedtime'] as $key => &$v){
					if($v['type'] == 1){
						$ver = pdo_get('wlmerchant_member',array('id' => $v['ver']),array('nickname'));
						$v['ver'] = $ver['nickname'];
						$v['type'] = '扫码核销';
					}else if($v['type'] == 2){
						$v['type'] = '后台核销';
					}else if($v['type'] == 3){
						$ver = pdo_get('wlmerchant_member',array('id' => $v['ver']),array('nickname'));
						$v['ver'] = $ver['nickname'];
						$v['type'] = '输码核销';
					}else if($v['type'] == 4){
						$v['type'] = '密码核销';
					}
				}
			}
			
		}
		//用户信息
		$member = pdo_get('wlmerchant_member',array('id' => $item['mid']));
		//商户信息
		$merchant = pdo_get('wlmerchant_merchantdata',array('id' => $item['sid']));
		
		include wl_template('ptorder/orderdetail');
	}
	//确认发货
	function confirmsend(){
		global $_W, $_GPC;
		$id = $_GPC['id'];
		$item = pdo_get('wlmerchant_order',array('id' => $id),array('expressid'));
		$data['expressname'] = $_GPC['express'];
		$data['expresssn'] = $_GPC['expresssn'];
		$data['sendtime'] = time();
		$data['orderid'] = $id;
		$res = pdo_update('wlmerchant_express',$data,array('id' => $item['expressid']));
		if($res){
			pdo_update('wlmerchant_order',array('status' => 4),array('id' => $id));
			Message::sendremind($id,'a');
		}		
		header('location:' . web_url('wlfightgroup/fightorder/orderdeail',array('id'=>$id)));
	}
	//确认核销
	function confirmHexiao(){
		global $_W, $_GPC;
		$id = $_GPC['id'];
		$item = pdo_get('wlmerchant_order',array('id' => $id),array('recordid'));
		$record = pdo_get('wlmerchant_fightgroup_userecord',array('id' => $item['recordid']));
		$arr = array();
		if($record['usedtime']){
			$record['usedtime'] = unserialize($record['usedtime']);
			$a = $record['usedtime'];
			for ($i=0; $i < $record['usetimes']; $i++){ 
				$arr['time'] = time();
				$arr['type'] = 2;
				$a[] = $arr;
			}
			$record['usedtime'] = serialize($a);
		}else {
			$a = array();
			for ($i=0; $i < $record['usetimes']; $i++) {
				$arr['time'] = time();
				$arr['type'] = 2;
				$a[] = $arr;
			}
			$record['usedtime'] = serialize($a);
		}
		$data['usetimes'] = 0;
		$data['usedtime'] = $record['usedtime'];
		$res = pdo_update('wlmerchant_fightgroup_userecord',$data,array('id' => $item['recordid']));
		if($res){
			$order = Wlfightgroup::getSingleOrder($id, '*');
			$goodname = pdo_getcolumn('wlmerchant_fightgroup_goods',array('id' => $order['fkid']),'name');
			SingleMerchant::verifRecordAdd($order['aid'], $order['sid'], $order['mid'], 'wlfightgroup', $order['id'],$record['qrcode'],$goodname,3,$record['usetimes']);
			pdo_update('wlmerchant_order',array('status' => 2),array('id' => $id));
		}
		die(json_encode(array('errno'=>2,'message'=>$record['usedtime'],'id'=>$id)));
	}
	//退款
	function refundfight(){
		global $_W, $_GPC;
		$id = $_GPC['id'];
		$res = Wlfightgroup::refund($id);
		if($res['status']){
			wl_message($res['message'],referer(),'success');
		}else {
			wl_message($res['message'],referer(),'error');
		}
	}
	//组团列表	
	function grouplist(){
		global $_W, $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$wheres = array();
		$wheres['uniacid'] = $_W['uniacid'];
		$wheres['aid'] = $_W['aid'];
		$status0 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_fightgroup_group')." WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} ");
		$status1 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_fightgroup_group')." WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 1");
		$status2 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_fightgroup_group')." WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 2");
		$status3 = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_fightgroup_group')." WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND status = 3");
		
		$status = $_GPC['status'];
		if($status){
			$wheres['status'] = $status;
		}
        $keywordtype = $_GPC['keywordtype'];
		if ($keywordtype) {
            $keyword = $_GPC['keyword'];
            switch($keywordtype){
                case 1:
                    $wheres['@goodsid@'] = $keyword;
                    break;
                case 2:
                    $wheres['sid'] = $keyword;
                    break;
                case 3:
                    $params[':name'] = "%{$keyword}%";
                    $goods = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_fightgroup_goods')."WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND name LIKE :name",$params);
                    if($goods){
                        $goodids = "(";
                        foreach ($goods as $key => $v) {
                            if($key == 0){
                                $goodids.= $v['id'];
                            }else{
                                $goodids.= ",".$v['id'];
                            }
                        }
                        $goodids.= ")";
                        $wheres['goodsid#'] = $goodids;
                    }else {
                        $wheres['goodsid#'] = "(0)";
                    }
                    break;
                case 4:
                    $params[':storename'] = "%{$keyword}%";
                    $merchant = pdo_fetchall("SELECT * FROM ".tablename('wlmerchant_merchantdata')."WHERE uniacid = {$_W['uniacid']}  AND storename LIKE :storename",$params);
                    if($merchant){
                        $sids = "(";
                        foreach ($merchant as $key => $v) {
                            if($key == 0){
                                $sids.= $v['id'];
                            }else{
                                $sids.= ",".$v['id'];
                            }
                        }
                        $sids.= ")";
                        $wheres['sid#'] = $sids;
                    }else {
                        $wheres['sid#'] = "(0)";
                    }
                    break;
            }
		}
		if($_GPC['time_limit']){
			$time_limit = $_GPC['time_limit'];
			$starttime = strtotime($_GPC['time_limit']['start']);
			$endtime = strtotime($_GPC['time_limit']['end']) ;
			$wheres['starttime>'] = $starttime;
			$wheres['starttime<'] = $endtime;
		}
		
		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		$orderlist = Wlfightgroup::getNumGroup('*',$wheres,'ID DESC',$pindex, $psize, 1);
		$pager = $orderlist[1];
		$list = $orderlist[0];
		foreach ($list as $key => &$v) {
			$merchant = pdo_get('wlmerchant_merchantdata',array('id' => $v['sid']),array('storename'));
			$goods = pdo_get('wlmerchant_fightgroup_goods',array('id' => $v['goodsid']),array('name','logo'));
			$v['storename'] = $merchant['storename'];
			$v['name'] = $goods['name'];
			$v['logo'] = $goods['logo'];
		}
		include wl_template('ptorder/grouplist');
	}
	//修改备注
	function remark(){
		global $_W,$_GPC;	
		$id = $_GPC['id'];
		$remark = $_GPC['remark'];
		$res = pdo_update('wlmerchant_order',array('remark' => $remark),array('id' => $id));
		if($res){
			die(json_encode(array('errno'=>0,'message'=>$res,'id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>$res,'id'=>$id)));
		}
	}
	//导出订单
	public function export($where){
		if(empty($where)) return FALSE;
		set_time_limit(0);
		$list = Wlfightgroup::getNumOrder("*",$where,'ID DESC',0,0,0);
		$list = $list[0];
		foreach ($list as $key => &$v) {
			$merchant = pdo_get('wlmerchant_merchantdata',array('id' => $v['sid']),array('storename'));
			$goods = pdo_get('wlmerchant_fightgroup_goods',array('id' => $v['fkid']),array('name','logo','unit'));
			$member = pdo_get('wlmerchant_member',array('id' => $v['mid']),array('nickname','avatar','mobile'));
			$group = pdo_get('wlmerchant_fightgroup_group',array('id' => $v['fightgroupid']),array('status'));
			if($v['expressid']){
				$express = pdo_get('wlmerchant_express',array('id' => $v['expressid']),array('expressname','expresssn','name','tel','address'));
				$v['expressname'] = $express['expressname'];
				$v['expresssn'] = $express['expresssn'];
				$v['peoplename'] = $express['name'];
				$v['tel'] = $express['tel'];
				$v['address'] = $express['address'];
			}
			$v['storename'] = $merchant['storename'];
			$v['name'] = $goods['name'];
			$v['unit'] = $goods['unit'];
			$v['nickname'] = $member['nickname'];
			$v['mobile'] = $member['mobile'];
			$v['groupstatus'] = $group['status'];
		}
		/* 输入到CSV文件 */
		$html = "\xEF\xBB\xBF";
		/* 输出表头 */
		$filter = array(
			'orderno' => '订单号',
			'name' => '商品名称',
			'num' => '数量',
			'storename' => '所属商家',
			'nickname' => '买家昵称',
			'mobile' => '买家电话',
			'status' => '订单状态',
			'paytype' => '支付方式',
			'createtime' => '下单时间',
			'paytime' => '支付时间',
			'groupstatus' => '团状态',
			'price' => '实付金额',
			'remark' => '备注',
			'peoplename' => '收货人姓名',
			'tel' => '收货人电话',
			'address' => '收货人地址',
			'expressname' => '物流公司',
			'expresssn' => '快递单号'
		);
		foreach ($filter as $key => $title) {
			$html .= $title . "\t,";
		}
		$html .= "\n";
		foreach ($list as $k => $v) {
			foreach ($filter as $key => $title) {
				if($key == 'status'){
					switch ($v[$key]) {
						case '1':
							$html .= '已支付' . "\t, ";
							break;
						case '2':
							$html .= '已消费' . "\t, ";
							break;
						default:
							$html .= '未支付' . "\t, ";
							break;
					}
				}elseif($key == 'createtime'){
					$html .= date('Y-m-d H:i:s',$v[$key]) . "\t,";
				}elseif($key == 'paytime'){
					if(!empty($v['paytime'])){
						$html .= date('Y-m-d H:i:s',$v[$key]) . "\t, ";
					}else{
						$html .= '未支付' . "\t, ";
					}
				}elseif($key == 'paytype'){
					switch ($v[$key]) {
						case '1':
							$html .= '余额支付' . "\t, ";
							break;
						case '2':
							$html .= '微信支付' . "\t, ";
							break;
						case '3':
							$html .= '支付宝支付' . "\t, ";
							break;
						case '4':
							$html .= '货到付款' . "\t, ";
							break;
						default:
							$html .= '其他或未支付' . "\t, ";
							break;
					}
				}else if($key == 'groupstatus'){
					switch ($v[$key]) {
						case '1':
							$html .= '组团中' . "\t, ";
							break;
						case '2':
							$html .= '组团成功' . "\t, ";
							break;
						default:
							$html .= '组团失败' . "\t, ";
							break;
					}
				}else {
					$html .= $v[$key] . "\t, ";
				}
			}
			$html .= "\n";
		}
		/* 输出CSV文件 */
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=拼团订单.csv");
		echo $html;
		exit();
	}
    //批量发货
    function import(){
    	$file = $_FILES['fileName'];
		$max_size = "2000000";
		$fname = $file['name'];
		$ftype = strtolower(substr(strrchr($fname, '.'), 1));
		$uploadfile = $file['tmp_name'];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (is_uploaded_file($uploadfile)) {
				if ($file['size'] > $max_size) {
					echo "上传文件过大";
					exit ;
				}
				if ($ftype == 'xls'){
					require_once '../framework/library/phpexcel/PHPExcel.php';
					$objReader = PHPExcel_IOFactory::createReader('Excel5');
					$objPHPExcel = $objReader -> load($uploadfile);
					$sheet = $objPHPExcel -> getSheet(0);
					$highestRow = $sheet -> getHighestRow();
					$succ_result = 0;
					$error_result = 0;
					for ($j = 2; $j <= $highestRow; $j++) {
						$orderNo = trim($objPHPExcel -> getActiveSheet() -> getCell("A$j") -> getValue());
						$expressOrder = trim($objPHPExcel -> getActiveSheet() -> getCell("O$j") -> getValue());
						$expressName = trim($objPHPExcel -> getActiveSheet() -> getCell("N$j") -> getValue());
						if (!empty($expressOrder) && !empty($expressName)){
							$order = pdo_get('wlmerchant_order',array('orderno' => $orderNo),array('expressid','id'));
							if($order['expressid']){
								$res = pdo_update('wlmerchant_express',array('expressname' => $expressName,'expresssn' => $expressOrder,'sendtime' => time()),array('id' => $order['expressid']));
								if($res){
									$res2 = pdo_update('wlmerchant_order',array('status' => 4),array('orderno' => $orderNo));
									if($res2){
										$succ_result += 0;
										Message::sendremind($order['id'],'a');
									}else {
										$error_result += 1;
									}
								}else {
									$error_result += 1;
								}
							}
						}else {
							$error_result += 1;
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
				    for ($i = 2; $i < $len_result; $i++) { //循环获取各字段值 
				        $orderNo = trim(iconv('gb2312', 'utf-8', $result[$i][0])); //中文转码 
				        if($orderNo==''){			
				        	continue;
				        }
				        $expressOrder = trim(iconv('gb2312', 'utf-8', $result[$i][14])); 
				        $expressName =trim(iconv('gb2312', 'utf-8', $result[$i][13]));
						if (!empty($expressOrder) && !empty($expressName)){
							$order = pdo_get('wlmerchant_order',array('orderno' => $orderNo),array('expressid','id'));
							if($order['expressid']){
								$res = pdo_update('wlmerchant_express',array('expressname' => $expressName,'expresssn' => $expressOrder,'sendtime' => time()),array('id' => $order['expressid']));
								if($res){
									$res2 = pdo_update('wlmerchant_order',array('status' => 4),array('orderno' => $orderNo));
									if($res2){
										$succ_result += 1;
										Message::sendremind($order['id'],'a');
									}else {
										$error_result += 1;
									}
								}else {
									$error_result += 1;
								}
							}
						}else {
							$error_result += 1;
						}
					}
			   		fclose($handle); //关闭指针 
			   	}else{
					echo "文件后缀格式必须为xls或csv";
					exit ;
				}
			}else{
				echo "文件名不能为空!";
				exit ;
			}	
		}
		wl_message('自动发货操作成功！成功' . $succ_result . '条，失败' .$error_result . '条', referer(), 'success');
    }
	//运费模板列表
	function freightlist(){
		global $_W, $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$wheres = array();
		$wheres['uniacid'] = $_W['uniacid'];
		$wheres['aid'] = $_W['aid'];
		$freightlist = Wlfightgroup::getNumExpress('*',$wheres,'ID DESC',$pindex, $psize, 1);
		$pager = $freightlist[1];
		$list = $freightlist[0];
		
		include wl_template('ptorder/freightlist');
	}
	//新建运费模板
	function creatfreight(){
		global $_W, $_GPC;
		$id = $_GPC['id'];
		if($id){
			$info = pdo_get('wlmerchant_express_template',array('id' => $id));
			$info['expressarray'] = unserialize($info['expressarray']);
		}
		if (checksubmit('submit')){
			
			$data['name'] = htmlspecialchars($_GPC['expressname']);
			$data['defaultnum'] = intval($_GPC['defaultnum']);
			$data['defaultmoney'] = sprintf('%.2f',$_GPC['defaultmoney']);
			$data['defaultnumex'] = intval($_GPC['defaultnumex']);
			$data['defaultmoneyex'] = sprintf('%.2f',$_GPC['defaultmoneyex']);	
			
			if(!empty($_GPC['express']['area']) && is_array($_GPC['express']['area'])){
				foreach($_GPC['express']['area'] as $k=>$v){
					$expressarray[] = array(
						'area'=>$v,
						'num'=> intval($_GPC['express']['num'][$k]),
						'money'=>sprintf('%.2f',$_GPC['express']['money'][$k]),
						'numex'=>intval($_GPC['express']['numex'][$k]),
						'moneyex'=>sprintf('%.2f',$_GPC['express']['moneyex'][$k])
					);
				}
			}
			
			$data['expressarray'] = serialize($expressarray);
			$data['createtime'] = time();
			if($id){
				$res = Wlfightgroup::updateExpress($data,$id);
				if ($res) {
					wl_message('更新运费模板成功', web_url('wlfightgroup/fightorder/freightlist'), 'success');
				} else {
					wl_message('更新运费模板失败', referer(),'error');
				}
			}else {
				$res = Wlfightgroup::saveExpress($data);
				if ($res) {
					wl_message('创建运费模板成功', web_url('wlfightgroup/fightorder/freightlist'), 'success');
				} else {
					wl_message('创建运费模板失败', referer(), 'error');
				}
			}	
		}
		include wl_template('ptorder/creatfreight');
	}
	//删除运费模板
	function deleteExpress(){
		global $_W, $_GPC;
		$id = $_GPC['id'];
		$res = Wlfightgroup::deteleExpress($id);
		if($res){
			die(json_encode(array('errno'=>0,'message'=>$res,'id'=>$id)));
		}else {
			die(json_encode(array('errno'=>2,'message'=>$res,'id'=>$id)));
		}
	}
	//手动成团
	function fishgroup(){
		global $_W, $_GPC;
		$groupid = $_GPC['id'];
		$group = Wlfightgroup::getSingleGroup($groupid,'*');
		$lacknum = $group['lacknum'];
		$falsenum = pdo_fetchcolumn('SELECT count(id) FROM '.tablename('wlmerchant_fightgroup_falsemember')."WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']}");
		if($lacknum < $falsenum){
			$falsemembers = pdo_fetchall("SELECT id FROM ".tablename('wlmerchant_fightgroup_falsemember')."WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} ORDER BY RAND() LIMIT {$lacknum}"); 
			for ($i=0; $i < $lacknum; $i++) { 
				$data = array(
					'uniacid' => $_W['uniacid'], 
					'mid' => $falsemembers[$i]['id'], 
					'aid' => $_W['aid'], 
					'fkid' => $group['goodsid'], 
					'sid' => $group['sid'], 
					'status' => 3, 
					'paytype' => 2, 
					'createtime' => time(), 
					'orderno' => '666666', 
					'price' => 0, 
					'num' => 0,
					'plugin' => 'wlfightgroup', 
					'payfor' => 'fightsharge',
					'spec'=>'',
					'fightstatus'=>1,
					'fightgroupid'=>$groupid,
					'expressid'=>'',
					'buyremark'=>''
					);
				Wlfightgroup::saveFightOrder($data);
			}
			$newdata['lacknum'] = 0;
			$newdata['status'] = 2;
			$newdata['successtime'] = time();
			$orders = pdo_getall('wlmerchant_order',array('fightgroupid' => $group['id'],'uniacid' => $group['uniacid'],'aid' => $group['aid'],'status'=> 1));
			foreach($orders as $key => $or){
				if($or['expressid']){
					pdo_update(PDO_NAME.'order',array('status' => 8), array('id' => $or['id']));
					$member = pdo_get('wlmerchant_member',array('id' => $or['mid']),array('openid'));
					Message::groupresult($member['openid'],$or['fightgroupid'],1);
				}else {
					$recordid = Wlfightgroup::createRecord($or['id'],$or['num']);
					pdo_update(PDO_NAME.'order',array('status' => 1,'recordid' => $recordid), array('id' => $or['id']));
					$member = pdo_get('wlmerchant_member',array('id' => $or['mid']),array('openid'));
					Message::groupresult($member['openid'],$or['fightgroupid'],1);
				}
			}
			$res = pdo_update(PDO_NAME . 'fightgroup_group',$newdata, array('id' => $groupid));
			if($res){
				die(json_encode(array('errno'=>0,'message'=>'ok')));
			}else {
				die(json_encode(array('errno'=>1,'message'=>'未知错误，请重试')));
			}
		}else{
			die(json_encode(array('errno'=>1,'message'=>'虚拟客户过少，请添加')));
		}
	}
}
?>