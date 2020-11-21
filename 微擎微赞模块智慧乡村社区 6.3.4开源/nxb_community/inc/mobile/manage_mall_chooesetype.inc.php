<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);


	
	
	$result = pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_category')." WHERE weid=:uniacid AND pid=:pid ORDER BY id DESC",array(':uniacid'=>$_W['uniacid'],':pid'=>$id));
	
	
	if (!empty($result)) {
		
		$ht = '';
        foreach ($result as $key => $item) {
       	
        $ht.='<span class="mr05 mb05 t-gra" id="stype'.$item['id'].'" onclick="chooesestype('.$item['id'].');">'.$item['ctitle'].'</span>';
		
		}
		
		echo json_encode(array('status'=>1,'log'=>$ht,'id'=>$id));
	} else {
		echo json_encode(array('status'=>0,'log'=>'失败','id'=>$id));
	}
	
	
	
