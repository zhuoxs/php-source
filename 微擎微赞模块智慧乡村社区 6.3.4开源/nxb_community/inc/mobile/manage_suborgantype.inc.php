<?php

global $_W,$_GPC;
 
	
	$weid=intval($_GPC['weid']);
	$townid=intval($_GPC['townid']);
	$villageid=intval($_GPC['villageid']);
	$organname=$_GPC['organname'];
	
	$newdata = array(
		'weid'=>$weid,
		'townid'=>$townid,
		'villageid'=>$villageid,
		'organname'=>$organname,			
		'ctime'=>time(),
	);
	
	$res = pdo_insert('bc_community_organlev', $newdata);
	if($res){
		$id = pdo_insertid();

		echo json_encode(array('status'=>1,'log'=>'添加成功！','id'=>$id,'organname'=>$organname));
		
	}else{
		
		echo json_encode(array('status'=>0,'log'=>'添加失败！'));
		
	}
			
		
	          
    

?>