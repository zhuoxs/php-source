<?php

global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

//switch ($_GPC['type']) {
//	case 'wait':
//		$where['state'] = 1;
//		break;
//	case 'ok':
//		$where['state'] = 3;
//		break;
//	case 'no':
//		$where['state'] = 4;
//		break;
//	default:
//		break;
//}
$state = $_GPC['status'];
$where=" WHERE uniacid=:uniacid and type !=2 ";
if($state==1){
    $where.=" and state=1";
}elseif($state==3){
    $where.=" and state=2 or state=3";
}elseif($state==5){
    $where.=" and state=4 or state=5";
}

if (! empty($_GPC['keywords'])) {
	$where['out_trade_no'] = $_GPC['keywords'];
}
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select * from " . tablename("yzhd_sun_order") . $where . "  order by id desc ";

$total=pdo_fetchcolumn("select count(*) as wname from " . tablename("yzhd_sun_order").$where."  order by id desc ",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);

if($_GPC['op']=='delete'){
    $res=pdo_delete('yzhd_sun_order',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('orderinfo'), 'success');
        }else{
              message('删除失败！','','error');
        }
}

if($_GPC['op']=='delivery'){
    $res=pdo_update('yzhd_sun_order',array('state'=>3, 'pay_time' => time()),array('id'=>$_GPC['id']));
    if($res){
        $order = pdo_get('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        if($order['type']==0){
            $result = pdo_update('yzhd_sun_caipin',array('sp_num -='=>$order['good_num']),array('uniacid'=>$_W['uniacid'],'cid'=>$order['good_id']));
        }elseif ($order['type']==1){
            $result = pdo_update('yzhd_sun_goods',array('sp_num -='=>$order['good_num']),array('uniacid'=>$_W['uniacid'],'id'=>$order['good_id']));
        }elseif ($order['type']==3){
            $result = pdo_update('yzhd_sun_goods_meal',array('sp_num -='=>$order['good_num']),array('uniacid'=>$_W['uniacid'],'id'=>$order['good_id']));
        }elseif ($order['type']==4){
            $gid = explode(',',$order['good_id']);
            $num = explode(',',$order['good_num']);
            foreach ($gid as $k=>$v){
                foreach ($num as $kk=>$vv){
                    if($k==$kk){
                        $result = pdo_update('yzhd_sun_caipin',array('sp_num -='=>$vv),array('uniacid'=>$_W['uniacid'],'cid'=>$v));
                    }
                }
            }
        }
        message('操作成功',$this->createWebUrl('orderinfo',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='receipt'){
    $res=pdo_update('yzhd_sun_order',array('state'=>4),array('id'=>$_GPC['id']));
    if($res){
        $order = pdo_get('yzhd_sun_order',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
        $result = pdo_update('yzhd_sun_branch',array('allprice +='=>$order['money'],'canbeput +='=>$order['money']),array('id'=>$order['branch_id']));
        message('操作成功',$this->createWebUrl('orderinfo',array()),'success');
    }else{
        message('操作失败','','error');
    }
}
if($_GPC['op']=='excel'){
    $state = $_GPC['status'];
    $where=" WHERE uniacid=:uniacid and type !=2 ";
    if($state==1){
        $where.=" and state=1";
    }elseif($state==3){
        $where.=" and state=2 or state=3";
    }elseif($state==5){
        $where.=" and state=4 or state=5";
    }

    if (! empty($_GPC['keywords'])) {
        $where['out_trade_no'] = $_GPC['keywords'];
    }
    $data[':uniacid']=$_W['uniacid'];
    $sql="select * from " . tablename("yzhd_sun_order") . $where . "  order by id desc ";
    $list=pdo_fetchall($sql,$data);
    $new_array = array();
    foreach ($list as $k=>$v){
        $list[$k]['order_time'] = date('Y-m-d H:i:s',$v['time']);
        if($list[$k]['state']==1){
            $list[$k]['order_state'] = '未支付';
        }elseif($list[$k]['state']==2){
            $list[$k]['order_state'] = '已支付，待发货';
        }elseif($list[$k]['state']==3){
            $list[$k]['order_state'] = '已发货，待确认';
        }elseif($list[$k]['state']==4){
            $list[$k]['order_state'] = '已收货，待评价';
        }elseif($list[$k]['state']==5){
            $list[$k]['order_state'] = '已评价';
        }else{
            $list[$k]['order_state'] = '暂无状态';
        }
    }
    foreach ($list as $k=>$v){
        $new_array[$k]['id'] = $v['id'];
        $new_array[$k]['order_num'] = $v['order_num'];
        $new_array[$k]['good_name'] = $v['good_name'];
        $new_array[$k]['good_num'] = $v['good_num'];
        $new_array[$k]['money'] = $v['money'];
        $new_array[$k]['user_name'] = $v['user_name'];
        $new_array[$k]['tel'] = $v['tel'];
        $new_array[$k]['order_time'] = $v['order_time'];
        $new_array[$k]['order_state'] = $v['order_state'];
    }

    $this->toCSV('订单表'.date('ymdhis').'.csv',['编号','订单号','商品名称','商品数量','订单金额','用户名称','用户电话','购买时间','订单状态'],$new_array);
    die;
}
include $this->template('web/orderinfo');
