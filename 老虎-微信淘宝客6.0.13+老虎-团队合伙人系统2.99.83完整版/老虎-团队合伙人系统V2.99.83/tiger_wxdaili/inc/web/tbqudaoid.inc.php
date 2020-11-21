<?php
 global $_W, $_GPC;
 $cfg = $this->module['config'];
 $page=$_GPC['page'];
 if(empty($page)){
	$page=1; 
 }
 include IA_ROOT . "/addons/tiger_newhu/inc/fun/tiger.php"; 	
 $tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
 //echo $cfg['tbuid'];
 $str=getqudaolist($tksign['sign'],$_W['uniacid'],$page);	
if($str=="OK"){
	message('温馨提示：请不要关闭页面，渠道同步中！第'.$page.'页', $this->createWebUrl('tbqudaoid', array('page' => $page + 1)), 'error');
}else{
	message('渠道同步完成', $this->createWebUrl('qudaoidlist'), 'success');
	
}
 
 
 
?>