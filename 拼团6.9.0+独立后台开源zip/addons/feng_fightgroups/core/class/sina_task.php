<?php
require '../../../../framework/bootstrap.inc.php';
require IA_ROOT. '/addons/feng_fightgroups/core/common/defines.php';
require TG_CORE . 'class/autoload.php';
global $_W;
//global $_W['uniacid'] = 3;
//$uniacid = $_GPC['uniacid'];
//pdo_update("tg_order",array('address'=>$_W['uniacd']),array('orderno' => '20160903046394288887'));
//$queue = new queue;
//$queue -> queueMain();	
		file_put_contents(TG_CORE."/refund.log", var_export($_W, true).PHP_EOL, FILE_APPEND);
exit('success');