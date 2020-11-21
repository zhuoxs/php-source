<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;

$where="where uniacid={$_W['uniacid']} and type=1 ";
if(!empty($_GPC['state'])){
	$status = $_GPC['state'];
	$where .="and status=$status ";
}
$type=isset($_GPC['type'])?$_GPC['type']:'all';

$sql="select * from".tablename('yzcj_sun_ad').$where." ORDER BY status asc";
// p($sql);
$total=pdo_fetchcolumn("select count(*) from".tablename('yzcj_sun_ad')." where uniacid={$_W['uniacid']} ");
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql);
$pager = pagination($total, $pageindex, $pagesize);

$count=pdo_fetchcolumn("select count(id) from".tablename('yzcj_sun_ad')." where uniacid={$_W['uniacid']} and status=1 and type=1");
//$list=pdo_getall('yzcj_sun_ad',array('uniacid'=>$_W['uniacid']),array(),'','orderby ASC');

if($_GPC['op']=='delete'){
	$res=pdo_delete('yzcj_sun_ad',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
	if($res){
		 message('删除成功！', $this->createWebUrl('ad'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['status']){

    if($count>=10&&$_GPC['status']==1){
        message('编辑失败！广告启用数量最多为10！','','error');
    }else{
    	$data['status']=$_GPC['status'];
        $res=pdo_update('yzcj_sun_ad',$data,array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
        if($res){
             message('编辑成功！', $this->createWebUrl('ad'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }

}
include $this->template('web/ad');