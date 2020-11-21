<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {

}elseif ($op=="post") {
	$picall = empty($_GPC['picall'])?array():$_GPC['picall'];
    $data = array(
		'uniacid'    => $_W['uniacid'],
        'title'      => trim($_GPC['title']),
		'picall'     => iserializer($picall),
		'details'    => trim($_GPC['details']),
		'reply'      => "",
		'status'     => 1,
		'createtime' => time()
        );
    pdo_insert($this->table_supreport, $data);
    message("信息提交成功！", $this->createMobileUrl('supreport'), 'success');
}
include $this->template('supreport');
?>