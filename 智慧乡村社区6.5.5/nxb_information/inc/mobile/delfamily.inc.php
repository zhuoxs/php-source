<?php
global $_W, $_GPC;
$fid=intval($_GPC['fid']);


	
	$result = pdo_delete('nx_information_family', array('fid' => $fid));
	
	
	if(!empty($result)){
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
	


?>