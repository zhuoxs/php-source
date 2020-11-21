<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$state=isset($_GPC['state'])?$_GPC['state']:'all';
$type=$_GPC['type'];
$type1=$_GPC['type1'];
$status=$_GPC['status'];
// load()->func('tpl');
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=" WHERE  a.uniacid=:uniacid  ";

if($_GPC['keywords']){
   $op=$_GPC['keywords'];
   $uid=pdo_fetch('select id from '.tablename('byjs_sun_user')." where name LIKE concat('%', '$op','%')");
   if(!empty($uid)){
        $uid=$uid['id'];
        $where .= " and b.uid=$uid";
   }else{
        $where .= " and b.uid=0";
   }
}
if(!empty($status)&&empty($type1)){

   $where.= " and a.status=$status";
}
if(empty($status)&&!empty($type1)){
  
   $where.= " and a.type=$type1";
}
if(!empty($status)&&!empty($type1)){
  
   $where.= " and a.type=$type1 and a.status = $status";
}
// $mealtype=pdo_getall('byjs_sun_mealtype',array('uniacid'=>$_W['uniacid'],'status'=>1));
// p($mealtype);

$sql="SELECT a.*,a.id as moid,a.count as ocount,a.name as uname,b.id,c.name,c.price,c.count,d.typename,e.name as user_name  FROM ".tablename('byjs_sun_mealorderdetail') .  " a"  . " left join " . tablename("byjs_sun_mealorder") . " b on a.oid=b.id left join ".tablename('byjs_sun_meal')." c on b.mid=c.id left join ".tablename('byjs_sun_mealtype')." d on d.id = c.typeid left join ".tablename('byjs_sun_user')." e on e.id = b.uid ".$where." order BY a.status asc,a.time asc";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('byjs_sun_mealorderdetail') .  " a"  . " left join " . tablename("byjs_sun_mealorder") . " b on a.oid=b.id left join ".tablename('byjs_sun_meal')." c on b.mid=c.id left join ".tablename('byjs_sun_mealtype')." d on d.id = c.typeid left join ".tablename('byjs_sun_user')." e on e.id = b.uid ".$where." order BY a.status asc,a.time asc",$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
// foreach ($list as $key => $value) {
//     $oid=$value['id'];
//     $count=$value['count'];
//     $num=pdo_fetchcolumn("select * from ".tablename('byjs_sun_mealorderdetail')."where oid='$oid' and uniacid =".$_W['uniacid']);
//     $list[$key]['count']=$count-$num;
// }
$pager = pagination($total, $pageindex, $pagesize);


// if($operation=='delete'){
// 	$res=pdo_delete('byjs_sun_mealorderdetail',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
//    //$res=pdo_update('byjs_sun_mealorder',array('is_delete'=>1),array('id'=>$_GPC['id']));
// 	if($res){
// 		message('删除成功',$this->createWebUrl('mealorderdetail',array()),'success');
// 	}else{
// 		message('删除失败','','error');
// 	}
// }
if($_GPC['send']=='tg'){

  // $data['status']=2;
  $res=pdo_update('byjs_sun_mealorderdetail',array('status'=>2),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
   //$res=pdo_update('byjs_sun_mealorder',array('is_delete'=>1),array('id'=>$_GPC['id']));
  if($res){
    message('确认成功',$this->createWebUrl('mealorderdetail',array()),'success');
  }else{
    message('确认失败','','error');
  }
}
// if($operation=='delivery'){
	
//    $res=pdo_update('byjs_sun_mealorder',array('state'=>3,'fh_time'=>time()),array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
// 	if($res){
// 		message('操作成功',$this->createWebUrl('mealorder',array()),'success');
// 	}else{
// 		message('操作失败','','error');
// 	}
// }


include $this->template('web/mealorderdetail');