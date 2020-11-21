<?php
	global $_W,$_GPC;
	include 'common.php';


	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	$bianma=$_GPC['bianma'];
	
	$res = pdo_fetchall("SELECT a.*,b.huzhu FROM " . tablename('nx_zhvillage__breed') . " as a left join ".tablename('nx_zhvillage__hus')." as b on a.hid=b.hid WHERE a.weid=:uniacid AND a.bianma=:bianma ORDER BY breid DESC LIMIT  ". $num . ",{$psize}",,array(':uniacid'=>$_W['uniacid'],':bianma'=>$bianma));	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	
        	$ht.='<li class="mui-table-view-cell mui-media oneinfo">'
        		.'<a class="mui-navigate-right" href="'.$this->createMobileUrl('breed_info',array('breid'=>$item['breid'])).'">';
        		
            		$ht.='<div class="mui-media-body">'
                		.'户主：'.$item['huzhu'].' | 品种：'.$item['varieties']
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