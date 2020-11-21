<?php
	global $_W,$_GPC;
	include 'common.php';
	$cx=$_GPC['cx'];	
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);
	
	$res = pdo_fetchall("SELECT * FROM " . tablename('bc_community_member') . " WHERE weid=" . $_W['uniacid'] . $cx."  ORDER BY mid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
         
		
        $ht.='<tr class="oneinfo" id="m'.$item['mid'].'">'
        			.'<td class="">'.$item['realname'].'</td>'
					.'<td class=""><img src="'.tomedia($item['avatar']).'" style="width:50px;height:50px;border-radius:25px;"></td>'
					.'<td class="">'.$item['tel'].'</td>'
					.'<td class="">'.gettownname($item['danyuan']).'-'.gettownname($item['menpai']).'</td>'
					.'<td class="">';
					if($item['isrz']==1){
						$ht.='<button type="button" class="mui-btn mui-btn-success">已认证</button>';
					}else if($item['isrz']==2){
						$ht.='<button type="button" class="mui-btn mui-btn-success">已提交认证申请</button>';
					}else{
						$ht.='<button type="button" class="mui-btn mui-btn-danger mui-btn-outlined">游客</button>';
					}
					 $ht.='</td>'
					.'<td class="">'.gettime($item['createtime']).'</td>'
					.'<td class="">';
						$ht.='<a href="'.$this->createMobileUrl('manage_member_edit',array('id'=>$item['mid'])).'"><button type="button" class="mui-btn mui-btn-primary">查看</button></a>';
						$ht.='&nbsp;&nbsp;&nbsp&nbsp;<button type="button" class="mui-btn mui-btn-warning" onclick="delmember('.$item['mid'].')">删除</button>';
					$ht.='</td>'
			.'</tr>';
				
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>