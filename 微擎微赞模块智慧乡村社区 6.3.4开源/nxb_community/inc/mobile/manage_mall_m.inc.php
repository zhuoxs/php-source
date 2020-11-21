<?php
	global $_W,$_GPC;
	include 'common.php';
	$cx=$_GPC['cx'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_mall_goods') . " WHERE weid=" . $_W['uniacid'] . $cx."  ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
         
		
        $ht.='<div class="mui-col-xs-3 oneinfo" >'
				.'<div class="mui-card">'
					.'<div class="mui-card-header mui-card-media" style="height:160px;background-image:url('.tomedia($item['pimg']).');background-repeat:no-repeat;background-size:cover;"></div>'
						.'<div class="mui-card-content">'
							.'<div class="mui-card-content-inner">'
								.'<p>'
									.'<span class="fl t-red">¥ </span>'
									.'<span class="fl t-red fb">'.$item['price'].'</span>'
									.'<span class="fr ulev-1 t-gra">已售：'.$item['pyqty'].'</span>'
								.'</p>'
								.'<p style="color: #333;">'.$item['ptitle'].'</p>'
							.'</div>'
						.'</div>'
						.'<div class="mui-card-footer">'
							.'<a class="mui-card-link" href="javascript:;" onclick="opengoodsinfo('.$item['id'].')">查看</a>'
							
						.'</div>'
					.'</div>'
				.'</div>';
				
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>