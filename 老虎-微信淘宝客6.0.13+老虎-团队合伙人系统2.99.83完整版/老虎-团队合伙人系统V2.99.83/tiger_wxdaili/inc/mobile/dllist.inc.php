 <?php
		global $_W, $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("select id from ".tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}' and dltype=1 order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_share")." where weid='{$_W['uniacid']}'  and dltype=1");
		$pager = pagination($total, $pindex, $psize);
		foreach($list as $k=>$v){
			$str.=$v['id'].",";
		}
    exit(trim($str));
?>