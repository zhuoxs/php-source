<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';
$param = $this->getParam();
$user = $this->getUser();

if ($op=="display") {


    $slide = pdo_fetchall("SELECT * FROM ".tablename($this->table_slide)." WHERE position='suphome' AND uniacid=:uniacid ORDER BY priority DESC, id DESC", array(':uniacid'=>$_W['uniacid']));

}
include $this->template('suphome');
?>