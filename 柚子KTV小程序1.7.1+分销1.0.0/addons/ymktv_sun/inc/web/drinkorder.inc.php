<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type = isset($_GPC['status'])?$_GPC['status']:2;
$build_id = isset($_GPC['build'])?$_GPC['build']:-1;
$build = pdo_getall('ymktv_sun_building',array('uniacid'=>$_W['uniacid']));

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

//p($servies);die;
if($_GPC['op']=='build'){
    $build_id = $_GPC['build'];
    if($build_id==-1){
        $sql = ' SELECT * FROM ' .tablename('ymktv_sun_order') . ' WHERE ' . ' uniacid='.$_W['uniacid'] . ' ORDER BY pay_time DESC';
        $total = pdo_fetchcolumn(' SELECT count(*) FROM ' .tablename('ymktv_sun_order') . ' WHERE ' . ' uniacid='.$_W['uniacid'] . ' ORDER BY pay_time DESC');
    }else{
        $sql = ' SELECT * FROM ' .tablename('ymktv_sun_order') . ' WHERE ' . ' uniacid='.$_W['uniacid'] . ' AND ' . ' build_id='.$build_id . ' ORDER BY pay_time DESC';
        $total = pdo_fetchcolumn(' SELECT count(*) FROM ' .tablename('ymktv_sun_order') . ' WHERE ' . ' uniacid='.$_W['uniacid'] . ' AND ' . ' build_id='.$build_id . ' ORDER BY pay_time DESC');
    }
}elseif($_GPC['op']=='status'){
    $type = $_GPC['status'];
    $build_id = 0;
    $sql = ' SELECT * FROM ' .tablename('ymktv_sun_order') . ' WHERE ' . ' status='.$type . ' ORDER BY pay_time DESC';
    $total = pdo_fetchcolumn(' SELECT count(*) FROM ' .tablename('ymktv_sun_order') . ' WHERE ' . ' status='.$_GPC['status'] . ' ORDER BY pay_time DESC');
}elseif($_GPC['op']=='search' && $_GPC['keywords']){
	if($_GPC['keywords']){
					
		$sql = " SELECT * FROM " .tablename('ymktv_sun_order') . " WHERE " . " uniacid=".$_W['uniacid'] . " and order_num like '%".$_GPC['keywords']."%' ORDER BY pay_time DESC";
		$total = pdo_fetchcolumn("SELECT count(*) FROM " .tablename('ymktv_sun_order') . " WHERE " . " uniacid=".$_W['uniacid'] . " and order_num like '%".$_GPC['keywords']."%' ORDER BY pay_time DESC");
	}
}elseif($_GPC['op']=='changeroom'){
	$res=pdo_update('ymktv_sun_order',array('sid'=>$_GPC['sid']),array('id'=>$_GPC['id']));
    if($res){
        message('更换成功',$this->createWebUrl('drinkorder',array()),'success');
    }else{
        message('更换失败','','error');
    }
}else{
    $sql = ' SELECT * FROM ' .tablename('ymktv_sun_order') . ' WHERE ' . ' uniacid='.$_W['uniacid'] . ' ORDER BY pay_time DESC';
    $total = pdo_fetchcolumn('SELECT count(*) FROM ' .tablename('ymktv_sun_order') . ' WHERE ' . ' uniacid='.$_W['uniacid'] . ' ORDER BY pay_time DESC');
}
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$order = pdo_fetchall($select_sql);
$pager = pagination($total, $pageindex, $pagesize);

// 获取服务数据
$servies = pdo_getall('ymktv_sun_servies',array('uniacid'=>$_W['uniacid']));
foreach ($order as $k=>$v){
    foreach ($servies as $kk=>$vv){
        if($order[$k]['build_id']==$vv['b_id']){
            $order[$k]['servies'][] = $vv;
        }
    }
	foreach($build as $k2=>$v2){
		if($v2['id']==$v['build_id']){
			$order[$k]['b_name']=$v2['b_name'];
		}
	}
}

foreach ($order as $k=>$v){
    $order[$k]['good_name'] = explode(',',$v['good_name']);
    $order[$k]['good_num'] = explode(',',$v['good_num']);
}
//p($order);die;
if($_GPC['op'] == 'delete'){
    $res = pdo_delete('ymktv_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('drinkorder'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
/*if($_GPC['keywords']){
    $order = pdo_getall('ymktv_sun_order',array('uniacid'=>$_W['uniacid'],'order_num like'=>'%'.$_GPC['keywords'].'%'),'','','pay_time DESC');
    foreach ($order as $k=>$v){
        $order[$k]['good_name'] = explode(',',$v['good_name']);
        $order[$k]['good_num'] = explode(',',$v['good_num']);
    }
}*/
if($_GPC['op']=='delivery'){
    $res=pdo_update('ymktv_sun_order',array('status'=>1),array('id'=>$_GPC['id']));
    if($res){
		/*======分销使用====== */
		include_once IA_ROOT . '/addons/ymktv_sun/inc/func/distribution.php';
		$distribution = new Distribution();
		$distribution->order_id = $_GPC['id'];
		$distribution->ordertype = 2;
		$distribution->settlecommission();
		/*======分销使用======*/
        message('操作成功',$this->createWebUrl('drinkorder',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('ymktv_sun_order',array('status'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('drinkorder',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
/*if($_GPC['submit']){
//    p($_GPC);die;
    $res=pdo_update('ymktv_sun_order',array('sid'=>$_GPC['sid']),array('id'=>$_GPC['id']));
    if($res){
        message('更换成功',$this->createWebUrl('drinkorder',array()),'success');
    }else{
        message('更换失败','','error');
    }
}*/


//p($order);die;
include $this->template('web/drinkorder');