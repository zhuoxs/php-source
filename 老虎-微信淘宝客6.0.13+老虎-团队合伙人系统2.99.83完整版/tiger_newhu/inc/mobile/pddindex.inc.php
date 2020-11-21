<?php
	
	//小程序 数据列表
	//wx.baokuanba.com/app/index.php?i=3&c=entry&do=pddgoodslist&m=tiger_newhu&owner_name=13735760105&page=1&keyword=%E8%A1%AC%E8%A1%AB&category_id=743&sort_type=0&with_coupon=true
global $_W, $_GPC;
		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/pdd.php"; 
		$weid=$_W['uniacid'];//绑定公众号的ID
		$cfg = $this->module['config'];
		$op=$_GPC['op'];
		$keyword=$_GPC['key'];//搜索关键词
		$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$weid}'");
		$owner_name=$pddset['ddjbbuid'];
		$hd=$_GPC['hd'];
		$pdaaa=pddtype($owner_name);
		$pddtype=$pdaaa['goods_opt_get_response']['goods_opt_list'];//拼多多分类
//		echo "<pre>";
//		print_r($pddtype);
//		exit;

		$category_id=$_GPC['category_id'];//商品分类
		$sort_type=$_GPC['sort_type'];//0-综合排序3-按价格升序 6-按销量降序 2-按佣金比率升序
		$with_coupon=$_GPC['with_coupon'];//false返回所有商品，true只返回有优惠券的商品     
		
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
		
		
		$lbad = pdo_fetchall("SELECT * FROM " . tablename($this -> table_ad) . " WHERE weid = '{$_W['uniacid']}' and type=2 order by id desc");//轮播图
		$ad4 = pdo_fetchall("SELECT * FROM " . tablename($this -> table_ad) . " WHERE weid = '{$_W['uniacid']}' and type=3 order by id desc");//菜单下4张图
//		echo "<pre>";
//		print_r($ad4);
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
			
			$goods=pddgoodslist($owner_name,$page,$keyword,$category_id,$sort_type,$with_coupon,$hd);
//			echo "<pre>";
//			print_r($goods);
//			exit;
			$data=$goods['goods_search_response']['goods_list'];
			$list=array();
			foreach($data as $k=>$v){
				
				$itemendprice=($v['min_group_price']-$v['coupon_discount'])/100;
				
				if($cfg['lbratetype']==3){
                	$ratea=$this->ptyjjl($itemendprice,$v['promotion_rate']/10,$cfg);
                }else{
                	$ratea=$this->sharejl($itemendprice,$v['promotion_rate']/10,$bl,$share,$cfg);
                }
				$list[$k]['itemid']=$v['goods_id'];
				$list[$k]['itemtitle']=$v['goods_name'];
				$list[$k]['itempic']=$v['goods_thumbnail_url'];//小图
				$list[$k]['itempic1']=$v['goods_image_url'];//大图
				$list[$k]['itemprice']=$v['min_group_price']/100;//原价
				$list[$k]['itemendprice']=$itemendprice;//券后拼购
				$list[$k]['couponmoney']=$v['coupon_discount']/100;//优惠券金额
	            $list[$k]['coupon_end_time']=$v['coupon_end_time'];//优惠券失效时间
	            $list[$k]['itemsale']=$v['sold_quantity'];//销量
	            $list[$k]['rate']=$ratea;//佣金
			}
			die(json_encode(array("error"=>0,'data'=>$list)));  
		
		}
		
		$dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=4  order by px desc");//底部菜单
		$cdlist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=3  order by px desc");//首页轮播图下面菜单
//		
//		echo "<pre>";
//		print_r($list);
//		exit;
////		
		include $this->template ( 'tbgoods/pdd/index' ); 
		
?>