<?php
	global $_W,$_GPC;
	include 'common.php';
	$weid=$_W['uniacid'];
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);

	
	$res = pdo_fetchall("SELECT a.*,b.huzhu FROM " . tablename('nx_information_transfer') . " as a left join ".tablename('nx_information_hus')." as b on a.hid=b.hid WHERE a.weid=" . $weid." ORDER BY traid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	
        	$ht.='<li class="mui-table-view-cell mui-media oneinfo">'
        		.'<a class="mui-navigate-right" href="'.$this->createMobileUrl('transfer_info',array('traid'=>$item['traid'])).'">';
        		
            		$ht.='<div class="mui-media-body">'
                		.'户主：'.$item['huzhu']
                	.'<p class="mui-ellipsis">家庭编码：'.$item['bianma'].'</p>'
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