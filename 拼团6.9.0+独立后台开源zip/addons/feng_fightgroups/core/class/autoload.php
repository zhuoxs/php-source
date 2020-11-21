<?php
	function tg_autoLoad($class_name){
		$file = TG_CORE . 'class/' . $class_name . '.class.php';	
		if(is_file($file)){
			require_once $file;
		}
		return false;
	}

	spl_autoload_register('tg_autoLoad');

?>