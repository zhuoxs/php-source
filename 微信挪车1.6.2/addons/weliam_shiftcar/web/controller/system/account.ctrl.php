<?php
defined('IN_IA') or exit('Access Denied');
load()->func('communication');
wl_load()->model('auth');
wl_load()->model('address');
$result = auth_checkauth($auth);
if($result['status'] != 0){
	message('您还未授权，请授权后再试！',web_url('system/auth/display'),'warning');
}
if (!$_W['isfounder']) {
	message('无权访问!');
}
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($op == 'display') {
	$uniaccounts = pdo_getall('account_wechats','','uniacid');
	$accounts = array();
	if(!empty($uniaccounts)) {
		foreach($uniaccounts as $uniaccount) {
			$accountlist = uni_accounts($uniaccount['uniacid']);
			if(!empty($accountlist)) {
				foreach($accountlist as $account) {
					if(in_array($account['level'], array(3, 4))) {
						$accounts[$account['acid']] = $account['name'];
					}
				}
			}
		}
	}
	$terarea = auth_downaddress($auth);
	if($terarea['result'] == 1){
		message($terarea['message']);
	}
	$terarea = $terarea['message'];
	$setting = address_tree_in_use($terarea);
	$setting = json_encode($setting);
	
	if(checksubmit('submit')) {
		$jsauth_acid = intval($_GPC['jsauth_acid']);
		if(!array_key_exists($jsauth_acid, $accounts)){
			message('指定的公众号不存在.');
		}
		$acconunt_we = pdo_get('account_wechats',array('acid' => $jsauth_acid),array('key','name'));
		if(empty($acconunt_we['key'])){
			message('请选择先完善公众号AppId.', referer() ,'success');
		}
		$districts = $_GPC['districts'];
		$address_code = pdo_getcolumn('weliam_shiftcar_address',array('name' => $districts['city'],'level' => 2),'id');
		if(empty($address_code)){
			message('请选择二级地区.', referer() ,'success');
		}
		$data = array(
			'name' => $acconunt_we['name'],
			'key' => $acconunt_we['key'],
			'addressid' => $address_code,
			'address' => $districts['province'].$districts['city'],
		);
		$upstatus = auth_upaddress($auth,$data);
		if($upstatus['result'] == 1){
			$data['acid'] = $jsauth_acid;
			$data['createtime'] = time();
			if(intval($_GPC['id'])){
				pdo_update('weliam_shiftcar_wechataddr',$data,array('id' => intval($_GPC['id'])));
			}else{
				pdo_insert('weliam_shiftcar_wechataddr',$data);
			}
			message('编辑成功！', web_url('system/account/list'),'success');
		}else{
			message($upstatus['message'], referer() ,'success');
		}
	}
	
	include wl_template('system/account');
}

if($op == 'list'){
	$where = " WHERE 1";
	$params = array();
	$keyword = trim($_GPC['keyword']);
	if (!empty($keyword)) {
		$where .= " AND name LIKE :name";
		$params[':name'] = "%{$keyword}%";
	}
	
	$size = 15;
	$page = $_GPC['page'];
	$sqlTotal = pdo_sql_select_count_from('weliam_shiftcar_wechataddr') . $where;
	$sqlData = pdo_sql_select_all_from('weliam_shiftcar_wechataddr') . $where . ' ORDER BY `id` DESC ';
	$list = pdo_pagination($sqlTotal, $sqlData, $params, '', $total, $page, $size);
	$pager = pagination($total, $page, $size);
	
	include wl_template('system/account_list');
}

if($op == 'del'){
	$id = intval($_GPC['id']);
	pdo_delete('weliam_shiftcar_wechataddr',array('id' => $id));
	message('删除成功',referer(),'success');
}
