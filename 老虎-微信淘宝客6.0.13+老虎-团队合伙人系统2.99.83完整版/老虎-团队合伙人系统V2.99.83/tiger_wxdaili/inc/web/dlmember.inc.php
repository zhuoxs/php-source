<?php
global $_W, $_GPC;
        $dl=$_GPC['dl'];
		$qdid=$_GPC['qdid'];
        

        $pindex = max(1, intval($_GPC['page']));
		$psize = 50;

        $name=$_GPC['name'];
        $uid=$_GPC['uid'];
				$tztype=$_GPC['tztype'];

        if (!empty($name)){
          $where .= " and (nickname like '%{$name}%' || tname like '%{$name}%' || tel like '%{$name}%' || weixin like '%{$name}%' || tgwid = '{$name}' || qunname like '%{$name}%' ||  dlptpid='{$name}' ||  pddpid='{$name}'  ||  jdpid='{$name}' ) ";
        }
        if(!empty($uid)){
        	$uwhere=" and id='{$uid}'";
        }
		if(!empty($qdid)){
			$uwhere=" and qdid='{$qdid}'";
		}
        if(!empty($dl)){
           $where.=" and dltype={$dl}";
        }
				
				if($_GPC['op']=='wfp'){
					$wfbwhere=" and tbuid=''";
				}
				if($_GPC['op']=='wtgw'){
					$tgwwhere=" and tgwid=''";
				}
				if($_GPC['op']=='wtbpid'){
					$dlpidwhere=" and dlptpid=''";
				}
				if($_GPC['op']=='wjdpid'){
					$jdpidwhere=" and jdpid=''";
				}
				if($_GPC['op']=='wpddpid'){
					$pddpidwhere=" and pddpid=''";
				}		
				if($tztype==1){
					$tzwhere=" and tztype=1";
				}
    $list = pdo_fetchall("select * from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' {$where} {$tzwhere} {$uwhere} {$wfbwhere} {$tgwwhere} {$dlpidwhere} {$jdpidwhere} {$pddpidwhere} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}'  {$where} {$tzwhere} {$uwhere} {$wfbwhere} {$tgwwhere} {$dlpidwhere} {$jdpidwhere} {$pddpidwhere}");
		$pager = pagination($total, $pindex, $psize);
//        echo '<pre>';
//        print_r($list);
//        exit;
        include $this->template ( 'dlmember' );    
?>