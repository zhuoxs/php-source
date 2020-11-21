<?php
global $_W, $_GPC;
$id=intval($_GPC['id']);

//查询这个导航是自定义还是帖子导航
	$menu=pdo_fetch("SELECT * FROM ".tablename('bc_community_menu')." WHERE meid=:id",array(':id'=>$id));
	if($menu['jump']==1){
		$result = pdo_delete('bc_community_menu', array('meid' =>$id));
		
		if (!empty($result)) {
			echo json_encode(array('status'=>1,'log'=>'删除成功'));
		} else {
			echo json_encode(array('status'=>0,'log'=>'删除失败'));
		}
		
	}else{
		//查询该分类下是否有帖子 
		$bbs=pdo_fetchall("SELECT * FROM ".tablename('bc_community_news')." WHERE weid=:uniacid AND nmenu=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$id));
		if(!empty($bbs)){
			echo json_encode(array('status'=>2,'log'=>'该分类下有帖子，请删除帖子再删除分类'));
		}else{
			
			$result = pdo_delete('bc_community_menu', array('meid' =>$id));
			
			if (!empty($result)) {
				echo json_encode(array('status'=>1,'log'=>'删除成功'));
			} else {
				echo json_encode(array('status'=>0,'log'=>'删除失败'));
			}
			
			
		}
		
	}
	
	
	
	
	
	
	
	
	
	
