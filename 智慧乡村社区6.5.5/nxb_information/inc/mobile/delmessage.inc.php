<?php
global $_W, $_GPC;
$mesid=intval($_GPC['mesid']);


	
	$result = pdo_delete('nx_information_message', array('mesid' => $mesid));
	
	
	if(!empty($result)){
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
	


?>