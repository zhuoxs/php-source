<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid";
$punch_id=$_GPC['punch_id'];
$punch=pdo_get('yzqzk_sun_punch',array('id'=>$punch_id));
$task_day=require_once 'wxapp_task_day_config.php';
$task_day_id=$_GPC['task_day_id'];
$result = array_filter($task_day,function($v){
    if($v['id']==$_GET['task_day_id']){
        return 1;
    }
});
$num=intval(array_keys($result)[0]);
$result=$result[$num];
$where.=" and punch_id=$punch_id ";
$where.=" and task_day_id=$task_day_id ";
$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="SELECT * FROM ".tablename('yzqzk_sun_punch_prize').$where." ORDER BY prize_day asc";
$total=pdo_fetchcolumn("select count(*) from " .tablename('yzqzk_sun_punch_prize').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
foreach($list as &$val){
    $val['store_name']=pdo_getcolumn('yzqzk_sun_store',array('uniacid'=>$_W['uniacid'],'id'=>$val['store_id']),'store_name',1);
    $val['title']=pdo_getcolumn('yzqzk_sun_coupon',array('uniacid'=>$_W['uniacid'],'id'=>$val['coupon_id']),'title',1);
}
$task_day=require_once 'wxapp_task_day_config.php';
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzqzk_sun_punch_prize',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('punchprize',array('punch_id'=>$_GPC['punch_id'],'task_day_id'=>$_GPC['task_day_id'])), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzqzk_sun_punch_prize',array('state'=>2,'tg_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('punchprize'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzqzk_sun_punch_prize',array('state'=>3,'jj_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('punch'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/punchprize');