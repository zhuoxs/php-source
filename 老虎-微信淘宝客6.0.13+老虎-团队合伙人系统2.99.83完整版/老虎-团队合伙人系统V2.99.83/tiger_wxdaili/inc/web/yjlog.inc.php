 <?php global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 12;
        if(!empty($_GPC['name'])){
         //$where=" and fans_id=".$_GPC['name']."";
         $name=$_GPC['name'];
         $where=" and (openid = '{$name}' or nickname like '%{$name}%' )";
        }else{
        	$name='';
        }
        if(!empty($_GPC['uid'])){
        	$whereuid=" and uid='{$_GPC['uid']}'";
        }
        
        if($_GPC['op']=='delete'){
        	$id=$_GPC['id'];
        	pdo_delete($this->modulename . "_yjlog", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }
        
        
        
        
        $yjlog = pdo_fetchall ( 'select * from ' . tablename ( $this->modulename . "_yjlog" ) . " where weid='{$_W['uniacid']}'  {$where}  {$whereuid} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_yjlog')." where weid='{$_W['uniacid']}' {$where} {$whereuid} ");
		$pager = pagination($total, $pindex, $psize); 
        //echo '<pre>';
        //print_r($order);
        //exit;
        include $this->template ( 'yjlog' );
        ?>