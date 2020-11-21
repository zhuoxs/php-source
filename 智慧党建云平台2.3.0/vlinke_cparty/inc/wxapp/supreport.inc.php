<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

}elseif ($op=="post") {
	$picall = str_replace(array('[','"',']','&quot;'),"",$_GPC['picall']);
    $picallarr = trim($picall)=="" ? array() : explode(",", $picall);
    $data = array(
		'uniacid'    => $_W['uniacid'],
        'title'      => trim($_GPC['title']),
		'picall'     => iserializer($picallarr),
		'details'    => trim($_GPC['details']),
		'reply'      => "",
		'status'     => 1,
		'createtime' => time()
        );
    pdo_insert($this->table_supreport, $data);
    $this->result(0, '', array());
}
?>