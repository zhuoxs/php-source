<?php
global $_W,$_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$rid = $_GPC['rid'];
$gid = $_GPC['gid'];
if($operation == 'display'){
	if(checksubmit('batchsend')){
		foreach ($_GPC['id'] as $id) {
          $row = pdo_fetch("SELECT id FROM ".tablename('n1ce_mission_order')." WHERE id = :id", array(':id' => $id));
          if (empty($row)) {
            continue;
          }
          pdo_update('n1ce_mission_order', array('status'=>1), array('id' => $id));
        }
		message('批量兑换成功. 兑换成功的请求已移入‘已兑换请求’栏！', referer(), 'success');
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$sql = 'select * from ' . tablename('n1ce_mission_order') . 'where uniacid = :uniacid and rid = :rid and gid = :gid and status=2 order by id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize ;
	$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid,':gid' => $gid);
	$list = pdo_fetchall($sql, $prarm);
	$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_order') . 'where uniacid = :uniacid and rid = :rid and gid = :gid and status=2 ', $prarm);
	$pager = pagination($count, $pindex, $psize);
}elseif ($operation == 'display_done') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$sql = 'select * from ' . tablename('n1ce_mission_order') . 'where uniacid = :uniacid and rid = :rid and gid = :gid and status=1 order by id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize ;
	$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid,':gid' => $gid);
	$list = pdo_fetchall($sql, $prarm);
	$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_order') . 'where uniacid = :uniacid and rid = :rid and gid = :gid and status=1 ', $prarm);
	$pager = pagination($count, $pindex, $psize);
}elseif ($operation == 'post') {
	pdo_update('n1ce_mission_order', array('status'=>1), array('id' => $_GPC['id']));
	message('兑换成功. 兑换成功的请求已移入‘已兑换请求’栏！', referer(), 'success');
}elseif ($operation == 'delete') {
	pdo_delete('n1ce_mission_order',array('id'=>$_GPC['id']));
	message('删除成功', referer(), 'success');
}
include $this->template('order');