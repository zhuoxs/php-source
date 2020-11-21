<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

    $telephone = iunserializer($param['telephone']);
    $telarr = array();
    if (empty($template)) {
        foreach ($telephone as $k => $v) {
            $arr = explode("###", trim($v));
            $telarr[$k]['name'] = $arr[0];
            $telarr[$k]['phone'] = $arr[1];
        }
    }

}
include $this->template('aboutus');
?>