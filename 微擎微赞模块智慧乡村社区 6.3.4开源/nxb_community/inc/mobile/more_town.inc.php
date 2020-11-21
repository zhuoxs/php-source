<?php
	global $_W,$_GPC;
	include 'common.php';
	$weid=$_W['uniacid'];
	$id=intval($_GPC['id']);	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	

	
	$cxtj="";
	
	
	
	
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_town') . " WHERE weid=".$weid." AND lev=3 ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	$n=$key+1;

        $ht.='<a href="'.$this->createMobileUrl('village_index',array('id'=>$item['id'])).'"><div class="mui-row oneinfo">';
        		$ht.='<div class="mui-col-xs-3 pt1 pb1 tx-c">'
					.'<img src="'.tomedia($item['cover']).'" class="xtx">'					
				.'</div>'
				.'<div class="mui-col-xs-9 pt1 pb1 pl05">'
					.'<div class="mui-row">'
						.'<div class="mui-col-xs-12">'
							.'<span class="t-sbla">第'.$n.'名 '.$item['name'].'</span>'
							.'<span class="t-gra ulev-1"> <span class="mui-icon mui-icon-location t-gra ulev1"></span>'.$item['remark'].'</span>'
						.'</div>'
						.'<div class="mui-col-xs-12">'
							.'<div class="mui-row pt05 pb05">'
								.'<div class="mui-col-xs-4 tx-c ubr b-gra ulev-1 t-gra">认证村民<br><span class="t-green">'.getvillageuser($item['weid'],$item['id']).'人</span></div>'
								.'<div class="mui-col-xs-4 tx-c ubr b-gra ulev-1 t-gra">关注人数<br><span class="t-green">'.getvillagegzuser($item['weid'],$item['id']).'人</span></div>'
								.'<div class="mui-col-xs-4 tx-c ulev-1 t-gra">热度值<br><span class="t-green">'.getvillagebbs($item['weid'],$item['id']).'</span></div>'
							.'</div>'
						.'</div>'		
					.'</div>'					
				.'</div><div class="uw pt02 c-qqh"></div>';
				
		$ht.='</div></a>';

        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>