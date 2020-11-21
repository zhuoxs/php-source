<?php
$op = $op ? $op : 'run';

if($op == 'run') {
	if(checksubmit()) {
		$sql = $_POST['sql'];
		pdo_run($sql);
		message('查询执行成功.', 'refresh');
	}
	include wl_template('system/database');
}

if($op == 'import') {
	$type = trim($_GPC['type']);
	$status = trim($_GPC['status']);
	if ($status == 'area') {
		if ($type == 'install') {
			$id = pdo_getcolumn('weliam_shiftcar_address', array('id' => 110000), 'id');
			if (empty($id)) {
				$sql = file_get_contents(WL_CORE . "common/addrdb.php");
				$sql = str_replace(' ims_', ' ' . tablename(), $sql);
				pdo_run(trim($sql));
			}
			message('地区数据安装成功.', web_url('system/database/import'), 'success');
			
		}
		if ($type == 'clear') {
			$id = pdo_getcolumn('weliam_shiftcar_address', array('id' => 110000), 'id');
			if (!empty($id)) {
				pdo_query("TRUNCATE TABLE " . tablename('weliam_shiftcar_address') . ";");
			}
			message('地区数据清除成功.', web_url('system/database/import'), 'success');
		}
	}
	
	if ($status == 'car') {
		if ($type == 'install') {
			$sid = pdo_getcolumn('weliam_shiftcar_sclass', array('id' => 1), 'id');
			if (empty($sid)) {
				$sql = file_get_contents(WL_CORE . "common/brand.php");
				$sql = str_replace(' ims_', ' ' . tablename(), $sql);
				pdo_run($sql);
			}
			$id = pdo_getcolumn('weliam_shiftcar_class', array('id' => 1), 'id');
			if (empty($id)) {
				$sql = file_get_contents(WL_CORE . "common/brand1.php");
				$sql = str_replace(' ims_', ' ' . tablename(), $sql);
				pdo_run($sql);
			}
			message('品牌数据安装成功.', web_url('system/database/import'), 'success');
			
		}
		if ($type == 'clear') {
			$sid = pdo_getcolumn('weliam_shiftcar_sclass', array('id' => 1), 'id');
			if (!empty($sid)) {
				pdo_query("TRUNCATE TABLE " . tablename('weliam_shiftcar_sclass') . ";");
			}
			$id = pdo_getcolumn('weliam_shiftcar_class', array('id' => 1), 'id');
			if (!empty($id)) {
				pdo_query("TRUNCATE TABLE " . tablename('weliam_shiftcar_class') . ";");
				pdo_query("TRUNCATE TABLE " . tablename('weliam_shiftcar_brand') . ";");
			}
			message('品牌数据清除成功.', web_url('system/database/import'), 'success');
		}
	}
	
	include wl_template('system/datemana');
}

if($op == 'repair') {
	$waitdo = 0;
	$carmember = pdo_getall('weliam_shiftcar_member',array('status'=>2),array('uniacid','ncnumber','id'));
	foreach ($carmember as $key => $value) {
		$qrcode = pdo_getall('weliam_shiftcar_qrcode',array('mid'=>$value['id']),array('uniacid','id'));
		foreach ($qrcode as $k => $val) {
			if($val['uniacid'] != $value['uniacid']){
				pdo_update('weliam_shiftcar_qrcode',array('mid'=>0,'status'=>1),array('id'=>$val['id']));
				$waitdo++;
			}
		}
	}
	if(empty($waitdo)){
		message('恭喜您，没有需要进行处理的车主！',web_url('card/qr/list'),'success');
	}else{
		message('恭喜您，成功处理了'.$waitdo."位数据错误的车主",web_url('card/qr/list'),'success');
	}
	include wl_template('card/data_repair');
}

