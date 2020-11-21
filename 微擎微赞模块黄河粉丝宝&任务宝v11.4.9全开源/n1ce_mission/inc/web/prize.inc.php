<?php
		global $_GPC, $_W;
		checklogin();
		$rid = intval($_GPC['rid']);
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if($operation=="delete"){
				$id = $_GPC['id'];
				$rid =$_GPC['rid'];
				if(!$id)message('参数错误！','', 'error');
				pdo_delete("n1ce_mission_prize",array("id"=>$id,"uniacid"=>$_W['uniacid'],"rid"=>$rid));
				pdo_delete('n1ce_mission_code',array('uniacid'=>$_W['uniacid'],'codeid'=>$id,'rid'=>$rid));
				message("删除成功",$this->createWebUrl("prize" , array('rid' => $rid)), 'success');
		}
		$pindex = max(1, intval($_GPC['page']));
			$psize = 15;
			$sql = 'select * from ' . tablename('n1ce_mission_prize') . 'where uniacid = :uniacid and rid = :rid LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
			$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid);
			$list = pdo_fetchall($sql, $prarm);
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_prize') . 'where uniacid = :uniacid and rid = :rid', $prarm);
			$pager = pagination($count, $pindex, $psize);
			// var_dump($pager);
		include $this->template('prize');