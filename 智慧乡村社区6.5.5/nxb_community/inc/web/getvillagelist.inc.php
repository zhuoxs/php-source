<?php
	global $_W,$_GPC;
	//include 'common.php';
	
	$id=intval($_GPC['v']);
	$cx='';
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_town') . " WHERE weid=" . $_W['uniacid'] . " AND pid=".$id." ORDER BY id ASC");	
	
	

	
		$ht = '';
        foreach ($res as $key => $item) {
        	
        	$ht.='<option value="'.$item['id'].'">'.$item['name'].'</option>';

        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }

?>