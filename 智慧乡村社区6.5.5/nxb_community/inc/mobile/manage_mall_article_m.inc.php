<?php
	global $_W,$_GPC;
	include 'common.php';
	$cx=$_GPC['cx'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_mall_article') . " WHERE weid=" . $_W['uniacid'] . $cx."  ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
         
		
        $ht.='<tr class="oneinfo" id="m'.$item['id'].'">'
        			.'<td style="width:10%">'.$item['id'].'</td>'
        			.'<td style="width:10%"><img src="'.tomedia($item['cicon']).'" style="width:50px;height:50px;border-radius:4px"></td>'
        			.'<td style="width:30%">'.$item['ctitle'].'</td>'
        			.'<td  style="width:20%;">'.gettownname($item['danyuan']).' '.gettownname($item['menpai']).'</td>'
					.'<td style="width:10%;">';
					if($item['status']==1){
						$ht.='显示';
					}else{
						$ht.='不显示';
					}
					
					
					$ht.='</p></td>'
					.'<td style="width:10%">'.gettime($item['ctime']).'</td>'
					.'<td style="width:10%">';
						$ht.='<a href="'.$this->createMobileUrl('manage_mall_article_edit',array('id'=>$item['id'])).'"><button type="button" class="mui-btn mui-btn-primary">查看</button></a>';
						$ht.='<button type="button" class="mui-btn mui-btn-primary" onclick="delarticle('.$item['id'].')">删除</button>';
					$ht.='</td>'
			.'</tr>';
				
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht,'cx'=>$cx));
        }
	

?>