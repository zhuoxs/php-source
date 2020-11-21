<?php
		global $_GPC, $_W;
		checklogin();
		$pindex = max(1, intval($_GPC['page']));
		$psize = 15;
		$rid = $_GPC['rid'];
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if(empty($rid)){
			message('参数错误！','','error');
		}
		$con = ""; 
		$settings = $this->module['config'];
		$from_user = trim($_GPC['from_user']);
		if($from_user != ''){
			$con .= " AND openid = '$from_user'";
		}
		if($operation=="havetrue"){
			$sql = 'select * from ' . tablename('n1ce_mission_user') . 'where uniacid = :uniacid and rid = :rid AND status = 1 ' . $con .' order by allnumber DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize ;
			$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid);
			$list = pdo_fetchall($sql, $prarm);
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_user') . 'where uniacid = :uniacid and rid = :rid and status = 1'.$con, $prarm);
			$pager = pagination($count, $pindex, $psize);
		}
		if($operation=="isfail"){
			$sql = 'select * from ' . tablename('n1ce_mission_user') . 'where uniacid = :uniacid and rid = :rid AND status = 2 ' . $con . 'order by allnumber DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize ;
			$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid);
			$list = pdo_fetchall($sql, $prarm);
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_user') . 'where uniacid = :uniacid and rid = :rid and status = 2'.$con, $prarm);
			$pager = pagination($count, $pindex, $psize);
		}
		load()->func('tpl');
		include $this->template('userdetail');