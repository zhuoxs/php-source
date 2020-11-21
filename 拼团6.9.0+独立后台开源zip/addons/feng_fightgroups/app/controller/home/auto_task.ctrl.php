<?php
set_time_limit(0); //解除超时限制
$array = array('value'=>1,'expire'=>time());
cache_write(MODULE_NAME.':task:status', $array);
		
$queue = new queue();
$queue->queueMain();
exit("success");
