<?php
	global $_W,$_GPC;
	include 'common.php';
	$cx=$_GPC['cx'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_mall_orders') . " WHERE weid=" . $_W['uniacid'] . $cx."  ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
         
		
        $ht.='<tr class="oneinfo" id="m'.$item['id'].'">'
        			.'<td style="width:10%">'.$item['id'].'</td>'
        			.'<td style="width:10%"><img src="'.tomedia($item['pcover']).'" style="width:50px;height:50px;border-radius:4px"></td>'
        			.'<td style="width:20%">'.$item['pocode'].'</td>'
					.'<td style="width:40%;text-align:left;"><p style="padding:5px;">'.$item['poinfo'].'</p></td>'
					.'<td style="width:10%">'.getorderstatus($item['postatus']).'</td>'
					.'<td style="width:10%">';
						$ht.='<a href="'.$this->createMobileUrl('manage_mall_order_edit',array('id'=>$item['id'])).'"><button type="button" class="mui-btn mui-btn-primary">查看</button></a>';
					$ht.='</td>'
			.'</tr>';
				
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht,'cx'=>$cx));
        }
	

?>