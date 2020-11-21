<?php
	
	//小程序 数据列表
	//wx.baokuanba.com/app/index.php?i=3&c=entry&do=pddgoodslist&m=tiger_newhu&owner_name=13735760105&page=1&keyword=%E8%A1%AC%E8%A1%AB&category_id=743&sort_type=0&with_coupon=true
global $_W, $_GPC;
		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/jd.php"; 
		$weid=$_W['uniacid'];//绑定公众号的ID
		$cfg = $this->module['config'];
		$op=$_GPC['op'];
		$keyword=$_GPC['key'];//搜索关键词

		
		
//		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
//      $arr=getfc($keyword,$_W);
//      $key="";
//      foreach($arr as $v){
//           if (empty($v)) continue;
//          $key.=$v;
//      }
//      $keyword=$key;
		

		
		$hd=$_GPC['hd'];
		$type=$_GPC['type'];
		$px=$_GPC['px'];
		$jdset=pdo_fetch("select * from ".tablename('tuike_jd_jdset')." where weid='{$weid}' order by id desc");
		//PID绑定
		$fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();        
        }
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
		
//		echo "<pre>";
//		print_r($zxshare);
//		exit;

		if($op=='1'){  
		
			
			
			$page=$_GPC['page'];//分页
			if(empty($page)){
				$page=1;
			}
			
			
			
			if(empty($category_id)){
				$category_id='';
			}
			
			
			if(pdo_tableexists('tiger_wxdaili_set')){
	          $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$weid}'");
	        }      
	        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and from_user='{$_W['fans']['openid']}'");
			
			$jdset=pdo_fetch("select * from ".tablename('tuike_jd_jdset')." where weid='{$weid}' order by id desc");
		    $jdsign=pdo_fetch("select * from ".tablename('tuike_jd_jdsign')." where weid='{$weid}' order by id desc");
			$goods=getkeylist($jdsign['access_token'],$keyword,$page,$itemid);
		
		    $data=$goods['data'];
		    
			$list=array();
			foreach($data as $k=>$v){
				
				$itemprice=$v['wlPrice'];	
			    $itemendprice=$v['wlPrice']-$v['couponList'][0]['discount'];
				
				if($cfg['lbratetype']==3){
                	$ratea=$this->ptyjjl($itemendprice,$v['wlCommissionShare'],$cfg);
                }else{
                	$ratea=$this->sharejl($itemendprice,$v['wlCommissionShare'],$bl,$share,$cfg);
                }
				$list[$k]['itemid']=$v['skuId'];
				$list[$k]['itemtitle']=$v['skuName'];
				$list[$k]['itempic']="https://img14.360buyimg.com/imgzone/".$v['imageurl'];//小图
				$list[$k]['itempic1']="https://img14.360buyimg.com/imgzone/".$v['imageurl'];//大图
				$list[$k]['itemprice']=$itemprice;//原价
				$list[$k]['itemendprice']=$itemendprice;//券后
				$list[$k]['couponmoney']=$v['couponList'][0]['discount'];//优惠券金额
				$list[$k]['coupon_end_time']=$v['couponList'][0]['endTime'];//优惠券失效时间
				$list[$k]['itemsale']=$v['inOrderCount'];//销量
				$list[$k]['yj']=$yj;//代理佣金奖励：22
				$list[$k]['discount_link']=$v['couponList'][0]['link'];//优惠券链接
				$list[$k]['rate']=$ratea;//
			}
			die(json_encode(array("error"=>0,'data'=>$list)));  
		
		}
		
		$dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=5 order by px desc");//底部菜单
//		
//		echo "<pre>";
//		print_r($list);
//		exit;
////		
		include $this->template ( 'tbgoods/jd/jdcjgoodslist' ); 
		
?>