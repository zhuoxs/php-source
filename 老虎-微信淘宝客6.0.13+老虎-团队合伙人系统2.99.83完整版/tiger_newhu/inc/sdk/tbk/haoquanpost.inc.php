<?php
global $_GPC,$_W;
		$cfg = $this->module['config'];
		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
		$type=$_GPC['type'];
		$page=$_GPC['page'];
		$pid=$_GPC['pid'];
		$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
		$sign=$tksign['sign'];
		$class=$_GPC['class'];
		//gethaoquan($type,$page,$pid,$sign,$wi,$cfg,$class)
		$list=gethaoquan($type,$page,$pid,$sign,$_W,$cfg,$class);
		//echo '<pre>';
		//print_r($list);
		//exit;
		if(empty($list)){
			$status=2;
		}else{
			$status=1;//有数据
		}
		exit(json_encode(array('status' => $status, 'content' => $list)));
?>