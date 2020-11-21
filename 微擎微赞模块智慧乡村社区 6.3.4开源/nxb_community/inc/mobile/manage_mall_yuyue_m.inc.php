<?php
	global $_W,$_GPC;
	include 'common.php';
	$cx=$_GPC['cx'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_mall_bespeak') . " WHERE weid=" . $_W['uniacid'] . $cx."  ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
         
		
        $ht.='<tr class="oneinfo" id="m'.$item['id'].'">'
        			.'<td  style="width:10%;">'.$item['contacts'].'</td>'
					.'<td  style="width:10%;">'.$item['mobile'].'</td>'
					.'<td  style="width:50%;">'.$item['content'].'</td>'
					.'<td  style="width:20%;">'.gettownname($item['danyuan']).'-'.gettownname($item['menpai']).'</td>'
					.'<td  style="width:10%;">'.gettime($item['ctime']).'</td>'
			.'</tr>';
				
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht,'cx'=>$cx));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>