<?php
global $_W, $_GPC;
$recid=intval($_GPC['recid']);


	
	$result = pdo_delete('nx_information_record', array('recid' => $recid));
	
	
	if(!empty($result)){
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
	


?>