<?php
//http://cs.tigertaoke.com/app/index.php?i=14&c=entry&do=pidcount&m=tiger_newhu
		global $_W, $_GPC;
		$cfg = $this->module['config'];
		$jd=pdo_fetchcolumn("select count(id) from ".tablename("tiger_wxdaili_jdpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
		$pdd=pdo_fetchcolumn("select count(id) from ".tablename("tiger_wxdaili_pddpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
		$tb=pdo_fetchcolumn("select count(id) from ".tablename("tiger_wxdaili_tkpid")." where weid='{$_W['uniacid']}' and type=0 order by id desc ");
		//批量审核自动加PID
	
		

		
		//结束

		
	

		exit($tb."|".$jd."|".$pdd); 
?>