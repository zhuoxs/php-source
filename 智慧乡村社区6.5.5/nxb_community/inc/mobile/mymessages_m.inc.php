<?php
	global $_W,$_GPC;
	include 'common.php';

	$mid=intval($_GPC['mid']);
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res=pdo_fetchall("SELECT A.*,B.title,B.ctime FROM ".tablename('bc_community_messages_record')." A LEFT JOIN ".tablename('bc_community_messages')." B ON A.message_id=B.id WHERE A.weid=" . $_W['uniacid'] . " AND A.mid=".$mid." ORDER BY B.ctime DESC LIMIT  ". $num . ",{$psize}");
	
	
		$ht = '';
        foreach ($res as $key => $item) {
        $ht.='<div class="mui-card oneinfo c-wh">';
        		
				$ht.='<div class="mui-card-header mui-card-media">';
					$ht.='<div class="mui-media-body ml0">'.$item['title'];
					if ($item['status']==0){
						$ht.='&nbsp;&nbsp;&nbsp;<img class="newdd cbg" src="'.MODULE_URL.'myui/img/newdd.png">';
					}
					
					$ht.='</div>'					
				.'</div>'
				.'<div class="mui-card-footer">'
					.'<a class="mui-card-link ulev-1 t-gra">'.gettime($item['ctime']).'</a>'
					.'<a href="'.$this->createMobileUrl('messagesinfo',array('id'=>$item['id'])).'" class="mui-card-link t-sbla">详情</a>'
				.'</div>';
				
		$ht.='</div>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>