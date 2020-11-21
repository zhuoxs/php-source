<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/rechargelogo";
$ty = array("直接充值","充值卡充值","购买会员卡","订单付款","订单退款","分销提现","购买优惠券","后台修改","线下付款",'微信支付购买会员卡','抽奖红包中奖','抽奖退款','礼物退款','礼物折现','云店提现');

if($_GPC['op']=='add'){
    $template = "web/rechargelogo";
}elseif($_GPC['op']=='save'){
    $id=intval($_GPC['id']);
    $data['title']=$_GPC['title'];
    $data['money']=$_GPC['money'];
    $data['lessmoney']=$_GPC['lessmoney'];
    $data['sort']=$_GPC['sort'];
    $data['addtime']=time();
    if($id==0){
        $data['uniacid']=$_W['uniacid'];
        $res=pdo_insert('mzhk_sun_rechargelogo',$data);
        if($res){
            message('添加成功',$this->createWebUrl('rechargelogo'),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_rechargelogo', $data, array('id' => $id));
        if($res){
            message('修改成功',$this->createWebUrl('rechargelogo'),'success');
        }else{
            message('修改失败','','error');
        }
    }
}elseif($_GPC['op']=='edit'){
    $id=intval($_GPC['id']);
    $info=pdo_get('mzhk_sun_rechargelogo',array('uniacid'=>$_W['uniacid'],'id'=>$id));

    $template = "web/rechargelogo";
}elseif($_GPC['op']=='delete'){
    die('erro');
	$res=pdo_delete('mzhk_sun_rechargelogo',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
    if($res){
        message('删除成功！', $this->createWebUrl('rechargelogo'), 'success');
    }else{
        message('删除失败！','','error');
    }
}elseif($_GPC['op']=='log' || $_GPC['op']=='exportorder2'){
    $where=" WHERE uniacid=".$_W['uniacid']." and rtype<2 ";

	if(!empty($_GPC['user_name'])){
		$user_name=$_GPC['user_name'];

		$usql = "select openid from " . tablename("mzhk_sun_user") ." where name like '%".$user_name."%' and uniacid=".$_W['uniacid']." ";
		$user = pdo_fetch($usql);
		$where.=" and openid LIKE '%".$user['openid']."%' ";
	}

    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $sql="select * from " . tablename("mzhk_sun_rechargelogo") ." ".$where." order by id desc ";
    
	//导出
	if($_GPC['op']=='exportorder2'){
		$select_sql =$sql." ";
		
		$orderlist=pdo_fetchall($select_sql,$data);	
		
		$export_title_str = "id,会员,充值金额(元),赠送金额(元),充值类型,备注";
		
		$export_title = explode(',',$export_title_str);
		$export_list = array(); 
		$i=1;
		foreach ($orderlist as $k => $v){
			$user = pdo_get("mzhk_sun_user",array("openid"=>$v["openid"]),array("name"));
			$export_list[$k]["k"] = $v["id"];
			$export_list[$k]["name"] = $user["name"];			
			$export_list[$k]["money"] =$v['money'];
			$export_list[$k]["addmoney"] =$v['addmoney'];
			$export_list[$k]["rtype"] = $ty[$v['rtype']]."\t";
			$export_list[$k]["memo"] = $v['memo'];
			$i++;
		}
		$exporttitle = "充值记录";

		exportToExcel($exporttitle.'_'.date("YmdHis").'.csv',$export_title,$export_list);
		exit;
	}
	
	$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_rechargelogo") . " " .$where." order by id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    foreach($list as $k => $v){
        $user = pdo_get("mzhk_sun_user",array("openid"=>$v["openid"]),array("name","img"));
        $list[$k]["name"] = $user["name"];
        $list[$k]["img"] = $user["img"];
    }
    $pager = pagination($total, $pageindex, $pagesize);

}else{
    
    $where=" WHERE uniacid=".$_W['uniacid']." and rtype>1 ";

	if(!empty($_GPC['user_name'])){
		$user_name=$_GPC['user_name'];

		$usql = "select openid from " . tablename("mzhk_sun_user") ." where name like '%".$user_name."%' and uniacid=".$_W['uniacid']." ";
		$user = pdo_fetch($usql);
		$where.=" and openid LIKE '%".$user['openid']."%' ";
	}
    
	
	$pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;


    $sql="select * from " . tablename("mzhk_sun_rechargelogo") ." ".$where." order by id desc ";
    
	//导出
	if($_GPC['op']=='exportorder'){
		$select_sql =$sql." ";

		
		$orderlist=pdo_fetchall($select_sql,$data);	
		
				
		$export_title_str = "id,会员,增加金额(元),减少金额(元),类型,备注";
		
		$export_title = explode(',',$export_title_str);
		$export_list = array(); 
		$i=1;
		foreach ($orderlist as $k => $v){
			$user = pdo_get("mzhk_sun_user",array("openid"=>$v["openid"]),array("name"));

			$export_list[$k]["k"] = $v["id"];
			$export_list[$k]["name"] = $user["name"];
			

			if($v['rtype'] == 4 || $v['rtype'] == 5 || ($v['rtype'] == 7 && $v['money'] > 0) || ($v['rtype'] == 9 && $v['money'] > 0)|| $v['rtype'] == 10 || $v['rtype'] == 11 || $v['rtype'] == 12 || $v['rtype'] == 13){
				$export_list[$k]["amoney"] =$v['money'];
			}else{
				$export_list[$k]["amoney"] =0;
			}

			if($v['rtype'] < 4 || $v['rtype'] == 6  || ($v['rtype'] == 7 && $v['money']<0) || $v['rtype'] == 8){
				$export_list[$k]["dmoney"] =abs($v['money']);
			}else{
				$export_list[$k]["dmoney"] =0;
			}

			
			$export_list[$k]["rtype"] = $ty[$v['rtype']]."\t";
			$export_list[$k]["memo"] = $v['memo'];
			$i++;
		}
		$exporttitle = "会员明细";

		exportToExcel($exporttitle.'_'.date("YmdHis").'.csv',$export_title,$export_list);
		exit;
	}


	$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("mzhk_sun_rechargelogo") . " " .$where." order by id desc ",$data);
    
	
	$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    foreach($list as $k => $v){
        $user = pdo_get("mzhk_sun_user",array("openid"=>$v["openid"]),array("name","img"));
        $list[$k]["name"] = $user["name"];
        $list[$k]["img"] = $user["img"];
    }
    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template($template);