<?php
global $_GPC,$_W;
		$cfg = $this->module['config'];
		$lm=$cfg['mmtype'];
		$zt=$_GPC['zt'];
		$weid=$_W['uniacid'];
		$px=$_GPC['px'];
		$type=$_GPC['type'];
		$tm=$_GPC['tm'];
		$price1=$_GPC['price1'];
		$price2=$_GPC['price2'];
		$hd=$_GPC['hd'];
		$page=$_GPC['page'];
		$key=$_GPC['key'];
		$dlyj=$_GPC['dlyj'];
		$dluid=$_GPC['dluid'];
		$pid=$_GPC['pid'];
        $rate=$cfg['zgf'];
		$key=str_replace(" ","",$key);
		$hdtype=$_GPC['hdtype'];
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();	        
        }
		
		
		
		$dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
		//PID绑定
		if(!empty($dluid)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
        }else{
          //$fans=mc_oauth_userinfo();
          $openid=$fans['openid'];
          if(empty($openid)){
          	$openid=$_W['openid'];
          }
          $zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
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
        }else{
           if($share['dlptpid']){
               if(!empty($share['dlptpid'])){
                 $cfg['ptpid']=$share['dlptpid'];
                 $cfg['qqpid']=$share['dlqqpid'];
               }       
            }
        }
		//结束
		if(empty($pid)){
        	$pid=$cfg['ptpid'];
	    }else{
	    	$cfg['ptpid']=$pid;
	    }
		
        if(!empty($cfg['gyspsj'])){
           $weid=$cfg['gyspsj'];
         }
         
		//分类
		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 		
		$list=getddqtype();
//		echo "<pre>";
//		print_r($list);
//		exit;
		$list1=array();
		$day=date("d",time());
		$hday=date("H",time());
		$star=$day.$hday;
		$cout=count($list)-1;
		foreach($list as $k=>$v){
			    
				if($star>$v['type']){
					$dtitle="已开抢";
					$types=1;
				}elseif($star<$v['type']){
					$dtitle="即将开抢";
					$types=0;
				}else{
					$dtitle="正在疯抢";
					$types=1;
				}
				//
				$list1[$k]['day']=$v['type'];
				$list1[$k]['check']=0;
				$list1[$k]['types']=$types;
				if($list[$k-1]['type']<$star && $star<=$v['type']){
					$dtitle="正在疯抢";				
					if($star==$v['type']){
						$list1[$k]['dtitle']="正在疯抢";
						$list1[$k]['day']=$star;
						$list1[$k]['check']=1;
						$xzdata=array('id'=>$k,'check'=>1,'types'=>1,'type'=>$list[$k]['type'],'ztbt'=>'正在疯抢');
					}else{
						$list1[$k]['dtitle']="即将开抢";
						$list1[$k-1]['dtitle']="正在疯抢";
						$list1[$k-1]['day']=$star;
						$list1[$k-1]['check']=1;
						$xzdata=array('id'=>$k-1,'check'=>1,'types'=>1,'type'=>$list[$k-1]['type'],'ztbt'=>'正在疯抢');
					}
				}
				else{
					$list1[$k]['dtitle']=$dtitle;
				}
				$list1[$k]['id']=$v['id'];
				$list1[$k]['title']=$v['title'];
				$list1[$k]['type']=$v['type'];
		}
		//分类结束
		$catlist=$list1;
		
