<?php
 global $_W,$_GPC;
 		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/jd.php"; 
		$jdset=pdo_fetch("select * from ".tablename('tuike_jd_jdset')." where weid='{$_W['uniacid']}' order by id desc");
		$jdsign=pdo_fetch("select * from ".tablename('tuike_jd_jdsign')." where weid='{$_W['uniacid']}' order by id desc");
		
		if(empty($jdset)){
			message('请先授权京东！', $this -> createWebUrl('dlmember', array('op' => 'display','dl'=>1)), 'error');
			exit;
		}
//		echo "<pre>";
//		   	   print_r($jdset);
//		   	   print_r($jdsign);
//		   	   exit;
		
		
		   $sharelist=pdo_fetchall("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and dltype=1 and jdpid='' || jdpid='-1' order by id desc limit 0,100 ");
		   if(empty($sharelist)){
		   	   			message('暂无代理需要分配京东推广位', $this -> createWebUrl('dlmember', array('op' => 'display','dl'=>1)), 'error');
						exit;
		   	   }
		   
		   foreach($sharelist as $k=>$v){
		   	   $tgwname=$v['id']."_".time();
		   	   $tgw=gettgw($jdsign['access_token'],$jdset['unionid'],$tgwname,$jdset['jdkey']);
		   	   $tgwid=$tgw['data']['resultList'][$tgwname];//对应代理推广位
		   	   if(empty($tgwid)){
                       //echo "<pre>";
                        //print_r($tgw);
		   	   			message('创建失败，用户：'.$v['id'].$tgw['message'], $this -> createWebUrl('dlmember', array('op' => 'display')), 'error');
						exit;
		   	   }
              if($tgwid=='-1'){
                $tgwid='';
              }
		   	   $res=pdo_update("tiger_newhu_share", array('jdpid'=>$tgwid), array('id' =>$v['id'],'weid'=>$_W['uniacid']));
		   	   
		   	   echo $v['nickname']."分配推广".$tgwid."成功";
		   	   echo "<br>";
		   	   if($res=='1'){
   		   	   	 $pidres=pdo_fetch("select * from ".tablename($this->modulename."_jdpid")." where weid='{$_W['uniacid']}' and pid='{$tgwid}' order by id desc ");
   		   	   	 $data = array(
	                    'weid' => $_W['weid'], 
	                    'type' =>1, 
	                    'nickname' => $v['nickname'], 
	                    'uid'=>$v['id'],
	                    'pid' =>$tgwid, 
	                    'tgwname' =>$tgwname, 
	                    'fptime' =>time(), 
	                    'createtime' => TIMESTAMP
                    ); 
   		   	   	 if(empty($pidres)){   		   	   	 	
   		   	   	 	pdo_insert($this->modulename."_jdpid", $data);
   		   	   	 }else{
   		   	   	 	$res=pdo_update($this->modulename."_jdpid",$data, array('pid' => $tgwid));
   		   	   	 }  	 
		   	   }
//		   	   exit;
		   }
		   message('分配的PID完成！', $this -> createWebUrl('dlmember', array('op' => 'display','dl'=>1)), 'success');	
		
        
        include $this -> template('jdpidlist');
?>