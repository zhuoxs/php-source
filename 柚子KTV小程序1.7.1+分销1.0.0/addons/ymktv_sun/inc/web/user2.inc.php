<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$where= " where uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];
if($_GPC['keywords']){
	$where.=" and name LIKE  concat('%', :name,'%')";
	 $data[':name']=$_GPC['keywords'];  
}
	$pageindex = max(1, intval($_GPC['page']));

	$pagesize=10;
	$sql="select *  from " . tablename("ymktv_sun_user") .$where;
	$select_sql =$sql." order by id desc LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list = pdo_fetchall($select_sql,$data);
	
	if($list){
		foreach ($list as $k=>$v){
			//获取余额
			$moneys = pdo_get('ymktv_sun_user_balance',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']));
			if(!$moneys){
				$moneys['money'] = 0;
			}
			$list[$k]['moneys'] = $moneys['money'];
		}
	}

	$total=pdo_fetchcolumn("select count(*) from " . tablename("ymktv_sun_user") .$where,$data);
	$pager = pagination($total, $pageindex, $pagesize);
	if($_GPC['op']=='delete'){
		$res4=pdo_delete("ymktv_sun_user",array('id'=>$_GPC['id']));
		if($res4){
		 message('删除成功！', $this->createWebUrl('user2'), 'success');
		}else{
			  message('删除失败！','','error');
		}
	}
		if($_GPC['op']=='defriend'){
		$res4=pdo_update("ymktv_sun_user",array('state'=>2),array('id'=>$_GPC['id']));
		if($res4){
		 message('拉黑成功！', $this->createWebUrl('user2',array('page'=>$_GPC['page'])), 'success');
		}else{
			  message('拉黑失败！','','error');
		}
	}
	if($_GPC['op']=='relieve'){
		$res4=pdo_update("ymktv_sun_user",array('state'=>1),array('id'=>$_GPC['id']));
		if($res4){
		 message('取消成功！', $this->createWebUrl('user2',array('page'=>$_GPC['page'])), 'success');
		}else{
			  message('取消失败！','','error');
		}
	}

	if($_GPC['op']=='modifymoney'){
		$id = $_GPC['id'];
		$money = floatval($_GPC['money']);
		$user = pdo_get('ymktv_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$id));
		$umoney = pdo_get('ymktv_sun_user_balance',array('uniacid'=>$_W['uniacid'],'openid'=>$user['openid']));
		$allmoney=floatval($money)+floatval($umoney['money']);
		
		if($allmoney<0){
			echo 3; //减少金额大于所剩余额
			exit;
		}else{
			$res = pdo_get("ymktv_sun_user_balance",array('uniacid'=>$_W['uniacid'],'openid'=>$user['openid']));
			if($res){
				$rmoney=pdo_update("ymktv_sun_user_balance",array('money +='=>$money),array('uniacid'=>$_W['uniacid'],'openid'=>$user['openid']));
			}else{
				$datas['openid'] = $user['openid'];
                $datas['money'] = $money;
                $datas['uniacid'] = $_W['uniacid'];
				$rmoney=pdo_insert("ymktv_sun_user_balance",$datas);
			}
			
			if($rmoney){
				$newData = array(
					'details_name'=>'后台修改',
					'details_money'=>$money,
					'uniacid'=>$_W['uniacid'],
					'addtime'=>time(),
					'openid'=>$user['openid']
				);
				$result=pdo_insert('ymktv_sun_detailed',$newData);
				if($result){
					echo 1; //修改成功
					exit;
				}else{
					echo 2; //修改失败
					exit;
				}
			}else{
				echo 2; //修改失败
				exit;
			}
		}
	}
	
include $this->template('web/user2');