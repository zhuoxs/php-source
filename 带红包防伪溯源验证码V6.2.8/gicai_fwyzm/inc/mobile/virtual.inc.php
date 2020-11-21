<?php
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC,$form_d;
$account = pdo_get('gicai_fwyzm',array('id'=>$_GPC['fid'],'uniacid'=>$_W['uniacid']));
$account['tpimg1'] = iunserializer($account['tpimg1']);
$account['menu'] 	= iunserializer($account['menu']);

$virtual = pdo_get('gicai_fwyzm_virtual',array('id'=>$_GPC['id'],'fid'=>$_GPC['fid'],'uniacid'=>$_W['uniacid']));

 

include $this->template($account['template'].'/virtual');