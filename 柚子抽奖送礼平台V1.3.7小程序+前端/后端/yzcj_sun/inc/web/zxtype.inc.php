<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$list=pdo_getall('yzcj_sun_selectedtype',array('uniacid' => $_W['uniacid']));

if($_GPC['op']=='delete'){
	$res=pdo_delete('yzcj_sun_selectedtype',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
	if($res){
		 message('删除成功！', $this->createWebUrl('zxtype'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
 include $this->template('web/zxtype');