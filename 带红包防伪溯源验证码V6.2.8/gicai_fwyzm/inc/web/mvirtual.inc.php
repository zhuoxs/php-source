<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
 
load()->func('tpl'); 
switch($_GPC['mo']) {
	case 'add_data':
		$ar = $this->import('inputExcel');
		 
			foreach ($ar as $key=>$row) {
				$datav['vid']			=	$_GPC['id'];
				$datav['uniacid']		=	$_W['uniacid'];
				$datav['code']			=	$row[0];
				$datav['openid']		=	'';
				$datav['state']			=	'1'; 
				$datav['data']			=	$row[1];
				$datav['addtime']		=	time();
				pdo_insert('gicai_fwyzm_virtual_data',$datav);
			 
			}
			message('导入成功！',$this->createWebUrl('mvirtual',array('id'=>$_GPC['id'],'mo'=>'data','fid'=>$_GPC['fid'])),'success');
		 
		 
	case 'data':
		$where 	= ' WHERE vid=:vid and uniacid=:uniacid';
		$params = array(
			'vid'=>$_GPC['id'],
			':uniacid'=>$_W['uniacid']
		);
		 
		$countsql 	= 'SELECT COUNT(*) FROM '.tablename('gicai_fwyzm_virtual_data').$where;
		$total 		= pdo_fetchcolumn($countsql, $params);
		$pageindex 	= max(intval($_GPC['page']), 1); // 当前页码
		$pagesize 	= 20; // 设置分页大小
		$pager 		= pagination($total, $pageindex, $pagesize);
		$sql 		= "SELECT * FROM ".tablename('gicai_fwyzm_virtual_data').$where." ORDER BY id desc LIMIT ".(($pageindex -1) * $pagesize).",". $pagesize;
		$account	= pdo_fetchall($sql,$params);
		include $this->template('virtual_data');
		break;
	case 'add':
		if(checksubmit()){
			 
			$data['uniacid']		=	$_W['uniacid'];
			$data['fid']			=	$_GPC['fid'];
			$data['title']			=	$_GPC['data']['title'];	
			$data['url']			=	$_GPC['data']['url'];	
			$data['description']	=	$_GPC['data']['description'];
			$data['content']		=	$_GPC['data']['content'];
			$data['state']			=	$_GPC['data']['state'];
			$data['addtime']		=	time();	
			$account = pdo_insert('gicai_fwyzm_virtual',$data);
			 
			if($account){
				message('添加成功！',$this->createWebUrl('mvirtual',array('mo'=>'add','fid'=>$_GPC['fid'])),'success');
			}else{
				message('添加失败！','','error');
			}
		} 
		include $this->template('virtual_add');
		break;
	case 'edit':
		if(checksubmit()){
			$data['fid']			=	$_GPC['fid'];
			$data['title']			=	$_GPC['data']['title'];	
			$data['url']			=	$_GPC['data']['url'];	
			$data['description']	=	$_GPC['data']['description'];
			$data['content']		=	$_GPC['data']['content'];
			$data['state']			=	$_GPC['data']['state'];
			$account = pdo_update('gicai_fwyzm_virtual',$data, array('id'=>$_GPC['id'],'fid'=>$_GPC['fid'],'uniacid'=>$_W['uniacid']));
			if($account){
				message('修改成功！',$this->createWebUrl('mvirtual',array('mo'=>'edit','id'=>$_GPC['id'],'fid'=>$_GPC['fid'])),'success');
			}else{
				message('修改失败！','','error');
			}
		}else{
			$sql = "SELECT * FROM " .tablename('gicai_fwyzm_virtual')."WHERE `id`=:id and `uniacid`=:uniacid";
			$params = array('id'=>$_GPC['id'],':uniacid'=>$_W['uniacid']);
			$account = pdo_fetch($sql,$params);
		}
		include $this->template('virtual_edit');
		break;
	default:
		 
	 
		$where 	= ' WHERE uniacid=:uniacid and fid=:fid';
		$params = array(
			':uniacid'=>$_W['uniacid'],
			':fid'=>$_GPC['fid']
		);
		 
		$countsql 	= 'SELECT COUNT(*) FROM '.tablename('gicai_fwyzm_virtual').$where;
		$total 		= pdo_fetchcolumn($countsql, $params);
		$pageindex 	= max(intval($_GPC['page']), 1); // 当前页码
		$pagesize 	= 20; // 设置分页大小
		$pager 		= pagination($total, $pageindex, $pagesize);
		$sql 		= "SELECT * FROM ".tablename('gicai_fwyzm_virtual').$where." ORDER BY id desc LIMIT ".(($pageindex -1) * $pagesize).",". $pagesize;
		$account	= pdo_fetchall($sql,$params);
		include $this->template('virtual_list');
}


















