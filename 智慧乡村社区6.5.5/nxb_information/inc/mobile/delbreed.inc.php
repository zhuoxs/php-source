<?php
global $_W, $_GPC;
$breid=intval($_GPC['breid']);


	
	$result = pdo_delete('nx_information_breed', array('breid' => $breid));
	
	
	if(!empty($result)){
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
	


?>