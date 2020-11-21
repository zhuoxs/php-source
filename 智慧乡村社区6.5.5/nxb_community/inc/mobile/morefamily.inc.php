<?php
	global $_W,$_GPC;
	include 'common.php';
	$weid=$_W['uniacid'];
	$bianma=$_GPC['bianma'];
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);

	
	$res = pdo_fetchall("SELECT * FROM " . tablename('nx_information_family') . " WHERE weid=:uniacid AND bianma=:bianma ORDER BY fid DESC LIMIT  ". $num . ",{$psize}",array(':uniacid'=>$_W['uniacid'],':bianma'=>$bianma));	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	
        	$ht.='<li class="mui-table-view-cell mui-media oneinfo">'
        		.'<a class="mui-navigate-right" href="'.$this->createMobileUrl('family_info',array('fid'=>$item['fid'])).'">';
        		
            		$ht.='<div class="mui-media-body">'
                		.$item['fname']
                	.'<p class="mui-ellipsis">户编码：'.$item['bianma'].'</p>'
            	.'</div>'
        		
        		
        		.'</a>'
    		.'</li>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht,'bianma'=>$bianma));
        }
	

?>