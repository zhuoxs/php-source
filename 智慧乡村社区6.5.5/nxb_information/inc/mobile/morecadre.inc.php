<?php
	global $_W,$_GPC;
	include 'common.php';
	$weid=$_W['uniacid'];
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);

	
	$res = pdo_fetchall("SELECT * FROM " . tablename('nx_information_cadre') . " WHERE weid=" . $weid." ORDER BY cadid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	$images='';
        	$img=explode("|",$item['avatar']);
			if(!empty($img)){
				$images=$img[0];
			}
        	$ht.='<li class="mui-table-view-cell mui-media oneinfo">'
        		.'<a class="mui-navigate-right" href="'.$this->createMobileUrl('cadre_info',array('cadid'=>$item['cadid'])).'">';
        			if($images!=''){
        				$ht.='<img class="mui-media-object mui-pull-left tx" src="'.tomedia($images).'">';
        			}
            		$ht.='<div class="mui-media-body">'.$item['cname']
                		.'<p class="mui-ellipsis">职务：'.$item['post'].'</p>'
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