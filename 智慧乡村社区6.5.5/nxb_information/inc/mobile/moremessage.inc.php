<?php
	global $_W,$_GPC;
	include 'common.php';
	$weid=$_W['uniacid'];
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);

	
	$res = pdo_fetchall("SELECT a.*,b.huzhu,c.cname FROM " . tablename('nx_information_message') . " as a left join ".tablename('nx_information_hus')." as b on a.hid=b.hid left join ".tablename('nx_information_cadre')." as c on a.cadid=c.cadid WHERE a.weid=" . $weid." ORDER BY mesid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	
        	$ht.='<li class="mui-table-view-cell mui-media oneinfo">'
        		.'<a class="mui-navigate-right" href="'.$this->createMobileUrl('message_info',array('mesid'=>$item['mesid'])).'">';
        		
            		$ht.='<div class="mui-media-body">'
                		.'户主：'.$item['huzhu'].' & 干部：'.$item['cname']
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