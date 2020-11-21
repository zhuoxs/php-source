<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$fx_id =$_GPC['fx_id'];
$op=$_GPC['op'];
if($op =='post'){
	$data_arr1 =$_GPC['data_arr1'];
	$pl_content =$_GPC['pl_content'];
	$useropenid =$_GPC['useropenid'];
	$idarr = htmlspecialchars_decode($data_arr1);
	$array = json_decode($idarr);
	$object = json_decode(json_encode($array), true);
	//
	$text =array(
	  'estimatePicBigUrl'=>$object,
	  'rcontent'=>$pl_content
		);

	$data =array(
	     'uniacid'=>$uniacid,
	     'fx_id'=>$fx_id,
	     'useropenid'=>$useropenid,
	     'pl_text'=>serialize($text),
	     'usertoux'=>$_GPC['usertoux'],
	     'name'=>$_GPC['name'],
	     'rtimeDay'=>strtotime('now'),
		);

	$res  =pdo_insert("hyb_yl_docpinglunsite",$data);
    echo json_encode($res);
}
if($op =='all'){
	$res = pdo_fetchall("SELECT * FROM".tablename('hyb_yl_docpinglunsite')."where uniacid='{$uniacid}' and fx_id='{$fx_id}' order by rtimeDay desc");
	foreach ($res as $key => $value) {
		$res[$key]['pl_text']= unserialize($res[$key]['pl_text']);
		$res[$key]['rcontent'] =$res[$key]['pl_text']['rcontent'];
		$res[$key]['userIcon'] =$res[$key]['usertoux'];
        $count =count($res[$key]['pl_text']['estimatePicBigUrl']);
        for ($i=0; $i <$count ; $i++) { 
        	$res[$key]['estimatePicBigUrl'][]=$_W['attachurl'].$res[$key]['pl_text']['estimatePicBigUrl'][$i];
        }
		$res[$key]['rtimeDay'] =date("Y-m-d H:i:s",$res[$key]['rtimeDay']); 
		$pl_id=$value['pl_id'];
	}
	echo json_encode($res);
}

