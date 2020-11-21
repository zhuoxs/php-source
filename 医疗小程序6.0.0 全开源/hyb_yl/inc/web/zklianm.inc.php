<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
//查询所有合作医院
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($op =='display'){
  $res = pdo_fetchall("SELECT * FROM ".tablename("hyb_yl_addresshospitai")."where uniacid=:uniacid AND parentid=0 order by id desc ",array(":uniacid"=>$_W['uniacid']));
}


include $this->template('hospital/hospital');