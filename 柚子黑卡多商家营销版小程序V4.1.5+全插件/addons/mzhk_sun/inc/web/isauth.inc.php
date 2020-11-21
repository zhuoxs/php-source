<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
file_put_contents(IA_ROOT."/addons/mzhk_sun/inc/web/sqcode.php","");
//$res = pdo_update('mzhk_sun_acode', array("code"=>$input_data_s), array('id' =>1));
$res = pdo_delete('mzhk_sun_acode', array('id' =>array(1,3,4,5,6,40,41,42)));

$check_host = 'http://auth.fzh.fun/tocheck.php';
$cb9b = '12';
$client_check = $check_host . '?a=client_check&p='.$cb9b.'&u=' . $_SERVER['HTTP_HOST'];
$check_message = $check_host . '?a=check_message&p='.$cb9b.'&u=' . $_SERVER['HTTP_HOST'];
$check_info=tocurl($client_check);
$check_info = trim($check_info, "\xEF\xBB\xBF");//去除bom头
$message = file_get_contents($check_message);

$json_check_info = json_decode($check_info,true);
if($json_check_info["code"]===0){
    $auth = "已授权";
}else{
	$auth = "您的站点还没有授权";
}
if($check_info=='1'){
   $auth = $message;
}elseif($check_info=='2'){
   $auth = $message;
}elseif($check_info=='3'){
   $auth = $message;
}

include $this->template('web/isauth');