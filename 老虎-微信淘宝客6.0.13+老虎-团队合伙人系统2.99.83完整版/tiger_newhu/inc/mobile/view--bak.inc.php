<?php
 global $_W, $_GPC;
       $cfg = $this->module['config'];
       $dluid=$_GPC['dluid'];//share id
       $id=$_GPC['id'];
       $pc=$_GPC['pc'];
       $pid=$_GPC['pid'];
       $lm=$_GPC['lm'];//1 联盟  2 云商品库  
       $itemid=$_GPC['itemid'];//云商品库商品ID
       $dlyj=$_GPC['dlyj'];
			 
			 
       
       
//     $fans=mc_oauth_userinfo();
//     print_r($fans);
//     exit;
       $weid=$_W['uniacid'];


       $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();        
        }



       if(pdo_tableexists('tiger_wxdaili_set')){
          $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
       }
       //print_r($bl);

        if(!empty($dluid)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
          $openid=$fans['openid'];
          $zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        }else{
         // $fans=mc_oauth_userinfo();
          
          $openid=$fans['openid'];
          $zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
          if($zxshare['status']==1){
          	message('访问出错！确定返回首页', $this->createMobileUrl('index'), 'error');
          }
        }
        if($zxshare['dltype']==1){
            if(!empty($zxshare['dlptpid'])){
               $cfg['ptpid']=$zxshare['dlptpid'];
               $cfg['qqpid']=$zxshare['dlqqpid'];
            }
            
        }else{
           if(!empty($zxshare['helpid'])){//查询有没有上级
                 $sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and id='{$zxshare['helpid']}'");           
            }
        }
        

        if(!empty($sjshare['dlptpid'])){
            if(!empty($sjshare['dlptpid'])){
              $cfg['ptpid']=$sjshare['dlptpid'];
              $cfg['qqpid']=$sjshare['dlqqpid'];
            }   
            $dlewm="http://bshare.optimix.asia/barCode?site=weixin&url=".urlencode($sjshare['url']);
        }else{
           if($share['dlptpid']){
               if(!empty($share['dlptpid'])){
                 $cfg['ptpid']=$share['dlptpid'];
                 $cfg['qqpid']=$share['dlqqpid'];
               }       
               $dlewm="http://bshare.optimix.asia/barCode?site=weixin&url=".urlencode($share['url']);
            }
        }
      if(empty($pid)){
        	$pid=$cfg['ptpid'];
	    }else{
	    	$cfg['ptpid']=$pid;
	    }
			
			//$tkuid = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_share") . " WHERE weid='{$weid}' and  dlptpid='{$cfg['ptpid']}'");
			$pidSplit=explode('_',$cfg['ptpid']);
			$memberid=$pidSplit[1];
			if(empty($memberid)){
				$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
			}else{
				$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  memberid='{$memberid}'");
			}
			
			
