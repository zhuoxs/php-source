<?php
	global $_W,$_GPC;
	include 'common.php';
	$cx=$_GPC['cx'];	
	$cx1=$_GPC['cx1'];
	if($cx1!=''){
		$cx=" AND ptitle LIKE'%".$cx1."%'";
	}
		
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_mall_goods') . " WHERE weid=" . $_W['uniacid'] .$cx." AND pstatus=1 ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	$nn='';
        	if($key%2==0){
        		$nn='gleft';
        	}else{
        		$nn='gright';
        	}
        	
        $ht.='<div class="mui-col-xs-6 oneinfo dz mt05 '.$nn.'" onclick="opengoodsinfo('.$item['id'].')">'
					.'<div class="mui-row c-wh">'
					.'<div class="mui-col-xs-12">'
						.'<img src="'.tomedia($item['pimg']).'" style="width:100%;height:185px;">'
					.'</div>'
					.'<div class="mui-col-xs-12 pl05 pr05 ulev-1 line1over">'
						.$item['ptitle']
					.'</div>'
					.'<div class="mui-col-xs-12 pl05 pr05 pt02 pb02">'
						.'<span class="fl t-red">¥ </span>'
						.'<span class="fl t-red fb">'.$item['price'].'</span>'
						.'<span class="fr ulev-1 t-gra">已售：'.$item['pyqty'].'</span>'
					.'</div>'
					.'</div>'
			.'</div>';
			
			
			
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht,'cx'=>$cx));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht,'cx'=>$cx));
        }
	

?>