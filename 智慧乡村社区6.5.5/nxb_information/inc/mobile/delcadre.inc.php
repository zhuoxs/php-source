<?php
global $_W, $_GPC;
$cadid=intval($_GPC['cadid']);


	
	
	$result = pdo_delete('nx_information_cadre', array('cadid' => $cadid));
	
	
	if(!empty($result)){
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
	


?>