<?php
//http://cs.tigertaoke.com/app/index.php?i=14&c=entry&do=fbpid&m=tiger_newhu&jd=1&pdd=1&tb=1
		global $_W, $_GPC;
		$cfg = $this->module['config'];
		$jd=$_GPC['jd'];
		$pdd=$_GPC['pdd'];
		$tb=$_GPC['tb'];
		
		
		//批量审核自动加PID
	
		$sharelist=pdo_fetchall("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and  dltype=2  order by id desc ");
		if(empty($sharelist)){
			exit("暂无要审核的代理！");
		}else{
			foreach($sharelist as $k=>$v){				
				if($jd==1){
					$pidres=pdo_fetch("select * from ".tablename("tiger_wxdaili_jdpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
					if(empty($pidres)){
						exit("可分配的京东PID不足！,请先生成PID，重新分配！"); 
					}
					$res=pdo_update("tiger_newhu_share", array('jdpid'=>$pidres['pid']), array('id' =>$v['id'],'weid'=>$_W['uniacid']));
					if(!empty($res)){
						$res=pdo_update("tiger_wxdaili_jdpid", array('type'=>1,'uid'=>$v['id'],'nickname'=>$v['nickname']), array('id' => $pidres['id']));
					}
				}
				
				if($pdd==1){
					$pidres=pdo_fetch("select * from ".tablename("tiger_wxdaili_pddpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
					if(empty($pidres)){
						exit("可分配的拼多多PID不足！,请先生成PID，重新分配！"); 
					}
					$res=pdo_update("tiger_newhu_share", array('pddpid'=>$pidres['pid']), array('id' =>$v['id'],'weid'=>$_W['uniacid']));
					if($res=='1'){
						$res=pdo_update("tiger_wxdaili_pddpid", array('type'=>1,'uid'=>$v['id'],'nickname'=>$v['nickname']), array('id' => $pidres['id']));
					}
				}
				
				if($tb==1){
					$pidres=pdo_fetch("select * from ".tablename("tiger_wxdaili_tkpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
					if(empty($pidres)){
						exit("可分配的淘宝PID不足！,请先生成PID，重新分配！"); 
					}
					$pidSplit=explode('_',$pidres['pid']);
					$tgwid=$pidSplit[3];
					$res=pdo_update("tiger_newhu_share", array('dlptpid'=>$pidres['pid'],'tgwid'=>$tgwid,'tbkpidtype'=>1,'tbuid'=>$pidres['tbuid']), array('id' =>$v['id'],'weid'=>$_W['uniacid']));
					if($res=='1'){
						$res=pdo_update("tiger_wxdaili_tkpid", array('type'=>1,'uid'=>$v['id'],'nickname'=>$v['nickname'],'fptime'=>time()), array('id' => $pidres['id']));
					}
				}
				
				$res=pdo_update("tiger_newhu_share", array('dltype'=>1), array('id' =>$v['id'],'weid'=>$_W['uniacid']));
				echo "uid:".$v['id']."审核成功".$res;			
			}
		}
		exit("ok");
		

		
		//结束

		
		if($jd==1){
			$jdlist=pdo_fetch("select * from ".tablename($this->modulename."_jdpid")." where weid='{$_W['uniacid']}' and type<>1  order by id desc ");
			if(empty($jdlist)){
				exit("暂无可分配的京东PID"); 
			}else{
			   $sharelist=pdo_fetchall("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and  dltype=2  and jdpid='' order by id desc ");
			   foreach($sharelist as $k=>$v){
				   $pidres=pdo_fetch("select * from ".tablename($this->modulename."_jdpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
					 if(empty($pidres)){
						 exit("可分配的京东PID不足！,请先生成PID，重新分配！"); 
					 }
				   $res=pdo_update("tiger_newhu_share", array('jdpid'=>$pidres['pid']), array('id' =>$v['id'],'weid'=>$_W['uniacid']));
				   if($res=='1'){
					 $res=pdo_update($this->modulename."_jdpid", array('type'=>1,'uid'=>$v['id'],'nickname'=>$v['nickname']), array('id' => $pidres['id']));
				   }
			   }
			  // message('分配的PID完成！', $this -> createWebUrl('dlmember', array('op' => 'display')), 'success');	
			}
		}
		
		
		if($pdd==1){
			$pddlist=pdo_fetch("select * from ".tablename($this->modulename."_pddpid")." where weid='{$_W['uniacid']}' and type<>1 order by id desc ");
			if(empty($pddlist)){
				exit("暂无可分配的拼多多PID"); 
			}else{
			   $sharelist=pdo_fetchall("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and  dltype=2  and pddpid='' order by id desc ");
			   foreach($sharelist as $k=>$v){
				   $pidres=pdo_fetch("select * from ".tablename($this->modulename."_pddpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
						 if(empty($pidres)){
							exit("可分配的拼多多PID不足！,请先生成PID，重新分配！"); 
						 }
				   $res=pdo_update("tiger_newhu_share", array('pddpid'=>$pidres['pid']), array('id' =>$v['id'],'weid'=>$_W['uniacid']));
				   if($res=='1'){
					 $res=pdo_update($this->modulename."_pddpid", array('type'=>1,'uid'=>$v['id'],'nickname'=>$v['nickname']), array('id' => $pidres['id']));
				   }
			   }
			   //message('分配PID完成！', $this -> createWebUrl('dlmember', array('op' => 'display')), 'success');	
			}
		}
		
		if($tb==1){
			$tblist=pdo_fetch("select * from ".tablename($this->modulename."_tkpid")." where weid='{$_W['uniacid']}' and type<>1 order by id desc ");
			if(empty($tblist)){
				exit("暂无可分配的淘宝PID"); 
			}else{
			   $sharelist=pdo_fetchall("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and dltype=2 and dlptpid='' order by id desc ");
			   foreach($sharelist as $k=>$v){
				   $pidres=pdo_fetch("select * from ".tablename($this->modulename."_tkpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
					 if(empty($pidres)){
						exit("可分配的淘宝PID不足！,请先生成PID，重新分配！"); 
					 }
					 $pidSplit=explode('_',$pidres['pid']);
				   $res=pdo_update("tiger_newhu_share", array('tgwid'=>$pidSplit[3],'dlptpid'=>$pidres['pid'],'tbkpidtype'=>1,'tbuid'=>$pidres['tbuid']), array('id' =>$v['id'],'weid'=>$_W['uniacid']));
				   if($res=='1'){
					 $res=pdo_update($this->modulename."_tkpid", array('type'=>1,'uid'=>$v['id'],'nickname'=>$v['nickname'],'fptime'=>time()), array('id' => $pidres['id']));
				   }
			   }
			  // message('分配PID完成！', $this -> createWebUrl('dlmember', array('op' => 'display')), 'success');	
			}
		}
		
		
		
		
		
		

		exit(json_encode(array('errcode'=>0,'data'=>$dha))); 
?>