//		echo "<pre>";
//	    print_r($catlist);
//	    exit;


         
        //ajax请求开始
		if($_W['isajax']){
//      include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 	
		$type=$_GPC['hdtype'];
		$uid=$_GPC['uid'];	
		$list=getddqlist($type);
		
		$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
        if($share['status']==1){
			$this->shtype=0;
		}
		$bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
		
		$list1=array();
		
		foreach($list as $k=>$v){
            	
            				$arr=strstr($v['itempic'],"http");
            	            if($arr!==false){
            	            	$itempic=str_replace("http:","https:",$v['itempic'])."_250x250.jpg";
            	            	$itempic1=str_replace("http:","https:",$v['itempic'])."";
            	            }else{
            	            	$itempic="https:".$v['itempic']."_250x250.jpg";
            	            	$itempic1="https:".$v['itempic']."";
            	            }
            	            
            	            if($cfg['lbratetype']==3){
                            	$ratea=$this->ptyjjl($v['itemendprice'],$v['tkrates'],$cfg);
                            }else{
                            	$ratea=$this->sharejl($v['itemendprice'],$v['tkrates'],$bl,$share,$cfg);
                            }   

                             $list1[$k]['rate']=$ratea;
                            $list1[$k]['itemtitle']=$v['itemtitle'];               			
                            $list1[$k]['weid']=$v['weid'];
                            $list1[$k]['fqcat']=$v['fqcat'];
                            $list1[$k]['zy']=$v['zy'];
                            $list1[$k]['quan_id']=$v['quan_id'];
                            $list1[$k]['itemid']=$v['itemid'];
                            $list1[$k]['itemtitle']=$v['itemtitle'];
                            $list1[$k]['itemshorttitle']=$v['itemshorttitle'];
                            $list1[$k]['itemdesc']=$v['itemdesc'];
                            $list1[$k]['itemprice']=$v['itemprice'];
                            $list1[$k]['itemsale']=$v['itemsale'];
                            $list1[$k]['itemsale2']=$v['itemsale2'];
                            $list1[$k]['conversion_ratio']=$v['conversion_ratio'];
                            $list1[$k]['itempic']=$itempic;
                            $list1[$k]['itempic1']=$itempic1;
                            $list1[$k]['itemendprice']=$v['itemendprice'];
                            $list1[$k]['shoptype']=$v['shoptype'];
                            $list1[$k]['userid']=$v['userid'];
                            $list1[$k]['sellernick']=$v['sellernick'];
                            $list1[$k]['tktype']=$v['tktype'];
                            $list1[$k]['tkrates']=$v['tkrates'];
                            $list1[$k]['ctrates']=$v['ctrates'];
                            $list1[$k]['cuntao']=$v['cuntao'];
                            $list1[$k]['tkmoney']=$v['tkmoney'];
                            $list1[$k]['tkurl']=$v['tkurl'];
                            $list1[$k]['couponurl']=$v['couponurl'];
                            $list1[$k]['planlink']=$v['planlink'];
                            $list1[$k]['couponmoney']=$v['couponmoney'];
                            $list1[$k]['couponsurplus']=$v['couponsurplus'];
                            $list1[$k]['couponreceive']=$v['couponreceive'];
                            $list1[$k]['couponreceive2']=$v['couponreceive2'];
                            $list1[$k]['couponnum']=$v['couponnum'];
                            $list1[$k]['couponexplain']=$v['couponexplain'];
                            $list1[$k]['couponstarttime']=$v['couponstarttime'];
                            $list1[$k]['couponendtime']=$v['couponendtime'];
                            $list1[$k]['starttime']=$v['starttime'];
                            $list1[$k]['isquality']=$v['isquality']; 
                            $list1[$k]['item_status']=$v['item_status'];
                            $list1[$k]['report_status']=$v['report_status'];
                            $list1[$k]['is_brand']=$v['is_brand'];
                            $list1[$k]['is_live']=$v['is_live'];
                            $list1[$k]['videoid']=$v['videoid'];
                            $list1[$k]['activity_type']=$v['activity_type'];
                            $list1[$k]['createtime']=$v['createtime'];
                            $list1[$k]['lm']=1;//2云商品库    0自己采集   1联盟商品
                
           }
			exit(json_encode(array('pages' =>ceil($list['total']/20), 'data' =>$list1,'lm'=>2)));
        }
		


		include $this->template ( 'tbgoods/style99/ddq' );  
?>