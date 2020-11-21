<?php 
defined('IN_IA') or exit('Access Denied');
$ops = array('list','send','output','cover','setting','import','delete','confirmsend');
$op = in_array($op, $ops) ? $op : 'list';
wl_load()->model('notice');

if ($op == 'list') {
	$where = " WHERE 1 and uniacid = {$_W['uniacid']} ";
	$params = array();
	$status = intval($_GPC['status']);
	$keyword = trim($_GPC['keyword']);
	$orderstatus = array('5' => array('css' => 'danger', 'name' => '待付款'),'1' => array('css' => 'info', 'name' => '待发货'), '2' => array('css' => 'warning', 'name' => '已发货'), '3' => array('css' => 'success', 'name' => '已收货'),  '4' => array('css' => 'default', 'name' => '已取消'));
	
	if (empty($starttime) || empty($endtime)) {
		$starttime = strtotime('-1 month');
		$endtime = time();
	}
	if (!empty($_GPC['time'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']) ;
		$where .= " AND  createtime >= :starttime AND  createtime <= :endtime ";
		$params[':starttime'] = $starttime;
		$params[':endtime'] = $endtime;
	}
	if (!empty($keyword)) {
		$where .= " AND ordersn LIKE '%{$keyword}%'";
	}
	if (!empty($_GPC['member'])) {
		$where .= " AND (name LIKE '%{$_GPC['member']}%' or mobile LIKE '%{$_GPC['member']}%')";
	}
	if (!empty($status) && $status != 0) {
		$where .= " AND status = :status";
		$params[':status'] = $status;
	}
	
	$size = 10;
	$page = $_GPC['page'];
	$sqlTotal = pdo_sql_select_count_from('weliam_shiftcar_apply') . $where;
	$sqlData = pdo_sql_select_all_from('weliam_shiftcar_apply') . $where . ' ORDER BY `id` DESC ';
	$list = pdo_pagination($sqlTotal, $sqlData, $params, '', $total, $page, $size);
	foreach ($list as $key => $value) {
		$list[$key]['avatar'] = pdo_getcolumn('weliam_shiftcar_member', array('id' => $value['mid']), 'avatar');
		$list[$key]['statuscss'] = $orderstatus[$value['status']]['css'];
		$list[$key]['status'] = $orderstatus[$value['status']]['name'];
	}
	$pager = pagination($total, $page, $size);
	
	if($_GPC['export'] != ''){
		$list = pdo_fetchall("SELECT * FROM ".tablename('weliam_shiftcar_apply'). $where . ' ORDER BY `id` DESC', $params);
		/* 输入到CSV文件 */
		$html = "\xEF\xBB\xBF";
		/* 输出表头 */
		$filter = array(
			'ordersn' => '订单号',
			'name' => '姓名',
			'mobile' => '电话',
			'address' => '地址',
			'status' => '状态',
			'createtime' => '申请时间',
			'express' => '快递名称',
			'expresssn' => '快递单号'
		);

		foreach ($filter as $key => $title) {
			$html .= $title . "\t,";
		}
		$html .= "\n";
		foreach ($list as $k => $v) {
			foreach ($filter as $key => $title) {
				if ($key == 'createtime') {
					$html .= date('Y-m-d H:i:s', $v[$key]) . "\t, ";
				}elseif($key == 'status'){
					switch ($v['status']) {
						case 1:
							$html .= '待发货' . "\t, ";
							break;
						case 2:
							$html .= '待收货' . "\t, ";
							break;
						case 3:
							$html .= '已收货' . "\t, ";
							break;
						default:
							$html .= '已取消' . "\t, ";
							break;
					}
				}elseif($key == 'address'){
					$html .= $v['area'].$v['address']."\t, ";
				}else {
					$html .= $v[$key] . "\t, ";
				}
			}
			$html .= "\n";
		}
		/* 输出CSV文件 */
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=申请挪车卡订单.csv");
		echo $html;
		exit();
	}
	
	$all = pdo_fetchcolumn(pdo_sql_select_count_from('weliam_shiftcar_apply')." WHERE 1 and uniacid = {$_W['uniacid']}");
	$status0 = pdo_fetchcolumn(pdo_sql_select_count_from('weliam_shiftcar_apply')." WHERE 1 and uniacid = {$_W['uniacid']} and status = 5");
	$status1 = pdo_fetchcolumn(pdo_sql_select_count_from('weliam_shiftcar_apply')." WHERE 1 and uniacid = {$_W['uniacid']} and status = 1");
	$status2 = pdo_fetchcolumn(pdo_sql_select_count_from('weliam_shiftcar_apply')." WHERE 1 and uniacid = {$_W['uniacid']} and status = 2");
	$status3 = pdo_fetchcolumn(pdo_sql_select_count_from('weliam_shiftcar_apply')." WHERE 1 and uniacid = {$_W['uniacid']} and status = 3");
	$status4 = pdo_fetchcolumn(pdo_sql_select_count_from('weliam_shiftcar_apply')." WHERE 1 and uniacid = {$_W['uniacid']} and status = 4");
	
	include wl_template('app/apply/apply_list');
}

if ($op == 'send') {
	
	include wl_template('app/apply/apply_import');
}

if ($op == 'setting') {
	wl_load()->model('setting');
	$settings = wlsetting_read('apply');
	if (!empty($settings)) {
		$data = json_decode(str_replace('&quot;', '\'', $settings['data']), true);
	}
	$remark_arr = pdo_fetchall('SELECT distinct remark FROM ' . tablename('weliam_shiftcar_qrcode') . "WHERE uniacid = {$_W['uniacid']} AND sid in(0,-1) ");
	$remark_arr = Util::i_array_column($remark_arr,'remark');
	
	
	if (checksubmit('submit')) {
		$base = array(
			'storestatus'=>intval($_GPC['storestatus']),
			'sendstatus'=>intval($_GPC['sendstatus']),
			'mailstatus'=>intval($_GPC['mailstatus']),
			'times'=>intval($_GPC['times']),
			'postage'=> round($_GPC['postage'],2),
			'nckexplain'=> trim($_GPC['nckexplain']),
			'defaultarea'=> trim($_GPC['defaultarea']),
			'remark'=> trim($_GPC['remark']),
			'data' => htmlspecialchars_decode($_GPC['data']),
			'bg' => $_GPC['bg']
		);
		wlsetting_save($base, 'apply');
		if(!empty($base['remark'])){
			pdo_update('weliam_shiftcar_qrcode',array('sid'=>-1),array('uniacid'=>$_W['uniacid'],'remark'=>$base['remark']));
		}
		message('更新设置成功！', web_url('app/apply/setting'));
	}
	include wl_template('app/apply/apply_setting');
}

if ($op == 'cover') {
	load()->model('reply');
	$url = app_url('app/apply');
	$name = '挪车卡申请';
	
	$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'cover', ':name' => WL_NAME . $name . '入口设置'));
	
	if (!empty($rule)) {
		$keyword = pdo_fetch('select * from ' . tablename('rule_keyword') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
		$cover = pdo_fetch('select * from ' . tablename('cover_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(':uniacid' => $_W['uniacid'], ':rid' => $rule['id']));
	}
	
	if (checksubmit('submit')) {
		$data = (is_array($_GPC['cover']) ? $_GPC['cover'] : array());
	
		if (empty($data['keyword'])) {
			message('请输入关键词!');
		}
		$keyword1 = keyExist($data['keyword']);
		if (!empty($keyword1)) {
			if ($keyword1['name'] != (WL_NAME . $name . '入口设置')) {
				message('关键字已存在!');
			}
		}
		if (!empty($rule)) {
			pdo_delete('rule', array('id' => $rule['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('rule_keyword', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
			pdo_delete('cover_reply', array('rid' => $rule['id'], 'uniacid' => $_W['uniacid']));
		}
	
		$rule_data = array('uniacid' => $_W['uniacid'], 'name' => WL_NAME . $name . '入口设置', 'module' => 'cover', 'displayorder' => 0, 'status' => intval($data['status']));
		pdo_insert('rule', $rule_data);
		$rid = pdo_insertid();
		
		$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'cover', 'content' => trim($data['keyword']), 'type' => 1, 'displayorder' => 0, 'status' => intval($data['status']));
		pdo_insert('rule_keyword', $keyword_data);
		
		$cover_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => WL_NAME, 'title' => trim($data['title']), 'description' => trim($data['desc']), 'thumb' => $data['thumb'], 'url' => $url);
		pdo_insert('cover_reply', $cover_data);
		message('保存成功！');
	}
	
	$cover = array('rule' => $rule, 'cover' => $cover, 'keyword' => $keyword, 'url' => $url,'name' => $name);
	
	include wl_template('setting/cover');
}

if ($op == 'import') {
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
					$expressOrder = trim($objPHPExcel -> getActiveSheet() -> getCell("H$j") -> getValue());
					$expressName = trim($objPHPExcel -> getActiveSheet() -> getCell("G$j") -> getValue());
					if (!empty($expressOrder) && !empty($expressName) && !empty($orderNo)) {
						$res = pdo_update('weliam_shiftcar_apply', array('status' => 2, 'express' => $expressName, 'expresssn' => $expressOrder,'sendtime'=>TIMESTAMP), array('ordersn' => $orderNo));
						if ($res) {
							$mid = pdo_getcolumn('weliam_shiftcar_apply', array('ordersn' => $orderNo),'mid');
							$openid = pdo_getcolumn('weliam_shiftcar_member', array('id' => $mid),'openid');
							delivery_notice($openid,$orderNo,$expressName,$expressOrder);
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
			        if($orderNo == ''){			
			        	continue;
			        }
			        $expressOrder = trim(iconv('gb2312', 'utf-8', $result[$i][7])); 
			        $expressName =trim(iconv('gb2312', 'utf-8', $result[$i][6]));
				
					if (!empty($expressOrder) && !empty($expressName) && !empty($orderNo)) {
						$res = pdo_update('weliam_shiftcar_apply', array('status' => 2, 'express' => $expressName, 'expresssn' => $expressOrder,'sendtime'=>TIMESTAMP), array('ordersn' => $orderNo));
						if ($res) {
							$mid = pdo_getcolumn('weliam_shiftcar_apply', array('ordersn' => $orderNo),'mid');
							$openid = pdo_getcolumn('weliam_shiftcar_member', array('id' => $mid),'openid');
							delivery_notice($openid,$orderNo,$expressName,$expressOrder);
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
}

if($op == 'delete'){
	if(!empty($_GPC['id'])){
		$id = $_GPC['id'];
		$data = pdo_fetch("SELECT * FROM " . tablename('weliam_shiftcar_apply') . " WHERE id = :id", array(':id' => $id));
		$data = serialize($data);
		$result = pdo_delete('weliam_shiftcar_apply', array('id' => $id));
		if($result){
			oplog('admin',"删除订单",web_url('app/apply/delete'), $data);
			die(json_encode(array('errno'=>0)));
		} else {
			die(json_encode(array('errno'=>1)));
		}	
	}else {
		$ids = $_GPC['ids'];
		foreach($ids as $key=>$value){
			$data = pdo_fetch("SELECT * FROM " . tablename('weliam_shiftcar_apply') . " WHERE id = :id", array(':id' => $value));
			$data = serialize($data);
			$result = pdo_delete('weliam_shiftcar_apply', array('id' => $value));
			if($result){
				oplog('admin',"删除订单",web_url('app/apply/delete'), $data);
			}
		} 
		die(json_encode(array('errno'=>0)));
	}
}	

if($op == 'confirmsend'){
	$id = $_GPC['id'];
	$express = $_GPC['express'];
	$expresssn = $_GPC['expresssn'];
	if (!empty($id)) {
		$res = pdo_update('weliam_shiftcar_apply', array('status' => 2, 'express' => $express, 'expresssn' => $expresssn,'sendtime'=>TIMESTAMP), array('id' => $id));
		if ($res) {
			$mid = pdo_get('weliam_shiftcar_apply', array('id' => $id),array('mid','ordersn'));
			$openid = pdo_getcolumn('weliam_shiftcar_member', array('id' => $mid['mid']),'openid');
			delivery_notice($openid,$mid['ordersn'],$express,$expresssn);
			message('发货成功');
		} else {
			message('发货失败');
		}
	} else {
		message('缺少参数，请重试！');
	}
}
