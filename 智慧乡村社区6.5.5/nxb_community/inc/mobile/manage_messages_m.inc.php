<?php
	global $_W,$_GPC;
	include 'common.php';
	$cx=$_GPC['cx'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_messages') . " WHERE weid=" . $_W['uniacid'] . $cx."  ORDER BY id DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
         
		
        $ht.='<tr class="oneinfo">'
        			.'<td class="">'.$item['type'].'</td>'
					.'<td class="">'.$item['title'].'</td>'
					.'<td class="">'.$item['content'].'</td>'
					.'<td class="">'.getmanagename($item['manageid']).'</td>'
					.'<td class="">'.getusername($item['mid']).'</td>'
					.'<td class="">';
					if($item['status']==1){
						$ht.='<button type="button" class="mui-btn mui-btn-success">已读</button>';
					}else{
						$ht.='<button type="button" class="mui-btn mui-btn-danger mui-btn-outlined">未读</button>';
					}
					 $ht.='</td>'
					.'<td class="">'.gettime($item['ctime']).'</td>'
					.'<td class="">';
						$ht.='<button type="button" class="mui-btn mui-btn-primary">查看</button>';
						$ht.='<button type="button" class="mui-btn mui-btn-warning">删除</button>';
					$ht.='</td>'
			.'</tr>';
				
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>