<?php
			global $_GPC, $_W;
			$cfg=$this->module['config'];
			$uid=$_GPC['uid'];
			if(empty($uid)){
				$result = array("errcode" => 1, "errmsg" => '用户信息不存在1');
				die(json_encode($result));
			}
			$member=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
			//结束

			if (empty($member)) {
					$result = array("errcode" => 1, "errmsg" => '用户信息不存在2');
					die(json_encode($result));
			}
		
			$appset= pdo_fetch("SELECT * FROM " . tablename("tiger_app_tuanzhangset") . " WHERE weid='{$_W['uniacid']}' order by px desc ");
			
			if($appset['sjtype']==1){
				$dlfs = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and helpid='{$member['id']}' and dltype=1");//粉丝
			}else{
				$dlfs = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and helpid='{$member['id']}'");//粉丝
			}
			$dlorder = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_tkorder")." where weid='{$_W['uniacid']}' and tgwid='{$member['tgwid']}'");//粉丝
			
			if($appset['fsm']>$dlfs){
				$result = array("errcode" => 1, "errmsg" => '人数未达到，暂不能申请！');
				die(json_encode($result));
			}
			if($appset['ordermsum']>$dlorder){
				$result = array("errcode" => 1, "errmsg" => '订单数未达到，暂不能申请！');
				die(json_encode($result));
			}
			
			$dldata=array(
						'helpid'=>0,
						'tztype'=>1,//1是团长
						'tztime'=>time(),
						'tzendtime'=>time()+365*24*60*60
			);		
			pdo_update("tiger_newhu_share", $dldata, array('weid' => $_W['uniacid'],'id'=>$member['id']));
			
			$result = array("errcode" => 0, "errmsg" => '团长申请成功！');
			die(json_encode($result));

			
?>