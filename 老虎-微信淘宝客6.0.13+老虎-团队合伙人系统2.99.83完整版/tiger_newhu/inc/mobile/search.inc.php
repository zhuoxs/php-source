<?php
global $_W, $_GPC;
$cfg=$this->module['config'];
$style=$cfg['qtstyle'];
$dluid=$_GPC['dluid'];//share id
        if(empty($style)){
            $style='style1';        
        }
        $fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$_W['uniacid']}'  order by px desc");
include $this->template ( 'tbgoods/'.$style.'/search' );