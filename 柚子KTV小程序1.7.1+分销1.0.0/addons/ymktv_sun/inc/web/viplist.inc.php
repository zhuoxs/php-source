<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$type=isset($_GPC['type'])?$_GPC['type']:'all';

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

// 判断是否过期
$vip = pdo_getall('ymktv_sun_vipopen',array('uniacid'=>$_W['uniacid']));
foreach ($vip as $k=>$v){
    if(time()>$v['end_time']){
        pdo_update('ymktv_sun_vipopen',array('isopen'=>0),array('uniacid'=>$_W['uniacid'],'id'=>$v['id']));
    }
}

if($_GPC['keywords']){
	$where = "and u.name like '%".$_GPC['keywords']."%' ";
}
if($type=='all'){
    $sql = " SELECT * FROM " . tablename('ymktv_sun_user') . " u " . " JOIN " . tablename('ymktv_sun_vipopen') . " v " . " ON " . " v.openid=u.openid" . " WHERE " . " v.uniacid=" . $_W['uniacid'] . " AND " . " u.uniacid=". $_W['uniacid']." ".$where." ";
}else{
    $type = $_GPC['state'];
    $sql = " SELECT * FROM " . tablename('ymktv_sun_user') . " u " . " JOIN " . tablename('ymktv_sun_vipopen') . " v " . " ON " . " v.openid=u.openid" . " WHERE " . " v.uniacid=" . $_W['uniacid'] . " AND " . " u.uniacid=". $_W['uniacid'] . " AND " . " v.isopen=".$type." ".$where." ";
}


$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$list = pdo_fetchall($select_sql);
if($list){
	foreach ($list as $k=>$v){
		$list[$k]['start_time'] = date('Y-m-d H:i:s',$v['start_time']);
		$list[$k]['end_time'] = date('Y-m-d H:i:s',$v['end_time']);
	}
}
$pager = pagination($total, $pageindex, $pagesize);

if($_GPC['op']=='delivery'){
    $res=pdo_update('ymktv_sun_vipopen',array('status'=>1),array('id'=>$_GPC['id']));
    if($res){
        message('编辑成功！', $this->createWebUrl('viplist'), 'success');
    }else{
        message('编辑失败！','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('ymktv_sun_vipopen',array('status'=>3),array('id'=>$_GPC['id']));
    if($res){
        message('编辑成功！', $this->createWebUrl('viplist'), 'success');
    }else{
        message('编辑失败！','','error');
    }
}
if($_GPC['op']=='delete'){
    $res=pdo_delete('ymktv_sun_vipopen',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('viplist'), 'success');
    }else{
        message('删除失败！','','error');
    }
}


include $this->template('web/viplist');