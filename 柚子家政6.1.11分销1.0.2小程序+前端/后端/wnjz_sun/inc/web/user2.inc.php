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
	$sql="select *  from " . tablename("wnjz_sun_user") .$where;
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list = pdo_fetchall($select_sql,$data);	

	$total=pdo_fetchcolumn("select count(*) from " . tablename("wnjz_sun_user") .$where,$data);
	$pager = pagination($total, $pageindex, $pagesize);
	if($_GPC['op']=='delete'){
		$res4=pdo_delete("wnjz_sun_user",array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
		if($res4){
		 message('删除成功！', $this->createWebUrl('user2'), 'success');
		}else{
			  message('删除失败！','','error');
		}
	}
		if($_GPC['op']=='defriend'){
		$res4=pdo_update("wnjz_sun_user",array('state'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
		if($res4){
		 message('拉黑成功！', $this->createWebUrl('user2',array('page'=>$_GPC['page'])), 'success');
		}else{
			  message('拉黑失败！','','error');
		}
	}
		if($_GPC['op']=='relieve'){
		$res4=pdo_update("wnjz_sun_user",array('state'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
		if($res4){
		 message('取消成功！', $this->createWebUrl('user2',array('page'=>$_GPC['page'])), 'success');
		}else{
			  message('取消失败！','','error');
		}
	}

if($_GPC['op']=='modifymoney'){
	$id = $_GPC['id'];
	$money = $_GPC['money'];
	$user = pdo_get('wnjz_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$id));
	$allmoney=$money+$user['money'];
	if($allmoney<0){
		echo 3; //减少金额大于所剩余额
	}else{
		$rmoney=pdo_update("wnjz_sun_user",array('money +='=>$money),array('uniacid'=>$_W['uniacid'],'id'=>$id));
		if($rmoney){
			$newData = array(
				'r_name'=>$user['name'],
				'r_img'=>$user['img'],
				'uniacid'=>$_W['uniacid'],
				'r_time'=>date('Y-m-d H:i:s',time()),
				'r_money'=>$money
			);
			$result=pdo_insert('wnjz_sun_recharges',$newData);
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