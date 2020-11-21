<?php
global $_W, $_GPC;
        if($_GPC['op']=='delete'){
            if (pdo_delete($this->modulename."_sdorder",array('id'=>$_GPC['id'])) === false){
				message ( '删除失败！' );
			}else{
               message ( '删除成功！' );
            }
        }

        $pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("select * from ".tablename($this->modulename."_sdorder")." where weid='{$_W['uniacid']}' order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_sdorder')." where weid='{$_W['uniacid']}'");
		$pager = pagination($total, $pindex, $psize);

        include $this->template ( 'sdgl' );