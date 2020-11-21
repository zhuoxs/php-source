<?php
	global $_W,$_GPC;
	include 'common.php';
	$cx=$_GPC['cx'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_mall_wallet') . " WHERE weid=" . $_W['uniacid'] . $cx."  ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
         
		
        $ht.='<tr class="oneinfo" id="m'.$item['id'].'">'
        			.'<td style="width:10%">'.$item['id'].'</td>'
        			.'<td style="width:10%">用户ID'.$item['mid'].'</td>'
        			
					.'<td style="width:10%;">';
					if($item['type']==1){
						$ht.='订单收入';
					}else if($item['type']==2){
						$ht.='商家提现';
					}else if($item['type']==3){
						$ht.='平台提现手续费';
					}					
	
					$ht.='</td>'
					.'<td style="width:40%;">';
					
					if($item['status']==1){
						$ht.='已审核';
					}else{
						$ht.='<p>未审核 </p><p class="t-red" onclick="chulitx('.$item['id'].')"> [去处理]</p>';
					}
					
					
					
					$ht.='</td>'
					.'<td style="width:10%;">'.$item['amount'].'</td>'
					.'<td style="width:10%">'.gettime($item['ctime']).'</td>'
					.'<td style="width:10%">';
					if($item['etime']!=0){
						$ht.=gettime($item['etime']);
					}
					$ht.='</td>'
			.'</tr>';
				
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht,'cx'=>$cx));
        }
	

?>