<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

    $param['mynav'] = iunserializer($param['mynav']);

    $ulevelarr = array(1=>"正式党员",2=>"预备党员",3=>"发展对象",4=>"入党积极分子");
    

    $branch = $this->getBranch($user['branchid']);
    $brancharr = pdo_fetchall("SELECT id, blevel, name FROM ".tablename($this->table_branch)." WHERE id IN ( ".$branch['scort']." ) AND uniacid=:uniacid ORDER BY field( id,".$branch['scort']." ), priority DESC ", array(':uniacid'=>$_W['uniacid']),"id");


    $telephone = iunserializer($param['telephone']);
    $telarr = array();
    if (empty($template)) {
        foreach ($telephone as $k => $v) {
            $arr = explode("###", trim($v));
            $telarr[$k]['name'] = $arr[0];
            $telarr[$k]['phone'] = $arr[1];
        }
    }

    $notice = pdo_fetch("SELECT * FROM ".tablename($this->table_notice)." WHERE branchid in (".$branch['scort'].") AND uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT 1 ",array(':uniacid'=>$_W['uniacid']));

}
include $this->template('my');
?>