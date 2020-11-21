<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where = " WHERE  a.uniacid=".$_W['uniacid'] . ' and b.type=2';
if(!empty($_GPC['keywords'])){
    $op=$_GPC['keywords'];
    $where.=" and b.orderNum LIKE  '%$op%'";
    $data[':name']=$op;
}
// 门店数据
$build = pdo_getall('ymktv_sun_building',array('uniacid'=>$_W['uniacid']));
$servies = pdo_getall('ymktv_sun_servies',array('uniacid'=>$_W['uniacid']));

$state=$_GPC['state'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$type = isset($_GPC['status'])?$_GPC['status']:2;
$build_id = isset($_GPC['build'])?$_GPC['build']:-1;
// $data[':uniacid']=$_W['uniacid'];
if($_GPC['op']=='build'){
    $build_id = $_GPC['build'];
    if($build_id==-1){
        $sql = ' SELECT * FROM ' . tablename('ymktv_sun_new_bargain') . ' nb ' . ' JOIN ' . tablename('ymktv_sun_kjorder') . ' kj ' . ' ON ' . ' kj.gid=nb.id'. ' WHERE ' . ' kj.uniacid='.$_W['uniacid'] . ' ORDER BY ' . ' kj.time DESC';
        $total = pdo_fetchcolumn(' SELECT count(*) FROM ' . tablename('ymktv_sun_new_bargain') . ' nb ' . ' JOIN ' . tablename('ymktv_sun_kjorder') . ' kj ' . ' ON ' . ' kj.gid=nb.id'. ' WHERE ' . ' kj.uniacid='.$_W['uniacid'] . ' ORDER BY ' . ' kj.time DESC');
    }else{
        $sql = ' SELECT * FROM ' . tablename('ymktv_sun_new_bargain') . ' nb ' . ' JOIN ' . tablename('ymktv_sun_kjorder') . ' kj ' . ' ON ' . ' kj.gid=nb.id'. ' WHERE ' . ' kj.uniacid='.$_W['uniacid'] . ' AND ' . ' kj.build_id=' . $build_id . ' ORDER BY ' . ' kj.time DESC';
        $total = pdo_fetchcolumn(' SELECT count(*) FROM ' . tablename('ymktv_sun_new_bargain') . ' nb ' . ' JOIN ' . tablename('ymktv_sun_kjorder') . ' kj ' . ' ON ' . ' kj.gid=nb.id'. ' WHERE ' . ' kj.uniacid='.$_W['uniacid'] . ' AND ' . ' kj.build_id=' . $build_id . ' ORDER BY ' . ' kj.time DESC');
    }
//    p($lits);die;
}elseif($_GPC['op']=='state'){
    $type = $_GPC['state'];
    $build_id = 0;
    $sql = ' SELECT * FROM ' . tablename('ymktv_sun_new_bargain') . ' nb ' . ' JOIN ' . tablename('ymktv_sun_kjorder') . ' kj ' . ' ON ' . ' kj.gid=nb.id'. ' WHERE ' . ' kj.uniacid='.$_W['uniacid'] . ' AND' . ' kj.state='. $type . ' ORDER BY ' . ' kj.time DESC';
    $total = pdo_fetchcolumn(' SELECT count(*) FROM ' . tablename('ymktv_sun_new_bargain') . ' nb ' . ' JOIN ' . tablename('ymktv_sun_kjorder') . ' kj ' . ' ON ' . ' kj.gid=nb.id'. ' WHERE ' . ' kj.uniacid='.$_W['uniacid'] . ' AND' . ' kj.state='. $type . ' ORDER BY ' . ' kj.time DESC');
}else{
    $sql = ' SELECT * FROM ' . tablename('ymktv_sun_new_bargain') . ' nb ' . ' JOIN ' . tablename('ymktv_sun_kjorder') . ' kj ' . ' ON ' . ' kj.gid=nb.id'. ' WHERE ' . ' kj.uniacid='.$_W['uniacid'] . ' ORDER BY ' . ' kj.time DESC';
    $total = pdo_fetchcolumn(' SELECT count(*) FROM ' . tablename('ymktv_sun_new_bargain') . ' nb ' . ' JOIN ' . tablename('ymktv_sun_kjorder') . ' kj ' . ' ON ' . ' kj.gid=nb.id'. ' WHERE ' . ' kj.uniacid='.$_W['uniacid'] . ' ORDER BY ' . ' kj.time DESC');
}

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$lits = pdo_fetchall($select_sql);

foreach ($lits as $k=>$v){
    foreach ($servies as $kk=>$vv){
        if($lits[$k]['build_id']==$vv['b_id']){
            $lits[$k]['servies'][] = $vv;
        }
    }
	foreach($build as $k2=>$v2){
		if($v2['id']==$v['build_id']){
			$lits[$k]['b_name']=$v2['b_name'];
		}
	}
}

foreach ($lits as $k=>$v){
    $lits[$k]['username'] = pdo_getcolumn('ymktv_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'name');
}
$pager = pagination($total, $pageindex, $pagesize);

if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_kjorder',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('carcheck'), 'success');
    }else{
        message('删除失败！','','error');
    }
}

if($_GPC['op']=='delivery'){
    $res=pdo_update('ymktv_sun_kjorder',array('state'=>1),array('id'=>$_GPC['id']));
    if($res){
		/*======分销使用====== */
		include_once IA_ROOT . '/addons/ymktv_sun/inc/func/distribution.php';
		$distribution = new Distribution();
		$distribution->order_id = $_GPC['id'];
		$distribution->ordertype = 3;
		$distribution->settlecommission();
		/*======分销使用======*/
        message('操作成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('ymktv_sun_kjorder',array('state'=>0),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['keywords']){
    $data = pdo_getall('ymktv_sun_kjorder',array('uniacid'=>$_W['uniacid'],'order_num like'=>'%'.$_GPC['keywords'].'%'));
    $lits = [];
    foreach ($data as $k=>$v){
        $lits[] = $v+pdo_get('ymktv_sun_new_bargain',array('uniacid'=>$_W['uniacid'],'id'=>$v['gid']));
    }
    foreach ($lits as $k=>$v){
        $lits[$k]['username'] = pdo_getcolumn('ymktv_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$v['openid']),'name');
    }
}
if($_GPC['submit']){
//    p($_GPC);die;
    $res=pdo_update('ymktv_sun_kjorder',array('sid'=>$_GPC['sid']),array('id'=>$_GPC['id']));
    if($res){
        message('更换成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('更换失败','','error');
    }
}



include $this->template('web/carcheck');