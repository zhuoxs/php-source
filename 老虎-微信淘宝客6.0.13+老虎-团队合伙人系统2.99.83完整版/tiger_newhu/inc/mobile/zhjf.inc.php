<?php
global $_W, $_GPC;
     $cfg=$this->module['config'];
     $fans = mc_oauth_userinfo();
     $mc=mc_fetch($fans['openid']);
     //$member = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'");
     $fans=$this->getmember($fans,$mc['uid']);
     
     
     if($_W['isajax']){
     	
     	if($_GPC['type']==1){//转换
     		if(empty($mc['credit1']) and empty($mc['credit2'])){
	     		die(json_encode(array("statusCode"=>100,'msg'=>"暂无可转入的数据！")));  
	     	}else{
	     		if(!empty($mc['credit1'])){
	     		   mc_credit_update($mc['uid'],'credit1',-$mc['credit1'],array($mc['uid'],'TK积分转出'));
	     		   $this->mc_jl($fans['id'],0,11,$mc['credit1'],'wq积分【转入】增加','');
	     		}
	     		if(!empty($mc['credit2'])){
	     		   mc_credit_update($mc['uid'],'credit2',-$mc['credit2'],array($mc['uid'],'TK余额转出'));
	     		   $this->mc_jl($fans['id'],1,11,$mc['credit2'],'wq余额【转入】增加','');
	     		}
	     		die(json_encode(array("statusCode"=>200,'msg'=>"数据转入成功！")));  
	     	}
     	}elseif($_GPC['type']==2){
     		if(empty($fans['credit1']) and empty($fans['credit2'])){
     			die(json_encode(array("statusCode"=>100,'msg'=>"暂无可【转出】的数据！")));  
     		}else{
     			if(!empty($fans['credit1'])){
	     		   mc_credit_update($mc['uid'],'credit1',$fans['credit1'],array($mc['uid'],'TK积分转入'));
	     		   $this->mc_jl($fans['id'],0,11,-$fans['credit1'],'TK积分【转出】减少','');
	     		}
	     		
	     		if(!empty($fans['credit2'])){
	     		   mc_credit_update($mc['uid'],'credit2',$fans['credit2'],array($mc['uid'],'TK余额转入'));
	     		   $res=$this->mc_jl($fans['id'],1,11,-$fans['credit2'],'TK余额【转出】减少','');
	     		}
	     		die(json_encode(array("statusCode"=>200,'msg'=>"数据转出成功！")));  
     		}
     		
     	}
     	
     	
     	
     }
     
     include $this->template ( 'user/zhjf' );
     ?>