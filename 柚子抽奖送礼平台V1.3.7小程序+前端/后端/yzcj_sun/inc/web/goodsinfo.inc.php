<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('yzcj_sun_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
$img= explode(',',$info['img']);

	
    if(!empty($info['sid'])){
        $name=pdo_get('yzcj_sun_sponsorship',array('sid'=>$info['sid'],'uniacid'=>$_W['uniacid']),'sname')['sname'];
    }else{
        $name=pdo_get('yzcj_sun_user',array('id'=>$info['uid'],'uniacid'=>$_W['uniacid']),'name')['name'];
    }

    if($info['zuid']!=0){
    	$zname=pdo_get('yzcj_sun_user',array('id'=>$info['zuid'],'uniacid'=>$_W['uniacid']),'name')['name'];
    }
    

include $this->template('web/goodsinfo');