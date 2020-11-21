<?php
 global $_W,$_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';        
        $pindex = max(1, intval($_GPC['page']));
        $psize =50; 
        $list=pdo_fetchall("select * from ".tablename($this->modulename."_tkpid")." where weid='{$_W['uniacid']}' order by id desc limit " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->modulename."_tkpid")." where weid='{$_W['uniacid']}' order by id desc");
        $pager = pagination($total, $pindex, $psize); 
      
        include $this -> template('tkpidlist');
?>