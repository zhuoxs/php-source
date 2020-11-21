<?php
		global $_GPC, $_W;
		checklogin();
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$con = ""; 
		$from_user = trim($_GPC['from_user']);
		if($from_user != ''){
			if(strlen($from_user) !== 28){
				//输入的昵称
				$exist = pdo_get('mc_mapping_fans', array('nickname' => $from_user, 'acid' => $_W['acid']), array('openid'));
				$from_user = $exist['openid'];
			}
			$con .= " AND a.from_user = '$from_user'";
		}
		$pindex = max(1, intval($_GPC['page']));
		$psize = 15;
		$rid = $_GPC['rid'];
		if(empty($rid)){
			
			message('参数错误！','','error');
		}
		//统计人数
		$allnumber_sql = "SELECT a.id,a.createtime, c.nickname, c.avatar,a.from_user, a.allnumber,b.uid,b.follow,c.gender FROM " . tablename('n1ce_mission_allnumber') . " a LEFT JOIN "
        . tablename('mc_mapping_fans') . " b ON a.from_user = b.openid AND a.uniacid=b.uniacid LEFT JOIN "
        . tablename('mc_members') . " c ON b.uniacid = c.uniacid AND b.uid = c.uid  "
        . " WHERE rid=:rid AND a.uniacid=:uniacid".$con." ORDER BY allnumber DESC LIMIT ". ($pindex - 1) * $psize . ',' . $psize;
		$prarm = array(':uniacid' => $_W['uniacid'],':rid' => $rid);
		$list = pdo_fetchall($allnumber_sql, $prarm);
		foreach ($list as &$item) {
			if(empty($item['uid']) || empty($item['avatar'])){
				yload()->classs('n1ce_mission','fans');
				$fans = new Fans();
				$mc = $fans->refresh($item['from_user']);
				$item['uid'] = $mc['uid'];
				$item['avatar'] = $mc['avatar'];
				$item['nickname'] = $mc['nickname'];
			}
			unset($item);
		}
		$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_allnumber') . 'where uniacid = :uniacid and rid = :rid', $prarm);
		$qr_num = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_qrlog') . 'where uniacid = :uniacid and rid = :rid', $prarm);
		$follow_num = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_follow') . 'where uniacid = :uniacid and rid = :rid', $prarm);
		$un_follow = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_follow') . 'where uniacid = :uniacid and rid = :rid and status = 2', $prarm);
		$add_follow = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_follow') . 'where uniacid = :uniacid and rid = :rid and status = 1', $prarm);
		$success_num = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_mission_user') . 'where uniacid = :uniacid and rid = :rid', $prarm);
		if($qr_num>0){
			$acheve_num = sprintf("%.2f",$success_num/$qr_num);
			$ac_num = sprintf("%.2f",$follow_num/$qr_num);
		}else{
			$acheve_num = 0;
			$ac_num = 0;
		}
		
		$pager = pagination($count, $pindex, $psize);
		
		load()->func('tpl');
		include $this->template('user');