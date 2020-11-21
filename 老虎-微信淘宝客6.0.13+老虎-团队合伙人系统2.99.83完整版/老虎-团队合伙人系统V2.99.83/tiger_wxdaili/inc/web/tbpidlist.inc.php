<?php
 global $_W,$_GPC;
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';        
        $pindex = max(1, intval($_GPC['page']));
        $psize =50; 
        $list=pdo_fetchall("select * from ".tablename($this->modulename."_tkpid")." where weid='{$_W['uniacid']}' order by id desc limit " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->modulename."_tkpid")." where weid='{$_W['uniacid']}' order by id desc");
        $pager = pagination($total, $pindex, $psize); 

        if($_GPC['op']=="delete"){
        	$id=$_GPC['id'];

        	$row = pdo_fetch("SELECT id FROM " . tablename($this->modulename."_tkpid") . " WHERE id = :id", array(':id' => $id));
            if (empty($row)){
                message('抱歉，PID' . $id . '不存在或是已经被删除！');
            }
            pdo_delete($this->modulename."_tkpid", array('id' => $id));
            message('删除成功！', referer(), 'success');
        }
      
      
      
      
        include $this -> template('tkpidlist');
?>