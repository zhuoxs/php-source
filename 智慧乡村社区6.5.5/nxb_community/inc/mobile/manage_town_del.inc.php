<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);


$count = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('bc_community_town')." WHERE pid=$id");
if($count>0){
    echo json_encode(array('status'=>0,'log'=>'删除失败，请先删除下属村！'));
}else{
    $result = pdo_delete('bc_community_town', array('id' => $id));
    if (!empty($result)) {
        echo json_encode(array('status'=>1,'log'=>'删除成功'));
    } else {
        echo json_encode(array('status'=>0,'log'=>'删除失败'));
    }
}
	
	

	
	
	
