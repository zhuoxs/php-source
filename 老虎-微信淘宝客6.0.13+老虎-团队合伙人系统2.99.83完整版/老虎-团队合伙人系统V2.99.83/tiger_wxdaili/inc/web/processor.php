<?php
/**
 * 微信淘宝客模块处理程序
 *
 * @author 老虎
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
require_once IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/TopSdk.php";

class tiger_newhuModuleProcessor extends WeModuleProcessor {
	public function respond() {
         global $_W;
         load()->model('mc');
         $poster = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_poster')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));        
         $fans = mc_fetch($this->message['from']);
         //return $this->respText('2222');
				 //return $this->respText($this->message['content']);
         file_put_contents(IA_ROOT."/addons/tiger_newhu/log--2.txt","\n".json_encode($this->message),FILE_APPEND);
         if (empty($fans['nickname']) || empty($fans['avatar'])){
                    $openid = $this->message['from'];
					$ACCESS_TOKEN = $this->getAccessToken();
					$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$ACCESS_TOKEN}&openid={$openid}&lang=zh_CN";
					load()->func('communication');
					$json = ihttp_get($url);
					$userInfo = @json_decode($json['content'], true);
					$fans['nickname'] = $userInfo['nickname'];
					$fans['avatar'] = $userInfo['headimgurl'];
					$fans['province'] = $userInfo['province'];
					$fans['city'] = $userInfo['city'];
					//mc_update($this->message['from'],array('nickname'=>$fans['nickname'],'avatar'=>$fans['avatar']));
				}
				
				
				
				// file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".json_encode($userInfo),FILE_APPEND);

         $cfg = $this->module['config']; 
         include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
         include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
         include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/notb.php"; 
         include IA_ROOT . "/addons/tiger_newhu/inc/sdk/taoapi.php"; 
         include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/pdd.php"; 
         include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/jd.php"; 
         
         $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
         $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$this->message['from']}'");
         if(!empty($cfg['tknewurl'])){
         	$_W['siteroot']=$cfg['tknewurl'];
         }
         if(!empty($share['dlptpid'])){
              $cfg['ptpid']=$share['dlptpid'];
              $cfg['pddpid']=$share['dlqqpid'];
         }else{
           if(!empty($share['helpid'])){//查询有没有上级
                 $sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and id='{$share['helpid']}'");
                 if(!empty($sjshare['dlptpid'])){
                   $cfg['ptpid']=$sjshare['dlptpid'];
                   $cfg['qqpid']=$sjshare['dlqqpid'];
                 }
            }
         }
         //京东开始
         $arr=strstr($this->message['content'],"jd.com");
         if($arr!==false){
         	//获取京东推广位
         	$jdset=pdo_fetch("select * from ".tablename('tuike_jd_jdset')." where weid='{$_W['uniacid']}' order by id desc");
        	if($share['dltype']==1){//是代理
				if(empty($share['jdpid'])){//如果是代理，PID没填写就默认公众号PID					
					$share['jdpid']=$jdset['jdpid'];
				}
			}else{//不是代理
				if(!empty($share['helpid'])){//查看有没有上级
					$shshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");
					//file_put_contents(IA_ROOT."/addons/tiger_tkxcx/v_log.txt","\n helpid1:".$share['helpid']."--------".json_encode($shshare),FILE_APPEND);	
					if(empty($shshare['id'])){//没有上级代理，就用默认的公众号PID
					    $share['jdpid']=$jdset['jdpid'];
					}else{//有上级代理
						if($shshare['dltype']==1){//如果上级是代理，就用代理的PID
							$share['jdpid']=$shshare['jdpid'];
						}else{//上级不是代理就用默认的PID
					   		$share['jdpid']=$jdset['jdpid'];
						}
					}
				}else{//没有上级就用默认公众号PID
					$share['jdpid']=$jdset['jdpid'];
				}			
			}
			$p_id=$share['jdpid'];
			
			
         	$geturl=$this->geturl($this->message['content']);
         	$goodsid=$this->jdgoodsID($geturl);
  //       	return $this->respText($goodsid);
         	if(empty($goodsid)){
         		return $this->respText($cfg['ermsg']);
         	}
         	
         	$jdview=getcqview($goodsid,$jdset['jduid']);
         	if(empty($jdview['goodsName'])){
         		return $this->respText($cfg['ermsg']);
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
		         	$hjkurl="http://haojingke.com/index.php/api/index/myapi?type=goodsdetail&apikey=5e16dd968daf20de&skuid=25791192770";
		         	$hjkview=$this->curl_request($hjkurl);
		         	$hjkarr=@json_decode($hjkview, true);
		         	//return $this->respText($hjkarr['data']['skuName']);
		         	if(!empty($hjkarr['data']['couponList'])){         		
		         		if(!empty($hjkarr['datda']['couponList'])){//有优惠券就用二合一的接口
			         		$couponmoney=$hjkarr['data']['discount'];//优惠券面额
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
			return $this->respText($msg);	
         }
         
         //京东结束
         
         
         
         
         //拼多多
         $arr=strstr($this->message['content'],"yangkeduo.com");
        if($arr!==false){
        	
        	//获取拼多多PID
        	if($share['dltype']==1){//是代理
				if(empty($share['pddpid'])){//如果是代理，PID没填写就默认公众号PID
					$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$_W['uniacid']}'");
					$share['pddpid']=$pddset['pddpid'];
				}
			}else{//不是代理
				if(!empty($share['helpid'])){//查看有没有上级
					$shshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$share['helpid']}'");
					//file_put_contents(IA_ROOT."/addons/tiger_tkxcx/v_log.txt","\n helpid1:".$share['helpid']."--------".json_encode($shshare),FILE_APPEND);	
					if(empty($shshare['id'])){//没有上级代理，就用默认的公众号PID
						$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$_W['uniacid']}'");
					    $share['pddpid']=$pddset['pddpid'];
					}else{//有上级代理
						if($shshare['dltype']==1){//如果上级是代理，就用代理的PID
							$share['pddpid']=$shshare['pddpid'];
						}else{//上级不是代理就用默认的PID
							$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$_W['uniacid']}'");
					   		$share['pddpid']=$pddset['pddpid'];
						}
					}
				}else{//没有上级就用默认公众号PID
					$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$_W['uniacid']}'");
					$share['pddpid']=$pddset['pddpid'];
				}			
			}
			$p_id=$share['pddpid'];
			//PID结束
        	$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$_W['uniacid']}'");
			$owner_name=$pddset['ddjbbuid'];
			//获取链接
			$geturl=$this->geturl($this->message['content']);
			$itemid=$this->pddgoodsID($geturl);
			//return $this->respText($itemid);
			if(empty($itemid)){
				return $this->respText($cfg['ermsg']);
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
				return $this->respText($itemtitle);
			}
			if(empty($rate)){
				$itemtitle=$cfg['error2'];
				return $this->respText($itemtitle);
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
			return $this->respText($msg);			
         	return $this->respText("");
         	return '';
        }
         //拼多多结束
         
        
                  
         $pidSplit=explode('_',$cfg['ptpid']);
         $cfg['siteid']=$pidSplit[2];
         $cfg['adzoneid']=$pidSplit[3];
        // return $this->postText($this->message['from'],$cfg['ptpid']);
        //$cxtkl=$this->getyouhui2($this->message['content']);
        $arr=strstr($this->message['content'],"￥");
        $arr2=strstr($this->message['content'],"《");
//      if($arr!==false || $arr2!==false){
//       	$cxtkl=$this->message['content'];
//      }
        $cxtkl=$this->message['content'];
        
        
        if(!empty($cxtkl)){
        	$klurl=$this->tkljx($this->message['content']);
	        if(!empty($klurl['url'])){
	        	$geturl=$klurl['url'];
	        }else{
	        	$geturl=$this->geturl($this->message['content']);
	        }
        }else{
        	$geturl=$this->geturl($this->message['content']);
        }
				
				$arr=strstr($geturl,"http://m.tb.cn");
				if($arr!==false){
					$geturl=str_replace("http:","https:",$geturl)."";
				}
				//return $this->respText($geturl);
        
       
        
        
        if(!empty($geturl) and $this->message['msgtype'] == 'text'){        	
        	 $ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
             $myck=$ck['data'];
             $istao=$this->myisexists($geturl);            
             if(!empty($istao)){
             	if($istao==1){//e22a地址
             		
             		 $goodsid=$this->getgoodsid($geturl);
                 	 if(empty($goodsid)){
                 	 	$goodsid=$this->hqgoodsid($geturl); 
                 	 }
                     if(empty($goodsid)){
                        return $this->respText($cfg['ermsg']);
                     }  
                                    
             	}elseif($istao==2){//淘宝天猫地址
             		$goodsid=$this->mygetID($geturl); 
                 	 if(empty($goodsid)){
                 	 	$goodsid=$this->getgoodsid($geturl);
                 	 }
//                   $url="https://item.taobao.com/item.htm?id=".$goodsid;
                     if(empty($goodsid)){
                        return $this->respText($cfg['ermsg']);
                     }                     
             	}elseif($istao==3){
             		 $goodsid=$this->getrhy($geturl);
             		 //return $this->respText(2222);
             	}
             
             	 
             	
             	 $url="https://item.taobao.com/item.htm?id=".$goodsid;
                 $key=urlencode($url);                     
                 $goods=cjsearch(1,$cfg['ptpid'],$tksign['sign'],$tksign['tbuid'],$_W,$cfg,$key,2,'','','','',0,0,0);    
                 //file_put_contents(IA_ROOT."/addons/tiger_newhu/yjlog.txt","\n".json_encode($goods),FILE_APPEND);             
                 $goods=$goods['result_list']['map_data'];//超级搜索结果   
                 
                 //return $this->respText($url); 
                              
                 if(empty($goods)){
                 	if($cfg['gzhcjtype']==1){
                 		$cenkl=$this->tklresp($this->message['content'],$cfg);
                 		return $this->respText($cenkl);
                 	}else{
                 		return $this->respText($cfg['error2']);
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
                 		return $this->respText($cenkl);
                 	}else{
                 		return $this->respText($cfg['error2']);
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
                     	return $this->respText($cfg['ermsg2']);
                     }                
                     return $this->respText($newmsg);
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
                   $msg=str_replace('#昵称#',$fans['nickname'], $cfg['flmsg']);
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
	               return $this->respText($msg);
             	
             }
        	return $this->respText("111".$klurl['content'].$klurl['url'].$goodsid.$goods['title']);
        }


         if ($this->message['msgtype'] == 'event' || $this->message['event'] == 'subscribe' || $this->message['event'] =='SCAN') {
             //$scene_id=str_replace('qrscene_','',$this->message['eventkey']);//扫码关注场景ID
             $ticket=$this->message['ticket'];
             //$fans = mc_fetch($this->message['from']);
             if ($cfg['unionidtype']==1){
                        $openid = $this->message['from'];
                        $ACCESS_TOKEN = $this->getAccessToken();
                        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$ACCESS_TOKEN}&openid={$openid}&lang=zh_CN";
                        load()->func('communication');
                        $json = ihttp_get($url);
                        $userInfo = @json_decode($json['content'], true);
                        $fans['nickname'] = $userInfo['nickname'];
                        $fans['avatar'] = $userInfo['headimgurl'];
                        $fans['province'] = $userInfo['province'];
                        $fans['city'] = $userInfo['city'];
                        $fans['unionid'] = $userInfo['unionid'];
                        $fans['from_user'] = $openid;
                        //mc_update($this->message['from'],array('nickname'=>$mc['nickname'],'avatar'=>$mc['avatar']));
             }
            if ($this->message['event'] == 'subscribe') {  
              $hmember=pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_share')." WHERE weid = :weid and ticketid=:ticketid", array(':weid' => $_W['uniacid'],':ticketid'=>$ticket));//事件所有者
              if(!empty($fans['unionid'])){
              	$member=pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_share')." WHERE weid = :weid and unionid=:unionid", array(':weid' => $_W['uniacid'],':unionid'=>$fans['unionid']));//当前用户信息
              }else{
              	$member=pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_share')." WHERE weid = :weid and from_user=:from_user", array(':weid' => $_W['uniacid'],':from_user'=>$this->message['from']));//当前用户信息
              }
              

              if (empty($member['id'])){
              	   if($cfg['gzljcj']==1){
              	   	  $cqtype=1;
              	   }else{
              	   	  $cqtype=0;
              	   }
              	    $indata=array(
                            'openid'=>$fans['uid'],
                            'nickname'=>$fans['nickname'],
                            'avatar'=>$fans['avatar'],
                            'pid'=>$poster['id'],
                            'createtime'=>time(),
                            'helpid'=>$hmember['id'],
                            'weid'=>$_W['uniacid'],
                            'cqtype'=>$cqtype,
                            'from_user'=>$this->message['from'],
                            'unionid'=>$fans['unionid'],
                            'follow'=>1
                    );
                    $inshare=pdo_insert($this->modulename."_share",$indata);
                    $share['id'] = pdo_insertid();
                    $share = pdo_fetch('select * from '.tablename($this->modulename."_share")." where from_user='{$this->message['from']}'");
                    //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\nclnr:".json_encode($inshare),FILE_APPEND);
                    //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".json_encode($indata),FILE_APPEND);
                    //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\ncalu:".json_encode($share),FILE_APPEND);
                    


                    //得积分开始
                    if($poster['score']>0 || $poster['scorehb']>0){
                      $info1=str_replace('#昵称#',$fans['nickname'], $poster['ftips']);
                      $info1=str_replace('#积分#',$poster['score'], $info1);
                      $info1=str_replace('#元#',$poster['scorehb'], $info1);
                      if($poster['score']){
                      	//$this->postText($this->message['from'],'ID:'.$share['id'].'--'.$poster['score']);
                      	 $this->mc_jl($share['id'],0,5,$poster['score'],'关注送积分','');
                      }
                      if($poster['scorehb']){
                      	$this->postText($this->message['from'],'ID:'.$share['id']);
                          $this->mc_jl($share['id'],1,5,$poster['scorehb'],'关注送余额','');
                      }
                      $this->postText($this->message['from'],$info1);
                    }
                    
                    if($poster['cscore']>0 || $poster['cscorehb']>0){
                      if($hmember['status']==1){
                        exit;
                      }
                      $info2=str_replace('#昵称#',$fans['nickname'], $poster['utips']);
                      $info2=str_replace('#积分#',$poster['cscore'], $info2);
                      $info2=str_replace('#元#',$poster['cscorehb'], $info2);
                      if($poster['cscore']){
                      	$this->mc_jl($hmember['id'],0,2,$poster['cscore'],'2级推广奖励','');
                      }
                      if($poster['cscorehb']){
                      	$this->mc_jl($hmember['id'],1,2,$poster['cscorehb'],'2级推广奖励','');
                      	}                      
                      $this->postText($hmember['from_user'],$info2);
                    }
                    if($poster['pscore']>0 || $poster['pscorehb']>0){
                      $fmember=pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_share')." WHERE weid = :weid and id=:id", array(':weid' => $_W['uniacid'],':id'=>$hmember['helpid']));
                      if($fmember['status']==1){
                        exit;
                      }
                        if($fmember){
                            $info3=str_replace('#昵称#',$fans['nickname'], $poster['utips2']);
                            $info3=str_replace('#积分#',$poster['pscore'], $info3);
                            $info3=str_replace('#元#',$poster['pscorehb'], $info3);
                            if($poster['pscore']){
                            	$this->mc_jl($fmember['id'],0,2,$poster['pscore'],'3级推广奖励','');
                            }
                            if($poster['pscorehb']){
                            	$this->mc_jl($fmember['id'],1,2,$poster['pscorehb'],'3级推广奖励','');
                            }        
                            $this->postText($fmember['from_user'],$info3);   
                        }
                    }
                   
                }else{
                  $this->postText($this->message['from'],'亲，您已经是粉丝了，快去生成海报赚取奖励吧');  
                }
               
              return $this->PostNews($poster,$fans['nickname']);//关注推送图文
            }
            if ($this->message['event'] == 'SCAN' and $this->message['event'] <> 'subscribe') {
                //$cfg=$this->module['config'];
                if($cfg['hztype']<>''){
                  $jflx=$cfg['hztype'];
                }else{
                  $jflx="积分";
                }
               $share= pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_share')." WHERE weid='{$_W['uniacid']}' and from_user='{$this->message['from']}'");
              
							$info5=str_replace('#昵称#',$fans['nickname'], $cfg['ygzhf']);
							$info5=str_replace('#积分#',intval($share['credit1']), $info5);
							$info5=str_replace('#公众号名称#',$_W['account']['name'], $info5);
							//$msg1=$fans['nickname']."你已经是【".$_W['account']['name']."】的粉丝了，不用再扫了哦。\n\n你当前有".$share['credit1']."".$jflx."";							
               $this->postText($this->message['from'],$info5);
               return $this->PostNews($poster,$fans['nickname']);//推送图文
            }
         
         }
         

         //输入关键词查询
         if($this->message['msgtype'] == 'text' and $this->message['event'] <> 'CLICK' and $this->message['event'] <> 'subscribe' and $this->message['event'] <> 'SCAN' and $this->message['content']<>$poster['kword']){
						 
						 
						
						
						 
						 
						 
             $arr=strstr($this->message['content'],"找");
             
             if($arr!==false){
                 //$cfg = $this->module['config']; 
                 $str=str_replace("找","",$this->message['content']);             
                 //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".json_encode($arr),FILE_APPEND);
									
                   if(!empty($str)){
                   	
                        //include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
                        $arr=getfc($str,$_W);
                        
                         foreach($arr as $v){
                             if (empty($v)) continue;
                            $where.=" and itemtitle like '%{$v}%'";
                         }
                    }
                    
                 if(empty($cfg['ttsum'])){
                    $sum=5;
                 }else{
                    $sum=$cfg['ttsum'];
                 }
                    $weid=$_W['uniacid'];
//                  if(!empty($cfg['gyspsj'])){
//                    $weid=$cfg['gyspsj'];
//                  }

                // return $this->postText($this->message['from'],"cs111:".$cfg['ptpid']);

                if($cfg['zhaotype']==1){//只显示超级搜索
                    //关键词查询
                     $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('key'=>$str,'lm'=>4,'pid'=>$cfg['ptpid'],'pic_url'=>'')));
                     $ddwz=$this->dwzw($tturl);
                     $newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsg']);
                     $newmsg=str_replace('#名称#',$str, $newmsg);
                     $newmsg=str_replace('#短网址#',$ddwz, $newmsg);
                     return $this->respText($newmsg);
                     //关键词查询结束
                }
                

                 if($cfg['mmtype']==2){//云商品库
                   if(!empty($str)){
                      
		           	   $list=getcatlist($type,$px,$tm,$price1,$price2,$hd,1,$str,$dlyj,$pid,$cfg);
		           	   
		           	   foreach($list['data'] as $k=>$v){
		           	   	    if($k>$sum){
		           	   	    	continue;
		           	   	    }
		                    $zdgoods[$k]['itemid']=$v['itemid'];
			                $zdgoods[$k]['itemtitle']=$v['itemtitle'];
			                $zdgoods[$k]['itempic']=$v['itempic'];
			                $zdgoods[$k]['itemendprice']=$v['itemendprice'];
			                $zdgoods[$k]['couponmoney']=$v['couponmoney'];
			                $zdgoods[$k]['itemsale']=$v['itemsale'];
			                $zdgoods[$k]['tkrates']=$v['tkrates'];	
			                $zdgoods[$k]['id']=$v['id'];	                          
			            }
                   }
                 }else{
                 	$zdgoods = pdo_fetchall("SELECT id,itemid,itemtitle,itempic,itemendprice FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$weid}' {$where}  order by id desc limit {$sum}");
                 }
                  
                 if(empty($zdgoods)){//联盟库
                   $str=trim($str);
                    //关键词查询
                     $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('key'=>$str,'lm'=>4,'pid'=>$cfg['ptpid'],'pic_url'=>'')));
                     $ddwz=$this->dwzw($tturl);
                     $newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsg']);
                     $newmsg=str_replace('#名称#',$str, $newmsg);
                     $newmsg=str_replace('#短网址#',$ddwz, $newmsg);
                     return $this->respText($newmsg);
                     //关键词查询结束
                 }else{
                 	return $this->postgoods($zdgoods,$this->message['content'],$cfg['ptpid'],$cfg);
                 }
                     
             
               
             }
						 
						 if($this->message['msgtype'] == 'text'){
							
						 	$strcount=strlen($this->message['content']);
							//return $this->respText($strcount."sdfsdfsdf");

						 	if($strcount>54 and $strcount<300){
						 		//关键词查询
						 		$tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('key'=>$this->message['content'],'lm'=>4,'pid'=>$cfg['ptpid'],'pic_url'=>'')));
						 		$ddwz=$this->dwzw($tturl);
						 		$newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsg']);
						 		$newmsg=str_replace('#名称#',$this->message['content'], $newmsg);
						 		$newmsg=str_replace('#短网址#',$ddwz, $newmsg);
						 		return $this->respText($newmsg);
						 		//关键词查询结束
						 		//return $this->respText($this->message['content']);
						 	}
						 	//return $this->respText($this->message['content']);
						 	//return $this->respText($strcount);
						 	
						 }

             
         
         }
         //关注键结束
         
         
         
         if($this->message['msgtype'] == 'text' || $this->message['event'] == 'CLICK' and $this->message['event'] <> 'subscribe' and $this->message['event'] <> 'SCAN' and $this->message['content']==$poster['kword']){
           //地区限制
           //$cfg=$this->module['config'];
           
           if($cfg['locationtype']==1 || $cfg['locationtype']==2 || $cfg['locationtype']==0){
                 $user = mc_fetch($this->message['from']);
                 $city=$user['residecity'];
                 $pos = stripos($cfg['city'],$city);
                 if ($pos === false) {
                 $dqurl="<a href='".$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('diqu',array('uid'=>$fans['uid'])))."'>点击这里</a>";
                 $dqmsg="本次活动只针对【".$cfg['city']."】微信用户开放\n\n当前地区为【".$city."】\n\n如果你是该地区的用户，".$dqurl."验证\n\n如果不处于此地区，暂时不能参与活动，感谢您的支持！";
                 $this->postText($this->message['from'],$dqmsg);
                 exit;                   
                 }                 
            }
            $rid = $this->rule;

            $poster = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_poster')." WHERE weid = :weid and rid=:rid", array(':weid' => $_W['uniacid'],':rid'=>$rid)); 
            
            if(!empty($cfg['hbsctime'])){
                $share = pdo_fetch('select * from '.tablename($this->modulename."_share")." where from_user='{$this->message['from']}' and pid='{$poster['id']}' ");
                if ($share['updatetime'] > 0 && (time() - $share['updatetime']) < $cfg['hbsctime']){//一分钟内
                    if(!empty($cfg['hbcsmsg'])){
                       $this->postText($this->message['from'],$cfg['hbcsmsg']);
                    }                       
                        return '';
                        exit();
                } 
            }
            

            $img = $this->createPoster($fans,$poster);
            
            $media_id = $this->uploadImage($img);   
            
            
            
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($img),FILE_APPEND);
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($this->message['time']),FILE_APPEND);
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($this->message['type']),FILE_APPEND);
                      

           if($poster['winfo1']){
            $info=str_replace('#时间#',date('Y-m-d H:i',time()+30*24*3600),$poster['winfo1']);
            //$this->respText($info);
            $this->postText($this->message['from'],$info);
             }
           if ($poster['winfo2']){
                $hbshare = pdo_fetch('select * from '.tablename($this->modulename."_share")." where openid='{$fans['uid']}' "); 
                $url="<a href='".$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('hbshare',array('type' => $poster['type'],'id'=>$hbshare['id'])))."'>查看你的专属二维码</a>";
                $msg2 = $poster['winfo2'];
                $msg2=str_replace('#二维码链接#',$url, $msg2);
                if ($poster['rtype'] && $poster['type'] == 2);
                $this->postText($this->message['from'],$msg2);
            }

            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n old:".json_encode($this->message),FILE_APPEND);          
            //$this->sendImage($this->message['from'],$media_id);
            if ($this->message['checked'] == 'checked'){
					$this->sendImage($this->message['from'],$media_id);
					return '';
				}else return $this->respImage($media_id);
				exit;  
         }
         
	}

    public function addtbgoods($data) {
         $cfg = $this->module['config']; 
        if($cfg['cxrk']==1){//选择入库才会入数据库
            if(empty($data['itemid'])){
              Return '';
            }
            $go = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$data['weid']}' and  itemid='{$data['itemid']}'");
            if(empty($go)){
                 //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--res.txt","\n old:".json_encode("aaa"),FILE_APPEND);   
              $bb=pdo_insert($this->modulename."_newtbgoods",$data);
              //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--res.txt","\n old:".json_encode($bb),FILE_APPEND);  
            }else{
                //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--res.txt","\n old:".json_encode("bbb"),FILE_APPEND);        
              pdo_update($this->modulename."_newtbgoods", $data, array('weid'=>$data['weid'],'itemid' => $data['itemid']));
            }            
        }
              
    }
    
     //代理计算单个商品的代理佣金
    public function dljiangli($endprice,$tkrate,$bl,$share){
    	global $_W;
    	//产品佣金
    	$dlyj=$endprice*$tkrate/100;//商品佣金
    	if(!empty($bl['dlkcbl'])){//代理扣除比例
          $dlyj=$dlyj*(100-$bl['dlkcbl'])/100;//代理扣除后的佣金
        }
        $fs=$this->jcbl($share,$bl);
        if(empty($share['dlbl'])){
          $dlbl=$bl['dlbl1'];//没有开代理独立比例
        }else{
          $dlbl=$fs['bl'];//开了代理独立比例，要看一下开了几级代理
        }
        if($bl['fxtype']==1){//大众模式
        	$dlrate=number_format($dlyj*$dlbl/100,2);//普通大众模式 代理佣金
        }else{//==0 抽成模式
        	$yj=number_format($dlyj*$dlbl/100,2);//不抽成所得佣金
        	if($bl['dltype']==2){//二级模式抽成
        		if(empty($share['helpid'])){
        			$jryj=0;
        		}else{        			
         			$jryj=$yj*$bl['dlbl1t2']/100;//二级代理提取佣金
        		}        		
         	}elseif($bl['dltype']==3){//三级抽成模式
         		if(empty($share['helpid'])){//如果没有二级，二级不抽成
         			$jryj=0;
         		}else{
         			$sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$share['weid']}'and dltype=1 and id='{$share['helpid']}'");
         			$jryj=$yj*$bl['dlbl2t3']/100;//二级代理提取佣金
         			if(empty($sjshare['helpid'])){//如果没有三级，三级不抽成
         				$jrsjyj=0;
         			}else{
         				$jrsjyj=$yj*$bl['dlbl1t3']/100;//三级代理提取佣金
         			}
         		}
         		
         	}
         	
           $jrzyj=$yj-$jryj-$jrsjyj;//所得佣金-二级提取-三级提取
           file_put_contents(IA_ROOT."/addons/tiger_tkxcx/yj_log.txt","\n"."uid:".$share['id']."------".$yj."-".$jryj."-".$jrsjyj."=".$jrzyj,FILE_APPEND);
           $dlrate=number_format($jrzyj,2);
        }
        return $dlrate;
        
    }
    
    
    //普通会员单个商品奖励
    public function ptyjjl($endprice,$tkrate,$cfg){
    	global $_W;
    	//产品佣金
    	$yj=$endprice*$tkrate/100;//商品佣金    	
    	$yongj=$yj*$cfg['zgf']/100;    	
    	if(empty($yongj)){
    		$yongj='0.00';
    	}    	
    	if($cfg['fxtype']==1){//积分
    		$yj1=$yongj*$cfg['jfbl'];//佣金乘以积分兑换比例
    		$yj1=intval($yj1);
    	}elseif($cfg['fxtype']==2){//余额
    		//$yj1=$yongj;
    		$yj1=number_format($yongj,2);
    	}    	
    	return $yj1;
    }
    
    //实际到用的
    public function sharejl($endprice,$tkrate,$bl,$share,$cfg){
    	if($share['dltype']==1){
    		$yj=$this->dljiangli($endprice,$tkrate,$bl,$share);
    	}else{
    		$yj=$this->ptyjjl($endprice,$tkrate,$cfg);
    	}
    	return $yj;
    }
    
    public function jcbl($share,$bl,$weid){//单个会员佣金比例 
         global $_W;
         $sj=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and id='{$share['helpid']}'");//上级
         if($bl['dltype']==3){//开三级   
             if(!empty($sj)){
               $sj2=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and id='{$sj['helpid']}'");//上上级
               if(!empty($sj2)){
                 $djbl=$bl['dlbl3'];
                 $tname=$bl['dlname3'];
                 $cj=3;
               }else{
                 $djbl=$bl['dlbl2'];
                 $tname=$bl['dlname2'];
                 $cj=2;
               }           
             }else{
               $djbl=$bl['dlbl1'];
               $tname=$bl['dlname1'];
               $cj=1;
             }
         }elseif($bl['dltype']==2){//开二级
             if(!empty($sj)){
                $djbl=$bl['dlbl2'];
                $tname=$bl['dlname2'];
                $cj=2;
             }else{
                $djbl=$bl['dlbl1'];
                $tname=$bl['dlname1'];
                $cj=1;
             }           
         }else{
            $djbl=$bl['dlbl1'];
            $tname=$bl['dlname1'];
            $cj=1;
         }
         if(!empty($share['dlbl'])){//如果开了代理独立的，就用独立的
            $djbl=$share['dlbl'];
            $tname=$bl['dlname1'];
         }
         $arr=array(
             'bl'=>$djbl,
             'tname'=>$tname,
             'cj'=>$cj,
         );

         return $arr;         
     }
    //代理计算佣金规则结束
	
    
    public function getrhy($url){    	    
			$appkey	= '12574478';
			$activityId=$_GET['activityId'];
			file_put_contents(IA_ROOT."/addons/tiger_newhu/rhylog.txt","\n".$url."-------",FILE_APPEND);
			//echo $url;
			$e=$this->Text_qzj($url,'edetail?e=','&');
			$pid=$this->Text_qzj($url,'&pid=','&');	
			$src	= '';
			//$t		= '0';
			$t=$this->getMillisecond();
			$data	= array(
						"e"		=> $e,
						"activityId"=>$activityId
					 );
		    $jsondata=json_encode($data);
		    $jsondata=str_replace("\/","/",$jsondata);
		
			$url	= 'https://acs.m.taobao.com/h5/mtop.alimama.union.hsf.coupon.get/1.0/?jsv=2.4.0&appKey='.$appkey;
			$json	= $this->curl_request1($url,'',$cookies,1);
			$_m_h5_tk	= $this->qudaimapianduan($json['cookie'],"_m_h5_tk=","_");
		
			$singjson	= $_m_h5_tk.'&'.$t.'&'.$appkey.'&'.$jsondata;
			$sign	= md5($singjson);
			$url="https://acs.m.taobao.com/h5/mtop.alimama.union.hsf.coupon.get/1.0/?jsv=2.4.0&appKey=".$appkey."&t=".$t."&sign=".$sign."&api=mtop.alimama.union.hsf.coupon.get&v=1.0&AntiCreep=true&AntiFlood=true&type=jsonp&dataType=jsonp&callback=mtopjsonp1&data=".urlencode($jsondata);
			$json	= $this->curl_request1($url,'',$json['cookie'],0);
			
			$jsondata=str_replace("mtopjsonp1(","",$json);			
			$jsondata=str_replace(")","",$jsondata);
			$dataarr=@json_decode($jsondata,true);
			//echo "<pre>";
			//print_r($dataarr);
			//return $dataarr;
			return $dataarr['data']['result']['item']['itemId'];
	}
	
	public function getMillisecond() {
        //list($t1, $t2) = explode(' ', microtime());
        $time=time();
        $ran=rand(100,300);
        $t=$time.$ran;
        return $t;
    }
       
	
	public function qudaimapianduan ($ss,$qian,$hou){
		$i = strpos($ss,$qian);
		$output = substr($ss,$i+strlen($qian),strlen($ss));
		$i = strpos($output,$hou);
		$output = substr($output,0,$i);
		return $output;
	}
	
	public function curl_request1($url,$post='',$cookie='', $returnCookie=0){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; 	Trident/6.0)');
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		preg_match('/(https?:\/\/.*?)\//',$url,$arry);
		curl_setopt($curl, CURLOPT_REFERER, $arry[1]);
		if($post) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
		}
		if($cookie) {
			curl_setopt($curl, CURLOPT_COOKIE, $cookie);
		}
		curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		if (curl_errno($curl)) {
			return curl_error($curl);
		}
		curl_close($curl);
		if($returnCookie){
			list($header, $body) = explode("\r\n\r\n", $data, 2);
			preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
				while(list($key,$val)= each($matches[1])){
					if($cookies == ''){
						$cookies = $val; 
					}else{
						$cookies = $cookies.'; '.$val; 
					}
				} 
			$info['cookie']  = substr($cookies, 1);
			$info['content'] = $body;
			return $info;
		}else{
			return $data;
		}
	}




    public function sendImage($openid, $media_id) {
	    $data = array(
	      "touser"=>$openid,
	      "msgtype"=>"image",
	      "image"=>array("media_id"=>$media_id));
	    $ret = $this->postRes($this->getAccessToken(), json_encode($data));
	    return $ret;
	  }


    private function uploadImage($img) {
        $this->postText($this->message['from'], '');
        $url  = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $this->getAccessToken() . "&type=image";
        $post = array('media' => '@' . $img);
        load()->func('communication');
        $ret = ihttp_request($url, $post);
        $this->postText($this->message['from'], '');
        $content = @json_decode($ret['content'], true);
        if ($ret['errno'] != 1) {
            return $content['media_id'];
        }
        else {
            $this->postText($this->message['from'], '获取海报失败，请重试！');
            exit;
        }
    }

    private $sceneid = 0;
	private $Qrcode = "/addons/tiger_newhu/qrcode/mposter#sid#.jpg";
	private function createPoster($fans,$poster){
		global $_W;
		$bg = $poster['bg'];
		$pid = $poster['id'];
		$share = pdo_fetch('select * from '.tablename($this->modulename."_share")." where from_user='{$this->message['from']}' and  weid='{$_W['uniacid']}'");

		if (empty($share)){
			pdo_insert($this->modulename."_share",
					array(
							'openid'=>$fans['uid'],
							'nickname'=>$fans['nickname'],
							'avatar'=>$fans['avatar'],
							'pid'=>$poster['id'],
                            'updatetime'=>time(),
							'createtime'=>time(),
							'parentid'=>0,
							'weid'=>$_W['uniacid'],
							'score'=>$poster['score'],
							'cscore'=>$poster['cscore'],
							'pscore'=>$poster['pscore'],
                            'from_user'=>$this->message['from'],
                            'follow'=>1
					));
			$share['id'] = pdo_insertid();
			$share = pdo_fetch('select * from '.tablename($this->modulename."_share")." where id='{$share['id']}' and  weid='{$_W['uniacid']}'");
		}else pdo_update($this->modulename."_share",array('updatetime'=>time()),array('id'=>$share['id']));

		$qrcode = str_replace('#sid#',$share['id'],IA_ROOT .$this->Qrcode);
		$data = json_decode(str_replace('&quot;', "'", $poster['data']), true);
		
		include IA_ROOT . '/addons/tiger_newhu/func.php';
		
		
		set_time_limit(0);
		@ini_set('memory_limit', '256M');
		$size = getimagesize(tomedia($bg));
		$target = imagecreatetruecolor($size[0], $size[1]);
		$bg = imagecreates(tomedia($bg));
		imagecopy($target, $bg, 0, 0, 0, 0,$size[0], $size[1]);
		imagedestroy($bg);
		
		foreach ($data as $value) {
			$value = trimPx($value);
            if ($value['type'] == 'img') {
            	
                $img = saveImagehb($fans['avatar']);
                mergeImage($target, $img, array('left' => $value['left'], 'top' => $value['top'], 'width' => $value['width'], 'height' => $value['height']));
                
                @unlink($img);
            }elseif ($value['type'] == 'name') {
                if (empty($value['size'])) {
                    $value['size'] = '16px';
                }
                if (empty($value['color'])) {
                    $value['color'] = '#000000';
                }
                mergeText($this->modulename, $target, $fans['nickname'], array('size' => $value['size'], 'color' => $value['color'], 'left' => $value['left'], 'top' => $value['top']), $poster);
            }elseif ($value['type'] == 'qr') {                
                if($poster['type']==2){
                  $url = $this->getQR($fans, $poster, $share['id']);
                }elseif($poster['type']==3){
                  $url=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('sharetz',array('weid' =>$_W['uniacid'],'uid'=>$fans['uid'])));
                }
                if (!empty($url)) {
                    $img = IA_ROOT . "/addons/tiger_newhu/temp_qrcode.png";
                    include IA_ROOT . "/addons/tiger_newhu/phpqrcode.php";
                    $errorCorrectionLevel = "L";
                    $matrixPointSize      = "4";
                    QRcode::png($url, $img, $errorCorrectionLevel, $matrixPointSize, 2);
                    $qrcode_png = imagecreatefrompng($img);
                    imagecopyresized($target, $qrcode_png, $value['left'], $value['top'], 0, 0, $value['width'], $value['height'],132,132);
                    @unlink($img);
                }
            }

		}
		imagejpeg($target, $qrcode);
		imagedestroy($target);
		return $qrcode;
	}

    

    public function postimage($openid,$mediaid){
        $message = array(
            'touser' => $openid,
            'msgtype' => 'image',
            'image' => array('media_id' =>$mediaid) //微信素材media_id，微擎中微信上传组件可以得到此值
        );
        $account_api = WeAccount::create();
        $status = $account_api->sendCustomNotice($message);
        return '';
    }

    public function posttaobao($taouil){
         $mediaid=$this->taomedia($taouil);
         $this->postimage($this->message['from'],$mediaid);
         $img=IA_ROOT.'/attachment/images/taobaotemp.jpg';
         @unlink($img);         
         return '';
    }

    public function taomedia($taouil){
         $temurl=$this->taobaoImage($taouil);
         $mediaid=$this->uploadImage($temurl);
         return $mediaid;
    }

    public function taobaoImage($url) {
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        ob_start ();
        curl_exec ( $ch );
        $return_content = ob_get_contents ();
        ob_end_clean ();
        $return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
        $filename = IA_ROOT.'/attachment/images/taobaotemp.jpg';
        $fp= @fopen($filename,"a"); //将文件绑定到流 
        fwrite($fp,$return_content); //写入文件
        return $filename;
    }
    
   


    function getQR($fans, $poster, $sid) {
        global $_W;
        $pid = $poster['id'];
        $qrtype = $poster['rtype'];
        $share = pdo_fetch('select * from ' . tablename($this->modulename . "_share") . " where id='{$sid}'");
        if (!empty($share['url'])) {
            $out = false;
            if ($qrtype) {
                $qrcode = pdo_fetch('select * from ' . tablename('qrcode') . " where uniacid='{$_W['uniacid']}' and ticket='{$share['ticketid']}' " . " and name='{$poster['title']}' and url='{$share['url']}'");
                if ($qrcode['createtime'] + $qrcode['expire'] < time()) {
                    pdo_delete('qrcode', array('id' => $qrcode['id']));
                    $out = true;
                } 
            } 
            if (!$out) {
                return $share['url'];
            } 
        } 
        if (!$qrtype) {
            $barcode['action_info']['scene']['scene_str'] = $this->modulename . $sid;
        } else {
            $sceneid = pdo_fetchcolumn('select qrcid from ' . tablename("qrcode") . " where uniacid='{$_W['uniacid']}' order by qrcid desc limit 1");
            if (empty($sceneid)) $sceneid = 1;
            else $sceneid++;
            $barcode['action_info']['scene']['scene_id'] = $sceneid;
        } 
        load() -> model('account');
        $acid = pdo_fetchcolumn('select acid from ' . tablename('account') . " where uniacid={$_W['uniacid']}");
        $uniacccount = WeAccount :: create($acid);
        $time = 0;
        if ($qrtype) {
            $barcode['action_name'] = 'QR_SCENE';
            $barcode['expire_seconds'] = 30 * 24 * 3600;
            $res = $uniacccount -> barCodeCreateDisposable($barcode);
            $time = $barcode['expire_seconds'];
        } else {
            $barcode['action_name'] = 'QR_LIMIT_STR_SCENE';
            $res = $uniacccount -> barCodeCreateFixed($barcode);
        }
        $qrcode = array('uniacid' => $_W['uniacid'], 'acid' => $acid, 'name' => $poster['title'], 'keyword' => $poster['kword'], 'ticket' => $res['ticket'], 'expire' => $time, 'createtime' => time(), 'status' => 1, 'url' => $res['url']);
        if (!$qrtype) {
            $qrcode['scene_str'] = $barcode['action_info']['scene']['scene_str'];
            $qrcode['model'] = 2;
            $qrcode['type'] = 'scene';
           // file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n222222".json_encode($qrcode['scene_str']),FILE_APPEND);
        } else {
            $qrcode['qrcid'] = $sceneid;
            $qrcode['model'] = 1;
        } 
        pdo_insert('qrcode', $qrcode);
        pdo_update($this->modulename . "_share", array('ticketid' => $res['ticket'], 'url' => $res['url']), array('id' => $sid));
        return $res['url'];
    } 

    public function geturl($str) {//获取链接
        $exp = explode('http', $str);
        //$url = 'http' . trim($exp[1]) . '中国';
        $url = 'http' . trim($exp[1]) . ' ';
        //preg_match('/[\x{4e00}-\x{9fa5}]/u', $url, $matches, PREG_OFFSET_CAPTURE);
        preg_match('/[\s]/u', $url, $matches, PREG_OFFSET_CAPTURE); 
        $url = substr($url, 0, $matches[0][1]);
        if($url=='http'){
          Return '';
        }else{
          return $url;
        }        
    }

    public function myisexists($url) {//判断是不是淘宝的地址
       if(stripos($url,'uland.')!==false){
          return 3;
       }elseif (stripos($url,'taobao.com')!==false) {
          return 2;
       }elseif(stripos($url,'tmall.com')!==false) {
          return 2;
       }elseif(stripos($url,'tmall.hk')!==false) {
          return 2;
       }else{
          return 1;
       }
       return 0;
    }

    public function mygetID($url) {//获取链接商品ID
       if (preg_match("/[\?&]id=(\d+)/",$url,$match)) {
          return $match[1];
       } else {
          return '';
       }
    }
    
    public function pddgoodsID($url) {//获取链接商品ID
       if (preg_match("/[\?&]goods_id=(\d+)/",$url,$match)) {
          return $match[1];
       } else {
          return '';
       }
    }
    
    public function jdgoods($url) {//获取链接商品ID
       if (preg_match("/[\?&]sku=(\d+)/",$url,$match)) {
          return $match[1];
       } else {
          return '';
       }
    }
    
    public function jdgoodsID($url){
    	$goodsid=$this->Text_qzj($url,"?sku=","&");
    	if(empty($goodsid)){
    		$goodsid=$this->Text_qzj($url,"product/",".html");
    	}
    	if(empty($goodsid)){
    		$goodsid=$this->Text_qzj($url,"com/",".html");
    	}
    	if(empty($goodsid)){
    		$goodsid=$this->jdgoods($url);
    	}
    	
    	return $goodsid;
    }

    public function hqgoodsid($url) {//e22a获取ID
        $str = $this->curl_request($url);     
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n aaaaassss:".$str,FILE_APPEND);
        //preg_match_all('|url.*&id=([\d]+)&|', $fd,$str);
		$str=str_replace("\"", "", $str);       
        $title=$this->Text_qzj($str,"<title>","</title>");
        if($title=='亲，访问受限了'){
          Return array('error'=>'亲，访问受限了'); 
        }
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n goodsid:".json_encode($str),FILE_APPEND);
		$goodsid=$this->Text_qzj($str,"?id=","&");
        if(empty($goodsid)){
          $goodsid=$this->Text_qzj($str,"&id=","&");
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemId:",",");
        }
        if(empty($goodsid)){
            $url=$this->Text_qzj($str,"url = '","';");
            $goodsid=$this->Text_qzj($str,"com/i",".htm");
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".json_encode($goodsid),FILE_APPEND);
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemid=","&");
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemId=","&");
        }
        if(empty($goodsid)){
           $goodsid=Text_qzj($str,"itemId%3D","%26");
        }
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n goodsid:".json_encode("--------------"),FILE_APPEND);
        Return $goodsid;
    }
    
    public function getgoodsid($url) {//e22a获取ID
        $str=$url;
		$goodsid=$this->Text_qzj($str,"?id=","&");
        if(empty($goodsid)){
          $goodsid=$this->Text_qzj($str,"&id=","&");
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemId:",",");
        }
        if(empty($goodsid)){
            $url=$this->Text_qzj($str,"url = '","';");
            $goodsid=$this->Text_qzj($str,"com/i",".htm");
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".json_encode($goodsid),FILE_APPEND);
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemid=","&");
        }
        if(empty($goodsid)){
           $goodsid=$this->Text_qzj($str,"itemId=","&");
        }
        if(empty($goodsid)){
           $goodsid=Text_qzj($str,"itemId%3D","%26");
        }
        Return $goodsid;
        

    }

    public function curl_request($url,$post='',$cookie='', $returnCookie=0){
    //参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$Cookies,参数4：是否返回$cookies
        $curl = curl_init();//初始化curl会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; 	Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);//执行curl会话
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);//关闭curl会话
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
    }

    public function utf8_gbk($Text) {
					return iconv("UTF-8","gbk//TRANSLIT",$Text);
				}

    public  function getyouhui($str){
        preg_match_all('|￥([^￥]+)￥|ism', $str, $matches);
        return $matches[1][0];
    }

    public function getyouhui2($str){
        preg_match_all('|(￥[^￥]+￥)|ism', $str, $matches);
        return $matches[1][0];
    }

   public function getfc1 ($string, $len=2) {
      $string=str_replace(' ','',$string);
      $start = 0;
      $strlen = mb_strlen($string);
      while ($strlen) {
        $array[] = mb_substr($string,$start,$len,"utf8");
        $string = mb_substr($string, $len, $strlen,"utf8");
        $strlen = mb_strlen($string);
      }
      return $array;
   }

   public function httpPost($url,$postData) 
    { 
      $ch = curl_init(); 
      curl_setopt($ch,CURLOPT_URL,$url); 
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch,CURLOPT_HEADER, false); 
      curl_setopt($ch, CURLOPT_POST, count($postData));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
      $output=curl_exec($ch);
      curl_close($ch); 
      return $output;
    }



    public function Text_qzj($Text,$Front,$behind) {
				//语法：strpos(string,find,start)
				//函数返回字符串在另一个字符串中第一次出现的位置，如果没有找到该字符串，则返回 false。
				//参数描述：
				//string 必需。规定被搜索的字符串。
				//find   必需。规定要查找的字符。
				//start  可选。规定开始搜索的位置。
				
				//语法：string mb_substr($str,$start,$length,$encoding)
				//参数描述：
				//str      被截取的母字符串。
				//start    开始位置。
				//length   返回的字符串的最大长度,如果省略，则截取到str末尾。
				//encoding 参数为字符编码。如果省略，则使用内部字符编码。
					
					$t1 = mb_strpos(".".$Text,$Front);
					if($t1==FALSE){
						return "";
					}else{
						$t1 = $t1-1+strlen($Front);
					}
					$temp = mb_substr($Text,$t1,strlen($Text)-$t1);
					$t2 = mb_strpos($temp,$behind);
					if($t2==FALSE){
						return "";
					}
					return mb_substr($temp,0,$t2);
				}


    public function postText($openid, $text) {
	     $message = array(
	        'msgtype' => 'text',
	        'text' => array('content' => urlencode($text)),
	        'touser' => $openid,
	     );
	     $account_api = WeAccount::create();
	     $status = $account_api->sendCustomNotice($message);
		//$post = '{"touser":"' . $openid . '","msgtype":"text","text":{"content":"' . $text . '"}}';
		//$ret = $this->postRes($this->getAccessToken(), $post);
		//return $ret;
	}

    private function postRes($access_token, $data) {
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
		load()->func('communication');
		$ret = ihttp_request($url, $data);
		$content = @json_decode($ret['content'], true);
		return $content['errcode'];
	}

    private function PostNews($poster,$name){
		$stitle = unserialize($poster['stitle']);
		if (!empty($stitle)){
			$thumbs = unserialize($poster['sthumb']);
			$sdesc = unserialize($poster['sdesc']);
			$surl = unserialize($poster['surl']);
			foreach ($stitle as $key => $value) {
				if (empty($value)) continue;
				$response[] = array(
					'title' => str_replace('#昵称#',$name,$value),
					'description' => $sdesc[$key],
					'picurl' => tomedia( $thumbs[$key] ),
					'url' => $this->buildSiteUrl($surl[$key])
				);
			}
			if ($response) return $this->respNews($response);
		}
		return '';
	}


    private function postgoods($goods,$str,$pid,$cfg){
        //$cfg = $this->module['config']; 
        $lm=$cfg['mmtype'];
        $str=str_replace("找","",$str);
        if(!empty($cfg['ttpicurl'])){
            $response[]=array(
                'title' => $cfg['tttitle'],
                'description' =>$cfg['tttitle'],
                'picurl' => tomedia($cfg['ttpicurl']),
                'url' => $this->buildSiteUrl($cfg['tturl'])."&pid=".$pid
            );              
        }
        foreach ($goods as $key => $value) {
            $viewurl=$this->createMobileurl('view',array('itemid'=>$value['itemid']));
            
            $response[] = array(
                'title' => "【券后价:".$value['itemendprice']."】".$value['itemtitle'],
                'description' => $value['itemtitle'],
                'picurl' => tomedia($value['itempic']."_100x100.jpg"),
                'url' => $this->buildSiteUrl($viewurl)."&pid=".$pid."&lm=".$lm
            );
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".json_encode($response),FILE_APPEND);
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\n".json_encode("-------------------------"),FILE_APPEND);
        }

        $tturl=$this->createMobileurl('cqlist',array('key'=>$str,'zn'=>1));

        $response[]=array(
                'title' =>'点击查看【更多相关“'.$str.'”的优惠商品】',
                'description' =>'点击查看【更多相关“'.$str.'”优惠商品】',
                'picurl' =>'',
                'url' => $this->buildSiteUrl($tturl)."&pid=".$pid
            ); 
        if ($response) return $this->respNews($response);
		return '';
	}
    


    private function getAccessToken() {
		global $_W;
		load()->model('account');
		$acid = $_W['acid'];
		if (empty($acid)) {
			$acid = $_W['uniacid'];
		}
		$account = WeAccount::create($acid);
		//$token = $account->fetch_available_token();
        $token = $account->getAccessToken();
		return $token;
	}

    public function rhy($quan_id,$num_iid,$pid) {//二合一 鹊桥
        //$url="https://uland.taobao.com/coupon/edetail?activityId=".$quan_id."&itemId=".$num_iid."&src=tiger_tiger&pid=".$pid."&tj1=1";
        $url="https://uland.taobao.com/coupon/edetail?activityId=".$quan_id."&itemId=".$num_iid."&src=tiger_tiger&pid=".$pid."";
        Return $url;        
    }
    public function rhydx($quan_id,$num_iid,$pid) {//二合一 定向
        //$url="https://uland.taobao.com/coupon/edetail?activityId=".$quan_id."&itemId=".$num_iid."&src=tiger_tiger&pid=".$pid."&dx=1&tj1=1";
        $url="https://uland.taobao.com/coupon/edetail?activityId=".$quan_id."&itemId=".$num_iid."&src=tiger_tiger&pid=".$pid."&dx=1";
        Return $url;        
    }


    public function dwz($url) {//短网址API
        global $_W;
        $url=urlencode($url);
        $turl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('openlink',array('link'=>$url)));
        
        $cfg = $this->module['config'];
        if($cfg['dwzlj']==0){//sina
        	$url=$this->sinadwz($turl);
        }elseif($cfg['dwzlj']==1){//w.url
        	$url=$this->wxdwz($turl);
        }else{
        	$url=$this->zydwz($turl);
        }
        Return $url;
    }


    public function dwzw($turl) {//短网址API
        global $_W;
        $cfg = $this->module['config'];
        if($cfg['dwzlj']==0){//sina
        	$url=$this->sinadwz($turl);
        }elseif($cfg['dwzlj']==1){//w.url
        	$url=$this->wxdwz($turl);
        }else{
        	$url=$this->zydwz($turl);
        }
        Return $url;
    }
    public function pdddwzw($turl) {//同类产品拼多多 短网址API
        global $_W;
        $cfg = $this->module['config'];
        $url=$this->zydwz($turl);
        Return $url;
    }
    
    
    public function zydwz($turl){//自有短网址
    	global $_W;
        $cfg = $this->module['config'];
        $data=array(
                'weid'=>$_W['uniacid'],
                'url'=>$turl,
                'createtime'=>TIMESTAMP,
                );
        pdo_insert("tiger_newhu_dwz",$data);
        $id = pdo_insertid();        
        $url=$cfg['zydwz']."t.php?d=".$id;
        return $url;
    }
    
    
    
    public function wxdwz($url){
    	$result='{"action":"long2short","long_url":"'.$url.'"}';
        $access_token=$this->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token={$access_token}";
        $ret = ihttp_request($url, $result);        
        $content = @json_decode($ret['content'], true);
        Return $content['short_url'];
    }

    public function sinadwz($url) {//sina t.n短网址API
        global $_W;
        $cfg = $this->module['config'];
        if(empty($cfg['sinkey'])){
        	$key='1549359964';
        }else{
        	$key=trim($cfg['sinkey']);
        }
        //$url=urlencode($url);
        //$turl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('openlink',array('link'=>$url)));
        $turl2=urlencode($url);      
        $sinaurl="http://api.t.sina.com.cn/short_url/shorten.json?source={$key}&url_long={$turl2}";
        load()->func('communication');
        $json = ihttp_get($sinaurl);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--sina.txt","\n--3".$url,FILE_APPEND);
        //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--sina.txt","\n--3".json_encode($json),FILE_APPEND);
        $result = @json_decode($json['content'], true);
        return $result[0]['url_short'];  
    }

	public function tkl($url,$img,$tjcontent) {//淘口令转换
        global $_W, $_GPC;
        
        $cfg = $this->module['config'];
        $appkey=$cfg['tkAppKey'];
        $secret=$cfg['tksecretKey'];
        
        $c = new TopClient;
		$c->appkey = $appkey;
        $c->secretKey = $secret;
		$req = new TbkTpwdCreateRequest;
		//$req->setUserId("123");
		$req->setText($tjcontent);
		$req->setUrl($url);
		$req->setLogo($img);
		$req->setExt("{}");
		$resp = $c->execute($req);	
		$jsonStr = json_encode($resp);
		$jsonArray = json_decode($jsonStr,true);
		$taokou=$jsonArray['data']['model'];
		
	    if($cfg['tklnewtype']==1){
	      	$taokou=str_replace("《","￥",$taokou);//KuQU02tsN9Z《 ￥VFM402tN1ui￥《SFol02tuPOU《
	    }
        Return $taokou;
    }
    
    public function tkljx($msg){
    	 global $_W, $_GPC;
        $cfg = $this->module['config'];
        $appkey=$cfg['tkAppKey'];
        $secret=$cfg['tksecretKey'];
         $c = new TopClient;
		$c->appkey = $appkey;
		$c->secretKey = $secret;
		$req = new WirelessShareTpwdQueryRequest;
		$req->setPasswordContent($msg);
		$resp = $c->execute($req);
		$jsonStr = json_encode($resp);
		$jsonArray = json_decode($jsonStr,true);
		$url=$jsonArray['url'];		
		
		$title=$this->tklresp($jsonArray['content'],$cfg);

		$data=array(
			'url'=>$jsonArray['url'],
			'content'=>$title,
		);
		return $data;
//		echo $url;
//		echo "<pre>";
//      print_r($jsonArray);
//      exit;
    }
    

    public function fun1($str){
        if (preg_match('/（(.*?)）/sim', $str,$matches)) {
            $title=$matches[1];
        } else {
            # Match attempt failed
            $title="";
        }        
        return $title;
    }
    public function fun2($str){
        if (preg_match('/【(.*?)】/sim', $str,$matches)) {
            $title=$matches[1];
        } else {
            # Match attempt failed
            $title="";
        }        
        return $title;
    }
    
    public function tklresp($centent,$cfg){
    	         global $_W, $_GPC;
      	         $stry=str_replace("【天猫超市】","",$centent);   
                 $stry=str_replace("抢","",$centent); 
                 //$str=$this->Text_qzj($stry,"（","），");
                 $str=$this->fun1($stry);
                 if(!empty($str)){
                 	 $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('key'=>$str,'lm'=>1,'pid'=>$cfg['ptpid'],'pic_url'=>$res['pictUrl'])));
                     $ddwz=$this->dwzw($tturl);
                     $newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsg']);
                     $newmsg=str_replace('#名称#',$str, $newmsg);
                     $newmsg=str_replace('#短网址#',$ddwz, $newmsg);
                      return $newmsg;
                 }
                 $str1=$this->fun2($stry);
                 if(!empty($str1)){
                 	 $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('key'=>$str1,'lm'=>1,'pid'=>$cfg['ptpid'],'pic_url'=>$res['pictUrl'])));
                     $ddwz=$this->dwzw($tturl);
                     $newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsg']);
                     $newmsg=str_replace('#名称#',$str1, $newmsg);
                     $newmsg=str_replace('#短网址#',$ddwz, $newmsg);
                      return $newmsg;
                 }
                 $str2=$this->Text_qzj($stry,"【抢","】，");
                 //return $this->respText($str2);
                 if(!empty($str2)){
                 	 $tturl=$_W['siteroot'].str_replace('./','app/',$this->createMobileurl('cqlist',array('key'=>$str1,'lm'=>1,'pid'=>$cfg['ptpid'],'pic_url'=>$res['pictUrl'])));
                     $ddwz=$this->dwzw($tturl);
                     $newmsg=str_replace('#昵称#',$fans['nickname'], $cfg['newflmsg']);
                     $newmsg=str_replace('#名称#',$str2, $newmsg);
                     $newmsg=str_replace('#短网址#',$ddwz, $newmsg);                      
                      return $newmsg;
                 }
    }
    
    //增加余额 增加积分
    //mc_credit_update($share['openid'],'credit1',$poster['score'],array($share['openid'],'关注送积分'))
    //$uid 用户ID
    //$type 0 积分  1 余额
    //$typelx  1签到    2邀请奖励    3取消关注   4订单奖励  5关注奖励  6后台管理员增加余额积分 7提现 8 晒单奖励 9积分商城兑换  10 代理支付奖励
    //createtime 添加时间
    public function mc_jl($uid,$type,$typelx,$num,$remark,$orderid){
        global $_W;
        if(empty($uid)){
            return;
        }
        $data=array(
            'uid'=>$uid,
            'weid'=>$_W['uniacid'],
            'type'=>$type,
            'typelx'=>$typelx,
            'num'=>$num,
            'remark'=>$remark,
            'orderid'=>$orderid,
            'createtime'=>time(),
        );
        $share= pdo_fetch("SELECT credit1,credit2 FROM " . tablename($this->modulename."_share") . " WHERE id='{$uid}' and weid='{$_W['uniacid']}' ");
        if($type==1){
            $credit2=$share['credit2']+$num;
            if($credit2<0){
              return array('error'=>0,'data'=>'余额不足');
            }
            $res=pdo_update($this->modulename."_share",array('credit2'=>$credit2),array('id'=>$uid));
            if($res===false){
               return array('error'=>0,'data'=>'余额更新失败');
            }else{
               //die(json_encode(array('error'=>1,'data'=>'余额更新成功!','uid'=>$uid)));//返回JSON数据
                $inst=pdo_insert($this->modulename."_jl",$data);
                if($inst=== false){
                    return array('error'=>0,'data'=>'余额更新失败');
                }else{
                    return array('error'=>1,'data'=>'余额更新成功');
                }
            }
        }elseif($type==0){
            $credit1=$share['credit1']+$num;
            
            if($credit1<0){
              return array('error'=>0,'data'=>'积分不足');
            }
            $res=pdo_update($this->modulename."_share",array('credit1'=>$credit1),array('id'=>$uid));
            file_put_contents(IA_ROOT."/addons/tiger_newhu/log.txt","\nUID:".$share['id']."ji:".$credit1."jg:".$res,FILE_APPEND);
            
            if($res===false){
               return array('error'=>0,'data'=>'积分更新失败');
            }else{
               $inst=pdo_insert($this->modulename."_jl",$data);
                if($inst=== false){
                    return array('error'=>0,'data'=>'积分更新失败');
                }else{
                    return array('error'=>1,'data'=>'积分更新成功');
                }
            }
        }   
    
    }


}