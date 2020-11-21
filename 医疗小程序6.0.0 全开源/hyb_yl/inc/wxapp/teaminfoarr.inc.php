<?php
defined('IN_IA') or exit('Access Denied');
global $_GPC, $_W;
$uniacid =$_W['uniacid'];
$t_id =$_GPC['t_id'];
$op = $_GPC['op'];
//查询一条最新置顶记录
if($op=='display'){
	$zhiding =pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_teamment')."WHERE uniacid ='{$uniacid}' AND t_id='{$t_id}' AND menttypes=1 order by g_id desc LIMIT 1");
	//查询列表
	$res = pdo_fetchall('SELECT * FROM'.tablename('hyb_yl_teamment')."WHERE uniacid ='{$uniacid}' AND t_id='{$t_id}' order by g_id desc");
	foreach ($res as $key => $value) {
	 $res[$key]['thumbarr'] =unserialize($res[$key]['thumbarr']);
	 $res[$key]['updateTime'] =date('Y-m-d H:i:s',$res[$key]['updateTime']);
	 $num1 = count($res[$key]['thumbarr']);
	   for ($i=0; $i < $num1; $i++) { 
	     $res[$key]['thumbarr'][$i] =$_W['attachurl'].$res[$key]['thumbarr'][$i];
	   }
	}
	$data = array(
	    'zhiding'=>$zhiding,
	    'noticeList'=>$res
	  );
	echo json_encode($data);
}
if($op=='post'){
	$g_id = $_GPC['g_id'];
	$res = pdo_get('hyb_yl_teamment',array('uniacid'=>$uniacid,'g_id'=>$g_id));
	$res['thumbarr']=unserialize($res['thumbarr']);
	$res['updateTime'] =date('Y-m-d H:i:s',$res['updateTime']);
	$num1 = count($res['thumbarr']);
	for ($i=0; $i < $num1; $i++) { 
	 $res['thumbarr'][$i] =$_W['attachurl'].$res['thumbarr'][$i];
	}
	echo json_encode($res);
}
if($op =='delete'){

  $g_id = $_GPC['g_id'];

  $res = pdo_delete('hyb_yl_teamment',array('uniacid'=>$uniacid,'g_id'=>$g_id));

  echo json_encode($res);
}
