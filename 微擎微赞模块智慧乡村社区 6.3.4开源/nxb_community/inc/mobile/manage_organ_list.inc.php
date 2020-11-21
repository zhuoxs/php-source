<?php
	global $_W,$_GPC;
	include 'common.php';
	
	$townid=intval($_GPC['townid']);
	
	$res = pdo_fetchall("SELECT a.*,b.organname FROM " . tablename('bc_community_organuser') . " as a left join ".tablename('bc_community_organlev')." as b on a.organid=b.id WHERE a.weid=" . $_W['uniacid'] ." AND a.townid=".$townid." ORDER BY id DESC");	
	if(!empty($res)){
		
		
		$ht = '<table class="mui-table">';
        foreach ($res as $key => $item) {
         
		
        $ht.='<tr class="oneinfo"  id="organuser'.$item['id'].'">'
        
        			.'<td class="">'.$item['organname'].'</td>'
					.'<td class=""><img src="'.tomedia($item['cover']).'" style="width:50px;height:50px;border-radius:25px;"></td>'
					.'<td class="">'.$item['username'].'</td>'
					.'<td class="">'.$item['zhiwei'].'-'.$item['company'].'</td>'
					.'<td class="">';
					if($item['sex']==1){
						$ht.='男';
					}else{
						$ht.='女';
					}
					 $ht.='</td>'
					
					.'<td class="">';
						$ht.='<button type="button" class="mui-btn mui-btn-primary" onclick="ck('.$item['id'].')">查看</button>';
						$ht.='<button type="button" class="mui-btn mui-btn-warning" onclick="sc('.$item['id'].')">删除</button>';
					$ht.='</td>'
			.'</tr>';
				
        }
		
		$ht .= '</table>';
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht,'s'=>$s));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht,'s'=>$s));
        }
		
	}else{
		echo json_encode(array('status'=>3,'log'=>'暂无数据','s'=>$s));
	}
		
	

?>