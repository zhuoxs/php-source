<?php
	global $_W,$_GPC;
	include 'common.php';
	$mid=$_GPC['mid'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_mall_wallet') . " WHERE weid=" . $_W['uniacid'] . " AND mid=".$mid." ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	$color='t-gre';
         	if($item['type']==2 || $item['type']==3){
         		$color='t-red';
         	}
		
        $ht.='<div class="mui-row ml05 mr05 c-wh mt05 pt05 uc-a1 pl05 pr05 oneinfo">'
    	.'<div class="mui-col-xs-12 ulev-1 t-sbla pt02 pb02">'
    		.'<span class="fb">';
    		if($item['type']==1){
    			$ht.='订单收入';
    		}else if($item['type']==2){
    			$ht.='提现';
    		}else if($item['type']==3){
    			$ht.='平台交易手续费';
    		}
    		 $ht.='</span>'
    		.'<span class="fr fb '.$color.'">'.$item['amount'].'</span>'
    	.'</div>'
    	.'<div class="mui-col-xs-12 ulev-1 t-sbla pt02 pb02">'
    		.'<span class="fb t-gra">2018-07-17 10:00</span>'
    		.'<span class="fr t-gre">';
    			if($item['status']==1){
    				$ht.='已完成';
    			}else if($item['status']==0){
    				$ht.='未审核';   		
    			}
    		 $ht.='</span>'
    	.'</div>'

    	.'</div>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>