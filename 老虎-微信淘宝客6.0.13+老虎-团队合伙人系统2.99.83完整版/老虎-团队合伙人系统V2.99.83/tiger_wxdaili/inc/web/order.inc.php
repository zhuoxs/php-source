 <?php global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize =25;
        if($_GPC['name']){
         //$where=" and fans_id=".$_GPC['name']."";
         $name=$_GPC['name'];
         $where=" and (tel = '{$name}' or orderno = '{$name}' or usernames like '%{$name}%' or nickname like '%{$name}%' )";
        }else{
        	$name='';
        }
        $order = pdo_fetchall ( 'select * from ' . tablename ( $this->modulename . "_order" ) . " where cengji=0 and weid='{$_W['uniacid']}'   {$where} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_order')." where weid='{$_W['uniacid']}' {$where} ");
		$pager = pagination($total, $pindex, $psize); 
        //echo '<pre>';
        //print_r($order);
        //exit;
        if ($_GPC['op'] == 'delete'){
            $id = intval($_GPC['id']);
            $row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_order") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('记录' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_order", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }
        include $this->template ( 'order' );
        ?>