<?php
global $_W, $_GPC;
 		$cfg=$this->module['config'];
        $fans=$this->islogin();
       if(empty($fans['tkuid'])){
     		  $fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	  	  	 
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }		              
        }
				$member=$this->getmember($fans,$mc['uid']);
        
       
        
        
        if($_W['isajax']){
        	$uid=$_GPC['uid'];
        	$daytime=date('Y-m-d H:i:s',time());
        	$share = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and id='{$uid}'");  
        	$todayBegin=strtotime(date('Y-m-d')." 00:00:00"); 
            $todayEnd= strtotime(date('Y-m-d')." 23:59:59"); 
            $res= pdo_fetch("select * from ".tablename($this->modulename."_qiandao")." where weid='{$_W['uniacid']}' and uid='{$uid}'");  
            $qdjl= pdo_fetch("select * from ".tablename($this->modulename."_qiandao")." where weid='{$_W['uniacid']}' and uid='{$uid}' and addtime>='{$todayBegin}' and addtime<'{$todayEnd}'"); 
            	
            if(empty($cfg['qiandaormb'])){
            	die(json_encode(array('error'=>3,'msg'=>"管理员未设置签到奖励！")));
            } 
            
            if(!empty($qdjl)){//查询当天签到
               die(json_encode(array('error'=>3,'msg'=>"今日已经签到过了！")));
            }
            	
            	
            if(!empty($res)){//存在签到
//          	if((time() - $qdjl['addtime'] > 24*60*60)){ // 判断时间是否大于24小时
//                  // 让字段归0
//                  $addInfo=pdo_update($this->modulename."_qiandao", array('num'=>1,'addtime'=>time()), array('weid'=>$_W['uniacid'],'uid' =>$uid));
//              }else{
                    // 更新签到的天数
                    $num=1+$res['num'];
                    $addInfo=pdo_update($this->modulename."_qiandao", array('num'=>$num,'addtime'=>time()), array('weid'=>$_W['uniacid'],'uid' =>$uid));
                    
                    $this->mc_jl($uid,0,1,$cfg['qiandaormb'],'签到奖励'.$daytime,'');
                //}
                die(json_encode(array('error'=>1,'msg'=>"签到成功！")));                  
            }else{
            	 //没有签到过                
            	$indata=array(
            		'weid'=>$_W['uniacid'],
            		'uid'=>$share['id'],
            		'num'=>1,//签到次数
            		'addtime'=>time(),
            	);
            	pdo_insert($this->modulename."_qiandao", $indata);  
            	$this->mc_jl($uid,0,1,$cfg['qiandaormb'],'签到奖励'.$daytime,'');
            	die(json_encode(array('error'=>1,'msg'=>"今天签到成功！")));      	
            }
            // 获取连续签到的天数
            //$info= pdo_fetch("select * from ".tablename($this->modulename."_qiandao")." where weid='{$_W['uniacid']}' and uid='{$uid}'");  
                  	
        }
        //ajax结束
        
        $share = pdo_fetch("select * from ".tablename($this->modulename."_share")." where weid='{$_W['uniacid']}' and from_user='{$fans['openid']}'"); 
        
         
        include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
        $goodstj=gettjlist(1,12,'','',$cfg);
        
        $todayBegin=strtotime(date('Y-m-d')." 00:00:00"); 
        $todayEnd= strtotime(date('Y-m-d')." 23:59:59"); 
        $dayqiandao= pdo_fetch("select * from ".tablename($this->modulename."_qiandao")." where weid='{$_W['uniacid']}' and uid='{$share['id']}' and addtime>='{$todayBegin}' and addtime<'{$todayEnd}'");  

         $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
 		include $this->template ( 'user/qiandao' );
     ?>