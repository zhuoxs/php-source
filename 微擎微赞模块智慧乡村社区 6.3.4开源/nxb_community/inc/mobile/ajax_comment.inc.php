<?php
    global $_W,$_GPC;
	include 'common.php';
	$weid=intval($_GPC['weid']);
	$id=intval($_GPC['id']);
    $content=$_GPC['content'];
	$mid=$this->get_mid();

	
    $newdata=array(
		'weid'=>$weid,			
		'newsid'=>$id,
		'mid'=>$mid,		
		'comment'=>$content,
		'cctime'=>time()
	);
	$res=pdo_insert('bc_community_comment',$newdata);
	if(!empty($res)){
			
		$data=pdo_fetch("SELECT a.*,b.avatar,b.nickname FROM ".tablename('bc_community_comment')." as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid WHERE a.weid=".$weid." AND newsid=".$id." AND a.mid=".$mid." ORDER BY cid DESC limit 1");
		$data['ntime']='刚刚';
		$data['avatar']=tomedia($data['avatar']);
		echo json_encode($data);
	}
    
  

?>