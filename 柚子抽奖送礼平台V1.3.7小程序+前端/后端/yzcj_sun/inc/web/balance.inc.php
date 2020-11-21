<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$where= " where uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];
// ----------------审核状态--------------
if(!empty($_GPC['status'])&&empty($_GPC['keywords'])&&empty($_GPC['cid'])){
    $status = $_GPC['status'];
    $where.=" and status={$status} ";
}
	$pageindex = max(1, intval($_GPC['page']));

	$pagesize=10;
	$sql="select *  from " . tablename("yzcj_sun_balance") .$where;
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list = pdo_fetchall($select_sql,$data);

	$total=pdo_fetchcolumn("select count(*) from " . tablename("yzcj_sun_balance") .$where,$data);
	$pager = pagination($total, $pageindex, $pagesize);

		if($_GPC['op']=='sure'){
			$res4=pdo_update("yzcj_sun_balance",array('status'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
			// p($res4);die;
			if($res4){
			 	message('确认成功！', $this->createWebUrl('balance',array('page'=>$_GPC['page'])), 'success');
			}else{
				  message('确认失败！','','error');
			}
		}
	
include $this->template('web/balance');