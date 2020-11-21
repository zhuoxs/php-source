<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$account = cache_load('account:gicai_fwyzm_'.$_GPC['fid'].'_'.$_W['uniacid']);
if(!$account){
	$form_s	= "SELECT * FROM " .tablename('gicai_fwyzm')."WHERE `id`=:id and `uniacid`=:uniacid";
	$form_p	= array(':id'=>$_GPC['fid'],':uniacid'=>$_W['uniacid']);
	$account = pdo_fetch($form_s,$form_p);
	cache_write('account:gicai_fwyzm_'.$_GPC['fid'].'_'.$_W['uniacid'],$account);
}
if($form_d['redjie']>0){
	if($_W['openid']=='' && $_COOKIE['cookie_openid_'.$_GPC['fid']]!=''){
		$_W['openid']	= $_COOKIE['cookie_openid_'.$_GPC['fid']];
		$_W['oauthid']	= $_COOKIE['cookie_openid_'.$_GPC['fid']];	
	}	
}
if(strstr($account['admins'],$_W['openid'])){
	switch($_GPC['mo']) {
	case 'p':
		$sql_datalog = "SELECT * FROM " .tablename('gicai_fwyzm_prize_log')."WHERE `id`=:id and `uniacid`=:uniacid and `xu`=:xu";
		$params_datalog = array(':id'=>$_GPC['id'],':uniacid'=>$_W['uniacid'],':xu'=>'0');
		$datalog = pdo_fetch($sql_datalog,$params_datalog);
		if($datalog){
			include $this->template('default/admin/admintps');
		}else{
			$query['result']	= '-10000';
			$query['messages']	= '未查询到信息！';
			echo json_encode($query);
		}
		break;
	case 'l':
		$where 	= ' WHERE uniacid=:uniacid and fid=:fid and admin=:admin and state=:state';
		$params = array(
			':uniacid'=>$_W['uniacid'],
			':fid'=>$_GPC['fid'],
			':admin'=>$_W['openid'],
			':state'=>'0'
		);
		if($_GPC['starttime']!='' && $_GPC['endtime']!=''){
			$start = strtotime(date($_GPC['starttime'].' 00:00:00'));
			$end = strtotime(date($_GPC['endtime'].' H:i:s'));
			$where = $where.' and `audittime`>=:start and `audittime`<=:end';
			$params[':start']	=	$start;
			$params[':end']		=	$end;
		}
		
		$countsql 	= 'SELECT COUNT(*) FROM '.tablename('gicai_fwyzm_prize_log').$where;
		$total 		= pdo_fetchcolumn($countsql, $params);
		$pageindex 	= max(intval($_GPC['page']), 1); // 当前页码
		$pagesize 	= 20; // 设置分页大小
		$pager 		= pagination($total, $pageindex, $pagesize);
		$sql 		= "SELECT * FROM ".tablename('gicai_fwyzm_prize_log').$where." ORDER BY id desc LIMIT ".(($pageindex -1) * $pagesize).",". $pagesize;
		$list 		= pdo_fetchall($sql,$params);
	
		include $this->template('default/admin/adminlist');
		break;
	default:
		if($_GPC['jpid']!=''){
			$sql_datalog = "SELECT * FROM " .tablename('gicai_fwyzm_prize_log')."WHERE `id`=:id and `fid`=:fid and `uniacid`=:uniacid";
			$params_datalog = array(':id'=>$_GPC['jpid'],':fid'=>$_GPC['fid'],':uniacid'=>$_W['uniacid']);
			$datalog = pdo_fetch($sql_datalog,$params_datalog);
		}
		include $this->template('default/admin/admin');
		break;
	}
}else{
	echo "<div style='width:300px;margin:auto;position:relative;text-align:center;'><img src=".mobileurls($this->createmobileUrl('qr',array('url'=>mobileurls($this->createmobileUrl('admin',array('fid'=>$_GPC['fid'])),'app'))),'app')." /><p>请用管理员的微信浏览器打开！</p></div>";
}

