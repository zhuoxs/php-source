  <?php
  	 global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
		$psize = 20;
        $name=$_GPC['name'];

        if (!empty($name)){
          $where .= " and (m.nickname like '%{$name}%') ";
        }

        $list=pdo_fetchall("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' {$where} order by id desc limit " . ($pindex - 1) * $psize . ",{$psize}");



		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' {$where} order by id desc");
		$pager = pagination($total, $pindex, $psize); 
        include $this->template ( 'member' );
        ?>