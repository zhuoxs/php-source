<?php
	global $_W,$_GPC;
	include 'common.php';	
	$words=$_GPC['words'];

	$res = pdo_fetchall("SELECT * FROM " . tablename('nx_information_hus') . " WHERE weid=" . $_W['uniacid'] ." AND bianma LIKE '%".$words."%' ORDER BY hid DESC");	
	
		$ht = '';
        foreach ($res as $key => $item) {		
        $ht.='<a href="'.$this->createMobileUrl('hus_info',array('hid'=>$item['hid'])).'"><div class="mui-row oneinfo pt05 pb05 ubb b-gra">';
					$ht.='<div class="mui-col-xs-11"><span class="pl15">'.$item['huzhu'].'</span></div><div class="mui-col-xs-1"><span class="mui-icon mui-icon-arrowright"></span></div>';
				$ht.='</div></a>';


        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>