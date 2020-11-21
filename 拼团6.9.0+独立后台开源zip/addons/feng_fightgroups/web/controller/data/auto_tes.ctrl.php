<?php 
	global $_W;
	set_time_limit(1800); //解除超时限制	
//	$queue = new queue;
//	$queue -> queueMain($_W);	
pdo_update("tg_order",array('address'=>TG_CORE),array('orderno' => '20160903046394288887'));
//		file_put_contents(TG_CORE."/refund.log", var_export($_W, true).PHP_EOL, FILE_APPEND);
	
	//file_put_contents(ZOFUI_GROUPSHOP."/params.log", var_export(2222222222, true).PHP_EOL, FILE_APPEND);
	
	
	

	
