<?php
global $_W, $_GPC;
$traid=intval($_GPC['traid']);


	
	$result = pdo_delete('nx_information_transfer', array('traid' => $traid));
	
	
	if(!empty($result)){
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
	


?>