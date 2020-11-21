<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('yzcj_sun_gifts',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));

$info['pic']= explode(',',$info['pic']);
	// p($info);
if(!empty($info['sid'])){
    $name=pdo_get('yzcj_sun_sponsorship',array('sid'=>$info['sid'],'uniacid'=>$_W['uniacid']),'sname')['sname'];
}else{
	$name='平台';
}
// $info['pic']= str_replace('_', '/', $info['pic']);
$type=pdo_get('yzcj_sun_type',array('id'=>$info['type'],'uniacid'=>$_W['uniacid']),'type')['type'];

$content=html_entity_decode($info['content']);
// p($type);

include $this->template('web/giftsinfo');