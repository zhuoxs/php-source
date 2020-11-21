<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$list=pdo_getall('zhls_sun_zx_type',array('uniacid' => $_W['uniacid']),array(),'','sort asc');
if($_GPC['op']=='delete'){
	$res=pdo_delete('zhls_sun_zx_type',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl('zxtype'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
 include $this->template('web/zxtype');