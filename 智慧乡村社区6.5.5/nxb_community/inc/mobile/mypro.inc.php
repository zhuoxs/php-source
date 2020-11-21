<?php
global $_W, $_GPC;

$all_net=$this->get_allnet(); 
$base=$this->get_base(); 
$title=$base['title'];
$mid=$this->get_mid();
$typeid=$_GPC['tid'];
$pstatus=$_GPC['wst'];

$sx=$_GPC['sx'];
if(empty($sx)){
	$sx=1;
}

	$cxtj="";
	if($pstatus==''){
		$cxtj="";
	}else{
		
		if($pstatus==1 || $pstatus==0){
			$cxtj=" AND pstatus=".$pstatus;		
		}else{
			$cxtj="";
		}
		
	}


	

		$count=0;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 6;	
		$total = pdo_fetchcolumn("SELECT count(pid) FROM " . tablename('bc_community_proposal') . " WHERE weid=:uniacid ".$cxtj." ORDER BY pid DESC", array(':uniacid' => $_W['uniacid']));
		$count = ceil($total / $psize);
		include $this -> template('mypro');

	



?>