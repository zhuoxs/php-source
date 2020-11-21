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
		
		$usid=$member['id'];
		$subunionid=$_W['setting']['site']['key']."_".$_W['uniacid']."_".$usid;//订单跟单,站点ID——公众号ID——UID
		//echo $subunionid;
		$order=$this->jd1fgorder($subunionid,1);
		$list=array();
		foreach($order['data']['data'] as $k=>$v){
			$list[$k]['orderid']=$v['orderid'];
			$list[$k]['ordertime']=date("Y-m-d H:i:s",$v['ordertime']) ;
			$list[$k]['finishtime']=$v['finishtime'];
			$list[$k]['pid']=$v['pid'];
			$list[$k]['goods_id']=$v['goods_id'];
			$list[$k]['goods_name']=$v['goods_name'];
			$list[$k]['goods_num']=$v['goods_num'];
			$list[$k]['goods_frozennum']=$v['goods_frozennum'];
			$list[$k]['goods_returnnum']=$v['goods_returnnum'];
			$list[$k]['cosprice']=$v['cosprice'];
			$list[$k]['yn']=$v['yn'];
			$list[$k]['subunionid']=$v['subunionid'];
			$list[$k]['ynstatus']=$v['ynstatus'];
		}
// 		echo "<pre>";
// 		print_r($list);

       
       include $this->template ( 'tbgoods/jd/jdyfg/jdyfgorder' );
