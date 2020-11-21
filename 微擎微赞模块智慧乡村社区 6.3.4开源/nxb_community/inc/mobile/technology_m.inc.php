<?php
	global $_W,$_GPC;
	include 'common.php';
	$cx=$_GPC['cx'];
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_courselesson') . " WHERE weid=" . $_W['uniacid'] . $cx." ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	
        
		
        $ht.='<a href="'.$this->createMobileUrl('technology_info',array('id'=>$item['id'])).'"><div class="mui-row oneinfo pt05 pb05 ubb b-gra">';
        		if(!empty($item['cover'])){
					$ht.='<div class="mui-col-xs-3 pl05 pr05 img100">'
						.'<img src="'.tomedia($item['cover']).'" height="72" class="uc-a1">'					
					.'</div>'
					.'<div class="mui-col-xs-9 pr05">'
						.'<div class="mui-row">'
							.'<div class="mui-col-xs-12 mb05 text_overflow">'.$item['title'].'</div>'
							
							.'<div class="mui-col-xs-12 ulev-1 t-gra">'
								.'<span class="am-icon-folder t-green"> </span> 分类:'.gettechnologytype($item['typeid']).'&nbsp;&nbsp;<span class="am-icon-cloud-upload t-green"> </span> '.getgaptime($item['ctime']).''
							.'</div>'
						.'</div>'						
					.'</div>';
				}else{
					$ht.='<div class="mui-col-xs-12 pl05 pr05">'
						.'<div class="mui-row">'
							.'<div class="mui-col-xs-12 mb05 text_overflow">'.$item['title'].'</div>'
							
							.'<div class="mui-col-xs-6 tx-r ulev-1 t-gra">'
								.'<span class="am-icon-eye"> 分类:'.$item['typeid'].'</span>&nbsp;&nbsp;<span class="am-icon-commenting"> '.getgaptime($item['ctime']).'</span>'
							.'</div>'
						.'</div>'						
					.'</div>';
				}
				$ht.='</div></a>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>