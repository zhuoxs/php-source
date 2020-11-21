<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid ";
$where.=" and pay_status=1 ";
$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
//$sql="SELECT * FROM ".tablename('yzqzk_sun_store_active'). " a"  . " left join " . tablename("yzqzk_sun_in") . " b on b.type=a.time_type".$where." ORDER BY a.id DESC";
$sql="SELECT * FROM ".tablename('yzqzk_sun_store').$where." ORDER BY id DESC";
$total=pdo_fetchcolumn("select count(*) from " .tablename('yzqzk_sun_store').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
foreach($list as &$val){
    if($val['storelimit_id']>0){
        $val['lt_day']=pdo_getcolumn('yzqzk_sun_storelimit',array('id'=>$val['storelimit_id']),'lt_day',1);
        $order=pdo_getall('yzqzk_sun_order',array('uniacid'=>$_W['uniacid'],'order_lid'=>4,'openid'=>$val['openid'],'store_id'=>$val['id'],'pay_status'=>1),'',array(),'id desc');
        if($order[0]['pay_time']>0) {
            $val['pay_time_d'] =date('Y-m-d H:i',$order[0]['pay_time']);
        }
    }
}
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzqzk_sun_store',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('store'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $store=pdo_get('yzqzk_sun_store',array('id'=>$_GPC['id']));
    if($store['storelimit_id']>0){
        $storelimit=pdo_get('yzqzk_sun_storelimit',array('id'=>$store['storelimit_id']));
        $store_rz_record=pdo_get('yzqzk_sun_store_rz_record',array('uniacid'=>$_W['uniacid'],'openid'=>$store['openid'],'store_id'=>$store['id'],'order_id'=>$store['order_id']));
        if(!$store_rz_record){
            if(empty($store['rz_time'])){
                $rz_time=time();
            }else{
                $rz_time=$store['rz_time'];
            }
            if($store['rz_end_time']>time()){
                $rz_end_time=$store['rz_end_time']+$storelimit['lt_day']*60*60*24;
            }else{
                $rz_end_time=time()+$storelimit['lt_day']*60*60*24;
            }
            pdo_update('yzqzk_sun_store',array('rz_time'=>$rz_time,'rz_end_time'=>$rz_end_time));
            //增加记录
            $store_rz_record=array(
                'uniacid'=>$_W['uniacid'],
                'openid'=>$store['openid'],
                'store_id'=>$store['id'],
                'begin_time'=>$rz_time,
                'end_time'=>$rz_end_time,
                'storelimit_id'=>$store['storelimit_id'],
                'num'=>$storelimit['lt_day'],
                'order_id'=>$store['order_id'],
                'add_time'=>time(),
            );
            pdo_insert('yzqzk_sun_store_rz_record',$store_rz_record);
        }

    }else{
        if(!$store['rz_time']){
            pdo_update('yzqzk_sun_store',array('rz_time'=>time()),array('id'=>$val['id']));
        }
    }

    $res=pdo_update('yzqzk_sun_store',array('state'=>2,'rz_status'=>1),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('store'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzqzk_sun_store',array('state'=>3,'rz_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('store'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/store');