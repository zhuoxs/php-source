<?php
global $_GPC,$_W;
		$cfg = $this->module['config'];
		include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/goodsapi.php"; 
		$type=1;
		$page=$_GPC['page'];
		$pid=$_GPC['pid'];
		//$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
		//$sign=$tksign['sign'];
		$class=$_GPC['class'];
		//gethaoquan($type,$page,$pid,$sign,$wi,$cfg,$class)
	
		$pidSplit=explode('_',$pid);
		$memberid=$pidSplit[1];
		if(empty($memberid)){
			$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
		}else{
			$tksign = pdo_fetch("SELECT * FROM " . tablename($this->modulename."_tksign") . " WHERE  memberid='{$memberid}'");
		}
		
		
// 		$tkuid = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_share") . " WHERE weid='{$_W['uniacid']}' and  dlptpid='{$pid}'");
// 		if(empty($tkuid['tbuid'])){
// 			$tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$cfg['tbuid']}'");
// 		}else{
// 			$tksign = pdo_fetch("SELECT * FROM " . tablename("tiger_newhu_tksign") . " WHERE  tbuid='{$tkuid['tbuid']}'");
// 		}
		$sign=$tksign['sign'];
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