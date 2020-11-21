<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$info=pdo_get('mzhk_sun_plugin_lottery_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
$img= explode(',',$info['img']);

	
    if(!empty($info['sid'])){
        $name=pdo_get('mzhk_sun_brand',array('bid'=>$info['sid'],'uniacid'=>$_W['uniacid']),'bname')['bname'];
    }else{
        $name=pdo_get('mzhk_sun_user',array('id'=>$info['uid'],'uniacid'=>$_W['uniacid']),'name')['name'];
    }

    if($info['zuid']!=0){
    	$zname=pdo_get('mzhk_sun_user',array('id'=>$info['zuid'],'uniacid'=>$_W['uniacid']),'name')['name'];
    }
    

include $this->template('web/goodsinfo');