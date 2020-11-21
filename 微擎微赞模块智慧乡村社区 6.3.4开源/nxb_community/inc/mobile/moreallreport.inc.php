<?php
	global $_W,$_GPC;
	include 'common.php';
	$id=$_GPC['id'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT a.*,b.avatar FROM " . tablename('bc_community_report') . " as a left join ".tablename('bc_community_member')." as b on a.mid=b.mid WHERE a.weid=" . $_W['uniacid'] . " AND newsid=".$id." ORDER BY reid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
         
        $ht.='<div class="mui-row oneinfo pt05 pb05 ubb b-gra">';
        		$ht.='<div class="mui-col-xs-2 tx-c"><img src="'.tomedia($item['avatar']).'" class="xtx"></div><div class="mui-col-xs-10 pl05 pr05">'
						.'<div class="mui-row">'
							.'<div class="mui-col-xs-12 mb05 text_overflow">'.$item['username'].'&nbsp;&nbsp;<span class="ulev-1 t-gra">'.$item['telephone'].'</div>'
							.'<div class="mui-col-xs-12 ulev-1 t-gra">'
								.getgaptime($item['createtime'])
							.'</div>'
							
						.'</div>'						
					.'</div>';
				$ht.='</div>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>