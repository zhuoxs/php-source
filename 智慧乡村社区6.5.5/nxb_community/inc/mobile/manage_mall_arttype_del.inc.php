<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);

//查询此分类下是否有文章
$res=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_article')." WHERE pid=:pid ORDER BY id DESC",array(':pid'=>$id));
if($res){
	echo json_encode(array('status'=>2,'log'=>'此分类下有文章，请删除文章再删除分类'));
}else{
	
	$result = pdo_delete('bc_community_mall_arttype', array('id' => $id));
	
	if (!empty($result)) {
		echo json_encode(array('status'=>1,'log'=>'删除成功','id'=>$id));
	} else {
		echo json_encode(array('status'=>0,'log'=>'删除失败'));
	}
}	
	
	
