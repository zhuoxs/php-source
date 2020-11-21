<?php
	global $_W,$_GPC;
	include 'common.php';
	
	$mid=intval($_GPC['mid']);
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);

	
	$res=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_messages')."  WHERE weid=" . $_W['uniacid'] . " AND mid=".$mid." AND usertype=2 ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
	
		$ht = '';
        foreach ($res as $key => $item) {
       	
        $ht.='<div class="mui-col-xs-12 c-wh uc-a1 p10 mb05 oneinfo dz" onclick="openmessageinfo('.$item['id'].')">';
        			
				$ht.='<p class="ubb b-gra t-sbla"><span class="am-icon-star t-gre"></span> 新订单';
				
				if ($item['status']==0){
					$ht.=' <img class="cbg mr05" src="../addons/nxb_community/myui/img/newdd.png" style="border-radius:4px;">';
				}
					
				$ht.='</p>'
				.'<p>'.$item['content'].'</p>'
			.'</div>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>