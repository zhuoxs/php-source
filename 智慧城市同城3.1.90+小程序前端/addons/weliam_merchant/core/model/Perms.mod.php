<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2020 http://www.weliam.cn All rights reserved.
// +----------------------------------------------------------------------
// | Describe: 
// +----------------------------------------------------------------------
// | Author: startingline<916345570@qq.com>
// +----------------------------------------------------------------------
class Perms{
	/** 
	* 获取所有功能 
	* 
	* @access public
	* @name allParms 
	* @return array 
	*/ 
	static function allParms(){
		$parms = array(
			'dashboard' => $this->permDashboard(),
			'store' => $this->permStore(),
			'member' => $this->permMember(),
			'area' => $this->permArea(),
			'app' => $this->permApp(),
			'setting' => $this->permSetting()
		);
	}
	
	protected function permDashboard(){
		$func = array(
			'text'	=>	"首页",
			'adv'	=>	array(
				'text'	=>	"幻灯片",
			),
			'nav'	=>	array(
				'text'	=>	"导航图标",
			),
			'banner'	=>	array(
				'text'	=>	"广告",
			),
			'sort'	=>	array(
				'text'	=>	"排版设置",
			),
			'notice'	=>	array(
				'text'	=>	"公告管理",
			),
			'cube'	=>	array(
				'text'	=>	"魔方设置",
			)
		);
		return $func;
	}
	
	protected function permStore(){
		$func = array(
			'text'	=>	"商户",
			'regiseter'	=>	array(
				'text'	=>	"入驻申请",
			),
			'user'	=>	array(
				'text'	=>	"商户管理",
			),
			'group'	=>	array(
				'text'	=>	"商户分组",
			),
			'category'	=>	array(
				'text'	=>	"商户分类",
			)
		);
		return $func;
	}
	
	protected function permMember(){
		$func = array(
			'text'	=>	"会员",
			'member'	=>	array(
				'text'	=>	"会员概况",
			),
			'list'	=>	array(
				'text'	=>	"会员管理",
			),
			'level'	=>	array(
				'text'	=>	"会员等级",
			),
			'group'	=>	array(
				'text'	=>	"会员分组",
			)
		);
		return $func;
	}
	
	protected function permArea(){
		$func = array(
			'text'	=>	"区域",
			'basic'	=>	array(
				'text'	=>	"区域概况",
			),
			'agent'	=>	array(
				'text'	=>	"代理管理",
			),
			'selfarea'	=>	array(
				'text'	=>	"自营地区",
			)
		);
		return $func;
	}
	
	protected function permApp(){
		$func = array(
			'text'	=>	"应用",
			'plugins'	=>	array(
				'text'	=>	"应用展示",
			)
		);
		return $func;
	}
	
	protected function permSetting(){
		$func = array(
			'text'	=>	"设置",
			'shopset'	=>	array(
				'text'	=>	"商城设置",
			),
			'payset'	=>	array(
				'text'	=>	"支付方式",
			),
			'noticeset'	=>	array(
				'text'	=>	"消息提醒",
			),
			'coverset'	=>	array(
				'text'	=>	"入口设置",
			)
		);
		return $func;
	}
	
	/** 
	* 获取角色权限 
	* 
	* @access public
	* @name getRolePerm 
	* @param $roleid  角色id 
	* @return array 
	*/  
	public function getRolePerms($roleid){
		global $_W;
		if(empty($roleid)) return array();
		$rolePerms = Util::getDateByCacheFirst('model','perms',array('Util','getSingleDataInSingleTable'),array('wlmerchant',array('uniacid'=>$_W['uniacid'],'id'=>$roleid)));
		return unserialize($rolePerms['perms']);
	}
} 
