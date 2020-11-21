<?php
	//小程序 数据列表
	//http://cs.tiger-app.com/app/index.php?i=8&c=entry&a=wxapp&do=pddview&m=tiger_tkxcx&owner_name=13735760105&itemid=4837612
global $_W, $_GPC;
		$weid=$_W['uniacid'];//绑定公众号的ID
		$cfg = $this->module['config'];

		
		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/pdd.php"; 
		$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$weid}'");
		$owner_name=$pddset['ddjbbuid'];
		$itemid=$_GPC['itemid'];//
		
		$fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();        
        }
		
				
		$bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$weid}'");        
		
		$openid=$fans['openid'];
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");  
//      echo "<pre>";
//      print_r($fans);      
        
        if($share['dltype']==1){//是代理
			if(empty($share['pddpid'])){//如果是代理，PID没填写就默认公众号PID
				$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$weid}'");
				$share['pddpid']=$pddset['pddpid'];
			}
		}else{//不是代理
			if(!empty($share['helpid'])){//查看有没有上级
				$shshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$weid}' and id='{$share['helpid']}'");
				//file_put_contents(IA_ROOT."/addons/tiger_tkxcx/v_log.txt","\n helpid1:".$share['helpid']."--------".json_encode($shshare),FILE_APPEND);	
				if(empty($shshare['id'])){//没有上级代理，就用默认的公众号PID
					$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$weid}'");
				    $share['pddpid']=$pddset['pddpid'];
				}else{//有上级代理
					if($shshare['dltype']==1){//如果上级是代理，就用代理的PID
						$share['pddpid']=$shshare['pddpid'];
					}else{//上级不是代理就用默认的PID
						$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$weid}'");
				   		$share['pddpid']=$pddset['pddpid'];
					}
				}
			}else{//没有上级就用默认公众号PID
				$pddset=pdo_fetch("select * from ".tablename('tuike_pdd_set')." where weid='{$weid}'");
				$share['pddpid']=$pddset['pddpid'];
			}			
		}
		$p_id=$share['pddpid'];
		
//		echo $p_id;
//		exit;
		
//		$goods=pddview($owner_name,$itemid);
//		$dataview=$goods['goods_detail_response']['goods_details'][0];
		
		
		//转链详情
		$zl=pddviewzl($owner_name,$itemid,$p_id);	
		
		$data=$zl['goods_promotion_url_generate_response']['goods_promotion_url_list'][0];		
		$itemendprice=($data['goods_detail']['min_group_price']-$data['goods_detail']['coupon_discount'])/100;
		$itemtitle=$data['goods_detail']['goods_name'];
		if(!empty($zl['error_response'])){
			$itemtitle=$zl['error_response']['error_msg'];
		}
		
		$itempic=str_replace("http:","https:",$data['goods_detail']['goods_thumbnail_url']);
//		echo "<pre>";
//		print_r($data['goods_detail']['goods_gallery_urls']);

		foreach($data['goods_detail']['goods_gallery_urls'] as $k=>$v){
			$itempic5[$k]=str_replace("http:","https:",$v);
		}
//		print_r($itempic5);

		

		$views=array(
      		'itemid'=>$itemid,
      		'itemtitle'=>$itemtitle,
      		'itempic'=>$itempic,
      		'itemprice'=>$data['goods_detail']['min_group_price']/100,
      		'itemendprice'=>$itemendprice,
      		'couponmoney'=>$data['goods_detail']['coupon_discount']/100,
      		'itemdesc'=>$data['goods_detail']['goods_desc'],
      		'itemsale'=>$data['goods_detail']['sold_quantity'],
      		'videoid'=>'',
      		'itempic5'=>$itempic5,
      		'pddxcx'=>$data['we_app_info'],
      		'url1'=>$data['we_app_web_view_url'],
      		'url2'=>$data['we_app_web_view_url'],
			'url3'=>$data['we_app_web_view_url'],
      		'xcxewm'=>$gtxcximg,
      		'coupon_end_time'=>date('Y-m-d H:i:s',$data['goods_detail']['coupon_end_time']),
      	);
      	$msg=str_replace('#换行#','', $cfg['pddviewwenan']);
		$msg=str_replace('#名称#',"{$views['itemtitle']}", $msg);
		$msg=str_replace('#推荐理由#',"{$views['itemdesc']}", $msg);
		$msg=str_replace('#原价#',"{$views['itemprice']}", $msg);
		$msg=str_replace('#券后价#',"{$views['itemendprice']}", $msg);
		$msg=str_replace('#优惠券#',"{$views['couponmoney']}", $msg);
		$msg=str_replace('#网址#',"{$views['url2']}", $msg);
		$views['wenan']=$msg;	
		
	//	echo "<pre>";
	//print_r($views);
	//	exit;
//		
		include $this->template ( 'tbgoods/pdd/view' );
?>