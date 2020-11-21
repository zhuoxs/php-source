<?php
global $_W, $_GPC;
    	$cfg = $this->module['config'];
    	
    	if ($_GPC['op']=="search"){
    		$uid=$_GPC['uid'];
	    	$zt=1;//1结算 2付款 3结算+付款
	    	if(empty($uid)){
	    		message ( 'UID必须传！' );
	    	}
	    	$sbegin_time=strtotime($_GPC['sbegin_time']);
	    	$send_time=strtotime($_GPC['send_time']);
	    	$bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
	    	$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
	    	$res=$this->seachyj($share,$sbegin_time,$send_time,$zt,$bl,$cfg);
    	}
    	if($_GPC['op']=="js"){
    		$uid=$_GPC['uid'];
    		$sbegin_time=strtotime($_GPC['sbegin_time']);
	    	$send_time=strtotime($_GPC['send_time']);
//  		$yjod=pdo_fetch("select * from ".tablename('tiger_wxdaili_yjlog')." where weid='{$_W['uniacid']}' and uid='{$uid}' and createtime>{$sbegin_time} and createtime<{$send_time}");
//  		
//  		if(empty($yjod)){
//  			
//  		}
    		 $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
    		 $data=array(
               'weid'=>$_W['uniacid'],
               'type'=>1,
               'uid'=>$uid,
               'month'=>$sy_time,
               'openid'=>$share['from_user'],
               'memberid'=>$share['openid'],//微擎用户ID
               'nickname'=>$share['nickname'],
               'msg'=>$_GPC['sbegin_time']."到".$_GPC['send_time']."结算佣金，手动结算时间：".date('Y-m-d H:i:s',time()),
               'createtime'=>time(),
               'price'=>$_GPC['credit2'],
            );
            if(!empty($_GPC['credit2'])){
           	  $result=pdo_insert($this->modulename."_yjlog", $data);
           	  $odid = pdo_insertid();
           	  $this->mc_jl($uid,1,11,$_GPC['credit2'],$data['msg']."记录ID:".$odid,'');
           	  message ( '手动结算成功！' );
            } 
    	}
  
    	include $this -> template('searchyj');
?>