<?php
	
	//小程序 数据列表
	//wx.baokuanba.com/app/index.php?i=3&c=entry&do=pddgoodslist&m=tiger_newhu&owner_name=13735760105&page=1&keyword=%E8%A1%AC%E8%A1%AB&category_id=743&sort_type=0&with_coupon=true
global $_W, $_GPC;
		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/jd.php"; 
		$weid=$_W['uniacid'];//绑定公众号的ID
		$cfg = $this->module['config'];
		$op=$_GPC['op'];
		$keyword=$_GPC['key'];//搜索关键词
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
			
			$goods=jdgoodslist($jdset,$type,$px,$price1,$price2,$hd,$page,$keyword,$dlyj,$rate);
			//$goods=pddgoodslist($owner_name,$page,$keyword,$category_id,$sort_type,$with_coupon,$hd);
//			echo 22;
//			echo "<pre>";
//			print_r($goods);
//			exit;
			$data=$goods['data'];
			$list=array();
			foreach($data as $k=>$v){
				
				$itemendprice=$v['coupon_price'];
				
				if($cfg['lbratetype']==3){
                	$ratea=$this->ptyjjl($itemendprice,$v['commission'],$cfg);
                }else{
                	$ratea=$this->sharejl($itemendprice,$v['commission'],$bl,$share,$cfg);
                }
				$list[$k]['itemid']=$v['goods_id'];
				$list[$k]['itemtitle']=$v['goods_name'];
				$list[$k]['itempic']=$v['goods_img'];//小图
				$list[$k]['itempic1']=$v['goods_img'];//大图
				$list[$k]['itemprice']=$v['goods_price'];//原价
				$list[$k]['itemendprice']=$v['coupon_price'];//券后拼购
				$list[$k]['couponmoney']=$v['discount_price'];//优惠券金额
	            $list[$k]['coupon_end_time']=$v['discount_end'];//优惠券失效时间
	            $list[$k]['itemsale']=$v['sold_quantity'];//销量
	            $list[$k]['rate']=$ratea;//佣金
			}
			die(json_encode(array("error"=>0,'data'=>$list)));  
		
		}
		
		$dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=5 order by px desc");//底部菜单
//		
//		echo "<pre>";
//		print_r($list);
//		exit;
////		
		include $this->template ( 'tbgoods/jd/jdgoodslist' ); 
		
?>