// 		echo $cfg['ptpid'];
// 			echo "<pre>";
// 						print_r($tksign);
// 						exit;


         include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
         include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
         

          if($lm==1){//联盟产品
             $views['itemid']=$_GPC['itemid'];
             $views['itemprice']=$_GPC['org_price'];
             $views['itemendprice']=$_GPC['price'];
             $views['couponmoney']=$_GPC['coupons_price'];
             $views['itemsale']=$_GPC['goods_sale'];             
             $views['itemtitle']=$_GPC['title'];
             $views['itempic']=$_GPC['pic_url'];
             $couponendtime=strtotime($_GPC['coupons_end']);
             $ctime=date('Y/m/d H:i:s',$couponendtime);
             $pid=$_GPC['pid'];
             if(!empty($pid) and $pid!='undefined'){
             
               $cfg['ptpid']=$pid;
               $views['pid']=$pid;
               $pidSplit=explode('_',$cfg['ptpid']);
               $cfg['siteid']=$pidSplit[2];
               $cfg['adzoneid']=$pidSplit[3];
             }
//             echo $cfg['ptpid'];
//             exit;
//             echo '<pre>';
//             echo $cfg['ptpid'];
//             print_r($views);
//             exit;

             $viewslist=getviewcat($views['fqcat'],6,$cfg);


             $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
             $myck=$ck['data'];
             $turl="https://item.taobao.com/item.htm?id=".$views['itemid'];
             $res=hqyongjin($turl,$ck,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W,1,$views['itemid']);
             $views['tkrates']=$res['commissionRate'];
             
//           echo "<pre>";
//           	print_r($res);
//           	exit;
               

             $views['tk_rate']=$res['commissionRate'];
               if($cfg['yktype']==1){
                   if(empty($res['money'])){
                     $_GPC['url']=$res['itemurl'];
                     $views['url']=$res['itemurl'];
                     $rhyurl=$res['itemurl'];
                   }else{
                     $_GPC['url']=$res['dclickUrl'];
                     $views['url']=$res['dclickUrl'];
                     $rhyurl=$res['dclickUrl'];
                   }
                   
               }else{
                  if($res['qq']==1){
                     $rhyurl=$this->rhydx($views['quan_id'],$views['num_iid'],$cfg['ptpid']);
                   }else{
                     $rhyurl=$this->rhy($views['quan_id'],$views['num_iid'],$cfg['ptpid']);//二合一连接
                   }
                   $_GPC['url']=$rhyurl;
                   $views['url']=$rhyurl;
               } 
               if(empty($views['itemprice']) || $views['itemprice']=='0.00'){
                	$views['itemprice']=$views['itemendprice']+$views['couponmoney'];
               }
							 if(!empty($_GPC['gopturl'])){
							 	$views['gopturl']=base64_decode($_GPC['gopturl']);//拼团链接,有拼团链接就不用在转链接
							 	$views['url']=tbdwzurl("http:".$views['gopturl']);
								$_GPC['url']=$views['url'];
								$rhyurl=$views['url'];
							 }
							 
							 
          }elseif($lm==2){//云商品库产品
          	  
          	  $views=getview($itemid);
          	  if(!empty($itemid)){
          	  	$turl="https://item.taobao.com/item.htm?id=".$_GPC['$itemid'];
                $res=hqyongjin($turl,$ck,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W,1,$itemid); 
          	  }
          	  $viewslist=getviewcat($views['fqcat'],6,$cfg);
          	  $rhyurl=$res['dclickUrl']."&activityId=".$views['quan_id'];
          	  $ctime=date('Y/m/d H:i:s',$views['couponendtime']);
          	  
//        	  echo "<pre>";
// 						print_r($res);
//             exit;
          	  
          	  //echo $ctime;
          	  //exit;
//        	    echo '<pre>';
//        	    print_r($views);
//	      	  	print_r($res);
//	      	  	exit;
          }elseif($lm==3){
          	$views['itemid']=$_GPC['itemid'];
             $views['itemprice']=$_GPC['itemprice'];
             $views['itemendprice']=$_GPC['itemendprice'];
             $views['couponmoney']=$_GPC['couponmoney'];
             $views['itemsale']=$_GPC['itemsale'];             
             $views['itemtitle']=$_GPC['title'];
             $views['itempic']=$_GPC['itempic'];
             $couponendtime=strtotime($_GPC['couponendtime']);
             $ctime=date('Y/m/d H:i:s',$couponendtime);
             $pid=$_GPC['pid'];
             if(!empty($pid) and $pid!=='undefined'){
               $cfg['ptpid']=$pid;
               $views['pid']=$pid;
               $pidSplit=explode('_',$cfg['ptpid']);
               $cfg['siteid']=$pidSplit[2];
               $cfg['adzoneid']=$pidSplit[3];
             }
//             echo $cfg['ptpid'];
//             exit;
//             echo '<pre>';
//             echo $cfg['ptpid'];
//             print_r($views);
//             exit;
               
             $viewslist=getviewcat($views['fqcat'],6,$cfg);


             $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
             $myck=$ck['data'];
             $turl="https://item.taobao.com/item.htm?id=".$views['itemid'];
             $res=hqyongjin($turl,$ck,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W,1,$views['itemid']);
             $views['tkrates']=$res['commissionRate'];

//             echo "<pre>";
//             print_r($res);
//             exit;
             

             $views['tk_rate']=$res['commissionRate'];
               if($cfg['yktype']==1){
                   if(empty($res['money'])){
                     $_GPC['url']=$res['itemurl'];
                     $views['url']=$res['itemurl'];
                     $rhyurl=$res['itemurl'];
                   }else{
                     $_GPC['url']=$res['dclickUrl'];
                     $views['url']=$res['dclickUrl'];
                     $rhyurl=$res['dclickUrl'];
                   }
                   
               }else{
                  if($res['qq']==1){
                     $rhyurl=$this->rhydx($views['quan_id'],$views['num_iid'],$cfg['ptpid']);
                   }else{
                     $rhyurl=$this->rhy($views['quan_id'],$views['num_iid'],$cfg['ptpid']);//二合一连接
                   }
                   $_GPC['url']=$rhyurl;
                   $views['url']=$rhyurl;
               } 
          }else{
              if(!empty($cfg['gyspsj'])){
                $weid=$cfg['gyspsj'];
              }
              //echo 'aaaa';
               if(!empty($itemid)){
                  $views=pdo_fetch("select * from".tablename($this->modulename."_newtbgoods")." where weid='{$weid}' and itemid='{$itemid}'");
                  $ctime=date('Y/m/d H:i:s',$views['couponendtime']);
                  $viewslist = pdo_fetchall("select * from ".tablename($this->modulename."_newtbgoods")." where weid='{$weid}' and fqcat='{$views['fqcat']}' order by id desc limit 6");
                  
                  $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
                   $myck=$ck['data'];
                   $turl="https://item.taobao.com/item.htm?id=".$views['itemid'];
                   $res=hqyongjin($turl,$ck,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W,1,$itemid);
                   
                   if($cfg['yktype']==1){
                       $rhyurl=$res['dclickUrl']."&activityId=".$views['quan_id'];
                   }else{
                      $rhyurl=$this->rhy($views['quan_id'],$itemid,$cfg['ptpid']);//二合一连接
                   }
                }
          }
         

            //PC网站-----------------------------------
            if($pc==1){
              header("location:".$rhyurl);
            }
            //PC结束

            //echo $lxtype;
            //exit;
            
	      if(!empty($rhyurl)){
	      	$tjcontent=$views['itemtitle'];
	      	$rhyurl=str_replace("http:","https:",$rhyurl);
					
					//echo $rhyurl;
					//exit;
					
	        $taokouling=$this->tkl($rhyurl,$views['itempic'],$tjcontent);
					//echo  $taokouling."--0";
					//exit;
	        //$taokou=$taokouling->model;
	       // settype($taokou, 'string');
	        $views['taokouling']=$taokouling;
	      }

	      
