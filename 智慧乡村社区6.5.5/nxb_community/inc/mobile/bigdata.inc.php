<?php
global $_W, $_GPC;
include 'common.php';
load()->func('tpl');
$base=$this->get_base();
$title=$base['title'];

if($_GPC['action'] == 'login'){
    $uname = $_GPC['uname'];
    $upsd = md5($_GPC['upsd']);
    $userinfo = pdo_fetch("SELECT * FROM ".tablename('bc_community_jurisdiction')." WHERE weid=:uniacid AND uname='$uname' AND upsd='$upsd'",array(':uniacid'=>$_W['uniacid']));
    if($userinfo['id']){
        $_SESSION['login_id'] = $userinfo['id'];
    }
}















if(empty($_SESSION['login_id'])){
    include $this->template('bigdata_login');
}else{



    include $this->template('bigdata');
}





?>