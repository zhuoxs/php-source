<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('mzhk_sun_kanjia_banner',array('uniacid'=>$_W['uniacid']));

if($info['lb_imgs']){
    $lb_imgs = $info['lb_imgs'];
}
if($info['lb_imgs1']){
    $lb_imgs1 = $info['lb_imgs1'];
}
if($info['lb_imgs2']){
    $lb_imgs2 = $info['lb_imgs2'];
}
if($info['lb_imgs3']){
    $lb_imgs3 = $info['lb_imgs3'];
}

include $this->template('web/kanjia_banner');