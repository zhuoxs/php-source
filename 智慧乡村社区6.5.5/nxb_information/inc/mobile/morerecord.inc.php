<?php
	global $_W,$_GPC;
	include 'common.php';
	$weid=$_W['uniacid'];
	$num=intval($_GPC['num']);
	$psize=intval($_GPC['psize']);

	$mesid=$_GPC['mesid'];
	$cx='';
	if(!empty($mesid)){
		$cx=' AND a.mesid='.$mesid; 
	}
	$res = pdo_fetchall("SELECT a.*,b.bianma,c.projectname FROM " . tablename('nx_information_record') . " as a left join ".tablename('nx_information_message')." as b on a.mesid=b.mesid left join ".tablename('nx_information_project')." as c on a.proid=c.proid WHERE a.weid=" . $weid.$cx."  ORDER BY recid DESC LIMIT  ". $num . ",{$psize}");	
	
		$ht = '';
        foreach ($res as $key => $item) {
        	
        	$ht.='<li class="mui-table-view-cell mui-media oneinfo">'
        		.'<a class="mui-navigate-right" href="'.$this->createMobileUrl('record_info',array('recid'=>$item['recid'])).'">';
        		
            		$ht.='<div class="mui-media-body">'
                		.'家庭编码：'.$item['bianma']
                	.'<p class="mui-ellipsis">帮扶项目：'.$item['projectname'].'</p>'
            	.'</div>'
        		
        		
        		.'</a>'
    		.'</li>';
        }
        if(!empty($res)){
            echo json_encode(array('status'=>1,'log'=>$ht));
        }else{
            echo json_encode(array('status'=>0,'log'=>$ht));
        }
	

?>