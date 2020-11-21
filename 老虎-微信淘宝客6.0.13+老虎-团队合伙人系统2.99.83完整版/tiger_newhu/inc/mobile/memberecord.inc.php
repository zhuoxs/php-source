<?php
		global $_W, $_GPC;
		$uid = $_GPC['id'];
		$type= $_GPC['type'];
		if(empty($type)){
			$type=0;
		}
		
	
		$pindex = max(1, intval($_GPC['page']));
		$psize = 50;  
		$list = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_jl") . "  WHERE weid = '{$_W['uniacid']}' and type='{$type}' and uid='{$uid}' ORDER BY id LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_jl')." where weid='{$_W['uniacid']}'  and type='{$type}' and uid='{$uid}'");
		$pager = pagination($total, $pindex, $psize);   
//		echo "<pre>";
//		print_r($list);
//		exit;
        
		include $this->template ( 'memberecord' );