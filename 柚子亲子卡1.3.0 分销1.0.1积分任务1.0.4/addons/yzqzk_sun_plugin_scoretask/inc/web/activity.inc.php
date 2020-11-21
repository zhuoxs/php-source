<?php
global $_GPC, $_W;
$str='[{"attr_list":[{"attr_id":17,"attr_name":"红色"},{"attr_id":18,"attr_name":"20*20"}],"num":4,"price":10,"no":"1","pic":"http:\/\/sc.lzywzb.com\/addons\/zjhj_mall\/core\/web\/uploads\/image\/b9\/b9448de691596bcccdb1620a61f5a684.png"},{"attr_list":[{"attr_id":17,"attr_name":"红色"},{"attr_id":19,"attr_name":"30*30"}],"num":6,"price":8,"no":"2","pic":"http:\/\/sc.lzywzb.com\/addons\/zjhj_mall\/core\/web\/uploads\/image\/b9\/b92c9039bfce67478be8df6c668f04f9.jpg"},{"attr_list":[{"attr_id":20,"attr_name":"白色"},{"attr_id":18,"attr_name":"20*20"}],"num":8,"price":7,"no":"3","pic":"http:\/\/sc.lzywzb.com\/addons\/zjhj_mall\/core\/web\/uploads\/image\/a6\/a6b59866b9ec4583e7f4a557532fbb6a.jpg"},{"attr_list":[{"attr_id":20,"attr_name":"白色"},{"attr_id":19,"attr_name":"30*30"}],"num":6,"price":20,"no":"4","pic":"http:\/\/sc.lzywzb.com\/addons\/zjhj_mall\/core\/web\/uploads\/image\/a6\/a6b59866b9ec4583e7f4a557532fbb6a.jpg"}]';

$GLOBALS['frames'] = $this->getMainMenu();
$where=" where uniacid=:uniacid";
$data[':uniacid']=$_W['uniacid'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
//$sql="SELECT * FROM ".tablename('yzqzk_sun_activity_active'). " a"  . " left join " . tablename("yzqzk_sun_in") . " b on b.type=a.time_type".$where." ORDER BY a.id DESC";
$sql="SELECT * FROM ".tablename('yzqzk_sun_activity').$where." ORDER BY id DESC";
$total=pdo_fetchcolumn("select count(*) from " .tablename('yzqzk_sun_activity').$where,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
foreach($list as &$val){
    $val['store_name']=pdo_getcolumn('yzqzk_sun_store',array( 'uniacid' => $_W['uniacid'],'id'=>$val['store_id']),'store_name',1);
    $val['category_title']=pdo_getcolumn('yzqzk_sun_activity_category',array( 'uniacid' => $_W['uniacid'],'id'=>$val['category_id']),'title',1);
}
$pager = pagination($total, $pageindex, $pagesize);
if($_GPC['op']=='delete'){
    $res=pdo_delete('yzqzk_sun_activity',array('id'=>$_GPC['id']));
    if($res){
         message('删除成功！', $this->createWebUrl('activity'), 'success');
        }else{
              message('删除失败！','','error');
        }
}
if($_GPC['op']=='tg'){
    $res=pdo_update('yzqzk_sun_activity',array('state'=>2,'tg_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('通过成功！', $this->createWebUrl('activity'), 'success');
    }else{
        message('通过失败！','','error');
    }
}
if($_GPC['op']=='jj'){
    $res=pdo_update('yzqzk_sun_activity',array('state'=>3,'jj_time'=>time()),array('id'=>$_GPC['id']));
    if($res){
         message('拒绝成功！', $this->createWebUrl('activity'), 'success');
        }else{
              message('拒绝失败！','','error');
        }
}
include $this->template('web/activity');