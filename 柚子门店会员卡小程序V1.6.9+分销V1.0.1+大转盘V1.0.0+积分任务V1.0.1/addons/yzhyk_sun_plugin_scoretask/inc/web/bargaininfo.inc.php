<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$type=isset($_GPC['type'])?$_GPC['type']:'all';
$status=$_GPC['status'];
load()->func('tpl');
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE uniacid=:uniacid';
if($_GPC['keywords']){
   $op=$_GPC['keywords'];
   $where.=" and (orderformid LIKE  concat('%',:orderformid,'%') or name LIKE  concat('%',:name,'%'))";	
   $data[':orderformid']=$op;
   $data['name']=$op;
}	
if($status){
   if($status==1){
    $where.= " and order_status=0";
   }else if($status==2){
    $where.= " and order_status=1";
   }else if($status==3){
    $where.= " and order_status=3";
   }
}
if($_GPC['time']){
   $start=strtotime($_GPC['time']['start']);
   $end=strtotime($_GPC['time']['end']);
  $where.=" and pay_time >={$start} and pay_time<={$end}";
}
$where .=" and lid=2 and pay_status=1 ";
$sql="select * from ".tablename('yzhyk_sun_plugin_scoretask_order') .$where." order by id desc";
$data[':uniacid']=$_W['uniacid'];
$total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('yzhyk_sun_plugin_scoretask_order').$where." ORDER BY id DESC",$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
foreach($list as &$val){
    $val['title']=pdo_getcolumn('yzhyk_sun_plugin_scoretask_goods',array('id'=>$val['gid']),'title');
    if($val['lottery_type']==2){
        $val['title']=pdo_getcolumn('yzhyk_sun_plugin_scoretask_lotteryprize',array('id'=>$val['lotteryprize_id']),'name');
    }
}
if($operation=='delivery'){
   $res=pdo_update('yzhyk_sun_plugin_scoretask_order',array('order_status'=>3,'queren_time'=>time()),array('id'=>$_GPC['id']));
	if($res){
		message('操作成功',$this->createWebUrl('bookinfo',array()),'success');
	}else{
		message('操作失败','','error');
	}
}
include $this->template('web/bargaininfo');