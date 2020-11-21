<?php
global $_GPC, $_W;
		checklogin();
		$rid = $_GPC['rid'];
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if($operation=="edits"){
			$id = $_GPC['id'];
			$rid = $_GPC['rid'];
			$sql = 'select * from ' . tablename('n1ce_mission_prize') . 'where uniacid = :uniacid and rid = :rid and id = :id';
			$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid,':id' => $id);
			$sum = pdo_fetch($sql, $prarm);
		}
		if (checksubmit()){
			pdo_update('n1ce_mission_prize', array('prizesum' => $_GPC['prize_sum']), array('rid' => $_GPC['rid'],'uniacid' => $_W['uniacid'],'id' => $_GPC['id']));
			message('更新奖品成功',$this->createWebUrl('prize',array('rid' => $rid)),'success');
		}
		include $this->template('prizeedits');