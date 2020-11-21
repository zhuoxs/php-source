<?php
global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'fieldset_display';
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
// $where=" where a.uniacid=:uniacid";
$where = " WHERE  a.uniacid=".$_W['uniacid'];
if(!empty($_GPC['keywords'])){
    $where.=" and a.details LIKE  concat('%', :name,'%') ";
    $data[':name']=$_GPC['keywords'];   
}	
// $data[':uniacid']=$_W['uniacid'];
$sql="select a.uniacid,a.id,a.details,a.time,b.store_name as sj_name,c.name from " . tablename("yzkm_sun_comments") . " a left join " . tablename("yzkm_sun_store") . " b on a.store_id=b.id left join " . tablename("yzkm_sun_user") . " c on a.userId=c.id ".$where;


$total=pdo_fetchcolumn("select count(*) from " . tablename("yzkm_sun_comments") . " a left join " . tablename("yzkm_sun_store") . " b on a.store_id=b.id left join " . tablename("yzkm_sun_user") . " c on a.userId=c.id ".$where,$data);
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list=pdo_fetchall($select_sql,$data);
	// p($list);die;
	$pager = pagination($total, $pageindex, $pagesize);

	if($operation=='delete'){
		$res=pdo_delete('yzkm_sun_comments',array('id'=>$_GPC['id']));
		if($res){
			message('删除成功',$this->createWebUrl('sjpinglun',array()),'success');
		}else{
			message('删除失败','','error');
		}
	}


include $this->template('web/sjpinglun');