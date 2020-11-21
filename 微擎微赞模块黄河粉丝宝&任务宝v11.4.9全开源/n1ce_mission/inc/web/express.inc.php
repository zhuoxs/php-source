<?php
global $_W,$_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
load()->model('cache');
if($operation == 'post'){
	load()->func('file');
	if(checksubmit()){
		$last = pdo_fetch("select * from " .tablename('n1ce_mission_express'). " where uniacid = :uniacid order by id desc",array(':uniacid'=>$_W['uniacid']));
		if($last['id']){
			cache_write($_W['uniacid'].'n1ce_mission', $last['id']);
		}
		$dir_url = IA_ROOT . '/attachment/images/' . $_W['uniacid'] . '/n1ce_mission/';
		
		if ($_FILES["csvfile"]["name"]) {
			$extNameAry = explode(".", $_FILES["csvfile"]["name"]);
			$extName = $extNameAry[count($extNameAry) - 1];
			if ($extName != 'csv') {
				message('只能是导入csv格式的文件！', $this->createWebUrl('express',array('op'=>'post')), 'error');
			}
			mkdirs($dir_url);
			$filename = date("YmdHis") . "." . $extName;
			move_uploaded_file($_FILES["csvfile"]["tmp_name"], $dir_url . "/" . $filename);
			$file = fopen($dir_url . "/" . $filename, 'r');
			while ($data = fgetcsv($file)) {
				$goods_list[] = $data;
			}
			foreach ($goods_list as $row) {
				
				$temp = array(
					'uniacid' => $_W['uniacid'],
					'realname' => trim($row[0]),
					'mobile' => trim($row[1]),
					'ex_name' => $row[2],
					'ex_num' => $row[3],
				);
				pdo_insert('n1ce_mission_express',$temp);
			}
			fclose($file);
			message('导入成功',$this->createWebUrl('express'),'success');
		}else{
			message('请上传文件',$this->createWebUrl('express',array('op'=>'post')),'error');
		}	
		
	}
}elseif($operation == 'display'){
	$last_id = cache_load($_W['uniacid'].'n1ce_mission');
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$sql = 'select * from ' . tablename('n1ce_mission_express') . 'where uniacid = :uniacid order by id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize ;
	$prarm = array(':uniacid' => $_W['uniacid']);
	$list = pdo_fetchall($sql, $prarm);
	$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_express') . 'where uniacid = :uniacid', $prarm);
	$pager = pagination($count, $pindex, $psize);
}elseif($operation == 'delete'){
	if($_GPC['last_id']){
		pdo_delete('n1ce_mission_express',array('uniacid'=>$_W['uniacid'],'id >'=>$_GPC['last_id']));
		cache_delete($_W['uniacid'].'n1ce_mission');
	}else{
		pdo_delete('n1ce_mission_express',array('uniacid'=>$_W['uniacid']));
	}
	message('删除成功',$this->createWebUrl('express'),'success');
}
include $this->template('n1ce-express');