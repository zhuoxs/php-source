<?php
	global $_W,$_GPC;
	include 'common.php';

	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res=pdo_fetchall("SELECT * FROM ".tablename('bc_community_help')." WHERE weid=" . $_W['uniacid'] . " ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
	
		$ht = '';
        foreach ($res as $key => $item) {
       	
        $ht.='<div class="mui-col-xs-6 oneinfo"><div class=" mui-card">';
        		$ht.='<a href="'. $this->createMobileUrl('help_info',array('id'=>$item['id'])).'"><div class="mui-card-header mui-card-media" style="height:40vw;background-image:url('.tomedia($item['cover']).')"></div></a>'
				
				.'<div class="mui-card-footer">'
					.'<a class="mui-card-link">'.$item['uname'].'</a>'
					.'<a class="mui-card-link" href="'. $this->createMobileUrl('help_info',array('id'=>$item['id'])).'">去他家看看</a>'
				.'</div>';
		$ht.='</div></div>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>