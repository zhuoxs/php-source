<?php
	global $_W,$_GPC;
	include 'common.php';

	$id=intval($_GPC['id']);
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res=pdo_fetchall("SELECT * FROM ".tablename('bc_community_mall_article')." WHERE weid=" . $_W['uniacid'] . " AND pid=".$id." ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
	
		$ht = '';
        foreach ($res as $key => $item) {


        $ht.='<a href="'.$this->createMobileUrl('mall_articleinfo',array('id'=>$item['id'])).'"><div class="mui-row oneinfo mb05 pl05 pr05 pt05 pb05 c-wh">';

				$ht.='<div class="mui-col-xs-3 img100">';
				if ($item['cicon']!=''){
					$ht.='<img src="'.tomedia($item['cicon']).'" class="examprojectbg">';
				}
				
				$ht.='</div>';	
				
				$ht.='<div class="mui-col-xs-9 mt02 pl05">'
					.'<div class="mui-row">'
						.'<div class="mui-col-xs-12 t-sbla lineover1">'.$item['ctitle'].'</div>'
						.'<div class="mui-col-xs-12 t-gra ulev-1">时间：'.gettime($item['ctime']).' 浏览量：'.$item['clidk'].'</div>'
						
					.'</div>'
				.'</div>';
				
		$ht.='</div></a>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>