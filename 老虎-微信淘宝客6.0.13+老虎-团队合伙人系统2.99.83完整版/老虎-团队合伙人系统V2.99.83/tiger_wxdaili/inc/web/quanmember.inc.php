 <?php  global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
		$psize = 20;
        $id=$_GPC['id'];
        $op=$_GPC['op'];
        if($op=='delete'){
            pdo_delete($this->modulename."_qunmember", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }
        $list = pdo_fetchall("select * from ".tablename($this->modulename.'_qunmember')." where weid='{$_W['uniacid']}' and qunid='{$id}'  order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_qunmember')." where weid='{$_W['uniacid']}' and qunid='{$id}' ");
		$pager = pagination($total, $pindex, $psize);
        include $this->template ( 'qunmember' );  
        ?>