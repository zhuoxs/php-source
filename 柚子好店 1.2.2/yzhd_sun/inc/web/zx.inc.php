<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$list=pdo_getall('yzhd_sun_zx',array('uniacid'=>$_W['uniacid']),array(),'','time ASC');

$info = pdo_get('yzhd_sun_vip_card', array('uniacid'=>$_W['uniacid']));

//	$total=pdo_fetchcolumn("select count(*) from " . tablename("yzhd_sun_zx") . " a"  . " left join " . tablename("yzhd_sun_zx_type") . " b on a.type_id=b.id" . " left join " . tablename("yzhd_sun_user") . " c on a.user_id=c.id".$where,$data);
//	$pager = pagination($total, $pageindex, $pagesize);
		//$list=pdo_fetchall($sql,$data);
if($_GPC['op']=='delete'){
	$res=pdo_delete('yzhd_sun_selected',array('seid'=>$_GPC['seid']));
	if($res){
		 message('删除成功！', $this->createWebUrl('zx'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['state']){
	$data['state']=$_GPC['state'];
	$res=pdo_update('yzhd_sun_zx',$data,array('seid'=>$_GPC['seid']));
	if($res){
		 message('编辑成功！', $this->createWebUrl('zx'), 'success');
		}else{
			  message('编辑失败！','','error');
		}
}
include $this->template('web/zx');
