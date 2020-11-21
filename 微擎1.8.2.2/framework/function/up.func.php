<?php
/**
* [拾光授权系统 System] Copyright (c) 2018 33f3.cn
 */
defined('IN_IA') or exit('Access Denied');
	
function get_file($url,$name,$folder = './') {

    set_time_limit((240 * 60) * 3600);

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

function my_scandir($dir){
    $files = array();
	$result = array();
    if(is_dir($dir))
     {
        if($handle=opendir($dir))
         {
            while(($file=readdir($handle))!==false)
             {
                if($file!="." && $file!=".." && $file!="addons" && $file!="cloud.mod.php" && $file!="data" && $file!="db.class.php")
                 {
                    if(is_dir($dir."/".$file))
                     {
                        $files[$file]=my_scandir($dir."/".$file);
                     }
                    else
                     {
                        $files[]=$dir."/".$file;
                     }
                 }
             }
            closedir($handle);
			array_walk_recursive($files, function($value) use (&$result) {
				array_push($result, $value);
			});
			return $result;
         }       
     }   
}


function to_md5($dir){
	$result = array();
	$dir = my_scandir($dir);
	foreach( $dir as $key){
		$result[$key] = md5_file($key);
		$dir['a'][$key] = $result[$key];
	}
	return array_unique(array_values($dir['a']));
}


function SendCurl($url,$data=array()){
  	$url = str_replace(' ','',$url);
	$ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, $url);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($ch, CURLOPT_HEADER, 0);  
	curl_setopt($ch,CURLOPT_TIMEOUT,60);
	//POST传递  
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  
	$result = curl_exec($ch);  
	$error = curl_errno($ch);  
	curl_close($ch);  
	if($error) { 
		return false;  
	}  
	return json_decode($result,TRUE);
}

function down_f($zipurl,$updatedir,$lastver,$updatehost,$hosturl){
  	$arr = array();
	$zipname = 'we7up.zip';
    $isgot = get_file($zipurl, $zipname, $updatedir);
  
    if($isgot){				
      $updatezip = $updatedir.'/'.$zipname;
      require_once IA_ROOT.'/framework/library/phpexcel/PHPExcel/Shared/PCLZip/pclzip.lib.php';
      $thisfolder = new PclZip($updatezip);
      $isextract = $thisfolder->extract(PCLZIP_OPT_PATH, $updatedir);
      if ($isextract == 0) {  
        return 22222; 
      }
      SendCurl($updatehost.'?a=delete&u='.$hosturl,$arr);
      /*$archive = new PclZip($updatezip);
	  $list = $archive->extract(PCLZIP_OPT_PATH, IA_ROOT, PCLZIP_OPT_REPLACE_NEWER);
      $newver = "<?php return array ('ver' => '$lastver');?>";
      $f = fopen(IA_ROOT.'/data/version.php','w+');
      fwrite($f,$newver);
      fclose($f);
      deldir($updatedir);
      die;*/
    }else{
    	return 22222;
    }
}

function mkDirsc($dir){
    if(!is_dir($dir)){
        if(!mkDirsc(dirname($dir))){
            return false;
        }
        if(!mkdir($dir,0777)){
            return false;
        }
      	@chmod($dir,0777);
    }
    return true;
}

function file_back($src, $bin, $des, $filter) {
    if(!is_dir($des)){
      @mkDirsc($des);
    }
  	$content = base64_decode($bin);
  	$filterdir = dirname($filter);
    $source = $src.$filter;
  	if(is_file($source)){
      $backdat = get_newback($des);
      if(!is_dir($backdat.$filterdir)){
        @mkDirsc($backdat.$filterdir);
      }
      if(copy($source, $backdat.$filter)){
        if(!is_dir($src.$filterdir)){
          @mkDirsc($src.$filterdir);
        }
        $res = file_put_contents($source, $content, true);
        if(!$res){
        	return 1111;
        }
      }else{
      	return 1111;
      }
    }else{

        if(!is_dir($src.$filterdir)){
          @mkDirsc($src.$filterdir);
        }
        $res = file_put_contents($source, $content, true);
      	if(!$res){
        	return 1111;
        }
  	}

}

function get_newback($des) {
  
	$path = glob($des.'/*/');
    $path = implode('',$path);
  	$path = str_replace($des.'/','', $path);
  	$path = explode('/',$path);
  	rsort($path,1);
    return $des.'/'.$path[0];
}

function to_arr($arr) {
  	$result = array();
    array_walk_recursive($arr, function($value) use (&$result) {
      array_push($result, $value);
    });
  	return $result;
}

function del_key($res) {
    foreach($res as $key => $val){
      $res['a'][$key] = array_values($val);
    }
	return $res['a'];
}