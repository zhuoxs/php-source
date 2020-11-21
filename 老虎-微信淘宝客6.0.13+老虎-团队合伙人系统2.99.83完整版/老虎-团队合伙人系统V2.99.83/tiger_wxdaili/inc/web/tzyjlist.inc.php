<?php
global $_W,$_GPC;
        $uid=$_GPC['uid'];
        $where.=" and dltype=1 and tztype=1";
        $page=$_GPC['page'];
        if(empty($page)){
        	$page=1;
        }
				
		if(!empty($uid)){
			 $uidwhere=" and id='{$uid}'";
		}
		$pindex = max(1, intval($page));
		$psize = 50;
		$list = pdo_fetchall("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' {$where} {$uidwhere}  order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}'  {$where}  {$uidwhere}");
		$pager = pagination($total, $pindex, $psize);
		$bytimeday =date("Ym", mktime ( 0, 0, 0, date ( "m" ), 1, date ( "Y" )));//本月月份
		// echo $bytimeday;
		
		foreach($list as $k=>$v){         
            $list1[$k]['uid']=$v['id'];
			$list1[$k]['nickname']=$v['nickname'];
			$list1[$k]['from_user']=$v['from_user'];
			$list1[$k]['credit2']=$v['credit2'];
			$list1[$k]['dltype']=$v['dltype'];
			$yjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_tzyjlog')." where weid='{$_W['uniacid']}' and uid='{$v['id']}' and month={$bytimeday}");//当月团长记录
			if(empty($yjod['tbsyjsprice'])){
				$list1[$k]['tbsyjsprice']="0.00";//淘宝上月预估结算佣金
			}else{
				$list1[$k]['tbsyjsprice']=$yjod['tbsyjsprice'];//淘宝上月预估结算佣金
			}
			if(empty($yjod['pddsyjsprice'])){
				$list1[$k]['pddsyjsprice']="0.00";//拼多多上月预估结算佣金
			}else{
				$list1[$k]['pddsyjsprice']=$yjod['pddsyjsprice'];//拼多多上月预估结算佣金
			}
			if(empty($yjod['jdsyjsprice'])){
				$list1[$k]['jdsyjsprice']="0.00";//京东上月预估结算佣金
			}else{
				$list1[$k]['jdsyjsprice']=$yjod['jdsyjsprice'];//京东上月预估结算佣金
			}
			
			if(empty($yjod['jstype'])){
				$list1[$k]['jstype']="0.00";//是否已经结算 1已结算 
			}else{
				$list1[$k]['jstype']=$yjod['jstype'];//是否已经结算 1已结算 
			}
 						
 			$list1[$k]['jstime']=$yjod['jstime'];//结算时间	
			if(empty($yjod['tbjsrmb'])){
				$list1[$k]['tbjsrmb']="0.00";//已结算金额
			}else{
				$list1[$k]['tbjsrmb']=$yjod['tbjsrmb'];//已结算金额
			}
			if(empty($yjod['pddjsrmb'])){
				$list1[$k]['pddjsrmb']=0;//已结算金额
			}else{
				$list1[$k]['pddjsrmb']=$yjod['pddjsrmb'];//已结算金额
			}
			if(empty($yjod['jdjsrmb'])){
				$list1[$k]['jdjsrmb']="0.00";//已结算金额
			}else{
				$list1[$k]['jdjsrmb']=$yjod['jdjsrmb'];//已结算金额
			}
			
			if($_GPC['op']==1){		
				if($yjod['jstype']==1){
					
				}else{
					$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$v['id']}'");
					$data=array(
					       'weid'=>$_W['uniacid'],
					       'jstype'=>1,
					       'openid'=>$share['from_user'],
					       'nickname'=>$share['nickname'],
					       'msg'=>$bytimeday."结算佣金，批量结算时间：".date('Y-m-d H:i:s',time()),
					       'createtime'=>time(),
					       'tbjsrmb'=>$yjod['tbsyjsprice'],
						   'pddjsrmb'=>$yjod['pddsyjsprice'],
						   'jdjsrmb'=>$yjod['jdsyjsprice'],
						   'jstime'=>time(),
					   );
					   if(!empty($yjod['tbsyjsprice'])){
						   if(pdo_update($this->modulename."_tzyjlog",$data,array('id'=>$yjod['id'])) === false){					     
							   
							 }else{
								$yjsum=$yjod['tbsyjsprice']+$yjod['pddsyjsprice']+$yjod['jdsyjsprice'];//上月可结算佣金
								if(!empty($yjsum)){
									$this->mc_jl($share['id'],1,13,$yjsum,$data['msg'],'');
								}								
							    //message('上月团长佣金结算成功', $this->createWebUrl('tzyjlist'));
							 }
						}
				}
			}
			
		}
		
		if($_GPC['op']==1){
			if (!empty($list)) {
			    message('温馨提示：请不要关闭页面，批量发放中！（第' . $page . '页,每页50个代理）', $this->createWebUrl('tzyjlist', array('op' => '1','page' => $page + 1)), 'success');
		    }else {
		        message('温馨提示：佣金批量处理完成！', $this->createWebUrl('tzyjlist'), 'success');
		    }  
		    exit;
		}
		
		
		if($_GPC['op']==2){//单用户结算  三合一
			$uid=$_GPC['uid'];
			$tbsyjsprice=$_GPC['tbsyjsprice'];
			$pddsyjsprice=$_GPC['pddsyjsprice'];
			$jdsyjsprice=$_GPC['jdsyjsprice'];
			$yjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_tzyjlog')." where weid='{$_W['uniacid']}' and uid='{$uid}' and month={$bytimeday}");//当月团长记录
			if(empty($tbsyjsprice)){
				$tbsyjsprice=0;
			}
			if(empty($tbsyjsprice+0)){
				message('没有可结算的佣金', $this->createWebUrl('tzyjlist'), 'error');
			}
			if($yjod['jstype']==1){
				message($bytimeday月份.'已经结算过了，不能重复结算！', $this->createWebUrl('tzyjlist'), 'error');
			}else{
				$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
				$data=array(
				       'weid'=>$_W['uniacid'],
				       'jstype'=>1,
				       'openid'=>$share['from_user'],
				       'nickname'=>$share['nickname'],
				       'msg'=>$bytimeday."结算佣金，批量结算时间：".date('Y-m-d H:i:s',time()),
				       'createtime'=>time(),
				       'tbjsrmb'=>$tbsyjsprice,
					   'pddjsrmb'=>$pddsyjsprice,
					   'jdjsrmb'=>$jdsyjsprice,
					   'jstime'=>time(),
				   );
				   if(!empty($tbsyjsprice)){
					   if(pdo_update($this->modulename."_tzyjlog",$data,array('id'=>$yjod['id'])) === false){						     
						   message('上月团长佣金结算失败', $this->createWebUrl('tzyjlist'), 'error');
						 }else{
							$yjsum=$tbsyjsprice+$pddsyjsprice+$jdsyjsprice;//上月可结算佣金
							$this->mc_jl($share['id'],1,13,$yjsum,$data['msg'],'');
						    message('上月团长佣金结算成功', $this->createWebUrl('tzyjlist'));
						 }
					}
			}
		}
// 		echo "<pre>";
// 		print_r($yjod);
// 		print_r($list1);
// 		exit;
		include $this -> template('tzyjlist');
        
?>