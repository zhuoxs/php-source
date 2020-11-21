<?php
global $_W, $_GPC;
$dluid=$_GPC['dluid'];//share id
       $cfg = $this->module['config'];
       
        $list = pdo_fetchall("select * from ".tablename($this->modulename."_qtzlist")." where weid='{$_W['uniacid']}'  order by px desc");
       $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单
       
//     echo "<pre>";
//     	print_r($list);
//     	exit;
       
       include $this->template ( 'tbgoods/style88/qtz' );