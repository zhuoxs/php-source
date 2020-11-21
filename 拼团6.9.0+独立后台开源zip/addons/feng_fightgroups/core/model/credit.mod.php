<?php
	//1：积分，微擎表,2：tg表
	function credit_get_by_uid($uid = '' ,$credit_type=1) {
		global $_W;
		if($credit_type==1){
			load()->model('mc');
			$result = mc_fetch($uid, array('credit1','credit2'));
		}
		if($credit_type==2){
			$result = pdo_fetch("select credit1,credit2 from".tablename('tg_member')."where uid=:uid and uniacid=:uniacid",array(':uid'=>$uid,':uniacid'=>$_W['uniacid']));
		}
		return $result;
	} 
	
	 function credit_update_credit1($uid ,$credit1=0,$credit_type=1,$remark='') {
		global $_W;
		if($credit_type==1){
			$nuid = intval($uid);
			if(empty($nuid)){
				$fans = pdo_fetch("select uid from".tablename('mc_mapping_fans')."where uniacid={$_W['uniacid']} and openid='{$uid}'");
				$uid = $fans['uid'];
			}
			load()->model('mc');
			$f =mc_credit_update($uid, 'credit1', $credit1, array($uid, '拼团积分操作','feng_fightgroups'));
			if($f){
				$data=array(
					'uid'=>$uid,
					'uniacid'=>$_W['uniacid'],
					'openid'=>'',
					'num'=>$credit1,
					'createtime'=>TIMESTAMP,
					'status'=>1,
					'type'=>1,
					'paytype'=>2,
					'table'=>1,
					'remark'=>$remark
				);	
				pdo_insert("tg_credit_record",$data);
				return TRUE;
			}
			return FALSE;
		}
		if($credit_type==2){
			$info = pdo_fetch("select credit1,credit2 from".tablename('tg_member')."where uid=:uid and uniacid=:uniacid",array(':uid'=>$uid,':uniacid'=>$_W['uniacid']));
			$flag = pdo_update("tg_member",array('credit1'=>$info['credit1']+$credit1),array('uid'=>$uid,'uniacid'=>$_W['uniacid']));
			if($flag){
				$data=array(
					'uid'=>$uid,
					'uniacid'=>$_W['uniacid'],
					'openid'=>'',
					'num'=>$credit1,
					'createtime'=>TIMESTAMP,
					'status'=>1,
					'type'=>1,
					'paytype'=>2,
					'table'=>2,
					'remark'=>$remark
				);	
				pdo_insert("tg_credit_record",$data);
				return TRUE;
			}
			return FALSE;
		}
				
	}
	
	function credit_update_credit2($uid ,$credit2=0,$credit_type=1,$remark='') {
		global $_W;
		if($credit_type==1){
			load()->model('mc');
			$nuid = intval($uid);
			if(empty($nuid)){
				$fans = pdo_fetch("select uid from".tablename('mc_mapping_fans')."where uniacid={$_W['uniacid']} and openid='{$uid}'");
				$uid = $fans['uid'];
			}
			$f = mc_credit_update($uid, 'credit2', $credit2, array($uid, '拼团余额操作','feng_fightgroups'));
			if($f){
				$data=array(
					'uid'=>$uid,
					'uniacid'=>$_W['uniacid'],
					'openid'=>'',
					'num'=>$credit2,
					'createtime'=>TIMESTAMP,
					'status'=>1,
					'type'=>2,
					'paytype'=>2,
					'table'=>1,
					'remark'=>$remark
				);	
				pdo_insert("tg_credit_record",$data);	
				return TRUE;
			}
			return FALSE;
		}
		if($credit_type==2){
			$info = pdo_fetch("select credit1,credit2 from".tablename('tg_member')."where uid=:uid and uniacid=:uniacid",array(':uid'=>$uid,':uniacid'=>$_W['uniacid']));
			if(pdo_update("tg_member",array('credit2'=>$info['credit2']+$credit2),array('uid'=>$uid,'uniacid'=>$_W['uniacid']))){
				$data=array(
					'uid'=>$uid,
					'uniacid'=>$_W['uniacid'],
					'openid'=>'',
					'num'=>$credit2,
					'createtime'=>TIMESTAMP,
					'status'=>1,
					'type'=>2,
					'paytype'=>2,
					'table'=>2,
					'remark'=>$remark
				);	
				pdo_insert("tg_credit_record",$data);	
				return TRUE;
			}
			return FALSE;
		}
		
	}
	
