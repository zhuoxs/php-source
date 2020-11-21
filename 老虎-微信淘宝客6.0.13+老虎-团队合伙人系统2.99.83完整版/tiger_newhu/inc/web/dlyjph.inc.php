<?php
global $_W, $_GPC;
$weid=$_W['uniacid'];
$op = $_GPC['op'];
$uid = $_GPC['uid'];
$type=$_GPC['type'];
if(empty($type)){
	$des="tb18";
}elseif($type==1){
	$des="tb18";
}elseif($type==2){
	$des="tb6";
}elseif($type==3){
	$des="tb4";
}elseif($type==4){
	$des="tb2";
}
if(!empty($uid)){
	$weheruid=" and uid=".$uid;
}else{
	$weheruid="";
}

if($op=="ajax"){
	$list = pdo_fetchall("SELECT uid,tb18,tb6,tb4,tb2 FROM " . tablename("tiger_wxdaili_dlshuju")." where weid='{$_W['uniacid']}' {$weheruid} order by {$des}  desc limit 0,100 ");
	$returndata = array(
			'res_code' => 1,
			'Data' => $list,
			'type'=>$type
	);
	exit(json_encode($returndata));
}


// echo "<pre>";
// print_r($tkrow);
// exit;


include $this -> template('dlyjph');	

?>