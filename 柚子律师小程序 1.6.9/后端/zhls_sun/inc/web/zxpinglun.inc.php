<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'fieldset_display';
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=" where b.uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];
if(!empty($_GPC['keywords'])){
    $where.=" and  a.content LIKE  concat('%', :name,'%') ";
    $data[':name']=$_GPC['keywords'];   
}		
$sql="select a.* ,b.title from " . tablename("zhls_sun_zx_assess") . " a"  . " inner join " . tablename("zhls_sun_zx") . " b on a.zx_id=b.id ".$where." order by a.id DESC";
$total=pdo_fetchcolumn("select count(*) from " . tablename("zhls_sun_zx_assess") . " a" . " inner join " . tablename("zhls_sun_zx") . " b on a.zx_id=b.id  ".$where,$data);

	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list=pdo_fetchall($select_sql,$data);
	$pager = pagination($total, $pageindex, $pagesize);

	if($operation=='info'){
		$sql="select a.* ,b.name from " . tablename("zhls_sun_zx_assess") ." a" . " left join " . tablename("zhjd_user") . " b on b.id=a.user_id where a.uniacid=:uniacid and a.id=:id";
		$list=pdo_fetch($sql, array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));
		include $this->template('web/pingluninfo');
	}
	if(checksubmit('submit2')){
		//保存回复
		$result = pdo_update('zhls_sun_zx_assess', array('reply' => $_GPC['reply'],'status'=>2,'reply_time'=>date("Y-m-d H:i:s")), array('id' =>  $_GPC['id']));
		if($result){
			message('回复成功',$this->createWebUrl('zxpinglun',array()),'success');
		}else{
			message('回复失败','','error');
		}
	}


	if($operation=='delete'){
		$res=pdo_delete('zhls_sun_zx_assess',array('id'=>$_GPC['id']));
		if($res){
			message('删除成功',$this->createWebUrl('zxpinglun',array()),'success');
		}else{
			message('删除失败','','error');
		}
	}


include $this->template('web/zxpinglun');