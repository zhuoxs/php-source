<?php
	global $_W,$_GPC;
	include 'common.php';
	$weid=$_W['uniacid'];
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);

	
	$res = pdo_fetchall("SELECT * FROM " . tablename('nx_information_family') . " WHERE weid=" . $weid." ORDER BY hid DESC,fid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	$images='';
        	$img=explode("|",$item['favatar']);
			if(!empty($img)){
				$images=$img[0];
			}
        	$ht.='<li class="mui-table-view-cell mui-media oneinfo">'
        		.'<a class="mui-navigate-right" href="'.$this->createMobileUrl('family_info',array('fid'=>$item['fid'])).'">';
        		if($images!=''){
        			$ht.='<img class="mui-media-object mui-pull-left tx" src="'.tomedia($images).'">';
        		}
        		
            		
            		$ht.='<div class="mui-media-body">'
                		.$item['fname']
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