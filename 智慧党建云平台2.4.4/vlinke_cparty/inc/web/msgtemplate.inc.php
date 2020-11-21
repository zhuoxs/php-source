<?php
global $_GPC, $_W;
$op = empty($_GPC['op'])?"display":$_GPC['op'];
load()->func('tpl');
if ($op=="display") {
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall('SELECT * FROM '.tablename($this->table_msgtemplate).' WHERE uniacid=:uniacid ORDER BY id DESC LIMIT '.($pindex-1) * $psize.','.$psize, array(':uniacid'=>$_W['uniacid']));
	$total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_msgtemplate).' WHERE uniacid=:uniacid ', array(':uniacid'=>$_W['uniacid']));
	$pager = pagination($total, $pindex, $psize);

} elseif ($op=="post") {
	$id = intval($_GPC['id']);
	if (checksubmit('submit')) {
		$dataarr = $_GPC['dataarr'];
		$dataarr = iserializer(array_values($dataarr));
		
		$data = array(
			'uniacid' => $_W['uniacid'],
			'templateid' => trim($_GPC['templateid']),
			'templatename' => trim($_GPC['templatename']),
			'dataarr' => $dataarr
			);
		if($id==0){
			pdo_insert($this->table_msgtemplate, $data);
		}else{
			pdo_update($this->table_msgtemplate, $data, array('id'=>$id,'uniacid'=>$_W['uniacid']));
		}
		message("数据提交成功！", $this->createWebUrl('msgtemplate'),'success');
	}
	$template = pdo_get($this->table_msgtemplate, array('id'=>$id,'uniacid'=>$_W['uniacid']));
	if(!empty($template)){
		$template['dataarr'] = iunserializer($template['dataarr']);
	}

} elseif ($op=="addkeyword") {
	$rand = rand_str(6,1);
	
} elseif ($op=="delete") {
	$id = intval($_GPC['id']);
	$result = pdo_delete($this->table_msgtemplate, array('id'=>$id,'uniacid'=>$_W['uniacid']));
	if (!empty($result)) {
		message("数据删除成功！",referer(),'success');
	}
	message("数据删除失败，请刷新页面重试！",referer(),'error');
	
}
include $this->template("msgtemplate");
?>