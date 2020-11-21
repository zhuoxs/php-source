<?php
/**
 * 模块授权
 */
load()->func('communication');
load()->model('cloud');
load()->func('file');
load()->func('up');
load()->func('db');

global $_W,$_GPC;


$step = $_GPC['step'];
$steps = array('files','filespro', 'schemas', 'scripts');
$step = in_array($step, $steps) ? $step : 'files';
$res =array();
$m = $_GPC['m'];
$ress = array();
setcookie("m", $m);

	$hosturl = trim($_SERVER['HTTP_HOST']);
	$updatehost = UPDATEHOST;

	$mpathl = IA_ROOT.'/addons/'.$m;

    $updatedir = IA_ROOT.'/data/update';
	$backdir = IA_ROOT.'/data/patch';



if ($step == 'files' && $_GPC['d'] == 'prepare') {
  

      if(is_dir($mpathl)){
          $mpathlist = to_md5($mpathl);
      }else{
          $mpathlist = $res;
      }
      $mresult['mpath'] = json_encode($mpathlist);

      if(strlen($m) > 8){
          $tablelike = substr($m, 0, -2);
      }else{
          $tablelike = $m;
      }

      //$msql = "show tables like '%".$tablelike."%'";
      //$mtable = pdo_fetchall($msql,array());
      //$mtable = to_arr($mtable);

      $remtable = SendCurl($updatehost.'?a=mtable&u='.$hosturl.'&m='.$m,$res);
				
			$remote = array();				
			if (!empty($remtable)) {
				foreach($remtable as $remote){
				$name = substr($remote['tablename'], 4);
				$local = db_table_schema(pdo(), $name);
				$sqls = db_table_fix_sql($local, $remote);
				foreach ($sqls as $sql ) {
					pdo_query($sql);
				}
			}
		}			

      $mresult['md'] = json_encode(module_fetch($m));
      $mresult['mdbud'] = json_encode(module_buildlist($m));
      $content = json_encode($mresult);


        $result = json_decode($content,TRUE);  
        $return = SendCurl($updatehost.'?a=mupdate&u='.$hosturl.'&m='.$m,$result);  
      	$upgrade = $return;
      
    $filelist = array_filter($upgrade['B']);      
    if(!empty($upgrade)){
      if(!is_dir($updatedir)) {
        mkdirs($updatedir,0777);
        chmod($updatedir,0777);
      }
      $upgrade['m'] = $m;
      $upgrade['D'] = $filelist;
      $mapfile = $updatedir.'/moduleup.json';
      $content = json_encode($upgrade);
      $ret = file_put_contents($mapfile, $content, TRUE);
      if(!$ret){
        itoast('系统错误！',create_url('cloud/xcxinstall'),'error');
        die;
      }
    } 
  
    if(empty($filelist)){
		$mapfile = $updatedir.'/moduleup.json';
        $returns = file_get_contents($mapfile);
        $returns = json_decode($returns,TRUE);
        $packet = $returns;
        $modname = $returns['m'];
      
        if(!empty($packet['newmod'])){
          //pdo_insert('modules', $packet['newmod']);
          //cache_build_module_info($modname);
        }
        if(!empty($packet['upmod'])){
          $mid = module_mid($modname);
          pdo_update('modules', $packet['upmod'], array('mid' => $mid));
          //cache_build_module_info($modname);
        }
      
      
        if(!empty($packet['buddiff'])){
          $arry = $packet['buddiff'];
          $arr1 = array();
          $arr2 = array();
          if(!empty($arry['IN'])){
            foreach($arry['IN'] as  $key => $val){
              pdo_insert('modules_bindings', $val);
            }
          }
          if(!empty($arry['UP'])){
            foreach($arry['UP'] as  $keys => $value){
              $eid = array_search($value,$arry['UP']);
              pdo_update('modules_bindings', $value, array('eid' => $eid));
            }
          }
          //cache_build_module_info($modname);
        }
      //cache_build_account_modules();
      //cache_build_uninstalled_module();
      //cache_build_cloud_upgrade_module();
      cache_build_module_info($modname);
      $message = SendCurl($updatehost.'?a=message&u='.$hosturl.'&m='.$m);    
        /*if($packet['sqls']){
          pdo_query($packet['sqls']);
        }*/
      itoast($message['message'],create_url('cloud/xcxinstall'),'success');
    }
  
    if($_GPC['f'] == 0 && $_GPC['d'] != 0){

    }
  
      
      	$back = date("Ymdhis");
      	$back = $backdir.'/'.$back.'/addons/'.$m;
      	if(!mkdirs($back)) {
          itoast('创建回滚目录失败，请返回重新尝试！',create_url('cloud/xcxinstall'),'error');
      	  die;
        }
    	header("Location: ".create_url('cloud/xcxup',array("step"=>"filespro")));
      	exit;
}



if(!empty($_GPC['m'])){
	//$m = $_GPC['m']; 
}elseif(!empty($_GPC['w'])) {

}else{
    $mapfile = $updatedir.'/moduleup.json';
    $returns = file_get_contents($mapfile);
  	$returns = json_decode($returns,TRUE);
	$packet = $returns;
  	$modname = $returns['m'];
}


if ($step == 'filespro') {
  
    $m = $_COOKIE["m"];
    if(!empty($packet['newmod'])){
      //pdo_insert('modules', $packet['newmod']);
      //cache_build_module_info($modname);
    }
    if(!empty($packet['upmod'])){
      $mid = module_mid($modname);
      pdo_update('modules', $packet['upmod'], array('mid' => $mid));
      //cache_build_module_info($modname);
    }


    if(!empty($packet['buddiff'])){
      $arry = $packet['buddiff'];
      $arr1 = array();
      $arr2 = array();
      if(!empty($arry['IN'])){
        foreach($arry['IN'] as  $key => $val){
          pdo_insert('modules_bindings', $val);
        }
      }
      if(!empty($arry['UP'])){
        foreach($arry['UP'] as  $keys => $value){
          $eid = array_search($value,$arry['UP']);
          pdo_update('modules_bindings', $value, array('eid' => $eid));
        }
      }
      //cache_build_module_info($modname);
    }
  //cache_build_account_modules();
  //cache_build_uninstalled_module();
  //cache_build_cloud_upgrade_module();
  cache_build_module_info($modname);
    if($packet['sqls']){
      pdo_query($mdiffpost);
    }
}

if ($step == 'dbpro') {
  
  	//pdo_query($packet['sqls']);
    die;
  
}


template('cloud/xcxup');
