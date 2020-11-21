<?php
 
defined('IN_IA') or exit('Access Denied');
	
	function get_file($url,$name,$folder = './') {
      
		set_time_limit((24 * 60) * 60);

		$destination_folder = $folder . '/';

		$newfname = $destination_folder.$name;

		$file = fopen($url, 'rb');

		if ($file) {
			$newf = fopen($newfname, 'wb');
			if ($newf) {
				while (!feof($file)) {
					fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
				}
			}
		}
		if ($file) {
			fclose($file);
		}
		if ($newf) {
			fclose($newf);
		}
		return true;
	}

	function runquery($sql) {
	
		$file_path = $sql;  
		if(file_exists($file_path)){ 
			if($fp=fopen($file_path,"a+")){ 
				$buffer=1024; 
				$str=""; 
				while(!feof($fp)){ 
					$str.=fread($fp,$buffer); 
				}
			}
		}
		$query = $str;
		pdo_run($query);
	}	
	
	function deldir($dir) {

	  $dh=opendir($dir);
	  while ($file=readdir($dh)) {
		if($file!="." && $file!="..") {
		  $fullpath=$dir."/".$file;
		  if(!is_dir($fullpath)) {
			  unlink($fullpath);
		  } else {
			  deldir($fullpath);
		  }
		}
	  }	 
	  closedir($dh);
	  if(rmdir($dir)) {
		return true;
	  } else {
		return false;
	  }
	}
