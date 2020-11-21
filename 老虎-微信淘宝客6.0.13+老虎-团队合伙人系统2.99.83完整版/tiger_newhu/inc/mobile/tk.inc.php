<?php
 global $_W,$_GPC;
       $cfg = $this->module['config'];     
       $tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
       die(json_encode(array('pid'=>$cfg['ptpid'],'sign'=>$tksign['sign'])));
	   $a=$_GPC['abc'];
  

$b=base64_decode($a);
die($b);
?>