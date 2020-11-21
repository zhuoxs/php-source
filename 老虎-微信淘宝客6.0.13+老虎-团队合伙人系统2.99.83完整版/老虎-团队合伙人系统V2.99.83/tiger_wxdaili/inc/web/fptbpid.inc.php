<?php
 global $_W,$_GPC;
		$pidlist=pdo_fetch("select * from ".tablename($this->modulename."_tkpid")." where weid='{$_W['uniacid']}' and type<>1 order by id desc ");
		if(empty($pidlist)){
			message('暂无可分配的PID！', $this -> createWebUrl('dlmember', array('op' => 'display')), 'success');
		}else{
		   $sharelist=pdo_fetchall("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and (dltype=1 || dltype=2) and dlptpid='' order by id desc ");
// 			 echo "<pre>";
// 			 print_r($sharelist);
// 			 exit;
			 
			 
			 
		   foreach($sharelist as $k=>$v){
		   	   $pidres=pdo_fetch("select * from ".tablename($this->modulename."_tkpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
					 if(empty($pidres)){
					 	message('可分配的PID不足！,请在生成一些PID，重新分配！', $this -> createWebUrl('tkpidlist', array('op' => 'display')), 'error');
					 }
		   	   $res=pdo_update("tiger_newhu_share", array('dlptpid'=>$pidres['pid'],'tbkpidtype'=>1,'tbuid'=>$pidres['tbuid']), array('id' =>$v['id'],'weid'=>$_W['uniacid']));
		   	   if($res=='1'){
//		   	   	echo 666;
		   	   	 $res=pdo_update($this->modulename."_tkpid", array('type'=>1,'uid'=>$v['id'],'nickname'=>$v['nickname'],'fptime'=>time()), array('id' => $pidres['id']));
//		   	   	 echo $res;
//		   	   	 exit;	   	   	 
		   	   }
//		   	   exit;
		   }
		   message('分配PID完成！', $this -> createWebUrl('dlmember', array('op' => 'display')), 'success');	
		}
		
        
        include $this -> template('tbpidlist');
?>