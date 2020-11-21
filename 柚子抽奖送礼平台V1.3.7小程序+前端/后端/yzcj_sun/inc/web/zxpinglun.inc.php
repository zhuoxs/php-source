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
$sql="select a.* ,b.content as title,b.id as cid,c.name from " . tablename("yzcj_sun_content") . " a"  . " left join " . tablename("yzcj_sun_circle") . " b on a.cid=b.id left join" . tablename("yzcj_sun_user") . " c on a.uid=c.id".$where." order by a.id DESC";
$total=pdo_fetchcolumn("select count(*) from " . tablename("yzcj_sun_content") . " a" . " left join " . tablename("yzcj_sun_circle") . " b on a.cid=b.id left join" . tablename("yzcj_sun_user") . " c on a.uid=c.id".$where,$data);

	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list=pdo_fetchall($select_sql,$data);
	$pager = pagination($total, $pageindex, $pagesize);

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
		$res=pdo_delete('yzcj_sun_content',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
		if($res){
			message('删除成功',$this->createWebUrl('zxpinglun',array()),'success');
		}else{
			message('删除失败','','error');
		}
	}


include $this->template('web/zxpinglun');