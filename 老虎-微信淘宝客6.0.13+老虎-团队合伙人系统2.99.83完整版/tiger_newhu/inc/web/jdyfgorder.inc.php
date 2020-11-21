<?php
global $_W, $_GPC;

$order=$_GPC['orderid'];
$dj=$_GPC['dj'];
$name=$_GPC['name'];
$uid=$_GPC['uid'];
$op=$_GPC['op'];
$page=$_GPC['page'];
$id=$_GPC['id'];


if($op=="js"){
	$res= pdo_update($this->modulename."_jdyfgorder", array('sh'=>1), array('weid'=>$_W['uniacid'],'id' =>$id));
	if(!empty($res)){
		 $this->mc_jl($uid,1,15,9.89,'京东1分购返'.$order,$order);
		 message('返款成功', $this->createWebUrl('jdyfgorder'), 'success');
	}else{
		message('返款失败', $this->createWebUrl('jdyfgorder'), 'error');
	}
}

if($op=="jdyfgtbdd"){//同步订单
	
	if(empty($page)){
		$page=1;
	}
	$setkey=$_W['setting']['site']['key'];
	$order=$this->jd1fgorder("",$page);
	if(empty($order['data']['data'])){
		 message('温馨提示：采集任务已完成！', $this->createWebUrl('jdyfgorder'), 'success');
	}else{
		$pagesum=intval($order['data']['total']/50)+1 ;
		
		$list=array();
		foreach($order['data']['data'] as $k=>$v){
			$pidS=explode('_',$v['subunionid']);
			$list['weid']=$pidS[1];
			$list['uid']=$pidS[2];
			$list['orderid']=$v['orderid'];
			$list['ordertime']=$v['ordertime'];
			$list['finishtime']=$v['finishtime'];
			$list['pid']=$v['pid'];
			$list['goods_id']=$v['goods_id'];
			$list['goods_name']=$v['goods_name'];
			$list['goods_num']=$v['goods_num'];
			$list['goods_frozennum']=$v['goods_frozennum'];
			$list['goods_returnnum']=$v['goods_returnnum'];
			$list['cosprice']=$v['cosprice'];
			$list['yn']=$v['yn'];
			$list['subunionid']=$v['subunionid'];
			$list['ynstatus']=$v['ynstatus'];
			$list['createtime']=time();
			//echo $v['subunionid'];
			//echo $setkey."---".$pidS[0];
			 if($setkey==$pidS[0]){
				 
				  $go = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_jdyfgorder") . " WHERE weid = '{$_W['uniacid']}' and  orderid={$v['orderid']} ");
			 	if(empty($go)){
			 	  pdo_insert($this->modulename."_jdyfgorder",$list);
			 	}else{
			 	  pdo_update($this->modulename."_jdyfgorder", $list, array('weid'=>$_W['uniacid'],'orderid' => $v['orderid']));
			 	}  
			 }
		}
		if($page<=$pagesum){
						 message('温馨提示：请不要关闭页面，订单同步中！（' . $page . '/' . $pagesum . '）', $this->createWebUrl('jdyfgorder', array('op' => 'jdyfgtbdd','page' => $page + 1)), 'error');
		}else{
						 message('温馨提示：采集任务已完成！（' . $page . '/' . $total . '）', $this->createWebUrl('jdyfgorder'), 'success');
		}
	}
	exit;
}


if (!empty($order)){
  $where .= " and orderid ='{$order}'";
}
if (!empty($uid)){
  $whereuid .= " and uid={$uid}";
}
echo $where;

$page=$_GPC['page'];

 $cfg = $this->module['config'];
        $pindex = max(1, intval($page));
		$psize = 20;
		$list = pdo_fetchall("select * from ".tablename($this->modulename."_jdyfgorder")." where weid='{$_W['uniacid']}' {$where} {$whereuid} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_jdyfgorder')." where weid='{$_W['uniacid']}' {$where} {$whereuid}");
		$pager = pagination($total, $pindex, $psize);
		
		
        include $this->template ( 'jdyfgorder' );