<?php
/**
	 * 兑换码查看
	 */
global $_W,$_GPC;
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$rid = $_GPC['rid'];
		$codeid = $_GPC['codeid'];
		if($operation == 'display'){
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$sql = 'select * from ' . tablename('n1ce_mission_code') . 'where uniacid = :uniacid and codeid = :codeid LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$prarm = array(':uniacid' => $_W['uniacid'],':codeid' => $codeid);
			$list = pdo_fetchall($sql, $prarm);
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_code') . 'where uniacid = :uniacid and codeid = :codeid', $prarm);
			$pager = pagination($count, $pindex, $psize);
			include $this->template('prize_code');
		}elseif($operation == 'delete'){
			$id = $_GPC['id'];
			pdo_delete('n1ce_mission_code',array('id'=>$id));
			message('删除成功','referer','success');
		}