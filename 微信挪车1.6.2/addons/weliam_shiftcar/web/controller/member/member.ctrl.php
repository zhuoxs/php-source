<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('display','detail','ajax','summary','blacklist');
$op = in_array($op, $ops) ? $op : 'display';
wl_load()->model('mc');

if ($op == 'display') {
	$where = " WHERE 1 and uniacid = {$_W['uniacid']} ";
	$params = array();
	$type = intval($_GPC['type']);
	$keyword = trim($_GPC['keyword']);

	if (!empty($keyword)) {
		switch($type) {
			case 2 :
				$where .= " AND mobile LIKE :mobile";
				$params[':mobile'] = "%{$keyword}%";
				break;
			case 3 :
				$where .= " AND nickname LIKE :nickname";
				$params[':nickname'] = "%{$keyword}%";
				break;
			case 5 :
				$where .= " AND plate_number LIKE :plate_number";
				$params[':plate_number'] = "%{$keyword}%";
				break;
			default :
				$where .= " AND ncnumber LIKE :ncnumber";
				$params[':ncnumber'] = "%{$keyword}%";
		}
	}
	if (!empty($_GPC['status']) && $_GPC['status'] != -1) {
		$where .= " AND status = :status";
		$params[':status'] = $_GPC['status'];
	}
	
	if($_GPC['export'] != ''){
		set_time_limit(0);
		$list = pdo_fetchall("SELECT * FROM ".tablename('weliam_shiftcar_member'). $where . ' ORDER BY `id` DESC', $params);
		/* 输入到CSV文件 */
		$html = "\xEF\xBB\xBF";
		/* 输出表头 */
		$filter = array(
			'nickname' => '昵称',
			'status' => '用户类型',
			'mobile' => '手机号',
			'ncnumber' => '挪车卡编号',
			'plate_number' => '车牌号',
			'engine_number' => '发动机号',
			'frame_number' => '车架号',
			'brand' => '车辆品牌',
			'createtime' => '注册时间'
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
					switch ($v[$key]) {
						case '1':
							$html .= '粉丝' . "\t, ";
							break;
						default:
							$html .= '车主' . "\t, ";
							break;
					}
				}elseif($key == 'plate_number'){
					$html .= $v['plate1']. $v['plate2'] . $v['plate_number'] . "\t, ";
				}else {
					$html .= $v[$key] . "\t, ";
				}
			}
			$html .= "\n";
		}
		/* 输出CSV文件 */
		header("Content-type:text/csv");
		header("Content-Disposition:attachment; filename=会员数据.csv");
		echo $html;
		exit();
	}
	
	$size = 15;
	$page = $_GPC['page'];
	$sqlTotal = pdo_sql_select_count_from('weliam_shiftcar_member') . $where;
	$sqlData = pdo_sql_select_all_from('weliam_shiftcar_member') . $where . ' ORDER BY `id` DESC ';
	$list = pdo_pagination($sqlTotal, $sqlData, $params, '', $total, $page, $size);
	foreach ($list as $key => $value) {
		$list[$key]['fanid'] = pdo_getcolumn('mc_mapping_fans', array('openid' => $value['openid']), 'fanid');
		if($value['ncnumber']){
			$qrid = pdo_get('weliam_shiftcar_qrcode', array('cardsn' => $value['ncnumber'],'uniacid'=> $_W['uniacid']), array('qrid','model','salt'));
			if ($qrid['model'] == 2) {
				$ticket = pdo_getcolumn('qrcode', array('id' => $qrid['qrid']), 'ticket');
				$list[$key]['showurl'] = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);
			}
			if($qrid['model'] == 3) {
				$list[$key]['showurl'] = app_url('qr/qrcode/show',array('ncnumber' => $value['ncnumber'],'salt' => $qrid['salt']));
			}
		}
	}
	$pager = pagination($total, $page, $size);
}

if ($op == 'detail') {
	$mid = intval($_GPC['id']);
	$member = wl_mem_single($mid);
	$where = " WHERE 1 and uniacid = {$_W['uniacid']} AND (sendmid = {$mid} or takemid = {$mid})";
	$params = array();

	$size = 15;
	$page = $_GPC['page'];
	$sqlTotal = pdo_sql_select_count_from('weliam_shiftcar_record') . $where;
	$sqlData = pdo_sql_select_all_from('weliam_shiftcar_record') . $where . ' ORDER BY `id` DESC ';
	$list = pdo_pagination($sqlTotal, $sqlData, $params, '', $total, $page, $size);
	foreach ($list as $key => $value) {
		$send_member = pdo_get('weliam_shiftcar_member', array('id' => $value['sendmid']), array('avatar','nickname'));
		$take_member = pdo_get('weliam_shiftcar_member', array('id' => $value['takemid']), array('avatar','nickname','plate1','plate2','plate_number'));
		$list[$key]['favatar'] = $send_member['avatar'];
		$list[$key]['fnickname'] = $send_member['nickname'];
		$list[$key]['javatar'] = $take_member['avatar'];
		$list[$key]['jnickname'] = $take_member['nickname'];
		$list[$key]['carcard'] = $take_member['plate1'].$take_member['plate2'].$take_member['plate_number'];
	}
	$pager = pagination($total, $page, $size);
}

if($op == 'blacklist'){
	$id = intval($_GPC['id']);
	$type = $_GPC['type'];
	if($type == 'add'){
		pdo_update('weliam_shiftcar_member',array('userstatus' => -1),array('id' => $id));
		message('加入黑名单成功',web_url('member/member/display'),'success');
	}
	if($type == 'out'){
		pdo_update('weliam_shiftcar_member',array('userstatus' => 1),array('id' => $id));
		message('解除黑名单成功',web_url('member/member/display'),'success');
	}
}

