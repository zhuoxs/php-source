<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
load()->func('tpl'); 
switch($_GPC['mo']) {
	case 'data_edit':
		$diyclass	= pdo_get('gicai_fwyzm_diyclass',array('id'=>$_GPC['cid'],'uniacid'=>$_W['uniacid']));
		$diyclass['dengji']	= iunserializer($diyclass['dengji']);
		if(checksubmit()){
		 
			$data['note']			=	$_GPC['data']['note']; 
			$data['state']			=	$_GPC['data']['state'];
			 
			$account = pdo_update('gicai_fwyzm_diydata',$data, array('id'=>$_GPC['id'],'fid'=>$_GPC['fid'],'uniacid'=>$_W['uniacid']));
			if($account){
				message('修改成功！',$this->createWebUrl('mdiydata',array('mo'=>'data_list','id'=>$_GPC['cid'],'fid'=>$_GPC['fid'])),'success');
			}else{
				message('修改失败！','','error');
			}
		}else{
			
			$sql = "SELECT * FROM " .tablename('gicai_fwyzm_diydata')."WHERE `id`=:id and `uniacid`=:uniacid";
			$params = array('id'=>$_GPC['id'],':uniacid'=>$_W['uniacid']);
			$account = pdo_fetch($sql,$params);
			
			$account['dengji']	= iunserializer($account['dengji']);
		 	 
			$dengjicount	= count($account['dengji'])+1;
		}
		include $this->template('diydata_edit');
		break;
	case 'data_list':
		$where 	= ' WHERE uniacid=:uniacid and fid=:fid';
		$params = array(
			':uniacid'=>$_W['uniacid'],
			':fid'=>$_GPC['fid']
		);
		 
		$countsql 	= 'SELECT COUNT(*) FROM '.tablename('gicai_fwyzm_diydata').$where;
		$total 		= pdo_fetchcolumn($countsql, $params);
		$pageindex 	= max(intval($_GPC['page']), 1); // 当前页码
		$pagesize 	= 20; // 设置分页大小
		$pager 		= pagination($total, $pageindex, $pagesize);
		$sql 		= "SELECT * FROM ".tablename('gicai_fwyzm_diydata').$where." ORDER BY id desc LIMIT ".(($pageindex -1) * $pagesize).",". $pagesize;
		$account	= pdo_fetchall($sql,$params);
		include $this->template('diydata_list');
		break;
	case 'add':
		if(checksubmit()){
			 
			$data['uniacid']		=	$_W['uniacid'];
			$data['fid']			=	$_GPC['fid'];
			$data['title']			=	$_GPC['data']['title'];	
			$data['description']	=	$_GPC['data']['description'];
			$data['admins']			=	$_GPC['data']['admins'];
			$data['guanlian']		=	$_GPC['data']['guanlian'];
			 
			foreach ($_GPC['data']['dengji'] as $key => $value) {
				$dengji[]=$value;
		  	}
			$last_names = array_column($dengji,'fieldpx');
			array_multisort($last_names,SORT_ASC,$dengji);
		  	$data['dengji']			=	iserializer($dengji); 
			$data['state']			=	$_GPC['data']['state'];
			$data['addtime']		=	time();	
			$account = pdo_insert('gicai_fwyzm_diyclass',$data);
			 
			if($account){
				message('添加成功！',$this->createWebUrl('mdiydata',array('mo'=>'mdiydata','fid'=>$_GPC['fid'])),'success');
			}else{
				message('添加失败！','','error');
			}
		} 
		if($account['dengji']=='0' || $account['dengji']==''){
			$account['dengji'] = 'a:8:{i:0;a:5:{s:7:"fieldpx";s:1:"1";s:7:"fieldlx";s:4:"text";s:8:"fieldzdm";s:4:"name";s:9:"fieldname";s:6:"姓名";s:8:"fieldatt";s:18:"请输入姓名！";}i:1;a:5:{s:7:"fieldpx";s:1:"2";s:7:"fieldlx";s:3:"tel";s:8:"fieldzdm";s:3:"tel";s:9:"fieldname";s:6:"电话";s:8:"fieldatt";s:18:"请输入电话！";}i:2;a:5:{s:7:"fieldpx";s:1:"3";s:7:"fieldlx";s:6:"select";s:8:"fieldzdm";s:5:"xiala";s:9:"fieldname";s:6:"公司";s:8:"fieldatt";s:17:"欧波同||朗铎";}i:3;a:5:{s:7:"fieldpx";s:1:"4";s:7:"fieldlx";s:5:"radio";s:8:"fieldzdm";s:7:"xingbie";s:9:"fieldname";s:6:"性别";s:8:"fieldatt";s:8:"男||女";}i:4;a:5:{s:7:"fieldpx";s:1:"5";s:7:"fieldlx";s:8:"checkbox";s:8:"fieldzdm";s:7:"duoxuan";s:9:"fieldname";s:6:"爱好";s:8:"fieldatt";s:38:"唱歌||跳舞||看书||游戏||打泡";}i:5;a:5:{s:7:"fieldpx";s:1:"6";s:7:"fieldlx";s:6:"images";s:8:"fieldzdm";s:6:"images";s:9:"fieldname";s:6:"图片";s:8:"fieldatt";s:18:"请上传图片！";}i:6;a:5:{s:7:"fieldpx";s:1:"7";s:7:"fieldlx";s:7:"address";s:8:"fieldzdm";s:3:"diq";s:9:"fieldname";s:6:"地区";s:8:"fieldatt";s:18:"请输入地区！";}i:7;a:5:{s:7:"fieldpx";s:1:"8";s:7:"fieldlx";s:8:"textarea";s:8:"fieldzdm";s:4:"xxdd";s:9:"fieldname";s:6:"地址";s:8:"fieldatt";s:15:"详细地址！";}}';
			$dengji	= iunserializer($account['dengji']);
		} 
		
		include $this->template('diyclass_add');
		break;
	case 'edit':
		if(checksubmit()){
		 
			$data['fid']			=	$_GPC['fid'];
			$data['title']			=	$_GPC['data']['title'];	
			$data['description']	=	$_GPC['data']['description'];
			$data['admins']			=	$_GPC['data']['admins'];
			$data['guanlian']		=	$_GPC['data']['guanlian'];
			foreach ($_GPC['data']['dengji'] as $key => $value) {
				$dengji[]=$value;
		  	}
			$last_names = array_column($dengji,'fieldpx');
			array_multisort($last_names,SORT_ASC,$dengji);
		  	$data['dengji']			=	iserializer($dengji); 
			$data['state']			=	$_GPC['data']['state'];
			 
			 
			
			$account = pdo_update('gicai_fwyzm_diyclass',$data, array('id'=>$_GPC['id'],'fid'=>$_GPC['fid'],'uniacid'=>$_W['uniacid']));
			if($account){
				message('修改成功！',$this->createWebUrl('mdiydata',array('mo'=>'edit','id'=>$_GPC['id'],'fid'=>$_GPC['fid'])),'success');
			}else{
				message('修改失败！','','error');
			}
		}else{
			$sql = "SELECT * FROM " .tablename('gicai_fwyzm_diyclass')."WHERE `id`=:id and `uniacid`=:uniacid";
			$params = array('id'=>$_GPC['id'],':uniacid'=>$_W['uniacid']);
			$account = pdo_fetch($sql,$params);
			
			 
			
			$dengji	= iunserializer($account['dengji']);
			$dengjicount	= count($dengji)+1;
		}
		include $this->template('diyclass_edit');
		break;
	default:
		 
	 
		$where 	= ' WHERE uniacid=:uniacid and fid=:fid';
		$params = array(
			':uniacid'=>$_W['uniacid'],
			':fid'=>$_GPC['fid']
		);
		 
		$countsql 	= 'SELECT COUNT(*) FROM '.tablename('gicai_fwyzm_diyclass').$where;
		$total 		= pdo_fetchcolumn($countsql, $params);
		$pageindex 	= max(intval($_GPC['page']), 1); // 当前页码
		$pagesize 	= 20; // 设置分页大小
		$pager 		= pagination($total, $pageindex, $pagesize);
		$sql 		= "SELECT * FROM ".tablename('gicai_fwyzm_diyclass').$where." ORDER BY id desc LIMIT ".(($pageindex -1) * $pagesize).",". $pagesize;
		$account	= pdo_fetchall($sql,$params);
		include $this->template('diyclass_list');
}


















