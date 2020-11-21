<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('display', 'post', 'list', 'del', 'delsata', 'extend', 'SubDisplay', 'get', 'summary', 'dosalt', 'remark', 'cardmode');
$op = !empty($_GPC['op']) && in_array($_GPC['op'], $ops) ? $_GPC['op'] : 'list';
load()->model('account');
wl_load()->model('qr');
wl_load()->model('setting');

if ($op == 'summary') {
	$wheresql = "uniacid = '{$_W['uniacid']}'";
	if (!empty($_W['caraid'])) {
		$wheresql .= " AND aid = {$_W['caraid']} ";
	}
	
	//饼状图1
	$usednum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_qrcode') . " WHERE ".$wheresql." and status = 2");
	$invalidnum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_qrcode') . " WHERE ".$wheresql." and status = 3");
	$notusenum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_qrcode') . " WHERE ".$wheresql." and status = 1");
	//饼状图2
	$remark_arr = pdo_fetchall('SELECT distinct remark FROM ' . tablename('weliam_shiftcar_qrcode') . "WHERE ".$wheresql);
	$remark_arr = Util::i_array_column($remark_arr,'remark');
	
	//柱状图
	foreach ($remark_arr as $key => $item) {
		$arr2[] = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_qrcode') . " WHERE ".$wheresql." and remark = '{$item}' ");
		$arr3[] = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename('weliam_shiftcar_qrcode') . " WHERE ".$wheresql." and remark = '{$item}' and status = 2 ");
	}
	
	//将数据转化为json格式 让插件读入
	$data = json_encode($remark_arr);
	for ($i=0; $i < count($remark_arr); $i++) {
		$data2[$i]['value'] = $arr2[$i];
		$data2[$i]['name'] = $remark_arr[$i];
	}

	$data2 = json_encode($data2);
	$arr2 = json_encode($arr2);
	$arr3 = json_encode($arr3);
	include wl_template('card/qr-summary');
}