if ($op == 'summary') {
	//会员统计
	$today = strtotime(date('Ymd'));
	$yestoday = $today - 86400;
	$lastweek = $today - 604800;
	$newfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime >= {$today}");
	$yes_newfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime < {$today} and createtime > {$yestoday}");
	$week_newfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime < {$today} and createtime > {$lastweek}");
	$allfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}'");
	$newchezhu = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime >= {$today} and status = 2");
	$yes_newchezhu = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime < {$today} and createtime > {$yestoday} and status = 2");
	$week_newchezhu = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime < {$today} and createtime > {$lastweek} and status = 2");
	$allchezhu = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and status = 2");
	
	//饼状图统计
	$mannum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and gender = 1");
	$womannum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and gender = 2");
	$nonenum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and gender = 0");
	$chezhunum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and status = 2");
	$fansnum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_member') . " WHERE uniacid = '{$_W['uniacid']}' and status = 1");
	//地图
	$allnum = pdo_fetchall('SELECT province FROM ' . tablename('weliam_shiftcar_member') . "  WHERE   uniacid={$_W['uniacid']}");
	$address_arr['beijing']=0;
	$address_arr['tianjing']=0;
	$address_arr['shanghai']=0;
	$address_arr['chongqing']=0;
	$address_arr['hebei']=0;
	$address_arr['yunnan']=0;
	$address_arr['liaoning']=0;
	$address_arr['heilongjiang']=0;
	$address_arr['hunan']=0;
	$address_arr['anhui']=0;
	$address_arr['shandong']=0;
	$address_arr['xingjiang']=0;
	$address_arr['jiangshu']=0;
	$address_arr['zhejiang']=0;
	$address_arr['jiangxi']=0;
	$address_arr['hubei']=0;
	$address_arr['guangxi']=0;
	$address_arr['ganshu']=0;
	$address_arr['shanxi']=0;
	$address_arr['neimenggu']=0;
	$address_arr['sanxi']=0;
	$address_arr['jiling']=0;
	$address_arr['fujian']=0;
	$address_arr['guizhou']=0;
	$address_arr['guangdong']=0;
	$address_arr['qinghai']=0;
	$address_arr['xizhang']=0;
	$address_arr['shichuan']=0;
	$address_arr['ningxia']=0;
	$address_arr['hainan']=0;
	foreach($allnum as$key=>$value){
		$address_name = mb_strcut($value['province'], 0, 6, 'utf-8'); 
		switch($address_name){
			case '北京':$address_arr['beijing'] += 1;break;
			case '天津':$address_arr['tianjing']+= 1;break;
			case '上海':$address_arr['shanghai']+= 1;break;
			case '重庆':$address_arr['chongqing']+= 1;break;
			case '河北':$address_arr['hebei']+= 1;break;
			case '河南':$address_arr['henan']+= 1;break;
			case '云南':$address_arr['yunnan']+= 1;break;
			case '辽宁':$address_arr['liaoning']+= 1;break;
			case '黑龙':$address_arr['heilongjiang']+= 1;break;
			case '湖南':$address_arr['hunan']+= 1;break;
			case '安徽':$address_arr['anhui']+= 1;break;
			case '山东':$address_arr['shandong']+= 1;break;
			case '新疆':$address_arr['xingjiang']+= 1;break;
			case '江苏':$address_arr['jiangshu']+= 1;break;
			case '浙江':$address_arr['zhejiang']+= 1;break;
			case '江西':$address_arr['jiangxi']+= 1;break;
			case '湖北':$address_arr['hubei']+= 1;break;
			case '广西':$address_arr['guangxi']+= 1;break;
			case '甘肃':$address_arr['ganshu']+= 1;break;
			case '山西':$address_arr['shanxi']+= 1;break;
			case '内蒙':$address_arr['neimenggu']+= 1;break;
			case '陕西':$address_arr['sanxi']+= 1;break;
			case '吉林':$address_arr['jiling']+= 1;break;
			case '福建':$address_arr['fujian']+= 1;break;
			case '贵州':$address_arr['guizhou']+= 1;break;
			case '广东':$address_arr['guangdong']+= 1;break;
			case '青海':$address_arr['qinghai']+= 1;break;
			case '西藏':$address_arr['xizhang']+= 1;break;
			case '四川':$address_arr['shichuan']+= 1;break;
			case '宁夏':$address_arr['ningxia']+= 1;break;
			case '海南':$address_arr['hainan']+= 1;break;
		}
	}
	$maxnum = max($address_arr['beijing'],
					$address_arr['tianjing'],
					$address_arr['shanghai'],
					$address_arr['chongqing'],
					$address_arr['hebei'],
					$address_arr['henan'],
					$address_arr['yunnan'],
					$address_arr['liaoning'],
					$address_arr['heilongjiang'],
					$address_arr['hunan'],
					$address_arr['anhui'],
					$address_arr['shandong'],
					$address_arr['xingjiang'],
					$address_arr['jiangshu'],
					$address_arr['zhejiang'],
					$address_arr['jiangxi'],
					$address_arr['hubei'],
					$address_arr['guangxi'],
					$address_arr['ganshu'],
					$address_arr['shanxi'],
					$address_arr['neimenggu'],
					$address_arr['sanxi'],
					$address_arr['jiling'],
					$address_arr['fujian'],
					$address_arr['guizhou'],
					$address_arr['guangdong'],
					$address_arr['qinghai'],
					$address_arr['xizhang'],
					$address_arr['shichuan'],
					$address_arr['ningxia'],
					$address_arr['hainan']
		)+5;
}

include wl_template('member/member');
