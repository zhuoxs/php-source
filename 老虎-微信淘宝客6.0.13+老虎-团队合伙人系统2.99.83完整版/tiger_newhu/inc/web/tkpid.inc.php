<?php
global $_W;
        global $_GPC;
				$page=$_GPC['page'];
				if(empty($page)){
					$page=1;
				}
				$pindex = max(1, intval($page));
				$psize =50;
				//$list = pdo_fetchall("SELECT * FROM " . tablename("tiger_wxdaili_tkpid") . " WHERE weid = '{$_W['uniacid']}' and tbuid='{$_GPC['tkuid']}' ORDER BY id desc");
				$list = pdo_fetchall("select * from ".tablename("tiger_wxdaili_tkpid")." where weid='{$_W['uniacid']}' and tbuid='{$_GPC['tkuid']}' order by id desc LIMIT ". ($pindex - 1) * $psize . ",{$psize}");
				$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("tiger_wxdaili_tkpid")." where weid='{$_W['uniacid']}' and tbuid='{$_GPC['tkuid']}'");
				$pager = pagination($total, $pindex, $psize);
// 				echo "<pre>";
// 				print_r($list);
// 				//print_r($list1);
// 				exit;

        include $this -> template('tkpid');