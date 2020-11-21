<?php
 global $_W,$_GPC;
		$pidlist=pdo_fetch("select * from ".tablename($this->modulename."_jdpid")." where weid='{$_W['uniacid']}' and type<>1  order by id desc ");
		if(empty($pidlist)){
			message('暂无可分配的PID！', $this -> createWebUrl('dlmember', array('op' => 'display')), 'success');
		}else{
		   $sharelist=pdo_fetchall("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and  (dltype=1 || dltype=2)  and jdpid='' order by id desc ");
		   foreach($sharelist as $k=>$v){
		   	   $pidres=pdo_fetch("select * from ".tablename($this->modulename."_jdpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
					 if(empty($pidres)){
						 message('可分配的PID不足！,请在生成一些PID，重新分配！', $this -> createWebUrl('jdpidlist', array('op' => 'display')), 'error');
					 }
		   	   $res=pdo_update("tiger_newhu_share", array('jdpid'=>$pidres['pid']), array('id' =>$v['id'],'weid'=>$_W['uniacid']));
		   	   if($res=='1'){
//		   	   	echo 666;
		   	   	 $res=pdo_update($this->modulename."_jdpid", array('type'=>1,'uid'=>$v['id'],'nickname'=>$v['nickname']), array('id' => $pidres['id']));
//		   	   	 echo $res;
//		   	   	 exit;	   	   	 
		   	   }
//		   	   exit;
		   }
		   message('分配的PID完成！', $this -> createWebUrl('dlmember', array('op' => 'display')), 'success');	
		}
		
        
        include $this -> template('jdpidlist');
?>