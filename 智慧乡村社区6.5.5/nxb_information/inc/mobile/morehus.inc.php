<?php
	global $_W,$_GPC;
	include 'common.php';
	$weid=$_W['uniacid'];
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);

	
	$res = pdo_fetchall("SELECT * FROM " . tablename('nx_information_hus') . " WHERE weid=" . $weid." ORDER BY hid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	$ht.='<li class="mui-table-view-cell oneinfo">'
        		.'<a class="mui-navigate-right" href="'.$this->createMobileUrl('hus_info',array('hid'=>$item['hid'])).'">'.$item['huzhu'].'</a>'
    		.'</li>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>