 <?php
  global $_W, $_GPC;
         $cfg = $this->module['config'];
				 $dlcfg=$cfg;
//         echo "<pre>";
//         print_r($cfg);
//         exit;
        load()->model('mc');         
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();
	        if(empty($fans)){
	        	$loginurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('login'))."&m=tiger_newhu"."&tzurl=".urlencode($tktzurl);        	  	  	     	 
       	  	  	 header("Location: ".$loginurl); 
       	  	  	 exit;
	        }
        }
        

        
//      echo "<pre>";
//      print_r($fans);
//      echo "-----------------------------------";
//      exit;
 		    $wquid=mc_openid2uid($fans['openid']);
        $helpid=$_GPC['helpid'];
        $member=$this->getmember($fans,$wquid,$helpid);
        $fans['tkuid']=$member['id'];
//      echo "<pre>";
//      print_r($member);
//      exit;

//结束

         $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");

          if($_W['isajax']){

              if($bl['dlfftype']==1){
                 exit(json_encode(array('statusCode' =>1100,'msg'=>'代理申请已开通付费模式，请使用付费模式申请')));
              }
              if(1){
                     $data=array(
                           'weixin'=>$_GPC['weixin'],
                           'tel'=>$_GPC['tel'],
													 'pcuser'=>$_GPC['tel'],
                           'dlmsg'=>$_GPC['dlmsg'],
                           'tname'=>$_GPC['tname'],
                           'dltype' =>2,
                           'pcpasswords'=>$_GPC['pcpasswords'],
                       );
					  $uid=$_GPC['uid'];
					  $share=pdo_fetch("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and id='{$uid}'");
					  
                      $arr=pdo_update("tiger_newhu_share", $data, array('id' =>$_GPC['uid'],'weid'=>$_W['uniacid']));
					  if($cfg['zdshtype']==1){
						  $this->dlzdsh($share['id'],$share,$cfg['glyopenid'],$cfg);
					  }
					   
                      if($arr=== false){
                          exit(json_encode(array('statusCode' =>1100,'msg'=>'申请代理失败，请联系管理员1')));
                       }else{
                           //模版消息
                              if(!empty($cfg['dlsqtx'])){//管理员订单提交提醒
                                    $mbid=$cfg['dlsqtx'];
                                    $mb=pdo_fetch("select * from ".tablename("tiger_newhu_mobanmsg")." where weid='{$_W['uniacid']}' and id='{$mbid}'");
                                    //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n 1old:".json_encode($cfg['dlsqtx']),FILE_APPEND);
                                    $valuedata=array(
																			 'rmb'=>$pice,
																			 'txzhanghao'=>$_GPC['zfbuid'],//提现支付帐帐号
																			 'dlmsg'=>$_GPC['dlmsg'],//申请理由
																			 'tname'=>$_GPC['tname'],//申请人姓名
																			 'tel'=>$_GPC['tel'],
																			 'weixin'=>$_GPC['weixin'],
																			 'shenhe'=>'',//'审核通过|审核不通过|资料有误请重新提交审核',
																			 'goodstitle'=>''//'积分商城，商品名称'
																	 );
                                    $msg=$this->mbmsg($cfg['glyopenid'],$mb,$mb['mbid'],$mb['turl'],$fans,'',$cfg,$valuedata);                  
                               }
                               //结束
                          exit(json_encode(array('statusCode' => 200,'msg'=>'申请成功，等待审核！')));
                       }
                 }
                
         }
         
		 if($cfg['dlsqtype']==1){
			 if(!empty($cfg['dlnum'])){
			 	$dlnum = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and helpid='{$member['id']}' and dltype=1");//粉丝
			 	if(empty($dlnum)){
			 		$dlnum=0;
			 	}
			 }
			 if(!empty($cfg['fsnum'])){
			 	$fsnum = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and helpid='{$member['id']}'");//粉丝
			 	if(empty($fsnum)){
			 		$fsnum=0;
			 	}
			 }
		 }
		 
        include $this->template ('dl/hhrreg'); 
			 //include $this->template ('dlreg'); 
        ?>