<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'fieldset_display';
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=" where b.uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];
if(!empty($_GPC['keywords'])){
	$keywords=$_GPC['keywords'];
    $where.=" and  c.name LIKE  concat('%', :name,'%') ";
    $data[':name']=$_GPC['keywords'];   
}	
if(!empty($_GPC['active'])){
	$active=$_GPC['active'];
    $where.=" and  b.name LIKE  concat('%', :name,'%') ";
    $data[':name']=$_GPC['active'];   
}		
$sql="select a.id,a.content,a.time,b.name as title,c.name from " . tablename("byjs_sun_activityping") . " a"  . " left join " . tablename("byjs_sun_activitys") . " b on a.aid=b.id left join" . tablename("byjs_sun_user") . " c on a.uid=c.id".$where." order by a.id DESC";
// p($sql);
$total=pdo_fetchcolumn("select count(*) from " . tablename("byjs_sun_activityping") . " a"  . " left join " . tablename("byjs_sun_activitys") . " b on a.aid=b.id left join" . tablename("byjs_sun_user") . " c on a.uid=c.id".$where,$data);

	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list=pdo_fetchall($select_sql,$data);
	$pager = pagination($total, $pageindex, $pagesize);
foreach ($list as $key => $value) {
	$list[$key]['time']=date('Y-m-d H:i:s',$list[$key]['time']);
}
	// if($operation=='info'){
	// 	$sql="select a.* ,b.name from " . tablename("yzcj_sun_zx_assess") ." a" . " left join " . tablename("zhjd_user") . " b on b.id=a.user_id where a.uniacid=:uniacid and a.id=:id";
	// 	$list=pdo_fetch($sql, array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));
	// 	include $this->template('web/pingluninfo');
	// }
	// if(checksubmit('submit2')){
	// 	//保存回复
	// 	$result = pdo_update('yzcj_sun_zx_assess', array('reply' => $_GPC['reply'],'status'=>2,'reply_time'=>date("Y-m-d H:i:s")), array('id' =>  $_GPC['id']));
	// 	if($result){
	// 		message('回复成功',$this->createWebUrl('zxpinglun',array()),'success');
	// 	}else{
	// 		message('回复失败','','error');
	// 	}
	// }


	if($operation=='delete'){
		$res=pdo_delete('byjs_sun_activityping',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
		if($res){
			message('删除成功',$this->createWebUrl('zxpinglun',array()),'success');
		}else{
			message('删除失败','','error');
		}
	}


include $this->template('web/zxpinglun');