if($op == 'addcarinfo') {
	$where = "";
	$params = array();
	$type = intval($_GPC['type']);
	$keyword = trim($_GPC['keyword']);
	
	if (!empty($keyword)) {
		switch($type) {
			case 2 :
				$where .= " WHERE brand LIKE :brand";
				$params[':brand'] = "%{$keyword}%";
				break;
			case 3 :
				$where .= " WHERE id LIKE :id";
				$params[':id'] = "%{$keyword}%";
				break;
			default :
				$where .= "";
		}
	}
	
	$size = 15;
	$page = $_GPC['page'];
	$sqlTotal = pdo_sql_select_count_from('weliam_shiftcar_brand') . $where;
	$sqlData = pdo_sql_select_all_from('weliam_shiftcar_brand') . $where . ' ORDER BY `id` ASC ';
	$list = pdo_pagination($sqlTotal, $sqlData, $params, '', $total, $page, $size);
	foreach ($list as $key => &$value) {
		$value['imgs'] = WL_URL_ARES.'images/brand/'.$value['imgs'];
	}
	$pager = pagination($total, $page, $size);
	include wl_template('system/addinfo');
}
if($op=='detail'){
	global $_W,$_GPC;
	$parentid = $_GPC['id'];
	$brand = $_GPC['brand'];
	$categorys = pdo_getall('weliam_shiftcar_class',array('brandid'=>$parentid));
	foreach($categorys as $key=>$value){
		$childrens = pdo_getall('weliam_shiftcar_sclass',array('classid'=>$value['id']));
		$categorys[$key]['children'] = $childrens;
	}
	include wl_template('system/branddetail');
}
if($op=='addclass'){
	global $_W,$_GPC;
	$brandid = $_GPC['parentid'];
	$parentid = $_GPC['parentid'];
	if(checksubmit('submit')){
		$name = $_GPC['name'];
		if($_GPC['id']){
			$res = pdo_update('weliam_shiftcar_class',array('name' => $name),array('id' => $_GPC['id']));
		}else{
			$res = pdo_insert('weliam_shiftcar_class',array('name' => $name,'brandid'=>$brandid));
		}
		if($res){
			message('保存成功',web_url('system/database/detail',array('id'=>$parentid)),'success');
		}else {
			message('保存失败',web_url('system/database/detail',array('id'=>$parentid)),'error');
		}
	}
	include wl_template('system/addclass');
}
if($op=='deleteclass'){
	global $_W,$_GPC;
	$parentid = $_GPC['parentid'];
	$id = $_GPC['id'];
	$res = pdo_delete('weliam_shiftcar_class',array('id'=>$id));
	if($res){
		message('删除成功',web_url('system/database/detail',array('id'=>$parentid)),'success');
	}else {
		message('删除失败',web_url('system/database/detail',array('id'=>$parentid)),'error');
	}
}
if($op=='addsclass'){
	global $_W,$_GPC;
	$classid = $_GPC['parentid'];
	$parentid = $_GPC['brandid'];
	if(checksubmit('submit')){
		$name = $_GPC['name'];
		if($_GPC['id']){
			$res = pdo_update('weliam_shiftcar_sclass',array('name' => $name),array('id' => $_GPC['id']));
		}else{
			$res = pdo_insert('weliam_shiftcar_sclass',array('name' => $name,'classid'=>$classid));
		}
		if($res){
			message('保存成功',web_url('system/database/detail',array('id'=>$parentid)),'success');
		}else {
			message('保存失败',web_url('system/database/detail',array('id'=>$parentid)),'error');
		}
	}
	include wl_template('system/addclass');
}
if($op=='deletesclass'){
	global $_W,$_GPC;
	$parentid = $_GPC['parentid'];
	$id = $_GPC['id'];
	$res = pdo_delete('weliam_shiftcar_sclass',array('id'=>$id));
	if($res){
		message('删除成功',web_url('system/database/detail',array('id'=>$parentid)),'success');
	}else {
		message('删除失败',web_url('system/database/detail',array('id'=>$parentid)),'error');
	}
}
