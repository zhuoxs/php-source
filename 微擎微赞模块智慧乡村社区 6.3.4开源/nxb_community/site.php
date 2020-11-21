<?php
/**
 * 社区系统模块微站定义
 *
 * @author peng
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Nxb_communityModuleSite extends WeModuleSite {

	 //控制开启是否全网调试
	protected function get_allnet(){
		global $_W,$_GPC;
		$config=$this->module['config'];
		if ($_W['container']!="wechat"){
   	 		if (!$config['all_net']){   	   			
	   			exit();
   	 		}
    	}
	}
	
	//获取基础设置
    protected function get_base(){
    	global $_W,$_GPC;
						
		$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_base')." WHERE weid=:uniacid",array(':uniacid'=>$_W['uniacid']));   		
		return $res;
	}
	
	//获取用户的mid
	protected function get_mid(){
    	global $_W,$_GPC;
		//所有页面都要引用这个方法，判断用户是否关注
		mc_oauth_userinfo();
		$mid=0;
		
		$member=$_W['fans'];
		$user=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND openid=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$member['openid']));
		
		if(empty($user)){
	
			$data = array(
				'weid'=>$_W['uniacid'],
				'openid'=>$member['openid'],
				'idcard'=>0,
				'grade'=>0,
				'userip'=>$_W['clientip'],
				'gag'=>0,
				'blacklist'=>0,
				'nickname'=>$member['tag']['nickname'],
				'realname'=>$member['tag']['nickname'],
				'tel'=>'',
				'address'=>'',
				'coid'=>0,
				'dong'=>0,
				'danyuan'=>0,
				'menpai'=>0,
				'avatar'=>$member['avatar'],
				'integral'=>'',
				'country'=>$member['tag']['country'],
				'province'=>$member['tag']['province'],
				'city'=>$member['tag']['city'],
				'createtime'=>time(),
			);
			$result = pdo_insert('bc_community_member', $data);
	
			if($result){
				$userinfo=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND openid=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$member['openid']));
		
				if(!empty($userinfo)){
					$mid=$userinfo['mid'];			
				}	
			}

		}else{
			$data = array(

				'nickname'=>$member['tag']['nickname'],
				'avatar'=>$member['avatar'],
			);
			$result = pdo_update('nx_zhvillage_member', $data,array('mid'=>$user['mid']));
	
			$mid=$user['mid'];
		}

		return $mid;
	}


	//获取用户信息
    protected function getmember(){
    	global $_W,$_GPC;
		$mid=$this->get_mid();		
		$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_member')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));   		
		return $res;
	}
	
	//获取商户信息
    protected function getseller(){
    	global $_W,$_GPC;
		$mid=$this->get_mid();		
		$res=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_seller')." WHERE weid=:uniacid AND mid=:mid",array(':uniacid'=>$_W['uniacid'],':mid'=>$mid));   		
		return $res;
	}
	
	
	
public function payResult($params) {
	
	global $_W,$_GPC;
	
	//一些业务代码
	//根据参数params中的result来判断支付是否成功
	if ($params['result'] == 'success' && $params['from'] == 'notify') {
		//此处会处理一些支付成功的业务代码
		$tid=$params['tid'];	
		//通过$params参数包中的值
			$tid=$params['tid'];
			$o=strstr($params['tid'],'_',TRUE);
			$oid=intval($o);			
			//修改订单的支付状态			
			$newdata = array(
				'postatus'=>1,
				'potime1'=>time(),
			);
			$result = pdo_update('bc_community_mall_orders', $newdata,array('id'=>$oid));
			//查询这条记录的详情
			$cz=pdo_fetch("SELECT a.*,b.ptitle FROM ".tablename('bc_community_mall_orders')." as a left join ".tablename('bc_community_mall_goods')." as b on a.pid=b.id WHERE a.weid=:uniacid AND a.id=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$oid));			
			if($cz){
				//写入一条钱包记录
				$data1 = array(
					'weid'=>$_W['uniacid'],
					'mid'=>$cz['mid'],
					'amount'=>$cz['orderprice'],
					'type'=>1,
					'status'=>1,
					'remark'=>'',
					'ctime'=>time(),
					'etime'=>0,
					'danyuan'=>$cz['danyuan'],
					'menpai'=>$cz['menpai'],
			 	);
				$res1 = pdo_insert('bc_community_mall_wallet', $data1);		
				
				//再写入一条给商家的消息记录
				$data = array(
					'weid'=>$_W['uniacid'],
					'mid'=>$cz['mid'],
					'usertype'=>2,
					'townid'=>$cz['danyuan'],
					'villageid'=>$cz['menpai'],
					'type'=>1,
					'title'=>'新订单已付款了',
					'content'=>'你的商品 '.$cz['ptitle'].' 又卖出'.$cz['pnum'].'件了,共收入了 '.$cz['orderprice'].'元。请尽快发货哦',
					'status'=>0,
					'ctime'=>time(),
			 	);
				$res = pdo_insert('bc_community_mall_messages', $data);		
				
				//改变商品库存数量
				$goods=pdo_fetch("SELECT * FROM ".tablename('bc_community_mall_goods')." WHERE id=:id",array(':id'=>$cz['pid']));	
				if($goods){
					$newnum=$goods['pyqty']+$cz['pnum'];
					$data2 = array(										
						'pyqty'=>$newnum,					
			 		);
					$res2 = pdo_update('bc_community_mall_goods', $data2,array('id'=>$cz['pid']));						
				}		
					
	
			}								
	}
	//因为支付完成通知有两种方式 notify，return,notify为后台通知,return为前台通知，需要给用户展示提示信息
	//return做为通知是不稳定的，用户很可能直接关闭页面，所以状态变更以notify为准
	//如果消息是用户直接返回（非通知），则提示一个付款成功
    //如果是JS版的支付此处的跳转则没有意义
	if ($params['from'] == 'return') {
		if ($params['result'] == 'success') {
				
			message('支付成功',$this->createMobileUrl('mall_myorders',array()),'success');
		} else {
			message('支付失败',$this->createMobileUrl('mall_myorders',array()),'error');
		}
	}
}
	
	
	
	
	
	
	
	
	
	
	
	

}