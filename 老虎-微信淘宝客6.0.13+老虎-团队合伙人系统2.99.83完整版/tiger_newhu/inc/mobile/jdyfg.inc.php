<?php
global $_W, $_GPC;
		$page=$_GPC['page'];
		$cid=$_GPC['cid'];
		$uid=$_GPC['uid'];		
		$goods_id=$_GPC['goods_id'];
		if(empty($page)){
			$page=1;
		}		

    
        $cfg = $this->module['config'];
		
		if(empty($uid)){
			$fans = mc_oauth_userinfo();
			$mc=mc_fetch($fans['openid']);
			$member=$this->getmember($fans,$mc['uid']);  
		}else{
			$member=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
		}
		
		
		
		 
		
		$type=$this->jd1fgoufl();//分类
		
		if ($_W['isajax']){			
			$goodslit=$this->jd1fgougoodlist($page,$cid);//列表
			$pages=ceil($goodslit['data']['total']/10);
			exit(json_encode(array('pages' =>$pages, 'data' =>$goodslit['data']['data'])));
		}
		
		if(!empty($goods_id)){
			$usid=$member['id'];
			if(empty($usid)){
				$usid=0;
				message("用户ID不正确!", $this -> createMobileUrl('jdyfg', array('uid' => $uid,'page'=>$page,'cid'=>$cid)), 'error');
			}
			$subunionid=$_W['setting']['site']['key']."_".$_W['uniacid']."_".$usid;//订单跟单,站点ID——公众号ID——UID
			$goods=$this->jd1fgougoodurl($goods_id,$subunionid);
			// { "data": "https://u.jd.com/qXVLoU", "message": "success", "status_code": 200 }
			if(empty($goods['data'])){
				$msg=$goods['message'];//错误信息
				message($msg, $this -> createMobileUrl('jdyfg', array('uid' => $uid,'page'=>$page,'cid'=>$cid)), 'error');
			}else{
				$url=$goods['data'];//转链后URL
				header("Location:".$url); 
			}
		}
		
		
		

       
       include $this->template ( 'tbgoods/jd/jdyfg/yfg' );
