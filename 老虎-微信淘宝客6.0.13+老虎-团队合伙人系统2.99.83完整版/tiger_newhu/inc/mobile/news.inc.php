<?php
     global $_W,$_GPC;
		$type=$_GPC['type'];
		$pttype=$_GPC['pttype'];
		if(empty($ptype)){
			$ptype=0;
		}
		if(empty($type)){
			$type=1;			
		}		
		
//		//ajax请求开始
		if($_W['isajax']){
			$pindex = max(1, intval($_GPC['page']));
			$psize = 10;
	        $list1 = pdo_fetchall("select * from ".tablename($this->modulename."_news")." where weid='{$_W['uniacid']}' and pttype='{$pttype}' and type='{$type}'  order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename."_news")." where weid='{$_W['uniacid']}' and pttype='{$pttype}'  and type='{$type}'  ");
			$pager = pagination($total, $pindex, $psize);
			exit(json_encode(array('pages' =>ceil($total/10), 'data' => $list1)));
		}

		include $this -> template('news');	
?>