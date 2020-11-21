<?php 
	set_time_limit(0); //解除超时限制	
	die;
	$cache = Util::getCache('queue','q');

	if( empty( $cache ) || $cache['time'] < ( time() - 40 ) ){
		Util::setCache('queue','q',array('time'=>time()));
		$url = Util::createModuleUrl('message',array('op'=>1));

		try { 

			$queue = new queue;
			$queue -> queueMain();	

		} catch (Exception $e) { 
			
			Util::deleteCache('queue','q');
			Util::httpGet($url,'', 1);
			die;
		}

		sleep(5);
		Util::deleteCache('queue','q'); // 这个必须放在休眠后执行
		Util::httpGet($url,'', 1);

		//file_put_contents(MODULE_ROOT."/params.log", var_export(date('Y-m-d H:i:s'), true).PHP_EOL, FILE_APPEND);
	}
	echo 200;
	die;
	
	//file_put_contents(MODULE_ROOT."/params.log", var_export(2222222222, true).PHP_EOL, FILE_APPEND);
	
	
	

	
