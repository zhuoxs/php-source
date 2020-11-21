<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);


	
	
	$result = pdo_fetchall("SELECT * FROM ".tablename('bc_community_town')." WHERE weid=:uniacid AND lev=3 AND pid=:pid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':pid'=>$id));
	
	
	if (!empty($result)) {
		
		$ht = '';
        foreach ($result as $key => $item) {
        
        $ht.='<span class="mr05 mb05 t-gra" id="vil'.$item['id'].'" onclick="chooesevil('.$item['id'].');">'.$item['name'].'</span>';
		
		}
		
		echo json_encode(array('status'=>1,'log'=>$ht,'id'=>$id));
	} else {
		echo json_encode(array('status'=>0,'log'=>'失败','id'=>$id));
	}
	
	
	
