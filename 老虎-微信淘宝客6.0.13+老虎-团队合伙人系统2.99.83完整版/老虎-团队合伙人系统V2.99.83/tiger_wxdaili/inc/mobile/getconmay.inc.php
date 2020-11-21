<?php
global $_W, $_GPC;
  	     $cfg = $this->module['config'];
  	     $pid=$_GPC['pid'];
  	     $itemid=$_GPC['itemid'];
  	     $lm=$_GPC['lm'];
  	     $weid=$_W['uniacid'];
		 $uid=$_GPC['uid'];
		 $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
		 if(empty($share['qdid'])){
		 	if(!empty($share['dlptpid'])){
		        $cfg['ptpid']=$share['dlptpid'];
		     }
		 }else{
		 	//$cfg['ptpid']=$share['dlqqpid'];//渠道PID
		 	$qdid=$share['qdid'];
			$qdidlist=pdo_fetch("select * from ".tablename('tiger_newhu_qudaolist')." where weid='{$_W['uniacid']}' and relation_id='{$qdid}'");
			$cfg['ptpid']=$qdidlist['root_pid'];
		 }
		 
		 //exit(json_encode(array('status'=>1,'ios' =>2222,'az'=>$cfg['ptpid']."----".$qdid,'picurl' =>$picurl))); 

  	     
  	     include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
         include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
         //$tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
		 $pidSplit=explode('_',$cfg['ptpid']);
		 $memberid=$pidSplit[1];
		 if(empty($memberid)){
			$tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
		 }else{
			$tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  memberid='{$memberid}'");
		 }
  	     
  	     if($lm==2){//商品商品库
  	     	 $views=getview($itemid);
  	     	 
  	     	 if(!empty($itemid)){
          	  	$turl="https://item.taobao.com/item.htm?id=".$itemid;
                $res=hqyongjin($turl,'',$cfg,'tiger_newhu','','',$tksign['sign'],$tksign['tbuid'],$_W,1,$itemid,$qdid); 
          	 }
			 if(empty($res['money'])){
			   $rhyurl=$res['itemurl'];
			 }else{
			   $rhyurl=$res['dclickUrl'];
			 }
  
          	  $picurl=$views['itempic'];
          	  $rhyurl=str_replace("http:","https:",$rhyurl);
          	  $tkl=$this->tkl($rhyurl,$views['itempic'],$views['itemtitle']);
          	  //$taokou=$tkl->model;
              //settype($taokou, 'string');
              $taokouling=$tkl;  
              
              $rhyurl2=urlencode($rhyurl);
		      if($cfg['xqdwzxs']==1){
		      	//$urla=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('openview'))."&link=".$rhyurl2;
		      	$urla=$_W['siteroot']."/app/index.php?i=".$_W['uniacid']."&c=entry&do=openview&m=tiger_newhu&link=".$rhyurl2;
		        $ddwz=$this->dwzw($urla);
		      }
		     
			 //views['itemtitle']=$qdid."----".$uid."--".$cfg['ptpid'];
		      	    
		      //if($sjlx=='android'){
			        	$msgaz=str_replace('#换行#','', $cfg['flmsg']);
			      		$msgaz=str_replace('#名称#',"{$views['itemtitle']}", $msgaz);
			      	 	$msgaz=str_replace('#推荐理由#',"{$views['itemdesc']}", $msgaz);
			      	 	$msgaz=str_replace('#原价#',"{$views['itemprice']}", $msgaz);
			      	 	$msgaz=str_replace('#券后价#',"{$views['itemendprice']}", $msgaz);
			      	 	$msgaz=str_replace('#优惠券#',"{$views['couponmoney']}", $msgaz);
			      	 	$msgaz=str_replace('#淘口令#',"{$taokouling}", $msgaz);
			      	 	$msgaz=str_replace('#二合一链接#',"{$rhyurl}", $msgaz);
			      	 	$msgaz=str_replace('#短链接#',"{$ddwz}", $msgaz);
			      //}else{
			        	$msgios=str_replace('#换行#','<br>', $cfg['flmsg']);
			      		$msgios=str_replace('#名称#',"{$views['itemtitle']}", $msgios);
			      	 	$msgios=str_replace('#推荐理由#',"{$views['itemdesc']}", $msgios);
			      	 	$msgios=str_replace('#原价#',"{$views['itemprice']}", $msgios);
			      	 	$msgios=str_replace('#券后价#',"{$views['itemendprice']}", $msgios);
			      	 	$msgios=str_replace('#优惠券#',"{$views['couponmoney']}", $msgios);
			      	 	$msgios=str_replace('#淘口令#',"{$taokouling}", $msgios);
			      	 	$msgios=str_replace('#二合一链接#',"{$rhyurl}", $msgios);
			      	 	$msgios=str_replace('#短链接#',"{$ddwz}", $msgios);
			     // }
          	 
          	 $msgios="【商品】".$views['itemtitle']."<br/>【原价】".$views['itemprice']."元<br/>【优惠券】".$views['couponmoney']."元<br/>【券后价】".$views['itemendprice']."元<br/>-------------<br/>【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$taokouling;
          	 $msgaz="【商品】".$views['itemtitle']."\r\n【原价】".$views['itemprice']."元\r\n【优惠券】".$views['couponmoney']."元\r\n【券后价】".$views['itemendprice']."元\r\n-------------\r\n【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$taokouling;
          	 
          	if(empty($res['dclickUrl'])){
          		exit(json_encode(array('status'=>1,'ios' =>$res['error'],'az' =>$res['error'],'picurl' =>$picurl))); 
          	}else{
          		exit(json_encode(array('status'=>1,'ios' =>$msgios,'az'=>$msgaz,'picurl' =>$picurl))); 
          	}  	     	
  	     }else{//自己采集
  	     	if(!empty($cfg['gyspsj'])){
               $weid=$cfg['gyspsj'];
            }
  	     	   if(!empty($itemid)){
                  $views=pdo_fetch("select * from".tablename("tiger_newhu_newtbgoods")." where weid='{$weid}' and itemid='{$itemid}'");
                  if(!empty($itemid)){
	          	  	$turl="https://item.taobao.com/item.htm?id=".$itemid;
	                $res=hqyongjin($turl,'',$cfg,'tiger_newhu','','',$tksign['sign'],$tksign['tbuid'],$_W,1,$itemid,$qdid); 
	          	  }
                   $picurl=$views['itempic'];
	          	   $rhyurl=$res['dclickUrl']."&activityId=".$views['quan_id'];
	          	   $rhyurl=str_replace("http:","https:",$rhyurl);
	          	   $tkl=$this->tkl($rhyurl,$views['itempic'],$views['itemtitle']);
	          	   //$taokou=$tkl->model;
	               //settype($taokou, 'string');
	               $taokouling=$tkl;  
	               
	               $rhyurl2=urlencode($rhyurl);
			      if($cfg['xqdwzxs']==1){
			      	//$urla=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('openview'))."&link=".$rhyurl2;
			      	$urla=$_W['siteroot']."/app/index.php?i=".$_W['uniacid']."&c=entry&do=openview&m=tiger_newhu&link=".$rhyurl2;
			        $ddwz=$this->dwzw($urla);
			      }
			     
			      	    
			      //if($sjlx=='android'){
			        	$msgaz=str_replace('#换行#','', $cfg['flmsg']);
			      		$msgaz=str_replace('#名称#',"{$views['itemtitle']}", $msgaz);
			      	 	$msgaz=str_replace('#推荐理由#',"{$views['itemdesc']}", $msgaz);
			      	 	$msgaz=str_replace('#原价#',"{$views['itemprice']}", $msgaz);
			      	 	$msgaz=str_replace('#券后价#',"{$views['itemendprice']}", $msgaz);
			      	 	$msgaz=str_replace('#优惠券#',"{$views['couponmoney']}", $msgaz);
			      	 	$msgaz=str_replace('#淘口令#',"{$taokouling}", $msgaz);
			      	 	$msgaz=str_replace('#二合一链接#',"{$rhyurl}", $msgaz);
			      	 	$msgaz=str_replace('#短链接#',"{$ddwz}", $msgaz);
			      //}else{
			        	$msgios=str_replace('#换行#','<br>', $cfg['flmsg']);
			      		$msgios=str_replace('#名称#',"{$views['itemtitle']}", $msgios);
			      	 	$msgios=str_replace('#推荐理由#',"{$views['itemdesc']}", $msgios);
			      	 	$msgios=str_replace('#原价#',"{$views['itemprice']}", $msgios);
			      	 	$msgios=str_replace('#券后价#',"{$views['itemendprice']}", $msgios);
			      	 	$msgios=str_replace('#优惠券#',"{$views['couponmoney']}", $msgios);
			      	 	$msgios=str_replace('#淘口令#',"{$taokouling}", $msgios);
			      	 	$msgios=str_replace('#二合一链接#',"{$rhyurl}", $msgios);
			      	 	$msgios=str_replace('#短链接#',"{$ddwz}", $msgios);
			     // }
	               
	               //$msgios=$msgios;
	               //$msgaz=$msgaz;
	               
	               //$msgios="【商品】".$views['itemtitle']."<br/>【原价】".$views['itemprice']."元<br/>【优惠券】".$views['couponmoney']."元<br/>【券后价】".$views['itemendprice']."元<br/>-------------<br/>【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$taokouling;
	               
          		   //$msgaz="【商品】".$views['itemtitle']."\r\n【原价】".$views['itemprice']."元\r\n【优惠券】".$views['couponmoney']."元\r\n【券后价】".$views['itemendprice']."元\r\n-------------\r\n【商品领券下单】长按复制这条信息，打开【手机淘宝】可领券并下单".$taokouling;
          	 
		          	if(empty($res['dclickUrl'])){
		          		exit(json_encode(array('status'=>1,'ios' =>$res['error'],'az' =>$res['error'],'picurl' =>$picurl))); 
		          	}else{
		          		exit(json_encode(array('status'=>1,'ios' =>$msgios,'az'=>$msgaz,'picurl' =>$picurl))); 
		          	}  
                   
                }
  	     }
?>