if($op == 'list') {
	$settings = wlsetting_read('qrset');
	$digit = !empty($settings['digit']) ? $settings['digit'] : 7;
	$_W['page']['title'] = '管理二维码 - 二维码管理 - 高级功能';
	$wheresql = " WHERE uniacid = :uniacid";
	$param = array(':uniacid' => $_W['uniacid']);
	$keyword = trim($_GPC['keyword']);
	if(!empty($keyword)) {
		$wheresql .= " AND (cardsn LIKE '%{$keyword}%' or remark LIKE '%{$keyword}%') ";
	}
	$starttime = empty($_GPC['time']['start']) ? TIMESTAMP -  86399 * 30 : strtotime($_GPC['time']['start']);
	$endtime = empty($_GPC['time']['end']) ? TIMESTAMP: strtotime($_GPC['time']['end']);
	if(!empty($_GPC['time']['start'])) {
		$wheresql .= " AND createtime >= '{$starttime}' AND createtime <= '{$endtime}'";
	}
	if (!empty($_GPC['status'])) {
		$wheresql .= " AND status = {$_GPC['status']}";
	}
	if (!empty($_GPC['model']) && $_GPC['model'] != -1) {
		$wheresql .= " AND model = {$_GPC['model']}";
	}
	if (!empty($_W['caraid'])) {
		$wheresql .= " AND aid = {$_W['caraid']}";
	}
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall("SELECT * FROM ".tablename('weliam_shiftcar_qrcode'). $wheresql . ' ORDER BY `id` DESC LIMIT '.($pindex - 1) * $psize.','. $psize, $param);
	if (!empty($list)) {
		foreach ($list as $index => &$qrcode) {
			$qrcode['agentname'] = $qrcode['aid'] ? pdo_getcolumn(PDO_NAME.'agentusers', array('id' => $qrcode['aid']), 'agentname') : '系统管理员';
			$wq_qr = pdo_get('qrcode', array('id' => $qrcode['qrid']), array('ticket', 'scene_str', 'qrcid', 'id','createtime'));
			$qrcode['scene_str'] = $wq_qr['scene_str'];
			$qrcode['qrcid'] = $wq_qr['qrcid'];
			$qrcode['endtime'] = $wq_qr['createtime'] + 2592000;
			
			if ($qrcode['model'] == 2) {
				$qrcode['showurl'] = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($wq_qr['ticket']);
				$qrcode['modellabel']="含参";
				$qrcode['endtime'] = '<font color="green">永不</font>';
			} elseif($qrcode['model'] == 3) {
				$qrcode['showurl'] = app_url('qr/qrcode/show',array('ncnumber' => $qrcode['cardsn'],'salt' => $qrcode['salt']));
				$qrcode['modellabel']="智能";
				$qrcode['endtime'] = '<font color="green">永不</font>';
			}else{
				$qrcode['modellabel']="临时";
				$qrcode['showurl'] = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($wq_qr['ticket']);
				if (TIMESTAMP > $qrcode['endtime']) {
					$qrcode['endtime'] = '<font color="red">已过期</font>';
				}else{
					$qrcode['endtime'] = date('Y-m-d H:i:s',$qrcode['endtime']);
				}
			}
			
			if ($qrcode['mid']) {
				$member = pdo_get('weliam_shiftcar_member', array('id' => $qrcode['mid']), array('plate1', 'plate2', 'plate_number'));
				$qrcode['plate_number'] = $member['plate1']. $member['plate2'] . $member['plate_number'];
			}
		}
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('weliam_shiftcar_qrcode') . $wheresql, $param);
	$pager = pagination($total, $pindex, $psize);
	pdo_query("UPDATE ".tablename('qrcode')." SET status = '0' WHERE uniacid = '{$_W['uniacid']}' AND model = '1' AND createtime < '{$_W['timestamp']}' - expire");
	
	if($_GPC['export'] != ''){
		set_time_limit(0);
		$list = pdo_fetchall("SELECT * FROM ".tablename('weliam_shiftcar_qrcode'). $wheresql . ' ORDER BY `id` DESC', $param);
		/* 输出表头 */
		$filter = array(
			'showurl' => '二维码',
			'cardsn' => '挪车卡编号',
			'memid' => '用户码',
			'status' => '使用状态',
			'model' => '二维码类型',
			'qrcid' => '场景ID',
			'createtime' => '生成时间'
		);
		$data = array();
		foreach ($list as $k => $v) {
			$wq_qr = pdo_get('qrcode', array('id' => $v['qrid']), array('ticket', 'scene_str', 'model', 'id','url'));
			$v['scene_str'] = $wq_qr['scene_str'];
			if($wq_qr['model'] == 3){
				$str1 = substr($wq_qr['url'],0,15);
				if($str1 == 'http://w.url.cn'){
					$v['showurl'] = $wq_qr['url'];
				}else{
					$v['showurl'] = app_url('qr/qrcode',array('ncnumber' => $v['cardsn'],'salt' => $v['salt']));
				}
			}else{
				$v['showurl'] = $wq_qr['url'];
			}
			foreach ($filter as $key => $title) {
				if ($key == 'createtime') {
					$data[$k][$key] = date('Y-m-d H:i:s', $v[$key]);
				}elseif($key == 'status'){
					switch ($v[$key]) {
						case '1':
							$data[$k][$key] = '未绑定';
							break;
						case '2':
							$data[$k][$key] = '已绑定';
							break;
						default:
							$data[$k][$key] = '已失效';
							break;
					}
				}elseif($key == 'model'){
					switch ($v[$key]) {
						case '1':
							$data[$k][$key] = '临时';
							break;
						case '2':
							$data[$k][$key] = '含参';
							break;
						default:
							$data[$k][$key] = '智能';
							break;
					}
				}elseif($key == 'qrcid'){
					if(!empty($v['qrcid'])){
						$data[$k][$key] = $v['qrcid'];
					}else{
						$data[$k][$key] = $v['scene_str'];
					}
				}elseif($key == 'memid'){
					$data[$k][$key] = substr($v['cardsn'],-$digit);
				}else {
					$data[$k][$key] = $v[$key];
				}
			}
		}
		util_csv::export_csv_2($data, $filter, '全部数据.csv');
		exit();
	}
	include wl_template('card/qr-list');
}

