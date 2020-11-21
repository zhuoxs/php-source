<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$list = pdo_getall('zhls_sun_label',array('type2_id' => $_GPC['type2_id']));
if($_GPC['op']=='del'){
		$result = pdo_delete('zhls_sun_label', array('id'=>$_GPC['id']));
		if($result){
			message('删除成功',$this->createWebUrl('label',array('type2_id'=>$_GPC['type2_id'])),'success');
		}else{
		message('删除失败','','error');
		}
	
}
include $this->template('web/label');