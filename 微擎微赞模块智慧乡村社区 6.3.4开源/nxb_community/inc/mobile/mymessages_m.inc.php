<?php
	global $_W,$_GPC;
	include 'common.php';

	$mid=intval($_GPC['mid']);
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res=pdo_fetchall("SELECT * FROM ".tablename('bc_community_messages')." WHERE weid=" . $_W['uniacid'] . " AND mid=".$mid." ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
	
		$ht = '';
        foreach ($res as $key => $item) {
       	$newdd=getnewddone($item['weid'],$item['mid'],$item['id']);

        $ht.='<div class="mui-card oneinfo c-wh">';
        		
				$ht.='<div class="mui-card-header mui-card-media">';
					$ht.='<div class="mui-media-body ml0">'.$item['title'];
					if ($newdd==1){
						$ht.='&nbsp;&nbsp;&nbsp;<img class="newdd cbg" src="/addons/bc_community/myui/img/newdd.png">';
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