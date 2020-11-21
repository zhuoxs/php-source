<?php
global $_W, $_GPC;
$pid=intval($_GPC['pid']);


	
	$result = pdo_delete('nx_information_pinkuns', array('pid' => $pid));
	
	
	if(!empty($result)){
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
	


?>