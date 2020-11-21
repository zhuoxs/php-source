<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where = " WHERE  a.uniacid=".$_W['uniacid'] . ' and b.type=2';
if(!empty($_GPC['keywords'])){
    $op=$_GPC['keywords'];
    $where.=" and b.orderNum LIKE  '%$op%'";
    $data[':name']=$op;
}

$status=$_GPC['status'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=5;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
// $data[':uniacid']=$_W['uniacid'];
if($_GPC['build']){
    $type = $_GPC['build'];
    $where.=" and b.build_id=".$type;
}
// 获取所有的门店数据
$branch = pdo_getall('ymmf_sun_branch',array('uniacid'=>$_W['uniacid']));
if($type=='all'){
    $sql = "select * from ".tablename('ymmf_sun_kjorderlist')."a left join ".tablename('ymmf_sun_kjorder')."b on a.order_id=b.id".$where." order by b.id desc";
    $lit=pdo_fetchall($sql);
}else if($status){
    $sql = ' SELECT * FROM ' .tablename('ymmf_sun_kjorderlist') . ' a ' . ' JOIN ' . tablename('ymmf_sun_kjorder') . ' b ' . ' ON ' . ' a.order_id=b.id ' . '  WHERE' . ' b.uniacid=' . $_W['uniacid'] .  ' AND' . ' b.type=2' .  ' AND' . ' b.status=' . $status." order by b.id desc";
    $lit=pdo_fetchall($sql);
}else{
    $sql = "select * from ".tablename('ymmf_sun_kjorderlist')."a left join ".tablename('ymmf_sun_kjorder')."b on a.order_id=b.id".$where." order by b.id desc";
    $lit=pdo_fetchall($sql);
}

$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;

$lits=array();
foreach ($lit as $k =>$v){
    $lits[$k] = $v;
    $gid = $v['oid'];
    $wher="WHERE id=$gid  AND uniacid =".$_W['uniacid'];
    $val ="select * from ".tablename("ymmf_sun_new_bargain").$wher;
    $valu= pdo_fetch($val);
    $lits[$k]['gname']=$valu['gname'];
    $lits[$k]['id']=$v['order_id'];
    $lits[$k]['orderNum']=$v['orderNum'];
    $lits[$k]['telNumber']=$v['telNumber'];
    $lits[$k]['name']=$v['name'];
    $lits[$k]['addtime']=date('Y-m-d H:i:s',$v['addtime']);
    $lits[$k]['detailInfo']=$v['detailInfo'];
    $lits[$k]['countyName']=$v['countyName'];
    $lits[$k]['provinceName']=$v['provinceName'];
    $lits[$k]['status']=$v['status'];
    $lits[$k]['hair_id']=$v['hair_id'];
    $lits[$k]['text']=$v['text'];
    $lits[$k]['b_name'] = pdo_getcolumn('ymmf_sun_branch',array('id'=>$v['build_id'],'uniacid'=>$_W['uniacid']),'name');
}
//p($lits);die;
$servies = pdo_getall('ymmf_sun_hairers',array('uniacid'=>$_W['uniacid']));
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('ymmf_sun_kjorder',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('orderinfo'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('ymmf_sun_car',array('state'=>2,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
        message('通过成功！', $this->createWebUrl('carcheck'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('ymmf_sun_car',array('state'=>3,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('carcheck'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}
if($_GPC['op']=='delivery'){
    $res=pdo_update('ymmf_sun_kjorder',array('status'=>5),array('id'=>$_GPC['id']));
    if($res){
        $order = pdo_get('ymmf_sun_kjorder',array('id' => $_GPC['id']));
        $order["order_num"] = $order["orderNum"];
        if($order){
            //核销完成之后打钱给门店
            ChangeStoreMoney($order,2);
        }

		/*======分销使用====== */
		include_once IA_ROOT . '/addons/ymmf_sun/inc/func/distribution.php';
		$distribution = new Distribution();
		$distribution->order_id = $_GPC['id'];
		$distribution->ordertype = 2;
		$distribution->settlecommission();
		/*======分销使用======*/

        message('操作成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('ymmf_sun_kjorder',array('status'=>5),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['submit']){
//    p($_GPC);die;
    $res=pdo_update('ymmf_sun_kjorder',array('hair_id'=>$_GPC['hair_id']),array('id'=>$_GPC['id']));
    if($res){
        message('更换成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('更换失败','','error');
    }
}



include $this->template('web/carcheck');