//	      $bbb=$this->tkl("https://uland.taobao.com/coupon/edetail?e=ZRu9ucpmG0EGQASttHIRqSxezMgi5gP1%2BRUk6VVcjnHOYE6ZUVle2SAJlpJvh4j8EmfKcQeS99F5yepcRw0uu0hMrwC97%2FSyqpYM1S9PYKNY4Y%2Fgpq45GoD0X04J4a2T&traceId=0bb7501515034652584541047e&activityId=cd89c3d03b724b3ba79eb1e1ea1b34a7",'https://img.alicdn.com/bao/uploaded/i4/TB1RZnjXnAPL1JjSZFLYXFbWVXa_M2.SS2_430x430q90.jpg','ssssssss');
//	    echo $bbb;
//      exit;
	
       

//     $fans=$_W['fans'];
//     if(!empty($fans['openid'])){
//       $scgoods = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_shoucang") . " WHERE weid = '{$weid}' and goodsid='{$views['id']}' and openid='{$fans['openid']}'");
//     }

       //
      // $yongjin=$views['itemendprice']*$views['tkrates']/100;//佣金
//     if($cfg['fxtype']==1){//积分           
//          //$flyj=intval($yongjin*$cfg['zgf']/100*$cfg['jfbl']);//自购佣金
//          $lx=$cfg["hztype"];
//      }else{//余额
//         // $yongjin=number_format($yongjin, 2, '.', ''); 
//          //$flyj=$yongjin*$cfg['zgf']/100;//自购佣金
//          //$flyj=number_format($flyj, 2, '.', ''); 
//          $lx=$cfg["yetype"];
//          if($cfg['txtype']==3){
//              //$flyj=$flyj*100;
//              $lx='集分宝';            
//          }
//      }
//      
//      
//      if($zxshare['dltype']==1){
//      	$lx=$cfg["yetype"];
//      }else{
//      	if($cfg['fxtype']==1){//积分           
//         		 $lx=$cfg["hztype"];
//	        }else{//余额
//	            $lx=$cfg["yetype"];
//	            if($cfg['txtype']==3){
//	                $lx='集分宝';            
//	            }
//	        }
//      }
        
        if($cfg['lbratetype']==1){//显示普通和代理
        	$flyj=$this->sharejl($views['itemendprice'],$views['tkrates'],$bl,$zxshare,$cfg); 
        	if($zxshare['dltype']==1){
        		$lx=$cfg["yetype"];
        	}else{
        		if($cfg['fxtype']==1){//积分           
	           		 $lx=$cfg["hztype"];
		        }else{//余额
		            $lx=$cfg["yetype"];
		            if($cfg['txtype']==3){
		                $lx='集分宝';            
		            }
		        }
        	}        	
        }elseif($cfg['lbratetype']==2){//只显示代理        	
        	if($zxshare['dltype']==1){
        		$flyj=$this->sharejl($views['itemendprice'],$views['tkrates'],$bl,$zxshare,$cfg); 
        		$lx=$cfg["yetype"];
        	}else{
        		$flyj='';
        		$lx='';
        	}        	
        }elseif($cfg['lbratetype']==3){//代理和普通会员都显示普通的佣金和积分
        	$flyj=$this->ptyjjl($views['itemendprice'],$views['tkrates'],$cfg);
        	if($cfg['fxtype']==1){//积分           
           		 $lx=$cfg["hztype"];
	        }else{//余额
	            $lx=$cfg["yetype"];
	            if($cfg['txtype']==3){
	                $lx='集分宝';            
	            }
	        }
        }
        
        
        
        
        
        

        //echo '<pre>';
        //print_r($views);
        //exit;


          //上报日志-----------------------
            $arr=array(
               'pid'=>$cfg['ptpid'],
               'account'=>"无",
               'mediumType'=>"微信群",
               'mediumName'=>"老虎优惠券".rand(10,5000),
               'itemId'=>$views['num_iid'],
               'originUrl'=>"https://item.taobao.com/item.htm?id=".$views['itemid'],
               'tbkUrl'=>$rhyurl,
               'itemTitle'=>$views['itemtitle'],
               'itemDescription'=>$views['itemtitle'],
               'tbCommand'=>$views['taokouling'],
               'extraInfo'=>"无",
            );
            include IA_ROOT . "/addons/tiger_newhu/inc/sdk/taoapi.php"; 
            $resp=getapi($arr);
