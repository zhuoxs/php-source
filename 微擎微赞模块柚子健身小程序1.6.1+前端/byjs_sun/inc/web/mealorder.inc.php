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
   // $uid=pdo_get('byjs_sun_user',array('uniacid'=>$_W['uniacid'],'name'=>$op),'id')['id'];
   $uid=pdo_fetch('select id from '.tablename('byjs_sun_user')." where name LIKE concat('%', '$op','%')");
   // p($uid);

   if(!empty($uid)){
        $uid=$uid['id'];
        $where .= " and a.uid=$uid";
   }else{
        $where .= " and a.uid=0";
   }
   
   // $data[':uid']=$uid;
}
if($typeid){
   // $op=$_GPC['keywords'];
   
   $where.= " and c.id=$typeid";
}
$mealtype=pdo_getall('byjs_sun_mealtype',array('uniacid'=>$_W['uniacid'],'status'=>1));
// p($mealtype);

$sql="SELECT a.id,b.name,b.price,b.count,c.typename,d.name as user_name  FROM ".tablename('byjs_sun_mealorder') .  " a"  . " left join " . tablename("byjs_sun_meal") . " b on a.mid=b.id left join ".tablename('byjs_sun_mealtype')." c on c.id = b.typeid left join ".tablename('byjs_sun_user')." d on d.id = a.uid".$where." order BY a.id asc";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('byjs_sun_mealorder') .  " a"  . " left join " . tablename("byjs_sun_meal") . " b on a.mid=b.id left join ".tablename('byjs_sun_mealtype')." c on c.id = b.typeid left join ".tablename('byjs_sun_user')." d on d.id = a.uid".$where." order BY a.id asc",$data);

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
foreach ($list as $key => $value) {
    $oid=$value['id'];
    $count=$value['count'];
    $num=pdo_fetchall("select count from ".tablename('byjs_sun_mealorderdetail')." where oid='$oid' and uniacid =".$_W['uniacid']);
    $num1=0;
    foreach ($num as $k => $v) {
       $num1 += $v['count'];
    }
    // p($num1);
    $list[$key]['count']=$count-$num1;
}
$pager = pagination($total, $pageindex, $pagesize);


if($operation=='delete'){
	$res=pdo_delete('byjs_sun_mealorder',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
   //$res=pdo_update('byjs_sun_mealorder',array('is_delete'=>1),array('id'=>$_GPC['id']));
	if($res){
		message('删除成功',$this->createWebUrl('mealorder',array()),'success');
	}else{
		message('删除失败','','error');
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


include $this->template('web/mealorder');