<?php
global $_W,$_GPC;
        $uid=$_GPC['uid'];
        $where.=" and dltype=1";
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
		
//		echo "<pre>";
//		print_r($list);
//		exit;
		
		$sytime =date('Y-m', mktime(0,0,0,date('m')-1,1,date('Y')))."月结算佣金记录";//上个月开始时间
		$sy_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
		$sysum=pdo_fetchcolumn("select SUM(price) from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and month={$sy_time}");//上月结算佣金总和

		
		
		$cfg = $this->module['config'];
		$bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
		include IA_ROOT . "/addons/tiger_wxdaili/inc/sdk/tbsysy.php"; 
		include IA_ROOT . "/addons/tiger_wxdaili/inc/sdk/pddsysy.php"; 
		include IA_ROOT . "/addons/tiger_wxdaili/inc/sdk/jdsysy.php"; 
		
		foreach($list as $k=>$v){
            $tbrmb=tbsysy($v,$bl,$cfg);//淘宝佣金上个月
            $pddrmb=pddsysy($v,$bl,$cfg);//拼多多佣金上个月
            $jdrmb=jdsysy($v,$bl,$cfg);//京东佣金上个月
            if(empty($syrmb)){
            	$syrmb='0.00';
            }            
            $list1[$k]['uid']=$v['id'];
			$list1[$k]['nickname']=$v['nickname'];
			$list1[$k]['from_user']=$v['from_user'];
			$list1[$k]['credit2']=$v['credit2'];
			$list1[$k]['dltype']=$v['dltype'];
			$list1[$k]['tbrmb']=$tbrmb;//上月奖励
			$list1[$k]['pddrmb']=$pddrmb;//
			$list1[$k]['jdrmb']=$jdrmb;//
			$hejiyj=$tbrmb+$pddrmb+$jdrmb;
			$list1[$k]['hjrmb']=$hejiyj;//合记奖励
			$sy_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
			$yjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and uid='{$v['id']}' and month={$sy_time} and type=1");//如果当月有结算记录，就不在结算
			if(!empty($yjod)){
				$js=1;
			}else{
				$js='';
			}
			$list1[$k]['js']=$js;//是否结算 上月已经结算过了
			$list1[$k]['price']=$yjod['price'];//已结算金额
			
			$tbyjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and uid='{$v['id']}' and month={$sy_time} and type=2");//如果当月有结算记录，就不在结算
			if(!empty($tbyjod)){
				$tbjs=1;
			}else{
				$tbjs='';
			}
			$list1[$k]['tbjs']=$tbjs;//是否结算 上月已经结算过了
			$list1[$k]['tbprice']=$tbyjod['price'];//已结算金额
			
			$pddyjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and uid='{$v['id']}' and month={$sy_time} and type=3");//如果当月有结算记录，就不在结算
			if(!empty($pddyjod)){
				$pddjs=1;
			}else{
				$pddjs='';
			}
			$list1[$k]['pddjs']=$pddjs;//是否结算 上月已经结算过了
			$list1[$k]['pddprice']=$pddyjod['price'];//已结算金额
			
			$jdyjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and uid='{$v['id']}' and month={$sy_time} and type=4");//如果当月有结算记录，就不在结算
			if(!empty($jdyjod)){
				$jdjs=1;
			}else{
				$jdjs='';
			}
			$list1[$k]['jdjs']=$jdjs;//是否结算 上月已经结算过了
			$list1[$k]['jdprice']=$jdyjod['price'];//已结算金额
			
			
			
			$list1[$k]['jstime']=date('Y-m-d H:i:s',$yjod['createtime']);//已结算金额
			$list1[$k]['tbjstime']=date('Y-m-d H:i:s',$tbyjod['createtime']);//已结算金额
			$list1[$k]['pddjstime']=date('Y-m-d H:i:s',$pddyjod['createtime']);//已结算金额
			$list1[$k]['jdjstime']=date('Y-m-d H:i:s',$jdyjod['createtime']);//已结算金额
			
			
			
			//批量结算开始 三合一
			if($_GPC['op']==1){				
				if(empty($yjod)){
					$data=array(
                       'weid'=>$_W['uniacid'],
                       'type'=>1,
                       'uid'=>$v['id'],
                       'month'=>$sy_time,
                       'openid'=>$v['from_user'],
                       'memberid'=>$v['openid'],//微擎用户ID
                       'nickname'=>$v['nickname'],
                       'msg'=>date('Y年m月',$sy_time)."结算佣金，(三合一)批量结算时间：".date('Y-m-d H:i:s',time()),
                       'createtime'=>time(),
                       'price'=>$hejiyj,
                   );
                   if(!empty($hejiyj)){
                   	   $log="UID:".$v['id']."---昵称：".$v['nickname']."---结算月：".date('Y年m月',$sy_time)."佣金结算成功---到帐时间：".date('Y-m-d H:i:s',time()).",结算金额：".$hejiyj."元";
                   	   	file_put_contents(IA_ROOT."/addons/tiger_wxdaili/".date('Y年m月',$sy_time)."yjlog.txt","\n".$log,FILE_APPEND);
                   	  $result=pdo_insert($this->modulename."_yjlog", $data);
                   } 
                   if (!empty($result)) {
                        $odid = pdo_insertid();
                        if(!empty($hejiyj)){
                           $yjsum=$hejiyj;//上月可结算佣金
                           $this->mc_jl($v['id'],1,11,$yjsum,$data['msg']."记录ID:".$odid,'');
                        }
                   }
                   
                   
				}
			}
			//批量结算结束
			
			//批量结算开始 淘宝    type 淘宝 2  拼多多3  京东4
			if($_GPC['op']=="tb"){	
				$tbyjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and uid='{$v['id']}' and month={$sy_time} and type=2");//如果当月有结算记录，就不在结算
				if(empty($tbyjod)){
					$data=array(
											'weid'=>$_W['uniacid'],
											'type'=>2,
											'uid'=>$v['id'],
											'month'=>$sy_time,
											'openid'=>$v['from_user'],
											'memberid'=>$v['openid'],//微擎用户ID
											'nickname'=>$v['nickname'],
											'msg'=>date('Y年m月',$sy_time)."结算佣金，(淘)批量结算时间：".date('Y-m-d H:i:s',time()),
											'createtime'=>time(),
											'price'=>$tbrmb,
									);
									if(!empty($tbrmb)){
											$log="UID:".$v['id']."---昵称：".$v['nickname']."---结算月：".date('Y年m月',$sy_time)."佣金结算成功---到帐时间：".date('Y-m-d H:i:s',time()).",结算金额：".$hejiyj."元";
												file_put_contents(IA_ROOT."/addons/tiger_wxdaili/".date('Y年m月',$sy_time)."yjlog.txt","\n".$log,FILE_APPEND);
											$result=pdo_insert($this->modulename."_yjlog", $data);
									} 
									if (!empty($result)) {
												$odid = pdo_insertid();
												if(!empty($tbrmb)){
													$yjsum=$tbrmb;//上月可结算佣金
													$this->mc_jl($v['id'],1,11,$yjsum,$data['msg']."淘记录ID:".$odid,'');
												}
									}
									
									
				}
			}
			//批量结算结束 淘宝
			
			//批量结算开始 拼多多    type 淘宝 2  拼多多3  京东4
			if($_GPC['op']=="pdd"){	
				$tbyjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and uid='{$v['id']}' and month={$sy_time} and type=3");//如果当月有结算记录，就不在结算
				if(empty($tbyjod)){
					$data=array(
											'weid'=>$_W['uniacid'],
											'type'=>3,
											'uid'=>$v['id'],
											'month'=>$sy_time,
											'openid'=>$v['from_user'],
											'memberid'=>$v['openid'],//微擎用户ID
											'nickname'=>$v['nickname'],
											'msg'=>date('Y年m月',$sy_time)."结算佣金，(拼)批量结算时间：".date('Y-m-d H:i:s',time()),
											'createtime'=>time(),
											'price'=>$pddrmb,
									);
									if(!empty($pddrmb)){
											$log="UID:".$v['id']."---昵称：".$v['nickname']."---结算月：".date('Y年m月',$sy_time)."佣金结算成功---到帐时间：".date('Y-m-d H:i:s',time()).",结算金额：".$hejiyj."元";
												file_put_contents(IA_ROOT."/addons/tiger_wxdaili/".date('Y年m月',$sy_time)."yjlog.txt","\n".$log,FILE_APPEND);
											$result=pdo_insert($this->modulename."_yjlog", $data);
									} 
									if (!empty($result)) {
												$odid = pdo_insertid();
												if(!empty($pddrmb)){
													$yjsum=$pddrmb;//上月可结算佣金
													$this->mc_jl($v['id'],1,11,$yjsum,$data['msg']."拼记录ID:".$odid,'');
												}
									}
									
									
				}
			}
			//批量结算结束 拼多多
			
			//批量结算开始 京东    type 淘宝 2  拼多多3  京东4
			if($_GPC['op']=="jd"){	
				$tbyjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and uid='{$v['id']}' and month={$sy_time} and type=4");//如果当月有结算记录，就不在结算
				if(empty($tbyjod)){
					$data=array(
											'weid'=>$_W['uniacid'],
											'type'=>4,
											'uid'=>$v['id'],
											'month'=>$sy_time,
											'openid'=>$v['from_user'],
											'memberid'=>$v['openid'],//微擎用户ID
											'nickname'=>$v['nickname'],
											'msg'=>date('Y年m月',$sy_time)."结算佣金，(京)批量结算时间：".date('Y-m-d H:i:s',time()),
											'createtime'=>time(),
											'price'=>$jdrmb,
									);
									if(!empty($jdrmb)){
											$log="UID:".$v['id']."---昵称：".$v['nickname']."---结算月：".date('Y年m月',$sy_time)."佣金结算成功---到帐时间：".date('Y-m-d H:i:s',time()).",结算金额：".$hejiyj."元";
												file_put_contents(IA_ROOT."/addons/tiger_wxdaili/".date('Y年m月',$sy_time)."yjlog.txt","\n".$log,FILE_APPEND);
											$result=pdo_insert($this->modulename."_yjlog", $data);
									} 
									if (!empty($result)) {
												$odid = pdo_insertid();
												if(!empty($jdrmb)){
													$yjsum=$jdrmb;//上月可结算佣金
													$this->mc_jl($v['id'],1,11,$yjsum,$data['msg']."京记录ID:".$odid,'');
												}
									}
									
									
				}
			}
			//批量结算结束 京东

		}
		
		if($_GPC['op']==1){
			if (!empty($list)) {
					message('温馨提示：请不要关闭页面，批量发放中！（第' . $page . '页,每页50个代理）', $this->createWebUrl('plyjlist', array('op' => '1','page' => $page + 1)), 'success');
            }else {
                message('温馨提示：佣金批量处理完成！', $this->createWebUrl('plyjlist'), 'success');
            }  
            exit;
		}
		
		if($_GPC['op']=="tb"){
			if (!empty($list)) {
					message('温馨提示：请不要关闭页面，批量发放中！（第' . $page . '页,每页50个代理）', $this->createWebUrl('plyjlist', array('op' => 'tb','page' => $page + 1)), 'success');
						}else {
								message('温馨提示：佣金批量处理完成！', $this->createWebUrl('plyjlist'), 'success');
						}  
						exit;
		}
		
		if($_GPC['op']=="pdd"){
			if (!empty($list)) {
					message('温馨提示：请不要关闭页面，批量发放中！（第' . $page . '页,每页50个代理）', $this->createWebUrl('plyjlist', array('op' => 'pdd','page' => $page + 1)), 'success');
						}else {
								message('温馨提示：佣金批量处理完成！', $this->createWebUrl('plyjlist'), 'success');
						}  
						exit;
		}
		
		if($_GPC['op']=="jd"){
			if (!empty($list)) {
					message('温馨提示：请不要关闭页面，批量发放中！（第' . $page . '页,每页50个代理）', $this->createWebUrl('plyjlist', array('op' => 'jd','page' => $page + 1)), 'success');
						}else {
								message('温馨提示：佣金批量处理完成！', $this->createWebUrl('plyjlist'), 'success');
						}  
						exit;
		}

		if($_GPC['op']==2){//单用户结算  三合一
			$uid=$_GPC['uid'];
			$hejiyj=$_GPC['hjrmb'];
			
			$sy_time = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));//上个月开始时间
			if(empty($hejiyj)){
				message(date('Y年m月',$sy_time).'没有可结算的佣金！', $this->createWebUrl('plyjlist'), 'error');
			}
			$yjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and uid='{$uid}' and month={$sy_time}");//如果当月有结算记录，就不在结算
			if(empty($yjod)){
				$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
				$data=array(
                       'weid'=>$_W['uniacid'],
                       'type'=>1,
                       'uid'=>$share['id'],
                       'month'=>$sy_time,
                       'openid'=>$share['from_user'],
                       'memberid'=>$share['openid'],//微擎用户ID
                       'nickname'=>$share['nickname'],
                       'msg'=>date('Y年m月',$sy_time)."结算佣金，批量结算时间：".date('Y-m-d H:i:s',time()),
                       'createtime'=>time(),
                       'price'=>$hejiyj,
                   );
                   if(!empty($hejiyj)){
                   	    $log="UID:".$share['id']."---昵称：".$share['nickname']."---结算月：".date('Y年m月',$sy_time)."佣金结算成功---到帐时间：".date('Y-m-d H:i:s',time()).",手动单独结算金额：".$hejiyj."元";
                   	   	file_put_contents(IA_ROOT."/addons/tiger_wxdaili/".date('Y年m月',$sy_time)."yjlog.txt","\n".$log,FILE_APPEND);
                   	    $result=pdo_insert($this->modulename."_yjlog", $data);
                   } 
                   if (!empty($result)) {
                        $odid = pdo_insertid();
                        if(!empty($hejiyj)){
                           $yjsum=$hejiyj;//上月可结算佣金
                           $this->mc_jl($share['id'],1,11,$yjsum,$data['msg']."记录ID:".$odid,'');
                        }
                   }
                   message('佣金结算成功！', $this->createWebUrl('plyjlist'), 'success');
			}else{
				message(date('Y年m月',$sy_time).'已经结算过了，不能重复结算！', $this->createWebUrl('plyjlist'), 'error');
			}
			
			
		}
		
		
		
//		echo "<pre>";
//		print_r($list1);
//		exit;
		include $this -> template('plyjlist');
        
?>