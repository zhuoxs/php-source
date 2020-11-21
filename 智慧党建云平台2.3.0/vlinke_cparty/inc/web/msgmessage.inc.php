<?php
global $_GPC, $_W;
$op = empty($_GPC['op'])?"display":$_GPC['op'];
load()->func('tpl');
if ($op=="display") {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$list = pdo_fetchall('SELECT * FROM '.tablename($this->table_msgmessage).' WHERE uniacid=:uniacid ORDER BY id DESC LIMIT '.($pindex-1) * $psize.','.$psize, array(':uniacid'=>$_W['uniacid']));
	$total = pdo_fetchcolumn('SELECT count(id) FROM '.tablename($this->table_msgmessage).' WHERE uniacid=:uniacid ', array(':uniacid'=>$_W['uniacid']));
	$pager = pagination($total, $pindex, $psize);

} elseif ($op=="setpush") {
	
// 	$ret['msg'] = "为了不骚扰其他演示用户，演示版的推送环节已被禁用，敬请谅解！";
// 	exit(json_encode($ret));
	
	$ret = array("status"=>"error","msg"=>"error");
	$id = intval($_GPC['id']);
	$message = pdo_get($this->table_msgmessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
	if(empty($message)){
		$ret['msg'] = "消息信息不存在，请刷新页面重新选择！";
		exit(json_encode($ret));
	}
	$message['miniprogram'] = iunserializer($message['miniprogram']);
	$dataarr = iunserializer($message['dataarr']);
	$msgdata = array();
	foreach($dataarr as $k=>$v){
		$msgdata[$v['keyword']]['value'] = $v['content'];
		$msgdata[$v['keyword']]['color'] = $v['color'];
	}
	$useridstr = trim($_GPC['useridstr']);
	$userlist = pdo_fetchall("SELECT id,openid,wxappopenid FROM ".tablename($this->table_user)." WHERE id IN (".$useridstr.") AND uniacid=:uniacid ",  array('uniacid'=>$_W['uniacid']));
	$logdata = array(
		'uniacid' => $_W['uniacid'],
		'messageid' => $message['id'],
		'userid' => 0,
		'createtime' => time()
	);
	$account_api = WeAccount::create();
	foreach($userlist as $k=>$v){
		$account_api->sendTplNotice($v['openid'], $message['templateid'], $msgdata, $message['url'], '#FF683F', $message['miniprogram']);
		// $result = $account_api->sendTplNotice('oHnG4wQNJkSItgDWsml7r6bJRvvA', $message['templateid'], $msgdata, $message['url'], '#FF683F', $message['miniprogram']);
		$logdata['userid'] = $v['id'];
		pdo_insert($this->table_msglog, $logdata);
	}
	$ret['status'] = "success";
	$ret['msg'] = "消息推送成功！";
	exit(json_encode($ret));

} elseif ($op=="getuser") {
	$id = intval($_GPC['id']);
	$message = pdo_get($this->table_msgmessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
	$userarr = iunserializer($message['userarr']);
	$userstr = empty($userarr) ? "0" : implode(",", $userarr);
	$con = ' WHERE u.id NOT IN ('.$userstr.') AND u.uniacid=:uniacid AND u.recycle=0 ';
	$par[':uniacid'] = $_W['uniacid'];
	$keyword = $_GPC['keyword'];
	if (!empty($keyword)) {
		$con .= " AND ( u.realname LIKE :keyword OR u.mobile LIKE :keyword ) ";
		$par[':keyword'] = "%".$keyword."%";
	}
	$branchid = intval($_GPC['branchid']);
	if ($branchid!=0) {
		$con .= " AND u.branchid=:branchid ";
		$par[':branchid'] = $branchid;
		$branch = pdo_get($this->table_branch,array('id'=>$branchid,'uniacid'=>$_W['uniacid']));
	}
	$status = intval($_GPC['status']);
	if ($status!=0) {
		$con .= " AND u.status=:status ";
		$par[':status'] = $status;
	}
	$ulevel = intval($_GPC['ulevel']);
	if ($ulevel!=0) {
		$con .= " AND u.ulevel=:ulevel ";
		$par[':ulevel'] = $ulevel;
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 50;
	$list = pdo_fetchall("SELECT u.*,b.name FROM ".tablename($this->table_user)." u LEFT JOIN ".tablename($this->table_branch)." b ON u.branchid=b.id ".$con." ORDER BY u.id DESC LIMIT ".($pindex-1) * $psize.",".$psize, $par);
	$total = pdo_fetchcolumn('SELECT count(u.id) FROM '.tablename($this->table_user)." u ".$con ,$par);
	$pager = pagination($total, $pindex, $psize);
	
	$idarr = pdo_fetchall("SELECT u.id FROM ".tablename($this->table_user)." u ".$con." ORDER BY u.id DESC ", $par);
	$idarr = array_column($idarr,"id");
	$idall = implode(",", $idarr);
	
} elseif ($op=="add") {
	$templateid = intval($_GPC['templateid']);
	$template = pdo_get($this->table_msgtemplate, array('id'=>$templateid,'uniacid'=>$_W['uniacid']));
	if(empty($template)){
		message("消息模板不存在，请刷新页面重新选择模板添加！", $this->createWebUrl('msgtemplate'), 'error');
	}
	$data = array(
		'uniacid' => $_W['uniacid'],
		'templateid' => $template['templateid'],
		'templatename' => $template['templatename'],
		'title' => "",
		'dataarr' => $template['dataarr'],
		'url' => "",
		'miniprogram' => iserializer(array("appid"=>"","pagepath"=>"")),
		'createtime' => time()
	);
	pdo_insert($this->table_msgmessage, $data);
	$id = pdo_insertid();
	header( "location:".$this->createWebUrl('msgmessage',array('op'=>'post','id'=>$id)) );

} elseif ($op=="post") {
	$id = intval($_GPC['id']);
	$message = pdo_get($this->table_msgmessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
	if(empty($message)){
		message("消息信息不存在，请刷新页面重新选择！", $this->createWebUrl('msgmessage'), 'error');
	}
	$message['dataarr'] = iunserializer($message['dataarr']);
	$message['miniprogram'] = iunserializer($message['miniprogram']);
	
	if (checksubmit('submit')) {
		$dataarr = $_GPC['dataarr'];
		$dataarr = iserializer(array_values($dataarr));
		$data = array(
			'title' => trim($_GPC['title']),
			'dataarr' => $dataarr,
			'url' => trim($_GPC['url']),
			'miniprogram' => iserializer($_GPC['miniprogram']),
			);
		pdo_update($this->table_msgmessage, $data, array('id'=>$id,'uniacid'=>$_W['uniacid']));
		message("数据提交成功！", referer(), 'success');
	}
	
} elseif ($op=="delete") {
	$id = intval($_GPC['id']);
	$result = pdo_delete($this->table_msgmessage, array('id'=>$id,'uniacid'=>$_W['uniacid']));
	if (!empty($result)) {
		message("数据删除成功！",referer(),'success');
	}
	message("数据删除失败，请刷新页面重试！",referer(),'error');
	
}
include $this->template("msgmessage");
?>