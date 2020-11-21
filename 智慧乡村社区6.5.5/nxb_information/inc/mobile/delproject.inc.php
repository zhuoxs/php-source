<?php
global $_W, $_GPC;
$proid=intval($_GPC['proid']);


	
	$result = pdo_delete('nx_information_project', array('proid' => $proid));
	
	
	if(!empty($result)){
            echo json_encode(array('status'=>1,'log'=>'删除成功'));
        }else{
            echo json_encode(array('status'=>0,'log'=>'删除失败'));
        }
	


?>