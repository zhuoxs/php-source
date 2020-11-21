<?php
//http://r0hgk.cn/app/index.php?i=14&c=entry&m=tiger_newhu&do=jqrkl&pid=mm_13157221_19846366_110806711&str=%E5%A4%8D%E5%88%B6%E6%95%B4%E6%AE%B5%E4%BF%A1%E6%81%AF%EF%BC%8C%E6%89%93%E5%BC%80%E5%A4%A9%E7%8C%ABAPP%EF%BC%8C%E5%8D%B3%E5%8F%AF%E6%9F%A5%E7%9C%8B%E6%AD%A4%E5%95%86%E5%93%81:%E3%80%90%E7%8C%AB%E4%BA%BA%E5%86%85%E8%A1%A3%E5%A5%B3%E6%96%87%E8%83%B8%E6%97%A0%E9%92%A2%E5%9C%88%E5%B0%8F%E8%83%B8%E8%81%9A%E6%8B%A2%E4%B8%8A%E6%89%98%E5%A4%8F%E5%AD%A3%E5%B0%91%E5%A5%B3%E5%85%89%E9%9D%A2%E6%97%A0%E7%97%95%E6%80%A7%E6%84%9F%E8%96%84%E6%AC%BE%E8%83%B8%E7%BD%A9%E3%80%91(%E6%9C%AA%E5%AE%89%E8%A3%85App%E7%82%B9%E8%BF%99%E9%87%8C%EF%BC%9Ahttp://zmnxbc.com/s/Wd02W?tm=c32bc7%20)%E5%96%B5%E5%8F%A3%E4%BB%A4
global $_W, $_GPC;
         $cfg = $this->module['config'];
         $str=urldecode(trim($_GPC['str']));
         $pid=$_GPC['pid'];
				 $pddpid=$_GPC['pddpid'];
				 $jdpid=$_GPC['jdpid'];
         
         if(!empty($pid)){
           $cfg['ptpid']=$pid;
         }
				 $pidSplit=explode('_',$cfg['ptpid']);
				 $memberid=$pidSplit[1];
				 if(empty($memberid)){
				 $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
				 }else{
				 $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  memberid='{$memberid}'");
				 }
				 include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
				 include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
				 include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/notb.php"; 
				 include IA_ROOT . "/addons/tiger_newhu/inc/sdk/taoapi.php"; 
				 include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/pdd.php"; 
				 include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/jd.php"; 
				 
				 
				 
				 
				 //京东开始
				  $arr=strstr($str,"jd.com");
				  if($arr!==false){
				          	//获取京东推广位
				      $jdset=pdo_fetch("select * from ".tablename('tuike_jd_jdset')." where weid='{$_W['uniacid']}' order by id desc");
				      if(!empty($jdpid)){
								$p_id=$jdpid;
							}else{
								$p_id=$jdset['jduid'];
							}
			 			
				 			
				          	$geturl=$this->geturl($str);
				          	$goodsid=$this->jdgoodsID($geturl);
				   //       	return $this->respText($goodsid);
				          	if(empty($goodsid)){
				          		//return $this->respText($cfg['ermsg']);
				          	}
				          	
				          	$jdview=getcqview($goodsid,$jdset['jduid']);
				          	if(empty($jdview['goodsName'])){
				          		//return $this->respText($cfg['ermsg']);
				          	}
				          	
				          	
				          	//return $this->respText($jdview['goodsName']);
				          	$ssview=getkeylist('',$jdview['goodsName'],1,$goodsid);//搜索标题获取搜索结果获取优惠券链接
				          	$yhjurl=$ssview['data'][0]['couponList'][0]['link'];
				 					
				 					//return $this->respText($yhjurl);
				 					
				          	$jdsign=pdo_fetch("select * from ".tablename('tuike_jd_jdsign')." where weid='{$_W['uniacid']}' order by id desc");
				          	$zl=jdviewzl($jdset,$jdsign,$goodsid,$p_id);
										
				          	if(!empty($zl['jdrhy'])){
				          		$couponmoney=$zl['discount_price'];
				          		$vurl=$zl['jdrhy'];
				 						//return $this->respText("---".$zl['jdyurl']);
				          	}else{
				          		    //好京客 
				 							
				 		         	//$hjkurl="http://haojingke.com/index.php/api/index/myapi?type=goodsdetail&apikey=5e16dd968daf20de&skuid=25791192770";
				 							$hjkurl="http://www.haojingke.com/index.php/api/index/myapi?type=goodsdetail";
				 							$hjkpost=array('apikey'=>'5e16dd968daf20de','skuid'=>$goodsid);
				 		         	$hjkview=$this->curl_request($hjkurl,$hjkpost);
				 		         	$hjkarr=@json_decode($hjkview, true);
// 											echo "<pre>";
// 											print_r($hjkarr);
// 											exit;
				 		         	//return $this->respText($hjkarr['data']['skuName']);
				 		         	if(!empty($hjkarr['data']['couponList'])){         		
				 		         		if(!empty($hjkarr['data']['couponList'])){//有优惠券就用二合一的接口
				 			         		$couponmoney=$hjkarr['data']['discount'];//优惠券面额
													//echo $couponmoney;
				 			         		$vurl=viewrhy('',$hjkarr['data']['couponList'],$goodsid,$jdset['unionid'],$p_id);//二合一链接
				 									//return $this->respText(2);
				 			         	}else{//没优惠券直接转链
				 								  if(!empty($yhjurl)){
				 										//return $this->respText($yhjurl);
				 										$couponmoney=$ssview['data'][0]['couponList'][0]['discount'];//优惠券面额
				 										$vurl=viewrhy('','http:'.$yhjurl,$goodsid,$jdset['unionid'],$p_id);//二合一链接
				 										//return $this->respText(3);
				 									}else{
				 										$vurl=viewzl('',$goodsid,$jdset['unionid'],$p_id);//没优惠券的直接转
				 										$couponmoney=0;
				 										//return $this->respText(4);
				 									}			         		
				 			         	}		         		
				 		         		//return $this->respText($couponmoney.$hjkarr['datda']['couponList']);
				 		         	}else{
				 								//return $this->respText(5);
				 		         		if(!empty($yhjurl)){//有优惠券就用二合一的接口
				 			         		$couponmoney=$ssview['data'][0]['couponList'][0]['discount'];//优惠券面额
				 			         		$vurl=viewrhy('','http:'.$yhjurl,$goodsid,$jdset['unionid'],$p_id);//二合一链接
				 			         	}else{//没优惠券直接转链
				 			         		$vurl=viewzl('',$goodsid,$jdset['unionid'],$p_id);//没优惠券的直接转
				 			         		$couponmoney=0;
				 			         	}
				 		         	}
				          	}
										//echo $vurl;
									//	exit;
				          	
				          	        
				          	//return $this->respText("++++".$vurl);
				          	
				          	
				 //       	$tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('jdgoodslist',array('key'=>$jdview['goodsName'])));			
				 //          $ddwz=$this->pdddwzw($tturl);//同类产品
				             
				             $itemprice=$jdview['wlUnitPrice'];
				             $itemendprice=$jdview['wlUnitPrice']-$couponmoney;
				             $rate=$jdview['commisionRatioWl'];
				             //奖励
				             $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
				 			if($cfg['lbratetype']==3){//全都用代理积分
				 				$flyj=$this->ptyjjl($itemendprice,$rate,$cfg);
				 	        	if($cfg['fxtype']==1){//积分           
				 	           		 $lx=$cfg["hztype"];	
				 	           		  $flyj=intval($flyj);		           		 
				 		        }else{//余额
				 		            $lx=$cfg["yetype"];
				 		            if($cfg['txtype']==3){
				 		                $lx='集分宝';            
				 		            }
				 		            $zyh=$couponmoney+$flyj;//优惠金额
				 	          	    $zyhhprice=$itemprice-$zyh;//优惠后价格
				 		        }
				 			}else{
				 	               if($cfg['fxtype']==1){//积分
				 			            $flyj=$this->sharejl($itemendprice,$rate,$bl,$share,$cfg);
				 			        }else{//余额            
				 			            $flyj=$this->sharejl($itemendprice,$rate,$bl,$share,$cfg);
				 			            $zyh=$couponmoney+$flyj;//优惠金额
				 			            $zyhhprice=$itemprice-$zyh;//优惠后价格
				 			        }	
				 			}
				 			//结束
				 			
				 			$msg=str_replace('#换行#','', $cfg['pddwenan']);
				 			$msg=str_replace('#拼多多短网址#',$vurl, $msg);
				 			$msg=str_replace('#名称#',$jdview['goodsName'], $msg);
				 			$msg=str_replace('#推荐理由#',$jdview['goodsName'], $msg);
				 			$msg=str_replace('#原价#',$itemprice, $msg);
				 			$msg=str_replace('#券后价#',$itemendprice, $msg);
				 			$msg=str_replace('#优惠券#',$couponmoney, $msg);			
				 			$msg=str_replace('#奖励#',$flyj.$lx, $msg);
				 //			$msg=str_replace('#同类产品#',$ddwz, $msg);
				 			//return $this->respText($msg);	
							exit($msg);
				     }
				          
				          //京东结束
									
									
					//拼多多
					$arr=strstr($str,"yangkeduo.com");
					if($arr!==false){

				//PID结束
				$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$_W['uniacid']}'");
				$owner_name=$pddset['ddjbbuid'];
				if(empty($pddpid)){
					$p_id=$pddset['pddpid'];
				}else{
					$p_id=$pddpid;
				}
				//获取链接
				$geturl=$this->geturl($str);
				$itemid=$this->pddgoodsID($geturl);
				//return $this->respText($itemid);
				if(empty($itemid)){
					//return $this->respText($cfg['ermsg']);
				}		
				//转链详情
				$zl=pddviewzl($owner_name,$itemid,$p_id);	
				file_put_contents(IA_ROOT."/addons/tiger_newhu/log-pdd.txt","\n".json_encode($zl),FILE_APPEND);	
				$data=$zl['goods_promotion_url_generate_response']['goods_promotion_url_list'][0];		
				$itemendprice=($data['goods_detail']['min_group_price']-$data['goods_detail']['coupon_discount'])/100;
				$itemtitle=$data['goods_detail']['goods_name'];
				$itemprice=$data['goods_detail']['min_group_price']/100;
				$couponmoney=$data['goods_detail']['coupon_discount']/100;
				$url2=$data['we_app_web_view_url'];//短网址
				$itemdesc=$data['goods_detail']['goods_desc'];
				$rate=$data['goods_detail']['promotion_rate']/10;//实际佣金
				if(!empty($zl['error_response'])){
					$itemtitle=$zl['error_response']['error_msg'];
					$itemtitle=$cfg['error2'];
					//return $this->respText($itemtitle);
				}
				if(empty($rate)){
					$itemtitle=$cfg['error2'];
					//return $this->respText($itemtitle);
				}
				$bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
				if($cfg['lbratetype']==3){//全都用代理积分
					$flyj=$this->ptyjjl($itemendprice,$rate,$cfg);
							if($cfg['fxtype']==1){//积分           
									$lx=$cfg["hztype"];	
										$flyj=intval($flyj);		           		 
							}else{//余额
									$lx=$cfg["yetype"];
									if($cfg['txtype']==3){
											$lx='集分宝';            
									}
									$zyh=$couponmoney+$flyj;//优惠金额
										$zyhhprice=$itemprice-$zyh;//优惠后价格
							}
				}else{
									if($cfg['fxtype']==1){//积分
										$flyj=$this->sharejl($itemendprice,$rate,$bl,$share,$cfg);
								}else{//余额            
										$flyj=$this->sharejl($itemendprice,$rate,$bl,$share,$cfg);
										$zyh=$couponmoney+$flyj;//优惠金额
										$zyhhprice=$itemprice-$zyh;//优惠后价格
								}	
				}
				
				$tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('pddgoodslist',array('key'=>$itemtitle)));			
							$ddwz=$this->pdddwzw($tturl);
				
				$msg=str_replace('#换行#','', $cfg['pddwenan']);
				$msg=str_replace('#名称#',$itemtitle, $msg);
				$msg=str_replace('#推荐理由#',$itemdesc, $msg);
				$msg=str_replace('#原价#',$itemprice, $msg);
				$msg=str_replace('#券后价#',$itemendprice, $msg);
				$msg=str_replace('#优惠券#',$couponmoney, $msg);
				$msg=str_replace('#拼多多短网址#',$url2, $msg);
				$msg=str_replace('#奖励#',$flyj.$lx, $msg);
				$msg=str_replace('#同类产品#',$ddwz, $msg);
				exit($msg);
				    //return $this->respText($msg);			
						//return $this->respText("");
						//return '';
					}
					//拼多多结束
				 
				 
				 
				 
				 
				 //淘宝
				 $cxtkl=$str;
				 if(!empty($cxtkl)){
				 	$klurl=$this->tkljx($cxtkl);
				 	if(!empty($klurl['url'])){
				 		$geturl=$klurl['url'];
				 	}else{
				 		$geturl=$this->geturl($cxtkl);
				 	}
				 }else{
				 	$geturl=$this->geturl($cxtkl);
				 }

				 
				 $arr=strstr($geturl,"http://m.tb.cn");
				 if($arr!==false){
				 	$geturl=str_replace("http:","https:",$geturl)."";
				 }
				 $istao=$this->myisexists($geturl); 

										
				              if(!empty($istao)){
				              	if($istao==1){//e22a地址
				              		
				              		 $goodsid=$this->getgoodsid($geturl);
				                  	 if(empty($goodsid)){
				                  	 	$goodsid=$this->hqgoodsid($geturl); 
				                  	 }
				                      if(empty($goodsid)){
				                         //return $this->respText($cfg['ermsg']);
																 exit;
																 exit($cfg['ermsg']);
				                      }  
				                                     
				              	}elseif($istao==2){//淘宝天猫地址
				              		$goodsid=$this->mygetID($geturl); 
				                  	 if(empty($goodsid)){
				                  	 	$goodsid=$this->getgoodsid($geturl);
				                  	 }
				 //                   $url="https://item.taobao.com/item.htm?id=".$goodsid;
				                      if(empty($goodsid)){
				                         //return $this->respText($cfg['ermsg']);
																 exit;
																 exit($cfg['ermsg']);
				                      }                     
				              	}elseif($istao==3){
				              		 $goodsid=$this->getrhy($geturl);
				              		 //return $this->respText(2222);
				              	}
				                
				              	 
				              	
				              	 $url="https://item.taobao.com/item.htm?id=".$goodsid;
												
				                  $key=urlencode($url);                     
				                  $goods=cjsearch(1,$cfg['ptpid'],$tksign['sign'],$tksign['tbuid'],$_W,$cfg,$key,2,'','','','',0,0,0);    
				                  $goods=$goods['result_list']['map_data'];//超级搜索结果
//  													echo "<pre>";
// 													print_r($goods);
// 													exit;
				                  
				                  //return $this->respText($url); 
				                               
				                  if(empty($goods)){
				                  	if($cfg['gzhcjtype']==1){
				                  		$cenkl=$this->tklresp($this->message['content'],$cfg);
				                  		//return $this->respText($cenkl);
															
															exit($cenkl);
				                  	}else{
				                  		//return $this->respText($cfg['error2']);
															exit;
															exit($cfg['error2']);
				                  	}
				                  }
				                  if(!empty($goods['coupon_info'])){//优惠券金额
													   	preg_match_all('|减(\d*)元|',$goods['coupon_info'], $returnArr);
															$conmany=$returnArr[1][0];     
													}else{
														$conmany=0;
													} 
													
				             	  
				                  $res=hqyongjin($url,0,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W,1,$goodsid);//申请高佣金                 
				                  $erylj=$res['dcouponLink'];
				                  //file_put_contents(IA_ROOT."/addons/tiger_newhu/yjlog.txt","\n".json_encode($res),FILE_APPEND);
				                    
				 	             //return $this->respText("111".$conmany);
				                  if(!empty($erylj)){
				                  	 $erylj=str_replace("http:","https:",$erylj);
				                      $taokouling=$this->tkl($erylj,$goods['pict_url'],$goods['title']);
				                      $res['taokouling']=$taokouling;
				                  }else{
				                  	if($cfg['gzhcjtype']==1){
				                  		$cenkl=$this->tklresp($this->message['content'],$cfg);
				                  		//return $this->respText($cenkl);
															exit($cenkl);
				                  	}else{
				                  		//return $this->respText($cfg['error2']);
															exit;
															exit($cfg['error2']);
				                  	}
				                  }
				                  //上报日志
				                  $arr=array(
				                    'pid'=>$cfg['ptpid'],
				                    'account'=>"无",
				                    'mediumType'=>"微信群",
				                    'mediumName'=>"老虎内部券".rand(10,100),
				                    'itemId'=>$goodsid,
				                    'originUrl'=>"https://item.taobao.com/item.htm?id=".$goodsid,
				                    'tbkUrl'=>$rhyurl,
				                    'itemTitle'=>$goods['title'],
				                    'itemDescription'=>$goods['title'],
				                    'tbCommand'=>$res['taokouling'],
				                    'extraInfo'=>"无",
				                  );
				                  $resp=getapi($arr);
				                 //日志结束
				                 if($cfg['gzljcj']==2){//开启所有用户查券
				                 	$share['cqtype']=1;
				                 }
				                 if(empty($share['cqtype'])){
				                      //关键词查询
				                      $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('lm'=>1,'pid'=>$cfg['ptpid'],'key'=>$goods['title'],'pic_url'=>$goods['pict_url'],'lx'=>2)));
				                      $ddwz=$this->dwzw($tturl);
				                      $newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsg']);
				                      $newmsg=str_replace('#名称#',$goods['title'], $newmsg);
				                      $newmsg=str_replace('#短网址#',$ddwz, $newmsg);     
				                      if(empty($goods['title'])){
				                      	//return $this->respText($cfg['ermsg2']);
																exit;
																exit($cfg['error2']);
				                      }                
				                      //return $this->respText($newmsg);
															exit($newmsg);
				                      //关键词查询结束
				                 }
				                    $itemprice=$goods['zk_final_price'];
				                    //$commissionRate=$goods['commission_rate']/100;
				                     $commissionRate=$res['commissionRate'];
				                    if(empty($conmany)){//如果ID为空优惠券有门槛的，就不计算优惠券
															$yongjin=$itemprice*$commissionRate/100;//佣金
															$itemendprice=$itemprice;
														}else{
															$yongjin=($itemprice-$conmany)*$commissionRate/100;//佣金
															$itemendprice=$itemprice-$conmany;
														}
				 			        
				 			        $share = pdo_fetch('select * from '.tablename($this->modulename."_share")." where from_user='{$this->message['from']}'");
				 			        $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
				 
				 
				 					if($cfg['lbratetype']==3){//全都用代理积分
				 						$flyj=$this->ptyjjl($itemendprice,$commissionRate,$cfg);
				 			        	if($cfg['fxtype']==1){//积分           
				 			           		 $lx=$cfg["hztype"];	
				 			           		  $flyj=intval($flyj);		           		 
				 				        }else{//余额
				 				            $lx=$cfg["yetype"];
				 				            if($cfg['txtype']==3){
				 				                $lx='集分宝';            
				 				            }
				 				            $zyh=$conmany+$flyj;//优惠金额
				 			          	    $zyhhprice=$itemprice-$zyh;//优惠后价格
				 				        }
				 					}else{
				 		                   if($cfg['fxtype']==1){//积分
				 					            $flyj=$this->sharejl($itemendprice,$commissionRate,$bl,$share,$cfg);
				 					        }else{//余额            
				 					            $flyj=$this->sharejl($itemendprice,$commissionRate,$bl,$share,$cfg);
				 					            $zyh=$conmany+$flyj;//优惠金额
				 					            $zyhhprice=$itemprice-$zyh;//优惠后价格
				 					        }	
				 					}
				 			        	 
				 			        
				 			        //return $this->respText($yongjin);
				 			       $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('lm'=>1,'pid'=>$cfg['ptpid'],'key'=>$goods['title'],'pic_url'=>$goods['pict_url'],'lx'=>2)));
				                    $ddwz=$this->dwzw($tturl);
				                      
				 			       $tcn=$this->dwz($erylj);//短网址
				                    $msg=str_replace('#昵称#',$fans['nickname'], $cfg['jqrflmsg']);
				 	               $msg=str_replace('#名称#',$goods['title'], $msg);
				 	               $msg=str_replace('#原价#',$itemprice, $msg);
				 	               $msg=str_replace('#惠后价#',$zyhhprice, $msg);
				 	               $msg=str_replace('#券后价#',$itemendprice, $msg);
				 	               $msg=str_replace('#总优惠#',$zyh, $msg);
				 	               $msg=str_replace('#短网址#',$tcn, $msg);
				 	               $msg=str_replace('#同类产品#',$ddwz, $msg);
				 	               if(empty($conmany)){
				 	                 $conmany='0';
				 	               }
				 	               $msg=str_replace('#优惠券#',$conmany, $msg);
				 //	               if($cfg['fxtype']==1){
				 //	                 $flyj=intval($flyj);
				 //	               }
				 	               $msg=str_replace('#返现金额#',$flyj.$lx, $msg);
				 	               $msg=str_replace('#淘口令#',$res['taokouling'], $msg);
				 	               if($cfg['gzhtp']==1){                             
				                      $this->posttaobao($goods['pict_url']."_250x250.jpg");
				                      usleep(500000);
				                   }	               
				 	               //return $this->respText($msg);
												 exit($msg);
				              	
				              }
				 //淘宝结束

         
?>