//            echo '<pre>';
//            print_r($arr);
//            print_r($resp);
//            exit;
            //日志结束

       //$url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('view',array('id'=>$views['id'],'dluid'=>$dluid,'lm'=>$lm,'num_iid'=>$views['num_iid'],'org_price'=>$views['org_price'],'price'=>$views['price'],'coupons_price'=>$views['coupons_price'],'goods_sale'=>$views['goods_sale'],'url'=>$rhyurl,'title'=>$views['title'],'pic_url'=>$views['pic_url'],'pid'=>$_GPC['pid'])));

       //http://cs.youqi18.com/app/index.php?i=3&c=entry&do=view&m=tiger_newhu&id=undefined&dluid=0&lm=1&num_iid=544317483003&org_price=39.40&price=34.4&coupons_price=5&goods_sale=323&url=&title=&pic_url=http%3A%2F%2Fimg2.tbcdn.cn%2Ftfscom%2Fi3%2FTB1wz4sQpXXXXbaXFXXXXXXXXXX_!!0-item_pic.jpg&pid=mm_13157221_19846366_71352774
       //$url1=$this->dwzewm($url);

       //$emw="http://pan.baidu.com/share/qrcode?w=150&h=150&url=".$url1;
       //$emw=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('ewmin',array('url'=>$url)));
       //echo '<pre>';
       //print_r($res);
      // exit;
      $rhyurl2=urlencode($rhyurl);
      $sjlx=$this->get_device_type();//手机类型 换行 安桌:\r\n  ios:<br>
      
      //二维码图片链接
        $viewurl=$_W['siteroot'].$_SERVER['REQUEST_URI'];//当前网址
        if(empty($cfg['itemewm'])){
	    	$ewmurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('openview'))."&link=".$rhyurl;
	    }elseif($cfg['itemewm']==1){
	    	$ewmurl=$viewurl;
	    }elseif($cfg['itemewm']==2){
	    	$ewmurl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('tklview',array('itemid'=>$views['itemid'],'itemendprice'=>$views['itemendprice'],'couponmoney'=>$views['couponmoney'],'itempic'=>urlencode($views['itempic']),'tkl'=>$views['taokouling'],'itemprice'=>$views['itemprice'])))."&rhyurl=".$rhyurl."&itemtitle=".urlencode($views['itemtitle']);
	    	//$url=urlencode($url);
	    }elseif($cfg['itemewm']==3){//百度
            $straaa=urlencode("请点击右下方复制按钮".$views['taokouling']."然后打开手机淘宝即可领券购买");
         	$ewmurl="http://fanyi.baidu.com/?aldtype=16047#cht/zh/".$straaa;
         	//$url=urlencode($urlaa);
       }elseif($cfg['itemewm']==4){//百度        	
        	$bdtkl=str_replace("￥","",$views['taokouling']);
            $ewmurl1=$_W['siteroot']."addons/tiger_newhu/baidu.php?token=".$bdtkl;
            $ewmurl="http://fanyi.baidu.com/transpage?query=".$ewmurl1."&source=url&ie=utf8&from=zh&to=en&render=1";    
        }elseif($cfg['itemewm']==5){//快站 
				  $taokou=str_replace("￥","",$views['taokouling']);
					$taokou="(".$taokou.")";
        	$ewmurl=$cfg['kuaizhanurl']."?image=".urlencode($views['itempic'])."&word=".$views['taokouling']."&nmd=".$taokou;   
        }
      
      if($cfg['xqdwzxs']==1){      	
        $ddwz=$this->dwzw($ewmurl);
      }
      $rhyurl3=$rhyurl;
     
      	    
      if($sjlx=='android'){
        	$msg=str_replace('#换行#','', $cfg['tklmb']);
      		$msg=str_replace('#名称#',"{$views['itemtitle']}", $msg);
      	 	$msg=str_replace('#推荐理由#',"{$views['itemdesc']}", $msg);
      	 	$msg=str_replace('#原价#',"{$views['itemprice']}", $msg);
      	 	$msg=str_replace('#券后价#',"{$views['itemendprice']}", $msg);
      	 	$msg=str_replace('#优惠券#',"{$views['couponmoney']}", $msg);
      	 	$msg=str_replace('#淘口令#',"{$views['taokouling']}", $msg);
      	 	$msg=str_replace('#二合一链接#',"{$rhyurl}", $msg);
      	 	$msg=str_replace('#短链接#',"{$ddwz}", $msg);
					//echo $msg;
					//exit;
      }else{
        	$msg=str_replace('#换行#','<br>', $cfg['tklmb']);
      		$msg=str_replace('#名称#',"{$views['itemtitle']}", $msg);
      	 	$msg=str_replace('#推荐理由#',"{$views['itemdesc']}", $msg);
      	 	$msg=str_replace('#原价#',"{$views['itemprice']}", $msg);
      	 	$msg=str_replace('#券后价#',"{$views['itemendprice']}", $msg);
      	 	$msg=str_replace('#优惠券#',"{$views['couponmoney']}", $msg);
      	 	$msg=str_replace('#淘口令#',"{$views['taokouling']}", $msg);
      	 	$msg=str_replace('#二合一链接#',"{$rhyurl}", $msg);
      	 	$msg=str_replace('#短链接#',"{$ddwz}", $msg);
      }
			
			
      
      if($cfg['lbtx']==1){//订单轮播
	     $msg1 = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_msg") . " WHERE weid = '{$_W['uniacid']}' order by rand() desc limit 20");
	  }
      
      $rhyurl=urlencode($rhyurl);
      $time=time();
      $gootime0=date('Y-m-d H',$views['couponstarttime']);
      $gootime=strtotime($gootime0);
      


      
      if($time>$gootime){
          $kj=1;
      }else{
          $kj=0;
      }
      
      
      if($_GPC['fromid']==1){
      	$views['rhyurl']=$rhyurl;
      	exit(json_encode(array('data' =>$views)));
      }
			
			//拼团
// 			 $pturl=$_GPC['pturl'];
// 			 $ptorprice=$_GPC['ptorprice'];
// 			 $ptsum=$_GPC['ptsum'];
// 			 $ptprice=$_GPC['ptprice'];
// 			 if(!empty($ptsum)){
// 				 $views['url']=$pturl;
// 				 $taokouling=$this->tkl("http:".$views['url'],$views['itempic'],$tjcontent);
// 				 $views['taokouling']=$taokouling;
// 			 }

			 //拼团结束
// 			echo '<pre>';
// 			print_r($views);
// 			exit;
			
		
     
       

        include $this->template ( 'tbgoods/style99/view' );
?>