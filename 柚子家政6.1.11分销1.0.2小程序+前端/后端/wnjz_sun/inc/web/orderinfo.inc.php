<?php

global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();
$where = " WHERE  b.uniacid=".$_W['uniacid'];
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
    $sql = "select * from ".tablename('wnjz_sun_orderlist')."a left join ".tablename('wnjz_sun_order')."b on b.oid=a.order_id".$where;
}else{
    $where.= " and status =$status";
    $sql = "select * from ".tablename('wnjz_sun_orderlist')."a left join ".tablename('wnjz_sun_order')."b on b.oid=a.order_id".$where;

}
$total = pdo_fetchcolumn("select count(*) from ".tablename('wnjz_sun_orderlist')."a left join ".tablename('wnjz_sun_order')."b on b.oid=a.order_id".$where.' and a.uniacid='.$_W['uniacid']);

$select_sql =$sql." ORDER BY b.oid DESC LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$lit=pdo_fetchall($select_sql);
$pager = pagination($total, $pageindex, $pagesize);

$lits=array();
foreach ($lit as $k =>$v){
    $gid = $v['gid'];
    $wher="WHERE gid=$gid  AND uniacid =".$_W['uniacid'];
    $val ="select * from ".tablename("wnjz_sun_goods").$wher;
    $valu= pdo_fetch($val);
    $lits[$k]['gname']=$valu['gname'];
    $lits[$k]['id']=$v['id'];
    $lits[$k]['oid']=$v['oid'];
    $lits[$k]['orderNum']=$v['orderNum'];
    $lits[$k]['telNumber']=$v['telNumber'];
    $lits[$k]['name']=$v['name'];
    $lits[$k]['time']=$v['time'];
    $lits[$k]['detailInfo']=$v['detailInfo'];
    $lits[$k]['countyName']=$v['countyName'];
    $lits[$k]['provinceName']=$v['provinceName'];
    $lits[$k]['status']=$v['status'];
	$lits[$k]['isrefund']=$v['isrefund'];
    $lits[$k]['sid']=$v['sid'];
    $lits[$k]['text']=$v['text'];
	$lits[$k]['money']=$v['money'];
	$lits[$k]['num']=$v['num'];
	$lits[$k]['addtime']=$v['addtime'];
	$lits[$k]['paytime']=$v['paytime'];
}

$servies = pdo_getall('wnjz_sun_servies',array('uniacid'=>$_W['uniacid']));
if($_GPC['op']=='delete'){
    $res=pdo_delete('wnjz_sun_order',array('oid'=>$_GPC['oid']));
    if($res){
        pdo_delete('wnjz_sun_orderlist',array('order_id'=>$_GPC['oid']));
         message('删除成功！', $this->createWebUrl('orderinfo'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('wnjz_sun_car',array('state'=>2,'sh_time'=>time()),array('oid'=>$_GPC['oid']));
    if($res){
         message('通过成功！', $this->createWebUrl('carinfo'), 'success');
        }else{
              message('通过失败！','','error');
        }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('wnjz_sun_car',array('state'=>3,'sh_time'=>time()),array('oid'=>$_GPC['oid']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('carinfo'), 'success');
        }else{
         message('拒绝失败！','','error');
        }
}
if($_GPC['op']=='delivery'){
    $res=pdo_update('wnjz_sun_order',array('status'=>5),array('oid'=>$_GPC['oid']));

	/*======分销使用====== */
	include_once IA_ROOT . '/addons/wnjz_sun/inc/func/distribution.php';
	$distribution = new Distribution();
	$distribution->order_id = $_GPC['oid'];
	//0抢购，1拼团，2砍价，3集卡，4普通，10优惠券,6免单
	////1普通，2砍价，3拼团，4抢购，5预约
	$distribution->ordertype = 1;
	$distribution->settlecommission();
	/*======分销使用======*/

    if($res){
        message('操作成功',$this->createWebUrl('orderinfo',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('wnjz_sun_order',array('status'=>5),array('oid'=>$_GPC['oid']));
    if($res){
        message('操作成功',$this->createWebUrl('orderinfo',array()),'success');
    }else{
        message('操作失败','','error');
    }
}

//退款
if($_GPC['op']=='refund'){
    $id = intval($_GPC['id']);
    $uniacid = $_W['uniacid'];
    $isrefund = intval($_GPC['isrefund']);
    if($isrefund==3){
        $ress = pdo_update('wnjz_sun_order',array("isrefund ="=>3),array('oid'=>$id,'uniacid'=>$uniacid));
        if($ress){
            message('拒绝成功！', $this->createWebUrl('orderinfo'), 'success');
        }else{
            message('拒绝失败！','','error');
        }
    }
    //获取订单信息
    $order = pdo_get('wnjz_sun_order',array('uniacid'=>$uniacid,'oid'=>$id),array("money","out_trade_no","out_refund_no","paytype","oprnid"));
	if($order){
		$order['openid'] = $order['oprnid']; 
	}
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
        pdo_update('wnjz_sun_order',array("isrefund ="=>2,"out_refund_no ="=>$out_refund_no),array('oid'=>$id,'uniacid'=>$uniacid));
        message('退款成功！', $this->createWebUrl('orderinfo'), 'success');
    }else{
        pdo_update('mzhk_sun_order',array("out_refund_no ="=>$out_refund_no),array('oid'=>$id,'uniacid'=>$uniacid));
        if($order["paytype"]==2){//余额支付
            message('退款失败！','error');
        }else{
			//echo '<pre>';
			//var_dump($result);die;
            message('退款失败！微信'.$result["err_code_des"],'','error');
        }
    }
}


if($_GPC['submit1']){
    $res=pdo_update('wnjz_sun_order',array('sid'=>$_GPC['sid']),array('oid'=>$_GPC['oid']));
    if($res){
        message('更换成功',$this->createWebUrl('orderinfo',array()),'success');
    }else{
        message('更换失败','','error');
    }
}
include $this->template('web/orderinfo');