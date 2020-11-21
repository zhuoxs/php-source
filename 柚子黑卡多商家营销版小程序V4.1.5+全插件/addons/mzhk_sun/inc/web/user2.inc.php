<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//判断积分插件是否存在
if(pdo_tableexists("mzhk_sun_plugin_scoretask_system")){
	$system=pdo_get('mzhk_sun_plugin_scoretask_system',array('uniacid'=>$_W['uniacid']));
	if($system['is_show']==1){
		$scoretask = 1;
	}
}

if($_GPC['op']=='edituser'){
	$viplist = pdo_getall('mzhk_sun_vip',array('uniacid'=>$_W['uniacid']));
	$info = pdo_get('mzhk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
	include $this->template('web/user_add');
	exit;
}elseif($_GPC['op']=='updateuser'){
	$id=intval($_GPC['id']);
    $data['viptype']=$_GPC['viptype'];
    $data['endtime']=strtotime($_GPC['endtime']);
    $data['telphone']=$_GPC['telphone'];
    $data['addtime']=time();
    $res = pdo_update('mzhk_sun_user', $data, array('id' => $id));
    if($res){
        message('修改成功',$this->createWebUrl('user2'),'success');
    }else{
        message('修改失败','','error');
    }
    
}

$where=" WHERE uniacid=:uniacid ";
$keyword = $_GPC["keywords"];
if(!empty($keyword)){
	$where .=" and name like'%".$keyword."%' ";
}
$isvip = $_GPC["isvip"];
if($isvip>0){
	if($isvip==1){
		$where .=" and viptype >1 ";
	}elseif($isvip==2){
		$where .=" and viptype = 0 ";
	}
}

$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select * from " . tablename("mzhk_sun_user") ." {$where} order by id desc ";

//导出
if($_GPC['op']=='exportorder'){
	$select_sql =$sql." ";

	$orderlist=pdo_fetchall($select_sql,$data);	

	
	$export_title_str = "id,openid,用户昵称,用户姓名,手机号码,余额,积分,vip级别,vip到期时间";
	
	$export_title = explode(',',$export_title_str);
	$export_list = array(); 
	$i=1;
	foreach ($orderlist as $k => $v){
		$viptype = pdo_get('mzhk_sun_vip',array('uniacid'=>$_W['uniacid'],'id'=>$v['viptype']));

		$export_list[$k]["k"] = $v["id"];
		$export_list[$k]["openid"] = $v["openid"];
		$export_list[$k]["name"] = $v["name"];
		$export_list[$k]["uname"] = $v["uname"];
		$export_list[$k]["telphone"] = $v["telphone"];
		$export_list[$k]["money"] = $v["money"];
		if($scoretask==1){
			$export_list[$k]["integral"] = $v["integral"];
		}
		$export_list[$k]["title"] = $viptype['title'];
		$export_list[$k]["endtime"] = date('Y-m-d',$v['endtime']);
		
		$i++;
	}
	$exporttitle = "会员列表";

	exportToExcel($exporttitle.'_'.date("YmdHis").'.csv',$export_title,$export_list);
	exit;
}

$total=pdo_fetchcolumn("select count(id) as wname from " . tablename("mzhk_sun_user") . " {$where} ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
//print_r($list);
$pager = pagination($total, $pageindex, $pagesize);

foreach ($list as $k=>$v){
    $data = pdo_get('mzhk_sun_vip',array('uniacid'=>$_W['uniacid'],'id'=>$v['viptype']));
    $list[$k]['title']=$data['title'];
    $list[$k]['endtime']=date('Y-m-d',$v['endtime']);
}

if($_GPC['op']=='delete'){
	$res4=pdo_delete("mzhk_sun_user",array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
	if($res4){
	 message('删除成功！', $this->createWebUrl('user2'), 'success');
	}else{
		  message('删除失败！','','error');
	}
}
if($_GPC['op']=='defriend'){

	$res = pdo_get('mzhk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
	if($res['isvisit']==1){
		$res4=pdo_update("mzhk_sun_user",array('isvisit'=>0),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
	}else{
		$res4=pdo_update("mzhk_sun_user",array('isvisit'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
	}
	
	
	if($res4){
		message('设置成功！', $this->createWebUrl('user2',array('page'=>$_GPC['page'])), 'success');
	}else{
		message('设置失败！','','error');
	}
}
if($_GPC['op']=='relieve'){
	$res4=pdo_update("mzhk_sun_user",array('state'=>1),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
	if($res4){
	 message('取消成功！', $this->createWebUrl('user2',array('page'=>$_GPC['page'])), 'success');
	}else{
		  message('取消失败！','','error');
	}
}



if($_GPC['op']=='modifymoney'){
	$id = $_GPC['id'];
	$money = $_GPC['money'];
	$user = pdo_get('mzhk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$id));
	$allmoney=$money+$user['money'];
	if($allmoney<0){
		echo 3; //减少金额大于所剩余额
	}else{
		$rmoney=pdo_update("mzhk_sun_user",array('money +='=>$money),array('uniacid'=>$_W['uniacid'],'id'=>$id));
		if($rmoney){
			$newData = [
				'openid'=>$user['openid'],
				'uniacid'=>$_W['uniacid'],
				'money'=>$money,
				'addtime'=>time(),
				'rtype'=>7,
				'memo'=>'后台修改'
			];
			$result=pdo_insert('mzhk_sun_rechargelogo',$newData);
			if($result){
				echo 1; //修改成功
			}else{
				echo 2; //修改失败
			}
		}else{
			echo 2; //修改失败
		}
	}
}

if($_GPC['op']=='modifyscoretask'){
	$id = $_GPC['id'];
	$scoretask = $_GPC['scoretask'];
	$user = pdo_get('mzhk_sun_user',array('uniacid'=>$_W['uniacid'],'id'=>$id));
	$allscoretask=$scoretask+$user['integral'];
	if($allscoretask<0){
		echo 3; //减少积分大于所剩积分
		exit;
	}else{
		$rintegral=pdo_update("mzhk_sun_user",array('integral +='=>$scoretask),array('uniacid'=>$_W['uniacid'],'id'=>$id));
		if($rintegral){
			if($scoretask>0){
				$sign = 1;
			}else{
				$sign = 2;
			}
			
			$newData = [
				'uniacid'=>$_W['uniacid'],
				'openid'=>$user['openid'],
				'type'=>17,
				'sign'=>$sign,
				'score'=>abs($scoretask),
				'date'=>date("Y-m-d",time()),
				'add_time'=>time(),
			];

			$result=pdo_insert('mzhk_sun_plugin_scoretask_taskrecord',$newData);
			if($result){
				echo 1; //修改成功
				exit;
			}else{
				echo 2; //修改失败
				exit;
			}
		}else{
			echo 2; //修改失败
			exit;
		}
	}
}

include $this->template('web/user2');