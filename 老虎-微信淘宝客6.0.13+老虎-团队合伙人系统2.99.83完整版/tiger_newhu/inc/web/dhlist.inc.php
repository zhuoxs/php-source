<?php
global $_W, $_GPC;
        $name = $_GPC['name'];
        $pindex = max(1, intval($_GPC['page']));
		$psize = 20;
        if (!empty($name)) $where .= " and (dwnick like '%{$name}%' or dopenid = '{$name}') ";
        $sql = "select * from ".tablename($this->modulename."_paylog")." where uniacid='{$_W['uniacid']}' {$where} order BY dtime DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}";
        $list = pdo_fetchall($sql);
        $total = pdo_fetchcolumn($sql);
		$pager = pagination($total, $pindex, $psize);
		 include $this->template('dhlist');