if($op == 'del') {
	if ($_GPC['scgq']) {
		$list = pdo_fetchall("SELECT id FROM ".tablename('qrcode')." WHERE uniacid = :uniacid AND acid = :acid AND status = '0' AND type='scene'", array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid']), 'id');
		if (!empty($list)) {
			pdo_query("DELETE FROM ".tablename('qrcode')." WHERE id IN (".implode(',', array_keys($list)).")");
			pdo_query("DELETE FROM ".tablename('qrcode_stat')." WHERE qid IN (".implode(',', array_keys($list)).")");
		}
		message('执行成功<br />删除二维码：'.count($list), web_url('card/qr/list'),'success');
	}else{
		$id = $_GPC['id'];
		pdo_delete('qrcode', array('id' =>$id, 'uniacid' => $_W['uniacid']));
		pdo_delete('qrcode_stat',array('qid' => $id, 'uniacid' => $_W['uniacid']));
		message('删除成功',web_url('card/qr/list'),'success');
	}
}

if($op == 'post') {
	$_W['page']['title'] = '生成二维码 - 二维码管理 - 高级功能';
	if(checksubmit('submit')){
		qr_createkeywords();
		$qrctype = intval($_GPC['qrc-model']);
		$allnum = intval($_GPC['qr_num']);
		$storeid = intval($_GPC['storeid']);
		$caraid = intval($_GPC['caraid']);
		include wl_template('card/qr-process');
		exit;
	}
	if(pdo_tableexists('wlmerchant_merchantdata')){
		$remark_arr = pdo_getall('wlmerchant_merchantdata',array('uniacid'=>$_W['uniacid']),array('id','storename'));
	}
	if (p('caragent')) {
		$allagent = pdo_getall(PDO_NAME.'agentusers',array('uniacid'=>$_W['uniacid']),array('id','agentname'));
	}
	include wl_template('card/qr-post');
}

if($op == 'get') {
	load()->func('communication');
	$barcode = array(
		'expire_seconds' => '',
		'action_name' => '',
		'action_info' => array(
			'scene' => array(),
		),
	);
	$qrctype = intval($_GPC['qrc-model']);
	$storeid = intval($_GPC['storeid']);
	$caraid = intval($_GPC['caraid']);
	$acid = intval($_W['acid']);
	$qrcid = pdo_fetchcolumn("SELECT COUNT(id) FROM ".tablename('weliam_shiftcar_qrcode')." WHERE uniacid = :uniacid AND model in(2,3) ", array(':uniacid' => $_W['uniacid']));
	$sstr = !empty($qrcid) ? ($qrcid + 1) : 1;
	
	if ($qrctype == 3) {
		$scene_str = 'PT'.$sstr;
		$is_exist = pdo_fetchcolumn('SELECT id FROM ' . tablename('qrcode') . ' WHERE uniacid = :uniacid AND acid = :acid AND scene_str = :scene_str AND model = 3', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid'], ':scene_str' => $scene_str));
		if(!empty($is_exist)) {
			$scene_str = 'PT'.date('md').substr(time(), -5).substr(microtime(), 2, 5).sprintf('%02d', rand(0, 99));
		}
		$barcode['action_info']['scene']['scene_str'] = $scene_str;
		$result['url'] = app_url('qr/qrcode',array('ncnumber' => 'NC'.$addressid.sprintf("%07d",$sstr)));
	} else if ($qrctype == 2) {
		$uniacccount = WeAccount::create($acid);
		$scene_str = 'YJ'.$sstr;
		$is_exist = pdo_fetchcolumn('SELECT id FROM ' . tablename('qrcode') . ' WHERE uniacid = :uniacid AND acid = :acid AND scene_str = :scene_str AND model = 2', array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid'], ':scene_str' => $scene_str));
		if(!empty($is_exist)) {
			$scene_str = 'YJ'.date('md').substr(time(), -5).substr(microtime(), 2, 5).sprintf('%02d', rand(0, 99));
		}
		$barcode['action_info']['scene']['scene_str'] = $scene_str;
		$barcode['action_name'] = 'QR_LIMIT_STR_SCENE';
		$result = $uniacccount->barCodeCreateFixed($barcode);
	}
	
	if(!is_error($result)) {
		$insert = array(
			'uniacid' => $_W['uniacid'],
			'acid' => $acid,
			'qrcid' => $barcode['action_info']['scene']['scene_id'],
			'scene_str' => $barcode['action_info']['scene']['scene_str'],
			'keyword' => 'weliam_shiftcar_qr',
			'name' => '微信挪车卡',
			'model' => $qrctype,
			'ticket' => $result['ticket'],
			'url' => $result['url'],
			'expire' => $result['expire_seconds'],
			'createtime' => TIMESTAMP,
			'status' => '1',
			'type' => 'scene',
		);
		pdo_insert('qrcode', $insert);
		$qrid = pdo_insertid();
		$qrinsert = array(
			'uniacid' => $_W['uniacid'],
			'qrid' => $qrid,
			'model' => $qrctype,
			'aid' => $caraid,
			'sid' => $storeid,
			'cardsn' => 'NC'.$addressid.sprintf("%07d",$sstr),
			'salt' => random(8),
			'createtime' => TIMESTAMP,
			'status' => '1',
			'remark' => $_GPC['remark']
		);
		pdo_insert('weliam_shiftcar_qrcode', $qrinsert);
		die(json_encode(array('result' => 1)));
	} else {
		$success = "公众平台返回接口错误. <br />错误代码为: {$result['errorcode']} <br />错误信息为: {$result['message']}";
		die(json_encode(array('result' => 2,'message' => $success)));
	}
}

if($op == 'extend') {
	load()->func('communication');
	$id = intval($_GPC['id']);
	if (!empty($id)) {
		$qrcrow = pdo_fetch("SELECT * FROM ".tablename('qrcode')." WHERE uniacid = :uniacid AND id = :id LIMIT 1", array(':uniacid' => $_W['uniacid'], ':id' => $id));
		$update = array();
		if ($qrcrow['model'] == 1) {
			$uniacccount = WeAccount::create($qrcrow['acid']);
			$barcode['action_info']['scene']['scene_id'] = $qrcrow['qrcid'];
			$barcode['expire_seconds'] = 2592000;
			$barcode['action_name'] = 'QR_SCENE';
			$result = $uniacccount->barCodeCreateDisposable($barcode);
			if(is_error($result)) {
				message($result['message'], '', 'error');
			}
			$update['ticket'] = $result['ticket'];
			$update['url'] = $result['url'];
			$update['expire'] = $result['expire_seconds'];
			$update['createtime'] = TIMESTAMP;
			pdo_update('qrcode', $update, array('id' => $id, 'uniacid' => $_W['uniacid']));
		}
		message('恭喜，延长临时二维码时间成功！', referer(), 'success');
	}
}

if($op == 'display') {
	$starttime = empty($_GPC['time']['start']) ? TIMESTAMP -  86399 * 30 : strtotime($_GPC['time']['start']);
	$endtime = empty($_GPC['time']['end']) ? TIMESTAMP + 6*86400: strtotime($_GPC['time']['end']) + 86399;
	$where .= " WHERE name = '微信挪车卡' AND uniacid = :uniacid AND acid = :acid AND createtime >= :starttime AND createtime < :endtime";
	$param = array(':uniacid' => $_W['uniacid'], ':acid' => $_W['acid'], ':starttime' => $starttime, ':endtime' => $endtime);
	!empty($_GPC['keyword']) && $where .= " AND name LIKE '%{$_GPC['keyword']}%'";
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$count = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('qrcode_stat'). $where, $param);
	$list = pdo_fetchall("SELECT * FROM ".tablename('qrcode_stat')." $where ORDER BY id DESC LIMIT ".($pindex - 1) * $psize.','. $psize, $param);
	if (!empty($list)) {
		$openid = array();
		foreach ($list as $index => &$qrcode) {
			if ($qrcode['type'] == 1) {
				$qrcode['type']='<span class="label label-danger">关注</span>';
			} else {
				$qrcode['type']='<span class="label label-primary">扫描</span>';
			}
			if(!in_array($qrcode['openid'], $openid)) {
				$openid[] = $qrcode['openid'];
			}
			$list[$index]['mid'] = pdo_getcolumn('weliam_shiftcar_member', array('openid' => $qrcode['openid'],'uniacid' => $_W['uniacid']), 'id');
			$list[$index]['cardsn'] = pdo_getcolumn('weliam_shiftcar_qrcode', array('qrid' => $qrcode['qid']), 'cardsn');
		}
		$openids = implode("','", $openid);
		$param_temp[':uniacid'] = $_W['uniacid'];
		$param_temp[':acid'] = $_W['acid'];
		$nickname = pdo_fetchall('SELECT nickname, openid FROM ' . tablename('mc_mapping_fans') . " WHERE uniacid = :uniacid AND acid = :acid AND openid IN ('{$openids}')", $param_temp, 'openid');
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('qrcode_stat') . $where, $param);
	$pager = pagination($total, $pindex, $psize);
	include wl_template('card/qr-display');
}

if($op == 'delsata') {
	$id = $_GPC['id'];
	$b = pdo_delete('qrcode_stat',array('id' =>$id, 'uniacid' => $_W['uniacid']));
	if ($b){
		message('删除成功',web_url('card/qr/display'),'success');
	}else{
		message('删除失败',web_url('card/qr/display'),'error');
	}
}

if($op == 'dosalt') {
	if($_W['ispost']){
		$qrcode = pdo_fetch('SELECT id FROM ' . tablename('weliam_shiftcar_qrcode') . " WHERE uniacid = {$_W['uniacid']} AND salt is NULL ");
		$data = array('salt' => random(8));
		pdo_update('weliam_shiftcar_qrcode',$data,array('id' => $qrcode['id']));
		die(json_encode(array('result' => 1)));
	}
	$allnum = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('weliam_shiftcar_qrcode') . " WHERE uniacid = {$_W['uniacid']} AND salt is NULL ");
	if(empty($allnum)){
		message('恭喜您，没有需要进行加密处理的挪车卡！',web_url('card/qr/list'),'success');
	}
	include wl_template('card/qr-dosalt');
	exit;
}

if($op == 'remark') {
	if(checksubmit('submit')){
		$remark = $_GPC['remark'];
		$qr_num = $_GPC['qr_num'];
		$cardnumber = explode(',', $qr_num);
		if($cardnumber[0] > $cardnumber[1] || empty($cardnumber[1])){
			message('挪车卡范围错误请重新填写', referer(), 'warning');
		}
		$addressid = pdo_getcolumn('weliam_shiftcar_wechataddr',array('acid' => $_W['acid']),'addressid');
		for ($i = $cardnumber[0]; $i <= $cardnumber[1]; $i++) { 
			$movecode = 'NC'.$addressid.sprintf("%07d",$i);
			pdo_update('weliam_shiftcar_qrcode',array('remark'=>$remark),array('uniacid'=>$_W['uniacid'],'cardsn'=>$movecode));
		}
		message('挪车卡备注修改成功',web_url('card/qr/remark'),'success');
	}
	include wl_template('card/qr-remark');
	exit;
}

if($op == 'cardmode') {
	$id = intval($_GPC['id']);
	$qrcode = pdo_get('weliam_shiftcar_qrcode', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if(pdo_tableexists('wlmerchant_merchantdata')){
		$remark_arr = pdo_getall('wlmerchant_merchantdata',array('uniacid'=>$_W['uniacid']),array('id','storename'));
	}
	if (p('caragent')) {
		$allagent = pdo_getall(PDO_NAME.'agentusers',array('uniacid'=>$_W['uniacid']),array('id','agentname'));
	}
	
	if($_W['ispost']){
		if($id){
			$storeid = intval($_GPC['storeid']);
			$caraid = intval($_GPC['caraid']);
			$data = array(
				'sid'    => intval($_GPC['storeid']),
				'aid'    => intval($_GPC['caraid']),
				'remark' => trim($_GPC['remark'])
			);
			if($_GPC['range']){
				$res = pdo_update('weliam_shiftcar_qrcode', $data, array('remark' => $qrcode['remark']));
			}else {
				$res = pdo_update('weliam_shiftcar_qrcode', $data, array('uniacid' => $_W['uniacid'], 'id' => $id));
			}
		}
		if($res){
			show_json(1,'操作成功');
		}else {
			show_json(0,'操作失败,请重试');
		}
	}
	include wl_template('card/qr-model');
}
