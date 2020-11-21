<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list = pdo_getall('mzhk_sun_type',array('uniacid' => $_W['uniacid']),array(),'','num ASC');

global $_W, $_GPC;
$template = "web/vippaylog";

if($_GPC['op']=='delete'){
    if($_W['ispost']){
        $res=pdo_delete('mzhk_sun_vippaylog',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
            message('操作成功',$this->createWebUrl('vipcode',array()),'success');
        }else{
            message('操作失败','','error');
        }
    }
}else{

    $where=" WHERE  v.uniacid=:uniacid ";
    $data[':uniacid']=$_W['uniacid'];

    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $data[':uniacid']=$_W['uniacid'];
    //$sql="select v.id,v.viptitle,v.vc_code,v.addtime,u.name,v.openid,v.activetype from " . tablename("mzhk_sun_vippaylog") ." as v left join " . tablename("mzhk_sun_user") ." as u on u.openid=v.openid {$where} order by v.id desc ";
    //$total=pdo_fetchcolumn("select count(v.id) as wname from " . tablename("mzhk_sun_vippaylog") . " as v left join " . tablename("mzhk_sun_user") ." as u on u.openid=v.openid {$where} order by v.id desc ",$data);
    $sql = "select v.id,v.viptitle,v.vc_code,v.addtime,v.openid,v.activetype,(select a.name from " . tablename("mzhk_sun_user") ." as a where a.openid=v.openid ) as name from " . tablename("mzhk_sun_vippaylog") ." as v ".$where." ";
    $total=pdo_fetchcolumn("select count(id) as wname from " . tablename("mzhk_sun_vippaylog") . " as v {$where} order by v.id desc ",$data);
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $list=pdo_fetchall($select_sql,$data);
    $pager = pagination($total, $pageindex, $pagesize);

}

include $this->template($template);