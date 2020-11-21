<?php
	global $_W,$_GPC;
	include 'common.php';
	$mid=$_GPC['mid'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	$sx=$_GPC['sx'];

	$pstatus=$_GPC['status'];


	$cxtj="";
	if($pstatus=='' ){	
		$cxtj="";
	}else{
		if($pstatus==1 || $pstatus==0){
			$cxtj=" AND pstatus=".$pstatus;		
		}else if($pstatus==2){
			$cxtj="";
		}
		
	}

	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_proposal') . "  WHERE weid=" . $_W['uniacid'] .$cxtj." ORDER BY pid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        $ht.='<div class="mui-row c-wh oneinfo mb1" id="pro'.$item['pid'].'">'
				.'<div class="mui-col-xs-12">'
					.'<ul class="mui-table-view">'
    					.'<li class="mui-table-view-cell dz" onclick="ck('.$item['pid'].')">';
							if($item['pstatus']==0){
								$ht.='<button type="button" class="mui-btn mui-btn-primary">已处理</button>';
							}else{
								$ht.='<button type="button" class="mui-btn mui-btn-danger">未处理</button>';
							}      					
        					$ht.='&nbsp;'.gettypename($item['weid'],$item['ptype'])
    					.'</li>'
    					.'<li class="mui-table-view-cell ulev-1 t-gra">&nbsp;建议日期：'.gettime($item['pctime']);
							if($item['pstatus']==1){
    							$ht.='<span class="mui-icon mui-icon-trash fr dz"  style="font-size:24px;" onclick="del('.$item['pid'].')"></span>&nbsp;&nbsp;';
    						}
    					$ht.='</li>'   
					.'</ul>'
				.'</div>'
			.'</div>';
			
			
			
       
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>