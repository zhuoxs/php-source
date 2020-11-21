<?php

load()->func('tpl');
global $_GPC, $_W;  
$uniacid = $_W['uniacid'];
$bdapp = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_bd_applet')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
if (checksubmit('submit')) {
    $bdappdata = array(
        'appid' => $_GPC['bdappid'],
        'appkey' => $_GPC['bdappkey'],
        'appsecret' => $_GPC['bdappsecret']
    );
    if(!$bdapp){
        $bdappdata['uniacid']= $uniacid;
        $res = pdo_insert("sudu8_page_bd_applet",$bdappdata);
    }else{
        $res = pdo_update('sudu8_page_bd_applet', $bdappdata, array('uniacid' => $uniacid));
    }
    if($res>=0){
        message('百度小程序设置信息更新成功!', $this->createWebUrl('Bdapp', array('op'=>'display','opt'=>$opt,'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
    }else{
        message('百度小程序设置信息更新失败!', $this->createWebUrl('Bdapp', array('op'=>'display','opt'=>$opt,'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'error');
    }
}
return include self::template('web/Bdapp/display');