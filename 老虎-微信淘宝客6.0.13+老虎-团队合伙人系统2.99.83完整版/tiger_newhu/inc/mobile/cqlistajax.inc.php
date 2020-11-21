<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
       include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
       include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
       $page=$_GPC['page'];
       $lm=$_GPC['lm'];
       $lx=$_GPC['lx'];
       $tm=$_GPC['tm'];//1
       $pid=$_GPC['pid'];
       $zn=$_GPC['zn'];//1站内
       $weid=$_W['uniacid'];
       if(empty($pid)){
         $pid=$cfg['ptpid'];
       }
       
       $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$_W['fans']['openid']}'");
        if(pdo_tableexists('tiger_wxdaili_set')){
          $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
        }	

       //$_GPC['key']=str_replace("[emoji=EFBFBC]","",$_GPC['key']);
       //$_GPC['key']=str_replace(" ","",$_GPC['key']);
       

       


       //$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
			 
			 $pidSplit=explode('_',$pid);
			 $memberid=$pidSplit[1];
			 if(empty($memberid)){
			 	$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
			 }else{
			 	$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  memberid='{$memberid}'");
			 }

//     if($cfg['cjsstype']==1){//开启标题查券
//     	$ck = pdo_fetch("SELECT * FROM ".tablename('tiger_newhu_ck')." WHERE weid = :weid", array(':weid' => $_W['uniacid']));
//      $goods=getgoodslist($_GPC['key'],'',$_W,$page,$cfg,$lx,$tm);
//     	 $url=$goods[0]->auctionUrl;
//       $res=hqyongjin($url,$ck,$cfg,$this->modulename,'','',$tksign['sign'],$tksign['tbuid'],$_W,2);  
//       if(!empty($res['couponid'])){
//	          $data=array(
//	             'weid' => $_W['uniacid'],
//	             'itemid'=>$res['num_iid'],//商品ID
//	             'itemtitle'=>$res['title'],//商品名称
//	             'itempic'=>$res['pictUrl'],//主图地址
//	             'itemprice'=>$res['price'],//'商品原价', 
//	             'itemendprice'=>$res['qhjpric'],//商品价格,券后价
//	             'tkrates'=>$res['commissionRate'],//通用佣金
//	             'quan_id'=>$res['couponid'],//'优惠券ID',  
//	             'couponmoney'=>$res['couponAmount'],//优惠券面额
//	             'itemsale'=>$res['biz30day'],//月销售	             
//	             //'taokouling'=>$res['taokouling'],//淘口令
//	             //'lxtype'=>$res['qq'],
//	             'couponendtime'=>strtotime($res['couponendtime']),//优惠券结束
//	             'createtime'=>TIMESTAMP,
//	         );
//	         $go = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_newtbgoods") . " WHERE weid = '{$data['weid']}' and  itemid='{$res['num_iid']}'");
//	           if(empty($go)){ 
//	              $bb=pdo_insert($this->modulename."_newtbgoods",$data);             
//	            }else{      
//	              pdo_update($this->modulename."_newtbgoods", $data, array('weid'=>$data['weid'],'itemid' =>$res['num_iid']));
//	            }         
//	      }
//     }
       
       
       
       
      // echo "<pre>";
      // print_r($res);
      // exit;
      
      if($zn==1){//站内搜索
	        $key=trim($_GPC['key']);
	        if($lx==2){
	        	$px=1;//销量
	        }
	        if($lx==4){
	           $px=4;//优惠券
	        }
	        if($lx==3){
	           $px=2;//价格
	        }
	        $page=$page;	
		    $list1=getcatlist($type,$px,$tm,$price1,$price2,$hd,$page,$key,$dlyj,$pid,$cfg,$rate);
//		    echo "<pre>";
//		    	print_r($list1);
//		    	exit;
//		   
            foreach($list1['data'] as $k=>$v){
            	if($v['itemendprice']<0.02){
            		continue;
            	}
            	if($cfg['lbratetype']==3){
                	$ratea=$this->ptyjjl($v['itemendprice'],$v['tkrates'],$cfg);
                }else{
                	$ratea=$this->sharejl($v['itemendprice'],$v['tkrates'],$bl,$share,$cfg);
                } 
            	 //$ratea=$this->sharejl($v['itemendprice'],$v['tkrates'],$bl,$share,$cfg); 
            	 $list[$k]['rate']=$ratea; //佣金
                 $list[$k]['itemtitle']=$v['itemtitle']; //标题
                 $list[$k]['shoptype']=$v['tm'];  //1天猫
                 $list[$k]['itemid']=$v['itemid'];//商品ID
                 $list[$k]['itemprice']=$v['itemprice'];//原价
                 $list[$k]['itemendprice']=$v['itemendprice'];//折扣价-优惠券金额
                 $list[$k]['couponmoney']=$v['couponmoney'];//优惠券金额
                 $list[$k]['itemsale']=$v['itemsale'];//月销量
                 //$list[$k]['url']=$v->auctionUrl;//商品链接
                 //$list[$k]['shopTitle']=$v->shopTitle;//店铺名称                 
                 $list[$k]['itempic']=$v['itempic'];;//图片
                 $list[$k]['pid']=$pid;
                 $list[$k]['lm']=2;
                 $list[$k]['couponnum']=$v['couponsurplus'];//剩余优惠券数量//用的是总量                 
            }
           if(empty($list)){
           	 $pages=0;
           }else{
           	$pages=ceil(1000/20);
           }           
           exit(json_encode(array('pages' =>$pages, 'data' =>$list,'lm'=>2)));
      }else{
      	   if($lx==2){
	        	$px=1;//销量
	        }
	        if($lx==4){
	           //$px=4;//优惠券
	           $yhj=1;
	        }
	        if($lx==3){
	           $px=2;//价格
	        }

// 	               if($page==1){
// 	               	 $goods=cjsearch($page,$pid,$tksign['sign'],$tksign['tbuid'],$_W,$cfg,urlencode($_GPC['key']),2,'','','','',$tm,$px,1);
// 									 
// 	               	 if(empty($goods['result_list'])){
// 	               	 	$goods=cjsearch($page,$pid,$tksign['sign'],$tksign['tbuid'],$_W,$cfg,urlencode($_GPC['key']),2,'','','','',$tm,$px,$yhj);
// 	               	 }
// 	               }else{
// 	               	 $goods=cjsearch($page,$pid,$tksign['sign'],$tksign['tbuid'],$_W,$cfg,urlencode($_GPC['key']),2,'','','','',$tm,$px,$yhj);
// 	               }
	        	   $goods=cjsearch($page,$pid,$tksign['sign'],$tksign['tbuid'],$_W,$cfg,urlencode(trim($_GPC['key'])),2,'','','','',$tm,$px,$yhj);

// 	        	   echo "<pre>";
// 	        	   	print_r($goods);
// 	        	   	exit;
//	        	   
	        	   
		           	if($goods['total_results']==1){
		           		$goods=$goods['result_list']['map_data'];
		           		if(!empty($goods['coupon_info'])){
		            		preg_match_all('|减(\d*)元|',$goods['coupon_info'], $returnArr);
           					$conmany=$returnArr[1][0];   
		            	}else{
		            		$conmany=0;
		            	}       		
		           		 $itemendprice=$goods['zk_final_price']-$conmany;
				         $status=1;
				         $list[0]['itemtitle']=$goods['title'];  //标题
		                 $list[0]['shoptype']=$goods['user_type'];  //1天猫
		                 $list[0]['itemid']=$goods['num_iid'];//商品ID
		                 $list[0]['itemprice']=$goods['zk_final_price'];//原价
		                 $list[0]['itemendprice']=$itemendprice;//折扣价-优惠券金额
		                 $list[0]['couponmoney']=$conmany;//优惠券金额
		                 $list[0]['itemsale']=$goods['volume'];//月销量
		                 $list[0]['url']=$goods['item_url'];//商品链接
		                 $list[0]['shopTitle']=$goods['shop_title'];//店铺名称                 
		                 $list[0]['itempic']=$goods['pict_url'];//图片
		                 $list[0]['pid']=$pid;
		                 $list[0]['lm']=1;
		                 if($cfg['lbratetype']==3){
		                	$ratea=$this->ptyjjl($itemendprice,$goods['commission_rate']/100,$cfg);
		                 }else{
		                	$ratea=$this->sharejl($itemendprice,$goods['commission_rate']/100,$bl,$share,$cfg);
		                 } 
		                 $list[0]['rate']=$ratea;
		                 $list[0]['couponnum']=$goods['coupon_remain_count'];//剩余优惠券数量//用的是总量  
		
				    }else{
				    	
			            foreach($goods['result_list']['map_data'] as $k=>$v){
			            	$goods=$v;
			            	if(!empty($goods['coupon_info'])){
								preg_match_all('|减(\d*)元|',$goods['coupon_info'], $returnArr);
           						$conmany=$returnArr[1][0];    
			            	}else{
			            		$conmany=0;
			            	}
			            	 		      		
			           		 $itemendprice=$goods['zk_final_price']-$conmany;
		//	            	if($itemendprice<0.02){
		//	            		continue;
		//	            	}        		
					         $status=1;
					         $list[$k]['itemtitle']=$goods['title'];  //标题
			                 $list[$k]['shoptype']=$goods['user_type'];  //1天猫
			                 $list[$k]['itemid']=$goods['num_iid'];//商品ID
			                 $list[$k]['itemprice']=$goods['zk_final_price'];//原价
			                 $list[$k]['itemendprice']=$itemendprice;//折扣价-优惠券金额
			                 $list[$k]['couponmoney']=$conmany;//优惠券金额
			                 $list[$k]['itemsale']=$goods['volume'];//月销量
			                 $list[$k]['url']=$goods['item_url'];//商品链接
			                 $list[$k]['shopTitle']=$goods['shop_title'];//店铺名称                 
			                 $list[$k]['itempic']=$goods['pict_url'];//图片
			                 $list[$k]['pid']=$pid;
			                 $list[$k]['lm']=1;
//			                 $ratea=$this->sharejl($itemendprice,$goods['commission_rate']/100,$bl,$share,$cfg);
			                 if($cfg['lbratetype']==3){
			                	$ratea=$this->ptyjjl($itemendprice,$goods['commission_rate']/100,$cfg);
			                 }else{
			                	$ratea=$this->sharejl($itemendprice,$goods['commission_rate']/100,$bl,$share,$cfg);
			                 } 
			                 $list[$k]['rate']=$ratea;
			                 $list[$k]['couponnum']=$goods['coupon_remain_count'];//剩余优惠券数量//用的是总量     
			          }
				       $status=1;
				    }
	        	
	        }

       $key=trim($_GPC['key']);
			 
// 			 	        	   echo "<pre>";
// 			 	        	   	print_r($list);
// 			 	        	   	exit;
      

       //file_put_contents(IA_ROOT."/addons/tiger_newhu/inc/mobile/log--aaa.txt","\n".json_encode($list),FILE_APPEND);
       //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--aaa.txt","\n".json_encode($status),FILE_APPEND);
       
           	 

      // exit(json_encode(array('pages'=>ceil(100/20),status' => $status,'data' => $list,'lm'=>1)));
      if(empty($list)){
       	 $pages=0;
       }else{
       	$pages=ceil(1000/20);
       }
//    	           echo "<pre>";
//       	   print_r($list);
//      	   exit;
           
       exit(json_encode(array('pages' =>$pages, 'data' =>$list,'lm'=>1)));
?>