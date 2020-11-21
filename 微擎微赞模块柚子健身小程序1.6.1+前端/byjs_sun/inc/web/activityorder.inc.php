<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$typeid=$_GPC['typeid'];
load()->func('tpl');
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=" WHERE  a.uniacid=:uniacid  ";

if($_GPC['keywords']){
   $op=$_GPC['keywords'];
    $where.=" and  a.name LIKE  concat('%', :name,'%') ";
    $data[':name']=$_GPC['keywords'];   
   // $uid=pdo_get('byjs_sun_user',array('uniacid'=>$_W['uniacid'],'name'=>$op),'id')['id'];
   // $uid=pdo_fetch('select id from '.tablename('byjs_sun_user')." where name LIKE concat('%', '$op','%')");
   // if(!empty($uid)){
   //      $uid=$uid['id'];
   //      $where .= " and a.uid=$uid";
   // }else{
   //      $where .= " and a.uid=0";
   // }
   
   // $data[':uid']=$uid;
}
if(!empty($_GPC['active'])){
    $active=$_GPC['active'];
    $where.=" and  b.name LIKE  concat('%', :name,'%') ";
    $data[':name']=$_GPC['active'];   
}
if($typeid){
   // $op=$_GPC['keywords'];
   
   $where.= " and c.id=$typeid";
}
$activitytype=pdo_getall('byjs_sun_activitytype',array('uniacid'=>$_W['uniacid'],'status'=>1));
// p($activitytype);

$sql="SELECT a.id,a.orderNum,a.time,a.name,a.phone,a.IDcard,a.text,b.name as acname,c.name as typename,d.name as uname  FROM ".tablename('byjs_sun_activityorder') .  " a"  . " left join " . tablename("byjs_sun_activitys") . " b on a.aid=b.id left join ".tablename('byjs_sun_activitytype')." c on c.id = b.typeid left join ".tablename('byjs_sun_user')." d on d.id = a.uid".$where." order BY a.id asc";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('byjs_sun_activityorder') .  " a"  . " left join " . tablename("byjs_sun_activitys") . " b on a.aid=b.id left join ".tablename('byjs_sun_activitytype')." c on c.id = b.typeid left join ".tablename('byjs_sun_user')." d on d.id = a.uid".$where." order BY a.id asc",$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
foreach ($list as $key => $value) {
    $list[$key]['time'] = date('Y-m-d H:i:s', $list[$key]['time']);
};
$pager = pagination($total, $pageindex, $pagesize);


if($operation=='delete'){
	$res=pdo_delete('byjs_sun_activityorder',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
   //$res=pdo_update('byjs_sun_activityorder',array('is_delete'=>1),array('id'=>$_GPC['id']));
	if($res){
		message('删除成功',$this->createWebUrl('activityorder',array()),'success');
	}else{
		message('删除失败','','error');
	}
}
// if($operation=='delivery'){
	
//    $res=pdo_update('byjs_sun_activityorder',array('state'=>3,'fh_time'=>time()),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
// 	if($res){
// 		message('操作成功',$this->createWebUrl('activityorder',array()),'success');
// 	}else{
// 		message('操作失败','','error');
// 	}
// }


include $this->template('web/activityorder');