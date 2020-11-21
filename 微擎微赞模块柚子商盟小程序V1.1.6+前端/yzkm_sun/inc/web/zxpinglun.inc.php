<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'fieldset_display';
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where =" WHERE a.uniacid=".$_W['uniacid'];
// $where=" where b.uniacid=:uniacid";
// $data[':uniacid']=$_W['uniacid'];
if(!empty($_GPC['keywords'])){
    $where.=" and  b.content LIKE  concat('%', :name,'%') ";
    $data[':name']=$_GPC['keywords'];   
}		
$sql="select a.* ,b.content,c.name from " . tablename("yzkm_sun_comment_yh") . " a"  . " left join " . tablename("yzkm_sun_zx") . " b on a.fabu_zx_id=b.id "  . " left join " . tablename("yzkm_sun_user") . " c on a.pl_user_openid=c.id ".$where." order by a.id DESC";
// p($list);die;
$total=pdo_fetchcolumn("select count(*) from " . tablename("yzkm_sun_comment_yh") . " a"  . " left join " . tablename("yzkm_sun_zx") . " b on a.fabu_zx_id=b.id "  . " left join " . tablename("yzkm_sun_user") . " c on a.pl_user_openid=c.openid ".$where,$data);

	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
	$list=pdo_fetchall($select_sql,$data);
	$pager = pagination($total, $pageindex, $pagesize);
// p($list);die;
	if($operation=='info'){
		$sql="select a.* ,b.name from " . tablename("yzkm_sun_comment_yh") ." a" . " left join " . tablename("zhjd_user") . " b on b.id=a.user_id where a.uniacid=:uniacid and a.id=:id";
		$list=pdo_fetch($sql, array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));
		include $this->template('web/pingluninfo');
	}
	// if(checksubmit('submit2')){
	// 	//保存回复
	// 	$result = pdo_update('yzkm_sun_comment_yh', array('reply' => $_GPC['reply'],'status'=>2,'reply_time'=>date("Y-m-d H:i:s")), array('id' =>  $_GPC['id']));
	// 	if($result){
	// 		message('回复成功',$this->createWebUrl('zxpinglun',array()),'success');
	// 	}else{
	// 		message('回复失败','','error');
	// 	}
	// }


	if($operation=='delete'){
		$res=pdo_delete('yzkm_sun_comment_yh',array('id'=>$_GPC['id']));
		if($res){
			message('删除成功',$this->createWebUrl('zxpinglun',array()),'success');
		}else{
			message('删除失败','','error');
		}
	}


include $this->template('web/zxpinglun');