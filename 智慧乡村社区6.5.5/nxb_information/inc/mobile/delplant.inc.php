<?php
global $_W, $_GPC;
$plaid=intval($_GPC['plaid']);


	
	$result = pdo_delete('nx_information_plant', array('plaid' => $plaid));
	
	
	if(!empty($result)){
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
	


?>