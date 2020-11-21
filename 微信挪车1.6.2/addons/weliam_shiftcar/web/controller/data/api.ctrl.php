<?php
defined('IN_IA') or exit('Access Denied');
$ops = array('display','detail','ajax');
$op = in_array($op, $ops) ? $op : 'display';

if ($op == 'display') {
	$where = " WHERE 1 and uniacid = {$_W['uniacid']} ";
	$params = array();
	$type = intval($_GPC['type']);
	$keyword = trim($_GPC['keyword']);

	if (!empty($keyword)) {
		$where .= " AND (sendmobile LIKE '%{$keyword}%' or takemobile LIKE '%{$keyword}%')";
	}
	if (!empty($type) && $type != -1) {
		$where .= " AND type = :type";
		$params[':type'] = $type;
	}
	
	$size = 15;
	$page = $_GPC['page'];
	$sqlTotal = pdo_sql_select_count_from('weliam_shiftcar_apirecord') . $where;
	$sqlData = pdo_sql_select_all_from('weliam_shiftcar_apirecord') . $where . ' ORDER BY `id` DESC ';
	$list = pdo_pagination($sqlTotal, $sqlData, $params, '', $total, $page, $size);
	foreach ($list as $key => $value) {
		$takemid = pdo_getcolumn('weliam_shiftcar_record', array('uniacid' => $_W['uniacid'], 'sendmid' => $value['sendmid'], 'createtime' => $value['createtime']), 'takemid');
		if (($takemid != $value['takemid']) && !empty($takemid)) {
			$value['takemid'] = $takemid;
		}
		$jmember = pdo_get('weliam_shiftcar_member', array('id' => $value['takemid']), array('avatar','nickname'));
		$list[$key]['javatar'] = $jmember['avatar'];
		$list[$key]['jnickname'] = $jmember['nickname'];
		if($value['sendmid'] == '-1'){
			$list[$key]['favatar'] = tomedia('headimg_'.$_W['acid'].'.jpg');
			$list[$key]['fnickname'] = '系统';
			$list[$key]['sendmobile'] = '系统';
		}else{
			$fmember = pdo_get('weliam_shiftcar_member', array('id' => $value['sendmid']), array('avatar','nickname'));
			$list[$key]['favatar'] = $fmember['avatar'];
			$list[$key]['fnickname'] = $fmember['nickname'];
		}
		unset($jmember,$fmember);
	}
	$pager = pagination($total, $page, $size);
}

include wl_template('data/api');
