<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();


// p($_GPC['id']);
$sql="select a.* ,b.name from " . tablename("yzcj_sun_circle") ." a" . " left join " . tablename("yzcj_sun_user") . "b on b.id=a.uid where a.uniacid=:uniacid and a.id=:id";
$list=pdo_fetch($sql, array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));

$list['img']= explode(',',$list['img']);  
// p($list);
// p($list['img']);
$pageindex = max(1, intval($_GPC['page']));
$pagesize=5;
$where= " where a.uniacid=". $_W['uniacid'] ." and a.cid=". $_GPC['id'];
$data[':uniacid']=$_W['uniacid'];
$data[':id']=$_GPC['id'];

$sql1="select a.*,b.name from" . tablename("yzcj_sun_content") ." a" . " left join " . tablename("yzcj_sun_user") . "b on b.id=a.uid ". $where;
$select_sql =$sql1." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$content = pdo_fetchall($select_sql,$data);

$total=pdo_fetchcolumn("select count(*) from " . tablename("yzcj_sun_content") ." a" . " left join " . tablename("yzcj_sun_user") . "b on b.id=a.uid". $where,$data);
$pager = pagination($total, $pageindex, $pagesize);


if($_GPC['op']=='delete'){
	$res=pdo_delete('yzcj_sun_content',array('id'=>$_GPC['cid'],'uniacid'=>$_W['uniacid']));
	if($res){
	 	message('删除成功！', $this->createWebUrl('pingluninfo', array('id' => $_GPC['id'])), 'success');
	}else{
		message('删除失败！','','error');
	}
}

include $this->template('web/pingluninfo');