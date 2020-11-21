<?php
//http://cs.tigertaoke.com/app/index.php?i=14&c=entry&do=appdh&m=tiger_newhu&fztype=1
	//菜单//广告
global $_W, $_GPC;
		$cfg = $this->module['config'];
		$weid=$_W['uniacid'];

		

		//$dh = pdo_fetchall("SELECT * FROM " . tablename("tiger_newhu_faquan") . " WHERE weid='{$weid}'");
		
		    $page=$_GPC['page'];
			$type=$_GPC['type'];
			if(empty($type)){
				$typewhere=" and type=0";
			}else{
				$typewhere=" and type=1";
			}
		    if(empty($page)){
		    	$page=1;
		    }
            $pindex = max(1, intval($page));
		    $psize = 10;
            $list = pdo_fetchall("select * from ".tablename("tiger_newhu_faquan")." where weid='{$weid}' {$typewhere} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_newhu_faquan")." where   weid='{$weid}'  {$typewhere}");

		$dha=array();
		foreach($list as $k=>$v){		
			$imglist=unserialize($v['piclist']);
			foreach($imglist as $i=>$ve){
				$dha[$k]['itempic'][$i]=tomedia($ve);
			}	
			$dha[$k]['id']=$v['id'];
			$dha[$k]['weid']=$v['weid'];
			$dha[$k]['title']=$v['title'];			
			$dha[$k]['content']=$v['content'];				
			$dha[$k]['createtime']=$v['createtime'];
		}
		//file_put_contents(IA_ROOT."/addons/tiger_tkxcx/dh_log.txt","\ndaohang:".json_encode($dha),FILE_APPEND);
		exit(json_encode(array('errcode'=>0,'data'=>$dha))); 
?>