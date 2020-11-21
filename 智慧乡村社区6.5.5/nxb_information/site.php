<?php
/**
 * 智慧牧场模块微站定义
 *
 * @author 赤那网络
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class nxb_informationModuleSite extends WeModuleSite {

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
						
		$res=pdo_fetch("SELECT * FROM ".tablename('nx_information_base')." WHERE weid=:uniacid",array(':uniacid'=>$_W['uniacid']));   		
		return $res;
	}
	
	//获取用户的mid
	protected function get_mid(){
    	global $_W,$_GPC;
		$mid=0;
		$member=$_W['fans'];
		$user=pdo_fetch("SELECT * FROM ".tablename('nx_information_member')." WHERE weid=:uniacid AND openid=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$member['openid']));
		
		if(empty($user)){
			
			$data = array(
				'weid'=>$_W['uniacid'],
				'openid'=>$member['openid'],
				'idcard'=>'',
				'grade'=>0,
				'nickname'=>$member['tag']['nickname'],
				'avatar'=>$member['tag']['avatar'],
				'realname'=>'',
				'tel'=>'',
				'address'=>'',
				'country'=>1,
				'province'=>1,
				'city'=>1,
				'createtime'=>time(),
			);
			$result = pdo_insert('nx_information_member', $data);
	
			if(!empty($result)){
				$mid = pdo_insertid();				
			}

		}else{
	
			$mid=$user['mid'];
		}

		return $mid;
	}


}