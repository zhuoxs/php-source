<?php
	global $_W, $_GPC;     
        $weid = $_GPC['weid'];
        $last = $_GPC['last'];
        $amount = $_GPC['amount'];
        $shares=pdo_fetchall("select m.nickname,m.avatar,m.credit1 FROM ".tablename('mc_members')." m LEFT JOIN ".tablename('mc_mapping_fans')." f ON m.uid=f.uid where f.follow=1 and f.uniacid='{$weid}' and m.credit1<>0 order by credit1 desc limit $last,$amount");	
        //print_r($shares);
                
		echo json_encode($shares);
?>