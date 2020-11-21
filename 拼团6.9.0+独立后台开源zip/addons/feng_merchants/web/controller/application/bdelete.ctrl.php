<?php

$ops = array('store', 'saler','selectsaler','selectstore');
$op_names = array('门店管理', '核销员','选择粉丝','选择门店');
foreach($ops as$key=>$value){
	permissions('do', 'ac', 'op', 'application', 'bdelete', $ops[$key], '应用与营销', '核销管理', $op_names[$key]);
}
$op = in_array($op, $ops) ? $op : 'store';
$opp = !empty($_GPC['opp'])?$_GPC['opp']:'display';
$merchants = pdo_fetchall("SELECT * FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}' and id = ".MERCHANTID);
//商品展示
if ($op == 'store') {
	if ($opp == 'display') {
		$list = pdo_fetchall("select * from" . tablename('tg_store') . "where uniacid='{$_W['uniacid']}' and merchantid=".MERCHANTID);
		foreach($list as$key=>&$value){
			$value['merchant'] = pdo_fetch("SELECT * FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}' and id={$value['merchantid']}");
		}
	} elseif ($opp == 'post') {
		$id = $_GPC['id'];
		if ($id) {
			$item = pdo_fetch("select * from" . tablename('tg_store') . "where uniacid='{$_W['uniacid']}' and id = '{$id}' and merchantid=".MERCHANTID);
		}
		if (checksubmit('storesubmit')) {
			$id   = $_GPC['id'];
			$data = array(
				'uniacid' => $_W['uniacid'],
				'storename' => $_GPC['storename'],
				'address' => $_GPC['address'],
				'tel' => $_GPC['tel'],
				'lng' => $_GPC['map']['lng'],
				'lat' => $_GPC['map']['lat'],
				'status' => $_GPC['qiyongstatus'],
				'merchantid'=>$_GPC['merchantid']
			);
			if (trim($data['storename']) == '') {
				message('必须填写门店名称！', referer(), 'error');
				exit;
			}
			if ($id) {
				pdo_update('tg_store', $data, array(
					'id' => $id
				));
			} else {
				pdo_insert('tg_store', $data);
			}
			message('操作成功！', web_url('application/bdelete/store'), 'success');
		}
	} elseif ($opp == 'delete') {
		$id = $_GPC['id'];
		pdo_delete('tg_store', array(
			'id' => $id
		));
		message('删除成功！', referer(), 'success');
	}
	include wl_template('application/bdelete');
} elseif ($op == 'saler') {
	if ($opp == 'display') {
		$list = pdo_fetchall("select * from" . tablename('tg_saler') . "where uniacid='{$_W['uniacid']}' and merchantid=".MERCHANTID);
		foreach ($list as $key => $value) {
			$storeid_arr = explode(',', $value['storeid']);
			$storename   = '';
			foreach ($storeid_arr as $k => $v) {
				if ($v) {
					$store = pdo_fetch("select * from" . tablename('tg_store') . "where id='{$v}'");
					$storename .= $store['storename'] . "/";
				}
			}
			$storename               = substr($storename, 0, strlen($storename) - 1);
			$list[$key]['storename'] = $storename;
			$list[$key]['merchant'] = pdo_fetch("SELECT * FROM " . tablename('tg_merchant') . " WHERE uniacid = '{$_W['uniacid']}' and id={$value['merchantid']}");
		}
	} elseif ($opp == 'post') {
		$id = $_GPC['id'];
		if ($id) {
			$saler       = pdo_fetch("select * from" . tablename('tg_saler') . "where uniacid='{$_W['uniacid']}' and id = '{$id}' and merchantid=".MERCHANTID);
			$storeid_arr = explode(',', $saler['storeid']);
			$storename   = '';
			foreach ($storeid_arr as $k => $v) {
				if ($v) {
					$stores[$k] = pdo_fetch("select * from" . tablename('tg_store') . "where id='{$v}' and uniacid='{$_W['uniacid']}' and merchantid=".MERCHANTID);
				}
			}
		}
		if (checksubmit('salersubmit')) {
			wl_load()->model('member');
			$id       = $_GPC['id'];
			$str      = '';
			$storeids = $_GPC['storeids'];
			if ($storeids) {
				foreach ($storeids as $key => $value) {
					if ($value) {
						$str .= $value . ",";
					}
				}
			}
			$data = array(
				'uniacid' => $_W['uniacid'],
				'openid' => $_GPC['openid'],
				'storeid' => $str,
				'status' => $_GPC['salerstatus'],
				'merchantid'=>$_GPC['merchantid']
			);
			if ($data['openid'] == '') {
				message('必须选择核销员！', referer(), 'error');
				exit;
			}
			$info             = member_get_by_params(" openid = '{$data['openid']}'");
			$data['avatar']   = $info['avatar'];
			$data['nickname'] = $info['nickname'];
			if ($id) {
				pdo_update('tg_saler', $data, array(
					'id' => $id
				));
			} else {
				pdo_insert('tg_saler', $data);
			}
			message('操作成功！', web_url('application/bdelete/saler'), 'success');
		}
	} elseif ($opp == 'delete') {
		$id = $_GPC['id'];
		pdo_delete('tg_saler', array(
			'id' => $id
		));
		message('删除成功！', referer(), 'success');
	}
	include wl_template('application/bdelete');
} elseif ($op == 'selectstore') {
	$con     = "uniacid='{$_W['uniacid']}' and status=1 ";
	$keyword = $_GPC['keyword'];
	if ($keyword != '') {
		$con .= " and storename LIKE '%{$keyword}%' ";
	}
	$ds = pdo_fetchall("select * from" . tablename('tg_store') . "where $con and merchantid=".MERCHANTID);
	include wl_template('application/query_store');
	exit;
} elseif ($op == 'selectsaler') {
	$con     = "uniacid='{$_W['uniacid']}' ";
	$keyword = $_GPC['keyword'];
	if ($keyword != '') {
		$con .= " and nickname LIKE '%{$keyword}%'";
	}
	$ds = pdo_fetchall("select * from" . tablename('tg_member') . "where $con");
	include wl_template('application/query_saler');
	exit;
}
