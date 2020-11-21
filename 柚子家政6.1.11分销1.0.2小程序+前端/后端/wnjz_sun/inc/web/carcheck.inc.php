<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where = " WHERE  a.uniacid=".$_W['uniacid'] . ' and b.type=2';
if(!empty($_GPC['keywords'])){
    $op=$_GPC['keywords'];
    $where.=" and b.orderNum LIKE  '%$op%'";
    $data[':name']=$op;
}
if($_GPC['build']){
    $type = $_GPC['build'];
    $where.=" and b.build_id=".$type;
}

// 获取所有的门店数据
$branch = pdo_getall('wnjz_sun_branch',array('uniacid'=>$_W['uniacid']));

$status=$_GPC['status'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$type=isset($_GPC['type'])?$_GPC['type']:'all';
// $data[':uniacid']=$_W['uniacid'];
if($type=='all'){
    $sql = "select * from ".tablename('wnjz_sun_kjorderlist')."a left join ".tablename('wnjz_sun_kjorder')."b on a.order_id=b.id".$where;
}else if($status){
    $sql = ' SELECT * FROM ' .tablename('wnjz_sun_kjorderlist') . ' a ' . ' JOIN ' . tablename('wnjz_sun_kjorder') . ' b ' . ' ON ' . ' a.order_id=b.id ' . '  WHERE' . ' b.uniacid=' . $_W['uniacid'] .  ' AND' . ' b.type=2' .  ' AND' . ' b.status=' . $status;
}else{
    $sql = "select * from ".tablename('wnjz_sun_kjorderlist')."a left join ".tablename('wnjz_sun_kjorder')."b on a.order_id=b.id".$where;
}

$select_sql =$sql." ORDER BY b.id DESC LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$lit = pdo_fetchall($select_sql);
$total = pdo_fetchcolumn("select count(*) from ".tablename('wnjz_sun_kjorderlist')."a left join ".tablename('wnjz_sun_kjorder')."b on a.order_id=b.id".$where);
//p($status);die;
$lits=array();
foreach ($lit as $k =>$v){
    $gid = $v['oid'];
    $wher="WHERE id=$gid  AND uniacid =".$_W['uniacid'];
    $val ="select * from ".tablename("wnjz_sun_new_bargain").$wher;
    $valu= pdo_fetch($val);
    $lits[$k]['gname']=$valu['gname'];
    $lits[$k]['id']=$v['order_id'];
    $lits[$k]['orderNum']=$v['orderNum'];
    $lits[$k]['telNumber']=$v['telNumber'];
    $lits[$k]['name']=$v['name'];
    $lits[$k]['time']=$v['time'];
    $lits[$k]['detailInfo']=$v['detailInfo'];
    $lits[$k]['countyName']=$v['countyName'];
    $lits[$k]['provinceName']=$v['provinceName'];
    $lits[$k]['status']=$v['status'];
    $lits[$k]['sid']=$v['sid'];
    $lits[$k]['text']=$v['text'];
	$lits[$k]['money']=$v['money'];
	$lits[$k]['addtime']=$v['addtime'];
	$lits[$k]['paytime']=$v['paytime'];
	$lits[$k]['isrefund']=$v['isrefund'];
}
$servies = pdo_getall('wnjz_sun_servies',array('uniacid'=>$_W['uniacid']));
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('wnjz_sun_kjorder',array('id'=>$_GPC['id']));
    if($res){
        message('删除成功！', $this->createWebUrl('orderinfo'), 'success');
    }else{
        message('删除失败！','','error');
    }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('wnjz_sun_car',array('state'=>2,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
        message('通过成功！', $this->createWebUrl('carcheck'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('wnjz_sun_car',array('state'=>3,'sh_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
        message('拒绝成功！', $this->createWebUrl('carcheck'), 'success');
    }else{
        message('拒绝失败！','','error');
    }
}
if($_GPC['op']=='delivery'){
    $res=pdo_update('wnjz_sun_kjorder',array('status'=>5),array('id'=>$_GPC['id']));

	/*======分销使用====== */
	include_once IA_ROOT . '/addons/wnjz_sun/inc/func/distribution.php';
	$distribution = new Distribution();
	$distribution->order_id = $_GPC['id'];
	$distribution->ordertype = 2;
	$distribution->settlecommission();
	/*======分销使用======*/

    if($res){
        message('操作成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('wnjz_sun_kjorder',array('status'=>5),array('id'=>$_GPC['id']));
    if($res){
        message('操作成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['submit1']){
    $res=pdo_update('wnjz_sun_kjorder',array('sid'=>$_GPC['sid']),array('id'=>$_GPC['id']));
    if($res){
        message('更换成功',$this->createWebUrl('carcheck',array()),'success');
    }else{
        message('更换失败','','error');
    }
}

//退款
if($_GPC['op']=='refund'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $isrefund = intval($_GPC['isrefund']);
    if($isrefund==3){
        $ress = pdo_update('wnjz_sun_kjorder',array("isrefund ="=>3),array('id'=>$id,'uniacid'=>$uniacid));
        if($ress){
            message('拒绝成功！', $this->createWebUrl('carcheck'), 'success');
        }else{
            message('拒绝失败！','','error');
        }
    }
    //获取订单信息
    $order = pdo_get('wnjz_sun_kjorder',array('uniacid'=>$uniacid,'id'=>$id),array("money","out_trade_no","out_refund_no","paytype","openid"));
    //判断是微信支付还是余额支付
    if($order["paytype"]==2){//余额支付
        $money = $order['money'];
        //更新用户剩余金额
        $res_user = pdo_update('wnjz_sun_user', array('money +=' => $money), array('openid' => $order['openid']));
        if($res_user){
            $result['result_code'] = 'SUCCESS';
        }else{
            $result['result_code'] = 'ERROR';
        }
    }else{
        //退款操作
        load()->model('account');
        load()->func('communication');
        $res=pdo_get('wnjz_sun_system',array('uniacid'=>$uniacid));
        $result = wxserverrefund($order,$res);
    }
    
    if ($result['result_code'] == 'SUCCESS') {//退款成功
        pdo_update('wnjz_sun_kjorder',array("isrefund ="=>2,"out_refund_no ="=>$out_refund_no),array('id'=>$id,'uniacid'=>$uniacid));
        message('退款成功！', $this->createWebUrl('carcheck'), 'success');
    }else{
        pdo_update('wnjz_sun_kjorder',array("out_refund_no ="=>$out_refund_no),array('id'=>$id,'uniacid'=>$uniacid));
        if($order["paytype"]==2){//余额支付
            message('退款失败！','error');
        }else{
			//echo '<pre>';
			//var_dump($result);die;
            message('退款失败！微信'.$result["err_code_des"],'','error');
        }
    }
}


include $this->template('web/carcheck');