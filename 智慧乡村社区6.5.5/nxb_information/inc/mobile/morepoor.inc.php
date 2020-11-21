<?php
	global $_W,$_GPC;
	include 'common.php';
	$weid=$_W['uniacid'];
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);

	
	$res = pdo_fetchall("SELECT a.*,b.huzhu FROM " . tablename('nx_information_pinkuns') . " as a left join ".tablename('nx_information_hus')." as b on a.hid=b.hid WHERE a.weid=" . $weid." ORDER BY pid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	
        	$ht.='<li class="mui-table-view-cell mui-media oneinfo">'
        		.'<a class="mui-navigate-right" href="'.$this->createMobileUrl('poor_info',array('pid'=>$item['pid'])).'">';
        		
            		$ht.='<div class="mui-media-body">'
                		.'户主：'.$item['huzhu']
                	.'<p class="mui-ellipsis">家庭编码：'.$item['bianma'].' 致贫原因：';
                	if($item['reason']==1){
                		$ht.='因灾';
                	}else if($item['reason']==2){
                		$ht.='因病';
					}else if($item['reason']==3){
                		$ht.='因残';
					}else if($item['reason']==4){
                		$ht.='因学';
					}else if($item['reason']==5){
                		$ht.='缺技术';
					}else if($item['reason']==6){
                		$ht.='缺水';
					}else if($item['reason']==7){
                		$ht.='缺劳力';
					}else if($item['reason']==8){
                		$ht.='自身发展不足';
                	}else if($item['reason']==9){
                		$ht.='其他';
                	}
                	$ht.='</p>'
            	.'</div>'
        		
        		
        		.'</a>'
    		.'</li>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>